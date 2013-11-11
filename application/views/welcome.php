<?php include("head.php");?>
	<title>Bridgestone Tasarım Yarışması</title>
	<script type="text/javascript">
var loaded = 0;
		window.fbAsyncInit = function() {
		    // init the FB JS SDK
		    FB.init({
		      appId      : '1381153932127900',                        // App ID from the app dashboard
		      //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel file for x-domain comms
		      status     : true,                                 // Check Facebook Login status
		      xfbml      : true                                  // Look for social plugins on the page
		    });

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
		};


		function fileUpload(form, action_url, div_id, kayitform) {
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
		 				$(".loadingoverlay").hide();
		 				if(kayitform){
		 					var data = $("#kayit-formu").serializeObject();
							$.post("<?php echo base_url(); ?>welcome/create/", data, function(d){
								$("#upload-content").hide(function(){
				 					$("#upload-success").show();
				 				});
				 				openPage(".yukle");
							});	
		 				}else{
			 				openPage(".yukle");
			 				$("#upload-content").fadeOut(function(){
			 					$("#upload-success").fadeIn();
			 				});
			 			}
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
		 
		 	if(kayitform){
			 	$("#katil").fadeOut(function(){
			 		$(".kayit .loading").fadeIn();
			 		$(".loadingoverlay").show();
			 	});
		 	}else{
		 		$("#tasarimyukle_buton").fadeOut(function(){
			 		$("#upload-content .loading").fadeIn();
			 		$(".loadingoverlay").show();
		 		});
		 	}
		    //document.getElementById(div_id).innerHTML = "Uploading...";
		}

		function checkFileSize(inputid, kayitform) {
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
		        	popup_alert("Yüklemeye çalıştığınız dosya boyutu max 10MB olmalıdır. Lütfen tekrar deneyiniz.");
		        	return false;
		        }
		        var ext = file.name.split(".")[file.name.split(".").length - 1];
		        if(ext == "png" || ext == "jpg" || ext == "png" || ext == "pdf" || ext == "ai" || ext == "psd" || ext == "tif"){
		        	//
		        }else{
		        	popup_alert("Destek verilen formatlar; jpg, png, pdf, ai, psd, tif");
		        	return false;
		        }

		        if(kayitform == false){
		        	if(katilim_kosullari2 == false){
			        	popup_alert("Katılım koşullarını kabul etmeniz gerekiyor");
			        	return false;
			        }
		        }
		        
		    }

		    return true;
		}

		function popup_alert(d){
			$(".alert").css({
				"left" : ($(window).width() - $(".alert").width()) / 2,
				"top" : ($(window).height() - $(".alert").height()) / 2,
			});
			$(".alert .text").text(d);
			$(".overlay").fadeIn();
		}

		
		//if (document.getElementById('facebook-jssdk')) {return;}
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
		var file_upload_action = false;

		function toDateTime(secs){
		    var t = new Date();
		    t.setSeconds(secs);
		    return t;
		}

		function openPage(page){
			$(".page").slideUp();
			$(page).slideDown();
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
				if(p == ".kayit"){
					$.post("<?php echo base_url();?>welcome/user_check/", function(d){
						if(d > 0){
							openPage(".yukle");
						}else{
							openPage(".kayit");
						}
					});
				}else{
					openPage($(this).data("page"));	
				}
			});


			$("#menu #down .body a").click(function(){
				openPage("." + $(this).attr("href").split("#")[1]);
				$("#menu #down").fadeOut();

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
					popup_alert("Katılım koşullarını okumanız ve kabul etmeniz gerekiyor.");
					hata = true;
				}


				if(hata == true){
					return false;
				}else{
					if(checkFileSize("tasariminput2", true)){
						fileUpload(document.getElementById("fileform2"), "<?php base_url() ?>welcome/upload/", "upload_action", true);
					}else{
						return false;
					}
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
				$("#tasarimfilename").val($("#tasariminput").val());
			});

			$("#tasariminput2").change(function(){
				$("#tasarimfilename2").val($("#tasariminput2").val());
			});

			$("#tasarimyukle_buton").click(function(){
				if(checkFileSize("tasariminput", false)){
					fileUpload(document.getElementById("fileform"), "<?php base_url() ?>welcome/upload/", "upload_action", false);
				}
			});

			
			$(".case3d img").load(function(){
				loaded++;
				if(loaded == 70){
					$(".icons").fadeIn(1600);	
					$(".case3d").fadeIn();
					$(".sol").fadeIn();
					$(".case3dloading").hide();
					$(".loadingoverlay").hide();
					var don = setInterval(function(){
						if(frame == 80){
							nextFrame(frame);
							frame = 0;
						}else{
							nextFrame(frame);
							frame++;
						}
					}, 60);
				}

				$(".yukleme_yuzde").text(((100 / 81) * loaded).toFixed(0));
				
			});

			 $( "#slider" ).slider({
			 	min : 0,
			 	max : 80,
			 	value : 40,
			 	slide : function(event, ui){
			 		$(".caseframe").hide();
					$(".caseframe" + ui.value).show();
					if(ui.value >= 40){
						var deg = ui.value - 40;
					}else{
						var deg = "-" + (40 - ui.value);
					}
					//$(".icon").transition({rotate: deg},1);
			 	}
			 });

			 $(".hemenbasvur").hover(function(){
			 	$(".hemenbasvur-ok").animate({"margin-top": "+=10px"});
			 }, function(){
			 	$(".hemenbasvur-ok").animate({"margin-top": "-=10px"});
			 });

			 $(".kapat").click(function(){
				$(this).parents(".overlay").fadeOut();
			 });

			$(document).bind('keydown',function(evt) {
				if(evt.keyCode == "37"){
					$("#slider").slider('value', $("#slider").slider("value") - 1);
				}
				if(evt.keyCode == "39"){
					$("#slider").slider('value', $("#slider").slider("value") + 1);
				}
				$(".caseframe").hide();
				$(".caseframe" + $("#slider").slider("value")).show();
			});

			$(".pagekapat").click(function(){
				openPage(".page-anasayfa");
			});
			

			 /*

			hleft = 0;
			setInterval(function(){
				if($(".handle").css("left") != hleft){
					console.log($(".handle").css("left"));
					hleft = $(".handle").css("left");
					$(".caseframe").hide();
					$(".caseframe" + $("#range").val()).show();
					
				}
			}, 50);

*/

			/*
			

			*/
			
			/*
			setTimeout(function(){
				animatePusula();
				setInterval(function(){
					animatePusula();
				}, 2000);
			}, 400);
			
			//setTimeout(function(){
				animateTelefon();
				setInterval(function(){
					animateTelefon();
				}, 2000);
			//}, 2000);


			setTimeout(function(){
				animateYol();
				setInterval(function(){
					animateYol();
				}, 2000);
			}, 200);

			setTimeout(function(){
				animateLike();
				setInterval(function(){
					animateLike();
				}, 2000);
			}, 1100);

			setTimeout(function(){
				animatePark();
				setInterval(function(){
					animatePark();
				}, 2000);
			}, 500);

			setTimeout(function(){
				animateTrafik();
				setInterval(function(){
					animateTrafik();
				}, 2000);
			}, 1900);

			setTimeout(function(){
				animateGunes();
				setInterval(function(){
					animateGunes();
				}, 2000);
			}, 420);

			setTimeout(function(){
				animateAraba();
				setInterval(function(){
					animateAraba();
				}, 2000);
			}, 120);

			setTimeout(function(){
				animateTabela();
				setInterval(function(){
					animateTabela();
				}, 2000);
			}, 80);

			*/

		});


