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

// TASK: Handle Image File and display it with an <img> tag
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
