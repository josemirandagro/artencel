<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "barcode_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$barcode_accesorio_list = NULL; // Initialize page object first

class cbarcode_accesorio_list extends cbarcode_accesorio {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'barcode_accesorio';

	// Page object name
	var $PageObjName = 'barcode_accesorio_list';

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

		// Table object (barcode_accesorio)
		if (!isset($GLOBALS["barcode_accesorio"])) {
			$GLOBALS["barcode_accesorio"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["barcode_accesorio"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "barcode_accesorioadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "barcode_accesoriodelete.php";
		$this->MultiUpdateUrl = "barcode_accesorioupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'barcode_accesorio', TRUE);

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

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->Id_Etiqueta->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($this->Export == "email")
				$this->Page_Terminate($this->ExportReturnUrl());
			else
				$this->Page_Terminate(); // Terminate response
			exit();
		}
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
			$this->Id_Etiqueta->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Etiqueta->FormValue))
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
			$this->UpdateSort($this->Id_Etiqueta); // Id_Etiqueta
			$this->UpdateSort($this->Id_Compra); // Id_Compra
			$this->UpdateSort($this->Articulo); // Articulo
			$this->UpdateSort($this->Codigo); // Codigo
			$this->UpdateSort($this->Status); // Status
			$this->UpdateSort($this->Articulo_L1); // Articulo_L1
			$this->UpdateSort($this->Articulo_L2); // Articulo_L2
			$this->UpdateSort($this->Articulo_L3); // Articulo_L3
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
				$this->Id_Etiqueta->setSort("");
				$this->Id_Compra->setSort("");
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->Status->setSort("");
				$this->Articulo_L1->setSort("");
				$this->Articulo_L2->setSort("");
				$this->Articulo_L3->setSort("");
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
		$this->Id_Etiqueta->setDbValue($rs->fields('Id_Etiqueta'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Articulo_L1->setDbValue($rs->fields('Articulo_L1'));
		$this->Articulo_L2->setDbValue($rs->fields('Articulo_L2'));
		$this->Articulo_L3->setDbValue($rs->fields('Articulo_L3'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Etiqueta")) <> "")
			$this->Id_Etiqueta->CurrentValue = $this->getKey("Id_Etiqueta"); // Id_Etiqueta
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
		// Id_Etiqueta
		// Id_Compra
		// Id_Compra_Det

		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Articulo
		// Codigo
		// Status
		// Articulo_L1
		// Articulo_L2
		// Articulo_L3

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Etiqueta
			$this->Id_Etiqueta->ViewValue = $this->Id_Etiqueta->CurrentValue;
			$this->Id_Etiqueta->ViewCustomAttributes = "";

			// Id_Compra
			$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
			$this->Id_Compra->ViewCustomAttributes = "";

			// Id_Compra_Det
			if (strval($this->Id_Compra_Det->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Etiqueta`" . ew_SearchString("=", $this->Id_Compra_Det->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT DISTINCT `Id_Etiqueta`, `Id_Etiqueta` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `barcode_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Compra_Det->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Compra_Det->ViewValue = $this->Id_Compra_Det->CurrentValue;
				}
			} else {
				$this->Id_Compra_Det->ViewValue = NULL;
			}
			$this->Id_Compra_Det->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->ViewValue = NULL;
			}
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// Articulo_L1
			$this->Articulo_L1->ViewValue = $this->Articulo_L1->CurrentValue;
			$this->Articulo_L1->ViewCustomAttributes = "";

			// Articulo_L2
			$this->Articulo_L2->ViewValue = $this->Articulo_L2->CurrentValue;
			$this->Articulo_L2->ViewCustomAttributes = "";

			// Articulo_L3
			$this->Articulo_L3->ViewValue = $this->Articulo_L3->CurrentValue;
			$this->Articulo_L3->ViewCustomAttributes = "";

			// Id_Etiqueta
			$this->Id_Etiqueta->LinkCustomAttributes = "";
			$this->Id_Etiqueta->HrefValue = "";
			$this->Id_Etiqueta->TooltipValue = "";

			// Id_Compra
			$this->Id_Compra->LinkCustomAttributes = "";
			$this->Id_Compra->HrefValue = "";
			$this->Id_Compra->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Articulo_L1
			$this->Articulo_L1->LinkCustomAttributes = "";
			$this->Articulo_L1->HrefValue = "";
			$this->Articulo_L1->TooltipValue = "";

			// Articulo_L2
			$this->Articulo_L2->LinkCustomAttributes = "";
			$this->Articulo_L2->HrefValue = "";
			$this->Articulo_L2->TooltipValue = "";

			// Articulo_L3
			$this->Articulo_L3->LinkCustomAttributes = "";
			$this->Articulo_L3->HrefValue = "";
			$this->Articulo_L3->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\">" . "<img src=\"phpimages/print.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendly")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendly")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\">" . "<img src=\"phpimages/exportxls.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcel")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcel")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\">" . "<img src=\"phpimages/exportdoc.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToWord")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWord")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\">" . "<img src=\"phpimages/exporthtml.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtml")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtml")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\">" . "<img src=\"phpimages/exportxml.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToXml")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXml")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\">" . "<img src=\"phpimages/exportcsv.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsv")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsv")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . "<img src=\"phpimages/exportpdf.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToPdf")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPdf")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_barcode_accesorio\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_barcode_accesorio',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fbarcode_accesoriolist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		$ExportDoc->Export();
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
if (!isset($barcode_accesorio_list)) $barcode_accesorio_list = new cbarcode_accesorio_list();

