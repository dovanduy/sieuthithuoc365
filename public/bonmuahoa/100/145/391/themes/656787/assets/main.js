$(document).ready(function ($) {
	"use strict";
	awe_backtotop();
	awe_owl();
	awe_category();

	awe_tab();

	$('.product_box_item .time').each(function(e){
		awe_countDown($(this));
	})

	if(navigator.userAgent.indexOf("Speed Insights") == -1) {
		awe_lazyloadImage();
	}

});


/********************************************************
# Countdown
********************************************************/
function awe_countDown(selector){
	// Set the date we're counting down to
	// Kiểu thời gian đặt tag endtime_4/15/2018 15:10:00
	var dataTime = selector.attr('data-time');
	var countDownDate = new Date(dataTime).getTime();
	// Update the count down every 1 second
	var x = setInterval(function() {
		// Get todays date and time
		var now = new Date().getTime();
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		// Display the result in the element
		selector.html("<span>"+days+"<p>Ngày</p></span>" +"<span>"+hours+"<p>Giờ</p></span>" + "<span>"+minutes+"<p>Phút</p></span>" + "<span>"+seconds+"<p>Giây</p></span>");
		// If the count down is finished, write some text
		if (distance < 0) {
			clearInterval(x);
			selector.html("Hết hạn");
		}
	}, 1000);
}

/********************************************************
# LazyLoad
********************************************************/
function awe_lazyloadImage(){
	var i = $("[data-lazyload]");
	i.length > 0 && i.each(function() {
		var i = $(this), e = i.attr("data-lazyload");
		i.appear(function() {
			i.removeAttr("height").attr("src", e);
		}, {
			accX: 0,
			accY: 120
		}, "easeInCubic");
	});
	var e = $("[data-lazyload2]");
	e.length > 0 && e.each(function() {
		var i = $(this), e = i.attr("data-lazyload2");
		i.appear(function() {
			i.css("background-image", "url(" + e + ")");
		}, {
			accX: 0,
			accY: 120
		}, "easeInCubic");
	});
} window.awe_lazyloadImage=awe_lazyloadImage;


$(window).on("load resize",function(e){	
	setTimeout(function(){					 
		awe_owl();
		$('.owl_product_mini').removeClass('timeout');
	},200);
});
$(document).on('click','.overlay, .close-popup, .btn-continue, .fancybox-close', function() {   
	awe_hidePopup('.awe-popup'); 	
	setTimeout(function(){
		$('.loading').removeClass('loaded-content');
	},500);
	return false;
})


function awe_currency(str){	
	str = str.replace('$','');
	str = str.replace('.00','');			
	str = str.replace('.','xxx');
	str = str.replace(',','.');
	str = str.replace('xxx',',');									
	return str;
}window.awe_currency=awe_currency;


$(document).ready(function(){
	var wDW = $(window).width();
	/*Footer*/
	if(wDW > 767){
		$('.toggle-mn').show();
	}else {
		$('.footer-click > .cliked').click(function(){
			$(this).toggleClass('open_');
			$(this).next('ul').slideToggle("fast");
			$(this).next('div').slideToggle("fast");
		});
	}
	if (wDW < 991) {
		$(".filter-group li span label").click(function(){
			$('.dqdt-sidebar').removeClass('openf');
			$('.open-filters').removeClass('openf');
			$('.opacity_filter').removeClass('opacity_filter_true');
		});
		$('.opacity_filter').click(function(e){
			$('.dqdt-sidebar').removeClass('openf');
			$('.open-filters').removeClass('openf');
			$('.opacity_filter').removeClass('opacity_filter_true');
		});
	}
	if (wDW > 992) {
		$(".button_clicked").click(function(){ 
			$('.search_pc').slideToggle('fast');
		})
	}
});


/*Show hide Recoverpass*/
$('.recv-text #rcv-pass').click(function(){
	$('.form_recover_').slideToggle('500');
});
/*End*/

