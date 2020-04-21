<?php
?>
  <div class="card">
    <div class="card-header text-center">
      SvxLink System Logs (<?php echo TIMEZONE; ?>) <br /> Latest log line first | Screen refreshes every <strong> <?php echo REFRESHAFTER; ?> </strong> seconds
    </div>
    <pre class="pre-scrollable" style="max-height: 80vh">
      <code>
<?php
	$logLines = getSvxLog();
	$reverseLogLines = $logLines;
	array_multisort($reverseLogLines,SORT_DESC);
	foreach ($reverseLogLines as $logLine) {
		echo $logLine;
	}
?>
      </code>
    </pre>
  </div>
