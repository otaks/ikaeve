@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @include('tournament/nav')
              <h5 class="mt-2">{{ $selectSheet }}ブロック総当たり表</h5>
              <table class="table table-bordered mt-3" style="table-layout:fixed;">
                  <tr>
                    <th class="text-center p-1" style="width:25px;">No</th>
                    <th class="text-center p-1" style="width:80px;">チーム名</th>
                    @foreach ($teams as $team)
                        <th colspan="2" class="p-2" style="width:80px;"><a href="{{ route('team.detail', ['id' => $team->id]) }}" target="_blank">{{ $team->name }}</a>
                          @if ($team->abstention == 1)<span class="badge badge-warning">棄権</span>@endif</th>
                    @endforeach
                    <th class="text-center p-1" style="width:25px;">勝点</th>
                    <th class="text-center p-1" style="width:25px;">取得率</th>
                    <th class="text-center p-1" style="width:25px;">順位</th>
                  </tr>
                  @foreach ($teams as $k => $team)
                    <tr>
                        <th class="text-center p-1">{{ $team->number }}</th>
                        <th class="p-2"><a href="{{ route('team.detail', ['id' => $team->id]) }}" target="_blank">{{ $team->name }}</a>
                          @if ($team->abstention == 1)<span class="badge badge-warning">棄権</span>@endif
                        </th>
                        @foreach ($teams as $key => $team)
                            @if ($k == $key)
                                <td class="table-secondary"></td>
                                <td class="table-secondary"></td>
                            @else
                                <td class="text-center p-1">0-0</td>
                                <td class="text-center p-1">0</td>
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
