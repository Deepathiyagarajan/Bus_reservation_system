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
                        <span>Book Tickets for Bus: {{ $bus->bus_name }}</span>
                        <a href="{{ route('bus.list') }}" class="btn btn-danger btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <!-- Bus Details -->
                        <p><strong>Total Seats:</strong> {{ $bus->total_seat }}</p>
                        <p><strong>Available Seats:</strong> <span id="availableSeats">{{ $available_seat }}</span></p>
                        <p><strong>Date:</strong> <span id="availableSeats">{{ $date }}</span></p>

                        <!-- Booking Form -->
                        <form method="POST" action="{{ route('bus.submitBooking') }}" id="bookingForm">
                            @csrf
                            <input type="hidden" name="bus_name" value="{{ $bus->bus_name }}">
                            <input type="hidden" name="id" value="{{ $bus->id }}">
                            <input type="hidden" name="date" value="{{ $date }}">

                            <!-- Ticket Count -->
                            <div class="mb-3">
                                <label for="ticket_count" class="form-label">Ticket Count</label>
                                <input id="ticket_count" type="number" class="form-control @error('ticket_count') is-invalid @enderror"
                                    name="ticket_count" value="{{ old('ticket_count') }}" min="1" max="{{ $bus->available_seat }}" required>
                                @error('ticket_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="warningMessage" class="text-danger mt-2" style="display: none;">
                                    You cannot book more tickets than available seats!
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Name</label>
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror"
                                    name="user_name" value="{{ old('user_name') }}" required>
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input id="mobile_number" type="text"
                                    class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number"
                                    value="{{ old('mobile_number') }}" required>
                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    Book Tickets
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for live validation
        const ticketCountInput = document.getElementById('ticket_count');
        const availableSeats = parseInt(document.getElementById('availableSeats').innerText);
        const warningMessage = document.getElementById('warningMessage');
        const submitButton = document.getElementById('submitButton');

        ticketCountInput.addEventListener('input', function () {
            const ticketCount = parseInt(ticketCountInput.value);

            if (ticketCount > availableSeats) {
                warningMessage.style.display = 'block';
                submitButton.disabled = true; // Disable submit button
            } else {
                warningMessage.style.display = 'none';
                submitButton.disabled = false; // Enable submit button
            }
        });
    </script>
@endsection


