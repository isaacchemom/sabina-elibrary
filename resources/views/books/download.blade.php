{{-- @extends('layouts.store') --}}

@extends('layouts.store')

@section('content')




    <div class="row container" style="margin-top:-750px">
        <div class="col-md-8 offset-md-2">
            <h5 class="alert alert-info">Download your file here or find it in your email!</h5>

            <!-- Form to enter transaction ID -->
            <form id="paymentForm">
                <div class="form-group">
                    <label for="transactionId">ENTER MPESA TRANSACTION CODE RECEIVED AFTER PAYMENT OF THE ITEM:</label>
                    <input type="text" id="mpesaTransactionId" name="mpesaTransactionId" class="form-control" require="required">
                </div>
                <button type="button" id="checkPaymentButton" class="btn btn-warning mt-3">Check Payment</button>
            </form>

            <!-- Placeholder for messages and download link -->

            <div id="responseMessage" class="mt-3"></div>
           <div id="responseMessageM" class="mt-3"></div>


        </div>
    </div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#checkPaymentButton').click(function() {

            var fadeOutTimeout;
            var mpesaTransactionId = $('#mpesaTransactionId').val();


    if (mpesaTransactionId.trim() === '') {
        // Show an error message if the field is empty
        alert('MPESA Transaction transaction is required.');
        return; // Stop further execution
    }

            $.ajax({
                url: '/check-payment',
                type: 'POST',
                data: {
                    mpesaTransactionId: mpesaTransactionId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    //console.log(response);
                    if (response.success) {

                        if (fadeOutTimeout) {
                        clearTimeout(fadeOutTimeout);
                    }
                     // Stop any ongoing animations and show the message
                     $('#responseMessage').stop(true, true).show();
                        // Display success message and download link
                        $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        if (response.file_path) {


                            $('#responseMessage').append('<a href="' + response.file_path + '" class="btn btn-primary mt-3" target="_blank">Download Your File: ' + response.name + '</a>' + '<br>');

                            if (response.ms_path) {
                            $('#responseMessage').append('<a href="' + response.ms_path + '" class="btn btn-success mt-3" target="_blank">Download marking scheme</a>');
                            }


                        }


                    } else {
                        // Display error message
                        $('#responseMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }

                    // Set a new timeout to fade out the message
                    fadeOutTimeout = setTimeout(function() {
                        $('#responseMessage').fadeOut('slow'); // Fade out effect
                    }, 20000);
                    $('#responseMessage').stop(true, true).show();
                },
                error: function(xhr, status, error) {


                     // Clear any previous timeout
                     if (fadeOutTimeout) {
                        clearTimeout(fadeOutTimeout);
                    }

                    // Stop any ongoing animations and show the message
                    $('#responseMessage').stop(true, true).show();
                    console.error('AJAX Error:', error);
                    $('#responseMessage').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');

                // Set a new timeout to fade out the message
                fadeOutTimeout = setTimeout(function() {
                        $('#responseMessage').fadeOut('slow'); // Fade out effect
                    }, 10000);

                }
            });
        });
    });





    </script>
