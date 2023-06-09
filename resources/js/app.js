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

var ctx = document.getElementById("myChart");

var myChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ],
        datasets: [
            {
                label: 'PLN',
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                lineTension: 0,
                backgroundColor: "transparent",
                borderColor: "#007bff",
                borderWidth: 4,
                pointBackgroundColor: "#007bff",
            },
        ],
    },
    options: {
        scales: {
            yAxes: [
                {
                    ticks: {
                        beginAtZero: false,
                    },
                },
            ],
        },
        legend: {
            display: false,
        },
    },
});

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


