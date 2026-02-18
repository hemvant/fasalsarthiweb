@extends('admin.layout')

@section('title', 'Add Scheme')
@section('header', 'Add Scheme')

@section('content')
    <form action="{{ route('admin.schemes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.schemes._form')
        <button type="submit" class="btn btn-admin">Create Scheme</button>
        <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
