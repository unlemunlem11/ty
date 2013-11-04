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

	<ul class="nav nav-tabs" id="userTab">
	  <li class="active"><a href="#genel">Genel Bilgiler</a></li>
	  <li><a href="#puanlar">Puanlar</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="genel">
			<form class="form-horizontal" method="post" action="<?=base_url()?>admin/user_manage/save_info/">
				<div class="control-group">
				    <label class="control-label">ID</label>
				    <div class="controls">
				      <input type="text" disabled value="<?=$detail['id']?>">
				      <input type="hidden" name="id" value="<?=$detail['id']?>">
				    </div>
			  	</div>
			  	<div class="control-group">
				    <label class="control-label">Ünvan</label>
				    <div class="controls">
				      <input type="text" name="title" value="<?=$detail['title']?>">
				    </div>
			  	</div>
			  	<div class="control-group">
				    <label class="control-label">İsim</label>
				    <div class="controls">
				      <input type="text" name="first_name" value="<?=$detail['first_name']?>">
				    </div>
			  	</div>

			  	<div class="control-group">
				    <label class="control-label">Soyisim</label>
				    <div class="controls">
				      <input type="text" name="last_name" value="<?=$detail['last_name']?>">
				    </div>
			  	</div>

				<div class="control-group">
				    <label class="control-label">Telefon</label>
				    <div class="controls">
				      <input type="text" name="phone" value="<?=$detail['phone']?>">
				    </div>
			  	</div>

			  	<div class="control-group">
				    <label class="control-label">E-posta</label>
				    <div class="controls">
				      <input type="text" name="email" value="<?=$detail['email']?>">
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
		</div>

		<div class="tab-pane" id="puanlar">
			puanlar
		</div>
	</div>



<?include("footer.php");?>