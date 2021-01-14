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
    if (sheet == 'progress' || sheet == 'teamlist' || sheet== 'maingame') {
    } else {
      if (!$('#'+sheet).length) {
        location.href = '/tournament/index/' + block + '/' + sheet;
      } else{
        // 取得した値のid属性がついた要素の位置を取得
        offsetTop = $('#'+sheet).offset().top;
        // 取得した箇所に移動
        $("html, body").animate({ scrollTop: offsetTop }, 200);
      }
    }
  });

  $('#selectSheet').change(function() {
    block = $('#selectBlock').val();
    sheet = $(this).val();
    if (sheet == 'progress' || sheet == 'teamlist' || sheet== 'maingame') {
      location.href = '/tournament/' + sheet + '/' + block;
    } else {
      if (!$('#'+sheet).length) {
        location.href = '/tournament/index/' + block + '/' + sheet + '#' + sheet;
      } else{
        // 取得した値のid属性がついた要素の位置を取得
        offsetTop = $('#'+sheet).offset().top;
        // 取得した箇所に移動
        $("html, body").animate({ scrollTop: offsetTop }, 200);
      }
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
});
