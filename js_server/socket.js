var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

server.listen(3000);


var game = [[0,0,0]];
var users= [];
var new_id = 10;

app.get('/', function(request, response){

  response.sendFile(__dirname + "/index.html");
  let id = -1;
  if (new_id<=20){
    id = new_id;
    new_id +=1;
    users.push({id: id, cookie : request.headers.cookie, lastButtons: ''});
  }
});

io.on('connection', function(socket){
  console.log(socket.request.headers.cookie);
  socket.on('user.pushButton', function(button){
  });
});

setInterval(function(){
  // gamelogic
  game[0][0]+=1;
  io.emit('map.update', JSON.stringify(game))
}, 500);
