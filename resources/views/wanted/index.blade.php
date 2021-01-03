@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                @include('elements.flash_message')
                <div class="text-right mb-2"><a href="{{ route('wanted.regist') }}" class="btn btn-primary">登録</a></div>
                @if (0 < count($datas))
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr class="thead-light text-center">
                                <th></th>
                                <th>No</th>
                                <th>募集名</th>
                                <th>内容</th>
                                <th>登録日時</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                      <a href="{{ route('wanted.edit', ['id' => $data->id]) }}"><i class="fas fa-edit fa-lg"></i></a>
                                    </td>
                                    <td>{{ $data->id }}</td>
                                    <td><a href="{{ route('wanted.detail', ['id' => $data->id]) }}">{{ $data->name }}</a></td>
                                    <td>{{ $data->note }}</td>
                                    <td>{{ $data->created_at->format('Y/m/d H:i') }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
@endsection
