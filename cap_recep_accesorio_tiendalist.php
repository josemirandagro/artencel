<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_recep_accesorio_tiendainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_recep_accesorio_tienda_list = NULL; // Initialize page object first

class ccap_recep_accesorio_tienda_list extends ccap_recep_accesorio_tienda {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_recep_accesorio_tienda';

	// Page object name
	var $PageObjName = 'cap_recep_accesorio_tienda_list';

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

		// Table object (cap_recep_accesorio_tienda)
		if (!isset($GLOBALS["cap_recep_accesorio_tienda"])) {
			$GLOBALS["cap_recep_accesorio_tienda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_recep_accesorio_tienda"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_recep_accesorio_tiendaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_recep_accesorio_tiendadelete.php";
		$this->MultiUpdateUrl = "cap_recep_accesorio_tiendaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_recep_accesorio_tienda', TRUE);

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
		$this->Fecha_recepcion->Visible = !$this->IsAddOrEdit();
		$this->Hora_recepcion->Visible = !$this->IsAddOrEdit();

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

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$this->GridUpdate();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
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
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $this->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue("k_key"));
			$rowaction = strval($objForm->GetValue("k_action"));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
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

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Codigo") && $objForm->HasValue("o_Codigo") && $this->Codigo->CurrentValue <> $this->Codigo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Status") && $objForm->HasValue("o_Status") && $this->Status->CurrentValue <> $this->Status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Articulo") && $objForm->HasValue("o_Id_Articulo") && $this->Id_Articulo->CurrentValue <> $this->Id_Articulo->OldValue)
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
			$this->UpdateSort($this->Codigo); // Codigo
			$this->UpdateSort($this->Status); // Status
			$this->UpdateSort($this->Id_Articulo); // Id_Articulo
			$this->UpdateSort($this->Fecha_recepcion); // Fecha_recepcion
			$this->UpdateSort($this->Hora_recepcion); // Hora_recepcion
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Codigo->setSort("");
				$this->Status->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Fecha_recepcion->setSort("");
				$this->Hora_recepcion->setSort("");
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
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
				}
			}
		}
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $this->Id_Traspaso_Det->CurrentValue . "\">";
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
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Status->CurrentValue = "Enviado";
		$this->Status->OldValue = $this->Status->CurrentValue;
		$this->Id_Articulo->CurrentValue = NULL;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Fecha_recepcion->CurrentValue = NULL;
		$this->Fecha_recepcion->OldValue = $this->Fecha_recepcion->CurrentValue;
		$this->Hora_recepcion->CurrentValue = NULL;
		$this->Hora_recepcion->OldValue = $this->Hora_recepcion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Fecha_recepcion->FldIsDetailKey) {
			$this->Fecha_recepcion->setFormValue($objForm->GetValue("x_Fecha_recepcion"));
			$this->Fecha_recepcion->CurrentValue = ew_UnFormatDateTime($this->Fecha_recepcion->CurrentValue, 7);
		}
		if (!$this->Hora_recepcion->FldIsDetailKey) {
			$this->Hora_recepcion->setFormValue($objForm->GetValue("x_Hora_recepcion"));
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
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Fecha_recepcion->CurrentValue = $this->Fecha_recepcion->FormValue;
		$this->Fecha_recepcion->CurrentValue = ew_UnFormatDateTime($this->Fecha_recepcion->CurrentValue, 7);
		$this->Hora_recepcion->CurrentValue = $this->Hora_recepcion->FormValue;
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
		$this->Id_Almacen_Entrega->setDbValue($rs->fields('Id_Almacen_Entrega'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Id_Almacen_Recibe->setDbValue($rs->fields('Id_Almacen_Recibe'));
		$this->Id_Empleado_Recibe->setDbValue($rs->fields('Id_Empleado_Recibe'));
		$this->Id_Empleado_Entrega->setDbValue($rs->fields('Id_Empleado_Entrega'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Fecha_recepcion->setDbValue($rs->fields('Fecha_recepcion'));
		$this->Hora_recepcion->setDbValue($rs->fields('Hora_recepcion'));
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

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->CellCssStyle = "white-space: nowrap;";

		// Codigo
		// Status
		// Id_Almacen_Recibe

		$this->Id_Almacen_Recibe->CellCssStyle = "white-space: nowrap;";

		// Id_Empleado_Recibe
		// Id_Empleado_Entrega
		// Id_Articulo
		// Fecha_recepcion
		// Hora_recepcion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

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

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->ViewValue = $this->Id_Almacen_Recibe->CurrentValue;
			if (strval($this->Id_Almacen_Recibe->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Id_Empleado_Recibe
			$this->Id_Empleado_Recibe->ViewValue = $this->Id_Empleado_Recibe->CurrentValue;
			$this->Id_Empleado_Recibe->ViewCustomAttributes = "";

			// Id_Empleado_Entrega
			if (strval($this->Id_Empleado_Entrega->CurrentValue) <> "") {
				$sFilterWrk = "`Id_usuario`" . ew_SearchString("=", $this->Id_Empleado_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_usuario`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_user`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Empleado_Entrega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Empleado_Entrega->ViewValue = $this->Id_Empleado_Entrega->CurrentValue;
				}
			} else {
				$this->Id_Empleado_Entrega->ViewValue = NULL;
			}
			$this->Id_Empleado_Entrega->ViewCustomAttributes = "";

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

			// Fecha_recepcion
			$this->Fecha_recepcion->ViewValue = $this->Fecha_recepcion->CurrentValue;
			$this->Fecha_recepcion->ViewValue = ew_FormatDateTime($this->Fecha_recepcion->ViewValue, 7);
			$this->Fecha_recepcion->ViewCustomAttributes = "";

			// Hora_recepcion
			$this->Hora_recepcion->ViewValue = $this->Hora_recepcion->CurrentValue;
			$this->Hora_recepcion->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Fecha_recepcion
			$this->Fecha_recepcion->LinkCustomAttributes = "";
			$this->Fecha_recepcion->HrefValue = "";
			$this->Fecha_recepcion->TooltipValue = "";

			// Hora_recepcion
			$this->Hora_recepcion->LinkCustomAttributes = "";
			$this->Hora_recepcion->HrefValue = "";
			$this->Hora_recepcion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$arwrk[] = array($this->Status->FldTagValue(3), $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->FldTagValue(3));
			$this->Status->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = ew_HtmlEncode($this->Id_Articulo->CurrentValue);
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

			// Fecha_recepcion
			// Hora_recepcion
			// Edit refer script
			// Codigo

			$this->Codigo->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Fecha_recepcion
			$this->Fecha_recepcion->HrefValue = "";

			// Hora_recepcion
			$this->Hora_recepcion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$arwrk[] = array($this->Status->FldTagValue(3), $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->FldTagValue(3));
			$this->Status->EditValue = $arwrk;

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

			// Fecha_recepcion
			// Hora_recepcion
			// Edit refer script
			// Codigo

			$this->Codigo->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Fecha_recepcion
			$this->Fecha_recepcion->HrefValue = "";

			// Hora_recepcion
			$this->Hora_recepcion->HrefValue = "";
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
		if ($this->Status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Status->FldCaption());
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
				$sThisKey .= $row['Id_Traspaso_Det'];
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

			// Status
			$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, "", $this->Status->ReadOnly);

			// Fecha_recepcion
			$this->Fecha_recepcion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_recepcion'] = &$this->Fecha_recepcion->DbValue;

			// Hora_recepcion
			$this->Hora_recepcion->SetDbValueDef($rsnew, ew_CurrentTime(), NULL);
			$rsnew['Hora_recepcion'] = &$this->Hora_recepcion->DbValue;

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

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, "", strval($this->Status->CurrentValue) == "");

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, FALSE);

		// Fecha_recepcion
		$this->Fecha_recepcion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_recepcion'] = &$this->Fecha_recepcion->DbValue;

		// Hora_recepcion
		$this->Hora_recepcion->SetDbValueDef($rsnew, ew_CurrentTime(), NULL);
		$rsnew['Hora_recepcion'] = &$this->Hora_recepcion->DbValue;

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
		$item->Body = "<a id=\"emf_cap_recep_accesorio_tienda\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_recep_accesorio_tienda',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_recep_accesorio_tiendalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
	  $GLOBALS["Language"]->setPhrase("NoRecord", "NO HAY ACCESORIOS PENDIENTES POR RECIBIR"); 
	  $GLOBALS["Language"]->setPhrase("GridEditLink", "<H3>RECIBIR ACCESORIOS</H3>"); 
	  $this->AllowAddDeleteRow = FALSE;  // QUITAMOS EL BOTON ADD_ROW EN GRID EDIT
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
if (!isset($cap_recep_accesorio_tienda_list)) $cap_recep_accesorio_tienda_list = new ccap_recep_accesorio_tienda_list();

// Page init
$cap_recep_accesorio_tienda_list->Page_Init();

// Page main
$cap_recep_accesorio_tienda_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_recep_accesorio_tienda->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_recep_accesorio_tienda_list = new ew_Page("cap_recep_accesorio_tienda_list");
cap_recep_accesorio_tienda_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_recep_accesorio_tienda_list.PageID; // For backward compatibility

// Form object
var fcap_recep_accesorio_tiendalist = new ew_Form("fcap_recep_accesorio_tiendalist");

// Validate form
fcap_recep_accesorio_tiendalist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_recep_accesorio_tienda->Status->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_recep_accesorio_tiendalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_recep_accesorio_tiendalist.ValidateRequired = true;
<?php } else { ?>
fcap_recep_accesorio_tiendalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_recep_accesorio_tiendalist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_recep_accesorio_tienda_list->TotalRecs = $cap_recep_accesorio_tienda->SelectRecordCount();
	} else {
		if ($cap_recep_accesorio_tienda_list->Recordset = $cap_recep_accesorio_tienda_list->LoadRecordset())
			$cap_recep_accesorio_tienda_list->TotalRecs = $cap_recep_accesorio_tienda_list->Recordset->RecordCount();
	}
	$cap_recep_accesorio_tienda_list->StartRec = 1;
	if ($cap_recep_accesorio_tienda_list->DisplayRecs <= 0 || ($cap_recep_accesorio_tienda->Export <> "" && $cap_recep_accesorio_tienda->ExportAll)) // Display all records
		$cap_recep_accesorio_tienda_list->DisplayRecs = $cap_recep_accesorio_tienda_list->TotalRecs;
	if (!($cap_recep_accesorio_tienda->Export <> "" && $cap_recep_accesorio_tienda->ExportAll))
		$cap_recep_accesorio_tienda_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_recep_accesorio_tienda_list->Recordset = $cap_recep_accesorio_tienda_list->LoadRecordset($cap_recep_accesorio_tienda_list->StartRec-1, $cap_recep_accesorio_tienda_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_recep_accesorio_tienda->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_recep_accesorio_tienda_list->ExportOptions->Render("body"); ?>
</p>
<?php $cap_recep_accesorio_tienda_list->ShowPageHeader(); ?>
<?php
$cap_recep_accesorio_tienda_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_recep_accesorio_tienda->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_recep_accesorio_tienda->CurrentAction <> "gridadd" && $cap_recep_accesorio_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_recep_accesorio_tienda_list->Pager)) $cap_recep_accesorio_tienda_list->Pager = new cPrevNextPager($cap_recep_accesorio_tienda_list->StartRec, $cap_recep_accesorio_tienda_list->DisplayRecs, $cap_recep_accesorio_tienda_list->TotalRecs) ?>
<?php if ($cap_recep_accesorio_tienda_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_recep_accesorio_tienda_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_recep_accesorio_tienda_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_recep_accesorio_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_recep_accesorio_tienda->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_recep_accesorio_tienda->CurrentAction <> "gridadd" && $cap_recep_accesorio_tienda->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0 && $cap_recep_accesorio_tienda_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_recep_accesorio_tienda_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit") { ?>
<?php if ($cap_recep_accesorio_tienda->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_recep_accesorio_tiendalist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_recep_accesorio_tiendalist" id="fcap_recep_accesorio_tiendalist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_recep_accesorio_tienda">
<div id="gmp_cap_recep_accesorio_tienda" class="ewGridMiddlePanel">
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0) { ?>
<table id="tbl_cap_recep_accesorio_tiendalist" class="ewTable ewTableSeparate">
<?php echo $cap_recep_accesorio_tienda->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_recep_accesorio_tienda_list->RenderListOptions();

// Render list options (header, left)
$cap_recep_accesorio_tienda_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_recep_accesorio_tienda->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Codigo) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_tienda_Codigo" class="cap_recep_accesorio_tienda_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_tienda->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Codigo) ?>',1);"><span id="elh_cap_recep_accesorio_tienda_Codigo" class="cap_recep_accesorio_tienda_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_tienda->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_tienda->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_tienda->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_tienda->Status->Visible) { // Status ?>
	<?php if ($cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Status) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_tienda_Status" class="cap_recep_accesorio_tienda_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_tienda->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Status) ?>',1);"><span id="elh_cap_recep_accesorio_tienda_Status" class="cap_recep_accesorio_tienda_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_tienda->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_tienda->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_tienda->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_tienda_Id_Articulo" class="cap_recep_accesorio_tienda_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_tienda->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Id_Articulo) ?>',1);"><span id="elh_cap_recep_accesorio_tienda_Id_Articulo" class="cap_recep_accesorio_tienda_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_tienda->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_tienda->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_tienda->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_tienda->Fecha_recepcion->Visible) { // Fecha_recepcion ?>
	<?php if ($cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Fecha_recepcion) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_tienda_Fecha_recepcion" class="cap_recep_accesorio_tienda_Fecha_recepcion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_tienda->Fecha_recepcion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Fecha_recepcion) ?>',1);"><span id="elh_cap_recep_accesorio_tienda_Fecha_recepcion" class="cap_recep_accesorio_tienda_Fecha_recepcion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_tienda->Fecha_recepcion->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_tienda->Fecha_recepcion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_tienda->Fecha_recepcion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_tienda->Hora_recepcion->Visible) { // Hora_recepcion ?>
	<?php if ($cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Hora_recepcion) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_tienda_Hora_recepcion" class="cap_recep_accesorio_tienda_Hora_recepcion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_tienda->Hora_recepcion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_recep_accesorio_tienda->SortUrl($cap_recep_accesorio_tienda->Hora_recepcion) ?>',1);"><span id="elh_cap_recep_accesorio_tienda_Hora_recepcion" class="cap_recep_accesorio_tienda_Hora_recepcion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_tienda->Hora_recepcion->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_tienda->Hora_recepcion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_tienda->Hora_recepcion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_recep_accesorio_tienda_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_recep_accesorio_tienda->ExportAll && $cap_recep_accesorio_tienda->Export <> "") {
	$cap_recep_accesorio_tienda_list->StopRec = $cap_recep_accesorio_tienda_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_recep_accesorio_tienda_list->TotalRecs > $cap_recep_accesorio_tienda_list->StartRec + $cap_recep_accesorio_tienda_list->DisplayRecs - 1)
		$cap_recep_accesorio_tienda_list->StopRec = $cap_recep_accesorio_tienda_list->StartRec + $cap_recep_accesorio_tienda_list->DisplayRecs - 1;
	else
		$cap_recep_accesorio_tienda_list->StopRec = $cap_recep_accesorio_tienda_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_recep_accesorio_tienda->CurrentAction == "gridadd" || $cap_recep_accesorio_tienda->CurrentAction == "gridedit" || $cap_recep_accesorio_tienda->CurrentAction == "F")) {
		$cap_recep_accesorio_tienda_list->KeyCount = $objForm->GetValue("key_count");
		$cap_recep_accesorio_tienda_list->StopRec = $cap_recep_accesorio_tienda_list->KeyCount;
	}
}
$cap_recep_accesorio_tienda_list->RecCnt = $cap_recep_accesorio_tienda_list->StartRec - 1;
if ($cap_recep_accesorio_tienda_list->Recordset && !$cap_recep_accesorio_tienda_list->Recordset->EOF) {
	$cap_recep_accesorio_tienda_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_recep_accesorio_tienda_list->StartRec > 1)
		$cap_recep_accesorio_tienda_list->Recordset->Move($cap_recep_accesorio_tienda_list->StartRec - 1);
} elseif (!$cap_recep_accesorio_tienda->AllowAddDeleteRow && $cap_recep_accesorio_tienda_list->StopRec == 0) {
	$cap_recep_accesorio_tienda_list->StopRec = $cap_recep_accesorio_tienda->GridAddRowCount;
}

