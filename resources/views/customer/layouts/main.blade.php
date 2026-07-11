<!DOCTYPE html>
<html lang="en">

@include('customer.layouts.head')

<body>


    {{-- header --}}
    @include('customer.layouts.navbar')

    {{-- aside --}}
    @include('customer.layouts.aside')


    @yield('content')



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000",
                "rtl": true,
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>



    @stack('scripts')


    <script src="{{ asset('assets\js\customer\customer.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-messaging.js";

        const firebaseConfig = {
            apiKey: "AIzaSyChq8FzHli36CwLekTb0uym2GfyAawACps",
            authDomain: "rawabet-fc6a3.firebaseapp.com",
            projectId: "rawabet-fc6a3",
            storageBucket: "rawabet-fc6a3.firebasestorage.app",
            messagingSenderId: "606958798803",
            appId: "1:606958798803:web:22014c39123b2e2c099126",
            measurementId: "G-H2VZZ9C40Z"

        };

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        // Request permission
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                getToken(messaging, {
                        vapidKey: "BFY_iMvuMiQlAeaRstozA1ypv2CxPkROB36nr2DshGWp_Yne3h8h7VdWHcYLPhMDnrHUfp8_3kUJ0tA__lqmWFo"
                    })
                    .then((token) => {
                        if (token) {
                            fetch('/customer/save-fcm-token', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    token
                                })
                            });
                        }
                    }).catch((err) => {
                        console.error('FCM token error:', err);
                    });
            }
        });

        // Handle messages when site is open
        onMessage(messaging, (payload) => {
            console.log('Message received in foreground:', payload);
            // alert(`${payload.notification.title}: ${payload.notification.body}`);
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000",
                "rtl": true,
            };

            if (payload.notification) {
                toastr.info(payload.notification.body, payload.notification.title);
            }
        });
    </script>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('Service worker registered:', registration);
                }).catch((err) => {
                    console.error('Service worker registration failed:', err);
                });
        }
    </script>


    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('Service worker registered:', registration);
                }).catch((err) => {
                    console.error('Service worker registration failed:', err);
                });
        }
    </script>

</body>

</html>
