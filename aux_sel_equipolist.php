<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "aux_sel_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$aux_sel_equipo_list = NULL; // Initialize page object first

class caux_sel_equipo_list extends caux_sel_equipo {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'aux_sel_equipo';

	// Page object name
	var $PageObjName = 'aux_sel_equipo_list';

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

		// Table object (aux_sel_equipo)
		if (!isset($GLOBALS["aux_sel_equipo"])) {
			$GLOBALS["aux_sel_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aux_sel_equipo"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "aux_sel_equipoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "aux_sel_equipodelete.php";
		$this->MultiUpdateUrl = "aux_sel_equipoupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'aux_sel_equipo', TRUE);

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
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Tel_SIM, FALSE); // Id_Tel_SIM
		$this->BuildSearchSql($sWhere, $this->Id_Almacen, FALSE); // Id_Almacen
		$this->BuildSearchSql($sWhere, $this->Articulo, FALSE); // Articulo
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo
		$this->BuildSearchSql($sWhere, $this->Acabado_eq, FALSE); // Acabado_eq
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI
		$this->BuildSearchSql($sWhere, $this->Num_ICCID, FALSE); // Num_ICCID
		$this->BuildSearchSql($sWhere, $this->Num_CEL, FALSE); // Num_CEL
		$this->BuildSearchSql($sWhere, $this->Id_Articulo, FALSE); // Id_Articulo
		$this->BuildSearchSql($sWhere, $this->Id_Acabado_eq, FALSE); // Id_Acabado_eq
		$this->BuildSearchSql($sWhere, $this->Status, FALSE); // Status
		$this->BuildSearchSql($sWhere, $this->EquipoAcabado, FALSE); // EquipoAcabado
		$this->BuildSearchSql($sWhere, $this->Precio_Venta, FALSE); // Precio_Venta
		$this->BuildSearchSql($sWhere, $this->TipoEquipo, FALSE); // TipoEquipo

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Tel_SIM->AdvancedSearch->Save(); // Id_Tel_SIM
			$this->Id_Almacen->AdvancedSearch->Save(); // Id_Almacen
			$this->Articulo->AdvancedSearch->Save(); // Articulo
			$this->Codigo->AdvancedSearch->Save(); // Codigo
			$this->Acabado_eq->AdvancedSearch->Save(); // Acabado_eq
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
			$this->Num_ICCID->AdvancedSearch->Save(); // Num_ICCID
			$this->Num_CEL->AdvancedSearch->Save(); // Num_CEL
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->Id_Acabado_eq->AdvancedSearch->Save(); // Id_Acabado_eq
			$this->Status->AdvancedSearch->Save(); // Status
			$this->EquipoAcabado->AdvancedSearch->Save(); // EquipoAcabado
			$this->Precio_Venta->AdvancedSearch->Save(); // Precio_Venta
			$this->TipoEquipo->AdvancedSearch->Save(); // TipoEquipo
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
		$this->BuildBasicSearchSQL($sWhere, $this->Articulo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Codigo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Acabado_eq, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_IMEI, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_ICCID, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_CEL, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->EquipoAcabado, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->TipoEquipo, $Keyword);
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
		if ($this->Id_Tel_SIM->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Almacen->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Acabado_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_ICCID->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_CEL->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Acabado_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->EquipoAcabado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_Venta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->TipoEquipo->AdvancedSearch->IssetSession())
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
		$this->Id_Tel_SIM->AdvancedSearch->UnsetSession();
		$this->Id_Almacen->AdvancedSearch->UnsetSession();
		$this->Articulo->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
		$this->Acabado_eq->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
		$this->Num_ICCID->AdvancedSearch->UnsetSession();
		$this->Num_CEL->AdvancedSearch->UnsetSession();
		$this->Id_Articulo->AdvancedSearch->UnsetSession();
		$this->Id_Acabado_eq->AdvancedSearch->UnsetSession();
		$this->Status->AdvancedSearch->UnsetSession();
		$this->EquipoAcabado->AdvancedSearch->UnsetSession();
		$this->Precio_Venta->AdvancedSearch->UnsetSession();
		$this->TipoEquipo->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Acabado_eq->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Id_Acabado_eq->AdvancedSearch->Load();
		$this->Status->AdvancedSearch->Load();
		$this->EquipoAcabado->AdvancedSearch->Load();
		$this->Precio_Venta->AdvancedSearch->Load();
		$this->TipoEquipo->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Tel_SIM); // Id_Tel_SIM
			$this->UpdateSort($this->Id_Almacen); // Id_Almacen
			$this->UpdateSort($this->Articulo); // Articulo
			$this->UpdateSort($this->Codigo); // Codigo
			$this->UpdateSort($this->Acabado_eq); // Acabado_eq
			$this->UpdateSort($this->Num_IMEI); // Num_IMEI
			$this->UpdateSort($this->Num_ICCID); // Num_ICCID
			$this->UpdateSort($this->Num_CEL); // Num_CEL
			$this->UpdateSort($this->Id_Articulo); // Id_Articulo
			$this->UpdateSort($this->Id_Acabado_eq); // Id_Acabado_eq
			$this->UpdateSort($this->Status); // Status
			$this->UpdateSort($this->EquipoAcabado); // EquipoAcabado
			$this->UpdateSort($this->Precio_Venta); // Precio_Venta
			$this->UpdateSort($this->TipoEquipo); // TipoEquipo
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
				$this->Id_Tel_SIM->setSort("");
				$this->Id_Almacen->setSort("");
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->Acabado_eq->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_ICCID->setSort("");
				$this->Num_CEL->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Id_Acabado_eq->setSort("");
				$this->Status->setSort("");
				$this->EquipoAcabado->setSort("");
				$this->Precio_Venta->setSort("");
				$this->TipoEquipo->setSort("");
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
		// Id_Tel_SIM

