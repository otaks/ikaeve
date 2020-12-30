$(function(){

  $('.datepicker1').datetimepicker();
  $('.submit').click(function() {
    // data属性で指定した送信先をform action=""にセット
    $(this).parents('form').attr('action', $(this).data('action'));
  });

  $('input[name^="friend_code[]"]').keyup(function() {
    if ($(this).val().length >= $(this).attr('maxlength')) {
      if ($(this).attr('id') == 'friend_code1') {
        $('#friend_code2').focus();
      } else if ($(this).attr('id') == 'friend_code2') {
        $('#friend_code3').focus();
      }
    }
  });
});
