$(document).ready(function() {
    
  $('#back').on('click', function(){
    document.location.href="index.php";
  });


  $( '#sbt' ).on( 'click', function(){
    var form = $( '#sbt' ).closest( 'form' );
    //берем из формы метод передачи данных
    var m_method = form.attr( 'method' );
     m_method = 'POST';
    //получаем адрес скрипта на сервере, куда нужно отправить форму
    var m_action = form.attr( 'action' );
    //получаем данные, введенные пользователем ERR_NAME_NOT_RESOLVED
    
    var еее = $( '#imageForm' ).serialize();
    var m_data = form.serialize();
    $.ajax({
            type:    m_method,
            url:     m_action,
            data:    m_data + '&' + еее,
            success: function( result, response ){
              $( '#myModal' ).find( '.modal-body' ).text( result );
              $( '#myModal' ).modal( 'show' );
              
              if(response == 'success'){
                
              }
               
            }
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      switch (form.attr('id')){
        case 'loginform':
          document.location.href="index.php";
          break;
        default:
          alert(form.attr('id'));
      }
    });

  });

  $( '#preview' ).on( 'click', function(){
    $("[preview=preview]").remove();
    var tr = $( "tr:first" ).clone();
    tr.find(".panel-heading").text("Предварительный просмотр");
    var body = tr.find(".panel-body");
    body.text($("[field=text]").val());
    
    body.prepend( "<img src="+$('CANVAS')[0].toDataURL()+">" );
    tr.find(".panel-footer").text('');
    tr.attr('preview', 'preview');
    tr.appendTo("table");                     
  });
  
  $( '#addImage').on( 'click', function(){
    $( '#photo').trigger('click');
  })
  
  $( 'a[title="Status"]').on( 'click', function(){
    var _this = $(this);
    $.ajax({
            type:    'get',
            url:     '?cr=editorFeedback&action=toggle',
            data:    ('rowid=' + $(this).data('rowid')),
            success: function( result,response ){
  
              $( '#myModal' ).find( '.modal-body' ).text( result );
              $( '#myModal' ).modal( 'show' ); 
              
              if(response == 'success'){
               var el = _this.find('span')
                var atrq = el.hasClass('fa-eye') ? 'fa fa-eye-slash fa-fw' : 'fa fa-eye fa-fw';
                el.attr('class',atrq);
              }
            }
    });
  })
 
})