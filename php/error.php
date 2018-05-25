<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="../images/Logo.png"/>
        <title>Error! :(</title>
        <style type="text/css">
            body {
                max-width: 1200px;
                margin: 0 auto;
            }
            
            div#memes {
/*                background-image: url("https://media.giphy.com/media/9J7tdYltWyXIY/giphy.gif");*/
                height: 100em;
            }
            
            div#msg {
                padding: 1em;
                border-radius: 10px;
                background-color: red;
            }
            
            img {
                margin-left: 150px;
            }
        </style>
    </head>
    <body>
        <div id="content">
            <div id="msg">
                <h1>Ocurrió un error desconocido.</h1>
            </div>
            <div id="memes">
                <img id="img" src="" width="900"/>
            </div>
        </div>
        <script type="text/javascript">
            var array = [
                "https://media.giphy.com/media/9J7tdYltWyXIY/giphy.gif",
                "https://media.giphy.com/media/citBl9yPwnUOs/giphy.gif",
                "https://media.giphy.com/media/9J7tdYltWyXIY/giphy.gif",
                "https://media.giphy.com/media/fDO2Nk0ImzvvW/giphy.gif",
                "https://media.giphy.com/media/18ANhgTABn04M/giphy.gif",
                "https://media.giphy.com/media/hbd8nlok7kqnS/giphy.gif",
                "https://media.giphy.com/media/mq5y2jHRCAqMo/giphy.gif",
                "https://media.giphy.com/media/SKUhuXbT0OjwA/giphy.gif",
                "https://media.giphy.com/media/3owypf6HrM3J7UTvAA/giphy.gif",
                "https://media.giphy.com/media/xTiTncVep2khPGhK1i/giphy.gif",
                "https://media.giphy.com/media/5f2mqsGTHpe5a/giphy.gif",
                "https://media.giphy.com/media/Jk4ZT6R0OEUoM/giphy.gif"
            ];
            var img = document.getElementById("img");
            var x = Math.floor(Math.random()*array.length);
            img.src = array[x];
        </script>
    </body>
</html>
