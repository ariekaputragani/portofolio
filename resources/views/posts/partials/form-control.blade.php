<input type="hidden" name="user" id="user" value="{{ Auth::user()->id }}">
<div class="mb-3">
    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
    @error('thumbnail')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan Judul" value="{{ old('title') ?? $post->title }}">
    @error('title')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="category" class="form-label">Kategori</label>
    <select name="category" id="category" class="form-select">
        @foreach($categories as $category)
            <option {{ $category->id == $post->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="tags" class="form-label">Tag</label>
    <div class="row">
        <div id="tag" class="col-tag">
            @include('tag-input')
        </div>
    </div>
    
    @error('tags')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="body" class="form-label">Body</label>
    <textarea name="body" id="body" class="form-control" rows="5">{{ old('body') ?? $post->body }}</textarea>
    @error('body')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<button type="submit" class="btn btn-primary">{{ $submit ?? 'Update'}}</button>
