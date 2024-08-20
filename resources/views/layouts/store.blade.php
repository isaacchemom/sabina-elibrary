<?php
$cartbooks = \Cart::getContent();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="google-site-verification" content="DAUvwu9FceWB8-qDUdqZdCHJkRuLuwEpmSSfpCZnkI8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SABIN BOOKS </title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('storage/css/styles.css') }}" rel="stylesheet" />
    @yield('styles')


    <style>
        .blink {
            animation: blink 6s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 9;
            }

            50% {
                opacity: 0;
                transform: scale(1);
            }

            51% {
                opacity: 0;
                transform: scale(0);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            margin-bottom: 0px;
            /* Margin bottom by footer height */
        }

        .footer {
            position: absolute;
            bottom: -12%;
            width: 100%;
            height: 60px;
            /* Set the fixed height of the footer here */
            line-height: 60px;
            /* Vertically center the text there */
        }

        /* resources/css/app.css or a separate CSS file */
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            text-align: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            animation: spin 2s linear infinite;
        }

        .loading-message {
            margin-top: 30px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .completed {
            color: green;
        }

        .incomplete {
            color: red;
        }

        .pending {
            color: orange;
        }


        .zoom {


            transition: transform .2s;
            /* Animation */



            border: 2px solid #ccc;
            /* Add a border */
            border-radius: 8px;
            /* Rounded corners */
            padding: 5px;
            /* Add some padding */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle shadow */
            display: inline-block;
            /* Ensure the div fits the content */

            margin: 0 auto;


        }

        .zoom:hover {
            transform: scale(8.5);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }

        .zoom img {


            display: block;
            /* Remove extra space below image */

        }


        @media all and (min-width: 300px) {
            .sidebar {
                display: none;

            }


        }
    </style>


</head>

<body style="background-color: rgb(222, 230, 230)">
    <!-- Navigation-->
    <div style="height:120%; background-color:rgba(199, 230, 216, 0.274)">
        <div class=" container ">
            <i class="fa fa-envelope" aria-hidden="true">&nbsp;gorgekimathi@gmail.com</i> &nbsp;&nbsp;
            <i class="fa fa-phone" aria-hidden="true">&nbsp 0721589890</i> &nbsp;
            <!-- <span> Mpesa&nbsp;Till:12345 </i> </span> -->
        </div>
    </div>

    <div>
        <nav class=" containerx navbar navbar-expand-lg navbar-dark bg-successx mt-2X fixed-top"
            style="background-color: rgb(21, 181, 90);text-transform:uppercase">
            <div class="container px-4 px-lg-5">
                <img src="{{ asset('img/mylogo.jpg') }}" height="40px" width="60px"
                    style="border-radius: 15px; box-shadow: 0 2px 2px rgba(250, 64, 64, 0.1); padding: 2px; background-color: #f9fffb;margin-top:-10px">


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span>MENUE</button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 ">
                        <li class="nav-item"><a class="nav-link active " aria-current="page" href="/">Home</a>
                        </li>

                        {{-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Recently
                            added</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('itemCategory', 4)}}">Schemes of
                            work</a></li> --}}

                        {{--
                            @if ($check == 2)
                            @foreach ($bookss as $category)
                            <li class="nav-item"><a class="nav-link active"   href="{{route('itemCategory', $category->category_id  )}}">{{ $category->categories->name }}</a>
                            </li>

                        @endforeach
                              @else
                              @foreach ($bookss1 as $category1)
                            <li class="nav-item"><a class="nav-link active"   href="{{route('itemCategory', $category1->category_id  )}}">{{ $category1->categories->name }}</a></li>
                        @endforeach
                        @endif  --}}
                        @if (isset($check) && $check == 2 && isset($bookss) && $bookss->isNotEmpty())
                            @foreach ($bookss as $category)
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        href="{{ route('itemCategory', $category->category_id) }}">
                                        {{ $category->categories->name ?? 'Unknown' }}
                                    </a>
                                </li>
                            @endforeach
                        @elseif(isset($bookss1) && $bookss1->isNotEmpty())
                            @foreach ($bookss1 as $category1)
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        href="{{ route('itemCategory', $category1->category_id) }}">
                                        {{ $category1->categories->name ?? 'Unknown' }}
                                    </a>
                                </li>
                            @endforeach
                        @endif




                        {{--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:white ">Lesson plans</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/">Termly lesson plans</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li><a class="dropdown-item" href="/">General lesson plans</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                        </ul>
                    </li> --}}
                        <li class="nav-item"><a class="nav-link active " aria-current="page"
                                href="/download">Downloads</a></li>
                    </ul>


                </div>

            </div>

            @if (!isset($check5) )
            <button id="cartButtons" class="btn btn-success btn-sm ml-auto" style="margin-right:20px;">CART</button>
             @endif





        </nav>



    </div>





    <!-- cart/modal.blade.php -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (!empty($cart) && count($cart) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    {{-- th>Quantity</th>- --}}
                                    <th>Price</th>
                                   {{-- <th>Total</th>--}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $item)
                                    <tr>
                                        <td>{{ $item['title'] }}</td>
                                        {{--    <td>{{ $item['quantity'] }}</td> --}}
                                        <td>{{ $item['price'] }}</td>
                                      {{--  <td>{{ $item['quantity'] * $item['price'] }}</td>--}}

                                        <td>

                                            @if (isset($transactionStatuses[$id]) && $transactionStatuses[$id] == 'paid')
                                                <a href="{{ asset('/' . $item['file_path']) }}"
                                                    class="btn btn-success btn-sm" download>Download</a>
                                                @if ($item['ms_path'] !== null)
                                                    <a href="{{ asset('/' . $item['ms_path']) }}"
                                                        class="btn btn-success btn-sm" download>MS</a>
                                                @endif
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Unpaid</button>

                                            @endif

                                          <button class="btn btn-danger btn-sm remove-item" data-id="{{ $id }}">X</button>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end">
                            <strong>Total: KES {{ array_sum(array_column($cart, 'price')) }}</strong>
                            <input type="hidden" id="cartTotalAmount"
                                value="{{ array_sum(array_column($cart, 'price')) }}">
                        </div>
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
                @if (!empty($cart) && count($cart) > 0)
                  @if (!isset($transactionStatuses[$id]) || $transactionStatuses[$id] !== 'paid')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="proceedToPaymentBtn"
                            data-cart="{{ json_encode($cart) }}">Proceed to Payment</button>
                    </div>
                      @endif
                @endif

            </div>
        </div>
    </div>



    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border border-success"
                    style="background-color: #ffffff; border-color: #30d854;">
                    <span style="border: 1px solid #28a745; padding: 5px; display: inline-block; border-radius: 5px;">
                        <img src="https://zegetech.com/assets/images/blog/localgateways/mpesa.jpg" height="25px"
                            width="90px" style="vertical-align: middle;">
                        <h5 class="modal-title text-success" id="paymentModalLabel"
                            style="display: inline-block; margin-left: 10px;">Payment</h5>
                    </span>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p>Total Payment Amount: <span id="paymentTotalAmount"></span></p>
                    <form id="paymentForm">

                        <!-- Hidden input fields to store cart items and total amount -->
                        <input type="hidden" id="cartItemsInput" name="cartItems">
                        <input type="hidden" id="totalAmountInput" name="totalAmount">
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Mpesa Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required
                                pattern="^(01|07)\d{8}$"
                                title="Phone number must be 10 digits long and start with 01 0r 07">


                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>



                        <button type="submit" class="btn btn-success ">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- Header-->
    @yield('content')


    <!-- Footer-->
    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <span class="m-0 text-block text-white">Copyright &copy; 2024:</span>
            <a href="/admin" class="text-end" style="text-decoration: none" target="_blank">ELIBRARY </a>
        </div>

    </footer>



    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('storage/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('myForm');
            const loader = document.getElementById('loader');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
                showLoader();
                submitForm();
            });

            function showLoader() {
                loader.style.display = 'block';
            }

            function hideLoader() {
                loader.style.display = 'none';
            }

            function submitForm() {
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.getAttribute('action'), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.message) {
                            // Display a success message, e.g., using an alert
                            // alert(response.message);

                            swal("SUCCESS!!", response.message, 'success', {
                                button: true,
                                button: "OK",
                                timer: 20000,
                                dangerMode: true,

                            }).then(function() {

                                // Redirect to a new page after the SweetAlert is closed
                                window.location.href = '/download'; // Replace with your desired URL
                            });

                        }
                        if (response.error) {
                            // Display a success message, e.g., using an alert
                            // alert(response.message);

                            swal("ERROR!", response.error, 'error', {
                                button: true,
                                button: "OK",
                                timer: 8000,
                                dangerMode: true,

                            });

                        }

                        if (response.data) {
                            // Update the page with data from the response
                            const dataElement = document.getElementById('data-container');
                            dataElement.textContent = `Data: ${response.data.key}`;
                        }
                    }
                    hideLoader(); // Hide the loader after form submission is complete
                };
                xhr.send(formData);
            }
        });
    </script>

    <script>
        var lastScrollTop = 0;
        $(window).scroll(function() {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                // Downscroll code
                $('#navbar').removeClass('fixed-top');
            } else {
                // Upscroll code
                $('#navbar').addClass('fixed-top');
            }
            lastScrollTop = st;
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event listener for "Add to Cart" button
            $('.add-to-cart').on('click', function(e) {
                e.preventDefault();

                var bookId = $(this).data('id');
                var button = $(this); // Reference to the clicked button

                $.ajax({
                    url: '{{ route('add.cart') }}',
                    method: 'POST',
                    data: {
                        id: bookId
                    },
                    success: function(response) {
                        // Update the cart button and display success message
                        $('#cartButtons')
        .text('BUY NOW (' + response.totalItems + ')')
        .css({
            'color': 'white',           // Set the text color to white
            'background-color': 'orange'   // Set the background color to red
        });
                        button.text('In Cart')
                            .attr('disabled', true)
                            .addClass('text-warning');
                        toastr.success(response.success);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.error);
                    }
                });
            });

            // Event listener for "Cart" button to open the modal
            $('#cartButtons').on('click', function(e) {
                e.preventDefault();

                $.get('{{ route('cart.modal') }}', function(data) {
                    // Load the modal content and show the modal
                    $('#cartModal .modal-content').html($(data).find('.modal-content').html());
                    $('#cartModal').modal('show');
                });
            });

            // Delegated event listener for "Remove Item" button inside the modal
            $('#cartModal').on('click', '.remove-item', function(e) {
                e.preventDefault();

                var button = $(this);
                var itemId = button.data('id');

                $.ajax({
                    url: '{{ route('remove.cart.item') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: itemId
                    },
                    success: function(response) {
                        // Optionally hide the modal first
                        $('#cartModal').modal('hide');

                        // Optionally refresh the modal content
                        $.get('{{ route('cart.modal') }}', function(data) {
                            $('#cartModal .modal-content').html($(data).find(
                                '.modal-content').html());
                            $('#cartModal').modal('show');
                        });

                        toastr.success(response.success);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.error);
                    }
                });
            });



            // Trigger the payment modal when the "Proceed to Payment" button is clicked
            $('#cartModal').on('click', '#proceedToPaymentBtn', function(e) {

                var cartItems = $(this).data('cart');
                var totalAmount = $('#cartTotalAmount').val();

                // Set the total amount and cart items in the payment modal

                // Set the total amount and cart items in the payment modal
                $('#paymentTotalAmount').text('KES ' + totalAmount);
                $('#cartItemsInput').val(JSON.stringify(cartItems)); // Store cart items as JSON string
                $('#totalAmountInput').val(totalAmount);

                $('#cartModal').modal('hide');
                // Show the payment modal
                $('#paymentModal').modal('show');

            });

            // Handle the payment form submission
            $('#paymentForm').on('submit', function(e) {
                e.preventDefault();

                   $('#loader').show();
                var phoneNumber = $('#phoneNumber').val();
                var email = $('#email').val();

                var cartItems = $('#cartItemsInput').val(); // Get the cart items as a JSON string
                var totalAmount = $('#totalAmountInput').val(); // Get the total amount


                // You can add AJAX here to send the phoneNumber and email to your backend


                $.ajax({
                    url: '{{ route('process.payment') }}', // Your payment processing route
                    method: 'POST',
                    data: {
                        phoneNumber: phoneNumber,
                        email: email,
                        totalAmount: totalAmount, // Send the total amount to the server
                        cartItems: cartItems // Send cart items if needed
                    },
                    success: function(response) {
                        console.log(response)
                    $('#loader').hide();
                     // Check if the response.transaction is an array and has at least one element
let transaction = Array.isArray(response.transaction) && response.transaction.length > 0 ? response.transaction[0] : null;

let MerchantRequestID = transaction ? (transaction.MerchantRequestID || null) : null;
let CheckoutRequestID = transaction ? (transaction.CheckoutRequestID || null) : null;

// Use the variables as needed
console.log('MerchantRequestID:', MerchantRequestID);
console.log('CheckoutRequestID:', CheckoutRequestID);


                        if (!localStorage.getItem('MerchantRequestID') && !localStorage.getItem(
                                'CheckoutRequestID')) {

                            localStorage.setItem('MerchantRequestID', MerchantRequestID);
                            localStorage.setItem('CheckoutRequestID', CheckoutRequestID);
                        } else {
                            localStorage.removeItem('MerchantRequestID');
                            localStorage.removeItem('CheckoutRequestID');
                            localStorage.setItem('MerchantRequestID', MerchantRequestID);
                            localStorage.setItem('CheckoutRequestID', CheckoutRequestID);
                        }

                        if (response.success) {
                            //toastr.success(response.success);
                            swal("SUCCESS!!", response.success, 'success', {
                                button: true,
                                button: "OK",
                                timer: 20000,
                                dangerMode: true,

                            }).then(function() {

                                //check if the user paid

                                let MerchantRequestID = localStorage.getItem(
                                    'MerchantRequestID');
                                let CheckoutRequestID = localStorage.getItem(
                                    'CheckoutRequestID');
                                let url = '/api/mpesa/stkpush/check-payment-status';
                                checkPaymentStatus(MerchantRequestID, CheckoutRequestID,
                                    url);

                            });
                            $('#paymentModal').modal('hide');

                        }

                        if (response.error) {
                            // toastr.error(response.message);
                               // Hide the loader in case of an error
                $('#loader').hide();

                            console.log("Error:", response
                            .error); // Log the error to ensure it's being captured
                            $('#paymentModal').modal('hide'); // Hide the modal first
                            swal("ERROR!", response.error, 'error', {
                                button: true,
                                button: "OK",
                                timer: 6000,
                                dangerMode: true,

                            });


                        }


                    },
                    error: function(xhr) {

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error);
                        } else {
                            toastr.error('An unexpected error occurred. Please try again.');
                        }

                    }
                });
            });




            function checkPaymentStatus(MerchantRequestID, CheckoutRequestID, url) {
              // Show the loader
        $('#loader').show();
               //  showLoader();
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        MerchantRequestID: MerchantRequestID,
                        CheckoutRequestID: CheckoutRequestID
                    },
                    success: function(response) {
                        if (response.status === 'paid') {
                            swal("SUCCESS!!", response.success, 'success', {
                                button: true,
                                button: "OK",
                                timer: 30000,
                                dangerMode: true,

                            }).then(function() {
                                // hideLoader();
                                       // Hide the loader in case of an error
                                      $('#loader').hide();

                               // $('#cartModal').modal('show');
                                                    $.get('{{ route('cart.modal') }}', function(data) {
                    // Load the modal content and show the modal
                    $('#cartModal .modal-content').html($(data).find('.modal-content').html());
                    $('#cartModal').modal('show');
                });

                            });

                        } else {
                            // Transaction still pending, retry
                            retry(MerchantRequestID, CheckoutRequestID, url);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error if any
                        console.error(error);
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                });
            }



            function retry(MerchantRequestID, CheckoutRequestID, url) {
                let retryCount = 0;
                const maxRetries = 8;
                const interval = 1000; // milliseconds
                console.log('Retrying...', retryCount);
                //var message = `Retrying... ${retryCount} - ${response.success}`;
                var message = 'We are checking your payment..';
                toastr.success(message);



                function sendRequest(MerchantRequestID, CheckoutRequestID, url) {
                    setTimeout(function() {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                MerchantRequestID: MerchantRequestID,
                                CheckoutRequestID: CheckoutRequestID
                            },
                            success: function(response) {


                                console.log("MPESA Response: ", response);
                                if (response.status === 'paid') {
                                    swal("SUCCESS!!", response.success, 'success', {
                                        button: true,
                                        button: "OK",
                                        timer: 30000,
                                        dangerMode: true,

                                    }).then(function() {
                                          // hideLoader();
                                             $('#loader').hide();

                                         // $('#cartModal').modal('show');
                                                    $.get('{{ route('cart.modal') }}', function(data) {
                    // Load the modal content and show the modal
                    $('#cartModal .modal-content').html($(data).find('.modal-content').html());
                    $('#cartModal').modal('show');
                });



                                    });
                                }

                                  if (response.status === 'pending') {
                                      /// toastr.error(response.success);
                                    swal("Payment not receieved!!", response.success, 'error', {
                                        button: true,
                                        button: "OK",
                                        timer: 20000,
                                        dangerMode: true,

                                    }).then(function() {
                                        // hideLoader();
                                         // $('#cartModal').modal('show');
                                                   // $.get('{{ route('cart.modal') }}', function(data) {
                    // Load the modal content and show the modal
                    //$('#cartModal .modal-content').html($(data).find('.modal-content').html());
                    //$('#cartModal').modal('show');
               // });
                              $('#loader').hide();
                              $('#cartModal').modal('show');

                                    });

                                    if (retryCount < maxRetries) {
                                        retryCount++;
                                        toastr.success(message);
                                        sendRequest(MerchantRequestID, CheckoutRequestID, url);
                                    }



                                }




                                else {
                                    // Retry if still pending
                                    if (retryCount < maxRetries) {
                                        retryCount++;
                                        toastr.success(message);
                                        sendRequest(MerchantRequestID, CheckoutRequestID, url);
                                    } else {
                                        if (response.status === 'not_found') {
                                            swal({
                                                title: "Sorry, we have not received your payment!",
                                                text: response.success,
                                                icon: "error",
                                                buttons: {
                                                    confirm: {
                                                        text: "OK",
                                                        value: true,
                                                        visible: true,
                                                        className: "",
                                                        closeModal: true
                                                    }
                                                },
                                                dangerMode: true,
                                                timer: 30000
                                            }).then(function() {
                                                // Redirect to home or any other page
                                               // window.location.href = '/';
                                                  // $('#cartModal').modal('show');
                                                    $.get('{{ route('cart.modal') }}', function(data) {
                    // Load the modal content and show the modal
                    $('#cartModal .modal-content').html($(data).find('.modal-content').html());
                    $('#cartModal').modal('show');
                });

                                            });
                                        }
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle error if any
                                console.error(error);
                            }
                        });
                    }, interval);
                }

                sendRequest(MerchantRequestID, CheckoutRequestID, url);
            }





        });
    </script>








    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <div class="elfsight-app-7f7db468-b7dd-4e89-9331-6cfaab965165" data-elfsight-app-lazy></div>



    <!-- Other page content -->


</body>

</html>
