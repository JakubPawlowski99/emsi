<?php
// Include database connection logic
include 'database.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (example: using mysqli_real_escape_string for simplicity)
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $regon = mysqli_real_escape_string($conn, $_POST['regon']);
    $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
    $czy_platnik_vat = isset($_POST['czy_platnik_vat']) ? 1 : 0;
    $ulica = mysqli_real_escape_string($conn, $_POST['ulica']);
    $numer_domu = mysqli_real_escape_string($conn, $_POST['numer_domu']);
    $numer_mieszkania = mysqli_real_escape_string($conn, $_POST['numer_mieszkania']);
    
    // Prepare SQL query
    $sql = "INSERT INTO kontrahenci (nip, regon, nazwa, czy_platnik_vat, ulica, numer_domu, numer_mieszkania, usuniety)
            VALUES ('$nip', '$regon', '$nazwa', '$czy_platnik_vat', '$ulica', '$numer_domu', '$numer_mieszkania', 0)";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Redirect to index.html after successful insertion
        header('Location: index.html');
        exit;
    } else {
        // Handle errors
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form action="add_contractor.php" method="POST">
    <label>NIP:</label><br>
    <input type="text" name="nip"><br>

    <label>REGON:</label><br>
    <input type="text" name="regon"><br>

    <label>Nazwa:</label><br>
    <input type="text" name="nazwa"><br>

    <label>Czy płatnik VAT?:</label><br>
    <select name="czy_platnik_vat">
        <option value="1">Tak</option>
        <option value="0">Nie</option>
    </select><br>

    <label>Ulica:</label><br>
    <input type="text" name="ulica"><br>

    <label>Numer domu:</label><br>
    <input type="text" name="numer_domu"><br>

    <label>Numer mieszkania:</label><br>
    <input type="text" name="numer_mieszkania"><br>

    <input type="submit" value="Dodaj kontrahenta">
</form>