// Initialize aggregate
$cap_recep_accesorio_tienda->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_recep_accesorio_tienda->ResetAttrs();
$cap_recep_accesorio_tienda_list->RenderRow();
if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit")
	$cap_recep_accesorio_tienda_list->RowIndex = 0;
while ($cap_recep_accesorio_tienda_list->RecCnt < $cap_recep_accesorio_tienda_list->StopRec) {
	$cap_recep_accesorio_tienda_list->RecCnt++;
	if (intval($cap_recep_accesorio_tienda_list->RecCnt) >= intval($cap_recep_accesorio_tienda_list->StartRec)) {
		$cap_recep_accesorio_tienda_list->RowCnt++;
		if ($cap_recep_accesorio_tienda->CurrentAction == "gridadd" || $cap_recep_accesorio_tienda->CurrentAction == "gridedit" || $cap_recep_accesorio_tienda->CurrentAction == "F") {
			$cap_recep_accesorio_tienda_list->RowIndex++;
			$objForm->Index = $cap_recep_accesorio_tienda_list->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_recep_accesorio_tienda_list->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_recep_accesorio_tienda->CurrentAction == "gridadd")
				$cap_recep_accesorio_tienda_list->RowAction = "insert";
			else
				$cap_recep_accesorio_tienda_list->RowAction = "";
		}

		// Set up key count
		$cap_recep_accesorio_tienda_list->KeyCount = $cap_recep_accesorio_tienda_list->RowIndex;

		// Init row class and style
		$cap_recep_accesorio_tienda->ResetAttrs();
		$cap_recep_accesorio_tienda->CssClass = "";
		if ($cap_recep_accesorio_tienda->CurrentAction == "gridadd") {
			$cap_recep_accesorio_tienda_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_recep_accesorio_tienda_list->LoadRowValues($cap_recep_accesorio_tienda_list->Recordset); // Load row values
		}
		$cap_recep_accesorio_tienda->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit") { // Grid edit
			if ($cap_recep_accesorio_tienda->EventCancelled) {
				$cap_recep_accesorio_tienda_list->RestoreCurrentRowFormValues($cap_recep_accesorio_tienda_list->RowIndex); // Restore form values
			}
			if ($cap_recep_accesorio_tienda_list->RowAction == "insert")
				$cap_recep_accesorio_tienda->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_recep_accesorio_tienda->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit" && ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT || $cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) && $cap_recep_accesorio_tienda->EventCancelled) // Update failed
			$cap_recep_accesorio_tienda_list->RestoreCurrentRowFormValues($cap_recep_accesorio_tienda_list->RowIndex); // Restore form values
		if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_recep_accesorio_tienda_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_recep_accesorio_tienda->RowAttrs = array_merge($cap_recep_accesorio_tienda->RowAttrs, array('data-rowindex'=>$cap_recep_accesorio_tienda_list->RowCnt, 'id'=>'r' . $cap_recep_accesorio_tienda_list->RowCnt . '_cap_recep_accesorio_tienda', 'data-rowtype'=>$cap_recep_accesorio_tienda->RowType));

		// Render row
		$cap_recep_accesorio_tienda_list->RenderRow();

		// Render list options
		$cap_recep_accesorio_tienda_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_recep_accesorio_tienda_list->RowAction <> "delete" && $cap_recep_accesorio_tienda_list->RowAction <> "insertdelete" && !($cap_recep_accesorio_tienda_list->RowAction == "insert" && $cap_recep_accesorio_tienda->CurrentAction == "F" && $cap_recep_accesorio_tienda_list->EmptyRow())) {
?>
	<tr<?php echo $cap_recep_accesorio_tienda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorio_tienda_list->ListOptions->Render("body", "left", $cap_recep_accesorio_tienda_list->RowCnt);
?>
	<?php if ($cap_recep_accesorio_tienda->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_recep_accesorio_tienda->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_tienda_list->RowCnt ?>_cap_recep_accesorio_tienda_Codigo" class="cap_recep_accesorio_tienda_Codigo">
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" size="30" maxlength="20" value="<?php echo $cap_recep_accesorio_tienda->Codigo->EditValue ?>"<?php echo $cap_recep_accesorio_tienda->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Codigo->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_recep_accesorio_tienda->Codigo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Codigo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Codigo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_tienda->Codigo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_tienda_list->PageObjName . "_row_" . $cap_recep_accesorio_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Traspaso_Det->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Traspaso_Det->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT || $cap_recep_accesorio_tienda->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Traspaso_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Status->Visible) { // Status ?>
		<td<?php echo $cap_recep_accesorio_tienda->Status->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_tienda_list->RowCnt ?>_cap_recep_accesorio_tienda_Status" class="cap_recep_accesorio_tienda_Status">
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="tp_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="{value}"<?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_recep_accesorio_tienda->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_tienda->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Status->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="{value}"<?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_recep_accesorio_tienda->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_tienda->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_tienda->Status->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Status->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_tienda_list->PageObjName . "_row_" . $cap_recep_accesorio_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_recep_accesorio_tienda->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_tienda_list->RowCnt ?>_cap_recep_accesorio_tienda_Id_Articulo" class="cap_recep_accesorio_tienda_Id_Articulo">
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php
	$wrkonchange = trim(" " . @$cap_recep_accesorio_tienda->Id_Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_recep_accesorio_tienda->Id_Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_recep_accesorio_tienda_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="sv_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo $cap_recep_accesorio_tienda->Id_Articulo->EditValue ?>" size="30"<?php echo $cap_recep_accesorio_tienda->Id_Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" style="display: inline; z-index: <?php echo (9000 - $cap_recep_accesorio_tienda_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo $cap_recep_accesorio_tienda->Id_Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` FROM `ca_articulos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="q_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_tienda->Id_Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo", fcap_recep_accesorio_tiendalist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo") + ar[i] : "";
	return dv;
}
oas.ac.typeAhead = false;
fcap_recep_accesorio_tiendalist.AutoSuggests["x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_recep_accesorio_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_tienda_list->PageObjName . "_row_" . $cap_recep_accesorio_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Fecha_recepcion->Visible) { // Fecha_recepcion ?>
		<td<?php echo $cap_recep_accesorio_tienda->Fecha_recepcion->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_tienda_list->RowCnt ?>_cap_recep_accesorio_tienda_Fecha_recepcion" class="cap_recep_accesorio_tienda_Fecha_recepcion">
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Fecha_recepcion" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Fecha_recepcion" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Fecha_recepcion->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_tienda->Fecha_recepcion->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Fecha_recepcion->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_tienda_list->PageObjName . "_row_" . $cap_recep_accesorio_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Hora_recepcion->Visible) { // Hora_recepcion ?>
		<td<?php echo $cap_recep_accesorio_tienda->Hora_recepcion->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_tienda_list->RowCnt ?>_cap_recep_accesorio_tienda_Hora_recepcion" class="cap_recep_accesorio_tienda_Hora_recepcion">
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Hora_recepcion" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Hora_recepcion" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Hora_recepcion->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_tienda->Hora_recepcion->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_tienda->Hora_recepcion->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_tienda_list->PageObjName . "_row_" . $cap_recep_accesorio_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorio_tienda_list->ListOptions->Render("body", "right", $cap_recep_accesorio_tienda_list->RowCnt);
?>
	</tr>
<?php if ($cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_ADD || $cap_recep_accesorio_tienda->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_recep_accesorio_tiendalist.UpdateOpts(<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_recep_accesorio_tienda->CurrentAction <> "gridadd")
		if (!$cap_recep_accesorio_tienda_list->Recordset->EOF) $cap_recep_accesorio_tienda_list->Recordset->MoveNext();
}
?>
<?php
	if ($cap_recep_accesorio_tienda->CurrentAction == "gridadd" || $cap_recep_accesorio_tienda->CurrentAction == "gridedit") {
		$cap_recep_accesorio_tienda_list->RowIndex = '$rowindex$';
		$cap_recep_accesorio_tienda_list->LoadDefaultValues();

		// Set row properties
		$cap_recep_accesorio_tienda->ResetAttrs();
		$cap_recep_accesorio_tienda->RowAttrs = array_merge($cap_recep_accesorio_tienda->RowAttrs, array('data-rowindex'=>$cap_recep_accesorio_tienda_list->RowIndex, 'id'=>'r0_cap_recep_accesorio_tienda', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_recep_accesorio_tienda->RowAttrs["class"], "ewTemplate");
		$cap_recep_accesorio_tienda->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_recep_accesorio_tienda_list->RenderRow();

		// Render list options
		$cap_recep_accesorio_tienda_list->RenderListOptions();
		$cap_recep_accesorio_tienda_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_recep_accesorio_tienda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorio_tienda_list->ListOptions->Render("body", "left", $cap_recep_accesorio_tienda_list->RowIndex);
?>
	<?php if ($cap_recep_accesorio_tienda->Codigo->Visible) { // Codigo ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_tienda_Codigo" class="cap_recep_accesorio_tienda_Codigo">
<input type="text" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" size="30" maxlength="20" value="<?php echo $cap_recep_accesorio_tienda->Codigo->EditValue ?>"<?php echo $cap_recep_accesorio_tienda->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Status->Visible) { // Status ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_tienda_Status" class="cap_recep_accesorio_tienda_Status">
<div id="tp_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="{value}"<?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_recep_accesorio_tienda->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_tienda->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_recep_accesorio_tienda->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Status->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_tienda_Id_Articulo" class="cap_recep_accesorio_tienda_Id_Articulo">
<?php
	$wrkonchange = trim(" " . @$cap_recep_accesorio_tienda->Id_Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_recep_accesorio_tienda->Id_Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_recep_accesorio_tienda_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="sv_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo $cap_recep_accesorio_tienda->Id_Articulo->EditValue ?>" size="30"<?php echo $cap_recep_accesorio_tienda->Id_Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" style="display: inline; z-index: <?php echo (9000 - $cap_recep_accesorio_tienda_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo $cap_recep_accesorio_tienda->Id_Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` FROM `ca_articulos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="q_x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_tienda->Id_Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo", fcap_recep_accesorio_tiendalist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo") + ar[i] : "";
	return dv;
}
oas.ac.typeAhead = false;
fcap_recep_accesorio_tiendalist.AutoSuggests["x<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Fecha_recepcion->Visible) { // Fecha_recepcion ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_tienda_Fecha_recepcion" class="cap_recep_accesorio_tienda_Fecha_recepcion">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Fecha_recepcion" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Fecha_recepcion" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Fecha_recepcion->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_tienda->Hora_recepcion->Visible) { // Hora_recepcion ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_tienda_Hora_recepcion" class="cap_recep_accesorio_tienda_Hora_recepcion">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Hora_recepcion" id="o<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>_Hora_recepcion" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_tienda->Hora_recepcion->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorio_tienda_list->ListOptions->Render("body", "right", $cap_recep_accesorio_tienda_list->RowCnt);
?>
<script type="text/javascript">
fcap_recep_accesorio_tiendalist.UpdateOpts(<?php echo $cap_recep_accesorio_tienda_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_recep_accesorio_tienda_list->KeyCount ?>">
<?php echo $cap_recep_accesorio_tienda_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_recep_accesorio_tienda->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_recep_accesorio_tienda_list->Recordset)
	$cap_recep_accesorio_tienda_list->Recordset->Close();
?>
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0) { ?>
<?php if ($cap_recep_accesorio_tienda->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_recep_accesorio_tienda->CurrentAction <> "gridadd" && $cap_recep_accesorio_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_recep_accesorio_tienda_list->Pager)) $cap_recep_accesorio_tienda_list->Pager = new cPrevNextPager($cap_recep_accesorio_tienda_list->StartRec, $cap_recep_accesorio_tienda_list->DisplayRecs, $cap_recep_accesorio_tienda_list->TotalRecs) ?>
<?php if ($cap_recep_accesorio_tienda_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_recep_accesorio_tienda_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_recep_accesorio_tienda_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>start=<?php echo $cap_recep_accesorio_tienda_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_recep_accesorio_tienda_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_recep_accesorio_tienda_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_recep_accesorio_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_recep_accesorio_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_recep_accesorio_tienda->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_recep_accesorio_tienda->CurrentAction <> "gridadd" && $cap_recep_accesorio_tienda->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_recep_accesorio_tienda_list->TotalRecs > 0 && $cap_recep_accesorio_tienda_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_recep_accesorio_tienda_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_recep_accesorio_tienda->CurrentAction == "gridedit") { ?>
<?php if ($cap_recep_accesorio_tienda->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_recep_accesorio_tiendalist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_recep_accesorio_tienda_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_recep_accesorio_tienda->Export == "") { ?>
<script type="text/javascript">
fcap_recep_accesorio_tiendalist.Init();
</script>
<?php } ?>
<?php
$cap_recep_accesorio_tienda_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_recep_accesorio_tienda->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");  

  pon_boton_cerrar();  
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_recep_accesorio_tienda_list->Page_Terminate();
?>
