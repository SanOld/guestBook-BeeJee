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
                <div class='panel panel-default'>
                   <div class='panel-heading'>
                      Сортировка
                   </div>
                   <div class='panel-body'>
                      <button type="button" id="dateSort" class="btn btn-default">По дате</button>
                      <button type="button" id="nameSort" class="btn btn-default">По имени</button>
                      <button type="button" id="emailSort" class="btn btn-default">По email</button>
                      <button type="button" id="statusSort" class="btn btn-default">По статусу</button>
                   </div>
                </div>
                <table id="feedbackTable" class="table">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                   <?php
                   foreach($model->data as $key=>$feedback){
                     $eye = $feedback['status'] ? 'fa-eye' : 'fa-eye-slash';
                     if($feedback['status'] || $this->user['login'] == 'admin'){
                   ?>
                      <tr data-rowid=$key >
                        <td class="first">
                         <div class='panel panel-default'>
                          <div class='panel-heading'>
                            <?php echo $feedback[user][name]; ?>
                            <div class='pull-right'>(<?php echo $feedback[created_at]; ?>)</div>

                          </div>
                           <div class='panel-body'>
                            <?php if ($feedback[img] != ''){
                             echo  "<img src='" . I_PATH . $feedback[img] . "' class='border'>";
                            }?>
                             <p><?php echo $feedback[text]; ?></p>
                           </div>
                           <div class='panel-footer'>
                                <?php
                                if($feedback['changed']){
                                  echo 'Изменен администратором';
                                } else {
                                  echo 'Не проверен';
                                }
                                ?>
                                <?php if($this->user['login'] == 'admin'){ ?>
                                  <a  title='Status'  class='tools' data-rowid="<?php echo $key; ?>">
                                    <span class='fa <?php echo $eye; ?>  fa-fw'></span>
                                  </a>
                                  <a  title='Edit'  class='tools' href='<?php echo BASE_URL; ?>cr=editorFeedback&action=edit&rowid=<?php echo $key; ?>'>
                                    <span class='fa fa-pencil fa-fw'></span>
                                  </a>
                                  <a  title='delete' class='tools'  href='<?php echo BASE_URL; ?>cr=editorFeedback&action=delete&rowid=<?php echo $key; ?>'>
                                    <span class='fa fa-trash-o fa-fw'></span>
                                  </a>
                                <?php }?>
                           </div>
                         </div>
                        </td>

                        <td class='hide'>
                          <?php echo $feedback[created_at]; ?>
                        </td>
                        <td class='hide'>
                          <?php echo $feedback[user][name]; ?>
                        </td>
                        <td class='hide'>
                          <?php echo $feedback[user][email]; ?>
                        </td>
                        <td class='hide'>
                          <?php echo $feedback[status]; ?>
                        </td>
                      </tr>
                      <?php }?>
                    <?php }?>

                <tbody>
                </table>
              <table id="previewTable" class="table">
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
                      <input type="text" class="form-control"   name ="name" field ="name" value="" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="fields[]" value="email" style="display: none">
                      <input type="email" class="form-control"   name ="email" field ="email" value="" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-2 control-label">
                        Отзыв
                    </label>
                    <div class="col-sm-10">
                      <input type="text " class="form-control"  name="fields[]" value="text" style="display: none">
                      <textarea  class="form-control"   value="" name ="text" field ="text" cols="40" rows="6" required ></textarea>
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