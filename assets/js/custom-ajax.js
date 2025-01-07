(function($) {

"use strict"; // Start of use strict

  var firebaseConfig = {
                apiKey: "AIzaSyARmvL9u4ku_1yV_GXhqbbK6TxRuLf9VV4",
                authDomain: "veatfresh.firebaseapp.com",
                databaseURL: "https://veatfresh.firebaseio.com",
                projectId: "veatfresh",
                storageBucket: "veatfresh.appspot.com",
                messagingSenderId: "916684734406",
                appId: "1:916684734406:web:d462fc6907fcdf5a2e7cc7",
                measurementId: "G-15XYF3DH3E"
  };
          
  firebase.initializeApp(firebaseConfig);
  window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
    "recaptcha-container",
    {
      size: "invisible",
      callback: function(response) {
        submitPhoneNumberAuth();
      }
    }
  );
  
  window.recaptchaVerifiers = new firebase.auth.RecaptchaVerifier(
        "recaptcha-containers",
        {
          size: "invisible",
          callback: function(response) {
            submitPhoneNumberAuthForgot();
          }
        }
      );            
});