		$this->Id_Tel_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tel_SIM"]);
		if ($this->Id_Tel_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tel_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tel_SIM"];

		// Id_Almacen
		$this->Id_Almacen->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Almacen"]);
		if ($this->Id_Almacen->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Almacen->AdvancedSearch->SearchOperator = @$_GET["z_Id_Almacen"];

		// Articulo
		$this->Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Articulo"]);
		if ($this->Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Articulo"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];

		// Acabado_eq
		$this->Acabado_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Acabado_eq"]);
		if ($this->Acabado_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Acabado_eq->AdvancedSearch->SearchOperator = @$_GET["z_Acabado_eq"];

		// Num_IMEI
		$this->Num_IMEI->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_IMEI"]);
		if ($this->Num_IMEI->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_IMEI->AdvancedSearch->SearchOperator = @$_GET["z_Num_IMEI"];

		// Num_ICCID
		$this->Num_ICCID->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_ICCID"]);
		if ($this->Num_ICCID->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_ICCID->AdvancedSearch->SearchOperator = @$_GET["z_Num_ICCID"];

		// Num_CEL
		$this->Num_CEL->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_CEL"]);
		if ($this->Num_CEL->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_CEL->AdvancedSearch->SearchOperator = @$_GET["z_Num_CEL"];

		// Id_Articulo
		$this->Id_Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Articulo"]);
		if ($this->Id_Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Articulo"];

		// Id_Acabado_eq
		$this->Id_Acabado_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Acabado_eq"]);
		if ($this->Id_Acabado_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Acabado_eq->AdvancedSearch->SearchOperator = @$_GET["z_Id_Acabado_eq"];

		// Status
		$this->Status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Status"]);
		if ($this->Status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Status->AdvancedSearch->SearchOperator = @$_GET["z_Status"];

		// EquipoAcabado
		$this->EquipoAcabado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_EquipoAcabado"]);
		if ($this->EquipoAcabado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->EquipoAcabado->AdvancedSearch->SearchOperator = @$_GET["z_EquipoAcabado"];

		// Precio_Venta
		$this->Precio_Venta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_Venta"]);
		if ($this->Precio_Venta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_Venta->AdvancedSearch->SearchOperator = @$_GET["z_Precio_Venta"];

		// TipoEquipo
		$this->TipoEquipo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_TipoEquipo"]);
		if ($this->TipoEquipo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->TipoEquipo->AdvancedSearch->SearchOperator = @$_GET["z_TipoEquipo"];
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
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->EquipoAcabado->setDbValue($rs->fields('EquipoAcabado'));
		$this->Precio_Venta->setDbValue($rs->fields('Precio_Venta'));
		$this->TipoEquipo->setDbValue($rs->fields('TipoEquipo'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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

		// Convert decimal values if posted back
		if ($this->Precio_Venta->FormValue == $this->Precio_Venta->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_Venta->CurrentValue)))
			$this->Precio_Venta->CurrentValue = ew_StrToFloat($this->Precio_Venta->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Tel_SIM
		// Id_Almacen
		// Articulo
		// Codigo
		// Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Id_Articulo
		// Id_Acabado_eq
		// Status
		// EquipoAcabado
		// Precio_Venta
		// TipoEquipo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Acabado_eq
			$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
			$this->Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(3):
						$this->Status->ViewValue = $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(4):
						$this->Status->ViewValue = $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// EquipoAcabado
			$this->EquipoAcabado->ViewValue = $this->EquipoAcabado->CurrentValue;
			$this->EquipoAcabado->ViewCustomAttributes = "";

			// Precio_Venta
			$this->Precio_Venta->ViewValue = $this->Precio_Venta->CurrentValue;
			$this->Precio_Venta->ViewCustomAttributes = "";

			// TipoEquipo
			$this->TipoEquipo->ViewValue = $this->TipoEquipo->CurrentValue;
			$this->TipoEquipo->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Id_Almacen
			$this->Id_Almacen->LinkCustomAttributes = "";
			$this->Id_Almacen->HrefValue = "";
			$this->Id_Almacen->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Acabado_eq
			$this->Acabado_eq->LinkCustomAttributes = "";
			$this->Acabado_eq->HrefValue = "";
			$this->Acabado_eq->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Num_ICCID
			$this->Num_ICCID->LinkCustomAttributes = "";
			$this->Num_ICCID->HrefValue = "";
			$this->Num_ICCID->TooltipValue = "";

			// Num_CEL
			$this->Num_CEL->LinkCustomAttributes = "";
			$this->Num_CEL->HrefValue = "";
			$this->Num_CEL->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// EquipoAcabado
			$this->EquipoAcabado->LinkCustomAttributes = "";
			$this->EquipoAcabado->HrefValue = "";
			$this->EquipoAcabado->TooltipValue = "";

			// Precio_Venta
			$this->Precio_Venta->LinkCustomAttributes = "";
			$this->Precio_Venta->HrefValue = "";
			$this->Precio_Venta->TooltipValue = "";

			// TipoEquipo
			$this->TipoEquipo->LinkCustomAttributes = "";
			$this->TipoEquipo->HrefValue = "";
			$this->TipoEquipo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			$this->Id_Tel_SIM->EditValue = ew_HtmlEncode($this->Id_Tel_SIM->AdvancedSearch->SearchValue);

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			$this->Id_Almacen->EditValue = ew_HtmlEncode($this->Id_Almacen->AdvancedSearch->SearchValue);

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->AdvancedSearch->SearchValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->AdvancedSearch->SearchValue);

			// Acabado_eq
			$this->Acabado_eq->EditCustomAttributes = "";
			$this->Acabado_eq->EditValue = ew_HtmlEncode($this->Acabado_eq->AdvancedSearch->SearchValue);

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->AdvancedSearch->SearchValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->AdvancedSearch->SearchValue);

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = ew_HtmlEncode($this->Id_Articulo->AdvancedSearch->SearchValue);

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$this->Id_Acabado_eq->EditValue = ew_HtmlEncode($this->Id_Acabado_eq->AdvancedSearch->SearchValue);

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$arwrk[] = array($this->Status->FldTagValue(3), $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->FldTagValue(3));
			$arwrk[] = array($this->Status->FldTagValue(4), $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->FldTagValue(4));
			$this->Status->EditValue = $arwrk;

			// EquipoAcabado
			$this->EquipoAcabado->EditCustomAttributes = "";
			$this->EquipoAcabado->EditValue = ew_HtmlEncode($this->EquipoAcabado->AdvancedSearch->SearchValue);

			// Precio_Venta
			$this->Precio_Venta->EditCustomAttributes = "";
			$this->Precio_Venta->EditValue = ew_HtmlEncode($this->Precio_Venta->AdvancedSearch->SearchValue);

			// TipoEquipo
			$this->TipoEquipo->EditCustomAttributes = "";
			$this->TipoEquipo->EditValue = ew_HtmlEncode($this->TipoEquipo->AdvancedSearch->SearchValue);
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
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Acabado_eq->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Id_Acabado_eq->AdvancedSearch->Load();
		$this->Status->AdvancedSearch->Load();
		$this->EquipoAcabado->AdvancedSearch->Load();
		$this->Precio_Venta->AdvancedSearch->Load();
		$this->TipoEquipo->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_aux_sel_equipo\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_aux_sel_equipo',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.faux_sel_equipolist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($aux_sel_equipo_list)) $aux_sel_equipo_list = new caux_sel_equipo_list();

// Page init
$aux_sel_equipo_list->Page_Init();

// Page main
$aux_sel_equipo_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($aux_sel_equipo->Export == "") { ?>
<script type="text/javascript">

// Page object
var aux_sel_equipo_list = new ew_Page("aux_sel_equipo_list");
aux_sel_equipo_list.PageID = "list"; // Page ID
var EW_PAGE_ID = aux_sel_equipo_list.PageID; // For backward compatibility

// Form object
var faux_sel_equipolist = new ew_Form("faux_sel_equipolist");

// Form_CustomValidate event
faux_sel_equipolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_sel_equipolist.ValidateRequired = true;
<?php } else { ?>
faux_sel_equipolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var faux_sel_equipolistsrch = new ew_Form("faux_sel_equipolistsrch");

// Validate function for search
faux_sel_equipolistsrch.Validate = function(fobj) {
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
faux_sel_equipolistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_sel_equipolistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
faux_sel_equipolistsrch.ValidateRequired = false; // no JavaScript validation
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
		$aux_sel_equipo_list->TotalRecs = $aux_sel_equipo->SelectRecordCount();
	} else {
		if ($aux_sel_equipo_list->Recordset = $aux_sel_equipo_list->LoadRecordset())
			$aux_sel_equipo_list->TotalRecs = $aux_sel_equipo_list->Recordset->RecordCount();
	}
	$aux_sel_equipo_list->StartRec = 1;
	if ($aux_sel_equipo_list->DisplayRecs <= 0 || ($aux_sel_equipo->Export <> "" && $aux_sel_equipo->ExportAll)) // Display all records
		$aux_sel_equipo_list->DisplayRecs = $aux_sel_equipo_list->TotalRecs;
	if (!($aux_sel_equipo->Export <> "" && $aux_sel_equipo->ExportAll))
		$aux_sel_equipo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$aux_sel_equipo_list->Recordset = $aux_sel_equipo_list->LoadRecordset($aux_sel_equipo_list->StartRec-1, $aux_sel_equipo_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $aux_sel_equipo->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $aux_sel_equipo_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($aux_sel_equipo->Export == "" && $aux_sel_equipo->CurrentAction == "") { ?>
<form name="faux_sel_equipolistsrch" id="faux_sel_equipolistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:faux_sel_equipolistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="faux_sel_equipolistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="faux_sel_equipolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="aux_sel_equipo">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$aux_sel_equipo_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$aux_sel_equipo->RowType = EW_ROWTYPE_SEARCH;

// Render row
$aux_sel_equipo->ResetAttrs();
$aux_sel_equipo_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($aux_sel_equipo->Status->Visible) { // Status ?>
	<span id="xsc_Status" class="ewCell">
		<span class="ewSearchCaption"><?php echo $aux_sel_equipo->Status->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Status" id="z_Status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Status" id="x_Status" value="{value}"<?php echo $aux_sel_equipo->Status->EditAttributes() ?>></div>
<div id="dsl_x_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $aux_sel_equipo->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($aux_sel_equipo->Status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Status" id="x_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $aux_sel_equipo->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($aux_sel_equipo_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_3" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($aux_sel_equipo_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($aux_sel_equipo_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($aux_sel_equipo_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $aux_sel_equipo_list->ShowPageHeader(); ?>
<?php
$aux_sel_equipo_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($aux_sel_equipo->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($aux_sel_equipo->CurrentAction <> "gridadd" && $aux_sel_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($aux_sel_equipo_list->Pager)) $aux_sel_equipo_list->Pager = new cPrevNextPager($aux_sel_equipo_list->StartRec, $aux_sel_equipo_list->DisplayRecs, $aux_sel_equipo_list->TotalRecs) ?>
<?php if ($aux_sel_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($aux_sel_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($aux_sel_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $aux_sel_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($aux_sel_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($aux_sel_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($aux_sel_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($aux_sel_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="aux_sel_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($aux_sel_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($aux_sel_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($aux_sel_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($aux_sel_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($aux_sel_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<form name="faux_sel_equipolist" id="faux_sel_equipolist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="aux_sel_equipo">
<div id="gmp_aux_sel_equipo" class="ewGridMiddlePanel">
<?php if ($aux_sel_equipo_list->TotalRecs > 0) { ?>
<table id="tbl_aux_sel_equipolist" class="ewTable ewTableSeparate">
<?php echo $aux_sel_equipo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$aux_sel_equipo_list->RenderListOptions();

// Render list options (header, left)
$aux_sel_equipo_list->ListOptions->Render("header", "left");
?>
<?php if ($aux_sel_equipo->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Id_Tel_SIM" class="aux_sel_equipo_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Tel_SIM) ?>',1);"><span id="elh_aux_sel_equipo_Id_Tel_SIM" class="aux_sel_equipo_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Id_Almacen->Visible) { // Id_Almacen ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Almacen) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Id_Almacen" class="aux_sel_equipo_Id_Almacen"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Id_Almacen->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Almacen) ?>',1);"><span id="elh_aux_sel_equipo_Id_Almacen" class="aux_sel_equipo_Id_Almacen">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Id_Almacen->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Id_Almacen->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Id_Almacen->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Articulo->Visible) { // Articulo ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Articulo) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Articulo" class="aux_sel_equipo_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Articulo) ?>',1);"><span id="elh_aux_sel_equipo_Articulo" class="aux_sel_equipo_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Articulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Codigo->Visible) { // Codigo ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Codigo) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Codigo" class="aux_sel_equipo_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Codigo) ?>',1);"><span id="elh_aux_sel_equipo_Codigo" class="aux_sel_equipo_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Codigo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Acabado_eq->Visible) { // Acabado_eq ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Acabado_eq) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Acabado_eq" class="aux_sel_equipo_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Acabado_eq) ?>',1);"><span id="elh_aux_sel_equipo_Acabado_eq" class="aux_sel_equipo_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Acabado_eq->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Num_IMEI) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Num_IMEI" class="aux_sel_equipo_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Num_IMEI) ?>',1);"><span id="elh_aux_sel_equipo_Num_IMEI" class="aux_sel_equipo_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Num_ICCID) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Num_ICCID" class="aux_sel_equipo_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Num_ICCID) ?>',1);"><span id="elh_aux_sel_equipo_Num_ICCID" class="aux_sel_equipo_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Num_ICCID->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Num_CEL) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Num_CEL" class="aux_sel_equipo_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Num_CEL) ?>',1);"><span id="elh_aux_sel_equipo_Num_CEL" class="aux_sel_equipo_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Num_CEL->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Articulo) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Id_Articulo" class="aux_sel_equipo_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Articulo) ?>',1);"><span id="elh_aux_sel_equipo_Id_Articulo" class="aux_sel_equipo_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Id_Acabado_eq" class="aux_sel_equipo_Id_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Id_Acabado_eq) ?>',1);"><span id="elh_aux_sel_equipo_Id_Acabado_eq" class="aux_sel_equipo_Id_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Status->Visible) { // Status ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Status) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Status" class="aux_sel_equipo_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Status) ?>',1);"><span id="elh_aux_sel_equipo_Status" class="aux_sel_equipo_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->EquipoAcabado->Visible) { // EquipoAcabado ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->EquipoAcabado) == "") { ?>
		<td><span id="elh_aux_sel_equipo_EquipoAcabado" class="aux_sel_equipo_EquipoAcabado"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->EquipoAcabado->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->EquipoAcabado) ?>',1);"><span id="elh_aux_sel_equipo_EquipoAcabado" class="aux_sel_equipo_EquipoAcabado">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->EquipoAcabado->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->EquipoAcabado->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->EquipoAcabado->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->Precio_Venta->Visible) { // Precio_Venta ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->Precio_Venta) == "") { ?>
		<td><span id="elh_aux_sel_equipo_Precio_Venta" class="aux_sel_equipo_Precio_Venta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->Precio_Venta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->Precio_Venta) ?>',1);"><span id="elh_aux_sel_equipo_Precio_Venta" class="aux_sel_equipo_Precio_Venta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->Precio_Venta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->Precio_Venta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->Precio_Venta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_sel_equipo->TipoEquipo->Visible) { // TipoEquipo ?>
	<?php if ($aux_sel_equipo->SortUrl($aux_sel_equipo->TipoEquipo) == "") { ?>
		<td><span id="elh_aux_sel_equipo_TipoEquipo" class="aux_sel_equipo_TipoEquipo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_sel_equipo->TipoEquipo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_sel_equipo->SortUrl($aux_sel_equipo->TipoEquipo) ?>',1);"><span id="elh_aux_sel_equipo_TipoEquipo" class="aux_sel_equipo_TipoEquipo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_sel_equipo->TipoEquipo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_sel_equipo->TipoEquipo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_sel_equipo->TipoEquipo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$aux_sel_equipo_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($aux_sel_equipo->ExportAll && $aux_sel_equipo->Export <> "") {
	$aux_sel_equipo_list->StopRec = $aux_sel_equipo_list->TotalRecs;
} else {

	// Set the last record to display
	if ($aux_sel_equipo_list->TotalRecs > $aux_sel_equipo_list->StartRec + $aux_sel_equipo_list->DisplayRecs - 1)
		$aux_sel_equipo_list->StopRec = $aux_sel_equipo_list->StartRec + $aux_sel_equipo_list->DisplayRecs - 1;
	else
		$aux_sel_equipo_list->StopRec = $aux_sel_equipo_list->TotalRecs;
}
$aux_sel_equipo_list->RecCnt = $aux_sel_equipo_list->StartRec - 1;
if ($aux_sel_equipo_list->Recordset && !$aux_sel_equipo_list->Recordset->EOF) {
	$aux_sel_equipo_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $aux_sel_equipo_list->StartRec > 1)
		$aux_sel_equipo_list->Recordset->Move($aux_sel_equipo_list->StartRec - 1);
} elseif (!$aux_sel_equipo->AllowAddDeleteRow && $aux_sel_equipo_list->StopRec == 0) {
	$aux_sel_equipo_list->StopRec = $aux_sel_equipo->GridAddRowCount;
}

// Initialize aggregate
$aux_sel_equipo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$aux_sel_equipo->ResetAttrs();
$aux_sel_equipo_list->RenderRow();
while ($aux_sel_equipo_list->RecCnt < $aux_sel_equipo_list->StopRec) {
	$aux_sel_equipo_list->RecCnt++;
	if (intval($aux_sel_equipo_list->RecCnt) >= intval($aux_sel_equipo_list->StartRec)) {
		$aux_sel_equipo_list->RowCnt++;

		// Set up key count
		$aux_sel_equipo_list->KeyCount = $aux_sel_equipo_list->RowIndex;

		// Init row class and style
		$aux_sel_equipo->ResetAttrs();
		$aux_sel_equipo->CssClass = "";
		if ($aux_sel_equipo->CurrentAction == "gridadd") {
		} else {
			$aux_sel_equipo_list->LoadRowValues($aux_sel_equipo_list->Recordset); // Load row values
		}
		$aux_sel_equipo->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$aux_sel_equipo->RowAttrs = array_merge($aux_sel_equipo->RowAttrs, array('data-rowindex'=>$aux_sel_equipo_list->RowCnt, 'id'=>'r' . $aux_sel_equipo_list->RowCnt . '_aux_sel_equipo', 'data-rowtype'=>$aux_sel_equipo->RowType));

		// Render row
		$aux_sel_equipo_list->RenderRow();

		// Render list options
		$aux_sel_equipo_list->RenderListOptions();
?>
	<tr<?php echo $aux_sel_equipo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$aux_sel_equipo_list->ListOptions->Render("body", "left", $aux_sel_equipo_list->RowCnt);
?>
	<?php if ($aux_sel_equipo->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $aux_sel_equipo->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Id_Tel_SIM" class="aux_sel_equipo_Id_Tel_SIM">
<span<?php echo $aux_sel_equipo->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Id_Tel_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Id_Almacen->Visible) { // Id_Almacen ?>
		<td<?php echo $aux_sel_equipo->Id_Almacen->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Id_Almacen" class="aux_sel_equipo_Id_Almacen">
<span<?php echo $aux_sel_equipo->Id_Almacen->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Id_Almacen->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Articulo->Visible) { // Articulo ?>
		<td<?php echo $aux_sel_equipo->Articulo->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Articulo" class="aux_sel_equipo_Articulo">
<span<?php echo $aux_sel_equipo->Articulo->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Codigo->Visible) { // Codigo ?>
		<td<?php echo $aux_sel_equipo->Codigo->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Codigo" class="aux_sel_equipo_Codigo">
<span<?php echo $aux_sel_equipo->Codigo->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Codigo->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Acabado_eq->Visible) { // Acabado_eq ?>
		<td<?php echo $aux_sel_equipo->Acabado_eq->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Acabado_eq" class="aux_sel_equipo_Acabado_eq">
<span<?php echo $aux_sel_equipo->Acabado_eq->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Acabado_eq->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $aux_sel_equipo->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Num_IMEI" class="aux_sel_equipo_Num_IMEI">
<span<?php echo $aux_sel_equipo->Num_IMEI->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Num_IMEI->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $aux_sel_equipo->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Num_ICCID" class="aux_sel_equipo_Num_ICCID">
<span<?php echo $aux_sel_equipo->Num_ICCID->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Num_ICCID->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $aux_sel_equipo->Num_CEL->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Num_CEL" class="aux_sel_equipo_Num_CEL">
<span<?php echo $aux_sel_equipo->Num_CEL->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Num_CEL->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $aux_sel_equipo->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Id_Articulo" class="aux_sel_equipo_Id_Articulo">
<span<?php echo $aux_sel_equipo->Id_Articulo->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Id_Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $aux_sel_equipo->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Id_Acabado_eq" class="aux_sel_equipo_Id_Acabado_eq">
<span<?php echo $aux_sel_equipo->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Id_Acabado_eq->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Status->Visible) { // Status ?>
		<td<?php echo $aux_sel_equipo->Status->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Status" class="aux_sel_equipo_Status">
<span<?php echo $aux_sel_equipo->Status->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Status->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->EquipoAcabado->Visible) { // EquipoAcabado ?>
		<td<?php echo $aux_sel_equipo->EquipoAcabado->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_EquipoAcabado" class="aux_sel_equipo_EquipoAcabado">
<span<?php echo $aux_sel_equipo->EquipoAcabado->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->EquipoAcabado->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->Precio_Venta->Visible) { // Precio_Venta ?>
		<td<?php echo $aux_sel_equipo->Precio_Venta->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_Precio_Venta" class="aux_sel_equipo_Precio_Venta">
<span<?php echo $aux_sel_equipo->Precio_Venta->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->Precio_Venta->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_sel_equipo->TipoEquipo->Visible) { // TipoEquipo ?>
		<td<?php echo $aux_sel_equipo->TipoEquipo->CellAttributes() ?>><span id="el<?php echo $aux_sel_equipo_list->RowCnt ?>_aux_sel_equipo_TipoEquipo" class="aux_sel_equipo_TipoEquipo">
<span<?php echo $aux_sel_equipo->TipoEquipo->ViewAttributes() ?>>
<?php echo $aux_sel_equipo->TipoEquipo->ListViewValue() ?></span>
</span><a id="<?php echo $aux_sel_equipo_list->PageObjName . "_row_" . $aux_sel_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$aux_sel_equipo_list->ListOptions->Render("body", "right", $aux_sel_equipo_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($aux_sel_equipo->CurrentAction <> "gridadd")
		$aux_sel_equipo_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($aux_sel_equipo->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($aux_sel_equipo_list->Recordset)
	$aux_sel_equipo_list->Recordset->Close();
?>
<?php if ($aux_sel_equipo_list->TotalRecs > 0) { ?>
<?php if ($aux_sel_equipo->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($aux_sel_equipo->CurrentAction <> "gridadd" && $aux_sel_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($aux_sel_equipo_list->Pager)) $aux_sel_equipo_list->Pager = new cPrevNextPager($aux_sel_equipo_list->StartRec, $aux_sel_equipo_list->DisplayRecs, $aux_sel_equipo_list->TotalRecs) ?>
<?php if ($aux_sel_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($aux_sel_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($aux_sel_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $aux_sel_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($aux_sel_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($aux_sel_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $aux_sel_equipo_list->PageUrl() ?>start=<?php echo $aux_sel_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $aux_sel_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($aux_sel_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($aux_sel_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="aux_sel_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($aux_sel_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($aux_sel_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($aux_sel_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($aux_sel_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($aux_sel_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<?php if ($aux_sel_equipo->Export == "") { ?>
<script type="text/javascript">
faux_sel_equipolistsrch.Init();
faux_sel_equipolist.Init();
</script>
<?php } ?>
<?php
$aux_sel_equipo_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($aux_sel_equipo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$aux_sel_equipo_list->Page_Terminate();
?>
