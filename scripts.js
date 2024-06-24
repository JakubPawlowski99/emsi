// Define registerEventListeners function in global scope
function registerEventListeners() {
    // Przechwytywanie kliknięcia przycisku "Aktualizuj kolory"
    var updateColorsButton = document.getElementById('updateColorsButton');
    if (updateColorsButton) {
        updateColorsButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            updateTableColors();
        });
    }

    // Przechwytywanie zmiany koloru 1
    var color1 = document.getElementById('color1');
    if (color1) {
        color1.addEventListener('change', function() {
            console.log("Zmiana koloru 1");
            updateTableColors();
        });
    }

    // Przechwytywanie zmiany koloru 2
    var color2 = document.getElementById('color2');
    if (color2) {
        color2.addEventListener('change', function() {
            console.log("Zmiana koloru 2");
            updateTableColors();
        });
    }



    // Początkowa aktualizacja po załadowaniu strony
    document.querySelectorAll('.netto, .ilosc, .vat').forEach(input => {
        input.addEventListener('input', updateRow);
    });

}

// Function to load content into #Prawy element
function loadPage(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('Prawy').innerHTML = data;
            registerEventListeners();
        })
        .catch(error => console.error('Error loading page:', error));
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

// Register event listeners after DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    registerEventListeners();
});