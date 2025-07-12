<?php
$resumeText = file_get_contents("output.txt");

$apiKey = "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"; // Your OpenAI API key here

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are an interview question generator."],
        ["role" => "user", "content" => "Generate detailed interview questions based on this resume:\n\n" . $resumeText]
    ]
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$questions = $responseData['choices'][0]['message']['content'] ?? 'Error generating questions.';

echo "<h2>Generated Interview Questions:</h2><pre>$questions</pre>";
?>
