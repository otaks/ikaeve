
                  @foreach ($sheets as $k => $select)
                  @if (empty($teams[$select->sheet])) @continue @endif
                  <div style="background-color: {{ ($selectSheet != 'all' || ($k % 2 == 0 && $selectSheet == 'all')) ? '#F8FAFC' : 'rgb(218, 227, 243)'}}; padding: 1rem; margin-top: 10px;">
                    <h2 id="{{ ($k + 1) }}" style="margin-top: 10px;">A-{{ $select->sheet }}ブロック</h2>
                    <h3 class="blue_title">現在の結果</h3>
                    @foreach ($teams[$select->sheet] as $k => $team)
                      @if ($k == 1)
                        <p style="font-size:110%"><span class="badge badge-info">{{ $k }}位</span> <b>{{ $k }}.{{ $team['name'] }}</b>&nbsp;<span class="badge badge-warning"><i class="fas fa-crown"></i>1位確定</span><br><span style="font-size:80%">（勝ち点：9、取得率：85.7%）</span>
                      @else
                        <p style="font-size:110%"><span class="badge badge-info">{{ $k }}位</span> {{ $k }}.{{ $team['name'] }} <br><span style="font-size:80%">（勝ち点：9、取得率：85.7%）</span>
                      @endif
                      @if (isset($teams[$select->sheet][$k-1]['name']))<br><span style="font-size:80%">vs {{ $k }}.{{ mb_substr($teams[$select->sheet][$k-1]['name'], 0, 2) }}<font color="red">2</font>-0</span> @endif
                      @if (isset($teams[$select->sheet][$k-2]['name']))<span style="font-size:80%">vs {{ $k }}.{{ mb_substr($teams[$select->sheet][$k-2]['name'],0, 2) }}2-0</span> @endif
                      @if (isset($teams[$select->sheet][$k-3]['name']))<span style="font-size:80%">vs {{ $k }}.{{ mb_substr($teams[$select->sheet][$k-3]['name'], 0, 2) }}?</span> @endif
                    @endforeach
                    <div class="row">
                      <div class="col-md-6 col-12">
                      <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">対戦表</h3>
                        @foreach (config('game.pre') as $key => $val)
                          <table class="table table-bordered mt-1">
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
                                  <td class="p-1">{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }} @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                    <p class="text-center" style="background: #FDCBBF;font-size: 150%;padding: 3px;margin: 5px;">2</p></td>
                                  <td class="text-center p-1">VS</td>
                                  <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }} @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif
                                      <p class="text-center" style="background: #EEEEEE;font-size: 150%;padding: 3px;margin: 5px;">0</p>
                                  </td>
                                  <td class="p-1 align-middle text-center"><a href="{{ route('game.result', ['block' => $selectBlock, 'sheet' => $select->sheet, 'turn' => $key]) }}" class="btn btn-secondary btn-sm">報告</a></td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
