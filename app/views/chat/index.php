<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300"> -->
    <title>Ezpark Chat</title>

    
</head>

<style type ="text/css">

    @font-face{
        font-family:headFont;
        src:url(public/font/Summer-Vibes-OTF.otf);
    }

    #wrapper{

        max-width:900px;
        min-width:500px;
        display:flex;
        margin:auto;
        color:white;
        
    }

    #left_pannel{

        min-height:400px;
        background-color:#27344d;
        flex:1;


    }

    #right_pannel{

        min-height:500px;
        background-color:#27344d;
        flex:4;
    }

    #header{

        background-color: #475a6c;
        height:70px;
        font-size:40px;
        text-align:center;
        font-family:headFont;

    }

    #inner_left_pannel{

        background-color:#2b323a;
        flex:1;
        min-height:430px;

    }

    #inner_right_pannel{

        background-color: #dde8ee;
        flex:2;
        min-height:430px;

    }

</style>

<body>

    <div id ="wrapper">

        <div id="left_pannel">

        </div>

        <div id="right_pannel">
            <div id="header">Ezpark Chat</div>
            <div id="container" style="display: flex;">
                <div id="inner_left_pannel"></div>
                <div id="inner_right_pannel"></div>
            </div>
        </div>
    </div>


</body>
</html>