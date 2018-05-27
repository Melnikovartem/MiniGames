<html>
  <head>
    <title>Snake</title>
    <meta charset = "UTF-8">
    <style>
      body {
        background-color: #FFFAF0;
      }

      .main {
        display: flex;
        justify-content: center;
      }

    </style>
  </head>
  <body onkeypress="push(event)">


    <div class="main"  >
      <canvas width="840" height="600" id="canvas"></canvas>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js" charset="utf-8"></script>
    <script>
    var session ={{ $session }};
    var code = {{ $code }};
      var socket = io();
      socket.on('map.update', function(map){
        render(map);
        //update map
      });

      var id = '10';


      function push(e){
        switch (event.which || event.keyCode) {
          case 119:
            socket.emit(code + ':pushButton', 'w')
            break;
          case 115:
            socket.emit(code + ':pushButton', 's')
            break;
          case 97:
            socket.emit(code + ':pushButton', 'a')
            break;
          case 100:
            socket.emit(code + ':pushButton', 'd')
            break;

        }
      }

      function find_head(id, map, w, h) {
        for (var i = 0; i < h; i += 1) {
          for (var j = 0; j < w; j += 1) {
            if (map[i][j].length == 3 && map[i][j][0] != "0" && (map[i][j][1] + map[i][j][2]) == id) {
              return [i, j];
            }
          }
        }
        return [-1, -1];
      }

      function render(fileJSON) {

        var mydata = JSON.parse(fileJSON);
        var map1 = mydata["map"];
        var map = [];
        var color = mydata["color"];
        var list = mydata["list"];
        var n = 30;
        var max_x = 25;
        var max_y = 15;



        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');
        var t = 0, r, g, b, x, y;

        ctx.clearRect(0, 0, 840, 600);
        ctx.lineWidth = 0.17;

        for (var i = 0; i < max_x; i += 1) {
          for (var j = 0; j < max_y; j += 1) {
            ctx.strokeRect(i*n, j*n, n, n);
          }
        }
        var pos = find_head(id, map1, mydata["w"], mydata["h"]);
        var h = mydata["h"];
        var w = mydata["w"];
        // pos = [51, 50];
        // alert(pos);

        if (pos[0] < max_y / 2) {
          pos[0] = Math.trunc(max_y / 2);
        }
        if (pos[1] < max_x / 2) {
          pos[1] = Math.trunc(max_x / 2);
        }

        if (pos[0] > h - max_y / 2) {
          pos[0] = h - Math.trunc(max_y / 2) - 1;
        }
        if (pos[1] > w - max_x / 2) {
          pos[1] = w - Math.trunc(max_x / 2) - 1;
        }

        // alert(pos);

        var k = 0, f;
        for (var i = pos[0] - Math.trunc(max_y / 2); i <= pos[0] + Math.trunc(max_y / 2); i += 1) {
          f = [];
          for (var j = pos[1] - Math.trunc(max_x / 2); j <= pos[1] + Math.trunc(max_x / 2); j += 1) {
            f.push(map1[i][j]);
          }
          map.push(f)
          k += 1;
        }


        for (var i = 0; i < max_y; i += 1) {
          for (var j = 0; j < max_x; j += 1) {
            t = map[i][j];
            if (t == "0") {
              continue;
            } else if (t == "1") {
              ctx.fillStyle = 'red';
              ctx.beginPath();
              ctx.arc(j*n + n / 2, i*n + n / 2, n / 3, 0, 2*Math.PI, false);
              ctx.fill();

              ctx.strokeStyle = '#43CD80';
              ctx.lineWidth = 4;
              ctx.lineCap = "round";
              ctx.beginPath();
              ctx.moveTo(j*n + n / 2, i*n + n*0.1);
              ctx.lineTo(j*n + n / 2, i*n + n / 2 - n*0.1);
              ctx.stroke();
            } else if (t == "2") {
              for (var k = 0; k < 8; k += 1) {
                r = Math.floor(Math.random() * 255) + 70;
                g = Math.floor(Math.random() * 255) + 70;
                b = Math.floor(Math.random() * 255) + 70;
                x = Math.random()*(n / 1.5) - (n / 3);
                y = Math.random()*(n / 1.5) - (n / 3);

                ctx.fillStyle = 'rgba(' + r + ',' + g + ',' + b + ', 0.5)';
                ctx.beginPath();
                ctx.arc(j*n + n / 2 + x, i*n + n / 2 + y, n / 8, 0, 2*Math.PI, false);
                ctx.fill();
              }
            } else if (t == "3") {
              ctx.fillStyle = 'blue';
              ctx.moveTo(j*n + n / 2, i*n + n*0.25);
              ctx.beginPath();
              ctx.lineTo(j*n + n / 2 + n*0.3, (i + 1)*n - n*0.25);
              ctx.lineTo(j*n + n / 2 - n*0.3, (i + 1)*n - n*0.25);
              ctx.lineTo(j*n + n / 2, i*n + n*0.25);
              ctx.fill();
              ctx.fillStyle = "red";
              ctx.textAlign = "center";
              ctx.font = (n / 2.3) + "px Arial";
              ctx.fillText("B", j*n + n / 2, i*n + n / 1.39);
            } else if (t[0] == "0") {
              ctx.fillStyle = color[t[1] + t[2]];
              ctx.fillRect(j*n, i*n, n, n);
            } else {
              ctx.fillStyle = color[t[1] + t[2]];
              ctx.beginPath();
              ctx.arc(j*n + n / 2, i*n + n / 2, n / 2, 0, 2*Math.PI, false);
              ctx.fill();


              var t1;

              if (t[0] == "1") {
                t1 = -Math.PI;
                ctx.fillRect(j*n, (i + 0.5)*n, n, n / 2);
              }
              if (t[0] == "2") {
                t1 = -0.5*Math.PI;
                ctx.fillRect(j*n, i*n, n / 2, n);
              }
              if (t[0] == "3") {
                t1 = 0;
                ctx.fillRect(j*n, i*n, n, n / 2);
              }
              if (t[0] == "4") {
                t1 = 0.5*Math.PI;
                ctx.fillRect((j + 0.5)*n, i*n, n / 2, n);
              }

              ctx.fillStyle = 'white';
              ctx.beginPath();
              ctx.arc(j*n + n / 2, i*n + n / 2, n / 4, t1, t1 + Math.PI, false);
              ctx.fill();
            }
          }
        }


        ctx.strokeStyle = "black";
        ctx.lineWidth = 0.17;
        /*
        ctx.strokeRect(640, 440, 200, 160);
        ctx.font = "italic 14pt Arial";
        for (var i = 0; i < 3; i += 1) {
          if (i == 1) {
            ctx.fillStyle = "#EE2C2C";
            ctx.fillText((i + 1) + ") " + list[i][0] + " -> " + list[i][1], 660, 470 + i*n);
          } else {
            ctx.fillStyle = "black";
            ctx.fillText((i + 1) + ") " + list[i][0] + " -> " + list[i][1], 660, 470 + i*n);
          }
        }
  */
      }
    </script>
  </body>

</html>
