import './bootstrap';


var price = 0;
var myList = [];

document.querySelectorAll('.form-outline').forEach((formOutline) => {
    new mdb.Input(formOutline).init();
});

function values(){
    console.log(myList)
    return myList;
}

$(document).ready(function () {
    var table = $('#services_table').DataTable();

    var table_history = $('#services_table').DataTable();

    if (!table_history || !table_history.data().any()) {
        $('#services_table').DataTable({
            "dom": 'ftip',
            "language": {
                "zeroRecords": "Nie znaleziono",
                "info": "Strona _PAGE_ z _PAGES_",
                "search": "Szukaj:",
                "infoEmpty": "Brak informacji do wyświetlenia",
                "infoFiltered": "(Filtrowano z _MAX_ rekordów)",
                "paginate": {
                    "previous": "",
                    "next": "",
                }
            },
            "pageLength": 5,
        });
    }
    if (!table || !table.data().any()) {

        $('#services_table').DataTable({
            "dom": 'ftip',
            "language": {
                "zeroRecords": "Nie znaleziono",
                "info": "Strona _PAGE_ z _PAGES_",
                "search": "Szukaj:",
                "infoEmpty": "Brak informacji do wyświetlenia",
                "infoFiltered": "(Filtrowano z _MAX_ rekordów)",
                "paginate": {
                    "previous": "",
                    "next": "",
                }
            },
            "pageLength": 5,
        });
    }

});

// funkcja zamieniajaca ikone w zdjeciach
$(function(){
    $('#icon_photo').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#my_photo').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#my_photo').attr('src', '/assets/no_preview.png');
        }
    });

    $('#icon_photo_service').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#photo_service').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#photo_service').attr('src', '/public/png/services_icons/dye.jpg');
        }
    });

});

function formatPhoneNumber(value) {
    value = this.replaceAll(value.trim(),"-","");

    if(value.length > 3 && value.length <= 6)
        value = value.slice(0,3) + "-" + value.slice(3);
    else if(value.length > 6)
        value = value.slice(0,3) + "-" + value.slice(3,6) + "-" + value.slice(6);

    return value;
}

function phoneNumberFormat(){
    const inputField = document.getElementById('phone');
    const formattedInputValue = formatPhoneNumber(inputField.value);
    inputField.value = formattedInputValue;
}
function replaceAll(src,search,replace){
    return src.split(search).join(replace);
}

import Chart from 'chart.js/auto';
import 'chartjs-plugin-zoom';

var ctx = document.getElementById("myChart");

// Sprawdź, czy istnieje poprzedni wykres i usuń go
var previousChart = Chart.getChart(ctx);
if (previousChart) {
    previousChart.destroy();
}
var xhr = new XMLHttpRequest();

var currentPath = window.location.pathname;

// Pobieranie id z path, zakładając, że path ma postać '/analytics/worker/{id}'
var matches = currentPath.match(/\/analytics\/worker\/(\d+)/);

// Sprawdzanie, czy matches zawiera id
if (matches && matches.length > 1) {
    xhr.open("GET", "/charts/getData/"+matches[1], true);
} else {
    xhr.open("GET", "/charts/getData/", true);
}
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        var dataFromDatabase = JSON.parse(xhr.responseText);

        // Przekształć dane do odpowiedniego formatu
        var entries = [];

        var currentDate = new Date();

        // Iteruj przez dane z bazy danych
        dataFromDatabase.forEach(function (entry) {
            var startDate = new Date(entry.start);

            // Dodaj tylko wpisy z przeszłości
            if (startDate < currentDate) {
                var monthYear = startDate.toLocaleString('default', { month: 'long', year: 'numeric' }); // Pobierz nazwę miesiąca i rok

                // Sprawdź, czy już istnieje wpis dla tego samego miesiąca
                var existingEntry = entries.find(function (existing) {
                    return existing.monthYear === monthYear;
                });

                if (existingEntry) {
                    // Jeśli istnieje, dodaj do istniejącego wpisu
                    existingEntry.overallPrice += entry.overal_price;
                } else {
                    // Jeśli nie istnieje, utwórz nowy wpis
                    entries.push({
                        monthYear: monthYear,
                        overallPrice: entry.overal_price,
                    });
                }
            }
        });

        // Sortuj wpisy chronologicznie
        entries.sort(function (a, b) {
            var dateA = new Date(a.monthYear);
            var dateB = new Date(b.monthYear);
            return dateA - dateB;
        });

        var visibleEntries = entries.slice();

        // Przygotuj etykiety i dane do wykresu
        var months = visibleEntries.map(function (entry) {
            return entry.monthYear;
        });

        var overallPrices = visibleEntries.map(function (entry) {
            return entry.overallPrice;
        });

        // Stwórz wykres kolumnowy
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'PLN',
                        data: overallPrices,
                        backgroundColor: "gray",
                    },
                ],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }],
                    xAxes: [{
                        ticks: {
                            maxRotation: 0, // Obrót etykiet na osi X
                            minRotation: 0,
                        },
                        maxTicksLimit: 3, // Maksymalna liczba widocznych etykiet
                    }],
                },
                legend: {
                    display: false,
                },
                pan: {
                    enabled: true,
                    mode: 'x', // Umożliwia przewijanie tylko w osi X
                },
                zoom: {
                    enabled: true,
                    mode: 'x', // Umożliwia zoomowanie tylko w osi X
                },
            },
        });
    }
};
xhr.send();





$('.selectpicker').selectpicker({
    style: 'btn btn-outline-dark',
    liveSearch: true,
    size: 4,
});

$("#select_services").change(function(){
    calculateTotal()
});

function calculateTotal() {

    var selectElement = document.getElementById("select_services");

    var selectedOptions = selectElement.selectedOptions;

    var total = 0;
    for (var i = 0; i < selectedOptions.length; i++) {
        total += parseInt(selectedOptions[i].getAttribute("data-price"));
    }

    document.getElementById("overall_price").value = total;
}

var selectServices = document.getElementById("select_services");
var totalServiceTime = 0;
var dateStartInput = document.getElementById("date_start");
var dateEndInput = document.getElementById("date_end");

selectServices.addEventListener("change", function() {
    totalServiceTime = 0;

    for (var i = 0; i < selectServices.options.length; i++) {
        if (selectServices.options[i].selected) {
            totalServiceTime += parseInt(selectServices.options[i].getAttribute("data-time"));
        }
    }

    var dateStart = new Date(dateStartInput.value);
    var dateEnd = new Date(dateStart.getTime() + totalServiceTime * 60000 + 2 * 3600000);
    dateEndInput.value = dateEnd.toISOString().slice(0, 16);

});


function resetSelects(){
    $('.selectpicker').selectpicker('deselectAll')
}

function calculateTime(){
    totalServiceTime = 0;

    for (var i = 0; i < selectServices.options.length; i++) {
        if (selectServices.options[i].selected) {
            totalServiceTime += parseInt(selectServices.options[i].getAttribute("data-time"));
        }
    }

    var dateStart = new Date(dateStartInput.value);
    var dateEnd = new Date(dateStart.getTime() + totalServiceTime * 60000 + 2 * 3600000);
    dateEndInput.value = dateEnd.toISOString().slice(0, 16);
}


