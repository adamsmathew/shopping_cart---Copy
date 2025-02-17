@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h1 class="mb-4">Add Product</h1>
                    <div class="card-body">
                        
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" 
                                          class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       step="0.01" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                       

                            <!-- Product Images -->
                            <div class="mb-3">
                                <label for="images" class="form-label">Product Images</label>
                                <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" 
                                       multiple required>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="preview-images" class="mt-2"></div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Add Product</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('images').addEventListener('change', function() {
            var preview = document.getElementById('preview-images');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'me-2');
                    img.style.width = '100px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
