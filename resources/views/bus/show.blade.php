@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .card-header {
            background-color: #3f72af;
            color: #ffffff;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px 12px 0 0;
            padding: 15px;
        }

        .card-body {
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .btn {
            font-size: 1rem;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
        }

        h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        strong {
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }

            h3 {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Bus Details</span>
                        <a href="{{ route('bus.view') }}" class="btn btn-danger btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <h3>Bus Name: {{ $bus->bus_name }}</h3>
                        <p><strong>Total Seats:</strong> {{ $bus->total_seat }}</p>
                        <p><strong>From:</strong> {{ $bus->from }}</p>
                        <p><strong>To:</strong> {{ $bus->to }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

