@extends('admin.layout')

@section('title', 'Add Blog Post')
@section('header', 'Add Blog Post')

@section('content')
    <form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.blog-posts._form')
        <button type="submit" class="btn btn-admin">Create Post</button>
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