function animateTelefon(){
	$(".icon-telefon")
		.transition({x: '+=10px', rotate: '+=10deg', y : '+=10px', scale: 1.1}, 1000)
		.transition({x: '-=10px', rotate: '-=10deg', y : '-=10px', scale: 1}, 1000);

	/*
		$(".icon-telefon").css("z-index", "98");
		setTimeout(function(){
			$(".icon-telefon").css("z-index", "100");
		}, 2000);
	
	$(".icon-telefon").
		transition({ x: '-=340px', y: '-=30px', scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=200px', y: '-=30px', scale: 1 , perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=340px', y: '+=30px', scale: 1.2, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=200px', y: '+=30px', scale: 1 , perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');

		*/
}

function animatePusula(){
	$(".icon-pusula")
		.transition({ rotate: '+=360'}, 1000)
		.transition({ rotate: '-=360', rotate3d: '1,1,0,180deg'}, 1000);
	/*
		$(".icon-pusula").css("z-index", "98");
		setTimeout(function(){
			$(".icon-pusula").css("z-index", "100");
		}, 2000);
	
	$(".icon-pusula").
		transition({ x: '-=240px', y: '+=30px', scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', y: '+=20px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=240px', y: '-=30px', scale: 1.3, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '-=20px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animateYol(){
	$(".icon-yol")
		.transition({x: "+=10", y: "-=10px", scale:0.9}, 1000)
		.transition({x: "-=10", y: "+=10px", scale:1}, 1000);

	/*
		$(".icon-yol").css("z-index", "98");
		setTimeout(function(){
			$(".icon-yol").css("z-index", "100");
		}, 2000);
	
	$(".icon-yol").
		transition({ x: '-=340px', y: '-=30px',  scale: 0.8, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px',y: '-=20px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '+=340px', y: '+=30px', scale: 1.2, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '+=30px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
	*/
}

