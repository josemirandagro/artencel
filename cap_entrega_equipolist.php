<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_entrega_equipo_detgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_equipo_list = NULL; // Initialize page object first

class ccap_entrega_equipo_list extends ccap_entrega_equipo {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_equipo';

	// Page object name
	var $PageObjName = 'cap_entrega_equipo_list';

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

		// Table object (cap_entrega_equipo)
		if (!isset($GLOBALS["cap_entrega_equipo"])) {
			$GLOBALS["cap_entrega_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_equipo"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_entrega_equipoadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_entrega_equipodelete.php";
		$this->MultiUpdateUrl = "cap_entrega_equipoupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_equipo', TRUE);

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
		$this->Id_Traspaso->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Id_Almacen_Entrega->Visible = !$this->IsAddOrEdit();
		$this->Status->Visible = !$this->IsAddOrEdit();
		$this->Fecha->Visible = !$this->IsAddOrEdit();
		$this->Hora->Visible = !$this->IsAddOrEdit();
		$this->Id_Empleado_Entrega->Visible = !$this->IsAddOrEdit();

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
	var $cap_entrega_equipo_det_Count;
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
		$this->setKey("Id_Traspaso", ""); // Clear inline edit key
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
		if (@$_GET["Id_Traspaso"] <> "") {
			$this->Id_Traspaso->setQueryStringValue($_GET["Id_Traspaso"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Traspaso", $this->Id_Traspaso->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Traspaso")) <> strval($this->Id_Traspaso->CurrentValue))
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
			$this->Id_Traspaso->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Traspaso->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Observaciones, $Keyword);
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
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Traspaso); // Id_Traspaso
			$this->UpdateSort($this->Id_Almacen_Entrega); // Id_Almacen_Entrega
			$this->UpdateSort($this->Id_Almacen_Recibe); // Id_Almacen_Recibe
			$this->UpdateSort($this->Status); // Status
			$this->UpdateSort($this->Fecha); // Fecha
			$this->UpdateSort($this->Hora); // Hora
			$this->UpdateSort($this->Observaciones); // Observaciones
			$this->UpdateSort($this->Id_Empleado_Entrega); // Id_Empleado_Entrega
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
				$this->Fecha->setSort("DESC");
				$this->Hora->setSort("DESC");
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
				$this->Id_Traspaso->setSort("");
				$this->Id_Almacen_Entrega->setSort("");
				$this->Id_Almacen_Recibe->setSort("");
				$this->Status->setSort("");
				$this->Fecha->setSort("");
				$this->Hora->setSort("");
				$this->Observaciones->setSort("");
				$this->Id_Empleado_Entrega->setSort("");
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

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// "detail_cap_entrega_equipo_det"
		$item = &$this->ListOptions->Add("detail_cap_entrega_equipo_det");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cap_entrega_equipo_det');
		$item->OnLeft = TRUE;
		if (!isset($GLOBALS["cap_entrega_equipo_det_grid"])) $GLOBALS["cap_entrega_equipo_det_grid"] = new ccap_entrega_equipo_det_grid;

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
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_entrega_equipolist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Traspaso->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink\"" . "" . " href=\"" . $this->DeleteUrl . "\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";

