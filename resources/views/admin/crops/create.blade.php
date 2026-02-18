@extends('admin.layout')

@section('title', 'Add Crop')
@section('header', 'Add Crop')

@section('content')
    <form action="{{ route('admin.crops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.crops._form')
        <button type="submit" class="btn btn-admin">Create Crop</button>
        <a href="{{ route('admin.crops.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
