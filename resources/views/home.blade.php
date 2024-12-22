@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Include DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <!-- JS Libraries for PDF & Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

    <style>
        /* Your existing styles */
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">
                        <h3>{{ __('Dashboard') }}</h3>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Bus List</span>
                        <a href="{{ route('home') }}" class="btn btn-danger btn-sm">Back</a>
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

                        <!-- Search Form (For Journey Date) -->
                       <form action="{{ route('bus.submitBooking') }}" method="POST" class="text-center" autocomplete="off">
    @csrf
    <div class="form-group">
        <label for="journey_date" class="text-muted">Select Journey Date</label>
        <input type="text" name="journey_date" id="journey_date"
            class="form-control flatpickr-input" placeholder="Choose Date" required>
    </div><br>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-search text-white"> </i> Find Bus
    </button>
</form>


                        <br>

                        <!-- Filter Form (Separate Filter Button) -->
                        <div class="text-center mb-3">
                            <label for="searchFilter">Filter by Name or Bus:</label>
                            <input type="text" id="searchFilter" class="form-control" placeholder="Search by Name or Bus Name">
                            <button type="button" class="btn btn-success mt-2" id="filterBtn">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>

                        <!-- DataTable for booking details -->
                        @if($booking_details->count() > 0)
                            <table id="bookingTable" class="display">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Name</th>
                                        <th>Bus Name</th>
                                        <th>Tickets Count</th>
                                        <th>Journey Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sno = 1; @endphp
                                    @foreach ($booking_details as $booking_detail)
                                        <tr>
                                            <td>{{ $sno++ }}</td>
                                            <td>{{ $booking_detail->user_name }}</td>
                                            <td>{{ $booking_detail->bus_name }}</td>
                                            <td>{{ $booking_detail->ticket_count }}</td>
                                            <td>{{ $booking_detail->booking_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center mt-4 text-muted">No booking details available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#bookingTable').DataTable({
                searching: true,  // Enable the built-in search functionality
                paging: true,     // Enable pagination
                ordering: true,   // Enable sorting on columns
                info: true,       // Show table info (e.g., showing x to y of z entries)

                // Add buttons for export functionality
                dom: 'Bfrtip',  // Specify the position of the buttons
                buttons: [
                    {
                        extend: 'excelHtml5',  // Excel export
                        title: 'Booking Details',  // Title of the exported file
                        className: 'btn btn-success'  // Button style
                    },
                    {
                        extend: 'pdfHtml5',  // PDF export
                        title: 'Booking Details',  // Title of the exported file
                        className: 'btn btn-danger'  // Button style
                    }
                ]
            });

            // Apply custom filtering on button click
            $('#filterBtn').on('click', function() {
                var filterValue = $('#searchFilter').val();  // Get the value from the filter input field
                table.search(filterValue).draw();  // Apply the search filter to the table
            });

            // Handling the form submission via AJAX
            $('form').on('submit', function(e) {
                e.preventDefault();  // Prevent default form submission
                var formData = $(this).serialize();  // Serialize the form data

                $.ajax({
                    url: "{{ route('bus.submitBooking') }}",  // Your booking submission route
                    type: 'POST',
                    data: formData,
                    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token header
        },
                    success: function(response) {
                        // If booking is successful, update the DataTable
                        if (response.success) {
                            // Add the new booking details to the table
                            table.row.add([
                                table.rows().count() + 1,  // S No (incremented)
                                response.booking.user_name,
                                response.booking.bus_name,
                                response.booking.ticket_count,
                                response.booking.booking_date
                            ]).draw(false);  // Redraw the table without resetting the page

                            // Optionally, reset the form
                            $('form')[0].reset();

                            // Show a success message
                            alert('Booking successful!');
                        } else {
                            alert('Booking failed. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);  // Log the error response for debugging
            alert('There was an error. Please try again.');
        }
                });
            });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#journey_date", {
                dateFormat: "d-m-Y",
                minDate: "today",
                allowInput: true
            });
        });
           
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
