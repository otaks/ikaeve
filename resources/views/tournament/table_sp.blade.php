
                  @foreach ($sheets as $k => $select)
                  <div style="background-color: #F8FAFC; padding: 1rem; margin-top: 10px;">
                    <h2 id="{{ ($k + 1) }}" style="margin-top: 10px;">A-{{ $select->sheet }}ブロック</h2>
                    <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;">現在の結果</h3>
                    @foreach ($teams[$select->sheet] as $k => $team)
                      <p style="font-size:110%"><span class="badge badge-info">{{ $k }}位</span> {{ $k }}.{{ $team['name'] }} <br><span style="font-size:80%">（勝ち点：9、取得率：85.7%）</span>
                      @if (isset($teams[$select->sheet][$k-1]['name']))<br><span style="font-size:80%">VS {{ $k }}.{{ $teams[$select->sheet][$k-1]['name'] }}</span> @endif
                      @if (isset($teams[$select->sheet][$k-2]['name']))<span style="font-size:80%">VS {{ $k }}.{{ $teams[$select->sheet][$k-2]['name'] }}</span> @endif
                      @if (isset($teams[$select->sheet][$k-3]['name']))<span style="font-size:80%">VS {{ $k }}.{{ $teams[$select->sheet][$k-3]['name'] }}</span> @endif
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
                                  <td class="p-1">{{ $conf[0] }}.{{ $teams[$select->sheet][$conf[0]]['name'] ?? '' }} @if ($teams[$select->sheet][$conf[0]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif<p class="text-center" style="background: #FDCBBF;font-size: 150%;padding: 3px;margin: 5px;">2</p></td>
                                  <td class="text-center p-1">VS</td>
                                  <td class="p-1">{{ $conf[1] }}.{{ $teams[$select->sheet][$conf[1]]['name'] ?? '' }} @if ($teams[$select->sheet][$conf[1]]['abstention'] == 1)<span class="badge badge-warning">棄権</span>@endif<p class="text-center" style="background: #EEEEEE;font-size: 150%;padding: 3px;margin: 5px;">0</p></td>
                                  <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
