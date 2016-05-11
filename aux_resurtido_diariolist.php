<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "aux_resurtido_diarioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "con_invent_equipo_imeisgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$aux_resurtido_diario_list = NULL; // Initialize page object first

class caux_resurtido_diario_list extends caux_resurtido_diario {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'aux_resurtido_diario';

	// Page object name
	var $PageObjName = 'aux_resurtido_diario_list';

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

		// Table object (aux_resurtido_diario)
		if (!isset($GLOBALS["aux_resurtido_diario"])) {
			$GLOBALS["aux_resurtido_diario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aux_resurtido_diario"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "aux_resurtido_diarioadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "aux_resurtido_diariodelete.php";
		$this->MultiUpdateUrl = "aux_resurtido_diarioupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'aux_resurtido_diario', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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
	var $con_invent_equipo_imeis_Count;
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("Id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["Id"] <> "") {
			$this->Id->setQueryStringValue($_GET["Id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id", $this->Id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue("k_key"));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("Id")) <> strval($this->Id->CurrentValue))
			return FALSE;
		return TRUE;
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
			$this->Id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id, FALSE); // Id
		$this->BuildSearchSql($sWhere, $this->Id_Almacen, FALSE); // Id_Almacen
		$this->BuildSearchSql($sWhere, $this->Id_Traspaso, FALSE); // Id_Traspaso
		$this->BuildSearchSql($sWhere, $this->Tipo, FALSE); // Tipo
		$this->BuildSearchSql($sWhere, $this->Fecha, FALSE); // Fecha
		$this->BuildSearchSql($sWhere, $this->Disponibles, FALSE); // Disponibles
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id->AdvancedSearch->Save(); // Id
			$this->Id_Almacen->AdvancedSearch->Save(); // Id_Almacen
			$this->Id_Traspaso->AdvancedSearch->Save(); // Id_Traspaso
			$this->Tipo->AdvancedSearch->Save(); // Tipo
			$this->Fecha->AdvancedSearch->Save(); // Fecha
			$this->Disponibles->AdvancedSearch->Save(); // Disponibles
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
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
		$this->BuildBasicSearchSQL($sWhere, $this->Num_IMEI, $Keyword);
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
		if ($this->Id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Almacen->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Traspaso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tipo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Disponibles->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
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
		$this->Id->AdvancedSearch->UnsetSession();
		$this->Id_Almacen->AdvancedSearch->UnsetSession();
		$this->Id_Traspaso->AdvancedSearch->UnsetSession();
		$this->Tipo->AdvancedSearch->UnsetSession();
		$this->Fecha->AdvancedSearch->UnsetSession();
		$this->Disponibles->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Id_Traspaso->AdvancedSearch->Load();
		$this->Tipo->AdvancedSearch->Load();
		$this->Fecha->AdvancedSearch->Load();
		$this->Disponibles->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Almacen, $bCtrl); // Id_Almacen
			$this->UpdateSort($this->Id_Articulo, $bCtrl); // Id_Articulo
			$this->UpdateSort($this->Id_Acabado_eq, $bCtrl); // Id_Acabado_eq
			$this->UpdateSort($this->Id_Tel_SIM, $bCtrl); // Id_Tel_SIM
			$this->UpdateSort($this->Fecha, $bCtrl); // Fecha
			$this->UpdateSort($this->Disponibles, $bCtrl); // Disponibles
			$this->UpdateSort($this->Num_IMEI, $bCtrl); // Num_IMEI
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
				$this->Id_Almacen->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Id_Acabado_eq->setSort("");
				$this->Id_Tel_SIM->setSort("");
				$this->Fecha->setSort("");
				$this->Disponibles->setSort("");
				$this->Num_IMEI->setSort("");
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
		$item->OnLeft = FALSE;

		// "detail_con_invent_equipo_imeis"
		$item = &$this->ListOptions->Add("detail_con_invent_equipo_imeis");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'con_invent_equipo_imeis');
		$item->OnLeft = FALSE;
		if (!isset($GLOBALS["con_invent_equipo_imeis_grid"])) $GLOBALS["con_invent_equipo_imeis_grid"] = new ccon_invent_equipo_imeis_grid;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex)) {
			$objForm->Index = $this->RowIndex;
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_action\" id=\"k" . $this->RowIndex . "_action\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue("k_key");
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_blankrow\" id=\"k" . $this->RowIndex . "_blankrow\" value=\"1\">";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['faux_resurtido_diariolist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "detail_con_invent_equipo_imeis"
		$oListOpt = &$this->ListOptions->Items["detail_con_invent_equipo_imeis"];
		if ($Security->AllowList(CurrentProjectID() . 'con_invent_equipo_imeis')) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("con_invent_equipo_imeis", "TblCaption");
			$oListOpt->Body .= str_replace("%c", $this->con_invent_equipo_imeis_Count, $Language->Phrase("DetailCount"));
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"con_invent_equipo_imeislist.php?" . EW_TABLE_SHOW_MASTER . "=aux_resurtido_diario&Id_Almacen=" . urlencode(strval($this->Id_Almacen->CurrentValue)) . "&Id_Articulo=" . urlencode(strval($this->Id_Articulo->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
		$sSqlWrk = "`Id_Almacen`=" . ew_AdjustSql($this->Id_Almacen->CurrentValue) . "";
		$sSqlWrk = $sSqlWrk . " AND " . "`Id_Articulo`=" . ew_AdjustSql($this->Id_Articulo->CurrentValue) . "";
		$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
		$sSqlWrk = str_replace("'", "\'", $sSqlWrk);
		$oListOpt = &$this->ListOptions->Items["detail_con_invent_equipo_imeis"];
		$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("con_invent_equipo_imeis", "TblCaption");
		$oListOpt->Body .= str_replace("%c", $this->con_invent_equipo_imeis_Count, $Language->Phrase("DetailCount"));
		$sHyperLinkParm = " href=\"con_invent_equipo_imeislist.php?" . EW_TABLE_SHOW_MASTER . "=aux_resurtido_diario&Id_Almacen=" . urlencode(strval($this->Id_Almacen->CurrentValue)) . "&Id_Articulo=" . urlencode(strval($this->Id_Articulo->CurrentValue)) . "\" id=\"dl%i_aux_resurtido_diario_con_invent_equipo_imeis\" onmouseover=\"ew_ShowDetails(this, 'con_invent_equipo_imeispreview.php?f=%s')\" onmouseout=\"ew_HideDetails();\"";
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

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Almacen->CurrentValue = 1;
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Acabado_eq->CurrentValue = NULL;
		$this->Id_Acabado_eq->OldValue = $this->Id_Acabado_eq->CurrentValue;
		$this->Id_Tel_SIM->CurrentValue = NULL;
		$this->Id_Tel_SIM->OldValue = $this->Id_Tel_SIM->CurrentValue;
		$this->Fecha->CurrentValue = date('d/m/Y');
		$this->Disponibles->CurrentValue = NULL;
		$this->Disponibles->OldValue = $this->Disponibles->CurrentValue;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
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
		// Id

		$this->Id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id"]);
		if ($this->Id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id->AdvancedSearch->SearchOperator = @$_GET["z_Id"];

		// Id_Almacen
		$this->Id_Almacen->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Almacen"]);
		if ($this->Id_Almacen->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Almacen->AdvancedSearch->SearchOperator = @$_GET["z_Id_Almacen"];

		// Id_Traspaso
		$this->Id_Traspaso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Traspaso"]);
		if ($this->Id_Traspaso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Traspaso->AdvancedSearch->SearchOperator = @$_GET["z_Id_Traspaso"];

		// Tipo
		$this->Tipo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tipo"]);
		if ($this->Tipo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tipo->AdvancedSearch->SearchOperator = @$_GET["z_Tipo"];

		// Fecha
		$this->Fecha->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha"]);
		if ($this->Fecha->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha->AdvancedSearch->SearchOperator = @$_GET["z_Fecha"];
		$this->Fecha->AdvancedSearch->SearchCondition = @$_GET["v_Fecha"];
		$this->Fecha->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Fecha"]);
		if ($this->Fecha->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Fecha->AdvancedSearch->SearchOperator2 = @$_GET["w_Fecha"];

		// Disponibles
		$this->Disponibles->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Disponibles"]);
		if ($this->Disponibles->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Disponibles->AdvancedSearch->SearchOperator = @$_GET["z_Disponibles"];

		// Num_IMEI
		$this->Num_IMEI->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_IMEI"]);
		if ($this->Num_IMEI->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_IMEI->AdvancedSearch->SearchOperator = @$_GET["z_Num_IMEI"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Almacen->FldIsDetailKey) {
			$this->Id_Almacen->setFormValue($objForm->GetValue("x_Id_Almacen"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Id_Acabado_eq->FldIsDetailKey) {
			$this->Id_Acabado_eq->setFormValue($objForm->GetValue("x_Id_Acabado_eq"));
		}
		if (!$this->Id_Tel_SIM->FldIsDetailKey) {
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->Disponibles->FldIsDetailKey) {
			$this->Disponibles->setFormValue($objForm->GetValue("x_Disponibles"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id->setFormValue($objForm->GetValue("x_Id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id->CurrentValue = $this->Id->FormValue;
		$this->Id_Almacen->CurrentValue = $this->Id_Almacen->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Id_Acabado_eq->CurrentValue = $this->Id_Acabado_eq->FormValue;
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->Disponibles->CurrentValue = $this->Disponibles->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
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
		$this->Id->setDbValue($rs->fields('Id'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Tipo->setDbValue($rs->fields('Tipo'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Disponibles->setDbValue($rs->fields('Disponibles'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		if (!isset($GLOBALS["con_invent_equipo_imeis_grid"])) $GLOBALS["con_invent_equipo_imeis_grid"] = new ccon_invent_equipo_imeis_grid;
		$sDetailFilter = $GLOBALS["con_invent_equipo_imeis"]->SqlDetailFilter_aux_resurtido_diario();
		$sDetailFilter = str_replace("@Id_Almacen@", ew_AdjustSql($this->Id_Almacen->DbValue), $sDetailFilter);
		$sDetailFilter = str_replace("@Id_Articulo@", ew_AdjustSql($this->Id_Articulo->DbValue), $sDetailFilter);
		$GLOBALS["con_invent_equipo_imeis"]->setCurrentMasterTable("aux_resurtido_diario");
		$sDetailFilter = $GLOBALS["con_invent_equipo_imeis"]->ApplyUserIDFilters($sDetailFilter);
		$this->con_invent_equipo_imeis_Count = $GLOBALS["con_invent_equipo_imeis"]->LoadRecordCount($sDetailFilter);
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id")) <> "")
			$this->Id->CurrentValue = $this->getKey("Id"); // Id
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
		// Id

		$this->Id->CellCssStyle = "white-space: nowrap;";

		// Id_Almacen
		// Id_Articulo

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->CellCssStyle = "white-space: nowrap;";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->CellCssStyle = "white-space: nowrap;";

		// Id_Traspaso
		$this->Id_Traspaso->CellCssStyle = "white-space: nowrap;";

		// Tipo
		$this->Tipo->CellCssStyle = "white-space: nowrap;";

		// Fecha
		$this->Fecha->CellCssStyle = "white-space: nowrap;";

		// Disponibles
		// Num_IMEI

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Almacen
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->ViewValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->ViewValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Acabado_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
				}
			} else {
				$this->Id_Acabado_eq->ViewValue = NULL;
			}
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Num_IMEI` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `reg_unico_tel_sim`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Disponibles
			$this->Disponibles->ViewValue = $this->Disponibles->CurrentValue;
			$this->Disponibles->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->LinkCustomAttributes = "";
			$this->Id_Almacen->HrefValue = "";
			$this->Id_Almacen->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Disponibles
			$this->Disponibles->LinkCustomAttributes = "";
			$this->Disponibles->HrefValue = "";
			$this->Disponibles->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = ew_HtmlEncode($this->Id_Articulo->CurrentValue);

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$this->Id_Acabado_eq->EditValue = ew_HtmlEncode($this->Id_Acabado_eq->CurrentValue);

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha->CurrentValue, 7));

			// Disponibles
			$this->Disponibles->EditCustomAttributes = "";
			$this->Disponibles->EditValue = ew_HtmlEncode($this->Disponibles->CurrentValue);

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Edit refer script
			// Id_Almacen

			$this->Id_Almacen->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Disponibles
			$this->Disponibles->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->EditValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->EditValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = $this->Id_Articulo->CurrentValue;
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->EditValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->EditValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$this->Id_Acabado_eq->EditValue = $this->Id_Acabado_eq->CurrentValue;
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Acabado_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Acabado_eq->EditValue = $this->Id_Acabado_eq->CurrentValue;
				}
			} else {
				$this->Id_Acabado_eq->EditValue = NULL;
			}
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Num_IMEI` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `reg_unico_tel_sim`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->EditValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->EditValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = $this->Fecha->CurrentValue;
			$this->Fecha->EditValue = ew_FormatDateTime($this->Fecha->EditValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Disponibles
			$this->Disponibles->EditCustomAttributes = "";
			$this->Disponibles->EditValue = $this->Disponibles->CurrentValue;
			$this->Disponibles->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Edit refer script
			// Id_Almacen

			$this->Id_Almacen->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Disponibles
			$this->Disponibles->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			if (trim(strval($this->Id_Almacen->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = ew_HtmlEncode($this->Id_Articulo->AdvancedSearch->SearchValue);

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$this->Id_Acabado_eq->EditValue = ew_HtmlEncode($this->Id_Acabado_eq->AdvancedSearch->SearchValue);

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha->AdvancedSearch->SearchValue2, 7), 7));

			// Disponibles
			$this->Disponibles->EditCustomAttributes = "";
			$this->Disponibles->EditValue = ew_HtmlEncode($this->Disponibles->AdvancedSearch->SearchValue);

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);
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
		if (!ew_CheckEuroDate($this->Fecha->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Fecha->FldErrMsg());
		}

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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($this->Num_IMEI->FormValue) && $this->Num_IMEI->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_IMEI->FldCaption());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
			if ($this->Id_Tel_SIM->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Id_Tel_SIM` = " . ew_AdjustSql($this->Id_Tel_SIM->CurrentValue) . ")";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Id_Tel_SIM->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Id_Tel_SIM->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// Num_IMEI
			$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, $this->Num_IMEI->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		if ($this->Id_Tel_SIM->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Id_Tel_SIM = " . ew_AdjustSql($this->Id_Tel_SIM->CurrentValue) . ")";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Id_Tel_SIM->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Id_Tel_SIM->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Id_Almacen
		$this->Id_Almacen->SetDbValueDef($rsnew, $this->Id_Almacen->CurrentValue, 0, strval($this->Id_Almacen->CurrentValue) == "");

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, NULL, FALSE);

		// Id_Acabado_eq
		$this->Id_Acabado_eq->SetDbValueDef($rsnew, $this->Id_Acabado_eq->CurrentValue, NULL, FALSE);

		// Id_Tel_SIM
		$this->Id_Tel_SIM->SetDbValueDef($rsnew, $this->Id_Tel_SIM->CurrentValue, 0, FALSE);

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha->CurrentValue, 7), NULL, FALSE);

		// Disponibles
		$this->Disponibles->SetDbValueDef($rsnew, $this->Disponibles->CurrentValue, NULL, FALSE);

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->Id->setDbValue($conn->Insert_ID());
			$rsnew['Id'] = $this->Id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Id_Traspaso->AdvancedSearch->Load();
		$this->Tipo->AdvancedSearch->Load();
		$this->Fecha->AdvancedSearch->Load();
		$this->Disponibles->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_aux_resurtido_diario\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_aux_resurtido_diario',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.faux_resurtido_diariolist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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

	// Generamos la tabla auxiliar de surtido diario al entrar a la vista, para que se actualizaen los telefonos que hay que resurtir
	  DB_Ejecuta("TRUNCATE TABLE aux_resurtido_diario"); // Quitamos lo que hay

	//  DB_Ejecuta("INSERT IGNORE INTO aux_resurtido_diario SELECT * FROM z_insertar_resurtido_traspaso WHERE Id_Almacen<>".Id_Tienda_Actual());
	  DB_Ejecuta("INSERT IGNORE INTO aux_resurtido_diario SELECT * FROM z_insertar_resurtido_venta WHERE Id_Almacen<>".Id_Tienda_Actual());
	  DB_Ejecuta("UPDATE z_actualizar_resurtido_disponibles SET Disponibles=Disponible_actual WHERE Id_Almacen=".Id_Tienda_Actual());
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
if (!isset($aux_resurtido_diario_list)) $aux_resurtido_diario_list = new caux_resurtido_diario_list();

// Page init
$aux_resurtido_diario_list->Page_Init();

// Page main
$aux_resurtido_diario_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($aux_resurtido_diario->Export == "") { ?>
<script type="text/javascript">

// Page object
var aux_resurtido_diario_list = new ew_Page("aux_resurtido_diario_list");
aux_resurtido_diario_list.PageID = "list"; // Page ID
var EW_PAGE_ID = aux_resurtido_diario_list.PageID; // For backward compatibility

// Form object
var faux_resurtido_diariolist = new ew_Form("faux_resurtido_diariolist");

// Validate form
faux_resurtido_diariolist.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = (fobj.key_count) ? String(i) : "";
		elm = fobj.elements["x" + infix + "_Num_IMEI"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_resurtido_diario->Num_IMEI->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
faux_resurtido_diariolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_resurtido_diariolist.ValidateRequired = true;
<?php } else { ?>
faux_resurtido_diariolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faux_resurtido_diariolist.Lists["x_Id_Almacen"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faux_resurtido_diariolist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faux_resurtido_diariolist.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faux_resurtido_diariolist.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":false,"DisplayFields":["x_Num_IMEI","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var faux_resurtido_diariolistsrch = new ew_Form("faux_resurtido_diariolistsrch");

// Validate function for search
faux_resurtido_diariolistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = fobj.elements["x" + infix + "_Fecha"];
	if (elm && !ew_CheckEuroDate(elm.value))
		return ew_OnError(this, elm, "<?php echo ew_JsEncode2($aux_resurtido_diario->Fecha->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj, infix);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
faux_resurtido_diariolistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_resurtido_diariolistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
faux_resurtido_diariolistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
faux_resurtido_diariolistsrch.Lists["x_Id_Almacen"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
	argument: [null, "tr", "tl"]	
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
		$aux_resurtido_diario_list->TotalRecs = $aux_resurtido_diario->SelectRecordCount();
	} else {
		if ($aux_resurtido_diario_list->Recordset = $aux_resurtido_diario_list->LoadRecordset())
			$aux_resurtido_diario_list->TotalRecs = $aux_resurtido_diario_list->Recordset->RecordCount();
	}
	$aux_resurtido_diario_list->StartRec = 1;
	if ($aux_resurtido_diario_list->DisplayRecs <= 0 || ($aux_resurtido_diario->Export <> "" && $aux_resurtido_diario->ExportAll)) // Display all records
		$aux_resurtido_diario_list->DisplayRecs = $aux_resurtido_diario_list->TotalRecs;
	if (!($aux_resurtido_diario->Export <> "" && $aux_resurtido_diario->ExportAll))
		$aux_resurtido_diario_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$aux_resurtido_diario_list->Recordset = $aux_resurtido_diario_list->LoadRecordset($aux_resurtido_diario_list->StartRec-1, $aux_resurtido_diario_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $aux_resurtido_diario->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $aux_resurtido_diario_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($aux_resurtido_diario->Export == "" && $aux_resurtido_diario->CurrentAction == "") { ?>
<form name="faux_resurtido_diariolistsrch" id="faux_resurtido_diariolistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:faux_resurtido_diariolistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="faux_resurtido_diariolistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="faux_resurtido_diariolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="aux_resurtido_diario">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$aux_resurtido_diario_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$aux_resurtido_diario->RowType = EW_ROWTYPE_SEARCH;

// Render row
$aux_resurtido_diario->ResetAttrs();
$aux_resurtido_diario_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($aux_resurtido_diario->Id_Almacen->Visible) { // Id_Almacen ?>
	<span id="xsc_Id_Almacen" class="ewCell">
		<span class="ewSearchCaption"><?php echo $aux_resurtido_diario->Id_Almacen->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Almacen" id="z_Id_Almacen" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Almacen" name="x_Id_Almacen"<?php echo $aux_resurtido_diario->Id_Almacen->EditAttributes() ?>>
<?php
if (is_array($aux_resurtido_diario->Id_Almacen->EditValue)) {
	$arwrk = $aux_resurtido_diario->Id_Almacen->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($aux_resurtido_diario->Id_Almacen->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Almacen`";
?>
<input type="hidden" name="s_x_Id_Almacen" id="s_x_Id_Almacen" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($aux_resurtido_diario->Id_Almacen->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Almacen` = {filter_value}"); ?>&t0=19">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($aux_resurtido_diario->Fecha->Visible) { // Fecha ?>
	<span id="xsc_Fecha" class="ewCell">
		<span class="ewSearchCaption"><?php echo $aux_resurtido_diario->Fecha->FldCaption() ?></span>
		<span class="ewSearchOperator"><select name="z_Fecha" id="z_Fecha" onchange="ewForms['faux_resurtido_diariolistsrch'].SrchOprChanged(this);"><option value="="<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("=") ?></option><option value="<>"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="<>") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="<") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="<=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator==">") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator==">=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="IS NULL") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="IS NOT NULL") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($aux_resurtido_diario->Fecha->AdvancedSearch->SearchOperator=="BETWEEN") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
		<span class="ewSearchField">
<input type="text" name="x_Fecha" id="x_Fecha" value="<?php echo $aux_resurtido_diario->Fecha->EditValue ?>"<?php echo $aux_resurtido_diario->Fecha->EditAttributes() ?>>
<?php if (!$aux_resurtido_diario->Fecha->ReadOnly && !$aux_resurtido_diario->Fecha->Disabled && @$aux_resurtido_diario->Fecha->EditAttrs["readonly"] == "" && @$aux_resurtido_diario->Fecha->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="faux_resurtido_diariolistsrch$x_Fecha$" name="faux_resurtido_diariolistsrch$x_Fecha$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("faux_resurtido_diariolistsrch", "x_Fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
		<span class="ewSearchCond btw1_Fecha" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
		<span class="ewSearchField btw1_Fecha" style="display: none">
<input type="text" name="y_Fecha" id="y_Fecha" value="<?php echo $aux_resurtido_diario->Fecha->EditValue2 ?>"<?php echo $aux_resurtido_diario->Fecha->EditAttributes() ?>>
<?php if (!$aux_resurtido_diario->Fecha->ReadOnly && !$aux_resurtido_diario->Fecha->Disabled && @$aux_resurtido_diario->Fecha->EditAttrs["readonly"] == "" && @$aux_resurtido_diario->Fecha->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="faux_resurtido_diariolistsrch$y_Fecha$" name="faux_resurtido_diariolistsrch$y_Fecha$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("faux_resurtido_diariolistsrch", "y_Fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($aux_resurtido_diario_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($aux_resurtido_diario_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($aux_resurtido_diario_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($aux_resurtido_diario_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $aux_resurtido_diario_list->ShowPageHeader(); ?>
<?php
$aux_resurtido_diario_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($aux_resurtido_diario->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($aux_resurtido_diario->CurrentAction <> "gridadd" && $aux_resurtido_diario->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($aux_resurtido_diario_list->Pager)) $aux_resurtido_diario_list->Pager = new cNumericPager($aux_resurtido_diario_list->StartRec, $aux_resurtido_diario_list->DisplayRecs, $aux_resurtido_diario_list->TotalRecs, $aux_resurtido_diario_list->RecRange) ?>
<?php if ($aux_resurtido_diario_list->Pager->RecordCount > 0) { ?>
	<?php if ($aux_resurtido_diario_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($aux_resurtido_diario_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($aux_resurtido_diario_list->SearchWhere == "0=101") { ?>
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
<?php if ($aux_resurtido_diario_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="aux_resurtido_diario">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($aux_resurtido_diario_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($aux_resurtido_diario_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($aux_resurtido_diario_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($aux_resurtido_diario_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($aux_resurtido_diario->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<form name="faux_resurtido_diariolist" id="faux_resurtido_diariolist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="aux_resurtido_diario">
<div id="gmp_aux_resurtido_diario" class="ewGridMiddlePanel">
<?php if ($aux_resurtido_diario_list->TotalRecs > 0) { ?>
<table id="tbl_aux_resurtido_diariolist" class="ewTable ewTableSeparate">
<?php echo $aux_resurtido_diario->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$aux_resurtido_diario_list->RenderListOptions();

// Render list options (header, left)
$aux_resurtido_diario_list->ListOptions->Render("header", "left");
?>
<?php if ($aux_resurtido_diario->Id_Almacen->Visible) { // Id_Almacen ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Almacen) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Id_Almacen" class="aux_resurtido_diario_Id_Almacen"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_resurtido_diario->Id_Almacen->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Almacen) ?>',2);"><span id="elh_aux_resurtido_diario_Id_Almacen" class="aux_resurtido_diario_Id_Almacen">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Id_Almacen->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Id_Almacen->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Id_Almacen->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Articulo) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Id_Articulo" class="aux_resurtido_diario_Id_Articulo"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $aux_resurtido_diario->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Articulo) ?>',2);"><span id="elh_aux_resurtido_diario_Id_Articulo" class="aux_resurtido_diario_Id_Articulo">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Id_Acabado_eq" class="aux_resurtido_diario_Id_Acabado_eq"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $aux_resurtido_diario->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Acabado_eq) ?>',2);"><span id="elh_aux_resurtido_diario_Id_Acabado_eq" class="aux_resurtido_diario_Id_Acabado_eq">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Id_Tel_SIM" class="aux_resurtido_diario_Id_Tel_SIM"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $aux_resurtido_diario->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Id_Tel_SIM) ?>',2);"><span id="elh_aux_resurtido_diario_Id_Tel_SIM" class="aux_resurtido_diario_Id_Tel_SIM">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Fecha->Visible) { // Fecha ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Fecha) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Fecha" class="aux_resurtido_diario_Fecha"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $aux_resurtido_diario->Fecha->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Fecha) ?>',2);"><span id="elh_aux_resurtido_diario_Fecha" class="aux_resurtido_diario_Fecha">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Fecha->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Fecha->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Fecha->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Disponibles->Visible) { // Disponibles ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Disponibles) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Disponibles" class="aux_resurtido_diario_Disponibles"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_resurtido_diario->Disponibles->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Disponibles) ?>',2);"><span id="elh_aux_resurtido_diario_Disponibles" class="aux_resurtido_diario_Disponibles">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Disponibles->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Disponibles->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Disponibles->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($aux_resurtido_diario->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($aux_resurtido_diario->SortUrl($aux_resurtido_diario->Num_IMEI) == "") { ?>
		<td><span id="elh_aux_resurtido_diario_Num_IMEI" class="aux_resurtido_diario_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $aux_resurtido_diario->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $aux_resurtido_diario->SortUrl($aux_resurtido_diario->Num_IMEI) ?>',2);"><span id="elh_aux_resurtido_diario_Num_IMEI" class="aux_resurtido_diario_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $aux_resurtido_diario->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($aux_resurtido_diario->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($aux_resurtido_diario->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$aux_resurtido_diario_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($aux_resurtido_diario->ExportAll && $aux_resurtido_diario->Export <> "") {
	$aux_resurtido_diario_list->StopRec = $aux_resurtido_diario_list->TotalRecs;
} else {

	// Set the last record to display
	if ($aux_resurtido_diario_list->TotalRecs > $aux_resurtido_diario_list->StartRec + $aux_resurtido_diario_list->DisplayRecs - 1)
		$aux_resurtido_diario_list->StopRec = $aux_resurtido_diario_list->StartRec + $aux_resurtido_diario_list->DisplayRecs - 1;
	else
		$aux_resurtido_diario_list->StopRec = $aux_resurtido_diario_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($aux_resurtido_diario->CurrentAction == "gridadd" || $aux_resurtido_diario->CurrentAction == "gridedit" || $aux_resurtido_diario->CurrentAction == "F")) {
		$aux_resurtido_diario_list->KeyCount = $objForm->GetValue("key_count");
		$aux_resurtido_diario_list->StopRec = $aux_resurtido_diario_list->KeyCount;
	}
}
$aux_resurtido_diario_list->RecCnt = $aux_resurtido_diario_list->StartRec - 1;
if ($aux_resurtido_diario_list->Recordset && !$aux_resurtido_diario_list->Recordset->EOF) {
	$aux_resurtido_diario_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $aux_resurtido_diario_list->StartRec > 1)
		$aux_resurtido_diario_list->Recordset->Move($aux_resurtido_diario_list->StartRec - 1);
} elseif (!$aux_resurtido_diario->AllowAddDeleteRow && $aux_resurtido_diario_list->StopRec == 0) {
	$aux_resurtido_diario_list->StopRec = $aux_resurtido_diario->GridAddRowCount;
}

// Initialize aggregate
$aux_resurtido_diario->RowType = EW_ROWTYPE_AGGREGATEINIT;
$aux_resurtido_diario->ResetAttrs();
$aux_resurtido_diario_list->RenderRow();
$aux_resurtido_diario_list->EditRowCnt = 0;
if ($aux_resurtido_diario->CurrentAction == "edit")
	$aux_resurtido_diario_list->RowIndex = 1;
while ($aux_resurtido_diario_list->RecCnt < $aux_resurtido_diario_list->StopRec) {
	$aux_resurtido_diario_list->RecCnt++;
	if (intval($aux_resurtido_diario_list->RecCnt) >= intval($aux_resurtido_diario_list->StartRec)) {
		$aux_resurtido_diario_list->RowCnt++;

		// Set up key count
		$aux_resurtido_diario_list->KeyCount = $aux_resurtido_diario_list->RowIndex;

		// Init row class and style
		$aux_resurtido_diario->ResetAttrs();
		$aux_resurtido_diario->CssClass = "";
		if ($aux_resurtido_diario->CurrentAction == "gridadd") {
			$aux_resurtido_diario_list->LoadDefaultValues(); // Load default values
		} else {
			$aux_resurtido_diario_list->LoadRowValues($aux_resurtido_diario_list->Recordset); // Load row values
		}
		$aux_resurtido_diario->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($aux_resurtido_diario->CurrentAction == "edit") {
			if ($aux_resurtido_diario_list->CheckInlineEditKey() && $aux_resurtido_diario_list->EditRowCnt == 0) { // Inline edit
				$aux_resurtido_diario->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($aux_resurtido_diario->CurrentAction == "edit" && $aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT && $aux_resurtido_diario->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$aux_resurtido_diario_list->RestoreFormValues(); // Restore form values
		}
		if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) // Edit row
			$aux_resurtido_diario_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$aux_resurtido_diario->RowAttrs = array_merge($aux_resurtido_diario->RowAttrs, array('data-rowindex'=>$aux_resurtido_diario_list->RowCnt, 'id'=>'r' . $aux_resurtido_diario_list->RowCnt . '_aux_resurtido_diario', 'data-rowtype'=>$aux_resurtido_diario->RowType));

		// Render row
		$aux_resurtido_diario_list->RenderRow();

		// Render list options
		$aux_resurtido_diario_list->RenderListOptions();
?>
	<tr<?php echo $aux_resurtido_diario->RowAttributes() ?>>
<?php

// Render list options (body, left)
$aux_resurtido_diario_list->ListOptions->Render("body", "left", $aux_resurtido_diario_list->RowCnt);
?>
	<?php if ($aux_resurtido_diario->Id_Almacen->Visible) { // Id_Almacen ?>
		<td<?php echo $aux_resurtido_diario->Id_Almacen->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Id_Almacen" class="aux_resurtido_diario_Id_Almacen">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Id_Almacen->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Almacen->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Almacen" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id_Almacen->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Id_Almacen->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Almacen->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT || $aux_resurtido_diario->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id->CurrentValue) ?>">
<?php } ?>
	<?php if ($aux_resurtido_diario->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $aux_resurtido_diario->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Id_Articulo" class="aux_resurtido_diario_Id_Articulo">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Id_Articulo->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Articulo" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id_Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Id_Articulo->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_resurtido_diario->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $aux_resurtido_diario->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Id_Acabado_eq" class="aux_resurtido_diario_Id_Acabado_eq">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Acabado_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Acabado_eq" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id_Acabado_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Acabado_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_resurtido_diario->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $aux_resurtido_diario->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Id_Tel_SIM" class="aux_resurtido_diario_Id_Tel_SIM">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Tel_SIM->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Tel_SIM" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id_Tel_SIM->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Tel_SIM->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_resurtido_diario->Fecha->Visible) { // Fecha ?>
		<td<?php echo $aux_resurtido_diario->Fecha->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Fecha" class="aux_resurtido_diario_Fecha">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Fecha->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Fecha->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Fecha" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Fecha->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Fecha->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Fecha->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_resurtido_diario->Disponibles->Visible) { // Disponibles ?>
		<td<?php echo $aux_resurtido_diario->Disponibles->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Disponibles" class="aux_resurtido_diario_Disponibles">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $aux_resurtido_diario->Disponibles->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Disponibles->EditValue ?></span>
<input type="hidden" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Disponibles" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Disponibles" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Disponibles->CurrentValue) ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Disponibles->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Disponibles->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($aux_resurtido_diario->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $aux_resurtido_diario->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $aux_resurtido_diario_list->RowCnt ?>_aux_resurtido_diario_Num_IMEI" class="aux_resurtido_diario_Num_IMEI">
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Num_IMEI" id="x<?php echo $aux_resurtido_diario_list->RowIndex ?>_Num_IMEI" size="15" maxlength="17" value="<?php echo $aux_resurtido_diario->Num_IMEI->EditValue ?>"<?php echo $aux_resurtido_diario->Num_IMEI->EditAttributes() ?>>
<?php } ?>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $aux_resurtido_diario->Num_IMEI->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Num_IMEI->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $aux_resurtido_diario_list->PageObjName . "_row_" . $aux_resurtido_diario_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$aux_resurtido_diario_list->ListOptions->Render("body", "right", $aux_resurtido_diario_list->RowCnt);
?>
	</tr>
<?php if ($aux_resurtido_diario->RowType == EW_ROWTYPE_ADD || $aux_resurtido_diario->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
faux_resurtido_diariolist.UpdateOpts(<?php echo $aux_resurtido_diario_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($aux_resurtido_diario->CurrentAction <> "gridadd")
		$aux_resurtido_diario_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($aux_resurtido_diario->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $aux_resurtido_diario_list->KeyCount ?>">
<?php } ?>
<?php if ($aux_resurtido_diario->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($aux_resurtido_diario_list->Recordset)
	$aux_resurtido_diario_list->Recordset->Close();
?>
<?php if ($aux_resurtido_diario_list->TotalRecs > 0) { ?>
<?php if ($aux_resurtido_diario->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($aux_resurtido_diario->CurrentAction <> "gridadd" && $aux_resurtido_diario->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($aux_resurtido_diario_list->Pager)) $aux_resurtido_diario_list->Pager = new cNumericPager($aux_resurtido_diario_list->StartRec, $aux_resurtido_diario_list->DisplayRecs, $aux_resurtido_diario_list->TotalRecs, $aux_resurtido_diario_list->RecRange) ?>
<?php if ($aux_resurtido_diario_list->Pager->RecordCount > 0) { ?>
	<?php if ($aux_resurtido_diario_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($aux_resurtido_diario_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $aux_resurtido_diario_list->PageUrl() ?>start=<?php echo $aux_resurtido_diario_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($aux_resurtido_diario_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $aux_resurtido_diario_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($aux_resurtido_diario_list->SearchWhere == "0=101") { ?>
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
<?php if ($aux_resurtido_diario_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="aux_resurtido_diario">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($aux_resurtido_diario_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($aux_resurtido_diario_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($aux_resurtido_diario_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($aux_resurtido_diario_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($aux_resurtido_diario->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<?php if ($aux_resurtido_diario->Export == "") { ?>
<script type="text/javascript">
faux_resurtido_diariolistsrch.Init();
faux_resurtido_diariolist.Init();
</script>
<?php } ?>
<?php
$aux_resurtido_diario_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($aux_resurtido_diario->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

document.getElementById('x1_Id_Tel_SIM').style.backgroundColor="#DCDCDC";  // Lo ponemos en gris
document.getElementById('x1_Id_Tel_SIM').style.display='block';  // Lo deshabilitamos 
document.getElementById('x1_Num_IMEI').value=""; // Borramos el valor del IMEI Nuevo, por si hubo validacion
document.getElementById('x1_Num_IMEI').focus();  // Le ponemos el Focus al IMEI NUEVO
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$aux_resurtido_diario_list->Page_Terminate();
?>
