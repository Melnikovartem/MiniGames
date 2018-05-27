var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('snake:new_game');

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
});

//some function for game logic
function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}

function death(pos, game)
{
  id = game[pos[0]][pos[1]].slice(1);
  if(game[pos[0]][pos[1]][0] == '0')
  {
    if(getRandomInt(2) == 1)
      game[pos[0]][pos[1]] = '2';
    else
      game[pos[0]][pos[1]] = '0';
  }
  else
    game[pos[0]][pos[1]] = '1' + game[pos[0]][pos[1]].slice(1);

  if(pos[0]-1>=0)
    if(game[pos[0]-1][pos[1]].slice(1) == id)
      death([pos[0]-1,pos[1]], game)
  if(pos[0]+1<game.length)
    if(game[pos[0]+1][pos[1]].slice(1) == id)
      death([pos[0]+1,pos[1]], game)
  if(pos[1]-1>=0)
    if(game[pos[0]][pos[1]-1].slice(1) == id)
      death([pos[0],pos[1]-1], game)
  if(pos[1]+1<game[0].length)
    if(game[pos[0]][pos[1]+1].slice(1) == id)
      death([pos[0],pos[1]+1], game)
}

//[{name: 'name', code: 'wqdqwe123S'}]
function play(users, session){

for(let i =0; i< users.length; i++){
    io.on(user['code'] + ':pushButton', function(button){
          users[i]['lastButtons'] += button;
    });
    users[i]['snake'] = []
  }

  let height = 100;
  let len = 100;
  let dead = [];
  let food = 500;
  let users_end = 1;
  let tick = 200;

  let game = [];
  let row = [];
  //empty field
  for(let j =0; j< height; j++){
    row = [];
    for(let k = 0; k< len; k++)
      row.push('0');
    game.push(row);
  }
  //generate position of food/players

  for(let i =0; i< users.length; i++)
    for(let j = 0; j< 1000; j++){
      let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
      if(y1+1<game.length && y1-1>=0)
        if(game[y1][x1] == '0' && game[y1-1][x1] == '0' && game[y1+1][x1] == '0'){
          game[y1][x1]   = '1' + users[i]['id'].toString();
          game[y1+1][x1] = '0' + users[i]['id'].toString();
          users[i]['snake'] = [[y1+1,x1],[y1,x1]];
          break;
        }
    }
    //generate food
    for(let k =0; k<food; k++)
      for(let j = 0; j< 1000; j++){
        let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
        if(game[y1][x1] == '0'){
          game[y1][x1] = '1';
          break;
        }
      }
    let data = {};// to do
    io.emit(session + ':game_start', JSON.stringify(data))
    let game_id = setInterval(function(){
      // gamelogic

      //for each player
      for(let i = 0; i< users.length; i++){
        var move = [0, 0];
          switch(users[i]['lastButtons'][users[i]['lastButtons'].length-1]){
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
        if(move[0] == 0 && move[1] == 0)
          move = [-1, 0];
        var [y,x] = users[i]['snake'][users[i]['snake'].length-1];
        let found = false;
        //can move
        if(y+move[0] >= 0 && y+move[0] < game.length && x+move[1] >= 0 && x+move[1] < game[0].length){
          if(users[i]['snake'][users[i]['snake'].length-2][0] == y+move[0] && users[i]['snake'][users[i]['snake'].length-2][1] == x+move[1]){
              move[0] = -move[0];
              move[1] = -move[1];
          }
          if(game[y+move[0]][x+move[1]].length == 1){
            //slice tail
            if(game[y+move[0]][x+move[1]] != '1' && game[y+move[0]][x+move[1]] != '2'){
              let [y1, x1] = users[i]['snake'].splice(0,1)[0];
              game[y1][x1] = '0';
            }
            //generate more food
            if(game[y+move[0]][x+move[1]] == '1'){
              for(let j = 0; j< 1000; j++){
                let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
                if(game[y1][x1] == '0'){
                  game[y1][x1] = '1';
                  break;
                }
              }
            }
            if(move[0] == -1 && move[1] == 0)
                game[y+move[0]][x+move[1]] = '1' + game[y][x].slice(1);
            else if(move[0] == 1 && move[1] == 0)
                game[y+move[0]][x+move[1]] = '3' + game[y][x].slice(1);
            else if(move[0] == 0 && move[1] == 1)
                game[y+move[0]][x+move[1]] = '2' + game[y][x].slice(1);
            else if(move[0] == 0 && move[1] == -1)
                game[y+move[0]][x+move[1]] = '4' + game[y][x].slice(1);
            users[i]['snake'].push([y+move[0], x+move[1]])
            game[y][x] = '0' + game[y][x].slice(1);
          }
          else{
            dead.push(i);
            death([y, x], game);
          }
        }
        else{
          dead.push(i);
          death([y, x], game);
        }
      }
      while(dead.length > 0){
        users.splice(dead[0], 1);
        dead.splice(0, 1);
        for(let k = 0; k< dead.length;k++)
          dead[k]-=1;
      }
      var ter = {};
      ter["map"] = game;
      ter["h"] = game.length;
      ter["w"] = game[0].length;
      ter["color"] = {
      "10": "black",
      "11": "blue",
      "12": "#778899",
      "13": "#6495ED",
      "14": "#40E0D0",
      "15": "#7FFF00",
      "16": "#EEE8AA",
      "17": "#CD5C5C",
      "18": "#FFB6C1",
      "19": "#9400D3",
      "20": "#90EE90",
    };

    /*
      ter["list"] = [["Artem", 1234], ["Alex", 945], ["NoName", 12], ["Slava", -10]]; //топ гроков
      ter["score"] = 12345;

    */
      io.emit(session + ':map.update', JSON.stringify(ter));
      if(users.length == users_end)
      {
        clearInterval(game_id);
        new_id = 10;
        game_on = false;
        users = [];
      }
    }, tick);
}
