<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    // Display all products
    public function index(Request $request)
    {
        $query = DB::table('products')->select('*');
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
    
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
    
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }
    
        $products = $query->get()->map(function ($product) {
            $product->created_at = Carbon::parse($product->created_at); // 
            return $product;
        });
    
        return view('products.index', compact('products'));
    }
    

    // Show form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


    // Generate a unique product code
    $productCode = 'PRD-' . strtoupper(Str::random(8));

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'images' => json_encode($images),
            'code' => $productCode,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $images = json_decode($product->images, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'images' => json_encode($images),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete images from storage
        foreach (json_decode($product->images, true) ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }
    
        $product->delete();
    
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
    
    

    public function show(Product $product)
{
    return view('products.show', compact('product'));
}



public function bulkDelete(Request $request)
{
    $productIds = $request->input('selected_products');

    if (!empty($productIds)) {
   
        $products = Product::whereIn('id', $productIds)->get();
        foreach ($products as $product) {
            $images = json_decode($product->images, true) ?? []; 
            foreach ($images as $image) {
                Storage::delete($image);
            }
        }

        // Delete selected products
        Product::whereIn('id', $productIds)->delete();

        return redirect()->route('products.index')->with('success', 'Selected products deleted successfully.');
    }

    return redirect()->route('products.index')->with('error', 'No products selected.');
}
public function toggleStatus($id)
{
    $product = Product::findOrFail($id);
    $product->status = $product->status === 'Y' ? 'N' : 'Y';
    $product->save();

    return response()->json(['status' => $product->status]);
}


public function dashboardOverview()
{
    $totalProducts = Product::count();
    $activeProducts = Product::where('status', 'Y')->count();
    $inactiveProducts = Product::where('status', 'N')->count();
    $recentProducts = Product::latest()->take(5)->get();

    return view('home', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'recentProducts'));
}


public function listAllProducts()
{
    $products = Product::select('id', 'name', 'description', 'price', 'images', 'status', 'created_at')
        ->get()
        ->map(function ($product) {
            // Decode images JSON into an array
            $product->images = json_decode($product->images, true) ?? [];
            return $product;
        });

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:2048',
    ]);

    Excel::import(new ProductsImport, $request->file('file'));

    return redirect()->route('products.index')->with('success', 'Products imported successfully!');
}

public function importView()
{
    return view('import');
}
}
