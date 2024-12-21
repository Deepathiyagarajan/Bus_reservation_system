@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-success {
            border-radius: 30px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn {
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .card-header {
            background-color: #3f72af;
            color: #ffffff;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px 12px 0 0;
            padding: 15px;
        }

        @media (max-width: 576px) {
            .card-header h2 {
                font-size: 1.25rem;
            }

            .btn {
                font-size: 0.9rem;
            }

            .card-title {
                font-size: 1rem;
            }
        }
    </style>
    <div class="container">
        <div class="card-header d-flex justify-content-between align-items-center my-4 p-3 text-white rounded">
            <h2 class="mb-0">Available Buses</h2>
            <a href="{{ route('home') }}" class="btn btn-danger">Back</a>
        </div>

        <div class="row g-4">
            @foreach ($buses as $bus)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $bus->bus_name }}</h5>
                            <p class="mb-2">
                                <span class="fw-bold">Total Seats:</span> {{ $bus->total_seat }}
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold">From:</span> {{ $bus->from }}
                            </p>
                            <p class="mb-3">
                                <span class="fw-bold">To:</span> {{ $bus->to }}
                            </p>
                            <form action="{{ route('bus.select', $bus->id) }}" method="get">
                                @csrf
                                <input type="text" name="journey_date" value="{{ $date }}" hidden>
                                <button type="submit" class="btn btn-success w-100">Book Tickets</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