// Page init
$barcode_accesorio_list->Page_Init();

// Page main
$barcode_accesorio_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($barcode_accesorio->Export == "") { ?>
<script type="text/javascript">

// Page object
var barcode_accesorio_list = new ew_Page("barcode_accesorio_list");
barcode_accesorio_list.PageID = "list"; // Page ID
var EW_PAGE_ID = barcode_accesorio_list.PageID; // For backward compatibility

// Form object
var fbarcode_accesoriolist = new ew_Form("fbarcode_accesoriolist");

// Form_CustomValidate event
fbarcode_accesoriolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbarcode_accesoriolist.ValidateRequired = true;
<?php } else { ?>
fbarcode_accesoriolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbarcode_accesoriolist.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$barcode_accesorio_list->TotalRecs = $barcode_accesorio->SelectRecordCount();
	} else {
		if ($barcode_accesorio_list->Recordset = $barcode_accesorio_list->LoadRecordset())
			$barcode_accesorio_list->TotalRecs = $barcode_accesorio_list->Recordset->RecordCount();
	}
	$barcode_accesorio_list->StartRec = 1;
	if ($barcode_accesorio_list->DisplayRecs <= 0 || ($barcode_accesorio->Export <> "" && $barcode_accesorio->ExportAll)) // Display all records
		$barcode_accesorio_list->DisplayRecs = $barcode_accesorio_list->TotalRecs;
	if (!($barcode_accesorio->Export <> "" && $barcode_accesorio->ExportAll))
		$barcode_accesorio_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$barcode_accesorio_list->Recordset = $barcode_accesorio_list->LoadRecordset($barcode_accesorio_list->StartRec-1, $barcode_accesorio_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $barcode_accesorio->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $barcode_accesorio_list->ExportOptions->Render("body"); ?>
</p>
<?php $barcode_accesorio_list->ShowPageHeader(); ?>
<?php
$barcode_accesorio_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($barcode_accesorio->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($barcode_accesorio->CurrentAction <> "gridadd" && $barcode_accesorio->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($barcode_accesorio_list->Pager)) $barcode_accesorio_list->Pager = new cPrevNextPager($barcode_accesorio_list->StartRec, $barcode_accesorio_list->DisplayRecs, $barcode_accesorio_list->TotalRecs) ?>
<?php if ($barcode_accesorio_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($barcode_accesorio_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($barcode_accesorio_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $barcode_accesorio_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($barcode_accesorio_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($barcode_accesorio_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($barcode_accesorio_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($barcode_accesorio_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="barcode_accesorio">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($barcode_accesorio_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($barcode_accesorio_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($barcode_accesorio_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($barcode_accesorio_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($barcode_accesorio->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($barcode_accesorio_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $barcode_accesorio_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fbarcode_accesoriolist" id="fbarcode_accesoriolist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="barcode_accesorio">
<div id="gmp_barcode_accesorio" class="ewGridMiddlePanel">
<?php if ($barcode_accesorio_list->TotalRecs > 0) { ?>
<table id="tbl_barcode_accesoriolist" class="ewTable ewTableSeparate">
<?php echo $barcode_accesorio->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$barcode_accesorio_list->RenderListOptions();

// Render list options (header, left)
$barcode_accesorio_list->ListOptions->Render("header", "left");
?>
<?php if ($barcode_accesorio->Id_Etiqueta->Visible) { // Id_Etiqueta ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Id_Etiqueta) == "") { ?>
		<td><span id="elh_barcode_accesorio_Id_Etiqueta" class="barcode_accesorio_Id_Etiqueta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Id_Etiqueta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Id_Etiqueta) ?>',1);"><span id="elh_barcode_accesorio_Id_Etiqueta" class="barcode_accesorio_Id_Etiqueta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Id_Etiqueta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Id_Etiqueta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Id_Etiqueta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Id_Compra->Visible) { // Id_Compra ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Id_Compra) == "") { ?>
		<td><span id="elh_barcode_accesorio_Id_Compra" class="barcode_accesorio_Id_Compra"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Id_Compra->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Id_Compra) ?>',1);"><span id="elh_barcode_accesorio_Id_Compra" class="barcode_accesorio_Id_Compra">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Id_Compra->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Id_Compra->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Id_Compra->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Articulo->Visible) { // Articulo ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Articulo) == "") { ?>
		<td><span id="elh_barcode_accesorio_Articulo" class="barcode_accesorio_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Articulo) ?>',1);"><span id="elh_barcode_accesorio_Articulo" class="barcode_accesorio_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Codigo->Visible) { // Codigo ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Codigo) == "") { ?>
		<td><span id="elh_barcode_accesorio_Codigo" class="barcode_accesorio_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Codigo) ?>',1);"><span id="elh_barcode_accesorio_Codigo" class="barcode_accesorio_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Status->Visible) { // Status ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Status) == "") { ?>
		<td><span id="elh_barcode_accesorio_Status" class="barcode_accesorio_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Status) ?>',1);"><span id="elh_barcode_accesorio_Status" class="barcode_accesorio_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Articulo_L1->Visible) { // Articulo_L1 ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L1) == "") { ?>
		<td><span id="elh_barcode_accesorio_Articulo_L1" class="barcode_accesorio_Articulo_L1"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Articulo_L1->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L1) ?>',1);"><span id="elh_barcode_accesorio_Articulo_L1" class="barcode_accesorio_Articulo_L1">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Articulo_L1->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Articulo_L1->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Articulo_L1->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Articulo_L2->Visible) { // Articulo_L2 ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L2) == "") { ?>
		<td><span id="elh_barcode_accesorio_Articulo_L2" class="barcode_accesorio_Articulo_L2"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Articulo_L2->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L2) ?>',1);"><span id="elh_barcode_accesorio_Articulo_L2" class="barcode_accesorio_Articulo_L2">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Articulo_L2->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Articulo_L2->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Articulo_L2->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($barcode_accesorio->Articulo_L3->Visible) { // Articulo_L3 ?>
	<?php if ($barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L3) == "") { ?>
		<td><span id="elh_barcode_accesorio_Articulo_L3" class="barcode_accesorio_Articulo_L3"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $barcode_accesorio->Articulo_L3->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $barcode_accesorio->SortUrl($barcode_accesorio->Articulo_L3) ?>',1);"><span id="elh_barcode_accesorio_Articulo_L3" class="barcode_accesorio_Articulo_L3">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $barcode_accesorio->Articulo_L3->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($barcode_accesorio->Articulo_L3->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($barcode_accesorio->Articulo_L3->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$barcode_accesorio_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($barcode_accesorio->ExportAll && $barcode_accesorio->Export <> "") {
	$barcode_accesorio_list->StopRec = $barcode_accesorio_list->TotalRecs;
} else {

	// Set the last record to display
	if ($barcode_accesorio_list->TotalRecs > $barcode_accesorio_list->StartRec + $barcode_accesorio_list->DisplayRecs - 1)
		$barcode_accesorio_list->StopRec = $barcode_accesorio_list->StartRec + $barcode_accesorio_list->DisplayRecs - 1;
	else
		$barcode_accesorio_list->StopRec = $barcode_accesorio_list->TotalRecs;
}
$barcode_accesorio_list->RecCnt = $barcode_accesorio_list->StartRec - 1;
if ($barcode_accesorio_list->Recordset && !$barcode_accesorio_list->Recordset->EOF) {
	$barcode_accesorio_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $barcode_accesorio_list->StartRec > 1)
		$barcode_accesorio_list->Recordset->Move($barcode_accesorio_list->StartRec - 1);
} elseif (!$barcode_accesorio->AllowAddDeleteRow && $barcode_accesorio_list->StopRec == 0) {
	$barcode_accesorio_list->StopRec = $barcode_accesorio->GridAddRowCount;
}

// Initialize aggregate
$barcode_accesorio->RowType = EW_ROWTYPE_AGGREGATEINIT;
$barcode_accesorio->ResetAttrs();
$barcode_accesorio_list->RenderRow();
while ($barcode_accesorio_list->RecCnt < $barcode_accesorio_list->StopRec) {
	$barcode_accesorio_list->RecCnt++;
	if (intval($barcode_accesorio_list->RecCnt) >= intval($barcode_accesorio_list->StartRec)) {
		$barcode_accesorio_list->RowCnt++;

		// Set up key count
		$barcode_accesorio_list->KeyCount = $barcode_accesorio_list->RowIndex;

		// Init row class and style
		$barcode_accesorio->ResetAttrs();
		$barcode_accesorio->CssClass = "";
		if ($barcode_accesorio->CurrentAction == "gridadd") {
		} else {
			$barcode_accesorio_list->LoadRowValues($barcode_accesorio_list->Recordset); // Load row values
		}
		$barcode_accesorio->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$barcode_accesorio->RowAttrs = array_merge($barcode_accesorio->RowAttrs, array('data-rowindex'=>$barcode_accesorio_list->RowCnt, 'id'=>'r' . $barcode_accesorio_list->RowCnt . '_barcode_accesorio', 'data-rowtype'=>$barcode_accesorio->RowType));

		// Render row
		$barcode_accesorio_list->RenderRow();

		// Render list options
		$barcode_accesorio_list->RenderListOptions();
?>
	<tr<?php echo $barcode_accesorio->RowAttributes() ?>>
<?php

// Render list options (body, left)
$barcode_accesorio_list->ListOptions->Render("body", "left", $barcode_accesorio_list->RowCnt);
?>
	<?php if ($barcode_accesorio->Id_Etiqueta->Visible) { // Id_Etiqueta ?>
		<td<?php echo $barcode_accesorio->Id_Etiqueta->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Id_Etiqueta" class="barcode_accesorio_Id_Etiqueta">
<span<?php echo $barcode_accesorio->Id_Etiqueta->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Id_Etiqueta->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Id_Compra->Visible) { // Id_Compra ?>
		<td<?php echo $barcode_accesorio->Id_Compra->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Id_Compra" class="barcode_accesorio_Id_Compra">
<span<?php echo $barcode_accesorio->Id_Compra->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Id_Compra->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Articulo->Visible) { // Articulo ?>
		<td<?php echo $barcode_accesorio->Articulo->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Articulo" class="barcode_accesorio_Articulo">
<span<?php echo $barcode_accesorio->Articulo->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Codigo->Visible) { // Codigo ?>
		<td<?php echo $barcode_accesorio->Codigo->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Codigo" class="barcode_accesorio_Codigo">
<span<?php echo $barcode_accesorio->Codigo->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Codigo->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Status->Visible) { // Status ?>
		<td<?php echo $barcode_accesorio->Status->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Status" class="barcode_accesorio_Status">
<span<?php echo $barcode_accesorio->Status->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Status->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Articulo_L1->Visible) { // Articulo_L1 ?>
		<td<?php echo $barcode_accesorio->Articulo_L1->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Articulo_L1" class="barcode_accesorio_Articulo_L1">
<span<?php echo $barcode_accesorio->Articulo_L1->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Articulo_L1->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Articulo_L2->Visible) { // Articulo_L2 ?>
		<td<?php echo $barcode_accesorio->Articulo_L2->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Articulo_L2" class="barcode_accesorio_Articulo_L2">
<span<?php echo $barcode_accesorio->Articulo_L2->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Articulo_L2->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($barcode_accesorio->Articulo_L3->Visible) { // Articulo_L3 ?>
		<td<?php echo $barcode_accesorio->Articulo_L3->CellAttributes() ?>><span id="el<?php echo $barcode_accesorio_list->RowCnt ?>_barcode_accesorio_Articulo_L3" class="barcode_accesorio_Articulo_L3">
<span<?php echo $barcode_accesorio->Articulo_L3->ViewAttributes() ?>>
<?php echo $barcode_accesorio->Articulo_L3->ListViewValue() ?></span>
</span><a id="<?php echo $barcode_accesorio_list->PageObjName . "_row_" . $barcode_accesorio_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$barcode_accesorio_list->ListOptions->Render("body", "right", $barcode_accesorio_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($barcode_accesorio->CurrentAction <> "gridadd")
		$barcode_accesorio_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($barcode_accesorio->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($barcode_accesorio_list->Recordset)
	$barcode_accesorio_list->Recordset->Close();
?>
<?php if ($barcode_accesorio_list->TotalRecs > 0) { ?>
<?php if ($barcode_accesorio->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($barcode_accesorio->CurrentAction <> "gridadd" && $barcode_accesorio->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($barcode_accesorio_list->Pager)) $barcode_accesorio_list->Pager = new cPrevNextPager($barcode_accesorio_list->StartRec, $barcode_accesorio_list->DisplayRecs, $barcode_accesorio_list->TotalRecs) ?>
<?php if ($barcode_accesorio_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($barcode_accesorio_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($barcode_accesorio_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $barcode_accesorio_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($barcode_accesorio_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($barcode_accesorio_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $barcode_accesorio_list->PageUrl() ?>start=<?php echo $barcode_accesorio_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $barcode_accesorio_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($barcode_accesorio_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($barcode_accesorio_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="barcode_accesorio">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($barcode_accesorio_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($barcode_accesorio_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($barcode_accesorio_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($barcode_accesorio_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($barcode_accesorio->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($barcode_accesorio_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $barcode_accesorio_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($barcode_accesorio->Export == "") { ?>
<script type="text/javascript">
fbarcode_accesoriolist.Init();
</script>
<?php } ?>
<?php
$barcode_accesorio_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($barcode_accesorio->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$barcode_accesorio_list->Page_Terminate();
?>
