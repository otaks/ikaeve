  <div class="row">
    <div class="col-2 ml-4 p-1">
      <select name="block" id="selectBlock" class="form-control">
        @foreach ($blocks as $val)
          <option value="{{ $val->block }}" {{ ($selectBlock == $val->block) ? 'selected' : ''}}>{{ $val->block }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-4 p-1">
      <select name="sheet" id="selectSheet" class="form-control">
        <option value="teamlist" {{ ($selectSheet == 'teamlist') ? 'selected' : ''}}>チーム一覧</option>
        <option value="all" {{ ($selectSheet == 'all') ? 'selected' : ''}}>全ブロック</option>
        <!--
        <option value="maingame" {{ ($selectSheet == 'maingame') ? 'selected' : ''}}>本戦</option>
        -->
        <option value="progress" {{ ($selectSheet == 'progress') ? 'selected' : ''}}>進行表</option>
        @foreach ($sheets as $val)
          <option value="{{ $val->sheet }}" {{ ($selectSheet == $val->sheet) ? 'selected' : ''}}>{{ $val->sheet }}</option>
        @endforeach
      </select>
    </div>
  </div>
