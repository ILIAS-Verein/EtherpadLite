/**
 * etherpadliteJsClass
 *
 * @author  Timon Amstutz <timon.amstutz@ilub.unibe.ch>
 * **/

 function etherpadliteJsClass() {

    /** "Private" variables **/
    var fullscreenPad = false;
    var height = 0;

    /** "Public" functions **/
    this.toggleFullscreen = function () {
        fullscreenPad = !fullscreenPad;
        this.resizePad();
    }
    this.resizePad = function () {
        if (fullscreenPad) {
            height = $(window).height();
        }
        else {
          height = $('#mainspacekeeper').height() - $('div.il_HeaderInner').outerHeight() - $('#ilTab').outerHeight() - $('div.il_after_tabs_spacing').outerHeight() - 100;
        }
        repaintPad();
    }

    /** Constructor actions **/
    this.resizePad();
    $("#leaveFullscreenPad").hide();

    /** "Private" functions **/
    function repaintPad() {
        if (fullscreenPad) {
            $("#etherpad-lite").addClass("etherpad-liteFullscreen").removeClass("etherpad-liteRegular");
            $("html").scrollTop(0);
            $("body").addClass("hiddenOverflow");
            $("#enterFullscreenPad").hide();
            $("#leaveFullscreenPad").show();
        }
        else {
            $("#etherpad-lite").addClass("etherpad-liteRegular").removeClass("etherpad-liteFullscreen");
            $("body").removeClass("hiddenOverflow");
            $("#enterFullscreenPad").show();
            $("#leaveFullscreenPad").hide();
        }
        $("#etherpad-lite").css({'height':height + "px"});
        //$("#etherpad-liteFrame").css({'height':$("#etherpad-lite").height()});
        $("#etherpad-liteFrame").css({'height':$("#etherpad-lite").height() - $(".labeFullscreenPad").height()-1 + "px"});
    }

}

/** Actions done when Document is loaded **/
$(function () {
    var etherpadlite = new etherpadliteJsClass();

    $(window).resize(function () {
        etherpadlite.resizePad();
    });

    $(".labeFullscreenPad").click(function () {
        etherpadlite.toggleFullscreen();
    });
});


