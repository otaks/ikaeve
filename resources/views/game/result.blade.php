@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST">
                    @csrf
                    <h6>1ブロック A　第1試合　予選</h6>
                    <div class="form-group row mt-4">
                        <div class="offset-md-4 col-md-2 col-5 text-md-center">チーム名</div>
                        <div class="col-md-1 col-2 text-center">VS</div>
                        <div class="col-md-2 col-5 text-center">チーム名</div>
                    </div>
                    <div class="form-group row mt-4">
                      <div class="offset-md-4 col-md-2 col-5 text-md-center">
                        <select name="team_member" class="form-control">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </div>
                      <div class="col-md-1 col-2 text-center"></div>
                      <div class="col-md-2 col-5 text-center">
                        <select name="team_member" class="form-control">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-md-4 col-md-2 col-5 text-center">
                        <button type="button" class="btn btn-outline-success">不戦勝</button>
                      </div>
                      <div class="col-md-1 col-2 text-center"></div>
                      <div class="col-md-2 col-5 text-center">
                        <button type="button" class="btn btn-outline-success">不戦勝</button>
                      </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">メモ</label>

                        <div class="col-md-5 col-12">
                            <textarea class="form-control" name="note" rows="7"></textarea>
                        </div>
                    </div>
                  -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4 text-center">
                            <button type="submit" class="btn btn-primary submit w-25">更新</button>
                            <button type="submit" class="btn btn-danger submit w-25">削除</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
