<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@3.3.5/src/css/preflight.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <script src="/js/video-call/socket.io-2.2.0.js"></script>
    <script src="/js/video-call/StringeeSDK-1.5.10.js"></script>
    <script>
        const GLOBAL_AUTH_USER = @json(auth()->user());
        let token = @json($jwt);
        var callerId = 'userId' + GLOBAL_AUTH_USER.id;
    </script>
    @isset($calleeId)
        <script>
            var calleeId = @json($calleeId);
        </script>
    @endisset
    <script src="/js/video-call/code.js"></script>
    <div class="min-h-screen relative bg-black">
        <span style="display: none;" id="incoming-call-notice"
            class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-3xl text-white z-50 animate-pulse">Incoming
            call...</span>
        <div id="video-container">
            <video id="localVideo" class="fixed w-full h-full" autoplay muted></video>
            <video id="remoteVideo" autoplay class="h-44 w-auto fixed top-2 right-2 z-30 rounded-lg"></video>
        </div>
        <nav class="absolute bottom-4 left-1/2 -translate-x-1/2" id="call-nav">
            <ul class="bg-black flex p-2 rounded-full">
                <li><button id="callButton" class="hidden"></button></li>
                <li>
                    <button id="rejectCallButton" class="p-3 bg-red-500 text-white rounded-full hover:opacity-70"
                        style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-phone-missed relative -translate-x-0.5 translate-y-0.5">
                            <line x1="23" y1="1" x2="17" y2="7"></line>
                            <line x1="17" y1="1" x2="23" y2="7"></line>
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg></button>
                </li>
                <div id="sp-bt" class="grow w-40"></div>
                <li>
                    <button id="answerCallButton" class="p-3 bg-green-500 text-white rounded-full hover:opacity-70"
                        style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg></button>
                </li>
                <li>
                    <button id="endCallButton" class="p-3 bg-red-500 text-white rounded-full hover:opacity-70"
                        style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-off">
                            <path
                                d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91">
                            </path>
                            <line x1="23" y1="1" x2="1" y2="23"></line>
                        </svg></button>
                </li>
            </ul>
        </nav>
    </div>
    @isset($calleeId)
        <script>
            $(function() {
                $('#callButton').click()
            })
        </script>
    @endisset
</body>

</html>
