@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tr><th>大会名</th><td>{{ $data->event->name }}</tr>
                    <tr><th>チーム名</th><td>{{ $data->name }}@if($data->abstention == 1) (棄権) @endif</tr>
                    <tr><th>フレンドコード</th><td>
                      @if($data->friend_code) {{ substr($data->friend_code, 0, 4) }}-{{ substr($data->friend_code, 4, 4) }}-{{ substr($data->friend_code, 8, 4) }} @endif</tr>
                    <tr><th>代表メンバー</th><td>@if($data->member) <a href="{{ route('member.detail', ['id' => $data->member_id]) }}">{{ $data->member->name }}</a> @endif</tr>
                    @foreach($data::members($data->id) as $v => $member)
                      <tr><th>メンバー{{($v+1)}}</th><td><a href="{{ route('member.detail', ['id' => $member->id]) }}">{{ $member->name }}</a>
                        @if($member->twitter)
                            &nbsp;<a href="https://twitter.com/{{ $member->twitter }}" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
                        @endif
                      </tr>
                    @endforeach
                    @if ($data->answer)
                        @foreach($data->answer as $v => $val)
                          @if (!$val->question)
                            @continue
                          @endif
                          <tr><th>{{ $val->question->title }}</th>
                            <td>{{ $val->note }}</a></td>
                          </tr>
                        @endforeach
                    @endif
                    <tr><th>意気込みなど</th><td>{!! nl2br(e($data->note)) !!}</tr>
                    <tr><th>申請日時</th><td>{{ $data->created_at->format('Y/m/d H:i')  }}</tr>
                </table>
              </div>
          </div>
@endsection
