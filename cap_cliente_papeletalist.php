<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_cliente_papeletainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_cliente_papeleta_list = NULL; // Initialize page object first

class ccap_cliente_papeleta_list extends ccap_cliente_papeleta {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_cliente_papeleta';

	// Page object name
	var $PageObjName = 'cap_cliente_papeleta_list';

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

		// Table object (cap_cliente_papeleta)
		if (!isset($GLOBALS["cap_cliente_papeleta"])) {
			$GLOBALS["cap_cliente_papeleta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_cliente_papeleta"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_cliente_papeletaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_cliente_papeletadelete.php";
		$this->MultiUpdateUrl = "cap_cliente_papeletaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_cliente_papeleta', TRUE);

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
		$this->Id_Cliente->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Id_Cliente->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Cliente->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Cliente, FALSE); // Id_Cliente
		$this->BuildSearchSql($sWhere, $this->Domicilio, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Num_Exterior, FALSE); // Num_Exterior
		$this->BuildSearchSql($sWhere, $this->Num_Interior, FALSE); // Num_Interior
		$this->BuildSearchSql($sWhere, $this->Colonia, FALSE); // Colonia
		$this->BuildSearchSql($sWhere, $this->Poblacion, FALSE); // Poblacion
		$this->BuildSearchSql($sWhere, $this->CP, FALSE); // CP
		$this->BuildSearchSql($sWhere, $this->Id_Estado, FALSE); // Id_Estado
		$this->BuildSearchSql($sWhere, $this->Tel_Particular, FALSE); // Tel_Particular
		$this->BuildSearchSql($sWhere, $this->Tel_Oficina, FALSE); // Tel_Oficina
		$this->BuildSearchSql($sWhere, $this->Tipo_Identificacion, FALSE); // Tipo_Identificacion
		$this->BuildSearchSql($sWhere, $this->Numero_Identificacion, FALSE); // Numero_Identificacion

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Cliente->AdvancedSearch->Save(); // Id_Cliente
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Num_Exterior->AdvancedSearch->Save(); // Num_Exterior
			$this->Num_Interior->AdvancedSearch->Save(); // Num_Interior
			$this->Colonia->AdvancedSearch->Save(); // Colonia
			$this->Poblacion->AdvancedSearch->Save(); // Poblacion
			$this->CP->AdvancedSearch->Save(); // CP
			$this->Id_Estado->AdvancedSearch->Save(); // Id_Estado
			$this->Tel_Particular->AdvancedSearch->Save(); // Tel_Particular
			$this->Tel_Oficina->AdvancedSearch->Save(); // Tel_Oficina
			$this->Tipo_Identificacion->AdvancedSearch->Save(); // Tipo_Identificacion
			$this->Numero_Identificacion->AdvancedSearch->Save(); // Numero_Identificacion
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
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Completo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Domicilio, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_Exterior, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_Interior, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Colonia, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Poblacion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->CP, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Tel_Particular, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Tel_Oficina, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Numero_Identificacion, $Keyword);
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
		if ($this->Id_Cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_Exterior->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_Interior->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Colonia->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Poblacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->CP->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Particular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Oficina->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tipo_Identificacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Numero_Identificacion->AdvancedSearch->IssetSession())
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
		$this->Id_Cliente->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Num_Exterior->AdvancedSearch->UnsetSession();
		$this->Num_Interior->AdvancedSearch->UnsetSession();
		$this->Colonia->AdvancedSearch->UnsetSession();
		$this->Poblacion->AdvancedSearch->UnsetSession();
		$this->CP->AdvancedSearch->UnsetSession();
		$this->Id_Estado->AdvancedSearch->UnsetSession();
		$this->Tel_Particular->AdvancedSearch->UnsetSession();
		$this->Tel_Oficina->AdvancedSearch->UnsetSession();
		$this->Tipo_Identificacion->AdvancedSearch->UnsetSession();
		$this->Numero_Identificacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Num_Exterior->AdvancedSearch->Load();
		$this->Num_Interior->AdvancedSearch->Load();
		$this->Colonia->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->CP->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Tel_Particular->AdvancedSearch->Load();
		$this->Tel_Oficina->AdvancedSearch->Load();
		$this->Tipo_Identificacion->AdvancedSearch->Load();
		$this->Numero_Identificacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Cliente); // Id_Cliente
			$this->UpdateSort($this->Nombre_Completo); // Nombre_Completo
			$this->UpdateSort($this->Domicilio); // Domicilio
			$this->UpdateSort($this->Num_Exterior); // Num_Exterior
			$this->UpdateSort($this->Num_Interior); // Num_Interior
			$this->UpdateSort($this->Colonia); // Colonia
			$this->UpdateSort($this->Poblacion); // Poblacion
			$this->UpdateSort($this->CP); // CP
			$this->UpdateSort($this->Id_Estado); // Id_Estado
			$this->UpdateSort($this->Tel_Particular); // Tel_Particular
			$this->UpdateSort($this->Tel_Oficina); // Tel_Oficina
			$this->UpdateSort($this->Tipo_Identificacion); // Tipo_Identificacion
			$this->UpdateSort($this->Numero_Identificacion); // Numero_Identificacion
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
				$this->Id_Cliente->setSort("");
				$this->Nombre_Completo->setSort("");
				$this->Domicilio->setSort("");
				$this->Num_Exterior->setSort("");
				$this->Num_Interior->setSort("");
				$this->Colonia->setSort("");
				$this->Poblacion->setSort("");
				$this->CP->setSort("");
				$this->Id_Estado->setSort("");
				$this->Tel_Particular->setSort("");
				$this->Tel_Oficina->setSort("");
				$this->Tipo_Identificacion->setSort("");
				$this->Numero_Identificacion->setSort("");
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
		// Id_Cliente

		$this->Id_Cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cliente"]);
		if ($this->Id_Cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cliente->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cliente"];

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Domicilio"]);
		if ($this->Domicilio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Domicilio->AdvancedSearch->SearchOperator = @$_GET["z_Domicilio"];

		// Num_Exterior
		$this->Num_Exterior->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_Exterior"]);
		if ($this->Num_Exterior->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_Exterior->AdvancedSearch->SearchOperator = @$_GET["z_Num_Exterior"];

		// Num_Interior
		$this->Num_Interior->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_Interior"]);
		if ($this->Num_Interior->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_Interior->AdvancedSearch->SearchOperator = @$_GET["z_Num_Interior"];

		// Colonia
		$this->Colonia->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Colonia"]);
		if ($this->Colonia->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Colonia->AdvancedSearch->SearchOperator = @$_GET["z_Colonia"];

		// Poblacion
		$this->Poblacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Poblacion"]);
		if ($this->Poblacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Poblacion->AdvancedSearch->SearchOperator = @$_GET["z_Poblacion"];

		// CP
		$this->CP->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_CP"]);
		if ($this->CP->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->CP->AdvancedSearch->SearchOperator = @$_GET["z_CP"];

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado"]);
		if ($this->Id_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado"];

		// Tel_Particular
		$this->Tel_Particular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tel_Particular"]);
		if ($this->Tel_Particular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tel_Particular->AdvancedSearch->SearchOperator = @$_GET["z_Tel_Particular"];

		// Tel_Oficina
		$this->Tel_Oficina->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tel_Oficina"]);
		if ($this->Tel_Oficina->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tel_Oficina->AdvancedSearch->SearchOperator = @$_GET["z_Tel_Oficina"];

		// Tipo_Identificacion
		$this->Tipo_Identificacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tipo_Identificacion"]);
		if ($this->Tipo_Identificacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tipo_Identificacion->AdvancedSearch->SearchOperator = @$_GET["z_Tipo_Identificacion"];

		// Numero_Identificacion
		$this->Numero_Identificacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Numero_Identificacion"]);
		if ($this->Numero_Identificacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Numero_Identificacion->AdvancedSearch->SearchOperator = @$_GET["z_Numero_Identificacion"];
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
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Num_Exterior->setDbValue($rs->fields('Num_Exterior'));
		$this->Num_Interior->setDbValue($rs->fields('Num_Interior'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Tel_Particular->setDbValue($rs->fields('Tel_Particular'));
		$this->Tel_Oficina->setDbValue($rs->fields('Tel_Oficina'));
		$this->Tipo_Identificacion->setDbValue($rs->fields('Tipo_Identificacion'));
		$this->Numero_Identificacion->setDbValue($rs->fields('Numero_Identificacion'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Cliente")) <> "")
			$this->Id_Cliente->CurrentValue = $this->getKey("Id_Cliente"); // Id_Cliente
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
		// Id_Cliente
		// Nombre_Completo

		$this->Nombre_Completo->CellCssStyle = "white-space: nowrap;";

		// Domicilio
		// Num_Exterior
		// Num_Interior
		// Colonia
		// Poblacion
		// CP
		// Id_Estado
		// Tel_Particular
		// Tel_Oficina
		// Tipo_Identificacion
		// Numero_Identificacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Cliente
			$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewCustomAttributes = "";

			// Num_Exterior
			$this->Num_Exterior->ViewValue = $this->Num_Exterior->CurrentValue;
			$this->Num_Exterior->ViewCustomAttributes = "";

			// Num_Interior
			$this->Num_Interior->ViewValue = $this->Num_Interior->CurrentValue;
			$this->Num_Interior->ViewCustomAttributes = "";

			// Colonia
			$this->Colonia->ViewValue = $this->Colonia->CurrentValue;
			$this->Colonia->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

			// Id_Estado
			if (strval($this->Id_Estado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Estado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
				}
			} else {
				$this->Id_Estado->ViewValue = NULL;
			}
			$this->Id_Estado->ViewCustomAttributes = "";

			// Tel_Particular
			$this->Tel_Particular->ViewValue = $this->Tel_Particular->CurrentValue;
			$this->Tel_Particular->ViewCustomAttributes = "";

			// Tel_Oficina
			$this->Tel_Oficina->ViewValue = $this->Tel_Oficina->CurrentValue;
			$this->Tel_Oficina->ViewCustomAttributes = "";

			// Tipo_Identificacion
			if (strval($this->Tipo_Identificacion->CurrentValue) <> "") {
				switch ($this->Tipo_Identificacion->CurrentValue) {
					case $this->Tipo_Identificacion->FldTagValue(1):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(2):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(3):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(4):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->CurrentValue;
						break;
					default:
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->CurrentValue;
				}
			} else {
				$this->Tipo_Identificacion->ViewValue = NULL;
			}
			$this->Tipo_Identificacion->ViewCustomAttributes = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->ViewValue = $this->Numero_Identificacion->CurrentValue;
			$this->Numero_Identificacion->ViewCustomAttributes = "";

			// Id_Cliente
			$this->Id_Cliente->LinkCustomAttributes = "";
			$this->Id_Cliente->HrefValue = "";
			$this->Id_Cliente->TooltipValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->LinkCustomAttributes = "";
			$this->Nombre_Completo->HrefValue = "";
			$this->Nombre_Completo->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Num_Exterior
			$this->Num_Exterior->LinkCustomAttributes = "";
			$this->Num_Exterior->HrefValue = "";
			$this->Num_Exterior->TooltipValue = "";

			// Num_Interior
			$this->Num_Interior->LinkCustomAttributes = "";
			$this->Num_Interior->HrefValue = "";
			$this->Num_Interior->TooltipValue = "";

			// Colonia
			$this->Colonia->LinkCustomAttributes = "";
			$this->Colonia->HrefValue = "";
			$this->Colonia->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// CP
			$this->CP->LinkCustomAttributes = "";
			$this->CP->HrefValue = "";
			$this->CP->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Tel_Particular
			$this->Tel_Particular->LinkCustomAttributes = "";
			$this->Tel_Particular->HrefValue = "";
			$this->Tel_Particular->TooltipValue = "";

			// Tel_Oficina
			$this->Tel_Oficina->LinkCustomAttributes = "";
			$this->Tel_Oficina->HrefValue = "";
			$this->Tel_Oficina->TooltipValue = "";

			// Tipo_Identificacion
			$this->Tipo_Identificacion->LinkCustomAttributes = "";
			$this->Tipo_Identificacion->HrefValue = "";
			$this->Tipo_Identificacion->TooltipValue = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->LinkCustomAttributes = "";
			$this->Numero_Identificacion->HrefValue = "";
			$this->Numero_Identificacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Cliente
			$this->Id_Cliente->EditCustomAttributes = "";
			$this->Id_Cliente->EditValue = ew_HtmlEncode($this->Id_Cliente->AdvancedSearch->SearchValue);

			// Nombre_Completo
			$this->Nombre_Completo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre_Completo->EditValue = ew_HtmlEncode($this->Nombre_Completo->AdvancedSearch->SearchValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);

			// Num_Exterior
			$this->Num_Exterior->EditCustomAttributes = "";
			$this->Num_Exterior->EditValue = ew_HtmlEncode($this->Num_Exterior->AdvancedSearch->SearchValue);

			// Num_Interior
			$this->Num_Interior->EditCustomAttributes = "";
			$this->Num_Interior->EditValue = ew_HtmlEncode($this->Num_Interior->AdvancedSearch->SearchValue);

			// Colonia
			$this->Colonia->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Colonia->EditValue = ew_HtmlEncode($this->Colonia->AdvancedSearch->SearchValue);

			// Poblacion
			$this->Poblacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->AdvancedSearch->SearchValue);

			// CP
			$this->CP->EditCustomAttributes = "";
			$this->CP->EditValue = ew_HtmlEncode($this->CP->AdvancedSearch->SearchValue);

			// Id_Estado
			$this->Id_Estado->EditCustomAttributes = "";

			// Tel_Particular
			$this->Tel_Particular->EditCustomAttributes = "";
			$this->Tel_Particular->EditValue = ew_HtmlEncode($this->Tel_Particular->AdvancedSearch->SearchValue);

			// Tel_Oficina
			$this->Tel_Oficina->EditCustomAttributes = "";
			$this->Tel_Oficina->EditValue = ew_HtmlEncode($this->Tel_Oficina->AdvancedSearch->SearchValue);

			// Tipo_Identificacion
			$this->Tipo_Identificacion->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(1), $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(2), $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(3), $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->FldTagValue(3));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(4), $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->FldTagValue(4));
			$this->Tipo_Identificacion->EditValue = $arwrk;

			// Numero_Identificacion
			$this->Numero_Identificacion->EditCustomAttributes = "";
			$this->Numero_Identificacion->EditValue = ew_HtmlEncode($this->Numero_Identificacion->AdvancedSearch->SearchValue);
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
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Num_Exterior->AdvancedSearch->Load();
		$this->Num_Interior->AdvancedSearch->Load();
		$this->Colonia->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->CP->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Tel_Particular->AdvancedSearch->Load();
		$this->Tel_Oficina->AdvancedSearch->Load();
		$this->Tipo_Identificacion->AdvancedSearch->Load();
		$this->Numero_Identificacion->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_cliente_papeleta\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_cliente_papeleta',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_cliente_papeletalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_cliente_papeleta_list)) $cap_cliente_papeleta_list = new ccap_cliente_papeleta_list();

// Page init
$cap_cliente_papeleta_list->Page_Init();

// Page main
$cap_cliente_papeleta_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_cliente_papeleta->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_cliente_papeleta_list = new ew_Page("cap_cliente_papeleta_list");
cap_cliente_papeleta_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_cliente_papeleta_list.PageID; // For backward compatibility

// Form object
var fcap_cliente_papeletalist = new ew_Form("fcap_cliente_papeletalist");

// Form_CustomValidate event
fcap_cliente_papeletalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_cliente_papeletalist.ValidateRequired = true;
<?php } else { ?>
fcap_cliente_papeletalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_cliente_papeletalist.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_cliente_papeletalistsrch = new ew_Form("fcap_cliente_papeletalistsrch");

// Validate function for search
fcap_cliente_papeletalistsrch.Validate = function(fobj) {
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
fcap_cliente_papeletalistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_cliente_papeletalistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_cliente_papeletalistsrch.ValidateRequired = false; // no JavaScript validation
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
		$cap_cliente_papeleta_list->TotalRecs = $cap_cliente_papeleta->SelectRecordCount();
	} else {
		if ($cap_cliente_papeleta_list->Recordset = $cap_cliente_papeleta_list->LoadRecordset())
			$cap_cliente_papeleta_list->TotalRecs = $cap_cliente_papeleta_list->Recordset->RecordCount();
	}
	$cap_cliente_papeleta_list->StartRec = 1;
	if ($cap_cliente_papeleta_list->DisplayRecs <= 0 || ($cap_cliente_papeleta->Export <> "" && $cap_cliente_papeleta->ExportAll)) // Display all records
		$cap_cliente_papeleta_list->DisplayRecs = $cap_cliente_papeleta_list->TotalRecs;
	if (!($cap_cliente_papeleta->Export <> "" && $cap_cliente_papeleta->ExportAll))
		$cap_cliente_papeleta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_cliente_papeleta_list->Recordset = $cap_cliente_papeleta_list->LoadRecordset($cap_cliente_papeleta_list->StartRec-1, $cap_cliente_papeleta_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_cliente_papeleta->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_cliente_papeleta_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_cliente_papeleta->Export == "" && $cap_cliente_papeleta->CurrentAction == "") { ?>
<form name="fcap_cliente_papeletalistsrch" id="fcap_cliente_papeletalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_cliente_papeletalistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_cliente_papeletalistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_cliente_papeletalistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_cliente_papeleta">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_cliente_papeleta_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_cliente_papeleta->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_cliente_papeleta->ResetAttrs();
$cap_cliente_papeleta_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_cliente_papeleta->Tipo_Identificacion->Visible) { // Tipo_Identificacion ?>
	<span id="xsc_Tipo_Identificacion" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_cliente_papeleta->Tipo_Identificacion->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Tipo_Identificacion" id="z_Tipo_Identificacion" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Tipo_Identificacion" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="{value}"<?php echo $cap_cliente_papeleta->Tipo_Identificacion->EditAttributes() ?>></div>
<div id="dsl_x_Tipo_Identificacion" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_cliente_papeleta->Tipo_Identificacion->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cliente_papeleta->Tipo_Identificacion->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_cliente_papeleta->Tipo_Identificacion->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_cliente_papeleta_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_3" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_cliente_papeleta_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_cliente_papeleta_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_cliente_papeleta_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_cliente_papeleta_list->ShowPageHeader(); ?>
<?php
$cap_cliente_papeleta_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_cliente_papeleta->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_cliente_papeleta->CurrentAction <> "gridadd" && $cap_cliente_papeleta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_cliente_papeleta_list->Pager)) $cap_cliente_papeleta_list->Pager = new cPrevNextPager($cap_cliente_papeleta_list->StartRec, $cap_cliente_papeleta_list->DisplayRecs, $cap_cliente_papeleta_list->TotalRecs) ?>
<?php if ($cap_cliente_papeleta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_cliente_papeleta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_cliente_papeleta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_cliente_papeleta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_cliente_papeleta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_cliente_papeleta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_cliente_papeleta_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_cliente_papeleta_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_cliente_papeletalist" id="fcap_cliente_papeletalist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_cliente_papeleta">
<div id="gmp_cap_cliente_papeleta" class="ewGridMiddlePanel">
<?php if ($cap_cliente_papeleta_list->TotalRecs > 0) { ?>
<table id="tbl_cap_cliente_papeletalist" class="ewTable ewTableSeparate">
<?php echo $cap_cliente_papeleta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_cliente_papeleta_list->RenderListOptions();

// Render list options (header, left)
$cap_cliente_papeleta_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_cliente_papeleta->Id_Cliente->Visible) { // Id_Cliente ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Id_Cliente) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Id_Cliente" class="cap_cliente_papeleta_Id_Cliente"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Id_Cliente->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Id_Cliente) ?>',1);"><span id="elh_cap_cliente_papeleta_Id_Cliente" class="cap_cliente_papeleta_Id_Cliente">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Id_Cliente->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Id_Cliente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Id_Cliente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Nombre_Completo->Visible) { // Nombre_Completo ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Nombre_Completo) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Nombre_Completo" class="cap_cliente_papeleta_Nombre_Completo"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $cap_cliente_papeleta->Nombre_Completo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Nombre_Completo) ?>',1);"><span id="elh_cap_cliente_papeleta_Nombre_Completo" class="cap_cliente_papeleta_Nombre_Completo">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Nombre_Completo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Nombre_Completo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Nombre_Completo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Domicilio->Visible) { // Domicilio ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Domicilio) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Domicilio" class="cap_cliente_papeleta_Domicilio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Domicilio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Domicilio) ?>',1);"><span id="elh_cap_cliente_papeleta_Domicilio" class="cap_cliente_papeleta_Domicilio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Domicilio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Domicilio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Domicilio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Num_Exterior->Visible) { // Num_Exterior ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Num_Exterior) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Num_Exterior" class="cap_cliente_papeleta_Num_Exterior"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Num_Exterior->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Num_Exterior) ?>',1);"><span id="elh_cap_cliente_papeleta_Num_Exterior" class="cap_cliente_papeleta_Num_Exterior">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Num_Exterior->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Num_Exterior->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Num_Exterior->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Num_Interior->Visible) { // Num_Interior ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Num_Interior) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Num_Interior" class="cap_cliente_papeleta_Num_Interior"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Num_Interior->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Num_Interior) ?>',1);"><span id="elh_cap_cliente_papeleta_Num_Interior" class="cap_cliente_papeleta_Num_Interior">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Num_Interior->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Num_Interior->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Num_Interior->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Colonia->Visible) { // Colonia ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Colonia) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Colonia" class="cap_cliente_papeleta_Colonia"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Colonia->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Colonia) ?>',1);"><span id="elh_cap_cliente_papeleta_Colonia" class="cap_cliente_papeleta_Colonia">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Colonia->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Colonia->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Colonia->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Poblacion->Visible) { // Poblacion ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Poblacion) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Poblacion" class="cap_cliente_papeleta_Poblacion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Poblacion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Poblacion) ?>',1);"><span id="elh_cap_cliente_papeleta_Poblacion" class="cap_cliente_papeleta_Poblacion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Poblacion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Poblacion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Poblacion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->CP->Visible) { // CP ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->CP) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_CP" class="cap_cliente_papeleta_CP"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->CP->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->CP) ?>',1);"><span id="elh_cap_cliente_papeleta_CP" class="cap_cliente_papeleta_CP">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->CP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->CP->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->CP->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Id_Estado) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Id_Estado" class="cap_cliente_papeleta_Id_Estado"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Id_Estado->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Id_Estado) ?>',1);"><span id="elh_cap_cliente_papeleta_Id_Estado" class="cap_cliente_papeleta_Id_Estado">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Id_Estado->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Id_Estado->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Id_Estado->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Tel_Particular->Visible) { // Tel_Particular ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tel_Particular) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Tel_Particular" class="cap_cliente_papeleta_Tel_Particular"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Tel_Particular->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tel_Particular) ?>',1);"><span id="elh_cap_cliente_papeleta_Tel_Particular" class="cap_cliente_papeleta_Tel_Particular">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Tel_Particular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Tel_Particular->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Tel_Particular->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Tel_Oficina->Visible) { // Tel_Oficina ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tel_Oficina) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Tel_Oficina" class="cap_cliente_papeleta_Tel_Oficina"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Tel_Oficina->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tel_Oficina) ?>',1);"><span id="elh_cap_cliente_papeleta_Tel_Oficina" class="cap_cliente_papeleta_Tel_Oficina">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Tel_Oficina->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Tel_Oficina->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Tel_Oficina->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Tipo_Identificacion->Visible) { // Tipo_Identificacion ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tipo_Identificacion) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Tipo_Identificacion" class="cap_cliente_papeleta_Tipo_Identificacion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Tipo_Identificacion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Tipo_Identificacion) ?>',1);"><span id="elh_cap_cliente_papeleta_Tipo_Identificacion" class="cap_cliente_papeleta_Tipo_Identificacion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Tipo_Identificacion->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Tipo_Identificacion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Tipo_Identificacion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cliente_papeleta->Numero_Identificacion->Visible) { // Numero_Identificacion ?>
	<?php if ($cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Numero_Identificacion) == "") { ?>
		<td><span id="elh_cap_cliente_papeleta_Numero_Identificacion" class="cap_cliente_papeleta_Numero_Identificacion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cliente_papeleta->Numero_Identificacion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cliente_papeleta->SortUrl($cap_cliente_papeleta->Numero_Identificacion) ?>',1);"><span id="elh_cap_cliente_papeleta_Numero_Identificacion" class="cap_cliente_papeleta_Numero_Identificacion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cliente_papeleta->Numero_Identificacion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cliente_papeleta->Numero_Identificacion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cliente_papeleta->Numero_Identificacion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_cliente_papeleta_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_cliente_papeleta->ExportAll && $cap_cliente_papeleta->Export <> "") {
	$cap_cliente_papeleta_list->StopRec = $cap_cliente_papeleta_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_cliente_papeleta_list->TotalRecs > $cap_cliente_papeleta_list->StartRec + $cap_cliente_papeleta_list->DisplayRecs - 1)
		$cap_cliente_papeleta_list->StopRec = $cap_cliente_papeleta_list->StartRec + $cap_cliente_papeleta_list->DisplayRecs - 1;
	else
		$cap_cliente_papeleta_list->StopRec = $cap_cliente_papeleta_list->TotalRecs;
}
$cap_cliente_papeleta_list->RecCnt = $cap_cliente_papeleta_list->StartRec - 1;
if ($cap_cliente_papeleta_list->Recordset && !$cap_cliente_papeleta_list->Recordset->EOF) {
	$cap_cliente_papeleta_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_cliente_papeleta_list->StartRec > 1)
		$cap_cliente_papeleta_list->Recordset->Move($cap_cliente_papeleta_list->StartRec - 1);
} elseif (!$cap_cliente_papeleta->AllowAddDeleteRow && $cap_cliente_papeleta_list->StopRec == 0) {
	$cap_cliente_papeleta_list->StopRec = $cap_cliente_papeleta->GridAddRowCount;
}

// Initialize aggregate
$cap_cliente_papeleta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_cliente_papeleta->ResetAttrs();
$cap_cliente_papeleta_list->RenderRow();
while ($cap_cliente_papeleta_list->RecCnt < $cap_cliente_papeleta_list->StopRec) {
	$cap_cliente_papeleta_list->RecCnt++;
	if (intval($cap_cliente_papeleta_list->RecCnt) >= intval($cap_cliente_papeleta_list->StartRec)) {
		$cap_cliente_papeleta_list->RowCnt++;

		// Set up key count
		$cap_cliente_papeleta_list->KeyCount = $cap_cliente_papeleta_list->RowIndex;

		// Init row class and style
		$cap_cliente_papeleta->ResetAttrs();
		$cap_cliente_papeleta->CssClass = "";
		if ($cap_cliente_papeleta->CurrentAction == "gridadd") {
		} else {
			$cap_cliente_papeleta_list->LoadRowValues($cap_cliente_papeleta_list->Recordset); // Load row values
		}
		$cap_cliente_papeleta->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_cliente_papeleta->RowAttrs = array_merge($cap_cliente_papeleta->RowAttrs, array('data-rowindex'=>$cap_cliente_papeleta_list->RowCnt, 'id'=>'r' . $cap_cliente_papeleta_list->RowCnt . '_cap_cliente_papeleta', 'data-rowtype'=>$cap_cliente_papeleta->RowType));

		// Render row
		$cap_cliente_papeleta_list->RenderRow();

		// Render list options
		$cap_cliente_papeleta_list->RenderListOptions();
?>
	<tr<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_cliente_papeleta_list->ListOptions->Render("body", "left", $cap_cliente_papeleta_list->RowCnt);
?>
	<?php if ($cap_cliente_papeleta->Id_Cliente->Visible) { // Id_Cliente ?>
		<td<?php echo $cap_cliente_papeleta->Id_Cliente->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Id_Cliente" class="cap_cliente_papeleta_Id_Cliente">
<span<?php echo $cap_cliente_papeleta->Id_Cliente->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Id_Cliente->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Nombre_Completo->Visible) { // Nombre_Completo ?>
		<td<?php echo $cap_cliente_papeleta->Nombre_Completo->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Nombre_Completo" class="cap_cliente_papeleta_Nombre_Completo">
<span<?php echo $cap_cliente_papeleta->Nombre_Completo->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Nombre_Completo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Domicilio->Visible) { // Domicilio ?>
		<td<?php echo $cap_cliente_papeleta->Domicilio->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Domicilio" class="cap_cliente_papeleta_Domicilio">
<span<?php echo $cap_cliente_papeleta->Domicilio->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Domicilio->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Num_Exterior->Visible) { // Num_Exterior ?>
		<td<?php echo $cap_cliente_papeleta->Num_Exterior->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Num_Exterior" class="cap_cliente_papeleta_Num_Exterior">
<span<?php echo $cap_cliente_papeleta->Num_Exterior->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Num_Exterior->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Num_Interior->Visible) { // Num_Interior ?>
		<td<?php echo $cap_cliente_papeleta->Num_Interior->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Num_Interior" class="cap_cliente_papeleta_Num_Interior">
<span<?php echo $cap_cliente_papeleta->Num_Interior->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Num_Interior->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Colonia->Visible) { // Colonia ?>
		<td<?php echo $cap_cliente_papeleta->Colonia->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Colonia" class="cap_cliente_papeleta_Colonia">
<span<?php echo $cap_cliente_papeleta->Colonia->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Colonia->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Poblacion->Visible) { // Poblacion ?>
		<td<?php echo $cap_cliente_papeleta->Poblacion->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Poblacion" class="cap_cliente_papeleta_Poblacion">
<span<?php echo $cap_cliente_papeleta->Poblacion->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Poblacion->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->CP->Visible) { // CP ?>
		<td<?php echo $cap_cliente_papeleta->CP->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_CP" class="cap_cliente_papeleta_CP">
<span<?php echo $cap_cliente_papeleta->CP->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->CP->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Id_Estado->Visible) { // Id_Estado ?>
		<td<?php echo $cap_cliente_papeleta->Id_Estado->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Id_Estado" class="cap_cliente_papeleta_Id_Estado">
<span<?php echo $cap_cliente_papeleta->Id_Estado->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Id_Estado->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Tel_Particular->Visible) { // Tel_Particular ?>
		<td<?php echo $cap_cliente_papeleta->Tel_Particular->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Tel_Particular" class="cap_cliente_papeleta_Tel_Particular">
<span<?php echo $cap_cliente_papeleta->Tel_Particular->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Tel_Particular->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Tel_Oficina->Visible) { // Tel_Oficina ?>
		<td<?php echo $cap_cliente_papeleta->Tel_Oficina->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Tel_Oficina" class="cap_cliente_papeleta_Tel_Oficina">
<span<?php echo $cap_cliente_papeleta->Tel_Oficina->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Tel_Oficina->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Tipo_Identificacion->Visible) { // Tipo_Identificacion ?>
		<td<?php echo $cap_cliente_papeleta->Tipo_Identificacion->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Tipo_Identificacion" class="cap_cliente_papeleta_Tipo_Identificacion">
<span<?php echo $cap_cliente_papeleta->Tipo_Identificacion->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Tipo_Identificacion->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cliente_papeleta->Numero_Identificacion->Visible) { // Numero_Identificacion ?>
		<td<?php echo $cap_cliente_papeleta->Numero_Identificacion->CellAttributes() ?>><span id="el<?php echo $cap_cliente_papeleta_list->RowCnt ?>_cap_cliente_papeleta_Numero_Identificacion" class="cap_cliente_papeleta_Numero_Identificacion">
<span<?php echo $cap_cliente_papeleta->Numero_Identificacion->ViewAttributes() ?>>
<?php echo $cap_cliente_papeleta->Numero_Identificacion->ListViewValue() ?></span>
</span><a id="<?php echo $cap_cliente_papeleta_list->PageObjName . "_row_" . $cap_cliente_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_cliente_papeleta_list->ListOptions->Render("body", "right", $cap_cliente_papeleta_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_cliente_papeleta->CurrentAction <> "gridadd")
		$cap_cliente_papeleta_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_cliente_papeleta->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_cliente_papeleta_list->Recordset)
	$cap_cliente_papeleta_list->Recordset->Close();
?>
<?php if ($cap_cliente_papeleta_list->TotalRecs > 0) { ?>
<?php if ($cap_cliente_papeleta->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_cliente_papeleta->CurrentAction <> "gridadd" && $cap_cliente_papeleta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_cliente_papeleta_list->Pager)) $cap_cliente_papeleta_list->Pager = new cPrevNextPager($cap_cliente_papeleta_list->StartRec, $cap_cliente_papeleta_list->DisplayRecs, $cap_cliente_papeleta_list->TotalRecs) ?>
<?php if ($cap_cliente_papeleta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_cliente_papeleta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_cliente_papeleta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cliente_papeleta_list->PageUrl() ?>start=<?php echo $cap_cliente_papeleta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_cliente_papeleta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_cliente_papeleta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_cliente_papeleta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_cliente_papeleta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_cliente_papeleta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_cliente_papeleta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_cliente_papeleta_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_cliente_papeleta_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_cliente_papeleta->Export == "") { ?>
<script type="text/javascript">
fcap_cliente_papeletalistsrch.Init();
fcap_cliente_papeletalist.Init();
</script>
<?php } ?>
<?php
$cap_cliente_papeleta_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_cliente_papeleta->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_cliente_papeleta_list->Page_Terminate();
?>
