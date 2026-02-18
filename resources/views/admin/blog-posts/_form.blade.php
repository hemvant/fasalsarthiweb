@php
    $isEdit = isset($blogPost) && $blogPost->exists;
    $blogPost = $blogPost ?? new \App\Models\BlogPost();
@endphp

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Basic Info</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="blog_category_id" class="form-select @error('blog_category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('blog_category_id', $blogPost->blog_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('blog_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blogPost->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (URL) *</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $blogPost->slug) }}" required placeholder="ai-crop-yield-prediction">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Published Date</label>
                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $blogPost->published_at?->format('Y-m-d')) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Excerpt (listing)</label>
                <textarea name="excerpt" class="form-control summernote" rows="2" maxlength="500">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Featured Image</label>
                @if($isEdit && $blogPost->featured_image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $blogPost->featured_image) }}" alt="" style="max-height:80px;"> <label class="ms-2"><input type="checkbox" name="remove_featured_image" value="1"> Remove</label></div>
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label">Author Name</label>
                <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $blogPost->author_name) }}" placeholder="Dr. Rajesh Kumar">
            </div>
            <div class="col-md-6">
                <label class="form-label">Read Time</label>
                <input type="text" name="read_time" class="form-control" value="{{ old('read_time', $blogPost->read_time) }}" placeholder="8 min read">
            </div>
            <div class="col-12">
                <label class="form-label">Author Bio</label>
                <textarea name="author_bio" class="form-control summernote" rows="3">{{ old('author_bio', $blogPost->author_bio) }}</textarea>
            </div>
            <div class="col-md-6 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $blogPost->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $blogPost->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>SEO</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $blogPost->meta_title) }}"></div>
        <div class="mb-0"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $blogPost->meta_description) }}</textarea></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Content</strong></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Tags (comma or newline separated)</label>
            <textarea name="tags" class="form-control" rows="2" placeholder="AI, Crop Yield, Farming">{{ old('tags', is_array($blogPost->tags) ? implode(", \n", $blogPost->tags) : '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Table of Contents (HTML, optional)</label>
            <textarea name="table_of_contents" class="form-control summernote" rows="6" placeholder="<ul><li><a href='#section1'>Section 1</a></li></ul>">{{ old('table_of_contents', $blogPost->table_of_contents) }}</textarea>
        </div>
        <div class="mb-0">
            <label class="form-label">Body Content (HTML allowed)</label>
            <textarea name="content" class="form-control summernote" rows="15">{{ old('content', $blogPost->content) }}</textarea>
        </div>
    </div>
</div>
