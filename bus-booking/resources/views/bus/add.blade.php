@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Custom Styles */
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

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
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

        /* Error Messages */
        .alert {
            margin-bottom: 20px;
            border-radius: 12px;
        }

        /* Small screen adjustment */
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
                    <div class="card-header d-flex justify-content-between">
                        <span>Add Bus</span>
                        <a href="{{ route('home') }}" class="btn btn-danger">Back</a>
                    </div>

                    <div class="card-body">
                        <!-- Displaying errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Bus Add Form -->
                        <form method="POST" action="{{ route('bus.store') }}" autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label for="bus_name" class="form-label">Bus Name</label>
                                <input type="text" class="form-control" id="bus_name" name="bus_name"
                                    value="{{ old('bus_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="available_seats" class="form-label">Available Seats</label>
                                <input type="number" class="form-control" id="available_seats" name="available_seats"
                                    value="{{ old('available_seats') }}" required min="1">
                            </div>

                            <div class="mb-3">
                                <label for="from" class="form-label">From</label>
                                <input type="text" class="form-control" id="from" name="from"
                                    value="{{ old('from') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="to_address" class="form-label">To</label>
                                <input type="text" class="form-control" id="to_address" name="to_address"
                                    value="{{ old('to_address') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add Bus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