function animateLike(){
	$(".icon-like")
		.transition({rotate: "+=10px", x:'+=10', y: '-=10px'}, 1000)
		.transition({rotate: "-=10px", x:'-=10', y: '+=10px'}, 1000)
	/*
		$(".icon-like").css("z-index", "100");
		setTimeout(function(){
			$(".icon-like").css("z-index", "98");
		}, 2000);
	
	$(".icon-like").		
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animateTabela(){
	$(".icon-tabela")
		.transition({scale:1.2, x: '-=10px'}, 1000)
		.transition({scale:1, x: '+=10px'}, 1000)
	/*
	$(".icon-tabela").css("z-index", "100");
		setTimeout(function(){
			$(".icon-tabela").css("z-index", "98");
		}, 2000);
	
	$(".icon-tabela").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animatePark(){
	$(".icon-park")
		.transition({x:'-=10', scale: 1.1}, 1000)
		.transition({x:'+=10', scale: 1}, 1000);
	/*
		$(".icon-park").css("z-index", "100");
		setTimeout(function(){
			$(".icon-park").css("z-index", "98");
		}, 2000);
	
	$(".icon-park").
		transition({ x: '+=340px',y: '+=40px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', y: '+=30px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=100px',y: '-=40px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=340px', y: '-=30px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animateTrafik(){
	$(".icon-trafik")
		.transition({x: "+=10px", rotate: '+=10'}, 1000)
		.transition({x: "-=10px", rotate: '-=10'}, 1000);
	/*
		$(".icon-trafik").css("z-index", "100");
		setTimeout(function(){
			$(".icon-trafik").css("z-index", "98");
		}, 2000);
	
	$(".icon-trafik").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animateGunes(){
	$(".icon-gunes")
		.transition({x: "+=10px", scale: 1.2, y: "-=10px"}, 1000)
		.transition({x: "-=10px", scale: 1, y: "+=10px"}, 1000)
	/*		
		$(".icon-gunes").css("z-index", "100");
		setTimeout(function(){
			$(".icon-gunes").css("z-index", "98");	
		}, 2000);
	
	$(".icon-gunes").
		transition({ x: '+=240px', scale: 0.8, perspective : '-=50px',rotateY: '-=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '+=100px', scale: 1 ,perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.34,.96,.83,.99)').
		transition({ x: '-=240px', scale: 1.2, perspective : '+=50px',rotateY: '+=90deg'}, 1000, 'cubic-bezier(.79,.41,.92,.71)').transition({ x: '-=100px', scale: 1 ,perspective : '-=50px',rotateY: '-=90deg'}, 1050, 'cubic-bezier(.34,.96,.83,.99)');
		*/
}

