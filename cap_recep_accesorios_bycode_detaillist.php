<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_recep_accesorios_bycode_detailinfo.php" ?>
<?php include_once "cap_recep_accesorios_bycodeinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_recep_accesorios_bycode_detail_list = NULL; // Initialize page object first

class ccap_recep_accesorios_bycode_detail_list extends ccap_recep_accesorios_bycode_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_recep_accesorios_bycode_detail';

	// Page object name
	var $PageObjName = 'cap_recep_accesorios_bycode_detail_list';

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

		// Table object (cap_recep_accesorios_bycode_detail)
		if (!isset($GLOBALS["cap_recep_accesorios_bycode_detail"])) {
			$GLOBALS["cap_recep_accesorios_bycode_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_recep_accesorios_bycode_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_recep_accesorios_bycode_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_recep_accesorios_bycode_detaildelete.php";
		$this->MultiUpdateUrl = "cap_recep_accesorios_bycode_detailupdate.php";

		// Table object (cap_recep_accesorios_bycode)
		if (!isset($GLOBALS['cap_recep_accesorios_bycode'])) $GLOBALS['cap_recep_accesorios_bycode'] = new ccap_recep_accesorios_bycode();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_recep_accesorios_bycode_detail', TRUE);

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

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_recep_accesorios_bycode") {
			global $cap_recep_accesorios_bycode;
			$rsmaster = $cap_recep_accesorios_bycode->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cap_recep_accesorios_bycodelist.php"); // Return to master page
			} else {
				$cap_recep_accesorios_bycode->LoadListRowValues($rsmaster);
				$cap_recep_accesorios_bycode->RowType = EW_ROWTYPE_MASTER; // Master row
				$cap_recep_accesorios_bycode->RenderListRow();
				$rsmaster->Close();
			}
		}

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
		$this->setKey("Id_Compra_Det", ""); // Clear inline edit key
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
		if (@$_GET["Id_Compra_Det"] <> "") {
			$this->Id_Compra_Det->setQueryStringValue($_GET["Id_Compra_Det"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Compra_Det", $this->Id_Compra_Det->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Compra_Det")) <> strval($this->Id_Compra_Det->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["Id_Compra_Det"] <> "") {
				$this->Id_Compra_Det->setQueryStringValue($_GET["Id_Compra_Det"]);
				$this->setKey("Id_Compra_Det", $this->Id_Compra_Det->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Compra_Det", ""); // Clear key
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
			$this->Id_Compra_Det->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Compra_Det->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->BarCode_Externo); // BarCode_Externo
			$this->UpdateSort($this->Id_Articulo); // Id_Articulo
			$this->UpdateSort($this->CantRecibida); // CantRecibida
			$this->UpdateSort($this->Precio_Unitario); // Precio_Unitario
			$this->UpdateSort($this->MontoTotal); // MontoTotal
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Id_Compra->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->setSessionOrderByList($sOrderBy);
				$this->BarCode_Externo->setSort("");
				$this->Id_Articulo->setSort("");
				$this->CantRecibida->setSort("");
				$this->Precio_Unitario->setSort("");
				$this->MontoTotal->setSort("");
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
				"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_recep_accesorios_bycode_detaillist'].Submit();\">" . "<img src=\"phpimages/insert.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
				"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_recep_accesorios_bycode_detaillist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Compra_Det->CurrentValue) . "\">";
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
		$this->BarCode_Externo->CurrentValue = NULL;
		$this->BarCode_Externo->OldValue = $this->BarCode_Externo->CurrentValue;
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->CantRecibida->CurrentValue = 1;
		$this->Precio_Unitario->CurrentValue = NULL;
		$this->Precio_Unitario->OldValue = $this->Precio_Unitario->CurrentValue;
		$this->MontoTotal->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->BarCode_Externo->FldIsDetailKey) {
			$this->BarCode_Externo->setFormValue($objForm->GetValue("x_BarCode_Externo"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->CantRecibida->FldIsDetailKey) {
			$this->CantRecibida->setFormValue($objForm->GetValue("x_CantRecibida"));
		}
		if (!$this->Precio_Unitario->FldIsDetailKey) {
			$this->Precio_Unitario->setFormValue($objForm->GetValue("x_Precio_Unitario"));
		}
		if (!$this->MontoTotal->FldIsDetailKey) {
			$this->MontoTotal->setFormValue($objForm->GetValue("x_MontoTotal"));
		}
		if (!$this->Id_Compra_Det->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Compra_Det->setFormValue($objForm->GetValue("x_Id_Compra_Det"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Compra_Det->CurrentValue = $this->Id_Compra_Det->FormValue;
		$this->BarCode_Externo->CurrentValue = $this->BarCode_Externo->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->CantRecibida->CurrentValue = $this->CantRecibida->FormValue;
		$this->Precio_Unitario->CurrentValue = $this->Precio_Unitario->FormValue;
		$this->MontoTotal->CurrentValue = $this->MontoTotal->FormValue;
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
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->BarCode_Externo->setDbValue($rs->fields('BarCode_Externo'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		if (array_key_exists('EV__Id_Articulo', $rs->fields)) {
			$this->Id_Articulo->VirtualValue = $rs->fields('EV__Id_Articulo'); // Set up virtual field value
		} else {
			$this->Id_Articulo->VirtualValue = ""; // Clear value
		}
		$this->CantRecibida->setDbValue($rs->fields('CantRecibida'));
		$this->Precio_Unitario->setDbValue($rs->fields('Precio_Unitario'));
		$this->MontoTotal->setDbValue($rs->fields('MontoTotal'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Compra_Det")) <> "")
			$this->Id_Compra_Det->CurrentValue = $this->getKey("Id_Compra_Det"); // Id_Compra_Det
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

		// Convert decimal values if posted back
		if ($this->Precio_Unitario->FormValue == $this->Precio_Unitario->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_Unitario->CurrentValue)))
			$this->Precio_Unitario->CurrentValue = ew_StrToFloat($this->Precio_Unitario->CurrentValue);

		// Convert decimal values if posted back
		if ($this->MontoTotal->FormValue == $this->MontoTotal->CurrentValue && is_numeric(ew_StrToFloat($this->MontoTotal->CurrentValue)))
			$this->MontoTotal->CurrentValue = ew_StrToFloat($this->MontoTotal->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Compra_Det

		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Id_Compra
		$this->Id_Compra->CellCssStyle = "white-space: nowrap;";

		// BarCode_Externo
		// Id_Articulo
		// CantRecibida
		// Precio_Unitario
		// MontoTotal
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// Accumulate aggregate value
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->CantRecibida->CurrentValue))
				$this->CantRecibida->Total += $this->CantRecibida->CurrentValue; // Accumulate total
			if (is_numeric($this->MontoTotal->CurrentValue))
				$this->MontoTotal->Total += $this->MontoTotal->CurrentValue; // Accumulate total
		}
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// BarCode_Externo
			if (strval($this->BarCode_Externo->CurrentValue) <> "") {
				$sFilterWrk = "`BarCode_Externo`" . ew_SearchString("=", $this->BarCode_Externo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `BarCode_Externo`, `BarCode_Externo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->BarCode_Externo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->BarCode_Externo->ViewValue = $this->BarCode_Externo->CurrentValue;
				}
			} else {
				$this->BarCode_Externo->ViewValue = NULL;
			}
			$this->BarCode_Externo->ViewCustomAttributes = "";

			// Id_Articulo
			if ($this->Id_Articulo->VirtualValue <> "") {
				$this->Id_Articulo->ViewValue = $this->Id_Articulo->VirtualValue;
			} else {
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
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
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// CantRecibida
			$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
			$this->CantRecibida->ViewCustomAttributes = "";

			// Precio_Unitario
			$this->Precio_Unitario->ViewValue = $this->Precio_Unitario->CurrentValue;
			$this->Precio_Unitario->ViewValue = ew_FormatCurrency($this->Precio_Unitario->ViewValue, 2, -2, -2, -2);
			$this->Precio_Unitario->ViewCustomAttributes = "";

			// MontoTotal
			$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";

			// BarCode_Externo
			$this->BarCode_Externo->LinkCustomAttributes = "";
			$this->BarCode_Externo->HrefValue = "";
			$this->BarCode_Externo->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// CantRecibida
			$this->CantRecibida->LinkCustomAttributes = "";
			$this->CantRecibida->HrefValue = "";
			$this->CantRecibida->TooltipValue = "";

			// Precio_Unitario
			$this->Precio_Unitario->LinkCustomAttributes = "";
			$this->Precio_Unitario->HrefValue = "";
			$this->Precio_Unitario->TooltipValue = "";

			// MontoTotal
			$this->MontoTotal->LinkCustomAttributes = "";
			$this->MontoTotal->HrefValue = "";
			$this->MontoTotal->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			if (trim(strval($this->BarCode_Externo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`BarCode_Externo`" . ew_SearchString("=", $this->BarCode_Externo->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `BarCode_Externo`, `BarCode_Externo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->BarCode_Externo->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
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
			$this->Id_Articulo->EditValue = $arwrk;

			// CantRecibida
			$this->CantRecibida->EditCustomAttributes = "";
			$this->CantRecibida->EditValue = ew_HtmlEncode($this->CantRecibida->CurrentValue);

			// Precio_Unitario
			$this->Precio_Unitario->EditCustomAttributes = "";
			$this->Precio_Unitario->EditValue = ew_HtmlEncode($this->Precio_Unitario->CurrentValue);
			if (strval($this->Precio_Unitario->EditValue) <> "" && is_numeric($this->Precio_Unitario->EditValue)) $this->Precio_Unitario->EditValue = ew_FormatNumber($this->Precio_Unitario->EditValue, -2, -2, -2, -2);

			// MontoTotal
			$this->MontoTotal->EditCustomAttributes = "";
			$this->MontoTotal->EditValue = ew_HtmlEncode($this->MontoTotal->CurrentValue);
			if (strval($this->MontoTotal->EditValue) <> "" && is_numeric($this->MontoTotal->EditValue)) $this->MontoTotal->EditValue = ew_FormatNumber($this->MontoTotal->EditValue, -2, -2, -2, -2);

			// Edit refer script
			// BarCode_Externo

			$this->BarCode_Externo->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// CantRecibida
			$this->CantRecibida->HrefValue = "";

			// Precio_Unitario
			$this->Precio_Unitario->HrefValue = "";

			// MontoTotal
			$this->MontoTotal->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			if (trim(strval($this->BarCode_Externo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`BarCode_Externo`" . ew_SearchString("=", $this->BarCode_Externo->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `BarCode_Externo`, `BarCode_Externo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->BarCode_Externo->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
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
			$this->Id_Articulo->EditValue = $arwrk;

			// CantRecibida
			$this->CantRecibida->EditCustomAttributes = "";
			$this->CantRecibida->EditValue = ew_HtmlEncode($this->CantRecibida->CurrentValue);

			// Precio_Unitario
			$this->Precio_Unitario->EditCustomAttributes = "";
			$this->Precio_Unitario->EditValue = ew_HtmlEncode($this->Precio_Unitario->CurrentValue);
			if (strval($this->Precio_Unitario->EditValue) <> "" && is_numeric($this->Precio_Unitario->EditValue)) $this->Precio_Unitario->EditValue = ew_FormatNumber($this->Precio_Unitario->EditValue, -2, -2, -2, -2);

			// MontoTotal
			$this->MontoTotal->EditCustomAttributes = "";
			$this->MontoTotal->EditValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->EditValue = ew_FormatCurrency($this->MontoTotal->EditValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";

			// Edit refer script
			// BarCode_Externo

			$this->BarCode_Externo->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// CantRecibida
			$this->CantRecibida->HrefValue = "";

			// Precio_Unitario
			$this->Precio_Unitario->HrefValue = "";

			// MontoTotal
			$this->MontoTotal->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->CantRecibida->Total = 0; // Initialize total
			$this->MontoTotal->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->CantRecibida->CurrentValue = $this->CantRecibida->Total;
			$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
			$this->CantRecibida->ViewCustomAttributes = "";
			$this->CantRecibida->HrefValue = ""; // Clear href value
			$this->MontoTotal->CurrentValue = $this->MontoTotal->Total;
			$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";
			$this->MontoTotal->HrefValue = ""; // Clear href value
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
		if (!is_null($this->Id_Articulo->FormValue) && $this->Id_Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Articulo->FldCaption());
		}
		if (!ew_CheckInteger($this->CantRecibida->FormValue)) {
			ew_AddMessage($gsFormError, $this->CantRecibida->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Precio_Unitario->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_Unitario->FldErrMsg());
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

			// BarCode_Externo
			$this->BarCode_Externo->SetDbValueDef($rsnew, $this->BarCode_Externo->CurrentValue, NULL, $this->BarCode_Externo->ReadOnly);

			// Id_Articulo
			$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, $this->Id_Articulo->ReadOnly);

			// CantRecibida
			$this->CantRecibida->SetDbValueDef($rsnew, $this->CantRecibida->CurrentValue, NULL, $this->CantRecibida->ReadOnly);

			// Precio_Unitario
			$this->Precio_Unitario->SetDbValueDef($rsnew, $this->Precio_Unitario->CurrentValue, NULL, $this->Precio_Unitario->ReadOnly);

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

		// BarCode_Externo
		$this->BarCode_Externo->SetDbValueDef($rsnew, $this->BarCode_Externo->CurrentValue, NULL, FALSE);

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, FALSE);

		// CantRecibida
		$this->CantRecibida->SetDbValueDef($rsnew, $this->CantRecibida->CurrentValue, NULL, strval($this->CantRecibida->CurrentValue) == "");

		// Precio_Unitario
		$this->Precio_Unitario->SetDbValueDef($rsnew, $this->Precio_Unitario->CurrentValue, NULL, strval($this->Precio_Unitario->CurrentValue) == "");

		// MontoTotal
		$this->MontoTotal->SetDbValueDef($rsnew, $this->MontoTotal->CurrentValue, NULL, strval($this->MontoTotal->CurrentValue) == "");

		// Id_Compra
		if ($this->Id_Compra->getSessionValue() <> "") {
			$rsnew['Id_Compra'] = $this->Id_Compra->getSessionValue();
		}

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
			$this->Id_Compra_Det->setDbValue($conn->Insert_ID());
			$rsnew['Id_Compra_Det'] = $this->Id_Compra_Det->DbValue;
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
		$item->Body = "<a id=\"emf_cap_recep_accesorios_bycode_detail\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_recep_accesorios_bycode_detail',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_recep_accesorios_bycode_detaillist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_recep_accesorios_bycode") {
			global $cap_recep_accesorios_bycode;
			$rsmaster = $cap_recep_accesorios_bycode->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cap_recep_accesorios_bycode->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cap_recep_accesorios_bycode") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Compra"] <> "") {
					$GLOBALS["cap_recep_accesorios_bycode"]->Id_Compra->setQueryStringValue($_GET["Id_Compra"]);
					$this->Id_Compra->setQueryStringValue($GLOBALS["cap_recep_accesorios_bycode"]->Id_Compra->QueryStringValue);
					$this->Id_Compra->setSessionValue($this->Id_Compra->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_recep_accesorios_bycode"]->Id_Compra->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cap_recep_accesorios_bycode") {
				if ($this->Id_Compra->QueryStringValue == "") $this->Id_Compra->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
if (!isset($cap_recep_accesorios_bycode_detail_list)) $cap_recep_accesorios_bycode_detail_list = new ccap_recep_accesorios_bycode_detail_list();

// Page init
$cap_recep_accesorios_bycode_detail_list->Page_Init();

// Page main
$cap_recep_accesorios_bycode_detail_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_recep_accesorios_bycode_detail_list = new ew_Page("cap_recep_accesorios_bycode_detail_list");
cap_recep_accesorios_bycode_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_recep_accesorios_bycode_detail_list.PageID; // For backward compatibility

// Form object
var fcap_recep_accesorios_bycode_detaillist = new ew_Form("fcap_recep_accesorios_bycode_detaillist");

// Validate form
fcap_recep_accesorios_bycode_detaillist.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_recep_accesorios_bycode_detail->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_CantRecibida"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_recep_accesorios_bycode_detail->CantRecibida->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_Unitario"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_recep_accesorios_bycode_detail->Precio_Unitario->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_recep_accesorios_bycode_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_recep_accesorios_bycode_detaillist.ValidateRequired = true;
<?php } else { ?>
fcap_recep_accesorios_bycode_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_recep_accesorios_bycode_detaillist.Lists["x_BarCode_Externo"] = {"LinkField":"x_BarCode_Externo","Ajax":true,"AutoFill":true,"DisplayFields":["x_BarCode_Externo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_recep_accesorios_bycode_detaillist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
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
<?php if (($cap_recep_accesorios_bycode_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $cap_recep_accesorios_bycode_detail->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cap_recep_accesorios_bycodelist.php";
if ($cap_recep_accesorios_bycode_detail_list->DbMasterFilter <> "" && $cap_recep_accesorios_bycode_detail->getCurrentMasterTable() == "cap_recep_accesorios_bycode") {
	if ($cap_recep_accesorios_bycode_detail_list->MasterRecordExists) {
		if ($cap_recep_accesorios_bycode_detail->getCurrentMasterTable() == $cap_recep_accesorios_bycode_detail->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p><span class="ewTitle ewMasterTableTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $cap_recep_accesorios_bycode->TableCaption() ?>&nbsp;&nbsp;</span><?php $cap_recep_accesorios_bycode_detail_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterRecordPage") ?></a></p>
<?php } ?>
<?php include_once "cap_recep_accesorios_bycodemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_recep_accesorios_bycode_detail_list->TotalRecs = $cap_recep_accesorios_bycode_detail->SelectRecordCount();
	} else {
		if ($cap_recep_accesorios_bycode_detail_list->Recordset = $cap_recep_accesorios_bycode_detail_list->LoadRecordset())
			$cap_recep_accesorios_bycode_detail_list->TotalRecs = $cap_recep_accesorios_bycode_detail_list->Recordset->RecordCount();
	}
	$cap_recep_accesorios_bycode_detail_list->StartRec = 1;
	if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs <= 0 || ($cap_recep_accesorios_bycode_detail->Export <> "" && $cap_recep_accesorios_bycode_detail->ExportAll)) // Display all records
		$cap_recep_accesorios_bycode_detail_list->DisplayRecs = $cap_recep_accesorios_bycode_detail_list->TotalRecs;
	if (!($cap_recep_accesorios_bycode_detail->Export <> "" && $cap_recep_accesorios_bycode_detail->ExportAll))
		$cap_recep_accesorios_bycode_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_recep_accesorios_bycode_detail_list->Recordset = $cap_recep_accesorios_bycode_detail_list->LoadRecordset($cap_recep_accesorios_bycode_detail_list->StartRec-1, $cap_recep_accesorios_bycode_detail_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_recep_accesorios_bycode_detail->TableCaption() ?>&nbsp;&nbsp;</span>
<?php if ($cap_recep_accesorios_bycode_detail->getCurrentMasterTable() == "") { ?>
<?php $cap_recep_accesorios_bycode_detail_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php $cap_recep_accesorios_bycode_detail_list->ShowPageHeader(); ?>
<?php
$cap_recep_accesorios_bycode_detail_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_recep_accesorios_bycode_detail->CurrentAction <> "gridadd" && $cap_recep_accesorios_bycode_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_recep_accesorios_bycode_detail_list->Pager)) $cap_recep_accesorios_bycode_detail_list->Pager = new cPrevNextPager($cap_recep_accesorios_bycode_detail_list->StartRec, $cap_recep_accesorios_bycode_detail_list->DisplayRecs, $cap_recep_accesorios_bycode_detail_list->TotalRecs) ?>
<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_recep_accesorios_bycode_detail_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_recep_accesorios_bycode_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_recep_accesorios_bycode_detail->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_recep_accesorios_bycode_detail_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_recep_accesorios_bycode_detail_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_recep_accesorios_bycode_detaillist" id="fcap_recep_accesorios_bycode_detaillist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_recep_accesorios_bycode_detail">
<div id="gmp_cap_recep_accesorios_bycode_detail" class="ewGridMiddlePanel">
<?php if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > 0 || $cap_recep_accesorios_bycode_detail->CurrentAction == "add" || $cap_recep_accesorios_bycode_detail->CurrentAction == "copy") { ?>
<table id="tbl_cap_recep_accesorios_bycode_detaillist" class="ewTable ewTableSeparate">
<?php echo $cap_recep_accesorios_bycode_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_recep_accesorios_bycode_detail_list->RenderListOptions();

// Render list options (header, left)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_recep_accesorios_bycode_detail->BarCode_Externo->Visible) { // BarCode_Externo ?>
	<?php if ($cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->BarCode_Externo) == "") { ?>
		<td><span id="elh_cap_recep_accesorios_bycode_detail_BarCode_Externo" class="cap_recep_accesorios_bycode_detail_BarCode_Externo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->BarCode_Externo) ?>',1);"><span id="elh_cap_recep_accesorios_bycode_detail_BarCode_Externo" class="cap_recep_accesorios_bycode_detail_BarCode_Externo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorios_bycode_detail->BarCode_Externo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorios_bycode_detail->BarCode_Externo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorios_bycode_detail->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_recep_accesorios_bycode_detail_Id_Articulo" class="cap_recep_accesorios_bycode_detail_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->Id_Articulo) ?>',1);"><span id="elh_cap_recep_accesorios_bycode_detail_Id_Articulo" class="cap_recep_accesorios_bycode_detail_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorios_bycode_detail->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorios_bycode_detail->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorios_bycode_detail->CantRecibida->Visible) { // CantRecibida ?>
	<?php if ($cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->CantRecibida) == "") { ?>
		<td><span id="elh_cap_recep_accesorios_bycode_detail_CantRecibida" class="cap_recep_accesorios_bycode_detail_CantRecibida"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->CantRecibida) ?>',1);"><span id="elh_cap_recep_accesorios_bycode_detail_CantRecibida" class="cap_recep_accesorios_bycode_detail_CantRecibida">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorios_bycode_detail->CantRecibida->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorios_bycode_detail->CantRecibida->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorios_bycode_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
	<?php if ($cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->Precio_Unitario) == "") { ?>
		<td><span id="elh_cap_recep_accesorios_bycode_detail_Precio_Unitario" class="cap_recep_accesorios_bycode_detail_Precio_Unitario"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->Precio_Unitario) ?>',1);"><span id="elh_cap_recep_accesorios_bycode_detail_Precio_Unitario" class="cap_recep_accesorios_bycode_detail_Precio_Unitario">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorios_bycode_detail->Precio_Unitario->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorios_bycode_detail->Precio_Unitario->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorios_bycode_detail->MontoTotal->Visible) { // MontoTotal ?>
	<?php if ($cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->MontoTotal) == "") { ?>
		<td><span id="elh_cap_recep_accesorios_bycode_detail_MontoTotal" class="cap_recep_accesorios_bycode_detail_MontoTotal"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorios_bycode_detail->SortUrl($cap_recep_accesorios_bycode_detail->MontoTotal) ?>',1);"><span id="elh_cap_recep_accesorios_bycode_detail_MontoTotal" class="cap_recep_accesorios_bycode_detail_MontoTotal">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorios_bycode_detail->MontoTotal->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorios_bycode_detail->MontoTotal->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cap_recep_accesorios_bycode_detail->CurrentAction == "add" || $cap_recep_accesorios_bycode_detail->CurrentAction == "copy") {
		$cap_recep_accesorios_bycode_detail_list->RowIndex = 0;
		$cap_recep_accesorios_bycode_detail_list->KeyCount = $cap_recep_accesorios_bycode_detail_list->RowIndex;
		if ($cap_recep_accesorios_bycode_detail->CurrentAction == "copy" && !$cap_recep_accesorios_bycode_detail_list->LoadRow())
				$cap_recep_accesorios_bycode_detail->CurrentAction = "add";
		if ($cap_recep_accesorios_bycode_detail->CurrentAction == "add")
			$cap_recep_accesorios_bycode_detail_list->LoadDefaultValues();
		if ($cap_recep_accesorios_bycode_detail->EventCancelled) // Insert failed
			$cap_recep_accesorios_bycode_detail_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cap_recep_accesorios_bycode_detail->ResetAttrs();
		$cap_recep_accesorios_bycode_detail->RowAttrs = array_merge($cap_recep_accesorios_bycode_detail->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cap_recep_accesorios_bycode_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cap_recep_accesorios_bycode_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_recep_accesorios_bycode_detail_list->RenderRow();

		// Render list options
		$cap_recep_accesorios_bycode_detail_list->RenderListOptions();
		$cap_recep_accesorios_bycode_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_recep_accesorios_bycode_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("body", "left", $cap_recep_accesorios_bycode_detail_list->RowCnt);
?>
	<?php if ($cap_recep_accesorios_bycode_detail->BarCode_Externo->Visible) { // BarCode_Externo ?>
		<td><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_BarCode_Externo" class="cap_recep_accesorios_bycode_detail_BarCode_Externo">
<?php $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo"<?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorios_bycode_detail->BarCode_Externo->EditValue)) {
	$arwrk = $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorios_bycode_detail->BarCode_Externo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `BarCode_Externo`, `BarCode_Externo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorios_bycode_detail->BarCode_Externo->LookupFn) ?>&f0=<?php echo TEAencrypt("`BarCode_Externo` = {filter_value}"); ?>&t0=200">
<?php
$sSqlWrk = "SELECT `Id_Articulo` AS FIELD0, `Precio_compra` AS FIELD1 FROM `ca_articulos`";
$sWhereWrk = "(`BarCode_Externo` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="sf_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="ln_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo,x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario">
<input type="hidden" name="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->BarCode_Externo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_Id_Articulo" class="cap_recep_accesorios_bycode_detail_Id_Articulo">
<select id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo"<?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorios_bycode_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_recep_accesorios_bycode_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorios_bycode_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorios_bycode_detail->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<input type="hidden" name="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_CantRecibida" class="cap_recep_accesorios_bycode_detail_CantRecibida">
<input type="text" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" size="5" value="<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->EditValue ?>"<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" id="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->CantRecibida->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
		<td><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_Precio_Unitario" class="cap_recep_accesorios_bycode_detail_Precio_Unitario">
<input type="text" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" size="8" value="<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->EditValue ?>"<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" id="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->Precio_Unitario->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->MontoTotal->Visible) { // MontoTotal ?>
		<td><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_MontoTotal" class="cap_recep_accesorios_bycode_detail_MontoTotal">
<input type="text" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" size="30" value="<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->EditValue ?>"<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" id="o<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->MontoTotal->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("body", "right", $cap_recep_accesorios_bycode_detail_list->RowCnt);
?>
<script type="text/javascript">
fcap_recep_accesorios_bycode_detaillist.UpdateOpts(<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cap_recep_accesorios_bycode_detail->ExportAll && $cap_recep_accesorios_bycode_detail->Export <> "") {
	$cap_recep_accesorios_bycode_detail_list->StopRec = $cap_recep_accesorios_bycode_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > $cap_recep_accesorios_bycode_detail_list->StartRec + $cap_recep_accesorios_bycode_detail_list->DisplayRecs - 1)
		$cap_recep_accesorios_bycode_detail_list->StopRec = $cap_recep_accesorios_bycode_detail_list->StartRec + $cap_recep_accesorios_bycode_detail_list->DisplayRecs - 1;
	else
		$cap_recep_accesorios_bycode_detail_list->StopRec = $cap_recep_accesorios_bycode_detail_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_recep_accesorios_bycode_detail->CurrentAction == "gridadd" || $cap_recep_accesorios_bycode_detail->CurrentAction == "gridedit" || $cap_recep_accesorios_bycode_detail->CurrentAction == "F")) {
		$cap_recep_accesorios_bycode_detail_list->KeyCount = $objForm->GetValue("key_count");
		$cap_recep_accesorios_bycode_detail_list->StopRec = $cap_recep_accesorios_bycode_detail_list->KeyCount;
	}
}
$cap_recep_accesorios_bycode_detail_list->RecCnt = $cap_recep_accesorios_bycode_detail_list->StartRec - 1;
if ($cap_recep_accesorios_bycode_detail_list->Recordset && !$cap_recep_accesorios_bycode_detail_list->Recordset->EOF) {
	$cap_recep_accesorios_bycode_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_recep_accesorios_bycode_detail_list->StartRec > 1)
		$cap_recep_accesorios_bycode_detail_list->Recordset->Move($cap_recep_accesorios_bycode_detail_list->StartRec - 1);
} elseif (!$cap_recep_accesorios_bycode_detail->AllowAddDeleteRow && $cap_recep_accesorios_bycode_detail_list->StopRec == 0) {
	$cap_recep_accesorios_bycode_detail_list->StopRec = $cap_recep_accesorios_bycode_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_recep_accesorios_bycode_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_recep_accesorios_bycode_detail->ResetAttrs();
$cap_recep_accesorios_bycode_detail_list->RenderRow();
$cap_recep_accesorios_bycode_detail_list->EditRowCnt = 0;
if ($cap_recep_accesorios_bycode_detail->CurrentAction == "edit")
	$cap_recep_accesorios_bycode_detail_list->RowIndex = 1;
while ($cap_recep_accesorios_bycode_detail_list->RecCnt < $cap_recep_accesorios_bycode_detail_list->StopRec) {
	$cap_recep_accesorios_bycode_detail_list->RecCnt++;
	if (intval($cap_recep_accesorios_bycode_detail_list->RecCnt) >= intval($cap_recep_accesorios_bycode_detail_list->StartRec)) {
		$cap_recep_accesorios_bycode_detail_list->RowCnt++;

		// Set up key count
		$cap_recep_accesorios_bycode_detail_list->KeyCount = $cap_recep_accesorios_bycode_detail_list->RowIndex;

		// Init row class and style
		$cap_recep_accesorios_bycode_detail->ResetAttrs();
		$cap_recep_accesorios_bycode_detail->CssClass = "";
		if ($cap_recep_accesorios_bycode_detail->CurrentAction == "gridadd") {
			$cap_recep_accesorios_bycode_detail_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_recep_accesorios_bycode_detail_list->LoadRowValues($cap_recep_accesorios_bycode_detail_list->Recordset); // Load row values
		}
		$cap_recep_accesorios_bycode_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_recep_accesorios_bycode_detail->CurrentAction == "edit") {
			if ($cap_recep_accesorios_bycode_detail_list->CheckInlineEditKey() && $cap_recep_accesorios_bycode_detail_list->EditRowCnt == 0) { // Inline edit
				$cap_recep_accesorios_bycode_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_recep_accesorios_bycode_detail->CurrentAction == "edit" && $cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT && $cap_recep_accesorios_bycode_detail->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_recep_accesorios_bycode_detail_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_recep_accesorios_bycode_detail_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_recep_accesorios_bycode_detail->RowAttrs = array_merge($cap_recep_accesorios_bycode_detail->RowAttrs, array('data-rowindex'=>$cap_recep_accesorios_bycode_detail_list->RowCnt, 'id'=>'r' . $cap_recep_accesorios_bycode_detail_list->RowCnt . '_cap_recep_accesorios_bycode_detail', 'data-rowtype'=>$cap_recep_accesorios_bycode_detail->RowType));

		// Render row
		$cap_recep_accesorios_bycode_detail_list->RenderRow();

		// Render list options
		$cap_recep_accesorios_bycode_detail_list->RenderListOptions();
?>
	<tr<?php echo $cap_recep_accesorios_bycode_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("body", "left", $cap_recep_accesorios_bycode_detail_list->RowCnt);
?>
	<?php if ($cap_recep_accesorios_bycode_detail->BarCode_Externo->Visible) { // BarCode_Externo ?>
		<td<?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_BarCode_Externo" class="cap_recep_accesorios_bycode_detail_BarCode_Externo">
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo"<?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorios_bycode_detail->BarCode_Externo->EditValue)) {
	$arwrk = $cap_recep_accesorios_bycode_detail->BarCode_Externo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorios_bycode_detail->BarCode_Externo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `BarCode_Externo`, `BarCode_Externo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorios_bycode_detail->BarCode_Externo->LookupFn) ?>&f0=<?php echo TEAencrypt("`BarCode_Externo` = {filter_value}"); ?>&t0=200">
<?php
$sSqlWrk = "SELECT `Id_Articulo` AS FIELD0, `Precio_compra` AS FIELD1 FROM `ca_articulos`";
$sWhereWrk = "(`BarCode_Externo` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="sf_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" id="ln_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_BarCode_Externo" value="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo,x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario">
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->BarCode_Externo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorios_bycode_detail_list->PageObjName . "_row_" . $cap_recep_accesorios_bycode_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT || $cap_recep_accesorios_bycode_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Compra_Det" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->Id_Compra_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_Id_Articulo" class="cap_recep_accesorios_bycode_detail_Id_Articulo">
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo"<?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorios_bycode_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_recep_accesorios_bycode_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorios_bycode_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorios_bycode_detail->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorios_bycode_detail_list->PageObjName . "_row_" . $cap_recep_accesorios_bycode_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_CantRecibida" class="cap_recep_accesorios_bycode_detail_CantRecibida">
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_CantRecibida" size="5" value="<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->EditValue ?>"<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorios_bycode_detail_list->PageObjName . "_row_" . $cap_recep_accesorios_bycode_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
		<td<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_Precio_Unitario" class="cap_recep_accesorios_bycode_detail_Precio_Unitario">
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_Precio_Unitario" size="8" value="<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->EditValue ?>"<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->Precio_Unitario->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorios_bycode_detail_list->PageObjName . "_row_" . $cap_recep_accesorios_bycode_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->MontoTotal->Visible) { // MontoTotal ?>
		<td<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorios_bycode_detail_list->RowCnt ?>_cap_recep_accesorios_bycode_detail_MontoTotal" class="cap_recep_accesorios_bycode_detail_MontoTotal">
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorios_bycode_detail->MontoTotal->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorios_bycode_detail_list->PageObjName . "_row_" . $cap_recep_accesorios_bycode_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("body", "right", $cap_recep_accesorios_bycode_detail_list->RowCnt);
?>
	</tr>
<?php if ($cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_ADD || $cap_recep_accesorios_bycode_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_recep_accesorios_bycode_detaillist.UpdateOpts(<?php echo $cap_recep_accesorios_bycode_detail_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_recep_accesorios_bycode_detail->CurrentAction <> "gridadd")
		$cap_recep_accesorios_bycode_detail_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$cap_recep_accesorios_bycode_detail->RowType = EW_ROWTYPE_AGGREGATE;
$cap_recep_accesorios_bycode_detail->ResetAttrs();
$cap_recep_accesorios_bycode_detail_list->RenderRow();
?>
<?php if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > 0 && ($cap_recep_accesorios_bycode_detail->CurrentAction <> "gridadd" && $cap_recep_accesorios_bycode_detail->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$cap_recep_accesorios_bycode_detail_list->RenderListOptions();

// Render list options (footer, left)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("footer", "left");
?>
	<?php if ($cap_recep_accesorios_bycode_detail->BarCode_Externo->Visible) { // BarCode_Externo ?>
		<td><span id="elf_cap_recep_accesorios_bycode_detail_BarCode_Externo" class="cap_recep_accesorios_bycode_detail_BarCode_Externo">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="elf_cap_recep_accesorios_bycode_detail_Id_Articulo" class="cap_recep_accesorios_bycode_detail_Id_Articulo">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td><span id="elf_cap_recep_accesorios_bycode_detail_CantRecibida" class="cap_recep_accesorios_bycode_detail_CantRecibida">
<?php echo $Language->Phrase("TOTAL") ?>: 
<?php echo $cap_recep_accesorios_bycode_detail->CantRecibida->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
		<td><span id="elf_cap_recep_accesorios_bycode_detail_Precio_Unitario" class="cap_recep_accesorios_bycode_detail_Precio_Unitario">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorios_bycode_detail->MontoTotal->Visible) { // MontoTotal ?>
		<td><span id="elf_cap_recep_accesorios_bycode_detail_MontoTotal" class="cap_recep_accesorios_bycode_detail_MontoTotal">
<?php echo $Language->Phrase("TOTAL") ?>: 
<?php echo $cap_recep_accesorios_bycode_detail->MontoTotal->ViewValue ?>
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$cap_recep_accesorios_bycode_detail_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>	
<?php } ?>
</table>
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->CurrentAction == "add" || $cap_recep_accesorios_bycode_detail->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_recep_accesorios_bycode_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_recep_accesorios_bycode_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_recep_accesorios_bycode_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_recep_accesorios_bycode_detail_list->Recordset)
	$cap_recep_accesorios_bycode_detail_list->Recordset->Close();
?>
<?php if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > 0) { ?>
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_recep_accesorios_bycode_detail->CurrentAction <> "gridadd" && $cap_recep_accesorios_bycode_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_recep_accesorios_bycode_detail_list->Pager)) $cap_recep_accesorios_bycode_detail_list->Pager = new cPrevNextPager($cap_recep_accesorios_bycode_detail_list->StartRec, $cap_recep_accesorios_bycode_detail_list->DisplayRecs, $cap_recep_accesorios_bycode_detail_list->TotalRecs) ?>
<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_recep_accesorios_bycode_detail_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorios_bycode_detail_list->PageUrl() ?>start=<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_recep_accesorios_bycode_detail_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_recep_accesorios_bycode_detail_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_recep_accesorios_bycode_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_recep_accesorios_bycode_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_recep_accesorios_bycode_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_recep_accesorios_bycode_detail->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_recep_accesorios_bycode_detail_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_recep_accesorios_bycode_detail_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<script type="text/javascript">
fcap_recep_accesorios_bycode_detaillist.Init();
</script>
<?php } ?>
<?php
$cap_recep_accesorios_bycode_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_recep_accesorios_bycode_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_recep_accesorios_bycode_detail_list->Page_Terminate();
?>
