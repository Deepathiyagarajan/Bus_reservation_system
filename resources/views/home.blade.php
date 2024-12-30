@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body {
            background: url('{{ asset('storage/images/Bus-Online-Booking-System.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Nunito', sans-serif;
            color: #ffffff;
        }

        .blur-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(8px);
            z-index: -1;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: rgba(63, 114, 175, 0.8);
            color: #ffffff;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .card-body {
            padding: 2rem;
        }

        .btn {
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #3f72af;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2a4a7f;
            transform: translateY(-3px);
        }

        .btn-success {
            background-color: #6ab04c;
            border: none;
        }

        .btn-success:hover {
            background-color: #4e8e3b;
            transform: translateY(-3px);
        }

        .btn-secondary {
            background-color: #f0ad4e;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #e08533;
            transform: translateY(-3px);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 30px;
            padding: 10px 15px;
            font-size: 1rem;
            width: 100%;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #3f72af;
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color:black;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3f72af;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }

            .form-control {
                font-size: 0.9rem;
                padding: 8px 12px;
            }
        }


        .dataTables_wrapper{
            color: black !important;
        }

    </style>

    <div class="blur-background"></div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ ('Dashboard') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (Auth::user()->role == 1)
                            <div class="mb-4 text-center">
                                <a href="{{ route('bus.add') }}" class="btn btn-success mr-3">
                                    <i class="fas fa-plus-circle"></i> Add Bus
                                </a>
                                <a href="{{ route('bus.view') }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> View Bus
                                </a>
                            </div>
                        @endif

                        <form action="{{ route('bus.list') }}" method="get" class="text-center" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="journey_date" class="text-muted">Select Journey Date</label>
                                <input type="text" name="journey_date" id="journey_date"
                                    class="form-control flatpickr-input" placeholder="Choose Date" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search text-white"> </i> Find Bus
                            </button>
                        </form>
                        <br>
                        <div class="filter-container">
                            <input type="text" id="userFilter" placeholder="Search by name...">
                            <input type="text" id="busFilter" placeholder="Search by bus name..."><br><br>
                            <button id="filterBtn" class="btn btn-secondary">Apply Filter</button>
                            <button id="resetBtn" class="btn btn-primary">Reset Filter</button>
                        </div>
                        <br>

                        <table id="bookingTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Name</th>
                                    <th>Bus Name</th>
                                    <th>Tickets Count</th>
                                    <th>Journey Date</th>
                                    <th>Ticket Price</th>
                                    <th>Total Price</th>

                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script>
    $(document).ready(function () {
        var table = $('#bookingTable').DataTable({
            processing: true,
            serverSide: true,
            // searching:true,
            ajax: "{{ route('booking.details.ajax') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user_name', name: 'user_name' },
                { data: 'bus_name', name: 'bus_name' },
                { data: 'ticket_count', name: 'ticket_count' },
                { data: 'booking_date', name: 'booking_date' },
                { data: 'price', name: 'price'},
                { data: 'total_price', name: 'total_price'},


            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn btn-success export-excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF',
                    className: 'btn btn-primary export-pdf'
                }
            ]

        });

        $('#filterBtn').on('click', function () {
            var userFilter = $('#userFilter').val();
            var busFilter = $('#busFilter').val();

            table.column(1).search(userFilter).column(2).search(busFilter).draw();
        });

        $('#resetBtn').on('click', function () {
            $('#userFilter').val('');
            $('#busFilter').val('');
            table.search('').columns().search('').draw();
        });

        flatpickr("#journey_date", {
            dateFormat: "d-m-Y",
            minDate: "today",
            allowInput: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#journey_date').validate({
              rules:{
                 journey_date: {
                    required:true,
                    minlength:5
                 }
              },
              messages:{
                 journey_date: {
                    required: "Please choose the date",
                    minlength: "Date must be atleast 6 length"
                 }
              },
              errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".mb-3").append(error);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
        });
    });
</script>

@endsection
