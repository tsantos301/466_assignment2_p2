// pull in all of the HTML elements we need to manipulate in javascript
var currentQuestion = 0;
var score = 0;
var totQuestions = questions.length;

//debug
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