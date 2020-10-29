( function ( $ ) {
    'use strict';

/*/ ####################################
		#####                          #####
		#####      1) General          #####
		#####                          #####
		#################################### /*/

$.puertosend = function(Fid, Faj, Fty = 'modal', Fred = ''){
	$(Fid).on("submit", function(){
		var ths = $(this);
		var btn  = ths.find('button[type=submit]');
		var msg  = ths.find('.pt-msg');
		var btxt = btn.html();
		var form = Faj == "sendpaypalitem" ? $("#payment-form") : $(this);

		btn.prop('disabled', true).html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Loading..');

		$.post(path+"/ajax.php?pg="+ Faj, form.serialize(), function(puerto){
			if(Fty == 'modal'){
				if(puerto.type == 'success'){
					$.puerto_confirm("Success!", puerto.alert, "green");
					setTimeout(function () {
						if(Faj == 'sendpaypalitem' || Faj == 'sendpaypalplan') $(location).attr('href', puerto.url);
						else {
							if(Fred) $(location).attr('href', path+"/"+Fred);
							else location.reload();
						}
					}, 2000);
				} else {
					$.puerto_confirm("Error!", puerto.alert, "red");
					btn.html(btxt).prop('disabled', false);
				}
			} else {
				msg.before(puerto.alert);
				if(puerto.type == "danger"){
					setTimeout(function () {
						$(".alert").fadeOut('slow').remove();
						btn.html(btxt).prop('disabled', false);
					}, 3000);
				} else {
					setTimeout(function () {
						$(".alert").fadeOut('slow').remove();
						if(Faj == "sendsignup"){
							$("#registerModal").modal("hide");
							$("input[name=sign_name]").val($("input[name=reg_name]").val());
							$("input[name=sign_pass]").val($("input[name=reg_pass]").val());
						} else {
							if(Fred) $(location).attr('href', path+"/"+Fred);
							else location.reload();
						}
					}, 3000);
				}
			}
		}, 'json');
		return false;
	});
}

//- Droped menu

$.puerto_droped = function( prtclick, prtlist = "ul.pt-drop" ){
	$(prtclick).on('click', function(){
		var ul = $(this).parent();
		if( ul.find(prtlist).hasClass('open') ){
			ul.find(prtlist).removeClass('open');
			$(this).removeClass('active');
		} else {
			$("ul.pt-drop").parent().find(".active").removeClass('active');
			$("ul.pt-drop").removeClass('open');
			ul.find(prtlist).addClass('open');
			$(this).addClass('active');
		}
		return false;
	});
	$("html, body").on('click', function(){
		$("ul.pt-drop").parent().find(".active").removeClass('active');
		$("ul.pt-drop").removeClass('open');
	});
}

$.puerto_droped(".pt-options-link");
$.puerto_droped(".pt-showmenudetails");
$.puerto_droped(".pt-mobile-menu > a");


//- Phone Mask
$('[type=phone]').mask('000-000-0000');
$('[type=email]').mask("A", {
	translation: {
		"A": { pattern: /[\w@\-.+]/, recursive: true }
	}
});
$('.money').mask('#0.00', {reverse: true});

//- Puerto Conferm

$.puerto_confirm = function( tit, aler, col) {
	$.confirm({
			icon: ( col == 'green' ? 'far fa-laugh-wink' : 'far fa-surprise'),
			theme: 'modern',
			closeIcon: true,
			animation: 'scale',
			type: col,
			title: tit,
			content: aler,
			buttons: false
	});
}

if($('.owl-carousel').length){
$('.owl-carousel').owlCarousel({
	loop: true,
	margin: 10,
	responsiveClass: true,
	nav: true,
	items: 1
});
}


 $('.timepicker1').timepicker({
	 icons: {
    up: 'fas fa-chevron-up',
    down: 'fas fa-chevron-down'
	}
 });


/*
#-------------------------------------------------------------------------
# + 3) File Multi Uploader
#-------------------------------------------------------------------------
*/

/** File Upload **/
if($("#images").length){
$("#images").fileinput({
		language: 'en',
    uploadAsync: false,
		showZoom: false,
    uploadUrl: path+"/ajax.php?pg=multiupload",
		allowedFileExtensions: ["jpg", "jpeg", "bmp", "png", "gif"],
		actionZoom: false
});

$('#images').on('fileuploaded', function(event, data) {
    console.log(event);
    console.log(data);
});

$('#images').on('filebatchuploadsuccess', function(event, data, previewId, index) {

		var dataUploaded = data.response.file_output;
		var i;
		for(i=0;i<dataUploaded.length;i++){
			if(dataUploaded[i].success === true){
				$('.pt-image-append').append('<div class=""><span class="pt-select-profile bg-o pt-btn tips"><i class="fas fa-user"></i><b>As profile</b></span><span class="pt-select-cover bg-gr pt-btn tips"><i class="fas fa-image"></i><b>As cover</b></span><img src="'+path+'/'+dataUploaded[i].path+'" title="'+dataUploaded[i].name+'"></div>');
				$('.pt-image-append').append('<input type="hidden" name="images_tmp[]" value="'+dataUploaded[i].path+'"/>');
			}
		}

		$(window).trigger('resize');
});
}

$('.pt-select-profile').livequery('click', function(){
	var vl = $(this).parent().find('img').attr('src');
	var ex = vl.match(/\/([^\/]+)\/?$/);
	$("[name=profile]").val(ex[1]);
	console.log(ex[1]);
});

$('.pt-select-cover').livequery('click', function(){
	var vl = $(this).parent().find('img').attr('src');
	var ex = vl.match(/\/([^\/]+)\/?$/);

	$("[name=cover]").val(ex[1]);
});


$(".pt-addExtra i").livequery("click", function(){

	var extra_id = 0;
	if($('div[class^="extra_"]').length){
		$('div[class^="extra_"]').each(function(){
	    var currentNum = parseInt($(this).attr('class').replace('extra_', ''), 10);
	    if(currentNum > extra_id) {
        extra_id = currentNum;
	    }
		});
	}

	extra_id = extra_id+1;

	$(this).parent().parent().append(
		'<div class="extra_'+extra_id+'">'+
			'<div class="form-row">'+
				'<div class="col-8">'+
					'<div class="form-group"><input type="text" name="extra['+extra_id+'][name]" placeholder="Name"></div>'+
				'</div>'+
				'<div class="col-4">'+
					'<div class="form-group"><input type="text" name="extra['+extra_id+'][price]" placeholder="Selling price" class="money"><i class="fas fa-minus-circle pt-removeExtra"></i></div>'+
				'</div>'+
			'</div>'+
		'</div>');
		$(window).trigger('resize');
});

$(".pt-removeExtra").livequery("click", function(){
	$(this).parent().parent().parent().parent().fadeOut().remove();
	$(window).trigger('resize');
});

$(".pt-addSize i").livequery("click", function(){

	var extra_id = 0;
	if($('div[class^="size_"]').length){
		$('div[class^="size_"]').each(function(){
	    var currentNum = parseInt($(this).attr('class').replace('size_', ''), 10);
	    if(currentNum > extra_id) {
        extra_id = currentNum;
	    }
		});
	}

	extra_id = extra_id+1;

	$(this).parent().parent().append(
		'<div class="size_'+extra_id+'">'+
			'<div class="form-row">'+
				'<div class="col-4">'+
					'<div class="form-group"><input type="text" name="size['+extra_id+'][name]" placeholder="Name"></div>'+
				'</div>'+
				'<div class="col-4">'+
					'<div class="form-group"><input type="text" name="size['+extra_id+'][price]" placeholder="Selling price" class="money"></div>'+
				'</div>'+
				'<div class="col-4">'+
					'<div class="form-group"><input type="text" name="size['+extra_id+'][reduce]" placeholder="price before reduce" class="money"><i class="fas fa-minus-circle pt-removeSize"></i>'+
				'</div>'+
			'</div>'+
		'</div>');
		$(window).trigger('resize');
});

$(".pt-removeSize").livequery("click", function(){
	$(this).parent().parent().parent().parent().fadeOut().remove();
	$(window).trigger('resize');
});



/*/ ####################################
		#####                          #####
		#####      1) Index          #####
		#####                          #####
		#################################### /*/


//- Send Password
$.puertosend("#sendpassword", "sendpassword", "alert");

//- Send User Details
$.puertosend(".pt-senduserdetails", "senduserdetails");

//- Send Testimonial
$.puertosend("#sendtestimonial", "sendtestimonial");

//- Send Withdraw
$.puertosend("#sendwithdraw", "sendwithdraw");

$(".pt-accept, .pt-refuse").on("click", function(){
	var ths = $(this);
	var id  = ths.data('id');
	var btxt = ths.html();
	var form = ths.attr("class").replace("pt-", "");

	ths.html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Loading..');

	$.get(path+"/ajax.php?pg=withdraw&request="+form+"&id="+id, function(puerto){
		setTimeout(function () {
			ths.html(btxt);
		}, 2000);
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		}
	}, 'json');
	return false;
});

$(".pt-itemhome").on("click", function(){
	var ths = $(this);
	var id  = ths.data('id');
	var btxt = ths.html();
	var form = ths.attr("class").replace("pt-", "");

	ths.html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Loading..');

	$.get(path+"/ajax.php?pg=itemhome&id="+id, function(puerto){
		setTimeout(function () {
			ths.html(btxt);
		}, 2000);
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		}
	}, 'json');
	return false;
});

