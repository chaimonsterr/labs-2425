<?php
require "helpers.php";

// from the $_SERVER global variable, check if the HTTP method used is POST, if its not POST, redirect to the index.php page
// BUG FIX: header('Location: ...') does NOT stop script execution by itself.
// Without exit; the rest of the page (which assumes $_POST data exists) kept
// running even after issuing the redirect. Added exit; right after it.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Supply the missing code
$complete_name  = $_POST['complete_name']  ?? '';
$email          = $_POST['email']          ?? '';
$birthdate      = $_POST['birthdate']      ?? '';
$contact_number = $_POST['contact_number'] ?? '';

// Used for the "Hello [FIRST NAME]" greeting.
$name_parts = explode(' ', trim($complete_name));
$first_name = $name_parts[0] ?? $complete_name;
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
        <h1 class="title">Instructions</h1>
        <h2 class="subtitle">
            Hello <?php echo h($first_name); ?>, please read the instructions first
        </h2>

        <!-- BUG FIX: target action was blank (""), meaning the form posted
             back to itself instead of moving to quiz.php. -->
        <form method="POST" action="quiz.php" id="instructions-form">
            <!-- BUG FIX: the original hidden inputs had no "name" attribute,
                 so none of the registration data was actually sent to the
                 next page ($_POST would be missing complete_name, email, etc). -->
            <input type="hidden" name="complete_name"  value="<?php echo h($complete_name); ?>" />
            <input type="hidden" name="email"          value="<?php echo h($email); ?>" />
            <input type="hidden" name="birthdate"      value="<?php echo h($birthdate); ?>" />
            <input type="hidden" name="contact_number" value="<?php echo h($contact_number); ?>" />

            <!-- Display the instruction -->
            <div class="content">
                <p>
                    Welcome to the IPT10 PHP Trivia Quiz! You are about to answer 5 multiple-choice
                    questions about Philippine history and geography. Read each question carefully
                    and select one answer per question. Once you start, you will have
                    <strong>60 seconds</strong> to finish and submit the quiz — after that, it will
                    submit automatically with whatever answers you've selected so far. Good luck!
                </p>
            </div>

            <div class="field">
                <label class="label">Terms and conditions</label>
                <div class="control">
                    <textarea class="textarea" readonly rows="5">By taking this quiz, you agree to answer honestly and acknowledge that your name, email, birthdate, and contact number will be used solely for this activity's results page. No data is stored or shared beyond this session.</textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <!-- BUG FIX: checkbox was named "disagree" while the label said
                             "I agree to the terms and conditions" - contradictory and
                             confusing. Renamed to "agree" to match its actual meaning. -->
                        <input type="checkbox" id="agree" name="agree" value="yes">
                        I agree to the <a href="#">terms and conditions</a>
                    </label>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <!-- Disabled by default; JS enables it once the checkbox is ticked -->
                    <button type="submit" class="button is-link" id="start-quiz-btn" disabled>Start Quiz</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // TASK: disable the Start Quiz button unless the terms checkbox is ticked.
    const agreeCheckbox = document.getElementById('agree');
    const startBtn = document.getElementById('start-quiz-btn');

    function validateAgreement() {
        startBtn.disabled = !agreeCheckbox.checked;
    }

    agreeCheckbox.addEventListener('change', validateAgreement);
    validateAgreement();
</script>
</body>
</html>
