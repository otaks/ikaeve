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

  $('#addTrBtn').click(function() {
    var new_row = $('#questionTable tbody tr:last-child').clone(true).appendTo('#questionTable tbody');
    new_row.find("input[type='text']").val('');
    new_row.find("input[type='hidden']").val('0');
  });

  $('.deleteTrBtn').click(function() {
    $(this).closest('tr').remove();
  });

});
