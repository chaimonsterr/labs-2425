<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3B</title>
    <link rel="icon" href="https://phpsandbox.io/assets/img/brand/phpsandbox.png">
    <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-4.15.0.min.css" />
</head>

<body style="background-color: pink;">
<div class="u-fixed-width">
  <div class="p-logo-section">
    <div class="p-logo-section__items">
      <div class="p-logo-section__item">
        <img class="p-logo-section__logo" src="https://www.auf.edu.ph/home/images/logo2.png" alt="Angeles University Foundation">
      </div>
    </div>
  </div>
</div>

<div class="row--50-50 grid-demo">
  <div class="col">
    <h4>File Upload</h4>

    <form method="POST" action="uploaded.php" enctype="multipart/form-data">
        <div class="p-card">
            <h3>Text File</h3>
            <p class="p-card__content">
            <input type="file" name="text_file" accept=".txt" />
            </p>
        </div>

        <!-- TASK: Image file upload input, only accepts image files -->
        <div class="p-card">
            <h3>Image File</h3>
            <p class="p-card__content">
            <input type="file" name="image_file" accept="image/*" />
            </p>
        </div>

        <div>
            <button>
                Upload
            </button>
        </div>
    </form>
    </div>
  <div class="col">
  <img class="p-logo-section__logo" src="https://www.auf.edu.ph/home/images/mascot/CCS.png" alt="College of Computing Studies">
  </div>
</div>

</body>
</html>
