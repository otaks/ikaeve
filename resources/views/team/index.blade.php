@extends('layouts.app')

@section('content')
        @include('share/event_tab')
        <div class="card-body">
            <div class="container-fluid">
                @include('elements.flash_message')
                <form method="POST">
                    @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="name" value="{{ $search['name'] ?? '' }}" placeholder="チーム名部分一致">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="approval">
                                <option></option>
                                <option value="0" @if(isset($search) && $search['approval'] == '0') selected @endif>未承認</option>
                                <option value="1" @if(isset($search) && $search['approval'] == 1) selected @endif>承認済</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </div>
                    <input type="hidden" name="" value="">
                </form>
                @if (0 < count($datas))
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr class="thead-light text-center">
                                <th></th>
                                <th>No</th>
                                <th>チーム名</th>
                                <th>フレンドコード</th>
                                @auth
                                    <th>承認</th>
                                    <th>棄権</th>
                                @endauth
                                <th>ブロック</th>
                                <th>登録日時</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                      <a href="{{ route('team.edit', ['id' => $data->id]) }}"><i class="fas fa-edit fa-lg"></i></a>
                                    </td>
                                    <td>{{ $data->id }}</td>
                                    <td><a href="{{ route('team.detail', ['id' => $data->id]) }}">{{ $data->name }}</a>@if($data->abstention == 1) (棄権) @endif</td>
                                    <td>@if($data->friend_code) {{ substr($data->friend_code, 0, 4) }}-{{ substr($data->friend_code, 4, 4) }}-{{ substr($data->friend_code, 8, 4) }} @endif</td>
                                    @auth
                                        <td class="text-center">
                                          @if($data->approval == 1)
                                              <!--<a href="{{ route('team.update', ['id' => $data->id, 'column' => 'approval', 'value'=> 0]) }}" class="btn btn-danger" style="width:70px;">取消</a>-->
                                              済
                                          @else
                                              <a href="{{ route('team.update', ['id' => $data->id, 'column' => 'approval', 'value'=> 1]) }}" class="btn btn-success" style="width:70px;">承認</a>
                                          @endif
                                        </td>
                                        <td class="text-center">
                                          @if($data->abstention == 0)
                                              <a href="{{ route('team.update', ['id' => $data->id, 'column' => 'abstention', 'value'=> 1]) }}" class="btn btn-danger" style="width:70px;">棄権</a>
                                          @else
                                              <a href="{{ route('team.update', ['id' => $data->id, 'column' => 'abstention', 'value'=> 0]) }}" class="btn btn-success" style="width:70px;">取消</a>
                                          @endif
                                        </td>
                                    @endauth
                                    <td></td>
                                    <td>{{ $data->created_at }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
@endsection
