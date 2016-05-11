<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_empleadosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_empleados_list = NULL; // Initialize page object first

class cca_empleados_list extends cca_empleados {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_empleados';

	// Page object name
	var $PageObjName = 'ca_empleados_list';

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

		// Table object (ca_empleados)
		if (!isset($GLOBALS["ca_empleados"])) {
			$GLOBALS["ca_empleados"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_empleados"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ca_empleadosadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ca_empleadosdelete.php";
		$this->MultiUpdateUrl = "ca_empleadosupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_empleados', TRUE);

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

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

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

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

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

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

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
			$this->IdEmpleado->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->IdEmpleado->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Status, FALSE); // Status
		$this->BuildSearchSql($sWhere, $this->DiaPago, FALSE); // DiaPago
		$this->BuildSearchSql($sWhere, $this->Poblacion, FALSE); // Poblacion
		$this->BuildSearchSql($sWhere, $this->FechaNacimiento, FALSE); // FechaNacimiento
		$this->BuildSearchSql($sWhere, $this->FechaIngreso, FALSE); // FechaIngreso
		$this->BuildSearchSql($sWhere, $this->RFC, FALSE); // RFC

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Status->AdvancedSearch->Save(); // Status
			$this->DiaPago->AdvancedSearch->Save(); // DiaPago
			$this->Poblacion->AdvancedSearch->Save(); // Poblacion
			$this->FechaNacimiento->AdvancedSearch->Save(); // FechaNacimiento
			$this->FechaIngreso->AdvancedSearch->Save(); // FechaIngreso
			$this->RFC->AdvancedSearch->Save(); // RFC
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

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Domicilio, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->_EMail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Celular, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Tel_Fijo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->MunicipioDel, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->CP, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Poblacion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->RFC, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->Status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->DiaPago->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Poblacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaNacimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaIngreso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->RFC->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Status->AdvancedSearch->UnsetSession();
		$this->DiaPago->AdvancedSearch->UnsetSession();
		$this->Poblacion->AdvancedSearch->UnsetSession();
		$this->FechaNacimiento->AdvancedSearch->UnsetSession();
		$this->FechaIngreso->AdvancedSearch->UnsetSession();
		$this->RFC->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Status->AdvancedSearch->Load();
		$this->DiaPago->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->FechaNacimiento->AdvancedSearch->Load();
		$this->FechaIngreso->AdvancedSearch->Load();
		$this->RFC->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Nombre, $bCtrl); // Nombre
			$this->UpdateSort($this->Domicilio, $bCtrl); // Domicilio
			$this->UpdateSort($this->_EMail, $bCtrl); // EMail
			$this->UpdateSort($this->Celular, $bCtrl); // Celular
			$this->UpdateSort($this->Id_Nivel, $bCtrl); // Id_Nivel
			$this->UpdateSort($this->Status, $bCtrl); // Status
			$this->UpdateSort($this->Poblacion, $bCtrl); // Poblacion
			$this->UpdateSort($this->FechaIngreso, $bCtrl); // FechaIngreso
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
				$this->Nombre->setSort("ASC");
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
				$this->Nombre->setSort("");
				$this->Domicilio->setSort("");
				$this->_EMail->setSort("");
				$this->Celular->setSort("");
				$this->Id_Nivel->setSort("");
				$this->Status->setSort("");
				$this->Poblacion->setSort("");
				$this->FechaIngreso->setSort("");
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Status

