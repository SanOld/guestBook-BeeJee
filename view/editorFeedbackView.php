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
            <form id="editform" class="form-horizontal" method="get" action="<?php echo  BASE_URL ;?>">
                <input type="text" class="form-control"  name="cr" value="editorFeedback" style="display: none">
                <input type="text" class="form-control"  name="action" value="save" style="display: none">
                <input type="text" class="form-control"  name="rowid" value="<?php echo $model->data['id']; ?>" style="display: none">
              <div class="form-group">
                <label  class="col-sm-2 control-label">Имя</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  name="fields[]" value="name" style="display: none">
                  <input type="text" class="form-control"  name ="name" field ="name" value="<?php echo $model->data[user][name]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  name="fields[]" value="email" style="display: none">
                  <input type="email" class="form-control"  name ="email" field ="email" value="<?php echo $model->data[user][email]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Сообщение</label>
                <div class="col-sm-10">
                  <input type="text " class="form-control"  name="fields[]" value="text" style="display: none">
                  <!--<input type="text" class="form-control"  name="values[]" value="" style="display: none">-->
                  <textarea  class="form-control"  name ="text" field ="text"  cols="40" rows="6" required ><?php echo $model->data[text]; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="button" id="sbt" class="btn btn-default">Сохранить</button>
                </div>
              </div>
            </form>
          </div>
        </div>

		</div>
		<!-- Page Content Ends -->

		<?php include('templates/footer.php'); ?>

		<div class="md-overlay"></div>

		<?php include('templates/scripts.php'); ?>

	</body>
</html>