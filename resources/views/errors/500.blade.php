@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
    <section class="error-page">
        <div class="container">
            <h1>500</h1>
            <p>Something went wrong on our end. Please try again later.</p>
            <a href="{{ route('home') }}" class="btn btn-explore">Back to Home</a>
        </div>
    </section>
@endsection
