$(function(){
    $(".loadmoredetail").click(function(){
        $(this).html("<img src=\""+WEB_ROOT+"/static/theme/noietheme/css/i/ajax-loader.gif\" />");
        $(this).prev().load(WEB_ROOT+"/ajax/team_detail.php?id="+$(this).attr("teamid"),
            function(a,b,c){
                
                $(this).prev().show();
                $(this).next().next().show();
                $(this).next().hide();

            });
        
    })

    $(".hidedetail-top").click(function(){
        $(this).next().html("");
        $(this).next().next().html("点击获取更多详情");
        $(this).next().next().show();
        $(this).next().next().next().hide();
        $(this).hide();
    })
    $(".hidedetail-bottom").click(function(){
        $(this).prev().prev().html("");
        $(this).prev().html("点击获取更多详情");
        $(this).prev().show();
        $(this).prev().prev().prev().hide();
        $(this).hide();
    })
})