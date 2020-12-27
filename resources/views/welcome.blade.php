<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BENJOL</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Muli" />

        <style>
            body {
                font-family: 'Muli';
                background-image: url('{{ asset('images/scooter-wave.png') }}');
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #ffffff;
            }

            .logo {
                display: block;
                margin-left: auto;
                margin-right: 200px;
                max-width: 400px;
                height: auto;
                width: 100%;
            }
            div.gallery {
                margin: 5px;
                float: left;
                width: 180px;
            }

            div.gallery img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }

            div.desc {
                padding: 15px;
                text-align: center;
            }

            div.center {
                position: absolute;
                left: 70%;
                top: 50%;
                transform: translate(-50%, -50%);
                padding: 10px;
            }

            .button {
                background-color: #FCCA53;
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 10%;
            }
        </style>
    </head>
    <body>
        <div style="padding-top:50px">
            <a href="http://benjol.bike">
            <img src="images/horizontal-primary.png" class="logo"/>
            </a>
        </div>
        <div style="padding-top:30px" class="center">           
            <div class="gallery">
                <img src="images/playstore.png" alt="Benjol Android">
            <div class="desc">
            <a href="http://intip.in/benjol-mobile">
            <button class="button">Get App</button>
            </a>
            </div>
            </div>

            <div class="gallery">
                <img src="images/windows.png" alt="Benjol PC"> 
                <div class="desc">
                <a href="http://intip.in/benjol-desktop">
                <button class="button">Get App</button>
                </a>
                </div>
            </div>
        </div>
    </body>
</html>
