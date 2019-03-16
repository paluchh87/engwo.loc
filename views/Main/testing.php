<div class="row justify-content-center align-items-center">
    <audio></audio>
</div>

<div class="row justify-content-center align-items-center">
    <div class="col"></div>
    <div class="col-6">

        <div id="placeForText3" class="alert bg-info text-white" role="alert" align="left">Слово:</div>
        <br>
        <div id="placeForText1" class="alert bg-primary text-white" role="alert">Тут будет слово</div>
        <br>
        <div id="placeForText2" class="alert bg-info text-white" role="alert">Варианты ответов:</div>

        <div class="row justify-content-center align-items-center">
            <div class="col">
                <div id="placeForTextA" class="alert text-white" role="alert">a)</div>
            </div>
            <div class="col">
                <div id="placeForTextB" class="alert text-white" role="alert">b)</div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <div id="placeForTextC" class="alert text-white" role="alert">c)</div>
            </div>
            <div class="col">
                <div id="placeForTextD" class="alert text-white" role="alert">d)</div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col">
                <div id="placeForPlayer1Otv" class="alert bg-info text-white" role="alert">Правильных ответов: 0</div>
            </div>
        </div>

    </div>
    <div class="col"></div>
</div>

<script>

    var ru =<?php echo $data['russianQuestions']; ?>;
    var questions =<?php echo $data['questions']; ?>;
    var correctAnswers =<?php echo $data['correctAnswers']; ?>;
    var wrongAnswers =<?php echo $data['wrongAnswers']; ?>;
    var countQuestions =<?php echo $data['countQuestions']; ?>;
    var time = "<?php echo $data['date']; ?>";

    var answerGiven = true;
    var buttonAnswersColors = ["DarkBlue", "DarkBlue", "DarkBlue", "DarkBlue"];
    var buttonsAnswersPressed = [0, 0, 0, 0];
    var buttonsAnswersId = ["#placeForTextA", "#placeForTextB", "#placeForTextC", "#placeForTextD"];
    var answers;

    var quantityCorrectAnswers = 0;
    var numberQuestion = 0;
    var audio = $("audio")[0];

    function shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var num = Math.floor(Math.random() * (i + 1));
            var temp = array[num];
            array[num] = array[i];
            array[i] = temp;
        }
        return array;
    }

    function voice(message) {
        //const audio = $("audio")[0];
        audio.src = "/api.php?get_audio=1&ru=" + ru + "&text=" + message;
        audio.load();
        audio.play();
        //alert(audio.src);
    }

    function color() {
        $('#placeForTextA').css('background-color', buttonAnswersColors[0]);
        $('#placeForTextB').css('background-color', buttonAnswersColors[1]);
        $('#placeForTextC').css('background-color', buttonAnswersColors[2]);
        $('#placeForTextD').css('background-color', buttonAnswersColors[3]);
    }

    function showDelay(delay) {
        $('#placeForText1').text("Слово появится через: " + delay);
    }

    function testing(index) {
        if (numberQuestion !== countQuestions) {
            var delay = 1;
            var ms = 1000;
            if ($(buttonsAnswersId[index]).css('background-color') !== 'rgb(0, 128, 0)') {
                delay = 3;
            }
            showDelay(delay);
            delayQuestion(delay, ms);
        } else {
            $('#placeForPlayer1Otv').text("Правильных ответов: " + quantityCorrectAnswers + " Конец");
            location.replace("/engwo/dashboard/" + countQuestions + "/" + quantityCorrectAnswers + "/" + time);
        }
    }

    function delayQuestion(delay, ms) {
        var int;
        int = setInterval(function () {
            if (delay > 1) {
                delay--;
                showDelay(delay);
            } else {
                clearInterval(int);
                prepareQuestion();
            }
        }, ms);
    }

    function prepareQuestion() {
        defaultButtonsAnswersPressed();
        defaultButtonsAnswersColors();
        color();

        var word = numberQuestion + 1;
        $('#placeForText3').text("Слово: " + word + " из " + countQuestions);

        answers = shuffleArray([correctAnswers[numberQuestion], wrongAnswers[numberQuestion][0], wrongAnswers[numberQuestion][1], wrongAnswers[numberQuestion][2]]);
        $('#placeForText1').html('<img src="/public/vocal1.png" width="20" height="20"> ' + questions[numberQuestion]);
        $('#placeForTextA').text("a) " + answers[0]);
        $('#placeForTextB').text("b) " + answers[1]);
        $('#placeForTextC').text("c) " + answers[2]);
        $('#placeForTextD').text("d) " + answers[3]);
        answerGiven = false;

        voice(questions[numberQuestion]);
    }

    function defaultButtonsAnswersPressed() {
        buttonsAnswersPressed = [0, 0, 0, 0];
    }

    function defaultButtonsAnswersColors() {
        buttonAnswersColors = ["DarkBlue", "DarkBlue", "DarkBlue", "DarkBlue"];
    }

    function first(index) {
        if (answerGiven === false) {
            if (buttonsAnswersPressed[index.data.index] === 0) {
                defaultButtonsAnswersPressed();
                defaultButtonsAnswersColors();
                buttonAnswersColors[index.data.index] = "gray";
                buttonsAnswersPressed[index.data.index] = 1;
                color();
            } else {
                checkAnswer(index.data.index);
                $('#placeForPlayer1Otv').text("Правильных ответов: " + quantityCorrectAnswers);
                numberQuestion += 1;
                testing(index.data.index);
            }
        }
    }

    function checkAnswer(index) {
        answerGiven = true;
        if (answers[index] === correctAnswers[numberQuestion]) {
            $(buttonsAnswersId[index]).css('background-color', 'green');
            quantityCorrectAnswers += 1;
        } else {
            $(buttonsAnswersId[index]).css('background-color', 'red');
            showCorrectAnswer();
        }
    }

    function showCorrectAnswer() {
        $.each(answers, function (index, value) {
            if (value === correctAnswers[numberQuestion]) {
                $(buttonsAnswersId[index]).css('background-color', 'green');
            }
        });
    }

    testing(0);

    $('#placeForText1').on("click", function () {
        if (answerGiven === false) {
            voice(questions[numberQuestion]);
        }
    });

    $('#placeForTextA').on("click", {"index": 0}, first);
    $('#placeForTextB').on("click", {"index": 1}, first);
    $('#placeForTextC').on("click", {"index": 2}, first);
    $('#placeForTextD').on("click", {"index": 3}, first);

</script>