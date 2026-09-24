<?php
include 'initialize.php';

$queries = [
    "CREATE INDEX idx_username ON users(username)",
    "CREATE INDEX idx_firstname ON users(firstname)",
    "CREATE INDEX idx_lastname ON users(lastname)"
];

echo "<h2>Running Database Indexing...</h2>";

foreach ($queries as $sql) {
    try {
        if ($connection->query($sql) === TRUE) {
            echo "<p style='color: green;'><strong>Success:</strong> " . htmlspecialchars($sql) . "</p>";
        }
    } catch (Exception $e) {
        // If it already exists, just show a harmless orange message and keep going
        echo "<p style='color: orange;'><strong>Skipped (Already Exists or Error):</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>