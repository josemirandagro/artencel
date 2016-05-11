<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_control_papeletainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_control_papeleta_list = NULL; // Initialize page object first

class ccap_control_papeleta_list extends ccap_control_papeleta {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_control_papeleta';

	// Page object name
	var $PageObjName = 'cap_control_papeleta_list';

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

		// Table object (cap_control_papeleta)
		if (!isset($GLOBALS["cap_control_papeleta"])) {
			$GLOBALS["cap_control_papeleta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_control_papeleta"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_control_papeletaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_control_papeletadelete.php";
		$this->MultiUpdateUrl = "cap_control_papeletaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_control_papeleta', TRUE);

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
		$this->FechaAviso->Visible = !$this->IsAddOrEdit();

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
			$this->Id_Venta_Eq->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Venta_Eq->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_StatusPapeleta") && $objForm->HasValue("o_StatusPapeleta") && $this->StatusPapeleta->CurrentValue <> $this->StatusPapeleta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Tipo_Papeleta") && $objForm->HasValue("o_Tipo_Papeleta") && $this->Tipo_Papeleta->CurrentValue <> $this->Tipo_Papeleta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Num_IMEI") && $objForm->HasValue("o_Num_IMEI") && $this->Num_IMEI->CurrentValue <> $this->Num_IMEI->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Num_CEL") && $objForm->HasValue("o_Num_CEL") && $this->Num_CEL->CurrentValue <> $this->Num_CEL->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_FolioImpresoPapeleta") && $objForm->HasValue("o_FolioImpresoPapeleta") && $this->FolioImpresoPapeleta->CurrentValue <> $this->FolioImpresoPapeleta->OldValue)
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

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Venta_Eq, FALSE); // Id_Venta_Eq
		$this->BuildSearchSql($sWhere, $this->StatusPapeleta, FALSE); // StatusPapeleta
		$this->BuildSearchSql($sWhere, $this->FechaAviso, FALSE); // FechaAviso
		$this->BuildSearchSql($sWhere, $this->Tipo_Papeleta, FALSE); // Tipo Papeleta
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI
		$this->BuildSearchSql($sWhere, $this->Num_CEL, FALSE); // Num_CEL
		$this->BuildSearchSql($sWhere, $this->FolioImpresoPapeleta, FALSE); // FolioImpresoPapeleta

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Venta_Eq->AdvancedSearch->Save(); // Id_Venta_Eq
			$this->StatusPapeleta->AdvancedSearch->Save(); // StatusPapeleta
			$this->FechaAviso->AdvancedSearch->Save(); // FechaAviso
			$this->Tipo_Papeleta->AdvancedSearch->Save(); // Tipo Papeleta
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
			$this->Num_CEL->AdvancedSearch->Save(); // Num_CEL
			$this->FolioImpresoPapeleta->AdvancedSearch->Save(); // FolioImpresoPapeleta
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
		$this->BuildBasicSearchSQL($sWhere, $this->Num_CEL, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->FolioImpresoPapeleta, $Keyword);
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
		if ($this->StatusPapeleta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaAviso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tipo_Papeleta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_CEL->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FolioImpresoPapeleta->AdvancedSearch->IssetSession())
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
		$this->StatusPapeleta->AdvancedSearch->UnsetSession();
		$this->FechaAviso->AdvancedSearch->UnsetSession();
		$this->Tipo_Papeleta->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
		$this->Num_CEL->AdvancedSearch->UnsetSession();
		$this->FolioImpresoPapeleta->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Venta_Eq->AdvancedSearch->Load();
		$this->StatusPapeleta->AdvancedSearch->Load();
		$this->FechaAviso->AdvancedSearch->Load();
		$this->Tipo_Papeleta->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->FolioImpresoPapeleta->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->StatusPapeleta); // StatusPapeleta
			$this->UpdateSort($this->FechaAviso); // FechaAviso
			$this->UpdateSort($this->Tipo_Papeleta); // Tipo Papeleta
			$this->UpdateSort($this->Num_IMEI); // Num_IMEI
			$this->UpdateSort($this->Num_CEL); // Num_CEL
			$this->UpdateSort($this->FolioImpresoPapeleta); // FolioImpresoPapeleta
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
				$this->StatusPapeleta->setSort("");
				$this->FechaAviso->setSort("");
				$this->Tipo_Papeleta->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_CEL->setSort("");
				$this->FolioImpresoPapeleta->setSort("");
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
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $this->Id_Venta_Eq->CurrentValue . "\">";
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
		$this->StatusPapeleta->CurrentValue = "Por Enviar";
		$this->StatusPapeleta->OldValue = $this->StatusPapeleta->CurrentValue;
		$this->FechaAviso->CurrentValue = NULL;
		$this->FechaAviso->OldValue = $this->FechaAviso->CurrentValue;
		$this->Tipo_Papeleta->CurrentValue = "SI";
		$this->Tipo_Papeleta->OldValue = $this->Tipo_Papeleta->CurrentValue;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->Num_CEL->CurrentValue = NULL;
		$this->Num_CEL->OldValue = $this->Num_CEL->CurrentValue;
		$this->FolioImpresoPapeleta->CurrentValue = NULL;
		$this->FolioImpresoPapeleta->OldValue = $this->FolioImpresoPapeleta->CurrentValue;
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

		// StatusPapeleta
		$this->StatusPapeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_StatusPapeleta"]);
		if ($this->StatusPapeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->StatusPapeleta->AdvancedSearch->SearchOperator = @$_GET["z_StatusPapeleta"];

		// FechaAviso
		$this->FechaAviso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaAviso"]);
		if ($this->FechaAviso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaAviso->AdvancedSearch->SearchOperator = @$_GET["z_FechaAviso"];
		$this->FechaAviso->AdvancedSearch->SearchCondition = @$_GET["v_FechaAviso"];
		$this->FechaAviso->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_FechaAviso"]);
		if ($this->FechaAviso->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->FechaAviso->AdvancedSearch->SearchOperator2 = @$_GET["w_FechaAviso"];

		// Tipo Papeleta
		$this->Tipo_Papeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tipo_Papeleta"]);
		if ($this->Tipo_Papeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tipo_Papeleta->AdvancedSearch->SearchOperator = @$_GET["z_Tipo_Papeleta"];

		// Num_IMEI
		$this->Num_IMEI->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_IMEI"]);
		if ($this->Num_IMEI->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_IMEI->AdvancedSearch->SearchOperator = @$_GET["z_Num_IMEI"];

		// Num_CEL
		$this->Num_CEL->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_CEL"]);
		if ($this->Num_CEL->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_CEL->AdvancedSearch->SearchOperator = @$_GET["z_Num_CEL"];

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FolioImpresoPapeleta"]);
		if ($this->FolioImpresoPapeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FolioImpresoPapeleta->AdvancedSearch->SearchOperator = @$_GET["z_FolioImpresoPapeleta"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->StatusPapeleta->FldIsDetailKey) {
			$this->StatusPapeleta->setFormValue($objForm->GetValue("x_StatusPapeleta"));
		}
		if (!$this->FechaAviso->FldIsDetailKey) {
			$this->FechaAviso->setFormValue($objForm->GetValue("x_FechaAviso"));
			$this->FechaAviso->CurrentValue = ew_UnFormatDateTime($this->FechaAviso->CurrentValue, 7);
		}
		if (!$this->Tipo_Papeleta->FldIsDetailKey) {
			$this->Tipo_Papeleta->setFormValue($objForm->GetValue("x_Tipo_Papeleta"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Num_CEL->FldIsDetailKey) {
			$this->Num_CEL->setFormValue($objForm->GetValue("x_Num_CEL"));
		}
		if (!$this->FolioImpresoPapeleta->FldIsDetailKey) {
			$this->FolioImpresoPapeleta->setFormValue($objForm->GetValue("x_FolioImpresoPapeleta"));
		}
		if (!$this->Id_Venta_Eq->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Venta_Eq->setFormValue($objForm->GetValue("x_Id_Venta_Eq"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Venta_Eq->CurrentValue = $this->Id_Venta_Eq->FormValue;
		$this->StatusPapeleta->CurrentValue = $this->StatusPapeleta->FormValue;
		$this->FechaAviso->CurrentValue = $this->FechaAviso->FormValue;
		$this->FechaAviso->CurrentValue = ew_UnFormatDateTime($this->FechaAviso->CurrentValue, 7);
		$this->Tipo_Papeleta->CurrentValue = $this->Tipo_Papeleta->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_CEL->CurrentValue = $this->Num_CEL->FormValue;
		$this->FolioImpresoPapeleta->CurrentValue = $this->FolioImpresoPapeleta->FormValue;
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
		$this->StatusPapeleta->setDbValue($rs->fields('StatusPapeleta'));
		$this->FechaAviso->setDbValue($rs->fields('FechaAviso'));
		$this->Tipo_Papeleta->setDbValue($rs->fields('Tipo Papeleta'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
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
		// StatusPapeleta
		// FechaAviso
		// Tipo Papeleta
		// Num_IMEI
		// Num_CEL
		// FolioImpresoPapeleta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// StatusPapeleta
			if (strval($this->StatusPapeleta->CurrentValue) <> "") {
				switch ($this->StatusPapeleta->CurrentValue) {
					case $this->StatusPapeleta->FldTagValue(1):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(2):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(3):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(4):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->CurrentValue;
						break;
					default:
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->CurrentValue;
				}
			} else {
				$this->StatusPapeleta->ViewValue = NULL;
			}
			$this->StatusPapeleta->ViewCustomAttributes = "";

			// FechaAviso
			$this->FechaAviso->ViewValue = $this->FechaAviso->CurrentValue;
			$this->FechaAviso->ViewValue = ew_FormatDateTime($this->FechaAviso->ViewValue, 7);
			$this->FechaAviso->ViewCustomAttributes = "";

			// Tipo Papeleta
			if (strval($this->Tipo_Papeleta->CurrentValue) <> "") {
				switch ($this->Tipo_Papeleta->CurrentValue) {
					case $this->Tipo_Papeleta->FldTagValue(1):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->CurrentValue;
						break;
					case $this->Tipo_Papeleta->FldTagValue(2):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->CurrentValue;
						break;
					case $this->Tipo_Papeleta->FldTagValue(3):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->CurrentValue;
						break;
					default:
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->CurrentValue;
				}
			} else {
				$this->Tipo_Papeleta->ViewValue = NULL;
			}
			$this->Tipo_Papeleta->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
			$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

			// StatusPapeleta
			$this->StatusPapeleta->LinkCustomAttributes = "";
			$this->StatusPapeleta->HrefValue = "";
			$this->StatusPapeleta->TooltipValue = "";

			// FechaAviso
			$this->FechaAviso->LinkCustomAttributes = "";
			$this->FechaAviso->HrefValue = "";
			$this->FechaAviso->TooltipValue = "";

			// Tipo Papeleta
			$this->Tipo_Papeleta->LinkCustomAttributes = "";
			$this->Tipo_Papeleta->HrefValue = "";
			$this->Tipo_Papeleta->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Num_CEL
			$this->Num_CEL->LinkCustomAttributes = "";
			$this->Num_CEL->HrefValue = "";
			$this->Num_CEL->TooltipValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->LinkCustomAttributes = "";
			$this->FolioImpresoPapeleta->HrefValue = "";
			$this->FolioImpresoPapeleta->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// StatusPapeleta
			$this->StatusPapeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(1), $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->FldTagValue(1));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(2), $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->FldTagValue(2));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(3), $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->FldTagValue(3));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(4), $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->FldTagValue(4));
			$this->StatusPapeleta->EditValue = $arwrk;

			// FechaAviso
			// Tipo Papeleta

			$this->Tipo_Papeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(1), $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(2), $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(3), $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->FldTagValue(3));
			$this->Tipo_Papeleta->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->CurrentValue);

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->EditCustomAttributes = "";
			$this->FolioImpresoPapeleta->EditValue = ew_HtmlEncode($this->FolioImpresoPapeleta->CurrentValue);

			// Edit refer script
			// StatusPapeleta

			$this->StatusPapeleta->HrefValue = "";

			// FechaAviso
			$this->FechaAviso->HrefValue = "";

			// Tipo Papeleta
			$this->Tipo_Papeleta->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// StatusPapeleta
			$this->StatusPapeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(1), $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->FldTagValue(1));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(2), $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->FldTagValue(2));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(3), $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->FldTagValue(3));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(4), $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->FldTagValue(4));
			$this->StatusPapeleta->EditValue = $arwrk;

			// FechaAviso
			// Tipo Papeleta

			$this->Tipo_Papeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(1), $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(2), $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(3), $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->FldTagValue(3));
			$this->Tipo_Papeleta->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->CurrentValue);

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->EditCustomAttributes = "";
			$this->FolioImpresoPapeleta->EditValue = ew_HtmlEncode($this->FolioImpresoPapeleta->CurrentValue);

			// Edit refer script
			// StatusPapeleta

			$this->StatusPapeleta->HrefValue = "";

			// FechaAviso
			$this->FechaAviso->HrefValue = "";

			// Tipo Papeleta
			$this->Tipo_Papeleta->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// StatusPapeleta
			$this->StatusPapeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(1), $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->FldTagValue(1));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(2), $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->FldTagValue(2));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(3), $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->FldTagValue(3));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(4), $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->FldTagValue(4));
			$this->StatusPapeleta->EditValue = $arwrk;

			// FechaAviso
			$this->FechaAviso->EditCustomAttributes = "";
			$this->FechaAviso->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaAviso->AdvancedSearch->SearchValue, 7), 7));
			$this->FechaAviso->EditCustomAttributes = "";
			$this->FechaAviso->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaAviso->AdvancedSearch->SearchValue2, 7), 7));

			// Tipo Papeleta
			$this->Tipo_Papeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(1), $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(2), $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Papeleta->FldTagValue(3), $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->FldTagValue(3));
			$this->Tipo_Papeleta->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "onchange= 'ValidaCEL(this);' ";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->AdvancedSearch->SearchValue);

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->EditCustomAttributes = "";
			$this->FolioImpresoPapeleta->EditValue = ew_HtmlEncode($this->FolioImpresoPapeleta->AdvancedSearch->SearchValue);
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
		if (!ew_CheckEuroDate($this->FechaAviso->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->FechaAviso->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->FechaAviso->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->FechaAviso->FldErrMsg());
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
				$sThisKey .= $row['Id_Venta_Eq'];
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

			// StatusPapeleta
			$this->StatusPapeleta->SetDbValueDef($rsnew, $this->StatusPapeleta->CurrentValue, NULL, $this->StatusPapeleta->ReadOnly);

			// FechaAviso
			$this->FechaAviso->SetDbValueDef($rsnew, ew_CurrentDate(), ew_CurrentDate());
			$rsnew['FechaAviso'] = &$this->FechaAviso->DbValue;

			// Tipo Papeleta
			$this->Tipo_Papeleta->SetDbValueDef($rsnew, $this->Tipo_Papeleta->CurrentValue, NULL, $this->Tipo_Papeleta->ReadOnly);

			// Num_CEL
			$this->Num_CEL->SetDbValueDef($rsnew, $this->Num_CEL->CurrentValue, NULL, $this->Num_CEL->ReadOnly);

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->SetDbValueDef($rsnew, $this->FolioImpresoPapeleta->CurrentValue, NULL, $this->FolioImpresoPapeleta->ReadOnly);

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
		$rsnew = array();

		// StatusPapeleta
		$this->StatusPapeleta->SetDbValueDef($rsnew, $this->StatusPapeleta->CurrentValue, NULL, strval($this->StatusPapeleta->CurrentValue) == "");

		// FechaAviso
		$this->FechaAviso->SetDbValueDef($rsnew, ew_CurrentDate(), ew_CurrentDate());
		$rsnew['FechaAviso'] = &$this->FechaAviso->DbValue;

		// Tipo Papeleta
		$this->Tipo_Papeleta->SetDbValueDef($rsnew, $this->Tipo_Papeleta->CurrentValue, NULL, strval($this->Tipo_Papeleta->CurrentValue) == "");

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, "", FALSE);

		// Num_CEL
		$this->Num_CEL->SetDbValueDef($rsnew, $this->Num_CEL->CurrentValue, NULL, FALSE);

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->SetDbValueDef($rsnew, $this->FolioImpresoPapeleta->CurrentValue, NULL, FALSE);

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
		$this->StatusPapeleta->AdvancedSearch->Load();
		$this->FechaAviso->AdvancedSearch->Load();
		$this->Tipo_Papeleta->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->FolioImpresoPapeleta->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_control_papeleta\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_control_papeleta',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_control_papeletalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_control_papeleta_list)) $cap_control_papeleta_list = new ccap_control_papeleta_list();

