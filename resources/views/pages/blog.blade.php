@extends('layouts.app')

@section('title', 'Blog')
@section('meta_description', 'Expert insights, farming tips, and AI-powered agriculture updates.')

@section('content')
    <section class="blog-hero">
        <div class="container">
            <h1 data-aos="fade-up">Farming Blog</h1>
            <p data-aos="fade-up" data-aos-delay="100">Expert insights, farming tips, and AI-powered agriculture updates.</p>
        </div>
    </section>
    <section class="blog-section">
        <div class="container">
            @if($categories->isNotEmpty())
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                            <label class="text-muted mb-0">Filter:</label>
                            <a href="{{ route('blog.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-success' }}">All</a>
                            @foreach($categories as $cat)
                                <a href="{{ route('blog.index', ['category' => $cat->id]) }}" class="btn btn-sm {{ request('category') == $cat->id ? 'btn-success' : 'btn-outline-success' }}">{{ $cat->name }} ({{ $cat->posts_count }})</a>
                            @endforeach
                        </form>
                    </div>
                </div>
            @endif
            <div class="row g-4">
                @forelse($posts as $p)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="blog-card">
                            <div class="blog-image" style="background-image: url('{{ $p->featured_image ? asset('storage/' . $p->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');"></div>
                            <div class="blog-content">
                                @if($p->category)
                                    <span class="blog-category">{{ $p->category->name }}</span>
                                @endif
                                <h3 class="blog-title"><a href="{{ route('blog.show', $p->slug) }}">{{ $p->title }}</a></h3>
                                @if($p->excerpt)
                                    <p class="blog-excerpt">{{ Str::limit($p->excerpt, 120) }}</p>
                                @endif
                                <div class="blog-meta">
                                    @if($p->published_at)
                                        <span class="date"><i class="far fa-calendar"></i> {{ $p->published_at->format('F j, Y') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('blog.show', $p->slug) }}" class="btn btn-apply mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No posts yet. Check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
