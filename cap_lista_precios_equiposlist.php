<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_lista_precios_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_lista_precios_equipos_list = NULL; // Initialize page object first

class ccap_lista_precios_equipos_list extends ccap_lista_precios_equipos {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_lista_precios_equipos';

	// Page object name
	var $PageObjName = 'cap_lista_precios_equipos_list';

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

		// Table object (cap_lista_precios_equipos)
		if (!isset($GLOBALS["cap_lista_precios_equipos"])) {
			$GLOBALS["cap_lista_precios_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_lista_precios_equipos"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_lista_precios_equiposadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_lista_precios_equiposdelete.php";
		$this->MultiUpdateUrl = "cap_lista_precios_equiposupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_lista_precios_equipos', TRUE);

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
			$this->Id_Articulo->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Articulo->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_COD_Marca_eq") && $objForm->HasValue("o_COD_Marca_eq") && $this->COD_Marca_eq->CurrentValue <> $this->COD_Marca_eq->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_COD_Modelo_eq") && $objForm->HasValue("o_COD_Modelo_eq") && $this->COD_Modelo_eq->CurrentValue <> $this->COD_Modelo_eq->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_COD_Compania_eq") && $objForm->HasValue("o_COD_Compania_eq") && $this->COD_Compania_eq->CurrentValue <> $this->COD_Compania_eq->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Articulo") && $objForm->HasValue("o_Articulo") && $this->Articulo->CurrentValue <> $this->Articulo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Codigo") && $objForm->HasValue("o_Codigo") && $this->Codigo->CurrentValue <> $this->Codigo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_compra") && $objForm->HasValue("o_Precio_compra") && $this->Precio_compra->CurrentValue <> $this->Precio_compra->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Descuento_Sin_Chip") && $objForm->HasValue("o_Descuento_Sin_Chip") && $this->Descuento_Sin_Chip->CurrentValue <> $this->Descuento_Sin_Chip->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_lista_venta_publico_1") && $objForm->HasValue("o_Precio_lista_venta_publico_1") && $this->Precio_lista_venta_publico_1->CurrentValue <> $this->Precio_lista_venta_publico_1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_lista_venta_publico_2") && $objForm->HasValue("o_Precio_lista_venta_publico_2") && $this->Precio_lista_venta_publico_2->CurrentValue <> $this->Precio_lista_venta_publico_2->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_lista_venta_publico_3") && $objForm->HasValue("o_Precio_lista_venta_publico_3") && $this->Precio_lista_venta_publico_3->CurrentValue <> $this->Precio_lista_venta_publico_3->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_lista_venta_medio_mayoreo") && $objForm->HasValue("o_Precio_lista_venta_medio_mayoreo") && $this->Precio_lista_venta_medio_mayoreo->CurrentValue <> $this->Precio_lista_venta_medio_mayoreo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Precio_lista_venta_mayoreo") && $objForm->HasValue("o_Precio_lista_venta_mayoreo") && $this->Precio_lista_venta_mayoreo->CurrentValue <> $this->Precio_lista_venta_mayoreo->OldValue)
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
		$this->BuildSearchSql($sWhere, $this->Id_Articulo, FALSE); // Id_Articulo
		$this->BuildSearchSql($sWhere, $this->COD_Marca_eq, FALSE); // COD_Marca_eq
		$this->BuildSearchSql($sWhere, $this->COD_Modelo_eq, FALSE); // COD_Modelo_eq
		$this->BuildSearchSql($sWhere, $this->COD_Compania_eq, FALSE); // COD_Compania_eq
		$this->BuildSearchSql($sWhere, $this->Articulo, FALSE); // Articulo
		$this->BuildSearchSql($sWhere, $this->Codigo, FALSE); // Codigo
		$this->BuildSearchSql($sWhere, $this->Precio_compra, FALSE); // Precio_compra
		$this->BuildSearchSql($sWhere, $this->Descuento_Sin_Chip, FALSE); // Descuento_Sin_Chip
		$this->BuildSearchSql($sWhere, $this->Precio_lista_venta_publico_1, FALSE); // Precio_lista_venta_publico_1
		$this->BuildSearchSql($sWhere, $this->Precio_lista_venta_publico_2, FALSE); // Precio_lista_venta_publico_2
		$this->BuildSearchSql($sWhere, $this->Precio_lista_venta_publico_3, FALSE); // Precio_lista_venta_publico_3
		$this->BuildSearchSql($sWhere, $this->Precio_lista_venta_medio_mayoreo, FALSE); // Precio_lista_venta_medio_mayoreo
		$this->BuildSearchSql($sWhere, $this->Precio_lista_venta_mayoreo, FALSE); // Precio_lista_venta_mayoreo

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Articulo->AdvancedSearch->Save(); // Id_Articulo
			$this->COD_Marca_eq->AdvancedSearch->Save(); // COD_Marca_eq
			$this->COD_Modelo_eq->AdvancedSearch->Save(); // COD_Modelo_eq
			$this->COD_Compania_eq->AdvancedSearch->Save(); // COD_Compania_eq
			$this->Articulo->AdvancedSearch->Save(); // Articulo
			$this->Codigo->AdvancedSearch->Save(); // Codigo
			$this->Precio_compra->AdvancedSearch->Save(); // Precio_compra
			$this->Descuento_Sin_Chip->AdvancedSearch->Save(); // Descuento_Sin_Chip
			$this->Precio_lista_venta_publico_1->AdvancedSearch->Save(); // Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_2->AdvancedSearch->Save(); // Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_3->AdvancedSearch->Save(); // Precio_lista_venta_publico_3
			$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->Save(); // Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_mayoreo->AdvancedSearch->Save(); // Precio_lista_venta_mayoreo
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
		$this->BuildBasicSearchSQL($sWhere, $this->COD_Modelo_eq, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Articulo, $Keyword);
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
		if ($this->Id_Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Marca_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Modelo_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->COD_Compania_eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Articulo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Codigo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_compra->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Descuento_Sin_Chip->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_lista_venta_publico_1->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_lista_venta_publico_2->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_lista_venta_publico_3->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Precio_lista_venta_mayoreo->AdvancedSearch->IssetSession())
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
		$this->COD_Marca_eq->AdvancedSearch->UnsetSession();
		$this->COD_Modelo_eq->AdvancedSearch->UnsetSession();
		$this->COD_Compania_eq->AdvancedSearch->UnsetSession();
		$this->Articulo->AdvancedSearch->UnsetSession();
		$this->Codigo->AdvancedSearch->UnsetSession();
		$this->Precio_compra->AdvancedSearch->UnsetSession();
		$this->Descuento_Sin_Chip->AdvancedSearch->UnsetSession();
		$this->Precio_lista_venta_publico_1->AdvancedSearch->UnsetSession();
		$this->Precio_lista_venta_publico_2->AdvancedSearch->UnsetSession();
		$this->Precio_lista_venta_publico_3->AdvancedSearch->UnsetSession();
		$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->UnsetSession();
		$this->Precio_lista_venta_mayoreo->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Articulo->AdvancedSearch->Load();
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->COD_Modelo_eq->AdvancedSearch->Load();
		$this->COD_Compania_eq->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Precio_compra->AdvancedSearch->Load();
		$this->Descuento_Sin_Chip->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_1->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_2->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_3->AdvancedSearch->Load();
		$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->Load();
		$this->Precio_lista_venta_mayoreo->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->COD_Marca_eq, $bCtrl); // COD_Marca_eq
			$this->UpdateSort($this->COD_Modelo_eq, $bCtrl); // COD_Modelo_eq
			$this->UpdateSort($this->COD_Compania_eq, $bCtrl); // COD_Compania_eq
			$this->UpdateSort($this->Articulo, $bCtrl); // Articulo
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->Precio_compra, $bCtrl); // Precio_compra
			$this->UpdateSort($this->Descuento_Sin_Chip, $bCtrl); // Descuento_Sin_Chip
			$this->UpdateSort($this->Precio_lista_venta_publico_1, $bCtrl); // Precio_lista_venta_publico_1
			$this->UpdateSort($this->Precio_lista_venta_publico_2, $bCtrl); // Precio_lista_venta_publico_2
			$this->UpdateSort($this->Precio_lista_venta_publico_3, $bCtrl); // Precio_lista_venta_publico_3
			$this->UpdateSort($this->Precio_lista_venta_medio_mayoreo, $bCtrl); // Precio_lista_venta_medio_mayoreo
			$this->UpdateSort($this->Precio_lista_venta_mayoreo, $bCtrl); // Precio_lista_venta_mayoreo
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
				$this->COD_Marca_eq->setSort("ASC");
				$this->COD_Modelo_eq->setSort("ASC");
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
				$this->COD_Marca_eq->setSort("");
				$this->COD_Modelo_eq->setSort("");
				$this->COD_Compania_eq->setSort("");
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->Precio_compra->setSort("");
				$this->Descuento_Sin_Chip->setSort("");
				$this->Precio_lista_venta_publico_1->setSort("");
				$this->Precio_lista_venta_publico_2->setSort("");
				$this->Precio_lista_venta_publico_3->setSort("");
				$this->Precio_lista_venta_medio_mayoreo->setSort("");
				$this->Precio_lista_venta_mayoreo->setSort("");
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
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fcap_lista_precios_equiposlist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
					"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Articulo->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink\" href=\"" . ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt) . "\">" . "<img src=\"phpimages/inlineedit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InlineEditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
		}
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $this->Id_Articulo->CurrentValue . "\">";
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
		$this->COD_Marca_eq->CurrentValue = NULL;
		$this->COD_Marca_eq->OldValue = $this->COD_Marca_eq->CurrentValue;
		$this->COD_Modelo_eq->CurrentValue = NULL;
		$this->COD_Modelo_eq->OldValue = $this->COD_Modelo_eq->CurrentValue;
		$this->COD_Compania_eq->CurrentValue = NULL;
		$this->COD_Compania_eq->OldValue = $this->COD_Compania_eq->CurrentValue;
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Precio_compra->CurrentValue = 0.00;
		$this->Precio_compra->OldValue = $this->Precio_compra->CurrentValue;
		$this->Descuento_Sin_Chip->CurrentValue = 100.00;
		$this->Descuento_Sin_Chip->OldValue = $this->Descuento_Sin_Chip->CurrentValue;
		$this->Precio_lista_venta_publico_1->CurrentValue = 0.00;
		$this->Precio_lista_venta_publico_1->OldValue = $this->Precio_lista_venta_publico_1->CurrentValue;
		$this->Precio_lista_venta_publico_2->CurrentValue = 0.00;
		$this->Precio_lista_venta_publico_2->OldValue = $this->Precio_lista_venta_publico_2->CurrentValue;
		$this->Precio_lista_venta_publico_3->CurrentValue = 0.00;
		$this->Precio_lista_venta_publico_3->OldValue = $this->Precio_lista_venta_publico_3->CurrentValue;
		$this->Precio_lista_venta_medio_mayoreo->CurrentValue = 0.00;
		$this->Precio_lista_venta_medio_mayoreo->OldValue = $this->Precio_lista_venta_medio_mayoreo->CurrentValue;
		$this->Precio_lista_venta_mayoreo->CurrentValue = 0.00;
		$this->Precio_lista_venta_mayoreo->OldValue = $this->Precio_lista_venta_mayoreo->CurrentValue;
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

		// COD_Marca_eq
		$this->COD_Marca_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Marca_eq"]);
		if ($this->COD_Marca_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Marca_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Marca_eq"];

		// COD_Modelo_eq
		$this->COD_Modelo_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Modelo_eq"]);
		if ($this->COD_Modelo_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Modelo_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Modelo_eq"];

		// COD_Compania_eq
		$this->COD_Compania_eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_COD_Compania_eq"]);
		if ($this->COD_Compania_eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->COD_Compania_eq->AdvancedSearch->SearchOperator = @$_GET["z_COD_Compania_eq"];

		// Articulo
		$this->Articulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Articulo"]);
		if ($this->Articulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Articulo->AdvancedSearch->SearchOperator = @$_GET["z_Articulo"];

		// Codigo
		$this->Codigo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Codigo"]);
		if ($this->Codigo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Codigo->AdvancedSearch->SearchOperator = @$_GET["z_Codigo"];

		// Precio_compra
		$this->Precio_compra->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_compra"]);
		if ($this->Precio_compra->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_compra->AdvancedSearch->SearchOperator = @$_GET["z_Precio_compra"];

		// Descuento_Sin_Chip
		$this->Descuento_Sin_Chip->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Descuento_Sin_Chip"]);
		if ($this->Descuento_Sin_Chip->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Descuento_Sin_Chip->AdvancedSearch->SearchOperator = @$_GET["z_Descuento_Sin_Chip"];

		// Precio_lista_venta_publico_1
		$this->Precio_lista_venta_publico_1->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_lista_venta_publico_1"]);
		if ($this->Precio_lista_venta_publico_1->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_lista_venta_publico_1->AdvancedSearch->SearchOperator = @$_GET["z_Precio_lista_venta_publico_1"];

		// Precio_lista_venta_publico_2
		$this->Precio_lista_venta_publico_2->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_lista_venta_publico_2"]);
		if ($this->Precio_lista_venta_publico_2->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_lista_venta_publico_2->AdvancedSearch->SearchOperator = @$_GET["z_Precio_lista_venta_publico_2"];

		// Precio_lista_venta_publico_3
		$this->Precio_lista_venta_publico_3->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_lista_venta_publico_3"]);
		if ($this->Precio_lista_venta_publico_3->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_lista_venta_publico_3->AdvancedSearch->SearchOperator = @$_GET["z_Precio_lista_venta_publico_3"];

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_lista_venta_medio_mayoreo"]);
		if ($this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->SearchOperator = @$_GET["z_Precio_lista_venta_medio_mayoreo"];

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Precio_lista_venta_mayoreo"]);
		if ($this->Precio_lista_venta_mayoreo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Precio_lista_venta_mayoreo->AdvancedSearch->SearchOperator = @$_GET["z_Precio_lista_venta_mayoreo"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->COD_Marca_eq->FldIsDetailKey) {
			$this->COD_Marca_eq->setFormValue($objForm->GetValue("x_COD_Marca_eq"));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue($objForm->GetValue("x_COD_Modelo_eq"));
		}
		if (!$this->COD_Compania_eq->FldIsDetailKey) {
			$this->COD_Compania_eq->setFormValue($objForm->GetValue("x_COD_Compania_eq"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Precio_compra->FldIsDetailKey) {
			$this->Precio_compra->setFormValue($objForm->GetValue("x_Precio_compra"));
		}
		if (!$this->Descuento_Sin_Chip->FldIsDetailKey) {
			$this->Descuento_Sin_Chip->setFormValue($objForm->GetValue("x_Descuento_Sin_Chip"));
		}
		if (!$this->Precio_lista_venta_publico_1->FldIsDetailKey) {
			$this->Precio_lista_venta_publico_1->setFormValue($objForm->GetValue("x_Precio_lista_venta_publico_1"));
		}
		if (!$this->Precio_lista_venta_publico_2->FldIsDetailKey) {
			$this->Precio_lista_venta_publico_2->setFormValue($objForm->GetValue("x_Precio_lista_venta_publico_2"));
		}
		if (!$this->Precio_lista_venta_publico_3->FldIsDetailKey) {
			$this->Precio_lista_venta_publico_3->setFormValue($objForm->GetValue("x_Precio_lista_venta_publico_3"));
		}
		if (!$this->Precio_lista_venta_medio_mayoreo->FldIsDetailKey) {
			$this->Precio_lista_venta_medio_mayoreo->setFormValue($objForm->GetValue("x_Precio_lista_venta_medio_mayoreo"));
		}
		if (!$this->Precio_lista_venta_mayoreo->FldIsDetailKey) {
			$this->Precio_lista_venta_mayoreo->setFormValue($objForm->GetValue("x_Precio_lista_venta_mayoreo"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->COD_Marca_eq->CurrentValue = $this->COD_Marca_eq->FormValue;
		$this->COD_Modelo_eq->CurrentValue = $this->COD_Modelo_eq->FormValue;
		$this->COD_Compania_eq->CurrentValue = $this->COD_Compania_eq->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Precio_compra->CurrentValue = $this->Precio_compra->FormValue;
		$this->Descuento_Sin_Chip->CurrentValue = $this->Descuento_Sin_Chip->FormValue;
		$this->Precio_lista_venta_publico_1->CurrentValue = $this->Precio_lista_venta_publico_1->FormValue;
		$this->Precio_lista_venta_publico_2->CurrentValue = $this->Precio_lista_venta_publico_2->FormValue;
		$this->Precio_lista_venta_publico_3->CurrentValue = $this->Precio_lista_venta_publico_3->FormValue;
		$this->Precio_lista_venta_medio_mayoreo->CurrentValue = $this->Precio_lista_venta_medio_mayoreo->FormValue;
		$this->Precio_lista_venta_mayoreo->CurrentValue = $this->Precio_lista_venta_mayoreo->FormValue;
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
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		if (array_key_exists('EV__COD_Marca_eq', $rs->fields)) {
			$this->COD_Marca_eq->VirtualValue = $rs->fields('EV__COD_Marca_eq'); // Set up virtual field value
		} else {
			$this->COD_Marca_eq->VirtualValue = ""; // Clear value
		}
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		if (array_key_exists('EV__COD_Modelo_eq', $rs->fields)) {
			$this->COD_Modelo_eq->VirtualValue = $rs->fields('EV__COD_Modelo_eq'); // Set up virtual field value
		} else {
			$this->COD_Modelo_eq->VirtualValue = ""; // Clear value
		}
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Precio_compra->setDbValue($rs->fields('Precio_compra'));
		$this->Descuento_Sin_Chip->setDbValue($rs->fields('Descuento_Sin_Chip'));
		$this->Precio_lista_venta_publico_1->setDbValue($rs->fields('Precio_lista_venta_publico_1'));
		$this->Precio_lista_venta_publico_2->setDbValue($rs->fields('Precio_lista_venta_publico_2'));
		$this->Precio_lista_venta_publico_3->setDbValue($rs->fields('Precio_lista_venta_publico_3'));
		$this->Precio_lista_venta_medio_mayoreo->setDbValue($rs->fields('Precio_lista_venta_medio_mayoreo'));
		$this->Precio_lista_venta_mayoreo->setDbValue($rs->fields('Precio_lista_venta_mayoreo'));
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

		// Convert decimal values if posted back
		if ($this->Precio_compra->FormValue == $this->Precio_compra->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_compra->CurrentValue)))
			$this->Precio_compra->CurrentValue = ew_StrToFloat($this->Precio_compra->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Descuento_Sin_Chip->FormValue == $this->Descuento_Sin_Chip->CurrentValue && is_numeric(ew_StrToFloat($this->Descuento_Sin_Chip->CurrentValue)))
			$this->Descuento_Sin_Chip->CurrentValue = ew_StrToFloat($this->Descuento_Sin_Chip->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_1->FormValue == $this->Precio_lista_venta_publico_1->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue)))
			$this->Precio_lista_venta_publico_1->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_2->FormValue == $this->Precio_lista_venta_publico_2->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue)))
			$this->Precio_lista_venta_publico_2->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_3->FormValue == $this->Precio_lista_venta_publico_3->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_3->CurrentValue)))
			$this->Precio_lista_venta_publico_3->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_3->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_medio_mayoreo->FormValue == $this->Precio_lista_venta_medio_mayoreo->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_medio_mayoreo->CurrentValue)))
			$this->Precio_lista_venta_medio_mayoreo->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_medio_mayoreo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_mayoreo->FormValue == $this->Precio_lista_venta_mayoreo->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_mayoreo->CurrentValue)))
			$this->Precio_lista_venta_mayoreo->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_mayoreo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Articulo
		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq
		// Articulo
		// Codigo
		// Precio_compra
		// Descuento_Sin_Chip
		// Precio_lista_venta_publico_1
		// Precio_lista_venta_publico_2
		// Precio_lista_venta_publico_3
		// Precio_lista_venta_medio_mayoreo
		// Precio_lista_venta_mayoreo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// COD_Marca_eq
			if ($this->COD_Marca_eq->VirtualValue <> "") {
				$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->VirtualValue;
			} else {
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->ViewValue = NULL;
			}
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			if ($this->COD_Modelo_eq->VirtualValue <> "") {
				$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->VirtualValue;
			} else {
			if (strval($this->COD_Modelo_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Modelo_eq`" . ew_SearchString("=", $this->COD_Modelo_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `COD_Modelo_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Modelo_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
				}
			} else {
				$this->COD_Modelo_eq->ViewValue = NULL;
			}
			}
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->ViewValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->ViewValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->ViewValue = NULL;
			}
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Codigo` Asc";
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

			// Precio_compra
			$this->Precio_compra->ViewValue = $this->Precio_compra->CurrentValue;
			$this->Precio_compra->ViewCustomAttributes = "";

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->ViewValue = $this->Descuento_Sin_Chip->CurrentValue;
			$this->Descuento_Sin_Chip->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->ViewValue = $this->Precio_lista_venta_publico_1->CurrentValue;
			$this->Precio_lista_venta_publico_1->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->ViewValue = $this->Precio_lista_venta_publico_2->CurrentValue;
			$this->Precio_lista_venta_publico_2->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->ViewValue = $this->Precio_lista_venta_publico_3->CurrentValue;
			$this->Precio_lista_venta_publico_3->ViewCustomAttributes = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->ViewValue = $this->Precio_lista_venta_medio_mayoreo->CurrentValue;
			$this->Precio_lista_venta_medio_mayoreo->ViewCustomAttributes = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->ViewValue = $this->Precio_lista_venta_mayoreo->CurrentValue;
			$this->Precio_lista_venta_mayoreo->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Precio_compra
			$this->Precio_compra->LinkCustomAttributes = "";
			$this->Precio_compra->HrefValue = "";
			$this->Precio_compra->TooltipValue = "";

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->LinkCustomAttributes = "";
			$this->Descuento_Sin_Chip->HrefValue = "";
			$this->Descuento_Sin_Chip->TooltipValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->HrefValue = "";
			$this->Precio_lista_venta_publico_1->TooltipValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->HrefValue = "";
			$this->Precio_lista_venta_publico_2->TooltipValue = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_3->HrefValue = "";
			$this->Precio_lista_venta_publico_3->TooltipValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_medio_mayoreo->TooltipValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_mayoreo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			if (trim(strval($this->COD_Marca_eq->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_eq->EditValue = $arwrk;

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			if (trim(strval($this->COD_Modelo_eq->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Modelo_eq`" . ew_SearchString("=", $this->COD_Modelo_eq->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `COD_Marca_eq` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `COD_Modelo_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Modelo_eq->EditValue = $arwrk;

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Compania_eq->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->EditValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->EditValue = NULL;
			}

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Codigo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Codigo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Codigo->EditValue = $this->Codigo->CurrentValue;
				}
			} else {
				$this->Codigo->EditValue = NULL;
			}

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->CurrentValue);
			if (strval($this->Precio_compra->EditValue) <> "" && is_numeric($this->Precio_compra->EditValue)) $this->Precio_compra->EditValue = ew_FormatNumber($this->Precio_compra->EditValue, -2, -1, -2, 0);

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->EditCustomAttributes = "";
			$this->Descuento_Sin_Chip->EditValue = ew_HtmlEncode($this->Descuento_Sin_Chip->CurrentValue);
			if (strval($this->Descuento_Sin_Chip->EditValue) <> "" && is_numeric($this->Descuento_Sin_Chip->EditValue)) $this->Descuento_Sin_Chip->EditValue = ew_FormatNumber($this->Descuento_Sin_Chip->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_1->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_1->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_1->EditValue)) $this->Precio_lista_venta_publico_1->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_1->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_2->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_2->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_2->EditValue)) $this->Precio_lista_venta_publico_2->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_2->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_3->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_3->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_3->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_3->EditValue)) $this->Precio_lista_venta_publico_3->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_3->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_medio_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_medio_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_medio_mayoreo->EditValue)) $this->Precio_lista_venta_medio_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_medio_mayoreo->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_mayoreo->EditValue)) $this->Precio_lista_venta_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_mayoreo->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// COD_Marca_eq

			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Precio_compra
			$this->Precio_compra->HrefValue = "";

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->HrefValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->HrefValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->HrefValue = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->HrefValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			if ($this->COD_Marca_eq->VirtualValue <> "") {
				$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->VirtualValue;
			} else {
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->EditValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->EditValue = NULL;
			}
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			if ($this->COD_Modelo_eq->VirtualValue <> "") {
				$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->VirtualValue;
			} else {
			if (strval($this->COD_Modelo_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Modelo_eq`" . ew_SearchString("=", $this->COD_Modelo_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `COD_Modelo_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Modelo_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Modelo_eq->EditValue = $this->COD_Modelo_eq->CurrentValue;
				}
			} else {
				$this->COD_Modelo_eq->EditValue = NULL;
			}
			}
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->EditValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->EditValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->EditValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->EditValue = NULL;
			}
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Codigo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Codigo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Codigo->EditValue = $this->Codigo->CurrentValue;
				}
			} else {
				$this->Codigo->EditValue = NULL;
			}
			$this->Codigo->ViewCustomAttributes = "";

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->CurrentValue);
			if (strval($this->Precio_compra->EditValue) <> "" && is_numeric($this->Precio_compra->EditValue)) $this->Precio_compra->EditValue = ew_FormatNumber($this->Precio_compra->EditValue, -2, -1, -2, 0);

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->EditCustomAttributes = "";
			$this->Descuento_Sin_Chip->EditValue = ew_HtmlEncode($this->Descuento_Sin_Chip->CurrentValue);
			if (strval($this->Descuento_Sin_Chip->EditValue) <> "" && is_numeric($this->Descuento_Sin_Chip->EditValue)) $this->Descuento_Sin_Chip->EditValue = ew_FormatNumber($this->Descuento_Sin_Chip->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_1->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_1->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_1->EditValue)) $this->Precio_lista_venta_publico_1->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_1->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_2->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_2->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_2->EditValue)) $this->Precio_lista_venta_publico_2->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_2->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_3->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_3->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_3->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_3->EditValue)) $this->Precio_lista_venta_publico_3->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_3->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_medio_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_medio_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_medio_mayoreo->EditValue)) $this->Precio_lista_venta_medio_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_medio_mayoreo->EditValue, -2, -1, -2, 0);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_mayoreo->EditValue)) $this->Precio_lista_venta_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_mayoreo->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// COD_Marca_eq

			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Precio_compra
			$this->Precio_compra->HrefValue = "";

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->HrefValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->HrefValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->HrefValue = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->HrefValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			if (trim(strval($this->COD_Marca_eq->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->AdvancedSearch->SearchValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_eq->EditValue = $arwrk;

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Compania_eq->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->AdvancedSearch->SearchValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->AdvancedSearch->SearchValue);

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->AdvancedSearch->SearchValue);

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->EditCustomAttributes = "";
			$this->Descuento_Sin_Chip->EditValue = ew_HtmlEncode($this->Descuento_Sin_Chip->AdvancedSearch->SearchValue);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_1->AdvancedSearch->SearchValue);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_2->AdvancedSearch->SearchValue);

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_3->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_3->AdvancedSearch->SearchValue);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->SearchValue);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_mayoreo->AdvancedSearch->SearchValue);
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
		if (!is_null($this->Precio_compra->FormValue) && $this->Precio_compra->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_compra->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_compra->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_compra->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Descuento_Sin_Chip->FormValue)) {
			ew_AddMessage($gsFormError, $this->Descuento_Sin_Chip->FldErrMsg());
		}
		if (!is_null($this->Precio_lista_venta_publico_1->FormValue) && $this->Precio_lista_venta_publico_1->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_lista_venta_publico_1->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_lista_venta_publico_1->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_lista_venta_publico_1->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Precio_lista_venta_publico_2->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_lista_venta_publico_2->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Precio_lista_venta_publico_3->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_lista_venta_publico_3->FldErrMsg());
		}
		if (!is_null($this->Precio_lista_venta_medio_mayoreo->FormValue) && $this->Precio_lista_venta_medio_mayoreo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_lista_venta_medio_mayoreo->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_lista_venta_medio_mayoreo->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_lista_venta_medio_mayoreo->FldErrMsg());
		}
		if (!is_null($this->Precio_lista_venta_mayoreo->FormValue) && $this->Precio_lista_venta_mayoreo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_lista_venta_mayoreo->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_lista_venta_mayoreo->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_lista_venta_mayoreo->FldErrMsg());
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

			// Precio_compra
			$this->Precio_compra->SetDbValueDef($rsnew, $this->Precio_compra->CurrentValue, 0, $this->Precio_compra->ReadOnly);

			// Descuento_Sin_Chip
			$this->Descuento_Sin_Chip->SetDbValueDef($rsnew, $this->Descuento_Sin_Chip->CurrentValue, NULL, $this->Descuento_Sin_Chip->ReadOnly);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_1->CurrentValue, 0, $this->Precio_lista_venta_publico_1->ReadOnly);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_2->CurrentValue, NULL, $this->Precio_lista_venta_publico_2->ReadOnly);

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_3->CurrentValue, NULL, $this->Precio_lista_venta_publico_3->ReadOnly);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_medio_mayoreo->CurrentValue, 0, $this->Precio_lista_venta_medio_mayoreo->ReadOnly);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_mayoreo->CurrentValue, 0, $this->Precio_lista_venta_mayoreo->ReadOnly);

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
		$rsnew = array();

		// COD_Marca_eq
		$this->COD_Marca_eq->SetDbValueDef($rsnew, $this->COD_Marca_eq->CurrentValue, NULL, FALSE);

		// COD_Modelo_eq
		$this->COD_Modelo_eq->SetDbValueDef($rsnew, $this->COD_Modelo_eq->CurrentValue, NULL, FALSE);

		// COD_Compania_eq
		$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, FALSE);

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Precio_compra
		$this->Precio_compra->SetDbValueDef($rsnew, $this->Precio_compra->CurrentValue, 0, strval($this->Precio_compra->CurrentValue) == "");

		// Descuento_Sin_Chip
		$this->Descuento_Sin_Chip->SetDbValueDef($rsnew, $this->Descuento_Sin_Chip->CurrentValue, NULL, strval($this->Descuento_Sin_Chip->CurrentValue) == "");

		// Precio_lista_venta_publico_1
		$this->Precio_lista_venta_publico_1->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_1->CurrentValue, 0, strval($this->Precio_lista_venta_publico_1->CurrentValue) == "");

		// Precio_lista_venta_publico_2
		$this->Precio_lista_venta_publico_2->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_2->CurrentValue, NULL, strval($this->Precio_lista_venta_publico_2->CurrentValue) == "");

		// Precio_lista_venta_publico_3
		$this->Precio_lista_venta_publico_3->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_3->CurrentValue, NULL, strval($this->Precio_lista_venta_publico_3->CurrentValue) == "");

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_medio_mayoreo->CurrentValue, 0, strval($this->Precio_lista_venta_medio_mayoreo->CurrentValue) == "");

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_mayoreo->CurrentValue, 0, strval($this->Precio_lista_venta_mayoreo->CurrentValue) == "");

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
		$this->COD_Marca_eq->AdvancedSearch->Load();
		$this->COD_Modelo_eq->AdvancedSearch->Load();
		$this->COD_Compania_eq->AdvancedSearch->Load();
		$this->Articulo->AdvancedSearch->Load();
		$this->Codigo->AdvancedSearch->Load();
		$this->Precio_compra->AdvancedSearch->Load();
		$this->Descuento_Sin_Chip->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_1->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_2->AdvancedSearch->Load();
		$this->Precio_lista_venta_publico_3->AdvancedSearch->Load();
		$this->Precio_lista_venta_medio_mayoreo->AdvancedSearch->Load();
		$this->Precio_lista_venta_mayoreo->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_lista_precios_equipos\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_lista_precios_equipos',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_lista_precios_equiposlist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_lista_precios_equipos_list)) $cap_lista_precios_equipos_list = new ccap_lista_precios_equipos_list();

