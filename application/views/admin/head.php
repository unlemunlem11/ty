<!DOCTYPE html>
<html lang="tr">
<head>

	<!-- META -->

	<meta charset="utf-8">


	<!-- CSS -->
	<script type="text/javascript" src="<?=base_url()?>admin/jquery-1.7.2.min.js"></script>

	<link href="<?=base_url()?>admin/datatables.css" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url()?>admin/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?=base_url()?>admin/jquery.dataTables.fnReloadAjax.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.tipTip.minified.js"></script>
	<script type="text/javascript">
		$.fn.reset_form = function(){
			$(this[0]).find("input, textarea").val("");
			$(this[0]).find("select").each(function(index, elem){
				$(elem).val($(this).attr("defVal"));
			});
		}
	</script>


	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>admin/bootstrap.css">
	<!-- JS -->

	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.serializeObject.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/helper.js"></script>
	<script type="text/javascript" src="<?=base_url()?>admin/bootstrap.js"></script>

	<script type="text/javascript">
		var base_url = "<?=base_url()?>";
	</script>


	<style type="text/css">
		.paginate_enabled_next {background: url("<?=base_url()?>images/forward_enabled.jpg");}
		.paginate_disabled_next {background: url("<?=base_url()?>images/forward_disabled.jpg");}
		.paginate_disabled_previous {background: url("<?=base_url()?>images/back_disabled.jpg");}
		.paginate_enabled_previous {background: url("<?=base_url()?>images/back_enabled.jpg");}
		.paging_two_button {cursor: pointer}
		.datatable {width:98%; margin-left:1%; max-width: 1300px}
		table tr th {font-size:14px;}
		table td {cursor: pointer;}

	</style>