@php
    $isEdit = isset($crop) && $crop->exists;
    $crop = $crop ?? new \App\Models\Crop();
@endphp

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Basic Info</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="crop_category_id" class="form-select @error('crop_category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('crop_category_id', $crop->crop_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('crop_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $crop->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (URL) *</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $crop->slug) }}" required placeholder="wheat-farming-guide">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Excerpt (listing)</label>
                <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt', $crop->excerpt) }}" maxlength="500">
            </div>
            <div class="col-12">
                <label class="form-label">Featured Image</label>
                @if($isEdit && $crop->featured_image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $crop->featured_image) }}" alt="" style="max-height:80px;"> <label class="ms-2"><input type="checkbox" name="remove_featured_image" value="1"> Remove</label></div>
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label">Season</label>
                <input type="text" name="season" class="form-control" value="{{ old('season', $crop->season) }}" placeholder="Rabi / Kharif">
            </div>
            <div class="col-md-4">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration', $crop->duration) }}" placeholder="120-140 Days">
            </div>
            <div class="col-md-4">
                <label class="form-label">Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $crop->badge_text) }}" placeholder="Rabi Season">
            </div>
            <div class="col-md-6 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $crop->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $crop->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Stats (display on detail page)</strong></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Yield</label><input type="text" name="stat_yield" class="form-control" value="{{ old('stat_yield', $crop->stat_yield) }}" placeholder="25-30"></div>
            <div class="col-md-6"><label class="form-label">Yield Label</label><input type="text" name="stat_yield_label" class="form-control" value="{{ old('stat_yield_label', $crop->stat_yield_label) }}" placeholder="Quintal/Acre Yield"></div>
            <div class="col-md-6"><label class="form-label">Profit</label><input type="text" name="stat_profit" class="form-control" value="{{ old('stat_profit', $crop->stat_profit) }}" placeholder="₹25,000"></div>
            <div class="col-md-6"><label class="form-label">Profit Label</label><input type="text" name="stat_profit_label" class="form-control" value="{{ old('stat_profit_label', $crop->stat_profit_label) }}" placeholder="Profit/Acre"></div>
            <div class="col-md-6"><label class="form-label">Temperature</label><input type="text" name="stat_temperature" class="form-control" value="{{ old('stat_temperature', $crop->stat_temperature) }}" placeholder="15-20°C"></div>
            <div class="col-md-6"><label class="form-label">Temperature Label</label><input type="text" name="stat_temperature_label" class="form-control" value="{{ old('stat_temperature_label', $crop->stat_temperature_label) }}" placeholder="Optimal Temperature"></div>
            <div class="col-md-6"><label class="form-label">Rainfall</label><input type="text" name="stat_rainfall" class="form-control" value="{{ old('stat_rainfall', $crop->stat_rainfall) }}" placeholder="75-100cm"></div>
            <div class="col-md-6"><label class="form-label">Rainfall Label</label><input type="text" name="stat_rainfall_label" class="form-control" value="{{ old('stat_rainfall_label', $crop->stat_rainfall_label) }}" placeholder="Rainfall Required"></div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>SEO</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $crop->meta_title) }}" placeholder="Wheat Farming Guide - FasalSarthi"></div>
        <div class="mb-3"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $crop->meta_description) }}</textarea></div>
        <div class="mb-0"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $crop->meta_keywords) }}" placeholder="wheat, farming, rabi crop"></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Content</strong></div>
    <div class="card-body">
        <div class="mb-3"><label class="form-label">About Crop</label><textarea name="about" class="form-control summernote" rows="5">{{ old('about', $crop->about) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Suitable Regions (HTML allowed)</label><textarea name="suitable_regions" class="form-control summernote" rows="4">{{ old('suitable_regions', $crop->suitable_regions) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Soil & Climate Requirements (HTML allowed)</label><textarea name="soil_requirements" class="form-control summernote" rows="4">{{ old('soil_requirements', $crop->soil_requirements) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Growing Guide (HTML allowed)</label><textarea name="growing_guide" class="form-control summernote" rows="6">{{ old('growing_guide', $crop->growing_guide) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Pest & Disease Management (HTML allowed)</label><textarea name="pest_management" class="form-control summernote" rows="4">{{ old('pest_management', $crop->pest_management) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Harvesting & Post-Harvest (HTML allowed)</label><textarea name="harvesting_guide" class="form-control summernote" rows="4">{{ old('harvesting_guide', $crop->harvesting_guide) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Cost & Profit Analysis (HTML/table allowed)</label><textarea name="profit_analysis" class="form-control summernote" rows="6">{{ old('profit_analysis', $crop->profit_analysis) }}</textarea></div>
        <div class="mb-0"><label class="form-label">Government Support & Schemes (HTML allowed)</label><textarea name="government_support" class="form-control summernote" rows="3">{{ old('government_support', $crop->government_support) }}</textarea></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Varieties</strong> <small class="text-muted">(name, duration, yield, features)</small></div>
    <div class="card-body">
        <div id="varieties-container">
            @php
                $varieties = $crop->varieties ?? [];
                if (old('variety_name')) {
                    $vn = old('variety_name', []);
                    $vd = old('variety_duration', []);
                    $vy = old('variety_yield', []);
                    $vf = old('variety_features', []);
                    $varieties = [];
                    foreach ($vn as $i => $name) {
                        $varieties[] = ['name' => $name, 'duration' => $vd[$i] ?? '', 'yield' => $vy[$i] ?? '', 'features' => $vf[$i] ?? ''];
                    }
                }
                if (empty($varieties)) $varieties = [['name'=>'','duration'=>'','yield'=>'','features'=>'']];
            @endphp
            @foreach($varieties as $v)
                <div class="row g-2 mb-2 variety-row">
                    <div class="col-md-3"><input type="text" name="variety_name[]" class="form-control form-control-sm" value="{{ $v['name'] ?? '' }}" placeholder="Name"></div>
                    <div class="col-md-2"><input type="text" name="variety_duration[]" class="form-control form-control-sm" value="{{ $v['duration'] ?? '' }}" placeholder="Duration"></div>
                    <div class="col-md-2"><input type="text" name="variety_yield[]" class="form-control form-control-sm" value="{{ $v['yield'] ?? '' }}" placeholder="Yield"></div>
                    <div class="col"><input type="text" name="variety_features[]" class="form-control form-control-sm" value="{{ $v['features'] ?? '' }}" placeholder="Features"></div>
                    <div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-variety">×</button></div>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-variety" class="btn btn-sm btn-outline-success mt-2">+ Add Variety</button>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light"><strong>Growth Stages</strong> <small class="text-muted">(title, duration, description, icon)</small></div>
    <div class="card-body">
        <div id="stages-container">
            @php
                $stages = $crop->growth_stages ?? [];
                if (old('stage_title')) {
                    $st = old('stage_title', []);
                    $sd = old('stage_duration', []);
                    $sdesc = old('stage_description', []);
                    $si = old('stage_icon', []);
                    $stages = [];
                    foreach ($st as $i => $title) {
                        $stages[] = ['title' => $title, 'duration' => $sd[$i] ?? '', 'description' => $sdesc[$i] ?? '', 'icon' => $si[$i] ?? 'fas fa-seedling'];
                    }
                }
                if (empty($stages)) $stages = [['title'=>'','duration'=>'','description'=>'','icon'=>'fas fa-seedling']];
            @endphp
            @foreach($stages as $s)
                <div class="row g-2 mb-2 stage-row">
                    <div class="col-md-2"><input type="text" name="stage_title[]" class="form-control form-control-sm" value="{{ $s['title'] ?? '' }}" placeholder="Title"></div>
                    <div class="col-md-2"><input type="text" name="stage_duration[]" class="form-control form-control-sm" value="{{ $s['duration'] ?? '' }}" placeholder="Duration"></div>
                    <div class="col"><input type="text" name="stage_description[]" class="form-control form-control-sm" value="{{ $s['description'] ?? '' }}" placeholder="Description"></div>
                    <div class="col-md-2"><input type="text" name="stage_icon[]" class="form-control form-control-sm" value="{{ $s['icon'] ?? 'fas fa-seedling' }}" placeholder="fas fa-leaf"></div>
                    <div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-stage">×</button></div>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-stage" class="btn btn-sm btn-outline-success mt-2">+ Add Stage</button>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('add-variety')?.addEventListener('click', function() {
    var html = '<div class="row g-2 mb-2 variety-row"><div class="col-md-3"><input type="text" name="variety_name[]" class="form-control form-control-sm" placeholder="Name"></div><div class="col-md-2"><input type="text" name="variety_duration[]" class="form-control form-control-sm" placeholder="Duration"></div><div class="col-md-2"><input type="text" name="variety_yield[]" class="form-control form-control-sm" placeholder="Yield"></div><div class="col"><input type="text" name="variety_features[]" class="form-control form-control-sm" placeholder="Features"></div><div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-variety">×</button></div></div>';
    document.getElementById('varieties-container').insertAdjacentHTML('beforeend', html);
});
document.getElementById('varieties-container')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variety')) e.target.closest('.variety-row')?.remove();
});
document.getElementById('add-stage')?.addEventListener('click', function() {
    var html = '<div class="row g-2 mb-2 stage-row"><div class="col-md-2"><input type="text" name="stage_title[]" class="form-control form-control-sm" placeholder="Title"></div><div class="col-md-2"><input type="text" name="stage_duration[]" class="form-control form-control-sm" placeholder="Duration"></div><div class="col"><input type="text" name="stage_description[]" class="form-control form-control-sm" placeholder="Description"></div><div class="col-md-2"><input type="text" name="stage_icon[]" class="form-control form-control-sm" value="fas fa-seedling" placeholder="fas fa-leaf"></div><div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger remove-stage">×</button></div></div>';
    document.getElementById('stages-container').insertAdjacentHTML('beforeend', html);
});
document.getElementById('stages-container')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-stage')) e.target.closest('.stage-row')?.remove();
});
</script>
@endpush
