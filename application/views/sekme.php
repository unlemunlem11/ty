<?php include("head.php");?>
	<title>Bridgestone Tasarım Yarışması</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#katil").click(function(){
				FB.login(function(response) {
					if (response.authResponse) {
						userdata['access_token_expire_date'] = toDateTime(FB.getAuthResponse()['expiresIn']);
						userdata['access_token'] = FB.getAuthResponse()['accessToken'];
						location.href="https://apps.facebook.com/casecontest/";
					}
				}, {scope: 'user_likes,user_about_me,user_interests,user_education_history,user_work_history,email,user_birthday,user_hometown,user_location,user_relationships,user_relationship_details,user_website'});
			});
		});
	</script>
</head>
<body>

<div style="width:810px; height: 700px; float:left; background: url('<?php echo base_url() ?>/img/sekme-bg.jpg');">

	<a href="#" id="katil" class="btn-lg" style="text-decoration:none; float: left;margin-top: 336px;margin-left: 275px;">Katıl</a>

</div>

<?php include("footer.php");?>