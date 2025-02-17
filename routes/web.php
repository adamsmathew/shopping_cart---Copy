<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Auth::routes();
Route::get('/', function () {
  return redirect()->route('login'); // Redirect to the named route for login
});
// Protect product routes with the auth middleware
Route::middleware(['auth'])->group(function () {
    // Route to display all products

    
    // Route for bulk delete
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');

      // Route to delete a specific product
      Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

      Route::get('/home', [ProductController::class, 'dashboardOverview'])->name('dashboard');

        // Route for home
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Route to show the form for creating a new product
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Route to store a newly created product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Route to display a specific product
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Route to show the form for editing a specific product
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // Route to update a specific product
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

  
    // Route to toggle product status
    Route::post('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

    Route::get('/import', [ProductController::class, 'importView'])->name('import-view');
Route::post('/import', [ProductController::class, 'import'])->name('import');

});


