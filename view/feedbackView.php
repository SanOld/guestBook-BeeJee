<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('templates/head.php'); ?>
	</head>

	<body>
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			 <!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
			
			
			<!-- Page Content Start -->
        <div class="container">
            <div class="row">
                <table class="table table-striped">
                <tbody>   
                   <?php
                   foreach($model->data as $key=>$feedback){
                     $eye = $feedback['status'] ? 'fa-eye' : 'fa-eye-slash';
                     if($feedback['status'] || $this->user['login'] == 'admin'){
                       echo
                            "<tr data-rowid=$key >  
                              <td>
                               <div class='panel panel-default'>
                                 <div class='panel-heading'> 
                                    ".$feedback[user][name]." 
                                  <div class='pull-right'>(".$feedback[created_at].")</div>"
                       ;
                                 if($this->user['login'] == 'admin'){
                                    echo   "
                                            <a  title='Status'  class='tools' data-rowid=".$key.">
                                              <span class='fa $eye fa-fw'></span>
                                            </a>  
                                            <a  title='Edit'  class='tools' href='" . BASE_URL . "cr=editorFeedback&action=edit&rowid=" .$key. "'>
                                              <span class='fa fa-pencil fa-fw'></span>
                                            </a>                                   
                                            <a  title='delete' class='tools' href='" . BASE_URL . "cr=feedback&action=delete&rowid=" .$key. "'>
                                              <span class='fa fa-trash-o fa-fw'></span>
                                            </a>"
                                    ;
                                  } 
                           echo  "</div>
                                 <div class='panel-body'>
                                 <img src='" . I_PATH . $feedback[img] . "'>
                                  $feedback[text]
                                 </div>
                                 <div class='panel-footer'>"
                             ;
                                if($feedback['changed']){
                                  echo 'изменен администратором';
                                }
                          echo "</div>
                               </div>                               
                              </td>    
                            </tr>"
                          ;
                     }    
                   }
                   ?>
                <tbody>      
                </table>    
            </div>
            
            <div class="row ">
              <div class="col-sm-6 pull-left">  
                <form id="editform" class="form-horizontal" method="get" action="<?php echo  BASE_URL ;?>">
                    <input type="text" class="form-control"  name="cr" value="editorFeedback" style="display: none">
                    <input type="text" class="form-control"  name="action" value="save" style="display: none">
                    <input type="text" class="form-control"  name="rowid" value="0" style="display: none">
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">Имя</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="fields[]" value="name" style="display: none">
                      <input type="text" class="form-control"  name="values[]" field ="name" value="">
                    </div>
                  </div>                   
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="fields[]" value="email" style="display: none">
                      <input type="text" class="form-control"  name="values[]" field ="email" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">
                        Отзыв
                    </label>
                    <div class="col-sm-10">
                      <input type="text " class="form-control"  name="fields[]" value="text" style="display: none">
                      <textarea  class="form-control"  name="values[]" value="" field ="text" cols="40" rows="6" required ></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="button" id="addImage" class="btn btn-default pull-right">Добавить изображение</button>
                    </div>
                  </div>  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" id="sbt" class="btn btn-default">Сохранить</button>
                      <button type="button" id="preview" class="btn btn-default pull-right">Предварительный просмотр</button>
                    </div>
                  </div>
                </form>
              </div>  
                
              <div class="col-sm-6">  
                  
                <form id="imageForm" action="<?php echo  BASE_URL  ;?>" method="post" >                  
                    <div>
                        <input type="file"  id="photo" style="display: none">
                    </div>
                    <div>
                        <ul id="preview-photo">
                        </ul>
                    </div>
                </form>
              </div>  
            </div>            
        </div> 
		</div>
    
		<!-- Page Content Ends -->
		<?php include('templates/footer.php'); ?>

		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>

	</body>
</html>