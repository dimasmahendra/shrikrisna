<div class="card-subheader">
    <div class="row">
        <div class="col-md-12">SEO Information</div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Title Tag</label>
            </div>
            <div class="form-group">
                <input type="text" id="title_tag" class="form-control @error('title_tag') is-invalid @enderror"
                    name="title_tag" placeholder="Input Title Tag"
                    value="{{ empty(old('title_tag')) ? @$data['title_tag'] : old('title_tag') }}">
                @error('title_tag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Meta Description</label>
            </div>
            <div class="form-group">
                <textarea id="meta_desc" class="form-textarea @error('meta_desc') is-invalid @enderror"
                    rows="10"
                    name="meta_desc">{{ empty(old('meta_desc')) ? @$data['meta_desc'] : old('meta_desc') }}</textarea>
                @error('meta_desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> URL Slug</label>
            </div>
            <div class="form-group">
                <input type="text" id="url_slug" class="form-control @error('url_slug') is-invalid @enderror"
                    name="url_slug" placeholder="Input URL Slug" readonly
                    value="{{ empty(old('url_slug')) ? @$data['url_slug'] : old('url_slug') }}">
                @error('url_slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Canonical</label>
            </div>
            <div class="form-group">
                <input type="text" id="canonical" class="form-control @error('canonical') is-invalid @enderror"
                    name="canonical" placeholder="Input Canonical"
                    value="{{ empty(old('canonical')) ? @$data['canonical'] : old('canonical') }}">
                @error('canonical')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-5">
                <label class="text-label pb-2"><span class="text-danger">*</span> Meta Keyword</label>
            </div>
            <div class="form-group">
                <textarea id="meta_key" class="form-textarea @error('meta_key') is-invalid @enderror" rows="6"
                    name="meta_key">{{ empty(old('meta_key')) ? @$data['meta_key'] : old('meta_key') }}</textarea>
                @error('meta_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>