@extends('admin.layout')

@section('title', 'Add Feature')
@section('header', 'Add Feature')

@section('content')
    <form action="{{ route('admin.features.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.features._form')
        <button type="submit" class="btn btn-admin">Create Feature</button>
        <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
