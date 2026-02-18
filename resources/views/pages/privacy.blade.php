@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description)

@section('content')
    <section class="policy-hero">
        <div class="container">
            <h1 data-aos="fade-up">{{ $page->title }}</h1>
            <p data-aos="fade-up" data-aos-delay="100">Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.</p>
            <p data-aos="fade-up" data-aos-delay="200"><strong>Last Updated:</strong> {{ $page->updated_at->format('F j, Y') }}</p>
        </div>
    </section>
    <section class="policy-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if($page->content)
                        <div class="policy-main">{!! $page->content !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
