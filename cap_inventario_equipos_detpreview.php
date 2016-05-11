<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_inventario_equipos_detinfo.php" ?>
<?php include_once "cap_inventario_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_inventario_equipos_det_preview = NULL; // Initialize page object first

class ccap_inventario_equipos_det_preview extends ccap_inventario_equipos_det {

	// Page ID
	var $PageID = 'preview';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_inventario_equipos_det';

	// Page object name
	var $PageObjName = 'cap_inventario_equipos_det_preview';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			$html .= "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewWarningIcon\"></td><td class=\"ewWarningMessage\">" . $sWarningMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewSuccessIcon\"></td><td class=\"ewSuccessMessage\">" . $sSuccessMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewErrorIcon\"></td><td class=\"ewErrorMessage\">" . $sErrorMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (cap_inventario_equipos_det)
		if (!isset($GLOBALS["cap_inventario_equipos_det"])) {
			$GLOBALS["cap_inventario_equipos_det"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_inventario_equipos_det"];
		}

		// Table object (cap_inventario_equipos)
		if (!isset($GLOBALS['cap_inventario_equipos'])) $GLOBALS['cap_inventario_equipos'] = new ccap_inventario_equipos();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'preview', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_inventario_equipos_det', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (is_null($Security)) $Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			echo $Language->Phrase("NoPermission");
			exit();
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel(CurrentProjectID() . 'cap_inventario_equipos_det');
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			echo $Language->Phrase("NoPermission");
			exit();
		}
		if (!$Security->CanList()) {
			echo $Language->Phrase("NoPermission");
			exit();
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $Recordset;
	var $TotalRecs;
	var $RecCount;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load filter
		$filter = @$_GET["f"];
		$filter = TEAdecrypt($filter, EW_RANDOM_KEY);
		if ($filter == "") $filter = "0=1";

		// Call Recordset Selecting event
		$this->Recordset_Selecting($filter);

		// Load recordset
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset = $this->LoadRs($filter);
		$this->TotalRecs = ($this->Recordset) ? $this->Recordset->RecordCount() : 0;

		// Call Recordset Selected event
		$this->Recordset_Selected($this->Recordset);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE, 'utf-8') ?>
<?php

// Create page object
if (!isset($cap_inventario_equipos_det_preview)) $cap_inventario_equipos_det_preview = new ccap_inventario_equipos_det_preview();

// Page init
$cap_inventario_equipos_det_preview->Page_Init();

// Page main
$cap_inventario_equipos_det_preview->Page_Main();
?>
<link href="phpcss/ArtEnCel_920.css" rel="stylesheet" type="text/css">
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo  $cap_inventario_equipos_det->TableCaption() ?>&nbsp;
<?php if ($cap_inventario_equipos_det_preview->TotalRecs > 0) { ?>
(<?php echo $cap_inventario_equipos_det_preview->TotalRecs ?>&nbsp;<?php echo $Language->Phrase("Record") ?>)
<?php } else { ?>
(<?php echo $Language->Phrase("NoRecord") ?>)
<?php } ?>
</p>
<?php $cap_inventario_equipos_det_preview->ShowPageHeader(); ?>
<?php if ($cap_inventario_equipos_det_preview->TotalRecs > 0) { ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="ewDetailsPreviewTable" class="ewTable ewTableSeparate">
	<thead><!-- Table header -->
		<tr class="ewTableHeader">
<?php if ($cap_inventario_equipos_det->Num_IMEI->Visible) { // Num_IMEI ?>
			<td><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos_det->Num_IMEI->FldCaption() ?></td></tr></table></td>
<?php } ?>
<?php if ($cap_inventario_equipos_det->Articulo->Visible) { // Articulo ?>
			<td><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos_det->Articulo->FldCaption() ?></td></tr></table></td>
<?php } ?>
<?php if ($cap_inventario_equipos_det->Acabado_eq->Visible) { // Acabado_eq ?>
			<td><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos_det->Acabado_eq->FldCaption() ?></td></tr></table></td>
<?php } ?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$cap_inventario_equipos_det_preview->RecCount = 0;
while ($cap_inventario_equipos_det_preview->Recordset && !$cap_inventario_equipos_det_preview->Recordset->EOF) {

	// Init row class and style
	$cap_inventario_equipos_det_preview->RecCount++;
	$cap_inventario_equipos_det->CssClass = "";
	$cap_inventario_equipos_det->CssStyle = "";
	$cap_inventario_equipos_det->LoadListRowValues($cap_inventario_equipos_det_preview->Recordset);

	// Render row
	$cap_inventario_equipos_det->RowType = EW_ROWTYPE_PREVIEW; // Preview record
	$cap_inventario_equipos_det->RenderListRow();
?>
	<tr<?php echo $cap_inventario_equipos_det->RowAttributes() ?>>
<?php if ($cap_inventario_equipos_det->Num_IMEI->Visible) { // Num_IMEI ?>
		<!-- Num_IMEI -->
		<td<?php echo $cap_inventario_equipos_det->Num_IMEI->CellAttributes() ?>>
<span<?php echo $cap_inventario_equipos_det->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos_det->Num_IMEI->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($cap_inventario_equipos_det->Articulo->Visible) { // Articulo ?>
		<!-- Articulo -->
		<td<?php echo $cap_inventario_equipos_det->Articulo->CellAttributes() ?>>
<span<?php echo $cap_inventario_equipos_det->Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos_det->Articulo->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($cap_inventario_equipos_det->Acabado_eq->Visible) { // Acabado_eq ?>
		<!-- Acabado_eq -->
		<td<?php echo $cap_inventario_equipos_det->Acabado_eq->CellAttributes() ?>>
<span<?php echo $cap_inventario_equipos_det->Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos_det->Acabado_eq->ListViewValue() ?></span>
</td>
<?php } ?>
	</tr>
<?php
	$cap_inventario_equipos_det_preview->Recordset->MoveNext();
}
?>
	</tbody>
</table>
</div>
</td></tr></table>
<?php
$cap_inventario_equipos_det_preview->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
if ($cap_inventario_equipos_det_preview->Recordset)
	$cap_inventario_equipos_det_preview->Recordset->Close();
}
$content = ob_get_contents();
ob_end_clean();
echo ew_ConvertToUtf8($content);
?>
<?php
$cap_inventario_equipos_det_preview->Page_Terminate();
?>
