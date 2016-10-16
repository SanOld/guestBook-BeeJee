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

                <form id="loginform" class="form-horizontal" method="get" action="<?php echo  BASE_URL ;?>">
                    <input type="text" class="form-control"  name="cr" value="auth" style="display: none">
                    <input type="text" class="form-control"  name="action" value="login" style="display: none">
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">Login</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="fields[]" value="login" style="display: none">
                      <input type="text" class="form-control"  name="values[]" value="">
                    </div>
                  </div>                   
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="fields[]" value="password" style="display: none">
                      <input type="password" class="form-control"  name="values[]" value="">
                    </div>
                  </div>
  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" id="sbt" class="btn btn-default">Войти</button>
                    </div>
                  </div>

                </form>

   
            </div>      
        </div>
        <!-- Small modal -->

        <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Сообщение</h4>
                </div>
                <div class="modal-body">
                  Данные успешно сохранены
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

                </div>
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