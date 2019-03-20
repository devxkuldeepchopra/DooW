var config = {
    apiKey: "AIzaSyCwa1wIgCNMGeLjVDCHTQsbEBGOHtLtBE4",
    authDomain: "doomw-544ee.firebaseapp.com",
    databaseURL: "https://doomw-544ee.firebaseio.com",
    projectId: "doomw-544ee",
    storageBucket: "doomw-544ee.appspot.com",
    messagingSenderId: "14732587236"
  }; 
  firebase.initializeApp(config);
    const messaging = firebase.messaging();
    messaging.usePublicVapidKey('BK7o_JmtrE34vVM0o3OfJOFwXPfJFxfwhDuc5hgGoStC39aZYzr6WwNpyE-gyx-YiCDzuKVYL8TI05uzfO21jec');
    
    messaging.onTokenRefresh(function() {
    messaging.getToken().then(function(refreshedToken) {
      setTokenSentToServer(false);
      sendTokenToServer(refreshedToken);
    }).catch(function(err) {
            console.log('Unable to retrieve refreshed token ', err);
        });
    });

    function getPushToken() {
        messaging.getToken().then(function(currentToken) {
      if (currentToken) {
        sendTokenToServer(currentToken);
      } else {
        console.log('No Instance ID token available. Request permission to generate one.');
        setTokenSentToServer(false);
      }
    }).catch(function(err) {
      console.log('An error occurred while retrieving token. ', err);
      //showToken('Error retrieving Instance ID token. ', err);
      setTokenSentToServer(false);

    });
    }
    
    function sendTokenToServer(currentToken) {
        debugger;
        var sentToken = window.localStorage.getItem('token');
        var isValid = currentToken.includes(sentToken);
        if(!isValid){
            var http = new XMLHttpRequest();
            var url = '/server/Post.php';
            var params = 'action=PushToken&pushtoken='+currentToken;
            http.open('POST', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if(http.responseText){
                    setTokenSentToServer(currentToken);
                }
            }
        }
        http.send(params);          
        }
        else {
            console.log('Token already sent to server so won\'t send it again ' +'unless it changes');
        }
    }

    function isTokenSentToServer() {
        return window.localStorage.getItem('sentToServer') === '1';
    }

    function setTokenSentToServer(sent) {
        var senttoken = sent.slice(5,33)
        window.localStorage.setItem('token',senttoken);
    }

    function requestPermission() {
        messaging.requestPermission().then(function() {
            getPushToken();
        }).catch(function(err) {
         console.log('Unable to get permission to notify.', err);
        });
    }
    requestPermission();
    
//messaging.onMessage(function(payload) {
//  console.log('Message received. ', payload);
//  // ...
//});
