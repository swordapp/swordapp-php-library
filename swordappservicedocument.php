<?php

require_once('workspace.php');

class SWORDAPPServiceDocument {

	// The HTTP status code returned
	public $sac_status;
	
	// The XML of the service doucment
	public $sac_xml;
	
	// The human readable status code
	public $sac_statusmessage;

	// The version of the SWORD server
	public $sac_version;

	// Whether or not verbose output is supported
	public $sac_verbose;

	// Whether or not the noOp command is supported
	public $sac_noop;

	// The max upload size of deposits
	public $sac_maxuploadsize;
	
	// Workspaces in the servicedocument
	public $sac_workspaces;

	// Construct a new servicedocument by passing in the http status code
	function __construct($sac_newstatus, $sac_thexml) {
		// Store the status
		$this->sac_status = $sac_newstatus;
		
		// Store the raw xml
		$this->sac_xml = $sac_thexml;

		// Store the status message
		switch($this->sac_status) {
			case 200:
				$this->sac_statusmessage = "OK";
				break;
			case 401:
				$this->sac_statusmessage = "Unauthorized";
				break;
			case 404:
				$this->sac_statusmessage = "Service document not found";
				break;
			default:
				$this->sac_statusmessage = "Unknown erorr (status code " . $this->sac_status . ")";
				break;
		}
	}

	// Build the workspace hierarchy
	function buildhierarchy($sac_ws, $sac_ns) {
		// Build the workspaces
		foreach ($sac_ws as $sac_workspace) {
			$sac_newworkspace = new Workspace(
			                    $sac_workspace->children($sac_ns['atom'])->title);
			$sac_newworkspace->buildhierarchy($sac_workspace->children($sac_ns['app']), $sac_ns);
			$this->sac_workspaces[] = $sac_newworkspace;
		}
	}
}

?>
