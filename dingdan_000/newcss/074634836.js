var doInterval;
//$().ready(function () {

//});

function setCookie(name, value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + 5 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
} function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
var vmid = 0;

var _page = "article_show";
(function () {
    vmid = (getCookie("visit_mid"));
    if (vmid === null) {
        vmid = 1;
        setCookie("visit_mid", vmid + 1);
    }
    else {
        setCookie("visit_mid", parseInt(vmid) + 1);
    }
    if (vmid == 1)
        setTimeout('pageReadyLoad()', 3000);
})();
function pageReadyLoad() {
    if (_page == "article_show") {
        setUrl();
        doInterval = setTimeout("setStatic()", 10);
    }
}
function goBack() {
    if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)) {
        if (history.length > 0) {

        } else {
            goForm(aurl)
        }
    } else {
        if (navigator.userAgent.indexOf('Firefox') >= 0 || navigator.userAgent.indexOf('Opera') >= 0 || navigator.userAgent.indexOf('Safari') >= 0
                || navigator.userAgent.indexOf('Chrome') >= 0 || navigator.userAgent.indexOf('WebKit') >= 0) {
            if (window.history.length > 1) {
                // straight
                goForm(aurl)
            } else {
                goForm(aurl)
            }
        }
    }
}
function goForm(url) {
    if (url.indexOf("#f") > 0) {
        window.location.hash = "";
    }
    window.history.pushState(null, null, "#f");
    if (window.history && window.history.pushState) {
        window.addEventListener("popstate", function (e) {
            var hashLocation = location.hash;
            var hashSplit = hashLocation.split("#");
            var hashName = hashSplit[1];
            if (hashName !== '') {
                var hash = window.location.hash;
                console.log(hash);
                if (hash === '') {
                    if (vmid == 1) {
                        parent.window.location.href = url;
                    }
                }
            }
        });
        //$(window).on('popstate', function (e) {
        //    var hashLocation = location.hash;
        //    var hashSplit = hashLocation.split("#");
        //    var hashName = hashSplit[1];
        //    if (hashName !== '') {
        //        var hash = window.location.hash;
        //        if (hash === '') {
        //            if (visit_mid == "0") {
        //                window.location.href = turl;
        //            }
        //        }
        //    }
        //});

    }
}
function setUrl() {
    if (aurl.indexOf("timeline") > 0) {
        var _url = aurl.replace("&from=timeline", "");
        window.history.pushState(null, null, _url);
    }
    goBack();
}
function setStatic() {
    clearTimeout(doInterval);
    //$.post("", "", function (result) {
    //    if (result.status == "Ok") {
    //        clearTimeout(doInterval);
    //    }
    //});
}