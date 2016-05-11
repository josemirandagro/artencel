<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_asigna_acabados_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_asigna_acabados_equipo_detailgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_asigna_acabados_equipo_list = NULL; // Initialize page object first

class ccap_asigna_acabados_equipo_list extends ccap_asigna_acabados_equipo {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_asigna_acabados_equipo';

	// Page object name
	var $PageObjName = 'cap_asigna_acabados_equipo_list';

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

		// Table object (cap_asigna_acabados_equipo)
		if (!isset($GLOBALS["cap_asigna_acabados_equipo"])) {
			$GLOBALS["cap_asigna_acabados_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_asigna_acabados_equipo"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_asigna_acabados_equipoadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_asigna_acabados_equipodelete.php";
		$this->MultiUpdateUrl = "cap_asigna_acabados_equipoupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_asigna_acabados_equipo', TRUE);

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
	var $cap_asigna_acabados_equipo_detail_Count;
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
			$this->Id_Articulo->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Articulo->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Articulo, FALSE); // Id_Articulo
		$this->BuildSearchSql($sWhere, $this->COD_Marca_eq, FALSE); // COD_Marca_eq
		$this->BuildSearchSql($sWhere, $this->Articulo, FALSE); // Articulo
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->COD_Marca_eq->AdvancedSearch->Save(); // COD_Marca_eq
			$this->Articulo->AdvancedSearch->Save(); // Articulo
			$this->Codigo->AdvancedSearch->Save(); // Codigo
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
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Marca_eq, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Articulo, $Keyword);
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
		if ($this->Id_Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Marca_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
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
		$this->Id_Articulo->AdvancedSearch->UnsetSession();
		$this->COD_Marca_eq->AdvancedSearch->UnsetSession();
		$this->Articulo->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->COD_Marca_eq); // COD_Marca_eq
			$this->UpdateSort($this->Articulo); // Articulo
			$this->UpdateSort($this->Codigo); // Codigo
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
				$this->Articulo->setSort("ASC");
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
				$this->COD_Marca_eq->setSort("");
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "detail_cap_asigna_acabados_equipo_detail"
		$item = &$this->ListOptions->Add("detail_cap_asigna_acabados_equipo_detail");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cap_asigna_acabados_equipo_detail');
		$item->OnLeft = TRUE;
		if (!isset($GLOBALS["cap_asigna_acabados_equipo_detail_grid"])) $GLOBALS["cap_asigna_acabados_equipo_detail_grid"] = new ccap_asigna_acabados_equipo_detail_grid;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "detail_cap_asigna_acabados_equipo_detail"
		$oListOpt = &$this->ListOptions->Items["detail_cap_asigna_acabados_equipo_detail"];
		if ($Security->AllowList(CurrentProjectID() . 'cap_asigna_acabados_equipo_detail')) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_asigna_acabados_equipo_detail", "TblCaption");
			$oListOpt->Body .= str_replace("%c", $this->cap_asigna_acabados_equipo_detail_Count, $Language->Phrase("DetailCount"));
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"cap_asigna_acabados_equipo_detaillist.php?" . EW_TABLE_SHOW_MASTER . "=cap_asigna_acabados_equipo&Id_Articulo=" . urlencode(strval($this->Id_Articulo->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
		$sSqlWrk = "`Id_Articulo`=" . ew_AdjustSql($this->Id_Articulo->CurrentValue) . "";
		$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
		$sSqlWrk = str_replace("'", "\'", $sSqlWrk);
		$oListOpt = &$this->ListOptions->Items["detail_cap_asigna_acabados_equipo_detail"];
		$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_asigna_acabados_equipo_detail", "TblCaption");
		$oListOpt->Body .= str_replace("%c", $this->cap_asigna_acabados_equipo_detail_Count, $Language->Phrase("DetailCount"));
		$sHyperLinkParm = " href=\"cap_asigna_acabados_equipo_detaillist.php?" . EW_TABLE_SHOW_MASTER . "=cap_asigna_acabados_equipo&Id_Articulo=" . urlencode(strval($this->Id_Articulo->CurrentValue)) . "\" id=\"dl%i_cap_asigna_acabados_equipo_cap_asigna_acabados_equipo_detail\" onmouseover=\"ew_ShowDetails(this, 'cap_asigna_acabados_equipo_detailpreview.php?f=%s')\" onmouseout=\"ew_HideDetails();\"";
		$sHyperLinkParm = str_replace("%i", $this->RowCnt, $sHyperLinkParm);
		$sHyperLinkParm = str_replace("%s", $sSqlWrk, $sHyperLinkParm);
		$oListOpt->Body = "<a class=\"ewRowLink\"" . $sHyperLinkParm . ">" . $oListOpt->Body . "</a>";
		$links = "";
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
		// Id_Articulo

		$this->Id_Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Articulo"]);
		if ($this->Id_Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Articulo"];

		// COD_Marca_eq
		$this->COD_Marca_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Marca_eq"]);
		if ($this->COD_Marca_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Marca_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Marca_eq"];

		// Articulo
		$this->Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Articulo"]);
		if ($this->Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Articulo"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];
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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		if (!isset($GLOBALS["cap_asigna_acabados_equipo_detail_grid"])) $GLOBALS["cap_asigna_acabados_equipo_detail_grid"] = new ccap_asigna_acabados_equipo_detail_grid;
		$sDetailFilter = $GLOBALS["cap_asigna_acabados_equipo_detail"]->SqlDetailFilter_cap_asigna_acabados_equipo();
		$sDetailFilter = str_replace("@Id_Articulo@", ew_AdjustSql($this->Id_Articulo->DbValue), $sDetailFilter);
		$GLOBALS["cap_asigna_acabados_equipo_detail"]->setCurrentMasterTable("cap_asigna_acabados_equipo");
		$sDetailFilter = $GLOBALS["cap_asigna_acabados_equipo_detail"]->ApplyUserIDFilters($sDetailFilter);
		$this->cap_asigna_acabados_equipo_detail_Count = $GLOBALS["cap_asigna_acabados_equipo_detail"]->LoadRecordCount($sDetailFilter);
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Articulo")) <> "")
			$this->Id_Articulo->CurrentValue = $this->getKey("Id_Articulo"); // Id_Articulo
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
		// Id_Articulo
		// COD_Marca_eq
		// Articulo
		// Codigo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// COD_Marca_eq
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->ViewValue = NULL;
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
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
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Codigo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Codigo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
				}
			} else {
				$this->Codigo->ViewValue = NULL;
			}
			$this->Codigo->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_eq->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->AdvancedSearch->SearchValue);
			if (strval($this->Articulo->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->AdvancedSearch->SearchValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->EditValue = $this->Articulo->AdvancedSearch->SearchValue;
				}
			} else {
				$this->Articulo->EditValue = NULL;
			}

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
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
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
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
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . "<img src=\"phpimages/exportpdf.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToPdf")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPdf")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_cap_asigna_acabados_equipo\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_asigna_acabados_equipo',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_asigna_acabados_equipolist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_asigna_acabados_equipo_list)) $cap_asigna_acabados_equipo_list = new ccap_asigna_acabados_equipo_list();

// Page init
$cap_asigna_acabados_equipo_list->Page_Init();

// Page main
$cap_asigna_acabados_equipo_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_asigna_acabados_equipo->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_asigna_acabados_equipo_list = new ew_Page("cap_asigna_acabados_equipo_list");
cap_asigna_acabados_equipo_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_asigna_acabados_equipo_list.PageID; // For backward compatibility

// Form object
var fcap_asigna_acabados_equipolist = new ew_Form("fcap_asigna_acabados_equipolist");

// Form_CustomValidate event
fcap_asigna_acabados_equipolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_asigna_acabados_equipolist.ValidateRequired = true;
<?php } else { ?>
fcap_asigna_acabados_equipolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_asigna_acabados_equipolist.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_asigna_acabados_equipolist.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_asigna_acabados_equipolist.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_asigna_acabados_equipolistsrch = new ew_Form("fcap_asigna_acabados_equipolistsrch");

// Validate function for search
fcap_asigna_acabados_equipolistsrch.Validate = function(fobj) {
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
fcap_asigna_acabados_equipolistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_asigna_acabados_equipolistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_asigna_acabados_equipolistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_asigna_acabados_equipolistsrch.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_asigna_acabados_equipolistsrch.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":["x_COD_Marca_eq"],"FilterFields":["x_COD_Marca_eq"],"Options":[]};
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
		$cap_asigna_acabados_equipo_list->TotalRecs = $cap_asigna_acabados_equipo->SelectRecordCount();
	} else {
		if ($cap_asigna_acabados_equipo_list->Recordset = $cap_asigna_acabados_equipo_list->LoadRecordset())
			$cap_asigna_acabados_equipo_list->TotalRecs = $cap_asigna_acabados_equipo_list->Recordset->RecordCount();
	}
	$cap_asigna_acabados_equipo_list->StartRec = 1;
	if ($cap_asigna_acabados_equipo_list->DisplayRecs <= 0 || ($cap_asigna_acabados_equipo->Export <> "" && $cap_asigna_acabados_equipo->ExportAll)) // Display all records
		$cap_asigna_acabados_equipo_list->DisplayRecs = $cap_asigna_acabados_equipo_list->TotalRecs;
	if (!($cap_asigna_acabados_equipo->Export <> "" && $cap_asigna_acabados_equipo->ExportAll))
		$cap_asigna_acabados_equipo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_asigna_acabados_equipo_list->Recordset = $cap_asigna_acabados_equipo_list->LoadRecordset($cap_asigna_acabados_equipo_list->StartRec-1, $cap_asigna_acabados_equipo_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_asigna_acabados_equipo->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_asigna_acabados_equipo_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_asigna_acabados_equipo->Export == "" && $cap_asigna_acabados_equipo->CurrentAction == "") { ?>
<form name="fcap_asigna_acabados_equipolistsrch" id="fcap_asigna_acabados_equipolistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_asigna_acabados_equipolistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_asigna_acabados_equipolistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_asigna_acabados_equipolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_asigna_acabados_equipo">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_asigna_acabados_equipo_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_asigna_acabados_equipo->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_asigna_acabados_equipo->ResetAttrs();
$cap_asigna_acabados_equipo_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_asigna_acabados_equipo->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<span id="xsc_COD_Marca_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Marca_eq" id="z_COD_Marca_eq" value="="></span>
		<span class="ewSearchField">
<?php $cap_asigna_acabados_equipo->COD_Marca_eq->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_Articulo']); " . @$cap_asigna_acabados_equipo->COD_Marca_eq->EditAttrs["onchange"]; ?>
<select id="x_COD_Marca_eq" name="x_COD_Marca_eq"<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo->COD_Marca_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipolistsrch.Lists["x_COD_Marca_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo->COD_Marca_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo->COD_Marca_eq->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_asigna_acabados_equipo->Articulo->Visible) { // Articulo ?>
	<span id="xsc_Articulo" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_asigna_acabados_equipo->Articulo->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Articulo" id="z_Articulo" value="LIKE"></span>
		<span class="ewSearchField">
<?php
	$wrkonchange = trim(" " . @$cap_asigna_acabados_equipo->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_asigna_acabados_equipo->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x_Articulo" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_Articulo" id="sv_x_Articulo" value="<?php echo $cap_asigna_acabados_equipo->Articulo->EditValue ?>" size="30" maxlength="100"<?php echo $cap_asigna_acabados_equipo->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_Articulo" style="display: inline; z-index: 8970"></div>
</span>
<input type="hidden" name="x_Articulo" id="x_Articulo" value="<?php echo $cap_asigna_acabados_equipo->Articulo->AdvancedSearch->SearchValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT DISTINCT `Articulo`, `Articulo` FROM `aux_sel_equipos`";
$sWhereWrk = "(`Articulo` LIKE '{query_value}%') AND ({filter})";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo`";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_Articulo" id="q_x_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_asigna_acabados_equipo->Articulo->LookupFn) ?>&f1=<?php echo TEAencrypt("`COD_Marca_eq` IN ({filter_value})"); ?>&t1=200">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_Articulo", fcap_asigna_acabados_equipolistsrch, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcap_asigna_acabados_equipolistsrch.AutoSuggests["x_Articulo"] = oas;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_asigna_acabados_equipo_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_asigna_acabados_equipo_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_asigna_acabados_equipo_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_asigna_acabados_equipo_list->ShowPageHeader(); ?>
<?php
$cap_asigna_acabados_equipo_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_asigna_acabados_equipo->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_asigna_acabados_equipo->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_asigna_acabados_equipo_list->Pager)) $cap_asigna_acabados_equipo_list->Pager = new cPrevNextPager($cap_asigna_acabados_equipo_list->StartRec, $cap_asigna_acabados_equipo_list->DisplayRecs, $cap_asigna_acabados_equipo_list->TotalRecs) ?>
<?php if ($cap_asigna_acabados_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_asigna_acabados_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_asigna_acabados_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_asigna_acabados_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_asigna_acabados_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_asigna_acabados_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<form name="fcap_asigna_acabados_equipolist" id="fcap_asigna_acabados_equipolist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_asigna_acabados_equipo">
<div id="gmp_cap_asigna_acabados_equipo" class="ewGridMiddlePanel">
<?php if ($cap_asigna_acabados_equipo_list->TotalRecs > 0) { ?>
<table id="tbl_cap_asigna_acabados_equipolist" class="ewTable ewTableSeparate">
<?php echo $cap_asigna_acabados_equipo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_asigna_acabados_equipo_list->RenderListOptions();

// Render list options (header, left)
$cap_asigna_acabados_equipo_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_asigna_acabados_equipo->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<?php if ($cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->COD_Marca_eq) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_COD_Marca_eq" class="cap_asigna_acabados_equipo_COD_Marca_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->COD_Marca_eq) ?>',1);"><span id="elh_cap_asigna_acabados_equipo_COD_Marca_eq" class="cap_asigna_acabados_equipo_COD_Marca_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo->COD_Marca_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo->COD_Marca_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_asigna_acabados_equipo->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->Articulo) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_Articulo" class="cap_asigna_acabados_equipo_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->Articulo) ?>',1);"><span id="elh_cap_asigna_acabados_equipo_Articulo" class="cap_asigna_acabados_equipo_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo->Articulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_asigna_acabados_equipo->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->Codigo) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_Codigo" class="cap_asigna_acabados_equipo_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_asigna_acabados_equipo->SortUrl($cap_asigna_acabados_equipo->Codigo) ?>',1);"><span id="elh_cap_asigna_acabados_equipo_Codigo" class="cap_asigna_acabados_equipo_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_asigna_acabados_equipo_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_asigna_acabados_equipo->ExportAll && $cap_asigna_acabados_equipo->Export <> "") {
	$cap_asigna_acabados_equipo_list->StopRec = $cap_asigna_acabados_equipo_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_asigna_acabados_equipo_list->TotalRecs > $cap_asigna_acabados_equipo_list->StartRec + $cap_asigna_acabados_equipo_list->DisplayRecs - 1)
		$cap_asigna_acabados_equipo_list->StopRec = $cap_asigna_acabados_equipo_list->StartRec + $cap_asigna_acabados_equipo_list->DisplayRecs - 1;
	else
		$cap_asigna_acabados_equipo_list->StopRec = $cap_asigna_acabados_equipo_list->TotalRecs;
}
$cap_asigna_acabados_equipo_list->RecCnt = $cap_asigna_acabados_equipo_list->StartRec - 1;
if ($cap_asigna_acabados_equipo_list->Recordset && !$cap_asigna_acabados_equipo_list->Recordset->EOF) {
	$cap_asigna_acabados_equipo_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_asigna_acabados_equipo_list->StartRec > 1)
		$cap_asigna_acabados_equipo_list->Recordset->Move($cap_asigna_acabados_equipo_list->StartRec - 1);
} elseif (!$cap_asigna_acabados_equipo->AllowAddDeleteRow && $cap_asigna_acabados_equipo_list->StopRec == 0) {
	$cap_asigna_acabados_equipo_list->StopRec = $cap_asigna_acabados_equipo->GridAddRowCount;
}

// Initialize aggregate
$cap_asigna_acabados_equipo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_asigna_acabados_equipo->ResetAttrs();
$cap_asigna_acabados_equipo_list->RenderRow();
while ($cap_asigna_acabados_equipo_list->RecCnt < $cap_asigna_acabados_equipo_list->StopRec) {
	$cap_asigna_acabados_equipo_list->RecCnt++;
	if (intval($cap_asigna_acabados_equipo_list->RecCnt) >= intval($cap_asigna_acabados_equipo_list->StartRec)) {
		$cap_asigna_acabados_equipo_list->RowCnt++;

		// Set up key count
		$cap_asigna_acabados_equipo_list->KeyCount = $cap_asigna_acabados_equipo_list->RowIndex;

		// Init row class and style
		$cap_asigna_acabados_equipo->ResetAttrs();
		$cap_asigna_acabados_equipo->CssClass = "";
		if ($cap_asigna_acabados_equipo->CurrentAction == "gridadd") {
		} else {
			$cap_asigna_acabados_equipo_list->LoadRowValues($cap_asigna_acabados_equipo_list->Recordset); // Load row values
		}
		$cap_asigna_acabados_equipo->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_asigna_acabados_equipo->RowAttrs = array_merge($cap_asigna_acabados_equipo->RowAttrs, array('data-rowindex'=>$cap_asigna_acabados_equipo_list->RowCnt, 'id'=>'r' . $cap_asigna_acabados_equipo_list->RowCnt . '_cap_asigna_acabados_equipo', 'data-rowtype'=>$cap_asigna_acabados_equipo->RowType));

		// Render row
		$cap_asigna_acabados_equipo_list->RenderRow();

		// Render list options
		$cap_asigna_acabados_equipo_list->RenderListOptions();
?>
	<tr<?php echo $cap_asigna_acabados_equipo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_asigna_acabados_equipo_list->ListOptions->Render("body", "left", $cap_asigna_acabados_equipo_list->RowCnt);
?>
	<?php if ($cap_asigna_acabados_equipo->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<td<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_list->RowCnt ?>_cap_asigna_acabados_equipo_COD_Marca_eq" class="cap_asigna_acabados_equipo_COD_Marca_eq">
<span<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_asigna_acabados_equipo_list->PageObjName . "_row_" . $cap_asigna_acabados_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_asigna_acabados_equipo->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_asigna_acabados_equipo->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_list->RowCnt ?>_cap_asigna_acabados_equipo_Articulo" class="cap_asigna_acabados_equipo_Articulo">
<span<?php echo $cap_asigna_acabados_equipo->Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_asigna_acabados_equipo_list->PageObjName . "_row_" . $cap_asigna_acabados_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_asigna_acabados_equipo->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_asigna_acabados_equipo->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_list->RowCnt ?>_cap_asigna_acabados_equipo_Codigo" class="cap_asigna_acabados_equipo_Codigo">
<span<?php echo $cap_asigna_acabados_equipo->Codigo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->Codigo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_asigna_acabados_equipo_list->PageObjName . "_row_" . $cap_asigna_acabados_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_asigna_acabados_equipo_list->ListOptions->Render("body", "right", $cap_asigna_acabados_equipo_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_asigna_acabados_equipo->CurrentAction <> "gridadd")
		$cap_asigna_acabados_equipo_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_asigna_acabados_equipo_list->Recordset)
	$cap_asigna_acabados_equipo_list->Recordset->Close();
?>
<?php if ($cap_asigna_acabados_equipo_list->TotalRecs > 0) { ?>
<?php if ($cap_asigna_acabados_equipo->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_asigna_acabados_equipo->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_asigna_acabados_equipo_list->Pager)) $cap_asigna_acabados_equipo_list->Pager = new cPrevNextPager($cap_asigna_acabados_equipo_list->StartRec, $cap_asigna_acabados_equipo_list->DisplayRecs, $cap_asigna_acabados_equipo_list->TotalRecs) ?>
<?php if ($cap_asigna_acabados_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_asigna_acabados_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_asigna_acabados_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_asigna_acabados_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_asigna_acabados_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_asigna_acabados_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_asigna_acabados_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_asigna_acabados_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<?php if ($cap_asigna_acabados_equipo->Export == "") { ?>
<script type="text/javascript">
fcap_asigna_acabados_equipolistsrch.Init();
fcap_asigna_acabados_equipolist.Init();
</script>
<?php } ?>
<?php
$cap_asigna_acabados_equipo_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_asigna_acabados_equipo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_asigna_acabados_equipo_list->Page_Terminate();
?>
