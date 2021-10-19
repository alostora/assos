/*function run() {
    var myRequest;

    if (window.XMLHttpRequest) {

        myRequest = new XMLHttpRequest();

    } else {

        myReques = new ActiveXObject("Microsoft.XMLHTTP");
    }

        myRequest.onreadystatechange = function (){

        var mydiv = document.getElementById("myinfo");

        if (this.readyState == 4 && this.status == 200){

           // mydiv.innerHTML = "<p>welcome</p><br>";
            mydiv.innerHTML = myRequest.responseText;

        }else if(this.readyState > 0 && this.readyState < 4){

            mydiv.innerHTML = "<h1> your Request isnot initialize </h1><br>";

        }

    }
    myRequest.open("GET", "info.php?fname=hosam&lname=zaki", true);

    myRequest.send();
    
}
*/
/*
myRequest.open("post","info.php",true);
myRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
myRequest.send("fname=hosam&lname=zaki");


var mydiv = document.getElementById("myinfo");

    mydiv.innerHTML = myRequest.responseText;

*/
