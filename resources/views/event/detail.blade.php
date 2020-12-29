@extends('layouts.app')

@section('content')
        <div class="card-header">大会詳細</div>
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tr>
                      <th>大会名</th>
                      <td>{{ $data->name }}</td>
                    </tr>
                    <tr>
                      <th>申請日時</th>
                      <td>
                        {{ isset($data->to_recruit_date) ? $data->to_recruit_date->format('Y/m/d H:i') : '' }}〜
                        {{ isset($data->from_recruit_date) ? $data->from_recruit_date->format('Y/m/d H:i') : '' }}
                      </td>
                    </tr>
                    <tr>
                      <th>開催日時</th>
                      <td>
                        {{ isset($data->to_date) ? $data->to_date->format('Y/m/d H:i') : '' }}〜
                        {{ isset($data->from_date) ? $data->from_date->format('Y/m/d H:i') : '' }}
                      </td>
                    </tr>
                    <tr><th>チーム申請数</th><td>{{ count($data->team) }}</tr>
                    <tr><th>チーム承認数</th><td>{{ $data::approved_team($data->id) }}</tr>
                </table>
                <a href="{{ route('team.regist') }}" class="btn btn-primary">参加申請</a>
                <a href="{{ route('team.index') }}" class="btn btn-success">チーム一覧</a>
              </div>
          </div>
@endsection
