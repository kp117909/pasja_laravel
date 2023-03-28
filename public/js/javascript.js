
var price = 0;
var myList = [];



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

// $('form').on('submit',function(e){
//     // watch form values
//     $('#formValues').html(($('form').serialize()));
//     e.preventDefault();
// });
