<?php

require "helpers.php";

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

// quiz.php now submits one radio group per question named answers[1..N]
// instead of a single accumulated "answers" string. Rebuild that string
// here, in question order, so compute_score() (which expects a string of
// letters like "DBABC") keeps working unmodified.
$submitted_answers = $_POST['answers'] ?? [];
$answers = '';
for ($i = 1; $i <= MAX_QUESTION_NUMBER; $i++) {
    $answers .= $submitted_answers[$i] ?? '-';
}

// BUG FIX: $score was referenced in the markup below but never computed -
// the compute_score() call was commented out. Restored it.
$score = compute_score($answers);
$correct_answers = get_answers();
$questions = retrieve_questions()['questions'];

// TASK: hero section uses is-success if score is beyond 2 points (i.e. > 2),
// otherwise is-danger.
$hero_class = $score > 2 ? 'is-success' : 'is-danger';

// TASK: confetti canvas only shows on a perfect score (5/5).
$is_perfect_score = ($score === MAX_QUESTION_NUMBER);

// TASK: birthdate formatted from YYYY-MM-DD to "Month dd, YYYY".
$formatted_birthdate = format_birthdate($birthdate);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/site/site.min.css">
    <script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>
</head>
<body>
<section class="hero <?php echo $hero_class; ?>">
    <div class="hero-body">
        <p class="title">Your Score: <?php echo $score; ?> / <?php echo MAX_QUESTION_NUMBER; ?></p>
        <p class="subtitle">This is the IPT10 PHP Quiz Web Application Laboratory Activity.</p>
    </div>
</section>
<section class="section">
    <div class="table-container">
        <table class="table is-bordered is-hoverable is-fullwidth">
            <tbody>
                <tr>
                    <th>Input Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Complete Name</td>
                    <td><?php echo h($complete_name); ?></td>
                </tr>
                <tr class="is-selected">
                    <td>Email</td>
                    <td><?php echo h($email); ?></td>
                </tr>
                <tr>
                    <td>Birthdate</td>
                    <td><?php echo h($formatted_birthdate); ?></td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td><?php echo h($contact_number); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- TASK: another table showing every question, the correct answer, and the user's answer -->
    <h2 class="title is-4">Answer Review</h2>
    <div class="table-container">
        <table class="table is-bordered is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Your Answer</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $index => $question): ?>
                    <?php
                        $question_number = $index + 1;
                        $correct_key = $correct_answers[$index] ?? '';
                        $user_key = $answers[$index] ?? '-';
                        $is_correct = ($user_key === $correct_key);

                        $option_lookup = [];
                        foreach ($question['options'] as $option) {
                            $option_lookup[$option['key']] = $option['value'];
                        }
                        $correct_text = $option_lookup[$correct_key] ?? $correct_key;
                        $user_text = $option_lookup[$user_key] ?? 'No answer';
                    ?>
                    <tr class="<?php echo $is_correct ? 'has-background-success-light' : 'has-background-danger-light'; ?>">
                        <td><?php echo $question_number; ?></td>
                        <td><?php echo h($question['question']); ?></td>
                        <td><?php echo h($correct_key . ' - ' . $correct_text); ?></td>
                        <td><?php echo h($user_key . ' - ' . $user_text); ?></td>
                        <td><?php echo $is_correct ? '✅ Correct' : '❌ Wrong'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($is_perfect_score): ?>
        <canvas id="confetti-canvas"></canvas>
    <?php endif; ?>
</section>

<?php if ($is_perfect_score): ?>
<script>
    // TASK: confetti only shows for a perfect score (5/5) - the canvas
    // element itself is only rendered when $is_perfect_score is true, so this
    // script only runs in that case.
    var confettiSettings = {
        target: 'confetti-canvas'
    };
    var confetti = new ConfettiGenerator(confettiSettings);
    confetti.render();
</script>
<?php endif; ?>
</body>
</html>