$('.cate_padding  li .fa').click(function() {
	$(this).closest('li').find('> ul').slideToggle("fast");
	$(this).closest('i').toggleClass('fa-caret-down fa-caret-up');
	return false;              
}); 



/*Open filter*/
$('.open-filters').click(function(e){
	e.stopPropagation();
	$(this).toggleClass('openf');
	$('.opacity_filter').toggleClass('opacity_filter_true');
	$('.dqdt-sidebar').toggleClass('openf');
});



$('.opacity_menu').click(function(e){
	$('.menu_mobile').removeClass('open_sidebar_menu');
	$('.opacity_menu').removeClass('open_opacity');
});
$('.ct-mobile li .ti-plus').click(function() {
	$(this).closest('li').find('> .sub-menu').slideToggle("fast");
	$(this).closest('i').toggleClass('show_open hide_close');
	return false;              
});

/********************************************************
# MENU MOBILE
********************************************************/
function awe_menumobile(){
	$('.menu-bar').click(function(e){
		e.preventDefault();
		$('#nav').toggleClass('open');
	});
	$('#nav .fa').click(function(e){		
		e.preventDefault();
		$(this).parent().parent().toggleClass('open');
	});
} window.awe_menumobile=awe_menumobile;

$(document).ready(function(){
	$("#nav-mobile").mmenu();
});
/*End*/

