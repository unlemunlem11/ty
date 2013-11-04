var hashData = {};
hash = location.hash.replace("#", "").split("&");

$(function(){
	$(".postForm").submit(function(){
		var cb = $(this).data("callback");
		$.post($(this).data("url"), $(this).serializeObject(), function(d){
			try
			{
				var resp = $.parseJSON(d);
				eval(cb + "(" + d + ")");
			}
			catch(err)
			{
				eval(cb + "('" + d + "')");
			}       
			
			
		});
		return false;
	});

	$(document).on('click', ".logged", function(){
		var action = $(this).data("action");
		var item_id = $(this).data("item_id");
		var model = $(this).data("model");
		var point = $(this).data("point");
		$.post("<?=base_url()?>log/action/", {
			action : action,
			point : point
		}, function(d){
			// 
		});
	});

	$(document).on("click", ".anketPost", function(){
		var anket = $(this).parents(".question-wrapper");
		var question_id = $(this).data("anket");
		var vote = anket.find("[name=cevap]:checked").val();
		console.log(vote);
		$.post(base_url + "questions/vote", {
			question_id : question_id,
			vote : vote
		}, function(d){
			anket.find(".question").fadeOut(function(){
				anket.find(".question_success").removeClass("hide").fadeIn();
			});
		});
	});


	

	$('.tt').tipTip({
		delay:0,
		defaultPosition: 'bottom'
	});

	$(document).on("click", ".trigger", function(){
		eval($(this).data("callback"));
	});


	$(document).on('click', ".getJSON", function(){
		if($(this).data("loadbar") != ""){
			$($(this).data("loadbar")).html('<img class="loading" src="' + base_url + 'img/loading.gif">');
		}
		var cb = $(this).data("callback");
		$.get($(this).data("url"), function(j){
			eval(cb + "(" +  j + ")");
		});
	});

	try	{
		for(var i in hash){
			hashData[hash[i].split("=")[0]] = hash[i].split("=")[1];
		}
	}catch(err){

	}

});


	

String.prototype.format = function() {
  var args = arguments;
  return this.replace(/{(\d+)}/g, function(match, number) { 
    return typeof args[number] != 'undefined'
      ? args[number]
      : match
    ;
  });
};