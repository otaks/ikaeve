<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="TSLBB2d8LjX7g5JoATlT9Ef6y4B0XJa0RbaYJMzm">
  <title> TEST大会 </title>
  <!-- Scripts -->
  <script src="http://terracotta.daa.jp/ikaeve/js/app.js" defer=""></script>
  <script src="http://terracotta.daa.jp/ikaeve/js/all.js" defer=""></script>
  <script src="http://terracotta.daa.jp/ikaeve/js/menu.js" defer=""></script>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
  <!-- Styles -->
  <link href="http://terracotta.daa.jp/ikaeve/css/app.css" rel="stylesheet">
  <link href="http://terracotta.daa.jp/ikaeve/css/all.css" rel="stylesheet">
<style>
.card-body {padding:5px;!important}
table {font-size:0.8rem;!important}
</style>

  <!-- datetimepicker -->
  <link href="http://terracotta.daa.jp/ikaeve/css/jquery.datetimepicker.css" rel="stylesheet">
  <script src="http://terracotta.daa.jp/ikaeve/js/jquery.js" defer=""></script>
  <script src="http://terracotta.daa.jp/ikaeve/js/jquery.datetimepicker.full.js" defer=""></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body style="">
  <div id="app">
    <div id="navArea">
      <nav class="hamburger">
        <div class="inner">
          <ul>
            <li><a href="http://terracotta.daa.jp/ikaeve/event/index">大会一覧</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/event/detail/1">大会詳細</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/tournament/index">対戦表</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/team/index">チーム</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/wanted/index">メンバー募集</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/admin/index">管理画面</a></li>
            <li><a href="http://terracotta.daa.jp/ikaeve/logout" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">logout</a></li>
          </ul>
          <form id="logout-form" action="http://terracotta.daa.jp/ikaeve/logout" method="POST" class="d-none"><input type="hidden" name="_token" value="TSLBB2d8LjX7g5JoATlT9Ef6y4B0XJa0RbaYJMzm"></form>
        </div>
      </nav>
      <div class="toggle_btn"><span></span> <span></span> <span></span></div>
      <div id="mask"></div>
      <main>
        <h1>TEST大会 Aブロック </h1>
      </main>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-4"><select name="block" id="selectBlock" class="form-control"><option value="1" selected="selected">1</option> <option value="2">2</option></select></div>
                <div class="col-6"><select name="sheet" id="selectSheet" class="form-control"><option value="teamlist">チーム一覧</option> <option value="maingame">本戦</option> <option value="progress">進捗</option> <option value="A" selected="selected">A</option> <option value="B">B</option> <option value="C">C</option> <option value="D">D</option> <option value="E">E</option> <option value="F">F</option> <option value="G">G</option> <option value="H">H</option> <option value="I">I</option> <option value="J">J</option> <option value="K">K</option> <option value="L">L</option> <option value="M">M</option> <option value="N">N</option> <option value="O">O</option> <option value="P">P</option></select></div>
              </div>

              <div style="background-color: rgb(218, 227, 243); padding: 1rem; margin-top: 10px;">
                <h2 id="A-1" style="margin-top: 10px;">A-1ブロック</h2>
                <ul style="list-style-type: none; border: solid 1px #2E7AA0; padding: 20px;background-color: #F8FAFC;">
                <li style="font-size:110%"><span class="badge badge-info">1位</span>　4.まけたくない</li>
                <li style="font-size:110%"><span class="badge badge-info">2位</span>　3.平均パワー2900？？</li>
                <li style="font-size:110%"><span class="badge badge-info">3位</span>　2.カレーライス大好き</li>
                <li style="font-size:110%"><span class="badge badge-info">4位</span>　1.裏取リッター</li>
                </ul>
                <div class="row">
                  <div class="col-md-6 col-12">
                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">対戦表</h3>
                    <table class="table table-bordered mt-1">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第1試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #EEEEEE;">
                          <td class="p-1">1.裏取リッター </td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">2.カレーライス大好き<span class="badge badge-warning">棄権</span></td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-outline-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第2試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #EEEEEE;">
                          <td class="p-1">1.裏取リッター</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-outline-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.カレーライス大好き</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered mt-1 sheetA">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%"> </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第3試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.裏取リッター</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.カレーライス大好き</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">結果表</h3>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">1.裏取リッター </h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center">0-2</td>
		                          <td class="p-1 text-center">0</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center">1-2</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center">  </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>14.3%</strong></td>
		                          <td class="p-1 text-center"><strong>1</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>


                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">2.カレーライス大好き</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>

　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center">0-2</td>
		                          <td class="p-1 text-center">0</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center">1-2</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center">  </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>50.0%</strong></td>
		                          <td class="p-1 text-center"><strong>3</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">3.平均パワー2900？？</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center">2-0</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center">2-1</td>
		                          <td class="p-1 text-center">3</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>50.0%</strong></td>
		                          <td class="p-1 text-center"><strong>4</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">4.まけたくない</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>0.0%</strong></td>
		                          <td class="p-1 text-center"><strong>0</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-bottom: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>
              </div>

              <div style="background-color: #F8FAFC; padding: 1rem; margin-top: 10px;">
                <h2 id="A-2" style="margin-top: 10px;">A-2ブロック</h2>
                <ul style="list-style-type: none; border: solid 1px #2E7AA0; padding: 20px;">
                <li style="font-size:110%"><span class="badge badge-info">1位</span>　4.まけたくない</li>
                <li style="font-size:110%"><span class="badge badge-info">2位</span>　3.平均パワー2900？？</li>
                <li style="font-size:110%"><span class="badge badge-info">3位</span>　2.カレーライス大好き</li>
                <li style="font-size:110%"><span class="badge badge-info">4位</span>　1.裏取リッター</li>
                </ul>
                <div class="row">
                  <div class="col-md-6 col-12">
                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">対戦表</h3>
                    <table class="table table-bordered mt-1">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第1試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #EEEEEE;">
                          <td class="p-1">1.裏取リッター </td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">2.カレーライス大好き<span class="badge badge-warning">棄権</span></td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-outline-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第2試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #EEEEEE;">
                          <td class="p-1">1.裏取リッター</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-outline-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.カレーライス大好き</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered mt-1 sheetA">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%"> </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第3試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.裏取リッター</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.まけたくない</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.カレーライス大好き</td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">3.平均パワー2900？？</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">結果表</h3>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">1.裏取リッター </h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center">0-2</td>
		                          <td class="p-1 text-center">0</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center">1-2</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center">  </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>14.3%</strong></td>
		                          <td class="p-1 text-center"><strong>1</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>


                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">2.カレーライス大好き</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>

　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center">0-2</td>
		                          <td class="p-1 text-center">0</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center">1-2</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center">  </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>50.0%</strong></td>
		                          <td class="p-1 text-center"><strong>3</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">3.平均パワー2900？？</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center">2-0</td>
		                          <td class="p-1 text-center">1</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center">2-1</td>
		                          <td class="p-1 text-center">3</td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">4.まけたくない</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>50.0%</strong></td>
		                          <td class="p-1 text-center"><strong>4</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-top: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>

                    <h4 style="font-size: 1.1rem; padding: 7px; border-bottom: dotted 1px #2E7AA0;!important">4.まけたくない</h4>
                    <div style="margin-left: 0.5rem;">
	                    <table class="table table-bordered mt-1" style="margin-bottom: 0.4rem;!important">
	                      <colgroup>
	                        <col style="width: 50%">
	                        <col style="width: 30%">
	                        <col style="width: 20%">
	                      </colgroup>
