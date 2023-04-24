
@extends('layout')


@section('content')
    <link href = "{{url('css/style.css')}}" rel = "stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://kit.fontawesome.com/3133d360bd.js" crossorigin="anonyous"></script>

  <div class = "border border-3" id = "calendar"></div>

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
                  $('#modalAddVisit').modal('show');
                  $('#modalAddVisit #date_start').attr('value', moment(start.startStr).format("YYYY-MM-DDThh:mm"))
                  $('#modalAddVisit #date_end').attr('value', moment(start.endStr).format("YYYY-MM-DDThh:mm"))
              },
              eventRender: function (event, el, view) {
              },
              eventResize: function(event) {
                  $.ajax({
                      url:"{{ route('calendar.update')}}",
                      type:"GET",
                      dataType:'json',
                      data:{event_id: event.event.id, start: moment(event.event.start).format("YYYY-MM-DD h:mm:ss"), end:moment(event.event.end).format("YYYY-MM-DD h:mm:ss")},
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
                          '<ul class="list-group">' + services_list + '</ul>'+
                          '<button type="button" class="btn btn-success btn-rounded" data-mdb-toggle="modal" data-mdb-target="#modal_editCalendar">Edytuj Usługę</button>',
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
                                  ' <select class="form-control form-control-sm">>'+
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

  <div class="modal fade" id="modal_editCalendar" tabindex="-1" aria-labelledby="modal_editCalendar" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modal_editCalendar">Dodaj nową usługę</h5>
              </div>
              <div class="modal-body">
                  <form action="{{ route('services.store') }}" enctype="multipart/form-data" method="POST">
                      @csrf
                      <div class="d-flex flex-column align-items-center text-center">
                          <h4 class="text-center">Wybierz zdjęcie</h4>
                      </div>
                      <div class="d-flex justify-content-center">
                          <select class="selectpicker" name = "select_icon_service" data-live-search="true">
                              <option data-tokens="IC1" value = "dye.jpg" data-content="<img src='{{asset('png/services_icons/dye.jpg')}}' style='width: 50%;'><span class='badge badge-primary'>IC 1</span>"></option>
                              <option data-tokens="IC2" value = "scissors.png" data-content="<img src='{{asset('png/services_icons/scissors.png')}}' style='width: 50%;'><span class='badge badge-primary'>IC 2</span>"></option>
                              <option data-tokens="IC3" value = "swithp.jpg" data-content="<img src='{{asset('png/services_icons/swithp.jpg')}}' style='width: 50%;'><span class='badge badge-primary'>IC 3</span>"></option>
                          </select>
                      </div>
                      <div class="p-3 py-5">
                          <div class="d-flex flex-column align-items-center text-center">
                              <h4 class="text-center">Wprowadź dane</h4>
                          </div>
                          <div class = "row">
                              <div class="col-md-7 mb-2 pb-2">
                                  <div class="form-outline mb-3">
                                      <input type="text" id="service_name" name = "service_name"  class="form-control form-control" />
                                      <label class="form-label" for="service_name">Nazwa Usługi</label>
                                  </div>
                              </div>

                              <div class="col-md-3 mb-2 pb-2">
                                  <div class="form-outline mb-3">
                                      <input type="number" id="price" name = "price" class="form-control form-control" />
                                      <label class="form-label" for="price">Cena</label>
                                  </div>
                              </div>

                              <div class="col-md-2 mb-2 pb-2">
                                  <input disabled type="text" placeholder="zł" id="price_zł" name = "price_zl"  class="form-control form-control" />
                              </div>

                              <div class="d-flex flex-column align-items-center text-center">
                                  <button type="submit" class="btn btn-success btn-rounded">
                                      Potwierdź
                                  </button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Zamknij</button>
          </div>
      </div>
  </div>

  <div class="modal fade" id="modalAddVisit" tabindex="-1" aria-labelledby="modal_editCalendar" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 id="modalTitle" class="modal-title">Dodaj wizyte do kalendarza</h4>
              </div>
              <div id="modalBody" class="modal-body">
                  <label for="input_client">Wybierz Klienta z listy</label>
                  <select id ="select_client" class="form-control selectpicker">
                      @foreach ($clients as $client)
                          <option id = "{{$client->phone}}" value = "{{ $client->id }}">{{ $client->first_name }}  {{ $client->last_name }} </option>
                      @endforeach
                      </select>
                  <label for="input_worker">Wybierz Pracownika</label>
                  <select id ="select_worker" class="form-control selectpicker">
                      @foreach($workers as $worker)
                          <option id = " worker" value = "{{ $worker->id }}"> {{ $worker->first_name }} {{ $worker -> last_name }}</option>
                      @endforeach
                  </select>
                  <label for="select_services">Wybierz Usługi z listy</label>
                      <select id ="select_services" showSubtext class="selectpicker form-control" data-live-search="true" title='Wybierz usługi z listy...' multiple="multiple">
                      @foreach($services as $service)
                         <option class="services" data-subtext="{{ $service->price }} zł" id = "worker_{{$service->id}}" value = "{{ $service->price }}"> {{ $service->service_name }}</option>
                      @endforeach
                      </select>
                  <p class="font-weight-bold">Czas Usługi</p>
                  <div class = "row">
                      <div class="col-md-6 mb-2 pb-2">
                          <div class="datetimepicker">
                              <span class="input-group-text" id="basic-addon1">Od</span>
                              <input type="datetime-local" id="date_start" name="date_start" class="form-control" />
                          </div>
                      </div>
                      <div class="col-md-6 mb-2 pb-2">
                          <div class="datetimepicker">
                              <span class="input-group-text" id="basic-addon1">Do</span>
                              <input type="datetime-local" id="date_end" name="date_end" class="form-control"/>
                          </div>
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Kwota Końcowa:</span>
                          </div>
                      <input type="number" value = "0" id = "overal_price" class="form-control" aria-label="Cena">
                      <div class="input-group-append">
                          <span class="input-group-text">zł</span>
                          </div>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>


  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@endsection

