<?php
    echo var_dump($_POST);
    foreach($_POST as $post_var){
        echo strtoupper($post_var)."<br>";
    }


?>

<?php

$db = mysqli_connect('localhost','root','','eLearning') or die("could not connect to database");
print_r($_POST);
if(isset($_POST['quizSelect'])) {
    $quizID = $_POST['quizSelect'];

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

    unset($_POST);

}

$newString="";



$xml=simplexml_load_string($questions); // creates simple xml object xml

//debugging
//foreach ($xml->children() as $books) {
//    echo htmlspecialchars($books->question . ", ");
//    $newString.="question".$books->question . ", ";
//    echo htmlspecialchars($books->option1 . ", ");
//    echo htmlspecialchars($books->b . ", ");
//    echo htmlspecialchars($books->c . ", ");
//    echo htmlspecialchars($books->d . ", ");
//    echo htmlspecialchars($books->answer . "<br>");
//}
//
//echo $newString;

//send the quiz object to javascript
echo '<script>';
echo 'var PHPquestions = ' . json_encode($xml) . ';';
echo '</script>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz's</title>
    <!--math library for javascript for test results-->
    <!--<script src="math.js" type="text/javascript"></script>-->
    <link href = "navigation.css" rel="stylesheet">
    <link href="quiz.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Pacifico|Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>
<body>
<ul class = "nav">
    <li><a class = "active" href="../index.html">Home</a></li>
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
            <a href=quiz.html>HTML Test</a>
            <a href="../Quiz's/quizCSS.html">CSS Test</a>
            <a href="quizJavaScript.html">JavaScript Test</a>
        </div>
    </li>
    <li id="contact"><a href="../contact.html">Contact</a></li>
</ul>
<h2 class="title"> Please Select a Quiz</h2>
<form action="testing.php" method="post" style="text-align: center">
    <select name="quizSelect">
        <option name="HTML" value="HTMLquiz" >HTML</option>
        <option name="CSS" value="CSSquiz" >CSS</option>
        <option name="Javascript" value="Javascriptquiz" >Javascript</option>
    </select>
    <input type="submit" value="Submit">
</form>

<br>
<div id="quizContainer" class="container">
    <div id="question" class="quiz_questions"></div>
    <br>

    <label class="option">
        <input type="radio" name="option" value="1" />
        <span id="option1"></span>
    </label>

    <label class="option">
        <input type="radio" name="option" value="2" />
        <span id="option2">test</span>
    </label>

    <label class="option">
        <input type="radio" name="option" value="3" />
        <span id="option3"></span>
    </label>

    <label class="option">
        <input type="radio" name="option" value="4" />
        <span id="option4"></span>
    </label>

    <button id="progressButton" class="progressButton" onclick="loadNextQuestion();">Submit and Continue</button>

</div>

<div id="result" class="container result" style="display:none;"></div>
<br>
<div id="corrections" style="display:none"></div>

</body>
<script type="text/javascript">

    console.log("PHP object:");
    console.log(PHPquestions);


    var temp = Object.entries(PHPquestions);

    console.log("Javascript array:");
    console.log(temp);

    var questions = temp[0][1];

    console.log("Inner content of array in new array:");
    console.log(questions);

    // pull in all of the HTML elements we need to manipulate in javascript
    var currentQuestion = 0;
    var score = 0;
    var totQuestions = questions.length;

    //debug
    console.log(questions.length.toString());
    //document.writeln(questions.length.toString());

    var container = document.getElementById('quizContainer');
    var questionEl = document.getElementById('question');
    var option1 = document.getElementById('option1');
    var option2 = document.getElementById('option2');
    var option3 = document.getElementById('option3');
    var option4 = document.getElementById('option4');

    //debug
    //  document.write(questionEl.toString());

    var progressButton = document.getElementById('progressButton');
    var resultCont = document.getElementById('result');
    var correctionCont = document.getElementById('corrections');
    var wrongArray = [];

    function loadQuestion (questionIndex) { //pass in the current question or question index
        var q = questions[questionIndex];
        questionEl.textContent = (questionIndex + 1) + '. ' + q.question;
        option1.textContent = q.option1;
        option2.textContent = q.option2;
        option3.textContent = q.option3;
        option4.textContent = q.option4;
    };

    function loadNextQuestion () {

        var selectedOption = document.querySelector('input[type=radio]:checked');

        // if the user hasnt selected a choice do not let them continue on in the quiz
        if(!selectedOption){
            alert('You should at least guess! Please select an answer!');
            return;
        }

        var studentAnswer = selectedOption.value;

        if(questions[currentQuestion].answer === studentAnswer){
            score += 1;
        }
        else{
            wrongArray.push("Problem Number "+ (currentQuestion+1)); //removing zero index so its easy to understand for readers
            if(questions[currentQuestion].answer==1)var alphaAnswer="A";
            if(questions[currentQuestion].answer==2)var alphaAnswer="B";
            if(questions[currentQuestion].answer==3)var alphaAnswer="C";
            if(questions[currentQuestion].answer==4)var alphaAnswer="D";
            wrongArray.push("Correct Answer: "+alphaAnswer);
        }

        selectedOption.checked = false;
        currentQuestion++;
        // if we are on the last question change the button letters to finish
        if(currentQuestion == (totQuestions - 1)){
            progressButton.textContent = 'Finish';
        }
        if(currentQuestion == totQuestions){
            // Use javascript to modify the quiz container look to display results
            container.style.display = 'none';
            resultCont.style.display = '';
            correctionCont.style.display = '';
            // document.writeln(score.valueOf());
            // document.writeln(totQuestions.valueOf());
            // document.writeln(math.fraction(score.valueOf(),totQuestions.valueOf()));
            var percent = ((score/totQuestions)*100).toFixed(2);
            resultCont.textContent = 'Your Grade: ' + score + '/' + totQuestions + '=' + percent + '%';
            correctionCont.textContent = "Incorrect Questions: "+ wrongArray;
            return;
        }
        loadQuestion(currentQuestion);
    }

    loadQuestion(currentQuestion);

</script>

</html>
