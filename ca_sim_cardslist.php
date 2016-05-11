<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_sim_cardsinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_sim_cards_list = NULL; // Initialize page object first

class cca_sim_cards_list extends cca_sim_cards {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_sim_cards';

	// Page object name
	var $PageObjName = 'ca_sim_cards_list';

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

		// Table object (ca_sim_cards)
		if (!isset($GLOBALS["ca_sim_cards"])) {
			$GLOBALS["ca_sim_cards"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_sim_cards"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ca_sim_cardsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ca_sim_cardsdelete.php";
		$this->MultiUpdateUrl = "ca_sim_cardsupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_sim_cards', TRUE);

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
			$this->Id_Articulo->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Articulo->FormValue))
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
			$this->UpdateSort($this->Articulo, $bCtrl); // Articulo
			$this->UpdateSort($this->Codigo, $bCtrl); // Codigo
			$this->UpdateSort($this->COD_Compania_eq, $bCtrl); // COD_Compania_eq
			$this->UpdateSort($this->Amigo_CHIP, $bCtrl); // Amigo_CHIP
			$this->UpdateSort($this->Activacion_Movi, $bCtrl); // Activacion_Movi
			$this->UpdateSort($this->Precio_compra, $bCtrl); // Precio_compra
			$this->UpdateSort($this->Precio_lista_venta_publico_1, $bCtrl); // Precio_lista_venta_publico_1
			$this->UpdateSort($this->Precio_lista_venta_publico_2, $bCtrl); // Precio_lista_venta_publico_2
			$this->UpdateSort($this->Precio_lista_venta_medio_mayoreo, $bCtrl); // Precio_lista_venta_medio_mayoreo
			$this->UpdateSort($this->Precio_lista_venta_mayoreo, $bCtrl); // Precio_lista_venta_mayoreo
			$this->UpdateSort($this->Id_Almacen_Entrada, $bCtrl); // Id_Almacen_Entrada
			$this->UpdateSort($this->Status, $bCtrl); // Status
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Articulo->setSort("");
				$this->Codigo->setSort("");
				$this->COD_Compania_eq->setSort("");
				$this->Amigo_CHIP->setSort("");
				$this->Activacion_Movi->setSort("");
				$this->Precio_compra->setSort("");
				$this->Precio_lista_venta_publico_1->setSort("");
				$this->Precio_lista_venta_publico_2->setSort("");
				$this->Precio_lista_venta_medio_mayoreo->setSort("");
				$this->Precio_lista_venta_mayoreo->setSort("");
				$this->Id_Almacen_Entrada->setSort("");
				$this->Status->setSort("");
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
				"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fca_sim_cardslist'].Submit();\">" . "<img src=\"phpimages/insert.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("InsertLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
				"<a class=\"ewGridLink\" href=\"" . $this->PageUrl() . "a=cancel\">" . "<img src=\"phpimages/cancel.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CancelLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink\" href=\"\" onclick=\"return ewForms['fca_sim_cardslist'].Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . "<img src=\"phpimages/update.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("UpdateLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>&nbsp;" .
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
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->COD_Compania_eq->CurrentValue = NULL;
		$this->COD_Compania_eq->OldValue = $this->COD_Compania_eq->CurrentValue;
		$this->Amigo_CHIP->CurrentValue = "NO";
		$this->Activacion_Movi->CurrentValue = "NO";
		$this->Precio_compra->CurrentValue = 0.00;
		$this->Precio_lista_venta_publico_1->CurrentValue = 0.00;
		$this->Precio_lista_venta_publico_2->CurrentValue = 0.00;
		$this->Precio_lista_venta_medio_mayoreo->CurrentValue = 0.00;
		$this->Precio_lista_venta_mayoreo->CurrentValue = 0.00;
		$this->Id_Almacen_Entrada->CurrentValue = 2;
		$this->Status->CurrentValue = "Activo";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->COD_Compania_eq->FldIsDetailKey) {
			$this->COD_Compania_eq->setFormValue($objForm->GetValue("x_COD_Compania_eq"));
		}
		if (!$this->Amigo_CHIP->FldIsDetailKey) {
			$this->Amigo_CHIP->setFormValue($objForm->GetValue("x_Amigo_CHIP"));
		}
		if (!$this->Activacion_Movi->FldIsDetailKey) {
			$this->Activacion_Movi->setFormValue($objForm->GetValue("x_Activacion_Movi"));
		}
		if (!$this->Precio_compra->FldIsDetailKey) {
			$this->Precio_compra->setFormValue($objForm->GetValue("x_Precio_compra"));
		}
		if (!$this->Precio_lista_venta_publico_1->FldIsDetailKey) {
			$this->Precio_lista_venta_publico_1->setFormValue($objForm->GetValue("x_Precio_lista_venta_publico_1"));
		}
		if (!$this->Precio_lista_venta_publico_2->FldIsDetailKey) {
			$this->Precio_lista_venta_publico_2->setFormValue($objForm->GetValue("x_Precio_lista_venta_publico_2"));
		}
		if (!$this->Precio_lista_venta_medio_mayoreo->FldIsDetailKey) {
			$this->Precio_lista_venta_medio_mayoreo->setFormValue($objForm->GetValue("x_Precio_lista_venta_medio_mayoreo"));
		}
		if (!$this->Precio_lista_venta_mayoreo->FldIsDetailKey) {
			$this->Precio_lista_venta_mayoreo->setFormValue($objForm->GetValue("x_Precio_lista_venta_mayoreo"));
		}
		if (!$this->Id_Almacen_Entrada->FldIsDetailKey) {
			$this->Id_Almacen_Entrada->setFormValue($objForm->GetValue("x_Id_Almacen_Entrada"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->COD_Compania_eq->CurrentValue = $this->COD_Compania_eq->FormValue;
		$this->Amigo_CHIP->CurrentValue = $this->Amigo_CHIP->FormValue;
		$this->Activacion_Movi->CurrentValue = $this->Activacion_Movi->FormValue;
		$this->Precio_compra->CurrentValue = $this->Precio_compra->FormValue;
		$this->Precio_lista_venta_publico_1->CurrentValue = $this->Precio_lista_venta_publico_1->FormValue;
		$this->Precio_lista_venta_publico_2->CurrentValue = $this->Precio_lista_venta_publico_2->FormValue;
		$this->Precio_lista_venta_medio_mayoreo->CurrentValue = $this->Precio_lista_venta_medio_mayoreo->FormValue;
		$this->Precio_lista_venta_mayoreo->CurrentValue = $this->Precio_lista_venta_mayoreo->FormValue;
		$this->Id_Almacen_Entrada->CurrentValue = $this->Id_Almacen_Entrada->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
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
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Amigo_CHIP->setDbValue($rs->fields('Amigo_CHIP'));
		$this->Activacion_Movi->setDbValue($rs->fields('Activacion_Movi'));
		$this->Precio_compra->setDbValue($rs->fields('Precio_compra'));
		$this->Precio_lista_venta_publico_1->setDbValue($rs->fields('Precio_lista_venta_publico_1'));
		$this->Precio_lista_venta_publico_2->setDbValue($rs->fields('Precio_lista_venta_publico_2'));
		$this->Precio_lista_venta_publico_3->setDbValue($rs->fields('Precio_lista_venta_publico_3'));
		$this->Precio_lista_venta_medio_mayoreo->setDbValue($rs->fields('Precio_lista_venta_medio_mayoreo'));
		$this->Precio_lista_venta_mayoreo->setDbValue($rs->fields('Precio_lista_venta_mayoreo'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
		$this->Status->setDbValue($rs->fields('Status'));
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
		if ($this->Precio_lista_venta_publico_1->FormValue == $this->Precio_lista_venta_publico_1->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue)))
			$this->Precio_lista_venta_publico_1->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_2->FormValue == $this->Precio_lista_venta_publico_2->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue)))
			$this->Precio_lista_venta_publico_2->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue);

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
		// Articulo
		// Codigo
		// COD_Compania_eq
		// Amigo_CHIP
		// Activacion_Movi
		// Precio_compra
		// Precio_lista_venta_publico_1
		// Precio_lista_venta_publico_2
		// Precio_lista_venta_publico_3
		// Precio_lista_venta_medio_mayoreo
		// Precio_lista_venta_mayoreo
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// Id_Almacen_Entrada
		// Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

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

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Amigo_CHIP
			if (strval($this->Amigo_CHIP->CurrentValue) <> "") {
				switch ($this->Amigo_CHIP->CurrentValue) {
					case $this->Amigo_CHIP->FldTagValue(1):
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->FldTagCaption(1) <> "" ? $this->Amigo_CHIP->FldTagCaption(1) : $this->Amigo_CHIP->CurrentValue;
						break;
					case $this->Amigo_CHIP->FldTagValue(2):
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->FldTagCaption(2) <> "" ? $this->Amigo_CHIP->FldTagCaption(2) : $this->Amigo_CHIP->CurrentValue;
						break;
					default:
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->CurrentValue;
				}
			} else {
				$this->Amigo_CHIP->ViewValue = NULL;
			}
			$this->Amigo_CHIP->ViewCustomAttributes = "";

			// Activacion_Movi
			if (strval($this->Activacion_Movi->CurrentValue) <> "") {
				switch ($this->Activacion_Movi->CurrentValue) {
					case $this->Activacion_Movi->FldTagValue(1):
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->FldTagCaption(1) <> "" ? $this->Activacion_Movi->FldTagCaption(1) : $this->Activacion_Movi->CurrentValue;
						break;
					case $this->Activacion_Movi->FldTagValue(2):
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->FldTagCaption(2) <> "" ? $this->Activacion_Movi->FldTagCaption(2) : $this->Activacion_Movi->CurrentValue;
						break;
					default:
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->CurrentValue;
				}
			} else {
				$this->Activacion_Movi->ViewValue = NULL;
			}
			$this->Activacion_Movi->ViewCustomAttributes = "";

			// Precio_compra
			$this->Precio_compra->ViewValue = $this->Precio_compra->CurrentValue;
			$this->Precio_compra->ViewValue = ew_FormatCurrency($this->Precio_compra->ViewValue, 2, -2, -2, -2);
			$this->Precio_compra->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->ViewValue = $this->Precio_lista_venta_publico_1->CurrentValue;
			$this->Precio_lista_venta_publico_1->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_publico_1->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_publico_1->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->ViewValue = $this->Precio_lista_venta_publico_2->CurrentValue;
			$this->Precio_lista_venta_publico_2->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_publico_2->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_publico_2->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->ViewValue = $this->Precio_lista_venta_publico_3->CurrentValue;
			$this->Precio_lista_venta_publico_3->ViewCustomAttributes = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->ViewValue = $this->Precio_lista_venta_medio_mayoreo->CurrentValue;
			$this->Precio_lista_venta_medio_mayoreo->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_medio_mayoreo->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_medio_mayoreo->ViewCustomAttributes = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->ViewValue = $this->Precio_lista_venta_mayoreo->CurrentValue;
			$this->Precio_lista_venta_mayoreo->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_mayoreo->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_mayoreo->ViewCustomAttributes = "";

			// Id_Almacen_Entrada
			if (strval($this->Id_Almacen_Entrada->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrada->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
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

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";

			// Amigo_CHIP
			$this->Amigo_CHIP->LinkCustomAttributes = "";
			$this->Amigo_CHIP->HrefValue = "";
			$this->Amigo_CHIP->TooltipValue = "";

			// Activacion_Movi
			$this->Activacion_Movi->LinkCustomAttributes = "";
			$this->Activacion_Movi->HrefValue = "";
			$this->Activacion_Movi->TooltipValue = "";

			// Precio_compra
			$this->Precio_compra->LinkCustomAttributes = "";
			$this->Precio_compra->HrefValue = "";
			$this->Precio_compra->TooltipValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->HrefValue = "";
			$this->Precio_lista_venta_publico_1->TooltipValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->HrefValue = "";
			$this->Precio_lista_venta_publico_2->TooltipValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_medio_mayoreo->TooltipValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_mayoreo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Articulo
			$this->Articulo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
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
			$this->Codigo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
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

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
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
			$this->COD_Compania_eq->EditValue = $arwrk;

			// Amigo_CHIP
			$this->Amigo_CHIP->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Amigo_CHIP->FldTagValue(1), $this->Amigo_CHIP->FldTagCaption(1) <> "" ? $this->Amigo_CHIP->FldTagCaption(1) : $this->Amigo_CHIP->FldTagValue(1));
			$arwrk[] = array($this->Amigo_CHIP->FldTagValue(2), $this->Amigo_CHIP->FldTagCaption(2) <> "" ? $this->Amigo_CHIP->FldTagCaption(2) : $this->Amigo_CHIP->FldTagValue(2));
			$this->Amigo_CHIP->EditValue = $arwrk;

			// Activacion_Movi
			$this->Activacion_Movi->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Activacion_Movi->FldTagValue(1), $this->Activacion_Movi->FldTagCaption(1) <> "" ? $this->Activacion_Movi->FldTagCaption(1) : $this->Activacion_Movi->FldTagValue(1));
			$arwrk[] = array($this->Activacion_Movi->FldTagValue(2), $this->Activacion_Movi->FldTagCaption(2) <> "" ? $this->Activacion_Movi->FldTagCaption(2) : $this->Activacion_Movi->FldTagValue(2));
			$this->Activacion_Movi->EditValue = $arwrk;

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->CurrentValue);
			if (strval($this->Precio_compra->EditValue) <> "" && is_numeric($this->Precio_compra->EditValue)) $this->Precio_compra->EditValue = ew_FormatNumber($this->Precio_compra->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_1->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_1->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_1->EditValue)) $this->Precio_lista_venta_publico_1->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_1->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_2->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_2->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_2->EditValue)) $this->Precio_lista_venta_publico_2->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_2->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_medio_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_medio_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_medio_mayoreo->EditValue)) $this->Precio_lista_venta_medio_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_medio_mayoreo->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_mayoreo->EditValue)) $this->Precio_lista_venta_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_mayoreo->EditValue, -2, -2, -2, -2);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Edit refer script
			// Articulo

			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Amigo_CHIP
			$this->Amigo_CHIP->HrefValue = "";

			// Activacion_Movi
			$this->Activacion_Movi->HrefValue = "";

			// Precio_compra
			$this->Precio_compra->HrefValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->HrefValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->HrefValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->HrefValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Articulo
			$this->Articulo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
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
			$this->Codigo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
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

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
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
			$this->COD_Compania_eq->EditValue = $arwrk;

			// Amigo_CHIP
			$this->Amigo_CHIP->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Amigo_CHIP->FldTagValue(1), $this->Amigo_CHIP->FldTagCaption(1) <> "" ? $this->Amigo_CHIP->FldTagCaption(1) : $this->Amigo_CHIP->FldTagValue(1));
			$arwrk[] = array($this->Amigo_CHIP->FldTagValue(2), $this->Amigo_CHIP->FldTagCaption(2) <> "" ? $this->Amigo_CHIP->FldTagCaption(2) : $this->Amigo_CHIP->FldTagValue(2));
			$this->Amigo_CHIP->EditValue = $arwrk;

			// Activacion_Movi
			$this->Activacion_Movi->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Activacion_Movi->FldTagValue(1), $this->Activacion_Movi->FldTagCaption(1) <> "" ? $this->Activacion_Movi->FldTagCaption(1) : $this->Activacion_Movi->FldTagValue(1));
			$arwrk[] = array($this->Activacion_Movi->FldTagValue(2), $this->Activacion_Movi->FldTagCaption(2) <> "" ? $this->Activacion_Movi->FldTagCaption(2) : $this->Activacion_Movi->FldTagValue(2));
			$this->Activacion_Movi->EditValue = $arwrk;

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->CurrentValue);
			if (strval($this->Precio_compra->EditValue) <> "" && is_numeric($this->Precio_compra->EditValue)) $this->Precio_compra->EditValue = ew_FormatNumber($this->Precio_compra->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_1->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_1->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_1->EditValue)) $this->Precio_lista_venta_publico_1->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_1->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->EditCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->EditValue = ew_HtmlEncode($this->Precio_lista_venta_publico_2->CurrentValue);
			if (strval($this->Precio_lista_venta_publico_2->EditValue) <> "" && is_numeric($this->Precio_lista_venta_publico_2->EditValue)) $this->Precio_lista_venta_publico_2->EditValue = ew_FormatNumber($this->Precio_lista_venta_publico_2->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_medio_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_medio_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_medio_mayoreo->EditValue)) $this->Precio_lista_venta_medio_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_medio_mayoreo->EditValue, -2, -2, -2, -2);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->EditCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->EditValue = ew_HtmlEncode($this->Precio_lista_venta_mayoreo->CurrentValue);
			if (strval($this->Precio_lista_venta_mayoreo->EditValue) <> "" && is_numeric($this->Precio_lista_venta_mayoreo->EditValue)) $this->Precio_lista_venta_mayoreo->EditValue = ew_FormatNumber($this->Precio_lista_venta_mayoreo->EditValue, -2, -2, -2, -2);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Edit refer script
			// Articulo

			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Amigo_CHIP
			$this->Amigo_CHIP->HrefValue = "";

			// Activacion_Movi
			$this->Activacion_Movi->HrefValue = "";

			// Precio_compra
			$this->Precio_compra->HrefValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->HrefValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->HrefValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->HrefValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";
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
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
		}
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
		}
		if (!is_null($this->Precio_compra->FormValue) && $this->Precio_compra->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_compra->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_compra->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_compra->FldErrMsg());
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

			// Articulo
			$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", $this->Articulo->ReadOnly);

			// Codigo
			$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, $this->Codigo->ReadOnly);

			// COD_Compania_eq
			$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, $this->COD_Compania_eq->ReadOnly);

			// Amigo_CHIP
			$this->Amigo_CHIP->SetDbValueDef($rsnew, $this->Amigo_CHIP->CurrentValue, NULL, $this->Amigo_CHIP->ReadOnly);

			// Activacion_Movi
			$this->Activacion_Movi->SetDbValueDef($rsnew, $this->Activacion_Movi->CurrentValue, NULL, $this->Activacion_Movi->ReadOnly);

			// Precio_compra
			$this->Precio_compra->SetDbValueDef($rsnew, $this->Precio_compra->CurrentValue, 0, $this->Precio_compra->ReadOnly);

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_1->CurrentValue, 0, $this->Precio_lista_venta_publico_1->ReadOnly);

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_2->CurrentValue, NULL, $this->Precio_lista_venta_publico_2->ReadOnly);

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_medio_mayoreo->CurrentValue, 0, $this->Precio_lista_venta_medio_mayoreo->ReadOnly);

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_mayoreo->CurrentValue, 0, $this->Precio_lista_venta_mayoreo->ReadOnly);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, $this->Id_Almacen_Entrada->ReadOnly);

			// Status
			$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, NULL, $this->Status->ReadOnly);

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

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// COD_Compania_eq
		$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, FALSE);

		// Amigo_CHIP
		$this->Amigo_CHIP->SetDbValueDef($rsnew, $this->Amigo_CHIP->CurrentValue, NULL, FALSE);

		// Activacion_Movi
		$this->Activacion_Movi->SetDbValueDef($rsnew, $this->Activacion_Movi->CurrentValue, NULL, FALSE);

		// Precio_compra
		$this->Precio_compra->SetDbValueDef($rsnew, $this->Precio_compra->CurrentValue, 0, strval($this->Precio_compra->CurrentValue) == "");

		// Precio_lista_venta_publico_1
		$this->Precio_lista_venta_publico_1->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_1->CurrentValue, 0, strval($this->Precio_lista_venta_publico_1->CurrentValue) == "");

		// Precio_lista_venta_publico_2
		$this->Precio_lista_venta_publico_2->SetDbValueDef($rsnew, $this->Precio_lista_venta_publico_2->CurrentValue, NULL, strval($this->Precio_lista_venta_publico_2->CurrentValue) == "");

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_medio_mayoreo->CurrentValue, 0, strval($this->Precio_lista_venta_medio_mayoreo->CurrentValue) == "");

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo->SetDbValueDef($rsnew, $this->Precio_lista_venta_mayoreo->CurrentValue, 0, strval($this->Precio_lista_venta_mayoreo->CurrentValue) == "");

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, strval($this->Id_Almacen_Entrada->CurrentValue) == "");

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, NULL, strval($this->Status->CurrentValue) == "");

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
		$item->Body = "<a id=\"emf_ca_sim_cards\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_ca_sim_cards',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fca_sim_cardslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($ca_sim_cards_list)) $ca_sim_cards_list = new cca_sim_cards_list();

