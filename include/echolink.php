<?php
?>
  <div class="card">
  <div class="card-header">Connected Echolink Stations</div>
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
  <script>
    $(document).ready(function(){
      $('#echolink').dataTable( {
        "aaSorting": [[1,'asc']]
      } );
    });
   </script>
</div>

