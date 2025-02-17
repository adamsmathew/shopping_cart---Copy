@extends('layouts.dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h1 class="mb-4">Product Details</h1>

                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name:</label>
                    <p>{{ $product->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description:</label>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Price:</label>
                    <p>${{ $product->price }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Images:</label>
                    <div>
                        @php
                            $images = json_decode($product->images, true);
                        @endphp

                        @if (!empty($images) && is_array($images))
                            @foreach($images as $image)
                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail me-2" width="150">
                            @endforeach
                        @else
                            <p>No images available</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
