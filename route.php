<?php

switch ( $_REQUEST['cr'] ){
  case 'auth':
    require_once( C_PATH . 'authController.php' );
    $auth = new authController();    
    $func = $_REQUEST[ 'action' ];
    $arg = $_REQUEST;
    if( is_callable( array($auth, $func) ) ){
        $auth->$func( $arg );
    }
    break;
  case 'editor':
    require_once( C_PATH . 'editorController.php' );
    $editor = new editorController( $_REQUEST['rowid'] );
    $func = $_REQUEST[ 'action' ];
    $arg = $_REQUEST;
    if( is_callable( array($editor, $func) ) ){
        $editor->$func( $arg );
    }
    break;
  case 'browser':
    require_once( C_PATH . 'browserController.php' );
    $editor = new browserController( $_REQUEST['rowid'] );
    $func = $_REQUEST[ 'action' ];
    $arg = $_REQUEST;
    if( is_callable(array( $editor, $func ) ) ){
        $editor->$func( $arg );
    }
    break;
  case 'feedback':
    require_once( C_PATH . 'feedbackController.php' );
    $editor = new feedbackController( $_REQUEST['rowid'] );
    $func = $_REQUEST[ 'action' ];
    $arg = $_REQUEST;
    if( is_callable(array( $editor, $func ) ) ){
      $editor->$func( $arg );
    } else {
      $editor->createTable(); 
    }
    break;    
  case 'editorFeedback':
    require_once( C_PATH . 'editorFeedbackController.php' );
    $editor = new editorFeedbackController( $_REQUEST['rowid'] );
    $func = $_REQUEST[ 'action' ];
    $arg = $_REQUEST;
    if( is_callable( array($editor, $func) ) ){
        $editor->$func( $arg );
    }
    break;    
  default:
    require_once( C_PATH . 'dashboardController.php' );
    $editor = new dashboardController( $config );
    $editor->render('dashboardView');   
}
