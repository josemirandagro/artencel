<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_gen_barcode_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_gen_barcode_accesorios_detailgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_gen_barcode_accesorios_list = NULL; // Initialize page object first

class ccap_gen_barcode_accesorios_list extends ccap_gen_barcode_accesorios {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_gen_barcode_accesorios';

	// Page object name
	var $PageObjName = 'cap_gen_barcode_accesorios_list';

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

		// Table object (cap_gen_barcode_accesorios)
		if (!isset($GLOBALS["cap_gen_barcode_accesorios"])) {
			$GLOBALS["cap_gen_barcode_accesorios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_gen_barcode_accesorios"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_gen_barcode_accesoriosadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_gen_barcode_accesoriosdelete.php";
		$this->MultiUpdateUrl = "cap_gen_barcode_accesoriosupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_gen_barcode_accesorios', TRUE);

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
		$this->Id_Compra->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall")
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search") {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

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
			$this->Id_Compra->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Compra->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Compra, FALSE); // Id_Compra
		$this->BuildSearchSql($sWhere, $this->Id_Proveedor, FALSE); // Id_Proveedor
		$this->BuildSearchSql($sWhere, $this->FechaEntrega, FALSE); // FechaEntrega
		$this->BuildSearchSql($sWhere, $this->Status_Recepcion, FALSE); // Status_Recepcion

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Compra->AdvancedSearch->Save(); // Id_Compra
			$this->Id_Proveedor->AdvancedSearch->Save(); // Id_Proveedor
			$this->FechaEntrega->AdvancedSearch->Save(); // FechaEntrega
			$this->Status_Recepcion->AdvancedSearch->Save(); // Status_Recepcion
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->Id_Compra->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Proveedor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaEntrega->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Status_Recepcion->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Id_Compra->AdvancedSearch->UnsetSession();
		$this->Id_Proveedor->AdvancedSearch->UnsetSession();
		$this->FechaEntrega->AdvancedSearch->UnsetSession();
		$this->Status_Recepcion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore advanced search values
		$this->Id_Compra->AdvancedSearch->Load();
		$this->Id_Proveedor->AdvancedSearch->Load();
		$this->FechaEntrega->AdvancedSearch->Load();
		$this->Status_Recepcion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Compra, $bCtrl); // Id_Compra
			$this->UpdateSort($this->Id_Proveedor, $bCtrl); // Id_Proveedor
			$this->UpdateSort($this->FechaEntrega, $bCtrl); // FechaEntrega
			$this->UpdateSort($this->Status_Recepcion, $bCtrl); // Status_Recepcion
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Id_Compra->setSort("");
				$this->Id_Proveedor->setSort("");
				$this->FechaEntrega->setSort("");
				$this->Status_Recepcion->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "detail_cap_gen_barcode_accesorios_detail"
		$item = &$this->ListOptions->Add("detail_cap_gen_barcode_accesorios_detail");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cap_gen_barcode_accesorios_detail');
		$item->OnLeft = TRUE;
		if (!isset($GLOBALS["cap_gen_barcode_accesorios_detail_grid"])) $GLOBALS["cap_gen_barcode_accesorios_detail_grid"] = new ccap_gen_barcode_accesorios_detail_grid;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "detail_cap_gen_barcode_accesorios_detail"
		$oListOpt = &$this->ListOptions->Items["detail_cap_gen_barcode_accesorios_detail"];
		if ($Security->AllowList(CurrentProjectID() . 'cap_gen_barcode_accesorios_detail')) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_gen_barcode_accesorios_detail", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"cap_gen_barcode_accesorios_detaillist.php?" . EW_TABLE_SHOW_MASTER . "=cap_gen_barcode_accesorios&Id_Compra=" . urlencode(strval($this->Id_Compra->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'cap_gen_barcode_accesorios_detail'))
				$links .= "<a class=\"ewRowLink\" href=\"" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=cap_gen_barcode_accesorios_detail") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
		$sSqlWrk = "`Id_Compra`=" . ew_AdjustSql($this->Id_Compra->CurrentValue) . "";
		$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
		$sSqlWrk = str_replace("'", "\'", $sSqlWrk);
		$oListOpt = &$this->ListOptions->Items["detail_cap_gen_barcode_accesorios_detail"];
		$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_gen_barcode_accesorios_detail", "TblCaption");
		$sHyperLinkParm = " href=\"cap_gen_barcode_accesorios_detaillist.php?" . EW_TABLE_SHOW_MASTER . "=cap_gen_barcode_accesorios&Id_Compra=" . urlencode(strval($this->Id_Compra->CurrentValue)) . "\" id=\"dl%i_cap_gen_barcode_accesorios_cap_gen_barcode_accesorios_detail\" onmouseover=\"ew_ShowDetails(this, 'cap_gen_barcode_accesorios_detailpreview.php?f=%s')\" onmouseout=\"ew_HideDetails();\"";
		$sHyperLinkParm = str_replace("%i", $this->RowCnt, $sHyperLinkParm);
		$sHyperLinkParm = str_replace("%s", $sSqlWrk, $sHyperLinkParm);
		$oListOpt->Body = "<a class=\"ewRowLink\"" . $sHyperLinkParm . ">" . $oListOpt->Body . "</a>";
		$links = "";
		if ($GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'cap_gen_barcode_accesorios_detail'))
			$links .= "<a class=\"ewRowLink\" href=\"" . $this->getEditUrl(EW_TABLE_SHOW_DETAIL . "=cap_gen_barcode_accesorios_detail") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;";
		if ($links <> "") $oListOpt->Body .= "<br>" . $links;
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

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Id_Compra

		$this->Id_Compra->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Compra"]);
		if ($this->Id_Compra->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Compra->AdvancedSearch->SearchOperator = @$_GET["z_Id_Compra"];

		// Id_Proveedor
		$this->Id_Proveedor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Proveedor"]);
		if ($this->Id_Proveedor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Proveedor->AdvancedSearch->SearchOperator = @$_GET["z_Id_Proveedor"];

		// FechaEntrega
		$this->FechaEntrega->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaEntrega"]);
		if ($this->FechaEntrega->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaEntrega->AdvancedSearch->SearchOperator = @$_GET["z_FechaEntrega"];

		// Status_Recepcion
		$this->Status_Recepcion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Status_Recepcion"]);
		if ($this->Status_Recepcion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Status_Recepcion->AdvancedSearch->SearchOperator = @$_GET["z_Status_Recepcion"];
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
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->FechaEntrega->setDbValue($rs->fields('FechaEntrega'));
		$this->Status_Recepcion->setDbValue($rs->fields('Status_Recepcion'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Compra")) <> "")
			$this->Id_Compra->CurrentValue = $this->getKey("Id_Compra"); // Id_Compra
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
		// Id_Proveedor
		// FechaEntrega
		// Status_Recepcion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Compra
			$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
			$this->Id_Compra->ViewCustomAttributes = "";

			// Id_Proveedor
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->ViewValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// FechaEntrega
			$this->FechaEntrega->ViewValue = $this->FechaEntrega->CurrentValue;
			$this->FechaEntrega->ViewValue = ew_FormatDateTime($this->FechaEntrega->ViewValue, 7);
			$this->FechaEntrega->ViewCustomAttributes = "";

			// Status_Recepcion
			if (strval($this->Status_Recepcion->CurrentValue) <> "") {
				switch ($this->Status_Recepcion->CurrentValue) {
					case $this->Status_Recepcion->FldTagValue(1):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(1) <> "" ? $this->Status_Recepcion->FldTagCaption(1) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(2):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(2) <> "" ? $this->Status_Recepcion->FldTagCaption(2) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(3):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(3) <> "" ? $this->Status_Recepcion->FldTagCaption(3) : $this->Status_Recepcion->CurrentValue;
						break;
					default:
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->CurrentValue;
				}
			} else {
				$this->Status_Recepcion->ViewValue = NULL;
			}
			$this->Status_Recepcion->ViewCustomAttributes = "";

			// Id_Compra
			$this->Id_Compra->LinkCustomAttributes = "";
			$this->Id_Compra->HrefValue = "";
			$this->Id_Compra->TooltipValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";

			// FechaEntrega
			$this->FechaEntrega->LinkCustomAttributes = "";
			$this->FechaEntrega->HrefValue = "";
			$this->FechaEntrega->TooltipValue = "";

			// Status_Recepcion
			$this->Status_Recepcion->LinkCustomAttributes = "";
			$this->Status_Recepcion->HrefValue = "";
			$this->Status_Recepcion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Compra
			$this->Id_Compra->EditCustomAttributes = "";
			$this->Id_Compra->EditValue = ew_HtmlEncode($this->Id_Compra->AdvancedSearch->SearchValue);

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";

			// FechaEntrega
			$this->FechaEntrega->EditCustomAttributes = "";
			$this->FechaEntrega->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaEntrega->AdvancedSearch->SearchValue, 7), 7));

			// Status_Recepcion
			$this->Status_Recepcion->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status_Recepcion->FldTagValue(1), $this->Status_Recepcion->FldTagCaption(1) <> "" ? $this->Status_Recepcion->FldTagCaption(1) : $this->Status_Recepcion->FldTagValue(1));
			$arwrk[] = array($this->Status_Recepcion->FldTagValue(2), $this->Status_Recepcion->FldTagCaption(2) <> "" ? $this->Status_Recepcion->FldTagCaption(2) : $this->Status_Recepcion->FldTagValue(2));
			$arwrk[] = array($this->Status_Recepcion->FldTagValue(3), $this->Status_Recepcion->FldTagCaption(3) <> "" ? $this->Status_Recepcion->FldTagCaption(3) : $this->Status_Recepcion->FldTagValue(3));
			$this->Status_Recepcion->EditValue = $arwrk;
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Compra->AdvancedSearch->Load();
		$this->Id_Proveedor->AdvancedSearch->Load();
		$this->FechaEntrega->AdvancedSearch->Load();
		$this->Status_Recepcion->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_gen_barcode_accesorios\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_gen_barcode_accesorios',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_gen_barcode_accesorioslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_gen_barcode_accesorios_list)) $cap_gen_barcode_accesorios_list = new ccap_gen_barcode_accesorios_list();

// Page init
$cap_gen_barcode_accesorios_list->Page_Init();

// Page main
$cap_gen_barcode_accesorios_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_gen_barcode_accesorios->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_gen_barcode_accesorios_list = new ew_Page("cap_gen_barcode_accesorios_list");
cap_gen_barcode_accesorios_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_gen_barcode_accesorios_list.PageID; // For backward compatibility

// Form object
var fcap_gen_barcode_accesorioslist = new ew_Form("fcap_gen_barcode_accesorioslist");

// Form_CustomValidate event
fcap_gen_barcode_accesorioslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_gen_barcode_accesorioslist.ValidateRequired = true;
<?php } else { ?>
fcap_gen_barcode_accesorioslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_gen_barcode_accesorioslist.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":null,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_gen_barcode_accesorioslistsrch = new ew_Form("fcap_gen_barcode_accesorioslistsrch");

// Validate function for search
fcap_gen_barcode_accesorioslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";

	// Set up row object
	ew_ElementsToRow(fobj, infix);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fcap_gen_barcode_accesorioslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_gen_barcode_accesorioslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_gen_barcode_accesorioslistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<style>

/* styles for detail preview panel */
#ewDetailsDiv.yui-overlay { position:absolute;background:#fff;border:2px solid orange;padding:4px;margin:10px; }
#ewDetailsDiv.yui-overlay .hd { border:1px solid red;padding:5px; }
#ewDetailsDiv.yui-overlay .bd { border:0px solid green;padding:5px; }
#ewDetailsDiv.yui-overlay .ft { border:1px solid blue;padding:5px; }
</style>
<div id="ewDetailsDiv" style="visibility: hidden; z-index: 11000;"></div>
<script type="text/javascript">

// Details preview
var ewDetailsDiv, ewDetailsTimer = null;

// Init details div on window load
ewEvent.on(window, "load", function() {
	ewDetailsDiv = new ewWidget.Overlay("ewDetailsDiv", {context:null, visible:false});
	ewDetailsDiv.render();
});
var ewDetailsCallback = {
	cache: false,

	// Show results in details div
	success: function(o) {
		if (ewDetailsDiv && o.responseText) {
			ewDetailsDiv.cfg.applyConfig({context:o.argument, visible:false, constraintoviewport:true, preventcontextoverlap:true}, true);
			ewDetailsDiv.setBody(o.responseText);
			ewDetailsDiv.render();
			ew_SetupTable(ew_Select("#ewDetailsPreviewTable:first", ewDetailsDiv.body)[0]);
			ewDetailsDiv.show();
		}
	},	

	// Show error in details div
	failure: function(o) {
		if (ewDetailsDiv && o.responseText) {
			ewDetailsDiv.cfg.applyConfig({context:o.argument, visible:false, constraintoviewport:true, preventcontextoverlap:true}, true);
			ewDetailsDiv.setBody(o.responseText);
			ewDetailsDiv.render();
			ewDetailsDiv.show();
		}
	},
	argument: [null, "tl", "tr"]
}

// Show details div
function ew_ShowDetails(obj, url) {
	if (ewDetailsTimer)
		clearTimeout(ewDetailsTimer);
	ewDetailsCallback.argument[0] = obj;
	ewDetailsTimer = setTimeout(function() {ewConnect.asyncRequest('GET', url, ewDetailsCallback);}, 200);
}

// Hide details div
function ew_HideDetails() {
	if (ewDetailsTimer)
		clearTimeout(ewDetailsTimer);
	if (ewDetailsDiv)
		ewDetailsDiv.hide();
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_gen_barcode_accesorios_list->TotalRecs = $cap_gen_barcode_accesorios->SelectRecordCount();
	} else {
		if ($cap_gen_barcode_accesorios_list->Recordset = $cap_gen_barcode_accesorios_list->LoadRecordset())
			$cap_gen_barcode_accesorios_list->TotalRecs = $cap_gen_barcode_accesorios_list->Recordset->RecordCount();
	}
	$cap_gen_barcode_accesorios_list->StartRec = 1;
	if ($cap_gen_barcode_accesorios_list->DisplayRecs <= 0 || ($cap_gen_barcode_accesorios->Export <> "" && $cap_gen_barcode_accesorios->ExportAll)) // Display all records
		$cap_gen_barcode_accesorios_list->DisplayRecs = $cap_gen_barcode_accesorios_list->TotalRecs;
	if (!($cap_gen_barcode_accesorios->Export <> "" && $cap_gen_barcode_accesorios->ExportAll))
		$cap_gen_barcode_accesorios_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_gen_barcode_accesorios_list->Recordset = $cap_gen_barcode_accesorios_list->LoadRecordset($cap_gen_barcode_accesorios_list->StartRec-1, $cap_gen_barcode_accesorios_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_gen_barcode_accesorios->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_gen_barcode_accesorios_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_gen_barcode_accesorios->Export == "" && $cap_gen_barcode_accesorios->CurrentAction == "") { ?>
<form name="fcap_gen_barcode_accesorioslistsrch" id="fcap_gen_barcode_accesorioslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_gen_barcode_accesorioslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_gen_barcode_accesorioslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_gen_barcode_accesorioslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_gen_barcode_accesorios">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_gen_barcode_accesorios_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_gen_barcode_accesorios->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_gen_barcode_accesorios->ResetAttrs();
$cap_gen_barcode_accesorios_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_gen_barcode_accesorios->Status_Recepcion->Visible) { // Status_Recepcion ?>
	<span id="xsc_Status_Recepcion" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Status_Recepcion" id="z_Status_Recepcion" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Status_Recepcion" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Status_Recepcion" id="x_Status_Recepcion" value="{value}"<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->EditAttributes() ?>></div>
<div id="dsl_x_Status_Recepcion" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_gen_barcode_accesorios->Status_Recepcion->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_gen_barcode_accesorios->Status_Recepcion->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Status_Recepcion" id="x_Status_Recepcion" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_gen_barcode_accesorios_list->ShowPageHeader(); ?>
<?php
$cap_gen_barcode_accesorios_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_gen_barcode_accesorios->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_gen_barcode_accesorios->CurrentAction <> "gridadd" && $cap_gen_barcode_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_gen_barcode_accesorios_list->Pager)) $cap_gen_barcode_accesorios_list->Pager = new cNumericPager($cap_gen_barcode_accesorios_list->StartRec, $cap_gen_barcode_accesorios_list->DisplayRecs, $cap_gen_barcode_accesorios_list->TotalRecs, $cap_gen_barcode_accesorios_list->RecRange) ?>
<?php if ($cap_gen_barcode_accesorios_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_gen_barcode_accesorios_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_gen_barcode_accesorios_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_gen_barcode_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_gen_barcode_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<form name="fcap_gen_barcode_accesorioslist" id="fcap_gen_barcode_accesorioslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_gen_barcode_accesorios">
<div id="gmp_cap_gen_barcode_accesorios" class="ewGridMiddlePanel">
<?php if ($cap_gen_barcode_accesorios_list->TotalRecs > 0) { ?>
<table id="tbl_cap_gen_barcode_accesorioslist" class="ewTable ewTableSeparate">
<?php echo $cap_gen_barcode_accesorios->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_gen_barcode_accesorios_list->RenderListOptions();

// Render list options (header, left)
$cap_gen_barcode_accesorios_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_gen_barcode_accesorios->Id_Compra->Visible) { // Id_Compra ?>
	<?php if ($cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Id_Compra) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_Id_Compra" class="cap_gen_barcode_accesorios_Id_Compra"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Compra->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Id_Compra) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_Id_Compra" class="cap_gen_barcode_accesorios_Id_Compra">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios->Id_Compra->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios->Id_Compra->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios->Id_Compra->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<?php if ($cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Id_Proveedor) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_Id_Proveedor" class="cap_gen_barcode_accesorios_Id_Proveedor"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Proveedor->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Id_Proveedor) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_Id_Proveedor" class="cap_gen_barcode_accesorios_Id_Proveedor">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios->Id_Proveedor->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios->Id_Proveedor->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios->Id_Proveedor->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios->FechaEntrega->Visible) { // FechaEntrega ?>
	<?php if ($cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->FechaEntrega) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_FechaEntrega" class="cap_gen_barcode_accesorios_FechaEntrega"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios->FechaEntrega->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->FechaEntrega) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_FechaEntrega" class="cap_gen_barcode_accesorios_FechaEntrega">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios->FechaEntrega->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios->FechaEntrega->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios->FechaEntrega->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios->Status_Recepcion->Visible) { // Status_Recepcion ?>
	<?php if ($cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Status_Recepcion) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_Status_Recepcion" class="cap_gen_barcode_accesorios_Status_Recepcion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_gen_barcode_accesorios->SortUrl($cap_gen_barcode_accesorios->Status_Recepcion) ?>',2);"><span id="elh_cap_gen_barcode_accesorios_Status_Recepcion" class="cap_gen_barcode_accesorios_Status_Recepcion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios->Status_Recepcion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios->Status_Recepcion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_gen_barcode_accesorios_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_gen_barcode_accesorios->ExportAll && $cap_gen_barcode_accesorios->Export <> "") {
	$cap_gen_barcode_accesorios_list->StopRec = $cap_gen_barcode_accesorios_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_gen_barcode_accesorios_list->TotalRecs > $cap_gen_barcode_accesorios_list->StartRec + $cap_gen_barcode_accesorios_list->DisplayRecs - 1)
		$cap_gen_barcode_accesorios_list->StopRec = $cap_gen_barcode_accesorios_list->StartRec + $cap_gen_barcode_accesorios_list->DisplayRecs - 1;
	else
		$cap_gen_barcode_accesorios_list->StopRec = $cap_gen_barcode_accesorios_list->TotalRecs;
}
$cap_gen_barcode_accesorios_list->RecCnt = $cap_gen_barcode_accesorios_list->StartRec - 1;
if ($cap_gen_barcode_accesorios_list->Recordset && !$cap_gen_barcode_accesorios_list->Recordset->EOF) {
	$cap_gen_barcode_accesorios_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_gen_barcode_accesorios_list->StartRec > 1)
		$cap_gen_barcode_accesorios_list->Recordset->Move($cap_gen_barcode_accesorios_list->StartRec - 1);
} elseif (!$cap_gen_barcode_accesorios->AllowAddDeleteRow && $cap_gen_barcode_accesorios_list->StopRec == 0) {
	$cap_gen_barcode_accesorios_list->StopRec = $cap_gen_barcode_accesorios->GridAddRowCount;
}