// Page init
$cap_control_papeleta_list->Page_Init();

// Page main
$cap_control_papeleta_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_control_papeleta->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_control_papeleta_list = new ew_Page("cap_control_papeleta_list");
cap_control_papeleta_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_control_papeleta_list.PageID; // For backward compatibility

// Form object
var fcap_control_papeletalist = new ew_Form("fcap_control_papeletalist");

// Validate form
fcap_control_papeletalist.Validate = function(fobj) {
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
fcap_control_papeletalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_control_papeletalist.ValidateRequired = true;
<?php } else { ?>
fcap_control_papeletalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fcap_control_papeletalistsrch = new ew_Form("fcap_control_papeletalistsrch");

// Validate function for search
fcap_control_papeletalistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = fobj.elements["x" + infix + "_FechaAviso"];
	if (elm && !ew_CheckEuroDate(elm.value))
		return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_control_papeleta->FechaAviso->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj, infix);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fcap_control_papeletalistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_control_papeletalistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_control_papeletalistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
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
		$cap_control_papeleta_list->TotalRecs = $cap_control_papeleta->SelectRecordCount();
	} else {
		if ($cap_control_papeleta_list->Recordset = $cap_control_papeleta_list->LoadRecordset())
			$cap_control_papeleta_list->TotalRecs = $cap_control_papeleta_list->Recordset->RecordCount();
	}
	$cap_control_papeleta_list->StartRec = 1;
	if ($cap_control_papeleta_list->DisplayRecs <= 0 || ($cap_control_papeleta->Export <> "" && $cap_control_papeleta->ExportAll)) // Display all records
		$cap_control_papeleta_list->DisplayRecs = $cap_control_papeleta_list->TotalRecs;
	if (!($cap_control_papeleta->Export <> "" && $cap_control_papeleta->ExportAll))
		$cap_control_papeleta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_control_papeleta_list->Recordset = $cap_control_papeleta_list->LoadRecordset($cap_control_papeleta_list->StartRec-1, $cap_control_papeleta_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_control_papeleta->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_control_papeleta_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_control_papeleta->Export == "" && $cap_control_papeleta->CurrentAction == "") { ?>
<form name="fcap_control_papeletalistsrch" id="fcap_control_papeletalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_control_papeletalistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_control_papeletalistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_control_papeletalistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_control_papeleta">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_control_papeleta_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_control_papeleta->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_control_papeleta->ResetAttrs();
$cap_control_papeleta_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_control_papeleta->StatusPapeleta->Visible) { // StatusPapeleta ?>
	<span id="xsc_StatusPapeleta" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_control_papeleta->StatusPapeleta->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_StatusPapeleta" id="z_StatusPapeleta" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_StatusPapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_StatusPapeleta" id="x_StatusPapeleta" value="{value}"<?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>></div>
<div id="dsl_x_StatusPapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->StatusPapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->StatusPapeleta->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_StatusPapeleta" id="x_StatusPapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
<div id="xsr_2" class="ewRow">
<?php if ($cap_control_papeleta->FechaAviso->Visible) { // FechaAviso ?>
	<span id="xsc_FechaAviso" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_control_papeleta->FechaAviso->FldCaption() ?></span>
		<span class="ewSearchOperator"><select name="z_FechaAviso" id="z_FechaAviso" onchange="ewForms['fcap_control_papeletalistsrch'].SrchOprChanged(this);"><option value="="<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator=="=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("=") ?></option><option value="<>"<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator=="<>") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator=="<") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator=="<=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator==">") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator==">=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($cap_control_papeleta->FechaAviso->AdvancedSearch->SearchOperator=="BETWEEN") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
		<span class="ewSearchField">
<input type="text" name="x_FechaAviso" id="x_FechaAviso" value="<?php echo $cap_control_papeleta->FechaAviso->EditValue ?>"<?php echo $cap_control_papeleta->FechaAviso->EditAttributes() ?>>
</span>
		<span class="ewSearchCond btw1_FechaAviso" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
		<span class="ewSearchField btw1_FechaAviso" style="display: none">
<input type="text" name="y_FechaAviso" id="y_FechaAviso" value="<?php echo $cap_control_papeleta->FechaAviso->EditValue2 ?>"<?php echo $cap_control_papeleta->FechaAviso->EditAttributes() ?>>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_control_papeleta->Tipo_Papeleta->Visible) { // Tipo Papeleta ?>
	<span id="xsc_Tipo_Papeleta" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_control_papeleta->Tipo_Papeleta->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Tipo_Papeleta" id="z_Tipo_Papeleta" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Tipo_Papeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Tipo_Papeleta" id="x_Tipo_Papeleta" value="{value}"<?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>></div>
<div id="dsl_x_Tipo_Papeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->Tipo_Papeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->Tipo_Papeleta->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Tipo_Papeleta" id="x_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
<div id="xsr_4" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_control_papeleta_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_5" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_control_papeleta_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_control_papeleta_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_control_papeleta_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_control_papeleta_list->ShowPageHeader(); ?>
<?php
$cap_control_papeleta_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_control_papeleta->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_control_papeleta->CurrentAction <> "gridadd" && $cap_control_papeleta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_control_papeleta_list->Pager)) $cap_control_papeleta_list->Pager = new cPrevNextPager($cap_control_papeleta_list->StartRec, $cap_control_papeleta_list->DisplayRecs, $cap_control_papeleta_list->TotalRecs) ?>
<?php if ($cap_control_papeleta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_control_papeleta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_control_papeleta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_control_papeleta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_control_papeleta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_control_papeleta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_control_papeleta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_control_papeleta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_control_papeleta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_control_papeleta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_control_papeleta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_control_papeleta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_control_papeleta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_control_papeleta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_control_papeleta->CurrentAction <> "gridadd" && $cap_control_papeleta->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_control_papeleta_list->TotalRecs > 0 && $cap_control_papeleta_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_control_papeleta_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_control_papeleta->CurrentAction == "gridedit") { ?>
<?php if ($cap_control_papeleta->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_control_papeletalist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_control_papeleta_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_control_papeletalist" id="fcap_control_papeletalist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_control_papeleta">
<div id="gmp_cap_control_papeleta" class="ewGridMiddlePanel">
<?php if ($cap_control_papeleta_list->TotalRecs > 0) { ?>
<table id="tbl_cap_control_papeletalist" class="ewTable ewTableSeparate">
<?php echo $cap_control_papeleta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_control_papeleta_list->RenderListOptions();

// Render list options (header, left)
$cap_control_papeleta_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_control_papeleta->StatusPapeleta->Visible) { // StatusPapeleta ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->StatusPapeleta) == "") { ?>
		<td><span id="elh_cap_control_papeleta_StatusPapeleta" class="cap_control_papeleta_StatusPapeleta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->StatusPapeleta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->StatusPapeleta) ?>',1);"><span id="elh_cap_control_papeleta_StatusPapeleta" class="cap_control_papeleta_StatusPapeleta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->StatusPapeleta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->StatusPapeleta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->StatusPapeleta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_control_papeleta->FechaAviso->Visible) { // FechaAviso ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->FechaAviso) == "") { ?>
		<td><span id="elh_cap_control_papeleta_FechaAviso" class="cap_control_papeleta_FechaAviso"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->FechaAviso->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->FechaAviso) ?>',1);"><span id="elh_cap_control_papeleta_FechaAviso" class="cap_control_papeleta_FechaAviso">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->FechaAviso->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->FechaAviso->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->FechaAviso->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_control_papeleta->Tipo_Papeleta->Visible) { // Tipo Papeleta ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->Tipo_Papeleta) == "") { ?>
		<td><span id="elh_cap_control_papeleta_Tipo_Papeleta" class="cap_control_papeleta_Tipo_Papeleta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->Tipo_Papeleta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->Tipo_Papeleta) ?>',1);"><span id="elh_cap_control_papeleta_Tipo_Papeleta" class="cap_control_papeleta_Tipo_Papeleta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->Tipo_Papeleta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->Tipo_Papeleta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->Tipo_Papeleta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_control_papeleta->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_control_papeleta_Num_IMEI" class="cap_control_papeleta_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->Num_IMEI) ?>',1);"><span id="elh_cap_control_papeleta_Num_IMEI" class="cap_control_papeleta_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_control_papeleta->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->Num_CEL) == "") { ?>
		<td><span id="elh_cap_control_papeleta_Num_CEL" class="cap_control_papeleta_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->Num_CEL) ?>',1);"><span id="elh_cap_control_papeleta_Num_CEL" class="cap_control_papeleta_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->Num_CEL->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_control_papeleta->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
	<?php if ($cap_control_papeleta->SortUrl($cap_control_papeleta->FolioImpresoPapeleta) == "") { ?>
		<td><span id="elh_cap_control_papeleta_FolioImpresoPapeleta" class="cap_control_papeleta_FolioImpresoPapeleta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_control_papeleta->FolioImpresoPapeleta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_control_papeleta->SortUrl($cap_control_papeleta->FolioImpresoPapeleta) ?>',1);"><span id="elh_cap_control_papeleta_FolioImpresoPapeleta" class="cap_control_papeleta_FolioImpresoPapeleta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_control_papeleta->FolioImpresoPapeleta->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_control_papeleta->FolioImpresoPapeleta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_control_papeleta->FolioImpresoPapeleta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_control_papeleta_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_control_papeleta->ExportAll && $cap_control_papeleta->Export <> "") {
	$cap_control_papeleta_list->StopRec = $cap_control_papeleta_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_control_papeleta_list->TotalRecs > $cap_control_papeleta_list->StartRec + $cap_control_papeleta_list->DisplayRecs - 1)
		$cap_control_papeleta_list->StopRec = $cap_control_papeleta_list->StartRec + $cap_control_papeleta_list->DisplayRecs - 1;
	else
		$cap_control_papeleta_list->StopRec = $cap_control_papeleta_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_control_papeleta->CurrentAction == "gridadd" || $cap_control_papeleta->CurrentAction == "gridedit" || $cap_control_papeleta->CurrentAction == "F")) {
		$cap_control_papeleta_list->KeyCount = $objForm->GetValue("key_count");
		$cap_control_papeleta_list->StopRec = $cap_control_papeleta_list->KeyCount;
	}
}
$cap_control_papeleta_list->RecCnt = $cap_control_papeleta_list->StartRec - 1;
if ($cap_control_papeleta_list->Recordset && !$cap_control_papeleta_list->Recordset->EOF) {
	$cap_control_papeleta_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_control_papeleta_list->StartRec > 1)
		$cap_control_papeleta_list->Recordset->Move($cap_control_papeleta_list->StartRec - 1);
} elseif (!$cap_control_papeleta->AllowAddDeleteRow && $cap_control_papeleta_list->StopRec == 0) {
	$cap_control_papeleta_list->StopRec = $cap_control_papeleta->GridAddRowCount;
}

