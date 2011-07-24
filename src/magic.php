<?php

echo "<iframe 
         src='http://google.com/' // location of external resource 
         width='80'              // width of iframe should match the width of containing div
         height='80'             // height of iframe should match the height of containing div
         marginwidth='0'          // width of iframe margin
         marginheight='0'         // height of iframe margin   
         frameborder='no'         // frame border preference
         scrolling='no'           // instructs iframe to scroll overflow content
         style='
                border-style: solid;  // border style
                border-color: #333;   // border color
                border-width: 2px;    // border width
                background: #FFF;     // background color
                '
      />";

?>