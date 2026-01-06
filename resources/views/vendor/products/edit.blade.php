@extends('layouts.app')

@section('title', 'Edit Product')

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Card styles */
    .card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    .dark .card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    /* Form styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
    }
    .dark .form-group label {
        color: #e5e7eb;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .dark .form-control {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    select.form-control {
        cursor: pointer;
    }

    .form-text {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    .dark .form-text {
        color: #9ca3af;
    }

    .text-danger {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .dark .text-danger {
        color: #fca5a5;
    }

    .text-muted {
        color: #6b7280;
    }
    .dark .text-muted {
        color: #9ca3af;
    }

    /* Image grid */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .image-item {
        position: relative;
        border: 2px solid #d1d5db;
        padding: 0.5rem;
        border-radius: 0.5rem;
        background: white;
        transition: all 0.2s;
    }
    .dark .image-item {
        background: #374151;
        border-color: #4b5563;
    }

    .image-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .image-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 0.25rem;
    }

    .image-item label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        color: #374151;
    }
    .dark .image-item label {
        color: #e5e7eb;
    }

    .image-item input[type="checkbox"] {
        cursor: pointer;
    }

    /* Alert styles */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        border-left: 4px solid;
    }

    .alert-info {
        background-color: #dbeafe;
        border-color: #3b82f6;
        color: #1e40af;
    }
    .dark .alert-info {
        background-color: #1e3a8a;
        border-color: #3b82f6;
        color: #dbeafe;
    }

    /* Button styles */
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    /* Text colors for dark mode */
    h1 {
        color: #1f2937;
    }
    .dark h1 {
        color: #f9fafb;
    }

    /* Form grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        main {
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .image-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>
@endpush

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

        <div class="form-grid">
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
                <div class="image-grid">
                    @foreach($product->images as $image)
                        <div class="image-item">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                            <label>
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

