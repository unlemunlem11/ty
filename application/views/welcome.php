<?php include("head.php");?>
	<title></title>
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



		function fileUpload(form, action_url, div_id) {
		    // Create the iframe...
		    var iframe = document.createElement("iframe");
		    iframe.setAttribute("id", "upload_iframe");
		    iframe.setAttribute("name", "upload_iframe");
		    iframe.setAttribute("width", "0");
		    iframe.setAttribute("height", "0");
		    iframe.setAttribute("border", "0");
		    iframe.setAttribute("style", "width: 0; height: 0; border: none;");
		 
		    // Add to document...
		    form.parentNode.appendChild(iframe);
		    window.frames['upload_iframe'].name = "upload_iframe";
		 
		    iframeId = document.getElementById("upload_iframe");
		 
		    // Add event...
		    var eventHandler = function () {
		 
		            if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
		            else iframeId.removeEventListener("load", eventHandler, false);
		 
		            // Message from server...
		            if (iframeId.contentDocument) {
		                content = iframeId.contentDocument.body.innerHTML;
		            } else if (iframeId.contentWindow) {
		                content = iframeId.contentWindow.document.body.innerHTML;
		            } else if (iframeId.document) {
		                content = iframeId.document.body.innerHTML;
		            }
		 
		 			if(content == 1){
		 				openPage(".yukle");
		 				$("#upload-content").fadeOut(function(){
		 					$("#upload-success").fadeIn();
		 				});
		 			}
		            //document.getElementById(div_id).innerHTML = content;
		 
		            // Del the iframe...
		            setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
		        }
		 
		    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
		    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
		 
		    // Set properties of form...
		    form.setAttribute("target", "upload_iframe");
		    form.setAttribute("action", action_url);
		    form.setAttribute("method", "post");
		    form.setAttribute("enctype", "multipart/form-data");
		    form.setAttribute("encoding", "multipart/form-data");
		 
		    // Submit the form...
		    form.submit();
		 
		 	$("#tasarimyukle_buton").fadeOut(function(){
		 		$("#upload-content .loading").fadeIn();
		 	});
		    //document.getElementById(div_id).innerHTML = "Uploading...";
		}

		function checkFileSize(inputid) {
		    var input, file;


		    if (!window.FileReader) {
		        popup_alert("Tarayıcınız desteklemiyor.");
		        return false;
		    }

		    input = document.getElementById(inputid);
		    if (!input) {
		        popup_alert("Um, couldn't find the fileinput element.");
		        return false;
		    }
		    else if (!input.files) {
		        popup_alert("Tarayıcınız desteklemiyor.");
		        return false;
		    }
		    else if (!input.files[0]) {
		        popup_alert("Dosya seçmediniz!");
		        return false;
		    }
		    else {
		        file = input.files[0];
		        if(file.size > 10485760){
		        	popup_alert("Yüklemeye çalıştığınız dosya boyutu max 1MB olmalıdır. Lütfen tekrar deneyiniz.");
		        	return false;
		        }
		        var ext = file.name.split(".")[file.name.split(".").length - 1];
		        if(ext == "png" || ext == "jpg" || ext == "png" || ext == "pdf" || ext == "ai" || ext == "psd" || ext == "tif"){
		        	//
		        }else{
		        	popup_alert("Destek verilen formatlar; jpg, png, pdf, ai, psd, tif");
		        	return false;
		        }

		        if(katilim_kosullari2 == false){
		        	alert("Katılım koşullarını kabul etmeniz gerekiyor");
		        	return false;
		        }
		    }

		    return true;
		}

		function popup_alert(d){
			alert(d)
		}

		
		if (document.getElementById('facebook-jssdk')) {return;}
		var firstScriptElement = document.getElementsByTagName('script')[0];
		var facebookJS = document.createElement('script'); 
		facebookJS.id = 'facebook-jssdk';
		facebookJS.src = '//connect.facebook.net/en_US/all.js';
		firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);


		var katilim_kosullari = false;
		var katilim_kosullari2 = false;
		var user_id;
		var user_name;
		var userdata = {};

		function toDateTime(secs){
		    var t = new Date();
		    t.setSeconds(secs);
		    return t;
		}

		function openPage(page){
			$(".page").hide()
			$(page).fadeIn();
		}


		$(document).ready(function(){
			openPage(".page-anasayfa");
			$("[name=phone]").mask("0 (599) 999 99 99", {placeholder: "_"});

			$("#menu").hover(function(){
				$("#menu #down").fadeIn();
				$(".menu-ok").animate({
					"margin-top" : "12px"
				});
			}, function(){
				$("#menu #down").fadeOut();
				$(".menu-ok").animate({
					"margin-top" : "8px"
				});
			});

			$(".contentHolder").perfectScrollbar();

			$(".openPage").click(function(){
				var p = $(this).data("page");
				if(p == ".kayit" || p == ".iletisim"){
					FB.login(function(response) {
						if (response.authResponse) {
							userdata['access_token_expire_date'] = toDateTime(FB.getAuthResponse()['expiresIn']);
							userdata['access_token'] = FB.getAuthResponse()['accessToken'];
						 FB.api('/me', function(uinfo) {
							user_id = uinfo.id;
				            user_name = uinfo.first_name;
				            $("[name=first_name]").val(uinfo.first_name);
				            $('[name=last_name]').val(uinfo.last_name);
				            $("[name=email]").val(uinfo.email);

				            $.post("<?php echo base_url(); ?>index.php/welcome/user/", {
				            	userdata : userdata
				            });
						 });
						}
					}, {scope: 'user_likes,user_about_me,user_interests,user_education_history,user_work_history,email,user_birthday,user_hometown,user_location,user_relationships,user_relationship_details,user_website'});
				}
				openPage($(this).data("page"));
			});


			$("#menu #down .body a").click(function(){
				openPage("." + $(this).attr("href").split("#")[1]);

			});

			$("#katilim-kosullari-text").click(function(){
				if(katilim_kosullari){
					katilim_kosullari = false;
				}else{
					katilim_kosullari = true;
				}
				$(this).find("img").first().toggle().next("img").toggle();
			});

			$("#katilim-kosullari2-text").click(function(){
				if(katilim_kosullari2){
					katilim_kosullari2 = false;
				}else{
					katilim_kosullari2 = true;
				}
				$(this).find("img").first().toggle().next("img").toggle();
			});

			$("#kayit-formu").click(function(){
				//$("#katil").trigger("click");
			});

			$("#katil").click(function(){
				var hata = false;
				$(".kayit input").each(function(ind, elem){
					if($(elem).val() < $(elem).data("minlength") || ($(elem).attr("name") == "email" && $(elem).val().search("@") == "-1")){
						$(elem).tipTip({
							activation : "focus",
							keepAlive: true,
							defaultPosition: "top"
						}).focus().parents(".input").addClass("input-alert");
						hata = true;
						return false;
					}else{
						$("div[id^=tiptip_]").remove();
						$(elem).parents(".input").removeClass("input-alert");
					}
				});

				if(!katilim_kosullari && hata == false){
					alert("Katılım koşullarını okumanız ve kabul etmeniz gerekiyor.");
					hata = true;
				}

				if(hata == true){
					return false;
				}else{
					var data = $("#kayit-formu").serializeObject();
					$.post("<?php echo base_url(); ?>welcome/create/", data, function(d){
						openPage(".yukle");
					});	
				}
			});


			$("#form-gonder").click(function(){
				var hata = false;
				$(".iletisim input, .iletisim textarea").each(function(ind, elem){
					if($(elem).is("textarea") != ""){
						var alert_class = "textarea-alert";
					}else{
						var alert_class = "input-alert";
					}
					if($(elem).val() < $(elem).data("minlength") || ($(elem).attr("name") == "email" && $(elem).val().search("@") == "-1")){
						$(elem).tipTip({
							activation : "focus",
							keepAlive: true,
							defaultPosition: "top"
						}).focus().parents(".input").addClass(alert_class);
						hata = true;
						return false;
					}else{
						$("div[id^=tiptip_]").remove();
						$(elem).parents(".input").removeClass(alert_class);
					}
				});

				if(hata == true){
					return false;
				}else{
					var data = $("#iletisim-formu").serializeObject();
					$.post("<?php echo base_url(); ?>welcome/contact/", data, function(d){
						$("#iletisim-formu-wrapper").fadeOut(function(){
							$("#contact-success").fadeIn();
						});
					});	
				}
			});

			$("#tasariminput").change(function(){
				$("#tasarimfilename").val($(".hiddeninput").val());
			});

			$("#tasarimyukle_buton").click(function(){
				if(checkFileSize("tasariminput")){
					fileUpload(document.getElementById("fileform"), "<?php base_url() ?>welcome/upload/", "upload_action");
				}
			});

			$(".case3d img:first-child").fadeIn();
			$(".case3d img").load(function(){
				loaded++;
				if(loaded == 81){
					$(".icons").fadeIn(1600);	
					$(".case3d").fadeIn();
					$(".sol").fadeIn();
					$(".case3dloading").hide();

				}

				console.log("loaded: " + loaded);
				
			});
			

			
			setInterval(function(){
				nextFrame(frame);
				if(frame == 80){
					frame = 0;
				}else{
					frame++;
				}
			}, 50);
			

			setTimeout(function(){
				animatePusula();
				setInterval(function(){
					animatePusula();
				}, 4050);
			}, 400);
			
			setTimeout(function(){
				animateTelefon();
				setInterval(function(){
					animateTelefon();
				}, 4050);
			}, 2000);


			setTimeout(function(){
				animateYol();
				setInterval(function(){
					animateYol();
				}, 4050);
			}, 200);

			setTimeout(function(){
				animateLike();
				setInterval(function(){
					animateLike();
				}, 4050);
			}, 1100);

			setTimeout(function(){
				animatePark();
				setInterval(function(){
					animatePark();
				}, 4050);
			}, 500);

			setTimeout(function(){
				animateTrafik();
				setInterval(function(){
					animateTrafik();
				}, 4050);
			}, 1900);

			setTimeout(function(){
				animateGunes();
				setInterval(function(){
					animateGunes();
				}, 4050);
			}, 420);

			setTimeout(function(){
				animateAraba();
				setInterval(function(){
					animateAraba();
				}, 4050);
			}, 120);

			setTimeout(function(){
				animateTabela();
				setInterval(function(){
					animateTabela();
				}, 4050);
			}, 80);

			

		});

