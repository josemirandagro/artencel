<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "aviso_tienda_no_establecidainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$aviso_tienda_no_establecida_list = NULL; // Initialize page object first

class caviso_tienda_no_establecida_list extends caviso_tienda_no_establecida {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'aviso_tienda_no_establecida';

	// Page object name
	var $PageObjName = 'aviso_tienda_no_establecida_list';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (aviso_tienda_no_establecida)
		if (!isset($GLOBALS["aviso_tienda_no_establecida"])) {
			$GLOBALS["aviso_tienda_no_establecida"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aviso_tienda_no_establecida"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "aviso_tienda_no_establecidaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "aviso_tienda_no_establecidadelete.php";
		$this->MultiUpdateUrl = "aviso_tienda_no_establecidaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'aviso_tienda_no_establecida', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->IdEmpleado->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->IdEmpleado->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Nombre); // Nombre
			$this->UpdateSort($this->Id_Nivel); // Id_Nivel
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Nombre->setSort("");
				$this->Id_Nivel->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->IdEmpleado->setDbValue($rs->fields('IdEmpleado'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IdEmpleado")) <> "")
			$this->IdEmpleado->CurrentValue = $this->getKey("IdEmpleado"); // IdEmpleado
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Nombre
		// Id_Nivel
		// Usuario
		// IdEmpleado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nombre
			$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
			$this->Nombre->ViewCustomAttributes = "";

			// Id_Nivel
			$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			if (strval($this->Id_Nivel->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Nivel->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
				}
			} else {
				$this->Id_Nivel->ViewValue = NULL;
			}
			$this->Id_Nivel->ViewCustomAttributes = "";

			// Usuario
			$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
			$this->Usuario->ViewCustomAttributes = "";

			// IdEmpleado
			$this->IdEmpleado->ViewValue = $this->IdEmpleado->CurrentValue;
			$this->IdEmpleado->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($aviso_tienda_no_establecida_list)) $aviso_tienda_no_establecida_list = new caviso_tienda_no_establecida_list();

// Page init
$aviso_tienda_no_establecida_list->Page_Init();

// Page main
$aviso_tienda_no_establecida_list->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var aviso_tienda_no_establecida_list = new ew_Page("aviso_tienda_no_establecida_list");
aviso_tienda_no_establecida_list.PageID = "list"; // Page ID
var EW_PAGE_ID = aviso_tienda_no_establecida_list.PageID; // For backward compatibility

// Form object
var faviso_tienda_no_establecidalist = new ew_Form("faviso_tienda_no_establecidalist");

// Form_CustomValidate event
faviso_tienda_no_establecidalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faviso_tienda_no_establecidalist.ValidateRequired = true;
<?php } else { ?>
faviso_tienda_no_establecidalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faviso_tienda_no_establecidalist.Lists["x_Id_Nivel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<div id="ewDetailsDiv" style="visibility: hidden; z-index: 11000;"></div>
<script type="text/javascript">

// Details preview
var ewDetailsDiv, ewDetailsTimer = null;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$aviso_tienda_no_establecida_list->TotalRecs = $aviso_tienda_no_establecida->SelectRecordCount();
	} else {
		if ($aviso_tienda_no_establecida_list->Recordset = $aviso_tienda_no_establecida_list->LoadRecordset())
			$aviso_tienda_no_establecida_list->TotalRecs = $aviso_tienda_no_establecida_list->Recordset->RecordCount();
	}
	$aviso_tienda_no_establecida_list->StartRec = 1;
	if ($aviso_tienda_no_establecida_list->DisplayRecs <= 0 || ($aviso_tienda_no_establecida->Export <> "" && $aviso_tienda_no_establecida->ExportAll)) // Display all records
		$aviso_tienda_no_establecida_list->DisplayRecs = $aviso_tienda_no_establecida_list->TotalRecs;
	if (!($aviso_tienda_no_establecida->Export <> "" && $aviso_tienda_no_establecida->ExportAll))
		$aviso_tienda_no_establecida_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$aviso_tienda_no_establecida_list->Recordset = $aviso_tienda_no_establecida_list->LoadRecordset($aviso_tienda_no_establecida_list->StartRec-1, $aviso_tienda_no_establecida_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $aviso_tienda_no_establecida->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $aviso_tienda_no_establecida_list->ExportOptions->Render("body"); ?>
</p>
<?php $aviso_tienda_no_establecida_list->ShowPageHeader(); ?>
<?php
$aviso_tienda_no_establecida_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="faviso_tienda_no_establecidalist" id="faviso_tienda_no_establecidalist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="aviso_tienda_no_establecida">
<div id="gmp_aviso_tienda_no_establecida" class="ewGridMiddlePanel">
<?php if ($aviso_tienda_no_establecida_list->TotalRecs > 0) { ?>
<table id="tbl_aviso_tienda_no_establecidalist" class="ewTable ewTableSeparate">
<?php echo $aviso_tienda_no_establecida->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$aviso_tienda_no_establecida_list->RenderListOptions();

// Render list options (header, left)
$aviso_tienda_no_establecida_list->ListOptions->Render("header", "left");
?>
<?php if ($aviso_tienda_no_establecida->Nombre->Visible) { // Nombre ?>
	<?php if ($aviso_tienda_no_establecida->SortUrl($aviso_tienda_no_establecida->Nombre) == "") { ?>
		<td><span id="elh_aviso_tienda_no_establecida_Nombre" class="aviso_tienda_no_establecida_Nombre"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aviso_tienda_no_establecida->Nombre->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aviso_tienda_no_establecida->SortUrl($aviso_tienda_no_establecida->Nombre) ?>',1);"><span id="elh_aviso_tienda_no_establecida_Nombre" class="aviso_tienda_no_establecida_Nombre">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aviso_tienda_no_establecida->Nombre->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aviso_tienda_no_establecida->Nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aviso_tienda_no_establecida->Nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aviso_tienda_no_establecida->Id_Nivel->Visible) { // Id_Nivel ?>
	<?php if ($aviso_tienda_no_establecida->SortUrl($aviso_tienda_no_establecida->Id_Nivel) == "") { ?>
		<td><span id="elh_aviso_tienda_no_establecida_Id_Nivel" class="aviso_tienda_no_establecida_Id_Nivel"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aviso_tienda_no_establecida->Id_Nivel->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aviso_tienda_no_establecida->SortUrl($aviso_tienda_no_establecida->Id_Nivel) ?>',1);"><span id="elh_aviso_tienda_no_establecida_Id_Nivel" class="aviso_tienda_no_establecida_Id_Nivel">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aviso_tienda_no_establecida->Id_Nivel->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aviso_tienda_no_establecida->Id_Nivel->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aviso_tienda_no_establecida->Id_Nivel->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$aviso_tienda_no_establecida_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($aviso_tienda_no_establecida->ExportAll && $aviso_tienda_no_establecida->Export <> "") {
	$aviso_tienda_no_establecida_list->StopRec = $aviso_tienda_no_establecida_list->TotalRecs;
} else {

	// Set the last record to display
	if ($aviso_tienda_no_establecida_list->TotalRecs > $aviso_tienda_no_establecida_list->StartRec + $aviso_tienda_no_establecida_list->DisplayRecs - 1)
		$aviso_tienda_no_establecida_list->StopRec = $aviso_tienda_no_establecida_list->StartRec + $aviso_tienda_no_establecida_list->DisplayRecs - 1;
	else
		$aviso_tienda_no_establecida_list->StopRec = $aviso_tienda_no_establecida_list->TotalRecs;
}
$aviso_tienda_no_establecida_list->RecCnt = $aviso_tienda_no_establecida_list->StartRec - 1;
if ($aviso_tienda_no_establecida_list->Recordset && !$aviso_tienda_no_establecida_list->Recordset->EOF) {
	$aviso_tienda_no_establecida_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $aviso_tienda_no_establecida_list->StartRec > 1)
		$aviso_tienda_no_establecida_list->Recordset->Move($aviso_tienda_no_establecida_list->StartRec - 1);
} elseif (!$aviso_tienda_no_establecida->AllowAddDeleteRow && $aviso_tienda_no_establecida_list->StopRec == 0) {
	$aviso_tienda_no_establecida_list->StopRec = $aviso_tienda_no_establecida->GridAddRowCount;
}

// Initialize aggregate
$aviso_tienda_no_establecida->RowType = EW_ROWTYPE_AGGREGATEINIT;
$aviso_tienda_no_establecida->ResetAttrs();
$aviso_tienda_no_establecida_list->RenderRow();
while ($aviso_tienda_no_establecida_list->RecCnt < $aviso_tienda_no_establecida_list->StopRec) {
	$aviso_tienda_no_establecida_list->RecCnt++;
	if (intval($aviso_tienda_no_establecida_list->RecCnt) >= intval($aviso_tienda_no_establecida_list->StartRec)) {
		$aviso_tienda_no_establecida_list->RowCnt++;

		// Set up key count
		$aviso_tienda_no_establecida_list->KeyCount = $aviso_tienda_no_establecida_list->RowIndex;

		// Init row class and style
		$aviso_tienda_no_establecida->ResetAttrs();
		$aviso_tienda_no_establecida->CssClass = "";
		if ($aviso_tienda_no_establecida->CurrentAction == "gridadd") {
		} else {
			$aviso_tienda_no_establecida_list->LoadRowValues($aviso_tienda_no_establecida_list->Recordset); // Load row values
		}
		$aviso_tienda_no_establecida->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$aviso_tienda_no_establecida->RowAttrs = array_merge($aviso_tienda_no_establecida->RowAttrs, array('data-rowindex'=>$aviso_tienda_no_establecida_list->RowCnt, 'id'=>'r' . $aviso_tienda_no_establecida_list->RowCnt . '_aviso_tienda_no_establecida', 'data-rowtype'=>$aviso_tienda_no_establecida->RowType));

		// Render row
		$aviso_tienda_no_establecida_list->RenderRow();

		// Render list options
		$aviso_tienda_no_establecida_list->RenderListOptions();
?>
	<tr<?php echo $aviso_tienda_no_establecida->RowAttributes() ?>>
<?php

// Render list options (body, left)
$aviso_tienda_no_establecida_list->ListOptions->Render("body", "left", $aviso_tienda_no_establecida_list->RowCnt);
?>
	<?php if ($aviso_tienda_no_establecida->Nombre->Visible) { // Nombre ?>
		<td<?php echo $aviso_tienda_no_establecida->Nombre->CellAttributes() ?>><span id="el<?php echo $aviso_tienda_no_establecida_list->RowCnt ?>_aviso_tienda_no_establecida_Nombre" class="aviso_tienda_no_establecida_Nombre">
<span<?php echo $aviso_tienda_no_establecida->Nombre->ViewAttributes() ?>>
<?php echo $aviso_tienda_no_establecida->Nombre->ListViewValue() ?></span>
</span><a id="<?php echo $aviso_tienda_no_establecida_list->PageObjName . "_row_" . $aviso_tienda_no_establecida_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aviso_tienda_no_establecida->Id_Nivel->Visible) { // Id_Nivel ?>
		<td<?php echo $aviso_tienda_no_establecida->Id_Nivel->CellAttributes() ?>><span id="el<?php echo $aviso_tienda_no_establecida_list->RowCnt ?>_aviso_tienda_no_establecida_Id_Nivel" class="aviso_tienda_no_establecida_Id_Nivel">
<span<?php echo $aviso_tienda_no_establecida->Id_Nivel->ViewAttributes() ?>>
<?php echo $aviso_tienda_no_establecida->Id_Nivel->ListViewValue() ?></span>
</span><a id="<?php echo $aviso_tienda_no_establecida_list->PageObjName . "_row_" . $aviso_tienda_no_establecida_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$aviso_tienda_no_establecida_list->ListOptions->Render("body", "right", $aviso_tienda_no_establecida_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($aviso_tienda_no_establecida->CurrentAction <> "gridadd")
		$aviso_tienda_no_establecida_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($aviso_tienda_no_establecida->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($aviso_tienda_no_establecida_list->Recordset)
	$aviso_tienda_no_establecida_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($aviso_tienda_no_establecida->CurrentAction <> "gridadd" && $aviso_tienda_no_establecida->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($aviso_tienda_no_establecida_list->Pager)) $aviso_tienda_no_establecida_list->Pager = new cPrevNextPager($aviso_tienda_no_establecida_list->StartRec, $aviso_tienda_no_establecida_list->DisplayRecs, $aviso_tienda_no_establecida_list->TotalRecs) ?>
<?php if ($aviso_tienda_no_establecida_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($aviso_tienda_no_establecida_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $aviso_tienda_no_establecida_list->PageUrl() ?>start=<?php echo $aviso_tienda_no_establecida_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($aviso_tienda_no_establecida_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $aviso_tienda_no_establecida_list->PageUrl() ?>start=<?php echo $aviso_tienda_no_establecida_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $aviso_tienda_no_establecida_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($aviso_tienda_no_establecida_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $aviso_tienda_no_establecida_list->PageUrl() ?>start=<?php echo $aviso_tienda_no_establecida_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($aviso_tienda_no_establecida_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $aviso_tienda_no_establecida_list->PageUrl() ?>start=<?php echo $aviso_tienda_no_establecida_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $aviso_tienda_no_establecida_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $aviso_tienda_no_establecida_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $aviso_tienda_no_establecida_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $aviso_tienda_no_establecida_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($aviso_tienda_no_establecida_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($aviso_tienda_no_establecida_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="aviso_tienda_no_establecida">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($aviso_tienda_no_establecida_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($aviso_tienda_no_establecida_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($aviso_tienda_no_establecida_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($aviso_tienda_no_establecida_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($aviso_tienda_no_establecida->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
</span>
</div>
</td></tr></table>
<script type="text/javascript">
faviso_tienda_no_establecidalist.Init();
</script>
<?php
$aviso_tienda_no_establecida_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$aviso_tienda_no_establecida_list->Page_Terminate();
?>
