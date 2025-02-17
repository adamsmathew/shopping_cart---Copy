@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Import Products</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Upload Excel File:</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
            @error('file')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Import</button>
    </form>
</div>
@endsection
