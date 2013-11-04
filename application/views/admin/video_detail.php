<?include("head.php");?>
	<title>Management - Lenovo Plus</title>
	<style type="text/css">
		table tr th {font-size:14px;}
		.control-label {width: 136px !important; padding-right: 10px;}
		.tab-content, .nav-tabs {width: 98%; margin-left: 1%}
	</style>
</head>
<body>

<?include("header.php");?>


<script type="text/javascript">
	$(document).ready(function(){
		//$('#sellerTab a:first').tab('show');
	    $('#userTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr("href") == "#kullanicilar" && typeof dt_kullanicilar == "undefined"){
		  	dt_kullanicilar = $('#users').dataTable( {
	            "bProcessing": true,
	            "bServerSide": true,
	            "bRetrieve": true,
	            "iDisplayLength" : 30,
	            "aaSorting": [[ 0, "desc" ]],
	            "sAjaxSource": "<?=base_url()?>admin/user_manage/get_users/<?=$detail['id']?>",
	        } );

	        $("#users tbody tr td").live('click', function(){
	        	var item_id = $(this).parents("tr").find("td:first-child").text();
				location.href = "<?=base_url()?>admin/user_manage/detail/" + item_id;
	        });
		  }
		});		

	});
</script>

	<?php if (@$update): ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".alert").fadeIn();
			});
		</script>
		<div class="alert alert-success hide">
			İçerik güncellendi.
		</div>
	<?php endif ?>

	<form class="form-horizontal" method="post" action="<?=base_url()?>admin/video_manage/save/">
		<div class="control-group">
		    <label class="control-label">ID</label>
		    <div class="controls">
		      <input type="text" disabled value="<?=$detail['id']?>">
		      <input type="hidden" name="id" value="<?=$detail['id']?>">
		    </div>
	  	</div>
	  	<div class="control-group">
		    <label class="control-label">Başlık</label>
		    <div class="controls">
		      <input type="text" name="title" value="<?=$detail['title']?>">
		    </div>
	  	</div>
	  	<div class="control-group">
		    <label class="control-label">Source</label>
		    <div class="controls">
		      <input type="text" name="source" value="<?=$detail['source']?>">
		    </div>
	  	</div>

	  	<div class="control-group">
		    <label class="control-label">Açıklama</label>
		    <div class="controls">
		      <input type="text" name="description" value="<?=$detail['description']?>">
		    </div>
	  	</div>

		<div class="control-group">
		    <label class="control-label">Thumbnail</label>
		    <div class="controls">
		      <input type="text" name="thumbnail" value="<?=$detail['thumbnail']?>">
		    </div>
	  	</div>

	  	<div class="control-group">
		    <label class="control-label">Oluşturulma Tarihi</label>
		    <div class="controls">
		      <input type="text" disabled value="<?=$detail['created_at']?>">
		    </div>
	  	</div>

		<div class="control-group">
		    <div class="controls">
		      <button type="submit" class="btn btn-success" style="float:left; margin-left:250px;">Kaydet</button>
		    </div>
		</div>

	</form>



<?include("footer.php");?>