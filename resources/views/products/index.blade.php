@extends('layouts.dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">Product List</h1>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
                    <a href="{{ route('import') }}" class="btn btn-primary"> Import</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Filter Form -->
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Product Name" value="{{ request('name') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="Y" {{ request('status') == 'Y' ? 'selected' : '' }}>Active</option>
                                <option value="N" {{ request('status') == 'N' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="price_min" class="form-control" placeholder="Min Price" value="{{ request('price_min') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="price_max" class="form-control" placeholder="Max Price" value="{{ request('price_max') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <form id="bulkDeleteForm" method="POST" action="{{ route('products.bulkDelete') }}">
                    @csrf
                    @method('DELETE')
                    <br>
                    @can('delete product')
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete selected products?')">Delete Selected</button>
                    </div>
                    @endcan
                    <!-- DataTable -->
                    <div class="table-responsive">
                        <table id="productTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><input type="checkbox" name="selected_products[]" value="{{ $product->id }}" class="select-item"></td>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <button class="btn toggle-status btn-sm {{ $product->status == 'Y' ? 'btn-success' : 'btn-danger' }}" 
                                                data-id="{{ $product->id }}">
                                                {{ $product->status == 'Y' ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                        
                                            @can('edit product')
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            @endcan
                                        
                                            @can('delete product')
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                            
                                            @endcan
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#productTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [{ "orderable": false, "targets": [0, 6] }]
        });
    });

    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Toggle status using AJAX
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let productId = this.getAttribute('data-id');
                let buttonElement = this;

                fetch(`/products/${productId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Y') {
                        buttonElement.classList.remove('btn-danger');
                        buttonElement.classList.add('btn-success');
                        buttonElement.textContent = 'Active';
                    } else {
                        buttonElement.classList.remove('btn-success');
                        buttonElement.classList.add('btn-danger');
                        buttonElement.textContent = 'Inactive';
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

<script>
    window.addEventListener("load", function () {
        if (performance.navigation.type === 1) { // 1 means the page was reloaded
            window.location.href = window.location.pathname; // Reload without query parameters
        }
    });
</script>

@endsection
