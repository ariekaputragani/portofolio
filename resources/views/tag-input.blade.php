<div class="input-group">
    <select name="tags[]" id="tags" class="form-select select2" multiple>
        @foreach($post->tags as $tag)
            <option selected value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
    <button type="button" id="addtag" class="btn btn-primary"><i class="fa fa-plus"></i></button>
</div>
<script src="{{ asset('js/script.js') }}"></script>
