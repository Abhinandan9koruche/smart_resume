<!DOCTYPE html>
<html>
<head>
    <title>Upload Resume</title>
</head>
<body>
    <h2>Upload Your Resume (PDF)</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="resume" accept=".pdf" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
