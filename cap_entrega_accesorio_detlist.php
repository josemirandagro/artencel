<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_accesorio_detinfo.php" ?>
<?php include_once "cap_entrega_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_accesorio_det_list = NULL; // Initialize page object first

class ccap_entrega_accesorio_det_list extends ccap_entrega_accesorio_det {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_accesorio_det';

	// Page object name
	var $PageObjName = 'cap_entrega_accesorio_det_list';

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

		// Table object (cap_entrega_accesorio_det)
		if (!isset($GLOBALS["cap_entrega_accesorio_det"])) {
			$GLOBALS["cap_entrega_accesorio_det"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_accesorio_det"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_entrega_accesorio_detadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_entrega_accesorio_detdelete.php";
		$this->MultiUpdateUrl = "cap_entrega_accesorio_detupdate.php";

		// Table object (cap_entrega_accesorio)
		if (!isset($GLOBALS['cap_entrega_accesorio'])) $GLOBALS['cap_entrega_accesorio'] = new ccap_entrega_accesorio();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_accesorio_det', TRUE);

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_entrega_accesorio") {
			global $cap_entrega_accesorio;
			$rsmaster = $cap_entrega_accesorio->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cap_entrega_accesoriolist.php"); // Return to master page
			} else {
				$cap_entrega_accesorio->LoadListRowValues($rsmaster);
				$cap_entrega_accesorio->RowType = EW_ROWTYPE_MASTER; // Master row
				$cap_entrega_accesorio->RenderListRow();
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
		$this->setKey("Id_Traspaso_Det", ""); // Clear inline edit key
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
		if (@$_GET["Id_Traspaso_Det"] <> "") {
			$this->Id_Traspaso_Det->setQueryStringValue($_GET["Id_Traspaso_Det"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Traspaso_Det", $this->Id_Traspaso_Det->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Traspaso_Det")) <> strval($this->Id_Traspaso_Det->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
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
			$this->Id_Traspaso_Det->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Traspaso_Det->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->Id_Articulo, $bCtrl); // Id_Articulo
			$this->UpdateSort($this->Cantidad, $bCtrl); // Cantidad
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
				$this->Id_Traspaso->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Codigo->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Cantidad->setSort("");
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
		$item->Visible = $Security->CanAdd() && ($this->CurrentAction == "add");
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
				"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_entrega_accesorio_detlist'].Submit();\">" . "<img src=\"phpimages/insert.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
				"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_entrega_accesorio_detlist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Traspaso_Det->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Cantidad->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Cantidad->FldIsDetailKey) {
			$this->Cantidad->setFormValue($objForm->GetValue("x_Cantidad"));
		}
		if (!$this->Id_Traspaso_Det->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Traspaso_Det->setFormValue($objForm->GetValue("x_Id_Traspaso_Det"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Traspaso_Det->CurrentValue = $this->Id_Traspaso_Det->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Cantidad->CurrentValue = $this->Cantidad->FormValue;
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
		$this->Id_Traspaso_Det->setDbValue($rs->fields('Id_Traspaso_Det'));
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Cantidad->setDbValue($rs->fields('Cantidad'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Traspaso_Det")) <> "")
			$this->Id_Traspaso_Det->CurrentValue = $this->getKey("Id_Traspaso_Det"); // Id_Traspaso_Det
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
		// Id_Traspaso_Det

		$this->Id_Traspaso_Det->CellCssStyle = "white-space: nowrap;";

		// Id_Traspaso
		// Codigo
		// Id_Articulo
		// Cantidad
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Traspaso
			$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";

			// Codigo
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_accesorios`";
			$sWhereWrk = "";
			$lookuptblfilter = "TipoArticulo='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoArticulo`='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
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

			// Cantidad
			$this->Cantidad->ViewValue = $this->Cantidad->CurrentValue;
			$this->Cantidad->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Cantidad
			$this->Cantidad->LinkCustomAttributes = "";
			$this->Cantidad->HrefValue = "";
			$this->Cantidad->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_accesorios`";
			$sWhereWrk = "";
			$lookuptblfilter = "TipoArticulo='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Codigo->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoArticulo`='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Cantidad
			$this->Cantidad->EditCustomAttributes = "";
			$this->Cantidad->EditValue = ew_HtmlEncode($this->Cantidad->CurrentValue);

			// Edit refer script
			// Codigo

			$this->Codigo->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Cantidad
			$this->Cantidad->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_accesorios`";
			$sWhereWrk = "";
			$lookuptblfilter = "TipoArticulo='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Codigo->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoArticulo`='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Cantidad
			$this->Cantidad->EditCustomAttributes = "";
			$this->Cantidad->EditValue = ew_HtmlEncode($this->Cantidad->CurrentValue);

			// Edit refer script
			// Codigo

			$this->Codigo->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Cantidad
			$this->Cantidad->HrefValue = "";
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
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
		}
		if (!is_null($this->Id_Articulo->FormValue) && $this->Id_Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Articulo->FldCaption());
		}
		if (!is_null($this->Cantidad->FormValue) && $this->Cantidad->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad->FldCaption());
		}
		if (!ew_CheckInteger($this->Cantidad->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad->FldErrMsg());
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

			// Codigo
			$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, $this->Codigo->ReadOnly);

			// Id_Articulo
			$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, $this->Id_Articulo->ReadOnly);

			// Cantidad
			$this->Cantidad->SetDbValueDef($rsnew, $this->Cantidad->CurrentValue, 0, $this->Cantidad->ReadOnly);

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

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, FALSE);

		// Cantidad
		$this->Cantidad->SetDbValueDef($rsnew, $this->Cantidad->CurrentValue, 0, strval($this->Cantidad->CurrentValue) == "");

		// Id_Traspaso
		if ($this->Id_Traspaso->getSessionValue() <> "") {
			$rsnew['Id_Traspaso'] = $this->Id_Traspaso->getSessionValue();
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
			$this->Id_Traspaso_Det->setDbValue($conn->Insert_ID());
			$rsnew['Id_Traspaso_Det'] = $this->Id_Traspaso_Det->DbValue;
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
		$item->Body = "<a id=\"emf_cap_entrega_accesorio_det\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_entrega_accesorio_det',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_entrega_accesorio_detlist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_entrega_accesorio") {
			global $cap_entrega_accesorio;
			$rsmaster = $cap_entrega_accesorio->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cap_entrega_accesorio->ExportDocument($ExportDoc, $rsmaster, 1, 1);
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
			if ($sMasterTblVar == "cap_entrega_accesorio") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Traspaso"] <> "") {
					$GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->setQueryStringValue($_GET["Id_Traspaso"]);
					$this->Id_Traspaso->setQueryStringValue($GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->QueryStringValue);
					$this->Id_Traspaso->setSessionValue($this->Id_Traspaso->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cap_entrega_accesorio") {
				if ($this->Id_Traspaso->QueryStringValue == "") $this->Id_Traspaso->setSessionValue("");
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
if (!isset($cap_entrega_accesorio_det_list)) $cap_entrega_accesorio_det_list = new ccap_entrega_accesorio_det_list();

// Page init
$cap_entrega_accesorio_det_list->Page_Init();

// Page main
$cap_entrega_accesorio_det_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_entrega_accesorio_det_list = new ew_Page("cap_entrega_accesorio_det_list");
cap_entrega_accesorio_det_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_entrega_accesorio_det_list.PageID; // For backward compatibility

// Form object
var fcap_entrega_accesorio_detlist = new ew_Form("fcap_entrega_accesorio_detlist");

// Validate form
fcap_entrega_accesorio_detlist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_entrega_accesorio_detlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_accesorio_detlist.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_accesorio_detlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_accesorio_detlist.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":null,"AutoFill":true,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_accesorio_detlist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":true,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php if (($cap_entrega_accesorio_det->Export == "") || (EW_EXPORT_MASTER_RECORD && $cap_entrega_accesorio_det->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cap_entrega_accesoriolist.php";
if ($cap_entrega_accesorio_det_list->DbMasterFilter <> "" && $cap_entrega_accesorio_det->getCurrentMasterTable() == "cap_entrega_accesorio") {
	if ($cap_entrega_accesorio_det_list->MasterRecordExists) {
		if ($cap_entrega_accesorio_det->getCurrentMasterTable() == $cap_entrega_accesorio_det->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p><span class="ewTitle ewMasterTableTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $cap_entrega_accesorio->TableCaption() ?>&nbsp;&nbsp;</span><?php $cap_entrega_accesorio_det_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterRecordPage") ?></a></p>
<?php } ?>
<?php include_once "cap_entrega_accesoriomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_entrega_accesorio_det_list->TotalRecs = $cap_entrega_accesorio_det->SelectRecordCount();
	} else {
		if ($cap_entrega_accesorio_det_list->Recordset = $cap_entrega_accesorio_det_list->LoadRecordset())
			$cap_entrega_accesorio_det_list->TotalRecs = $cap_entrega_accesorio_det_list->Recordset->RecordCount();
	}
	$cap_entrega_accesorio_det_list->StartRec = 1;
	if ($cap_entrega_accesorio_det_list->DisplayRecs <= 0 || ($cap_entrega_accesorio_det->Export <> "" && $cap_entrega_accesorio_det->ExportAll)) // Display all records
		$cap_entrega_accesorio_det_list->DisplayRecs = $cap_entrega_accesorio_det_list->TotalRecs;
	if (!($cap_entrega_accesorio_det->Export <> "" && $cap_entrega_accesorio_det->ExportAll))
		$cap_entrega_accesorio_det_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_entrega_accesorio_det_list->Recordset = $cap_entrega_accesorio_det_list->LoadRecordset($cap_entrega_accesorio_det_list->StartRec-1, $cap_entrega_accesorio_det_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_accesorio_det->TableCaption() ?>&nbsp;&nbsp;</span>
<?php if ($cap_entrega_accesorio_det->getCurrentMasterTable() == "") { ?>
<?php $cap_entrega_accesorio_det_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php $cap_entrega_accesorio_det_list->ShowPageHeader(); ?>
<?php
$cap_entrega_accesorio_det_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_entrega_accesorio_det->CurrentAction <> "gridadd" && $cap_entrega_accesorio_det->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_entrega_accesorio_det_list->Pager)) $cap_entrega_accesorio_det_list->Pager = new cNumericPager($cap_entrega_accesorio_det_list->StartRec, $cap_entrega_accesorio_det_list->DisplayRecs, $cap_entrega_accesorio_det_list->TotalRecs, $cap_entrega_accesorio_det_list->RecRange) ?>
<?php if ($cap_entrega_accesorio_det_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_entrega_accesorio_det_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_entrega_accesorio_det_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_entrega_accesorio_det_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_entrega_accesorio_det">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_entrega_accesorio_det_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_accesorio_det_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_entrega_accesorio_detlist" id="fcap_entrega_accesorio_detlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_entrega_accesorio_det">
<div id="gmp_cap_entrega_accesorio_det" class="ewGridMiddlePanel">
<?php if ($cap_entrega_accesorio_det_list->TotalRecs > 0 || $cap_entrega_accesorio_det->CurrentAction == "add" || $cap_entrega_accesorio_det->CurrentAction == "copy") { ?>
<table id="tbl_cap_entrega_accesorio_detlist" class="ewTable ewTableSeparate">
<?php echo $cap_entrega_accesorio_det->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_entrega_accesorio_det_list->RenderListOptions();

// Render list options (header, left)
$cap_entrega_accesorio_det_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Codigo) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Codigo) ?>',2);"><span id="elh_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Id_Articulo) ?>',2);"><span id="elh_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Cantidad) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Cantidad->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Cantidad) ?>',2);"><span id="elh_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Cantidad->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Cantidad->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Cantidad->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_entrega_accesorio_det_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cap_entrega_accesorio_det->CurrentAction == "add" || $cap_entrega_accesorio_det->CurrentAction == "copy") {
		$cap_entrega_accesorio_det_list->RowIndex = 0;
		$cap_entrega_accesorio_det_list->KeyCount = $cap_entrega_accesorio_det_list->RowIndex;
		if ($cap_entrega_accesorio_det->CurrentAction == "add")
			$cap_entrega_accesorio_det_list->LoadDefaultValues();
		if ($cap_entrega_accesorio_det->EventCancelled) // Insert failed
			$cap_entrega_accesorio_det_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cap_entrega_accesorio_det->ResetAttrs();
		$cap_entrega_accesorio_det->RowAttrs = array_merge($cap_entrega_accesorio_det->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cap_entrega_accesorio_det', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_entrega_accesorio_det_list->RenderRow();

		// Render list options
		$cap_entrega_accesorio_det_list->RenderListOptions();
		$cap_entrega_accesorio_det_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_accesorio_det_list->ListOptions->Render("body", "left", $cap_entrega_accesorio_det_list->RowCnt);
?>
	<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
		<td><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_entrega_accesorio_detlist.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
$sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
$sWhereWrk = "(`Codigo` = '{query_value}')";
$lookuptblfilter = "TipoArticulo='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" id="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" id="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" value="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" id="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
$sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
$sWhereWrk = "(`Id_Articulo` = {query_value})";
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
		<td><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
<input type="text" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" id="o<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_accesorio_det_list->ListOptions->Render("body", "right", $cap_entrega_accesorio_det_list->RowCnt);
?>
<script type="text/javascript">
fcap_entrega_accesorio_detlist.UpdateOpts(<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cap_entrega_accesorio_det->ExportAll && $cap_entrega_accesorio_det->Export <> "") {
	$cap_entrega_accesorio_det_list->StopRec = $cap_entrega_accesorio_det_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_entrega_accesorio_det_list->TotalRecs > $cap_entrega_accesorio_det_list->StartRec + $cap_entrega_accesorio_det_list->DisplayRecs - 1)
		$cap_entrega_accesorio_det_list->StopRec = $cap_entrega_accesorio_det_list->StartRec + $cap_entrega_accesorio_det_list->DisplayRecs - 1;
	else
		$cap_entrega_accesorio_det_list->StopRec = $cap_entrega_accesorio_det_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_entrega_accesorio_det->CurrentAction == "gridadd" || $cap_entrega_accesorio_det->CurrentAction == "gridedit" || $cap_entrega_accesorio_det->CurrentAction == "F")) {
		$cap_entrega_accesorio_det_list->KeyCount = $objForm->GetValue("key_count");
		$cap_entrega_accesorio_det_list->StopRec = $cap_entrega_accesorio_det_list->KeyCount;
	}
}
$cap_entrega_accesorio_det_list->RecCnt = $cap_entrega_accesorio_det_list->StartRec - 1;
if ($cap_entrega_accesorio_det_list->Recordset && !$cap_entrega_accesorio_det_list->Recordset->EOF) {
	$cap_entrega_accesorio_det_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_entrega_accesorio_det_list->StartRec > 1)
		$cap_entrega_accesorio_det_list->Recordset->Move($cap_entrega_accesorio_det_list->StartRec - 1);
} elseif (!$cap_entrega_accesorio_det->AllowAddDeleteRow && $cap_entrega_accesorio_det_list->StopRec == 0) {
	$cap_entrega_accesorio_det_list->StopRec = $cap_entrega_accesorio_det->GridAddRowCount;
}

// Initialize aggregate
$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_entrega_accesorio_det->ResetAttrs();
$cap_entrega_accesorio_det_list->RenderRow();
$cap_entrega_accesorio_det_list->EditRowCnt = 0;
if ($cap_entrega_accesorio_det->CurrentAction == "edit")
	$cap_entrega_accesorio_det_list->RowIndex = 1;
while ($cap_entrega_accesorio_det_list->RecCnt < $cap_entrega_accesorio_det_list->StopRec) {
	$cap_entrega_accesorio_det_list->RecCnt++;
	if (intval($cap_entrega_accesorio_det_list->RecCnt) >= intval($cap_entrega_accesorio_det_list->StartRec)) {
		$cap_entrega_accesorio_det_list->RowCnt++;

		// Set up key count
		$cap_entrega_accesorio_det_list->KeyCount = $cap_entrega_accesorio_det_list->RowIndex;

		// Init row class and style
		$cap_entrega_accesorio_det->ResetAttrs();
		$cap_entrega_accesorio_det->CssClass = "";
		if ($cap_entrega_accesorio_det->CurrentAction == "gridadd") {
			$cap_entrega_accesorio_det_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_entrega_accesorio_det_list->LoadRowValues($cap_entrega_accesorio_det_list->Recordset); // Load row values
		}
		$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_entrega_accesorio_det->CurrentAction == "edit") {
			if ($cap_entrega_accesorio_det_list->CheckInlineEditKey() && $cap_entrega_accesorio_det_list->EditRowCnt == 0) { // Inline edit
				$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_entrega_accesorio_det->CurrentAction == "edit" && $cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT && $cap_entrega_accesorio_det->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_entrega_accesorio_det_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_entrega_accesorio_det_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_entrega_accesorio_det->RowAttrs = array_merge($cap_entrega_accesorio_det->RowAttrs, array('data-rowindex'=>$cap_entrega_accesorio_det_list->RowCnt, 'id'=>'r' . $cap_entrega_accesorio_det_list->RowCnt . '_cap_entrega_accesorio_det', 'data-rowtype'=>$cap_entrega_accesorio_det->RowType));

		// Render row
		$cap_entrega_accesorio_det_list->RenderRow();

		// Render list options
		$cap_entrega_accesorio_det_list->RenderListOptions();
?>
	<tr<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_accesorio_det_list->ListOptions->Render("body", "left", $cap_entrega_accesorio_det_list->RowCnt);
?>
	<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_entrega_accesorio_det->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_entrega_accesorio_detlist.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
$sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
$sWhereWrk = "(`Codigo` = '{query_value}')";
$lookuptblfilter = "TipoArticulo='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" id="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" id="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo" value="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Codigo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_list->PageObjName . "_row_" . $cap_entrega_accesorio_det_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT || $cap_entrega_accesorio_det->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_entrega_accesorio_det->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
$sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
$sWhereWrk = "(`Id_Articulo` = {query_value})";
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Codigo">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_list->PageObjName . "_row_" . $cap_entrega_accesorio_det_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
		<td<?php echo $cap_entrega_accesorio_det->Cantidad->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_list->RowCnt ?>_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Cantidad->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Cantidad->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_list->PageObjName . "_row_" . $cap_entrega_accesorio_det_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_accesorio_det_list->ListOptions->Render("body", "right", $cap_entrega_accesorio_det_list->RowCnt);
?>
	</tr>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD || $cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_entrega_accesorio_detlist.UpdateOpts(<?php echo $cap_entrega_accesorio_det_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($cap_entrega_accesorio_det->CurrentAction <> "gridadd")
		$cap_entrega_accesorio_det_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->CurrentAction == "add" || $cap_entrega_accesorio_det->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_accesorio_det_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_accesorio_det_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_entrega_accesorio_det_list->Recordset)
	$cap_entrega_accesorio_det_list->Recordset->Close();
?>
<?php if ($cap_entrega_accesorio_det_list->TotalRecs > 0) { ?>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_entrega_accesorio_det->CurrentAction <> "gridadd" && $cap_entrega_accesorio_det->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_entrega_accesorio_det_list->Pager)) $cap_entrega_accesorio_det_list->Pager = new cNumericPager($cap_entrega_accesorio_det_list->StartRec, $cap_entrega_accesorio_det_list->DisplayRecs, $cap_entrega_accesorio_det_list->TotalRecs, $cap_entrega_accesorio_det_list->RecRange) ?>
<?php if ($cap_entrega_accesorio_det_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_entrega_accesorio_det_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_entrega_accesorio_det_list->PageUrl() ?>start=<?php echo $cap_entrega_accesorio_det_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_entrega_accesorio_det_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_entrega_accesorio_det_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_entrega_accesorio_det_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_entrega_accesorio_det">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_entrega_accesorio_det_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_entrega_accesorio_det_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_entrega_accesorio_det_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<script type="text/javascript">
fcap_entrega_accesorio_detlist.Init();
</script>
<?php } ?>
<?php
$cap_entrega_accesorio_det_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_accesorio_det_list->Page_Terminate();
?>
