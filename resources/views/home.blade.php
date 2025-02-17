@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Dashboard</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="mb-3">Welcome, {{ Auth::user()->name }}! 👋</h5>
                    <p class="text-muted">Here’s an overview of your store's performance.</p>

                    {{-- Quick Stats Section --}}
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h3>{{ $totalProducts ?? 0 }}</h3>
                                    <p>Total Products</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h3>{{ $activeProducts ?? 0 }}</h3>
                                    <p>Active Products</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h3>{{ $inactiveProducts ?? 0 }}</h3>
                                    <p>Inactive Products</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Products --}}
                    <h5 class="mt-4">Recent Products</h5>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                {{-- <th>Status</th> --}}
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentProducts ?? [] as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ $product->price }}</td>
                                    {{-- <td> --}}
                                        {{-- <span class="badge {{ $product->status === 'Y' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $product->status === 'Y' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td> --}}
                                    <td>{{ $product->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Management Links --}}
                    <div class="mt-4">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Manage Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
