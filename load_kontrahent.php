<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $sql = "SELECT id, nip, regon, nazwa, ulica, numer_domu, numer_mieszkania, czy_platnik_vat FROM kontrahenci WHERE id='$id' AND usuniety=0";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Kontrahent nie znaleziony']);
    }
}

$conn->close();
?>