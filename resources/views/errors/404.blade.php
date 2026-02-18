@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <section class="error-page">
        <div class="container">
            <h1>404</h1>
            <p>Sorry, the page you are looking for could not be found.</p>
            <a href="{{ route('home') }}" class="btn btn-explore">Back to Home</a>
        </div>
    </section>
@endsection