		// "detail_cap_entrega_equipo_det"
		$oListOpt = &$this->ListOptions->Items["detail_cap_entrega_equipo_det"];
		if ($Security->AllowList(CurrentProjectID() . 'cap_entrega_equipo_det')) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_entrega_equipo_det", "TblCaption");
			$oListOpt->Body .= str_replace("%c", $this->cap_entrega_equipo_det_Count, $Language->Phrase("DetailCount"));
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"cap_entrega_equipo_detlist.php?" . EW_TABLE_SHOW_MASTER . "=cap_entrega_equipo&Id_Traspaso=" . urlencode(strval($this->Id_Traspaso->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
		$sSqlWrk = "`Id_Traspaso`=" . ew_AdjustSql($this->Id_Traspaso->CurrentValue) . "";
		$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
		$sSqlWrk = str_replace("'", "\'", $sSqlWrk);
		$oListOpt = &$this->ListOptions->Items["detail_cap_entrega_equipo_det"];
		$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . $Language->TablePhrase("cap_entrega_equipo_det", "TblCaption");
		$oListOpt->Body .= str_replace("%c", $this->cap_entrega_equipo_det_Count, $Language->Phrase("DetailCount"));
		$sHyperLinkParm = " href=\"cap_entrega_equipo_detlist.php?" . EW_TABLE_SHOW_MASTER . "=cap_entrega_equipo&Id_Traspaso=" . urlencode(strval($this->Id_Traspaso->CurrentValue)) . "\" id=\"dl%i_cap_entrega_equipo_cap_entrega_equipo_det\" onmouseover=\"ew_ShowDetails(this, 'cap_entrega_equipo_detpreview.php?f=%s')\" onmouseout=\"ew_HideDetails();\"";
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
		$this->Id_Traspaso->CurrentValue = NULL;
		$this->Id_Traspaso->OldValue = $this->Id_Traspaso->CurrentValue;
		$this->Id_Almacen_Entrega->CurrentValue = NULL;
		$this->Id_Almacen_Entrega->OldValue = $this->Id_Almacen_Entrega->CurrentValue;
		$this->Id_Almacen_Recibe->CurrentValue = NULL;
		$this->Id_Almacen_Recibe->OldValue = $this->Id_Almacen_Recibe->CurrentValue;
		$this->Status->CurrentValue = "Enviado";
		$this->Fecha->CurrentValue = NULL;
		$this->Fecha->OldValue = $this->Fecha->CurrentValue;
		$this->Hora->CurrentValue = NULL;
		$this->Hora->OldValue = $this->Hora->CurrentValue;
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
		$this->Id_Empleado_Entrega->CurrentValue = NULL;
		$this->Id_Empleado_Entrega->OldValue = $this->Id_Empleado_Entrega->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Traspaso->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Traspaso->setFormValue($objForm->GetValue("x_Id_Traspaso"));
		if (!$this->Id_Almacen_Entrega->FldIsDetailKey) {
			$this->Id_Almacen_Entrega->setFormValue($objForm->GetValue("x_Id_Almacen_Entrega"));
		}
		if (!$this->Id_Almacen_Recibe->FldIsDetailKey) {
			$this->Id_Almacen_Recibe->setFormValue($objForm->GetValue("x_Id_Almacen_Recibe"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->Hora->FldIsDetailKey) {
			$this->Hora->setFormValue($objForm->GetValue("x_Hora"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->Id_Empleado_Entrega->FldIsDetailKey) {
			$this->Id_Empleado_Entrega->setFormValue($objForm->GetValue("x_Id_Empleado_Entrega"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Traspaso->CurrentValue = $this->Id_Traspaso->FormValue;
		$this->Id_Almacen_Entrega->CurrentValue = $this->Id_Almacen_Entrega->FormValue;
		$this->Id_Almacen_Recibe->CurrentValue = $this->Id_Almacen_Recibe->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->Hora->CurrentValue = $this->Hora->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->Id_Empleado_Entrega->CurrentValue = $this->Id_Empleado_Entrega->FormValue;
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
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Id_Almacen_Entrega->setDbValue($rs->fields('Id_Almacen_Entrega'));
		$this->Id_Almacen_Recibe->setDbValue($rs->fields('Id_Almacen_Recibe'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Hora->setDbValue($rs->fields('Hora'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Id_Empleado_Entrega->setDbValue($rs->fields('Id_Empleado_Entrega'));
		if (!isset($GLOBALS["cap_entrega_equipo_det_grid"])) $GLOBALS["cap_entrega_equipo_det_grid"] = new ccap_entrega_equipo_det_grid;
		$sDetailFilter = $GLOBALS["cap_entrega_equipo_det"]->SqlDetailFilter_cap_entrega_equipo();
		$sDetailFilter = str_replace("@Id_Traspaso@", ew_AdjustSql($this->Id_Traspaso->DbValue), $sDetailFilter);
		$GLOBALS["cap_entrega_equipo_det"]->setCurrentMasterTable("cap_entrega_equipo");
		$sDetailFilter = $GLOBALS["cap_entrega_equipo_det"]->ApplyUserIDFilters($sDetailFilter);
		$this->cap_entrega_equipo_det_Count = $GLOBALS["cap_entrega_equipo_det"]->LoadRecordCount($sDetailFilter);
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Traspaso")) <> "")
			$this->Id_Traspaso->CurrentValue = $this->getKey("Id_Traspaso"); // Id_Traspaso
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
		// Id_Traspaso
		// Id_Almacen_Entrega
		// Id_Almacen_Recibe
		// Status
		// Fecha
		// Hora
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// Observaciones
		// Id_Empleado_Entrega

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Traspaso
			$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";

			// Id_Almacen_Entrega
			if (strval($this->Id_Almacen_Entrega->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Entrega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Entrega->ViewValue = $this->Id_Almacen_Entrega->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Entrega->ViewValue = NULL;
			}
			$this->Id_Almacen_Entrega->ViewCustomAttributes = "";

			// Id_Almacen_Recibe
			if (strval($this->Id_Almacen_Recibe->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Recibe->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Recibe->ViewValue = $this->Id_Almacen_Recibe->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Recibe->ViewValue = NULL;
			}
			$this->Id_Almacen_Recibe->ViewCustomAttributes = "";

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
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Hora
			$this->Hora->ViewValue = $this->Hora->CurrentValue;
			$this->Hora->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// Id_Empleado_Entrega
			if (strval($this->Id_Empleado_Entrega->CurrentValue) <> "") {
				$sFilterWrk = "`IdEmpleado`" . ew_SearchString("=", $this->Id_Empleado_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `IdEmpleado`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_empleados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Empleado_Entrega->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Empleado_Entrega->ViewValue = $this->Id_Empleado_Entrega->CurrentValue;
				}
			} else {
				$this->Id_Empleado_Entrega->ViewValue = NULL;
			}
			$this->Id_Empleado_Entrega->ViewCustomAttributes = "";

			// Id_Traspaso
			$this->Id_Traspaso->LinkCustomAttributes = "";
			$this->Id_Traspaso->HrefValue = "";
			$this->Id_Traspaso->TooltipValue = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrega->HrefValue = "";
			$this->Id_Almacen_Entrega->TooltipValue = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->LinkCustomAttributes = "";
			$this->Id_Almacen_Recibe->HrefValue = "";
			$this->Id_Almacen_Recibe->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Hora
			$this->Hora->LinkCustomAttributes = "";
			$this->Hora->HrefValue = "";
			$this->Hora->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->LinkCustomAttributes = "";
			$this->Id_Empleado_Entrega->HrefValue = "";
			$this->Id_Empleado_Entrega->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Traspaso
			// Id_Almacen_Entrega
			// Id_Almacen_Recibe

			$this->Id_Almacen_Recibe->EditCustomAttributes = "";

			// Status
			// Fecha
			// Hora
			// Observaciones

			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Id_Empleado_Entrega
			// Edit refer script
			// Id_Traspaso

			$this->Id_Traspaso->HrefValue = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->HrefValue = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Hora
			$this->Hora->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Traspaso
			$this->Id_Traspaso->EditCustomAttributes = "";
			$this->Id_Traspaso->EditValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";

			// Id_Almacen_Entrega
			// Id_Almacen_Recibe

			$this->Id_Almacen_Recibe->EditCustomAttributes = "";
			if (trim(strval($this->Id_Almacen_Recibe->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Recibe->EditValue = $arwrk;

			// Status
			// Fecha
			// Hora
			// Observaciones

			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Id_Empleado_Entrega
			// Edit refer script
			// Id_Traspaso

			$this->Id_Traspaso->HrefValue = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->HrefValue = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Hora
			$this->Hora->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($this->Id_Almacen_Recibe->FormValue) && $this->Id_Almacen_Recibe->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Almacen_Recibe->FldCaption());
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

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->SetDbValueDef($rsnew, Id_Tienda_actual(), 0);
			$rsnew['Id_Almacen_Entrega'] = &$this->Id_Almacen_Entrega->DbValue;

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->SetDbValueDef($rsnew, $this->Id_Almacen_Recibe->CurrentValue, 0, $this->Id_Almacen_Recibe->ReadOnly);

			// Observaciones
			$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, $this->Observaciones->ReadOnly);

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->SetDbValueDef($rsnew, CurrentUserID(), 0);
			$rsnew['Id_Empleado_Entrega'] = &$this->Id_Empleado_Entrega->DbValue;

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
		$rsnew = array();

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->SetDbValueDef($rsnew, Id_Tienda_actual(), 0);
		$rsnew['Id_Almacen_Entrega'] = &$this->Id_Almacen_Entrega->DbValue;

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe->SetDbValueDef($rsnew, $this->Id_Almacen_Recibe->CurrentValue, 0, FALSE);

		// Status
		$this->Status->SetDbValueDef($rsnew, Enviado(), "");
		$rsnew['Status'] = &$this->Status->DbValue;

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_CurrentDate(), ew_CurrentDate());
		$rsnew['Fecha'] = &$this->Fecha->DbValue;

		// Hora
		$this->Hora->SetDbValueDef($rsnew, ew_CurrentTime(), ew_CurrentTime());
		$rsnew['Hora'] = &$this->Hora->DbValue;

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Id_Empleado_Entrega
		$this->Id_Empleado_Entrega->SetDbValueDef($rsnew, CurrentUserID(), 0);
		$rsnew['Id_Empleado_Entrega'] = &$this->Id_Empleado_Entrega->DbValue;

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
			$this->Id_Traspaso->setDbValue($conn->Insert_ID());
			$rsnew['Id_Traspaso'] = $this->Id_Traspaso->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$item->Body = "<a id=\"emf_cap_entrega_equipo\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_entrega_equipo',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_entrega_equipolist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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

	  // Deshabilito la insercion master/detail, para dejar solo la insercion MASTER
	  $GLOBALS["cap_traspaso_tel_sim_det"]->DetailAdd = FALSE;                    
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
if (!isset($cap_entrega_equipo_list)) $cap_entrega_equipo_list = new ccap_entrega_equipo_list();

// Page init
$cap_entrega_equipo_list->Page_Init();

// Page main
$cap_entrega_equipo_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_entrega_equipo->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_entrega_equipo_list = new ew_Page("cap_entrega_equipo_list");
cap_entrega_equipo_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_entrega_equipo_list.PageID; // For backward compatibility

// Form object
var fcap_entrega_equipolist = new ew_Form("fcap_entrega_equipolist");

// Validate form
fcap_entrega_equipolist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Almacen_Recibe"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_equipo->Id_Almacen_Recibe->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_entrega_equipolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_equipolist.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_equipolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_equipolist.Lists["x_Id_Almacen_Entrega"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_equipolist.Lists["x_Id_Almacen_Recibe"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_equipolist.Lists["x_Id_Empleado_Entrega"] = {"LinkField":"x_IdEmpleado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_entrega_equipolistsrch = new ew_Form("fcap_entrega_equipolistsrch");
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
		$cap_entrega_equipo_list->TotalRecs = $cap_entrega_equipo->SelectRecordCount();
	} else {
		if ($cap_entrega_equipo_list->Recordset = $cap_entrega_equipo_list->LoadRecordset())
			$cap_entrega_equipo_list->TotalRecs = $cap_entrega_equipo_list->Recordset->RecordCount();
	}
	$cap_entrega_equipo_list->StartRec = 1;
	if ($cap_entrega_equipo_list->DisplayRecs <= 0 || ($cap_entrega_equipo->Export <> "" && $cap_entrega_equipo->ExportAll)) // Display all records
		$cap_entrega_equipo_list->DisplayRecs = $cap_entrega_equipo_list->TotalRecs;
	if (!($cap_entrega_equipo->Export <> "" && $cap_entrega_equipo->ExportAll))
		$cap_entrega_equipo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_entrega_equipo_list->Recordset = $cap_entrega_equipo_list->LoadRecordset($cap_entrega_equipo_list->StartRec-1, $cap_entrega_equipo_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_equipo->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_entrega_equipo_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_entrega_equipo->Export == "" && $cap_entrega_equipo->CurrentAction == "") { ?>
<form name="fcap_entrega_equipolistsrch" id="fcap_entrega_equipolistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<a href="javascript:fcap_entrega_equipolistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_entrega_equipolistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_entrega_equipolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_entrega_equipo">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_entrega_equipo_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_entrega_equipo_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_entrega_equipo_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_entrega_equipo_list->ShowPageHeader(); ?>
<?php
$cap_entrega_equipo_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_entrega_equipo->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_entrega_equipo->CurrentAction <> "gridadd" && $cap_entrega_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_entrega_equipo_list->Pager)) $cap_entrega_equipo_list->Pager = new cPrevNextPager($cap_entrega_equipo_list->StartRec, $cap_entrega_equipo_list->DisplayRecs, $cap_entrega_equipo_list->TotalRecs) ?>
<?php if ($cap_entrega_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_entrega_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_entrega_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_entrega_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_entrega_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_entrega_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_entrega_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_entrega_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_entrega_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_entrega_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_entrega_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_entrega_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_entrega_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_entrega_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_entrega_equipo_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_equipo_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cap_entrega_equipo_det_grid->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'cap_entrega_equipo_det')) { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_equipo->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=cap_entrega_equipo_det" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $cap_entrega_equipo->TableCaption() ?>/<?php echo $cap_entrega_equipo_det->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_entrega_equipolist" id="fcap_entrega_equipolist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_entrega_equipo">
<div id="gmp_cap_entrega_equipo" class="ewGridMiddlePanel">
<?php if ($cap_entrega_equipo_list->TotalRecs > 0) { ?>
<table id="tbl_cap_entrega_equipolist" class="ewTable ewTableSeparate">
<?php echo $cap_entrega_equipo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_entrega_equipo_list->RenderListOptions();

// Render list options (header, left)
$cap_entrega_equipo_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_entrega_equipo->Id_Traspaso->Visible) { // Id_Traspaso ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Traspaso) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Id_Traspaso" class="cap_entrega_equipo_Id_Traspaso"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Id_Traspaso->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Traspaso) ?>',1);"><span id="elh_cap_entrega_equipo_Id_Traspaso" class="cap_entrega_equipo_Id_Traspaso">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Id_Traspaso->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Id_Traspaso->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Id_Traspaso->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Id_Almacen_Entrega->Visible) { // Id_Almacen_Entrega ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Almacen_Entrega) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Id_Almacen_Entrega" class="cap_entrega_equipo_Id_Almacen_Entrega"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Id_Almacen_Entrega->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Almacen_Entrega) ?>',1);"><span id="elh_cap_entrega_equipo_Id_Almacen_Entrega" class="cap_entrega_equipo_Id_Almacen_Entrega">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Id_Almacen_Entrega->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Id_Almacen_Entrega->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Id_Almacen_Entrega->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Almacen_Recibe) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Id_Almacen_Recibe" class="cap_entrega_equipo_Id_Almacen_Recibe"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Id_Almacen_Recibe->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Almacen_Recibe) ?>',1);"><span id="elh_cap_entrega_equipo_Id_Almacen_Recibe" class="cap_entrega_equipo_Id_Almacen_Recibe">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Id_Almacen_Recibe->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Id_Almacen_Recibe->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Id_Almacen_Recibe->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Status->Visible) { // Status ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Status) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Status" class="cap_entrega_equipo_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Status) ?>',1);"><span id="elh_cap_entrega_equipo_Status" class="cap_entrega_equipo_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Fecha->Visible) { // Fecha ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Fecha) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Fecha" class="cap_entrega_equipo_Fecha"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Fecha->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Fecha) ?>',1);"><span id="elh_cap_entrega_equipo_Fecha" class="cap_entrega_equipo_Fecha">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Fecha->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Fecha->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Fecha->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Hora->Visible) { // Hora ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Hora) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Hora" class="cap_entrega_equipo_Hora"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Hora->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Hora) ?>',1);"><span id="elh_cap_entrega_equipo_Hora" class="cap_entrega_equipo_Hora">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Hora->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Hora->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Hora->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Observaciones->Visible) { // Observaciones ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Observaciones) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Observaciones" class="cap_entrega_equipo_Observaciones"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Observaciones->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Observaciones) ?>',1);"><span id="elh_cap_entrega_equipo_Observaciones" class="cap_entrega_equipo_Observaciones">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Observaciones->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Observaciones->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Observaciones->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo->Id_Empleado_Entrega->Visible) { // Id_Empleado_Entrega ?>
	<?php if ($cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Empleado_Entrega) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_Id_Empleado_Entrega" class="cap_entrega_equipo_Id_Empleado_Entrega"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo->Id_Empleado_Entrega->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_equipo->SortUrl($cap_entrega_equipo->Id_Empleado_Entrega) ?>',1);"><span id="elh_cap_entrega_equipo_Id_Empleado_Entrega" class="cap_entrega_equipo_Id_Empleado_Entrega">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo->Id_Empleado_Entrega->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo->Id_Empleado_Entrega->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo->Id_Empleado_Entrega->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_entrega_equipo_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_entrega_equipo->ExportAll && $cap_entrega_equipo->Export <> "") {
	$cap_entrega_equipo_list->StopRec = $cap_entrega_equipo_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_entrega_equipo_list->TotalRecs > $cap_entrega_equipo_list->StartRec + $cap_entrega_equipo_list->DisplayRecs - 1)
		$cap_entrega_equipo_list->StopRec = $cap_entrega_equipo_list->StartRec + $cap_entrega_equipo_list->DisplayRecs - 1;
	else
		$cap_entrega_equipo_list->StopRec = $cap_entrega_equipo_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_entrega_equipo->CurrentAction == "gridadd" || $cap_entrega_equipo->CurrentAction == "gridedit" || $cap_entrega_equipo->CurrentAction == "F")) {
		$cap_entrega_equipo_list->KeyCount = $objForm->GetValue("key_count");
		$cap_entrega_equipo_list->StopRec = $cap_entrega_equipo_list->KeyCount;
	}
}
$cap_entrega_equipo_list->RecCnt = $cap_entrega_equipo_list->StartRec - 1;
if ($cap_entrega_equipo_list->Recordset && !$cap_entrega_equipo_list->Recordset->EOF) {
	$cap_entrega_equipo_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_entrega_equipo_list->StartRec > 1)
		$cap_entrega_equipo_list->Recordset->Move($cap_entrega_equipo_list->StartRec - 1);
} elseif (!$cap_entrega_equipo->AllowAddDeleteRow && $cap_entrega_equipo_list->StopRec == 0) {
	$cap_entrega_equipo_list->StopRec = $cap_entrega_equipo->GridAddRowCount;
}

// Initialize aggregate
$cap_entrega_equipo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_entrega_equipo->ResetAttrs();
$cap_entrega_equipo_list->RenderRow();
$cap_entrega_equipo_list->EditRowCnt = 0;
if ($cap_entrega_equipo->CurrentAction == "edit")
	$cap_entrega_equipo_list->RowIndex = 1;
while ($cap_entrega_equipo_list->RecCnt < $cap_entrega_equipo_list->StopRec) {
	$cap_entrega_equipo_list->RecCnt++;
	if (intval($cap_entrega_equipo_list->RecCnt) >= intval($cap_entrega_equipo_list->StartRec)) {
		$cap_entrega_equipo_list->RowCnt++;

		// Set up key count
		$cap_entrega_equipo_list->KeyCount = $cap_entrega_equipo_list->RowIndex;

		// Init row class and style
		$cap_entrega_equipo->ResetAttrs();
		$cap_entrega_equipo->CssClass = "";
		if ($cap_entrega_equipo->CurrentAction == "gridadd") {
			$cap_entrega_equipo_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_entrega_equipo_list->LoadRowValues($cap_entrega_equipo_list->Recordset); // Load row values
		}
		$cap_entrega_equipo->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_entrega_equipo->CurrentAction == "edit") {
			if ($cap_entrega_equipo_list->CheckInlineEditKey() && $cap_entrega_equipo_list->EditRowCnt == 0) { // Inline edit
				$cap_entrega_equipo->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_entrega_equipo->CurrentAction == "edit" && $cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT && $cap_entrega_equipo->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_entrega_equipo_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_entrega_equipo_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_entrega_equipo->RowAttrs = array_merge($cap_entrega_equipo->RowAttrs, array('data-rowindex'=>$cap_entrega_equipo_list->RowCnt, 'id'=>'r' . $cap_entrega_equipo_list->RowCnt . '_cap_entrega_equipo', 'data-rowtype'=>$cap_entrega_equipo->RowType));

		// Render row
		$cap_entrega_equipo_list->RenderRow();

		// Render list options
		$cap_entrega_equipo_list->RenderListOptions();
?>
	<tr<?php echo $cap_entrega_equipo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_equipo_list->ListOptions->Render("body", "left", $cap_entrega_equipo_list->RowCnt);
?>
	<?php if ($cap_entrega_equipo->Id_Traspaso->Visible) { // Id_Traspaso ?>
		<td<?php echo $cap_entrega_equipo->Id_Traspaso->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Id_Traspaso" class="cap_entrega_equipo_Id_Traspaso">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_entrega_equipo->Id_Traspaso->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Id_Traspaso->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Traspaso" id="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Traspaso" value="<?php echo ew_HtmlEncode($cap_entrega_equipo->Id_Traspaso->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Id_Traspaso->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Id_Traspaso->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Id_Almacen_Entrega->Visible) { // Id_Almacen_Entrega ?>
		<td<?php echo $cap_entrega_equipo->Id_Almacen_Entrega->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Id_Almacen_Entrega" class="cap_entrega_equipo_Id_Almacen_Entrega">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Id_Almacen_Entrega->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Id_Almacen_Entrega->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
		<td<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Id_Almacen_Recibe" class="cap_entrega_equipo_Id_Almacen_Recibe">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Almacen_Recibe" name="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Almacen_Recibe"<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo->Id_Almacen_Recibe->EditValue)) {
	$arwrk = $cap_entrega_equipo->Id_Almacen_Recibe->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo->Id_Almacen_Recibe->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Almacen` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Almacen_Recibe" id="s_x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Id_Almacen_Recibe" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo->Id_Almacen_Recibe->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Almacen` = {filter_value}"); ?>&t0=19">
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Status->Visible) { // Status ?>
		<td<?php echo $cap_entrega_equipo->Status->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Status" class="cap_entrega_equipo_Status">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Status->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Status->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Fecha->Visible) { // Fecha ?>
		<td<?php echo $cap_entrega_equipo->Fecha->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Fecha" class="cap_entrega_equipo_Fecha">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Fecha->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Hora->Visible) { // Hora ?>
		<td<?php echo $cap_entrega_equipo->Hora->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Hora" class="cap_entrega_equipo_Hora">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Hora->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Observaciones->Visible) { // Observaciones ?>
		<td<?php echo $cap_entrega_equipo->Observaciones->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Observaciones" class="cap_entrega_equipo_Observaciones">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<textarea name="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Observaciones" id="x<?php echo $cap_entrega_equipo_list->RowIndex ?>_Observaciones" cols="50" rows="4"<?php echo $cap_entrega_equipo->Observaciones->EditAttributes() ?>><?php echo $cap_entrega_equipo->Observaciones->EditValue ?></textarea>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Observaciones->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Observaciones->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo->Id_Empleado_Entrega->Visible) { // Id_Empleado_Entrega ?>
		<td<?php echo $cap_entrega_equipo->Id_Empleado_Entrega->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_list->RowCnt ?>_cap_entrega_equipo_Id_Empleado_Entrega" class="cap_entrega_equipo_Id_Empleado_Entrega">
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo->Id_Empleado_Entrega->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo->Id_Empleado_Entrega->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_list->PageObjName . "_row_" . $cap_entrega_equipo_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_equipo_list->ListOptions->Render("body", "right", $cap_entrega_equipo_list->RowCnt);
?>
	</tr>
<?php if ($cap_entrega_equipo->RowType == EW_ROWTYPE_ADD || $cap_entrega_equipo->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_entrega_equipolist.UpdateOpts(<?php echo $cap_entrega_equipo_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_entrega_equipo->CurrentAction <> "gridadd")
		$cap_entrega_equipo_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_entrega_equipo->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_equipo_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_entrega_equipo->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_entrega_equipo_list->Recordset)
	$cap_entrega_equipo_list->Recordset->Close();
?>
<?php if ($cap_entrega_equipo_list->TotalRecs > 0) { ?>
<?php if ($cap_entrega_equipo->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_entrega_equipo->CurrentAction <> "gridadd" && $cap_entrega_equipo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_entrega_equipo_list->Pager)) $cap_entrega_equipo_list->Pager = new cPrevNextPager($cap_entrega_equipo_list->StartRec, $cap_entrega_equipo_list->DisplayRecs, $cap_entrega_equipo_list->TotalRecs) ?>
<?php if ($cap_entrega_equipo_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_entrega_equipo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_entrega_equipo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_entrega_equipo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_entrega_equipo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_entrega_equipo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_entrega_equipo_list->PageUrl() ?>start=<?php echo $cap_entrega_equipo_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_entrega_equipo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_entrega_equipo_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_entrega_equipo_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_entrega_equipo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_entrega_equipo_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_entrega_equipo_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_entrega_equipo_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_entrega_equipo_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_entrega_equipo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_entrega_equipo_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_equipo_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cap_entrega_equipo_det_grid->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'cap_entrega_equipo_det')) { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_equipo->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=cap_entrega_equipo_det" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $cap_entrega_equipo->TableCaption() ?>/<?php echo $cap_entrega_equipo_det->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_entrega_equipo->Export == "") { ?>
<script type="text/javascript">
fcap_entrega_equipolistsrch.Init();
fcap_entrega_equipolist.Init();
</script>
<?php } ?>
<?php
$cap_entrega_equipo_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_entrega_equipo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_equipo_list->Page_Terminate();
?>
