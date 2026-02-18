@php
    $isEdit = isset($scheme) && $scheme->exists;
    $scheme = $scheme ?? new \App\Models\Scheme();
@endphp

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Basic Info</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="scheme_category_id" class="form-select @error('scheme_category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('scheme_category_id', $scheme->scheme_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('scheme_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $scheme->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (URL) *</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $scheme->slug) }}" required placeholder="pmfby-scheme">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $scheme->badge_text) }}" placeholder="e.g. Central Scheme">
            </div>
            <div class="col-12">
                <label class="form-label">Excerpt (listing)</label>
                <textarea name="excerpt" class="form-control summernote" rows="2" maxlength="500">{{ old('excerpt', $scheme->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Featured Image</label>
                @if($isEdit && $scheme->featured_image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $scheme->featured_image) }}" alt="" style="max-height:80px;"> <label class="ms-2"><input type="checkbox" name="remove_featured_image" value="1"> Remove</label></div>
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ministry</label>
                <input type="text" name="ministry" class="form-control" value="{{ old('ministry', $scheme->ministry) }}" placeholder="Ministry of Agriculture">
            </div>
            <div class="col-md-6">
                <label class="form-label">Deadline</label>
                <input type="text" name="deadline" class="form-control" value="{{ old('deadline', $scheme->deadline) }}" placeholder="e.g. 31 March 2025">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 1 Value</label>
                <input type="text" name="stat1_value" class="form-control" value="{{ old('stat1_value', $scheme->stat1_value) }}" placeholder="e.g. 5%">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 1 Label</label>
                <input type="text" name="stat1_label" class="form-control" value="{{ old('stat1_label', $scheme->stat1_label) }}" placeholder="Farmer Share">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 2 Value</label>
                <input type="text" name="stat2_value" class="form-control" value="{{ old('stat2_value', $scheme->stat2_value) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 2 Label</label>
                <input type="text" name="stat2_label" class="form-control" value="{{ old('stat2_label', $scheme->stat2_label) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 3 Value</label>
                <input type="text" name="stat3_value" class="form-control" value="{{ old('stat3_value', $scheme->stat3_value) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stat 3 Label</label>
                <input type="text" name="stat3_label" class="form-control" value="{{ old('stat3_label', $scheme->stat3_label) }}">
            </div>
            <div class="col-md-6 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $scheme->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $scheme->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>SEO</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $scheme->meta_title) }}"></div>
        <div class="mb-0"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $scheme->meta_description) }}</textarea></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Content (HTML allowed)</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">About Scheme</label><textarea name="about" class="form-control summernote" rows="5">{{ old('about', $scheme->about) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Benefits</label><textarea name="benefits" class="form-control summernote" rows="4">{{ old('benefits', $scheme->benefits) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Benefit Tags</label><textarea name="benefit_tags" class="form-control" rows="2" placeholder="Comma or newline separated, e.g. Crop Insurance, Income Support">{{ old('benefit_tags', is_array($scheme->benefit_tags) ? implode(", \n", $scheme->benefit_tags) : $scheme->benefit_tags) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Eligibility Criteria</label><textarea name="eligibility_criteria" class="form-control summernote" rows="4">{{ old('eligibility_criteria', $scheme->eligibility_criteria) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Premium Rates (HTML/table)</label><textarea name="premium_rates" class="form-control summernote" rows="5">{{ old('premium_rates', $scheme->premium_rates) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Application Process</label><textarea name="application_process" class="form-control summernote" rows="4">{{ old('application_process', $scheme->application_process) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Documents Required</label><textarea name="documents_required" class="form-control summernote" rows="4">{{ old('documents_required', $scheme->documents_required) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Covered Crops</label><textarea name="covered_crops" class="form-control summernote" rows="3">{{ old('covered_crops', $scheme->covered_crops) }}</textarea></div>
        <div class="mb-0"><label class="form-label">Claim Process</label><textarea name="claim_process" class="form-control summernote" rows="4">{{ old('claim_process', $scheme->claim_process) }}</textarea></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Apply CTA</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12"><label class="form-label">CTA Title</label><input type="text" name="apply_cta_title" class="form-control" value="{{ old('apply_cta_title', $scheme->apply_cta_title) }}" placeholder="Apply Now"></div>
            <div class="col-12"><label class="form-label">CTA Text</label><textarea name="apply_cta_text" class="form-control summernote" rows="2">{{ old('apply_cta_text', $scheme->apply_cta_text) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Button Text</label><input type="text" name="apply_cta_button_text" class="form-control" value="{{ old('apply_cta_button_text', $scheme->apply_cta_button_text) }}" placeholder="Apply Online"></div>
            <div class="col-md-6"><label class="form-label">Button URL</label><input type="url" name="apply_cta_button_url" class="form-control" value="{{ old('apply_cta_button_url', $scheme->apply_cta_button_url) }}" placeholder="https://..."></div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Helpline & Important Dates</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Helpline Phone</label><input type="text" name="helpline_phone" class="form-control" value="{{ old('helpline_phone', $scheme->helpline_phone) }}"></div>
            <div class="col-md-6"><label class="form-label">Helpline Email</label><input type="email" name="helpline_email" class="form-control" value="{{ old('helpline_email', $scheme->helpline_email) }}"></div>
            <div class="col-12"><label class="form-label">Important Dates (HTML allowed)</label><textarea name="important_dates" class="form-control summernote" rows="3">{{ old('important_dates', $scheme->important_dates) }}</textarea></div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Resources</strong> <small class="text-muted">(title + URL links for sidebar)</small></div>
    <div class="card-body">
        <div id="resources-container">
            @php
                $resources = $scheme->resources ?? [];
                if (old('resource_title')) {
                    $rt = old('resource_title', []);
                    $ru = old('resource_url', []);
                    $resources = [];
                    foreach ($rt as $i => $title) {
                        $resources[] = ['title' => $title, 'url' => $ru[$i] ?? ''];
                    }
                }
                if (empty($resources)) $resources = [['title'=>'','url'=>'']];
            @endphp
            @foreach($resources as $r)
                <div class="row g-2 mb-2 resource-row">
                    <div class="col-md-5"><input type="text" name="resource_title[]" class="form-control form-control-sm" value="{{ $r['title'] ?? '' }}" placeholder="Title"></div>
                    <div class="col"><input type="url" name="resource_url[]" class="form-control form-control-sm" value="{{ $r['url'] ?? '' }}" placeholder="URL"></div>
                    <div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-resource">×</button></div>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-resource" class="btn btn-sm btn-outline-success mt-2">+ Add Resource</button>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('add-resource')?.addEventListener('click', function() {
    var html = '<div class="row g-2 mb-2 resource-row"><div class="col-md-5"><input type="text" name="resource_title[]" class="form-control form-control-sm" placeholder="Title"></div><div class="col"><input type="url" name="resource_url[]" class="form-control form-control-sm" placeholder="URL"></div><div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-resource">×</button></div></div>';
    document.getElementById('resources-container').insertAdjacentHTML('beforeend', html);
});
document.getElementById('resources-container')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-resource')) e.target.closest('.resource-row')?.remove();
});
</script>
@endpush
