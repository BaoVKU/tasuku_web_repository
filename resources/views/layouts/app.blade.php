<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'tasuku') }}</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@3.3.5/src/css/preflight.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/hide_show.js', 'resources/js/form.js', 'resources/js/filter.js', 'resources/js/chat.js', 'resources/js/user_activity.js', 'resources/js/notification.js'])
    <script>
        const GLOBAL_CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": GLOBAL_CSRF_TOKEN,
            },
        });
        const GLOBAL_AUTH_USER = @json(auth()->user());
        const GLOBAL_HOST = window.location.origin + '/';
        var GLOBAL_CHAT_LIST = []
        var GLOBAL_MAIL_LIST = []
    </script>

</head>

<body class="bg-slate-100 mt-12 mb-16 lg:mt-16 lg:mb-4">
    @include('layouts.navigation')
    <script src="/js/video-call/socket.io-2.2.0.js"></script>
    <script src="/js/video-call/StringeeSDK-1.5.10.js"></script>
    {{ $slot }}
</body>

</html>
