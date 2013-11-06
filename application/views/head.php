<!DOCTYPE html>
<html lang="tr">
<head>

	<!-- META -->

	<meta charset="utf-8">

	<!-- CSS -->


	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/tipTip.css">
	<link rel="stylesheet" href="<?php  echo base_url();?>js/perfect-scrollbar.css">

	<!-- JS -->

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery_v.2.0.3.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.serializeObject.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.tipTip.minified.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/perfect-scrollbar.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.transit.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/imagesloaded.js"></script>
	
	

	
	<?php /*
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugins/videos/video.js.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/font/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/bootstrap.css">
	<script type="text/javascript" src="<?php echo base_url()?>js/helper.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plugins/videos/jquery.video.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

	*/
	?>
	<script type="text/javascript">
		var base_url = "<?php echo base_url();?>";
		$(document).ready(function(){
			
		});
	</script>

	<style type="text/css">
		<?php if($this->agent->platform() != "Mac OS X"){?>
			 .input input::-moz-placeholder, .input input::-webkit-input-placeholder, .input input, #tiptip_holder, .juri-detay .body h2 span, .juri-detay .title {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
				font-weight: 100 !important;
			}

			.page h2, .page .body p, .btn-lg, .textarea textarea {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
				font-weight: 100 !important;
			}
		<?php } ?>
	</style>

