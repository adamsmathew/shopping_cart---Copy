@extends('layouts.dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h1 class="mb-4">Edit Product</h1>

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" step="0.01" required>
                    </div>

                    <!-- Current Images -->
                    <div class="mb-3">
                        <label class="form-label">Current Images</label>
                        <div>
                            @php
                                $images = json_decode($product->images, true);
                            @endphp

                            @if (!empty($images) && is_array($images))
                                @foreach ($images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" width="100" class="me-2">
                                @endforeach
                            @else
                                <p>No images available</p>
                            @endif
                        </div>
                    </div>

                    <!-- New Product Images -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Upload New Images (Optional)</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
