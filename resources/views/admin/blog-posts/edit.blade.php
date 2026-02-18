@extends('admin.layout')

@section('title', 'Edit Blog Post')
@section('header', 'Edit Blog Post')

@section('content')
    <form action="{{ route('admin.blog-posts.update', $blogPost) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.blog-posts._form', ['blogPost' => $blogPost])
        <button type="submit" class="btn btn-admin">Update Post</button>
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
