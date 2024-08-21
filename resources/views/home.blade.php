<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <link rel = "stylesheet" href="{{ asset('css/styleHome.css') }}">
</head>

<body>
    <header>
        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>

        <a href="{{ route('home') }}" class="logo"> UNIVERSITY MARKETSHOP </a>

            <nav class="navbar">
                <a href="{{ route('home') }}" class="selectedNav">Home</a>
                <a href="{{ route('productcatalog') }}">Products</a>
                <a href="{{ route('ordertracking') }}">Order Tracking</a>
                @if($loggedIn == true)
                    <a href="{{ route('exchangelist') }}">Exchange Requests</a>
                @else
                    <a href="{{ route('login') }}">Exchange Requests</a>
                @endif
            </nav>

            <div class="icons">
                @if($loggedIn == true)
                    <a href="javascript:void(0);" id="notificationBell">
                        <i id="bellIcon" class="fa-solid fa-bell"></i>
                        <i id="alertSymbol" class="fa-solid fa-bell fa-bounce"></i>
                    </a>
                    <div class="notification-dropdown">
                        @if ($notifications->count() > 0)
                            @foreach ($notifications as $notification)
                                <a href="{{ $notification->quick_link }}" style="text-decoration: none; color: black;"><div class="notification-item" data-notify-id="{{ $notification->id }}">{{ $notification->content }}</div></a>
                                @if (!$loop->last)<hr>@endif
                            @endforeach
                        @else
                            No new notifications.
                        @endif
                    </div>
                @else
                    @php
                        $notifications = collect([]);
                    @endphp
                    <a href="{{ route('login') }}" class="fas fa-bell"></a>
                @endif
                <a href="#" class="fas fa-search" id="search-link"></a>
                    <div id="search-box">
                    <form id="search-form" action="{{ route('search') }}" method="GET">
                        <input type="text" name="q" id="search-input" placeholder="Search products...">
                        <button type="submit">Search</button>
                    </form>
                    </div>
                @if($loggedIn == true)
                    <a href="{{ route('cart') }}" class="fas fa-shopping-cart"></a>
                    <a href="{{ route('dashboard') }}" class="fas fa-user"></a>
                    <a href="{{ route('logout') }}" class="fas fa-right-from-bracket"></a>
                @else
                    <a href="{{ route('login') }}" class="fas fa-shopping-cart"></a>
                    <a href="{{ route('login') }}" cl class="fas fa-user"></a>
                @endif
            </div>
    </header>

<section class="home">

</section>

<div class="products">
        @foreach ($products as $product)
        <a href="{{ url('/catalog/fulldetails/'.$product->prod_id) }}" class="text-dark text-decoration-none">
        <div class="shirt">
            <div class="image">
                @if ($product->image1 !== 'default_pics/default_prod_pic.jpg')
                <img src="{{ asset('storage/custom_prod_pics/'.$product->image1) }}" alt="Product Image">
                @else
                <img src="{{ asset('default_pics/default_prod_pic.jpg') }}" alt="Product Image">
                @endif
            </div>
        </div>
        </a>
        @endforeach
</div>

        
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#search-link").click(function(e) {
                e.preventDefault(); // Prevent the link from navigating

                $("#search-box").toggle();
            });
        });

        $(document).ready(function() {
            $('#search-link').click(function(e) {
                e.preventDefault();
                $('#search-box').toggleClass('active');
            });
        });

        $(document).ready(function () {
            const $notificationBell = $('#notificationBell');
            const $notificationDropdown = $('.notification-dropdown');
            const $alertSymbol = $('#alertSymbol');
            const $bellIcon = $('#bellIcon');
            let notificationBoxOpen = false;

            function checkUnreadNotifications() {
                const notificationCount = {!! $notifications->count() !!};
                if (notificationCount > 0) {
                    $alertSymbol.show();
                    $bellIcon.hide();
                } else {
                    $alertSymbol.hide();
                    $bellIcon.show();
                }
            }

            checkUnreadNotifications();

            $notificationBell.on('click', function (e) {
                e.stopPropagation();
                if (!notificationBoxOpen) {
                    $notificationDropdown.toggle();
                    markNotificationsAsRead();
                    notificationBoxOpen = true;
                } else {
                    $notificationDropdown.hide();
                    notificationBoxOpen = false;
                }
            });

            $(document).on('click', function () {
                $notificationDropdown.hide();
                notificationBoxOpen = false;
            });
        });

        function markNotificationsAsRead() {
            $.ajax({
                url: '{{ route('mark.notif') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function () {
                    console.log('Notifications marked as read.');
                },
                error: function () {
                    // Error handling
                }
            });
        }
    </script>

    <style>
        .notification-dropdown {
            position: absolute;
            background: white;
            width: 300px;
            height: auto;
            max-height: 300px; /* Set a maximum height, you can adjust this as needed */
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            right: 170px;
            top: 55px;
            z-index: 1;
            overflow-y: auto; /* Add a scrollbar for overflow */
        }
    </style>
</body>
</html>