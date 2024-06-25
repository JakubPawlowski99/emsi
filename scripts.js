// Register event listeners after DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    registerEventListeners();

        // Load initial page (dane_kontrahentow.php)
        loadPage('dane_kontrahentow.php');
});

// Function to load page into #Prawy element
function loadPage(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('Prawy').innerHTML = data;
            // After loading new content, re-register event listeners
            registerEventListeners();
        })
        .catch(error => console.error('Błąd wczytywania strony:', error));
}


// Define registerEventListeners function in global scope
function registerEventListeners() {
    // Event listener for color changes (if applicable)
    var color1 = document.getElementById('color1');
    if (color1) {
        color1.addEventListener('change', function() {
            console.log("Color 1 changed");
            updateTableColors();
        });
    }

    var color2 = document.getElementById('color2');
    if (color2) {
        color2.addEventListener('change', function() {
            console.log("Color 2 changed");
            updateTableColors();
        });
    }

    // Event listeners for input changes (if applicable)
    document.querySelectorAll('.netto, .ilosc, .vat').forEach(input => {
        input.addEventListener('input', updateRow);
    });

    // Event listener for Add Contractor button
    var addContractorButton = document.getElementById('addContractorButton');
    if (addContractorButton) {
        addContractorButton.addEventListener('click', function(event) {
            event.preventDefault();
            loadAddForm();
        });
    }

    // Event listeners for Edit buttons
    var editButtons = document.querySelectorAll('.editContractorButton');
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            console.log("Edit button clicked for ID:", this.dataset.id);
            var id = this.dataset.id;
            loadEditForm(id);
        });
    });

    // Event listeners for Delete buttons
    var deleteButtons = document.querySelectorAll('.deleteContractorButton');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var id = this.dataset.id;
            deleteContractor(id);
        });
    });
}

// Function to update table colors
function updateTableColors() {
    var color1 = document.getElementById('color1').value;
    var color2 = document.getElementById('color2').value;

    var rows = document.getElementById('pracownicy-tbody').getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        if (i % 2 == 0) {
            rows[i].style.backgroundColor = color1;
        } else {
            rows[i].style.backgroundColor = color2;
        }
    }
}

// Function to update table row values based on inputs
function updateRow() {
    const row = this.closest('tr');
    const netto = parseFloat(row.querySelector('.netto').value);
    const ilosc = parseFloat(row.querySelector('.ilosc').value);
    const vat = parseFloat(row.querySelector('.vat').value);

    const brutto = netto * (1 + vat);
    const wartoscNetto = netto * ilosc;
    const wartoscBrutto = brutto * ilosc;

    row.querySelector('.brutto').textContent = brutto.toFixed(2);
    row.querySelector('.wartosc-netto').textContent = wartoscNetto.toFixed(2);
    row.querySelector('.wartosc-brutto').textContent = wartoscBrutto.toFixed(2);

    highlightAbove1000(); // Update highlighting based on current values
}

// Function to highlight rows above 1000 netto
function highlightAbove1000() {
    const rows = document.querySelectorAll('#faktury-tbody tr');
    rows.forEach(row => {
        const netto = parseFloat(row.querySelector('.netto').value);
        if (netto > 1000) {
            row.classList.add('highlight');
        } else {
            row.classList.remove('highlight');
        }
    });
}

function loadAddForm() {
    fetch('add_contractor.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('Prawy').innerHTML = data;
            registerEventListeners();
        })
        .catch(error => console.error('Błąd wczytywania formularza dodawania:', error));
}

// Function to load form for editing a contractor
function loadEditForm(id) {
    fetch('edit_contractor.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            document.getElementById('Prawy').innerHTML = data;
            // Add event listener for form submission
            const editForm = document.querySelector('#Prawy form');
            if (editForm) {
                editForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission
                    const formData = new FormData(this);
                    const url = this.action;

                    fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            // Reload the contractor list after successful update
                            loadPage('dane_kontrahentow.php');
                        } else {
                            console.error('Błąd podczas aktualizacji kontrahenta.');
                        }
                    })
                    .catch(error => console.error('Błąd podczas wysyłania żądania:', error));
                });
            }
        })
        .catch(error => console.error('Błąd wczytywania formularza edycji:', error));
}

// Function to handle deletion of a contractor
function deleteContractor(id) {
    if (confirm("Czy na pewno chcesz usunąć tego kontrahenta?")) {
        fetch('delete_contractor.php?id=' + id)
            .then(response => {
                // Reload the contractor list after deletion
                loadPage('dane_kontrahentow.php');
            })
            .catch(error => console.error('Błąd usuwania kontrahenta:', error));
    }
}