function validate(evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

$(".hover").mouseleave(
	function () {
		$(this).removeClass("hover");
	}
);

/*Chi cho nhap so tu 1*/
var t = false

$('.check_number_here').focus(function () {
	var $this = $(this)
	t = setInterval(
		function () {
			if (($this.val() < 1 || $this.val() > 10) && $this.val().length != 0) {
				if ($this.val() < 1) {
					$this.val(1)
				}
				if ($this.val() > 10) {
					$this.val(10)
				}
			}
		}, 50)
})

$('.check_number_here').blur(function () {
	if (t != false) {
		window.clearInterval(t)
		t = false;
	}
})


/*Double click go to link menu*/
var wDWs = $(window).width();
if (wDWs < 1199) {
	$('.ul_menu li:has(ul)' ).doubleTapToGo();
	$('.nav_1 li:has(ul)' ).doubleTapToGo();
}

$('a.btn-support').click(function(e){
	e.stopPropagation();
	$('.support-content').slideToggle();
});
$('.support-content').click(function(e){
	e.stopPropagation();
});
$(document).click(function(){
	$('.support-content').slideUp();
});
/*dang ky*/
$(".accept_submit input").click(function() {
	if($(this).is(":checked"))
	{
		$('.button_register').removeAttr('disabled');
	}else {
		$('.button_register').attr('disabled', 'disabled');
	}
});




/********************************************************
Search header
********************************************************/
$('body').click(function(event) {
	if (!$(event.target).closest('.collection-selector').length) {
		$('.list_search').css('display','none');
	};
});
/* top search */

$('.search_text').click(function(){
	$(this).next().slideToggle(200);
	$('.list_search').show();
})

$('.list_search .search_item').on('click', function (e) {
	$('.list_search').hide();

	var optionSelected = $(this);

	/*
  var id = optionSelected.attr('data-coll-id');
  var handle = optionSelected.attr('data-coll-handle');
  var coll_name = optionSelected.attr('data-coll-name');
  */

	var title = optionSelected.text();
	//var filter = '(collectionid:product' + (id == 0 ? '>=0' : ('=' + id)) + ')';


	//console.log(coll_name);
	$('.search_text').text(title);

	/*
  $('.ultimate-search .collection_id').val(filter);
  $('.ultimate-search .collection_handle').val(handle);
  $('.ultimate-search .collection_name').val(coll_name);
  */

	$(".search-text").focus();
	optionSelected.addClass('active').siblings().removeClass('active');
	//console.log($('.kd_search_text').innerWidth());


	//$('.list_search').slideToggle(0);

	/*
  sessionStorage.setItem('last_search', JSON.stringify({
    title: title,
    handle: handle,
    filter: filter,
    name: coll_name
  }));
  */  
});


$('.header_search form button').click(function(e) {
	e.preventDefault();

	searchCollection();
	setSearchStorage('.header_search form');

});

$('#mb_search').click(function(){
	$('.mb_header_search').slideToggle('fast');
});

$('.fi-title.drop-down').click(function(){
	$(this).toggleClass('opentab');
});

function searchCollection() {
	var collectionId = $('.list_search .search_item.active').attr('data-coll-id');
	var vl = $('.header form input').val();
	var searchVal = $('.header_search input[type="search"]').val();
	var url = '';
	if(collectionId == 0 || vl == '') {
		url = '/search?q='+ searchVal;
	}
	else {
		url = '/search?q=collections:'+ collectionId +' AND name:' + searchVal;
		/*
    if(searchVal != '') {
      url = '/search?type=product&q=' + searchVal + '&filter=(collectionid:product=' + collectionId + ')';
    }
    else {
      url = '/search?type=product&q=filter=(collectionid:product=' + collectionId + ')';
    }
    */
	}
	window.location=url;
}
/*** Search Storage ****/

function setSearchStorage(form_id) {
	var seach_input = $(form_id).find('.search-text').val();
	var search_collection = $(form_id).find('.list_search .search_item.active').attr('data-coll-id');
	sessionStorage.setItem('search_input', seach_input);
	sessionStorage.setItem('search_collection', search_collection);
}
function getSearchStorage(form_id) {
	var search_input_st = ''; // sessionStorage.getItem('search_input');
	var search_collection_st = ''; // sessionStorage.getItem('search_collection');
	if(sessionStorage.search_input != '') {
		search_input_st = sessionStorage.search_input;
	}
	if(sessionStorage.search_collection != '') {
		search_collection_st = sessionStorage.search_collection;
	}
	$(form_id).find('.search-text').val(search_input_st);
	$(form_id).find('.search_item[data-coll-id="'+search_collection_st+'"]').addClass('active').siblings().removeClass('active');
	var search_key = $(form_id).find('.search_item[data-coll-id="'+search_collection_st+'"]').text();
	if(search_key != ''){
		var searchVal = $('.header_search input[type="search"]').val();
		$(form_id).find('.collection-selector .search_text').text(search_key);
		$('.search_item_name').text(searchVal + " thuộc danh mục " + search_key);
		console.log(search_key);
	}
	//$(form_id).find('.search_collection option[value="'+search_collection_st+'"]').prop('selected', true);
}
function resetSearchStorage() {
	sessionStorage.removeItem('search_input');
	sessionStorage.removeItem('search_collection');
}
$(window).load(function() {
	getSearchStorage('.header_search form');
	resetSearchStorage();
});
/*
$(document).ready(function (){
 var str = $('.search_item_name').text();
	var searchVal = $('.header_search input[type="search"]').val();
 $('.search_item_name').text(searchVal);
});
*/


/********************************************************
# SHOW NOITICE
********************************************************/
function awe_showNoitice(selector) {
	$(selector).animate({right: '0'}, 500);
	setTimeout(function() {
		$(selector).animate({right: '-300px'}, 500);
	}, 3500);
}  window.awe_showNoitice=awe_showNoitice;

/********************************************************
# SHOW LOADING
********************************************************/
function awe_showLoading(selector) {
	var loading = $('.loader').html();
	$(selector).addClass("loading").append(loading); 
}  window.awe_showLoading=awe_showLoading;

/********************************************************
# HIDE LOADING
********************************************************/
function awe_hideLoading(selector) {
	$(selector).removeClass("loading"); 
	$(selector + ' .loading-icon').remove();
}  window.awe_hideLoading=awe_hideLoading;

/********************************************************
# SHOW POPUP
********************************************************/
function awe_showPopup(selector) {
	$(selector).addClass('active');
}  window.awe_showPopup=awe_showPopup;

/********************************************************
# HIDE POPUP
********************************************************/
function awe_hidePopup(selector) {
	$(selector).removeClass('active');
}  window.awe_hidePopup=awe_hidePopup;

/********************************************************
# CONVERT VIETNAMESE
********************************************************/
function awe_convertVietnamese(str) { 
	str= str.toLowerCase();
	str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
	str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
	str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
	str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
	str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
	str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
	str= str.replace(/đ/g,"d"); 
	str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
	str= str.replace(/-+-/g,"-");
	str= str.replace(/^\-+|\-+$/g,""); 
	return str; 
} window.awe_convertVietnamese=awe_convertVietnamese;

/********************************************************
# RESIDE IMAGE PRODUCT BOX
********************************************************/
function awe_resizeimage() { 

} window.awe_resizeimage=awe_resizeimage;

/********************************************************
# SIDEBAR CATEOGRY
********************************************************/
function awe_category(){
	$('.nav-category .fa-angle-down').click(function(e){
		$(this).parent().toggleClass('active');
	});
} window.awe_category=awe_category;

/********************************************************
# ACCORDION
********************************************************/
function awe_accordion(){
	$('.accordion .nav-link').click(function(e){
		e.preventDefault;
		$(this).parent().toggleClass('active');
	})
} window.awe_accordion=awe_accordion;

/********************************************************
# OWL CAROUSEL
********************************************************/
function awe_owl() { 
	$('.owl-carousel:not(.not-dqowl)').each( function(){
		var xs_item = $(this).attr('data-xs-items');
		var md_item = $(this).attr('data-md-items');
		var lg_item = $(this).attr('data-lg-items');
		var sm_item = $(this).attr('data-sm-items');	
		var margin=$(this).attr('data-margin');
		var dot=$(this).attr('data-dot');
		var nav=$(this).attr('data-nav');
		var height=$(this).attr('data-height');
		var play=$(this).attr('data-play');
		var loop=$(this).attr('data-loop');
		if (typeof margin !== typeof undefined && margin !== false) {    
		} else{
			margin = 30;
		}
		if (typeof xs_item !== typeof undefined && xs_item !== false) {    
		} else{
			xs_item = 1;
		}
		if (typeof sm_item !== typeof undefined && sm_item !== false) {    

		} else{
			sm_item = 3;
		}	
		if (typeof md_item !== typeof undefined && md_item !== false) {    
		} else{
			md_item = 3;
		}
		if (typeof lg_item !== typeof undefined && lg_item !== false) {    
		} else{
			lg_item = 3;
		}
		if (typeof dot !== typeof undefined && dot !== true) {   
			dot= true;
		} else{
			dot = false;
		}
		$(this).owlCarousel({
			loop:loop,
			margin:Number(margin),
			responsiveClass:true,
			dots:dot,
			nav:nav,
			autoplay:play,
			autoplayTimeout:3000,
			autoplayHoverPause:true,
			autoHeight:false,
			responsive:{
				0:{
					items:Number(xs_item)				
				},
				600:{
					items:Number(sm_item)				
				},
				1000:{
					items:Number(md_item)				
				},
				1200:{
					items:Number(lg_item)				
				}
			}
		})
	})
} window.awe_owl=awe_owl;

/*OWL DETAILS*/



/********************************************************
# BACKTOTOP
********************************************************/
function awe_backtotop() { 
	/* Back to top */
	if ($('#back-to-top').length) {
		var scrollTrigger = 200, // px
			backToTop = function () {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > scrollTrigger) {
					$('#back-to-top').addClass('show');
				} else {
					$('#back-to-top').removeClass('show');
				}
			};
		backToTop();
		$(window).on('scroll', function () {
			backToTop();
		});
		$('#back-to-top').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});
	}
} window.awe_backtotop=awe_backtotop;


