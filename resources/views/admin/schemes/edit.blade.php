@extends('admin.layout')

@section('title', 'Edit Scheme')
@section('header', 'Edit Scheme')

@section('content')
    <form action="{{ route('admin.schemes.update', $scheme) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.schemes._form', ['scheme' => $scheme])
        <button type="submit" class="btn btn-admin">Update Scheme</button>
        <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
