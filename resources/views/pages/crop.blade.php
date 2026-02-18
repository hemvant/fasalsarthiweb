@extends('layouts.app')

@section('title', 'Crops')

@section('content')
    <section class="crop-hero">
        <div class="container">
            <h1 data-aos="fade-up">Crop Guide</h1>
            <p data-aos="fade-up" data-aos-delay="100">Learn about different crops, growing conditions, and best practices for maximum yield.</p>
        </div>
    </section>
    <section class="crop-section schemes-section">
        <div class="container">
            @if(isset($categories) && $categories->isNotEmpty())
                <form method="GET" class="mb-4 d-flex gap-2 flex-wrap align-items-center">
                    <label class="form-label mb-0">Category:</label>
                    <select name="category" class="form-select form-select-sm" style="max-width:200px;" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->crops_count }})</option>
                        @endforeach
                    </select>
                </form>
            @endif
            @if($crops->isEmpty())
                <p class="text-center text-muted py-5">No crops added yet. Admin can add crops from the admin panel.</p>
            @else
                <div class="row g-4">
                    @foreach($crops as $crop)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up">
                            <div class="crop-card">
                                <div class="crop-image" style="background-image: url('{{ $crop->featured_image ? asset('storage/' . $crop->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');">
                                    @if($crop->badge_text)
                                        <span class="crop-badge">{{ $crop->badge_text }}</span>
                                    @endif
                                </div>
                                <div class="crop-content">
                                    @if($crop->category)
                                        <span class="crop-category">{{ $crop->category->name }}</span>
                                    @endif
                                    <h3 class="crop-title"><a href="{{ route('crop.show', $crop->slug) }}">{{ $crop->title }}</a></h3>
                                    <p class="crop-excerpt">{{ Str::limit($crop->excerpt ?? $crop->title, 120) }}</p>
                                    <a href="{{ route('crop.show', $crop->slug) }}" class="learn-more">Read More <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
