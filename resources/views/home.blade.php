@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #3f72af;
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
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Dashboard') }}</h3>
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


                        @if($booking_details->count() > 0)
                            <table>
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

