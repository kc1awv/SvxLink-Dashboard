<?php
?>
  <div class="card">
    <div class="card-header">
      System Status
    </div>
    <div class="table-responsive">
      <table id="status" class="table table-condensed table-bordered">
        <thead>
          <tr class="text-center">
            <th>Transmitter</th>

<?php
	$modules = getActiveModules($logLines);
	foreach (array_keys($modules) as $module) {
		echo "<th>".$module." Module</th>";
	}
?>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center">
            <td class="table-success">RX</td>
<?php
	foreach (array_values($modules) as $status) {
		if ($status == "On") {
			echo "<td class=\"table-success\">".$status."</td>";
		} else {
			echo "<td class=\"table-danger\">Off</td>";
		}
	}
?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
