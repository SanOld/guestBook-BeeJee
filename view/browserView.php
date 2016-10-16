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
                    <th></th>
                    <th>ID</th>
                    <th>Fistname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>
                       <?php echo "<a  title='Add new'  href='".  BASE_URL . "cr=editor&action=edit&rowid=0"; ?>'>
                          <span class='fa fa-plus-square fa-fw text-danger'></span>
                        </a> 
                    </th>
                <tbody>   
                   <?php
                   foreach($model->data as $key=>$user){
                       echo
                            "<tr data-rowid=$key >
                             <td>
                                <a  title='Edit'  href='" . BASE_URL . "cr=editor&action=edit&rowid=" .$key. "'>
                                <span class='fa fa-pencil fa-fw'></span>
                                </a> 
                             </td>   
                             <td>$user[id]</td>
                             <td>$user[name]</td>
                             <td>$user[lastname]</td>
                             <td>$user[age]</td>    
                             <td>
                                <a  title='Edit'  href='" . BASE_URL . "cr=browser&action=delete&rowid=" .$key. "'>
                                <span class='fa fa-trash-o fa-fw'></span>
                                </a> 
                             </td>                                  
                            </tr>"
                        ;
                   }
                   ?>
                <tbody>      
                </table>    
            </div>      
        </div> 
		</div>

		<!-- Page Content Ends -->
		<?php include('templates/footer.php'); ?>

		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>

	</body>
</html>