		$this->Status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Status"]);
		if ($this->Status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Status->AdvancedSearch->SearchOperator = @$_GET["z_Status"];

		// DiaPago
		$this->DiaPago->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_DiaPago"]);
		if ($this->DiaPago->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->DiaPago->AdvancedSearch->SearchOperator = @$_GET["z_DiaPago"];

		// Poblacion
		$this->Poblacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Poblacion"]);
		if ($this->Poblacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Poblacion->AdvancedSearch->SearchOperator = @$_GET["z_Poblacion"];

		// FechaNacimiento
		$this->FechaNacimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaNacimiento"]);
		if ($this->FechaNacimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaNacimiento->AdvancedSearch->SearchOperator = @$_GET["z_FechaNacimiento"];

		// FechaIngreso
		$this->FechaIngreso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaIngreso"]);
		if ($this->FechaIngreso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaIngreso->AdvancedSearch->SearchOperator = @$_GET["z_FechaIngreso"];

		// RFC
		$this->RFC->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_RFC"]);
		if ($this->RFC->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->RFC->AdvancedSearch->SearchOperator = @$_GET["z_RFC"];
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
		$this->IdEmpleado->setDbValue($rs->fields('IdEmpleado'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Tel_Fijo->setDbValue($rs->fields('Tel_Fijo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->IdUsuarioJefe->setDbValue($rs->fields('IdUsuarioJefe'));
		$this->MunicipioDel->setDbValue($rs->fields('MunicipioDel'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->DiaPago->setDbValue($rs->fields('DiaPago'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->FechaNacimiento->setDbValue($rs->fields('FechaNacimiento'));
		$this->FechaIngreso->setDbValue($rs->fields('FechaIngreso'));
		$this->RFC->setDbValue($rs->fields('RFC'));
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
		// IdEmpleado
		// Nombre
		// Domicilio
		// EMail
		// Celular
		// Tel_Fijo
		// Usuario

		$this->Usuario->CellCssStyle = "white-space: nowrap;";

		// Password
		$this->Password->CellCssStyle = "white-space: nowrap;";

		// Id_Nivel
		$this->Id_Nivel->CellCssStyle = "white-space: nowrap;";

		// IdUsuarioJefe
		$this->IdUsuarioJefe->CellCssStyle = "white-space: nowrap;";

		// MunicipioDel
		// CP
		// Status

		$this->Status->CellCssStyle = "white-space: nowrap;";

		// DiaPago
		// Poblacion
		// FechaNacimiento
		// FechaIngreso
		// RFC

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// IdEmpleado
			$this->IdEmpleado->ViewValue = $this->IdEmpleado->CurrentValue;
			$this->IdEmpleado->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
			$this->Nombre->ViewValue = strtoupper($this->Nombre->ViewValue);
			$this->Nombre->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewCustomAttributes = "";

			// EMail
			$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
			$this->_EMail->ViewCustomAttributes = "";

			// Celular
			$this->Celular->ViewValue = $this->Celular->CurrentValue;
			$this->Celular->ViewCustomAttributes = "";

			// Tel_Fijo
			$this->Tel_Fijo->ViewValue = $this->Tel_Fijo->CurrentValue;
			$this->Tel_Fijo->ViewCustomAttributes = "";

			// Id_Nivel
			if (strval($this->Id_Nivel->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_userlevels`";
			$sWhereWrk = "";
			$lookuptblfilter = "`userlevelid`>0";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `userlevelid`";
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

			// MunicipioDel
			$this->MunicipioDel->ViewValue = $this->MunicipioDel->CurrentValue;
			$this->MunicipioDel->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

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

			// DiaPago
			if (strval($this->DiaPago->CurrentValue) <> "") {
				switch ($this->DiaPago->CurrentValue) {
					case $this->DiaPago->FldTagValue(1):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(1) <> "" ? $this->DiaPago->FldTagCaption(1) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(2):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(2) <> "" ? $this->DiaPago->FldTagCaption(2) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(3):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(3) <> "" ? $this->DiaPago->FldTagCaption(3) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(4):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(4) <> "" ? $this->DiaPago->FldTagCaption(4) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(5):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(5) <> "" ? $this->DiaPago->FldTagCaption(5) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(6):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(6) <> "" ? $this->DiaPago->FldTagCaption(6) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(7):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(7) <> "" ? $this->DiaPago->FldTagCaption(7) : $this->DiaPago->CurrentValue;
						break;
					default:
						$this->DiaPago->ViewValue = $this->DiaPago->CurrentValue;
				}
			} else {
				$this->DiaPago->ViewValue = NULL;
			}
			$this->DiaPago->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewCustomAttributes = "";

			// FechaNacimiento
			$this->FechaNacimiento->ViewValue = $this->FechaNacimiento->CurrentValue;
			$this->FechaNacimiento->ViewValue = ew_FormatDateTime($this->FechaNacimiento->ViewValue, 7);
			$this->FechaNacimiento->ViewCustomAttributes = "";

			// FechaIngreso
			$this->FechaIngreso->ViewValue = $this->FechaIngreso->CurrentValue;
			$this->FechaIngreso->ViewValue = ew_FormatDateTime($this->FechaIngreso->ViewValue, 7);
			$this->FechaIngreso->ViewCustomAttributes = "";

			// RFC
			$this->RFC->ViewValue = $this->RFC->CurrentValue;
			$this->RFC->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// EMail
			$this->_EMail->LinkCustomAttributes = "";
			$this->_EMail->HrefValue = "";
			$this->_EMail->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// FechaIngreso
			$this->FechaIngreso->LinkCustomAttributes = "";
			$this->FechaIngreso->HrefValue = "";
			$this->FechaIngreso->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Nombre
			$this->Nombre->EditCustomAttributes = 'class="mayusculas"  onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre->EditValue = ew_HtmlEncode($this->Nombre->AdvancedSearch->SearchValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);

			// EMail
			$this->_EMail->EditCustomAttributes = "";
			$this->_EMail->EditValue = ew_HtmlEncode($this->_EMail->AdvancedSearch->SearchValue);

			// Celular
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->AdvancedSearch->SearchValue);

			// Id_Nivel
			$this->Id_Nivel->EditCustomAttributes = "";

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Poblacion
			$this->Poblacion->EditCustomAttributes = "";
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->AdvancedSearch->SearchValue);

			// FechaIngreso
			$this->FechaIngreso->EditCustomAttributes = "";
			$this->FechaIngreso->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaIngreso->AdvancedSearch->SearchValue, 7), 7));
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
		$this->Status->AdvancedSearch->Load();
		$this->DiaPago->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->FechaNacimiento->AdvancedSearch->Load();
		$this->FechaIngreso->AdvancedSearch->Load();
		$this->RFC->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_ca_empleados\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_ca_empleados',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fca_empleadoslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($ca_empleados_list)) $ca_empleados_list = new cca_empleados_list();

// Page init
$ca_empleados_list->Page_Init();

// Page main
$ca_empleados_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ca_empleados->Export == "") { ?>
<script type="text/javascript">

// Page object
var ca_empleados_list = new ew_Page("ca_empleados_list");
ca_empleados_list.PageID = "list"; // Page ID
var EW_PAGE_ID = ca_empleados_list.PageID; // For backward compatibility

// Form object
var fca_empleadoslist = new ew_Form("fca_empleadoslist");

// Form_CustomValidate event
fca_empleadoslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_empleadoslist.ValidateRequired = true;
<?php } else { ?>
fca_empleadoslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_empleadoslist.Lists["x_Id_Nivel"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fca_empleadoslistsrch = new ew_Form("fca_empleadoslistsrch");

// Validate function for search
fca_empleadoslistsrch.Validate = function(fobj) {
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
fca_empleadoslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_empleadoslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fca_empleadoslistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
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
		$ca_empleados_list->TotalRecs = $ca_empleados->SelectRecordCount();
	} else {
		if ($ca_empleados_list->Recordset = $ca_empleados_list->LoadRecordset())
			$ca_empleados_list->TotalRecs = $ca_empleados_list->Recordset->RecordCount();
	}
	$ca_empleados_list->StartRec = 1;
	if ($ca_empleados_list->DisplayRecs <= 0 || ($ca_empleados->Export <> "" && $ca_empleados->ExportAll)) // Display all records
		$ca_empleados_list->DisplayRecs = $ca_empleados_list->TotalRecs;
	if (!($ca_empleados->Export <> "" && $ca_empleados->ExportAll))
		$ca_empleados_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ca_empleados_list->Recordset = $ca_empleados_list->LoadRecordset($ca_empleados_list->StartRec-1, $ca_empleados_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_empleados->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $ca_empleados_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($ca_empleados->Export == "" && $ca_empleados->CurrentAction == "") { ?>
<form name="fca_empleadoslistsrch" id="fca_empleadoslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fca_empleadoslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fca_empleadoslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fca_empleadoslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ca_empleados">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$ca_empleados_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$ca_empleados->RowType = EW_ROWTYPE_SEARCH;

// Render row
$ca_empleados->ResetAttrs();
$ca_empleados_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($ca_empleados->Status->Visible) { // Status ?>
	<span id="xsc_Status" class="ewCell">
		<span class="ewSearchCaption"><?php echo $ca_empleados->Status->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Status" id="z_Status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Status" id="x_Status" value="{value}"<?php echo $ca_empleados->Status->EditAttributes() ?>></div>
<div id="dsl_x_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_empleados->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_empleados->Status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Status" id="x_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_empleados->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($ca_empleados_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_3" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($ca_empleados_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($ca_empleados_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($ca_empleados_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ca_empleados_list->ShowPageHeader(); ?>
<?php
$ca_empleados_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($ca_empleados->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($ca_empleados->CurrentAction <> "gridadd" && $ca_empleados->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_empleados_list->Pager)) $ca_empleados_list->Pager = new cNumericPager($ca_empleados_list->StartRec, $ca_empleados_list->DisplayRecs, $ca_empleados_list->TotalRecs, $ca_empleados_list->RecRange) ?>
<?php if ($ca_empleados_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_empleados_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_empleados_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_empleados_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_empleados_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_empleados_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_empleados_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_empleados_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_empleados">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_empleados_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_empleados_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_empleados_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_empleados_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_empleados_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_empleados_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_empleados_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fca_empleadoslist" id="fca_empleadoslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="ca_empleados">
<div id="gmp_ca_empleados" class="ewGridMiddlePanel">
<?php if ($ca_empleados_list->TotalRecs > 0) { ?>
<table id="tbl_ca_empleadoslist" class="ewTable ewTableSeparate">
<?php echo $ca_empleados->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ca_empleados_list->RenderListOptions();

// Render list options (header, left)
$ca_empleados_list->ListOptions->Render("header", "left");
?>
<?php if ($ca_empleados->Nombre->Visible) { // Nombre ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Nombre) == "") { ?>
		<td><span id="elh_ca_empleados_Nombre" class="ca_empleados_Nombre"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->Nombre->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Nombre) ?>',2);"><span id="elh_ca_empleados_Nombre" class="ca_empleados_Nombre">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->Domicilio->Visible) { // Domicilio ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Domicilio) == "") { ?>
		<td><span id="elh_ca_empleados_Domicilio" class="ca_empleados_Domicilio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->Domicilio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Domicilio) ?>',2);"><span id="elh_ca_empleados_Domicilio" class="ca_empleados_Domicilio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Domicilio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Domicilio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Domicilio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->_EMail->Visible) { // EMail ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->_EMail) == "") { ?>
		<td><span id="elh_ca_empleados__EMail" class="ca_empleados__EMail"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->_EMail->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->_EMail) ?>',2);"><span id="elh_ca_empleados__EMail" class="ca_empleados__EMail">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->_EMail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->_EMail->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->_EMail->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->Celular->Visible) { // Celular ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Celular) == "") { ?>
		<td><span id="elh_ca_empleados_Celular" class="ca_empleados_Celular"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->Celular->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Celular) ?>',2);"><span id="elh_ca_empleados_Celular" class="ca_empleados_Celular">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Celular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Celular->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Celular->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->Id_Nivel->Visible) { // Id_Nivel ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Id_Nivel) == "") { ?>
		<td><span id="elh_ca_empleados_Id_Nivel" class="ca_empleados_Id_Nivel"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $ca_empleados->Id_Nivel->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Id_Nivel) ?>',2);"><span id="elh_ca_empleados_Id_Nivel" class="ca_empleados_Id_Nivel">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Id_Nivel->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Id_Nivel->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Id_Nivel->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->Status->Visible) { // Status ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Status) == "") { ?>
		<td><span id="elh_ca_empleados_Status" class="ca_empleados_Status"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $ca_empleados->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Status) ?>',2);"><span id="elh_ca_empleados_Status" class="ca_empleados_Status">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->Poblacion->Visible) { // Poblacion ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->Poblacion) == "") { ?>
		<td><span id="elh_ca_empleados_Poblacion" class="ca_empleados_Poblacion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->Poblacion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->Poblacion) ?>',2);"><span id="elh_ca_empleados_Poblacion" class="ca_empleados_Poblacion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->Poblacion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->Poblacion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->Poblacion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_empleados->FechaIngreso->Visible) { // FechaIngreso ?>
	<?php if ($ca_empleados->SortUrl($ca_empleados->FechaIngreso) == "") { ?>
		<td><span id="elh_ca_empleados_FechaIngreso" class="ca_empleados_FechaIngreso"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_empleados->FechaIngreso->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_empleados->SortUrl($ca_empleados->FechaIngreso) ?>',2);"><span id="elh_ca_empleados_FechaIngreso" class="ca_empleados_FechaIngreso">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_empleados->FechaIngreso->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_empleados->FechaIngreso->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_empleados->FechaIngreso->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ca_empleados_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ca_empleados->ExportAll && $ca_empleados->Export <> "") {
	$ca_empleados_list->StopRec = $ca_empleados_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ca_empleados_list->TotalRecs > $ca_empleados_list->StartRec + $ca_empleados_list->DisplayRecs - 1)
		$ca_empleados_list->StopRec = $ca_empleados_list->StartRec + $ca_empleados_list->DisplayRecs - 1;
	else
		$ca_empleados_list->StopRec = $ca_empleados_list->TotalRecs;
}
$ca_empleados_list->RecCnt = $ca_empleados_list->StartRec - 1;
if ($ca_empleados_list->Recordset && !$ca_empleados_list->Recordset->EOF) {
	$ca_empleados_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ca_empleados_list->StartRec > 1)
		$ca_empleados_list->Recordset->Move($ca_empleados_list->StartRec - 1);
} elseif (!$ca_empleados->AllowAddDeleteRow && $ca_empleados_list->StopRec == 0) {
	$ca_empleados_list->StopRec = $ca_empleados->GridAddRowCount;
}

// Initialize aggregate
$ca_empleados->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ca_empleados->ResetAttrs();
$ca_empleados_list->RenderRow();
while ($ca_empleados_list->RecCnt < $ca_empleados_list->StopRec) {
	$ca_empleados_list->RecCnt++;
	if (intval($ca_empleados_list->RecCnt) >= intval($ca_empleados_list->StartRec)) {
		$ca_empleados_list->RowCnt++;

		// Set up key count
		$ca_empleados_list->KeyCount = $ca_empleados_list->RowIndex;

		// Init row class and style
		$ca_empleados->ResetAttrs();
		$ca_empleados->CssClass = "";
		if ($ca_empleados->CurrentAction == "gridadd") {
		} else {
			$ca_empleados_list->LoadRowValues($ca_empleados_list->Recordset); // Load row values
		}
		$ca_empleados->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ca_empleados->RowAttrs = array_merge($ca_empleados->RowAttrs, array('data-rowindex'=>$ca_empleados_list->RowCnt, 'id'=>'r' . $ca_empleados_list->RowCnt . '_ca_empleados', 'data-rowtype'=>$ca_empleados->RowType));

		// Render row
		$ca_empleados_list->RenderRow();

		// Render list options
		$ca_empleados_list->RenderListOptions();
?>
	<tr<?php echo $ca_empleados->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_empleados_list->ListOptions->Render("body", "left", $ca_empleados_list->RowCnt);
?>
	<?php if ($ca_empleados->Nombre->Visible) { // Nombre ?>
		<td<?php echo $ca_empleados->Nombre->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Nombre" class="ca_empleados_Nombre">
<span<?php echo $ca_empleados->Nombre->ViewAttributes() ?>>
<?php echo $ca_empleados->Nombre->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->Domicilio->Visible) { // Domicilio ?>
		<td<?php echo $ca_empleados->Domicilio->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Domicilio" class="ca_empleados_Domicilio">
<span<?php echo $ca_empleados->Domicilio->ViewAttributes() ?>>
<?php echo $ca_empleados->Domicilio->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->_EMail->Visible) { // EMail ?>
		<td<?php echo $ca_empleados->_EMail->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados__EMail" class="ca_empleados__EMail">
<span<?php echo $ca_empleados->_EMail->ViewAttributes() ?>>
<?php echo $ca_empleados->_EMail->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->Celular->Visible) { // Celular ?>
		<td<?php echo $ca_empleados->Celular->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Celular" class="ca_empleados_Celular">
<span<?php echo $ca_empleados->Celular->ViewAttributes() ?>>
<?php echo $ca_empleados->Celular->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->Id_Nivel->Visible) { // Id_Nivel ?>
		<td<?php echo $ca_empleados->Id_Nivel->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Id_Nivel" class="ca_empleados_Id_Nivel">
<span<?php echo $ca_empleados->Id_Nivel->ViewAttributes() ?>>
<?php echo $ca_empleados->Id_Nivel->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->Status->Visible) { // Status ?>
		<td<?php echo $ca_empleados->Status->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Status" class="ca_empleados_Status">
<span<?php echo $ca_empleados->Status->ViewAttributes() ?>>
<?php echo $ca_empleados->Status->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->Poblacion->Visible) { // Poblacion ?>
		<td<?php echo $ca_empleados->Poblacion->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_Poblacion" class="ca_empleados_Poblacion">
<span<?php echo $ca_empleados->Poblacion->ViewAttributes() ?>>
<?php echo $ca_empleados->Poblacion->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_empleados->FechaIngreso->Visible) { // FechaIngreso ?>
		<td<?php echo $ca_empleados->FechaIngreso->CellAttributes() ?>><span id="el<?php echo $ca_empleados_list->RowCnt ?>_ca_empleados_FechaIngreso" class="ca_empleados_FechaIngreso">
<span<?php echo $ca_empleados->FechaIngreso->ViewAttributes() ?>>
<?php echo $ca_empleados->FechaIngreso->ListViewValue() ?></span>
</span><a id="<?php echo $ca_empleados_list->PageObjName . "_row_" . $ca_empleados_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_empleados_list->ListOptions->Render("body", "right", $ca_empleados_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ca_empleados->CurrentAction <> "gridadd")
		$ca_empleados_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ca_empleados->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ca_empleados_list->Recordset)
	$ca_empleados_list->Recordset->Close();
?>
<?php if ($ca_empleados_list->TotalRecs > 0) { ?>
<?php if ($ca_empleados->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ca_empleados->CurrentAction <> "gridadd" && $ca_empleados->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_empleados_list->Pager)) $ca_empleados_list->Pager = new cNumericPager($ca_empleados_list->StartRec, $ca_empleados_list->DisplayRecs, $ca_empleados_list->TotalRecs, $ca_empleados_list->RecRange) ?>
<?php if ($ca_empleados_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_empleados_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_empleados_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_empleados_list->PageUrl() ?>start=<?php echo $ca_empleados_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_empleados_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_empleados_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_empleados_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_empleados_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_empleados_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_empleados_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_empleados">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_empleados_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_empleados_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_empleados_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_empleados_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_empleados_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_empleados_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_empleados_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($ca_empleados->Export == "") { ?>
<script type="text/javascript">
fca_empleadoslistsrch.Init();
fca_empleadoslist.Init();
</script>
<?php } ?>
<?php
$ca_empleados_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ca_empleados->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ca_empleados_list->Page_Terminate();
?>
