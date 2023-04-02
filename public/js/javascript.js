
var price = 0;
var myList = [];

document.querySelectorAll('.form-outline').forEach((formOutline) => {
    new mdb.Input(formOutline).init();
  });



function start(e){
    input_value_price = 0
    console.log(e)
    console.log(document.getElementById(e))
    var label = $('#'+e);
    price = parseFloat(label.attr('value'));
    value_name = label.attr('value_name');
    if(document.getElementById(e).className == 'btn btn-block btn-danger' || document.getElementById(e).className == 'btn btn-block btn-danger active'){
        myList.push({price_value: price, label_value:e, name_value: value_name})
        document.getElementById(e).className = "btn btn-block btn-success";
    }else if(document.getElementById(e).className == 'btn btn-block btn-success' || document.getElementById(e).className == 'btn btn-block btn-success active')
     {
        for (var i = 0; i < myList.length; i ++ ){
            if(e === myList[i].label_value){
                myList.splice(i, 1);
            }
        }
        document.getElementById(e).className = "btn btn-block btn-danger";
    }

    for (var i = 0; i < myList.length; i ++ ){
        input_value_price = parseFloat(input_value_price) + parseFloat(myList[i].price_value)
    }
    $('input#overal_price').val(input_value_price);
}


function values(){
    console.log(myList)
    return myList;
}

$(document).ready(function () {
    $('#history_table').DataTable({
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
});

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
});


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

// $('form').on('submit',function(e){
//     // watch form values
//     $('#formValues').html(($('form').serialize()));
//     e.preventDefault();
// });


/*******************************************************
 * create a filter that will be used to determine
 * which keystrokes are allowed in the input field
 * and which are not. Since we're working exclusively
 * with phone numbers, we'll need the following:
 * -- digits 0 to 9 from the numeric keys
 * -- digits 0 to 9 from the num pad keys
 * -- arrow keys (left/right)
 * -- backspace / delete for correcting
 * -- tab key to allow focus to shift
 *******************************************************/
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





