@extends('admin.layout')

@section('title', 'Site Settings')
@section('header', 'Site Settings')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h6 class="text-success border-bottom pb-2 mb-3">Theme Colors</h6>
                <p class="text-muted small mb-3">Set colors for the website. Leave blank to use defaults. Use hex codes (e.g. #059669).</p>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Primary</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_primary_preview" value="{{ old('theme_primary', $settings['theme_primary'] ?? '#059669') }}" title="Choose primary">
                            <input type="text" name="theme_primary" class="form-control" value="{{ old('theme_primary', $settings['theme_primary'] ?? '') }}" placeholder="#059669" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Secondary</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_secondary_preview" value="{{ old('theme_secondary', $settings['theme_secondary'] ?? '#047857') }}" title="Choose secondary">
                            <input type="text" name="theme_secondary" class="form-control" value="{{ old('theme_secondary', $settings['theme_secondary'] ?? '') }}" placeholder="#047857" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Accent</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_accent_preview" value="{{ old('theme_accent', $settings['theme_accent'] ?? '#10B981') }}" title="Choose accent">
                            <input type="text" name="theme_accent" class="form-control" value="{{ old('theme_accent', $settings['theme_accent'] ?? '') }}" placeholder="#10B981" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Text Dark</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_text_dark_preview" value="{{ old('theme_text_dark', $settings['theme_text_dark'] ?? '#1a1a1a') }}" title="Choose text dark">
                            <input type="text" name="theme_text_dark" class="form-control" value="{{ old('theme_text_dark', $settings['theme_text_dark'] ?? '') }}" placeholder="#1a1a1a" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Text Light</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_text_light_preview" value="{{ old('theme_text_light', $settings['theme_text_light'] ?? '#666666') }}" title="Choose text light">
                            <input type="text" name="theme_text_light" class="form-control" value="{{ old('theme_text_light', $settings['theme_text_light'] ?? '') }}" placeholder="#666666" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Background</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_background_preview" value="{{ old('theme_background', $settings['theme_background'] ?? '#ffffff') }}" title="Choose background">
                            <input type="text" name="theme_background" class="form-control" value="{{ old('theme_background', $settings['theme_background'] ?? '') }}" placeholder="#ffffff" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Success</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_success_preview" value="{{ old('theme_success', $settings['theme_success'] ?? '#10B981') }}" title="Success">
                            <input type="text" name="theme_success" class="form-control" value="{{ old('theme_success', $settings['theme_success'] ?? '') }}" placeholder="#10B981" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warning</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_warning_preview" value="{{ old('theme_warning', $settings['theme_warning'] ?? '#F59E0B') }}" title="Warning">
                            <input type="text" name="theme_warning" class="form-control" value="{{ old('theme_warning', $settings['theme_warning'] ?? '') }}" placeholder="#F59E0B" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Error</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="theme_error_preview" value="{{ old('theme_error', $settings['theme_error'] ?? '#EF4444') }}" title="Error">
                            <input type="text" name="theme_error" class="form-control" value="{{ old('theme_error', $settings['theme_error'] ?? '') }}" placeholder="#EF4444" maxlength="20">
                        </div>
                    </div>
                </div>
                <script>
                document.querySelectorAll('input[type="color"]').forEach(function(colorInput) {
                    var id = colorInput.id;
                    if (id && id.endsWith('_preview')) {
                        var textName = id.replace('_preview', '');
                        var textInput = document.querySelector('input[name="' + textName + '"]');
                        if (textInput) {
                            colorInput.addEventListener('input', function() { textInput.value = this.value; });
                            textInput.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorInput.value = this.value; });
                        }
                    }
                });
                </script>

                <h6 class="text-success border-bottom pb-2 mb-3">General</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Site Title</label>
                        <input type="text" name="site_title" class="form-control" value="{{ old('site_title', $settings['site_title'] ?? '') }}" placeholder="FasalSarthi">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" placeholder="AI-Powered Farming Assistant">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Logo</label>
                        @if(!empty($settings['logo']))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" style="max-height: 60px;">
                                <label class="ms-2"><input type="checkbox" name="remove_logo" value="1"> Remove logo</label>
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                </div>

                <h6 class="text-success border-bottom pb-2 mb-3">Contact & Address</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone (Alt)</label>
                        <input type="text" name="contact_phone_alt" class="form-control" value="{{ old('contact_phone_alt', $settings['contact_phone_alt'] ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control summernote" rows="2">{{ old('address', $settings['address'] ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Working Hours</label>
                        <input type="text" name="working_hours" class="form-control" value="{{ old('working_hours', $settings['working_hours'] ?? '') }}" placeholder="Mon-Fri: 9AM-6PM">
                    </div>
                </div>

                <h6 class="text-success border-bottom pb-2 mb-3">Footer & SEO</h6>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Footer About (short text)</label>
                        <textarea name="footer_about" class="form-control summernote" rows="2">{{ old('footer_about', $settings['footer_about'] ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description (homepage)</label>
                        <textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                <h6 class="text-success border-bottom pb-2 mb-3">Social Links</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6"><label class="form-label">Facebook</label><input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"></div>
                    <div class="col-md-6"><label class="form-label">Twitter</label><input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"></div>
                    <div class="col-md-6"><label class="form-label">Instagram</label><input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"></div>
                    <div class="col-md-6"><label class="form-label">LinkedIn</label><input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"></div>
                </div>

                <h6 class="text-success border-bottom pb-2 mb-3">Home Page Content</h6>
                <p class="text-muted small mb-3">Edit hero, stats, testimonials, and CTA text. Leave blank to use defaults.</p>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>Hero</strong></div>
                    <div class="col-md-4"><label class="form-label">Hero title (prefix)</label><input type="text" name="hero_title_prefix" class="form-control" value="{{ old('hero_title_prefix', $settings['hero_title_prefix'] ?? '') }}" placeholder="Where"></div>
                    <div class="col-md-4"><label class="form-label">Hero title (highlight)</label><input type="text" name="hero_title_highlight" class="form-control" value="{{ old('hero_title_highlight', $settings['hero_title_highlight'] ?? '') }}" placeholder="AI Meets Agriculture"></div>
                    <div class="col-md-4"><label class="form-label">Hero CTA button</label><input type="text" name="hero_cta_text" class="form-control" value="{{ old('hero_cta_text', $settings['hero_cta_text'] ?? '') }}" placeholder="Get Started Today"></div>
                    <div class="col-12"><label class="form-label">Hero subtitle</label><textarea name="hero_subtitle" class="form-control summernote" rows="2">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea></div>
                    <div class="col-12"><strong>Hero stats (3)</strong></div>
                    <div class="col-md-4"><label class="form-label">Stat 1 number</label><input type="text" name="hero_stat1_number" class="form-control" value="{{ old('hero_stat1_number', $settings['hero_stat1_number'] ?? '') }}" placeholder="50K+"></div>
                    <div class="col-md-4"><label class="form-label">Stat 1 label</label><input type="text" name="hero_stat1_label" class="form-control" value="{{ old('hero_stat1_label', $settings['hero_stat1_label'] ?? '') }}" placeholder="Active farmers"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><label class="form-label">Stat 2 number</label><input type="text" name="hero_stat2_number" class="form-control" value="{{ old('hero_stat2_number', $settings['hero_stat2_number'] ?? '') }}" placeholder="4.8"></div>
                    <div class="col-md-4"><label class="form-label">Stat 2 label</label><input type="text" name="hero_stat2_label" class="form-control" value="{{ old('hero_stat2_label', $settings['hero_stat2_label'] ?? '') }}" placeholder="App Rating"></div>
                    <div class="col-md-4"><label class="form-label">Stat 3 number</label><input type="text" name="hero_stat3_number" class="form-control" value="{{ old('hero_stat3_number', $settings['hero_stat3_number'] ?? '') }}" placeholder="30%"></div>
                    <div class="col-md-4"><label class="form-label">Stat 3 label</label><input type="text" name="hero_stat3_label" class="form-control" value="{{ old('hero_stat3_label', $settings['hero_stat3_label'] ?? '') }}" placeholder="Better Yields"></div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>Features section</strong></div>
                    <div class="col-12"><label class="form-label">Features title</label><input type="text" name="features_title" class="form-control" value="{{ old('features_title', $settings['features_title'] ?? '') }}" placeholder="Empowering Farmers with AI Technology"></div>
                    <div class="col-12"><label class="form-label">Features subtitle</label><textarea name="features_subtitle" class="form-control summernote" rows="2">{{ old('features_subtitle', $settings['features_subtitle'] ?? '') }}</textarea></div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>Experience section</strong></div>
                    <div class="col-12"><label class="form-label">Experience title</label><input type="text" name="experience_title" class="form-control" value="{{ old('experience_title', $settings['experience_title'] ?? '') }}" placeholder="Experience the Future of Farming"></div>
                    <div class="col-12"><label class="form-label">Experience subtitle</label><textarea name="experience_subtitle" class="form-control summernote" rows="2">{{ old('experience_subtitle', $settings['experience_subtitle'] ?? '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Experience button text</label><input type="text" name="experience_btn_text" class="form-control" value="{{ old('experience_btn_text', $settings['experience_btn_text'] ?? '') }}" placeholder="Watch Demo Video"></div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>Testimonials</strong></div>
                    <div class="col-12"><label class="form-label">Testimonials title</label><input type="text" name="testimonials_title" class="form-control" value="{{ old('testimonials_title', $settings['testimonials_title'] ?? '') }}" placeholder="What Farmers Are Saying"></div>
                    <div class="col-12"><label class="form-label">Testimonials subtitle</label><textarea name="testimonials_subtitle" class="form-control summernote" rows="2">{{ old('testimonials_subtitle', $settings['testimonials_subtitle'] ?? '') }}</textarea></div>
                    <div class="col-12 border rounded p-3 bg-light">
                        <label class="form-label">Testimonial 1</label>
                        <textarea name="testimonial1_quote" class="form-control summernote mb-2" rows="2" placeholder="Quote">{{ old('testimonial1_quote', $settings['testimonial1_quote'] ?? '') }}</textarea>
                        <div class="row"><div class="col-md-6"><input type="text" name="testimonial1_name" class="form-control form-control-sm" value="{{ old('testimonial1_name', $settings['testimonial1_name'] ?? '') }}" placeholder="Name"></div><div class="col-md-6"><input type="text" name="testimonial1_role" class="form-control form-control-sm" value="{{ old('testimonial1_role', $settings['testimonial1_role'] ?? '') }}" placeholder="Role"></div></div>
                    </div>
                    <div class="col-12 border rounded p-3 bg-light">
                        <label class="form-label">Testimonial 2</label>
                        <textarea name="testimonial2_quote" class="form-control summernote mb-2" rows="2" placeholder="Quote">{{ old('testimonial2_quote', $settings['testimonial2_quote'] ?? '') }}</textarea>
                        <div class="row"><div class="col-md-6"><input type="text" name="testimonial2_name" class="form-control form-control-sm" value="{{ old('testimonial2_name', $settings['testimonial2_name'] ?? '') }}" placeholder="Name"></div><div class="col-md-6"><input type="text" name="testimonial2_role" class="form-control form-control-sm" value="{{ old('testimonial2_role', $settings['testimonial2_role'] ?? '') }}" placeholder="Role"></div></div>
                    </div>
                    <div class="col-12 border rounded p-3 bg-light">
                        <label class="form-label">Testimonial 3</label>
                        <textarea name="testimonial3_quote" class="form-control summernote mb-2" rows="2" placeholder="Quote">{{ old('testimonial3_quote', $settings['testimonial3_quote'] ?? '') }}</textarea>
                        <div class="row"><div class="col-md-6"><input type="text" name="testimonial3_name" class="form-control form-control-sm" value="{{ old('testimonial3_name', $settings['testimonial3_name'] ?? '') }}" placeholder="Name"></div><div class="col-md-6"><input type="text" name="testimonial3_role" class="form-control form-control-sm" value="{{ old('testimonial3_role', $settings['testimonial3_role'] ?? '') }}" placeholder="Role"></div></div>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>CTA section (middle)</strong></div>
                    <div class="col-12"><label class="form-label">CTA title</label><input type="text" name="cta_title" class="form-control" value="{{ old('cta_title', $settings['cta_title'] ?? '') }}" placeholder="Ready to Transform Your Farming?"></div>
                    <div class="col-12"><label class="form-label">CTA subtitle</label><input type="text" name="cta_subtitle" class="form-control" value="{{ old('cta_subtitle', $settings['cta_subtitle'] ?? '') }}"></div>
                    <div class="col-md-4"><label class="form-label">CTA stat 1</label><input type="text" name="cta_stat1_number" class="form-control form-control-sm" value="{{ old('cta_stat1_number', $settings['cta_stat1_number'] ?? '') }}" placeholder="50,000+"></div><div class="col-md-4"><label class="form-label">Label</label><input type="text" name="cta_stat1_label" class="form-control form-control-sm" value="{{ old('cta_stat1_label', $settings['cta_stat1_label'] ?? '') }}" placeholder="Happy Farmers"></div>
                    <div class="col-md-4"><label class="form-label">CTA stat 2</label><input type="text" name="cta_stat2_number" class="form-control form-control-sm" value="{{ old('cta_stat2_number', $settings['cta_stat2_number'] ?? '') }}" placeholder="4.8★"></div><div class="col-md-4"><label class="form-label">Label</label><input type="text" name="cta_stat2_label" class="form-control form-control-sm" value="{{ old('cta_stat2_label', $settings['cta_stat2_label'] ?? '') }}" placeholder="App Store Rating"></div>
                    <div class="col-md-4"><label class="form-label">CTA stat 3</label><input type="text" name="cta_stat3_number" class="form-control form-control-sm" value="{{ old('cta_stat3_number', $settings['cta_stat3_number'] ?? '') }}" placeholder="30%"></div><div class="col-md-4"><label class="form-label">Label</label><input type="text" name="cta_stat3_label" class="form-control form-control-sm" value="{{ old('cta_stat3_label', $settings['cta_stat3_label'] ?? '') }}" placeholder="Average Yield Increase"></div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12"><strong>Final CTA (green section)</strong></div>
                    <div class="col-12"><label class="form-label">Final CTA title</label><input type="text" name="final_cta_title" class="form-control" value="{{ old('final_cta_title', $settings['final_cta_title'] ?? '') }}" placeholder="Ready to Transform Your Farming?"></div>
                    <div class="col-12"><label class="form-label">Final CTA subtitle</label><textarea name="final_cta_subtitle" class="form-control summernote" rows="2">{{ old('final_cta_subtitle', $settings['final_cta_subtitle'] ?? '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Primary button text</label><input type="text" name="final_cta_btn_primary" class="form-control" value="{{ old('final_cta_btn_primary', $settings['final_cta_btn_primary'] ?? '') }}" placeholder="Download from Google Play"></div>
                    <div class="col-md-6"><label class="form-label">Secondary button text</label><input type="text" name="final_cta_btn_secondary" class="form-control" value="{{ old('final_cta_btn_secondary', $settings['final_cta_btn_secondary'] ?? '') }}" placeholder="Schedule a Demo"></div>
                </div>

                <button type="submit" class="btn btn-admin">Save Settings</button>
            </form>
        </div>
    </div>
@endsection
