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

});
