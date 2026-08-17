<?php

require "helpers.php";

// from the $_SERVER global variable, check if the HTTP method used is POST, if its not POST, redirect to the index.php page
// BUG FIX: missing exit; after header() redirect (see instructions.php note).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Supply the missing code
$complete_name  = $_POST['complete_name']  ?? '';
$email          = $_POST['email']          ?? '';
$birthdate      = $_POST['birthdate']      ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$agree          = $_POST['agree']          ?? '';

// TASK: instead of loading and submitting ONE question at a time (which used
// a hidden "answers" field to accumulate previously-answered letters across
// page reloads), we now load every question from the JSON file in a single
// pass and render them all together. Because everything is on one page,
// there is only ONE submit, straight to result.php - no more per-question
// hidden accumulator field or "answer"/"answers" hand-off is needed here.
$questions = retrieve_questions();
$total_questions = count($questions['questions']);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
</head>
<body>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Trivia Quiz</h1>
            </div>
            <div class="level-right">
                <span class="tag is-warning is-medium" id="timer">60</span>
            </div>
        </div>
        <h2 class="subtitle">Answer all <?php echo $total_questions; ?> questions below, then submit.</h2>

        <form method="POST" action="result.php" id="quiz-form">
            <input type="hidden" name="complete_name"  value="<?php echo h($complete_name); ?>" />
            <input type="hidden" name="email"          value="<?php echo h($email); ?>" />
            <input type="hidden" name="birthdate"      value="<?php echo h($birthdate); ?>" />
            <input type="hidden" name="contact_number" value="<?php echo h($contact_number); ?>" />
            <input type="hidden" name="agree"          value="<?php echo h($agree); ?>" />

            <!-- Show every question at once, each with its own set of radio
                 options. Each question's answer is stored as its own hidden
                 form field name: answers[<question_number>] so result.php
                 can rebuild the full answer sequence in order. -->
            <?php foreach ($questions['questions'] as $index => $question): ?>
                <?php $question_number = $index + 1; ?>
                <div class="box">
                    <h3 class="title is-5">
                        Question <?php echo $question_number; ?> / <?php echo $total_questions; ?>
                    </h3>
                    <p class="mb-3"><?php echo h($question['question']); ?></p>

                    <?php foreach ($question['options'] as $option): ?>
                        <div class="field">
                            <div class="control">
                                <label class="radio">
                                    <input type="radio"
                                        name="answers[<?php echo $question_number; ?>]"
                                        value="<?php echo h($option['key']); ?>" />
                                    <?php echo h($option['key']); ?>. <?php echo h($option['value']); ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-link">Submit Quiz</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // TASK: automatically submit the form after 60 seconds, whatever has
    // (or hasn't) been answered by then. A visible countdown tag keeps the
    // user aware of the time limit.
    const quizForm = document.getElementById('quiz-form');
    const timerTag = document.getElementById('timer');

    let secondsLeft = 60;

    const countdown = setInterval(() => {
        secondsLeft -= 1;
        timerTag.textContent = secondsLeft;

        if (secondsLeft <= 10) {
            timerTag.classList.remove('is-warning');
            timerTag.classList.add('is-danger');
        }

        if (secondsLeft <= 0) {
            clearInterval(countdown);
            quizForm.submit();
        }
    }, 1000);
</script>
</body>
</html>