$(".pt-lang a").on('click', function() {
	$.post(path+"/ajax.php?pg=lang", {id:$(this).attr('rel')}, function(puerto){ location.reload();});
});

$(document).ready(function(){
  $('.pt-scroll').scrollbar();
});

$("input[name=search]").on('keyup keydown change', function(){
	var th = $(this);
	var vl = $(this).val();

	$.post(path+"/ajax.php?pg=search", {search:vl}, function(puerto){
		$(".sresults").html(puerto);
		th.parent().find('ul').addClass("open");
	});
});


/*/ ####################################
		#####                          #####
		#####      1) Restaurant       #####
		#####                          #####
		#################################### /*/


//---------------------------------------------

//- Send Menu
$.puertosend("#sendmenu", "sendmenu", "alert");

//- Edit Menu
$(".pt-editmenulink").on("click", function(){
	var id = $(this).data("id");
	$.get(path+"/ajax.php?pg=editmenu&id="+id, function(puerto){
		if(puerto){
			$("input[name=name]").val(puerto.name);
			$("input[name=id]").val(puerto.id);
			$("select[name=rest]").val(puerto.restaurant);
			$('.selectpicker').selectpicker('refresh');
			$("#myModal").modal("show");
		}
	}, 'json');
	return false;
});

//- Delete Menu
$(".pt-delete").on("click", function(){
	if(confirm("Are you sure you want to delete?")){
		var th   = $(this);
		var id   = $(this).data("id");
		var type = $(this).data("type");
		$.get(path+"/ajax.php?pg=delete&id="+id+"&request="+type, function(puerto){
			if(puerto) th.parent().parent().parent().parent().fadeOut("slow", function(){ $(this).remove(); });
		});
	}
	return false;
});