var loaded = 0;

function animateTelefon(){
	
		$(".icon-telefon").css("z-index", "98");
		setTimeout(function(){
			$(".icon-telefon").css("z-index", "100");
		}, 2000);
	
	$(".icon-telefon").
		transition({ x: '-=340px', y: '-=30px', scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=200px', y: '-=30px', scale: 1 , perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=340px', y: '+=30px', scale: 1.2, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=200px', y: '+=30px', scale: 1 , perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animatePusula(){

		$(".icon-pusula").css("z-index", "98");
		setTimeout(function(){
			$(".icon-pusula").css("z-index", "100");
		}, 2000);
	
	$(".icon-pusula").
		transition({ x: '-=240px', y: '+=30px', scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', y: '+=20px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=240px', y: '-=30px', scale: 1.3, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '-=20px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateYol(){

		$(".icon-yol").css("z-index", "98");
		setTimeout(function(){
			$(".icon-yol").css("z-index", "100");
		}, 2000);
	
	$(".icon-yol").
		transition({ x: '-=340px', y: '-=30px',  scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px',y: '-=20px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=340px', y: '+=30px', scale: 1.2, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '+=30px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateLike(){

		$(".icon-like").css("z-index", "100");
		setTimeout(function(){
			$(".icon-like").css("z-index", "98");
		}, 2000);
	
	$(".icon-like").		
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateTabela(){

	$(".icon-tabela").css("z-index", "100");
		setTimeout(function(){
			$(".icon-tabela").css("z-index", "98");
		}, 2000);
	
	$(".icon-tabela").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animatePark(){

		$(".icon-park").css("z-index", "100");
		setTimeout(function(){
			$(".icon-park").css("z-index", "98");
		}, 2000);
	
	$(".icon-park").
		transition({ x: '+=340px',y: '+=40px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '+=30px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=100px',y: '-=40px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=340px', y: '-=30px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateTrafik(){

		$(".icon-trafik").css("z-index", "100");
		setTimeout(function(){
			$(".icon-trafik").css("z-index", "98");
		}, 2000);
	
	$(".icon-trafik").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateGunes(){

		
		$(".icon-gunes").css("z-index", "100");
		setTimeout(function(){
			$(".icon-gunes").css("z-index", "98");	
		}, 2000);
	
	$(".icon-gunes").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
}

function animateAraba(){
	$(".icon-araba").transition({
		  perspective : '+=100px',
		  rotateY: '+=180deg'
		}, 2000, 'linear').transition({
		  perspective : '+=100px',
		  rotateY: '-=180deg'
		}, 2050, 'linear');
	/*
		$(".icon-araba").css("z-index", "98");
		setTimeout(function(){
			$(".icon-araba").css("z-index", "100");
		}, 2000);
	
	$(".icon-araba").
		transition({ x: '-=240px', perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=240px', perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)');
	*/
}

function nextFrame(frame_id){
    $(".caseframe" + frame_id).hide();
	if(frame_id == 80){
		var next_frame = 0;
	}else{
		var next_frame = frame_id + 1;
	}
    $(".caseframe" + next_frame).show();
}
var frame = 0;
	</script>


</head>
<body>

<div class="main-site">
	<div class="content">
		<?php include("header.php");?>
		<div class="wrapper">
			<div class="page page-anasayfa">
				<div class="sol" style="display:none">
					<div class="openPage hemenbasvur" data-page=".basvuru"></div>
				</div>
				<div class="sag" style="float:left; width:400px;height:500px;margin-left:100px">
					<div style="width:100%;float:left;" class="case3dloading"><img src="<?php echo base_url();?>img/loader.gif" class="loading" style="float:left;margin-left:320px;margin-top:130px;width:40px;"></div>
					<div class="icons" style="position:absolute; display:none;">
						<img src="<?php echo base_url(); ?>img/icon/araba.png" class="icon icon-araba">
						<img src="<?php echo base_url(); ?>img/icon/gunes.png" class="icon icon-gunes">
						<img src="<?php echo base_url(); ?>img/icon/like.png" class="icon icon-like">
						<img src="<?php echo base_url(); ?>img/icon/park.png" class="icon icon-park">
						<img src="<?php echo base_url(); ?>img/icon/pusula.png" class="icon icon-pusula">
						<img src="<?php echo base_url(); ?>img/icon/tabela.png" class="icon icon-tabela">
						<img src="<?php echo base_url(); ?>img/icon/trafik.png" class="icon icon-trafik">
						<img src="<?php echo base_url(); ?>img/icon/yol.png" class="icon icon-yol">
						<img src="<?php echo base_url(); ?>img/icon/telefon.png" class="icon icon-telefon">
					</div>
					<div class="case3d" style="display:none">
						<?php for($i = 0; $i <= 80; $i++){ ?>
							<img src="<?php echo base_url(); ?>img/case/Case.RGB_color.00<?php echo $i; ?>.png" class="caseframe caseframe<?php echo $i;?>">
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="page pop basvuru casebg">
				<h2>Başvuru</h2>
				<div class="body" style="width:520px; margin:30px;">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea </p>
					<br>
					<p>commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id </p>
					<span class="openPage btn-lg" data-page=".kayit" style="margin-left:100px;margin-top:40px;">+Başvuru Yap</span>
					<a href="#" class="case-indir"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop kayit casebg">
				<h2>Kayıt</h2>
				<div class="body" style="width:520px; margin:30px;">
					<div style="float:left; margin-left:30px;">
						<form id="kayit-formu">
							<div class="input">
								<input type="text" name="first_name" placeholder="Ad" title="İsminizi giriniz!" data-minlength="3">
							</div>
							<div class="input">
								<input type="text" name="last_name" placeholder="Soyad" title="Soyadınızı giriniz!" data-minlength="2">
							</div>
							<div class="input">
								<input type="text" name="email" placeholder="E-posta" title="Geçerli bir e-posta adresi yazınız!" data-minlength="4">
							</div>
							<div class="input">
								<input type="text" name="phone" placeholder="Telefon" title="Geçerli bir telefon numarası yazınız!" data-minlength="9">
							</div>
							<div class="input">
								<input type="text" name="university" placeholder="Üniversite" title="Üniversitenizi yazınız!" data-minlength="3">
							</div>
						</form>
						<p style="width: 100%;float: left;line-height: 35px;margin-left: 46px;margin-top: 20px;text-indent: 4px;" id="katilim-kosullari-text" title="Katılım koşullarını okumanız ve kabul etmeniz gerekiyor!">
							<img src="<?php echo base_url()?>img/checkbox.png" style="margin-top:6px; float:left;cursor:pointer">
							<img src="<?php echo base_url()?>img/checkbox-checked.png" style="display:none; margin-top:6px; float:left;cursor:pointer">
							Katılım koşullarını okudum ve kabul ediyorum.
						</p>
						<span class="btn-lg" id="katil" style="margin-left:100px;margin-top:40px;">+ Katıl</span>
					</div>
				</div>
			</div>

			<div class="page pop yukle casebg">
				<h2>Tasarımını Yükle</h2>
				<div class="body" style="width:520px; margin:30px;">
					<div id="upload-content">
						<div class="input fileinput" style="margin-top:91px; margin-left:20px;">
							<input type="text" placeholder="Dosya Adı" id="tasarimfilename">
							<form id="fileform">
								<input type="file" name="file" class="hiddeninput" id="tasariminput">
							</form>
						</div>
						<p style="width: 100%;color:#191919; font-size:13px;float: left;line-height: 35px;margin-left: 92px;margin-top: 20px;text-indent: 4px;" id="katilim-kosullari2-text" title="Katılım koşullarını okumanız ve kabul etmeniz gerekiyor!">
							<img src="<?php echo base_url()?>img/checkbox.png" style="margin-top:6px; float:left;cursor:pointer">
							<img src="<?php echo base_url()?>img/checkbox-checked.png" style="display:none; margin-top:6px; float:left;cursor:pointer">
							Katılım koşullarını okudum ve kabul ediyorum.
						</p>
						<span class="btn-lg" id="tasarimyukle_buton" style="margin-left:100px;margin-top:18px;">+Tasarımını Yükle</span>
						<div style="width:100%;float:left;"><img src="<?php echo base_url();?>img/loader.gif" class="loading" style="display:none;float:left;margin-left:180px;margin-top:30px;width:40px;"></div>
						<div style="width:500px;float:left;" class="uyarilar">
							<p style="font-weight:bold;">Uyarılar:</p>
							<br>
							<p>- Dosya boyutu max. 1MB olmalıdır.</p>
							<p>- Destek verilen formatlar; jpg, png, pdf, ai, psd, tif</p>
							<p>- Yaptığınız çalışmayı vektörel formatta hazırlanması gerekmektedir. </p>
						</div>
					</div>

					<div id="upload-success" style="display:none; text-align:center;margin-top:200px;">
						<p style="font-weight:bold; font-size:19px;">Tasarımınız başarıyla yüklendi.</p><br>
						<p style="font-size:18px;font-weight:bold;">Yarışmanın sonuçlarını sayfamızdan takip edebilirsiniz.<br>Teşekkür ederiz.</p>
					</div>
				</div>
			</div>

			<div class="page pop odullistesi">
				<h2>Ödül Listesi</h2>
				<div class="body" style="width:520px; margin:30px;">
					<img src="<?php echo base_url()?>img/oduller.png" style="float:left; margin-left:54px;">
				</div>
			</div>

			<div class="page pop yarismatemasi casebg">
				<h2>Yarışma Teması</h2>
				<div class="body" style="width:520px; margin:30px; line-height:20px;">
					<p style="font-size:18px;"><span style="font-weight:bold;">Konsept:</span>Akıllı Telefon Case Yarışması</p>
					<br>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea </p>
					<br>
					<p>commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id </p>
					<a href="#" class="case-indir"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop juri">
				<h2>Jüri</h2>
				<div class="body" style="margin:30px; line-height:20px;">
					<div style="width:630px; float:left; margin-left:145px;">
						<div class="juri-item openPage" data-page=".juri1" style="background: url('<?php echo base_url()?>img/juri/1.png') no-repeat">
							<div class="juri-hover">
								<h2>Sami Savatlı</h2>
							</div>
						</div>
						<div class="juri-item openPage" data-page=".juri3" style="background: url('<?php echo base_url()?>img/juri/3.png') no-repeat">
							<div class="juri-hover">
								<h2>Sezgin Akan</h2>
							</div>
						</div>
						<div class="juri-item openPage" data-page=".juri4" style="background: url('<?php echo base_url()?>img/juri/4.png') no-repeat">
							<div class="juri-hover">
								<h2>Elif Cığızoğlu</h2>
							</div>
						</div>
						<div class="juri-item openPage" data-page=".juri5" style="background: url('<?php echo base_url()?>img/juri/5.png') no-repeat">
							<div class="juri-hover">
								<h2>Umut Eker</h2>
							</div>
						</div>
						<div class="juri-item openPage" data-page=".juri6" style="background: url('<?php echo base_url()?>img/juri/6.png') no-repeat">
							<div class="juri-hover">
								<h2>Mehmet Erzincan</h2>
							</div>
						</div>
						<div class="juri-item openPage" data-page=".juri7" style="background: url('<?php echo base_url()?>img/juri/7.png') no-repeat">
							<div class="juri-hover">
								<h2>Egemen Atış</h2>
							</div>
						</div>
						
					</div>
				</div>
			</div>

			<div class="page pop juri1">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/1.png">
						<img src="<?php echo base_url()?>img/juri/1a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Sami <span>Savatlı / </span><span style="font-size:16px;">Endüstri Ürünleri Tasarımcısı</span></h2>
						<p style="margin-top:20px;">Orta Doğu Teknik Üniversitesi’nde Endüstriyel Tasarım okudu.</p>
						<br>
						<p>Ünlü mimar Mahmut Anlar ile birlikte çalıştı, birçok restaurant, gece kulübü projesinde yer aldı.</p>
						<br>
						<p>2009 yılında, Nişantaşı’nda kendi tasarım ofisini kurdu. Hala mekan, ürün tasarımı ve tasarım danışmanlığı alanlarında hizmet veriyor.</p>
						<br>
						<p>Tasarımlarının arasında Funfatale - Les Ottomans, Joke Circus, Salomanje, Cento Per Cento ve yenilenen Sortie var.</p>
						<br>
						<p>2012 yılında “Archive” adlı mobilya ve aydınlatma aksesuarlarının satıldığı galetisini Galata’da açtı.</p>
						<br>
						<p>2013 yılında “Elle Decoration” dergisi tarafından düzenlenen Uluslararası EDIDA Tasarım Yarışması’nda 26 ülkenin editöründen oluşan uluslararası jürinin oylaması sonucu ülkemiz adına Yılın genç tasarımcısı “Best Young Designer ” ödülünü aldı.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri3">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/3.png">
						<img src="<?php echo base_url()?>img/juri/3a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Sezgin <span>Akan / </span><span style="font-size:16px">Akademisyen</span></h2>
						<p>Ankara'da doğdu. Tabeetha School, Tel Aviv ve Kadıköy Anadolu Lisesindeki orta ve lise öğreniminden sonra ODTÜ Endüstriyel Tasarım Bölümü'nden mezun oldu.</p>

						<p>Aynı bölümde 4 yıl araştırma görevlisi ve Bilkent Üniversitesi Mimarlık Bölümünde yarı zamanlı Öğretim görevlisi olarak çalıştı.</p>

						<p>1989 yılında Mehmet Akan ile STÜDYO'yu kurdu. Bugüne kadar 100'ün üzerindeki ofis, banka, restoran ve mağaza iç mekan projesinde proje yöneticisi ve müellif'i olarak çalıştı. STÜDYO ofis mobilyaları koleksiyonunu ve MetalForm'un metal mobilya koleksiyonunu tasarladı.</p>

						<p>Kurucularından olduğu ETMK adına yarışma jüri üyeliği yapmaktadır.</p>

						<p>Sezgin Akan profesyonel programının yanında mücevher tasarımı da yapıyor. Tasarımları İstanbul, Ankara, Londra ve Amsterdam'da solo, karma sergilerde ve galerilerde sergileniyor.</p>

						<p>2004 yılından bu yana ODTÜ Endüstriyel Tasarım Bölümü'nde Jewellery Beyond Tradition' derslerini vermekte. Aynı bölümde 2009 yılından beri Mezuniyet Projeleri' dersine giriyor.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri4">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/4.png">
						<img src="<?php echo base_url()?>img/juri/4a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Elif <span>Cığızoğlu / </span><span style="font-size:16px">Moda Tasarımcısı</span></h2>
						<p>Marmara Güzel Sanatlar Fakültesinde tekstil tasarımı eğitiminin hemen ardından, sayılı tasarım okullarından biri olan ve Amerika’da bulunan FIT’de eğitimini tamamladı.</p>

						<p>Donna Karan’a stajyer olarak girdi, kısa zaman zarfı içerisinde erkek departmanında tasarımcı olarak çalışmaya başladı.</p>

						<p>2 yıl sonra Türkiye’ye dönüp HakanYıldırım’la çalıştı, sonrasında kendi adını taşıyan markasını yarattı.</p>

					</div>
				</div>
			</div>

			<div class="page pop juri5">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/5.png">
						<img src="<?php echo base_url()?>img/juri/5a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Umut <span>Eker / </span><span style="font-size:16px">Stylist</span></h2>
						<p>Umut Eker 1983 yılında Bakırköy'de dünyaya geldi.</p>

						<p>Profesyonel kariyerine Diesel’de çalışarak başladı ve kreatif direktörlüğe kadar yükseldi. 2002 yılında Diesel’den ayrılıp birkaç arkadaşıyla bir street fashion marka kurdu. </p>

						<p>Aynı zamanda stylist kimliği ile aralarında Tarkan’ın da bulunduğu bir çok ünlü isim için stil danışmanlığı yapıyor.</p>

						<p>Şimdilerde kendine ait bir markanın alt yapısını hazırlıyor.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri6">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/6.png">
						<img src="<?php echo base_url()?>img/juri/6a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Mehmet <span>Erzincan / </span><span style="font-size:16px">Moda Fotoğrafçısı</span></h2>
						<p>Mehmet Erzincan İstanbulda yaşıyor ve moda ve portre fotoğrafçısı olarak çalışıyor.</p>

						<p>Kocaeli Universitesinde fotoğraf alanında Bachelor of Arts derecesini aldı.</p>

						<p>Mezuniyet sonrası 3 yıl asistanlık yapatıktan sonra moda dergileri ve reklam ajanslarında kendi işini yapmaya başladı.</p>

						<p>Bi çok ünlü isim ve marka için aktif şekilde fotoğraf prodüksiyonları yapmakta.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri7">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<div class="body juri-detay">
					<div style="width:180px;float:left;">
						<img src="<?php echo base_url()?>img/juri/7.png">
						<img src="<?php echo base_url()?>img/juri/7a.png" style="margin-left:30px;margin-top:40px;">
					</div>
					<div class="title">
						<a href="#" class="openPage" data-page=".juri">< Jüriye geri dön </a>
					</div>
					<div class="body">
						<h2>Egemen <span>Atış / </span><span style="font-size:16px">Brisa Tüketici Ürünleri Pazarlama Direktörü</span></h2>
					</div>
				</div>
			</div>
			<div class="page pop yarismahakkinda casebg">
				<h2>Yarışma Hakkında</h2>
				<div class="body" style=" margin:30px; line-height:20px;">
					<div class="contentHolder" style="float:left;">
						<div style="float:left;width:400px; height:400px;" class="scrollcontent">
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
								<br><br>
								It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
							 	<br><br>
								Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
								<br><br>
								Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
							</p>
						</div>
					</div>
					<a href="#" class="case-indir" style="margin-left:0px; margin-top:0px;"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop kullanimkosullari casebg">
				<h2>Katılım Koşulları</h2>
				<div class="body" style=" margin:30px; line-height:20px;">
					<div class="contentHolder" style="float:left;">
						<div style="float:left;width:400px; height:400px;" class="scrollcontent">
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
								<br><br>
								It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
							 	<br><br>
								Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
								<br><br>
								Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
							</p>
						</div>
					</div>
					<a href="#" class="case-indir" style="margin-left:0px; margin-top:0px;"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop iletisim casebg">
				<h2>İletişim</h2>
				<div class="body" style="width:520px; margin:30px;">
					<div id="iletisim-formu-wrapper" style="float:left; margin-left:30px;">
						<form id="iletisim-formu">
							<div class="input">
								<input type="text" name="first_name" placeholder="Ad" title="İsminizi giriniz!" data-minlength="3">
							</div>
							<div class="input">
								<input type="text" name="last_name" placeholder="Soyad" title="Soyadınızı giriniz!" data-minlength="2">
							</div>
							<div class="input">
								<input type="text" name="email" placeholder="E-posta" title="Geçerli bir e-posta adresi yazınız!" data-minlength="4">
							</div>
							<div class="input textarea" data-alertclass="textarea-alert">
								<textarea name="message" title="Mesajınızı yazmalısınız" data-minlength="5" placeholder="Yorum"></textarea>
							</div>
						</form>
						<span class="btn-lg" id="form-gonder" style="margin-left:100px;margin-top:40px;">+ Gönder</span>
					</div>
					<div id="contact-success" style="display:none; text-align:center;margin-top:200px;">
						<p style="font-weight:bold; font-size:19px;">İletişim formunuz ulaştı.</p><br>
						<p style="font-size:18px;font-weight:bold;"><br>Teşekkür ederiz.</p>
					</div>
				</div>
			</div>

			<div class="page pop takvim casebg">
				<h2>Yarışma Takvimi</h2>
				<div class="body" style="width:520px; margin:30px;">
					<img src="<?php echo base_url()?>img/takvim.png">
				</div>
			</div>

			

		</div>
	</div>
</div>


<?php include("footer.php");?>