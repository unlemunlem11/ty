<?include("head.php");?>
	<title>Management - Lenovo Plus</title>
	<script type="text/javascript">

	</script>
</head>
<body>

<?include("header.php");?>


<script type="text/javascript">
	$(document).ready(function(){
		dt_videos = $('#videos').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 30,
            "aaSorting": [[ 0, "desc" ]],
            "sAjaxSource": "<?=base_url()?>admin/video_manage/get_list/",
        } );

        $("#videos tbody tr td").live('click', function(){
        	var item_id = $(this).parents("tr").find("td:first-child").text();
			location.href = "<?=base_url()?>admin/video_manage/detail/" + item_id;
        });


	});
</script>

	<table class="table table-bordered datatable" id="videos">
		<thead>
			<tr>
				<th style="width:20px;">ID</th>
				<th>Başlık</th>
				<th style="width:140px;">Oluşturulma Tarihi</th>
			</tr>
		</thead>
	</table>


<?include("footer.php");?>