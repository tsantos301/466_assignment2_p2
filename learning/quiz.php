<?php
error_reporting(E_ERROR | E_PARSE);

$db = mysqli_connect('localhost','root','Allen07150794y','eLearning') or die("could not connect to database");

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

$xml=simplexml_load_string($questions); // creates simple xml object xml

//debugging
//foreach ($xml->children() as $books) {
//    echo htmlspecialchars($books->question . ", ");
//    echo htmlspecialchars($books->option1 . ", ");
//    echo htmlspecialchars($books->option2 . ", ");
//    echo htmlspecialchars($books->option3 . ", ");
//    echo htmlspecialchars($books->option4 . ", ");
//    echo htmlspecialchars($books->answer . "<br>");
//}


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
    <link href = "navigation.css" rel="stylesheet">
    <link href="quiz.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Pacifico|Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Indie+Flower|Just+Another+Hand|Stylish" rel="stylesheet">
</head>

<img id="logoIMG" src="logo.png" ><h2 id="logoText">Book-Worms Teaching Service</h2>
<body>
<ul class = "nav">
    <li><a class = "active" href="home.html">Home</a></li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropButton">Tutorials</a>
        <div class="dropdown-content">
            <a href="HTMLmain.html">HTML</a>
            <a href="CSSmain.html">CSS</a>
            <a href="Javascriptmain.html">JavaScript</a>
        </div>
    </li>
    <li><a class = "active" href="quiz.php">Quiz's</a></li>
    <li id="contact"><a href="contact.html">Contact</a></li>
</ul>
<h2 class="title"> Please Select a Quiz:</h2>
<form action="quiz.php" method="post" style="text-align: center">
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
        <span id="option2"></span>
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

    var temp = Object.entries(PHPquestions);
    var questions = temp[0][1];

    // pull in all of the HTML elements we need to manipulate in javascript
    var currentQuestion = 0;
    var score = 0;
    var totQuestions = questions.length;

    var container = document.getElementById('quizContainer');
    var questionEl = document.getElementById('question');
    var option1 = document.getElementById('option1');
    var option2 = document.getElementById('option2');
    var option3 = document.getElementById('option3');
    var option4 = document.getElementById('option4');
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

        // if the user hasn't selected a choice do not let them continue on in the quiz
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
