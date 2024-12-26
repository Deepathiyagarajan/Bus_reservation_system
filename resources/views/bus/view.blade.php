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
            padding: 15px;
        }

        .card-body {
            padding: 2rem;
        }

        .btn {
            font-size: 1rem;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .btn-info:hover {
            background-color: #138496;
            transform: translateY(-3px);
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
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

        .list-group-item {
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background-color: #f8f9fa;
            transition: transform 0.2s;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
        }

        .list-group-item h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .list-group-item p {
            font-size: 0.9rem;
            color: #777;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }

            .list-group-item {
                padding: 12px;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Bus List</span>
                        <a href="{{ route('home') }}" class="btn btn-danger btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h3 class="mb-4">List of Buses</h3>

                        <ul class="list-group">
                            @foreach ($buses as $bus)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>{{ $bus->bus_name }}</h5>
                                        <p>{{ $bus->from }} -> {{ $bus->to }}</p>
                                        <p>Price: {{ $bus->price }}</p>
                                    </div>

                                    <div>
                                        <a href="{{ route('bus.show', $bus->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('bus.edit', $bus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

