<?php
	require 'includes/config.php';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		updateProject($_POST['id'], $dbh, $_POST['title'],$_POST['image_url'],$_POST['content'],$_POST['link']);
		redirect("index.php");
    }

	$editProject = editProject($_GET['id'], $dbh);

	require 'partials/header.php';
	require 'partials/navigation.php';

?>

	<form class="form-horizontal" role="form" method="POST" action="edit.php">
		<input type="hidden" name="id" value="<?= $editProject['id'] ?>">

	    <!-- Form Title -->
	    <div class="form-group">
	        <label class="col-md-4">
	            Edit project
	        </label>
	    </div>

	    <!-- Title Input -->
	    <div class="form-group">
	        <label for="projectName" class="col-md-4 control-label">Title</label>

	        <div class="col-md-6">
	            <input id="projectName" type="text" class="form-control" name="title" value="<?=$editProject['title']?>" required="" autofocus="">
	        </div>
	    </div>

	    <!-- Image Url Input -->
	    <div class="form-group">
	        <label for="projectImgUrl" class="col-md-4 control-label">Image Url</label>

	        <div class="col-md-6">
	            <input id="projectImgUrl" type="text" class="form-control" name="image_url" value="<?=$editProject['image_url']?>" required="" autofocus=""  onchange="readURL(this)">
	        </div>
	    </div>

	    <!-- Content Input -->
	    <div class="form-group">
	        <label for="projectContent" class="col-md-4 control-label">Content</label>

	        <div class="col-md-6">
	            <input id="projectContent" type="text" class="form-control" name="content" value="<?=$editProject['content']?>" required="" autofocus="">
	        </div>
	    </div>

	    <!-- Link Input -->
	    <div class="form-group">
	        <label for="projectLink" class="col-md-4 control-label">Link</label>

	        <div class="col-md-6">
	            <input id="projectLink" type="text" class="form-control" name="link" value="<?=$editProject['link']?>" required="" autofocus="">
	        </div>
	    </div>

	     <!-- Submit Button -->
	    <div class="form-group">
	        <div class="col-md-8 col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                Update
	            </button>
	        </div>
	    </div>

	</form>
