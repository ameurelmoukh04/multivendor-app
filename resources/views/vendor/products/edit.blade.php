@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<h1 style="margin-bottom: 2rem;">Edit Product</h1>

<div class="card">
    <form method="POST" action="{{ route('vendor.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Product Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="price">Price *</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock *</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="sku">SKU *</label>
            <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
        </div>

        <div class="form-group">
            <label>Current Images</label>
            @if($product->images->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                    @foreach($product->images as $image)
                        <div style="position: relative; border: 1px solid #ddd; padding: 0.5rem; border-radius: 4px;">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                            <label style="display: block; margin-top: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="existing_images[]" value="{{ $image->id }}" checked>
                                Keep this image
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="form-text text-muted">Uncheck images you want to remove</small>
            @else
                <p class="text-muted">No images currently uploaded</p>
            @endif
        </div>

        <div class="form-group">
            <label for="images">Add New Images</label>
            <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
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
                <strong>Note:</strong> Updated products will be set to pending status and require admin approval before being published.
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

