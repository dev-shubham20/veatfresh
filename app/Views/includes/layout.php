<!DOCTYPE html>
<html lang="en">

<!-- Header Start -->
<?php echo view('includes/header'); ?>
<!-- Header Start -->

<body>

	<?php echo view('includes/common'); ?>

	<?php echo view('includes/navbar'); ?>

	<main class="main">
		<?php echo $content; ?>			
	</main>		
	<?php echo view('includes/footer'); ?>
	<!-- Scripts Start -->
	<?php echo view('includes/scripts'); ?>
	<!-- Scripts End -->		
</body>
</html>