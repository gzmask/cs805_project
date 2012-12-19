<?php
if ($_REQUEST['roty']) {
  $roty = $_REQUEST['roty'];
} else {
  $roty = 1;
}
if ($_REQUEST['rotz']) {
  $rotz = $_REQUEST['rotz'];
} else {
  $rotz = 1;
}
if ($_REQUEST['zoom']) {
  $zoom = $_REQUEST['zoom'];
} else {
  $zoom = 1;
}
if ($_REQUEST['lcf']) {
  $lcf = $_REQUEST['lcf'];
} else {
  $lcf = 1;
}
if ($_REQUEST['hcf']) {
  $hcf = $_REQUEST['hcf'];
} else {
  $hcf = 255;
}
if ($_REQUEST['threshold']) {
  $threshold = $_REQUEST['threshold'];
} else {
  $threshold = 10;
}
?>
<html>
  <head>
    <title>CS805 final project</title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <style>

      body {
        background: black;
        color: white;
      }

      #threshold_slider { 
        background: #00f;
        margin: 10px; 
      }
      #filter_slider { 
        background: #f00;
        margin: 10px; 
      }
    </style>

    <script>
      function updateURLParameter(url, param, paramVal){
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";
        if (additionalURL) {
            tempArray = additionalURL.split("&");
            for (i=0; i<tempArray.length; i++){
                if(tempArray[i].split('=')[0] != param){
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        }
        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
      };

      function zoom_change(event, ui){
        var newURL = updateURLParameter(window.location.href, 'zoom', ui.value);
        window.location = newURL;
      };

      function roty_change(event, ui){
        var newURL = updateURLParameter(window.location.href, 'roty', ui.value);
        window.location = newURL;
      };
      
      function rotz_change(event, ui){
        var newURL = updateURLParameter(window.location.href, 'rotz', ui.value);
        window.location = newURL;
      };

      function threshold_change(event, ui){
        var newURL = updateURLParameter(window.location.href, 'threshold', ui.value);
        window.location = newURL;
      };

      function filter_change(event, ui){
        var newURL = updateURLParameter(window.location.href, 'lcf', ui.values[0]);
        newURL = updateURLParameter(newURL, 'hcf', ui.values[1]);
        window.location = newURL;
      };

      $(document).ready(function() {
        $("#roty_slider").slider({ animate:true, max:100, min:1, value:<?php echo $roty ?>,change:roty_change });
        $("#rotz_slider").slider({ animate:true, max:100, min:1, value:<?php echo $rotz ?>,change:rotz_change });
        $("#zoom_slider").slider({ animate:true, max:100, min:1, value:<?php echo $zoom ?>,change:zoom_change });
        $("#filter_slider").slider({ range:true, animate:true, max:255, min:1, values:[<?php echo $lcf.','.$hcf ?>],change:filter_change });
        $("#threshold_slider").slider({ range:"min", animate:true, max:100, min:1, value:<?php echo $threshold ?>,change:threshold_change });
      });
    </script>
  </head>
  <body>
    <h1> Computer Graphic: Volume rendering CT sample </h1>
    <p>
      Please adjust the following sliders to intractively modify the rendering.<br />
    </p>
    <?php
    shell_exec('bin/run '.$roty.' '.$rotz.' '.$zoom.' '.$lcf.' '.$hcf.' '.$threshold);
    shell_exec('rawtopgm 512 512 output.raw > tmp.pgm');
    shell_exec('ppmtojpeg < tmp.pgm > result.jpg');
    ?>
  <table>
  <tr>
    <td style="width: 500px;">
      Rotation around Y:<br />
      <div id="roty_slider"></div><br />
      Rotation around Z:<br />
      <div id="rotz_slider"></div><br />
      Zoom:<br />
      <div id="zoom_slider"></div><br />
      Density filter:<br />
      <div id="filter_slider"></div><br />
      Derivative Threshold:<br />
      <div id="threshold_slider"></div><br />
    </td>
    <td><img src="result.jpg" /></td>
  </tr>
  </table>
  </body>
</html>
