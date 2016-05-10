<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Calendar</title>

      <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
      <link rel="stylesheet" href="cal.css">
      <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  </head>

  <body>
    <div id="calendar">
      <div id="calendar_header">
        <i class="icon-chevron-left"></i>
        <h1></h1>
        <i class="icon-chevron-right"></i>
      </div>

      <div id="calendar_weekdays"></div>
      <div id="calendar_content"></div>
    </div>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="cal.js"></script>

    <script>
      $(document).ready(function(){
        var toggle = 0;
        $(".today").click(function(){
          if(toggle == 0)
          {
            $('#calendar').hide();
            $('#result').show();
            toggle++;
          }
          else
          {
            $('#calendar').show();
            $('#result').hide();
            toggle--;
          }
        });
      });
    </script>

    <div id="result" style="height: 700px; width: 510px; margin-left: 400px; position: absolute; display: none; background-color: black">
      <br>
      <div style="background-color: pink;">
      <h2 id="header" style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">Test</h2>
      </div>

      <div id="text" style=" height: 400px; width: 900px; text-align: center; font-size: 30px; border: dashed; border-color: black">

      </div>
    </div>

  </body>
</html>