　　　　　　　　　　　　　　<thead>
		                        <tr style="background: #CCCCCC;white-space: nowrap;">
		                          <th class="p-1">対戦相手</th>
		                          <th class="p-1 text-center">スコア</th>
		                          <th class="p-1 text-center">勝ち点</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                          <td class="p-1">1.裏取リッター</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">2.カレーライス大好き</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                        <tr>
		                          <td class="p-1">3.平均パワー2900？？</td>
		                          <td class="p-1 text-center"> </td>
		                          <td class="p-1 text-center"> </td>
		                        </tr>
		                    </tbody>
	                        <tfoot style="border-top: 2px solid #333333;">
		                        <tr>
		                          <td class="p-1">(取得率 / 総勝ち点)</td>
		                          <td class="p-1 text-center"><strong>0.0%</strong></td>
		                          <td class="p-1 text-center"><strong>0</strong></td>
		                        </tr>
	                        </tfoot>
	                      </table>
	                      <p style="text-align: right;margin-bottom: 0;!important"><span class="small">（申請日：2021/01/04 23:53:30）</span> </p>
	                    </div>
              </div>


              <div style="background-color: rgb(218, 227, 243); padding: 1rem; margin-top: 10px;">
                <h2 id="A-3" style="margin-top: 10px;">A-3ブロック</h2>
                <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;">結果表</h3>
                <table class="table table-bordered table-hover sheetA" style="table-layout: fixed;">
                  <thead>
                    <tr style="background: #CCCCCC;white-space: nowrap;">
                      <th class="text-center p-1 align-middle" style="width: 7%;">No</th>
                      <th class="text-center p-1 align-middle" style="width: 60%;overflow-wrap: break-word;">チーム名</th>
                      <th class="text-center p-1 align-middle">勝点</th>
                      <th class="text-center p-1 align-middle">取得率</th>
                      <th class="text-center p-1 align-middle">順位</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-center p-1">1</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/50" target="_blank">2チーム1/50</a></th>
                      <td class="text-center p-1">3</td>
                      <td class="text-center p-1">10%</td>
                      <td class="text-center p-1">4</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">2</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/86" target="_blank">チーム1/22</a> <span class="badge badge-warning">棄権</span></th>
                      <td class="text-center p-1">4</td>
                      <td class="text-center p-1">20%</td>
                      <td class="text-center p-1">3</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">3</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/16" target="_blank">2チーム1/16</a></th>
                      <td class="text-center p-1">5</td>
                      <td class="text-center p-1">30%</td>
                      <td class="text-center p-1">2</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">4</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/102" target="_blank">チーム1/38</a></th>
                      <td class="text-center p-1">6</td>
                      <td class="text-center p-1">40%</td>
                      <td class="text-center p-1">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-6 col-12">
                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">対戦表</h3>
                    <table class="table table-bordered mt-1">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第1試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50 </td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.チーム1/38 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第2試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50 </td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">4.チーム1/38 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered mt-1 sheetA">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%"> </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第3試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50 </td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.チーム1/38 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div style="background-color: #F8FAFC; padding: 1rem; margin-top: 10px;">
                <h2 id="A-4" style="margin-top: 10px;">A-4ブロック</h2>
                <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;">結果表</h3>
                <table class="table table-bordered table-hover sheetA" style="table-layout: fixed;">
                  <thead>
                    <tr style="background: #CCCCCC;white-space: nowrap;">
                      <th class="text-center p-1 align-middle" style="width: 7%;">No</th>
                      <th class="text-center p-1 align-middle" style="width: 60%;overflow-wrap: break-word;">チーム名</th>
                      <th class="text-center p-1 align-middle">勝点</th>
                      <th class="text-center p-1 align-middle">取得率</th>
                      <th class="text-center p-1 align-middle">順位</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-center p-1">1</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/50" target="_blank">2チーム1/50</a></th>
                      <td class="text-center p-1">3</td>
                      <td class="text-center p-1">10%</td>
                      <td class="text-center p-1">4</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">2</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/86" target="_blank">チーム1/22</a> <span class="badge badge-warning">棄権</span></th>
                      <td class="text-center p-1">4</td>
                      <td class="text-center p-1">20%</td>
                      <td class="text-center p-1">3</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">3</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/16" target="_blank">2チーム1/16</a></th>
                      <td class="text-center p-1">5</td>
                      <td class="text-center p-1">30%</td>
                      <td class="text-center p-1">2</td>
                    </tr>
                    <tr>
                      <th class="text-center p-1">4</th>
                      <th class="p-1" style="overflow-wrap: break-word;"><a href="http://terracotta.daa.jp/ikaeve/team/detail/102" target="_blank">チーム1/38</a></th>
                      <td class="text-center p-1">6</td>
                      <td class="text-center p-1">40%</td>
                      <td class="text-center p-1">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-6 col-12">
                  <h3 style="color: #ffffff; font-size: 1.1rem; padding: 7px; background: #2E7AA0; border-radius: 5px;margin-top: 15px;">対戦表</h3>
                    <table class="table table-bordered mt-1">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第1試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.チーム1/38</td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%">
                      </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第2試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50</td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="text-center p-1">VS</td>
                          <td class="p-1">4.チーム1/38 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered mt-1 sheetA">
                      <colgroup>
                        <col style="width: 36%">
                        <col style="width: 5%">
                        <col style="width: 36%">
                        <col style="width: 23%"> </colgroup>
                      <thead>
                        <tr style="background: #F8EEBE;white-space: nowrap;text-align: left;">
                          <th colspan="4" class="text-center p-1">第3試合</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="p-1">1.2チーム1/50 </td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">4.チーム1/38 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                        <tr>
                          <td class="p-1">2.チーム1/22 <span class="badge badge-warning">棄権</span></td>
                          <td class="text-center p-1" style="width: 10px;">VS</td>
                          <td class="p-1">3.2チーム1/16 </td>
                          <td class="p-1 align-middle text-center"><a href="http://terracotta.daa.jp/ikaeve/game/result" class="btn btn-secondary btn-sm">報告</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
