<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_inventario_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_inventario_accesorios_list = NULL; // Initialize page object first

class ccap_inventario_accesorios_list extends ccap_inventario_accesorios {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_inventario_accesorios';

	// Page object name
	var $PageObjName = 'cap_inventario_accesorios_list';

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

		// Table object (cap_inventario_accesorios)
		if (!isset($GLOBALS["cap_inventario_accesorios"])) {
			$GLOBALS["cap_inventario_accesorios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_inventario_accesorios"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_inventario_accesoriosadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_inventario_accesoriosdelete.php";
		$this->MultiUpdateUrl = "cap_inventario_accesoriosupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_inventario_accesorios', TRUE);

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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
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
		if ($sFilter == "") {
			$sFilter = "0=101";
			$this->SearchWhere = $sFilter;
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
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
		$this->setKey("Id_Almacen", ""); // Clear inline edit key
		$this->setKey("Id_Articulo", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["Id_Almacen"] <> "") {
			$this->Id_Almacen->setQueryStringValue($_GET["Id_Almacen"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (@$_GET["Id_Articulo"] <> "") {
			$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Almacen", $this->Id_Almacen->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Id_Almacen")) <> strval($this->Id_Almacen->CurrentValue))
			return FALSE;
		if (strval($this->getKey("Id_Articulo")) <> strval($this->Id_Articulo->CurrentValue))
			return FALSE;
		return TRUE;
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
		if (count($arrKeyFlds) >= 2) {
			$this->Id_Almacen->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Almacen->FormValue))
				return FALSE;
			$this->Id_Articulo->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->Id_Articulo->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Id_Almacen") && $objForm->HasValue("o_Id_Almacen") && $this->Id_Almacen->CurrentValue <> $this->Id_Almacen->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_COD_Fam_Accesorio") && $objForm->HasValue("o_COD_Fam_Accesorio") && $this->COD_Fam_Accesorio->CurrentValue <> $this->COD_Fam_Accesorio->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_COD_Marca_acc") && $objForm->HasValue("o_COD_Marca_acc") && $this->COD_Marca_acc->CurrentValue <> $this->COD_Marca_acc->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Articulo") && $objForm->HasValue("o_Id_Articulo") && $this->Id_Articulo->CurrentValue <> $this->Id_Articulo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Codigo") && $objForm->HasValue("o_Codigo") && $this->Codigo->CurrentValue <> $this->Codigo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_MustBe") && $objForm->HasValue("o_Cantidad_MustBe") && $this->Cantidad_MustBe->CurrentValue <> $this->Cantidad_MustBe->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Actual") && $objForm->HasValue("o_Cantidad_Actual") && $this->Cantidad_Actual->CurrentValue <> $this->Cantidad_Actual->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Minima") && $objForm->HasValue("o_Cantidad_Minima") && $this->Cantidad_Minima->CurrentValue <> $this->Cantidad_Minima->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Maxima") && $objForm->HasValue("o_Cantidad_Maxima") && $this->Cantidad_Maxima->CurrentValue <> $this->Cantidad_Maxima->OldValue)
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
		$this->BuildSearchSql($sWhere, $this->Id_Almacen, FALSE); // Id_Almacen
		$this->BuildSearchSql($sWhere, $this->COD_Fam_Accesorio, FALSE); // COD_Fam_Accesorio
		$this->BuildSearchSql($sWhere, $this->COD_Marca_acc, FALSE); // COD_Marca_acc
		$this->BuildSearchSql($sWhere, $this->Id_Articulo, FALSE); // Id_Articulo
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo
		$this->BuildSearchSql($sWhere, $this->Cantidad_MustBe, FALSE); // Cantidad_MustBe
		$this->BuildSearchSql($sWhere, $this->Cantidad_Actual, FALSE); // Cantidad_Actual
		$this->BuildSearchSql($sWhere, $this->Cantidad_Minima, FALSE); // Cantidad_Minima
		$this->BuildSearchSql($sWhere, $this->Cantidad_Maxima, FALSE); // Cantidad_Maxima

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Almacen->AdvancedSearch->Save(); // Id_Almacen
			$this->COD_Fam_Accesorio->AdvancedSearch->Save(); // COD_Fam_Accesorio
			$this->COD_Marca_acc->AdvancedSearch->Save(); // COD_Marca_acc
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->Codigo->AdvancedSearch->Save(); // Codigo
			$this->Cantidad_MustBe->AdvancedSearch->Save(); // Cantidad_MustBe
			$this->Cantidad_Actual->AdvancedSearch->Save(); // Cantidad_Actual
			$this->Cantidad_Minima->AdvancedSearch->Save(); // Cantidad_Minima
			$this->Cantidad_Maxima->AdvancedSearch->Save(); // Cantidad_Maxima
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
		$this->BuildBasicSearchSQL($sWhere, $this->Codigo, $Keyword);
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
		if ($this->Id_Almacen->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Fam_Accesorio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Marca_acc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_MustBe->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Actual->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Minima->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Maxima->AdvancedSearch->IssetSession())
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
		$this->Id_Almacen->AdvancedSearch->UnsetSession();
		$this->COD_Fam_Accesorio->AdvancedSearch->UnsetSession();
		$this->COD_Marca_acc->AdvancedSearch->UnsetSession();
		$this->Id_Articulo->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
		$this->Cantidad_MustBe->AdvancedSearch->UnsetSession();
		$this->Cantidad_Actual->AdvancedSearch->UnsetSession();
		$this->Cantidad_Minima->AdvancedSearch->UnsetSession();
		$this->Cantidad_Maxima->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->COD_Fam_Accesorio->AdvancedSearch->Load();
		$this->COD_Marca_acc->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Cantidad_MustBe->AdvancedSearch->Load();
		$this->Cantidad_Actual->AdvancedSearch->Load();
		$this->Cantidad_Minima->AdvancedSearch->Load();
		$this->Cantidad_Maxima->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Almacen); // Id_Almacen
			$this->UpdateSort($this->COD_Fam_Accesorio); // COD_Fam_Accesorio
			$this->UpdateSort($this->COD_Marca_acc); // COD_Marca_acc
			$this->UpdateSort($this->Id_Articulo); // Id_Articulo
			$this->UpdateSort($this->Codigo); // Codigo
			$this->UpdateSort($this->Cantidad_MustBe); // Cantidad_MustBe
			$this->UpdateSort($this->Cantidad_Actual); // Cantidad_Actual
			$this->UpdateSort($this->Cantidad_Minima); // Cantidad_Minima
			$this->UpdateSort($this->Cantidad_Maxima); // Cantidad_Maxima
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
				$this->COD_Fam_Accesorio->setSort("ASC");
				$this->COD_Marca_acc->setSort("ASC");
				$this->Codigo->setSort("ASC");
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
				$this->Id_Almacen->setSort("");
				$this->COD_Fam_Accesorio->setSort("");
				$this->COD_Marca_acc->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->Cantidad_MustBe->setSort("");
				$this->Cantidad_Actual->setSort("");
				$this->Cantidad_Minima->setSort("");
				$this->Cantidad_Maxima->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->CssStyle = "white-space: nowrap; text-align: center; vertical-align: middle; margin: 0px;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);

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

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_inventario_accesorioslist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Almacen->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Id_Articulo->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		if ($Security->CanEdit())
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Almacen->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Id_Articulo->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $this->Id_Almacen->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Id_Articulo->CurrentValue . "\">";
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
		$this->Id_Almacen->CurrentValue = 0;
		$this->Id_Almacen->OldValue = $this->Id_Almacen->CurrentValue;
		$this->COD_Fam_Accesorio->CurrentValue = NULL;
		$this->COD_Fam_Accesorio->OldValue = $this->COD_Fam_Accesorio->CurrentValue;
		$this->COD_Marca_acc->CurrentValue = NULL;
		$this->COD_Marca_acc->OldValue = $this->COD_Marca_acc->CurrentValue;
		$this->Id_Articulo->CurrentValue = 0;
		$this->Id_Articulo->OldValue = $this->Id_Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Cantidad_MustBe->CurrentValue = 0;
		$this->Cantidad_MustBe->OldValue = $this->Cantidad_MustBe->CurrentValue;
		$this->Cantidad_Actual->CurrentValue = 0;
		$this->Cantidad_Actual->OldValue = $this->Cantidad_Actual->CurrentValue;
		$this->Cantidad_Minima->CurrentValue = 0;
		$this->Cantidad_Minima->OldValue = $this->Cantidad_Minima->CurrentValue;
		$this->Cantidad_Maxima->CurrentValue = 0;
		$this->Cantidad_Maxima->OldValue = $this->Cantidad_Maxima->CurrentValue;
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
		// Id_Almacen

		$this->Id_Almacen->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Almacen"]);
		if ($this->Id_Almacen->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Almacen->AdvancedSearch->SearchOperator = @$_GET["z_Id_Almacen"];

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Fam_Accesorio"]);
		if ($this->COD_Fam_Accesorio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Fam_Accesorio->AdvancedSearch->SearchOperator = @$_GET["z_COD_Fam_Accesorio"];

		// COD_Marca_acc
		$this->COD_Marca_acc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Marca_acc"]);
		if ($this->COD_Marca_acc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Marca_acc->AdvancedSearch->SearchOperator = @$_GET["z_COD_Marca_acc"];

		// Id_Articulo
		$this->Id_Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Articulo"]);
		if ($this->Id_Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Articulo"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];

		// Cantidad_MustBe
		$this->Cantidad_MustBe->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_MustBe"]);
		if ($this->Cantidad_MustBe->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_MustBe->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_MustBe"];

		// Cantidad_Actual
		$this->Cantidad_Actual->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Actual"]);
		if ($this->Cantidad_Actual->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Actual->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Actual"];

		// Cantidad_Minima
		$this->Cantidad_Minima->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Minima"]);
		if ($this->Cantidad_Minima->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Minima->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Minima"];

		// Cantidad_Maxima
		$this->Cantidad_Maxima->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Maxima"]);
		if ($this->Cantidad_Maxima->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Maxima->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Maxima"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Almacen->FldIsDetailKey) {
			$this->Id_Almacen->setFormValue($objForm->GetValue("x_Id_Almacen"));
		}
		if (!$this->COD_Fam_Accesorio->FldIsDetailKey) {
			$this->COD_Fam_Accesorio->setFormValue($objForm->GetValue("x_COD_Fam_Accesorio"));
		}
		if (!$this->COD_Marca_acc->FldIsDetailKey) {
			$this->COD_Marca_acc->setFormValue($objForm->GetValue("x_COD_Marca_acc"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Cantidad_MustBe->FldIsDetailKey) {
			$this->Cantidad_MustBe->setFormValue($objForm->GetValue("x_Cantidad_MustBe"));
		}
		if (!$this->Cantidad_Actual->FldIsDetailKey) {
			$this->Cantidad_Actual->setFormValue($objForm->GetValue("x_Cantidad_Actual"));
		}
		if (!$this->Cantidad_Minima->FldIsDetailKey) {
			$this->Cantidad_Minima->setFormValue($objForm->GetValue("x_Cantidad_Minima"));
		}
		if (!$this->Cantidad_Maxima->FldIsDetailKey) {
			$this->Cantidad_Maxima->setFormValue($objForm->GetValue("x_Cantidad_Maxima"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Almacen->CurrentValue = $this->Id_Almacen->FormValue;
		$this->COD_Fam_Accesorio->CurrentValue = $this->COD_Fam_Accesorio->FormValue;
		$this->COD_Marca_acc->CurrentValue = $this->COD_Marca_acc->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Cantidad_MustBe->CurrentValue = $this->Cantidad_MustBe->FormValue;
		$this->Cantidad_Actual->CurrentValue = $this->Cantidad_Actual->FormValue;
		$this->Cantidad_Minima->CurrentValue = $this->Cantidad_Minima->FormValue;
		$this->Cantidad_Maxima->CurrentValue = $this->Cantidad_Maxima->FormValue;
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
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->COD_Marca_acc->setDbValue($rs->fields('COD_Marca_acc'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Cantidad_MustBe->setDbValue($rs->fields('Cantidad_MustBe'));
		$this->Cantidad_Actual->setDbValue($rs->fields('Cantidad_Actual'));
		$this->Cantidad_Minima->setDbValue($rs->fields('Cantidad_Minima'));
		$this->Cantidad_Maxima->setDbValue($rs->fields('Cantidad_Maxima'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Almacen")) <> "")
			$this->Id_Almacen->CurrentValue = $this->getKey("Id_Almacen"); // Id_Almacen
		else
			$bValidKey = FALSE;
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
		// Id_Almacen
		// COD_Fam_Accesorio
		// COD_Marca_acc
		// Id_Articulo
		// Codigo
		// Cantidad_MustBe
		// Cantidad_Actual
		// Cantidad_Minima
		// Cantidad_Maxima

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Almacen
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->ViewValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// COD_Fam_Accesorio
			if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Id_Articulo
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

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->ViewValue = $this->Cantidad_MustBe->CurrentValue;
			$this->Cantidad_MustBe->ViewCustomAttributes = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->ViewValue = $this->Cantidad_Actual->CurrentValue;
			$this->Cantidad_Actual->ViewCustomAttributes = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->ViewValue = $this->Cantidad_Minima->CurrentValue;
			$this->Cantidad_Minima->ViewCustomAttributes = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->ViewValue = $this->Cantidad_Maxima->CurrentValue;
			$this->Cantidad_Maxima->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->LinkCustomAttributes = "";
			$this->Id_Almacen->HrefValue = "";
			$this->Id_Almacen->TooltipValue = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->LinkCustomAttributes = "";
			$this->COD_Fam_Accesorio->HrefValue = "";
			$this->COD_Fam_Accesorio->TooltipValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->LinkCustomAttributes = "";
			$this->COD_Marca_acc->HrefValue = "";
			$this->COD_Marca_acc->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->LinkCustomAttributes = "";
			$this->Cantidad_MustBe->HrefValue = "";
			$this->Cantidad_MustBe->TooltipValue = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->LinkCustomAttributes = "";
			$this->Cantidad_Actual->HrefValue = "";
			$this->Cantidad_Actual->TooltipValue = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->LinkCustomAttributes = "";
			$this->Cantidad_Minima->HrefValue = "";
			$this->Cantidad_Minima->TooltipValue = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->LinkCustomAttributes = "";
			$this->Cantidad_Maxima->HrefValue = "";
			$this->Cantidad_Maxima->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen->EditValue = $arwrk;

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "";
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

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Cantidad_MustBe
			$this->Cantidad_MustBe->EditCustomAttributes = "";
			$this->Cantidad_MustBe->EditValue = ew_HtmlEncode($this->Cantidad_MustBe->CurrentValue);

			// Cantidad_Actual
			$this->Cantidad_Actual->EditCustomAttributes = "";
			$this->Cantidad_Actual->EditValue = ew_HtmlEncode($this->Cantidad_Actual->CurrentValue);

			// Cantidad_Minima
			$this->Cantidad_Minima->EditCustomAttributes = "";
			$this->Cantidad_Minima->EditValue = ew_HtmlEncode($this->Cantidad_Minima->CurrentValue);

			// Cantidad_Maxima
			$this->Cantidad_Maxima->EditCustomAttributes = "";
			$this->Cantidad_Maxima->EditValue = ew_HtmlEncode($this->Cantidad_Maxima->CurrentValue);

			// Edit refer script
			// Id_Almacen

			$this->Id_Almacen->HrefValue = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->HrefValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->HrefValue = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->HrefValue = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->HrefValue = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->EditValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->EditValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "";
			if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Fam_Accesorio->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Fam_Accesorio->EditValue = $this->COD_Fam_Accesorio->CurrentValue;
				}
			} else {
				$this->COD_Fam_Accesorio->EditValue = NULL;
			}
			$this->COD_Fam_Accesorio->ViewCustomAttributes = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "";
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
					$this->COD_Marca_acc->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_acc->EditValue = $this->COD_Marca_acc->CurrentValue;
				}
			} else {
				$this->COD_Marca_acc->EditValue = NULL;
			}
			$this->COD_Marca_acc->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
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

			// Codigo
			$this->Codigo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->EditCustomAttributes = "";
			$this->Cantidad_MustBe->EditValue = $this->Cantidad_MustBe->CurrentValue;
			$this->Cantidad_MustBe->ViewCustomAttributes = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->EditCustomAttributes = "";
			$this->Cantidad_Actual->EditValue = ew_HtmlEncode($this->Cantidad_Actual->CurrentValue);

			// Cantidad_Minima
			$this->Cantidad_Minima->EditCustomAttributes = "";
			$this->Cantidad_Minima->EditValue = ew_HtmlEncode($this->Cantidad_Minima->CurrentValue);

			// Cantidad_Maxima
			$this->Cantidad_Maxima->EditCustomAttributes = "";
			$this->Cantidad_Maxima->EditValue = ew_HtmlEncode($this->Cantidad_Maxima->CurrentValue);

			// Edit refer script
			// Id_Almacen

			$this->Id_Almacen->HrefValue = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->HrefValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->HrefValue = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->HrefValue = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->HrefValue = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen->EditValue = $arwrk;

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "";
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

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->AdvancedSearch->SearchValue);

			// Cantidad_MustBe
			$this->Cantidad_MustBe->EditCustomAttributes = "";
			$this->Cantidad_MustBe->EditValue = ew_HtmlEncode($this->Cantidad_MustBe->AdvancedSearch->SearchValue);

			// Cantidad_Actual
			$this->Cantidad_Actual->EditCustomAttributes = "";
			$this->Cantidad_Actual->EditValue = ew_HtmlEncode($this->Cantidad_Actual->AdvancedSearch->SearchValue);

			// Cantidad_Minima
			$this->Cantidad_Minima->EditCustomAttributes = "";
			$this->Cantidad_Minima->EditValue = ew_HtmlEncode($this->Cantidad_Minima->AdvancedSearch->SearchValue);

			// Cantidad_Maxima
			$this->Cantidad_Maxima->EditCustomAttributes = "";
			$this->Cantidad_Maxima->EditValue = ew_HtmlEncode($this->Cantidad_Maxima->AdvancedSearch->SearchValue);
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
		if (!is_null($this->Id_Almacen->FormValue) && $this->Id_Almacen->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Almacen->FldCaption());
		}
		if (!is_null($this->Cantidad_Actual->FormValue) && $this->Cantidad_Actual->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad_Actual->FldCaption());
		}
		if (!ew_CheckInteger($this->Cantidad_Actual->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Actual->FldErrMsg());
		}
		if (!is_null($this->Cantidad_Minima->FormValue) && $this->Cantidad_Minima->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad_Minima->FldCaption());
		}
		if (!ew_CheckInteger($this->Cantidad_Minima->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Minima->FldErrMsg());
		}
		if (!is_null($this->Cantidad_Maxima->FormValue) && $this->Cantidad_Maxima->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad_Maxima->FldCaption());
		}
		if (!ew_CheckInteger($this->Cantidad_Maxima->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Maxima->FldErrMsg());
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
				$sThisKey .= $row['Id_Almacen'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Articulo'];
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

			// Id_Almacen
			// Cantidad_Actual

			$this->Cantidad_Actual->SetDbValueDef($rsnew, $this->Cantidad_Actual->CurrentValue, 0, $this->Cantidad_Actual->ReadOnly);

			// Cantidad_Minima
			$this->Cantidad_Minima->SetDbValueDef($rsnew, $this->Cantidad_Minima->CurrentValue, 0, $this->Cantidad_Minima->ReadOnly);

			// Cantidad_Maxima
			$this->Cantidad_Maxima->SetDbValueDef($rsnew, $this->Cantidad_Maxima->CurrentValue, 0, $this->Cantidad_Maxima->ReadOnly);

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

		// Id_Almacen
		$this->Id_Almacen->SetDbValueDef($rsnew, $this->Id_Almacen->CurrentValue, 0, strval($this->Id_Almacen->CurrentValue) == "");

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio->SetDbValueDef($rsnew, $this->COD_Fam_Accesorio->CurrentValue, NULL, FALSE);

		// COD_Marca_acc
		$this->COD_Marca_acc->SetDbValueDef($rsnew, $this->COD_Marca_acc->CurrentValue, NULL, FALSE);

		// Id_Articulo
		$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, strval($this->Id_Articulo->CurrentValue) == "");

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Cantidad_MustBe
		$this->Cantidad_MustBe->SetDbValueDef($rsnew, $this->Cantidad_MustBe->CurrentValue, 0, strval($this->Cantidad_MustBe->CurrentValue) == "");

		// Cantidad_Actual
		$this->Cantidad_Actual->SetDbValueDef($rsnew, $this->Cantidad_Actual->CurrentValue, 0, strval($this->Cantidad_Actual->CurrentValue) == "");

		// Cantidad_Minima
		$this->Cantidad_Minima->SetDbValueDef($rsnew, $this->Cantidad_Minima->CurrentValue, 0, strval($this->Cantidad_Minima->CurrentValue) == "");

		// Cantidad_Maxima
		$this->Cantidad_Maxima->SetDbValueDef($rsnew, $this->Cantidad_Maxima->CurrentValue, 0, strval($this->Cantidad_Maxima->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->Id_Almacen->CurrentValue == "" && $this->Id_Almacen->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->Id_Articulo->CurrentValue == "" && $this->Id_Articulo->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
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
		$this->Id_Almacen->AdvancedSearch->Load();
		$this->COD_Fam_Accesorio->AdvancedSearch->Load();
		$this->COD_Marca_acc->AdvancedSearch->Load();
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Cantidad_MustBe->AdvancedSearch->Load();
		$this->Cantidad_Actual->AdvancedSearch->Load();
		$this->Cantidad_Minima->AdvancedSearch->Load();
		$this->Cantidad_Maxima->AdvancedSearch->Load();
	}

	// Page Load event
	function Page_Load() {

	  //  Esta linea es para que al entrar al invetario SIEMPRE resetee la ultima busqueda   
	//  Redireccionar("cap_inventario_accesorioslist.php?cmd=resetall");

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
if (!isset($cap_inventario_accesorios_list)) $cap_inventario_accesorios_list = new ccap_inventario_accesorios_list();

// Page init
$cap_inventario_accesorios_list->Page_Init();

// Page main
$cap_inventario_accesorios_list->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_inventario_accesorios_list = new ew_Page("cap_inventario_accesorios_list");
cap_inventario_accesorios_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_inventario_accesorios_list.PageID; // For backward compatibility

// Form object
var fcap_inventario_accesorioslist = new ew_Form("fcap_inventario_accesorioslist");

// Validate form
fcap_inventario_accesorioslist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Almacen"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_accesorios->Id_Almacen->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Actual"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Actual->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Actual"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Actual->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Minima"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Minima->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Minima"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Minima->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Maxima"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Maxima->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Maxima"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_inventario_accesorios->Cantidad_Maxima->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_inventario_accesorioslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_accesorioslist.ValidateRequired = true;
<?php } else { ?>
fcap_inventario_accesorioslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_inventario_accesorioslist.Lists["x_Id_Almacen"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslist.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":null,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslist.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_inventario_accesorioslistsrch = new ew_Form("fcap_inventario_accesorioslistsrch");

// Validate function for search
fcap_inventario_accesorioslistsrch.Validate = function(fobj) {
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
fcap_inventario_accesorioslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_accesorioslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_inventario_accesorioslistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_inventario_accesorioslistsrch.Lists["x_Id_Almacen"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslistsrch.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":null,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslistsrch.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_accesorioslistsrch.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
</script>
<div id="ewDetailsDiv" style="visibility: hidden; z-index: 11000;"></div>
<script type="text/javascript">

// Details preview
var ewDetailsDiv, ewDetailsTimer = null;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_inventario_accesorios_list->TotalRecs = $cap_inventario_accesorios->SelectRecordCount();
	} else {
		if ($cap_inventario_accesorios_list->Recordset = $cap_inventario_accesorios_list->LoadRecordset())
			$cap_inventario_accesorios_list->TotalRecs = $cap_inventario_accesorios_list->Recordset->RecordCount();
	}
	$cap_inventario_accesorios_list->StartRec = 1;
	if ($cap_inventario_accesorios_list->DisplayRecs <= 0 || ($cap_inventario_accesorios->Export <> "" && $cap_inventario_accesorios->ExportAll)) // Display all records
		$cap_inventario_accesorios_list->DisplayRecs = $cap_inventario_accesorios_list->TotalRecs;
	if (!($cap_inventario_accesorios->Export <> "" && $cap_inventario_accesorios->ExportAll))
		$cap_inventario_accesorios_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_inventario_accesorios_list->Recordset = $cap_inventario_accesorios_list->LoadRecordset($cap_inventario_accesorios_list->StartRec-1, $cap_inventario_accesorios_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_inventario_accesorios->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_inventario_accesorios_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_inventario_accesorios->Export == "" && $cap_inventario_accesorios->CurrentAction == "") { ?>
<form name="fcap_inventario_accesorioslistsrch" id="fcap_inventario_accesorioslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_inventario_accesorioslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_inventario_accesorioslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_inventario_accesorioslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_inventario_accesorios">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_inventario_accesorios_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_inventario_accesorios->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_inventario_accesorios->ResetAttrs();
$cap_inventario_accesorios_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_inventario_accesorios->Id_Almacen->Visible) { // Id_Almacen ?>
	<span id="xsc_Id_Almacen" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_accesorios->Id_Almacen->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Almacen" id="z_Id_Almacen" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Almacen" name="x_Id_Almacen"<?php echo $cap_inventario_accesorios->Id_Almacen->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Almacen->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Almacen->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslistsrch.Lists["x_Id_Almacen"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Almacen->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_inventario_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<span id="xsc_COD_Fam_Accesorio" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Fam_Accesorio" id="z_COD_Fam_Accesorio" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Fam_Accesorio" name="x_COD_Fam_Accesorio"<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Fam_Accesorio->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslistsrch.Lists["x_COD_Fam_Accesorio"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_inventario_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
	<span id="xsc_COD_Marca_acc" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_accesorios->COD_Marca_acc->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Marca_acc" id="z_COD_Marca_acc" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Marca_acc" name="x_COD_Marca_acc"<?php echo $cap_inventario_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Marca_acc->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslistsrch.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
<?php if ($cap_inventario_accesorios->Id_Articulo->Visible) { // Id_Articulo ?>
	<span id="xsc_Id_Articulo" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_inventario_accesorios->Id_Articulo->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Articulo" id="z_Id_Articulo" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Articulo" name="x_Id_Articulo"<?php echo $cap_inventario_accesorios->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Articulo->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslistsrch.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_5" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ResetSearch") ?></a>&nbsp;
</div>
<div id="xsr_6" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_inventario_accesorios_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_inventario_accesorios_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_inventario_accesorios_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_inventario_accesorios_list->ShowPageHeader(); ?>
<?php
$cap_inventario_accesorios_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridUpperPanel">
<?php if ($cap_inventario_accesorios->CurrentAction <> "gridadd" && $cap_inventario_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_inventario_accesorios_list->Pager)) $cap_inventario_accesorios_list->Pager = new cPrevNextPager($cap_inventario_accesorios_list->StartRec, $cap_inventario_accesorios_list->DisplayRecs, $cap_inventario_accesorios_list->TotalRecs) ?>
<?php if ($cap_inventario_accesorios_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_inventario_accesorios_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_inventario_accesorios_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_inventario_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_inventario_accesorios->CurrentAction <> "gridadd" && $cap_inventario_accesorios->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0 && $cap_inventario_accesorios_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_inventario_accesorios_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
<?php if ($Security->CanEdit()) { ?>
<a class="ewGridLink" href="" onclick="ew_SubmitSelected(document.fcap_inventario_accesorioslist, '<?php echo $cap_inventario_accesorios_list->MultiUpdateUrl ?>');return false;"><?php echo $Language->Phrase("UpdateSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_inventario_accesorios->CurrentAction == "gridedit") { ?>
<?php if ($cap_inventario_accesorios->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_inventario_accesorioslist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<form name="fcap_inventario_accesorioslist" id="fcap_inventario_accesorioslist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_inventario_accesorios">
<div id="gmp_cap_inventario_accesorios" class="ewGridMiddlePanel">
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
<table id="tbl_cap_inventario_accesorioslist" class="ewTable ewTableSeparate">
<?php echo $cap_inventario_accesorios->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_inventario_accesorios_list->RenderListOptions();

// Render list options (header, left)
$cap_inventario_accesorios_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_inventario_accesorios->Id_Almacen->Visible) { // Id_Almacen ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Id_Almacen) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Id_Almacen" class="cap_inventario_accesorios_Id_Almacen"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Id_Almacen->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Id_Almacen) ?>',1);"><span id="elh_cap_inventario_accesorios_Id_Almacen" class="cap_inventario_accesorios_Id_Almacen">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Id_Almacen->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Id_Almacen->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Id_Almacen->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->COD_Fam_Accesorio) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_COD_Fam_Accesorio" class="cap_inventario_accesorios_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->COD_Fam_Accesorio) ?>',1);"><span id="elh_cap_inventario_accesorios_COD_Fam_Accesorio" class="cap_inventario_accesorios_COD_Fam_Accesorio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->COD_Fam_Accesorio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->COD_Fam_Accesorio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->COD_Marca_acc) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_COD_Marca_acc" class="cap_inventario_accesorios_COD_Marca_acc"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->COD_Marca_acc->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->COD_Marca_acc) ?>',1);"><span id="elh_cap_inventario_accesorios_COD_Marca_acc" class="cap_inventario_accesorios_COD_Marca_acc">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->COD_Marca_acc->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->COD_Marca_acc->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->COD_Marca_acc->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Id_Articulo" class="cap_inventario_accesorios_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Id_Articulo) ?>',1);"><span id="elh_cap_inventario_accesorios_Id_Articulo" class="cap_inventario_accesorios_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Codigo) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Codigo" class="cap_inventario_accesorios_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Codigo) ?>',1);"><span id="elh_cap_inventario_accesorios_Codigo" class="cap_inventario_accesorios_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Codigo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Cantidad_MustBe->Visible) { // Cantidad_MustBe ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_MustBe) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Cantidad_MustBe" class="cap_inventario_accesorios_Cantidad_MustBe"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Cantidad_MustBe->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_MustBe) ?>',1);"><span id="elh_cap_inventario_accesorios_Cantidad_MustBe" class="cap_inventario_accesorios_Cantidad_MustBe">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Cantidad_MustBe->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Cantidad_MustBe->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Cantidad_MustBe->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Cantidad_Actual->Visible) { // Cantidad_Actual ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Actual) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Cantidad_Actual" class="cap_inventario_accesorios_Cantidad_Actual"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Cantidad_Actual->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Actual) ?>',1);"><span id="elh_cap_inventario_accesorios_Cantidad_Actual" class="cap_inventario_accesorios_Cantidad_Actual">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Cantidad_Actual->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Cantidad_Actual->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Cantidad_Actual->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Cantidad_Minima->Visible) { // Cantidad_Minima ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Minima) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Cantidad_Minima" class="cap_inventario_accesorios_Cantidad_Minima"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Cantidad_Minima->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Minima) ?>',1);"><span id="elh_cap_inventario_accesorios_Cantidad_Minima" class="cap_inventario_accesorios_Cantidad_Minima">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Cantidad_Minima->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Cantidad_Minima->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Cantidad_Minima->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_accesorios->Cantidad_Maxima->Visible) { // Cantidad_Maxima ?>
	<?php if ($cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Maxima) == "") { ?>
		<td><span id="elh_cap_inventario_accesorios_Cantidad_Maxima" class="cap_inventario_accesorios_Cantidad_Maxima"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_accesorios->Cantidad_Maxima->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_inventario_accesorios->SortUrl($cap_inventario_accesorios->Cantidad_Maxima) ?>',1);"><span id="elh_cap_inventario_accesorios_Cantidad_Maxima" class="cap_inventario_accesorios_Cantidad_Maxima">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_accesorios->Cantidad_Maxima->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_accesorios->Cantidad_Maxima->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_accesorios->Cantidad_Maxima->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_inventario_accesorios_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_inventario_accesorios->ExportAll && $cap_inventario_accesorios->Export <> "") {
	$cap_inventario_accesorios_list->StopRec = $cap_inventario_accesorios_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_inventario_accesorios_list->TotalRecs > $cap_inventario_accesorios_list->StartRec + $cap_inventario_accesorios_list->DisplayRecs - 1)
		$cap_inventario_accesorios_list->StopRec = $cap_inventario_accesorios_list->StartRec + $cap_inventario_accesorios_list->DisplayRecs - 1;
	else
		$cap_inventario_accesorios_list->StopRec = $cap_inventario_accesorios_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_inventario_accesorios->CurrentAction == "gridadd" || $cap_inventario_accesorios->CurrentAction == "gridedit" || $cap_inventario_accesorios->CurrentAction == "F")) {
		$cap_inventario_accesorios_list->KeyCount = $objForm->GetValue("key_count");
		$cap_inventario_accesorios_list->StopRec = $cap_inventario_accesorios_list->KeyCount;
	}
}
$cap_inventario_accesorios_list->RecCnt = $cap_inventario_accesorios_list->StartRec - 1;
if ($cap_inventario_accesorios_list->Recordset && !$cap_inventario_accesorios_list->Recordset->EOF) {
	$cap_inventario_accesorios_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_inventario_accesorios_list->StartRec > 1)
		$cap_inventario_accesorios_list->Recordset->Move($cap_inventario_accesorios_list->StartRec - 1);
} elseif (!$cap_inventario_accesorios->AllowAddDeleteRow && $cap_inventario_accesorios_list->StopRec == 0) {
	$cap_inventario_accesorios_list->StopRec = $cap_inventario_accesorios->GridAddRowCount;
}

// Initialize aggregate
$cap_inventario_accesorios->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_inventario_accesorios->ResetAttrs();
$cap_inventario_accesorios_list->RenderRow();
$cap_inventario_accesorios_list->EditRowCnt = 0;
if ($cap_inventario_accesorios->CurrentAction == "edit")
	$cap_inventario_accesorios_list->RowIndex = 1;
if ($cap_inventario_accesorios->CurrentAction == "gridedit")
	$cap_inventario_accesorios_list->RowIndex = 0;
while ($cap_inventario_accesorios_list->RecCnt < $cap_inventario_accesorios_list->StopRec) {
	$cap_inventario_accesorios_list->RecCnt++;
	if (intval($cap_inventario_accesorios_list->RecCnt) >= intval($cap_inventario_accesorios_list->StartRec)) {
		$cap_inventario_accesorios_list->RowCnt++;
		if ($cap_inventario_accesorios->CurrentAction == "gridadd" || $cap_inventario_accesorios->CurrentAction == "gridedit" || $cap_inventario_accesorios->CurrentAction == "F") {
			$cap_inventario_accesorios_list->RowIndex++;
			$objForm->Index = $cap_inventario_accesorios_list->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_inventario_accesorios_list->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_inventario_accesorios->CurrentAction == "gridadd")
				$cap_inventario_accesorios_list->RowAction = "insert";
			else
				$cap_inventario_accesorios_list->RowAction = "";
		}

		// Set up key count
		$cap_inventario_accesorios_list->KeyCount = $cap_inventario_accesorios_list->RowIndex;

		// Init row class and style
		$cap_inventario_accesorios->ResetAttrs();
		$cap_inventario_accesorios->CssClass = "";
		if ($cap_inventario_accesorios->CurrentAction == "gridadd") {
			$cap_inventario_accesorios_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_inventario_accesorios_list->LoadRowValues($cap_inventario_accesorios_list->Recordset); // Load row values
		}
		$cap_inventario_accesorios->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_inventario_accesorios->CurrentAction == "edit") {
			if ($cap_inventario_accesorios_list->CheckInlineEditKey() && $cap_inventario_accesorios_list->EditRowCnt == 0) { // Inline edit
				$cap_inventario_accesorios->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_inventario_accesorios->CurrentAction == "gridedit") { // Grid edit
			if ($cap_inventario_accesorios->EventCancelled) {
				$cap_inventario_accesorios_list->RestoreCurrentRowFormValues($cap_inventario_accesorios_list->RowIndex); // Restore form values
			}
			if ($cap_inventario_accesorios_list->RowAction == "insert")
				$cap_inventario_accesorios->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_inventario_accesorios->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_inventario_accesorios->CurrentAction == "edit" && $cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT && $cap_inventario_accesorios->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_inventario_accesorios_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_inventario_accesorios->CurrentAction == "gridedit" && ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT || $cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) && $cap_inventario_accesorios->EventCancelled) // Update failed
			$cap_inventario_accesorios_list->RestoreCurrentRowFormValues($cap_inventario_accesorios_list->RowIndex); // Restore form values
		if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_inventario_accesorios_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_inventario_accesorios->RowAttrs = array_merge($cap_inventario_accesorios->RowAttrs, array('data-rowindex'=>$cap_inventario_accesorios_list->RowCnt, 'id'=>'r' . $cap_inventario_accesorios_list->RowCnt . '_cap_inventario_accesorios', 'data-rowtype'=>$cap_inventario_accesorios->RowType));

		// Render row
		$cap_inventario_accesorios_list->RenderRow();

		// Render list options
		$cap_inventario_accesorios_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_inventario_accesorios_list->RowAction <> "delete" && $cap_inventario_accesorios_list->RowAction <> "insertdelete" && !($cap_inventario_accesorios_list->RowAction == "insert" && $cap_inventario_accesorios->CurrentAction == "F" && $cap_inventario_accesorios_list->EmptyRow())) {
?>
	<tr<?php echo $cap_inventario_accesorios->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_accesorios_list->ListOptions->Render("body", "left", $cap_inventario_accesorios_list->RowCnt);
?>
	<?php if ($cap_inventario_accesorios->Id_Almacen->Visible) { // Id_Almacen ?>
		<td<?php echo $cap_inventario_accesorios->Id_Almacen->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Id_Almacen" class="cap_inventario_accesorios_Id_Almacen">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen"<?php echo $cap_inventario_accesorios->Id_Almacen->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Almacen->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Almacen->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_Id_Almacen"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Almacen->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Almacen->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->Id_Almacen->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Id_Almacen->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Almacen->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Id_Almacen->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Id_Almacen->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_COD_Fam_Accesorio" class="cap_inventario_accesorios_COD_Fam_Accesorio">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_COD_Fam_Accesorio"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Fam_Accesorio->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Fam_Accesorio->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
		<td<?php echo $cap_inventario_accesorios->COD_Marca_acc->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_COD_Marca_acc" class="cap_inventario_accesorios_COD_Marca_acc">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc"<?php echo $cap_inventario_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Marca_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Marca_acc->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->COD_Marca_acc->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->COD_Marca_acc->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Marca_acc->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->COD_Marca_acc->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->COD_Marca_acc->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_inventario_accesorios->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Id_Articulo" class="cap_inventario_accesorios_Id_Articulo">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo"<?php echo $cap_inventario_accesorios->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Id_Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_inventario_accesorios->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Codigo" class="cap_inventario_accesorios_Codigo">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" size="30" maxlength="15" value="<?php echo $cap_inventario_accesorios->Codigo->EditValue ?>"<?php echo $cap_inventario_accesorios->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Codigo->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Codigo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Codigo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_MustBe->Visible) { // Cantidad_MustBe ?>
		<td<?php echo $cap_inventario_accesorios->Cantidad_MustBe->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Cantidad_MustBe" class="cap_inventario_accesorios_Cantidad_MustBe">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_MustBe->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_MustBe->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_MustBe->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_inventario_accesorios->Cantidad_MustBe->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Cantidad_MustBe->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_MustBe->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Cantidad_MustBe->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Cantidad_MustBe->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Actual->Visible) { // Cantidad_Actual ?>
		<td<?php echo $cap_inventario_accesorios->Cantidad_Actual->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Cantidad_Actual" class="cap_inventario_accesorios_Cantidad_Actual">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Actual->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Cantidad_Actual->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Cantidad_Actual->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Minima->Visible) { // Cantidad_Minima ?>
		<td<?php echo $cap_inventario_accesorios->Cantidad_Minima->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Cantidad_Minima" class="cap_inventario_accesorios_Cantidad_Minima">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Minima->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Cantidad_Minima->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Cantidad_Minima->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Maxima->Visible) { // Cantidad_Maxima ?>
		<td<?php echo $cap_inventario_accesorios->Cantidad_Maxima->CellAttributes() ?>><span id="el<?php echo $cap_inventario_accesorios_list->RowCnt ?>_cap_inventario_accesorios_Cantidad_Maxima" class="cap_inventario_accesorios_Cantidad_Maxima">
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Maxima->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_accesorios->Cantidad_Maxima->ViewAttributes() ?>>
<?php echo $cap_inventario_accesorios->Cantidad_Maxima->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_inventario_accesorios_list->PageObjName . "_row_" . $cap_inventario_accesorios_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_accesorios_list->ListOptions->Render("body", "right", $cap_inventario_accesorios_list->RowCnt);
?>
	</tr>
<?php if ($cap_inventario_accesorios->RowType == EW_ROWTYPE_ADD || $cap_inventario_accesorios->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_inventario_accesorioslist.UpdateOpts(<?php echo $cap_inventario_accesorios_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_inventario_accesorios->CurrentAction <> "gridadd")
		if (!$cap_inventario_accesorios_list->Recordset->EOF) $cap_inventario_accesorios_list->Recordset->MoveNext();
}
?>
<?php
	if ($cap_inventario_accesorios->CurrentAction == "gridadd" || $cap_inventario_accesorios->CurrentAction == "gridedit") {
		$cap_inventario_accesorios_list->RowIndex = '$rowindex$';
		$cap_inventario_accesorios_list->LoadDefaultValues();

		// Set row properties
		$cap_inventario_accesorios->ResetAttrs();
		$cap_inventario_accesorios->RowAttrs = array_merge($cap_inventario_accesorios->RowAttrs, array('data-rowindex'=>$cap_inventario_accesorios_list->RowIndex, 'id'=>'r0_cap_inventario_accesorios', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_inventario_accesorios->RowAttrs["class"], "ewTemplate");
		$cap_inventario_accesorios->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_inventario_accesorios_list->RenderRow();

		// Render list options
		$cap_inventario_accesorios_list->RenderListOptions();
		$cap_inventario_accesorios_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_inventario_accesorios->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_accesorios_list->ListOptions->Render("body", "left", $cap_inventario_accesorios_list->RowIndex);
?>
	<?php if ($cap_inventario_accesorios->Id_Almacen->Visible) { // Id_Almacen ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Id_Almacen" class="cap_inventario_accesorios_Id_Almacen">
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen"<?php echo $cap_inventario_accesorios->Id_Almacen->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Almacen->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Almacen->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_Id_Almacen"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Almacen->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Almacen->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Almacen->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_COD_Fam_Accesorio" class="cap_inventario_accesorios_COD_Fam_Accesorio">
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_inventario_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_COD_Fam_Accesorio"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Fam_Accesorio->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Fam_Accesorio->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_COD_Marca_acc" class="cap_inventario_accesorios_COD_Marca_acc">
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc"<?php echo $cap_inventario_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_inventario_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->COD_Marca_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_inventario_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_COD_Marca_acc" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->COD_Marca_acc->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Id_Articulo" class="cap_inventario_accesorios_Id_Articulo">
<select id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo"<?php echo $cap_inventario_accesorios->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) {
	$arwrk = $cap_inventario_accesorios->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_inventario_accesorios->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_inventario_accesorioslist.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_inventario_accesorios->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_inventario_accesorios->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Codigo->Visible) { // Codigo ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Codigo" class="cap_inventario_accesorios_Codigo">
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" size="30" maxlength="15" value="<?php echo $cap_inventario_accesorios->Codigo->EditValue ?>"<?php echo $cap_inventario_accesorios->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_MustBe->Visible) { // Cantidad_MustBe ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Cantidad_MustBe" class="cap_inventario_accesorios_Cantidad_MustBe">
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_MustBe->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_MustBe->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_MustBe" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_MustBe->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Actual->Visible) { // Cantidad_Actual ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Cantidad_Actual" class="cap_inventario_accesorios_Cantidad_Actual">
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Actual->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Actual" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Actual->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Minima->Visible) { // Cantidad_Minima ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Cantidad_Minima" class="cap_inventario_accesorios_Cantidad_Minima">
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Minima->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Minima" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Minima->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_accesorios->Cantidad_Maxima->Visible) { // Cantidad_Maxima ?>
		<td><span id="el$rowindex$_cap_inventario_accesorios_Cantidad_Maxima" class="cap_inventario_accesorios_Cantidad_Maxima">
<input type="text" name="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" id="x<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" size="5" maxlength="5" value="<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditValue ?>"<?php echo $cap_inventario_accesorios->Cantidad_Maxima->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" id="o<?php echo $cap_inventario_accesorios_list->RowIndex ?>_Cantidad_Maxima" value="<?php echo ew_HtmlEncode($cap_inventario_accesorios->Cantidad_Maxima->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_accesorios_list->ListOptions->Render("body", "right", $cap_inventario_accesorios_list->RowCnt);
?>
<script type="text/javascript">
fcap_inventario_accesorioslist.UpdateOpts(<?php echo $cap_inventario_accesorios_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_inventario_accesorios->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_accesorios_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_inventario_accesorios->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_accesorios_list->KeyCount ?>">
<?php echo $cap_inventario_accesorios_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_inventario_accesorios->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_inventario_accesorios_list->Recordset)
	$cap_inventario_accesorios_list->Recordset->Close();
?>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_inventario_accesorios->CurrentAction <> "gridadd" && $cap_inventario_accesorios->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_inventario_accesorios_list->Pager)) $cap_inventario_accesorios_list->Pager = new cPrevNextPager($cap_inventario_accesorios_list->StartRec, $cap_inventario_accesorios_list->DisplayRecs, $cap_inventario_accesorios_list->TotalRecs) ?>
<?php if ($cap_inventario_accesorios_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_inventario_accesorios_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_inventario_accesorios_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>start=<?php echo $cap_inventario_accesorios_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_inventario_accesorios_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_inventario_accesorios_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_inventario_accesorios">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_inventario_accesorios_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_inventario_accesorios->CurrentAction <> "gridadd" && $cap_inventario_accesorios->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0 && $cap_inventario_accesorios_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_inventario_accesorios_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($cap_inventario_accesorios_list->TotalRecs > 0) { ?>
<?php if ($Security->CanEdit()) { ?>
<a class="ewGridLink" href="" onclick="ew_SubmitSelected(document.fcap_inventario_accesorioslist, '<?php echo $cap_inventario_accesorios_list->MultiUpdateUrl ?>');return false;"><?php echo $Language->Phrase("UpdateSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_inventario_accesorios->CurrentAction == "gridedit") { ?>
<?php if ($cap_inventario_accesorios->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_inventario_accesorioslist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_inventario_accesorios_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
</td></tr></table>
<script type="text/javascript">
fcap_inventario_accesorioslistsrch.Init();
fcap_inventario_accesorioslist.Init();
</script>
<?php
$cap_inventario_accesorios_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_inventario_accesorios_list->Page_Terminate();
?>
