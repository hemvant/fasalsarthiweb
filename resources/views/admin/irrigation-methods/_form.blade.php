@php
    $isEdit = isset($method) && $method->exists;
    $method = $method ?? new \App\Models\IrrigationMethod();
@endphp

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Basic Info</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="irrigation_category_id" class="form-select @error('irrigation_category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('irrigation_category_id', $method->irrigation_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('irrigation_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $method->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (URL) *</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $method->slug) }}" required placeholder="drip-irrigation">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $method->badge_text) }}" placeholder="e.g. Recommended">
            </div>
            <div class="col-12">
                <label class="form-label">Excerpt (listing)</label>
                <textarea name="excerpt" class="form-control summernote" rows="2" maxlength="500">{{ old('excerpt', $method->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Featured Image</label>
                @if($isEdit && $method->featured_image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $method->featured_image) }}" alt="" style="max-height:80px;"> <label class="ms-2"><input type="checkbox" name="remove_featured_image" value="1"> Remove</label></div>
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 1 Value</label>
                <input type="text" name="stat1_value" class="form-control" value="{{ old('stat1_value', $method->stat1_value) }}" placeholder="90-95%">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 1 Label</label>
                <input type="text" name="stat1_label" class="form-control" value="{{ old('stat1_label', $method->stat1_label) }}" placeholder="Water Efficiency">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 2 Value</label>
                <input type="text" name="stat2_value" class="form-control" value="{{ old('stat2_value', $method->stat2_value) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 2 Label</label>
                <input type="text" name="stat2_label" class="form-control" value="{{ old('stat2_label', $method->stat2_label) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 3 Value</label>
                <input type="text" name="stat3_value" class="form-control" value="{{ old('stat3_value', $method->stat3_value) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 3 Label</label>
                <input type="text" name="stat3_label" class="form-control" value="{{ old('stat3_label', $method->stat3_label) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 4 Value</label>
                <input type="text" name="stat4_value" class="form-control" value="{{ old('stat4_value', $method->stat4_value) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stat 4 Label</label>
                <input type="text" name="stat4_label" class="form-control" value="{{ old('stat4_label', $method->stat4_label) }}">
            </div>
            <div class="col-md-6 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $method->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $method->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>SEO</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $method->meta_title) }}"></div>
        <div class="mb-0"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $method->meta_description) }}</textarea></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Content (HTML allowed)</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">About / Introduction</label><textarea name="about" class="form-control summernote" rows="4">{{ old('about', $method->about) }}</textarea></div>
        <div class="mb-0"><label class="form-label">Full content (components, advantages, steps, etc.)</label><textarea name="content" class="form-control summernote" rows="15">{{ old('content', $method->content) }}</textarea></div>
    </div>
</div>