// Page init
$ca_sim_cards_list->Page_Init();

// Page main
$ca_sim_cards_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ca_sim_cards->Export == "") { ?>
<script type="text/javascript">

// Page object
var ca_sim_cards_list = new ew_Page("ca_sim_cards_list");
ca_sim_cards_list.PageID = "list"; // Page ID
var EW_PAGE_ID = ca_sim_cards_list.PageID; // For backward compatibility

// Form object
var fca_sim_cardslist = new ew_Form("fca_sim_cardslist");

// Validate form
fca_sim_cardslist.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Precio_compra->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_sim_cards->Precio_compra->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_1"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_publico_1->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_1"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_publico_1->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_publico_2"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_publico_2->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_medio_mayoreo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_medio_mayoreo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_medio_mayoreo"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_medio_mayoreo->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_mayoreo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_mayoreo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_lista_venta_mayoreo"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_sim_cards->Precio_lista_venta_mayoreo->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Almacen_Entrada"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_sim_cards->Id_Almacen_Entrada->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fca_sim_cardslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_sim_cardslist.ValidateRequired = true;
<?php } else { ?>
fca_sim_cardslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_sim_cardslist.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardslist.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardslist.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardslist.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
		$ca_sim_cards_list->TotalRecs = $ca_sim_cards->SelectRecordCount();
	} else {
		if ($ca_sim_cards_list->Recordset = $ca_sim_cards_list->LoadRecordset())
			$ca_sim_cards_list->TotalRecs = $ca_sim_cards_list->Recordset->RecordCount();
	}
	$ca_sim_cards_list->StartRec = 1;
	if ($ca_sim_cards_list->DisplayRecs <= 0 || ($ca_sim_cards->Export <> "" && $ca_sim_cards->ExportAll)) // Display all records
		$ca_sim_cards_list->DisplayRecs = $ca_sim_cards_list->TotalRecs;
	if (!($ca_sim_cards->Export <> "" && $ca_sim_cards->ExportAll))
		$ca_sim_cards_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ca_sim_cards_list->Recordset = $ca_sim_cards_list->LoadRecordset($ca_sim_cards_list->StartRec-1, $ca_sim_cards_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $ca_sim_cards->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $ca_sim_cards_list->ExportOptions->Render("body"); ?>
</p>
<?php $ca_sim_cards_list->ShowPageHeader(); ?>
<?php
$ca_sim_cards_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($ca_sim_cards->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($ca_sim_cards->CurrentAction <> "gridadd" && $ca_sim_cards->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_sim_cards_list->Pager)) $ca_sim_cards_list->Pager = new cNumericPager($ca_sim_cards_list->StartRec, $ca_sim_cards_list->DisplayRecs, $ca_sim_cards_list->TotalRecs, $ca_sim_cards_list->RecRange) ?>
<?php if ($ca_sim_cards_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_sim_cards_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_sim_cards_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_sim_cards_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_sim_cards_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_sim_cards">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_sim_cards_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_sim_cards_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_sim_cards_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_sim_cards_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_sim_cards_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($ca_sim_cards_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_sim_cards_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_sim_cards_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fca_sim_cardslist" id="fca_sim_cardslist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="ca_sim_cards">
<div id="gmp_ca_sim_cards" class="ewGridMiddlePanel">
<?php if ($ca_sim_cards_list->TotalRecs > 0 || $ca_sim_cards->CurrentAction == "add" || $ca_sim_cards->CurrentAction == "copy") { ?>
<table id="tbl_ca_sim_cardslist" class="ewTable ewTableSeparate">
<?php echo $ca_sim_cards->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ca_sim_cards_list->RenderListOptions();

// Render list options (header, left)
$ca_sim_cards_list->ListOptions->Render("header", "left");
?>
<?php if ($ca_sim_cards->Articulo->Visible) { // Articulo ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Articulo) == "") { ?>
		<td><span id="elh_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Articulo) ?>',2);"><span id="elh_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Codigo->Visible) { // Codigo ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Codigo) == "") { ?>
		<td><span id="elh_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Codigo) ?>',2);"><span id="elh_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->COD_Compania_eq) == "") { ?>
		<td><span id="elh_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->COD_Compania_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->COD_Compania_eq) ?>',2);"><span id="elh_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->COD_Compania_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->COD_Compania_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->COD_Compania_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Amigo_CHIP->Visible) { // Amigo_CHIP ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Amigo_CHIP) == "") { ?>
		<td><span id="elh_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Amigo_CHIP->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Amigo_CHIP) ?>',2);"><span id="elh_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Amigo_CHIP->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Amigo_CHIP->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Amigo_CHIP->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Activacion_Movi->Visible) { // Activacion_Movi ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Activacion_Movi) == "") { ?>
		<td><span id="elh_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Activacion_Movi->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Activacion_Movi) ?>',2);"><span id="elh_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Activacion_Movi->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Activacion_Movi->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Activacion_Movi->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Precio_compra->Visible) { // Precio_compra ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Precio_compra) == "") { ?>
		<td><span id="elh_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Precio_compra->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Precio_compra) ?>',2);"><span id="elh_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Precio_compra->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Precio_compra->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Precio_compra->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_publico_1) == "") { ?>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_publico_1->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_publico_1) ?>',2);"><span id="elh_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Precio_lista_venta_publico_1->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Precio_lista_venta_publico_1->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Precio_lista_venta_publico_1->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_publico_2) == "") { ?>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_publico_2->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_publico_2) ?>',2);"><span id="elh_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Precio_lista_venta_publico_2->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Precio_lista_venta_publico_2->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Precio_lista_venta_publico_2->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_medio_mayoreo) == "") { ?>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_medio_mayoreo) ?>',2);"><span id="elh_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Precio_lista_venta_medio_mayoreo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Precio_lista_venta_medio_mayoreo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_mayoreo) == "") { ?>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Precio_lista_venta_mayoreo) ?>',2);"><span id="elh_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Precio_lista_venta_mayoreo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Precio_lista_venta_mayoreo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Id_Almacen_Entrada) == "") { ?>
		<td><span id="elh_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Id_Almacen_Entrada->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Id_Almacen_Entrada) ?>',2);"><span id="elh_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Id_Almacen_Entrada->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Id_Almacen_Entrada->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Id_Almacen_Entrada->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_sim_cards->Status->Visible) { // Status ?>
	<?php if ($ca_sim_cards->SortUrl($ca_sim_cards->Status) == "") { ?>
		<td><span id="elh_ca_sim_cards_Status" class="ca_sim_cards_Status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_sim_cards->Status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_sim_cards->SortUrl($ca_sim_cards->Status) ?>',2);"><span id="elh_ca_sim_cards_Status" class="ca_sim_cards_Status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_sim_cards->Status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_sim_cards->Status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_sim_cards->Status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ca_sim_cards_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($ca_sim_cards->CurrentAction == "add" || $ca_sim_cards->CurrentAction == "copy") {
		$ca_sim_cards_list->RowIndex = 0;
		$ca_sim_cards_list->KeyCount = $ca_sim_cards_list->RowIndex;
		if ($ca_sim_cards->CurrentAction == "add")
			$ca_sim_cards_list->LoadDefaultValues();
		if ($ca_sim_cards->EventCancelled) // Insert failed
			$ca_sim_cards_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$ca_sim_cards->ResetAttrs();
		$ca_sim_cards->RowAttrs = array_merge($ca_sim_cards->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_ca_sim_cards', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$ca_sim_cards->RowType = EW_ROWTYPE_ADD;

		// Render row
		$ca_sim_cards_list->RenderRow();

		// Render list options
		$ca_sim_cards_list->RenderListOptions();
		$ca_sim_cards_list->StartRowCnt = 0;
?>
	<tr<?php echo $ca_sim_cards->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_sim_cards_list->ListOptions->Render("body", "left", $ca_sim_cards_list->RowCnt);
?>
	<?php if ($ca_sim_cards->Articulo->Visible) { // Articulo ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo">
<?php
	$wrkonchange = trim(" " . @$ca_sim_cards->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$ca_sim_cards->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="<?php echo $ca_sim_cards->Articulo->EditValue ?>" size="30" maxlength="100"<?php echo $ca_sim_cards->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" style="display: inline; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="<?php echo $ca_sim_cards->Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Articulo`, `Articulo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($ca_sim_cards->Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo", fca_sim_cardslist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fca_sim_cardslist.AutoSuggests["x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo"] = oas;
</script>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($ca_sim_cards->Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Codigo->Visible) { // Codigo ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo">
<?php
	$wrkonchange = trim(" " . @$ca_sim_cards->Codigo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$ca_sim_cards->Codigo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" style="white-space: nowrap; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="<?php echo $ca_sim_cards->Codigo->EditValue ?>" size="11" maxlength="10"<?php echo $ca_sim_cards->Codigo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" style="display: inline; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="<?php echo $ca_sim_cards->Codigo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Codigo`, `Codigo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Codigo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Codigo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($ca_sim_cards->Codigo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo", fca_sim_cardslist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fca_sim_cardslist.AutoSuggests["x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo"] = oas;
</script>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($ca_sim_cards->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq">
<select id="x<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq"<?php echo $ca_sim_cards->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($ca_sim_cards->COD_Compania_eq->EditValue)) {
	$arwrk = $ca_sim_cards->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->COD_Compania_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_sim_cardslist.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($ca_sim_cards->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($ca_sim_cards->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq" value="<?php echo ew_HtmlEncode($ca_sim_cards->COD_Compania_eq->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Amigo_CHIP->Visible) { // Amigo_CHIP ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP">
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" value="{value}"<?php echo $ca_sim_cards->Amigo_CHIP->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Amigo_CHIP->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Amigo_CHIP->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Amigo_CHIP->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" value="<?php echo ew_HtmlEncode($ca_sim_cards->Amigo_CHIP->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Activacion_Movi->Visible) { // Activacion_Movi ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi">
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" value="{value}"<?php echo $ca_sim_cards->Activacion_Movi->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Activacion_Movi->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Activacion_Movi->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Activacion_Movi->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" value="<?php echo ew_HtmlEncode($ca_sim_cards->Activacion_Movi->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_compra->Visible) { // Precio_compra ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra">
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" size="10" value="<?php echo $ca_sim_cards->Precio_compra->EditValue ?>"<?php echo $ca_sim_cards->Precio_compra->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" value="<?php echo ew_HtmlEncode($ca_sim_cards->Precio_compra->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1">
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" value="<?php echo ew_HtmlEncode($ca_sim_cards->Precio_lista_venta_publico_1->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2">
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" value="<?php echo ew_HtmlEncode($ca_sim_cards->Precio_lista_venta_publico_2->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo">
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" value="<?php echo ew_HtmlEncode($ca_sim_cards->Precio_lista_venta_medio_mayoreo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo">
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" value="<?php echo ew_HtmlEncode($ca_sim_cards->Precio_lista_venta_mayoreo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada">
<select id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada"<?php echo $ca_sim_cards->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($ca_sim_cards->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $ca_sim_cards->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_sim_cardslist.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($ca_sim_cards->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($ca_sim_cards->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada" value="<?php echo ew_HtmlEncode($ca_sim_cards->Id_Almacen_Entrada->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Status->Visible) { // Status ?>
		<td><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Status" class="ca_sim_cards_Status">
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" value="{value}"<?php echo $ca_sim_cards->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<input type="hidden" name="o<?php echo $ca_sim_cards_list->RowIndex ?>_Status" id="o<?php echo $ca_sim_cards_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($ca_sim_cards->Status->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_sim_cards_list->ListOptions->Render("body", "right", $ca_sim_cards_list->RowCnt);
?>
<script type="text/javascript">
fca_sim_cardslist.UpdateOpts(<?php echo $ca_sim_cards_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($ca_sim_cards->ExportAll && $ca_sim_cards->Export <> "") {
	$ca_sim_cards_list->StopRec = $ca_sim_cards_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ca_sim_cards_list->TotalRecs > $ca_sim_cards_list->StartRec + $ca_sim_cards_list->DisplayRecs - 1)
		$ca_sim_cards_list->StopRec = $ca_sim_cards_list->StartRec + $ca_sim_cards_list->DisplayRecs - 1;
	else
		$ca_sim_cards_list->StopRec = $ca_sim_cards_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($ca_sim_cards->CurrentAction == "gridadd" || $ca_sim_cards->CurrentAction == "gridedit" || $ca_sim_cards->CurrentAction == "F")) {
		$ca_sim_cards_list->KeyCount = $objForm->GetValue("key_count");
		$ca_sim_cards_list->StopRec = $ca_sim_cards_list->KeyCount;
	}
}
$ca_sim_cards_list->RecCnt = $ca_sim_cards_list->StartRec - 1;
if ($ca_sim_cards_list->Recordset && !$ca_sim_cards_list->Recordset->EOF) {
	$ca_sim_cards_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ca_sim_cards_list->StartRec > 1)
		$ca_sim_cards_list->Recordset->Move($ca_sim_cards_list->StartRec - 1);
} elseif (!$ca_sim_cards->AllowAddDeleteRow && $ca_sim_cards_list->StopRec == 0) {
	$ca_sim_cards_list->StopRec = $ca_sim_cards->GridAddRowCount;
}

// Initialize aggregate
$ca_sim_cards->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ca_sim_cards->ResetAttrs();
$ca_sim_cards_list->RenderRow();
$ca_sim_cards_list->EditRowCnt = 0;
if ($ca_sim_cards->CurrentAction == "edit")
	$ca_sim_cards_list->RowIndex = 1;
while ($ca_sim_cards_list->RecCnt < $ca_sim_cards_list->StopRec) {
	$ca_sim_cards_list->RecCnt++;
	if (intval($ca_sim_cards_list->RecCnt) >= intval($ca_sim_cards_list->StartRec)) {
		$ca_sim_cards_list->RowCnt++;

		// Set up key count
		$ca_sim_cards_list->KeyCount = $ca_sim_cards_list->RowIndex;

		// Init row class and style
		$ca_sim_cards->ResetAttrs();
		$ca_sim_cards->CssClass = "";
		if ($ca_sim_cards->CurrentAction == "gridadd") {
			$ca_sim_cards_list->LoadDefaultValues(); // Load default values
		} else {
			$ca_sim_cards_list->LoadRowValues($ca_sim_cards_list->Recordset); // Load row values
		}
		$ca_sim_cards->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($ca_sim_cards->CurrentAction == "edit") {
			if ($ca_sim_cards_list->CheckInlineEditKey() && $ca_sim_cards_list->EditRowCnt == 0) { // Inline edit
				$ca_sim_cards->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($ca_sim_cards->CurrentAction == "edit" && $ca_sim_cards->RowType == EW_ROWTYPE_EDIT && $ca_sim_cards->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$ca_sim_cards_list->RestoreFormValues(); // Restore form values
		}
		if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) // Edit row
			$ca_sim_cards_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$ca_sim_cards->RowAttrs = array_merge($ca_sim_cards->RowAttrs, array('data-rowindex'=>$ca_sim_cards_list->RowCnt, 'id'=>'r' . $ca_sim_cards_list->RowCnt . '_ca_sim_cards', 'data-rowtype'=>$ca_sim_cards->RowType));

		// Render row
		$ca_sim_cards_list->RenderRow();

		// Render list options
		$ca_sim_cards_list->RenderListOptions();
?>
	<tr<?php echo $ca_sim_cards->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_sim_cards_list->ListOptions->Render("body", "left", $ca_sim_cards_list->RowCnt);
?>
	<?php if ($ca_sim_cards->Articulo->Visible) { // Articulo ?>
		<td<?php echo $ca_sim_cards->Articulo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php
	$wrkonchange = trim(" " . @$ca_sim_cards->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$ca_sim_cards->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" style="white-space: nowrap; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="<?php echo $ca_sim_cards->Articulo->EditValue ?>" size="30" maxlength="100"<?php echo $ca_sim_cards->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" style="display: inline; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="<?php echo $ca_sim_cards->Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Articulo`, `Articulo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" id="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($ca_sim_cards->Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo", fca_sim_cardslist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fca_sim_cardslist.AutoSuggests["x<?php echo $ca_sim_cards_list->RowIndex ?>_Articulo"] = oas;
</script>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Articulo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Articulo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT || $ca_sim_cards->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Articulo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($ca_sim_cards->Id_Articulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($ca_sim_cards->Codigo->Visible) { // Codigo ?>
		<td<?php echo $ca_sim_cards->Codigo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php
	$wrkonchange = trim(" " . @$ca_sim_cards->Codigo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$ca_sim_cards->Codigo->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" style="white-space: nowrap; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="sv_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="<?php echo $ca_sim_cards->Codigo->EditValue ?>" size="11" maxlength="10"<?php echo $ca_sim_cards->Codigo->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" style="display: inline; z-index: <?php echo (9000 - $ca_sim_cards_list->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="<?php echo $ca_sim_cards->Codigo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Codigo`, `Codigo` FROM `cap_lista_precios_equipos`";
$sWhereWrk = "`Codigo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Codigo` Asc";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" id="q_x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($ca_sim_cards->Codigo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo", fca_sim_cardslist, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fca_sim_cardslist.AutoSuggests["x<?php echo $ca_sim_cards_list->RowIndex ?>_Codigo"] = oas;
</script>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Codigo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Codigo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
		<td<?php echo $ca_sim_cards->COD_Compania_eq->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_COD_Compania_eq"<?php echo $ca_sim_cards->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($ca_sim_cards->COD_Compania_eq->EditValue)) {
	$arwrk = $ca_sim_cards->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->COD_Compania_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_sim_cardslist.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($ca_sim_cards->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($ca_sim_cards->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $ca_sim_cards->COD_Compania_eq->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Amigo_CHIP->Visible) { // Amigo_CHIP ?>
		<td<?php echo $ca_sim_cards->Amigo_CHIP->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" value="{value}"<?php echo $ca_sim_cards->Amigo_CHIP->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Amigo_CHIP->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Amigo_CHIP->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Amigo_CHIP" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Amigo_CHIP->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Amigo_CHIP->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Amigo_CHIP->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Activacion_Movi->Visible) { // Activacion_Movi ?>
		<td<?php echo $ca_sim_cards->Activacion_Movi->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" value="{value}"<?php echo $ca_sim_cards->Activacion_Movi->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Activacion_Movi->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Activacion_Movi->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Activacion_Movi" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Activacion_Movi->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Activacion_Movi->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Activacion_Movi->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_compra->Visible) { // Precio_compra ?>
		<td<?php echo $ca_sim_cards->Precio_compra->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_compra" size="10" value="<?php echo $ca_sim_cards->Precio_compra->EditValue ?>"<?php echo $ca_sim_cards->Precio_compra->EditAttributes() ?>>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Precio_compra->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_compra->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_publico_1->Visible) { // Precio_lista_venta_publico_1 ?>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_1" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->EditAttributes() ?>>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_publico_2->Visible) { // Precio_lista_venta_publico_2 ?>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_publico_2" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->EditAttributes() ?>>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_medio_mayoreo->Visible) { // Precio_lista_venta_medio_mayoreo ?>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_medio_mayoreo" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->EditAttributes() ?>>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Precio_lista_venta_mayoreo->Visible) { // Precio_lista_venta_mayoreo ?>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Precio_lista_venta_mayoreo" size="10" value="<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->EditValue ?>"<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->EditAttributes() ?>>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
		<td<?php echo $ca_sim_cards->Id_Almacen_Entrada->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Id_Almacen_Entrada"<?php echo $ca_sim_cards->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($ca_sim_cards->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $ca_sim_cards->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_sim_cardslist.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($ca_sim_cards->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($ca_sim_cards->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Id_Almacen_Entrada->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Id_Almacen_Entrada->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_sim_cards->Status->Visible) { // Status ?>
		<td<?php echo $ca_sim_cards->Status->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_list->RowCnt ?>_ca_sim_cards_Status" class="ca_sim_cards_Status">
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" value="{value}"<?php echo $ca_sim_cards->Status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_sim_cards->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_sim_cards->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" id="x<?php echo $ca_sim_cards_list->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_sim_cards->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $ca_sim_cards->Status->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Status->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $ca_sim_cards_list->PageObjName . "_row_" . $ca_sim_cards_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_sim_cards_list->ListOptions->Render("body", "right", $ca_sim_cards_list->RowCnt);
?>
	</tr>
<?php if ($ca_sim_cards->RowType == EW_ROWTYPE_ADD || $ca_sim_cards->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fca_sim_cardslist.UpdateOpts(<?php echo $ca_sim_cards_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($ca_sim_cards->CurrentAction <> "gridadd")
		$ca_sim_cards_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ca_sim_cards->CurrentAction == "add" || $ca_sim_cards->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ca_sim_cards_list->KeyCount ?>">
<?php } ?>
<?php if ($ca_sim_cards->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ca_sim_cards_list->KeyCount ?>">
<?php } ?>
<?php if ($ca_sim_cards->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ca_sim_cards_list->Recordset)
	$ca_sim_cards_list->Recordset->Close();
?>
<?php if ($ca_sim_cards_list->TotalRecs > 0) { ?>
<?php if ($ca_sim_cards->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ca_sim_cards->CurrentAction <> "gridadd" && $ca_sim_cards->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_sim_cards_list->Pager)) $ca_sim_cards_list->Pager = new cNumericPager($ca_sim_cards_list->StartRec, $ca_sim_cards_list->DisplayRecs, $ca_sim_cards_list->TotalRecs, $ca_sim_cards_list->RecRange) ?>
<?php if ($ca_sim_cards_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_sim_cards_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_sim_cards_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_sim_cards_list->PageUrl() ?>start=<?php echo $ca_sim_cards_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_sim_cards_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_sim_cards_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_sim_cards_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_sim_cards_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_sim_cards">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_sim_cards_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_sim_cards_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_sim_cards_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_sim_cards_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_sim_cards_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($ca_sim_cards_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_sim_cards_list->InlineAddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_sim_cards_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($ca_sim_cards->Export == "") { ?>
<script type="text/javascript">
fca_sim_cardslist.Init();
</script>
<?php } ?>
<?php
$ca_sim_cards_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ca_sim_cards->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ca_sim_cards_list->Page_Terminate();
?>
