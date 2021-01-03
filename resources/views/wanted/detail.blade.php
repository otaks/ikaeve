@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tr><th>募集名</th><td>{{ $data->name }}</tr>
                    <tr><th>内容</th><td>{!! nl2br(e($data->note)) !!}</tr>
                    <tr><th>登録日時</th><td>{{ $data->created_at->format('Y/m/d H:i') }}</tr>
                  </tr>
                </table>
              </div>
          </div>
@endsection
