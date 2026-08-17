<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">User Registration</h1>
        <h2 class="subtitle">
            This is the IPT10 PHP Quiz Web Application Laboratory Activity. Please register
        </h2>

        <!-- BUG FIX: method was GET (fields would appear in the URL and $_POST
             checks on the next page would fail) and action pointed to a
             non-existent "pre-instructions.php". Fixed to POST -> instructions.php -->
        <form method="POST" action="instructions.php" id="registration-form">
            <div class="field">
                <label class="label">Complete Name</label>
                <div class="control">
                    <input class="input" type="text" id="complete_name" name="complete_name" placeholder="Complete Name" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" id="email" name="email" type="email" placeholder="you@example.com" required>
                </div>
                <p class="help" id="email-help"></p>
            </div>

            <div class="field">
                <label class="label">Birthdate</label>
                <div class="control">
                    <input class="input" name="birthdate" type="date" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Contact Number</label>
                <div class="control">
                    <input class="input" name="contact_number" type="number" placeholder="09171234567" required>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <!-- Disabled by default; JS below enables it once name + email are valid -->
                    <button type="submit" class="button is-link" id="next-btn" disabled>Proceed Next</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // TASK: disable the Next button unless Complete Name is non-empty AND
    // Email is a valid-looking email address; enable it once both are valid.
    const nameInput = document.getElementById('complete_name');
    const emailInput = document.getElementById('email');
    const nextBtn = document.getElementById('next-btn');
    const emailHelp = document.getElementById('email-help');

    // Simple, practical email pattern (not a full RFC 5322 validator).
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function validateForm() {
        const nameFilled = nameInput.value.trim().length > 0;
        const emailValid = emailPattern.test(emailInput.value.trim());

        nextBtn.disabled = !(nameFilled && emailValid);

        if (emailInput.value.trim().length > 0 && !emailValid) {
            emailHelp.textContent = 'Please enter a valid email address.';
            emailHelp.classList.add('is-danger');
        } else {
            emailHelp.textContent = '';
            emailHelp.classList.remove('is-danger');
        }
    }

    nameInput.addEventListener('input', validateForm);
    emailInput.addEventListener('input', validateForm);

    // Run once on load in case the browser autofills the fields.
    validateForm();
</script>
</body>
</html>
