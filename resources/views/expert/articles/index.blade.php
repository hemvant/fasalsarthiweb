@extends('expert.layout')
@section('title', 'My Articles')
@section('content')
<h3>My Articles</h3>
<p><a href="{{ route('expert.articles.create') }}" class="btn btn-success">New article</a></p>
@foreach($articles as $art)
<div><strong>{{ $art->title }}</strong> - {{ $art->status }} - <a href="{{ route('expert.articles.edit', $art) }}">Edit</a></div>
@endforeach
@if($articles->hasPages()){{ $articles->links() }}@endif
@endsection
