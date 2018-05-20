var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

server.listen(3000);


var game = [[]];
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
  console.log();
  socket.on('user.pushButton', function(button){
    for(let i = 0; i<users.length; i++){
      if(socket.request.headers.cookie == users[i]['cookie']){
        users[i]['lastButtons'] += button;
      }
    }
  });
});



//some function for game logic
function find_tail(pos, last_pos){
  if(){}
  else if(){}
  else if(){}
  else if(){}
}



setInterval(function(){
  // gamelogic
  for(let i = 0; i< users.length; i++){
    var move = [0, 0];
    //find move direction
    for(let j =0; j<users[i]['lastButtons'].length; j++){
      switch(users[i]['lastButtons'][j]){
        case 'w':
          move[0]-=1;
          break;
        case 's':
          move[0]+=1;
          break;
        case 'a':
          move[1]-=1;
          break;
        case 'd':
          move[1]+=1;
          break;
      }
    }
    //without boost move by 1
    if(abs(move[0])>abs(move[1] && move[0] != 0){
      move[0] = move[0]/abs(move[0]);
      move[1] = 0;
    }
    else if(move[1] != 0){
      move[1] = move[1]/abs(move[1]);
      move[0] = 0;
    }

    var x=0;
    var y=0;
    let found = false;
    //find header
    for(let j = 0; j<map.length; j++){
      for(let k = 0; k<map[0].length; k++)
        if(map[j][k][0] != '0')
          if(map[j][k].slice(1) == user[i]['id'].toString()){
            y=j;
            x=k;
            found = true;
            break;
          }
      if(found)
        break;
    }

    //can move
    if(y+move[0] >= 0 && y+move[0] < map.length && x+move[1] >= 0 && x+move[1] < map[0].length)
      if(map[y+move[0]][x+move[1]] == '0' || map[y+move[0]][x+move[1]] == '1'){
        //slice tail
        if(map[y+move[0]][x+move[1]] != '1'){
          let [y1, x1] = find_tail([y,x], [-1, -1])
          map[y1][x1] = '0';
        }

        map[y+move[0]][x+move[1]] = map[y][x];
        map[y][x] = '0' + map[y][x].slice(1);
        //turn head
        switch(move){}
      }
  }
  io.emit('map.update', JSON.stringify(game))
}, 500);
