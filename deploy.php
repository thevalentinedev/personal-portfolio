<?php
$secret = "jixqyf-vajve2-jixQor"; 

// Verify it's a POST request from GitHub
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit('Permission denied');
}

// Optional: verify secret (recommended for public repos)
$payload = file_get_contents('php://input');
$headers = getallheaders();
$signature = $headers['X-Hub-Signature'] ?? '';

if (!empty($secret)) {
    $hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
    if (!hash_equals($hash, $signature)) {
        http_response_code(403);
        exit('Invalid signature');
    }
}

// Run git pull
$output = shell_exec("cd /home/dmahqcwr/codebyval.ca/ && git pull 2>&1");
echo "<pre>$output</pre>";
