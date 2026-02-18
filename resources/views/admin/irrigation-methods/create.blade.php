@extends('admin.layout')

@section('title', 'Add Irrigation Method')
@section('header', 'Add Irrigation Method')

@section('content')
    <form action="{{ route('admin.irrigation-methods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.irrigation-methods._form')
        <button type="submit" class="btn btn-admin">Create Method</button>
        <a href="{{ route('admin.irrigation-methods.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
