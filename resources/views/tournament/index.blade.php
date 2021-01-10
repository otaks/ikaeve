@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              <ul class="nav nav-tabs">
                @foreach ($sheets as $sheet)
                  <li class="nav-item">
                    <a class="nav-link @if($selectSheet == $sheet->sheet) active @endif"
                      href="{{ route('tournament.index', ['block' => $selectBlock, 'sheet' => $sheet->sheet]) }}">{{ $sheet->sheet }}</a>
                  </li>
                @endforeach
              </ul>

              <h5 class="mt-2">{{ $selectSheet }}ブロック総当たり表</h5>
              <table class="table table-bordered mt-3">
                  <tr>
                    <th class="text-center">番号</th>
                    <th class="text-center">チーム名</th>
                    @foreach ($teams as $team)
                        <th colspan="2">{{ $team->name }}</th>
                    @endforeach
                    <th class="text-center">勝点</th>
                    <th class="text-center">取得率</th>
                    <th class="text-center">順位</th>
                  </tr>
                  @foreach ($teams as $k => $team)
                    <tr>
                        <th class="text-center">{{ $team->number }}</th>
                        <th>{{ $team->name }}</th>
                        @foreach ($teams as $key => $team)
                            @if ($k == $key)
                                <td class="table-secondary"></td>
                                <td class="table-secondary"></td>
                            @else
                                <td class="text-center">0-0</td>
                                <td class="text-center">0</td>
                            @endif
                        @endforeach
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                  @endforeach
              </table>
              <h5 class="mt-2">対戦表</h5>
          </div>
      </div>
@endsection
