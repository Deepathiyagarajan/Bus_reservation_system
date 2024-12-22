@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include jQuery and jQuery Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

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
                    <!-- Displaying Errors -->
                    <div id="error-messages" class="alert alert-danger" style="display: none;">
                        <ul id="error-list"></ul>
                    </div>

                    <form id="busForm" method="POST" action="{{ route('bus.update', $bus->id) }}">
                        @csrf
                        @method('POST')

                        <input type="text" name="id" id="id" value="{{ $bus->id }}" hidden>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bus_name" class="form-label">{{ __('Bus Name') }}</label>
                                <input id="bus_name" type="text" class="form-control" name="bus_name" value="{{ old('bus_name', $bus->bus_name) }}" required autofocus>
                            </div>

                            <div class="col-md-6">
                                <label for="total_seat" class="form-label">{{ __('Total Seats') }}</label>
                                <input id="total_seat" type="number" class="form-control" name="total_seat" value="{{ old('total_seat', $bus->total_seat) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="from" class="form-label">{{ __('From') }}</label>
                                <input id="from" type="text" class="form-control" name="from" value="{{ old('from', $bus->from) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="to" class="form-label">{{ __('To') }}</label>
                                <input id="to" type="text" class="form-control" name="to" value="{{ old('to', $bus->to) }}" required>
                            </div>
                        </div>

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

<script>
    $(document).ready(function() {
        $('#busForm').on('submit', function(e) {
            e.preventDefault();  // Prevent normal form submission

            // Clear any previous error messages
            $('#error-messages').hide();
            $('#error-list').empty();

            var formData = $(this).serialize();  // Serialize form data

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Handle successful form submission
                        alert('Bus details updated successfully!');
                        window.location.href = '{{ route('bus.view') }}';  // Redirect after success
                    }
                },
                error: function(xhr) {
                    // If there are validation errors, show them
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $('#error-messages').show();
                        for (var field in errors) {
                            errors[field].forEach(function(message) {
                                $('#error-list').append('<li>' + message + '</li>');
                            });
                        }
                    } else {
                        alert('An error occurred while updating bus details.');
                    }
                }
            });
        });
    });
</script>


    <script>
        $(document).ready(function() {
            $("#busForm").validate({
                rules: {
                    bus_name: {
                        required: true,
                        minlength: 3
                    },
                    total_seat: {
                        required: true,
                        min: 1
                    },
                    from: {
                        required: true,
                        minlength: 3
                    },
                    to: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    bus_name: {
                        required: "Please enter the bus name",
                        minlength: "Bus name must be at least 3 characters long"
                    },
                    total_seat: {
                        required: "Please enter the total seats",
                        min: "Seats should be at least 1"
                    },
                    from: {
                        required: "Please enter the starting location",
                        minlength: "Location must be at least 3 characters long"
                    },
                    to: {
                        required: "Please enter the destination",
                        minlength: "Destination must be at least 3 characters long"
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
