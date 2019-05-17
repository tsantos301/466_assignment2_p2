<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href = "navigation.css" rel="stylesheet" type="text/css">
    <title>Forms</title>
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Pacifico|Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>
<body>

<div name = "navigation">
    <ul class="nav">
        <li><a href="../index.html">Home</a></li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropButton">Tutorials</a>
            <div class="dropdown-content">
                <a href="../HTML.html">HTML</a>
                <a href="../CSS.html">CSS</a>
                <a href="../JavaScript.html">JavaScript</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropButton">Tests</a>
            <div class="dropdown-content">
                <a href="../Quiz's/quiz.html">HTML Test</a>
                <a href="../Quiz's/quizCSS.html">CSS Test</a>
                <a href="../Quiz's/quizJavaScript.html">JavaScript Test</a>
            </div>
        </li>
        <li id="contact"><a href="../contact.html">Contact</a></li>
    </ul>
</div>
<div id="html nav">
    <ul class="nav">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropButton">Basics:</a>
            <div class="dropdown-content">
                <a id="HelloWorld" onClick=" navigate(this.id)">Hello World</a> <!--<a onclick="dispHelloWorld();" href=../CSS_content/animations.html>Hello World</a>-->
                <a href= ../HTML_content/documentTypes.html>Document Types</a>
                <a href=../HTML_content/commentsTags.html>Comments and Tags</a>

                <a href=../HTML_content/links.html>Links</a>

                <a href=../HTML_content/paraLists.html>Paragraphs and Lists</a>
                <a href=../HTML_content/tables.html>Tables</a>
                <a href=../HTML_content/forms.html>Forms</a>

            </div>
        </li>

    </ul>
</div>

</body>
</html>