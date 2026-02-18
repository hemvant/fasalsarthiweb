@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: Str::limit($post->excerpt ?? strip_tags($post->content), 160))

@section('content')
    <section class="blog-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-detail-header" data-aos="fade-up">
                        @if($post->category)
                            <span class="blog-category">{{ $post->category->name }}</span>
                        @endif
                        <h1 class="blog-detail-title">{{ $post->title }}</h1>
                        <div class="blog-detail-meta">
                            @if($post->author_name)
                                <div class="author"><i class="far fa-user"></i> {{ $post->author_name }}</div>
                            @endif
                            @if($post->published_at)
                                <div class="date"><i class="far fa-calendar"></i> {{ $post->published_at->format('F j, Y') }}</div>
                            @endif
                            @if($post->read_time)
                                <div class="read-time"><i class="far fa-clock"></i> {{ $post->read_time }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="blog-detail-image" style="background-image: url('{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200' }}');" data-aos="fade-up"></div>

                    <div class="blog-detail-content" data-aos="fade-up">
                        @if($post->table_of_contents)
                            <div class="table-of-contents">
                                {!! $post->table_of_contents !!}
                            </div>
                        @endif

                        @if($post->content)
                            <div class="post-body">{!! $post->content !!}</div>
                        @endif
                    </div>

                    @if(is_array($post->tags) && count($post->tags) > 0)
                        <div class="tags-list mt-4" data-aos="fade-up">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.index') }}?tag={{ urlencode($tag) }}" class="tag">{{ $tag }}</a>
                            @endforeach
                        </div>
                    @endif

                    @if($post->author_name || $post->author_bio)
                        <div class="author-bio" data-aos="fade-up">
                            <div class="d-flex">
                                <div class="author-avatar">{{ Str::upper(Str::substr($post->author_name ?? 'A', 0, 2)) }}</div>
                                <div>
                                    @if($post->author_name)
                                        <h4>{{ $post->author_name }}</h4>
                                    @endif
                                    @if($post->author_bio)
                                        <p class="mb-0">{{ $post->author_bio }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($relatedPosts->isNotEmpty())
                        <div class="related-posts" data-aos="fade-up">
                            <h3>Related Articles</h3>
                            <div class="row g-4">
                                @foreach($relatedPosts as $rp)
                                    <div class="col-md-6">
                                        <div class="blog-card">
                                            <div class="blog-image" style="background-image: url('{{ $rp->featured_image ? asset('storage/' . $rp->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');"></div>
                                            <div class="blog-content">
                                                @if($rp->category)
                                                    <span class="blog-category">{{ $rp->category->name }}</span>
                                                @endif
                                                <h3 class="blog-title"><a href="{{ route('blog.show', $rp->slug) }}">{{ $rp->title }}</a></h3>
                                                @if($rp->published_at)
                                                    <div class="blog-meta">
                                                        <span class="date"><i class="far fa-calendar"></i> {{ $rp->published_at->format('F j, Y') }}</span>
                                                    </div>
                                                @endif
                                                <a href="{{ route('blog.show', $rp->slug) }}" class="btn btn-apply mt-2">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        @if($categories->isNotEmpty())
                            <div class="sidebar-widget">
                                <h4>Categories</h4>
                                <ul class="categories-list">
                                    @foreach($categories as $c)
                                        <li>
                                            <a href="{{ route('blog.index', ['category' => $c->id]) }}">
                                                {{ $c->name }}
                                                <span class="count">{{ $c->posts_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($recentPosts->isNotEmpty())
                            <div class="sidebar-widget">
                                <h4>Recent Posts</h4>
                                <div class="recent-posts">
                                    @foreach($recentPosts as $rp)
                                        <div class="post-item">
                                            <div class="post-thumb" style="background-image: url('{{ $rp->featured_image ? asset('storage/' . $rp->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=200' }}');"></div>
                                            <div class="post-content">
                                                <h5><a href="{{ route('blog.show', $rp->slug) }}">{{ Str::limit($rp->title, 50) }}</a></h5>
                                                <span class="post-date">{{ $rp->published_at ? $rp->published_at->format('M j, Y') : '' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
