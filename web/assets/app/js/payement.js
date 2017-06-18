$( function() {
  $('.btn-continue').click( function() {
    $('.payement').css('display', 'block');
    $('.recap').css('display', 'none');
    $('.btn-recap').css('background-color', '#fff');
    $('.btn-recap').css('color',  'black');
    $('.btn-payement').css('background-color', '#ef3054');
     $('.btn-payement').css('color', '#fff');
  });

  $('.btn-recap').click( function() {
    $('.payement').css('display', 'none');
    $('.recap').css('display', 'block');
    $('.btn-recap').css('background-color', '#ef3054');
    $('.btn-recap').css('color',  '#fff');
    $('.btn-payement').css('background-color', '#fff');
     $('.btn-payement').css('color', '#ef3054');
  });
} );