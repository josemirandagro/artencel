<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_reactiva_equipos_descontinuadosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_reactiva_equipos_descontinuados_list = NULL; // Initialize page object first

class ccap_reactiva_equipos_descontinuados_list extends ccap_reactiva_equipos_descontinuados {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_reactiva_equipos_descontinuados';

	// Page object name
	var $PageObjName = 'cap_reactiva_equipos_descontinuados_list';

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

		// Table object (cap_reactiva_equipos_descontinuados)
		if (!isset($GLOBALS["cap_reactiva_equipos_descontinuados"])) {
			$GLOBALS["cap_reactiva_equipos_descontinuados"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_reactiva_equipos_descontinuados"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_reactiva_equipos_descontinuadosadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_reactiva_equipos_descontinuadosdelete.php";
		$this->MultiUpdateUrl = "cap_reactiva_equipos_descontinuadosupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_reactiva_equipos_descontinuados', TRUE);

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
		$this->setKey("Id_Articulo", ""); // Clear inline edit key
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
		if (@$_GET["Id_Articulo"] <> "") {
			$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Articulo", $this->Id_Articulo->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Articulo")) <> strval($this->Id_Articulo->CurrentValue))
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
		$this->BuildSearchSql($sWhere, $this->Status, FALSE); // Status
		$this->BuildSearchSql($sWhere, $this->Articulo, FALSE); // Articulo
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo
		$this->BuildSearchSql($sWhere, $this->COD_Marca_eq, FALSE); // COD_Marca_eq
		$this->BuildSearchSql($sWhere, $this->COD_Modelo_eq, FALSE); // COD_Modelo_eq
		$this->BuildSearchSql($sWhere, $this->COD_Compania_eq, FALSE); // COD_Compania_eq

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->Status->AdvancedSearch->Save(); // Status
			$this->Articulo->AdvancedSearch->Save(); // Articulo
			$this->Codigo->AdvancedSearch->Save(); // Codigo
			$this->COD_Marca_eq->AdvancedSearch->Save(); // COD_Marca_eq
			$this->COD_Modelo_eq->AdvancedSearch->Save(); // COD_Modelo_eq
			$this->COD_Compania_eq->AdvancedSearch->Save(); // COD_Compania_eq
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
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Marca_eq, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Modelo_eq, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Compania_eq, $Keyword);
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
		if ($this->Status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Marca_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Modelo_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Compania_eq->AdvancedSearch->IssetSession())
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
		$this->Status->AdvancedSearch->UnsetSession();
		$this->Articulo->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
		$this->COD_Marca_eq->AdvancedSearch->UnsetSession();
		$this->COD_Modelo_eq->AdvancedSearch->UnsetSession();
		$this->COD_Compania_eq->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Status->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->COD_Modelo_eq->AdvancedSearch->Load();
		$this->COD_Compania_eq->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Status, $bCtrl); // Status
			$this->UpdateSort($this->Articulo, $bCtrl); // Articulo
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->COD_Marca_eq, $bCtrl); // COD_Marca_eq
			$this->UpdateSort($this->COD_Modelo_eq, $bCtrl); // COD_Modelo_eq
			$this->UpdateSort($this->COD_Compania_eq, $bCtrl); // COD_Compania_eq
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
				$this->Status->setSort("");
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->COD_Marca_eq->setSort("");
				$this->COD_Modelo_eq->setSort("");
				$this->COD_Compania_eq->setSort("");
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
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_reactiva_equipos_descontinuadoslist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Articulo->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->Status->CurrentValue = "Activo";
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->COD_Marca_eq->CurrentValue = NULL;
		$this->COD_Marca_eq->OldValue = $this->COD_Marca_eq->CurrentValue;
		$this->COD_Modelo_eq->CurrentValue = NULL;
		$this->COD_Modelo_eq->OldValue = $this->COD_Modelo_eq->CurrentValue;
		$this->COD_Compania_eq->CurrentValue = NULL;
		$this->COD_Compania_eq->OldValue = $this->COD_Compania_eq->CurrentValue;
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

		// Status
		$this->Status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Status"]);
		if ($this->Status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Status->AdvancedSearch->SearchOperator = @$_GET["z_Status"];

		// Articulo
		$this->Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Articulo"]);
		if ($this->Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Articulo"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];

		// COD_Marca_eq
		$this->COD_Marca_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Marca_eq"]);
		if ($this->COD_Marca_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Marca_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Marca_eq"];

		// COD_Modelo_eq
		$this->COD_Modelo_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Modelo_eq"]);
		if ($this->COD_Modelo_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Modelo_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Modelo_eq"];

		// COD_Compania_eq
		$this->COD_Compania_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Compania_eq"]);
		if ($this->COD_Compania_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Compania_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Compania_eq"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->COD_Marca_eq->FldIsDetailKey) {
			$this->COD_Marca_eq->setFormValue($objForm->GetValue("x_COD_Marca_eq"));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue($objForm->GetValue("x_COD_Modelo_eq"));
		}
		if (!$this->COD_Compania_eq->FldIsDetailKey) {
			$this->COD_Compania_eq->setFormValue($objForm->GetValue("x_COD_Compania_eq"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->COD_Marca_eq->CurrentValue = $this->COD_Marca_eq->FormValue;
		$this->COD_Modelo_eq->CurrentValue = $this->COD_Modelo_eq->FormValue;
		$this->COD_Compania_eq->CurrentValue = $this->COD_Compania_eq->FormValue;
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
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
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
		// Status
		// Articulo
		// Codigo
		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

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

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// COD_Marca_eq
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
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

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Compania_eq`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->ViewValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->ViewValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = ew_HtmlEncode($this->COD_Modelo_eq->CurrentValue);

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";

			// Edit refer script
			// Status

			$this->Status->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->EditValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->EditValue = NULL;
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Compania_eq`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->EditValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->EditValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Edit refer script
			// Status

			$this->Status->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->AdvancedSearch->SearchValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->AdvancedSearch->SearchValue);

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_equipo`";
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

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = ew_HtmlEncode($this->COD_Modelo_eq->AdvancedSearch->SearchValue);

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Compania_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Compania_eq->EditValue = $arwrk;
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

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
			if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Articulo` = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
			if ($this->Codigo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Codigo` = '" . ew_AdjustSql($this->Codigo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Codigo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Codigo->CurrentValue, $sIdxErrMsg);
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

			// Status
			$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, NULL, $this->Status->ReadOnly);

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
		if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Articulo = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->Codigo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Codigo = '" . ew_AdjustSql($this->Codigo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Codigo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Codigo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, NULL, strval($this->Status->CurrentValue) == "");

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// COD_Marca_eq
		$this->COD_Marca_eq->SetDbValueDef($rsnew, $this->COD_Marca_eq->CurrentValue, NULL, FALSE);

		// COD_Modelo_eq
		$this->COD_Modelo_eq->SetDbValueDef($rsnew, $this->COD_Modelo_eq->CurrentValue, NULL, FALSE);

		// COD_Compania_eq
		$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, FALSE);

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
			$this->Id_Articulo->setDbValue($conn->Insert_ID());
			$rsnew['Id_Articulo'] = $this->Id_Articulo->DbValue;
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
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Status->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->COD_Modelo_eq->AdvancedSearch->Load();
		$this->COD_Compania_eq->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_reactiva_equipos_descontinuados\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_reactiva_equipos_descontinuados',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_reactiva_equipos_descontinuadoslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_reactiva_equipos_descontinuados_list)) $cap_reactiva_equipos_descontinuados_list = new ccap_reactiva_equipos_descontinuados_list();

// Page init
$cap_reactiva_equipos_descontinuados_list->Page_Init();

// Page main
$cap_reactiva_equipos_descontinuados_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_reactiva_equipos_descontinuados->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_reactiva_equipos_descontinuados_list = new ew_Page("cap_reactiva_equipos_descontinuados_list");
cap_reactiva_equipos_descontinuados_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_reactiva_equipos_descontinuados_list.PageID; // For backward compatibility

// Form object
var fcap_reactiva_equipos_descontinuadoslist = new ew_Form("fcap_reactiva_equipos_descontinuadoslist");

// Validate form
fcap_reactiva_equipos_descontinuadoslist.Validate = function(fobj) {
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

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_reactiva_equipos_descontinuadoslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_reactiva_equipos_descontinuadoslist.ValidateRequired = true;
<?php } else { ?>
fcap_reactiva_equipos_descontinuadoslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_reactiva_equipos_descontinuadoslist.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_reactiva_equipos_descontinuadoslist.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_reactiva_equipos_descontinuadoslistsrch = new ew_Form("fcap_reactiva_equipos_descontinuadoslistsrch");

// Validate function for search
fcap_reactiva_equipos_descontinuadoslistsrch.Validate = function(fobj) {
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
fcap_reactiva_equipos_descontinuadoslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_reactiva_equipos_descontinuadoslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_reactiva_equipos_descontinuadoslistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_reactiva_equipos_descontinuadoslistsrch.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_reactiva_equipos_descontinuadoslistsrch.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		$cap_reactiva_equipos_descontinuados_list->TotalRecs = $cap_reactiva_equipos_descontinuados->SelectRecordCount();
	} else {
		if ($cap_reactiva_equipos_descontinuados_list->Recordset = $cap_reactiva_equipos_descontinuados_list->LoadRecordset())
			$cap_reactiva_equipos_descontinuados_list->TotalRecs = $cap_reactiva_equipos_descontinuados_list->Recordset->RecordCount();
	}
	$cap_reactiva_equipos_descontinuados_list->StartRec = 1;
	if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs <= 0 || ($cap_reactiva_equipos_descontinuados->Export <> "" && $cap_reactiva_equipos_descontinuados->ExportAll)) // Display all records
		$cap_reactiva_equipos_descontinuados_list->DisplayRecs = $cap_reactiva_equipos_descontinuados_list->TotalRecs;
	if (!($cap_reactiva_equipos_descontinuados->Export <> "" && $cap_reactiva_equipos_descontinuados->ExportAll))
		$cap_reactiva_equipos_descontinuados_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_reactiva_equipos_descontinuados_list->Recordset = $cap_reactiva_equipos_descontinuados_list->LoadRecordset($cap_reactiva_equipos_descontinuados_list->StartRec-1, $cap_reactiva_equipos_descontinuados_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_reactiva_equipos_descontinuados->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_reactiva_equipos_descontinuados_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_reactiva_equipos_descontinuados->Export == "" && $cap_reactiva_equipos_descontinuados->CurrentAction == "") { ?>
<form name="fcap_reactiva_equipos_descontinuadoslistsrch" id="fcap_reactiva_equipos_descontinuadoslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_reactiva_equipos_descontinuadoslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_reactiva_equipos_descontinuadoslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_reactiva_equipos_descontinuadoslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_reactiva_equipos_descontinuados">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_reactiva_equipos_descontinuados_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_reactiva_equipos_descontinuados->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_reactiva_equipos_descontinuados->ResetAttrs();
$cap_reactiva_equipos_descontinuados_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<span id="xsc_COD_Marca_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Marca_eq" id="z_COD_Marca_eq" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Marca_eq" name="x_COD_Marca_eq"<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_reactiva_equipos_descontinuados->COD_Marca_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_reactiva_equipos_descontinuadoslistsrch.Lists["x_COD_Marca_eq"].Options = <?php echo (is_array($cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue)) ? ew_ArrayToJson($cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<span id="xsc_COD_Modelo_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Modelo_eq" id="z_COD_Modelo_eq" value="="></span>
		<span class="ewSearchField">
<input type="text" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" size="30" maxlength="6" value="<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->EditAttributes() ?>>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<span id="xsc_COD_Compania_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Compania_eq" id="z_COD_Compania_eq" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Compania_eq" name="x_COD_Compania_eq"<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue)) {
	$arwrk = $cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_reactiva_equipos_descontinuados->COD_Compania_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_reactiva_equipos_descontinuadoslistsrch.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_5" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_reactiva_equipos_descontinuados_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_reactiva_equipos_descontinuados_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_reactiva_equipos_descontinuados_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_reactiva_equipos_descontinuados_list->ShowPageHeader(); ?>
<?php
$cap_reactiva_equipos_descontinuados_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_reactiva_equipos_descontinuados->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_reactiva_equipos_descontinuados->CurrentAction <> "gridadd" && $cap_reactiva_equipos_descontinuados->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_reactiva_equipos_descontinuados_list->Pager)) $cap_reactiva_equipos_descontinuados_list->Pager = new cNumericPager($cap_reactiva_equipos_descontinuados_list->StartRec, $cap_reactiva_equipos_descontinuados_list->DisplayRecs, $cap_reactiva_equipos_descontinuados_list->TotalRecs, $cap_reactiva_equipos_descontinuados_list->RecRange) ?>
<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_reactiva_equipos_descontinuados_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_reactiva_equipos_descontinuados_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_reactiva_equipos_descontinuados">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<form name="fcap_reactiva_equipos_descontinuadoslist" id="fcap_reactiva_equipos_descontinuadoslist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_reactiva_equipos_descontinuados">
<div id="gmp_cap_reactiva_equipos_descontinuados" class="ewGridMiddlePanel">
<?php if ($cap_reactiva_equipos_descontinuados_list->TotalRecs > 0) { ?>
<table id="tbl_cap_reactiva_equipos_descontinuadoslist" class="ewTable ewTableSeparate">
<?php echo $cap_reactiva_equipos_descontinuados->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_reactiva_equipos_descontinuados_list->RenderListOptions();

// Render list options (header, left)
$cap_reactiva_equipos_descontinuados_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_reactiva_equipos_descontinuados->Status->Visible) { // Status ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Status) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_Status" class="cap_reactiva_equipos_descontinuados_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Status) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_Status" class="cap_reactiva_equipos_descontinuados_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_reactiva_equipos_descontinuados->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Articulo) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_Articulo" class="cap_reactiva_equipos_descontinuados_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Articulo) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_Articulo" class="cap_reactiva_equipos_descontinuados_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->Articulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_reactiva_equipos_descontinuados->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Codigo) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_Codigo" class="cap_reactiva_equipos_descontinuados_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->Codigo) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_Codigo" class="cap_reactiva_equipos_descontinuados_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->Codigo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Marca_eq) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_COD_Marca_eq" class="cap_reactiva_equipos_descontinuados_COD_Marca_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Marca_eq) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Marca_eq" class="cap_reactiva_equipos_descontinuados_COD_Marca_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Modelo_eq) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_COD_Modelo_eq" class="cap_reactiva_equipos_descontinuados_COD_Modelo_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Modelo_eq) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Modelo_eq" class="cap_reactiva_equipos_descontinuados_COD_Modelo_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<?php if ($cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Compania_eq) == "") { ?>
		<td><span id="elh_cap_reactiva_equipos_descontinuados_COD_Compania_eq" class="cap_reactiva_equipos_descontinuados_COD_Compania_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_reactiva_equipos_descontinuados->SortUrl($cap_reactiva_equipos_descontinuados->COD_Compania_eq) ?>',2);"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Compania_eq" class="cap_reactiva_equipos_descontinuados_COD_Compania_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_reactiva_equipos_descontinuados_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_reactiva_equipos_descontinuados->ExportAll && $cap_reactiva_equipos_descontinuados->Export <> "") {
	$cap_reactiva_equipos_descontinuados_list->StopRec = $cap_reactiva_equipos_descontinuados_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_reactiva_equipos_descontinuados_list->TotalRecs > $cap_reactiva_equipos_descontinuados_list->StartRec + $cap_reactiva_equipos_descontinuados_list->DisplayRecs - 1)
		$cap_reactiva_equipos_descontinuados_list->StopRec = $cap_reactiva_equipos_descontinuados_list->StartRec + $cap_reactiva_equipos_descontinuados_list->DisplayRecs - 1;
	else
		$cap_reactiva_equipos_descontinuados_list->StopRec = $cap_reactiva_equipos_descontinuados_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_reactiva_equipos_descontinuados->CurrentAction == "gridadd" || $cap_reactiva_equipos_descontinuados->CurrentAction == "gridedit" || $cap_reactiva_equipos_descontinuados->CurrentAction == "F")) {
		$cap_reactiva_equipos_descontinuados_list->KeyCount = $objForm->GetValue("key_count");
		$cap_reactiva_equipos_descontinuados_list->StopRec = $cap_reactiva_equipos_descontinuados_list->KeyCount;
	}
}
$cap_reactiva_equipos_descontinuados_list->RecCnt = $cap_reactiva_equipos_descontinuados_list->StartRec - 1;
if ($cap_reactiva_equipos_descontinuados_list->Recordset && !$cap_reactiva_equipos_descontinuados_list->Recordset->EOF) {
	$cap_reactiva_equipos_descontinuados_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_reactiva_equipos_descontinuados_list->StartRec > 1)
		$cap_reactiva_equipos_descontinuados_list->Recordset->Move($cap_reactiva_equipos_descontinuados_list->StartRec - 1);
} elseif (!$cap_reactiva_equipos_descontinuados->AllowAddDeleteRow && $cap_reactiva_equipos_descontinuados_list->StopRec == 0) {
	$cap_reactiva_equipos_descontinuados_list->StopRec = $cap_reactiva_equipos_descontinuados->GridAddRowCount;
}

// Initialize aggregate
$cap_reactiva_equipos_descontinuados->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_reactiva_equipos_descontinuados->ResetAttrs();
$cap_reactiva_equipos_descontinuados_list->RenderRow();
$cap_reactiva_equipos_descontinuados_list->EditRowCnt = 0;
if ($cap_reactiva_equipos_descontinuados->CurrentAction == "edit")
	$cap_reactiva_equipos_descontinuados_list->RowIndex = 1;
while ($cap_reactiva_equipos_descontinuados_list->RecCnt < $cap_reactiva_equipos_descontinuados_list->StopRec) {
	$cap_reactiva_equipos_descontinuados_list->RecCnt++;
	if (intval($cap_reactiva_equipos_descontinuados_list->RecCnt) >= intval($cap_reactiva_equipos_descontinuados_list->StartRec)) {
		$cap_reactiva_equipos_descontinuados_list->RowCnt++;

		// Set up key count
		$cap_reactiva_equipos_descontinuados_list->KeyCount = $cap_reactiva_equipos_descontinuados_list->RowIndex;

		// Init row class and style
		$cap_reactiva_equipos_descontinuados->ResetAttrs();
		$cap_reactiva_equipos_descontinuados->CssClass = "";
		if ($cap_reactiva_equipos_descontinuados->CurrentAction == "gridadd") {
			$cap_reactiva_equipos_descontinuados_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_reactiva_equipos_descontinuados_list->LoadRowValues($cap_reactiva_equipos_descontinuados_list->Recordset); // Load row values
		}
		$cap_reactiva_equipos_descontinuados->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_reactiva_equipos_descontinuados->CurrentAction == "edit") {
			if ($cap_reactiva_equipos_descontinuados_list->CheckInlineEditKey() && $cap_reactiva_equipos_descontinuados_list->EditRowCnt == 0) { // Inline edit
				$cap_reactiva_equipos_descontinuados->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_reactiva_equipos_descontinuados->CurrentAction == "edit" && $cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT && $cap_reactiva_equipos_descontinuados->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_reactiva_equipos_descontinuados_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_reactiva_equipos_descontinuados_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_reactiva_equipos_descontinuados->RowAttrs = array_merge($cap_reactiva_equipos_descontinuados->RowAttrs, array('data-rowindex'=>$cap_reactiva_equipos_descontinuados_list->RowCnt, 'id'=>'r' . $cap_reactiva_equipos_descontinuados_list->RowCnt . '_cap_reactiva_equipos_descontinuados', 'data-rowtype'=>$cap_reactiva_equipos_descontinuados->RowType));

		// Render row
		$cap_reactiva_equipos_descontinuados_list->RenderRow();

		// Render list options
		$cap_reactiva_equipos_descontinuados_list->RenderListOptions();
?>
	<tr<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_reactiva_equipos_descontinuados_list->ListOptions->Render("body", "left", $cap_reactiva_equipos_descontinuados_list->RowCnt);
?>
	<?php if ($cap_reactiva_equipos_descontinuados->Status->Visible) { // Status ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Status->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_Status" class="cap_reactiva_equipos_descontinuados_Status">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" value="{value}"<?php echo $cap_reactiva_equipos_descontinuados->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_reactiva_equipos_descontinuados->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_reactiva_equipos_descontinuados->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_reactiva_equipos_descontinuados->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->Status->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Status->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT || $cap_reactiva_equipos_descontinuados->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->Id_Articulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_Articulo" class="cap_reactiva_equipos_descontinuados_Articulo">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->Articulo->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Articulo" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->Articulo->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_Codigo" class="cap_reactiva_equipos_descontinuados_Codigo">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->Codigo->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Codigo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Codigo" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->Codigo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->Codigo->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_COD_Marca_eq" class="cap_reactiva_equipos_descontinuados_COD_Marca_eq">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Marca_eq" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Marca_eq" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->COD_Marca_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_COD_Modelo_eq" class="cap_reactiva_equipos_descontinuados_COD_Modelo_eq">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Modelo_eq" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->CellAttributes() ?>><span id="el<?php echo $cap_reactiva_equipos_descontinuados_list->RowCnt ?>_cap_reactiva_equipos_descontinuados_COD_Compania_eq" class="cap_reactiva_equipos_descontinuados_COD_Compania_eq">
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Compania_eq" id="x<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>_COD_Compania_eq" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->COD_Compania_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_reactiva_equipos_descontinuados_list->PageObjName . "_row_" . $cap_reactiva_equipos_descontinuados_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_reactiva_equipos_descontinuados_list->ListOptions->Render("body", "right", $cap_reactiva_equipos_descontinuados_list->RowCnt);
?>
	</tr>
<?php if ($cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_ADD || $cap_reactiva_equipos_descontinuados->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_reactiva_equipos_descontinuadoslist.UpdateOpts(<?php echo $cap_reactiva_equipos_descontinuados_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_reactiva_equipos_descontinuados->CurrentAction <> "gridadd")
		$cap_reactiva_equipos_descontinuados_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_reactiva_equipos_descontinuados_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_reactiva_equipos_descontinuados_list->Recordset)
	$cap_reactiva_equipos_descontinuados_list->Recordset->Close();
?>
<?php if ($cap_reactiva_equipos_descontinuados_list->TotalRecs > 0) { ?>
<?php if ($cap_reactiva_equipos_descontinuados->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_reactiva_equipos_descontinuados->CurrentAction <> "gridadd" && $cap_reactiva_equipos_descontinuados->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_reactiva_equipos_descontinuados_list->Pager)) $cap_reactiva_equipos_descontinuados_list->Pager = new cNumericPager($cap_reactiva_equipos_descontinuados_list->StartRec, $cap_reactiva_equipos_descontinuados_list->DisplayRecs, $cap_reactiva_equipos_descontinuados_list->TotalRecs, $cap_reactiva_equipos_descontinuados_list->RecRange) ?>
<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_reactiva_equipos_descontinuados_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_reactiva_equipos_descontinuados_list->PageUrl() ?>start=<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_reactiva_equipos_descontinuados_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_reactiva_equipos_descontinuados_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_reactiva_equipos_descontinuados_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_reactiva_equipos_descontinuados">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_reactiva_equipos_descontinuados_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<?php if ($cap_reactiva_equipos_descontinuados->Export == "") { ?>
<script type="text/javascript">
fcap_reactiva_equipos_descontinuadoslistsrch.Init();
fcap_reactiva_equipos_descontinuadoslist.Init();
</script>
<?php } ?>
<?php
$cap_reactiva_equipos_descontinuados_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_reactiva_equipos_descontinuados->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_reactiva_equipos_descontinuados_list->Page_Terminate();
?>
