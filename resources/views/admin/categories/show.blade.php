@extends('layouts.app')

@section('title', $category->name)

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1200px;
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

    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .dark .table th {
        color: #e5e7eb;
        border-bottom-color: #4b5563;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    .dark .table td {
        border-bottom-color: #4b5563;
        color: #f9fafb;
    }

    .table tr:last-child td {
        border-bottom: none;
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
        margin-right: 0.5rem;
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

    /* List styles */
    ul {
        list-style: none;
        padding: 0;
    }

    ul li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .dark ul li {
        border-bottom-color: #4b5563;
    }

    ul li:last-child {
        border-bottom: none;
    }

    ul li a {
        color: #3b82f6;
        text-decoration: none;
    }
    .dark ul li a {
        color: #60a5fa;
    }

    ul li a:hover {
        text-decoration: underline;
    }

    /* Text colors for dark mode */
    h1, h2 {
        color: #1f2937;
    }
    .dark h1,
    .dark h2 {
        color: #f9fafb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        main {
            padding: 1rem;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<h1 style="margin-bottom: 2rem;">{{ $category->name }}</h1>

<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
    </div>

    <table class="table">
        <tr>
            <th style="width: 200px;">Name</th>
            <td>{{ $category->name }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $category->slug }}</td>
        </tr>
        <tr>
            <th>Parent Category</th>
            <td>{{ $category->parent->name ?? 'None' }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $category->description ?? 'No description' }}</td>
        </tr>
        <tr>
            <th>Products Count</th>
            <td>{{ $category->products->count() }}</td>
        </tr>
    </table>

    @if($category->children->count() > 0)
        <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Subcategories</h2>
        <ul>
            @foreach($category->children as $child)
                <li><a href="{{ route('admin.categories.show', $child->id) }}">{{ $child->name }}</a></li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

