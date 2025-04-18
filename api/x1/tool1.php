<?php
header('Content-Type: application/json');

// Read input
$input = json_decode(file_get_contents('php://input'), true);
$input_text = $input['input'] ?? '';

// If it's a test request, return the input
if (strpos($input_text, 'test') === 0) {
    echo json_encode(['output' => $input_text]);
    exit;
}

// Load research data
$badania = json_decode(file_get_contents('badania.json'), true);

// Search for time travel related research
$results = [];
foreach ($badania as $badanie) {
    if (stripos($badanie['nazwa'], 'podróż') !== false || 
        stripos($badanie['nazwa'], 'czas') !== false) {
        $results[] = [
            'nazwa' => $badanie['nazwa'],
            'uczelnia' => $badanie['uczelnia'],
            'sponsor' => $badanie['sponsor']
        ];
    }
}

// Limit results to fit within 1024 characters
$output = json_encode(['output' => $results]);
while (strlen($output) > 1024 && count($results) > 0) {
    array_pop($results);
    $output = json_encode(['output' => $results]);
}

$action = ['usetool', 'answer'];

//usetool => tool1, tool2
//answer => konczy caly algorytm

$r = json_encode([
    'action' => 'akcja',
    'value' => 'tool1',
    'params' => '']);

// Return results
echo $r; 
