<?include("head.php");?>
	<title>Management - Lenovo Plus</title>
	<script type="text/javascript">

	</script>
</head>
<body>

<?include("header.php");?>


<script type="text/javascript">
	$(document).ready(function(){
		dt_sellers = $('#sellers').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 30,
            "aaSorting": [[ 0, "desc" ]],
            "sAjaxSource": "<?=base_url()?>admin/seller_manage/get_sellers/",
        } );

        $("#sellers tbody tr td").live('click', function(){
        	var item_id = $(this).parents("tr").find("td:first-child").text();
			location.href = "<?=base_url()?>admin/seller_manage/detail/" + item_id;
        });


	});
</script>

	<table class="table table-bordered datatable" id="sellers">
		<thead>
			<tr>
				<th style="width:20px;">ID</th>
				<th>Ünvan</th>
				<th style="width:120px;">Vergi No</th>
				<th style="width:80px;">Telefon</th>
				<th>E-posta</th>
				<th style="width:120px;">LPN No</th>
				<th style="width:120px;">Segment</th>
				<th style="width:140px;">Oluşturulma Tarihi</th>
			</tr>
		</thead>
	</table>


<?include("footer.php");?>