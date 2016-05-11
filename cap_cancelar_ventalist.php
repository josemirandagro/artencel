<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_cancelar_ventainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_cancelar_venta_list = NULL; // Initialize page object first

class ccap_cancelar_venta_list extends ccap_cancelar_venta {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_cancelar_venta';

	// Page object name
	var $PageObjName = 'cap_cancelar_venta_list';

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

		// Table object (cap_cancelar_venta)
		if (!isset($GLOBALS["cap_cancelar_venta"])) {
			$GLOBALS["cap_cancelar_venta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_cancelar_venta"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_cancelar_ventaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_cancelar_ventadelete.php";
		$this->MultiUpdateUrl = "cap_cancelar_ventaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_cancelar_venta', TRUE);

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
		$this->setKey("Id_Venta_Eq", ""); // Clear inline edit key
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
		if (@$_GET["Id_Venta_Eq"] <> "") {
			$this->Id_Venta_Eq->setQueryStringValue($_GET["Id_Venta_Eq"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Venta_Eq", $this->Id_Venta_Eq->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Venta_Eq")) <> strval($this->Id_Venta_Eq->CurrentValue))
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
			$this->Id_Venta_Eq->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Venta_Eq->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Venta_Eq, FALSE); // Id_Venta_Eq
		$this->BuildSearchSql($sWhere, $this->Id_Tienda, FALSE); // Id_Tienda
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI
		$this->BuildSearchSql($sWhere, $this->FechaVenta, FALSE); // FechaVenta
		$this->BuildSearchSql($sWhere, $this->Cliente, FALSE); // Cliente
		$this->BuildSearchSql($sWhere, $this->Id_Tel_SIM, FALSE); // Id_Tel_SIM
		$this->BuildSearchSql($sWhere, $this->Status_Venta, FALSE); // Status_Venta
		$this->BuildSearchSql($sWhere, $this->Con_SIM, FALSE); // Con_SIM

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Venta_Eq->AdvancedSearch->Save(); // Id_Venta_Eq
			$this->Id_Tienda->AdvancedSearch->Save(); // Id_Tienda
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
			$this->FechaVenta->AdvancedSearch->Save(); // FechaVenta
			$this->Cliente->AdvancedSearch->Save(); // Cliente
			$this->Id_Tel_SIM->AdvancedSearch->Save(); // Id_Tel_SIM
			$this->Status_Venta->AdvancedSearch->Save(); // Status_Venta
			$this->Con_SIM->AdvancedSearch->Save(); // Con_SIM
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
		$this->BuildBasicSearchSQL($sWhere, $this->Cliente, $Keyword);
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
		if ($this->Id_Venta_Eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tienda->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaVenta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tel_SIM->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Status_Venta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Con_SIM->AdvancedSearch->IssetSession())
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
		$this->Id_Venta_Eq->AdvancedSearch->UnsetSession();
		$this->Id_Tienda->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
		$this->FechaVenta->AdvancedSearch->UnsetSession();
		$this->Cliente->AdvancedSearch->UnsetSession();
		$this->Id_Tel_SIM->AdvancedSearch->UnsetSession();
		$this->Status_Venta->AdvancedSearch->UnsetSession();
		$this->Con_SIM->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Venta_Eq->AdvancedSearch->Load();
		$this->Id_Tienda->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->FechaVenta->AdvancedSearch->Load();
		$this->Cliente->AdvancedSearch->Load();
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Status_Venta->AdvancedSearch->Load();
		$this->Con_SIM->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Num_IMEI); // Num_IMEI
			$this->UpdateSort($this->FechaVenta); // FechaVenta
			$this->UpdateSort($this->Cliente); // Cliente
			$this->UpdateSort($this->Id_Tel_SIM); // Id_Tel_SIM
			$this->UpdateSort($this->Status_Venta); // Status_Venta
			$this->UpdateSort($this->Con_SIM); // Con_SIM
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
				$this->Num_IMEI->setSort("");
				$this->FechaVenta->setSort("");
				$this->Cliente->setSort("");
				$this->Id_Tel_SIM->setSort("");
				$this->Status_Venta->setSort("");
				$this->Con_SIM->setSort("");
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
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_cancelar_ventalist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Venta_Eq->CurrentValue) . "\">";
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
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->FechaVenta->CurrentValue = NULL;
		$this->FechaVenta->OldValue = $this->FechaVenta->CurrentValue;
		$this->Cliente->CurrentValue = NULL;
		$this->Cliente->OldValue = $this->Cliente->CurrentValue;
		$this->Id_Tel_SIM->CurrentValue = 0;
		$this->Status_Venta->CurrentValue = "Vendido";
		$this->Con_SIM->CurrentValue = "SI";
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
		// Id_Venta_Eq

		$this->Id_Venta_Eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Venta_Eq"]);
		if ($this->Id_Venta_Eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Venta_Eq->AdvancedSearch->SearchOperator = @$_GET["z_Id_Venta_Eq"];

		// Id_Tienda
		$this->Id_Tienda->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tienda"]);
		if ($this->Id_Tienda->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tienda->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tienda"];

		// Num_IMEI
		$this->Num_IMEI->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_IMEI"]);
		if ($this->Num_IMEI->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_IMEI->AdvancedSearch->SearchOperator = @$_GET["z_Num_IMEI"];

		// FechaVenta
		$this->FechaVenta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaVenta"]);
		if ($this->FechaVenta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaVenta->AdvancedSearch->SearchOperator = @$_GET["z_FechaVenta"];

		// Cliente
		$this->Cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cliente"]);
		if ($this->Cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cliente->AdvancedSearch->SearchOperator = @$_GET["z_Cliente"];

		// Id_Tel_SIM
		$this->Id_Tel_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tel_SIM"]);
		if ($this->Id_Tel_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tel_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tel_SIM"];

		// Status_Venta
		$this->Status_Venta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Status_Venta"]);
		if ($this->Status_Venta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Status_Venta->AdvancedSearch->SearchOperator = @$_GET["z_Status_Venta"];

		// Con_SIM
		$this->Con_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Con_SIM"]);
		if ($this->Con_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Con_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Con_SIM"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->FechaVenta->FldIsDetailKey) {
			$this->FechaVenta->setFormValue($objForm->GetValue("x_FechaVenta"));
			$this->FechaVenta->CurrentValue = ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7);
		}
		if (!$this->Cliente->FldIsDetailKey) {
			$this->Cliente->setFormValue($objForm->GetValue("x_Cliente"));
		}
		if (!$this->Id_Tel_SIM->FldIsDetailKey) {
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		}
		if (!$this->Status_Venta->FldIsDetailKey) {
			$this->Status_Venta->setFormValue($objForm->GetValue("x_Status_Venta"));
		}
		if (!$this->Con_SIM->FldIsDetailKey) {
			$this->Con_SIM->setFormValue($objForm->GetValue("x_Con_SIM"));
		}
		if (!$this->Id_Venta_Eq->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Venta_Eq->setFormValue($objForm->GetValue("x_Id_Venta_Eq"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Venta_Eq->CurrentValue = $this->Id_Venta_Eq->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->FechaVenta->CurrentValue = $this->FechaVenta->FormValue;
		$this->FechaVenta->CurrentValue = ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7);
		$this->Cliente->CurrentValue = $this->Cliente->FormValue;
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Status_Venta->CurrentValue = $this->Status_Venta->FormValue;
		$this->Con_SIM->CurrentValue = $this->Con_SIM->FormValue;
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
		$this->Id_Venta_Eq->setDbValue($rs->fields('Id_Venta_Eq'));
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->FechaVenta->setDbValue($rs->fields('FechaVenta'));
		$this->Cliente->setDbValue($rs->fields('Cliente'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Status_Venta->setDbValue($rs->fields('Status_Venta'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Venta_Eq")) <> "")
			$this->Id_Venta_Eq->CurrentValue = $this->getKey("Id_Venta_Eq"); // Id_Venta_Eq
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
		// Id_Venta_Eq

		$this->Id_Venta_Eq->CellCssStyle = "white-space: nowrap;";

		// Id_Tienda
		// Num_IMEI
		// FechaVenta
		// Cliente
		// Id_Tel_SIM
		// Status_Venta
		// Con_SIM

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// FechaVenta
			$this->FechaVenta->ViewValue = $this->FechaVenta->CurrentValue;
			$this->FechaVenta->ViewValue = ew_FormatDateTime($this->FechaVenta->ViewValue, 7);
			$this->FechaVenta->ViewCustomAttributes = "";

			// Cliente
			if (strval($this->Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`Cliente`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Cliente`, `Cliente` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_cancelar_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Id_Tienda`=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Cliente`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Cliente->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
				}
			} else {
				$this->Cliente->ViewValue = NULL;
			}
			$this->Cliente->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Status_Venta
			if (strval($this->Status_Venta->CurrentValue) <> "") {
				switch ($this->Status_Venta->CurrentValue) {
					case $this->Status_Venta->FldTagValue(1):
						$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(1) <> "" ? $this->Status_Venta->FldTagCaption(1) : $this->Status_Venta->CurrentValue;
						break;
					case $this->Status_Venta->FldTagValue(2):
						$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(2) <> "" ? $this->Status_Venta->FldTagCaption(2) : $this->Status_Venta->CurrentValue;
						break;
					case $this->Status_Venta->FldTagValue(3):
						$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(3) <> "" ? $this->Status_Venta->FldTagCaption(3) : $this->Status_Venta->CurrentValue;
						break;
					case $this->Status_Venta->FldTagValue(4):
						$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(4) <> "" ? $this->Status_Venta->FldTagCaption(4) : $this->Status_Venta->CurrentValue;
						break;
					default:
						$this->Status_Venta->ViewValue = $this->Status_Venta->CurrentValue;
				}
			} else {
				$this->Status_Venta->ViewValue = NULL;
			}
			$this->Status_Venta->ViewCustomAttributes = "";

			// Con_SIM
			if (strval($this->Con_SIM->CurrentValue) <> "") {
				switch ($this->Con_SIM->CurrentValue) {
					case $this->Con_SIM->FldTagValue(1):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(2):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(3):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(3) <> "" ? $this->Con_SIM->FldTagCaption(3) : $this->Con_SIM->CurrentValue;
						break;
					default:
						$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
				}
			} else {
				$this->Con_SIM->ViewValue = NULL;
			}
			$this->Con_SIM->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// FechaVenta
			$this->FechaVenta->LinkCustomAttributes = "";
			$this->FechaVenta->HrefValue = "";
			$this->FechaVenta->TooltipValue = "";

			// Cliente
			$this->Cliente->LinkCustomAttributes = "";
			$this->Cliente->HrefValue = "";
			$this->Cliente->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Status_Venta
			$this->Status_Venta->LinkCustomAttributes = "";
			$this->Status_Venta->HrefValue = "";
			$this->Status_Venta->TooltipValue = "";

			// Con_SIM
			$this->Con_SIM->LinkCustomAttributes = "";
			$this->Con_SIM->HrefValue = "";
			$this->Con_SIM->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// FechaVenta
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaVenta->CurrentValue, 7));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";

			// Status_Venta
			$this->Status_Venta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status_Venta->FldTagValue(1), $this->Status_Venta->FldTagCaption(1) <> "" ? $this->Status_Venta->FldTagCaption(1) : $this->Status_Venta->FldTagValue(1));
			$arwrk[] = array($this->Status_Venta->FldTagValue(2), $this->Status_Venta->FldTagCaption(2) <> "" ? $this->Status_Venta->FldTagCaption(2) : $this->Status_Venta->FldTagValue(2));
			$arwrk[] = array($this->Status_Venta->FldTagValue(3), $this->Status_Venta->FldTagCaption(3) <> "" ? $this->Status_Venta->FldTagCaption(3) : $this->Status_Venta->FldTagValue(3));
			$arwrk[] = array($this->Status_Venta->FldTagValue(4), $this->Status_Venta->FldTagCaption(4) <> "" ? $this->Status_Venta->FldTagCaption(4) : $this->Status_Venta->FldTagValue(4));
			$this->Status_Venta->EditValue = $arwrk;

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Con_SIM->FldTagValue(1), $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->FldTagValue(1));
			$arwrk[] = array($this->Con_SIM->FldTagValue(2), $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->FldTagValue(2));
			$arwrk[] = array($this->Con_SIM->FldTagValue(3), $this->Con_SIM->FldTagCaption(3) <> "" ? $this->Con_SIM->FldTagCaption(3) : $this->Con_SIM->FldTagValue(3));
			$this->Con_SIM->EditValue = $arwrk;

			// Edit refer script
			// Num_IMEI

			$this->Num_IMEI->HrefValue = "";

			// FechaVenta
			$this->FechaVenta->HrefValue = "";

			// Cliente
			$this->Cliente->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Status_Venta
			$this->Status_Venta->HrefValue = "";

			// Con_SIM
			$this->Con_SIM->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// FechaVenta
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue = $this->FechaVenta->CurrentValue;
			$this->FechaVenta->EditValue = ew_FormatDateTime($this->FechaVenta->EditValue, 7);
			$this->FechaVenta->ViewCustomAttributes = "";

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			if (strval($this->Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`Cliente`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Cliente`, `Cliente` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_cancelar_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Id_Tienda`=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Cliente`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Cliente->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Cliente->EditValue = $this->Cliente->CurrentValue;
				}
			} else {
				$this->Cliente->EditValue = NULL;
			}
			$this->Cliente->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->EditValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->EditValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->EditValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->EditValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Status_Venta
			$this->Status_Venta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status_Venta->FldTagValue(1), $this->Status_Venta->FldTagCaption(1) <> "" ? $this->Status_Venta->FldTagCaption(1) : $this->Status_Venta->FldTagValue(1));
			$arwrk[] = array($this->Status_Venta->FldTagValue(2), $this->Status_Venta->FldTagCaption(2) <> "" ? $this->Status_Venta->FldTagCaption(2) : $this->Status_Venta->FldTagValue(2));
			$arwrk[] = array($this->Status_Venta->FldTagValue(3), $this->Status_Venta->FldTagCaption(3) <> "" ? $this->Status_Venta->FldTagCaption(3) : $this->Status_Venta->FldTagValue(3));
			$arwrk[] = array($this->Status_Venta->FldTagValue(4), $this->Status_Venta->FldTagCaption(4) <> "" ? $this->Status_Venta->FldTagCaption(4) : $this->Status_Venta->FldTagValue(4));
			$this->Status_Venta->EditValue = $arwrk;

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			if (strval($this->Con_SIM->CurrentValue) <> "") {
				switch ($this->Con_SIM->CurrentValue) {
					case $this->Con_SIM->FldTagValue(1):
						$this->Con_SIM->EditValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(2):
						$this->Con_SIM->EditValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(3):
						$this->Con_SIM->EditValue = $this->Con_SIM->FldTagCaption(3) <> "" ? $this->Con_SIM->FldTagCaption(3) : $this->Con_SIM->CurrentValue;
						break;
					default:
						$this->Con_SIM->EditValue = $this->Con_SIM->CurrentValue;
				}
			} else {
				$this->Con_SIM->EditValue = NULL;
			}
			$this->Con_SIM->ViewCustomAttributes = "";

			// Edit refer script
			// Num_IMEI

			$this->Num_IMEI->HrefValue = "";

			// FechaVenta
			$this->FechaVenta->HrefValue = "";

			// Cliente
			$this->Cliente->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Status_Venta
			$this->Status_Venta->HrefValue = "";

			// Con_SIM
			$this->Con_SIM->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);

			// FechaVenta
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaVenta->AdvancedSearch->SearchValue, 7), 7));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Cliente`, `Cliente` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cap_cancelar_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Id_Tienda`=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Cliente`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Cliente->EditValue = $arwrk;

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";

			// Status_Venta
			$this->Status_Venta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status_Venta->FldTagValue(1), $this->Status_Venta->FldTagCaption(1) <> "" ? $this->Status_Venta->FldTagCaption(1) : $this->Status_Venta->FldTagValue(1));
			$arwrk[] = array($this->Status_Venta->FldTagValue(2), $this->Status_Venta->FldTagCaption(2) <> "" ? $this->Status_Venta->FldTagCaption(2) : $this->Status_Venta->FldTagValue(2));
			$arwrk[] = array($this->Status_Venta->FldTagValue(3), $this->Status_Venta->FldTagCaption(3) <> "" ? $this->Status_Venta->FldTagCaption(3) : $this->Status_Venta->FldTagValue(3));
			$arwrk[] = array($this->Status_Venta->FldTagValue(4), $this->Status_Venta->FldTagCaption(4) <> "" ? $this->Status_Venta->FldTagCaption(4) : $this->Status_Venta->FldTagValue(4));
			$this->Status_Venta->EditValue = $arwrk;

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Con_SIM->FldTagValue(1), $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->FldTagValue(1));
			$arwrk[] = array($this->Con_SIM->FldTagValue(2), $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->FldTagValue(2));
			$arwrk[] = array($this->Con_SIM->FldTagValue(3), $this->Con_SIM->FldTagCaption(3) <> "" ? $this->Con_SIM->FldTagCaption(3) : $this->Con_SIM->FldTagValue(3));
			$this->Con_SIM->EditValue = $arwrk;
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
		if (!ew_CheckEuroDate($this->FechaVenta->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->FechaVenta->FldErrMsg());
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
			if ($this->Num_IMEI->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Num_IMEI` = '" . ew_AdjustSql($this->Num_IMEI->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_IMEI->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_IMEI->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// Status_Venta
			$this->Status_Venta->SetDbValueDef($rsnew, $this->Status_Venta->CurrentValue, NULL, $this->Status_Venta->ReadOnly);

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
		if ($this->Num_IMEI->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Num_IMEI = '" . ew_AdjustSql($this->Num_IMEI->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_IMEI->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_IMEI->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
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

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, "", FALSE);

		// FechaVenta
		$this->FechaVenta->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Cliente
		$this->Cliente->SetDbValueDef($rsnew, $this->Cliente->CurrentValue, NULL, FALSE);

		// Id_Tel_SIM
		$this->Id_Tel_SIM->SetDbValueDef($rsnew, $this->Id_Tel_SIM->CurrentValue, 0, strval($this->Id_Tel_SIM->CurrentValue) == "");

		// Status_Venta
		$this->Status_Venta->SetDbValueDef($rsnew, $this->Status_Venta->CurrentValue, NULL, strval($this->Status_Venta->CurrentValue) == "");

		// Con_SIM
		$this->Con_SIM->SetDbValueDef($rsnew, $this->Con_SIM->CurrentValue, NULL, strval($this->Con_SIM->CurrentValue) == "");

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
			$this->Id_Venta_Eq->setDbValue($conn->Insert_ID());
			$rsnew['Id_Venta_Eq'] = $this->Id_Venta_Eq->DbValue;
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
		$this->Id_Venta_Eq->AdvancedSearch->Load();
		$this->Id_Tienda->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->FechaVenta->AdvancedSearch->Load();
		$this->Cliente->AdvancedSearch->Load();
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Status_Venta->AdvancedSearch->Load();
		$this->Con_SIM->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_cancelar_venta\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_cancelar_venta',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_cancelar_ventalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_cancelar_venta_list)) $cap_cancelar_venta_list = new ccap_cancelar_venta_list();

// Page init
$cap_cancelar_venta_list->Page_Init();

// Page main
$cap_cancelar_venta_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_cancelar_venta->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_cancelar_venta_list = new ew_Page("cap_cancelar_venta_list");
cap_cancelar_venta_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_cancelar_venta_list.PageID; // For backward compatibility

// Form object
var fcap_cancelar_ventalist = new ew_Form("fcap_cancelar_ventalist");

// Validate form
fcap_cancelar_ventalist.Validate = function(fobj) {
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
fcap_cancelar_ventalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_cancelar_ventalist.ValidateRequired = true;
<?php } else { ?>
fcap_cancelar_ventalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_cancelar_ventalist.Lists["x_Cliente"] = {"LinkField":"x_Cliente","Ajax":null,"AutoFill":false,"DisplayFields":["x_Cliente","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_cancelar_ventalist.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_cancelar_ventalistsrch = new ew_Form("fcap_cancelar_ventalistsrch");

// Validate function for search
fcap_cancelar_ventalistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = fobj.elements["x" + infix + "_FechaVenta"];
	if (elm && !ew_CheckEuroDate(elm.value))
		return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_cancelar_venta->FechaVenta->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj, infix);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fcap_cancelar_ventalistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_cancelar_ventalistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_cancelar_ventalistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_cancelar_ventalistsrch.Lists["x_Cliente"] = {"LinkField":"x_Cliente","Ajax":null,"AutoFill":false,"DisplayFields":["x_Cliente","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		$cap_cancelar_venta_list->TotalRecs = $cap_cancelar_venta->SelectRecordCount();
	} else {
		if ($cap_cancelar_venta_list->Recordset = $cap_cancelar_venta_list->LoadRecordset())
			$cap_cancelar_venta_list->TotalRecs = $cap_cancelar_venta_list->Recordset->RecordCount();
	}
	$cap_cancelar_venta_list->StartRec = 1;
	if ($cap_cancelar_venta_list->DisplayRecs <= 0 || ($cap_cancelar_venta->Export <> "" && $cap_cancelar_venta->ExportAll)) // Display all records
		$cap_cancelar_venta_list->DisplayRecs = $cap_cancelar_venta_list->TotalRecs;
	if (!($cap_cancelar_venta->Export <> "" && $cap_cancelar_venta->ExportAll))
		$cap_cancelar_venta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_cancelar_venta_list->Recordset = $cap_cancelar_venta_list->LoadRecordset($cap_cancelar_venta_list->StartRec-1, $cap_cancelar_venta_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_cancelar_venta->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_cancelar_venta_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_cancelar_venta->Export == "" && $cap_cancelar_venta->CurrentAction == "") { ?>
<form name="fcap_cancelar_ventalistsrch" id="fcap_cancelar_ventalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_cancelar_ventalistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_cancelar_ventalistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_cancelar_ventalistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_cancelar_venta">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_cancelar_venta_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_cancelar_venta->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_cancelar_venta->ResetAttrs();
$cap_cancelar_venta_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_cancelar_venta->Num_IMEI->Visible) { // Num_IMEI ?>
	<span id="xsc_Num_IMEI" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_cancelar_venta->Num_IMEI->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Num_IMEI" id="z_Num_IMEI" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" name="x_Num_IMEI" id="x_Num_IMEI" size="30" maxlength="16" value="<?php echo $cap_cancelar_venta->Num_IMEI->EditValue ?>"<?php echo $cap_cancelar_venta->Num_IMEI->EditAttributes() ?>>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_cancelar_venta->FechaVenta->Visible) { // FechaVenta ?>
	<span id="xsc_FechaVenta" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_cancelar_venta->FechaVenta->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_FechaVenta" id="z_FechaVenta" value="="></span>
		<span class="ewSearchField">
<input type="text" name="x_FechaVenta" id="x_FechaVenta" value="<?php echo $cap_cancelar_venta->FechaVenta->EditValue ?>"<?php echo $cap_cancelar_venta->FechaVenta->EditAttributes() ?>>
<?php if (!$cap_cancelar_venta->FechaVenta->ReadOnly && !$cap_cancelar_venta->FechaVenta->Disabled && @$cap_cancelar_venta->FechaVenta->EditAttrs["readonly"] == "" && @$cap_cancelar_venta->FechaVenta->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_cancelar_ventalistsrch$x_FechaVenta$" name="fcap_cancelar_ventalistsrch$x_FechaVenta$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_cancelar_ventalistsrch", "x_FechaVenta", "%d/%m/%Y");
</script>
<?php } ?>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_cancelar_venta->Cliente->Visible) { // Cliente ?>
	<span id="xsc_Cliente" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_cancelar_venta->Cliente->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cliente" id="z_Cliente" value="="></span>
		<span class="ewSearchField">
<select id="x_Cliente" name="x_Cliente"<?php echo $cap_cancelar_venta->Cliente->EditAttributes() ?>>
<?php
if (is_array($cap_cancelar_venta->Cliente->EditValue)) {
	$arwrk = $cap_cancelar_venta->Cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cancelar_venta->Cliente->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_cancelar_ventalistsrch.Lists["x_Cliente"].Options = <?php echo (is_array($cap_cancelar_venta->Cliente->EditValue)) ? ew_ArrayToJson($cap_cancelar_venta->Cliente->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
<?php if ($cap_cancelar_venta->Con_SIM->Visible) { // Con_SIM ?>
	<span id="xsc_Con_SIM" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_cancelar_venta->Con_SIM->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Con_SIM" id="z_Con_SIM" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Con_SIM" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Con_SIM" id="x_Con_SIM" value="{value}"<?php echo $cap_cancelar_venta->Con_SIM->EditAttributes() ?>></div>
<div id="dsl_x_Con_SIM" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_cancelar_venta->Con_SIM->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cancelar_venta->Con_SIM->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Con_SIM" id="x_Con_SIM" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_cancelar_venta->Con_SIM->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
<div id="xsr_5" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_cancelar_venta_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_6" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_cancelar_venta_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_cancelar_venta_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_cancelar_venta_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_cancelar_venta_list->ShowPageHeader(); ?>
<?php
$cap_cancelar_venta_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_cancelar_venta->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_cancelar_venta->CurrentAction <> "gridadd" && $cap_cancelar_venta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_cancelar_venta_list->Pager)) $cap_cancelar_venta_list->Pager = new cPrevNextPager($cap_cancelar_venta_list->StartRec, $cap_cancelar_venta_list->DisplayRecs, $cap_cancelar_venta_list->TotalRecs) ?>
<?php if ($cap_cancelar_venta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_cancelar_venta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_cancelar_venta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_cancelar_venta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_cancelar_venta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_cancelar_venta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_cancelar_venta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_cancelar_venta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_cancelar_venta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_cancelar_venta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_cancelar_venta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_cancelar_venta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_cancelar_venta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_cancelar_venta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<form name="fcap_cancelar_ventalist" id="fcap_cancelar_ventalist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_cancelar_venta">
<div id="gmp_cap_cancelar_venta" class="ewGridMiddlePanel">
<?php if ($cap_cancelar_venta_list->TotalRecs > 0) { ?>
<table id="tbl_cap_cancelar_ventalist" class="ewTable ewTableSeparate">
<?php echo $cap_cancelar_venta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_cancelar_venta_list->RenderListOptions();

// Render list options (header, left)
$cap_cancelar_venta_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_cancelar_venta->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_Num_IMEI" class="cap_cancelar_venta_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->Num_IMEI) ?>',1);"><span id="elh_cap_cancelar_venta_Num_IMEI" class="cap_cancelar_venta_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cancelar_venta->FechaVenta->Visible) { // FechaVenta ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->FechaVenta) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_FechaVenta" class="cap_cancelar_venta_FechaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->FechaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->FechaVenta) ?>',1);"><span id="elh_cap_cancelar_venta_FechaVenta" class="cap_cancelar_venta_FechaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->FechaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->FechaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->FechaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cancelar_venta->Cliente->Visible) { // Cliente ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->Cliente) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_Cliente" class="cap_cancelar_venta_Cliente"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->Cliente->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->Cliente) ?>',1);"><span id="elh_cap_cancelar_venta_Cliente" class="cap_cancelar_venta_Cliente">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->Cliente->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->Cliente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->Cliente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cancelar_venta->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_Id_Tel_SIM" class="cap_cancelar_venta_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->Id_Tel_SIM) ?>',1);"><span id="elh_cap_cancelar_venta_Id_Tel_SIM" class="cap_cancelar_venta_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cancelar_venta->Status_Venta->Visible) { // Status_Venta ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->Status_Venta) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_Status_Venta" class="cap_cancelar_venta_Status_Venta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->Status_Venta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->Status_Venta) ?>',1);"><span id="elh_cap_cancelar_venta_Status_Venta" class="cap_cancelar_venta_Status_Venta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->Status_Venta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->Status_Venta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->Status_Venta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_cancelar_venta->Con_SIM->Visible) { // Con_SIM ?>
	<?php if ($cap_cancelar_venta->SortUrl($cap_cancelar_venta->Con_SIM) == "") { ?>
		<td><span id="elh_cap_cancelar_venta_Con_SIM" class="cap_cancelar_venta_Con_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_cancelar_venta->Con_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_cancelar_venta->SortUrl($cap_cancelar_venta->Con_SIM) ?>',1);"><span id="elh_cap_cancelar_venta_Con_SIM" class="cap_cancelar_venta_Con_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_cancelar_venta->Con_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_cancelar_venta->Con_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_cancelar_venta->Con_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_cancelar_venta_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_cancelar_venta->ExportAll && $cap_cancelar_venta->Export <> "") {
	$cap_cancelar_venta_list->StopRec = $cap_cancelar_venta_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_cancelar_venta_list->TotalRecs > $cap_cancelar_venta_list->StartRec + $cap_cancelar_venta_list->DisplayRecs - 1)
		$cap_cancelar_venta_list->StopRec = $cap_cancelar_venta_list->StartRec + $cap_cancelar_venta_list->DisplayRecs - 1;
	else
		$cap_cancelar_venta_list->StopRec = $cap_cancelar_venta_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_cancelar_venta->CurrentAction == "gridadd" || $cap_cancelar_venta->CurrentAction == "gridedit" || $cap_cancelar_venta->CurrentAction == "F")) {
		$cap_cancelar_venta_list->KeyCount = $objForm->GetValue("key_count");
		$cap_cancelar_venta_list->StopRec = $cap_cancelar_venta_list->KeyCount;
	}
}
$cap_cancelar_venta_list->RecCnt = $cap_cancelar_venta_list->StartRec - 1;
if ($cap_cancelar_venta_list->Recordset && !$cap_cancelar_venta_list->Recordset->EOF) {
	$cap_cancelar_venta_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_cancelar_venta_list->StartRec > 1)
		$cap_cancelar_venta_list->Recordset->Move($cap_cancelar_venta_list->StartRec - 1);
} elseif (!$cap_cancelar_venta->AllowAddDeleteRow && $cap_cancelar_venta_list->StopRec == 0) {
	$cap_cancelar_venta_list->StopRec = $cap_cancelar_venta->GridAddRowCount;
}

// Initialize aggregate
$cap_cancelar_venta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_cancelar_venta->ResetAttrs();
$cap_cancelar_venta_list->RenderRow();
$cap_cancelar_venta_list->EditRowCnt = 0;
if ($cap_cancelar_venta->CurrentAction == "edit")
	$cap_cancelar_venta_list->RowIndex = 1;
while ($cap_cancelar_venta_list->RecCnt < $cap_cancelar_venta_list->StopRec) {
	$cap_cancelar_venta_list->RecCnt++;
	if (intval($cap_cancelar_venta_list->RecCnt) >= intval($cap_cancelar_venta_list->StartRec)) {
		$cap_cancelar_venta_list->RowCnt++;

		// Set up key count
		$cap_cancelar_venta_list->KeyCount = $cap_cancelar_venta_list->RowIndex;

		// Init row class and style
		$cap_cancelar_venta->ResetAttrs();
		$cap_cancelar_venta->CssClass = "";
		if ($cap_cancelar_venta->CurrentAction == "gridadd") {
			$cap_cancelar_venta_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_cancelar_venta_list->LoadRowValues($cap_cancelar_venta_list->Recordset); // Load row values
		}
		$cap_cancelar_venta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_cancelar_venta->CurrentAction == "edit") {
			if ($cap_cancelar_venta_list->CheckInlineEditKey() && $cap_cancelar_venta_list->EditRowCnt == 0) { // Inline edit
				$cap_cancelar_venta->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_cancelar_venta->CurrentAction == "edit" && $cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT && $cap_cancelar_venta->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_cancelar_venta_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_cancelar_venta_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_cancelar_venta->RowAttrs = array_merge($cap_cancelar_venta->RowAttrs, array('data-rowindex'=>$cap_cancelar_venta_list->RowCnt, 'id'=>'r' . $cap_cancelar_venta_list->RowCnt . '_cap_cancelar_venta', 'data-rowtype'=>$cap_cancelar_venta->RowType));

		// Render row
		$cap_cancelar_venta_list->RenderRow();

		// Render list options
		$cap_cancelar_venta_list->RenderListOptions();
?>
	<tr<?php echo $cap_cancelar_venta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_cancelar_venta_list->ListOptions->Render("body", "left", $cap_cancelar_venta_list->RowCnt);
?>
	<?php if ($cap_cancelar_venta->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_cancelar_venta->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_Num_IMEI" class="cap_cancelar_venta_Num_IMEI">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_cancelar_venta->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Num_IMEI->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->Num_IMEI->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Num_IMEI->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT || $cap_cancelar_venta->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Id_Venta_Eq" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->Id_Venta_Eq->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_cancelar_venta->FechaVenta->Visible) { // FechaVenta ?>
		<td<?php echo $cap_cancelar_venta->FechaVenta->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_FechaVenta" class="cap_cancelar_venta_FechaVenta">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_cancelar_venta->FechaVenta->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->FechaVenta->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_FechaVenta" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_FechaVenta" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->FechaVenta->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->FechaVenta->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->FechaVenta->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cancelar_venta->Cliente->Visible) { // Cliente ?>
		<td<?php echo $cap_cancelar_venta->Cliente->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_Cliente" class="cap_cancelar_venta_Cliente">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_cancelar_venta->Cliente->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Cliente->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Cliente" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Cliente" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->Cliente->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->Cliente->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Cliente->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cancelar_venta->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_cancelar_venta->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_Id_Tel_SIM" class="cap_cancelar_venta_Id_Tel_SIM">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_cancelar_venta->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Id_Tel_SIM->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Id_Tel_SIM" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->Id_Tel_SIM->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Id_Tel_SIM->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cancelar_venta->Status_Venta->Visible) { // Status_Venta ?>
		<td<?php echo $cap_cancelar_venta->Status_Venta->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_Status_Venta" class="cap_cancelar_venta_Status_Venta">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" value="{value}"<?php echo $cap_cancelar_venta->Status_Venta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_cancelar_venta->Status_Venta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cancelar_venta->Status_Venta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Status_Venta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_cancelar_venta->Status_Venta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->Status_Venta->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Status_Venta->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_cancelar_venta->Con_SIM->Visible) { // Con_SIM ?>
		<td<?php echo $cap_cancelar_venta->Con_SIM->CellAttributes() ?>><span id="el<?php echo $cap_cancelar_venta_list->RowCnt ?>_cap_cancelar_venta_Con_SIM" class="cap_cancelar_venta_Con_SIM">
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_cancelar_venta->Con_SIM->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Con_SIM->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Con_SIM" id="x<?php echo $cap_cancelar_venta_list->RowIndex ?>_Con_SIM" value="<?php echo ew_HtmlEncode($cap_cancelar_venta->Con_SIM->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_cancelar_venta->Con_SIM->ViewAttributes() ?>>
<?php echo $cap_cancelar_venta->Con_SIM->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_cancelar_venta_list->PageObjName . "_row_" . $cap_cancelar_venta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_cancelar_venta_list->ListOptions->Render("body", "right", $cap_cancelar_venta_list->RowCnt);
?>
	</tr>
<?php if ($cap_cancelar_venta->RowType == EW_ROWTYPE_ADD || $cap_cancelar_venta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_cancelar_ventalist.UpdateOpts(<?php echo $cap_cancelar_venta_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_cancelar_venta->CurrentAction <> "gridadd")
		$cap_cancelar_venta_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_cancelar_venta->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_cancelar_venta_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_cancelar_venta->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_cancelar_venta_list->Recordset)
	$cap_cancelar_venta_list->Recordset->Close();
?>
<?php if ($cap_cancelar_venta_list->TotalRecs > 0) { ?>
<?php if ($cap_cancelar_venta->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_cancelar_venta->CurrentAction <> "gridadd" && $cap_cancelar_venta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_cancelar_venta_list->Pager)) $cap_cancelar_venta_list->Pager = new cPrevNextPager($cap_cancelar_venta_list->StartRec, $cap_cancelar_venta_list->DisplayRecs, $cap_cancelar_venta_list->TotalRecs) ?>
<?php if ($cap_cancelar_venta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_cancelar_venta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_cancelar_venta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_cancelar_venta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_cancelar_venta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_cancelar_venta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_cancelar_venta_list->PageUrl() ?>start=<?php echo $cap_cancelar_venta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_cancelar_venta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_cancelar_venta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_cancelar_venta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_cancelar_venta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_cancelar_venta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_cancelar_venta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_cancelar_venta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_cancelar_venta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_cancelar_venta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<?php if ($cap_cancelar_venta->Export == "") { ?>
<script type="text/javascript">
fcap_cancelar_ventalistsrch.Init();
fcap_cancelar_ventalist.Init();
</script>
<?php } ?>
<?php
$cap_cancelar_venta_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_cancelar_venta->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_cancelar_venta_list->Page_Terminate();
?>