/********************************************************
# TAB
********************************************************/
function awe_tab() {
	$(".e-tabs:not(.not-dqtab)").each( function(){
		$(this).find('.tabs-title li:first-child').addClass('current');
		$(this).find('.tab-content').first().addClass('current');

		$(this).find('.tabs-title li').click(function(){
			var tab_id = $(this).attr('data-tab');
			var url = $(this).attr('data-url');
			$(this).closest('.e-tabs').find('.tab-viewall').attr('href',url);
			$(this).closest('.e-tabs').find('.tabs-title li').removeClass('current');
			$(this).closest('.e-tabs').find('.tab-content').removeClass('current');
			$(this).addClass('current');
			$(this).closest('.e-tabs').find("#"+tab_id).addClass('current');
		});    
	});
} window.awe_tab=awe_tab;


// Create tab

$(".not-dqtab").each( function(e){
	var $this1 = $(this);
	var $this2 = $(this);
	var datasection = $this1.closest('.not-dqtab').attr('data-section');
	$this1.find('.tabs-title li:first-child').addClass('current');
	$this1.find('.tab-content').first().addClass('current');

	var datasection = $this2.closest('.not-dqtab').attr('data-section');
	$this2.find('.tabs-title li:first-child').addClass('current');
	$this2.find('.tab-content').first().addClass('current');

	var _this = $(this).find('.wrap_tab .button_show_tab');
	var droptab = $(this).find('.link_tab_check_click');

	$(_this).click(function(){ 
		if ($(droptab).hasClass('opensit')) {
			$(droptab).addClass('closeit').removeClass('opensit');
		}else {
			$(droptab).addClass('opensit').removeClass('closeit');
		}
	});

	/*type 1*/
	$this1.find('.tabtitle1.ajax li').click(function(){
		$(droptab).addClass('closeit').removeClass('opensit');

		var $this2 = $(this),
			tab_id = $this2.attr('data-tab'),
			url = $this2.attr('data-url');
		var etabs = $this2.closest('.e-tabs');
		etabs.find('.tab-viewall').attr('href',url);
		etabs.find('.tabs-title li').removeClass('current');
		etabs.find('.tabcontent_ajaxType1').removeClass('current');
		$this2.addClass('current');
		etabs.find("."+tab_id).addClass('current');
		//Nếu đã load rồi thì không load nữa
		if(!$this2.hasClass('has-content')){
			$this2.addClass('has-content');		
			getContentTab(url,"."+ datasection+" ."+tab_id);
		}
	});

	/*type 2*/
	$this2.find('.tabtitle2.ajax li').click(function(){
		$(droptab).addClass('closeit').removeClass('opensit');

		var $this2 = $(this),
			tab_id = $this2.attr('data-tab'),
			url = $this2.attr('data-url');
		var etabs = $this2.closest('.e-tabs');
		etabs.find('.tab-viewall').attr('href',url);
		etabs.find('.tabs-title li').removeClass('current');
		etabs.find('.tabcontent_ajaxType2').removeClass('current');
		$this2.addClass('current');
		etabs.find("."+tab_id).addClass('current');
		//Nếu đã load rồi thì không load nữa
		if(!$this2.hasClass('has-content')){
			$this2.addClass('has-content');		
			getContentTabTypeTwo(url,"."+ datasection+" ."+tab_id);
		}
	});
});



