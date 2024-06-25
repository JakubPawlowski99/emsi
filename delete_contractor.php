<?php
// Include database connection logic
include 'database.php';

// Get contractor ID from GET parameter
$id = $_GET['id'];

// Update database to mark contractor as deleted (soft delete)
$sql = "UPDATE kontrahenci SET usuniety = 1 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Optionally handle success (redirect or respond with success message)
} else {
    // Handle errors
    echo "Error deleting record: " . $conn->error;
}
?>
