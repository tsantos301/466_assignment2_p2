function navigate(clicked_id){
    var introHide = document.getElementById("introduction");
    introHide.style.display = "none";
    const xhr = new XMLHttpRequest();

    xhr.onload = function(){
        const serverResponse = document.getElementById("serverResponse");
        serverResponse.innerHTML = this.responseText;
    }

    xhr.open("POST","parser.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("data=" + clicked_id);
}