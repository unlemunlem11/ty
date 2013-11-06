<?php include("head.php");?>
	<title>Bridgestone Tasarım Yarışması</title>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
		    // init the FB JS SDK
		    FB.init({
		      appId      : '1381153932127900',                        // App ID from the app dashboard
		      //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel file for x-domain comms
		      status     : true,                                 // Check Facebook Login status
		      xfbml      : true                                  // Look for social plugins on the page
		    });

		    // Additional initialization code such as adding Event Listeners goes here
		};


		if (document.getElementById('facebook-jssdk')) {return;}
		var firstScriptElement = document.getElementsByTagName('script')[0];
		var facebookJS = document.createElement('script'); 
		facebookJS.id = 'facebook-jssdk';
		facebookJS.src = '//connect.facebook.net/en_US/all.js';
		firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);

		var userdata = {};

		function toDateTime(secs){
		    var t = new Date();
		    t.setSeconds(secs);
		    return t;
		}
		$(document).ready(function(){
			$("#katil").click(function(){
				FB.login(function(response) {
					if (response.authResponse) {
						userdata['access_token_expire_date'] = toDateTime(FB.getAuthResponse()['expiresIn']);
						userdata['access_token'] = FB.getAuthResponse()['accessToken'];
						top.location.href="https://apps.facebook.com/casecontest/";
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