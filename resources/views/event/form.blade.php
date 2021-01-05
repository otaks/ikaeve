<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">大会名</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', isset($data) ? $data->name : '') }}" required autocomplete="name" autofocus>
        @if($errors->has('name')) <span class="text-danger">{{ $errors->first('name') }}</span> @endif
    </div>
</div>
<div class="form-group row">
    <label for="from_recruit_date" class="col-md-4 col-form-label text-md-right required">募集日時</label>

    <div class="col-md-3 col-5">
      <input id="from_recruit_date" type="text" class="form-control datepicker1 @error('from_recruit_date') is-invalid @enderror" required name="from_recruit_date"
      value="{{ old('from_recruit_date', isset($data->from_recruit_date) ? $data->from_recruit_date->format('Y/m/d H:i') : '') }}" autocomplete="from_recruit_date">
      @if($errors->has('from_recruit_date')) <span class="text-danger">{{ $errors->first('from_recruit_date') }}</span> @endif
    </div>〜
    <div class="col-md-3 col-5">
      <input id="to_recruit_date" type="text" class="form-control datepicker1 @error('to_recruit_date') is-invalid @enderror" required name="to_recruit_date"
      value="{{ old('to_recruit_date', isset($data->to_recruit_date) ? $data->to_recruit_date->format('Y/m/d H:i') : '') }}" autocomplete="to_recruit_date">
      @if($errors->has('to_recruit_date')) <span class="text-danger">{{ $errors->first('to_recruit_date') }}</span> @endif
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right required">開催日時</label>

    <div class="col-md-3 col-5">
      <input id="from_date" type="text" class="form-control datepicker1 @error('from_date') is-invalid @enderror" required name="from_date"
      value="{{ old('from_date', isset($data->from_date) ? $data->from_date->format('Y/m/d H:i') : '') }}" autocomplete="from_date">
      @if($errors->has('from_date')) <span class="text-danger">{{ $errors->first('from_date') }}</span> @endif
    </div>〜
    <div class="col-md-3 col-5">
      <input id="to_date" type="text" class="form-control datepicker1 @error('to_date') is-invalid @enderror" required name="to_date"
      value="{{ old('to_date', isset($data->to_date) ? $data->to_date->format('Y/m/d H:i') : '') }}" autocomplete="to_date">
      @if($errors->has('to_date')) <span class="text-danger">{{ $errors->first('to_date') }}</span> @endif
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">チーム人数</label>

    <div class="col-md-2 col-3">
      <select name="team_member" class="form-control">
        <option value="2" {{ old('team_member', isset($data->team_member) && $data->team_member == 2 ? 'selected' : '') }}>2</option>
        <option value="4" {{ old('team_member', isset($data->team_member) && $data->team_member == 4 ? 'selected' : '') }}>4</option>
      </select>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">概要</label>

    <div class="col-md-6">
        <textarea class="form-control" name="note">{{ old('note', isset($data) ? $data->note : '') }}</textarea>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">一覧表示</label>

    <div class="col-md-2 col-3">
      <select name="view" class="form-control">
        <option value="0" {{ old('view', isset($data->view) && $data->view == 0 ? 'selected' : '') }}>表示</option>
        <option value="1" {{ old('view', isset($data->view) && $data->view == 1 ? 'selected' : '') }}>非表示</option>
      </select>
    </div>
</div>
