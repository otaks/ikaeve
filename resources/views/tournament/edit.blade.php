@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              <ul class="nav nav-tabs">
                @foreach ($blocks as $block)
                  <li class="nav-item">
                    <a class="nav-link @if($selectBlock == $block->block) active @endif"
                      href="{{ route('tournament.edit', ['block' => $block->block]) }}">{{ $block->block }}</a>
                  </li>
                @endforeach
              </ul>

              <h5 class="mt-2">{{ $selectBlock }}ブロック&nbsp;チーム一覧</h5>

              @foreach ($teams as $k => $team)
                @if ($k % 12 == 0)
                  <div class="row">
                @endif
                @if ($k % 4 == 0)
                    <div class="col-md-4 col-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mt-1">
                              <tr class="thead-light">
                                <th class="p-1 text-center" colspan="3">{{ $team->sheet }}</th>
                              </tr>
                              <tr class="thead-light">
                                <th class="text-center">No</th>
                                <th class="text-center">チーム名</th>
                                <th class="text-center"></th>
                              </tr>
                              <tr>
                @endif
                                <td class="text-center">{{ $team->number }}</td>
                                <td>
                                  <a href="{{ route('team.detail', ['id' => $team->id]) }}" target="_blank">{{ $team->name }}</a>
                                  @if ($team->abstention == 1)<span class="badge badge-warning">棄権</span>@endif
                                </td>
                                <td class="text-center">
                                  <button type="button" class="btn btn-sm btn-danger changeTeamBtn"
                                  data-id="{{ $team->id }}"><i class="fas fa-exchange-alt"></i></button>
                                </td>
                              </tr>
                @if (($k + 1) % 4 == 0)
                        </table>
                      </div>
                    </div>
                @endif
                @if (($k + 1) % 12 == 0)
                  </div>
                @endif
              @endforeach
          </div>
      </div>
      <input type="hidden" name="changeApi" id="changeApi" value="{{ route('tournament.changeTeam') }}">
@endsection
