
                  @foreach ($sheets as $k => $select)
                  @if (empty($teams[$select->sheet])) @continue @endif
                  <div style="background-color: {{ ($selectSheet != 'all' || ($k % 2 == 0 && ($selectSheet == 'all' || $selectSheet == ''))) ? '#F8FAFC' : 'rgb(218, 227, 243)'}}; padding: 1rem; margin-top: 8px;">
                  <div class="row">
                    <div class="col-md-6 col-12">
                    <h2 id="{{ ($k + 1) }}">{{ $selectBlock }}-{{ $select->sheet }}ブロック</h2>
                    <h3 class="blue_title">現在の結果</h3>
                    @php
                      $rank = 0;
                    @endphp
                    @foreach ($teams[$select->sheet] as $k => $team)
                      @php
                        $rank++;
                      @endphp
                      <p style="font-size:110%">@if ($team['abstention'] == 0 && $team['rank'])<span class="badge badge-info">{{ $rank }}位</span>@endif <a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['number'] }}.{{ $team['name'] }}</a>
                        @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>
                        @else
                          @if ($team['main_game'] == 1)<span class="badge badge-danger">順位確定</span>@endif
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
                                    <td class="p-1 align-bottom">{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[0] &&
                                      $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] != 0)
                                        <p class="text-center win_block align-bottom">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @else
                                        <p class="text-center lose_block align-bottom">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[0]]['id']]['score'] }}</p>
                                      @endif
                                    </td>
                                    <td class="align-middle text-center p-1">VS</td>
                                    <td class="p-1 align-bottom">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      @if($scores[$selectBlock][$select->sheet][$key][$k]['win'] == $conf[1] &&
                                      $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] != 0)
                                        <p class="text-center win_block align-bottom">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] }}</p>
                                      @else
                                        <p class="text-center lose_block align-bottom">{{ $scores[$selectBlock][$select->sheet][$key][$k][$teams[$select->sheet][$conf[1]]['id']]['score'] }}</p>
                                      @endif
                                    </td>
                                  @else
                                    <td class="p-1 align-middle">
                                      {{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                    </td>
                                    <td class="align-middle text-center p-1">VS</td>
                                    <td class="p-1 align-middle">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                    </td>
                                  @endif
                                  @if (Auth::user()->role != config('user.role.member'))
                                    <td class="p-1 align-middle text-center">
                                      @php
                                        $result = \App\Models\Result::chkResult($selectBlock, $select->sheet, $key, $teams[$select->sheet][$conf[0]]['id']);
                                      @endphp
                                      @if (!$result)
                                        <span class="badge badge-secondary">未報告</span>
                                      @else
                                        @if ($result->approval == 0)
                                          <span class="badge badge-warning">未承認</span>
                                        @else
                                          <span class="badge badge-info">確定</span>
                                        @endif
                                      @endif
                                      <br>
                                      <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-outline-info btn-sm">編集</a>
                                    </td>
                                  @else
                                      <td class="p-1 align-middle text-center">
                                      @if($member)
                                          @if(($member->team_id == $teams[$select->sheet][$conf[0]]['id']) ||
                                          ($member->team_id == $teams[$select->sheet][$conf[1]]['id']))
                                            @php
                                              $result = \App\Models\Result::chkResult($selectBlock, $select->sheet, $key, $teams[$select->sheet][$conf[0]]['id']);
                                            @endphp
                                            @if (!$result)
                                              <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-success btn-sm">報告</a>
                                            @else
                                              @if ($result->lose_team_id == $member->team_id && $result->approval == 0)
                                                <a href="{{ route('game.approval', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k, 'mode' => 'app']) }}" class="btn btn-primary btn-sm">承認</a>
                                              @elseif ($result->approval == 0)
                                                <a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key, 'num' => $k]) }}" class="btn btn-outline-info btn-sm">編集</a>
                                                <br><span class="badge badge-success">承認待</span>
                                              @else
                                                <span class="badge badge-info">確定</span>
                                              @endif
                                            @endif
                                          @else
                                            @php
                                              $result = \App\Models\Result::chkResult($selectBlock, $select->sheet, $key, $teams[$select->sheet][$conf[0]]['id']);
                                            @endphp
                                              @if (!$result)
                                                <span class="badge badge-secondary">未報告</span>
                                              @else
                                                @if ($result->approval == 0)
                                                  <span class="badge badge-warning">未承認</span>
                                                @else
                                                  <span class="badge badge-info">確定</span>
                                                @endif
                                            @endif
                                          @endif
                                        @endif
                                      </td>
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
