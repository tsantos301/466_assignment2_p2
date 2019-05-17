<?php

function parser($document){
    //~~~~~~~~~~~~~~~opening headers~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Replace title with h1
    $document = str_replace("<title>", "<h1>", $document);

    //Replace Subtitles with h2
    $document = str_replace("<subtitle>", "<h2>", $document);

    //Replace text with p
    $document = str_replace("<text>", "<p>", $document);

    //Replace examples with xmp
    $document = str_replace("<example>", "<xmp>", $document);

    //Replace bullets with ul
    $document = str_replace("<bullets>", "<ul>", $document);

    //Replace bullet with li
    $document = str_replace("<bullet>", "<li>", $document);

    //~~~~~~~~~~~~~~~Closing headers~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Replace title with h1
    $document = str_replace("</title>", "</h1>", $document);

    //Replace Subtitles with h2
    $document = str_replace("</subtitle>", "</h2>", $document);

    //Replace text with p
    $document = str_replace("</text>", "</p>", $document);

    //Replace examples with xmp
    $document = str_replace("</example>", "</xmp>", $document);

    //Replace bullets with ul
    $document = str_replace("</bullets>", "</ul>", $document);

    //Replace bullet with li
    $document = str_replace("</bullet>", "</li>", $document);
    //echo htmlspecialchars($document);
    return $document;
}

$db = mysqli_connect('localhost','root','','eLearning') or die("could not connect to database");
echo "data: ";
echo var_dump($_POST);
echo $_POST['data'];

//go to new page
if(isset($_POST['data'])) {
    echo "page change";
    $newPageID = $_POST['data'];

    //MAKE NEW QUERY AND EXECUTE IT
    $newPageQuery = "SELECT Content FROM pages WHERE Lesson = '$newPageID'";
    $result = mysqli_query($db, $newPageQuery);


    if (mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
            //Create HTML page
            $parsedPage = parser($row['Content']);
            $doc = new DOMDocument();
            $doc->loadHTML($parsedPage);
            echo $doc->saveHTML();
        }
    } else {
        echo "Could not find that page";
    }

    //unset($_POST);

}


?>


<p id="serverResponse"></p>
<script>



    function navigate(clicked_id){

        //alert(clicked_id);
        // console.log(clicked_id);
        // var xhttp = new XMLHttpRequest();
        // xhttp.open("POST", "parser.php", true);
        // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhttp.send("data=" + clicked_id);
        // console.log("do we go here");

        const xhr = new XMLHttpRequest();

        xhr.onload = function(){
            const serverResponse = document.getElementById("serverResponse");
            serverResponse.innerHTML = this.responseText;
        }

        xhr.open("POST","parser.php");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("data=" + clicked_id);
        //location.reload();
    }
</script>
