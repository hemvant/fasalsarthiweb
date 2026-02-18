@extends('admin.layout')

@section('title', 'Edit Crop')
@section('header', 'Edit Crop')

@section('content')
    <form action="{{ route('admin.crops.update', $crop) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.crops._form', ['crop' => $crop])
        <button type="submit" class="btn btn-admin">Update Crop</button>
        <a href="{{ route('admin.crops.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
