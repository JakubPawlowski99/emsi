<?php
// Include database connection logic
include 'database.php';

// Get contractor ID from GET parameter (or from hidden form field)
$id = $_GET['id']; // Ensure to validate and sanitize this ID

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $nip = $_POST['nip'];
    $regon = $_POST['regon'];
    $nazwa = $_POST['nazwa'];
    $czy_platnik_vat = isset($_POST['czy_platnik_vat']) ? 1 : 0;
    $ulica = $_POST['ulica'];
    $numer_domu = $_POST['numer_domu'];
    $numer_mieszkania = $_POST['numer_mieszkania'];

    // Prepare update query
    $sql = "UPDATE kontrahenci SET nip='$nip', regon='$regon', nazwa='$nazwa', czy_platnik_vat=$czy_platnik_vat, ulica='$ulica', numer_domu='$numer_domu', numer_mieszkania='$numer_mieszkania' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Success message or redirect
        echo "Kontrahent został zaktualizowany.";
    } else {
        // Error handling
        echo "Błąd podczas aktualizacji kontrahenta: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>