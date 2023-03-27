
@extends('layout')


@section('content')
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    document.addEventListener('DOMContentLoaded', function() {
    var events = @json($events);
    var calendarEl = document.getElementById('calendar');
    var initialView = 'timeGridWeek';
    var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list',],
    initialView: 'timeGridWeek',
    locale: 'pl',
    header: {
                  left: 'prev,next,today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
              },
    height: 650,
    events:  events,
    eventColor: '#6c757d',
    minTime: '06:00',
    maxTime: '21:00',
    selectable: true,
    select: async function (start, end, allDay) {
      const { value: formValues } = await Swal.fire({
      title: 'Dodaj Klienta',
      html:
        '<div class="input-group mb-3">'+
          '<input type="text" class="form-control" placeholder="Imie" aria-label="name" id = "name">'+
          '<span class="input-group-text" id="basic-addon1">||</span>'+
          '<input type="text" class="form-control" placeholder="Nazwisko" aria-label="surname" id = "surname">'+
          '<span class="input-group-text" id="basic-addon1">+48</span>'+
          '<input type="text" class="form-control" placeholder="Telefon" aria-label="phone" id = "phone" aria-describedby="basic-addon1">'+
        '</div>' +
        '<label for="input_client">Wybierz Klienta z listy</label>'+
        '<select id ="select_client" class="form-control form-control-sm">'+
            @foreach ($clients as $client)
              '<option id = "{{$client->phone}}" value = "{{ $client->id }}">{{ $client->first_name }}  {{ $client->last_name }} </option>'+
            @endforeach
        '</select>'+
        '<label for="input_worker">Wybierz Pracownika</label>'+
        '<select id ="select_worker" class="form-control form-control-sm">'+
          @foreach($workers as $worker)
          '<option id = " worker" value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>'+
          @endforeach
        '</select>'+
        '<form class="container">'+
          '<div class="row">'+
              '<div class="col-sm-12 col-xs-12">'+
                '<p class="font-weight-bold">Usługi</p>'+
                  '<div data-toggle="buttons">'+
                      @foreach($services as $service)
                      '<label name= "components_label" value_name = "{{ $service->service_name }}" value = "{{ $service->price }}" class="btn btn-block btn-danger" id = "{{ $service->id }}" onclick ="start(this.id)" >'+
                          '<input name= "components" value = "{{ $service->id }}" class="btn btn-block btn-danger" style = "display:none;" type="checkbox" id = "service-checkbox-"{{ $service->id }}"-input" name="{{ $service->id }}" >' +
                          '{{ $service->service_name }} | {{ $service->price }} zł'+
                      '</label>'+
                      @endforeach
                    '</div>'+ 
                '</div>'+
          '</div>'+
          '<p class="font-weight-bold">Czas Usługi</p>'+
          '<div class="datetimepicker">'+
          '<span class="input-group-text" id="basic-addon1">Od</span>'+
          '<input type="datetime-local" id="date_start" name="Test" class="form-control" format-value="YYYY-MM-DDTHH:mm:ss" value = "'+start.startStr.split('+',1)+'"  />'+
         '</div>'+
         '<p class="font-weight-bold"></p>'+
         '<div class="datetimepicker">'+
            '<span class="input-group-text" id="basic-addon1">Do</span>'+
            '<input type="datetime-local" id="date_end" name="Test" class="form-control" format-value="YYYY-MM-DDTHH:mm:ss" value = "'+start.endStr.split('+',1)+'"  />'+
         '</div>'+
         '<p class="font-weight-bold">Kwota</p>'+
         '<div class="input-group mb-3">'+
          '<div class="input-group-prepend">'+
            '<span class="input-group-text">Kwota Końcowa:</span>'+
         '</div>'+
          '<input type="number" value = "0" id = "overal_price" class="form-control" aria-label="Cena">'+
          '<div class="input-group-append">'+
            '<span class="input-group-text">zł</span>'+
          '</div>'+
        '</div>'+
        '</form>',
      focusConfirm: false,
      // preConfirm: () => {
      //   return [
      //   document.getElementById('name').value,
      //   document.getElementById('surname').value,
      //   document.getElementById('phone').value,
      //   document.querySelector('#select_client').value,
      //   values(),
      //   document.querySelector('#select_worker').value,
      //   document.getElementById('date_start').value,
      //   document.getElementById('date_end').value,
      //   document.getElementById('overal_price').value
      //   ]
      // },
      });
      if (formValues){
        var start_date = document.getElementById('date_start').value;
        var end_date =document.getElementById('date_end').value;
        var ovr_price = document.getElementById('overal_price').value;
        var client_id = document.querySelector('#select_client').value;
        var worker_id = document.querySelector('#select_worker').value;
        var service_events = values();
        console.log(service_events)
        $.ajax({
          url:"{{ route('calendar.store') }}",
          type:"GET",
          dataType:'json',
          data:{start: start_date, end: end_date, price:ovr_price, c_id: client_id, w_id: worker_id, service_events: service_events},
          success:function(response)
          {
            Swal.fire({
              title: "Wizyta dodana pomyślnie!",
              text: "Naciśnij przycisk aby przeładować stronę",
              icon: "success",
              showConfirmButton: true
            }).then((result) =>{
              location.reload();
            });
          },
          error:function(error)
          {
            Swal.fire('Nie udało sie dodać wizyty!', '', 'error');
          },
      })
        calendar.refetchEvents();
      }},
          //   fetch("{{ route('calendar.store') }}", {
    //     method: "POST",
    //     headers: { "Content-Type": "application/json" },
    //     body: JSON.stringify({ request_type:'addEvent', start:start.startStr, end:start.endStr, client_id: document.querySelector('#select_client').value, worker_id:document.querySelector('#select_worker').value, price: document.getElementById('overal_price').value , title: document.getElementById('name').value,}),
    //   })
    //   .then(response => response.json())
    //   .then(data => {
    //     Swal.fire(start.startStr)
    //     if (data.status == 1) {
    //     Swal.fire('Event added successfully!', '', 'success');
    //     } else {
    //     Swal.fire(data.error, '', 'error');
    //     }

    //     // Refetch events from all sources and rerender
    //     calendar.refetchEvents();
    //   })
    //   .catch(console.error);
    //   }
    // },

    eventClick: function(info) {
    // info.jsEvent.preventDefault();
    var client_services = info.event.extendedProps.events;var services_list = "";
    client_services.forEach((e)=> {
      services_list = services_list + "<li class='list-group-item'>" + e.service_name + "</li>";
    });
    // change the border color
    info.el.style.borderColor = 'black';
    Swal.fire({
      title: '</p>Klient: ' + info.event.extendedProps.name_c + ' ' +info.event.extendedProps.surname_c + "<br>Godzina: "  + info.event.start.getHours() + ":" + (info.event.start.getMinutes()<10?'0':'') + info.event.start.getMinutes() + "-" + info.event.end.getHours() + ":" + (info.event.end.getMinutes()<10?'0':'') + info.event.end.getMinutes(),
      icon: 'info',
      html:'<p><h4><b>Pracownik</b>: '+info.event.extendedProps.name_w+ ' ' + info.event.extendedProps.surname_w + '</h4><br><h3> Usługi </h3><br><ul class="list-group">'+
      '<ul class="list-group">' + services_list + '</ul>',
      showCloseButton: true,
      showCancelButton: true,
      showDenyButton: true,
      cancelButtonText: 'Wyjdź',
      confirmButtonText: 'Usuń',
      denyButtonText: 'Edytuj',
    }).then((result) => {
      if (result.isConfirmed) {
        // Delete event
        $.ajax({
          url:"{{ route('calendar.delete') }}",
          type:"GET",
          dataType:'json',
          data:{event_id:info.event.id},
          success:function(response)
          {
            var id = response.id
            Swal.fire({
              title: "Wizyta usunięta pomyślnie!",
              text: "Naciśnij przycisk aby przeładować stronę",
              icon: "success",
              showConfirmButton: true
            }).then((result) =>{
              location.reload();
            });
            calendar.refetchEvents();
          },
          error:function(error)
          {
            Swal.fire('Nie udało sie usunąć wizyty!', '', 'error');
          },
      })


        // fetch("sql/eventHandler.php", {
        //   method: "POST",
        //   headers: { "Content-Type": "application/json" },
        //   body: JSON.stringify({ request_type:'deleteEvent', event_id: info.event.id}),
        // })
        // .then(response => response.json())
        // .then(data => {
        //   if (data.status == 1) {
        //     Swal.fire('Event deleted successfully!', '', 'success');
        //   } else {
        //     Swal.fire(data.error, '', 'error');
        //   }

        //   // Refetch events from all sources and rerender
        //   calendar.refetchEvents();
        // })
        // .catch(console.error);
      } else if (result.isDenied) {
        // Edit and update event
        var date_s = info.event.start;var date_iso_s = date_s.toISOString();var date_one_s = date_iso_s.split("T")[0];var date_two_s = date_iso_s.split("T")[1].split(".")[0];
        var full_date_start = date_one_s + " " + date_two_s;
        var date_e = info.event.end;var date_iso_e = date_e.toISOString();var date_one_e = date_iso_e.split("T")[0];var date_two_e = date_iso_e.split("T")[1].split(".")[0];
        var full_date_end = date_one_e + " " + date_two_e;
          Swal.fire({
          title: 'Edytuj Wizytę',
          html:
          '<label for="input_client">Wybierz Klienta z listy</label>'+
        '<select id ="select_client" class="form-control form-control-sm">'+
            @foreach ($clients as $client)
              '<option id = "{{$client->phone}}" value = "{{ $client->id }}">{{ $client->first_name }}  {{ $client->last_name }} </option>'+
            @endforeach
        '</select>'+
        '<label for="input_worker">Wybierz Pracownika</label>'+
        '<select id ="select_worker" class="form-control form-control-sm">'+
          @foreach($workers as $worker)
          '<option id = " worker" value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>'+
          @endforeach
        '</select>'+
        '<form class="container">'+
          '<div class="row">'+
              '<div class="col-sm-12 col-xs-12">'+
                '<p class="font-weight-bold">Usługi</p>'+
                  '<div data-toggle="buttons">'+
                      @foreach($services as $service)
                      '<label name= "components_label" value_name = "{{ $service->service_name }}" value = "{{ $service->price }}" class="btn btn-block btn-danger" id = "{{ $service->id }}" onclick ="start(this.id)" >'+
                          '<input name= "components" value = "{{ $service->id }}" class="btn btn-block btn-danger" style = "display:none;" type="checkbox" id = "service-checkbox-"{{ $service->id }}"-input" name="{{ $service->id }}" >' +
                          '{{ $service->service_name }} | {{ $service->price }} zł'+
                      '</label>'+
                      @endforeach
                    '</div>'+ 
                '</div>'+
          '</div>'+
          '<p class="font-weight-bold">Czas Usługi</p>'+
          '<div class="datetimepicker">'+
          '<span class="input-group-text" id="basic-addon1">Od</span>'+
          '<input type="datetime-local" id="date_start" name="Test" class="form-control" format-value="YYYY-MM-DDTHH:mm:ss" value = "'+full_date_start+'"  />'+
         '</div>'+
         '<p class="font-weight-bold"></p>'+
         '<div class="datetimepicker">'+
            '<span class="input-group-text" id="basic-addon1">Do</span>'+
            '<input type="datetime-local" id="date_end" name="Test" class="form-control" format-value="YYYY-MM-DDTHH:mm:ss" value = "'+full_date_end+'"  />'+
         '</div>'+
         '<p class="font-weight-bold">Kwota</p>'+
         '<div class="input-group mb-3">'+
          '<div class="input-group-prepend">'+
            '<span class="input-group-text">Kwota Końcowa:</span>'+
         '</div>'+
          '<input type="number" value = "0" id = "overal_price" class="form-control" aria-label="Cena">'+
          '<div class="input-group-append">'+
            '<span class="input-group-text">zł</span>'+
          '</div>'+
        '</div>',
          focusConfirm: false,
          confirmButtonText: 'Submit',
          preConfirm: () => {
          return [
            document.getElementById('swalEvtTitle_edit').value,
            document.getElementById('swalEvtDesc_edit').value,
            document.getElementById('swalEvtURL_edit').value
          ]
          }
        }).then((result) => {
          if (result.value) {
            // Edit event
          $.ajax({
              url:"{{ route('calendar.update') }}",
              type:"GET",
              dataType:'json',
              data:{event_id:info.event.id},
              success:function(response)
              {
                var id = response.id
                Swal.fire({
                  title: "Wizyta usunięta pomyślnie!",
                  text: "Naciśnij przycisk aby przeładować stronę",
                  icon: "success",
                  showConfirmButton: true
                }).then((result) =>{
                  location.reload();
                });
                calendar.refetchEvents();
              },
              error:function(error)
              {
                Swal.fire('Nie udało sie usunąć wizyty!', '', 'error');
              },
          })
          
            fetch("eventHandler.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ request_type:'editEvent', start:info.event.startStr, end:info.event.endStr, event_id: info.event.id, event_data: result.value})
            })
            .then(response => response.json())
            .then(data => {
              if (data.status == 1) {
                Swal.fire('Event updated successfully!', '', 'success');
              } else {
                Swal.fire(data.error, '', 'error');
              }

              // Refetch events from all sources and rerender
              calendar.refetchEvents();
            })
            .catch(console.error);
          }
        });
      } else {
        Swal.close();
      }
    });
  }

  });
    calendar.render();
    calendar.changeView(initialView);
  });



</script>


  <div style = "width:75%; height:50%; margin-top:4%; margin-left:15%;" id = "calendar"></div>

  
@endsection

