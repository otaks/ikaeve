
                  @foreach ($sheets as $select)
                  <p class="mt-2" id="{{ $select->sheet }}"><b>{{ $select->sheet }}ブロック総当たり表</b></p>
                      <table class="table table-bordered table-hover sp-table sheet{{ $select->sheet }}" style="table-layout:fixed;">
                          <thead>
                            <tr>
                              <th class="text-center p-1 align-middle" style="width:40px;">勝点<br>取得率</th>
                              <th class="text-center p-1 align-middle" style="width:15px;">順<br>位</th>
                              <th class="text-center p-1 align-middle" style="width:15px;">N<br>o</th>
                              <th class="text-center p-1 align-middle" style="width:50px;word-wrap:break-word;">チーム名</th>
                              @foreach ($teams[$select->sheet] as $k => $team)
                                  <th class="p-1 align-middle" style="width:50px;word-wrap:break-word;"><a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['name'] }}</a>
                                    @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</th>
                              @endforeach
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($teams[$select->sheet] as $k => $team)
                              <tr>
                                  <td class="text-center p-1">{{ $k + 2 }}<br>{{ $k * 10 }}%</td>
                                  <td class="text-center p-1">{{ 5 - $k }}</td>
                                  <th class="text-center p-1">{{ $k }}</th>
                                  <th class="p-1" style="width:50px;word-wrap:break-word;"><a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['name'] }}</a>
                                    @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                  </th>
                                  @foreach ($teams[$select->sheet] as $key => $team)
                                      @if ($k == $key)
                                          <td class="table-secondary p-1"></td>
                                      @else
                                          <td class="text-center p-1">0-0<br>(0)</td>
                                      @endif
                                  @endforeach
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <p class="mt-2"><b>対戦表</b></p>

                          @foreach (config('game.pre') as $key => $val)
                            <table class="table table-bordered mt-1 sp-table sheet{{ $select->sheet }}" style="width:300px;">
                                <colgroup>
                                  <col style="width: 100px;">
                                  <col style="width: 20px;">
                                  <col style="width: 100px;">
                                  <col style="width: 70px;">
                                </colgroup>
                                <thead>
                                  <tr>
                                    <th class="text-center p-1" colspan="4">第{{ $key }}試合</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach ($val as $k => $conf)
                                  @if (empty($teams[$select->sheet][$conf[0]]['name']) || empty($teams[$select->sheet][$conf[1]]['name']))
                                    @continue
                                  @endif
                                  <tr>
                                    <td class="p-1">{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                      @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</td>
                                    <td class="text-center p-1" style="width:10px;">VS</td>
                                      <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                    @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</td>
                                    <td class="p-1 align-middle text-center">
                                      <a href="{{ route('game.result') }}" class="btn btn-primary btn-sm">報告</a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          @endforeach
                      @endforeach
                    </div>
                </div>
