@extends('admin.layout')

@section('title', 'Edit Irrigation Method')
@section('header', 'Edit Irrigation Method')

@section('content')
    <form action="{{ route('admin.irrigation-methods.update', $method) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.irrigation-methods._form', ['method' => $method])
        <button type="submit" class="btn btn-admin">Update Method</button>
        <a href="{{ route('admin.irrigation-methods.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
