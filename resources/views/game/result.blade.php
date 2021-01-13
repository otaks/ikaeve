@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="offset-md-4 col-md-2 text-md-center">チーム名</div>
                        <div class="col-md-1 text-md-center">VS</div>
                        <div class="col-md-2 text-md-center">チーム名</div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-md-4 col-md-2 col-3 text-md-center">
                        <select name="team_member" class="form-control">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </div>
                      <div class="col-md-1 text-md-center"></div>
                      <div class="col-md-2 col-3 text-md-center">
                        <select name="team_member" class="form-control">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-md-4 col-md-2 col-3 text-md-center">
                        不戦勝
                      </div>
                      <div class="col-md-1 text-md-center"></div>
                      <div class="col-md-2 col-3 text-md-center">
                        不戦勝
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">メモ</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="note">{{ old('note', isset($data) ? $data->note : '') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4 text-center">
                            <button type="submit" class="btn btn-primary submit w-25">編集</button>
                            <button type="submit" class="btn btn-danger submit w-25">削除</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
