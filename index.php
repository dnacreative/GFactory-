<?php
	include_once "config.php";

	// Create a new GFactory instance
	$GF = new GFactory(GAL_PATH);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> GFactory - A file-based gallery generator in PHP</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,500italic' rel='stylesheet' type='text/css'>
<link href="css/gfactory.css" rel="stylesheet">
<style>
  #copy-notice { 
  	margin: 10px auto; 
  	width: 268px; 
  }
</style>
</head>
<body>
<div id="header" class="navbar navbar-inverse navbar-fixed-top">	
	<div class="navbar-inner">
		<a class="brand" href="<?php echo dirname($_SERVER['PHP_SELF']); ?>">GFactory</a> 
	</div>
</div>

<div id="sidebar">
	<div id="sidebar-inner">
		<!-- Galleries -->
		<?php foreach($GF->galleries() as $Gallery) : ?>
			<div class="tab button"><?php echo fixFileName($Gallery->friendly_name); ?></div>

			<!-- Gallery's immediate files -->
			<div class="tab-content">
				<?php 
				  if (count($Gallery->files()) > 0) :
				    echo '<div class="files">';
				      foreach ($Gallery->files() as $gal_file) :
					    echo '<a href="'. $gal_file. '" data-name="'.fixFilePath($gal_file).'">'. fixFilePath($gal_file) .'</a>';
				      endforeach;
				    echo '</div>';
				  endif;
				?>

				<!-- Gallery's categories -->
				<?php 
				  if (count($Gallery->categories()) > 0):
					foreach($Gallery->categories() as $key => $category) : 
					  echo '<div class="sub-tab">'. fixFileName($key) .'<div class="arrow-down"></div> </div>';

					  echo '<div class="sub-tab-content">'; 
						echo '<div class="files-sub">';
						  foreach ($category as $category_file) {
							echo '<a href="'.$category_file.'" data-name="'.fixFilePath($category_file).'">'. fixFilePath($category_file) .'</a>';
						  }
						echo '</div>';
					  echo '</div>';
					endforeach; 					
				  endif; 						
				?>
			</div>
		<?php endforeach; ?>

		<!-- Super-path immediate files -->
		<?php if (count($GF->files()) > 0) : ?>
			<div class="files immediate-files">
				<?php foreach($GF->files() as $immediate_file) : ?>
					<a href="<?php echo $immediate_file; ?>" data-name="<?php echo fixFilePath($immediate_file); ?>"><?php echo fixFilePath($immediate_file); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>		
	</div>
</div>

<div id="browser">
	<div id="browser-inner">
		<div id="viewport">
			<div id="main-img-wrap">
				<h4 id="img-name">By ISTOCODE</h4>
				<img id="main-img" src="<?php echo $GF->files('by-ISTOCODE.png'); ?>" class="img-polaroid">
				
				<p class="muted" id="copy-notice">
				  <small>Photographs used in this application may be copyrighted. You are NOT allowed to copy these images without permission.</small>
				</p>				
			</div>
		</div>
	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script src="js/gfactory.js"></script>
</body>
</html>