<?php
$conn = new mysqli("localhost", "root", "", "resume_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_FILES["resume"]["type"] === "application/pdf") {
    $fileName = basename($_FILES["resume"]["name"]);
    $fileTmp = $_FILES["resume"]["tmp_name"];
    $uploadPath = "uploads/" . $fileName;

    if (!is_dir("uploads")) mkdir("uploads");

    if (move_uploaded_file($fileTmp, $uploadPath)) {
        $textFile = $uploadPath . ".txt";
        shell_exec("pdftotext \"$uploadPath\" \"$textFile\"");
        $resumeText = file_get_contents("output.txt"); // Not uploads/resume.pdf.txt


        $stmt = $conn->prepare("INSERT INTO resumes (filename, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $fileName, $resumeText);
        $stmt->execute();

        echo "✅ Resume uploaded and processed successfully.<br>";
        echo "<a href='questions.php'>Go to Interview Questions</a>";
    } else {
        echo "❌ Failed to upload file.";
    }
} else {
    echo "Please upload a valid PDF.";
}
?>
