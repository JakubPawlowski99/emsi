<?php
include 'database.php';

// Obsługa dodawania, edycji, usuwania kontrahentów
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $nip = $_POST['nip'];
    $regon = $_POST['regon'];
    $nazwa = $_POST['nazwa'];
    $ulica = $_POST['ulica'];
    $numer_domu = $_POST['numer_domu'];
    $numer_mieszkania = $_POST['numer_mieszkania'];
    $czy_platnik_vat = isset($_POST['czy_platnik_vat']) ? 1 : 0;

    if ($action == 'add') {
        $sql = "INSERT INTO kontrahenci (nip, regon, nazwa, ulica, numer_domu, numer_mieszkania, czy_platnik_vat) VALUES ('$nip', '$regon', '$nazwa', '$ulica', '$numer_domu', '$numer_mieszkania', '$czy_platnik_vat')";
        $conn->query($sql);
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        $sql = "UPDATE kontrahenci SET nip='$nip', regon='$regon', nazwa='$nazwa', ulica='$ulica', numer_domu='$numer_domu', numer_mieszkania='$numer_mieszkania', czy_platnik_vat='$czy_platnik_vat' WHERE id='$id'";
        $conn->query($sql);
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        $sql = "UPDATE kontrahenci SET usuniety=1 WHERE id='$id'";
        $conn->query($sql);
    }
}

// Pobranie danych kontrahentów z bazy danych
$sql = "SELECT id, nip, regon, nazwa, ulica, numer_domu, numer_mieszkania, czy_platnik_vat FROM kontrahenci WHERE usuniety=0";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}
?>

<table>
    <thead>
        <tr>
            <th>NIP</th>
            <th>REGON</th>
            <th>NAZWA</th>
            <th>ULICA</th>
            <th>NUMER DOMU</th>
            <th>NUMER MIESZKANIA</th>
            <th>CZY PŁATNIK VAT?</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row["nip"]); ?></td>
                <td><?php echo htmlspecialchars($row["regon"]); ?></td>
                <td><?php echo htmlspecialchars($row["nazwa"]); ?></td>
                <td><?php echo htmlspecialchars($row["ulica"]); ?></td>
                <td><?php echo htmlspecialchars($row["numer_domu"]); ?></td>
                <td><?php echo htmlspecialchars($row["numer_mieszkania"]); ?></td>
                <td><?php echo ($row["czy_platnik_vat"] ? "Tak" : "Nie"); ?></td>
                <td><button onclick="loadKontrahent(<?php echo $row['id']; ?>)">Edytuj</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$conn->close();
?>