//---------------------------------------------

//- Send Item
$.puertosend("#senditem", "senditem", "alert");


//---------------------------------------------
//- Sharts
$.barChart = function(ChartID, DataLabelss, DataCnts, DataClrs, DataTitle, DataType = 'bar'){
	new Chart(document.getElementById(ChartID), {
	    type: DataType, //horizontalBar
	    data: {
	      labels: DataLabelss,
	      datasets: [
	        {
	          label: DataTitle,
	          backgroundColor: DataClrs,
	          data: DataCnts
	        }
	      ]
	    },
	    options: {
	      legend: { display: false },
	      title: {
	        display: (DataTitle ? true : false),
	        text: DataTitle
	      },
				scales: {
	        xAxes: [{
            ticks: { beginAtZero: true }
	        }]
		    }
	    }
	});
}

$.lineChart = function(ChartID, DataLabelss, DataCnts, DataTitle){
	new Chart(document.getElementById(ChartID), {
		type: 'line',
		data: {
			labels: DataLabelss,
			datasets: [{
					data: DataCnts,
					label: false,
					borderColor: "#ff9f0e",
					backgroundColor: 'rgba(255, 159, 14, 0.52)'
				}
			]
		},
		options: {
			legend: {
					display: false
			},
			title: {
				display: (DataTitle ? true : false),
				text: DataTitle
			},
			scales: {
					xAxes: [{
							ticks: {
									autoSkip: false,
									maxRotation: 40,
									minRotation: 40
							}
					}]
			}
	}
	});
}

