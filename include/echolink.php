<?php
?>
<div class="row">
    <div class="col">
      <div class="card text-center">
        <div class="card-header">
          Echolink User Count
        </div>
        <div id="elgauge"></div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">Connected Echolink Stations
        </div>
        <div class="table-responsive">
          <table id="echolink" class="table table-condensed">
  	    <thead>
              <tr>
                <th>Reporting Time (<?php echo TIMEZONE;?>)</th>
                <th>Callsign</th>
              </tr>
            </thead>
            <tbody>
<?php
	$users = getConnectedEcholink($logLines);
	foreach ($users as $user) {

		echo "<tr>";
		echo "<td>".convertTimezone($user['timestamp'])."</td>";

		if (defined("GDPR"))
			echo"<td nowrap>".str_replace("0","&Oslash;",substr($user['callsign'],0,3)."***")."</td>";
		else
			echo"<td nowrap>".str_replace("0","&Oslash;",$user['callsign'])."</td>";
		echo "</tr>";
	}
?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<?php $count = getEcholinkCount($logLines);
echo "  <script type=\"text/javascript\">
    function echolinkGauge() {
      const knob = pureknob.createKnob(300, 300);

      knob.setProperty('angleStart', -0.75 * Math.PI);
      knob.setProperty('angleEnd', 0.75 * Math.PI);
      knob.setProperty('colorBG', '#343a40');
      knob.setProperty('colorFG', '#88ff88');
      knob.setProperty('trackWidth', 0.4);
      knob.setProperty('valMin', 0);
      knob.setProperty('valMax', 50);

      knob.setValue("; echo $count; echo ");

      const node = knob.node();

      const elem = document.getElementById('elgauge');
      elem.appendChild(node);
    }
    function ready() {
      echolinkGauge();
    }
    document.addEventListener('DOMContentLoaded', ready, false);
    </script>";
?>

  </div>
