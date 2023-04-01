
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
    editable:true,
    select: async function (start, end, allDay) {
      const { value: formValues } = await Swal.fire({
      title: 'Dodaj wizytę',
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
      showConfirmButton: true,
      showCancelButton: true,
      cancelButtonText: 'Wyjdź',
      confirmButtonText: 'Zapisz',
      focusConfirm: false,
      });
      if (formValues){
        var start_date = document.getElementById('date_start').value;var end_date = document.getElementById('date_end').value;var ovr_price = document.getElementById('overal_price').value;
        var client_id = document.querySelector('#select_client').value;var worker_id = document.querySelector('#select_worker').value;        var service_events = values();
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
      eventRender: function (event, el, view) {
      },
      eventResize: function(event) {
        var id = event.event.id;
        var start_date = moment(event.event.start).format("YYYY-MM-DD h:mm:ss")
        var end_date = moment(event.event.end).format("YYYY-MM-DD h:mm:ss")
        $.ajax({
                url:"{{ route('calendar.update')}}",
                type:"GET",
                dataType:'json',
                data:{event_id: id, start: start_date, end:end_date},
                success:function(response)
                {
                  Swal.fire({
                  title: "Czas wizyty edytowany pomyślnie!",
                  text: "Naciśnij przycisk aby przeładować stronę",
                  icon: "success",
                  showConfirmButton: true
                }).then((result) =>{
                  location.reload();
                });
                },
                error:function(error)
                {
                    console.log(error)
                },
            });
      },
      eventDrop: function(event) {
        var id = event.event.id;
        var start_date = moment(event.event.start).format("YYYY-MM-DD hh:mm:ss")
        var end_date = moment(event.event.end).format("YYYY-MM-DD hh:mm:ss")
        $.ajax({
                url:"{{ route('calendar.update')}}",
                type:"GET",
                dataType:'json',
                data:{event_id: id, start: start_date, end:end_date},
                success:function(response)
                {
                  Swal.fire({
                  title: "Czas wizyty edytowany pomyślnie!",
                  text: "Naciśnij przycisk aby przeładować stronę",
                  icon: "success",
                  showConfirmButton: true
                }).then((result) =>{
                  location.reload();
                });
                },
                error:function(error)
                {
                    console.log(error)
                },
            });
    },
    eventClick: function(info) {
    var client_services = info.event.extendedProps.events;var services_list = "";
    client_services.forEach((e)=> {
      services_list = services_list + "<li class='list-group-item'>" + e.service_name + "</li>";
    });
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
      } else if (result.isDenied) {
        var start_date = moment(info.event.start).format("YYYY-MM-DD hh:mm:ss")
        var end_date = moment(info.event.end).format("YYYY-MM-DD hh:mm:ss")
          Swal.fire({
          title: 'Edytuj Wizytę Klienta: <br> '+ info.event.extendedProps.name_c + ' ' +info.event.extendedProps.surname_c ,
          html:
        '<label for="input_worker">Zmień Pracownika</label>'+
        '<select id ="select_worker" class="form-control form-control-sm">'+
          @foreach($workers as $worker)
          '<option id = " worker" value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>'+
          @endforeach
        '</select>'+
        '<form class="container">'+
          '<p class="font-weight-bold">Czas Usługi</p>'+
          '<div class="datetimepicker">'+
          '<span class="input-group-text" id="basic-addon1">Od</span>'+
          '<input type="datetime-local" id="date_start" name="Test" class="form-control" format-value="YYYY-MM-DD h:mm:ss" value = "'+start_date+'"  />'+
         '</div>'+
         '<p class="font-weight-bold"></p>'+
         '<div class="datetimepicker">'+
            '<span class="input-group-text" id="basic-addon1">Do</span>'+
            '<input type="datetime-local" id="date_end" name="Test" class="form-control" format-value="YYYY-MM-DD h:mm:ss" value = "'+end_date+'"  />'+
         '</div>',
          focusConfirm: false,
          showConfirmButton: true,
          showCancelButton: true,
          cancelButtonText: 'Wyjdź',
          confirmButtonText: 'Zapisz',
        }).then((result) => {
          if (result.value) {
            var start_date = document.getElementById('date_start').value;
            var end_date = document.getElementById('date_end').value;
            var worker_id = document.querySelector('#select_worker').value;
          $.ajax({
              url:"{{ route('calendar.edit') }}",
              type:"GET",
              dataType:'json',
              data:{event_id:info.event.id, start : start_date, end: end_date, w_id : worker_id},
              success:function(response)
              {
                Swal.fire({
                  title: "Wizyta usunięta pomyślnie!",
                  text: "Naciśnij przycisk aby przeładować stronę",
                  icon: "success",
                  showConfirmButton: true,
                }).then((result) =>{
                  location.reload();
                });
                calendar.refetchEvents();
              },
              error:function(error)
              {
                Swal.fire('Nie udało sie edytować wizyty!', '', 'error');
              },
          })
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


  <div class = "border border-3" id = "calendar"></div>


@endsection

