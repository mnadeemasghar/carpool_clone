importScripts('https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js');

// Your Firebase configuration
var firebaseConfig = {
  apiKey: "{{env('FIREBASE_API_KEY')}}",
  authDomain: "{{env('FIREBASE_AUTH_DOMAIN')}}",
  projectId: "{{env('FIREBASE_PROJECT_ID')}}",
  storageBucket: "{{env('FIREBASE_STORAGE_BUCKET')}}",
  messagingSenderId: "{{env('FIREBASE_MESSAGING_SENDER_ID')}}",
  appId: "{{env('FIREBASE_APP_ID')}}",
  measurementId: "{{env('FIREBASE_MEASUREMENT_ID')}}"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Handle incoming background messages
messaging.onBackgroundMessage(function(payload) {
  console.log('Background Message received. ', payload);
  // Customize notification handling here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
      body: payload.notification.body,
      icon: payload.notification.icon
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
