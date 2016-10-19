$(document).ready(function() {

  $("#feedbackTable").tablesorter({sortList: [[1,1]]});

    var validator = $( "#editform" ).validate();

    $( "[name = name]" ).rules( "add", {
      required: true,
      maxlength: 20,
      messages: {
        required: "Обязательное для заполнения",
        maxlength: "Введено более 20 символов"
      }
    });
    $( "[name = email]" ).rules( "add", {
      required: true,
      email: true,
      messages: {
        required: "Обязательное для заполнения",
        email: "Некорректный email адрес"
      }
    });
    $( "[name = text]" ).rules( "add", {
      required: true,
      maxlength: 250,
      messages: {
        required: "Обязательное для заполнения",
        maxlength: "Введено более 250 символов"
      }
    });



  $('#back').on('click', function(){
    document.location.href="index.php";
  });

  $( '#sbt' ).on( 'click', function(){





    var form = $( '#sbt' ).closest( 'form' );
    //берем из формы метод передачи данных
      switch (form.attr('id')){
        case 'editform':
            if(validator != undefined && validator.form() ){
              $( "[field = name]" ).attr('name','values[]');
              $( "[field = email]" ).attr('name','values[]');
              $( "[field = text]" ).attr('name','values[]');
            } else {
              return false;
            }
          break;
        default:
      }

    var m_method = form.attr( 'method' );
     m_method = 'POST';
    //получаем адрес скрипта на сервере, куда нужно отправить форму
    var m_action = form.attr( 'action' );
    //получаем данные, введенные пользователем ERR_NAME_NOT_RESOLVED

    var add = $( '#imageForm' ).serialize();
    var m_data = form.serialize();
    $.ajax({
            type:    m_method,
            url:     m_action,
            data:    m_data + '&' + add,
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
      }
    });


    $( "[field = name]" ).attr('name','name');
    $( "[field = email]" ).attr('name','email');
    $( "[field = text]" ).attr('name','text');
  });



  $( '#preview' ).on( 'click', function(){


      $("[preview=preview]").remove();
      var tr = $( "tr:last" ).clone();
      tr.find(".panel-heading").text("Предварительный просмотр");
      var body = tr.find(".panel-body");
      body.text($("[field=text]").val());
      body.find('img').remove();
      if ($('CANVAS')[0] != undefined){
        body.prepend( "<img src="+$('CANVAS')[0].toDataURL()+">" );
      }
      tr.find(".panel-footer").text('');
      tr.attr('preview', 'preview');
      tr.appendTo("#previewTable");

  });


  $( '#addImage').on( 'click', function(){

    if($(this).val() != 1){
      $( '#photo').trigger('click');
    } else {
      var fileId = $('#preview-photo li').attr('data-id');

      if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // Удаляем файл из объекта selectedFiles
      $('#preview-photo li').remove(); // Удаляем превью
      $('input[name^=photo][data-id="' + fileId + '"]').remove(); // Удаляем поле с содержимым файла

      $(this).val(0);
      $(this).html('Добавить изображение')
    }

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

  var d = 0;
  $("#dateSort").click(function() {
      d = !d;
      var sorting = [[1,d]];
      $("#feedbackTable").trigger("sorton",[sorting]);
      return false;
  });

  var n = 0;
  $("#nameSort").click(function() {
      n = !n;
      var sorting = [[2,n]];
      $("#feedbackTable").trigger("sorton",[sorting]);
      return false;
  });

  var e = 0;
  $("#emailSort").click(function() {
      e = !e;
      var sorting = [[3,e]];
      $("#feedbackTable").trigger("sorton",[sorting]);
      return false;
  });

  var s = 0;
  $("#statusSort").click(function() {
      s = !s;
      var sorting = [[4,s]];
      $("#feedbackTable").trigger("sorton",[sorting]);
      return false;
  });


//
//  $("#editform").validate({
//
//   rules:{
//
//        login:{
//            required: true,
//            minlength: 4,
//            maxlength: 16,
//        },
//
//        pswd:{
//            required: true,
//            minlength: 6,
//            maxlength: 16,
//        },
//   },
//
//   messages:{
//
//        login:{
//            required: "Это поле обязательно для заполнения",
//            minlength: "Логин должен быть минимум 4 символа",
//            maxlength: "Максимальное число символо - 16",
//        },
//
//        pswd:{
//            required: "Это поле обязательно для заполнения",
//            minlength: "Пароль должен быть минимум 6 символа",
//            maxlength: "Пароль должен быть максимум 16 символов",
//        },
//
//   }
//
//});
})