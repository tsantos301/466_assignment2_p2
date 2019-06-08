<?php

echo var_dump($_POST);
if(isset($_POST['Javascript'])) {
    $quizID = $_POST['Javascript'];

    //MAKE NEW QUERY AND EXECUTE IT
    $quizQuery = "SELECT Content FROM pages WHERE Lesson = '$quizID'";
    $result = mysqli_query($db, $quizQuery);

    if (mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
            $questions = $row['Content'];
        }
    } else {
        echo "Could not find that page";
    }
}
