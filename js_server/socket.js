var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

server.listen(3000);



var game = [[]*n]

app.get('/', function(request, response){

  response.sendFile(__dirname + "/index.html");

});

io.on('connection', function(socket){
  socket.on('user.pushButton', function(data){

  });
});

setinterval(function(){

}, 500);