// Page init
$cap_lista_precios_equipos_list->Page_Init();

// Page main
$cap_lista_precios_equipos_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_lista_precios_equipos->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_lista_precios_equipos_list = new ew_Page("cap_lista_precios_equipos_list");
cap_lista_precios_equipos_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_lista_precios_equipos_list.PageID; // For backward compatibility

// Form object
var fcap_lista_precios_equiposlist = new ew_Form("fcap_lista_precios_equiposlist");

// Validate form
fcap_lista_precios_equiposlist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_compra->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_compra->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Descuento_Sin_Chip"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Descuento_Sin_Chip->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_1"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_publico_1->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_1"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_publico_1->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_2"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_publico_2->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_3"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_publico_3->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_medio_mayoreo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_medio_mayoreo"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_mayoreo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_mayoreo"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_lista_precios_equiposlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_lista_precios_equiposlist.ValidateRequired = true;
<?php } else { ?>
fcap_lista_precios_equiposlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_lista_precios_equiposlist.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_lista_precios_equiposlist.Lists["x_COD_Modelo_eq"] = {"LinkField":"x_COD_Modelo_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_COD_Modelo_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_lista_precios_equiposlist.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_lista_precios_equiposlist.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_lista_precios_equiposlist.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_lista_precios_equiposlistsrch = new ew_Form("fcap_lista_precios_equiposlistsrch");

// Validate function for search
fcap_lista_precios_equiposlistsrch.Validate = function(fobj) {
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
fcap_lista_precios_equiposlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_lista_precios_equiposlistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_lista_precios_equiposlistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_lista_precios_equiposlistsrch.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_lista_precios_equiposlistsrch.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		$cap_lista_precios_equipos_list->TotalRecs = $cap_lista_precios_equipos->SelectRecordCount();
	} else {
		if ($cap_lista_precios_equipos_list->Recordset = $cap_lista_precios_equipos_list->LoadRecordset())
			$cap_lista_precios_equipos_list->TotalRecs = $cap_lista_precios_equipos_list->Recordset->RecordCount();
	}
	$cap_lista_precios_equipos_list->StartRec = 1;
	if ($cap_lista_precios_equipos_list->DisplayRecs <= 0 || ($cap_lista_precios_equipos->Export <> "" && $cap_lista_precios_equipos->ExportAll)) // Display all records
		$cap_lista_precios_equipos_list->DisplayRecs = $cap_lista_precios_equipos_list->TotalRecs;
	if (!($cap_lista_precios_equipos->Export <> "" && $cap_lista_precios_equipos->ExportAll))
		$cap_lista_precios_equipos_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_lista_precios_equipos_list->Recordset = $cap_lista_precios_equipos_list->LoadRecordset($cap_lista_precios_equipos_list->StartRec-1, $cap_lista_precios_equipos_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_lista_precios_equipos->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_lista_precios_equipos_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_lista_precios_equipos->Export == "" && $cap_lista_precios_equipos->CurrentAction == "") { ?>
<form name="fcap_lista_precios_equiposlistsrch" id="fcap_lista_precios_equiposlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_lista_precios_equiposlistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_lista_precios_equiposlistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_lista_precios_equiposlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_lista_precios_equipos">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_lista_precios_equipos_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_lista_precios_equipos->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_lista_precios_equipos->ResetAttrs();
$cap_lista_precios_equipos_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_lista_precios_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<span id="xsc_COD_Marca_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_lista_precios_equipos->COD_Marca_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Marca_eq" id="z_COD_Marca_eq" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Marca_eq" name="x_COD_Marca_eq"<?php echo $cap_lista_precios_equipos->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Marca_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
?>
<input type="hidden" name="s_x_COD_Marca_eq" id="s_x_COD_Marca_eq" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->COD_Marca_eq->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Marca_eq` = {filter_value}"); ?>&t0=200">
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_lista_precios_equipos->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<span id="xsc_COD_Compania_eq" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_lista_precios_equipos->COD_Compania_eq->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_COD_Compania_eq" id="z_COD_Compania_eq" value="="></span>
		<span class="ewSearchField">
<select id="x_COD_Compania_eq" name="x_COD_Compania_eq"<?php echo $cap_lista_precios_equipos->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Compania_eq->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_lista_precios_equiposlistsrch.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($cap_lista_precios_equipos->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($cap_lista_precios_equipos_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cap_lista_precios_equipos_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cap_lista_precios_equipos_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_lista_precios_equipos_list->ShowPageHeader(); ?>
<?php
$cap_lista_precios_equipos_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_lista_precios_equipos->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_lista_precios_equipos->CurrentAction <> "gridadd" && $cap_lista_precios_equipos->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_lista_precios_equipos_list->Pager)) $cap_lista_precios_equipos_list->Pager = new cNumericPager($cap_lista_precios_equipos_list->StartRec, $cap_lista_precios_equipos_list->DisplayRecs, $cap_lista_precios_equipos_list->TotalRecs, $cap_lista_precios_equipos_list->RecRange) ?>
<?php if ($cap_lista_precios_equipos_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_lista_precios_equipos_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_lista_precios_equipos_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_lista_precios_equipos">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_lista_precios_equipos->CurrentAction <> "gridadd" && $cap_lista_precios_equipos->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0 && $cap_lista_precios_equipos_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_lista_precios_equipos_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_lista_precios_equipos->CurrentAction == "gridedit") { ?>
<?php if ($cap_lista_precios_equipos->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_lista_precios_equiposlist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_lista_precios_equiposlist" id="fcap_lista_precios_equiposlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="cap_lista_precios_equipos">
<div id="gmp_cap_lista_precios_equipos" class="ewGridMiddlePanel">
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0) { ?>
<table id="tbl_cap_lista_precios_equiposlist" class="ewTable ewTableSeparate">
<?php echo $cap_lista_precios_equipos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_lista_precios_equipos_list->RenderListOptions();

// Render list options (header, left)
$cap_lista_precios_equipos_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_lista_precios_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Marca_eq) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_COD_Marca_eq" class="cap_lista_precios_equipos_COD_Marca_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->COD_Marca_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Marca_eq) ?>',2);"><span id="elh_cap_lista_precios_equipos_COD_Marca_eq" class="cap_lista_precios_equipos_COD_Marca_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->COD_Marca_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->COD_Marca_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->COD_Marca_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Modelo_eq) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_COD_Modelo_eq" class="cap_lista_precios_equipos_COD_Modelo_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->COD_Modelo_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Modelo_eq) ?>',2);"><span id="elh_cap_lista_precios_equipos_COD_Modelo_eq" class="cap_lista_precios_equipos_COD_Modelo_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->COD_Modelo_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->COD_Modelo_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->COD_Modelo_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Compania_eq) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_COD_Compania_eq" class="cap_lista_precios_equipos_COD_Compania_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->COD_Compania_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->COD_Compania_eq) ?>',2);"><span id="elh_cap_lista_precios_equipos_COD_Compania_eq" class="cap_lista_precios_equipos_COD_Compania_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->COD_Compania_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->COD_Compania_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->COD_Compania_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Articulo) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Articulo" class="cap_lista_precios_equipos_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Articulo) ?>',2);"><span id="elh_cap_lista_precios_equipos_Articulo" class="cap_lista_precios_equipos_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Articulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Codigo) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Codigo" class="cap_lista_precios_equipos_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Codigo) ?>',2);"><span id="elh_cap_lista_precios_equipos_Codigo" class="cap_lista_precios_equipos_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Codigo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_compra->Visible) { // Precio_compra ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_compra) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_compra" class="cap_lista_precios_equipos_Precio_compra"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_compra->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_compra) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_compra" class="cap_lista_precios_equipos_Precio_compra">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_compra->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_compra->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_compra->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Descuento_Sin_Chip->Visible) { // Descuento_Sin_Chip ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Descuento_Sin_Chip) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Descuento_Sin_Chip" class="cap_lista_precios_equipos_Descuento_Sin_Chip"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Descuento_Sin_Chip) ?>',2);"><span id="elh_cap_lista_precios_equipos_Descuento_Sin_Chip" class="cap_lista_precios_equipos_Descuento_Sin_Chip">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Descuento_Sin_Chip->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Descuento_Sin_Chip->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_1) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_1" class="cap_lista_precios_equipos_Precio_lista_venta_publico_1"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_1) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_1" class="cap_lista_precios_equipos_Precio_lista_venta_publico_1">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_1->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_lista_venta_publico_1->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_2) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_2" class="cap_lista_precios_equipos_Precio_lista_venta_publico_2"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_2) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_2" class="cap_lista_precios_equipos_Precio_lista_venta_publico_2">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_2->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_lista_venta_publico_2->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_3->Visible) { // Precio_lista_venta_publico_3 ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_3) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_3" class="cap_lista_precios_equipos_Precio_lista_venta_publico_3"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_publico_3) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_publico_3" class="cap_lista_precios_equipos_Precio_lista_venta_publico_3">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_3->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_lista_venta_publico_3->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
	<?php if ($cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_mayoreo) == "") { ?>
		<td><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_mayoreo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_lista_precios_equipos->SortUrl($cap_lista_precios_equipos->Precio_lista_venta_mayoreo) ?>',2);"><span id="elh_cap_lista_precios_equipos_Precio_lista_venta_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_mayoreo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_lista_precios_equipos_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_lista_precios_equipos->ExportAll && $cap_lista_precios_equipos->Export <> "") {
	$cap_lista_precios_equipos_list->StopRec = $cap_lista_precios_equipos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_lista_precios_equipos_list->TotalRecs > $cap_lista_precios_equipos_list->StartRec + $cap_lista_precios_equipos_list->DisplayRecs - 1)
		$cap_lista_precios_equipos_list->StopRec = $cap_lista_precios_equipos_list->StartRec + $cap_lista_precios_equipos_list->DisplayRecs - 1;
	else
		$cap_lista_precios_equipos_list->StopRec = $cap_lista_precios_equipos_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_lista_precios_equipos->CurrentAction == "gridadd" || $cap_lista_precios_equipos->CurrentAction == "gridedit" || $cap_lista_precios_equipos->CurrentAction == "F")) {
		$cap_lista_precios_equipos_list->KeyCount = $objForm->GetValue("key_count");
		$cap_lista_precios_equipos_list->StopRec = $cap_lista_precios_equipos_list->KeyCount;
	}
}
$cap_lista_precios_equipos_list->RecCnt = $cap_lista_precios_equipos_list->StartRec - 1;
if ($cap_lista_precios_equipos_list->Recordset && !$cap_lista_precios_equipos_list->Recordset->EOF) {
	$cap_lista_precios_equipos_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_lista_precios_equipos_list->StartRec > 1)
		$cap_lista_precios_equipos_list->Recordset->Move($cap_lista_precios_equipos_list->StartRec - 1);
} elseif (!$cap_lista_precios_equipos->AllowAddDeleteRow && $cap_lista_precios_equipos_list->StopRec == 0) {
	$cap_lista_precios_equipos_list->StopRec = $cap_lista_precios_equipos->GridAddRowCount;
}

// Initialize aggregate
$cap_lista_precios_equipos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_lista_precios_equipos->ResetAttrs();
$cap_lista_precios_equipos_list->RenderRow();
$cap_lista_precios_equipos_list->EditRowCnt = 0;
if ($cap_lista_precios_equipos->CurrentAction == "edit")
	$cap_lista_precios_equipos_list->RowIndex = 1;
if ($cap_lista_precios_equipos->CurrentAction == "gridedit")
	$cap_lista_precios_equipos_list->RowIndex = 0;
while ($cap_lista_precios_equipos_list->RecCnt < $cap_lista_precios_equipos_list->StopRec) {
	$cap_lista_precios_equipos_list->RecCnt++;
	if (intval($cap_lista_precios_equipos_list->RecCnt) >= intval($cap_lista_precios_equipos_list->StartRec)) {
		$cap_lista_precios_equipos_list->RowCnt++;
		if ($cap_lista_precios_equipos->CurrentAction == "gridadd" || $cap_lista_precios_equipos->CurrentAction == "gridedit" || $cap_lista_precios_equipos->CurrentAction == "F") {
			$cap_lista_precios_equipos_list->RowIndex++;
			$objForm->Index = $cap_lista_precios_equipos_list->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_lista_precios_equipos_list->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_lista_precios_equipos->CurrentAction == "gridadd")
				$cap_lista_precios_equipos_list->RowAction = "insert";
			else
				$cap_lista_precios_equipos_list->RowAction = "";
		}

		// Set up key count
		$cap_lista_precios_equipos_list->KeyCount = $cap_lista_precios_equipos_list->RowIndex;

		// Init row class and style
		$cap_lista_precios_equipos->ResetAttrs();
		$cap_lista_precios_equipos->CssClass = "";
		if ($cap_lista_precios_equipos->CurrentAction == "gridadd") {
			$cap_lista_precios_equipos_list->LoadDefaultValues(); // Load default values
		} else {
			$cap_lista_precios_equipos_list->LoadRowValues($cap_lista_precios_equipos_list->Recordset); // Load row values
		}
		$cap_lista_precios_equipos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_lista_precios_equipos->CurrentAction == "edit") {
			if ($cap_lista_precios_equipos_list->CheckInlineEditKey() && $cap_lista_precios_equipos_list->EditRowCnt == 0) { // Inline edit
				$cap_lista_precios_equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cap_lista_precios_equipos->CurrentAction == "gridedit") { // Grid edit
			if ($cap_lista_precios_equipos->EventCancelled) {
				$cap_lista_precios_equipos_list->RestoreCurrentRowFormValues($cap_lista_precios_equipos_list->RowIndex); // Restore form values
			}
			if ($cap_lista_precios_equipos_list->RowAction == "insert")
				$cap_lista_precios_equipos->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_lista_precios_equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_lista_precios_equipos->CurrentAction == "edit" && $cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT && $cap_lista_precios_equipos->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cap_lista_precios_equipos_list->RestoreFormValues(); // Restore form values
		}
		if ($cap_lista_precios_equipos->CurrentAction == "gridedit" && ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT || $cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) && $cap_lista_precios_equipos->EventCancelled) // Update failed
			$cap_lista_precios_equipos_list->RestoreCurrentRowFormValues($cap_lista_precios_equipos_list->RowIndex); // Restore form values
		if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_lista_precios_equipos_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cap_lista_precios_equipos->RowAttrs = array_merge($cap_lista_precios_equipos->RowAttrs, array('data-rowindex'=>$cap_lista_precios_equipos_list->RowCnt, 'id'=>'r' . $cap_lista_precios_equipos_list->RowCnt . '_cap_lista_precios_equipos', 'data-rowtype'=>$cap_lista_precios_equipos->RowType));

		// Render row
		$cap_lista_precios_equipos_list->RenderRow();

		// Render list options
		$cap_lista_precios_equipos_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_lista_precios_equipos_list->RowAction <> "delete" && $cap_lista_precios_equipos_list->RowAction <> "insertdelete" && !($cap_lista_precios_equipos_list->RowAction == "insert" && $cap_lista_precios_equipos->CurrentAction == "F" && $cap_lista_precios_equipos_list->EmptyRow())) {
?>
	<tr<?php echo $cap_lista_precios_equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_lista_precios_equipos_list->ListOptions->Render("body", "left", $cap_lista_precios_equipos_list->RowCnt);
?>
	<?php if ($cap_lista_precios_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<td<?php echo $cap_lista_precios_equipos->COD_Marca_eq->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_COD_Marca_eq" class="cap_lista_precios_equipos_COD_Marca_eq">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_lista_precios_equipos->COD_Marca_eq->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $cap_lista_precios_equipos_list->RowIndex . "_COD_Modelo_eq']); " . @$cap_lista_precios_equipos->COD_Marca_eq->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq"<?php echo $cap_lista_precios_equipos->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Marca_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->COD_Marca_eq->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Marca_eq` = {filter_value}"); ?>&t0=200">
<?php
$sSqlWrk = "SELECT `COD_Modelo_eq` AS FIELD0 FROM `aux_sel_equipos`";
$sWhereWrk = "(`COD_Marca_eq` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="sf_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="ln_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq">
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Marca_eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Marca_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Marca_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Marca_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Id_Articulo->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT || $cap_lista_precios_equipos->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Id_Articulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_lista_precios_equipos->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
		<td<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_COD_Modelo_eq" class="cap_lista_precios_equipos_COD_Modelo_eq">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq"<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Modelo_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Modelo_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Modelo_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "{filter}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `COD_Modelo_eq` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" id="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->COD_Modelo_eq->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Modelo_eq` = {filter_value}"); ?>&t0=200&f1=<?php echo TEAencrypt("`COD_Marca_eq` IN ({filter_value})"); ?>&t1=200">
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Modelo_eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Modelo_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
		<td<?php echo $cap_lista_precios_equipos->COD_Compania_eq->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_COD_Compania_eq" class="cap_lista_precios_equipos_COD_Compania_eq">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq"<?php echo $cap_lista_precios_equipos->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Compania_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_lista_precios_equiposlist.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($cap_lista_precios_equipos->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Compania_eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Compania_eq->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Compania_eq->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->COD_Compania_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_lista_precios_equipos->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Articulo" class="cap_lista_precios_equipos_Articulo">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php
	$wrkonchange = trim(" " . @$cap_lista_precios_equipos->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_lista_precios_equipos->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo $cap_lista_precios_equipos->Articulo->EditValue ?>" size="30" maxlength="100"<?php echo $cap_lista_precios_equipos->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" style="display: inline; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo $cap_lista_precios_equipos->Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Articulo`, `Articulo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo", fcap_lista_precios_equiposlist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcap_lista_precios_equiposlist.AutoSuggests["x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_lista_precios_equipos->Articulo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Articulo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_lista_precios_equipos->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Codigo" class="cap_lista_precios_equipos_Codigo">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php
	$wrkonchange = trim(" " . @$cap_lista_precios_equipos->Codigo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_lista_precios_equipos->Codigo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo $cap_lista_precios_equipos->Codigo->EditValue ?>" size="30" maxlength="15"<?php echo $cap_lista_precios_equipos->Codigo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" style="display: inline; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo $cap_lista_precios_equipos->Codigo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Codigo`, `Codigo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Codigo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Codigo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->Codigo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo", fcap_lista_precios_equiposlist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcap_lista_precios_equiposlist.AutoSuggests["x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Codigo->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_lista_precios_equipos->Codigo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Codigo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Codigo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Codigo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_compra->Visible) { // Precio_compra ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_compra->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_compra" class="cap_lista_precios_equipos_Precio_compra">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_compra->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_compra->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_compra->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_compra->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_compra->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_compra->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_compra->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Descuento_Sin_Chip->Visible) { // Descuento_Sin_Chip ?>
		<td<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Descuento_Sin_Chip" class="cap_lista_precios_equipos_Descuento_Sin_Chip">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" size="10" value="<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditValue ?>"<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Descuento_Sin_Chip->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" size="10" value="<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditValue ?>"<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_lista_venta_publico_1" class="cap_lista_precios_equipos_Precio_lista_venta_publico_1">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_1->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_lista_venta_publico_2" class="cap_lista_precios_equipos_Precio_lista_venta_publico_2">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_2->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_3->Visible) { // Precio_lista_venta_publico_3 ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_lista_venta_publico_3" class="cap_lista_precios_equipos_Precio_lista_venta_publico_3">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_3->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
		<td<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->CellAttributes() ?>><span id="el<?php echo $cap_lista_precios_equipos_list->RowCnt ?>_cap_lista_precios_equipos_Precio_lista_venta_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_mayoreo">
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->OldValue) ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->ViewAttributes() ?>>
<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $cap_lista_precios_equipos_list->PageObjName . "_row_" . $cap_lista_precios_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_lista_precios_equipos_list->ListOptions->Render("body", "right", $cap_lista_precios_equipos_list->RowCnt);
?>
	</tr>
<?php if ($cap_lista_precios_equipos->RowType == EW_ROWTYPE_ADD || $cap_lista_precios_equipos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_lista_precios_equiposlist.UpdateOpts(<?php echo $cap_lista_precios_equipos_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_lista_precios_equipos->CurrentAction <> "gridadd")
		if (!$cap_lista_precios_equipos_list->Recordset->EOF) $cap_lista_precios_equipos_list->Recordset->MoveNext();
}
?>
<?php
	if ($cap_lista_precios_equipos->CurrentAction == "gridadd" || $cap_lista_precios_equipos->CurrentAction == "gridedit") {
		$cap_lista_precios_equipos_list->RowIndex = '$rowindex$';
		$cap_lista_precios_equipos_list->LoadDefaultValues();

		// Set row properties
		$cap_lista_precios_equipos->ResetAttrs();
		$cap_lista_precios_equipos->RowAttrs = array_merge($cap_lista_precios_equipos->RowAttrs, array('data-rowindex'=>$cap_lista_precios_equipos_list->RowIndex, 'id'=>'r0_cap_lista_precios_equipos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_lista_precios_equipos->RowAttrs["class"], "ewTemplate");
		$cap_lista_precios_equipos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_lista_precios_equipos_list->RenderRow();

		// Render list options
		$cap_lista_precios_equipos_list->RenderListOptions();
		$cap_lista_precios_equipos_list->StartRowCnt = 0;
?>
	<tr<?php echo $cap_lista_precios_equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_lista_precios_equipos_list->ListOptions->Render("body", "left", $cap_lista_precios_equipos_list->RowIndex);
?>
	<?php if ($cap_lista_precios_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_COD_Marca_eq" class="cap_lista_precios_equipos_COD_Marca_eq">
<?php $cap_lista_precios_equipos->COD_Marca_eq->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $cap_lista_precios_equipos_list->RowIndex . "_COD_Modelo_eq']); " . @$cap_lista_precios_equipos->COD_Marca_eq->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq"<?php echo $cap_lista_precios_equipos->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Marca_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->COD_Marca_eq->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Marca_eq` = {filter_value}"); ?>&t0=200">
<?php
$sSqlWrk = "SELECT `COD_Modelo_eq` AS FIELD0 FROM `aux_sel_equipos`";
$sWhereWrk = "(`COD_Marca_eq` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="sf_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="ln_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq">
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Marca_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Marca_eq->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_COD_Modelo_eq" class="cap_lista_precios_equipos_COD_Modelo_eq">
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq"<?php echo $cap_lista_precios_equipos->COD_Modelo_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Modelo_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Modelo_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Modelo_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
$sWhereWrk = "{filter}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `COD_Modelo_eq` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" id="s_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->COD_Modelo_eq->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Modelo_eq` = {filter_value}"); ?>&t0=200&f1=<?php echo TEAencrypt("`COD_Marca_eq` IN ({filter_value})"); ?>&t1=200">
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Modelo_eq->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_COD_Compania_eq" class="cap_lista_precios_equipos_COD_Compania_eq">
<select id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq"<?php echo $cap_lista_precios_equipos->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) {
	$arwrk = $cap_lista_precios_equipos->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_lista_precios_equipos->COD_Compania_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_lista_precios_equiposlist.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($cap_lista_precios_equipos->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($cap_lista_precios_equipos->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_COD_Compania_eq" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->COD_Compania_eq->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Articulo->Visible) { // Articulo ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Articulo" class="cap_lista_precios_equipos_Articulo">
<?php
	$wrkonchange = trim(" " . @$cap_lista_precios_equipos->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_lista_precios_equipos->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo $cap_lista_precios_equipos->Articulo->EditValue ?>" size="30" maxlength="100"<?php echo $cap_lista_precios_equipos->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" style="display: inline; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo $cap_lista_precios_equipos->Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Articulo`, `Articulo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo", fcap_lista_precios_equiposlist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcap_lista_precios_equiposlist.AutoSuggests["x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Codigo->Visible) { // Codigo ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Codigo" class="cap_lista_precios_equipos_Codigo">
<?php
	$wrkonchange = trim(" " . @$cap_lista_precios_equipos->Codigo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$cap_lista_precios_equipos->Codigo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" style="white-space: nowrap; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="sv_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo $cap_lista_precios_equipos->Codigo->EditValue ?>" size="30" maxlength="15"<?php echo $cap_lista_precios_equipos->Codigo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" style="display: inline; z-index: <?php echo (9000 - $cap_lista_precios_equipos_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo $cap_lista_precios_equipos->Codigo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Codigo`, `Codigo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Codigo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Codigo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="q_x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_lista_precios_equipos->Codigo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo", fcap_lista_precios_equiposlist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcap_lista_precios_equiposlist.AutoSuggests["x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo"] = oas;
</script>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_compra->Visible) { // Precio_compra ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_compra" class="cap_lista_precios_equipos_Precio_compra">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_compra->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_compra->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_compra" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_compra->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Descuento_Sin_Chip->Visible) { // Descuento_Sin_Chip ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Descuento_Sin_Chip" class="cap_lista_precios_equipos_Descuento_Sin_Chip">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" size="10" value="<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditValue ?>"<?php echo $cap_lista_precios_equipos->Descuento_Sin_Chip->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Descuento_Sin_Chip" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Descuento_Sin_Chip->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_lista_venta_publico_1" class="cap_lista_precios_equipos_Precio_lista_venta_publico_1">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_1->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_1" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_1->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_lista_venta_publico_2" class="cap_lista_precios_equipos_Precio_lista_venta_publico_2">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_2->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_2" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_2->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_publico_3->Visible) { // Precio_lista_venta_publico_3 ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_lista_venta_publico_3" class="cap_lista_precios_equipos_Precio_lista_venta_publico_3">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_publico_3->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_publico_3" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_publico_3->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_medio_mayoreo">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_medio_mayoreo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
		<td><span id="el$rowindex$_cap_lista_precios_equipos_Precio_lista_venta_mayoreo" class="cap_lista_precios_equipos_Precio_lista_venta_mayoreo">
<input type="text" name="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="x<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" size="10" value="<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditValue ?>"<?php echo $cap_lista_precios_equipos->Precio_lista_venta_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="o<?php echo $cap_lista_precios_equipos_list->RowIndex ?>_Precio_lista_venta_mayoreo" value="<?php echo ew_HtmlEncode($cap_lista_precios_equipos->Precio_lista_venta_mayoreo->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_lista_precios_equipos_list->ListOptions->Render("body", "right", $cap_lista_precios_equipos_list->RowCnt);
?>
<script type="text/javascript">
fcap_lista_precios_equiposlist.UpdateOpts(<?php echo $cap_lista_precios_equipos_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_lista_precios_equipos->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_lista_precios_equipos_list->KeyCount ?>">
<?php } ?>
<?php if ($cap_lista_precios_equipos->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_lista_precios_equipos_list->KeyCount ?>">
<?php echo $cap_lista_precios_equipos_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_lista_precios_equipos->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_lista_precios_equipos_list->Recordset)
	$cap_lista_precios_equipos_list->Recordset->Close();
?>
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0) { ?>
<?php if ($cap_lista_precios_equipos->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_lista_precios_equipos->CurrentAction <> "gridadd" && $cap_lista_precios_equipos->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_lista_precios_equipos_list->Pager)) $cap_lista_precios_equipos_list->Pager = new cNumericPager($cap_lista_precios_equipos_list->StartRec, $cap_lista_precios_equipos_list->DisplayRecs, $cap_lista_precios_equipos_list->TotalRecs, $cap_lista_precios_equipos_list->RecRange) ?>
<?php if ($cap_lista_precios_equipos_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_lista_precios_equipos_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>start=<?php echo $cap_lista_precios_equipos_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_lista_precios_equipos_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_lista_precios_equipos_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_lista_precios_equipos_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_lista_precios_equipos">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_lista_precios_equipos_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cap_lista_precios_equipos->CurrentAction <> "gridadd" && $cap_lista_precios_equipos->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($cap_lista_precios_equipos_list->TotalRecs > 0 && $cap_lista_precios_equipos_list->GridEditUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_lista_precios_equipos_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cap_lista_precios_equipos->CurrentAction == "gridedit") { ?>
<?php if ($cap_lista_precios_equipos->AllowAddDeleteRow) { ?>
<?php if ($Security->CanAdd()) { ?>
<a class="ewGridLink" href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<a class="ewGridLink" href="" onclick="return ewForms['fcap_lista_precios_equiposlist'].Submit();"><img src='phpimages/update.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridSaveLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<a class="ewGridLink" href="<?php echo $cap_lista_precios_equipos_list->PageUrl() ?>a=cancel"><img src='phpimages/cancel.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("GridCancelLink")) ?>' width='16' height='16' style='border: 0;'></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_lista_precios_equipos->Export == "") { ?>
<script type="text/javascript">
fcap_lista_precios_equiposlistsrch.Init();
fcap_lista_precios_equiposlist.Init();
</script>
<?php } ?>
<?php
$cap_lista_precios_equipos_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_lista_precios_equipos->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_lista_precios_equipos_list->Page_Terminate();
?>
