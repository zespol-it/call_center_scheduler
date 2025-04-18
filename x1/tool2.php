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

// Load people data
$osoby = json_decode(file_get_contents('osoby.json'), true);
$uczelnie = json_decode(file_get_contents('uczelnie.json'), true);

// Find university ID from name
$uczelnia_id = null;
foreach ($uczelnie as $uczelnia) {
    if (stripos($uczelnia['nazwa'], $input_text) !== false) {
        $uczelnia_id = $uczelnia['id'];
        break;
    }
}

// If university not found, return empty result
if (!$uczelnia_id) {
    echo json_encode(['output' => []]);
    exit;
}

// Find team members for the university
$results = [];
foreach ($osoby as $osoba) {
    if ($osoba['uczelnia'] === $uczelnia_id) {
        $results[] = [
            'imie' => $osoba['imie'],
            'nazwisko' => $osoba['nazwisko'],
            'wiek' => $osoba['wiek'],
            'plec' => $osoba['plec']
        ];
    }
}

// Limit results to fit within 1024 characters
$output = json_encode(['output' => $results]);
while (strlen($output) > 1024 && count($results) > 0) {
    array_pop($results);
    $output = json_encode(['output' => $results]);
}

// Return results
echo $output; 