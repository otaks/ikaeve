                @foreach ($sheets as $select)
                <h5 class="mt-2">{{ $select->sheet }}ブロック総当たり表</h5>
                    <table class="table table-bordered table-hover mt-3" style="table-layout:fixed;">
                      <thead>
                        <tr>
                          <th class="text-center p-1 align-middle" style="width:25px;">No</th>
                          <th class="text-center p-1 align-middle" style="width:80px;">チーム名</th>
                          @foreach ($teams[$select->sheet] as $k => $team)
                              <th colspan="2" class="p-2 align-middle" style="width:80px;"><a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['name'] }}</a>
                                @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</th>
                          @endforeach
                          <th class="text-center p-1 align-middle" style="width:25px;">勝点</th>
                          <th class="text-center p-1 align-middle" style="width:25px;">取得率</th>
                          <th class="text-center p-1 align-middle" style="width:25px;">順位</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($teams[$select->sheet] as $k => $team)
                          <tr>
                              <th class="text-center p-1">{{ $k }}</th>
                              <th class="p-2"><a href="{{ route('team.detail', ['id' => $team['id']]) }}" target="_blank">{{ $team['name'] }}</a>
                                @if ($team['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                              </th>
                              @foreach ($teams[$select->sheet] as $key => $team)
                                  @if ($k == $key)
                                      <td class="table-secondary"></td>
                                      <td class="table-secondary"></td>
                                  @else
                                      <td class="text-center p-1">0-0</td>
                                      <td class="text-center p-1">0</td>
                                  @endif
                              @endforeach
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <h5 class="mt-2">対戦表</h5>

                        @foreach (config('game.pre') as $key => $val)
                          <table class="table table-bordered mt-3 sheet{{ $select->sheet }}" style="width:500px;">
                              <colgroup>
                                <col style="width: 200px;">
                                <col style="width: 20px;">
                                <col style="width: 200px;">
                                <col style="width: 70px;">
                              </colgroup>
                              <thead>
                                <tr>
                                  <th colspan="4">第{{ $key }}試合</th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach ($val as $k => $conf)
                                @if (empty($teams[$select->sheet][$conf[0]]['name']) || empty($teams[$select->sheet][$conf[1]]['name']))
                                  @continue
                                @endif
                                <tr>
                                  <td>{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }}
                                    @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</td>
                                  <td class="text-center" style="width:10px;">VS</td>
                                    <td>{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }}
                                  @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif</td>
                                  <td>
                                    <a href="{{ route('game.result') }}" class="btn btn-primary btn-sm">報告</a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      </div>
                  </div>
                  @endforeach
