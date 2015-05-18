/** 可以放到页面html之后的js代码 v1.0.0 **/
function showMsgBar(msg) {
	alert(msg);
	//var alert = $('#alertTpl').clone();
	//$('.alert alert_msg_body').text(msg);
	//$('.alert').show();
	//setTimeout(hideMsgBar, 5000);
}
function hideMsgBar() {
	$('.alert').hide();
}
//判断元素是否进入可视区域 
function see(objLiLast) {
    //浏览器可视区域的高度 
    var see = document.documentElement.clientHeight;
    //滚动条滑动的距离 
    var winScroll = $(this).scrollTop();
    //距离浏览器顶部的 
    var lastLisee = $(objLiLast).offset().top;
    return lastLisee < (see + winScroll) ? true : false;
}
function buildLiItem(data, tags) {
	var template = $('#template').html();
	Mustache.parse(template, tags);
	var rendered = Mustache.render(template, data);
	return rendered;
}
$(function() {
	var onOff = true;
	$(document).scroll(function(e){
		var $this = $('.list-group.scroll_load_more');
		var nowPage = $('#page_now').text();
		var hasNextPage = $('#page_has_next').text();
		var lastLi = $(this).find('.list-group-item:last');
		var isSee = see(lastLi);
		if (isSee && onOff && hasNextPage == '1') {
			$('#loadNext').show();
			onOff = false;
			var url = $this.attr('data-url');
			$.ajax({
				url: url.replace(/\/p\/(\d+)/, '/p/'+ (parseInt(nowPage) + 1)),
				type: 'GET',
				dataType: 'json',
				asyc: false,
				success: function (data) {
					$('#loadNext').hide();
					var list = data.results;
					for (var i = 0; i < list.length; i++) {
						var html = buildLiItem(list[i], ["--", "--"]);
						$this.append(html);
					}
					$('#page_has_next').text(data.hasNextPage);
					$('#page_now').text(data.nowPage);
					onOff = true;
				}
			});
		}
	});
});