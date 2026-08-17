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

// TASK: Handle Video File and display it with a <video> player
if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
    $uploaded_video_file = $upload_directory . basename($_FILES['video_file']['name']);
    $temporary_file = $_FILES['video_file']['tmp_name'];
    $relative_video_path = $relative_path . basename($_FILES['video_file']['name']);

    if (move_uploaded_file($temporary_file, $uploaded_video_file)) {
        ?>
        <h3>Video File</h3>
        <video width="480" controls>
            <source src="<?php echo htmlspecialchars($relative_video_path); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <?php
    } else {
        echo '<p>Failed to upload video file.</p>';
    }
}
