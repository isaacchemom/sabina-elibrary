@extends('layouts.store')
@section('content')

    <div class="container-fluid mt-4 bg-red">
        <div class="row border border-default">
            <!-- Left Sidebar Navigation -->
            <div class="col-md-2 bg-default border ">
                <div class="sidebar d-sm-none d-md-block hidden-sm mt-1">
                    <!-- Your left sidebar navigation code goes here -->
                    <h6 class="text-success">SABIN LIBRARY</h6>
                    <ul class="mynav nav nav-pills flex-column mb-auto">

                        @if ($check == 3)
                            @if ($books->count() > 0)
                                @foreach ($books as $book)
                                    <li>
                                        <a href="{{ route('cart.add', $book->id) }}" class=" btn-outline-successx mt-auto "
                                            style="text-decoration:none; text-transform:uppercase">

                                            <!-- Product details-->

                                            <div class="text-center fs-5x border border-success  ">
                                                <!-- Product name-->

                                                <div class="text-mutedx small rounded  "
                                                      style="background-color:rgb(65, 165, 65); color:rgb(255, 255, 255); font-size:87%; ">
                                                    <small> {{ Str::limit($book->title, 25) }} >
                                                        {{ Str::limit($book->class, 25) }} >
                                                        {{ Str::limit($book->categories->name, 25) }} </small>
                                                </div>

                                                <!-- Product reviews-->

                                                <div>
                                                    <hr class="dropdown-divider" />
                                                </div>


                                            </div>


                                        </a>


                                    </li>
                                @endforeach
                            @endif
                        @else
                            @if ($myitems->count() > 0)
                                <div class="row">
                                    @foreach ($myitems as $book)
                                        <li>

                                            <a href="{{ route('cart.add', $book->id) }}"
                                                class=" btn-outline-successx mt-auto "
                                                style="text-decoration:none; text-transform:uppercase">



                                                <!-- Product name-->

                                                <div class="text-mutedx small roundedx "
                                                    style="background-color:rgb(65, 165, 65); color:white; font-size:87%; ">
                                                    <small> {{ Str::limit($book->title, 25) }} >
                                                        {{ Str::limit($book->class, 25) }} >
                                                        {{ Str::limit($book->categories->name, 25) }}</small>
                                                </div>

                                                <!-- Product reviews-->




                                            </a>

                                        </li>
                                        <hr class="dropdown-divider" />
                                    @endforeach

                                    <div>
                            @endif

                </div>
                @endif




                </ul>

            </div>
        </div>

        <!-- Main Content Section -->
        <div class="col-md-10">

            <p class="container mt-2 ">
                <span class="bg-info"> <Span class="text-white"> |SABIN ONLINE ELIBRARY| </span> <span class="blink " style="color:white">GET TOP KCSE REVISION PAST PAPER, LESSON PLANS , SCHEMES
                    OF
                    WORK... FOR HELP OR ENQUIRY CALL OR TEXT ON</span>:<span  style="color:rgb(255, 255, 255)"> 0768731081</span></span>
                    <marquee class=""  style="color:rgb(232, 80, 100)"> WELCOME TO SABIN ELIBRARY ONLINE . WE ARE TRANSPARENT, SIMPLE AND EASY .JUST SELECT YOUR FAVOURTE ITEM PAY VIA MPESA AND INSTANTLY WE SEND THE ITEM IN YOUR EMAIL: FOR HELP OR ENQUIRY CALL ,SMS OR WHATSAPP US ANY TIME !</marquee>
                <hr style="margin-top:-25px" class="dropdown-divider" />


            </p>

            <!--END OF COUNT-->
            <!-- Section-->
            <section class="py-1 mt-0">

                <div class="justify-content-center container  ">

                    @if ($check == 3)

                        <div class="row">
                            @if ($books->count() > 0)
                                @foreach ($books as $book)
                                    <div class="col-md-4">
                                        <!-- <a href="{{ route('book', $book->id) }}">-->
                                        <a href="{{ route('cart.add', $book->id) }}" class=" btn-outline-successx mt-auto "
                                            style="text-decoration:none; text-transform:uppercase">
                                            <div class="card h-100x bg-light  p-1">

                                                <!-- Product details-->
                                                <div class="card-body p-1 ">
                                                    <div class="text-center fs-5x border border-success  ">
                                                        <!-- Product name-->


                                                        <div class="text-mutedx small roundedx "
                                                            style="background-color:rgb(65, 165, 65); color:white; font-size:87%; ">
                                                            <small> {{ Str::limit($book->title, 25) }} >
                                                                {{ Str::limit($book->class, 25) }} >
                                                                {{ Str::limit($book->categories->name, 25) }}</small>
                                                        </div>

                                                        <!-- Product reviews-->


                                                        <div
                                                            class="bi-star-fill small d-flex justify-content-center small text-primary mb-2 ">
                                                            {{ Str::limit($book->desc, 25) }} &nbsp; @if(!empty($book->ms_path)) <small class="text-warning"> & marking scheme</small> @else <small class="text-info"> No MS</small>@endif</div>

                                                           @if($book->img_path==null)
                                                            <div class="zoomx">


                                                            </div>
                                                            @else
                                                            <div>
                                                                <hr class="dropdown-divider"/>
                                                                <small class="text-mutedx text-primary" style="font-size: 55%; color:red;margin-left:-50px">View book image:

                                                                </small>
                                                            <div class="zoom">

                                                                <img src="{{ asset($book->img_path) }}" alt="Image" width="50px" height="30px">
                                                            </div></div>

                                                           @endif

                                                        <div class="card-footer bi-star-fillx" style="font-size: 82%">
                                                            <small class="text-muted">Last updated
                                                                on:{{ $book->updated_at }}
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <hr class="dropdown-divider" />
                                                        </div>


                                                        <!-- Product price-->

                                                        <div class="mt-autox p-1">
                                                            <span style="font-size: 81%"
                                                                class="btn btn-light btn-outline-primary flex-shrink-0 mt-auto float-start ">Buy
                                                                now</span>
                                                                   <span >
                                                                <a href="javascript:void(0);" data-id="{{ $book->id }}" style="font-size: 70% ;margin-left:2px " class="btn btn-light btn-outline-primary flex-shrink-0 mt-auto float-start add-to-cart"
                                                                    style="text-decoration:none; text-transform:uppercase">
                                                                    ADD TO CART
                                                                 </a></span>

                                                                <span class="float-end">KES
                                                                {{ $book->price }}.00</span>


                                                        </div>

                                                        <hr />
                                                    </div>
                                                </div>


                                            </div>

                                        </a>

                                        <hr class="dropdown-divider" />


                                    </div>
                                @endforeach
                            @endif

                        </div>
                    @else
                        @if ($myitems->count() > 0)
                            <div class="row">
                                @foreach ($myitems as $book)
                                    <div class="col-md-4">


                                        <!-- <a href="{{ route('book', $book->id) }}">-->
                                        <a href="{{ route('cart.add', $book->id) }}" class=" btn-outline-successx mt-auto "
                                            style="text-decoration:none; text-transform:uppercase">
                                            <div class="card h-100x bg-light  p-1">

                                                <div class="card-body p-1 ">
                                                    <div class="text-center fs-5x border border-success  ">
                                                        <!-- Product name-->

                                                        <div class="text-mutedx small roundedx "
                                                            style="background-color:rgb(65, 165, 65); color:white; font-size:87%; ">
                                                            <small> {{ Str::limit($book->title, 25) }} >
                                                                {{ Str::limit($book->class, 25) }} >
                                                                {{ Str::limit($book->categories->name, 25) }}</small>
                                                        </div>

                                                        <!-- Product reviews-->


                                                        <div
                                                            class="bi-star-fill small d-flex justify-content-center small text-primary mb-2 ">
                                                            {{ $book->desc }}</div>


                                                            @if($book->img_path==null)
                                                            <div class="zoomx">


                                                            </div>
                                                            @else
                                                            <div>
                                                                <hr class="dropdown-divider"/>
                                                                <small class="text-mutedx text-primary" style="font-size: 55%; color:red;margin-left:-50px">View book image:

                                                                </small>
                                                            <div class="zoom">

                                                                <img src="{{ asset($book->img_path) }}" alt="Image" width="50px" height="30px">
                                                            </div></div>

                                                           @endif


                                                        <div class="card-footer bi-star-fillx" style="font-size: 82%">
                                                            <small class="text-muted">Last updated
                                                                on:{{ $book->updated_at }}
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <hr class="dropdown-divider" />
                                                        </div>


                                                        <div class="mt-autox p-1">
                                                            <span style="font-size: 80%"
                                                                class="btn btn-light btn-outline-primary flex-shrink-0 mt-auto float-start ">Buy
                                                                now</span>

                                                                <span >
                                                                    <a href="javascript:void(0);" data-id="{{ $book->id }}" style="font-size: 70% ;margin-left:2px " class="btn btn-light btn-outline-primary flex-shrink-0 mt-auto float-start add-to-cart"
                                                                        style="text-decoration:none; text-transform:uppercase">
                                                                        ADD TO CART
                                                                     </a></span>

                                                                <span class="float-end">KES
                                                                {{ $book->price }}.00</span>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                </div>


                                            </div>



                                        </a>
                                        <hr class="dropdown-divider" />

                                    </div>
                                @endforeach
                                <hr class="dropdown-divider " />
                                <div>
                        @endif



                </div>
                @endif



    </div>
    </div>

    </section>



    </div>

@endsection


