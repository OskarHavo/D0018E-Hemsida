function appendSessionID(argument, sessionID) {
    var string = "hej";

    if (String(argument).indexOf("?") > -1) {
        string = "&sessionID=" +sessionID;
    } else {
        string = "?sessionID="+sessionID;
    }
    return argument + string;
}

function setSessionID(sessionID) {
    if (sessionID == "") {
        return;
    }
    var list = document.getElementsByTagName("A");
    var i = 0;
    for (i = 0; i < list.length; i++) {
        //list[i].href = "http://www.youtube.com/";
        //var string = appendPHP(list[i].getAttribute("href"));
        list[i].href = appendSessionID(list[i].getAttribute("href"), sessionID);
    }
    //list.getElementsByTagName("LI")[0].innerHTML = "Milk";
}
