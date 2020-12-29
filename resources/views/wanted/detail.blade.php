@extends('layouts.app')

@section('content')
        <div class="card-header">メンバー募集詳細</div>
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tr><th>募集名</th><td>{{ $data->name }}</tr>
                    <tr><th>内容</th><td>{{ $data->note }}</tr>
                  </tr>
                </table>
              </div>
          </div>
@endsection
