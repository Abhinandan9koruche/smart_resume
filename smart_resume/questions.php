<?php
$conn = new mysqli("localhost", "root", "", "resume_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM resumes ORDER BY uploaded_at DESC LIMIT 1";
$result = $conn->query($sql);

$questions = [];

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $resumeText = $row['content'];

    $sentences = preg_split('/(?<=[.!?])\\s+/', $resumeText);

    foreach ($sentences as $s) {
        $s = trim($s);
        if (stripos($s, 'project') !== false)
            $questions[] = "What was your role in the project: \"$s\"?";
        elseif (stripos($s, 'intern') !== false)
            $questions[] = "Tell me more about your internship: \"$s\"?";
        elseif (stripos($s, 'java') !== false || stripos($s, 'python') !== false)
            $questions[] = "How did you apply your programming skills in: \"$s\"?";
        elseif (strlen($s) > 40)
            $questions[] = "Can you elaborate on: \"$s\"?";

        if (count($questions) >= 8) break;
    }
} else {
    $questions[] = "No resume content found.";
}
?>

<!DOCTYPE html>
<html>
<head><title>Interview Questions</title></head>
<body>
    <h2>Generated Interview Questions</h2>
    <ul>
        <?php foreach ($questions as $q): ?>
            <li><?= htmlspecialchars($q) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
