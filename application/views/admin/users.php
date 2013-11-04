<?include("head.php");?>
	<title>Management - Lenovo Plus</title>
	<script type="text/javascript">

	</script>
</head>
<body>

<?include("header.php");?>


<script type="text/javascript">
	$(document).ready(function(){
		dt_users = $('#users').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 30,
            "aaSorting": [[ 0, "desc" ]],
            "sAjaxSource": "<?=base_url()?>admin/user_manage/get_users/",
        } );

        $("#users tbody tr td").live('click', function(){
        	var item_id = $(this).parents("tr").find("td:first-child").text();
			location.href = "<?=base_url()?>admin/user_manage/detail/" + item_id;
        });


	});
</script>

	<table class="table table-bordered datatable" id="users">
		<thead>
			<tr>
				<th style="width:20px;">ID</th>
				<th>Firma</th>
				<th>Ünvan</th>
				<th style="width:120px;">İsim</th>
				<th style="width:120px;">Soyisim</th>
				<th style="width:120px;">Phone</th>
				<th style="width:200px;">Email</th>
				<th style="width:140px;">Oluşturulma Tarihi</th>
			</tr>
		</thead>
	</table>


<?include("footer.php");?>