// Initialize aggregate
$cap_gen_barcode_accesorios->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_gen_barcode_accesorios->ResetAttrs();
$cap_gen_barcode_accesorios_list->RenderRow();
while ($cap_gen_barcode_accesorios_list->RecCnt < $cap_gen_barcode_accesorios_list->StopRec) {
	$cap_gen_barcode_accesorios_list->RecCnt++;
	if (intval($cap_gen_barcode_accesorios_list->RecCnt) >= intval($cap_gen_barcode_accesorios_list->StartRec)) {
		$cap_gen_barcode_accesorios_list->RowCnt++;

		// Set up key count
		$cap_gen_barcode_accesorios_list->KeyCount = $cap_gen_barcode_accesorios_list->RowIndex;

		// Init row class and style
		$cap_gen_barcode_accesorios->ResetAttrs();
		$cap_gen_barcode_accesorios->CssClass = "";
		if ($cap_gen_barcode_accesorios->CurrentAction == "gridadd") {
		} else {
			$cap_gen_barcode_accesorios_list->LoadRowValues($cap_gen_barcode_accesorios_list->Recordset); // Load row values
		}
		$cap_gen_barcode_accesorios->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_gen_barcode_accesorios->RowAttrs = array_merge($cap_gen_barcode_accesorios->RowAttrs, array('data-rowindex'=>$cap_gen_barcode_accesorios_list->RowCnt, 'id'=>'r' . $cap_gen_barcode_accesorios_list->RowCnt . '_cap_gen_barcode_accesorios', 'data-rowtype'=>$cap_gen_barcode_accesorios->RowType));

		// Render row
		$cap_gen_barcode_accesorios_list->RenderRow();

		// Render list options
		$cap_gen_barcode_accesorios_list->RenderListOptions();
?>
	<tr<?php echo $cap_gen_barcode_accesorios->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_gen_barcode_accesorios_list->ListOptions->Render("body", "left", $cap_gen_barcode_accesorios_list->RowCnt);
?>
	<?php if ($cap_gen_barcode_accesorios->Id_Compra->Visible) { // Id_Compra ?>
		<td<?php echo $cap_gen_barcode_accesorios->Id_Compra->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_list->RowCnt ?>_cap_gen_barcode_accesorios_Id_Compra" class="cap_gen_barcode_accesorios_Id_Compra">
<span<?php echo $cap_gen_barcode_accesorios->Id_Compra->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Compra->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<td<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_list->RowCnt ?>_cap_gen_barcode_accesorios_Id_Proveedor" class="cap_gen_barcode_accesorios_Id_Proveedor">
<span<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios->FechaEntrega->Visible) { // FechaEntrega ?>
		<td<?php echo $cap_gen_barcode_accesorios->FechaEntrega->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_list->RowCnt ?>_cap_gen_barcode_accesorios_FechaEntrega" class="cap_gen_barcode_accesorios_FechaEntrega">
<span<?php echo $cap_gen_barcode_accesorios->FechaEntrega->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->FechaEntrega->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios->Status_Recepcion->Visible) { // Status_Recepcion ?>
		<td<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_list->RowCnt ?>_cap_gen_barcode_accesorios_Status_Recepcion" class="cap_gen_barcode_accesorios_Status_Recepcion">
<span<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->ListViewValue() ?></span>
</span><a id="<?php echo $cap_gen_barcode_accesorios_list->PageObjName . "_row_" . $cap_gen_barcode_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_gen_barcode_accesorios_list->ListOptions->Render("body", "right", $cap_gen_barcode_accesorios_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_gen_barcode_accesorios->CurrentAction <> "gridadd")
		$cap_gen_barcode_accesorios_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_gen_barcode_accesorios_list->Recordset)
	$cap_gen_barcode_accesorios_list->Recordset->Close();
?>
<?php if ($cap_gen_barcode_accesorios_list->TotalRecs > 0) { ?>
<?php if ($cap_gen_barcode_accesorios->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_gen_barcode_accesorios->CurrentAction <> "gridadd" && $cap_gen_barcode_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_gen_barcode_accesorios_list->Pager)) $cap_gen_barcode_accesorios_list->Pager = new cNumericPager($cap_gen_barcode_accesorios_list->StartRec, $cap_gen_barcode_accesorios_list->DisplayRecs, $cap_gen_barcode_accesorios_list->TotalRecs, $cap_gen_barcode_accesorios_list->RecRange) ?>
<?php if ($cap_gen_barcode_accesorios_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_gen_barcode_accesorios_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_gen_barcode_accesorios_list->PageUrl() ?>start=<?php echo $cap_gen_barcode_accesorios_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_gen_barcode_accesorios_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_gen_barcode_accesorios_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_gen_barcode_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_gen_barcode_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_gen_barcode_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<?php if ($cap_gen_barcode_accesorios->Export == "") { ?>
<script type="text/javascript">
fcap_gen_barcode_accesorioslistsrch.Init();
fcap_gen_barcode_accesorioslist.Init();
</script>
<?php } ?>
<?php
$cap_gen_barcode_accesorios_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_gen_barcode_accesorios->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_gen_barcode_accesorios_list->Page_Terminate();
?>
