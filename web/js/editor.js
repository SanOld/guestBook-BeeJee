$(document).ready(function() {
    
  $('#back').on('click', function(){
    document.location.href="index.php";
  });


  $( '#sbt' ).on( 'click', function(){
    var form = $( '#sbt' ).closest( 'form' );
    //берем из формы метод передачи данных
    var m_method = form.attr( 'method' );
    //получаем адрес скрипта на сервере, куда нужно отправить форму
    var m_action = form.attr( 'action' );
    //получаем данные, введенные пользователем 
    var m_data = form.serialize();
    $.ajax({
            type:    m_method,
            url:     m_action,
            data:    m_data,
            success: function( result ){
              $( '#myModal' ).find( '.modal-body' ).text( result );
              $( '#myModal' ).modal( 'show' ); 
            }
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      switch (form.id){
        case 'loginForm':
          document.location.href="index.php";
          break;
        default:
      }
    });

  });

  $( '#preview' ).on( 'click', function(){
    $("[preview=preview]").remove();
    var tr = $( "tr:first" ).clone();
    tr.find(".panel-heading").text("Предварительный просмотр");
    


     
//    var ctx2 = canv.getContext('2d');
//    ctx.drawImage(image, 0, 0, image.width, image.height);
    tr.find(".panel-body").text($("[field=text]").val());
$( "canvas" ).clone().appendTo( ".panel-body" );
    tr.find(".panel-footer").text('');
    tr.attr('preview', 'preview');
    tr.appendTo("table");                     
  });
  
  $( '#addImage').on( 'click', function(){
    $( '#photo').trigger('click');
  })
 
})