// Get content cho tab kieu 1
function getContentTab(url,selector){
	url = url+"?view=ajaxload";

	var dataLgg = $(selector).parent().find('.tab-1 .owl-carousel').attr('data-lgg-items');
	var loadding = '<div class="a-center"><svg height=30px style="enable-background:new 0 0 50 50"version=1.1 viewBox="0 0 24 30"width=24px x=0px xml:space=preserve xmlns=http://www.w3.org/2000/svg xmlns:xlink=http://www.w3.org/1999/xlink y=0px><rect fill=#333 height=10 opacity=0.2 width=4 x=0 y=10><animate attributeName=opacity attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect><rect fill=#333 height=10 opacity=0.2 width=4 x=8 y=10><animate attributeName=opacity attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect><rect fill=#333 height=10 opacity=0.2 width=4 x=16 y=10><animate attributeName=opacity attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect></svg></div>';

	$.ajax({
		type: 'GET',
		url: url,
		beforeSend: function() {
			$(selector).html(loadding);
		},
		success: function(data) {
			var content = $(data);
			$(selector).html(content.html());
			awe_lazyloadImage();
			loadOwl(selector,dataLgg);
			$('.add_to_cart').click(function(e){
				e.preventDefault();
				var $this = $(this);						   
				var form = $this.parents('form');						   
				$.ajax({
					type: 'POST',
					url: '/cart/add.js',
					async: false,
					data: form.serialize(),
					dataType: 'json',
					error: addToCartFail,
					beforeSend: function() {  
						if(window.theme_load == "icon"){
							awe_showLoading('.btn-addToCart');
						} else{
							awe_showPopup('.loading');
						}
					},
					success: addToCartSuccess,
					cache: false
				});
			});
			//Fix app
			if(window.BPR)
				return window.BPR.initDomEls(), window.BPR.loadBadges();
		},
		dataType: "html"
	});
}

