<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_asigna_acabados_equipo_detailinfo.php" ?>
<?php include_once "cap_asigna_acabados_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_asigna_acabados_equipo_detail_list = NULL; // Initialize page object first

class ccap_asigna_acabados_equipo_detail_list extends ccap_asigna_acabados_equipo_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_asigna_acabados_equipo_detail';

	// Page object name
	var $PageObjName = 'cap_asigna_acabados_equipo_detail_list';

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

		// Table object (cap_asigna_acabados_equipo_detail)
		if (!isset($GLOBALS["cap_asigna_acabados_equipo_detail"])) {
			$GLOBALS["cap_asigna_acabados_equipo_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_asigna_acabados_equipo_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_asigna_acabados_equipo_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_asigna_acabados_equipo_detaildelete.php";
		$this->MultiUpdateUrl = "cap_asigna_acabados_equipo_detailupdate.php";

		// Table object (cap_asigna_acabados_equipo)
		if (!isset($GLOBALS['cap_asigna_acabados_equipo'])) $GLOBALS['cap_asigna_acabados_equipo'] = new ccap_asigna_acabados_equipo();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_asigna_acabados_equipo_detail', TRUE);

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

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$this->GridInsert();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" ||
					$this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_asigna_acabados_equipo") {
			global $cap_asigna_acabados_equipo;
			$rsmaster = $cap_asigna_acabados_equipo->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cap_asigna_acabados_equipolist.php"); // Return to master page
			} else {
				$cap_asigna_acabados_equipo->LoadListRowValues($rsmaster);
				$cap_asigna_acabados_equipo->RowType = EW_ROWTYPE_MASTER; // Master row
				$cap_asigna_acabados_equipo->RenderListRow();
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
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
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

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->Id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Id_Articulo") && $objForm->HasValue("o_Id_Articulo") && $this->Id_Articulo->CurrentValue <> $this->Id_Articulo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Acabado_eq") && $objForm->HasValue("o_Id_Acabado_eq") && $this->Id_Acabado_eq->CurrentValue <> $this->Id_Acabado_eq->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Articulo); // Id_Articulo
			$this->UpdateSort($this->Id_Acabado_eq); // Id_Acabado_eq
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
				$this->Id_Acabado_eq->setSort("ASC");
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
				$this->Id_Articulo->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Id_Articulo->setSort("");
				$this->Id_Acabado_eq->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$oListOpt = &$this->ListOptions->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
				}
			}
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
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Acabado_eq->CurrentValue = NULL;
		$this->Id_Acabado_eq->OldValue = $this->Id_Acabado_eq->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		$this->Id_Articulo->setOldValue($objForm->GetValue("o_Id_Articulo"));
		if (!$this->Id_Acabado_eq->FldIsDetailKey) {
			$this->Id_Acabado_eq->setFormValue($objForm->GetValue("x_Id_Acabado_eq"));
		}
		$this->Id_Acabado_eq->setOldValue($objForm->GetValue("o_Id_Acabado_eq"));
		if (!$this->Id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id->setFormValue($objForm->GetValue("x_Id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id->CurrentValue = $this->Id->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Id_Acabado_eq->CurrentValue = $this->Id_Acabado_eq->FormValue;
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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
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
		// Id_Articulo
		// Id_Acabado_eq

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id
			$this->Id->ViewValue = $this->Id->CurrentValue;
			$this->Id->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
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
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
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

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if ($this->Id_Articulo->getSessionValue() <> "") {
				$this->Id_Articulo->CurrentValue = $this->Id_Articulo->getSessionValue();
				$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
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
			} else {
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
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
			}

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
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

			// Edit refer script
			// Id_Articulo

			$this->Id_Articulo->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";
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
		if (!is_null($this->Id_Acabado_eq->FormValue) && $this->Id_Acabado_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Acabado_eq->FldCaption());
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		$rsnew = array();

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, FALSE);

		// Id_Acabado_eq
		$this->Id_Acabado_eq->SetDbValueDef($rsnew, $this->Id_Acabado_eq->CurrentValue, 0, FALSE);

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
		$item->Body = "<a id=\"emf_cap_asigna_acabados_equipo_detail\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_asigna_acabados_equipo_detail',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_asigna_acabados_equipo_detaillist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cap_asigna_acabados_equipo") {
			global $cap_asigna_acabados_equipo;
			$rsmaster = $cap_asigna_acabados_equipo->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cap_asigna_acabados_equipo->ExportDocument($ExportDoc, $rsmaster, 1, 1);
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
			if ($sMasterTblVar == "cap_asigna_acabados_equipo") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Articulo"] <> "") {
					$GLOBALS["cap_asigna_acabados_equipo"]->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);
					$this->Id_Articulo->setQueryStringValue($GLOBALS["cap_asigna_acabados_equipo"]->Id_Articulo->QueryStringValue);
					$this->Id_Articulo->setSessionValue($this->Id_Articulo->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_asigna_acabados_equipo"]->Id_Articulo->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cap_asigna_acabados_equipo") {
				if ($this->Id_Articulo->QueryStringValue == "") $this->Id_Articulo->setSessionValue("");
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
if (!isset($cap_asigna_acabados_equipo_detail_list)) $cap_asigna_acabados_equipo_detail_list = new ccap_asigna_acabados_equipo_detail_list();

// Page init
$cap_asigna_acabados_equipo_detail_list->Page_Init();

// Page main
$cap_asigna_acabados_equipo_detail_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_asigna_acabados_equipo_detail_list = new ew_Page("cap_asigna_acabados_equipo_detail_list");
cap_asigna_acabados_equipo_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_asigna_acabados_equipo_detail_list.PageID; // For backward compatibility

// Form object
var fcap_asigna_acabados_equipo_detaillist = new ew_Form("fcap_asigna_acabados_equipo_detaillist");

// Validate form
fcap_asigna_acabados_equipo_detaillist.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	var addcnt = 0;
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = (fobj.key_count) ? String(i) : "";
		var checkrow = (fobj.a_list && fobj.a_list.value == "gridinsert") ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
		elm = fobj.elements["x" + infix + "_Id_Acabado_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fcap_asigna_acabados_equipo_detaillist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Id_Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Acabado_eq", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_asigna_acabados_equipo_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_asigna_acabados_equipo_detaillist.ValidateRequired = true;
<?php } else { ?>
fcap_asigna_acabados_equipo_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php if (($cap_asigna_acabados_equipo_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $cap_asigna_acabados_equipo_detail->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cap_asigna_acabados_equipolist.php";
if ($cap_asigna_acabados_equipo_detail_list->DbMasterFilter <> "" && $cap_asigna_acabados_equipo_detail->getCurrentMasterTable() == "cap_asigna_acabados_equipo") {
	if ($cap_asigna_acabados_equipo_detail_list->MasterRecordExists) {
		if ($cap_asigna_acabados_equipo_detail->getCurrentMasterTable() == $cap_asigna_acabados_equipo_detail->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p><span class="ewTitle ewMasterTableTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $cap_asigna_acabados_equipo->TableCaption() ?>&nbsp;&nbsp;</span><?php $cap_asigna_acabados_equipo_detail_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterRecordPage") ?></a></p>
<?php } ?>
<?php include_once "cap_asigna_acabados_equipomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") {
	$cap_asigna_acabados_equipo_detail->CurrentFilter = "0=1";
	$cap_asigna_acabados_equipo_detail_list->StartRec = 1;
	$cap_asigna_acabados_equipo_detail_list->DisplayRecs = $cap_asigna_acabados_equipo_detail->GridAddRowCount;
	$cap_asigna_acabados_equipo_detail_list->TotalRecs = $cap_asigna_acabados_equipo_detail_list->DisplayRecs;
	$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_asigna_acabados_equipo_detail_list->TotalRecs = $cap_asigna_acabados_equipo_detail->SelectRecordCount();
	} else {
		if ($cap_asigna_acabados_equipo_detail_list->Recordset = $cap_asigna_acabados_equipo_detail_list->LoadRecordset())
			$cap_asigna_acabados_equipo_detail_list->TotalRecs = $cap_asigna_acabados_equipo_detail_list->Recordset->RecordCount();
	}
	$cap_asigna_acabados_equipo_detail_list->StartRec = 1;
	if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs <= 0 || ($cap_asigna_acabados_equipo_detail->Export <> "" && $cap_asigna_acabados_equipo_detail->ExportAll)) // Display all records
		$cap_asigna_acabados_equipo_detail_list->DisplayRecs = $cap_asigna_acabados_equipo_detail_list->TotalRecs;
	if (!($cap_asigna_acabados_equipo_detail->Export <> "" && $cap_asigna_acabados_equipo_detail->ExportAll))
		$cap_asigna_acabados_equipo_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_asigna_acabados_equipo_detail_list->Recordset = $cap_asigna_acabados_equipo_detail_list->LoadRecordset($cap_asigna_acabados_equipo_detail_list->StartRec-1, $cap_asigna_acabados_equipo_detail_list->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_asigna_acabados_equipo_detail->TableCaption() ?>&nbsp;&nbsp;</span>
<?php if ($cap_asigna_acabados_equipo_detail->getCurrentMasterTable() == "") { ?>
<?php $cap_asigna_acabados_equipo_detail_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php $cap_asigna_acabados_equipo_detail_list->ShowPageHeader(); ?>
<?php
$cap_asigna_acabados_equipo_detail_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_asigna_acabados_equipo_detail_list->Pager)) $cap_asigna_acabados_equipo_detail_list->Pager = new cPrevNextPager($cap_asigna_acabados_equipo_detail_list->StartRec, $cap_asigna_acabados_equipo_detail_list->DisplayRecs, $cap_asigna_acabados_equipo_detail_list->TotalRecs) ?>
<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_asigna_acabados_equipo_detail_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_asigna_acabados_equipo_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_asigna_acabados_equipo_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_asigna_acabados_equipo_detail->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo_detail->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_asigna_acabados_equipo_detail_list->GridAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_asigna_acabados_equipo_detail_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") { ?>
<?php if ($cap_asigna_acabados_equipo_detail->AllowAddDeleteRow) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_asigna_acabados_equipo_detaillist'].Submit();"><img src='phpimages/insert.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridInsertLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridInsertLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_asigna_acabados_equipo_detaillist" id="fcap_asigna_acabados_equipo_detaillist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_asigna_acabados_equipo_detail">
<div id="gmp_cap_asigna_acabados_equipo_detail" class="ewGridMiddlePanel">
<?php if ($cap_asigna_acabados_equipo_detail_list->TotalRecs > 0) { ?>
<table id="tbl_cap_asigna_acabados_equipo_detaillist" class="ewTable ewTableSeparate">
<?php echo $cap_asigna_acabados_equipo_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_asigna_acabados_equipo_detail_list->RenderListOptions();

// Render list options (header, left)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Articulo) ?>',1);"><span id="elh_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Acabado_eq) ?>',1);"><span id="elh_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_asigna_acabados_equipo_detail->ExportAll && $cap_asigna_acabados_equipo_detail->Export <> "") {
	$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_asigna_acabados_equipo_detail_list->TotalRecs > $cap_asigna_acabados_equipo_detail_list->StartRec + $cap_asigna_acabados_equipo_detail_list->DisplayRecs - 1)
		$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail_list->StartRec + $cap_asigna_acabados_equipo_detail_list->DisplayRecs - 1;
	else
		$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit" || $cap_asigna_acabados_equipo_detail->CurrentAction == "F")) {
		$cap_asigna_acabados_equipo_detail_list->KeyCount = $objForm->GetValue("key_count");
		$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail_list->KeyCount;
	}
}
$cap_asigna_acabados_equipo_detail_list->RecCnt = $cap_asigna_acabados_equipo_detail_list->StartRec - 1;
if ($cap_asigna_acabados_equipo_detail_list->Recordset && !$cap_asigna_acabados_equipo_detail_list->Recordset->EOF) {
	$cap_asigna_acabados_equipo_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_asigna_acabados_equipo_detail_list->StartRec > 1)
		$cap_asigna_acabados_equipo_detail_list->Recordset->Move($cap_asigna_acabados_equipo_detail_list->StartRec - 1);
} elseif (!$cap_asigna_acabados_equipo_detail->AllowAddDeleteRow && $cap_asigna_acabados_equipo_detail_list->StopRec == 0) {
	$cap_asigna_acabados_equipo_detail_list->StopRec = $cap_asigna_acabados_equipo_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_asigna_acabados_equipo_detail->ResetAttrs();
$cap_asigna_acabados_equipo_detail_list->RenderRow();
if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd")
	$cap_asigna_acabados_equipo_detail_list->RowIndex = 0;
while ($cap_asigna_acabados_equipo_detail_list->RecCnt < $cap_asigna_acabados_equipo_detail_list->StopRec) {
	$cap_asigna_acabados_equipo_detail_list->RecCnt++;
	if (intval($cap_asigna_acabados_equipo_detail_list->RecCnt) >= intval($cap_asigna_acabados_equipo_detail_list->StartRec)) {
		$cap_asigna_acabados_equipo_detail_list->RowCnt++;
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit" || $cap_asigna_acabados_equipo_detail->CurrentAction == "F") {
			$cap_asigna_acabados_equipo_detail_list->RowIndex++;
			$objForm->Index = $cap_asigna_acabados_equipo_detail_list->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_asigna_acabados_equipo_detail_list->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd")
				$cap_asigna_acabados_equipo_detail_list->RowAction = "insert";
			else
				$cap_asigna_acabados_equipo_detail_list->RowAction = "";
		}

		// Set up key count
		$cap_asigna_acabados_equipo_detail_list->KeyCount = $cap_asigna_acabados_equipo_detail_list->RowIndex;

		// Init row class and style
		$cap_asigna_acabados_equipo_detail->ResetAttrs();
		$cap_asigna_acabados_equipo_detail->CssClass = "";
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") {
			$cap_asigna_acabados_equipo_detail_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_asigna_acabados_equipo_detail_list->LoadRowValues($cap_asigna_acabados_equipo_detail_list->Recordset); // Load row values
		}
		$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") // Grid add
			$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" && $cap_asigna_acabados_equipo_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_asigna_acabados_equipo_detail_list->RestoreCurrentRowFormValues($cap_asigna_acabados_equipo_detail_list->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_asigna_acabados_equipo_detail->RowAttrs = array_merge($cap_asigna_acabados_equipo_detail->RowAttrs, array('data-rowindex'=>$cap_asigna_acabados_equipo_detail_list->RowCnt, 'id'=>'r' . $cap_asigna_acabados_equipo_detail_list->RowCnt . '_cap_asigna_acabados_equipo_detail', 'data-rowtype'=>$cap_asigna_acabados_equipo_detail->RowType));

		// Render row
		$cap_asigna_acabados_equipo_detail_list->RenderRow();

		// Render list options
		$cap_asigna_acabados_equipo_detail_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_asigna_acabados_equipo_detail_list->RowAction <> "delete" && $cap_asigna_acabados_equipo_detail_list->RowAction <> "insertdelete" && !($cap_asigna_acabados_equipo_detail_list->RowAction == "insert" && $cap_asigna_acabados_equipo_detail->CurrentAction == "F" && $cap_asigna_acabados_equipo_detail_list->EmptyRow())) {
?>
	<tr<?php echo $cap_asigna_acabados_equipo_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("body", "left", $cap_asigna_acabados_equipo_detail_list->RowCnt);
?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_detail_list->RowCnt ?>_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSessionValue() <> "") { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo"<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_asigna_acabados_equipo_detail_list->PageObjName . "_row_" . $cap_asigna_acabados_equipo_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_detail_list->RowCnt ?>_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_asigna_acabados_equipo_detail_list->PageObjName . "_row_" . $cap_asigna_acabados_equipo_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("body", "right", $cap_asigna_acabados_equipo_detail_list->RowCnt);
?>
	</tr>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD || $cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.UpdateOpts(<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd")
		if (!$cap_asigna_acabados_equipo_detail_list->Recordset->EOF) $cap_asigna_acabados_equipo_detail_list->Recordset->MoveNext();
}
?>
<?php
	if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit") {
		$cap_asigna_acabados_equipo_detail_list->RowIndex = '$rowindex$';
		$cap_asigna_acabados_equipo_detail_list->LoadDefaultValues();

		// Set row properties
		$cap_asigna_acabados_equipo_detail->ResetAttrs();
		$cap_asigna_acabados_equipo_detail->RowAttrs = array_merge($cap_asigna_acabados_equipo_detail->RowAttrs, array('data-rowindex'=>$cap_asigna_acabados_equipo_detail_list->RowIndex, 'id'=>'r0_cap_asigna_acabados_equipo_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_asigna_acabados_equipo_detail->RowAttrs["class"], "ewTemplate");
		$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_asigna_acabados_equipo_detail_list->RenderRow();

		// Render list options
		$cap_asigna_acabados_equipo_detail_list->RenderListOptions();
		$cap_asigna_acabados_equipo_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_asigna_acabados_equipo_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("body", "left", $cap_asigna_acabados_equipo_detail_list->RowIndex);
?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSessionValue() <> "") { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo"<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td><span id="el$rowindex$_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_asigna_acabados_equipo_detail_list->ListOptions->Render("body", "right", $cap_asigna_acabados_equipo_detail_list->RowCnt);
?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.UpdateOpts(<?php echo $cap_asigna_acabados_equipo_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_asigna_acabados_equipo_detail_list->KeyCount ?>">
<?php echo $cap_asigna_acabados_equipo_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_asigna_acabados_equipo_detail_list->Recordset)
	$cap_asigna_acabados_equipo_detail_list->Recordset->Close();
?>
<?php if ($cap_asigna_acabados_equipo_detail_list->TotalRecs > 0) { ?>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo_detail->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_asigna_acabados_equipo_detail_list->Pager)) $cap_asigna_acabados_equipo_detail_list->Pager = new cPrevNextPager($cap_asigna_acabados_equipo_detail_list->StartRec, $cap_asigna_acabados_equipo_detail_list->DisplayRecs, $cap_asigna_acabados_equipo_detail_list->TotalRecs) ?>
<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_asigna_acabados_equipo_detail_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>start=<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_asigna_acabados_equipo_detail_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_asigna_acabados_equipo_detail_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_asigna_acabados_equipo_detail_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_asigna_acabados_equipo_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_asigna_acabados_equipo_detail_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_asigna_acabados_equipo_detail->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd" && $cap_asigna_acabados_equipo_detail->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_asigna_acabados_equipo_detail_list->GridAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_asigna_acabados_equipo_detail_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") { ?>
<?php if ($cap_asigna_acabados_equipo_detail->AllowAddDeleteRow) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_asigna_acabados_equipo_detaillist'].Submit();"><img src='phpimages/insert.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridInsertLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridInsertLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_asigna_acabados_equipo_detail_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detaillist.Init();
</script>
<?php } ?>
<?php
$cap_asigna_acabados_equipo_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_asigna_acabados_equipo_detail_list->Page_Terminate();
?>
