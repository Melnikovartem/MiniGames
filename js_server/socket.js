var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

server.listen(3000);

var height = 200;
var len = 200;
var game = [];
var row = [];

//empty field
for(let j =0; j< height; j++){
  row = [];
  for(let k = 0; k< len; k++)
    row.push('0');
  game.push(row);
}
var users= [];
var new_id = 10;

var game_on = false;
app.get('/', function(request, response){

  response.sendFile(__dirname + "/index.html");
  let id = -1;
  if (new_id<=20 && !game_on ){
    id = new_id;
    new_id +=1;
    users.push({id: id, cookie : request.headers.cookie, lastButtons: ''});
  }
  console.log(users);
});


io.on('connection', function(socket){
  socket.on('user.pushButton', function(button){
    for(let i = 0; i<users.length; i++){
      if(socket.request.headers.cookie == users[i]['cookie']){
        users[i]['lastButtons'] += button;
      }
    }
  });
});


//generate position of food/players

function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}

for(let i =0; i< users.length; i++)
  for(let j = 0; j< 1000; j++){
    let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
    if(y1+1<game.length && y1-1>=0)
      if(game[y1][x1] == '0' && game[y1-1][x1] == '0' && game[y1+1][x1] == '0'){
        game[y1][x1]   = '1' + users[i]['id'].toString();
        game[y1+1][x1] = '0' + users[i]['id'].toString();
        break;
      }
}

//generate food
for(let k =0; k<10; k++)
  for(let j = 0; j< 1000; j++){
    let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
    if(game[y1][x1] == '0'){
      game[y1][x1] = '1';
      break;
    }
  }


//some function for game logic
function find_tail(pos, last_pos)
{
  //to do
}

function death(pos)
{
  //to do
}

if(users.length >= 3){
  game_on = true;
setInterval(function(){
  // gamelogic

  //for each player
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
    if(Math.abs(move[0])>Math.abs(move[1]) && move[0] != 0){
      move[0] = move[0]/Math.abs(move[0]);
      move[1] = 0;
    }
    else if(move[1] != 0){
      move[1] = move[1]/Math.abs(move[1]);
      move[0] = 0;
    }
    else{
      move = [-1,0];
    }

    var x=0;
    var y=0;
    let found = false;
    //find head
    for(let j = 0; j<game.length; j++){
      for(let k = 0; k<game[0].length; k++)
        if(game[j][k].length == 3)
          if(game[j][k].slice(1) == user[i]['id'].toString()){
            y=j;
            x=k;
            found = true;
            break;
          }
      if(found)
        break;
    }

    //can move
    if(y+move[0] >= 0 && y+move[0] < game.length && x+move[1] >= 0 && x+move[1] < game[0].length){
      if(game[y+move[0]][x+move[1]].length == 1){
        //slice tail
        if(game[y+move[0]][x+move[1]] != '1' || game[y+move[0]][x+move[1]] != '3'){
          let [y1, x1] = find_tail([y,x], [-1, -1]);
          game[y1][x1] = '0';
        }
        //generate more food
        if(game[y+move[0]][x+move[1]] == '1'){
          for(let j = 0; j< 1000; j++){
            let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
            if(game[y1][x1] == '0'){
              game[y1][x1] = 1;
              break;
            }
          }
        }
        game[y+move[0]][x+move[1]] = game[y][x];
        game[y][x] = '0' + game[y][x].slice(1);
        //turn head
        switch(move){
          case[-1, 0]:
            game[y+move[0]][x+move[1]] = '1' + game[y+move[0]][x+move[1]].slice(1);
            break;
          case [1, 0]:
            game[y+move[0]][x+move[1]] = '3' + game[y+move[0]][x+move[1]].slice(1);
            break;
          case [0, 1]:
            game[y+move[0]][x+move[1]] = '2' + game[y+move[0]][x+move[1]].slice(1);
            break;
          case[0, -1]:
            game[y+move[0]][x+move[1]] = '4' + game[y+move[0]][x+move[1]].slice(1);
            break;
        }
      }
      else{
        death([x,y]);
      }
    }
    else{
      death([x,y]);
    }
  }

  io.emit('map.update', JSON.stringify(game))
}, 500);

}