$.pieChart = function(DataId, DataLabels, DataCnt, DataClrs, DataTitle){
	new Chart(document.getElementById(DataId), {
    type: 'doughnut',
    data: {
      labels: DataLabels,
      datasets: [
        {
          label: "Partisipate of",
          backgroundColor: DataClrs,
          data: DataCnt
        }
      ]
    },
		options: {
			legend: { display: true },
			title: {
				display: (DataTitle ? true : false),
				text: DataTitle
			}
		}
	});
}


if($("#orders-os").length){
$.get(path+"/ajax.php?pg=orders-os&id="+$("#orders-os").attr('rel'), function(puerto) {

	var ass = JSON.parse(puerto);
	var DataLabelss = ass.labels;
	var DataCnts = ass.data;
	var DataTitle = ass.title;
	var DataClrs = ass.colors;

	$.barChart("orders-os", DataLabelss, DataCnts, DataClrs, DataTitle, 'horizontalBar');

});
}

if($("#orders-devices").length){
$.get(path+"/ajax.php?pg=orders-devices&id="+$("#orders-devices").attr('rel'), function(puerto) {

	var ass = JSON.parse(puerto);
	var DataLabelss = ass.labels;
	var DataCnts = ass.data;
	var DataTitle = ass.title;
	var DataClrs = ass.colors;

	$.pieChart("orders-devices", DataLabelss, DataCnts, DataClrs)

});
}

if($("#orders-cpgender").length){
$.get(path+"/ajax.php?pg=orders-cpgender", function(puerto) {

	var ass = JSON.parse(puerto);
	var DataLabelss = ass.labels;
	var DataCnts = ass.data;
	var DataTitle = ass.title;
	var DataClrs = ass.colors;

	$.pieChart("orders-cpgender", DataLabelss, DataCnts, DataClrs)

});
}

if($("#orders-cporders").length){
$.get(path+"/ajax.php?pg=orders-cporders&request=months", function(puerto) {
	var ass = JSON.parse(puerto);
	var DataLabelss = ass.labels;
	var DataCnts = ass.data;
	var DataTitle = ass.title;
	$.lineChart("orders-cporders", DataLabelss,DataCnts,DataTitle);

});
$(".ptcporders").on("click", function(){
	var ids = $(this).attr('rel');
	$.get(path+"/ajax.php?pg=orders-cporders&request="+ids, function(puerto) {
		var ass = JSON.parse(puerto);
		var DataLabelss = ass.labels;
		var DataCnts = ass.data;
		var DataTitle = ass.title;

		$.lineChart("orders-cporders", DataLabelss,DataCnts, DataTitle);
	});
	return false;
});
}

$(".pt-intheway, .pt-delivered.tips").on("click", function(){
	if(confirm("Are you sure?")){
		var id = $(this).data("id");
		var status = $(this).attr("class").replace("pt-", "").replace(" tips", "");
		var th = $(this);
		$(this).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>');

		$.get( path+"/ajax.php?pg=orderstatus&request="+status+"&id="+id, function(puerto){
			th.fadeOut();
			if(status == 'intheway'){
				th.parent().find(".pt-awaiting").html('<i class="fas fa-truck"></i> in the way').addClass("bg-v");
			}
			else {
				th.parent().find(".pt-awaiting").html('<i class="fas fa-check"></i> delivered').addClass("bg-gr");
			}
		});
	}
	return false;
});


/*/ ####################################
		#####                          #####
		#####      1) My Orders        #####
		#####                          #####
		#################################### /*/

//- Send Review
$.puertosend("#sendreview", "sendreview", "alert");

//- Review Click
$(".pt-additemreview").on("click", function(){
	var id   = $(this).data("id");
	$("input[name=id]").val(id);
	$("#myModal").modal("show");
	return false;
});

/*/ ####################################
		#####                          #####
		#####      1) Restaurants      #####
		#####                          #####
		#################################### /*/

