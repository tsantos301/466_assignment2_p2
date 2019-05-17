<?php
    echo var_dump($_POST);
    foreach($_POST as $post_var){
        echo strtoupper($post_var)."<br>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h2>POST XMLHttpRequest</h2>
<p id="serverResponse"></p>
</body>


<script type="text/javascript">
    const xhr = new XMLHttpRequest();

    xhr.onload = function(){
        const serverResponse = document.getElementById("serverResponse");
        serverResponse.innerHTML = this.responseText;
    }

    xhr.open("POST","testing.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("name=domonic&message=hows it going");

</script>
</html>
