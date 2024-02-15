//スムーススクロール----------------------//
$(function(){
   $('a[href^=#]' + 'a:not(.non-smooth)').click(function() {
      var speed = 400; // ミリ秒
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $("html, body").animate({scrollTop:position}, 550, "swing");
      return false;
   });
});
//----------------------スムーススクロール//


//ページトップヘ----------------------//

$(function() {
	var topBtn = $('#pageTop');
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
});

//----------------------ページトップヘ//


//ブロック要素リンク----------------------//

$(function(){
     $('#txtbox').click(function(){
         window.location=$(this).find('a').attr('href');
         return false;
    });
});

//----------------------ブロック要素リンク//