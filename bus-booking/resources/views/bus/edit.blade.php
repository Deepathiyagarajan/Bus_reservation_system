@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Custom Styles */
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

        .form-label {
            font-weight: 600;
            font-size: 1rem;
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
            background-color: #2a4e84;
            transform: translateY(-3px);
        }

        .form-control {
            border-radius: 8px;
            font-size: 1rem;
            height: 45px;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.9rem;
            color: #e74c3c;
        }

        .row {
            margin-bottom: 20px;
        }

        /* Mobile responsiveness */
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }

            .card-header {
                font-size: 1.25rem;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Edit Bus Details</span>
                        <a href="{{ route('bus.view') }}" class="btn btn-danger btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <!-- Display errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Bus Edit Form -->
                        <form method="POST" action="{{ route('bus.update', $bus->id) }}">
                            @csrf
                            @method('POST') <!-- Ensure method is POST for updating -->

                            <input type="text" name="id" id="id" value="{{$bus->id}}" hidden>

                            <!-- Bus Name and Total Seats -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bus_name" class="form-label">{{ __('Bus Name') }}</label>
                                    <input id="bus_name" type="text" class="form-control @error('bus_name') is-invalid @enderror" name="bus_name" value="{{ old('bus_name', $bus->bus_name) }}" required autofocus>
                                    @error('bus_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="total_seat" class="form-label">{{ __('Total Seats') }}</label>
                                    <input id="total_seat" type="number" class="form-control @error('total_seat') is-invalid @enderror" name="total_seat" value="{{ old('total_seat', $bus->total_seat) }}" required>
                                    @error('total_seat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- From and To fields -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="from" class="form-label">{{ __('From') }}</label>
                                    <input id="from" type="text" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from', $bus->from) }}" required>
                                    @error('from')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="to" class="form-label">{{ __('To') }}</label>
                                    <input id="to" type="text" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to', $bus->to) }}" required>
                                    @error('to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Bus') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

