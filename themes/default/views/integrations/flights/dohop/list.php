
<html lang="en">
    <head>
        <style>
          html, body {
            height: 100%;
            overflow: hidden;
          }
          #wrapper {
            width: 100%;
            position:static;
            background-color: transparent;
          }
          /* Browser Scroller Styler */
         ::selection { background: #a8d1ff; }
         ::-moz-selection { background: #a8d1ff; }
         ::-webkit-scrollbar { width: 10px; }
         ::-webkit-scrollbar-track { background-color: #eaeaea; border-left: 1px solid #ccc; }
         ::-webkit-scrollbar-thumb { background-color: #888888; }
         ::-webkit-scrollbar-thumb:hover { background-color: #636363; }
        </style>
    </head>
    <body >
        <div id="wrapper">
             <iframe style="margin-top:-10px" id="tree" name="tree" src="//whitelabel.dohop.com/w/<?php echo $username;?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe>
        </div>
    </body>
</html>