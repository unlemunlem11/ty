<?include("head.php");?>
	<title>Management - Lenovo Plus</title>
	<style type="text/css">
		table tr th {font-size:14px;}
		.control-label {width: 136px !important; padding-right: 10px;}
		.tab-content, .nav-tabs {width: 98%; margin-left: 1%}
		.modal-body .loading {float:left; margin-left:240px;}
	</style>
</head>
<body>

<?include("header.php");?>


<script type="text/javascript">
var user_name = "";
var user_id;
var ticket_id;
	$(document).ready(function(){
		//$('#sellerTab a:first').tab('show');

		dt_tickets = $('#tickets').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 30,
            "aaSorting": [[ 0, "desc" ]],
            "sAjaxSource": "<?=base_url()?>admin/support_manage/get_tickets/",
        } );

        $("#tickets tbody tr td").live('click', function(){
        	$("#messages").modal();
        	$("#messages .loading").show();
        	var item_id = $(this).parents("tr").find("td:first-child").text();
        	user_name = $(this).parents("tr").find("td:nth-child(3)").text();
        	$(".message_subject").text($(this).parents("tr").find("td:nth-child(2)").text());
        	$.post("<?=base_url()?>admin/support_manage/get_messages/" + item_id, function(j){
				var str = "";
				var j = $.parseJSON(j);
				user_id = j[0]['user_id'];
				ticket_id = j[0]['id'];
				for(var i in j){
					var template = $("#mesajTemplate").html();
					if(j[i]['sender'] == "user"){
						name = user_name;
					}else{
						name = "Müşteri Temsilcisi";
					}
					str += template.format(name, j[i]['message'], j[i]['created_at']);
				}
				var template2 = $("#cevaplaTemplate").html();
				str += template2.format("Müşteri Temsilcisi");
				$("#messages .loading").hide();
				$(".mesaj_alani").show().html(str);
        	});
		
        });

        $("#cevap_gonder").click(function(){
			$(".mesaj_alani").hide();
			$("#messages .loading").fadeIn();
			$.post("<?=base_url()?>admin/support_manage/reply", {
				ticket_id : ticket_id,
				message : $("textarea[name=cevap]").val()
			}, function(d){
				dt_tickets.fnReloadAjax();
				alert("Mesajınız gönderildi");
				$("#messages").modal("hide");
			});

		});


	    $('#supportTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr("href") == "#sss" && typeof dt_sss == "undefined"){
			  	dt_sss = $('#sss_table').dataTable( {
	            "bProcessing": true,
	            "bServerSide": true,
	            "bRetrieve": true,
	            "iDisplayLength" : 30,
	            "aaSorting": [[ 0, "desc" ]],
	            "sAjaxSource": "<?=base_url()?>admin/support_manage/get_sss/",
	        } );

		  }
		});


		$("#sss_table tbody tr td").live('click', function(){
			$("#faq_edit .loading").show();
			var item_id = $(this).parents("tr").find("td:first-child").text();
			$.post("<?=base_url()?>admin/support_manage/get_faq", {
				id : item_id
			}, function(d){
				$("#faq_edit .loading").hide();
				var j = $.parseJSON(d);
				$("#faq_edit [name='id']").val(j['id']);
				$("#faq_edit [name='title']").val(j['title']);
				$("#faq_edit [name='text']").val(j['text']);
				$("#faq_edit [name='text_register']").val(j['text_register']);
				$("#faq_edit").modal();
			});

		});

		$("#faq_kaydet").click(function(){
			$("#faq_form").submit();
		});

		$("#yeni_soru").click(function(){
			$("#faq_new").modal();
		});

		$("#faq_ekle").click(function(){
			$("#faq_ekle_form").submit();
		});

		$("#faq_sil").click(function(){
			if(confirm("Soru silinecek! Emin misiniz?")){
				$.post("<?=base_url()?>admin/support_manage/faq_delete", {
					id : $("#faq_edit [name=id]").val()
				}, function(d){
					save_faq();
				});
			}
		});

	});

	function save_faq(d){
		$("#faq_edit").modal("hide");
		$("#faq_new").modal("hide");
		$(".postForm input, .postForm textarea").val("");
		dt_sss.fnReloadAjax();
	}


