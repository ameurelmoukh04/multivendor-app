@extends('layouts.app')

@section('title', $category->name)

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