// Get content cho tab kieu 2
function getContentTabTypeTwo(url,selector){
	url = url+"?view=ajaxloadTwo";

	var dataLgg = $(selector).parent().find('.tab-1 .owl-carousel').attr('data-lgg-items');
	var loadding = '<div class="a-center"><svg height=30px style="enable-background:new 0 0 50 50"version=1.1 viewBox="0 0 24 30"width=24px x=0px xml:space=preserve xmlns=http://www.w3.org/2000/svg xmlns:xlink=http://www.w3.org/1999/xlink y=0px><rect fill=#333 height=10 opacity=0.2 width=4 x=0 y=10><animate attributeName=opacity attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect><rect fill=#333 height=10 opacity=0.2 width=4 x=8 y=10><animate attributeName=opacity attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0.15s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect><rect fill=#333 height=10 opacity=0.2 width=4 x=16 y=10><animate attributeName=opacity attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="0.2; 1; .2"/><animate attributeName=height attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="10; 20; 10"/><animate attributeName=y attributeType=XML begin=0.3s dur=0.6s repeatCount=indefinite values="10; 5; 10"/></rect></svg></div>';

	$.ajax({
		type: 'GET',
		url: url,
		beforeSend: function() {
			$(selector).html(loadding);
		},
		success: function(data) {
			var content = $(data);
			$(selector).html(content.html());
			awe_lazyloadImage();
			loadOwlTwo(selector,dataLgg);
			$('.add_to_cart').click(function(e){
				e.preventDefault();
				var $this = $(this);						   
				var form = $this.parents('form');						   
				$.ajax({
					type: 'POST',
					url: '/cart/add.js',
					async: false,
					data: form.serialize(),
					dataType: 'json',
					error: addToCartFail,
					beforeSend: function() {  
						if(window.theme_load == "icon"){
							awe_showLoading('.btn-addToCart');
						} else{
							awe_showPopup('.loading');
						}
					},
					success: addToCartSuccess,
					cache: false
				});
			});
			//Fix app
			if(window.BPR)
				return window.BPR.initDomEls(), window.BPR.loadBadges();
		},
		dataType: "html"
	});
}

// Ajax carousel
function loadOwl(selector,dataLgg) {
	var owl = $('.owl_mobile'),
		owlOptions = {
			loop: false,
			margin: 15,
			nav: true,
			navText: ['<i class="prev-icon"></i>','<i class="next-icon"></i>'],
			dots: false,
			responsiveClass:true,
			responsive:{
				0	: { items: 1 },
				543	: { items: 1 },
				768	: { items: 3 },
				992	: { items: 3 }
			}
		};

	if ( $(window).width() > 315 ) {
		var owlActive = owl.owlCarousel(owlOptions);
	} else {
		owl.addClass('off');
	}

	$(window).resize(function() {
		if ( $(window).width() > 315 ) {
			if ( $('.owl_mobile').hasClass('off') ) {
				var owlActive = owl.owlCarousel(owlOptions);
				owl.removeClass('off');
			}
		} else {
			if ( !$('.owl_mobile').hasClass('off') ) {
				owl.addClass('off').trigger('destroy.owl.carousel');
				owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
			}
		}
	});
};

