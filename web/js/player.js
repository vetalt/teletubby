$(document).ready(function() {

    $("#jqplr").jPlayer({
        ready: function() {

        },
        resize: function(e) {
            if (!e.jPlayer.options.fullScreen) {
                $("#jqplr").jPlayer("stop");
            }
        },
        swfPath: "./js",
        supplied: "m4v",
        size: {
            width: "0px",
            height: "0px",
            cssClass: ""
        },
    });

    $('.clip').click(function(e) {
        e.preventDefault();
        var aurl = $(this).attr('href');
        $("#jqplr").jPlayer("setMedia", {m4v: aurl}).jPlayer("play").jPlayer({fullScreen: true});
    });

});