// ✅ Use compat version for service workers
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

firebase.initializeApp({
 apiKey: "AIzaSyChq8FzHli36CwLekTb0uym2GfyAawACps",
  authDomain: "rawabet-fc6a3.firebaseapp.com",
  projectId: "rawabet-fc6a3",
  storageBucket: "rawabet-fc6a3.firebasestorage.app",
  messagingSenderId: "606958798803",
  appId: "1:606958798803:web:22014c39123b2e2c099126",
  measurementId: "G-H2VZZ9C40Z"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/favicon.ico'
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
