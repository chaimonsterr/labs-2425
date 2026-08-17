<?php

$upload_directory = getcwd() . '/uploads/';
$relative_path = '/uploads/';

if (!is_dir($upload_directory)) {
    mkdir($upload_directory, 0755, true);
}

// Handle Text File
if (isset($_FILES['text_file']) && $_FILES['text_file']['error'] === UPLOAD_ERR_OK) {
    $uploaded_text_file = $upload_directory . basename($_FILES['text_file']['name']);
    $temporary_file = $_FILES['text_file']['tmp_name'];

    if (move_uploaded_file($temporary_file, $uploaded_text_file)) {
        $text_file_content = file_get_contents($uploaded_text_file);
        ?>
        <h3>Text File</h3>
        <textarea cols="70" rows="30"><?php echo htmlspecialchars($text_file_content); ?></textarea>
        <?php
    } else {
        echo '<p>Failed to upload text file.</p>';
    }
}

// from pdf-file-upload branch: Handle PDF File and display it embedded in the page
if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    $uploaded_pdf_file = $upload_directory . basename($_FILES['pdf_file']['name']);
    $temporary_file = $_FILES['pdf_file']['tmp_name'];
    $relative_pdf_path = $relative_path . basename($_FILES['pdf_file']['name']);

    if (move_uploaded_file($temporary_file, $uploaded_pdf_file)) {
        ?>
        <h3>PDF File</h3>
        <embed src="<?php echo htmlspecialchars($relative_pdf_path); ?>" type="application/pdf" width="100%" height="600px" />
        <?php
    } else {
        echo '<p>Failed to upload PDF file.</p>';
    }
}

// from audio-file-upload branch: Handle Audio File and display it with an <audio> player
if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
    $uploaded_audio_file = $upload_directory . basename($_FILES['audio_file']['name']);
    $temporary_file = $_FILES['audio_file']['tmp_name'];
    $relative_audio_path = $relative_path . basename($_FILES['audio_file']['name']);

    if (move_uploaded_file($temporary_file, $uploaded_audio_file)) {
        ?>
        <h3>Audio File</h3>
        <audio controls>
            <source src="<?php echo htmlspecialchars($relative_audio_path); ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <?php
    } else {
        echo '<p>Failed to upload audio file.</p>';
    }
}

// from image-file-upload branch: Handle Image File and display it with an <img> tag
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $uploaded_image_file = $upload_directory . basename($_FILES['image_file']['name']);
    $temporary_file = $_FILES['image_file']['tmp_name'];
    $relative_image_path = $relative_path . basename($_FILES['image_file']['name']);

    if (move_uploaded_file($temporary_file, $uploaded_image_file)) {
        ?>
        <h3>Image File</h3>
        <img src="<?php echo htmlspecialchars($relative_image_path); ?>" alt="Uploaded image" style="max-width: 400px;" />
        <?php
    } else {
        echo '<p>Failed to upload image file.</p>';
    }
}