function loadOwlTwo(selector,dataLgg) {
	var owl = $('.owl_mobileTypeTwo'),
		owlOptions = {
			loop: false,
			margin: 15,
			nav: true,
			navText: ['<i class="prev-icon"></i>','<i class="next-icon"></i>'],
			dots: false,
			responsiveClass:true,
			responsive:{
				0	: { items: 1 },
				543	: { items: 1 },
				768	: { items: 3 },
				992	: { items: 4 }
			}
		};

	if ( $(window).width() > 315 ) {
		var owlActive = owl.owlCarousel(owlOptions);
	} else {
		owl.addClass('off');
	}

	$(window).resize(function() {
		if ( $(window).width() > 315 ) {
			if ( $('.owl_mobile').hasClass('off') ) {
				var owlActive = owl.owlCarousel(owlOptions);
				owl.removeClass('off');
			}
		} else {
			if ( !$('.owl_mobile').hasClass('off') ) {
				owl.addClass('off').trigger('destroy.owl.carousel');
				owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
			}
		}
	});
};

$(function () {
	var owl = $('.owl_mobile'),
		owlOptions = {
			loop: false,
			margin: 30,
			nav: true,
			navText: ['<i class="prev-icon"></i>','<i class="next-icon"></i>'],
			dots: false,
			responsiveClass:true,
			responsive:{
				0	: { items: 1 },
				543	: { items: 1 },
				768	: { items: 3 },
				992	: { items: 3 }
			}
		};

	if ( $(window).width() > 315 ) {
		var owlActive = owl.owlCarousel(owlOptions);
	} else {
		owl.addClass('off');
	}

	$(window).resize(function() {
		if ( $(window).width() > 315 ) {
			if ( $('.owl_mobile').hasClass('off') ) {
				var owlActive = owl.owlCarousel(owlOptions);
				owl.removeClass('off');
			}
		} else {
			if ( !$('.owl_mobile').hasClass('off') ) {
				owl.addClass('off').trigger('destroy.owl.carousel');
				owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
			}
		}
	});
});
$(function () {
	var owl = $('.owl_mobileTypeTwo'),
		owlOptions = {
			loop: false,
			margin: 15,
			nav: true,
			navText: ['<i class="prev-icon"></i>','<i class="next-icon"></i>'],
			dots: false,
			responsiveClass:true,
			responsive:{
				0	: { items: 1 },
				543	: { items: 1 },
				768	: { items: 3 },
				992	: { items: 4 }
			}
		};

	if ( $(window).width() > 315 ) {
		var owlActive = owl.owlCarousel(owlOptions);
	} else {
		owl.addClass('off');
	}

	$(window).resize(function() {
		if ( $(window).width() > 315 ) {
			if ( $('.owl_mobile').hasClass('off') ) {
				var owlActive = owl.owlCarousel(owlOptions);
				owl.removeClass('off');
			}
		} else {
			if ( !$('.owl_mobile').hasClass('off') ) {
				owl.addClass('off').trigger('destroy.owl.carousel');
				owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
			}
		}
	});
});


/*Check so nho hon 1*/
function maxLengthCheck(object) {
	if (object.value.length > object.maxLength)
		object.value = object.value.slice(0, object.maxLength)
		}
function isNumeric (evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode (key);
	var regex = /[0-9]|\./;
	if ( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

/********************************************************
# DROPDOWN
********************************************************/
$('.dropdown-toggle').click(function() {
	$(this).parent().toggleClass('open'); 	
}); 
$('.btn-close').click(function() {
	$(this).parents('.dropdown').toggleClass('open');
}); 
$('body').click(function(event) {
	if (!$(event.target).closest('.dropdown').length) {
		$('.dropdown').removeClass('open');
	};
});