@include('elements.flash_message')
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
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">修正パスワード</label>

    <div class="col-md-6">
        <input id="pass" type="password" class="form-control @error('pass') is-invalid @enderror" name="pass"
        value="" required autocomplete="pass" autofocus placeholder="半角数字4桁">
        @if($errors->has('pass')) <span class="text-danger">{{ $errors->first('pass') }}</span> @endif
    </div>
</div>
