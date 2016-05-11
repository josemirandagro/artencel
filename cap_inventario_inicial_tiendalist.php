<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_inventario_inicial_tiendainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_inventario_inicial_tienda_list = NULL; // Initialize page object first

class ccap_inventario_inicial_tienda_list extends ccap_inventario_inicial_tienda {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_inventario_inicial_tienda';

	// Page object name
	var $PageObjName = 'cap_inventario_inicial_tienda_list';

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

		// Table object (cap_inventario_inicial_tienda)
		if (!isset($GLOBALS["cap_inventario_inicial_tienda"])) {
			$GLOBALS["cap_inventario_inicial_tienda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_inventario_inicial_tienda"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_inventario_inicial_tiendaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_inventario_inicial_tiendadelete.php";
		$this->MultiUpdateUrl = "cap_inventario_inicial_tiendaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_inventario_inicial_tienda', TRUE);

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
		$this->Id_Tel_SIM->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		$this->setKey("Id_Tel_SIM", ""); // Clear inline edit key
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
		if (@$_GET["Id_Tel_SIM"] <> "") {
			$this->Id_Tel_SIM->setQueryStringValue($_GET["Id_Tel_SIM"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Tel_SIM", $this->Id_Tel_SIM->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Tel_SIM")) <> strval($this->Id_Tel_SIM->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["Id_Tel_SIM"] <> "") {
				$this->Id_Tel_SIM->setQueryStringValue($_GET["Id_Tel_SIM"]);
				$this->setKey("Id_Tel_SIM", $this->Id_Tel_SIM->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Tel_SIM", ""); // Clear key
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
			$this->Id_Tel_SIM->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Tel_SIM->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Tel_SIM, FALSE); // Id_Tel_SIM
		$this->BuildSearchSql($sWhere, $this->Id_Articulo, FALSE); // Id_Articulo
		$this->BuildSearchSql($sWhere, $this->Id_Acabado_eq, FALSE); // Id_Acabado_eq
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI
		$this->BuildSearchSql($sWhere, $this->Num_ICCID, FALSE); // Num_ICCID
		$this->BuildSearchSql($sWhere, $this->Num_CEL, FALSE); // Num_CEL
		$this->BuildSearchSql($sWhere, $this->Id_Almacen, FALSE); // Id_Almacen
		$this->BuildSearchSql($sWhere, $this->Id_Usuario, FALSE); // Id_Usuario
		$this->BuildSearchSql($sWhere, $this->TipoArticulo, FALSE); // TipoArticulo
		$this->BuildSearchSql($sWhere, $this->Id_Proveedor, FALSE); // Id_Proveedor

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Tel_SIM->AdvancedSearch->Save(); // Id_Tel_SIM
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->Id_Acabado_eq->AdvancedSearch->Save(); // Id_Acabado_eq
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
			$this->Num_ICCID->AdvancedSearch->Save(); // Num_ICCID
			$this->Num_CEL->AdvancedSearch->Save(); // Num_CEL
			$this->Id_Almacen->AdvancedSearch->Save(); // Id_Almacen
			$this->Id_Usuario->AdvancedSearch->Save(); // Id_Usuario
			$this->TipoArticulo->AdvancedSearch->Save(); // TipoArticulo
			$this->Id_Proveedor->AdvancedSearch->Save(); // Id_Proveedor
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
		$this->BuildBasicSearchSQL($sWhere, $this->Num_ICCID, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_CEL, $Keyword);
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
		if ($this->Id_Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Acabado_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_ICCID->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_CEL->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Almacen->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Usuario->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->TipoArticulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Proveedor->AdvancedSearch->IssetSession())
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
		$this->Id_Articulo->AdvancedSearch->UnsetSession();
		$this->Id_Acabado_eq->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
		$this->Num_ICCID->AdvancedSearch->UnsetSession();
		$this->Num_CEL->AdvancedSearch->UnsetSession();
		$this->Id_Almacen->AdvancedSearch->UnsetSession();
		$this->Id_Usuario->AdvancedSearch->UnsetSession();
		$this->TipoArticulo->AdvancedSearch->UnsetSession();
		$this->Id_Proveedor->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Id_Acabado_eq->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Id_Usuario->AdvancedSearch->Load();
		$this->TipoArticulo->AdvancedSearch->Load();
		$this->Id_Proveedor->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Tel_SIM, $bCtrl); // Id_Tel_SIM
			$this->UpdateSort($this->Id_Articulo, $bCtrl); // Id_Articulo
			$this->UpdateSort($this->Id_Acabado_eq, $bCtrl); // Id_Acabado_eq
			$this->UpdateSort($this->Num_IMEI, $bCtrl); // Num_IMEI
			$this->UpdateSort($this->Num_ICCID, $bCtrl); // Num_ICCID
			$this->UpdateSort($this->Num_CEL, $bCtrl); // Num_CEL
			$this->UpdateSort($this->Id_Proveedor, $bCtrl); // Id_Proveedor
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
				$this->Id_Tel_SIM->setSort("DESC");
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
				$this->Id_Articulo->setSort("");
				$this->Id_Acabado_eq->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_ICCID->setSort("");
				$this->Num_CEL->setSort("");
				$this->Id_Proveedor->setSort("");
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
				"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_inventario_inicial_tiendalist'].Submit();\">" . "<img src=\"phpimages/insert.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
				"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_inventario_inicial_tiendalist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Tel_SIM->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . $this->InlineCopyUrl . "\">" . "<img src=\"phpimages/inlinecopy.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineCopyLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineCopyLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		$this->Id_Tel_SIM->CurrentValue = NULL;
		$this->Id_Tel_SIM->OldValue = $this->Id_Tel_SIM->CurrentValue;
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Acabado_eq->CurrentValue = 1;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->Num_ICCID->CurrentValue = NULL;
		$this->Num_ICCID->OldValue = $this->Num_ICCID->CurrentValue;
		$this->Num_CEL->CurrentValue = NULL;
		$this->Num_CEL->OldValue = $this->Num_CEL->CurrentValue;
		$this->Id_Proveedor->CurrentValue = NULL;
		$this->Id_Proveedor->OldValue = $this->Id_Proveedor->CurrentValue;
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

		// Id_Articulo
		$this->Id_Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Articulo"]);
		if ($this->Id_Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Articulo"];

		// Id_Acabado_eq
		$this->Id_Acabado_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Acabado_eq"]);
		if ($this->Id_Acabado_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Acabado_eq->AdvancedSearch->SearchOperator = @$_GET["z_Id_Acabado_eq"];

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

		// Id_Almacen
		$this->Id_Almacen->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Almacen"]);
		if ($this->Id_Almacen->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Almacen->AdvancedSearch->SearchOperator = @$_GET["z_Id_Almacen"];

		// Id_Usuario
		$this->Id_Usuario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Usuario"]);
		if ($this->Id_Usuario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Usuario->AdvancedSearch->SearchOperator = @$_GET["z_Id_Usuario"];

		// TipoArticulo
		$this->TipoArticulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_TipoArticulo"]);
		if ($this->TipoArticulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->TipoArticulo->AdvancedSearch->SearchOperator = @$_GET["z_TipoArticulo"];

		// Id_Proveedor
		$this->Id_Proveedor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Proveedor"]);
		if ($this->Id_Proveedor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Proveedor->AdvancedSearch->SearchOperator = @$_GET["z_Id_Proveedor"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Tel_SIM->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Id_Acabado_eq->FldIsDetailKey) {
			$this->Id_Acabado_eq->setFormValue($objForm->GetValue("x_Id_Acabado_eq"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Num_ICCID->FldIsDetailKey) {
			$this->Num_ICCID->setFormValue($objForm->GetValue("x_Num_ICCID"));
		}
		if (!$this->Num_CEL->FldIsDetailKey) {
			$this->Num_CEL->setFormValue($objForm->GetValue("x_Num_CEL"));
		}
		if (!$this->Id_Proveedor->FldIsDetailKey) {
			$this->Id_Proveedor->setFormValue($objForm->GetValue("x_Id_Proveedor"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Id_Acabado_eq->CurrentValue = $this->Id_Acabado_eq->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_ICCID->CurrentValue = $this->Num_ICCID->FormValue;
		$this->Num_CEL->CurrentValue = $this->Num_CEL->FormValue;
		$this->Id_Proveedor->CurrentValue = $this->Id_Proveedor->FormValue;
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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Id_Usuario->setDbValue($rs->fields('Id_Usuario'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Tel_SIM")) <> "")
			$this->Id_Tel_SIM->CurrentValue = $this->getKey("Id_Tel_SIM"); // Id_Tel_SIM
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
		// Id_Tel_SIM
		// Id_Articulo
		// Id_Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Id_Almacen
		// Id_Usuario
		// TipoArticulo
		// Id_Proveedor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Articulo->ViewValue .= ew_ValueSeparator(1,$this->Id_Articulo) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->ViewValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Id_Acabado_eq
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado_eq`";
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

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Id_Usuario
			$this->Id_Usuario->ViewValue = $this->Id_Usuario->CurrentValue;
			$this->Id_Usuario->ViewCustomAttributes = "";

			// TipoArticulo
			$this->TipoArticulo->ViewValue = $this->TipoArticulo->CurrentValue;
			$this->TipoArticulo->ViewCustomAttributes = "";

			// Id_Proveedor
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial`";
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

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

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

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Tel_SIM
			// Id_Articulo

			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Acabado_eq->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "onchange= 'ValidaICCID(this);' ";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->CurrentValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->CurrentValue);

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Proveedor->EditValue = $arwrk;

			// Edit refer script
			// Id_Tel_SIM

			$this->Id_Tel_SIM->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_ICCID
			$this->Num_ICCID->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			$this->Id_Tel_SIM->EditValue = $this->Id_Tel_SIM->CurrentValue;
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Acabado_eq->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "onchange= 'ValidaICCID(this);' ";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->CurrentValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->CurrentValue);

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Proveedor->EditValue = $arwrk;

			// Edit refer script
			// Id_Tel_SIM

			$this->Id_Tel_SIM->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_ICCID
			$this->Num_ICCID->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			$this->Id_Tel_SIM->EditValue = ew_HtmlEncode($this->Id_Tel_SIM->AdvancedSearch->SearchValue);

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Acabado_eq->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'ValidaIMEI(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "onchange= 'ValidaICCID(this);' ";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->AdvancedSearch->SearchValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->AdvancedSearch->SearchValue);

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
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
		if (!is_null($this->Id_Articulo->FormValue) && $this->Id_Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Articulo->FldCaption());
		}
		if (!is_null($this->Id_Acabado_eq->FormValue) && $this->Id_Acabado_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Acabado_eq->FldCaption());
		}
		if (!is_null($this->Num_IMEI->FormValue) && $this->Num_IMEI->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_IMEI->FldCaption());
		}
		if (!is_null($this->Id_Proveedor->FormValue) && $this->Id_Proveedor->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Proveedor->FldCaption());
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
			if ($this->Num_ICCID->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Num_ICCID` = '" . ew_AdjustSql($this->Num_ICCID->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_ICCID->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_ICCID->CurrentValue, $sIdxErrMsg);
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

			// Id_Articulo
			$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, NULL, $this->Id_Articulo->ReadOnly);

			// Id_Acabado_eq
			$this->Id_Acabado_eq->SetDbValueDef($rsnew, $this->Id_Acabado_eq->CurrentValue, NULL, $this->Id_Acabado_eq->ReadOnly);

			// Num_IMEI
			$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, $this->Num_IMEI->ReadOnly);

			// Num_ICCID
			$this->Num_ICCID->SetDbValueDef($rsnew, $this->Num_ICCID->CurrentValue, NULL, $this->Num_ICCID->ReadOnly);

			// Num_CEL
			$this->Num_CEL->SetDbValueDef($rsnew, $this->Num_CEL->CurrentValue, NULL, $this->Num_CEL->ReadOnly);

			// Id_Proveedor
			$this->Id_Proveedor->SetDbValueDef($rsnew, $this->Id_Proveedor->CurrentValue, NULL, $this->Id_Proveedor->ReadOnly);

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
		if ($this->Num_ICCID->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Num_ICCID = '" . ew_AdjustSql($this->Num_ICCID->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_ICCID->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_ICCID->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, NULL, FALSE);

		// Id_Acabado_eq
		$this->Id_Acabado_eq->SetDbValueDef($rsnew, $this->Id_Acabado_eq->CurrentValue, NULL, FALSE);

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, FALSE);

		// Num_ICCID
		$this->Num_ICCID->SetDbValueDef($rsnew, $this->Num_ICCID->CurrentValue, NULL, FALSE);

		// Num_CEL
		$this->Num_CEL->SetDbValueDef($rsnew, $this->Num_CEL->CurrentValue, NULL, FALSE);

		// Id_Proveedor
		$this->Id_Proveedor->SetDbValueDef($rsnew, $this->Id_Proveedor->CurrentValue, NULL, FALSE);

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
			$this->Id_Tel_SIM->setDbValue($conn->Insert_ID());
			$rsnew['Id_Tel_SIM'] = $this->Id_Tel_SIM->DbValue;
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
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Id_Acabado_eq->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->Id_Usuario->AdvancedSearch->Load();
		$this->TipoArticulo->AdvancedSearch->Load();
		$this->Id_Proveedor->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_inventario_inicial_tienda\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_inventario_inicial_tienda',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_inventario_inicial_tiendalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_inventario_inicial_tienda_list)) $cap_inventario_inicial_tienda_list = new ccap_inventario_inicial_tienda_list();

// Page init
$cap_inventario_inicial_tienda_list->Page_Init();

// Page main
$cap_inventario_inicial_tienda_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_inventario_inicial_tienda->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_inventario_inicial_tienda_list = new ew_Page("cap_inventario_inicial_tienda_list");
cap_inventario_inicial_tienda_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_inventario_inicial_tienda_list.PageID; // For backward compatibility

// Form object
var fcap_inventario_inicial_tiendalist = new ew_Form("fcap_inventario_inicial_tiendalist");

// Validate form
fcap_inventario_inicial_tiendalist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_inicial_tienda->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Acabado_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_inicial_tienda->Id_Acabado_eq->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_IMEI"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_inicial_tienda->Num_IMEI->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Proveedor"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_inicial_tienda->Id_Proveedor->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_inventario_inicial_tiendalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_inicial_tiendalist.ValidateRequired = true;
<?php } else { ?>
fcap_inventario_inicial_tiendalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_inventario_inicial_tiendalist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","x_Articulo","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_inicial_tiendalist.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_inicial_tiendalist.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":null,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_inventario_inicial_tiendalistsrch = new ew_Form("fcap_inventario_inicial_tiendalistsrch");

// Validate function for search
fcap_inventario_inicial_tiendalistsrch.Validate = function(fobj) {
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
fcap_inventario_inicial_tiendalistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_inicial_tiendalistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_inventario_inicial_tiendalistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_inventario_inicial_tiendalistsrch.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","x_Articulo","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_inicial_tiendalistsrch.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		$cap_inventario_inicial_tienda_list->TotalRecs = $cap_inventario_inicial_tienda->SelectRecordCount();
	} else {
		if ($cap_inventario_inicial_tienda_list->Recordset = $cap_inventario_inicial_tienda_list->LoadRecordset())
			$cap_inventario_inicial_tienda_list->TotalRecs = $cap_inventario_inicial_tienda_list->Recordset->RecordCount();
	}
	$cap_inventario_inicial_tienda_list->StartRec = 1;
	if ($cap_inventario_inicial_tienda_list->DisplayRecs <= 0 || ($cap_inventario_inicial_tienda->Export <> "" && $cap_inventario_inicial_tienda->ExportAll)) // Display all records
		$cap_inventario_inicial_tienda_list->DisplayRecs = $cap_inventario_inicial_tienda_list->TotalRecs;
	if (!($cap_inventario_inicial_tienda->Export <> "" && $cap_inventario_inicial_tienda->ExportAll))
		$cap_inventario_inicial_tienda_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_inventario_inicial_tienda_list->Recordset = $cap_inventario_inicial_tienda_list->LoadRecordset($cap_inventario_inicial_tienda_list->StartRec-1, $cap_inventario_inicial_tienda_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_inventario_inicial_tienda->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_inventario_inicial_tienda_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_inventario_inicial_tienda->Export == "" && $cap_inventario_inicial_tienda->CurrentAction == "") { ?>
<form name="fcap_inventario_inicial_tiendalistsrch" id="fcap_inventario_inicial_tiendalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_inventario_inicial_tiendalistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_inventario_inicial_tiendalistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_inventario_inicial_tiendalistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_inventario_inicial_tienda">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_inventario_inicial_tienda_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_inventario_inicial_tienda->ResetAttrs();
$cap_inventario_inicial_tienda_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_inventario_inicial_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
	<span id="xsc_Id_Articulo" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_inicial_tienda->Id_Articulo->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Articulo" id="z_Id_Articulo" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Articulo" name="x_Id_Articulo"<?php echo $cap_inventario_inicial_tienda->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Articulo->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_inventario_inicial_tienda->Id_Articulo) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo`";
?>
<input type="hidden" name="s_x_Id_Articulo" id="s_x_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_inventario_inicial_tienda->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_inventario_inicial_tienda->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<span id="xsc_Id_Acabado_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Acabado_eq" id="z_Id_Acabado_eq" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Acabado_eq" name="x_Id_Acabado_eq"<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Acabado_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_inicial_tiendalistsrch.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_inventario_inicial_tienda_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_inventario_inicial_tienda_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_inventario_inicial_tienda_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_inventario_inicial_tienda_list->ShowPageHeader(); ?>
<?php
$cap_inventario_inicial_tienda_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_inventario_inicial_tienda->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_inventario_inicial_tienda->CurrentAction <> "gridadd" && $cap_inventario_inicial_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_inventario_inicial_tienda_list->Pager)) $cap_inventario_inicial_tienda_list->Pager = new cNumericPager($cap_inventario_inicial_tienda_list->StartRec, $cap_inventario_inicial_tienda_list->DisplayRecs, $cap_inventario_inicial_tienda_list->TotalRecs, $cap_inventario_inicial_tienda_list->RecRange) ?>
<?php if ($cap_inventario_inicial_tienda_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_inventario_inicial_tienda_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_inventario_inicial_tienda_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_inventario_inicial_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_inventario_inicial_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_inventario_inicial_tienda_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_inventario_inicial_tienda_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_inventario_inicial_tiendalist" id="fcap_inventario_inicial_tiendalist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_inventario_inicial_tienda">
<div id="gmp_cap_inventario_inicial_tienda" class="ewGridMiddlePanel">
<?php if ($cap_inventario_inicial_tienda_list->TotalRecs > 0 || $cap_inventario_inicial_tienda->CurrentAction == "add" || $cap_inventario_inicial_tienda->CurrentAction == "copy") { ?>
<table id="tbl_cap_inventario_inicial_tiendalist" class="ewTable ewTableSeparate">
<?php echo $cap_inventario_inicial_tienda->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_inventario_inicial_tienda_list->RenderListOptions();

// Render list options (header, left)
$cap_inventario_inicial_tienda_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_inventario_inicial_tienda->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Tel_SIM" class="cap_inventario_inicial_tienda_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Tel_SIM) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Id_Tel_SIM" class="cap_inventario_inicial_tienda_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Articulo) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Acabado_eq) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_IMEI) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_ICCID) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_ICCID) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Num_ICCID->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_CEL) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Num_CEL) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Num_CEL->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_inicial_tienda->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<?php if ($cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Proveedor) == "") { ?>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Proveedor->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_inicial_tienda->SortUrl($cap_inventario_inicial_tienda->Id_Proveedor) ?>',2);"><span id="elh_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_inicial_tienda->Id_Proveedor->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_inicial_tienda->Id_Proveedor->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_inicial_tienda->Id_Proveedor->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_inventario_inicial_tienda_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cap_inventario_inicial_tienda->CurrentAction == "add" || $cap_inventario_inicial_tienda->CurrentAction == "copy") {
		$cap_inventario_inicial_tienda_list->RowIndex = 0;
		$cap_inventario_inicial_tienda_list->KeyCount = $cap_inventario_inicial_tienda_list->RowIndex;
		if ($cap_inventario_inicial_tienda->CurrentAction == "copy" && !$cap_inventario_inicial_tienda_list->LoadRow())
				$cap_inventario_inicial_tienda->CurrentAction = "add";
		if ($cap_inventario_inicial_tienda->CurrentAction == "add")
			$cap_inventario_inicial_tienda_list->LoadDefaultValues();
		if ($cap_inventario_inicial_tienda->EventCancelled) // Insert failed
			$cap_inventario_inicial_tienda_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cap_inventario_inicial_tienda->ResetAttrs();
		$cap_inventario_inicial_tienda->RowAttrs = array_merge($cap_inventario_inicial_tienda->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cap_inventario_inicial_tienda', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_inventario_inicial_tienda_list->RenderRow();

		// Render list options
		$cap_inventario_inicial_tienda_list->RenderListOptions();
		$cap_inventario_inicial_tienda_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_inventario_inicial_tienda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_inicial_tienda_list->ListOptions->Render("body", "left", $cap_inventario_inicial_tienda_list->RowCnt);
?>
	<?php if ($cap_inventario_inicial_tienda->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Tel_SIM" class="cap_inventario_inicial_tienda_Id_Tel_SIM">
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Tel_SIM" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Id_Tel_SIM->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo">
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo"<?php echo $cap_inventario_inicial_tienda->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_inventario_inicial_tienda->Id_Articulo) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo`";
?>
<input type="hidden" name="s_x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_inventario_inicial_tienda->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq">
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_inicial_tiendalist.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Id_Acabado_eq->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI">
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" size="22" maxlength="15" value="<?php echo $cap_inventario_inicial_tienda->Num_IMEI->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_IMEI->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Num_IMEI->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID">
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" size="22" maxlength="19" value="<?php echo $cap_inventario_inicial_tienda->Num_ICCID->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_ICCID->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Num_ICCID->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_CEL->Visible) { // Num_CEL ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL">
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" size="11" maxlength="10" value="<?php echo $cap_inventario_inicial_tienda->Num_CEL->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_CEL->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Num_CEL->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<td><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor">
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor"<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Proveedor->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_inicial_tiendalist.Lists["x_Id_Proveedor"].Options = <?php echo (is_array($cap_inventario_inicial_tienda->Id_Proveedor->EditValue)) ? ew_ArrayToJson($cap_inventario_inicial_tienda->Id_Proveedor->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor" id="o<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Id_Proveedor->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_inicial_tienda_list->ListOptions->Render("body", "right", $cap_inventario_inicial_tienda_list->RowCnt);
?>
<script type="text/javascript">
fcap_inventario_inicial_tiendalist.UpdateOpts(<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cap_inventario_inicial_tienda->ExportAll && $cap_inventario_inicial_tienda->Export <> "") {
	$cap_inventario_inicial_tienda_list->StopRec = $cap_inventario_inicial_tienda_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_inventario_inicial_tienda_list->TotalRecs > $cap_inventario_inicial_tienda_list->StartRec + $cap_inventario_inicial_tienda_list->DisplayRecs - 1)
		$cap_inventario_inicial_tienda_list->StopRec = $cap_inventario_inicial_tienda_list->StartRec + $cap_inventario_inicial_tienda_list->DisplayRecs - 1;
	else
		$cap_inventario_inicial_tienda_list->StopRec = $cap_inventario_inicial_tienda_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_inventario_inicial_tienda->CurrentAction == "gridadd" || $cap_inventario_inicial_tienda->CurrentAction == "gridedit" || $cap_inventario_inicial_tienda->CurrentAction == "F")) {
		$cap_inventario_inicial_tienda_list->KeyCount = $objForm->GetValue("key_count");
		$cap_inventario_inicial_tienda_list->StopRec = $cap_inventario_inicial_tienda_list->KeyCount;
	}
}
$cap_inventario_inicial_tienda_list->RecCnt = $cap_inventario_inicial_tienda_list->StartRec - 1;
if ($cap_inventario_inicial_tienda_list->Recordset && !$cap_inventario_inicial_tienda_list->Recordset->EOF) {
	$cap_inventario_inicial_tienda_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_inventario_inicial_tienda_list->StartRec > 1)
		$cap_inventario_inicial_tienda_list->Recordset->Move($cap_inventario_inicial_tienda_list->StartRec - 1);
} elseif (!$cap_inventario_inicial_tienda->AllowAddDeleteRow && $cap_inventario_inicial_tienda_list->StopRec == 0) {
	$cap_inventario_inicial_tienda_list->StopRec = $cap_inventario_inicial_tienda->GridAddRowCount;
}

// Initialize aggregate
$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_inventario_inicial_tienda->ResetAttrs();
$cap_inventario_inicial_tienda_list->RenderRow();
$cap_inventario_inicial_tienda_list->EditRowCnt = 0;
if ($cap_inventario_inicial_tienda->CurrentAction == "edit")
	$cap_inventario_inicial_tienda_list->RowIndex = 1;
while ($cap_inventario_inicial_tienda_list->RecCnt < $cap_inventario_inicial_tienda_list->StopRec) {
	$cap_inventario_inicial_tienda_list->RecCnt++;
	if (intval($cap_inventario_inicial_tienda_list->RecCnt) >= intval($cap_inventario_inicial_tienda_list->StartRec)) {
		$cap_inventario_inicial_tienda_list->RowCnt++;

		// Set up key count
		$cap_inventario_inicial_tienda_list->KeyCount = $cap_inventario_inicial_tienda_list->RowIndex;

		// Init row class and style
		$cap_inventario_inicial_tienda->ResetAttrs();
		$cap_inventario_inicial_tienda->CssClass = "";
		if ($cap_inventario_inicial_tienda->CurrentAction == "gridadd") {
			$cap_inventario_inicial_tienda_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_inventario_inicial_tienda_list->LoadRowValues($cap_inventario_inicial_tienda_list->Recordset); // Load row values
		}
		$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_inventario_inicial_tienda->CurrentAction == "edit") {
			if ($cap_inventario_inicial_tienda_list->CheckInlineEditKey() && $cap_inventario_inicial_tienda_list->EditRowCnt == 0) { // Inline edit
				$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_inventario_inicial_tienda->CurrentAction == "edit" && $cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT && $cap_inventario_inicial_tienda->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_inventario_inicial_tienda_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_inventario_inicial_tienda_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_inventario_inicial_tienda->RowAttrs = array_merge($cap_inventario_inicial_tienda->RowAttrs, array('data-rowindex'=>$cap_inventario_inicial_tienda_list->RowCnt, 'id'=>'r' . $cap_inventario_inicial_tienda_list->RowCnt . '_cap_inventario_inicial_tienda', 'data-rowtype'=>$cap_inventario_inicial_tienda->RowType));

		// Render row
		$cap_inventario_inicial_tienda_list->RenderRow();

		// Render list options
		$cap_inventario_inicial_tienda_list->RenderListOptions();
?>
	<tr<?php echo $cap_inventario_inicial_tienda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_inicial_tienda_list->ListOptions->Render("body", "left", $cap_inventario_inicial_tienda_list->RowCnt);
?>
	<?php if ($cap_inventario_inicial_tienda->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Tel_SIM" class="cap_inventario_inicial_tienda_Id_Tel_SIM">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Tel_SIM" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_inventario_inicial_tienda->Id_Tel_SIM->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Tel_SIM->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo"<?php echo $cap_inventario_inicial_tienda->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_inventario_inicial_tienda->Id_Articulo) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo`";
?>
<input type="hidden" name="s_x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_inventario_inicial_tienda->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_inicial_tiendalist.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_inventario_inicial_tienda->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_inventario_inicial_tienda->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_IMEI" size="22" maxlength="15" value="<?php echo $cap_inventario_inicial_tienda->Num_IMEI->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_IMEI->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_IMEI->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $cap_inventario_inicial_tienda->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_ICCID" size="22" maxlength="19" value="<?php echo $cap_inventario_inicial_tienda->Num_ICCID->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_ICCID->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_ICCID->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_inventario_inicial_tienda->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Num_CEL" size="11" maxlength="10" value="<?php echo $cap_inventario_inicial_tienda->Num_CEL->EditValue ?>"<?php echo $cap_inventario_inicial_tienda->Num_CEL->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_CEL->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_list->RowCnt ?>_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor">
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor" name="x<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>_Id_Proveedor"<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_inicial_tienda->Id_Proveedor->EditValue)) {
	$arwrk = $cap_inventario_inicial_tienda->Id_Proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_inicial_tienda->Id_Proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_inicial_tiendalist.Lists["x_Id_Proveedor"].Options = <?php echo (is_array($cap_inventario_inicial_tienda->Id_Proveedor->EditValue)) ? ew_ArrayToJson($cap_inventario_inicial_tienda->Id_Proveedor->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_inicial_tienda_list->PageObjName . "_row_" . $cap_inventario_inicial_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_inicial_tienda_list->ListOptions->Render("body", "right", $cap_inventario_inicial_tienda_list->RowCnt);
?>
	</tr>
<?php if ($cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_ADD || $cap_inventario_inicial_tienda->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_inventario_inicial_tiendalist.UpdateOpts(<?php echo $cap_inventario_inicial_tienda_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_inventario_inicial_tienda->CurrentAction <> "gridadd")
		$cap_inventario_inicial_tienda_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->CurrentAction == "add" || $cap_inventario_inicial_tienda->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_inicial_tienda_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_inicial_tienda_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_inventario_inicial_tienda->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_inventario_inicial_tienda_list->Recordset)
	$cap_inventario_inicial_tienda_list->Recordset->Close();
?>
<?php if ($cap_inventario_inicial_tienda_list->TotalRecs > 0) { ?>
<?php if ($cap_inventario_inicial_tienda->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_inventario_inicial_tienda->CurrentAction <> "gridadd" && $cap_inventario_inicial_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_inventario_inicial_tienda_list->Pager)) $cap_inventario_inicial_tienda_list->Pager = new cNumericPager($cap_inventario_inicial_tienda_list->StartRec, $cap_inventario_inicial_tienda_list->DisplayRecs, $cap_inventario_inicial_tienda_list->TotalRecs, $cap_inventario_inicial_tienda_list->RecRange) ?>
<?php if ($cap_inventario_inicial_tienda_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_inventario_inicial_tienda_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_inventario_inicial_tienda_list->PageUrl() ?>start=<?php echo $cap_inventario_inicial_tienda_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_inventario_inicial_tienda_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_inventario_inicial_tienda_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_inventario_inicial_tienda_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_inventario_inicial_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_inventario_inicial_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_inventario_inicial_tienda_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_inventario_inicial_tienda_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_inventario_inicial_tienda_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_inventario_inicial_tienda->Export == "") { ?>
<script type="text/javascript">
fcap_inventario_inicial_tiendalistsrch.Init();
fcap_inventario_inicial_tiendalist.Init();
</script>
<?php } ?>
<?php
$cap_inventario_inicial_tienda_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_inventario_inicial_tienda->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

  pon_boton_cerrar();   
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_inventario_inicial_tienda_list->Page_Terminate();
?>
