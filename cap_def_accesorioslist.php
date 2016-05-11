<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_def_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_def_accesorios_list = NULL; // Initialize page object first

class ccap_def_accesorios_list extends ccap_def_accesorios {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_def_accesorios';

	// Page object name
	var $PageObjName = 'cap_def_accesorios_list';

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

		// Table object (cap_def_accesorios)
		if (!isset($GLOBALS["cap_def_accesorios"])) {
			$GLOBALS["cap_def_accesorios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_def_accesorios"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_def_accesoriosadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_def_accesoriosdelete.php";
		$this->MultiUpdateUrl = "cap_def_accesoriosupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_def_accesorios', TRUE);

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

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
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

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["Id_Articulo"] <> "") {
				$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);
				$this->setKey("Id_Articulo", $this->Id_Articulo->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Articulo", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
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
		$this->BuildSearchSql($sWhere, $this->COD_Fam_Accesorio, FALSE); // COD_Fam_Accesorio
		$this->BuildSearchSql($sWhere, $this->COD_Marca_acc, FALSE); // COD_Marca_acc
		$this->BuildSearchSql($sWhere, $this->COD_Acabado_acc, FALSE); // COD_Acabado_acc
		$this->BuildSearchSql($sWhere, $this->COD_Tipo_acc, FALSE); // COD_Tipo_acc
		$this->BuildSearchSql($sWhere, $this->COD_Equipo_acc, FALSE); // COD_Equipo_acc
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo
		$this->BuildSearchSql($sWhere, $this->Articulo, FALSE); // Articulo
		$this->BuildSearchSql($sWhere, $this->BarCode_Externo, FALSE); // BarCode_Externo
		$this->BuildSearchSql($sWhere, $this->Id_Almacen_Entrada, FALSE); // Id_Almacen_Entrada

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->COD_Fam_Accesorio->AdvancedSearch->Save(); // COD_Fam_Accesorio
			$this->COD_Marca_acc->AdvancedSearch->Save(); // COD_Marca_acc
			$this->COD_Acabado_acc->AdvancedSearch->Save(); // COD_Acabado_acc
			$this->COD_Tipo_acc->AdvancedSearch->Save(); // COD_Tipo_acc
			$this->COD_Equipo_acc->AdvancedSearch->Save(); // COD_Equipo_acc
			$this->Codigo->AdvancedSearch->Save(); // Codigo
			$this->Articulo->AdvancedSearch->Save(); // Articulo
			$this->BarCode_Externo->AdvancedSearch->Save(); // BarCode_Externo
			$this->Id_Almacen_Entrada->AdvancedSearch->Save(); // Id_Almacen_Entrada
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
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Fam_Accesorio, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Marca_acc, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Acabado_acc, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Tipo_acc, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Equipo_acc, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Articulo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->BarCode_Externo, $Keyword);
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
		if ($this->COD_Fam_Accesorio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Marca_acc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Acabado_acc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Tipo_acc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Equipo_acc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->BarCode_Externo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Almacen_Entrada->AdvancedSearch->IssetSession())
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
		$this->COD_Fam_Accesorio->AdvancedSearch->UnsetSession();
		$this->COD_Marca_acc->AdvancedSearch->UnsetSession();
		$this->COD_Acabado_acc->AdvancedSearch->UnsetSession();
		$this->COD_Tipo_acc->AdvancedSearch->UnsetSession();
		$this->COD_Equipo_acc->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
		$this->Articulo->AdvancedSearch->UnsetSession();
		$this->BarCode_Externo->AdvancedSearch->UnsetSession();
		$this->Id_Almacen_Entrada->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->COD_Fam_Accesorio->AdvancedSearch->Load();
		$this->COD_Marca_acc->AdvancedSearch->Load();
		$this->COD_Acabado_acc->AdvancedSearch->Load();
		$this->COD_Tipo_acc->AdvancedSearch->Load();
		$this->COD_Equipo_acc->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->BarCode_Externo->AdvancedSearch->Load();
		$this->Id_Almacen_Entrada->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->COD_Fam_Accesorio, $bCtrl); // COD_Fam_Accesorio
			$this->UpdateSort($this->COD_Marca_acc, $bCtrl); // COD_Marca_acc
			$this->UpdateSort($this->COD_Acabado_acc, $bCtrl); // COD_Acabado_acc
			$this->UpdateSort($this->COD_Tipo_acc, $bCtrl); // COD_Tipo_acc
			$this->UpdateSort($this->COD_Equipo_acc, $bCtrl); // COD_Equipo_acc
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->Articulo, $bCtrl); // Articulo
			$this->UpdateSort($this->BarCode_Externo, $bCtrl); // BarCode_Externo
			$this->UpdateSort($this->Id_Almacen_Entrada, $bCtrl); // Id_Almacen_Entrada
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
				$this->setSessionOrderByList($sOrderBy);
				$this->COD_Fam_Accesorio->setSort("");
				$this->COD_Marca_acc->setSort("");
				$this->COD_Acabado_acc->setSort("");
				$this->COD_Tipo_acc->setSort("");
				$this->COD_Equipo_acc->setSort("");
				$this->Codigo->setSort("");
				$this->Articulo->setSort("");
				$this->BarCode_Externo->setSort("");
				$this->Id_Almacen_Entrada->setSort("");
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

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
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

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_def_accesorioslist'].Submit();\">" . "<img src=\"phpimages/insert.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
				"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_def_accesorioslist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Articulo->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->CopyUrl . "\">" . "<img src=\"phpimages/copy.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CopyLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CopyLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . $this->InlineCopyUrl . "\">" . "<img src=\"phpimages/inlinecopy.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineCopyLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineCopyLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink\"" . "" . " href=\"" . $this->DeleteUrl . "\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		$this->COD_Fam_Accesorio->CurrentValue = NULL;
		$this->COD_Fam_Accesorio->OldValue = $this->COD_Fam_Accesorio->CurrentValue;
		$this->COD_Marca_acc->CurrentValue = NULL;
		$this->COD_Marca_acc->OldValue = $this->COD_Marca_acc->CurrentValue;
		$this->COD_Acabado_acc->CurrentValue = NULL;
		$this->COD_Acabado_acc->OldValue = $this->COD_Acabado_acc->CurrentValue;
		$this->COD_Tipo_acc->CurrentValue = NULL;
		$this->COD_Tipo_acc->OldValue = $this->COD_Tipo_acc->CurrentValue;
		$this->COD_Equipo_acc->CurrentValue = NULL;
		$this->COD_Equipo_acc->OldValue = $this->COD_Equipo_acc->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->BarCode_Externo->CurrentValue = NULL;
		$this->BarCode_Externo->OldValue = $this->BarCode_Externo->CurrentValue;
		$this->Id_Almacen_Entrada->CurrentValue = 1;
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

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Fam_Accesorio"]);
		if ($this->COD_Fam_Accesorio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Fam_Accesorio->AdvancedSearch->SearchOperator = @$_GET["z_COD_Fam_Accesorio"];

		// COD_Marca_acc
		$this->COD_Marca_acc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Marca_acc"]);
		if ($this->COD_Marca_acc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Marca_acc->AdvancedSearch->SearchOperator = @$_GET["z_COD_Marca_acc"];

		// COD_Acabado_acc
		$this->COD_Acabado_acc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Acabado_acc"]);
		if ($this->COD_Acabado_acc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Acabado_acc->AdvancedSearch->SearchOperator = @$_GET["z_COD_Acabado_acc"];

		// COD_Tipo_acc
		$this->COD_Tipo_acc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Tipo_acc"]);
		if ($this->COD_Tipo_acc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Tipo_acc->AdvancedSearch->SearchOperator = @$_GET["z_COD_Tipo_acc"];

		// COD_Equipo_acc
		$this->COD_Equipo_acc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Equipo_acc"]);
		if ($this->COD_Equipo_acc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Equipo_acc->AdvancedSearch->SearchOperator = @$_GET["z_COD_Equipo_acc"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];

		// Articulo
		$this->Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Articulo"]);
		if ($this->Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Articulo"];

		// BarCode_Externo
		$this->BarCode_Externo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_BarCode_Externo"]);
		if ($this->BarCode_Externo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->BarCode_Externo->AdvancedSearch->SearchOperator = @$_GET["z_BarCode_Externo"];

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Almacen_Entrada"]);
		if ($this->Id_Almacen_Entrada->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Almacen_Entrada->AdvancedSearch->SearchOperator = @$_GET["z_Id_Almacen_Entrada"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->COD_Fam_Accesorio->FldIsDetailKey) {
			$this->COD_Fam_Accesorio->setFormValue($objForm->GetValue("x_COD_Fam_Accesorio"));
		}
		if (!$this->COD_Marca_acc->FldIsDetailKey) {
			$this->COD_Marca_acc->setFormValue($objForm->GetValue("x_COD_Marca_acc"));
		}
		if (!$this->COD_Acabado_acc->FldIsDetailKey) {
			$this->COD_Acabado_acc->setFormValue($objForm->GetValue("x_COD_Acabado_acc"));
		}
		if (!$this->COD_Tipo_acc->FldIsDetailKey) {
			$this->COD_Tipo_acc->setFormValue($objForm->GetValue("x_COD_Tipo_acc"));
		}
		if (!$this->COD_Equipo_acc->FldIsDetailKey) {
			$this->COD_Equipo_acc->setFormValue($objForm->GetValue("x_COD_Equipo_acc"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->BarCode_Externo->FldIsDetailKey) {
			$this->BarCode_Externo->setFormValue($objForm->GetValue("x_BarCode_Externo"));
		}
		if (!$this->Id_Almacen_Entrada->FldIsDetailKey) {
			$this->Id_Almacen_Entrada->setFormValue($objForm->GetValue("x_Id_Almacen_Entrada"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->COD_Fam_Accesorio->CurrentValue = $this->COD_Fam_Accesorio->FormValue;
		$this->COD_Marca_acc->CurrentValue = $this->COD_Marca_acc->FormValue;
		$this->COD_Acabado_acc->CurrentValue = $this->COD_Acabado_acc->FormValue;
		$this->COD_Tipo_acc->CurrentValue = $this->COD_Tipo_acc->FormValue;
		$this->COD_Equipo_acc->CurrentValue = $this->COD_Equipo_acc->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->BarCode_Externo->CurrentValue = $this->BarCode_Externo->FormValue;
		$this->Id_Almacen_Entrada->CurrentValue = $this->Id_Almacen_Entrada->FormValue;
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
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->COD_Marca_acc->setDbValue($rs->fields('COD_Marca_acc'));
		$this->COD_Acabado_acc->setDbValue($rs->fields('COD_Acabado_acc'));
		$this->COD_Tipo_acc->setDbValue($rs->fields('COD_Tipo_acc'));
		$this->COD_Equipo_acc->setDbValue($rs->fields('COD_Equipo_acc'));
		if (array_key_exists('EV__COD_Equipo_acc', $rs->fields)) {
			$this->COD_Equipo_acc->VirtualValue = $rs->fields('EV__COD_Equipo_acc'); // Set up virtual field value
		} else {
			$this->COD_Equipo_acc->VirtualValue = ""; // Clear value
		}
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->BarCode_Externo->setDbValue($rs->fields('BarCode_Externo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
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

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

		// COD_Fam_Accesorio
		// COD_Marca_acc
		// COD_Acabado_acc
		// COD_Tipo_acc
		// COD_Equipo_acc
		// Codigo
		// Articulo
		// BarCode_Externo
		// Id_Almacen_Entrada

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// COD_Fam_Accesorio
			if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Fam_Accesorio->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Fam_Accesorio->ViewValue = $this->COD_Fam_Accesorio->CurrentValue;
				}
			} else {
				$this->COD_Fam_Accesorio->ViewValue = NULL;
			}
			$this->COD_Fam_Accesorio->ViewCustomAttributes = "";

			// COD_Marca_acc
			if (strval($this->COD_Marca_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_acc`" . ew_SearchString("=", $this->COD_Marca_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_acc->ViewValue = $this->COD_Marca_acc->CurrentValue;
				}
			} else {
				$this->COD_Marca_acc->ViewValue = NULL;
			}
			$this->COD_Marca_acc->ViewCustomAttributes = "";

			// COD_Acabado_acc
			if (strval($this->COD_Acabado_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Acabado_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Acabado_acc->ViewValue = $this->COD_Acabado_acc->CurrentValue;
				}
			} else {
				$this->COD_Acabado_acc->ViewValue = NULL;
			}
			$this->COD_Acabado_acc->ViewCustomAttributes = "";

			// COD_Tipo_acc
			if (strval($this->COD_Tipo_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Tipo_acc`" . ew_SearchString("=", $this->COD_Tipo_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Tipo_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Tipo_acc->ViewValue = $this->COD_Tipo_acc->CurrentValue;
				}
			} else {
				$this->COD_Tipo_acc->ViewValue = NULL;
			}
			$this->COD_Tipo_acc->ViewCustomAttributes = "";

			// COD_Equipo_acc
			if ($this->COD_Equipo_acc->VirtualValue <> "") {
				$this->COD_Equipo_acc->ViewValue = $this->COD_Equipo_acc->VirtualValue;
			} else {
			if (strval($this->COD_Equipo_acc->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Equipo_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Equipo_acc->ViewValue = $this->COD_Equipo_acc->CurrentValue;
				}
			} else {
				$this->COD_Equipo_acc->ViewValue = NULL;
			}
			}
			$this->COD_Equipo_acc->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// BarCode_Externo
			$this->BarCode_Externo->ViewValue = $this->BarCode_Externo->CurrentValue;
			$this->BarCode_Externo->ViewCustomAttributes = "";

			// Id_Almacen_Entrada
			if (strval($this->Id_Almacen_Entrada->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrada->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Entrada->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Entrada->ViewValue = $this->Id_Almacen_Entrada->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Entrada->ViewValue = NULL;
			}
			$this->Id_Almacen_Entrada->ViewCustomAttributes = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->LinkCustomAttributes = "";
			$this->COD_Fam_Accesorio->HrefValue = "";
			$this->COD_Fam_Accesorio->TooltipValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->LinkCustomAttributes = "";
			$this->COD_Marca_acc->HrefValue = "";
			$this->COD_Marca_acc->TooltipValue = "";

			// COD_Acabado_acc
			$this->COD_Acabado_acc->LinkCustomAttributes = "";
			$this->COD_Acabado_acc->HrefValue = "";
			$this->COD_Acabado_acc->TooltipValue = "";

			// COD_Tipo_acc
			$this->COD_Tipo_acc->LinkCustomAttributes = "";
			$this->COD_Tipo_acc->HrefValue = "";
			$this->COD_Tipo_acc->TooltipValue = "";

			// COD_Equipo_acc
			$this->COD_Equipo_acc->LinkCustomAttributes = "";
			$this->COD_Equipo_acc->HrefValue = "";
			$this->COD_Equipo_acc->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// BarCode_Externo
			$this->BarCode_Externo->LinkCustomAttributes = "";
			$this->BarCode_Externo->HrefValue = "";
			$this->BarCode_Externo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Fam_Accesorio->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_acc->EditValue = $arwrk;

			// COD_Acabado_acc
			$this->COD_Acabado_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Acabado_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Acabado_acc->EditValue = $arwrk;

			// COD_Tipo_acc
			$this->COD_Tipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Tipo_acc->EditValue = $arwrk;

			// COD_Equipo_acc
			$this->COD_Equipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Equipo_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Equipo_acc->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			$this->BarCode_Externo->EditValue = ew_HtmlEncode($this->BarCode_Externo->CurrentValue);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
			$sFilterWrk = "";
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
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Edit refer script
			// COD_Fam_Accesorio

			$this->COD_Fam_Accesorio->HrefValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->HrefValue = "";

			// COD_Acabado_acc
			$this->COD_Acabado_acc->HrefValue = "";

			// COD_Tipo_acc
			$this->COD_Tipo_acc->HrefValue = "";

			// COD_Equipo_acc
			$this->COD_Equipo_acc->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// BarCode_Externo
			$this->BarCode_Externo->HrefValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Fam_Accesorio->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_acc->EditValue = $arwrk;

			// COD_Acabado_acc
			$this->COD_Acabado_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Acabado_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Acabado_acc->EditValue = $arwrk;

			// COD_Tipo_acc
			$this->COD_Tipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Tipo_acc->EditValue = $arwrk;

			// COD_Equipo_acc
			$this->COD_Equipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Equipo_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Equipo_acc->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			$this->BarCode_Externo->EditValue = ew_HtmlEncode($this->BarCode_Externo->CurrentValue);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
			$sFilterWrk = "";
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
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Edit refer script
			// COD_Fam_Accesorio

			$this->COD_Fam_Accesorio->HrefValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->HrefValue = "";

			// COD_Acabado_acc
			$this->COD_Acabado_acc->HrefValue = "";

			// COD_Tipo_acc
			$this->COD_Tipo_acc->HrefValue = "";

			// COD_Equipo_acc
			$this->COD_Equipo_acc->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// BarCode_Externo
			$this->BarCode_Externo->HrefValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Fam_Accesorio->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->AdvancedSearch->SearchValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_acc->EditValue = $arwrk;

			// COD_Acabado_acc
			$this->COD_Acabado_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Acabado_acc->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->AdvancedSearch->SearchValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Acabado_acc->EditValue = $arwrk;

			// COD_Tipo_acc
			$this->COD_Tipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Tipo_acc->EditValue = $arwrk;

			// COD_Equipo_acc
			$this->COD_Equipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Equipo_acc->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->AdvancedSearch->SearchValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Equipo_acc->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->AdvancedSearch->SearchValue);

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->AdvancedSearch->SearchValue);

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			$this->BarCode_Externo->EditValue = ew_HtmlEncode($this->BarCode_Externo->AdvancedSearch->SearchValue);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
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
		if (!is_null($this->COD_Fam_Accesorio->FormValue) && $this->COD_Fam_Accesorio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Fam_Accesorio->FldCaption());
		}
		if (!is_null($this->COD_Marca_acc->FormValue) && $this->COD_Marca_acc->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Marca_acc->FldCaption());
		}
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
		}
		if (!is_null($this->Id_Almacen_Entrada->FormValue) && $this->Id_Almacen_Entrada->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Almacen_Entrada->FldCaption());
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

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->SetDbValueDef($rsnew, $this->COD_Fam_Accesorio->CurrentValue, NULL, $this->COD_Fam_Accesorio->ReadOnly);

			// COD_Marca_acc
			$this->COD_Marca_acc->SetDbValueDef($rsnew, $this->COD_Marca_acc->CurrentValue, NULL, $this->COD_Marca_acc->ReadOnly);

			// COD_Acabado_acc
			$this->COD_Acabado_acc->SetDbValueDef($rsnew, $this->COD_Acabado_acc->CurrentValue, NULL, $this->COD_Acabado_acc->ReadOnly);

			// COD_Tipo_acc
			$this->COD_Tipo_acc->SetDbValueDef($rsnew, $this->COD_Tipo_acc->CurrentValue, NULL, $this->COD_Tipo_acc->ReadOnly);

			// COD_Equipo_acc
			$this->COD_Equipo_acc->SetDbValueDef($rsnew, $this->COD_Equipo_acc->CurrentValue, NULL, $this->COD_Equipo_acc->ReadOnly);

			// Articulo
			$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", $this->Articulo->ReadOnly);

			// BarCode_Externo
			$this->BarCode_Externo->SetDbValueDef($rsnew, $this->BarCode_Externo->CurrentValue, NULL, $this->BarCode_Externo->ReadOnly);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, $this->Id_Almacen_Entrada->ReadOnly);

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
		$rsnew = array();

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio->SetDbValueDef($rsnew, $this->COD_Fam_Accesorio->CurrentValue, NULL, FALSE);

		// COD_Marca_acc
		$this->COD_Marca_acc->SetDbValueDef($rsnew, $this->COD_Marca_acc->CurrentValue, NULL, FALSE);

		// COD_Acabado_acc
		$this->COD_Acabado_acc->SetDbValueDef($rsnew, $this->COD_Acabado_acc->CurrentValue, NULL, FALSE);

		// COD_Tipo_acc
		$this->COD_Tipo_acc->SetDbValueDef($rsnew, $this->COD_Tipo_acc->CurrentValue, NULL, FALSE);

		// COD_Equipo_acc
		$this->COD_Equipo_acc->SetDbValueDef($rsnew, $this->COD_Equipo_acc->CurrentValue, NULL, FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// BarCode_Externo
		$this->BarCode_Externo->SetDbValueDef($rsnew, $this->BarCode_Externo->CurrentValue, NULL, FALSE);

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, strval($this->Id_Almacen_Entrada->CurrentValue) == "");

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
		$this->COD_Fam_Accesorio->AdvancedSearch->Load();
		$this->COD_Marca_acc->AdvancedSearch->Load();
		$this->COD_Acabado_acc->AdvancedSearch->Load();
		$this->COD_Tipo_acc->AdvancedSearch->Load();
		$this->COD_Equipo_acc->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->BarCode_Externo->AdvancedSearch->Load();
		$this->Id_Almacen_Entrada->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_def_accesorios\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_def_accesorios',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_def_accesorioslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_def_accesorios_list)) $cap_def_accesorios_list = new ccap_def_accesorios_list();

// Page init
$cap_def_accesorios_list->Page_Init();

// Page main
$cap_def_accesorios_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_def_accesorios->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_def_accesorios_list = new ew_Page("cap_def_accesorios_list");
cap_def_accesorios_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_def_accesorios_list.PageID; // For backward compatibility

// Form object
var fcap_def_accesorioslist = new ew_Form("fcap_def_accesorioslist");

// Validate form
fcap_def_accesorioslist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_COD_Fam_Accesorio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->COD_Fam_Accesorio->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_COD_Marca_acc"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->COD_Marca_acc->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Almacen_Entrada"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->Id_Almacen_Entrada->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_def_accesorioslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_accesorioslist.ValidateRequired = true;
<?php } else { ?>
fcap_def_accesorioslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_def_accesorioslist.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslist.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslist.Lists["x_COD_Acabado_acc"] = {"LinkField":"x_COD_Acabado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslist.Lists["x_COD_Tipo_acc"] = {"LinkField":"x_COD_Tipo_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Tipo_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslist.Lists["x_COD_Equipo_acc"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslist.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_def_accesorioslistsrch = new ew_Form("fcap_def_accesorioslistsrch");

// Validate function for search
fcap_def_accesorioslistsrch.Validate = function(fobj) {
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
fcap_def_accesorioslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_accesorioslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_def_accesorioslistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_def_accesorioslistsrch.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslistsrch.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslistsrch.Lists["x_COD_Acabado_acc"] = {"LinkField":"x_COD_Acabado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslistsrch.Lists["x_COD_Tipo_acc"] = {"LinkField":"x_COD_Tipo_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Tipo_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesorioslistsrch.Lists["x_COD_Equipo_acc"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
</script>
<div id="ewDetailsDiv" style="visibility: hidden; z-index: 11000;"></div>
<script type="text/javascript">

// Details preview
var ewDetailsDiv, ewDetailsTimer = null;
</script>
<script type="text/javascript">

function ActualizaCodigo_Accesorio(x)                                            
{                                      

// alert("Llamada en LIST con: " + x.name + "  Valor: " + x.value); 
// alert(" Sub del name = " + xId);     

   var xId = x.name.substring(0,2);  /// Si llega desde agragar trae x0, si viene de Editar trae x1
   var Fam = document.getElementById(xId + '_COD_Fam_Accesorio');
   var Marca = document.getElementById(xId + '_COD_Marca_acc');                             
   var Acabado = document.getElementById(xId + '_COD_Acabado_acc');                             
   var Tipo = document.getElementById(xId + '_COD_Tipo_acc');                             
   var Modelo = document.getElementById(xId + '_COD_Equipo_acc');  
   var xCodigo = document.getElementById(xId + '_Codigo');
   var xArticulo = document.getElementById(xId + '_Articulo');

//  Llenamos el Codigo con los valores de los catalogos                             
   Codigo = Fam.value + Marca.value + Acabado.value + Tipo.value + Modelo.value;                  
   xCodigo.value=Codigo;

/*   Asi estaba cuando llenabamos el codigo con XXX, YYY y ZZZZZ... mala idea de Arthur  
   var Codigo = Fam.value + Marca.value;
   if (Acabado.value == "") { Codigo += "XXX" } else { Codigo += Acabado.value }                               
   if (Tipo.value == "")    { Codigo += "YYY" } else { Codigo += Tipo.value    }                     
   if (Modelo.value == "")  { Codigo += "ZZZZZZZZZ" } else { Codigo += Modelo.value }
   xCodigo.value=Codigo;
*/         

//  Llenamos el Articulo con los valores de los catalogos                             
   var Articulo=Fam.options[Fam.selectedIndex].text;
   Articulo += " " + Marca.options[Marca.selectedIndex].text;                 
   Articulo += " " + Acabado.options[Acabado.selectedIndex].text;                 
   Articulo += " " + Tipo.options[Tipo.selectedIndex].text;                 
   Articulo += " " + Modelo.options[Modelo.selectedIndex].text;
   Articulo=Articulo.replace("   "," ");  // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo 
   Articulo=Articulo.replace("  "," ");   // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo 
   xArticulo.value=Articulo;
}
</script>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_def_accesorios_list->TotalRecs = $cap_def_accesorios->SelectRecordCount();
	} else {
		if ($cap_def_accesorios_list->Recordset = $cap_def_accesorios_list->LoadRecordset())
			$cap_def_accesorios_list->TotalRecs = $cap_def_accesorios_list->Recordset->RecordCount();
	}
	$cap_def_accesorios_list->StartRec = 1;
	if ($cap_def_accesorios_list->DisplayRecs <= 0 || ($cap_def_accesorios->Export <> "" && $cap_def_accesorios->ExportAll)) // Display all records
		$cap_def_accesorios_list->DisplayRecs = $cap_def_accesorios_list->TotalRecs;
	if (!($cap_def_accesorios->Export <> "" && $cap_def_accesorios->ExportAll))
		$cap_def_accesorios_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_def_accesorios_list->Recordset = $cap_def_accesorios_list->LoadRecordset($cap_def_accesorios_list->StartRec-1, $cap_def_accesorios_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_def_accesorios->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_def_accesorios_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_def_accesorios->Export == "" && $cap_def_accesorios->CurrentAction == "") { ?>
<form name="fcap_def_accesorioslistsrch" id="fcap_def_accesorioslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_def_accesorioslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_def_accesorioslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_def_accesorioslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_def_accesorios">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_def_accesorios_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_def_accesorios->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_def_accesorios->ResetAttrs();
$cap_def_accesorios_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_def_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<span id="xsc_COD_Fam_Accesorio" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->COD_Fam_Accesorio->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Fam_Accesorio" id="z_COD_Fam_Accesorio" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Fam_Accesorio" name="x_COD_Fam_Accesorio"<?php echo $cap_def_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Fam_Accesorio->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
?>
<input type="hidden" name="s_x_COD_Fam_Accesorio" id="s_x_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_def_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
	<span id="xsc_COD_Marca_acc" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->COD_Marca_acc->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Marca_acc" id="z_COD_Marca_acc" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Marca_acc" name="x_COD_Marca_acc"<?php echo $cap_def_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Marca_acc->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslistsrch.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_def_accesorios->COD_Acabado_acc->Visible) { // COD_Acabado_acc ?>
	<span id="xsc_COD_Acabado_acc" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->COD_Acabado_acc->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Acabado_acc" id="z_COD_Acabado_acc" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Acabado_acc" name="x_COD_Acabado_acc"<?php echo $cap_def_accesorios->COD_Acabado_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Acabado_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Acabado_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Acabado_acc->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Acabado` Asc";
?>
<input type="hidden" name="s_x_COD_Acabado_acc" id="s_x_COD_Acabado_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Acabado_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Acabado` = {filter_value}"); ?>&t0=200">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
<?php if ($cap_def_accesorios->COD_Tipo_acc->Visible) { // COD_Tipo_acc ?>
	<span id="xsc_COD_Tipo_acc" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->COD_Tipo_acc->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Tipo_acc" id="z_COD_Tipo_acc" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Tipo_acc" name="x_COD_Tipo_acc"<?php echo $cap_def_accesorios->COD_Tipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Tipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Tipo_acc->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslistsrch.Lists["x_COD_Tipo_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Tipo_acc->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_5" class="ewRow">
<?php if ($cap_def_accesorios->COD_Equipo_acc->Visible) { // COD_Equipo_acc ?>
	<span id="xsc_COD_Equipo_acc" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->COD_Equipo_acc->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Equipo_acc" id="z_COD_Equipo_acc" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Equipo_acc" name="x_COD_Equipo_acc"<?php echo $cap_def_accesorios->COD_Equipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Equipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Equipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Equipo_acc->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x_COD_Equipo_acc" id="s_x_COD_Equipo_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Equipo_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`Codigo` = {filter_value}"); ?>&t0=200">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_6" class="ewRow">
<?php if ($cap_def_accesorios->Codigo->Visible) { // Codigo ?>
	<span id="xsc_Codigo" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_def_accesorios->Codigo->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Codigo" id="z_Codigo" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" name="x_Codigo" id="x_Codigo" size="30" maxlength="22" value="<?php echo $cap_def_accesorios->Codigo->EditValue ?>"<?php echo $cap_def_accesorios->Codigo->EditAttributes() ?>>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_7" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_def_accesorios_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_8" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_def_accesorios_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_def_accesorios_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_def_accesorios_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_def_accesorios_list->ShowPageHeader(); ?>
<?php
$cap_def_accesorios_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_def_accesorios->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_def_accesorios->CurrentAction <> "gridadd" && $cap_def_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_def_accesorios_list->Pager)) $cap_def_accesorios_list->Pager = new cNumericPager($cap_def_accesorios_list->StartRec, $cap_def_accesorios_list->DisplayRecs, $cap_def_accesorios_list->TotalRecs, $cap_def_accesorios_list->RecRange) ?>
<?php if ($cap_def_accesorios_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_def_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_def_accesorios_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_def_accesorios_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_def_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_def_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_def_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_def_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_def_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_def_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_def_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_def_accesorios_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_def_accesorios_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cap_def_accesorios_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_def_accesorios_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_def_accesorioslist" id="fcap_def_accesorioslist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_def_accesorios">
<div id="gmp_cap_def_accesorios" class="ewGridMiddlePanel">
<?php if ($cap_def_accesorios_list->TotalRecs > 0 || $cap_def_accesorios->CurrentAction == "add" || $cap_def_accesorios->CurrentAction == "copy") { ?>
<table id="tbl_cap_def_accesorioslist" class="ewTable ewTableSeparate">
<?php echo $cap_def_accesorios->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_def_accesorios_list->RenderListOptions();

// Render list options (header, left)
$cap_def_accesorios_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_def_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Fam_Accesorio) == "") { ?>
		<td><span id="elh_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->COD_Fam_Accesorio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Fam_Accesorio) ?>',2);"><span id="elh_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->COD_Fam_Accesorio->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->COD_Fam_Accesorio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->COD_Fam_Accesorio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Marca_acc) == "") { ?>
		<td><span id="elh_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->COD_Marca_acc->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Marca_acc) ?>',2);"><span id="elh_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->COD_Marca_acc->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->COD_Marca_acc->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->COD_Marca_acc->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->COD_Acabado_acc->Visible) { // COD_Acabado_acc ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Acabado_acc) == "") { ?>
		<td><span id="elh_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->COD_Acabado_acc->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Acabado_acc) ?>',2);"><span id="elh_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->COD_Acabado_acc->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->COD_Acabado_acc->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->COD_Acabado_acc->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->COD_Tipo_acc->Visible) { // COD_Tipo_acc ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Tipo_acc) == "") { ?>
		<td><span id="elh_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->COD_Tipo_acc->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Tipo_acc) ?>',2);"><span id="elh_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->COD_Tipo_acc->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->COD_Tipo_acc->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->COD_Tipo_acc->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->COD_Equipo_acc->Visible) { // COD_Equipo_acc ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Equipo_acc) == "") { ?>
		<td><span id="elh_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->COD_Equipo_acc->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->COD_Equipo_acc) ?>',2);"><span id="elh_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->COD_Equipo_acc->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->COD_Equipo_acc->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->COD_Equipo_acc->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->Codigo) == "") { ?>
		<td><span id="elh_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->Codigo) ?>',2);"><span id="elh_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->Articulo) == "") { ?>
		<td><span id="elh_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->Articulo) ?>',2);"><span id="elh_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->Articulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->BarCode_Externo->Visible) { // BarCode_Externo ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->BarCode_Externo) == "") { ?>
		<td><span id="elh_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->BarCode_Externo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->BarCode_Externo) ?>',2);"><span id="elh_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->BarCode_Externo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->BarCode_Externo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->BarCode_Externo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_def_accesorios->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
	<?php if ($cap_def_accesorios->SortUrl($cap_def_accesorios->Id_Almacen_Entrada) == "") { ?>
		<td><span id="elh_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_def_accesorios->Id_Almacen_Entrada->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_def_accesorios->SortUrl($cap_def_accesorios->Id_Almacen_Entrada) ?>',2);"><span id="elh_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_def_accesorios->Id_Almacen_Entrada->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_def_accesorios->Id_Almacen_Entrada->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_def_accesorios->Id_Almacen_Entrada->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_def_accesorios_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cap_def_accesorios->CurrentAction == "add" || $cap_def_accesorios->CurrentAction == "copy") {
		$cap_def_accesorios_list->RowIndex = 0;
		$cap_def_accesorios_list->KeyCount = $cap_def_accesorios_list->RowIndex;
		if ($cap_def_accesorios->CurrentAction == "copy" && !$cap_def_accesorios_list->LoadRow())
				$cap_def_accesorios->CurrentAction = "add";
		if ($cap_def_accesorios->CurrentAction == "add")
			$cap_def_accesorios_list->LoadDefaultValues();
		if ($cap_def_accesorios->EventCancelled) // Insert failed
			$cap_def_accesorios_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cap_def_accesorios->ResetAttrs();
		$cap_def_accesorios->RowAttrs = array_merge($cap_def_accesorios->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cap_def_accesorios', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cap_def_accesorios->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_def_accesorios_list->RenderRow();

		// Render list options
		$cap_def_accesorios_list->RenderListOptions();
		$cap_def_accesorios_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_def_accesorios->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_def_accesorios_list->ListOptions->Render("body", "left", $cap_def_accesorios_list->RowCnt);
?>
	<?php if ($cap_def_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_def_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_def_accesorios->COD_Fam_Accesorio->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc"<?php echo $cap_def_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Marca_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc" value="<?php echo ew_HtmlEncode($cap_def_accesorios->COD_Marca_acc->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Acabado_acc->Visible) { // COD_Acabado_acc ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc"<?php echo $cap_def_accesorios->COD_Acabado_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Acabado_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Acabado_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Acabado_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Acabado` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Acabado_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Acabado` = {filter_value}"); ?>&t0=200">
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" value="<?php echo ew_HtmlEncode($cap_def_accesorios->COD_Acabado_acc->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Tipo_acc->Visible) { // COD_Tipo_acc ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc"<?php echo $cap_def_accesorios->COD_Tipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Tipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Tipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_COD_Tipo_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Tipo_acc->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc" value="<?php echo ew_HtmlEncode($cap_def_accesorios->COD_Tipo_acc->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Equipo_acc->Visible) { // COD_Equipo_acc ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc"<?php echo $cap_def_accesorios->COD_Equipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Equipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Equipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Equipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Equipo_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`Codigo` = {filter_value}"); ?>&t0=200">
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" value="<?php echo ew_HtmlEncode($cap_def_accesorios->COD_Equipo_acc->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Codigo->Visible) { // Codigo ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo">
<input type="text" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" size="30" maxlength="22" value="<?php echo $cap_def_accesorios->Codigo->EditValue ?>"<?php echo $cap_def_accesorios->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Articulo->Visible) { // Articulo ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo">
<input type="text" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" size="100" maxlength="100" value="<?php echo $cap_def_accesorios->Articulo->EditValue ?>"<?php echo $cap_def_accesorios->Articulo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->BarCode_Externo->Visible) { // BarCode_Externo ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo">
<input type="text" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" size="30" maxlength="25" value="<?php echo $cap_def_accesorios->BarCode_Externo->EditValue ?>"<?php echo $cap_def_accesorios->BarCode_Externo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->BarCode_Externo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
		<td><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada">
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada"<?php echo $cap_def_accesorios->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $cap_def_accesorios->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada" id="o<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Id_Almacen_Entrada->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_def_accesorios_list->ListOptions->Render("body", "right", $cap_def_accesorios_list->RowCnt);
?>
<script type="text/javascript">
fcap_def_accesorioslist.UpdateOpts(<?php echo $cap_def_accesorios_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cap_def_accesorios->ExportAll && $cap_def_accesorios->Export <> "") {
	$cap_def_accesorios_list->StopRec = $cap_def_accesorios_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_def_accesorios_list->TotalRecs > $cap_def_accesorios_list->StartRec + $cap_def_accesorios_list->DisplayRecs - 1)
		$cap_def_accesorios_list->StopRec = $cap_def_accesorios_list->StartRec + $cap_def_accesorios_list->DisplayRecs - 1;
	else
		$cap_def_accesorios_list->StopRec = $cap_def_accesorios_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_def_accesorios->CurrentAction == "gridadd" || $cap_def_accesorios->CurrentAction == "gridedit" || $cap_def_accesorios->CurrentAction == "F")) {
		$cap_def_accesorios_list->KeyCount = $objForm->GetValue("key_count");
		$cap_def_accesorios_list->StopRec = $cap_def_accesorios_list->KeyCount;
	}
}
$cap_def_accesorios_list->RecCnt = $cap_def_accesorios_list->StartRec - 1;
if ($cap_def_accesorios_list->Recordset && !$cap_def_accesorios_list->Recordset->EOF) {
	$cap_def_accesorios_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_def_accesorios_list->StartRec > 1)
		$cap_def_accesorios_list->Recordset->Move($cap_def_accesorios_list->StartRec - 1);
} elseif (!$cap_def_accesorios->AllowAddDeleteRow && $cap_def_accesorios_list->StopRec == 0) {
	$cap_def_accesorios_list->StopRec = $cap_def_accesorios->GridAddRowCount;
}

// Initialize aggregate
$cap_def_accesorios->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_def_accesorios->ResetAttrs();
$cap_def_accesorios_list->RenderRow();
$cap_def_accesorios_list->EditRowCnt = 0;
if ($cap_def_accesorios->CurrentAction == "edit")
	$cap_def_accesorios_list->RowIndex = 1;
while ($cap_def_accesorios_list->RecCnt < $cap_def_accesorios_list->StopRec) {
	$cap_def_accesorios_list->RecCnt++;
	if (intval($cap_def_accesorios_list->RecCnt) >= intval($cap_def_accesorios_list->StartRec)) {
		$cap_def_accesorios_list->RowCnt++;

		// Set up key count
		$cap_def_accesorios_list->KeyCount = $cap_def_accesorios_list->RowIndex;

		// Init row class and style
		$cap_def_accesorios->ResetAttrs();
		$cap_def_accesorios->CssClass = "";
		if ($cap_def_accesorios->CurrentAction == "gridadd") {
			$cap_def_accesorios_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_def_accesorios_list->LoadRowValues($cap_def_accesorios_list->Recordset); // Load row values
		}
		$cap_def_accesorios->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_def_accesorios->CurrentAction == "edit") {
			if ($cap_def_accesorios_list->CheckInlineEditKey() && $cap_def_accesorios_list->EditRowCnt == 0) { // Inline edit
				$cap_def_accesorios->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_def_accesorios->CurrentAction == "edit" && $cap_def_accesorios->RowType == EW_ROWTYPE_EDIT && $cap_def_accesorios->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_def_accesorios_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_def_accesorios_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_def_accesorios->RowAttrs = array_merge($cap_def_accesorios->RowAttrs, array('data-rowindex'=>$cap_def_accesorios_list->RowCnt, 'id'=>'r' . $cap_def_accesorios_list->RowCnt . '_cap_def_accesorios', 'data-rowtype'=>$cap_def_accesorios->RowType));

		// Render row
		$cap_def_accesorios_list->RenderRow();

		// Render list options
		$cap_def_accesorios_list->RenderListOptions();
?>
	<tr<?php echo $cap_def_accesorios->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_def_accesorios_list->ListOptions->Render("body", "left", $cap_def_accesorios_list->RowCnt);
?>
	<?php if ($cap_def_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td<?php echo $cap_def_accesorios->COD_Fam_Accesorio->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_def_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Fam_Accesorio->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT || $cap_def_accesorios->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Id_Articulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_def_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
		<td<?php echo $cap_def_accesorios->COD_Marca_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Marca_acc"<?php echo $cap_def_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Marca_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->COD_Marca_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Marca_acc->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Acabado_acc->Visible) { // COD_Acabado_acc ?>
		<td<?php echo $cap_def_accesorios->COD_Acabado_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc"<?php echo $cap_def_accesorios->COD_Acabado_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Acabado_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Acabado_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Acabado_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Acabado` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Acabado_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Acabado_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Acabado` = {filter_value}"); ?>&t0=200">
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->COD_Acabado_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Acabado_acc->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Tipo_acc->Visible) { // COD_Tipo_acc ?>
		<td<?php echo $cap_def_accesorios->COD_Tipo_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Tipo_acc"<?php echo $cap_def_accesorios->COD_Tipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Tipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Tipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_COD_Tipo_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Tipo_acc->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->COD_Tipo_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Tipo_acc->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->COD_Equipo_acc->Visible) { // COD_Equipo_acc ?>
		<td<?php echo $cap_def_accesorios->COD_Equipo_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc"<?php echo $cap_def_accesorios->COD_Equipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Equipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Equipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Equipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" id="s_x<?php echo $cap_def_accesorios_list->RowIndex ?>_COD_Equipo_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Equipo_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`Codigo` = {filter_value}"); ?>&t0=200">
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->COD_Equipo_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Equipo_acc->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_def_accesorios->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_def_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Codigo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Codigo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_def_accesorios->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Articulo" size="100" maxlength="100" value="<?php echo $cap_def_accesorios->Articulo->EditValue ?>"<?php echo $cap_def_accesorios->Articulo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->Articulo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->BarCode_Externo->Visible) { // BarCode_Externo ?>
		<td<?php echo $cap_def_accesorios->BarCode_Externo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_BarCode_Externo" size="30" maxlength="25" value="<?php echo $cap_def_accesorios->BarCode_Externo->EditValue ?>"<?php echo $cap_def_accesorios->BarCode_Externo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->BarCode_Externo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->BarCode_Externo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_def_accesorios->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
		<td<?php echo $cap_def_accesorios->Id_Almacen_Entrada->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_list->RowCnt ?>_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada">
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada" name="x<?php echo $cap_def_accesorios_list->RowIndex ?>_Id_Almacen_Entrada"<?php echo $cap_def_accesorios->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $cap_def_accesorios->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesorioslist.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_def_accesorios->Id_Almacen_Entrada->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Id_Almacen_Entrada->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_def_accesorios_list->PageObjName . "_row_" . $cap_def_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_def_accesorios_list->ListOptions->Render("body", "right", $cap_def_accesorios_list->RowCnt);
?>
	</tr>
<?php if ($cap_def_accesorios->RowType == EW_ROWTYPE_ADD || $cap_def_accesorios->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_def_accesorioslist.UpdateOpts(<?php echo $cap_def_accesorios_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_def_accesorios->CurrentAction <> "gridadd")
		$cap_def_accesorios_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_def_accesorios->CurrentAction == "add" || $cap_def_accesorios->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_def_accesorios_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_def_accesorios->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_def_accesorios_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_def_accesorios->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_def_accesorios_list->Recordset)
	$cap_def_accesorios_list->Recordset->Close();
?>
<?php if ($cap_def_accesorios_list->TotalRecs > 0) { ?>
<?php if ($cap_def_accesorios->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_def_accesorios->CurrentAction <> "gridadd" && $cap_def_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_def_accesorios_list->Pager)) $cap_def_accesorios_list->Pager = new cNumericPager($cap_def_accesorios_list->StartRec, $cap_def_accesorios_list->DisplayRecs, $cap_def_accesorios_list->TotalRecs, $cap_def_accesorios_list->RecRange) ?>
<?php if ($cap_def_accesorios_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_def_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_def_accesorios_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_def_accesorios_list->PageUrl() ?>start=<?php echo $cap_def_accesorios_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_def_accesorios_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_def_accesorios_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_def_accesorios_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_def_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_def_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_def_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_def_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_def_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_def_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_def_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_def_accesorios_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_def_accesorios_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cap_def_accesorios_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_def_accesorios_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_def_accesorios->Export == "") { ?>
<script type="text/javascript">
fcap_def_accesorioslistsrch.Init();
fcap_def_accesorioslist.Init();
</script>
<?php } ?>
<?php
$cap_def_accesorios_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_def_accesorios->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
function AvisoNoEditarCodigo(x) {     
  alert(" EL CODIGO NO PUEDE SER MODIFICADO MANUALMENTE ");
  document.getElementById('x_COD_Fam_Accesorio').focus();
}
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_def_accesorios_list->Page_Terminate();
?>