</script>

<script type="text/template" id="mesajTemplate">
	<blockquote>
		<p><strong>{0}:</strong> {1}</p>
		<p><small>{2}</small></p>
	</blockquote>
</script>

<script type="text/template" id="cevaplaTemplate">
	<blockquote>
		<p><strong>{0}</strong> <br><textarea name="cevap" style="width:100%;"></textarea></p>
	</blockquote>
</script>

	<div class="modal fade" id="messages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title message_subject"></h4>
	        </div>
	        <div class="modal-body">
	        	<img src="<?=base_url()?>img/loading.gif" class="loading">
	        	<div class="mesaj_alani">

	        	</div>
	        		
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
	          <button type="button" class="btn btn-info" id="cevap_gonder">Gönder</button>
	        </div>
	      </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<ul class="nav nav-tabs" id="supportTab">
	  <li class="active"><a href="#destek_mesajlari">Tickets</a></li>
	  <li><a href="#sss">Sık Sorulan Sorular</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="destek_mesajlari">
			<table class="table table-bordered datatable" id="tickets">
				<thead>
					<tr>
						<th style="width:20px;">ID</th>
						<th>Konu</th>
						<th style="width:180px;">Kullanıcı</th>
						<th style="width:140px;">Oluşturulma Tarihi</th>
						<th style="width:140px;">Durum</th>
					</tr>
				</thead>
			</table>
		</div>

		<div class="tab-pane" id="sss">
			<button class="btn btn-info" style="margin-left:1%;margin-bottom:20px;" id="yeni_soru">Yeni Soru</button>
			<table class="table table-bordered datatable" id="sss_table">
				<thead>
					<tr>
						<th style="width:20px;">ID</th>
						<th>Soru</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<div class="modal fade" id="faq_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title">Soru Düzenle</h4>
	        </div>
	        <div class="modal-body">
	        	<img src="<?=base_url()?>img/loading.gif" class="loading">
	        	<div class="soru">
	        		<form class="form-horizontal postForm" id="faq_form" data-url="<?=base_url()?>admin/support_manage/save_faq/" data-callback="save_faq">
						<input type="hidden" name="id">
					  	<div class="control-group">
						    <label class="control-label">Soru</label>
						    <div class="controls">
						      <input type="text" name="title" style="width:300px;">
						    </div>
					  	</div>

					  	<div class="control-group">
						    <label class="control-label">Cevap</label>
						    <div class="controls">
						      <textarea name="text" style="width:300px; height:300px;"></textarea>
						    </div>
					  	</div>

					  	<div class="control-group">
						    <label class="control-label">Cevap (Register bayiler için)</label>
						    <div class="controls">
						      <textarea name="text_register" style="width:300px; height:300px;"></textarea>
						    </div>
					  	</div>
					</form>
	        	</div>
	        		
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
	          <button type="button" class="btn btn-danger" id="faq_sil">Sil</button>
	          <button type="button" class="btn btn-info" id="faq_kaydet">Kaydet</button>
	        </div>
	      </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="faq_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title">Yeni Soru</h4>
	        </div>
	        <div class="modal-body">
	        	<div class="soru left">
	        		<form class="form-horizontal postForm" id="faq_ekle_form" data-url="<?=base_url()?>admin/support_manage/new_faq/" data-callback="save_faq">
					  	<div class="control-group">
						    <label class="control-label">Soru</label>
						    <div class="controls">
						      <input type="text" name="title" style="width:300px;">
						    </div>
					  	</div>

					  	<div class="control-group">
						    <label class="control-label">Cevap</label>
						    <div class="controls">
						      <textarea name="text" style="width:300px; height:300px;"></textarea>
						    </div>
					  	</div>
					</form>
	        	</div>
	        		
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
	          <button type="button" class="btn btn-info" id="faq_ekle">Ekle</button>
	        </div>
	      </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->




<?include("footer.php");?>