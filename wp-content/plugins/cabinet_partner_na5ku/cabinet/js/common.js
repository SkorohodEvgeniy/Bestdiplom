$(document).ready(function() {

	//Preloader
	setTimeout(function(){
		$('#preloader').fadeOut('slow',function(){$(this).remove();});
	}, 1000);

	// Img
	$("img, a").on("dragstart", function(event) { event.preventDefault(); });

	
	// Slider
	$('.reviews-carousel').owlCarousel({
		loop: true,
		margin: 18,
		nav: true,
		autoplay: false,
		items: 3,
		navText: ["",""],
		dots: false,
		smartSpeed: 500,
		slideBy: 1,
		responsive:{
			0:{
				items: 1,
				nav: false,
				dots: true
			},
			380:{
				items: 1,
				nav: false,
				dots: true
			},
			480:{
				items: 1,
				nav: false,
				dots: true
			},
			768:{
				items: 2
			},
			992:{
				items: 3
			}
		}
	});

	// MatchHeight
	$('.advantages-item, .work-item, .reviews-carousel .item, .support-item').matchHeight();


	$('.reviews-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
        $(".reviews-carousel").trigger('refresh.owl.carousel');
        $('.reviews-carousel .item').matchHeight();

    });

	// Select
	$(".select-input").select2({
		minimumResultsForSearch: -1
	});

	// Slider
	$("#pagesSlider, #originalSlider").slider({
		tooltip: 'hide'
	});

	$("#pagesSlider").on("slide", function(slideEvt) {
		$("#pagesSliderVal").text(slideEvt.value);
	});

	$("#originalSlider").on("slide", function(slideEvt) {
		$("#originalSliderVal").text(slideEvt.value);
	});

	// Popup 
	$('.call-popup').magnificPopup({
		type:"inline",
		mainClass: 'mfp-fade',
		showCloseBtn: false,
		closeBtnInside: true,
		removalDelay: 300,
		fixedContentPos: false
	});

	$('.call-popup1').magnificPopup({
		type:"inline",
		mainClass: 'mfp-fade',
		showCloseBtn: false,
		closeBtnInside: true,
		removalDelay: 300,
		fixedContentPos: false
	});

	// Close Button
	$('.close-button').click(function() {
		$.magnificPopup.close();
	});

	// Menu Toggle
	$('.menu-button').click(function() {
		$("#menu").toggleClass("on");
		$(".main-menu-toggle").toggleClass("on");
		$(".main-menu-toggle-white").toggleClass("on");
		$(".menu-dark-bg").toggleClass("on");
	});

	$('.main-menu-toggle').click(function() {
		$(this).toggleClass("on");
		$("#menu").toggleClass("on");
		$(".main-menu-toggle-white").toggleClass("on");
		$(".menu-dark-bg").toggleClass("on");
	});

	$('.menu-dark-bg').click(function() {
		$('.main-menu-toggle').toggleClass("on");
		$("#menu").toggleClass("on");
		$(".main-menu-toggle-white").toggleClass("on");
		$(".menu-dark-bg").toggleClass("on");
	});

	// navbar
	$(window).scroll(function(){

	    if ($(window).scrollTop() > 0) {
	        $('#navbar').addClass('on');
	    } else {
	    	$('#navbar').removeClass('on');
	    }

	});

	// Show more 
	size_li = $(".faq-row .faq-item").size();
	var x = 3;
	$('.faq-row .faq-item:lt('+x+')').fadeIn('slow');
	$('#load-more-button').click(function () {
		x= (x+3 <= size_li) ? x+3 : size_li;
		$('.faq-row .faq-item:lt('+x+')').fadeIn('slow');

		if(x == size_li){
			$('#load-more-button').hide();
		}
	});

	// Datepicker
	var date = new Date();
	var currentMonth = date.getMonth();
	var currentDate = date.getDate();
	var currentYear = date.getFullYear();
	$('.datepicker').datepicker({
		minDate: new Date(currentYear, currentMonth, currentDate),
		autoclose: true,
		language: 'ru',
		orientation: 'bottom',
		ignoreReadonly: true,
		dateFormat: 'yy/mm/dd'
	});

    // Right menu
	$('#right-menu').metisMenu({ toggle: false });

});