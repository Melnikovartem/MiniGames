var height = 100;
var len = 100;
var game = [];
var row = [];

//empty field
for(let j =0; j< height; j++){
  row = [];
  for(let k = 0; k< len; k++)
    row.push('0');
  game.push(row);
}
var users= [
  {id: 10, cookie : '', lastButtons: ''},
  {id: 11, cookie : '', lastButtons: ''},
  {id: 12, cookie : '', lastButtons: ''},
  {id: 13, cookie : '', lastButtons: ''},
  {id: 14, cookie : '', lastButtons: ''},
];

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
for(let k =0; k<1000; k++)
  for(let j = 0; j< 1000; j++){
    let [y1, x1]= [getRandomInt(game.length), getRandomInt(game[0].length)];
    if(game[y1][x1] == '0'){
      game[y1][x1] = '1';
      break;
    }
  }

/*
var str;
for(let i = 0; i< game.length; i++ ){
  str = '';
  for(let j = 0; j< game[0].length; j++ )
    if(game[i][j].length == 1)
      str += '00' + game[i][j] + ' '
    else
      str += game[i][j] + ' '
  console.log(str);
}
*/
var fs = require('fs');
fs.writeFile(__dirname + "/test_map.txt", JSON.stringify(game));
