<?php

function getSvxConfig() {
        // loads svxlink.conf into array for further use
        $conf = array();
        if ($configs = fopen(SVXCONFPATH."/".SVXCONFFILENAME, 'r')) {
                while ($config = fgets($configs)) {
                        array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
                }
                fclose($configs);
        }
        return $conf;
}

function getConfigItem($section, $key, $configs) {
        // retrieves the corresponding config stanza within a [section]
        $sectionpos = array_search("[" . $section . "]", $configs) + 1;
        $len = count($configs);
        while(startsWith($configs[$sectionpos],$key."=") === false && $sectionpos <= ($len) ) {
                if (startsWith($configs[$sectionpos],"[")) {
                        return null;
                }
                $sectionpos++;
        }

        return substr($configs[$sectionpos], strlen($key) + 1);
}

function getGitVersion(){
	// retrieves the current Git version of the dashboard, if available
	if (file_exists(".git")) {
		exec("git rev-parse --short HEAD", $output);
		return 'GitID #<a href="https://github.com/kc1awv/SvxLink-Dashboard/commit/'.$output[0].'" target="_blank">'.$output[0].'</a>';
	} else {
		return 'GitID unknown';
	}
}

function getSvxLog() {
	// retrieves the current SvxLink log file
        $logLines = array();
        if ($log = fopen(SVXLOGPATH."/".SVXLOGPREFIX, 'r')) {
                while ($logLine = fgets($log)) {
                        array_push($logLines, $logLine);
                }
                fclose($log);
        }
        return $logLines;
}

function getConnectedEcholink($logLines) {
	// retrieves the current EchoLink users connected to the SvxLink
        $users = Array();
        foreach ($logLines as $logLine) {
                if(strpos($logLine,"Echolink QSO")){
                        $users = Array();
                }
                if(strpos($logLine,"state changed to CONNECTED")) {
                        $lineParts = explode(" ", $logLine);
			if (!array_search($lineParts[5], $users)) {
                                array_push($users, Array('callsign'=>substr($lineParts[5],0,-1),'timestamp'=>substr($logLine,0,24)));
                        }
                }
                if(strpos($logLine,"state changed to DISCONNECTED")) {
                        $lineParts = explode(" ", $logLine);
			$pos = array_search(substr($lineParts[5],0,-1), $users);
			array_splice($users, $pos, 1);
                }
        }
        return $users;
}

function initModuleArray() {
	// this initializes the active SvxLink module array for further use - move to tools.php?
	$modules = Array();
	foreach (SVXMODULES as $enabled) {
                $modules[$enabled] = 'Off';
        }
	return $modules;
}

function getActiveModules($logLines) {
	// this updates the module array with the status of the modules - could use cleanup
	$modules = initModuleArray();
        foreach ($logLines as $logLine) {
                if(strpos($logLine,"Activating module")) {
                        $lineParts = explode(" ", $logLine);
			$modul = substr($lineParts[8],0,-4);
                        if (!array_search($modul, $modules)) {
                                $modules[$modul] = 'On';
                        }
			if (array_search($modul, $modules)) {
				$modules[$modul] = 'On';
			}
                }
                if(strpos($logLine,"Deactivating module")) {
                        $lineParts = explode(" ", $logLine);
			$modul = substr($lineParts[8],0,-4);
			$modules[$modul] = 'Off';
                }
        }
        return $modules;
}

function getSize($filesize, $precision = 2) {
	// this is for the system info card
	$units = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');
	foreach ($units as $idUnit => $unit) {
		if ($filesize > 1024)
			$filesize /= 1024;
		else
			break;
	}
	return round($filesize, $precision).' '.$units[$idUnit].'B';
}

?>
