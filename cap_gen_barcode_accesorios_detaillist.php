<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_gen_barcode_accesorios_detailinfo.php" ?>
<?php include_once "cap_gen_barcode_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_gen_barcode_accesorios_detail_list = NULL; // Initialize page object first

class ccap_gen_barcode_accesorios_detail_list extends ccap_gen_barcode_accesorios_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_gen_barcode_accesorios_detail';

	// Page object name
	var $PageObjName = 'cap_gen_barcode_accesorios_detail_list';

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

		// Table object (cap_gen_barcode_accesorios_detail)
		if (!isset($GLOBALS["cap_gen_barcode_accesorios_detail"])) {
			$GLOBALS["cap_gen_barcode_accesorios_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_gen_barcode_accesorios_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_gen_barcode_accesorios_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_gen_barcode_accesorios_detaildelete.php";
		$this->MultiUpdateUrl = "cap_gen_barcode_accesorios_detailupdate.php";

		// Table object (cap_gen_barcode_accesorios)
		if (!isset($GLOBALS['cap_gen_barcode_accesorios'])) $GLOBALS['cap_gen_barcode_accesorios'] = new ccap_gen_barcode_accesorios();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_gen_barcode_accesorios_detail', TRUE);

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

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_gen_barcode_accesorios") {
			global $cap_gen_barcode_accesorios;
			$rsmaster = $cap_gen_barcode_accesorios->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cap_gen_barcode_accesorioslist.php"); // Return to master page
			} else {
				$cap_gen_barcode_accesorios->LoadListRowValues($rsmaster);
				$cap_gen_barcode_accesorios->RowType = EW_ROWTYPE_MASTER; // Master row
				$cap_gen_barcode_accesorios->RenderListRow();
				$rsmaster->Close();
			}
		}

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
			$this->Id_Compra_Det->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Compra_Det->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Articulo, $bCtrl); // Articulo
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->CantRecibida, $bCtrl); // CantRecibida
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Id_Compra->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->CantRecibida->setSort("");
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
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->CantRecibida->setDbValue($rs->fields('CantRecibida'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Compra_Det")) <> "")
			$this->Id_Compra_Det->CurrentValue = $this->getKey("Id_Compra_Det"); // Id_Compra_Det
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
		// Id_Compra

		$this->Id_Compra->CellCssStyle = "white-space: nowrap;";

		// Id_Compra_Det
		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Articulo
		// Codigo
		// CantRecibida

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// CantRecibida
			$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
			$this->CantRecibida->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// CantRecibida
			$this->CantRecibida->LinkCustomAttributes = "";
			$this->CantRecibida->HrefValue = "";
			$this->CantRecibida->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_cap_gen_barcode_accesorios_detail\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_gen_barcode_accesorios_detail',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_gen_barcode_accesorios_detaillist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_gen_barcode_accesorios") {
			global $cap_gen_barcode_accesorios;
			$rsmaster = $cap_gen_barcode_accesorios->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cap_gen_barcode_accesorios->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cap_gen_barcode_accesorios") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Compra"] <> "") {
					$GLOBALS["cap_gen_barcode_accesorios"]->Id_Compra->setQueryStringValue($_GET["Id_Compra"]);
					$this->Id_Compra->setQueryStringValue($GLOBALS["cap_gen_barcode_accesorios"]->Id_Compra->QueryStringValue);
					$this->Id_Compra->setSessionValue($this->Id_Compra->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_gen_barcode_accesorios"]->Id_Compra->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cap_gen_barcode_accesorios") {
				if ($this->Id_Compra->QueryStringValue == "") $this->Id_Compra->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
if (!isset($cap_gen_barcode_accesorios_detail_list)) $cap_gen_barcode_accesorios_detail_list = new ccap_gen_barcode_accesorios_detail_list();

// Page init
$cap_gen_barcode_accesorios_detail_list->Page_Init();

// Page main
$cap_gen_barcode_accesorios_detail_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_gen_barcode_accesorios_detail_list = new ew_Page("cap_gen_barcode_accesorios_detail_list");
cap_gen_barcode_accesorios_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_gen_barcode_accesorios_detail_list.PageID; // For backward compatibility

// Form object
var fcap_gen_barcode_accesorios_detaillist = new ew_Form("fcap_gen_barcode_accesorios_detaillist");

// Form_CustomValidate event
fcap_gen_barcode_accesorios_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_gen_barcode_accesorios_detaillist.ValidateRequired = true;
<?php } else { ?>
fcap_gen_barcode_accesorios_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php if (($cap_gen_barcode_accesorios_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $cap_gen_barcode_accesorios_detail->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cap_gen_barcode_accesorioslist.php";
if ($cap_gen_barcode_accesorios_detail_list->DbMasterFilter <> "" && $cap_gen_barcode_accesorios_detail->getCurrentMasterTable() == "cap_gen_barcode_accesorios") {
	if ($cap_gen_barcode_accesorios_detail_list->MasterRecordExists) {
		if ($cap_gen_barcode_accesorios_detail->getCurrentMasterTable() == $cap_gen_barcode_accesorios_detail->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p><span class="ewTitle ewMasterTableTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $cap_gen_barcode_accesorios->TableCaption() ?>&nbsp;&nbsp;</span><?php $cap_gen_barcode_accesorios_detail_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterRecordPage") ?></a></p>
<?php } ?>
<?php include_once "cap_gen_barcode_accesoriosmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_gen_barcode_accesorios_detail_list->TotalRecs = $cap_gen_barcode_accesorios_detail->SelectRecordCount();
	} else {
		if ($cap_gen_barcode_accesorios_detail_list->Recordset = $cap_gen_barcode_accesorios_detail_list->LoadRecordset())
			$cap_gen_barcode_accesorios_detail_list->TotalRecs = $cap_gen_barcode_accesorios_detail_list->Recordset->RecordCount();
	}
	$cap_gen_barcode_accesorios_detail_list->StartRec = 1;
	if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs <= 0 || ($cap_gen_barcode_accesorios_detail->Export <> "" && $cap_gen_barcode_accesorios_detail->ExportAll)) // Display all records
		$cap_gen_barcode_accesorios_detail_list->DisplayRecs = $cap_gen_barcode_accesorios_detail_list->TotalRecs;
	if (!($cap_gen_barcode_accesorios_detail->Export <> "" && $cap_gen_barcode_accesorios_detail->ExportAll))
		$cap_gen_barcode_accesorios_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_gen_barcode_accesorios_detail_list->Recordset = $cap_gen_barcode_accesorios_detail_list->LoadRecordset($cap_gen_barcode_accesorios_detail_list->StartRec-1, $cap_gen_barcode_accesorios_detail_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_gen_barcode_accesorios_detail->TableCaption() ?>&nbsp;&nbsp;</span>
<?php if ($cap_gen_barcode_accesorios_detail->getCurrentMasterTable() == "") { ?>
<?php $cap_gen_barcode_accesorios_detail_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php $cap_gen_barcode_accesorios_detail_list->ShowPageHeader(); ?>
<?php
$cap_gen_barcode_accesorios_detail_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "gridadd" && $cap_gen_barcode_accesorios_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_gen_barcode_accesorios_detail_list->Pager)) $cap_gen_barcode_accesorios_detail_list->Pager = new cNumericPager($cap_gen_barcode_accesorios_detail_list->StartRec, $cap_gen_barcode_accesorios_detail_list->DisplayRecs, $cap_gen_barcode_accesorios_detail_list->TotalRecs, $cap_gen_barcode_accesorios_detail_list->RecRange) ?>
<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_gen_barcode_accesorios_detail_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->SearchWhere == "0=101") { ?>
	<?php echo $Language->Phrase("EnterSearchCriteria") ?>
	<?php } else { ?>
	<?php echo $Language->Phrase("NoRecord") ?>
	<?php } ?>
	<?php } else { ?>
	<?php echo $Language->Phrase("NoPermission") ?>
	<?php } ?>
<?php } ?>
</span>
	</td>
