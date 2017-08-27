### NAMING CONVENTIONS
Application framework is in lib folder (namespace Weekend).  
Custom code is in src folder (namespace MyApp).


### SERVER
Start built in server (from main folder):  
bin/start

### MAILER
For mailing purposes you have to create hide_myapp_mailer.yml file in /src/
folder with following body:
    parameters:
        url:            'your smtp provider host'
        port:           your smtp port
        user:           'your email'
        pass:           'your password'
        security:       'ssl or tls as email encryption protocol'



### MISC

1. Installing Curl php extension needed for Curl/Curl - restart the server.