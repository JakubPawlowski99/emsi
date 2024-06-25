<?php
// Assuming database connection is already established
include 'database.php'; // Ensure this includes your database connection logic

// Fetch all contractors (excluding soft-deleted ones)
$sql = "SELECT * FROM kontrahenci WHERE usuniety = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<h2>Lista Kontrahentów</h2>';
    echo '<table>';
    echo '<thead><th>NIP</th><th>REGON</th><th>NAZWA</th><th>CZY PŁATNIK VAT?</th><th>ULICA</th><th>NUMER DOMU</th><th>NUMER MIESZKANIA</th><th>Edytuj</th><th>Usuń</th></thead>';

    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>'.$row['nip'].'</td>';
        echo '<td>'.$row['regon'].'</td>';
        echo '<td>'.$row['nazwa'].'</td>';
        echo '<td>'.($row['czy_platnik_vat'] ? 'Tak' : 'Nie').'</td>';
        echo '<td>'.$row['ulica'].'</td>';
        echo '<td>'.$row['numer_domu'].'</td>';
        echo '<td>'.$row['numer_mieszkania'].'</td>';
        echo '<td><button class="editContractorButton" data-id="'.$row['id'].'">Edytuj</button></td>';
        echo '<td><button class="deleteContractorButton" data-id="'.$row['id'].'">Usuń</button></td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<br>';
    echo '<button id="addContractorButton">Dodaj nowego kontrahenta</button>';
} else {
    echo "Brak danych do wyświetlenia.";
}

?>
