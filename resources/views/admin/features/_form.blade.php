@php
    $isEdit = isset($feature) && $feature->exists;
    $feature = $feature ?? new \App\Models\Feature();
    $iconColors = ['green' => 'Green', 'blue' => 'Blue', 'orange' => 'Orange', 'purple' => 'Purple', 'teal' => 'Teal'];
@endphp

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Basic Info</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $feature->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug (leave blank to auto-generate)</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $feature->slug) }}" placeholder="ai-crop-recommendations">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">Excerpt (short description for cards)</label>
                <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt', $feature->excerpt) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Icon (Font Awesome class)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $feature->icon) }}" placeholder="fa-leaf">
            </div>
            <div class="col-md-6">
                <label class="form-label">Icon color</label>
                <select name="icon_color" class="form-select">
                    <option value="">—</option>
                    @foreach($iconColors as $c => $label)
                        <option value="{{ $c }}" {{ old('icon_color', $feature->icon_color) === $c ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Featured Image</label>
                @if($isEdit && $feature->featured_image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $feature->featured_image) }}" alt="" style="max-height:80px;"> <label class="ms-2"><input type="checkbox" name="remove_featured_image" value="1"> Remove</label></div>
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $feature->sort_order ?? 0) }}" min="0">
            </div>
            <div class="col-md-4 form-check d-flex align-items-center">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label ms-2">Active</label>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Content (detail page)</strong></div>
    <div class="card-body">
        <label class="form-label">Full content (HTML allowed)</label>
        <textarea name="content" class="form-control summernote" rows="10" placeholder="Detail page body">{{ old('content', $feature->content) }}</textarea>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>SEO</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $feature->meta_title) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2" maxlength="500">{{ old('meta_description', $feature->meta_description) }}</textarea>
            </div>
        </div>
    </div>
</div>
