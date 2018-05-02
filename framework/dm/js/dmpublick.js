/*Loading*/
$(function(){
    var sidebarname = $(".breadcrumb li:last").html();
    $("span:contains("+sidebarname+")").parent().parent().addClass('active');
    $("span:contains("+sidebarname+")").parent().parent().parent().parent().addClass('open');	
    $(".breadcrumb li:first a").attr("href", "/dm");
    if(isMobileClient()){
        $("body").append('<script src="/framework/dm/js/dmmobile.js"></script>');
        setMobileNav();
    }
});

$(function(){
    bootbox.setDefaults("locale", "zh_CN");
    $("#apn").hide();
});

/* 看结果*/
function lookresult(data, show){
    var getData = function(data){
        /*<div style='position:fixed; z-index:999; top:0;'></div>相对浏览器
        <div style='position:absolute z-index:999; top:0;'></div>相对父元素
        <div style='position:relative; z-index:999; top:0;'></div>相对自己
        */                
        return "<div style='position:fixed; z-index:999; top:0;'><button onclick='window.location.reload()'>返回</button>" + data + "</div>";
    }

    if(show == 1){
        return;
    }

    if(typeof(show) == "undefinded" || show == 0){
        document.write(getData(data));
    } else {
        document.write(getData(data)+$(":root").html());
    }

    // var resultview = document.open("1.html", "_blank");// resultview.write(data);// resultview.close();
}

/*E看结果*/

//判断客户端
function isMobile() {
    var userAgentInfo = navigator.userAgent;

    var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone", "iPad","iPod"];

    var mobile_flag = false;

    //根据userAgent判断是否是手机
    for (var v = 0; v < mobileAgents.length; v++) {
        if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
            mobile_flag = true;
            break;
        }
    }

     var screen_width = window.screen.width;
     var screen_height = window.screen.height;    

     //根据屏幕分辨率判断是否是手机
     if(screen_width < 500 && screen_height < 800){
         mobile_flag = true;
     }

     return mobile_flag;
}

//判断设备是否是手机还是电脑
function isMobileClient() {
    var userAgentInfo = navigator.userAgent;
    var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
    var agentinfo = null;
    for(var i = 0; i < Agents.length; i++) {
        if(userAgentInfo.indexOf(Agents[i]) > 0) {
            agentinfo = userAgentInfo;
            break;
        }
    }
    if(agentinfo) {
        return true;
    } else {
        return false;
    }
}