<?php if ($cap_gen_barcode_accesorios_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_gen_barcode_accesorios_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
</span>
</div>
<?php } ?>
<form name="fcap_gen_barcode_accesorios_detaillist" id="fcap_gen_barcode_accesorios_detaillist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_gen_barcode_accesorios_detail">
<div id="gmp_cap_gen_barcode_accesorios_detail" class="ewGridMiddlePanel">
<?php if ($cap_gen_barcode_accesorios_detail_list->TotalRecs > 0) { ?>
<table id="tbl_cap_gen_barcode_accesorios_detaillist" class="ewTable ewTableSeparate">
<?php echo $cap_gen_barcode_accesorios_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_gen_barcode_accesorios_detail_list->RenderListOptions();

// Render list options (header, left)
$cap_gen_barcode_accesorios_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_gen_barcode_accesorios_detail->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Articulo) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Articulo) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios_detail->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Codigo) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Codigo) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->Visible) { // CantRecibida ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->CantRecibida) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->CantRecibida) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->CantRecibida->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_gen_barcode_accesorios_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_gen_barcode_accesorios_detail->ExportAll && $cap_gen_barcode_accesorios_detail->Export <> "") {
	$cap_gen_barcode_accesorios_detail_list->StopRec = $cap_gen_barcode_accesorios_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_gen_barcode_accesorios_detail_list->TotalRecs > $cap_gen_barcode_accesorios_detail_list->StartRec + $cap_gen_barcode_accesorios_detail_list->DisplayRecs - 1)
		$cap_gen_barcode_accesorios_detail_list->StopRec = $cap_gen_barcode_accesorios_detail_list->StartRec + $cap_gen_barcode_accesorios_detail_list->DisplayRecs - 1;
	else
		$cap_gen_barcode_accesorios_detail_list->StopRec = $cap_gen_barcode_accesorios_detail_list->TotalRecs;
}
$cap_gen_barcode_accesorios_detail_list->RecCnt = $cap_gen_barcode_accesorios_detail_list->StartRec - 1;
if ($cap_gen_barcode_accesorios_detail_list->Recordset && !$cap_gen_barcode_accesorios_detail_list->Recordset->EOF) {
	$cap_gen_barcode_accesorios_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_gen_barcode_accesorios_detail_list->StartRec > 1)
		$cap_gen_barcode_accesorios_detail_list->Recordset->Move($cap_gen_barcode_accesorios_detail_list->StartRec - 1);
} elseif (!$cap_gen_barcode_accesorios_detail->AllowAddDeleteRow && $cap_gen_barcode_accesorios_detail_list->StopRec == 0) {
	$cap_gen_barcode_accesorios_detail_list->StopRec = $cap_gen_barcode_accesorios_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_gen_barcode_accesorios_detail->ResetAttrs();
$cap_gen_barcode_accesorios_detail_list->RenderRow();
while ($cap_gen_barcode_accesorios_detail_list->RecCnt < $cap_gen_barcode_accesorios_detail_list->StopRec) {
	$cap_gen_barcode_accesorios_detail_list->RecCnt++;
	if (intval($cap_gen_barcode_accesorios_detail_list->RecCnt) >= intval($cap_gen_barcode_accesorios_detail_list->StartRec)) {
		$cap_gen_barcode_accesorios_detail_list->RowCnt++;

		// Set up key count
		$cap_gen_barcode_accesorios_detail_list->KeyCount = $cap_gen_barcode_accesorios_detail_list->RowIndex;

		// Init row class and style
		$cap_gen_barcode_accesorios_detail->ResetAttrs();
		$cap_gen_barcode_accesorios_detail->CssClass = "";
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd") {
		} else {
			$cap_gen_barcode_accesorios_detail_list->LoadRowValues($cap_gen_barcode_accesorios_detail_list->Recordset); // Load row values
		}
		$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_gen_barcode_accesorios_detail->RowAttrs = array_merge($cap_gen_barcode_accesorios_detail->RowAttrs, array('data-rowindex'=>$cap_gen_barcode_accesorios_detail_list->RowCnt, 'id'=>'r' . $cap_gen_barcode_accesorios_detail_list->RowCnt . '_cap_gen_barcode_accesorios_detail', 'data-rowtype'=>$cap_gen_barcode_accesorios_detail->RowType));

		// Render row
		$cap_gen_barcode_accesorios_detail_list->RenderRow();

		// Render list options
		$cap_gen_barcode_accesorios_detail_list->RenderListOptions();
?>
	<tr<?php echo $cap_gen_barcode_accesorios_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_gen_barcode_accesorios_detail_list->ListOptions->Render("body", "left", $cap_gen_barcode_accesorios_detail_list->RowCnt);
?>
	<?php if ($cap_gen_barcode_accesorios_detail->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_list->RowCnt ?>_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo">
<span<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_list->RowCnt ?>_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo">
<span<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_list->RowCnt ?>_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida">
<span<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_gen_barcode_accesorios_detail_list->ListOptions->Render("body", "right", $cap_gen_barcode_accesorios_detail_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "gridadd")
		$cap_gen_barcode_accesorios_detail_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_gen_barcode_accesorios_detail_list->Recordset)
	$cap_gen_barcode_accesorios_detail_list->Recordset->Close();
?>
<?php if ($cap_gen_barcode_accesorios_detail_list->TotalRecs > 0) { ?>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "gridadd" && $cap_gen_barcode_accesorios_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_gen_barcode_accesorios_detail_list->Pager)) $cap_gen_barcode_accesorios_detail_list->Pager = new cNumericPager($cap_gen_barcode_accesorios_detail_list->StartRec, $cap_gen_barcode_accesorios_detail_list->DisplayRecs, $cap_gen_barcode_accesorios_detail_list->TotalRecs, $cap_gen_barcode_accesorios_detail_list->RecRange) ?>
<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_gen_barcode_accesorios_detail_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_detail_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_detail_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_gen_barcode_accesorios_detail_list->SearchWhere == "0=101") { ?>
	<?php echo $Language->Phrase("EnterSearchCriteria") ?>
	<?php } else { ?>
	<?php echo $Language->Phrase("NoRecord") ?>
	<?php } ?>
	<?php } else { ?>
	<?php echo $Language->Phrase("NoPermission") ?>
	<?php } ?>
<?php } ?>
</span>
	</td>
<?php if ($cap_gen_barcode_accesorios_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_gen_barcode_accesorios_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_gen_barcode_accesorios_detail_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<script type="text/javascript">
fcap_gen_barcode_accesorios_detaillist.Init();
</script>
<?php } ?>
<?php
$cap_gen_barcode_accesorios_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_gen_barcode_accesorios_detail_list->Page_Terminate();
?>
