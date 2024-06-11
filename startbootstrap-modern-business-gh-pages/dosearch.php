<?php
require 'config.php';

// Get the POST data
$postData = file_get_contents("php://input");
$request = json_decode($postData, true);

// Validate the query parameter
if (!isset($request['query'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$query = $request['query'];

// Execute the query
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
