<?php
require(C_PATH . '/authController.php');
require(M_PATH . '/browserFeedbackModel.php');

class feedbackController extends authController
{
  public function __construct(){
    parent::__construct();
    $this->model = new browserFeedbackModel( 'feedback' );
  }

  public function createTable(){
    $this->render('feedbackView', $this->model );
  }
  
  public function delete( $arg ){
    $this->model->delete( 'feedback', $arg['rowid'] );
    $this->model->refresh();
    $this->render( 'feedbackView', $this->model );
  }
}
