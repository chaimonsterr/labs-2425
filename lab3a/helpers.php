<?php

// BUG FIX: this was hardcoded to 50, but the trivia JSON only has 5 questions.
// A wrong MAX_QUESTION_NUMBER breaks the "last question" detection and the
// score computation loop, so it must match the actual question count.
define('MAX_QUESTION_NUMBER', 5);

function retrieve_questions() {
    // 1. Open the questions/triviaquiz.json file
    $json_string = file_get_contents(__DIR__ . "/questions/triviaquiz.json");

    // 2. Convert it the array
    $json_data = json_decode($json_string, true);

    // 3. Return the trivia questions array data
    return $json_data;
}

function get_current_question($answers = '') {
    $number_of_answers = strlen($answers);
    $questions = retrieve_questions();
    return $questions['questions'][$number_of_answers];
}

function get_current_question_number($answers = '') {
    return strlen($answers) + 1;
}

function get_options_for_question_number($number = 0) {
    $questions = retrieve_questions();
    return $questions['questions'][$number - 1]['options'];
}

// BUG FIX: original code added 100 points per correct answer (max score 500)
// even though the activity treats the score as "out of 5" (see result.php's
// "beyond 2 points" rule). Score is now 1 point per correct answer.
// Also added isset() guards so a missing/short $answers string never throws
// a PHP warning or false-matches on null.
function compute_score($answers = '') {
    $questions = retrieve_questions();
    $correct_answers = $questions['answers'];

    $score = 0;
    for ($i = 0; $i < MAX_QUESTION_NUMBER; $i++) {
        if (isset($correct_answers[$i]) && isset($answers[$i]) && $correct_answers[$i] === $answers[$i]) {
            $score += 1;
        }
    }
    return $score;
}

function get_answers() {
    $questions = retrieve_questions();
    return $questions['answers'];
}

// Helper used by result.php to turn the birthdate (YYYY-MM-DD) into
// "Month dd, YYYY" format, e.g. "August 20, 2026".
function format_birthdate($birthdate) {
    $timestamp = strtotime($birthdate);
    if ($timestamp === false) {
        return $birthdate;
    }
    return date("F j, Y", $timestamp);
}

// Helper used by index.php / instructions.php / quiz.php to safely echo
// user-supplied values inside HTML attributes (prevents broken markup /
// XSS if someone types a quote or < character into a field).
function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