// Initialize aggregate
$cap_control_papeleta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_control_papeleta->ResetAttrs();
$cap_control_papeleta_list->RenderRow();
if ($cap_control_papeleta->CurrentAction == "gridedit")
	$cap_control_papeleta_list->RowIndex = 0;
while ($cap_control_papeleta_list->RecCnt < $cap_control_papeleta_list->StopRec) {
	$cap_control_papeleta_list->RecCnt++;
	if (intval($cap_control_papeleta_list->RecCnt) >= intval($cap_control_papeleta_list->StartRec)) {
		$cap_control_papeleta_list->RowCnt++;
		if ($cap_control_papeleta->CurrentAction == "gridadd" || $cap_control_papeleta->CurrentAction == "gridedit" || $cap_control_papeleta->CurrentAction == "F") {
			$cap_control_papeleta_list->RowIndex++;
			$objForm->Index = $cap_control_papeleta_list->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_control_papeleta_list->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_control_papeleta->CurrentAction == "gridadd")
				$cap_control_papeleta_list->RowAction = "insert";
			else
				$cap_control_papeleta_list->RowAction = "";
		}

		// Set up key count
		$cap_control_papeleta_list->KeyCount = $cap_control_papeleta_list->RowIndex;

		// Init row class and style
		$cap_control_papeleta->ResetAttrs();
		$cap_control_papeleta->CssClass = "";
		if ($cap_control_papeleta->CurrentAction == "gridadd") {
			$cap_control_papeleta_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_control_papeleta_list->LoadRowValues($cap_control_papeleta_list->Recordset); // Load row values
		}
		$cap_control_papeleta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_control_papeleta->CurrentAction == "gridedit") { // Grid edit
			if ($cap_control_papeleta->EventCancelled) {
				$cap_control_papeleta_list->RestoreCurrentRowFormValues($cap_control_papeleta_list->RowIndex); // Restore form values
			}
			if ($cap_control_papeleta_list->RowAction == "insert")
				$cap_control_papeleta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_control_papeleta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_control_papeleta->CurrentAction == "gridedit" && ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT || $cap_control_papeleta->RowType == EW_ROWTYPE_ADD) && $cap_control_papeleta->EventCancelled) // Update failed
			$cap_control_papeleta_list->RestoreCurrentRowFormValues($cap_control_papeleta_list->RowIndex); // Restore form values
		if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_control_papeleta_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_control_papeleta->RowAttrs = array_merge($cap_control_papeleta->RowAttrs, array('data-rowindex'=>$cap_control_papeleta_list->RowCnt, 'id'=>'r' . $cap_control_papeleta_list->RowCnt . '_cap_control_papeleta', 'data-rowtype'=>$cap_control_papeleta->RowType));

		// Render row
		$cap_control_papeleta_list->RenderRow();

		// Render list options
		$cap_control_papeleta_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_control_papeleta_list->RowAction <> "delete" && $cap_control_papeleta_list->RowAction <> "insertdelete" && !($cap_control_papeleta_list->RowAction == "insert" && $cap_control_papeleta->CurrentAction == "F" && $cap_control_papeleta_list->EmptyRow())) {
?>
	<tr<?php echo $cap_control_papeleta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_control_papeleta_list->ListOptions->Render("body", "left", $cap_control_papeleta_list->RowCnt);
?>
	<?php if ($cap_control_papeleta->StatusPapeleta->Visible) { // StatusPapeleta ?>
		<td<?php echo $cap_control_papeleta->StatusPapeleta->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_StatusPapeleta" class="cap_control_papeleta_StatusPapeleta">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="{value}"<?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->StatusPapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->StatusPapeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->StatusPapeleta->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="{value}"<?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->StatusPapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->StatusPapeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->StatusPapeleta->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->StatusPapeleta->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Id_Venta_Eq->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Id_Venta_Eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT || $cap_control_papeleta->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Id_Venta_Eq->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_control_papeleta->FechaAviso->Visible) { // FechaAviso ?>
		<td<?php echo $cap_control_papeleta->FechaAviso->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_FechaAviso" class="cap_control_papeleta_FechaAviso">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FechaAviso" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FechaAviso" value="<?php echo ew_HtmlEncode($cap_control_papeleta->FechaAviso->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->FechaAviso->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->FechaAviso->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Tipo_Papeleta->Visible) { // Tipo Papeleta ?>
		<td<?php echo $cap_control_papeleta->Tipo_Papeleta->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_Tipo_Papeleta" class="cap_control_papeleta_Tipo_Papeleta">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="{value}"<?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->Tipo_Papeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->Tipo_Papeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Tipo_Papeleta->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="{value}"<?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->Tipo_Papeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->Tipo_Papeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->Tipo_Papeleta->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->Tipo_Papeleta->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_control_papeleta->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_Num_IMEI" class="cap_control_papeleta_Num_IMEI">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" size="30" maxlength="16" value="<?php echo $cap_control_papeleta->Num_IMEI->EditValue ?>"<?php echo $cap_control_papeleta->Num_IMEI->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Num_IMEI->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_control_papeleta->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->Num_IMEI->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Num_IMEI->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->Num_IMEI->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_control_papeleta->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_Num_CEL" class="cap_control_papeleta_Num_CEL">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" size="12" maxlength="10" value="<?php echo $cap_control_papeleta->Num_CEL->EditValue ?>"<?php echo $cap_control_papeleta->Num_CEL->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Num_CEL->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" size="12" maxlength="10" value="<?php echo $cap_control_papeleta->Num_CEL->EditValue ?>"<?php echo $cap_control_papeleta->Num_CEL->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->Num_CEL->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
		<td<?php echo $cap_control_papeleta->FolioImpresoPapeleta->CellAttributes() ?>><span id="el<?php echo $cap_control_papeleta_list->RowCnt ?>_cap_control_papeleta_FolioImpresoPapeleta" class="cap_control_papeleta_FolioImpresoPapeleta">
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" size="30" maxlength="10" value="<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditValue ?>"<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->FolioImpresoPapeleta->OldValue) ?>">
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" size="30" maxlength="10" value="<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditValue ?>"<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_control_papeleta->FolioImpresoPapeleta->ViewAttributes() ?>>
<?php echo $cap_control_papeleta->FolioImpresoPapeleta->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_control_papeleta_list->PageObjName . "_row_" . $cap_control_papeleta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_control_papeleta_list->ListOptions->Render("body", "right", $cap_control_papeleta_list->RowCnt);
?>
	</tr>
<?php if ($cap_control_papeleta->RowType == EW_ROWTYPE_ADD || $cap_control_papeleta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_control_papeletalist.UpdateOpts(<?php echo $cap_control_papeleta_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_control_papeleta->CurrentAction <> "gridadd")
		if (!$cap_control_papeleta_list->Recordset->EOF) $cap_control_papeleta_list->Recordset->MoveNext();
}
?>
<?php
	if ($cap_control_papeleta->CurrentAction == "gridadd" || $cap_control_papeleta->CurrentAction == "gridedit") {
		$cap_control_papeleta_list->RowIndex = '$rowindex$';
		$cap_control_papeleta_list->LoadDefaultValues();

		// Set row properties
		$cap_control_papeleta->ResetAttrs();
		$cap_control_papeleta->RowAttrs = array_merge($cap_control_papeleta->RowAttrs, array('data-rowindex'=>$cap_control_papeleta_list->RowIndex, 'id'=>'r0_cap_control_papeleta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_control_papeleta->RowAttrs["class"], "ewTemplate");
		$cap_control_papeleta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_control_papeleta_list->RenderRow();

		// Render list options
		$cap_control_papeleta_list->RenderListOptions();
		$cap_control_papeleta_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_control_papeleta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_control_papeleta_list->ListOptions->Render("body", "left", $cap_control_papeleta_list->RowIndex);
?>
	<?php if ($cap_control_papeleta->StatusPapeleta->Visible) { // StatusPapeleta ?>
		<td><span id="el$rowindex$_cap_control_papeleta_StatusPapeleta" class="cap_control_papeleta_StatusPapeleta">
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="{value}"<?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->StatusPapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->StatusPapeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->StatusPapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_StatusPapeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->StatusPapeleta->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->FechaAviso->Visible) { // FechaAviso ?>
		<td><span id="el$rowindex$_cap_control_papeleta_FechaAviso" class="cap_control_papeleta_FechaAviso">
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FechaAviso" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FechaAviso" value="<?php echo ew_HtmlEncode($cap_control_papeleta->FechaAviso->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Tipo_Papeleta->Visible) { // Tipo Papeleta ?>
		<td><span id="el$rowindex$_cap_control_papeleta_Tipo_Papeleta" class="cap_control_papeleta_Tipo_Papeleta">
<div id="tp_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="{value}"<?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta->Tipo_Papeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta->Tipo_Papeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta->Tipo_Papeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Tipo_Papeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Tipo_Papeleta->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Num_IMEI->Visible) { // Num_IMEI ?>
		<td><span id="el$rowindex$_cap_control_papeleta_Num_IMEI" class="cap_control_papeleta_Num_IMEI">
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" size="30" maxlength="16" value="<?php echo $cap_control_papeleta->Num_IMEI->EditValue ?>"<?php echo $cap_control_papeleta->Num_IMEI->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Num_IMEI->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->Num_CEL->Visible) { // Num_CEL ?>
		<td><span id="el$rowindex$_cap_control_papeleta_Num_CEL" class="cap_control_papeleta_Num_CEL">
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" size="12" maxlength="10" value="<?php echo $cap_control_papeleta->Num_CEL->EditValue ?>"<?php echo $cap_control_papeleta->Num_CEL->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_control_papeleta->Num_CEL->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_control_papeleta->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
		<td><span id="el$rowindex$_cap_control_papeleta_FolioImpresoPapeleta" class="cap_control_papeleta_FolioImpresoPapeleta">
<input type="text" name="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" id="x<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" size="30" maxlength="10" value="<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditValue ?>"<?php echo $cap_control_papeleta->FolioImpresoPapeleta->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" id="o<?php echo $cap_control_papeleta_list->RowIndex ?>_FolioImpresoPapeleta" value="<?php echo ew_HtmlEncode($cap_control_papeleta->FolioImpresoPapeleta->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_control_papeleta_list->ListOptions->Render("body", "right", $cap_control_papeleta_list->RowCnt);
?>
<script type="text/javascript">
fcap_control_papeletalist.UpdateOpts(<?php echo $cap_control_papeleta_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_control_papeleta->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_control_papeleta_list->KeyCount ?>">
<?php echo $cap_control_papeleta_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_control_papeleta->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_control_papeleta_list->Recordset)
	$cap_control_papeleta_list->Recordset->Close();
?>
<?php if ($cap_control_papeleta_list->TotalRecs > 0) { ?>
<?php if ($cap_control_papeleta->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_control_papeleta->CurrentAction <> "gridadd" && $cap_control_papeleta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_control_papeleta_list->Pager)) $cap_control_papeleta_list->Pager = new cPrevNextPager($cap_control_papeleta_list->StartRec, $cap_control_papeleta_list->DisplayRecs, $cap_control_papeleta_list->TotalRecs) ?>
<?php if ($cap_control_papeleta_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_control_papeleta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_control_papeleta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_control_papeleta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_control_papeleta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_control_papeleta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_control_papeleta_list->PageUrl() ?>start=<?php echo $cap_control_papeleta_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_control_papeleta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_control_papeleta_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_control_papeleta_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_control_papeleta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_control_papeleta_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_control_papeleta_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_control_papeleta_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_control_papeleta_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_control_papeleta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_control_papeleta->CurrentAction <> "gridadd" && $cap_control_papeleta->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_control_papeleta_list->TotalRecs > 0 && $cap_control_papeleta_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_control_papeleta_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_control_papeleta->CurrentAction == "gridedit") { ?>
<?php if ($cap_control_papeleta->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_control_papeletalist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_control_papeleta_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_control_papeleta->Export == "") { ?>
<script type="text/javascript">
fcap_control_papeletalistsrch.Init();
fcap_control_papeletalist.Init();
</script>
<?php } ?>
<?php
$cap_control_papeleta_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_control_papeleta->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_control_papeleta_list->Page_Terminate();
?>
