$(function(){

  $('.datepicker1').datetimepicker();

  $('.submit').click(function() {
    // data属性で指定した送信先をform action=""にセット
    $(this).parents('form').attr('action', $(this).data('action'));
  });

  // フレンドコード入力
  $('input[name^="friend_code[]"]').keyup(function() {
    if ($(this).val().length >= $(this).attr('maxlength')) {
      if ($(this).attr('id') == 'friend_code1') {
        $('#friend_code2').focus();
      } else if ($(this).attr('id') == 'friend_code2') {
        $('#friend_code3').focus();
      }
    }
  });

  // twitter入力
  $('input[name^="twitter[]"]').change(function() {
    name = $(this).val();
    event_id = $('#event_id').val();
    team_id = $('#team_id').val();
    num = $('input[name^="twitter[]"]').index(this);
    $('input[name^="twitter_id[]"]').eq(num).val('');
    api = $('#twitterApi').val();
    url = api+'/'+name+'/'+event_id;
    if (team_id) {
      url += '/'+team_id;
    }
    axios.get(url).then((res) => {
      if(res.data.status == 400) {
        alert(res.data.message);
        $('input[name^="twitter[]"]').eq(num).val('');
      } else {
        $('input[name^="twitter_id[]"]').eq(num).val(res.data.result);
        url = 'https://twitter.com/'+name;
        alert('間違えのないようtwitterアイコンにて確認をお願いします');
        test = $('#twitterLink1').attr("href");

        alert(test);
        $('#twitterLink1').attr('href', url);
      }
    }).catch(error => {
      $('input[name^="twitter[]"]').eq(num).val('');
      alert('エラーが発生しました');
      console.log(error);
    });
  });

  $('#addTrBtn').click(function() {
    var new_row = $('#questionTable tbody tr:last-child').clone(true).appendTo('#questionTable tbody');
    new_row.find("input[type='text']").val('');
    new_row.find("input[type='hidden']").val('0');
  });

  $('.deleteTrBtn').click(function() {
    $(this).closest('tr').remove();
  });

  $('.changeTeamBtn').click(function(e) {
    team = $(this).data('id');
    api = $('#changeApi').val();
    url = api+'/'+team;
    axios.get(url).then((res) => {
      alert(res.data.message);
      if(res.data.status == 200) {
        $(e.target).closest('tr').children('td,th').toggleClass('table-warning');
      } else {
        location.reload();
      }
    }).catch(error => {
      alert('エラーが発生しました');
      console.log(error);
    });
  });

  $('#selectBlock').change(function() {
    block = $(this).val();
    location.href = '/tournament/index/' + block;
  });

  $('#selectSheet').load(function() {
    block = $('#selectBlock').val();
    sheet = $(this).val();
    url = $('#url').val();
    if (sheet == 'progress' || sheet == 'teamlist' || sheet== 'maingame') {
    } else {
      if (!$('#'+sheet).length) {
        location.href = url + '/tournament/index/' + block + '/' + sheet;
      // } else{
      //   // 取得した値のid属性がついた要素の位置を取得
      //   offsetTop = $('#'+sheet).offset().top;
      //   // 取得した箇所に移動
      //   $("html, body").animate({ scrollTop: offsetTop }, 200);
      }
    }
  });

  $('#selectSheet').change(function() {
    block = $('#selectBlock').val();
    sheet = $(this).val();
    url = $('#url').val();
    if (sheet == 'progress' || sheet == 'teamlist' || sheet== 'maingame') {
      location.href = url + '/tournament/' + sheet + '/' + block;
    } else {
        location.href = url + '/tournament/index/' + block + '/' + sheet;
      // } else{
      //   // 取得した値のid属性がついた要素の位置を取得
      //   offsetTop = $('#'+sheet).offset().top;
      //   // 取得した箇所に移動
      //   $("html, body").animate({ scrollTop: offsetTop }, 200);
      // }
    }
  });

  var pagetop = $('#page_top');
  // ボタン非表示
  pagetop.hide();
  // 100px スクロールしたらボタン表示
  $(window).scroll(function () {
     if ($(this).scrollTop() > 100) {
          pagetop.fadeIn();
     } else {
          pagetop.fadeOut();
     }
  });
  pagetop.click(function () {
     $('body, html').animate({ scrollTop: 0 }, 500);
     return false;
  });

  $('[name^="score[]"]').change(function() {
      num = $("[name='score[]']").index(this);
      score1 = $("[name='score[]']").eq(0).val();
      score2 = $("[name='score[]']").eq(1).val();
      if (score1 == score2) {
        alert('同点で更新はできません');
        $("#submitBtn").prop("disabled", true);
        return false;
      } else if(score1 < score2) {
        $("[name='team[]']").eq(1).css("color","salmon");
        $("[name='team[]']").eq(0).css("color","gray");
      } else if(score2 < score1) {
        $("[name='team[]']").eq(0).css("color","salmon");
        $("[name='team[]']").eq(1).css("color","gray");
      }
      $("#submitBtn").prop("disabled", false);
  });

  $('[name^="unearned[]"]').click(function() {
      num = $("[name='unearned[]']").index(this);
      $("[name='unearned[]']").eq(num).css("background","#38c172");
      $("[name='unearned[]']").eq(num).css("color","#fff");
      if (num == 0) {
        $("[name='score[]']").eq(0).val('2');
        $("[name='score[]']").eq(1).val('0');
        $("[name='team[]']").eq(0).css("color","salmon");
        $("[name='team[]']").eq(1).css("color","gray");
      } else if(num == 1) {
        $("[name='score[]']").eq(1).val('2');
        $("[name='score[]']").eq(0).val('0');
        $("[name='team[]']").eq(1).css("color","salmon");
        $("[name='team[]']").eq(0).css("color","gray");
      }
      $("#unearned_win").val('1');
      $("#submitBtn").prop("disabled", false);
  });

  $('#resetBtn').click(function() {
    $("#unearned_win").val('0');
    $("[name='unearned[]']").eq(num).css("background","#fff");
    $("[name='unearned[]']").eq(num).css("color","#38c172");
    $("[name='team[]']").eq(0).css("color","#212529");
    $("[name='team[]']").eq(1).css("color","#212529");
    chk = $('#result_id').val();
    if (chk == '') {
      $("#submitBtn").prop("disabled", true);
    }
    document.resultFrm.reset();
  });

  $('#submitBtn').click(function() {
    team1 = $("[name='team[]']").eq(0).val();
    team2 = $("[name='team[]']").eq(1).val();
    score1 = $("[name='score[]']").eq(0).val();
    score2 = $("[name='score[]']").eq(1).val();
    if (team1 == team2) {
      alert('別のチームを選択してください');
      return false;
    }
    if (score1 == score2) {
      alert('同点で更新はできません');
      return false;
    }
    document.resultFrm.submit();
  });

});
