<?php
// Quick fix script to reset AUTO_INCREMENT
require_once 'config.php';

echo "<h2>Database Fix Script</h2>";
echo "<hr>";

// Reset AUTO_INCREMENT to the next available ID
$result = $conn->query("SELECT MAX(id) as max_id FROM dogs");
$row = $result->fetch_assoc();
$next_id = ($row['max_id'] ?? 0) + 1;

$reset_sql = "ALTER TABLE dogs AUTO_INCREMENT = $next_id";
if ($conn->query($reset_sql)) {
    echo "✅ AUTO_INCREMENT reset successfully to $next_id<br>";
} else {
    echo "❌ Error resetting AUTO_INCREMENT: " . $conn->error . "<br>";
}

// Show current table status
echo "<br><h3>Current Table Status:</h3>";
$status_result = $conn->query("SHOW TABLE STATUS LIKE 'dogs'");
if ($status_result && $status_result->num_rows > 0) {
    $status = $status_result->fetch_assoc();
    echo "Auto_increment value: " . $status['Auto_increment'] . "<br>";
    echo "Rows in table: " . $status['Rows'] . "<br>";
} else {
    echo "Could not retrieve table status.<br>";
}

// Show last 5 records
echo "<br><h3>Last 5 Records:</h3>";
$recent_result = $conn->query("SELECT id, name, breed FROM dogs ORDER BY id DESC LIMIT 5");
if ($recent_result && $recent_result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Breed</th></tr>";
    while ($row = $recent_result->fetch_assoc()) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['breed'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No records found or error: " . $conn->error;
}

echo "<br><br><a href='DogRegister.php'>← Back to Dog Registration</a>";

$conn->close();
?>
