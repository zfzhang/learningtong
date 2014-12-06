$(function () {
	//机构动态/我们的观点切换效果
	var tagClass = "listTagBk";
	var boxClass = "listBox";
	$("." + tagClass).each(function(index){
		if(index == 0){
			$("." + tagClass).eq(index).attr("class", tagClass + "_On");
			$("." + boxClass).eq(index).show();
		}
		$(this).click(function(){
			$("." + tagClass + "_On").attr("class", tagClass);
			$(this).attr("class", tagClass + "_On");
			$("." + boxClass).hide();
			$("." + boxClass).eq(index).show();
		});
	});
});