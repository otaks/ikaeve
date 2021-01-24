
                  @foreach ($sheets as $k => $select)
                  @if (empty($teams[$select->sheet])) @continue @endif
                  <div style="background-color: {{ ($selectSheet != 'all' || ($k % 2 == 0 && ($selectSheet == 'all' || $selectSheet == ''))) ? '#F8FAFC' : 'rgb(218, 227, 243)'}}; padding: 1rem; margin-top: 8px;">
                  <div class="row">
                    <div class="col-md-6 col-12">
                    <h2 id="{{ ($k + 1) }}">{{ $selectBlock }}-{{ $select->sheet }}ブロック</h2>
                    <h3 class="blue_title">現在の結果</h3>
                    @foreach ($ranks[$select->sheet] as $k => $team)
                      <p style="font-size:110%"><span class="badge badge-info">{{ $k+1 }}位</span> <a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['number'] }}.{{ $team['name'] }}</a>
                        @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>
                        @else
                          <br><span style="font-size:80%">（勝ち点：{{ $team['win_num'] }}、取得率：{{ $team['percent'] }}%）</span>
                        @endif
                      <br>
                      <span style="font-size:80%">
                      @foreach ($vs[$team['id']] as $val)
                          @if($val['win'] == true)
                            <font color="red">
                          @endif
                            @if ($isMobile)
                              vs {{ mb_substr( $val['name'], 0, 3) }} {{ $val['score'] }}
                            @else
                              vs {{ $val['name'] }} {{ $val['score'] }}<br>
                            @endif
                          @if($val['win'] == true)
                            </font>
                          @endif
                      @endforeach
                      </span>
                    @endforeach
                    </div>
                    <div class="col-md-6 col-12 mt-4">
                      <h3 class="blue_title mt-3">対戦表</h3>
                        @foreach (config('game.pre') as $key => $val)
                          <table class="table table-bordered">
                            <colgroup>
                              <col style="width: 36%">
                              <col style="width: 5%">
                              <col style="width: 36%">
                              @if (Auth::user()->role != config('user.role.member'))
                                <col style="width: 23%">
                              @else
                                @if (Auth::user()->role == config('user.role.member') && isset($member)
                                    && (Auth::user()->member->team->sheet == $select->sheet))
                                    <col style="width: 23%">
                                @endif
                              @endif
                            </colgroup>
                            <thead>
                              <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                                @if (Auth::user()->role != config('user.role.member'))
                                  <th colspan="4" class="text-center p-1">第{{ $key }}試合</th>
                                @else
                                  @if (Auth::user()->role == config('user.role.member') && isset($member)
                                      && (Auth::user()->member->team->sheet == $select->sheet))
                                      <th colspan="4" class="text-center p-1">第{{ $key }}試合</th>
                                  @else
                                    <th colspan="3" class="text-center p-1">第{{ $key }}試合</th>
                                  @endif
                                @endif
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($val as $k => $conf)
                                @if (empty($teams[$select->sheet][$conf[0]]['name']) || empty($teams[$select->sheet][$conf[1]]['name']))
                                  @continue
                                @endif
                                <tr>
                                  @if (isset($scores[$selectBlock][$select->sheet][$key][$k]) &&
                                    ($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[0] ||
                                    $scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[1]))
                                    <td class="p-1">{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[0] &&
                                      $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] != 0)
                                        <p class="text-center win_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @else
                                        <p class="text-center lose_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @endif
                                    </td>
                                    <td class="text-center p-1">VS</td>
                                    <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[1] &&
                                      $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] != 0)
                                        <p class="text-center win_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] }}</p>
                                      @else
                                        <p class="text-center lose_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] }}</p>
                                      @endif
                                    </td>
                                  @else
                                    <td class="p-1">
                                      {{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                    </td>
                                    <td class="text-center p-1">VS</td>
                                    <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                    </td>
                                  @endif
                                  @if (Auth::user()->role != config('user.role.member'))
                                    <td class="p-1 align-middle text-center">
                                      <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-outline-info btn-sm">編集</a>
                                    </td>
                                  @else
                                    @if (Auth::user()->role == config('user.role.member') && isset($member)
                                        && (Auth::user()->member->team->sheet == $select->sheet))
                                        <td class="p-1 align-middle text-center">
                                        @if(($member->team_id == $teams[$select->sheet][$conf[0]]['id']) ||
                                        ($member->team_id == $teams[$select->sheet][$conf[1]]['id']))
                                        @php
                                          $result = Auth::user()->member->chkResult($selectBlock, $select->sheet, $key);
                                        @endphp
                                          @if (!$result)
                                          <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-outline-success btn-sm">報告</a>
                                          @else
                                            @if ($result->lose_team_id == $member->team_id && $result->approval == 0)
                                              <a href="{{ route('game.approval', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k, 'mode' => 'app']) }}" class="btn btn-outline-info btn-sm">承認</a>
                                            @elseif ($result->approval == 0)
                                              <a href="#" class="btn btn-outline-info btn-sm">承認待</a>
                                            @endif
                                          @endif
                                        @endif
                                        </td>
                                    @endif
                                  @endif
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
