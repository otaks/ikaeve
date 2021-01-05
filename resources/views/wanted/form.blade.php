@include('elements.flash_message')
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">募集者</label>

    <div class="col-md-6">
        {{ Auth::user()->name }}
        @if(Auth::user()->twitter_nickname)
            &nbsp;<a href="https://twitter.com/{{ Auth::user()->twitter_nickname }}" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
        @endif
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">募集名</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', isset($data) ? $data->name : '') }}" required autocomplete="name" autofocus>
        @if($errors->has('name')) <span class="text-danger">{{ $errors->first('name') }}</span> @endif
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">内容</label>

    <div class="col-md-6">
        <textarea class="form-control" name="note">{{ old('note', isset($data) ? $data->note : '') }}</textarea>
    </div>
</div>
