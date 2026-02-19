@extends('admin.layout')

@section('title', 'Edit Feature')
@section('header', 'Edit Feature')

@section('content')
    <form action="{{ route('admin.features.update', $feature) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.features._form')
        <button type="submit" class="btn btn-admin">Update Feature</button>
        <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
