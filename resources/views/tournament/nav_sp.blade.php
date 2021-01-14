@if (Auth::user()->role != config('user.role.member'))
  <div class="row">
    <div class="col-4">
      <select name="block" id="selectBlock" class="form-control">
        @foreach ($blocks as $val)
          <option value="{{ $val->block }}" {{ ($selectBlock == $val->block) ? 'selected' : ''}}>{{ $val->block }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6">
      <select name="sheet" id="selectSheet" class="form-control">
        <option value="teamlist" {{ ($selectSheet == 'teamlist') ? 'selected' : ''}}>チーム一覧</option>
        <option value="maingame" {{ ($selectSheet == 'maingame') ? 'selected' : ''}}>本戦</option>
        <option value="progress" {{ ($selectSheet == 'progress') ? 'selected' : ''}}>進捗</option>
        @foreach ($sheets as $val)
          <option value="{{ $val->sheet }}" {{ ($selectSheet == $val->sheet) ? 'selected' : ''}}>{{ $val->sheet }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <!-- <ul class="nav nav-tabs mb-1">
    @foreach ($blocks as $block)
      <li class="nav-item">
        <a class="nav-link @if($selectBlock == $block->block) active @endif"
          href="{{ route('tournament.index', ['block' => $block->block, 'sheet' => 'A']) }}">{{ $block->block }}</a>
      </li>
    @endforeach
  </ul> -->

  <!-- <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'teamlist') active @endif"
        href="{{ route('tournament.teamlist', ['block' => $selectBlock]) }}">チーム一覧</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'maingame') active @endif"
        href="{{ route('tournament.maingame', ['block' => $selectBlock]) }}">本戦</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'sheet') active @endif"
        href="{{ route('tournament.index', ['block' => $selectBlock, 'sheet' => 'sheet']) }}">対戦表</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'progress') active @endif"
        href="{{ route('tournament.progress', ['block' => $selectBlock]) }}">進捗</a>
    </li>
  </ul> -->
  @endif
