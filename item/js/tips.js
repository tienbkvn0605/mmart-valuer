$(function(){

	//*********************************
    //初期設定

	var tipsClassName = 'help_tips'　//注釈を表示させたい要素につけるclass名
	var popIdName = 'help_tips_pop'　//注釈の要素につけるID名

	//*********************************

	$('.'+tipsClassName).hover(
		function(){
			//overの処理
			//要素の位置を測定
			var offset = $(this).offset();
			var dataText = $(this).attr('data-help');
			//注釈を挿入
			$(this).after('<div id="'+popIdName+'">'+dataText+'</div>')
			$(window).mousemove( function(e) {
				var x = e.pageX;
				var y = e.pageY;
				$('#'+popIdName).css({left:x+'px',top:y+'px'});
			})
		},function(){
			//outの処理
			//注釈を削除する
			$('#'+popIdName).remove();
		}
	);

});
