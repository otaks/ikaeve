@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @include('tournament/nav')
                <table class="table table-borderless mt-3" style="table-layout:fixed;">
                      @foreach ($teams as $key => $team)
                          @php
                            $gameCnt = 4;
                          @endphp
                          <tr class="boeder border-white">
                            <th class="p-2 border border-dark" style="width:30px;">{{ $team['sheet'] }}{{ $team['order'] }}</th>
                            <td class="border border-dark" style="width:130px;"></td>
                            @while(0 < $gameCnt)
                              @if ($gameCnt == 4)
                                @if ($key % 2 == 1)
                                  <td style="width:10px;" class="border-bottom border-dark"></td>
                                @elseif ($key % 4 == 0)
                                  <td style="width:10px;"></td>
                                @else
                                  <td style="width:10px;" class="border-right border-dark"></td>
                                @endif
                              @elseif ($gameCnt == 3)
                                @if ($key % 4 == 0)
                                  <td style="width:10px;" class="border-top border-dark"></td>
                                @else
                                  <td style="width:10px;"></td>
                                @endif
                              @elseif ($gameCnt == 2)
                                @if ($key == 6 || $key == 22)
                                 <td style="width:10px;" class="border-top border-right border-dark"></td>
                                @elseif ($key == 13 || $key == 29)
                                 <td style="width:10px;" class="border-bottom border-right border-dark"></td>
                               @else
                                 <td style="width:10px;"></td>
                               @endif
                              @elseif ($gameCnt == 1)
                                @if ($key == 10)
                                 <td style="width:10px;" class="border-top border-right border-dark"></td>
                                @elseif ($key == 25)
                                 <td style="width:10px;" class="border-bottom border-right border-dark"></td>
                                @elseif ($key >= 11 && $key <= 25)
                                 <td style="width:10px;" class="border-right border-dark"></td>
                               @else
                                 <td style="width:10px;"></td>
                               @endif
                              @else
                                <td style="width:10px;"></td>
                              @endif
                              @if ($gameCnt == 4)
                                @if (($key+1)%4 == 0)
                                  <td style="width:10px;" class="border-left border-dark"></td>
                                @elseif ($key % 4 == 0)
                                  <td style="width:10px;" class="border-top border-dark"></td>
                                @else
                                  <td style="width:10px;"></td>
                                @endif
                              @elseif ($gameCnt == 3)
                                @if ($key == 6 || $key == 14 || $key == 22 || $key == 30)
                                 <td style="width:10px;" class="border-top border-left border-dark"></td>
                                @elseif ($key == 4 || $key == 5|| $key == 7
                                 ||$key == 12 ||$key == 13 ||$key == 15
                                 || $key == 20 || $key == 21 || $key == 23
                                 || $key == 28 || $key == 29 || $key == 31)
                                  <td style="width:10px;" class="border-left border-dark"></td>
                                @else
                                  <td style="width:10px;"></td>
                                @endif
                              @elseif ($gameCnt == 2)
                                @if ($key == 7 || $key == 8|| $key == 10|| $key == 11 || $key == 12
                                || $key == 22|| $key == 23|| $key == 24||$key == 26 ||
                                $key == 27 || $key == 28)
                                 <td style="width:10px;" class="border-left border-dark"></td>
                                @elseif ($key == 9 || $key == 25)
                                 <td style="width:10px;" class="border-left border-bottom border-dark"></td>
                                @else
                                 <td style="width:10px;"></td>
                                 @endif
                               @elseif ($gameCnt == 1)
                                 @if ($key == 18)
                                   <td style="width:10px;" class="border-top border-dark"></td>
                                 @else
                                   <td style="width:10px;"></td>
                                 @endif
                              @else
                                <td style="width:10px;"></td>
                              @endif
                              @if ((($key % 4 == 0 || ($key+1) % 4 == 0) && $gameCnt == 4) ||
                                  (($key == 5 || $key == 6) && $gameCnt == 3) ||
                                  (($key == 13 || $key == 14) && $gameCnt == 3) ||
                                  (($key == 21 || $key == 22) && $gameCnt == 3) ||
                                  (($key == 29 || $key == 30) && $gameCnt == 3) ||
                                  (($key == 9 || $key == 10) && $gameCnt == 2) ||
                                  (($key == 25 || $key == 26) && $gameCnt == 2) ||
                                  (($key == 17 || $key == 18) && $gameCnt == 1))
                                  <td class="p-2 border border-dark" style="width:30px;"></td>
                                  <td class="border border-dark" style="width:130px;">あいすめきゅんです<br>1111-2222-3333</td>
                              @else
                                  <td style="width:30px;"></td>
                                  <td style="width:130px;">@if($key == 16 && $gameCnt == 1) ブロック代表 @endif</td>
                              @endif
                              @php
                                $gameCnt--;
                              @endphp
                            @endwhile
                          </tr>
                          @php
                            $gameCnt2 = 5;
                          @endphp
                          @if ($key % 2 == 0)
                            <tr>
                              @while(0 < $gameCnt2)
                                @if ($gameCnt2 == 3)
                                  @if ($key == 4 ||$key == 6 ||$key == 14
                                   ||$key == 12 || $key == 20 || $key == 22
                                   || $key == 28|| $key == 30)
                                    <td style="width:10px;" class="border-right border-dark"></td>
                                  @else
                                    <td style="width:10px;"></td>
                                  @endif
                                @else
                                    <th class="p-2" style="width:10px;"></td>
                                @endif
                                <td style="width:30px;"></td>
                                @if ($gameCnt2 == 5)
                                  @if ($key % 4 == 0)
                                    <td style="width:130px;"></td>
                                  @else
                                    <td style="width:130px;" class="border-right border-dark"></td>
                                  @endif
                                @elseif ($gameCnt2 == 2)
                                  @if ($key == 6 || $key == 8|| $key == 12|| $key == 10
                                  || $key == 22|| $key == 24|| $key == 26|| $key == 28)
                                    <td style="width:130px;" class="border-left border-dark"></td>
                                  @else
                                    <td style="width:130px;"></td>
                                  @endif
                                @elseif ($gameCnt2 == 1)
                                  @if ($key == 12 || $key == 10 || $key == 14|| $key == 16
                                  || $key == 22|| $key == 24|| $key == 20|| $key == 18)
                                    <td style="width:130px;" class="border-right border-dark"></td>
                                  @else
                                    <td style="width:130px;"></td>
                                  @endif
                                @else
                                  <td style="width:130px;"></td>
                                @endif
                                @php
                                  $gameCnt2--;
                                @endphp
                              @endwhile
                            </tr>
                          @endif
                      @endforeach
                </table>
          </div>
      </div>
@endsection