if($("body.pt-cartpage").length){

var subtotal = parseFloat($(".pt-totalprice").text().replace(dollar_sign,""));
var alltotalprice = parseFloat($(".pt-alltotalprice").text().replace(dollar_sign,""));
var deliveryprice = 0;
var deliverytotalprice = parseFloat($(".pt-deliverytotalprice").text().replace(dollar_sign,""));

if($(".pt-deliveryprice").length){
	$(".pt-deliveryprice").each(function(){
		deliveryprice += parseFloat($(this).text().replace(dollar_sign,""));
	});
}

deliverytotalprice += deliverytotalprice + deliveryprice;
$(".pt-deliverytotalprice").text(dollar_sign+deliverytotalprice.toFixed(2));

var i = 0, ii = 0;
$(".pt-cart-body .pt-cart-body").each(function(){
	i++;
	var price = parseFloat($(this).find(".checked").text().replace(dollar_sign,""));
	var quantity = parseInt($(this).find("[name=item_quantity]").val());
	var extraPrice = 0;

	if($(this).find(".pt-extraprice").length){
		$(this).find(".pt-extraprice").each(function(){
			ii++;
			extraPrice += parseFloat($(this).text().replace(dollar_sign,""))*quantity;
		});
	}

	subtotal += price*quantity + extraPrice;


	$(".pt-totalprice").text(dollar_sign+subtotal.toFixed(2));
});

alltotalprice += subtotal+deliverytotalprice;
$(".pt-alltotalprice").text(dollar_sign+alltotalprice.toFixed(2));
$(".hidamount").val(alltotalprice.toFixed(2));

if(!$(".pt-cart-body .pt-cart-body").length)
	$(".col-8 .pt-cart-body").html("<div class='text-center'>No results!</div>");

$(".pt-removefromcart").on("click", function(){
	if(confirm("Are you sure?")){
		var par = $(this).parent().parent().parent().parent().parent().parent();
		var par1 = $(this).parent().parent().parent().parent().parent().parent().parent();
		var quantity = parseInt(par.find("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat(par.find(".checked").text().replace(dollar_sign,""));
		var extraPrice = 0;

		var alltotalprice = parseFloat($(".pt-alltotalprice").text().replace(dollar_sign,""));
		var deliveryprice = $(".pt-deliveryprice").length ? parseFloat(par.find(".pt-deliveryprice").text()) : 0;
		var deliverytotalprice = parseFloat($(".pt-deliverytotalprice").text().replace(dollar_sign,""));

		var extraIid = $(this).data("iid");
		var extraIiid = $(this).data("iiid");

		if(par.find(".pt-removeexratoitem").length){
			par.find(".pt-removeexratoitem").each(function(){
				extraPrice += parseFloat($(this).data("price"));
			});
		}

		total = (total-quantity*price-quantity*extraPrice).toFixed(2);

		totalId.text(dollar_sign+total);
		$(".pt-alltotalprice").text(dollar_sign+(alltotalprice-(quantity*price)-(quantity*extraPrice).toFixed(2)-deliveryprice).toFixed(2));
		$(".hidamount").val((alltotalprice-(quantity*price)-(quantity*extraPrice).toFixed(2)-deliveryprice).toFixed(2));
		$(".pt-deliverytotalprice").text(dollar_sign+(deliverytotalprice-deliveryprice).toFixed(2));


		$.post(path+"/ajax.php?pg=cartremoveitem", {extra_item: extraIid, extra_cart: extraIiid}, function(puerto){
			par.remove();
			if(!$(".pt-cart-body .pt-cart-body").length)
				$(".col-8 .pt-cart-body").html("<div class='text-center'>No results!</div>");
		});


	}
	return false;
});

$(".pt-plus").livequery("click", function(){
	var par = $(this).parent().parent().parent();
	var quantity = parseInt(par.find("[name=item_quantity]").val());
	var totalId = $(".pt-totalprice");
	var total = parseFloat(totalId.text().replace(dollar_sign,""));
	var price = parseFloat(par.find(".checked").text().replace(dollar_sign,""));
	var alltotalprice = parseFloat($(".pt-alltotalprice").text().replace(dollar_sign,""));
	var extraPrice = 0;
	if(par.find(".pt-removeexratoitem").length){
		par.find(".pt-removeexratoitem").each(function(){
			extraPrice += parseFloat($(this).data("price"));
		});
	}

	if(quantity > 0){
		var extraPriceBe = quantity*extraPrice;
		quantity = quantity+1;
		par.find("[name=item_quantity]").val(quantity);

		total = (total+price-extraPriceBe+quantity*extraPrice).toFixed(2);

		totalId.text(dollar_sign+total);
		$(".pt-alltotalprice").text(dollar_sign+(alltotalprice+price-extraPriceBe+quantity*extraPrice).toFixed(2));
		$(".hidamount").val((alltotalprice+price-extraPriceBe+quantity*extraPrice).toFixed(2));
		var item_id = $(this).data('i');
		var item_aid = $(this).data('a');
		$.post(path+"/ajax.php?pg=cartquantitychange", {item_id:item_id, item_aid: item_aid, qnt: quantity}, function(puerto){
		});
	}
});

$(".pt-minus").livequery("click", function(){

		var par = $(this).parent().parent().parent();
		var quantity = parseInt(par.find("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat(par.find(".checked").text().replace(dollar_sign,""));
		var alltotalprice = parseFloat($(".pt-alltotalprice").text().replace(dollar_sign,""));
		var extraPrice = 0;
		if(par.find(".pt-removeexratoitem").length){
			par.find(".pt-removeexratoitem").each(function(){
				extraPrice += parseFloat($(this).data("price"));
			});
		}

		if(quantity > 1){
			var extraPriceBe = quantity*extraPrice;
			quantity = quantity-1;
			par.find("[name=item_quantity]").val(quantity);

			total = (total-price-extraPriceBe+quantity*extraPrice).toFixed(2);

			totalId.text(dollar_sign+total);
			$(".pt-alltotalprice").text(dollar_sign+(alltotalprice-price-extraPriceBe+quantity*extraPrice).toFixed(2));
			$(".hidamount").val((alltotalprice-price-extraPriceBe+quantity*extraPrice).toFixed(2));

			var item_id = $(this).data('i');
			var item_aid = $(this).data('a');
			$.post(path+"/ajax.php?pg=cartquantitychange", {item_id:item_id, item_aid: item_aid, qnt: quantity}, function(puerto){
			});
		}

});


	$(".pt-removeexratoitem").livequery("click", function(){
		if(confirm("Are you sure?")){
			var par = $(this).parent().parent().parent();
			var quantity = parseInt(par.find("[name=item_quantity]").val());
			var totalId = $(".pt-totalprice");
			var total = parseFloat(totalId.text().replace(dollar_sign,""));
			var price = parseFloat($(this).data("price"));
			var extraId = $(this).data("id");
			var extraIid = $(this).data("iid");
			var extraIiid = $(this).data("iiid");
			var alltotalprice = parseFloat($(".pt-alltotalprice").text().replace(dollar_sign,""));

			total = (total-price*quantity).toFixed(2);
			alltotalprice = (alltotalprice-price*quantity).toFixed(2);

			totalId.text(dollar_sign+total);
			$("[name=item_price]").val(total);
			$(".pt-alltotalprice").text(dollar_sign+alltotalprice);
			$(".hidamount").val(alltotalprice);

			$.post(path+"/ajax.php?pg=cartremoveextra", {extra_id:extraId, extra_item: extraIid, extra_cart: extraIiid}, function(puerto){
			});
			$(this).parent().remove();

		}

	});


}


/*/ ####################################
		#####                          #####
		#####   1) Send Item To Cart   #####
		#####                          #####
		#################################### /*/


$("[name=item_size]").livequery("click", function(){
	var price = $(this).data("price");
	var totalId = $(".pt-totalprice");
	var total = parseFloat(totalId.text().replace(dollar_sign,""));
	var minus = $(this).parent().parent().find(".checked");
	var quantity = parseInt($("[name=item_quantity]").val());

	if(!$(this).hasClass("checked")){
		price = price*quantity;
		var minuss = minus.data("price")*quantity;
		total = (total-minuss+price).toFixed(2);

		$(this).addClass("checked");
		minus.removeClass("checked");
		totalId.text(dollar_sign+total);
		$("[name=item_price]").val(total);
	}
});

if(!$("body.pt-cartpage").length){
	$(".pt-plus").livequery("click", function(){
		var quantity = parseInt($("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat($(".checked").data("price"));
		var extraPrice = 0;
		if($(".pt-removeexratoitem").length){
			$(".pt-removeexratoitem").each(function(){
				extraPrice += parseFloat($(this).data("price"));
			});
		}

		if(quantity > 0){
			var extraPriceBe = quantity*extraPrice;
			quantity = quantity+1;
			$("[name=item_quantity]").val(quantity);
			$("[name=item_quantities]").val(quantity);

			total = (total+price-extraPriceBe+quantity*extraPrice).toFixed(2);

			totalId.text(dollar_sign+total);
			$("[name=item_price]").val(total);
		}
	});

	$(".pt-minus").livequery("click", function(){
		var quantity = parseInt($("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat($(".checked").data("price"));
		var extraPrice = 0;
		if($(".pt-removeexratoitem").length){
			$(".pt-removeexratoitem").each(function(){
				extraPrice += parseFloat($(this).data("price"));
			});
		}

		if(quantity > 1){
			var extraPriceBe = quantity*extraPrice;
			quantity = quantity-1;
			$("[name=item_quantity]").val(quantity);
			$("[name=item_quantities]").val(quantity);

			total = (total-price-extraPriceBe+quantity*extraPrice).toFixed(2);

			totalId.text(dollar_sign+total);
			$("[name=item_price]").val(total);
		}
	});

	$(".pt-addexratoitem").livequery("click", function(){
		var quantity = parseInt($("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat($(this).data("price"));
		var extraId = $(this).data("id");

		total = (total+price*quantity).toFixed(2);

		totalId.text(dollar_sign+total);
		$("[name=item_price]").val(total);

		$(this).attr("class", "pt-removeexratoitem");
		$(this).find("i").attr("class", "fas fa-minus-circle");
		$('[name=item_quantities]').after('<input type="hidden" name="item_extra[]" value="'+extraId+'" rel="">');

	});

	$(".pt-removeexratoitem").livequery("click", function(){
		var quantity = parseInt($("[name=item_quantity]").val());
		var totalId = $(".pt-totalprice");
		var total = parseFloat(totalId.text().replace(dollar_sign,""));
		var price = parseFloat($(this).data("price"));
		var extraId = $(this).data("id");

		total = (total-price*quantity).toFixed(2);

		totalId.text(dollar_sign+total);
		$("[name=item_price]").val(total);

		$(this).attr("class", "pt-addexratoitem");
		$(this).find("i").attr("class", "fas fa-plus-circle");
		$('[name="item_extra[]"][value='+extraId+']').remove();

	});
}


//- Show item to cart modal
$(".pt-addtocart").on("click", function(){
	var id = $(this).data("id");
	$.get(path+"/ajax.php?pg=getmodalitem&id="+id, function(puerto){
		$("#pt-getmodalitem").html(puerto);
	});
});


//- Add item to cart
$(".pt-buytocart, .pt-buy").livequery("click", function(){
	var buy = $(this).data("buy");
	$.post(path+"/ajax.php?pg=addtocart", $("#senditemtocart").serialize(), function(puerto){
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
			if(buy){
				setTimeout(function () {
					$(location).attr('href', path+"/cart.php");
				}, 1000);
			}
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
	}, 'json');

	return false;
});

//- Send order to paypal
$.puertosend("#sendpaypalitem", "sendpaypalitem");

/*/ ####################################
		#####                          #####
		#####      1) Login page       #####
		#####                          #####
		#################################### /*/

$.puertosend("#sendsignin", "login", "alert");
$.puertosend("#sendsignup", "sendsignup", "alert");




$.puertosend("#sendsubscribe", "sendsubscribe");
$.puertosend("#sendplans", "sendplans");

$.puertosend("#sendrestaurant", "sendrestaurant");

//- Send order to paypal
$.puertosend(".sendpaypalplan", "sendpaypalplan");

/** Logout **/
$('.pt-logout').on('click', function(){
	if(confirm(lang['alerts']['logout'])){
		$.post(path+"/ajax.php?pg=logout", {type: 1}, function(puerto){
			$(location).attr('href', path+'/index.php');
		});
	}
});


$('.pt-addinvoice').livequery('click', function(){

	var title = $(this).data("name");
	var id = $(this).data("id");
	var element = document.getElementById("invoice_"+id);

	var mode = 'avoid-all';
	var pagebreak = (mode === 'specify') ?
			{ mode: '', before: '.before', after: '.after', avoid: '.avoid' } :
			{ mode: mode };

	html2pdf().from(element).set({
		filename: title + '.pdf',
		margin: 1,
		pagebreak: 'legacy',
		jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
	}).save();

	return false;
});




$('.pt-resaurant .pt-title').on("click", function(){
	var th = $(this);
	if(th.hasClass('active')){
		th.removeClass("active");
		th.parent().removeClass("open");
		th.find('i').attr('class','fas fa-plus-circle');
	} else {
		th.addClass("active");
		th.parent().addClass("open");
		th.find('i').attr('class','fas fa-minus-circle');
	}

	$(window).trigger('resize');
	return false;

});



$.puertoAnswerImage = function(id, choose, thumb, thumb2, crop = true){
	var id = id, choose = choose, name = $("input[rel='"+id+"']"), thumb = thumb;
	$(id).imageUploader({
	  fileField: choose,
	  urlField: '#url',
	  hideFileField: false,
	  hideUrlField: false,
	  url: path+'/ajax.php?pg=imageupload'+(!crop ? '&request=crop' : ''),
	  thumbnails: {
	    div: thumb,
	    crop: 'zoom',
	    width: 150,
	    height: 150
	  },
	  afterUpload: function (data) { console.log('after uploadee', data); name.val(data); $(thumb2).attr("src",data); },
	  onFileAdded: function(file)        { console.log(file); },
	  onFilesSelected: function()        { console.log('file selected'); },
	  onUrlSelected: function()          { console.log('url selected'); },
	  onDragStart: function(event)       { console.log(event); },
	  onDragEnd: function(event)         { console.log(event); },
	  onDragEnter: function(event)       { console.log(event); },
	  onDragLeave: function(event)       { console.log(event); },
	  onDragOver: function(event)        { console.log(event); },
	  onDrop: function(event)            { console.log(event); },
	  onUploadProgress: function(event)  { console.log(event);console.log("p - "+event+"\n"); },
	  beforeUpload: function()           { console.log('before upload'); $(thumb).html(""); return true; },
	  error: function(msg) { alert(msg); },
	});
}

$.puertoAnswerImage('#dropZone', '#chooseFile', '#thumbnails', '#thumbnails');




/*/ ####################################
		#####                          #####
		#####     1) User Details      #####
		#####                          #####
		#################################### /*/


$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});

/*/ ####################################
		#####                          #####
		#####        1) Admin          #####
		#####                          #####
		#################################### /*/


//- Settings
$.puertoAnswerImage('#dropZone1', '#chooseFile1', '#thumbnails1', '#thumbnails1', false);
$.puertoAnswerImage('#dropZone2', '#chooseFile2', '#thumbnails2', '#thumbnails2', false);


//- Edit Cuisine
$(".pt-editcuisinelink").on("click", function(){
	var id = $(this).data("id");
	$.get(path+"/ajax.php?pg=editcuisine&id="+id, function(puerto){
		if(puerto){
			$("input[name=name]").val(puerto.name);
			$("input[name=id]").val(puerto.id);
			$("input[name=image]").val(puerto.image);
			$("#myModal").modal("show");
		}
	}, 'json');
	return false;
});

$.puertosend("#sendcuisine", "sendcuisine", "alert");

//- Publish/Unpublish Testimonial
$(".pt-testimonialstatus").on("click", function(){
	if(confirm("Are you sure you want to change status?")){
		var th   = $(this);
		var id   = $(this).data("id");
		var type = $(this).data("type");
		$.get(path+"/ajax.php?pg=testimonialstatus&id="+id+"&request="+type, function(puerto){
			location.reload();
		});
	}
	return false;
});


$.puertosend("#sendpage", "sendpage");
$.puertosend(".pt-sendsettings", "sendsettings");

//- Wysibb Editor

if($("#wysibb-editor").length){
	var textarea = document.getElementById('wysibb-editor');
	sceditor.create(textarea, {
		format: 'bbcode',
		style: path+'/js/minified/themes/content/default.min.css',
		emoticonsRoot: path+'/js/minified/',
		height: 400,
		toolbarExclude: 'indent,outdent,email,date,time,ltr,rtl,print,subscript,superscript,table,code,quote,emoticon',
		icons: 'material',
	});
	var body = sceditor.instance(textarea).getBody();
	sceditor.instance(textarea).keyUp(function(e) {
		var val = sceditor.instance(textarea).val();
		sceditor.instance(textarea).updateOriginal();
	});
}


} ( jQuery ) )
