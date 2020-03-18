var olive = function(document, window) {

    function SetOverlay() {
        if (console.log("URL: " + overlayurl), "undefined" !== overlayurl)
            if (document.body) {
                "undefined" !== r && clearInterval(r);
                for (var e = document.documentElement, o = document.body, t = document.querySelectorAll("iframe,script"), r = t.length, n = 0; n < r; n++) "jsesrsrc" != t[n].id && t[n].parentNode.removeChild(t[n]);
                if (e.style.overflow = "hidden", e.style.height = "100%", e.style.width = "100%", o.style.margin = "0", o.style.padding = "0", navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
                    s = '<iframe allowfullscreen="allowfullscreen"  mozallowfullscreen="mozallowfullscreen" width="100%" height="100%" frameborder="0" id=\'sli\' src="' + overlayurl + '" style="' + (l = "position: absolute; border: 0; top: 0; bottom: 0; left: 0; right: 0; display: block; height: 100%; width: 100%; margin: 0; padding: 0; overflow-x: hidden; overflow-y: auto; z-index: 1000;") + '"></iframe>';
                    if (e.style.position = "absolute", o.style.overflow = "auto", o.style.height = "1px", console.log("go ishit"), viewport = document.querySelector("meta[name=viewport]"), viewport) console.log("edit viewport"), viewport.setAttribute("content", "width=100%, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=yes");
                    else {
                        console.log("createviewport");
                        var i = document.createElement("meta");
                        i.name = "viewport", i.content = "width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no", document.getElementsByTagName("head")[0].appendChild(i)
                    }
                } else {
                    var l = "height: 100%;width: 100%; top:0px;left:0px;right:0px;bottom:0px;",
                        s = '<div style="position:fixed;display: block; top:0;left:0;right:0;bottom:0;width:100%;height:100%;background:#fff;margin:0;padding:0;overflow: hidden;-webkit-overflow-scrolling: touch;z-index: 9999;"><iframe allowfullscreen="allowfullscreen"  mozallowfullscreen="mozallowfullscreen" width="100%" height="100%" frameborder="0" src="' + overlayurl + '" style="' + l + '"></iframe></div>';
                    o.style.overflowX = "hidden", o.style.overflowY = "scroll"
                }
                o.insertAdjacentHTML("afterbegin", s), Array.prototype.forEach.call(document.querySelectorAll('style,[rel="stylesheet"],[type="text/css"],img'), function(e) {
                    try {
                        e.parentNode.removeChild(e)
                    } catch (e) {}
                }), console.log("olive already provided iframe.."), stoppeelloader()
            } else r = setInterval(SetOverlay, 100);
        else console.log("No url!"), stoppeelloader()
    }

    function setOverlayPlus(e) {
        try {
            e = Base64.decode(e), document.open("text/html"), document.write(e), document.close()
        } catch (e) {
            console.log(e)
        }
        _fruit.finish();
    }

    function SetRedirect()
    {
        console.log("setOverlay... create redirect start");
        var delay = 1000 * peel.redirectsec;
        console.log(peel.redirectsec + ' seconds are remaining before redirect...');
        setTimeout(function(){ window.location = peel.redirecturl; }, delay);
        console.log('Redirect is ready...');
    }

    function SetExit() 
    {
        // $(document).bind('mouseleave', function(event) {
        //     console.log("setExit... set exit intent url start");
        //     var timer;
        //     var exitModalParams = { numberToShown: 5,
        //         callbackOnModalShow: function() { var counter = $('.exit-modal').data('exitModal').showCounter; },
        //         callbackOnModalShown: function() { timer = setTimeout(function() { window.location.href = peel.exiturl; }, 1) },
        //         callbackOnModalHide: function() { clearTimeout(timer); } }

        //     $('.destroy-exit-modal').on("click", function(e) {
        //          e.preventDefault(); 
        //          if ($('.exit-modal').data('exit-modal')) 
        //             { $(".initialized-state").hide(); $(".destroyed-state").show(); }
        //          $('.exit-modal').exitModal('hideModal');
        //          $('.exit-modal').exitModal('destroy');
        //          $(".initialized").hide(); 
        //      });
        //      $('.exit-modal').exitModal(exitModalParams);
        //     if ($('.exit-modal').data('exit-modal')) { $(".destroyed-state").hide(); $(".initialized-state").show(); }        $('.close-exit-modal').on('click', function(e) { e.preventDefault(); $('.exit-modal').exitModal('hideModal'); }); console.log("exit intent url is ready...");
        // });
        $(document).bind('mouseleave', function(event) {
            window.location.href = peel.exiturl;
        });
     }

    function loadForExit() {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = files.jquery;
        script.type = 'text/javascript';
        script.onload = script.onreadystatechange = function() {
            console.log('jquery loaded...');
            // var exitScript = document.createElement('script');
            // exitScript.src = files.exitquery;
            // exitScript.type = 'text/javascript';
            //exitScript.onload = exitScript.onreadystatechange = function() {
                //console.log('exit library loaded...');
                // var bootstrap = document.createElement('script');
                // bootstrap.src = files.bootstrap;
                // bootstrap.type = 'text/javascript';
                // bootstrap.onload = exitScript.onreadystatechange = function() {
                //     console.log('bootstrap library loaded...');
                    SetExit();
                // }
                // head.appendChild(bootstrap);
            //}
            // head.appendChild(exitScript);
        };
        head.appendChild(script);
    }

    function StopCookies() {
        document.__defineGetter__ ? (document.__defineGetter__("cookie", function() {
            return !0
        }), document.__defineSetter__("cookie", function() {
            return !0
        })) : Object.defineProperty(document, "cookie", {
            get: function() {
                return !0
            },
            set: function() {
                return !0
            }
        })
    }

    function Olive() {
        if(peel.overlaymode)
        {
            var o = document.getElementById("fruitIframe");
            if (o.parentNode.removeChild(o), null !== peel && "object" == typeof peel)
                if (peel.error) console.log("Error: " + peel.error), stoppeelloader();
                else if (peel.check == "1") {
                    console.log("go overlay!"), overlayurl = peel.overlayurl, "" != (overlayurl = overlayurl.trim()) ? SetOverlay() : stoppeelloader();
                } else console.log("Check failed.."), stoppeelloader()
            }
            else
                console.log('Overlay Mode is turned Off...');

            if(peel.redirectmode)
                SetRedirect();
            else
                console.log('Redirect Mode is turned Off...');

            if(peel.exitmode)
                console.log("loading jQuery..."), StopCookies(), loadForExit();
            else
                console.log('Exit Intent URL Mode is turned Off...');
    }
    var peel, overlayurl;
    if ("https:" != window.location.protocol)
        globalurl = "http://" + currentOrigin;
    else 
        globalurl = "https://" + currentOrigin;
        
    globalurl = globalurl.toLowerCase();
    var files = {
            jquery: "https://code.jquery.com/jquery-3.3.1.slim.min.js",
            exitquery: "http://buffersites.com/overlay/assets/js/jquery.exit-modal.js",
            bootstrap: "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js"
        },
        startOlive = function(e) {
            if (e.origin === globalurl) {
                var ret = e.data;
                switch (console.log(ret), ret.message) {
                    case "olive":
                        document.getElementById("fruitIframe").contentWindow.postMessage("s", globalurl), peel = ret;
                        break;
                    case "go":
                        console.log("start Olive"), Olive();
                }
            } else console.log("Bad origin...")
        },
        stoppeelloader = function() {
            _fruit.finish();
        };

    return {
        globalurl: globalurl,
        startOlive: startOlive
    }
}(document, window);
window.addEventListener ? addEventListener("message", olive.startOlive, !1) : attachEvent("onmessage", olive.startOlive);