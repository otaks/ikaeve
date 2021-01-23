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
                              @if (Auth::user()->role != config('user.role.member'))
                                <th></th>
                              @endif
                              <th>No</th>
                              <th>募集者</th>
                              <th>内容</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($datas as $data)
                                <tr>
                                  @if (Auth::user()->role != config('user.role.member'))
                                    <td class="text-center">
                                      <a href="{{ route('wanted.edit', ['id' => $data->id]) }}"><i class="fas fa-edit fa-lg"></i></a>
                                    </td>
                                  @endif
                                  <td>{{ $data->id }}</td>
                                  <td>
                                    <a href="{{ route('wanted.detail', ['id' => $data->id]) }}">{{ $data->user->name }}</a>
                                    @if($data->user->twitter_nickname)
                                        &nbsp;<a href="https://twitter.com/{{ $data->user->twitter_nickname }}" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
                                    @endif
                                  </td>
                                  <td>{{ $data->note }}</td>
                                </tr>
                                <tr>
                                  <td colspan="3">{{ $data->weponStr() }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
@endsection
