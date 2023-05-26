
@extends('layout')


@section('content')
    <link href = "{{url('css/style.css')}}" rel = "stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://kit.fontawesome.com/3133d360bd.js" crossorigin="anonyous"></script>


    <div class = "row">

        <div class="container rounded-3 bg-white opacity-90 mb-5 w-50">
            <div class = "d-flex flex-column align-items-center text-center">
                <ul class="list-inline">
                @foreach($workers as $worker)
                    <li class = "list-inline-item">
                        <input class="filter form-check-input" id ="workers_filter" type="checkbox" value="{{$worker->last_name}}_{{$worker->id}}" checked>
                        {{ $worker->first_name }} {{ $worker -> last_name }}
                        <i class="fa-solid fa-palette" style="color: {{$worker->color}};"></i>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

      <div id = "calendar"></div>

    </div>

  <script>

      function showLoadingMessage() {

          Swal.fire({
              title: "HairLink <i class='fa-solid fa-spinner fa-spin-pulse'></i>",
              text: "Ładowanie danych",
              showConfirmButton: false
          }).then((result) => {
              calendar.refetchEvents();
          });
      }

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      showLoadingMessage();
      // document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var initialView = 'timeGridWeek';
          var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: ['interaction', 'dayGrid', 'timeGrid', 'list',],
              initialView: 'timeGridWeek',
              locale: 'pl',
              header: {
                  left: 'prev,next,today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
              },
              height: 650,
              events: {url: '/calendar.events'},
              minTime: '06:00',
              maxTime: '21:00',
              selectable: true,
              editable: true,
              select: async function (start, end, allDay) {
                  @if(auth()->user()->is_admin)
                    showOptionsAdmin(start.startStr, start.endStr, start.start.getDay());
                  @else
                      resetSelects();
                      $('#modalAddVisit').modal('show');
                      $('#modalAddVisit #date_start').attr('value', moment(start.startStr).format("YYYY-MM-DDTHH:mm"))
                      $('#modalAddVisit #date_end').attr('value', moment(start.endStr).format("YYYY-MM-DDTHH:mm"))
                      calculateTime();
                  @endif
              },

              eventRender: function (event) {
                  const eventPath = event.event;

                  event.el.querySelector('.fc-title').textContent = eventPath.extendedProps.name_c + ' ' + eventPath.extendedProps.surname_c;

                  var username = $('input:checkbox.filter:checked').map(function() {
                      return $(this).val();
                  }).get();
                  var getIndex = eventPath.extendedProps.surname_w + "_" + eventPath.extendedProps.worker_id;
                  show_username = username.indexOf(getIndex) >= 0;

                  if (show_username) {
                      hideLoadingMessage();
                      return true;
                  } else {
                      hideLoadingMessage();
                      return false;
                  }
                  // return show_username
              },

              eventResize: function (event) {
                  @if(auth()->user()->is_admin)
                  $.ajax({
                      url: "{{ route('calendar.update')}}",
                      type: "GET",
                      dataType: 'json',
                      data: {
                          event_id: event.event.id,
                          start: moment(event.event.start).format("YYYY-MM-DDTHH:mm:ss"),
                          end: moment(event.event.end).format("YYYY-MM-DDTHH:mm:ss")
                      },
                      success: function (response) {
                          Swal.fire({
                              title: "Czas wizyty edytowany pomyślnie!",
                              text: "HairLink",
                              icon: "success",
                              showConfirmButton: false
                          }).then((result) => {
                              calendar.refetchEvents();
                          });
                          calendar.refetchEvents();
                      },
                      error: function (error) {
                          console.log(error)
                      },
                  });
                  @else
                      Swal.fire({
                          title: "Edycja niedostępna!",
                          text: "Jeżeli chcesz zmienić date skontaktuj się z pracownikiem",
                          icon: "warning",
                          showConfirmButton: true
                      }).then((result) => {
                          calendar.refetchEvents();
                      });
                  @endif
              },
              eventDrop: function (event) {
                  @if(auth()->user()->is_admin)
                  var id = event.event.id;
                  var start_date = moment(event.event.start).format("YYYY-MM-DDTHH:mm:ss")
                  var end_date = moment(event.event.end).format("YYYY-MM-DDTHH:mm:ss")
                  $.ajax({
                      url: "{{ route('calendar.update')}}",
                      type: "GET",
                      dataType: 'json',
                      data: {event_id: id, start: start_date, end: end_date},
                      success: function (response) {
                          Swal.fire({
                              title: "Czas wizyty edytowany pomyślnie!",
                              text: "HairLink",
                              icon: "success",
                              showConfirmButton: false
                          }).then((result) => {
                              calendar.refetchEvents();
                          });
                          calendar.refetchEvents();
                      },
                      error: function (error) {
                          console.log(error)
                      },
                  });
                  @else
                      Swal.fire({
                          title: "Edycja niedostępna!",
                          text: "Jeżeli chcesz zmienić date skontaktuj się z pracownikiem",
                          icon: "warning",
                          showConfirmButton: true
                      }).then((result) => {
                          calendar.refetchEvents();
                      });
                  @endif
              },
              eventClick: function (info) {
                  var client_services = info.event.extendedProps.events;
                  var services_list = "";
                  client_services.forEach((e) => {
                      services_list = services_list + "<li class='list-group-item'>" + e.service_name + "</li>";
                  });
                  info.el.style.borderColor = 'black';
                  @if(auth()->user()->is_admin)
                      Swal.fire({
                          title: '</p>Klient: ' + info.event.extendedProps.name_c + ' ' + info.event.extendedProps.surname_c + "<br>Godzina: " + info.event.start.getHours() + ":" + (info.event.start.getMinutes() < 10 ? '0' : '') + info.event.start.getMinutes() + "-" + info.event.end.getHours() + ":" + (info.event.end.getMinutes() < 10 ? '0' : '') + info.event.end.getMinutes(),
                          icon: 'info',
                          html: '<p><h4><b>Pracownik</b>: ' + info.event.extendedProps.name_w + ' ' + info.event.extendedProps.surname_w + '</h4><br><h3> Usługi </h3><br><ul class="list-group">' +
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
                                  url: "{{ route('calendar.delete') }}",
                                  type: "GET",
                                  dataType: 'json',
                                  data: {event_id: info.event.id},
                                  success: function (response) {
                                      Swal.fire({
                                          title: "Wizyta usunięta pomyślnie!",
                                          text: "HairLink",
                                          icon: "success",
                                          showConfirmButton: false
                                      }).then((result) => {
                                          calendar.refetchEvents();
                                      });
                                      calendar.refetchEvents();
                                  },
                                  error: function (error) {
                                      Swal.fire('Nie udało sie usunąć wizyty!', '', 'error');
                                  },
                              })
                          } else if (result.isDenied) {
                              var start_date = moment(info.event.start).format("YYYY-MM-DDTHH:mm:ss")
                              var end_date = moment(info.event.end).format("YYYY-MM-DDTHH:mm:ss")
                              Swal.fire({
                                  title: 'Edytuj Wizytę Klienta: <br> ' + info.event.extendedProps.name_c + ' ' + info.event.extendedProps.surname_c,
                                  html:
                                      '<label for="input_worker">Zmień Pracownika</label>' +
                                      ' <select id = "worker_id_edit" class="form-control form-control-sm">>' +
                                      @foreach($workers as $worker)
                                          '<option value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>' +
                                      @endforeach
                                          '</select>' +
                                      '<form class="container">' +
                                      '<button type = "button" data-toggle="tooltip" data-placement="top" title="Czas usługi można zmieniać również poprzez przeciąganie w kalendarzu" >Czas Usługi</button>' +
                                      '<div class = "row">' +
                                      '   <div class="col-md-1"></div>' +
                                      '   <div class="col-md-4">' +
                                      '       <h4>Poczatęk</h4>' +
                                      '   </div>' +
                                      '   <div class="col-md-2"></div>' +
                                      '   <div class="col-md-3">' +
                                      '       <h4>Koniec</h4>' +
                                      '   </div>' +
                                      '   <div class="col-md-2"></div>' +
                                      '   <div class = "row">' +
                                      '       <div class="col-md-6 mb-1">' +
                                      '           <div class="datetimepicker">' +
                                      '               <input type="datetime-local" style="font-size:1rem;" value = "' + start_date + '" id="date_start_edit" name="date_start_edit" class="form-control" />' +
                                      '           </div>' +
                                      '       </div>' +
                                      '       <div class="col-md-6 mb-1">' +
                                      '           <div class="datetimepicker">' +
                                      '               <input type="datetime-local" style="font-size:1rem;" id="date_end_edit" value = "' + end_date + '" name="date_end_edit" class="form-control"/>' +
                                      '           </div>' +
                                      '       </div>' +
                                      '   </div>',
                                  focusConfirm: false,
                                  showConfirmButton: true,
                                  showCancelButton: true,
                                  cancelButtonText: 'Wyjdź',
                                  confirmButtonText: 'Zapisz',
                              }).then((result) => {
                                  if (result.value) {
                                      var start_date = document.getElementById('date_start_edit').value;
                                      var end_date = document.getElementById('date_end_edit').value;
                                      var worker_id = document.querySelector('#worker_id_edit').value;
                                      $.ajax({
                                          url: "{{ route('calendar.edit') }}",
                                          type: "GET",
                                          dataType: 'json',
                                          data: {
                                              event_id: info.event.id,
                                              start: moment(start_date).format("YYYY-MM-DDTHH:mm:ss"),
                                              end: moment(end_date).format("YYYY-MM-DDTHH:mm:ss"),
                                              w_id: worker_id
                                          },
                                          success: function (response) {
                                              Swal.fire({
                                                  title: "Wizyta edytowana pomyślnie!",
                                                  text: "HairLink",
                                                  icon: "success",
                                                  showConfirmButton: false,
                                              }).then((result) => {
                                                  calendar.refetchEvents();
                                              });
                                              calendar.refetchEvents();
                                          },
                                          error: function (error) {
                                              Swal.fire('Nie udało sie edytować wizyty!', '', 'error');
                                          },
                                      })
                                  }
                              });
                          } else {
                              Swal.close();
                          }
                      });
              @else
              Swal.fire({
                  title: '</p>Klient: ' + info.event.extendedProps.name_c + ' ' + info.event.extendedProps.surname_c + "<br>Godzina: " + info.event.start.getHours() + ":" + (info.event.start.getMinutes() < 10 ? '0' : '') + info.event.start.getMinutes() + "-" + info.event.end.getHours() + ":" + (info.event.end.getMinutes() < 10 ? '0' : '') + info.event.end.getMinutes(),
                  icon: 'info',
                  html: '<p><h4><b>Pracownik</b>: ' + info.event.extendedProps.name_w + ' ' + info.event.extendedProps.surname_w + '</h4><br><h3> Usługi </h3><br><ul class="list-group">' +
                      '<ul class="list-group">' + services_list + '</ul>',
                  showCloseButton: false,
                  showCancelButton: false,
                  showDenyButton: false,
              }).then((result) =>{
              });
              @endif
              }
          });
          calendar.render();
          calendar.changeView(initialView);


      $('.filter').on('change', function() {
          showLoadingMessage();
          calendar.refetchEvents();
      });

  </script>

    <script>

        function addVisitCalendar(){
            @if(auth()->user()->is_admin)
                var selectedServices = [];
                $("#select_services option:selected").each(function() {
                    var service = {
                        id: $(this).val(),
                        name: $(this).text(),
                        price: $(this).data('price'),
                        time: $(this).data('time')
                    };
                    selectedServices.push(service);
                });
                $.ajax({
                    url:"{{ route('calendar.store') }}",
                    type:"GET",
                    dataType:'json',
                    data:{
                        client:document.getElementById("select_client").value,
                        worker : document.getElementById("select_worker").value,
                        services: selectedServices,
                        overall_price: document.getElementById("overall_price").value,
                        date_start : moment(document.getElementById("date_start").value).format("YYYY-MM-DDTHH:mm:ss"),
                        date_end: moment(document.getElementById("date_end").value).format("YYYY-MM-DDTHH:mm:ss")
                    },
                    success:function(response)
                    {
                        Swal.fire({
                            title: "Wizyta dodana pomyślnie!",
                            text: "HairLink",
                            icon: "success",
                            showConfirmButton: false,
                        }).then((result) =>{
                            calendar.refetchEvents();
                            hideModal();
                        });
                        calendar.refetchEvents();
                    },
                    error:function(error)
                    {
                        console.log(error)
                        Swal.fire('Nie udało sie dodać wizyty!', '', 'error');
                    },
                })
            @else
            addVisitCalendarClient()
            @endif
        }

        function addVisitCalendarClient(){
            var selectedServices = [];
            $("#select_services option:selected").each(function() {
                var service = {
                    id: $(this).val(),
                    name: $(this).text(),
                    price: $(this).data('price'),
                    time: $(this).data('time')
                };
                selectedServices.push(service);
            });
            $.ajax({
                url:"{{ route('calendar.store') }}",
                type:"GET",
                dataType:'json',
                data:{
                    client: {{auth()->user()->id}},
                    worker : document.getElementById("select_worker").value,
                    services: selectedServices,
                    overall_price: document.getElementById("overall_price").value,
                    date_start : moment(document.getElementById("date_start").value).format("YYYY-MM-DDTHH:mm:ss"),
                    date_end: moment(document.getElementById("date_end").value).format("YYYY-MM-DDTHH:mm:ss")
                },
                success:function(response)
                {
                    Swal.fire({
                        title: "Wizyta dodana pomyślnie!",
                        text: "HairLink",
                        icon: "success",
                        showConfirmButton: false,
                    }).then((result) =>{
                        calendar.refetchEvents();
                        hideModal();
                    });
                    calendar.refetchEvents();
                },
                error:function(error)
                {
                    console.log(error)
                    Swal.fire('Nie udało sie dodać wizyty!', '', 'error');
                },
            })
        }
    </script>


  <div class="modal fade" id="modalAddVisit" tabindex="-1" aria-labelledby="modalAddVisit" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="d-flex flex-column align-items-center text-center mt-2">
                  <h4 class="text-center">Dodaj wizytę do kalendarza <i class="fa-regular fa-calendar fa-flip" style="color: #2C3E50;"></i></h4>
              </div>
              <div id="modalBody" class="modal-body">
                  <form onsubmit="addVisitCalendar();return false">
                      @csrf
                      @if(auth()->user()->is_admin)
                          <label for="select_client">Wybierz Klienta z listy</label>
                          <select id ="select_client" data-max-options="1" name = "client" title='Wybierz Klienta z listy...' class="form-control selectpicker" data-allow-clear="true" onchange="setCustomValidity('')" oninvalid="this.setCustomValidity('Wybierz Klienta')" multiple required>
                              @foreach ($clients as $client)
                                  <option id = "client" value = "{{ $client->id }}">{{ $client->first_name }}  {{ $client->last_name }} </option>
                              @endforeach
                          </select>
                      @endif
                  <label for="select_worker">Wybierz Pracownika</label>
                  <select id ="select_worker" data-max-options="1" name = "worker" title='Wybierz Pracownika z listy...' class="form-control selectpicker" data-allow-clear="true" onchange="setCustomValidity('')" oninvalid="this.setCustomValidity('Wybierz Pracownika')" multiple required>
                      @foreach($workers as $worker)
                          <option id = "worker"  value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>
                      @endforeach
                  </select>
                  <label for="select_services">Rodzaje Usług</label>
                  <select id ="select_services" data-show-subtext="true" name = "services[]" data-actions-box="true"  onchange="setCustomValidity('')" oninvalid="this.setCustomValidity('Wybierz usługi')" class="selectpicker form-control" title='Wybierz usługi z listy...' multiple required>
                      @foreach($services as $service)
                         <option class="services" data-subtext="{{ $service->price }} zł/ {{ $service->time }} min" data-time = "{{$service->time}}" data-price = "{{$service->price}}" value = "{{ $service->id }}"> {{ $service->service_name }}</option>
                      @endforeach
                  </select>
                  <p class="font-weight-bold">Czas Usługi</p>
                  <div class = "row">
                      <div class="col-md-2"></div>
                      <div class="col-md-4">
                          <h4>Poczatęk</h4>
                      </div>
                      <div class="col-md-1"></div>
                      <div class="col-md-3">
                          <h4>Koniec</h4>
                      </div>
                      <div class="col-md-2"></div>
                  <div class = "row">
                      <div class="col-md-1 mb-4"></div>
                      <div class="col-md-5 mb-4">
                          <div class="datetimepicker">
                              @if(auth()->user()->is_admin)
                                  <input type="datetime-local" id="date_start" name="date_start" class="form-control" />
                              @else
                                <input type="datetime-local" id="date_start" name="date_start" class="form-control" disabled/>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-5 mb-4">
                          <div class="datetimepicker">
                              @if(auth()->user()->is_admin)
                                 <input type="datetime-local" id="date_end" name="date_end" class="form-control"/>
                              @else
                                 <input type="datetime-local" id="date_end" name="date_end" class="form-control" disabled/>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-1 mb-4"></div>
                  </div>
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Kwota Końcowa:</span>
                          </div>
                      @if(auth()->user()->is_admin)
                          <input type="number" value = "0" id = "overall_price" name = "overall_price" class="form-control" aria-label="Cena">
                      @else
                          <input type="number" value = "0" id = "overall_price" name = "overall_price" class="form-control" aria-label="Cena" disabled>
                      @endif
                      <div class="input-group-append">
                          <span class="input-group-text">zł</span>
                          </div>
                      </div>
                  </div>

                  <div class="modal-footer">
                      <div class="d-flex flex-column align-items-center text-center">
                          <button type="submit" class="btn btn-dark ">
                              Potwierdź
                          </button>
                      </div>
                      <button type="button" class="btn btn-info" onclick = "resetSelects()" data-bs-toggle="modal">Wyczyść</button>
                      <button type="button" class="btn btn-default" onclick = "hideModal()" data-bs-toggle="modal">Zamknij</button>
                  </div>
                  </form>
          </div>
      </div>
  </div>
  </div>

    <script>
        function showOptionsAdmin(start, end, day) {
            var start_temp = moment(start).format("HH:mm")
            var end_temp = moment(end).format("HH:mm")
            var day_string = "";
            if(day === 0){ day_string = "Niedzielę"}else if(day === 1){day_string = "Poniedziałek"}else if(day === 2){day_string = "Wtorek"}else if(day === 3){day_string = "Środe"}else if(day === 4){day_string = "Czwartek"}else if(day === 5){day_string = "Piątek"}else if(day === 6){day_string = "Sobote"}
            Swal.fire({
                title: 'HairLink Menu Kalendarza',
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Zmień dyspozycyjność',
                denyButtonText: 'Dodaj wizytę',
                cancelButtonText: 'Wyjdź',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'HairLink Dyspozycyjność',
                        text: "Czy chcesz zmienić swoją dyspozycyjność w " + day_string + " na godzinę od " + start_temp + " do " + end_temp +" ?",
                        icon: 'info',
                        showCloseButton: true,
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: 'Aktualizuj',
                        denyButtonText: 'Cofnij',
                        cancelButtonText: 'Wyjdź',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            saveAvailability(start_temp, end_temp, day, day_string);
                        }else if (result.isDenied){
                            showOptionsAdmin(start, end, day)
                        }
                    });
                }else if (result.isDenied){
                    resetSelects();
                    $('#modalAddVisit').modal('show');
                    $('#modalAddVisit #date_start').attr('value', moment(start).format("YYYY-MM-DDTHH:mm"))
                    $('#modalAddVisit #date_end').attr('value', moment(end).format("YYYY-MM-DDTHH:mm"))
                    calculateTime();
                }
            });
        }

        function saveAvailability(startTime, endTime, day, dayString) {
            $.ajax({
                url:"{{ route('worker.saveAvailability') }}",
                type:"GET",
                dataType:'json',
                data:{
                    start_time: startTime,
                    end_time: endTime,
                    day: day
                },
                success:function(response)
                {
                    console.log(response)
                    Swal.fire({
                        title: "Dyspozycyjność zaktualizowana!",
                        text: "Od teraz twoje godziny pracy w " + dayString + " to " + startTime + "-"  + endTime ,
                        icon: "success",
                        showConfirmButton: false,
                    }).then((result) =>{
                        // console.log(result)
                    });
                },
                error:function(error)
                {
                    // console.log(error)
                    Swal.fire('Nie udało sie dodać wizyty!', '', 'error');
                },
            })


        }

        function hideLoadingMessage() {
            Swal.close()
        }
        function hideModal(){
            $('#modalAddVisit').modal('hide');
        }
    </script>



  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@endsection

