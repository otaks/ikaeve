  @if (1 < count($blocks))
    <ul class="nav nav-tabs mb-1">
      @foreach ($blocks as $block)
        <li class="nav-item">
          <a class="nav-link @if($selectBlock == $block->block) active @endif"
            href="{{ route('tournament.index', ['block' => $block->block, 'sheet' => 'all']) }}">{{ $block->block }}</a>
        </li>
      @endforeach
      <li class="nav-item">
        <a class="nav-link" href="#">決勝戦</a>
      </li>
    </ul>
  @endif

  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'teamlist') active @endif"
        href="{{ route('tournament.teamlist', ['block' => $selectBlock]) }}">チーム一覧</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'maingame') active @endif"
        href="{{ route('tournament.maingame', ['block' => $selectBlock]) }}">本戦</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'progress') active @endif"
        href="{{ route('tournament.progress', ['block' => $selectBlock]) }}">進行表</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if($selectSheet == 'all') active @endif"
        href="{{ route('tournament.index', ['block' => $selectBlock, 'sheet' => 'all']) }}">全対戦</a>
    </li>
    @foreach ($sheets as $val)
      <li class="nav-item">
        <a class="nav-link @if($selectSheet == $val->sheet) active @endif"
          href="{{ route('tournament.index', ['block' => $selectBlock, 'sheet' => $val->sheet]) }}">{{ $val->sheet }}</a>
      </li>
    @endforeach
  </ul>
