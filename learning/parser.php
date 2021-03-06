<?php
error_reporting(E_ERROR | E_PARSE);

function parser($document){
    //~~~~~~~~~~~~~~~opening headers~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Replace title with h1
    $document = str_replace("<title", "<h1", $document);

    //Replace Subtitles with h2
    $document = str_replace("<subtitle", "<h2", $document);

    //Replace text with p
    $document = str_replace("<text", "<p", $document);

    //Replace examples with xmp
    $document = str_replace("<example", "<pre", $document);

    //Replace bullets with ul
    $document = str_replace("<bullets", "<ul", $document);

    //Replace bullet with li
    $document = str_replace("<bullet", "<li", $document);

    //~~~~~~~~~~~~~~~Closing headers~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Replace title with h1
    $document = str_replace("</title>", "</h1>", $document);

    //Replace Subtitles with h2
    $document = str_replace("</subtitle>", "</h2>", $document);

    //Replace text with p
    $document = str_replace("</text>", "</p>", $document);

    //Replace examples with xmp
    $document = str_replace("</example>", "</pre>", $document);

    //Replace bullets with ul
    $document = str_replace("</bullets>", "</ul>", $document);

    //Replace bullet with li
    $document = str_replace("</bullet>", "</li>", $document);

    //debugging
    //echo htmlspecialchars($document);
    //echo $document;
    return $document;
}

$db = mysqli_connect('localhost','root','Allen07150794y','eLearning') or die("could not connect to database");

//debugging
//echo "data: ";
//echo var_dump($_POST);
//echo $_POST['data'];

//go to new page
if(isset($_POST['data'])) {
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
