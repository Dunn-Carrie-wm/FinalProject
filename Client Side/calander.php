<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Calendar</title>

      <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
      <link rel="stylesheet" href="cal.css">
      <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

      <style>
        .close
        {
          float: right;
          width: 70px;
          height: 55px;
          background: transparent no-repeat;
          border: none;
          cursor: pointer;
          overflow: hidden;
          outline: none;
          font-size: 175%;
        }
        #secondDiv
        {
          position: absolute;
          margin-left: auto;
          margin-right: auto;
          width: 480px;
          height: 580px;
          z-index: 15;
        }
        .information
        {
          margin-left: auto;
          margin-right: auto;
          margin-top: 5.5%;
          border: solid;
          z-index: 3;
          background: rgba(255, 255, 255, 1);
          position: relative;
        }
      </style>
  </head>

  <body>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="cal.js"></script>

    <script>
      $(document).ready(function(){
        $(".today").click(function(){
          $('#secondDiv').show();
        });

        $(".close").click(function(){
          $('#secondDiv').hide();
        });
      });
    </script>

    <div id="calendar">
      <div id="calendar_header">
        <h1></h1>
      </div>

      <div id="calendar_weekdays"></div>
      <div id="calendar_content"></div>

      <div id="secondDiv" style="display: none; background-color: black">
        <div style="background-color: pink;">
          <h2 id="header" style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">Test</h2>
        </div>

        <div class="information" style="height: 55%;">
          <div>
            <button class="close">&#10006;</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>