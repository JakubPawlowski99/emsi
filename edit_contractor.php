<?php
// Include database connection logic
include 'database.php';

// Get contractor ID from GET parameter
$id = $_GET['id'];

// Fetch contractor data based on ID
$sql = "SELECT * FROM kontrahenci WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Output HTML form pre-filled with existing data
    ?>
    <h2>Edytuj kontrahenta</h2>
    <form action="update_contractor.php?id=<?php echo $id; ?>" method="POST">
        <label>NIP:</label><br>
        <input type="text" name="nip" pattern="[0-9]+" title="NIP should only contain numbers" value="<?php echo htmlspecialchars($row['nip']); ?>"><br>
        
        <label>REGON:</label><br>
        <input type="text" name="regon" pattern="[0-9]+" title="REGON should only contain numbers" value="<?php echo htmlspecialchars($row['regon']); ?>"><br>
        
        <label>Nazwa:</label><br>
        <input type="text" name="nazwa" value="<?php echo htmlspecialchars($row['nazwa']); ?>"><br>
        
        <label>Czy płatnik VAT?:</label><br>
        <select name="czy_platnik_vat">
            <option value="1" <?php echo $row['czy_platnik_vat'] ? 'selected' : ''; ?>>Tak</option>
            <option value="0" <?php echo !$row['czy_platnik_vat'] ? 'selected' : ''; ?>>Nie</option>
        </select><br>
        
        <label>Ulica:</label><br>
        <input type="text" name="ulica" value="<?php echo htmlspecialchars($row['ulica']); ?>"><br>
        
        <label>Numer domu:</label><br>
        <input type="text" name="numer_domu" value="<?php echo htmlspecialchars($row['numer_domu']); ?>"><br>
        
        <label>Numer mieszkania:</label><br>
        <input type="text" name="numer_mieszkania" value="<?php echo htmlspecialchars($row['numer_mieszkania']); ?>"><br>
        
        <input type="submit" value="Zapisz zmiany">
    </form>
    <?php
} else {
    echo "Nie znaleziono kontrahenta o podanym ID.";
}
?>