function animateAraba(){
	$(".icon-araba")
		.transition({x:'-=10', rotate: '+=10px', y: '-=10px'}, 1000)
		.transition({x:'+=10', rotate: '-=10px', y: '+=10px'}, 1000);
	/*
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
	<style type="text/css">
		.loading {position: relative}
	</style>


</head>
<body>


<div class="loadingoverlay" style="width:100%;height: 100%;position: fixed;background: rgba(0, 0, 0, 0.61);">

</div>
<div class="main-site">
	<div class="content">
		<?php include("header.php");?>
		<div class="wrapper">
			<div class="page page-anasayfa">
				<div class="sol" style="display:none">
					<div style="float:left; width:100px;height: 65px;margin-left: 100px;margin-top: 62px;">
						<img src="<?php echo base_url();?>img/ok.png" class="hemenbasvur-ok">
					</div>
					<div class="openPage hemenbasvur" data-page=".kayit"></div>
				</div>
				<div class="sag" style="float:left; width:400px;height:500px;margin-left:100px; margin-top:-58px;">
					<div style="width:100%;float:left;" class="case3dloading">
						<img src="<?php echo base_url();?>img/loader.gif" class="loading" style="float:left;margin-left:320px;margin-top:130px;position:relative;">
					</div>
					<div style="width:100%;float:left;text-align:center;color:white;margin-left: 141px;margin-top: 12px;" class="case3dloading">Yükleniyor (<span class="yukleme_yuzde"></span>)</div>
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
						<?php $k = 0; ?>
						<?php for($i = 40; $i <= 80; $i++){?>
							<img src="<?php echo base_url(); ?>img/case/Case.RGB_color.00<?php echo $i; ?>.png?nocache=<?php echo rand(9, 99999);?>" class="caseframe caseframe<?php echo $k;?>" data-frame="<?php echo $k;?>">
						<?php 
							$k++;
						} ?>

						<?php for($i = 0; $i <= 39; $i++){ ?>
							<img src="<?php echo base_url(); ?>img/case/Case.RGB_color.00<?php echo $i; ?>.png?nocache=<?php echo rand(9, 99999);?>" class="caseframe caseframe<?php echo $k;?>" data-frame="<?php echo $k;?>">
						<?php $k++; } ?>
					</div>
				</div>
			</div>

			<div class="page pop basvuru casebg">
				<h2>Başvuru</h2>
				<span class="pagekapat">X</span>
				<div class="body" style="width:520px; margin:30px;">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea </p>
					<br>
					<p>commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id </p>
					<span class="openPage btn-lg" data-page=".kayit" style="margin-left:100px;margin-top:40px;">+Başvuru Yap</span>
					<a href="#" class="case-indir"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop kayit">
				<h2>Kayıt</h2>
				<span class="pagekapat">X</span>
				<div class="body" style="margin:30px;">
					<div style="float:left; margin-left:30px; width:490px;">
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
						<div class="input fileinput">
							<input type="text" placeholder="Dosya Adı" id="tasarimfilename2">
							<form id="fileform2">
								<input type="file" name="file" class="hiddeninput" id="tasariminput2" style="float:right; margin-top:-70px;">
							</form>
						</div>
						<p style="width: 100%;float: left;line-height: 35px;margin-left: 46px;margin-top: 20px;text-indent: 4px;" id="katilim-kosullari-text" title="Katılım koşullarını okumanız ve kabul etmeniz gerekiyor!">
							<img src="<?php echo base_url()?>img/checkbox.png" style="margin-top:6px; float:left;cursor:pointer">
							<img src="<?php echo base_url()?>img/checkbox-checked.png" style="display:none; margin-top:6px; float:left;cursor:pointer">
							<a href="#" class="openPage" data-page=".kullanimkosullari">Katılım koşulları</a>nı okudum ve kabul ediyorum.
						</p>
						<div style="width:100%;float:left;" >
							<img src="<?php echo base_url();?>img/loading2.gif" class="loading" style="display:none;float:left;margin-left:182px">
						</div>
						<span class="btn-lg" id="katil" style="margin-left:78px;">+ Katıl</span>
					</div>
					<div style="float: left;width: 316px;text-align: center;">
						<p style="margin-top:78px">Yarışma kapsamında değerlendirmeye alınacak <br>
							tasarımlarda lastik veya emniyet konseptinde <br>
									hazırlanmış olma şartı aranmaktadır.</p><br><br>
									<p>Tasarım kitini buradan indirebilirsiniz.</p>
									<a href="#" class="case-indir" style="margin-left:18px; margin-top:44px;"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
					</div>
				</div>
			</div>

			<div class="page pop yukle casebg">
				<h2>Tasarımını Yükle</h2>
				<span class="pagekapat">X</span>
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
							<a href="#" class="openPage" data-page=".kullanimkosullari">Katılım koşulları</a>nı okudum ve kabul ediyorum.
						</p>
						<span class="btn-lg" id="tasarimyukle_buton" style="margin-left:100px;margin-top:18px;">+Tasarımını Yükle</span>
						<div style="width:100%;float:left;"><img src="<?php echo base_url();?>img/loading2.gif" class="loading" style="display:none;float:left;margin-left:221px;margin-top:42px;"></div>
						<div style="width:500px;float:left;" class="uyarilar">
							<p style="font-weight:bold;">Uyarılar:</p>
							<br>
							<p>- Dosya boyutu max. 10MB olmalıdır.</p>
							<p>- Destek verilen formatlar; jpg, png, pdf, ai, psd, tif</p>
							<p>- Yaptığınız çalışmanın vektörel formatta hazırlanması gerekmektedir. </p>
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
				<span class="pagekapat">X</span>
				<div class="body" style="width:520px; margin:30px;">
					<img src="<?php echo base_url()?>img/oduller.png" style="float:left; margin-left:54px;">
				</div>
			</div>

			<div class="page pop yarismatemasi casebg">
				<h2>Yarışma Teması</h2>
				<span class="pagekapat">X</span>
				<div class="body" style="width:520px; margin:30px; line-height:20px;">
					<p style="font-size:18px;"><span style="font-weight:bold;">Konsept:</span>Akıllı Telefon Case Tasarımı  </p>
					<br>
					<p>Bridgestone olarak, yeteneğine güvenen her daldan sanatçıyı günlük hayatın vazgeçilmez bir parçası haline gelen akıllı telefonlara case tasarlamaya davet ediyoruz! </p>
					<p>Tasarım ve teknolojinin mükemmel uyumunu yakalamak için çıktığımız yolda yaratıcılığa verdiğimiz önemi kendi tasarımlarına aktarabilecek genç yetenekler! Bridgestone Tasarım Yarışması büyük ödülleriyle sizi bekliyor.
					<p>Eğer sen de lastik konseptini tasarımlarımda en yaratıcı olarak ben kullanırım diyorsan; durma, tasarla, gönder!</p>
					<a href="#" class="case-indir"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop juri">
				<h2>Jüri</h2>
				<span class="pagekapat">X</span>
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
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>Ünlü mimar Mahmut Anlar ile birlikte çalıştı; birçok restaurant, gece kulübü projesinde yer aldı.</p>
						<p>2009 yılında, Nişantaşı’nda kendi tasarım ofisini kurdu. Hala mekan, ürün tasarımı ve tasarım danışmanlığı alanlarında hizmet vermektedir.</p>
						<p>Tasarımlarının arasında Funfatale - Les Ottomans, Joke Circus, Salomanje, Cento Per Cento ve yenilenen Sortie var.</p>
						<p>2012 yılında “Archive” adlı mobilya ve aydınlatma aksesuarlarının satıldığı galerisini Galata’da açtı.</p>
						<p>2013 yılında “Elle Decoration” dergisi tarafından düzenlenen Uluslararası EDIDA Tasarım Yarışması’nda, 26 ülkenin editöründen oluşan uluslararası jürinin oylaması sonucu “Yılın Genç Tasarımcısı - Best Young Designer ” ödülünü aldı.</p>


					</div>
				</div>
			</div>

			<div class="page pop juri3">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>Ankara'da doğdu. Tabeetha School, Tel Aviv ve Kadıköy Anadolu Lisesi’ndeki orta ve lise öğreniminden sonra ODTÜ Endüstriyel Tasarım Bölümü'nden mezun oldu.</p>
						<p>Aynı bölümde 4 yıl araştırma görevlisi ve Bilkent Üniversitesi Mimarlık Bölümü’nde yarı zamanlı öğretim görevlisi olarak çalıştı.</p>
						<p>1989 yılında Mehmet Akan ile STÜDYO'yu kurdu. Bugüne kadar 100'ün üzerindeki ofis, banka, restoran ve mağaza iç mekan projesinde proje yöneticisi ve müellifi olarak çalıştı. STÜDYO ofis mobilyaları koleksiyonunu ve MetalForm'un metal mobilya koleksiyonunu tasarladı.</p>
						<p>Sezgin Akan, profesyonel programının yanında mücevher tasarımı da yapmakta ve eserleri İstanbul, Ankara, Londra ve Amsterdam'da solo, karma sergilerde ve galerilerde sergilenmektedir.</p>
						<p>2004 yılından bu yana ODTÜ Endüstriyel Tasarım Bölümü'nde Jewellery Beyond Tradition dersleri veren Akan, aynı bölümde 2009 yılından beri de Mezuniyet Projeleri dersine girmektedir.</p>
						<p>Ayrıca, kurucularından olduğu ETMK adına yarışma jüri üyeliği de yapmaktadır.
					</div>
				</div>
			</div>

			<div class="page pop juri4">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>Marmara Güzel Sanatlar Fakültesi’nde Tekstil Tasarımı eğitiminin ardından Amerika’ya gitti ve sayılı tasarım okullarından biri olan FIT’de (Fashion Institute of Technology) ve Paris American Fashion Academy’de moda tasarımı üzerine dersler aldı.</p>
						<p>Dünyaca ünlü tasarımcı Donna Karan’ın yanında staj yaptı ve kısa zamanda da markanın erkek departmanında tasarımcı olarak çalışmaya başladı.</p>
						<p>2 yıl sonra Türkiye’ye döndü ve Hakan Yıldırım ile çalıştı. Sonrasında kendi adını taşıyan markasını yarattı.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri5">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>Profesyonel kariyerine Diesel’de çalışarak başladı ve kreatif direktörlüğe kadar yükseldi. </p>
						<p>2002 yılında Diesel’den ayrılıp birkaç arkadaşıyla birlikte bir street fashion markası kurdu. </p>
						<p>Stylist kimliği ile aralarında Tarkan’ın da bulunduğu bir çok ünlü isim için stil danışmanlığı yapan Eker, şimdilerde kendine ait bir markanın alt yapısını hazırlamaktadır.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri6">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>Kocaeli Üniversitesi Fotoğraf Bölümü’nde Bachelor of Arts derecesini aldı.</p>
						<p>Mezuniyet sonrası 3 yıl asistanlık yaptıktan sonra, moda dergileri ve reklam ajanslarında kendi işini yapmaya başladı.</p>
						<p>İstanbul’da yaşayan Erzincan, moda ve portre fotoğrafçısı olarak birçok ünlü isim ve marka için aktif şekilde fotoğraf prodüksiyonları yapmaktadır.</p>
					</div>
				</div>
			</div>

			<div class="page pop juri7">
				<h2 style="margin-bottom:0px; !important">Jüri</h2>
				<span class="pagekapat" style="margin-top:-49px">X</span>
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
						<p>1977 yılında doğan ve lisans eğitimini ODTÜ Makine Mühendisliği’nde tamamlayan Egemen Atış, lisans eğitiminin ardından Boğaziçi Üniversitesi’nde İşletme üzerine yüksek lisans yapmıştır.</p>

						<p>2002 yılından beri Brisa bünyesinde çalışan ve Yeni Pazar Geliştirme Müdürü, Risk Yönetim Müdürü, Ürün Müdürü ve Ürün Yönetim Direktörü gibi çeşitli görevlerde bulunan Atış, 2012 yılından beri Tüketici Ürünleri Pazarlama Direktörlüğü görevini yürütmektedir.</p>

						<p>Seyahat etmekten ve sörf yapmaktan keyif alan Egemen Atış, evli ve 2 yaşında bir kız çocuk babasıdır.</p>
					</div>
				</div>
			</div>
			<div class="page pop yarismahakkinda casebg">
				<h2>Yarışma Hakkında</h2>
				<span class="pagekapat">X</span>
				<div class="body" style=" margin:30px; line-height:20px;">
					<div class="contentHolder" style="float:left;">
						<div style="float:left;width:400px; height:400px;" class="scrollcontent">
								
								<h4>BRIDGESTONE </h4>
								<h4 style="font-size:28px;">TASARIM YARISMASI 2013</h4>
								<br><br>

								<h4>YARIŞMA TEMASI</h4>
								<p>Akıllı Telefon Kılıfı (Case) Tasarımı</p>

								<br>
								<h4>YARIŞMANIN AMACI</h4>
								<p>"Geleceğin Basşarılı Tasarımcıları'nın yaratıcılıklarını geliştirmek, kariyerlerini desteklemek amacıyla düzenlenmektedir.</p>
								<br>
								<h4>DEĞERLENDİRME KRİTERLERİ </h4>
								<p>Jürinin değerlendirmesinde dikkate alınacak hususlar aşağıdaki gibidir;</p>
								<br>
								<p>
								•	Estetik<br>
								•	Özgünlük<br>
								•	İşlevsellik<br>
								•	Üretilebilirlik<br>
								•	Sürdürülebilirlik<br>
								</p>
								<br>

								<h4>JÜRİ</h4>
								<p>Sezgin Akan - Akademisyen<br>
								Elif Çigizoglu - Moda tasarimcisi<br>
								Umut Eker - Stylist <br>
								Mehmet Erzincan - Moda fotografcisi<br>
								Sami Savatli - Endustri ürünleri tasarimcisi<br>
								Egemen Atış - Brisa Tüketici Ürünleri Pazarlama Direktörü<br>
								</p>
								<br>
								<h4>BAŞVURU KOŞULLARI</h4>
								<p>Katılımcı, istediği sayıda tasarım ile yarışmaya katılabilir.</p>

								<p>Yarışmaya katılan her projede özgünlük, daha önce başka bir yerde üretilmemiş olması, başka bir yarışmada ödül almamış olması şartları aranmaktadır. Bunun aksi bir durumun tespiti halinde, proje yarışmadan diskalifiye edilir. Ayrıca, yarışmaya gönderilen eserin özgün bir çalışma olmaması, aksine bir iddia olması ve üçüncü kişilerin tasarım üzerinde hak iddia etmesi durumunda sorumluluk yarışmacıya ait olacaktır.</p>

								<p>Finale kalan ilk 10 finalist, tasarımlarının kullanım haklarını, hiçbir koşul öne sürmeksizin sözleşme ile Brisa Bridgestone </p>

								<p>Sabancı Lastik Sanayi ve Ticaret A. Ş.’ye devretmiş sayılacaktır. </p>

								<p>Yarışma sonrası tasarımcılar verilecek ödüllerin dışında Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’den hiçbir talep, hak ve iddiada bulunamazlar. </p>

								<p>Finale kalan tasarımların uygulanması ve üretimi durumunda proje sahiplerine ayrıca bir ücret ödenmez. </p>

								<p>Bu projelerin Fikir ve Sanat Eserleri Kanunu (FSEK) kapsamında tüm mali ve mülkiyet hakları süre, yer ve muhteva bakımından sınırsız olmak kaydıyla münhasıran Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’ye devir edilmiş olur. </p>

								<p>Proje sahibi, isminin yayınlanmasına şimdiden muvafakat eder. </p>

								<p>Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş. organizasyonla ilgili yaptığı değişikliklerden sorumlu tutulamaz.</p>

								<h4>TAAHHÜTNAME</h4>
								<p>Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş. tarafından düzenlenmekte olan “Bridgestone Tasarım Yarışması 2013” yarışmasına sunmuş olduğum tasarım ile katılmış bulunmaktayım. </p>
								<br>
								<p>Bu yarışma kapsamında, ilgili tasarımın tamamen bütün aşamaları ile tarafıma ait olduğunu, 3.şahıs/kurumlardan intihal/esinlenme v.b. suretiyle edinmediğimi kabul, beyan ve taahhüt ederim. </p>
								<br>
								<p>İş bu yarışma kapsamında tasarlamış olduğum tasarımın, tarafıma ait olmadığının tespiti ve bu sebeple Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’nin uğrayabileceği bütün zararları, nakden ve defaten Bridgestone’un ilk talebi halinde ödeyeceğimi gayrıkabilirücu olarak kabul, beyan ve taahhütle, yapmış olduğum tasarımımın ilk üçe seçilerek ödüllendirilmesi ve Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş. tarafından üretilmek istenmesi halinde, iş bu yarışma kapsamında vaadedilen ödül dışında başkaca herhangi bir maddi talepte bulunmayacağımı, telif, patent bedeli, v.s. adı altında her nam altında olursa olsun hiçbir şekilde bir bedel talep etmeyeceğimi ve bu tasarımın tüm mali ve her türlü mülkiyet haklarının (çoğaltma, basma, yayma, değiştirme, satışa sunma v.b.) haklarının Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’ye ait olduğunu peşinen kabul, beyan ve taahhüt ederim.</p>
								<br>

								<h4>KATILIM ŞEKLİ</h4>
								<p>Katılımcılar, çalışmalarını proje sitesinden indirdikleri örnek versiyon üzerinden hazırlayacaklardır. Başvurular online olarak proje sitesine yüklendikten sonra katılımcılar, öğrenci yada mezuniyet belgelerini ve proje sitesinden indirdikleri taahhütnamenin çıktısını imzalayarak en geç 15 Kasım 2013 tarihinde “Promoqube - İnönü Caddesi Mithat Paşa Apt. No:48-8 Gümüşsuyu Beyoğlu – İstanbul” adresinde olacak şekilde elden veya posta yolu ile iletmelidir. Belgelerin eksik olması halinde başvurular alınmayacaktır.</p>
								<br>

								<h4>DEĞERLENDİRME ŞEKLİ </h4>
								<p>Ön jüri elemesini geçen eserler yarışma jürisine sunulacaktır. Jüri başkanı yönetiminde toplanacak olan yarışma jürisi bir araya gelerek eserleri yukarıda açıklanan değerlendirme kriterleri üzerinden değerlendirerek öncelikle ilk 10 ﬁnalisti belirleyecek, sonrasında belirlenen ilk 10 ﬁnalist içerisinden yarışmanın birincisi, ikincisi ve üçüncüsü seçilecektir.  </p>
								<br>
								<h4>SONUÇLARIN DUYURULMASI </h4>
								<p>Jürinin elemeleri ile seçilen ilk 3 tasarım proje sitesi üzerinden açıklanacaktır. </p>
								<p>İlk 3 tasarımın sahibine ayrıca kayıt sırasında verdikleri adresler üzerinden ulaşılacaktır. </p>
								<br>

								<h4>VERİLECEK ÖDÜLLER </h4>
								<p><span style="font-weight:bold">Birincilik Ödülü</span> MacBook Pro 13" Retina DC i5 2.5GHz/8GB/128GB flash/HDG4000 ve CS6 ADOBE DESIGN STD 6 WIN & MAC AOO LICENSE</p>

								<p><span style="font-weight:bold">İkincilik Ödülü</span> MacBook Air 11" DC i5 1.3GHz/4GB/128GB/HDG ve CS6 ADOBE DESIGN STD 6 WIN & MAC AOO LICENSE</p>

								<p><span style="font-weight:bold">Üçüncülük Ödülü</span> MacBook Air 11" DC i5 1.3GHz/4GB/128GB/HDG</p>

								<p><span style="font-weight:bold">Mansiyon Ödülü</span> iPhone 5 16GB - Siyah</p>
								<br>

								<h4>TAKVIM</h4>
								<p>Yarışma başlangıç tarihi 12 Kasım 2013</p>
								<p>Son katılım tarihi 12 Aralık 2013</p>
								<p>Jüri değerlendirmesi 16 Aralık 2013</p>
								<p>Kazananların açıklanması 18 Aralık 2013</p>

						</div>
					</div>
					<a href="#" class="case-indir" style="margin-left:0px; margin-top:0px;"><img src="<?php echo base_url();?>img/caseindir-buton.png"></a>
				</div>
			</div>

			<div class="page pop kullanimkosullari casebg">
				<h2>Katılım Koşulları</h2>
				<span class="pagekapat">X</span>
				<div class="body" style=" margin:30px; line-height:20px;">
					<div class="contentHolder" style="float:left;">
						<div style="float:left;width:400px; height:400px;" class="scrollcontent">
							<p>Katılımcı, istediği sayıda tasarım ile yarışmaya katılabilir.</p>

							<p>Yarışmaya katılan her projede özgünlük, daha önce başka bir yerde üretilmemiş olması, başka bir yarışmada ödül almamış olması şartları aranmaktadır. Bunun aksi bir durumun tespiti halinde, proje yarışmadan diskalifiye edilir. Ayrıca, yarışmaya gönderilen eserin özgün bir çalışma olmaması, aksine bir iddia olması ve üçüncü kişilerin tasarım üzerinde hak iddia etmesi durumunda sorumluluk yarışmacıya ait olacaktır.</p>

							<p>Finale kalan ilk 10 finalist, tasarımlarının kullanım haklarını, hiçbir koşul öne sürmeksizin sözleşme ile Brisa Bridgestone </p>

							<p>Sabancı Lastik Sanayi ve Ticaret A. Ş.’ye devretmiş sayılacaktır. </p>

							<p>Yarışma sonrası tasarımcılar verilecek ödüllerin dışında Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’den hiçbir talep, hak ve iddiada bulunamazlar. </p>

							<p>Finale kalan tasarımların uygulanması ve üretimi durumunda proje sahiplerine ayrıca bir ücret ödenmez. </p>

							<p>Bu projelerin Fikir ve Sanat Eserleri Kanunu (FSEK) kapsamında tüm mali ve mülkiyet hakları süre, yer ve muhteva bakımından sınırsız olmak kaydıyla münhasıran Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş.’ye devir edilmiş olur. </p>

							<p>Proje sahibi, isminin yayınlanmasına şimdiden muvafakat eder. </p>

							<p>Brisa Bridgestone Sabancı Lastik Sanayi ve Ticaret A. Ş. organizasyonla ilgili yaptığı değişikliklerden sorumlu tutulamaz.</p>

						</div>
					</div>
				</div>
			</div>

			<div class="page pop iletisim casebg">
				<h2>İletişim</h2>
				<span class="pagekapat">X</span>
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
				<span class="pagekapat">X</span>
				<div class="body" style="width:520px; margin:30px;">
					<img src="<?php echo base_url()?>img/takvim.png">
				</div>
			</div>

			<div class="overlay" style="display:none">
				<div class="alert" style="margin:auto;">
					<div class="kapat">X</div>
					<div class="text">Yüklemeye çalıştığınız dosya boyutu max 10MB olmalıdır. Lütfen tekrar deneyiniz.</div>
				</div>
			</div>

			

		</div>
	</div>
</div>


<?php include("footer.php");?>