<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <title>LED CONTROL</title>
  <script type="text/javascript">
    function restoreSliderOpacity() {
      var redSliderValue = "rgba(233, 81, 58," + document.getElementById('redSlider').value * 3.9 / 1000 + ")";
      var greenSliderValue = "rgba(47, 202, 108," + document.getElementById('greenSlider').value * 3.9 / 1000 + ")";
      var blueSliderValue = "rgba(70, 70, 255," + document.getElementById('blueSlider').value * 3.9 / 1000 + ")";
      document.getElementById('redSlider').style.backgroundColor = redSliderValue;
      document.getElementById('greenSlider').style.backgroundColor = greenSliderValue;
      document.getElementById('blueSlider').style.backgroundColor = blueSliderValue;
    }

    function sliderColorChange(slider) {
      if (slider.id == 'redSlider')
        var currentSliderValue = "rgba(233, 81, 58,";
      if (slider.id == 'greenSlider')
        var currentSliderValue = "rgba(47, 202, 108,";
      if (slider.id == 'blueSlider')
        var currentSliderValue = "rgba(70, 70, 255,";
      var calculateSliderOpacity = slider.value * 3.9 / 1000 + ")";
      document.getElementById(slider.id).style.backgroundColor = currentSliderValue + calculateSliderOpacity;
    }

    function createAJAXRequest() {
      try {
        var ajaxRequest = new XMLHttpRequest();
      } catch (e1) {
        try {
          ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e2) {
          try {
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e3) {
            ajaxRequest = false;
          }
        }
      }
      return ajaxRequest;
    }

    function sendCommand(data) {
      var ajaxRequest = createAJAXRequest();
      ajaxRequest.open("POST", "execute_command.php", true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajaxRequest.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.status == 200) {
            if (this.responseText != null) {
              //alert(data);
            } else alert("Ajax error: No data received");
          } else alert("Ajax error: " + this.statusText);
        }
      }
      ajaxRequest.send(data);
    }

    function executeCommand() {
      /*POST DATA
      "submit_command=Execute&RGB=xxx,xxx,xxx&stay_time=1&change_time=1&enable_random=0&powerOn=true" */
      var RGB = document.getElementById('redSlider').value + "," +
        document.getElementById('greenSlider').value + "," +
        document.getElementById('blueSlider').value;
      var lampState =
        "&stay_time=" + document.getElementById('stayTime').value +
        "&change_time=" + document.getElementById('changeTime').value +
        "&enable_random=" + document.getElementById('enableRandomCheckbox').checked +
        "&powerOn=" + document.getElementById('ioCheckbox').checked;
      var data = "submit_command=Execute&RGB=" + RGB + lampState;
      sendCommand(data);
    }
  </script>
</head>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'get_current_values.php';
$currentValues = GetCurrentExecuteValues();
$redValue = $currentValues[0];
$greenValue = $currentValues[1];
$blueValue = $currentValues[2];
$stayTimeValue = $currentValues[3];
$changeTimeValue = $currentValues[4];
$enableRandomValue = $currentValues[5];
$powerOn = $currentValues[6];
?>

  <body onload="restoreSliderOpacity();">
    <form>
      <div id="wrapper">
        <div id="rgb_part" class="horizontal_middle">
          Red
          <input type="range" id="redSlider" min="1" max="255" value=<?php echo $redValue; ?> step="1" oninput="sliderColorChange(this);" onchange="executeCommand()"/>
          Green
          <input type="range" id="greenSlider" min="1" max="255" value=<?php echo $greenValue; ?> step="1" oninput="sliderColorChange(this);" onchange="executeCommand()"/>
          Blue
          <input type="range" id="blueSlider" min="1" max="255" step="1" value=<?php echo $blueValue; ?> oninput="sliderColorChange(this);" onchange="executeCommand()"/>
        </div>
        <div id="func_wrapper" class="horizontal_middle">
          <div id="func_part1">
            <span>Change Time</span>
            <input type="range" id="changeTime" min="1" max="10" step="1" value=<?php echo $changeTimeValue; ?> onchange="executeCommand()" />
            <span>Stay Time</span>
            <input type="range" id="stayTime" min="1" max="10" step="1" value=<?php echo $stayTimeValue; ?> onchange="executeCommand()" />
          </div>
          <div id="func_part2">

            <div class="flatCheckbox">
              <span>Enable random</span>
              <input type="checkbox" id="enableRandomCheckbox" <?php echo $enableRandomValue=="true" ? "checked" : ""; ?> onchange="executeCommand()"/>
              <label for="enableRandomCheckbox"></label>
              <div></div>
            </div>

            <div class="flatCheckbox">
              <span>Power</span>
              <input type="checkbox" id="ioCheckbox" <?php echo $powerOn=="true" ? "checked" : ""; ?> onchange="executeCommand()"/>
              <label for="ioCheckbox"></label>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </body>

</html>
