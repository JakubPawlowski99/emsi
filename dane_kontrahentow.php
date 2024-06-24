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
$sql = "SELECT id, NIP, REGON, NAZWA, ULICA, NUMER_DOMU, NUMER_MIESZKANIA, CZY_PLATNIK_VAT FROM kontrahenci WHERE usuniety=0";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>
<link rel="stylesheet" href="styles.css">
<h2>Dane Kontrahentów</h2>
<form id="kontrahent-form">
    <input type="hidden" id="kontrahent-id" name="id">
    <label for="nip">NIP:</label><input type="text" id="nip" name="nip"><br>
    <label for="regon">REGON:</label><input type="text" id="regon" name="regon"><br>
    <label for="nazwa">NAZWA:</label><input type="text" id="nazwa" name="nazwa"><br>
    <label for="ulica">ULICA:</label><input type="text" id="ulica" name="ulica"><br>
    <label for="numer_domu">NUMER DOMU:</label><input type="text" id="numer_domu" name="numer_domu"><br>
    <label for="numer_mieszkania">NUMER MIESZKANIA:</label><input type="text" id="numer_mieszkania" name="numer_mieszkania"><br>
    <label for="czy_platnik_vat">CZY PŁATNIK VAT?</label><input type="checkbox" id="czy_platnik_vat" name="czy_platnik_vat"><br>
    <button type="button" onclick="addKontrahent()">Dodaj</button>
    <button type="button" onclick="editKontrahent()">Edytuj</button>
    <button type="button" onclick="deleteKontrahent()">Usuń</button>
</form>

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
                <td><?php echo $row["NIP"]; ?></td>
                <td><?php echo $row["REGON"]; ?></td>
                <td><?php echo $row["NAZWA"]; ?></td>
                <td><?php echo $row["ULICA"]; ?></td>
                <td><?php echo $row["NUMER_DOMU"]; ?></td>
                <td><?php echo $row["NUMER_MIESZKANIA"]; ?></td>
                <td><?php echo ($row["CZY_PLATNIK_VAT"] ? "Tak" : "Nie"); ?></td>
                <td><button onclick="loadKontrahent(<?php echo $row['id']; ?>)">Edytuj</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php $conn->close(); ?>

<script>
function addKontrahent() {
    const form = document.getElementById('kontrahent-form');
    const formData = new FormData(form);
    formData.append('action', 'add');
    fetch('dane_kontrahentow.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text()).then(data => {
        document.body.innerHTML = data; // Aktualizacja całej strony po dodaniu kontrahenta
    });
}

function editKontrahent() {
    const form = document.getElementById('kontrahent-form');
    const formData = new FormData(form);
    formData.append('action', 'edit');
    fetch('dane_kontrahentow.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text()).then(data => {
        document.body.innerHTML = data; // Aktualizacja całej strony po edycji kontrahenta
    });
}

function deleteKontrahent() {
    const form = document.getElementById('kontrahent-form');
    const formData = new FormData(form);
    formData.append('action', 'delete');
    fetch('dane_kontrahentow.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text()).then(data => {
        document.body.innerHTML = data; // Aktualizacja całej strony po usunięciu kontrahenta
    });
}

function loadKontrahent(id) {
    const form = document.getElementById('kontrahent-form');
    const formData = new FormData(form);
    formData.append('id', id);
    fetch('load_kontrahent.php', {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        document.getElementById('kontrahent-id').value = data.id;
        document.getElementById('nip').value = data.nip;
        document.getElementById('regon').value = data.regon;
        document.getElementById('nazwa').value = data.nazwa;
        document.getElementById('ulica').value = data.ulica;
        document.getElementById('numer_domu').value = data.numer_domu;
        document.getElementById('numer_mieszkania').value = data.numer_mieszkania;
        document.getElementById('czy_platnik_vat').checked = data.czy_platnik_vat === "1";
    });
}
</script>
