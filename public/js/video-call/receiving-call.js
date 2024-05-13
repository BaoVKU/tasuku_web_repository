function settingCallEvent(
    call1,
    localVideo,
    remoteVideo,
    callButton,
    answerCallButton,
    endCallButton,
    rejectCallButton
) {
    call1.on("addremotestream", function (stream) {
        // reset srcObject to work around minor bugs in Chrome and Edge.
        remoteVideo.srcObject = null;
        remoteVideo.srcObject = stream;
    });

    call1.on("addlocalstream", function (stream) {
        // reset srcObject to work around minor bugs in Chrome and Edge.
        localVideo.srcObject = null;
        localVideo.srcObject = stream;
    });

    call1.on("signalingstate", function (state) {
        if (state.code === 6 || state.code === 5) {
            //end call or callee rejected
            callButton.show();
            endCallButton.hide();
            rejectCallButton.hide();
            answerCallButton.hide();
            localVideo.srcObject = null;
            remoteVideo.srcObject = null;
            $("#incoming-call-notice").hide();
        }
    });
    call1.on("mediastate", function (state) {
        console.log("mediastate ", state);
    });

    call1.on("info", function (info) {
        console.log("on info:" + JSON.stringify(info));
    });
}

$(function () {
    var localVideo = document.getElementById("localVideo");
    var remoteVideo = document.getElementById("remoteVideo");

    var callButton = $("#callButton");
    var answerCallButton = $("#answerCallButton");
    var rejectCallButton = $("#rejectCallButton");
    var endCallButton = $("#endCallButton");

    var currentCall = null;

    var client = new StringeeClient();
    client.connect(token);

    client.on("connect", function () {
        console.log("+++ connected!");
    });

    client.on("authen", function (res) {
        console.log("+++ on authen: ", res);
    });

    client.on("disconnect", function (res) {
        console.log("+++ disconnected");
    });
    //RECEIVE CALL
    client.on("incomingcall", function (incomingcall) {
        var width = screen.width * 0.7;
        var height = screen.height * 0.6;
        var left = screen.width / 2 - width / 2;
        var top = screen.height / 2 - height / 2;
        window.open(
            GLOBAL_HOST + "video-call",
            "_blank",
            "width=" +
                width +
                ",height=" +
                height +
                ",left=" +
                left +
                ",top=" +
                top
        );
    });
});
