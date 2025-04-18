<?php
function makeRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Test tool1
echo "Testing tool1:\n";
$test1 = json_encode(['input' => 'test123']);
$result1 = makeRequest('http://localhost:8000/tool1.php', $test1);
echo "Test response: " . $result1 . "\n\n";

// Test tool1 with actual search
$search1 = json_encode(['input' => '']);
$result2 = makeRequest('http://localhost:8000/tool1.php', $search1);
echo "Search response: " . $result2 . "\n\n";

// Test tool2
echo "Testing tool2:\n";
$test2 = json_encode(['input' => 'test456']);
$result3 = makeRequest('http://localhost:8000/tool2.php', $test2);
echo "Test response: " . $result3 . "\n\n";

// Test tool2 with actual search
$search2 = json_encode(['input' => 'Uniwersytet Jagielloński']);
$result4 = makeRequest('http://localhost:8000/tool2.php', $search2);
echo "Search response: " . $result4 . "\n"; 