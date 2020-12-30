@include('elements.flash_message')
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">チーム名</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', isset($data) ? $data->name : '') }}" required autocomplete="name" autofocus>
        @if($errors->has('name')) <span class="text-danger">{{ $errors->first('name') }}</span> @endif
    </div>
</div>
<div class="form-group row">
    <label for="friend_code" class="col-md-4 col-form-label text-md-right required">フレンドコード</label>

    <div class="col-md-2">
        <input id="friend_code1" type="text" class="form-control friend_code @error('friend_code') is-invalid @enderror" name="friend_code[]"
        value="{{ old('friend_code.0', isset($data) ? substr($data->friend_code, 0, 4) : '') }}" maxlength="4" required>
    </div>
    <div class="col-md-2">
        <input id="friend_code2" type="text" class="form-control friend_code @error('friend_code') is-invalid @enderror" name="friend_code[]"
        value="{{ old('friend_code.1', isset($data) ? substr($data->friend_code, 4, 4) : '') }}" maxlength="4" required>
    </div>
    <div class="col-md-2">
        <input id="friend_code3" type="text" class="form-control @error('friend_code') is-invalid @enderror" name="friend_code[]"
        value="{{ old('friend_code.2', isset($data) ? substr($data->friend_code, 8, 4) : '') }}" maxlength="4" required>
    </div>
</div>
@if($errors->has('friend_code.*'))
<div class="form-group row">
    <label for="error" class="col-md-4 col-form-label text-md-right"></label>
    <div class="col-md-6">
        <span class="text-danger">{{ $errors->first('friend_code.*') }}</span>
    </div>
</div>
@endif
@for ($i = 0; $i < $member_num; $i++)
    <input type="hidden" name="member_id[]" value="{{ isset($members[$i]) ? $members[$i]->id : '0' }}">
    <div class="form-group row">
        <label for="member_name[]" class="col-md-4 col-form-label text-md-right required">メンバー{{ ($i+1) }}</label>

        <div class="col-md-6">
            <input id="member_name[]" type="text" class="form-control @error('name') is-invalid @enderror" name="member_name[]"
            value="{{ old('member_name.'.$i, isset($members[$i]) ? $members[$i]->name : '') }}" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="twitter[]" class="col-md-4 col-form-label text-md-right required">twitter</label>

        <div class="col-md-6">
            <input id="twitter[]" type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter[]"
            value="{{ old('twitter.'.$i, isset($members[$i]) ? $members[$i]->twitter : '') }}" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="xp[]" class="col-md-4 col-form-label text-md-right required">xp</label>

        <div class="col-md-6">
            <input id="xp[]" type="text" class="form-control @error('xp') is-invalid @enderror" name="xp[]"
            value="{{ old('xp.'.$i, isset($members[$i]) ? $members[$i]->xp : '') }}" required>
        </div>
    </div>
@endfor
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">意気込みなど</label>

    <div class="col-md-6">
        <textarea class="form-control" name="note">{{ old('note', isset($data) ? $data->note : '') }}</textarea>
    </div>
</div>
@guest
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right required">修正パスワード</label>

        <div class="col-md-6">
            <input id="pass" type="password" class="form-control @error('pass') is-invalid @enderror" name="pass"
            value="" required autocomplete="pass" placeholder="半角数字4桁">
            @if($errors->has('pass')) <span class="text-danger">{{ $errors->first('pass') }}</span> @endif
        </div>
    </div>
@endguest
