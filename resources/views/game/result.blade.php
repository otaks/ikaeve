@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST" name="resultFrm" action="{{ route('game.result') }}">
                    @csrf
                    <h3 class="mb-3 blue_title offset-md-4 col-md-5">
                    {{ $selectBlock }}ブロック {{ $selectSheet }}第{{ $selectTurn }}試合</h3>
                    <div class="form-group row offset-md-4 mt-5">
                        <div class="col-md-3 col-5 text-center">
                          @if ($data)
                            <font color="salmon">{{ $data->winteam->name }}</font>
                            <input type="hidden" name="team[]" value="{{ $data->winteam->id }}">
                          @else
                            <select name="team[]" class="form-control" {{ $defaultTeam[0] ?? 'disabled' }}>
                              @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{($defaultTeam[0] == $team->number) ? 'selected' : ''}}>{{ $team->name }}</option>
                              @endforeach
                            </select>
                          @endif
                        </div>
                        <div class="col-md-1 col-1 text-center"></div>
                        <div class="col-md-3 col-5 text-center">
                          @if ($data)
                            <font color="gray">{{ $data->loseteam->name }}</font>
                            <input type="hidden" name="team[]" value="{{ $data->loseteam->id }}">
                          @else
                            <select name="team[]" class="form-control">
                              @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{($defaultTeam[1] == $team->number) ? 'selected' : ''}}>{{ $team->name }}</option>
                              @endforeach
                            </select>
                          @endif
                        </div>
                    </div>
                    <div class="form-group offset-md-4 row mt-4">
                      <div class="col-md-3 col-4 ml-3">
                        <select name="score[]" class="form-control col-md-10">
                          <option value="0" {{ ($data && $data->win_score == 0) ? 'selected' : '' }}>0</option>
                          <option value="1" {{ ($data && $data->win_score == 1) ? 'selected' : '' }}>1</option>
                          <option value="2" {{ ($data && $data->win_score == 2) ? 'selected' : '' }}>2</option>
                        </select>
                      </div>
                      <div class="col-md-1 col-2"><h3>VS</h3></div>
                      <div class="col-md-3 col-4 ml-3">
                        <select name="score[]" class="form-control col-md-10">
                          <option value="0" {{ ($data && $data->lose_score == 0) ? 'selected' : '' }}>0</option>
                          <option value="1" {{ ($data && $data->lose_score == 1) ? 'selected' : '' }}>1</option>
                          <option value="2" {{ ($data && $data->lose_score == 2) ? 'selected' : '' }}>2</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row offset-md-4">
                      <div class="col-md-3 col-5 text-center">
                        @if ($data && $data->unearned_win == 1)
                          <button type="button" name="unearned[]" style="background:#38c172; color:#fff" class="btn btn-outline-success">不戦勝</button>
                        @else
                          <button type="button" name="unearned[]" class="btn btn-outline-success">不戦勝</button>
                        @endif
                      </div>
                      <div class="col-md-1 col-2 text-center"></div>
                      <div class="col-md-3 col-5 text-center">
                        <button type="button" name="unearned[]" class="btn btn-outline-success">不戦勝</button>
                      </div>
                    </div>
                    <div class="form-group row row offset-md-4">
                        <div class="col-md-7 col-12">
                            <textarea class="form-control" name="memo" rows="7" placeholder="メモ"></textarea>
                        </div>
                    </div>
                    <div class="form-group row offset-md-4">
                        <div class="col-md-7 text-center">
                            <button type="button" id="submitBtn" class="btn btn-primary submit w-25" @if(!$data) 'disabled' @endif>更新</button>
                            <button type="button" id="resetBtn" class="btn btn-secondary w-25">リセット</button>
                            <button type="button" class="btn btn-success submit w-25">削除</button>
                            <input type="hidden" name="unearned_win" id="unearned_win" value="{{ ($data->unearned_win) ?? 0}}">
                            <input type="hidden" name="block" value="{{ $selectBlock }}">
                            <input type="hidden" name="sheet" value="{{ $selectSheet }}">
                            <input type="hidden" name="turn" value="{{ $selectTurn }}">
                            <input type="hidden" name="id" id="result_id" value="{{ ($data->id) ?? ''}}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
