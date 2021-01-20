
                  @foreach ($sheets as $k => $select)
                  @if (empty($teams[$select->sheet])) @continue @endif
                  <div style="background-color: {{ ($selectSheet != 'all' || ($k % 2 == 0 && ($selectSheet == 'all' || $selectSheet == ''))) ? '#F8FAFC' : 'rgb(218, 227, 243)'}}; padding: 1rem; margin-top: 8px;">
                  <div class="row">
                    <div class="col-md-6 col-12">
                    <h2 id="{{ ($k + 1) }}">{{ $selectBlock }}-{{ $select->sheet }}ブロック</h2>
                    <h3 class="blue_title">現在の結果</h3>
                    @foreach ($ranks[$select->sheet] as $k => $team)
                      @if ($k+1 == 1)
                        <p style="font-size:110%"><span class="badge badge-info">{{ $k+1 }}位</span> <b>{{ $team['number'] }}.{{ $team['name'] }}</b>&nbsp;<span class="badge badge-warning"><i class="fas fa-crown"></i>1位確定</span>
                          <br><span style="font-size:80%">（勝ち点：{{ $team['win_num'] }}、取得率：{{ $team['percent'] }}%）</span>
                      @else
                        <p style="font-size:110%"><span class="badge badge-info">{{ $k+1 }}位</span> {{ $team['number'] }}.{{ $team['name'] }}
                          @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>
                          @else
                            <br><span style="font-size:80%">（勝ち点：{{ $team['win_num'] }}、取得率：{{ $team['percent'] }}%）</span>
                          @endif
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
                              <col style="width: 23%">
                            </colgroup>
                            <thead>
                              <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                                <th colspan="4" class="text-center p-1">第{{ $key }}試合</th>
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
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[0])
                                        <p class="text-center win_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @else
                                        <p class="text-center lose_block">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @endif
                                    </td>
                                    <td class="text-center p-1">VS</td>
                                    <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[1])
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
                                  <td class="p-1 align-middle text-center">
                                    @if (Auth::user()->role != config('user.role.member') ||
                                    (Auth::user()->role == config('user.role.member') &&
                                      ($member->team_id == $teams[$select->sheet][$conf[0]]['id']) ||
                                      ($member->team_id == $teams[$select->sheet][$conf[1]]['id'])))
                                      <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-secondary btn-sm">報告</a>
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
