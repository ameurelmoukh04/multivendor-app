@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<h1 style="margin-bottom: 2rem;">Create New Product</h1>

<div class="card">
    <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Product Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="price">Price *</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock *</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="sku">SKU *</label>
            <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku') }}" required>
        </div>

        <div class="form-group">
            <label for="images">Product Images *</label>
            <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple required>
            <small class="form-text text-muted">You can upload multiple images. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB per image.</small>
            @error('images')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @error('images.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="alert alert-info">
                <strong>Note:</strong> Products are automatically set to pending status and will require admin approval before being published.
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

