<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_datos_reingreso_x_cancelacion_tiendainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_datos_reingreso_x_cancelacion_tienda_list = NULL; // Initialize page object first

class ccap_datos_reingreso_x_cancelacion_tienda_list extends ccap_datos_reingreso_x_cancelacion_tienda {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_datos_reingreso_x_cancelacion_tienda';

	// Page object name
	var $PageObjName = 'cap_datos_reingreso_x_cancelacion_tienda_list';

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

		// Table object (cap_datos_reingreso_x_cancelacion_tienda)
		if (!isset($GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"])) {
			$GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_datos_reingreso_x_cancelacion_tiendaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_datos_reingreso_x_cancelacion_tiendadelete.php";
		$this->MultiUpdateUrl = "cap_datos_reingreso_x_cancelacion_tiendaupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_datos_reingreso_x_cancelacion_tienda', TRUE);

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

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Venta_Eq, $bCtrl); // Id_Venta_Eq
			$this->UpdateSort($this->CLIENTE, $bCtrl); // CLIENTE
			$this->UpdateSort($this->Id_Articulo, $bCtrl); // Id_Articulo
			$this->UpdateSort($this->Acabado_eq, $bCtrl); // Acabado_eq
			$this->UpdateSort($this->Num_IMEI, $bCtrl); // Num_IMEI
			$this->UpdateSort($this->Num_ICCID, $bCtrl); // Num_ICCID
			$this->UpdateSort($this->Num_CEL, $bCtrl); // Num_CEL
			$this->UpdateSort($this->Causa, $bCtrl); // Causa
			$this->UpdateSort($this->Con_SIM, $bCtrl); // Con_SIM
			$this->UpdateSort($this->Observaciones, $bCtrl); // Observaciones
			$this->UpdateSort($this->PrecioUnitario, $bCtrl); // PrecioUnitario
			$this->UpdateSort($this->MontoDescuento, $bCtrl); // MontoDescuento
			$this->UpdateSort($this->Precio_SIM, $bCtrl); // Precio_SIM
			$this->UpdateSort($this->Monto, $bCtrl); // Monto
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
				$this->Id_Venta_Eq->setSort("");
				$this->CLIENTE->setSort("");
				$this->Id_Articulo->setSort("");
				$this->Acabado_eq->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_ICCID->setSort("");
				$this->Num_CEL->setSort("");
				$this->Causa->setSort("");
				$this->Con_SIM->setSort("");
				$this->Observaciones->setSort("");
				$this->PrecioUnitario->setSort("");
				$this->MontoDescuento->setSort("");
				$this->Precio_SIM->setSort("");
				$this->Monto->setSort("");
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

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		$this->CLIENTE->setDbValue($rs->fields('CLIENTE'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Causa->setDbValue($rs->fields('Causa'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->PrecioUnitario->setDbValue($rs->fields('PrecioUnitario'));
		$this->MontoDescuento->setDbValue($rs->fields('MontoDescuento'));
		$this->Precio_SIM->setDbValue($rs->fields('Precio_SIM'));
		$this->Monto->setDbValue($rs->fields('Monto'));
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

		// Convert decimal values if posted back
		if ($this->PrecioUnitario->FormValue == $this->PrecioUnitario->CurrentValue && is_numeric(ew_StrToFloat($this->PrecioUnitario->CurrentValue)))
			$this->PrecioUnitario->CurrentValue = ew_StrToFloat($this->PrecioUnitario->CurrentValue);

		// Convert decimal values if posted back
		if ($this->MontoDescuento->FormValue == $this->MontoDescuento->CurrentValue && is_numeric(ew_StrToFloat($this->MontoDescuento->CurrentValue)))
			$this->MontoDescuento->CurrentValue = ew_StrToFloat($this->MontoDescuento->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_SIM->FormValue == $this->Precio_SIM->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_SIM->CurrentValue)))
			$this->Precio_SIM->CurrentValue = ew_StrToFloat($this->Precio_SIM->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Monto->FormValue == $this->Monto->CurrentValue && is_numeric(ew_StrToFloat($this->Monto->CurrentValue)))
			$this->Monto->CurrentValue = ew_StrToFloat($this->Monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Venta_Eq
		// CLIENTE
		// Id_Articulo
		// Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Causa
		// Con_SIM
		// Observaciones
		// PrecioUnitario
		// MontoDescuento
		// Precio_SIM
		// Monto

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// CLIENTE
			$this->CLIENTE->ViewValue = $this->CLIENTE->CurrentValue;
			$this->CLIENTE->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
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

			// Acabado_eq
			$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
			$this->Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Causa
			if (strval($this->Causa->CurrentValue) <> "") {
				switch ($this->Causa->CurrentValue) {
					case $this->Causa->FldTagValue(1):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(1) <> "" ? $this->Causa->FldTagCaption(1) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(2):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(2) <> "" ? $this->Causa->FldTagCaption(2) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(3):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(3) <> "" ? $this->Causa->FldTagCaption(3) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(4):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(4) <> "" ? $this->Causa->FldTagCaption(4) : $this->Causa->CurrentValue;
						break;
					default:
						$this->Causa->ViewValue = $this->Causa->CurrentValue;
				}
			} else {
				$this->Causa->ViewValue = NULL;
			}
			$this->Causa->ViewCustomAttributes = "";

			// Con_SIM
			if (strval($this->Con_SIM->CurrentValue) <> "") {
				switch ($this->Con_SIM->CurrentValue) {
					case $this->Con_SIM->FldTagValue(1):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(2):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
						break;
					default:
						$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
				}
			} else {
				$this->Con_SIM->ViewValue = NULL;
			}
			$this->Con_SIM->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// PrecioUnitario
			$this->PrecioUnitario->ViewValue = $this->PrecioUnitario->CurrentValue;
			$this->PrecioUnitario->ViewCustomAttributes = "";

			// MontoDescuento
			$this->MontoDescuento->ViewValue = $this->MontoDescuento->CurrentValue;
			$this->MontoDescuento->ViewCustomAttributes = "";

			// Precio_SIM
			$this->Precio_SIM->ViewValue = $this->Precio_SIM->CurrentValue;
			$this->Precio_SIM->ViewCustomAttributes = "";

			// Monto
			$this->Monto->ViewValue = $this->Monto->CurrentValue;
			$this->Monto->ViewCustomAttributes = "";

			// Id_Venta_Eq
			$this->Id_Venta_Eq->LinkCustomAttributes = "";
			$this->Id_Venta_Eq->HrefValue = "";
			$this->Id_Venta_Eq->TooltipValue = "";

			// CLIENTE
			$this->CLIENTE->LinkCustomAttributes = "";
			$this->CLIENTE->HrefValue = "";
			$this->CLIENTE->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Acabado_eq
			$this->Acabado_eq->LinkCustomAttributes = "";
			$this->Acabado_eq->HrefValue = "";
			$this->Acabado_eq->TooltipValue = "";

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

			// Causa
			$this->Causa->LinkCustomAttributes = "";
			$this->Causa->HrefValue = "";
			$this->Causa->TooltipValue = "";

			// Con_SIM
			$this->Con_SIM->LinkCustomAttributes = "";
			$this->Con_SIM->HrefValue = "";
			$this->Con_SIM->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// PrecioUnitario
			$this->PrecioUnitario->LinkCustomAttributes = "";
			$this->PrecioUnitario->HrefValue = "";
			$this->PrecioUnitario->TooltipValue = "";

			// MontoDescuento
			$this->MontoDescuento->LinkCustomAttributes = "";
			$this->MontoDescuento->HrefValue = "";
			$this->MontoDescuento->TooltipValue = "";

			// Precio_SIM
			$this->Precio_SIM->LinkCustomAttributes = "";
			$this->Precio_SIM->HrefValue = "";
			$this->Precio_SIM->TooltipValue = "";

			// Monto
			$this->Monto->LinkCustomAttributes = "";
			$this->Monto->HrefValue = "";
			$this->Monto->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$item->Body = "<a id=\"emf_cap_datos_reingreso_x_cancelacion_tienda\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_datos_reingreso_x_cancelacion_tienda',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_datos_reingreso_x_cancelacion_tiendalist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
	  Cambia_Phrase("NoRecord","NO HAY VENTAS PARA CANCELAR");
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
if (!isset($cap_datos_reingreso_x_cancelacion_tienda_list)) $cap_datos_reingreso_x_cancelacion_tienda_list = new ccap_datos_reingreso_x_cancelacion_tienda_list();

// Page init
$cap_datos_reingreso_x_cancelacion_tienda_list->Page_Init();

// Page main
$cap_datos_reingreso_x_cancelacion_tienda_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_datos_reingreso_x_cancelacion_tienda_list = new ew_Page("cap_datos_reingreso_x_cancelacion_tienda_list");
cap_datos_reingreso_x_cancelacion_tienda_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_datos_reingreso_x_cancelacion_tienda_list.PageID; // For backward compatibility

// Form object
var fcap_datos_reingreso_x_cancelacion_tiendalist = new ew_Form("fcap_datos_reingreso_x_cancelacion_tiendalist");

// Form_CustomValidate event
fcap_datos_reingreso_x_cancelacion_tiendalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_datos_reingreso_x_cancelacion_tiendalist.ValidateRequired = true;
<?php } else { ?>
fcap_datos_reingreso_x_cancelacion_tiendalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_datos_reingreso_x_cancelacion_tiendalist.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
		$cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs = $cap_datos_reingreso_x_cancelacion_tienda->SelectRecordCount();
	} else {
		if ($cap_datos_reingreso_x_cancelacion_tienda_list->Recordset = $cap_datos_reingreso_x_cancelacion_tienda_list->LoadRecordset())
			$cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs = $cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->RecordCount();
	}
	$cap_datos_reingreso_x_cancelacion_tienda_list->StartRec = 1;
	if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs <= 0 || ($cap_datos_reingreso_x_cancelacion_tienda->Export <> "" && $cap_datos_reingreso_x_cancelacion_tienda->ExportAll)) // Display all records
		$cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs = $cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs;
	if (!($cap_datos_reingreso_x_cancelacion_tienda->Export <> "" && $cap_datos_reingreso_x_cancelacion_tienda->ExportAll))
		$cap_datos_reingreso_x_cancelacion_tienda_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset = $cap_datos_reingreso_x_cancelacion_tienda_list->LoadRecordset($cap_datos_reingreso_x_cancelacion_tienda_list->StartRec-1, $cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_datos_reingreso_x_cancelacion_tienda->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_datos_reingreso_x_cancelacion_tienda_list->ExportOptions->Render("body"); ?>
</p>
<?php $cap_datos_reingreso_x_cancelacion_tienda_list->ShowPageHeader(); ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CurrentAction <> "gridadd" && $cap_datos_reingreso_x_cancelacion_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_datos_reingreso_x_cancelacion_tienda_list->Pager)) $cap_datos_reingreso_x_cancelacion_tienda_list->Pager = new cNumericPager($cap_datos_reingreso_x_cancelacion_tienda_list->StartRec, $cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs, $cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs, $cap_datos_reingreso_x_cancelacion_tienda_list->RecRange) ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_datos_reingreso_x_cancelacion_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
</span>
</div>
<?php } ?>
<form name="fcap_datos_reingreso_x_cancelacion_tiendalist" id="fcap_datos_reingreso_x_cancelacion_tiendalist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_datos_reingreso_x_cancelacion_tienda">
<div id="gmp_cap_datos_reingreso_x_cancelacion_tienda" class="ewGridMiddlePanel">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs > 0) { ?>
<table id="tbl_cap_datos_reingreso_x_cancelacion_tiendalist" class="ewTable ewTableSeparate">
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_datos_reingreso_x_cancelacion_tienda_list->RenderListOptions();

// Render list options (header, left)
$cap_datos_reingreso_x_cancelacion_tienda_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->Visible) { // CLIENTE ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE" class="cap_datos_reingreso_x_cancelacion_tienda_CLIENTE"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE" class="cap_datos_reingreso_x_cancelacion_tienda_CLIENTE">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->Visible) { // Acabado_eq ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq" class="cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq" class="cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI" class="cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI" class="cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID" class="cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID" class="cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_CEL" class="cap_datos_reingreso_x_cancelacion_tienda_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_CEL" class="cap_datos_reingreso_x_cancelacion_tienda_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Causa->Visible) { // Causa ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Causa) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Causa" class="cap_datos_reingreso_x_cancelacion_tienda_Causa"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Causa) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Causa" class="cap_datos_reingreso_x_cancelacion_tienda_Causa">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Causa->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Causa->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->Visible) { // Con_SIM ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Con_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Con_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->Visible) { // Observaciones ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Observaciones) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Observaciones" class="cap_datos_reingreso_x_cancelacion_tienda_Observaciones"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Observaciones) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Observaciones" class="cap_datos_reingreso_x_cancelacion_tienda_Observaciones">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->Visible) { // PrecioUnitario ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario" class="cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario" class="cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->Visible) { // MontoDescuento ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento" class="cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento" class="cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->Visible) { // Precio_SIM ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Monto->Visible) { // Monto ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Monto) == "") { ?>
		<td><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Monto" class="cap_datos_reingreso_x_cancelacion_tienda_Monto"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_reingreso_x_cancelacion_tienda->SortUrl($cap_datos_reingreso_x_cancelacion_tienda->Monto) ?>',2);"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Monto" class="cap_datos_reingreso_x_cancelacion_tienda_Monto">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_reingreso_x_cancelacion_tienda->Monto->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_reingreso_x_cancelacion_tienda->Monto->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_datos_reingreso_x_cancelacion_tienda_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_datos_reingreso_x_cancelacion_tienda->ExportAll && $cap_datos_reingreso_x_cancelacion_tienda->Export <> "") {
	$cap_datos_reingreso_x_cancelacion_tienda_list->StopRec = $cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs > $cap_datos_reingreso_x_cancelacion_tienda_list->StartRec + $cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs - 1)
		$cap_datos_reingreso_x_cancelacion_tienda_list->StopRec = $cap_datos_reingreso_x_cancelacion_tienda_list->StartRec + $cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs - 1;
	else
		$cap_datos_reingreso_x_cancelacion_tienda_list->StopRec = $cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs;
}
$cap_datos_reingreso_x_cancelacion_tienda_list->RecCnt = $cap_datos_reingreso_x_cancelacion_tienda_list->StartRec - 1;
if ($cap_datos_reingreso_x_cancelacion_tienda_list->Recordset && !$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->EOF) {
	$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_datos_reingreso_x_cancelacion_tienda_list->StartRec > 1)
		$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->Move($cap_datos_reingreso_x_cancelacion_tienda_list->StartRec - 1);
} elseif (!$cap_datos_reingreso_x_cancelacion_tienda->AllowAddDeleteRow && $cap_datos_reingreso_x_cancelacion_tienda_list->StopRec == 0) {
	$cap_datos_reingreso_x_cancelacion_tienda_list->StopRec = $cap_datos_reingreso_x_cancelacion_tienda->GridAddRowCount;
}

// Initialize aggregate
$cap_datos_reingreso_x_cancelacion_tienda->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_datos_reingreso_x_cancelacion_tienda->ResetAttrs();
$cap_datos_reingreso_x_cancelacion_tienda_list->RenderRow();
while ($cap_datos_reingreso_x_cancelacion_tienda_list->RecCnt < $cap_datos_reingreso_x_cancelacion_tienda_list->StopRec) {
	$cap_datos_reingreso_x_cancelacion_tienda_list->RecCnt++;
	if (intval($cap_datos_reingreso_x_cancelacion_tienda_list->RecCnt) >= intval($cap_datos_reingreso_x_cancelacion_tienda_list->StartRec)) {
		$cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt++;

		// Set up key count
		$cap_datos_reingreso_x_cancelacion_tienda_list->KeyCount = $cap_datos_reingreso_x_cancelacion_tienda_list->RowIndex;

		// Init row class and style
		$cap_datos_reingreso_x_cancelacion_tienda->ResetAttrs();
		$cap_datos_reingreso_x_cancelacion_tienda->CssClass = "";
		if ($cap_datos_reingreso_x_cancelacion_tienda->CurrentAction == "gridadd") {
		} else {
			$cap_datos_reingreso_x_cancelacion_tienda_list->LoadRowValues($cap_datos_reingreso_x_cancelacion_tienda_list->Recordset); // Load row values
		}
		$cap_datos_reingreso_x_cancelacion_tienda->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_datos_reingreso_x_cancelacion_tienda->RowAttrs = array_merge($cap_datos_reingreso_x_cancelacion_tienda->RowAttrs, array('data-rowindex'=>$cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt, 'id'=>'r' . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt . '_cap_datos_reingreso_x_cancelacion_tienda', 'data-rowtype'=>$cap_datos_reingreso_x_cancelacion_tienda->RowType));

		// Render row
		$cap_datos_reingreso_x_cancelacion_tienda_list->RenderRow();

		// Render list options
		$cap_datos_reingreso_x_cancelacion_tienda_list->RenderListOptions();
?>
	<tr<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_datos_reingreso_x_cancelacion_tienda_list->ListOptions->Render("body", "left", $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt);
?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Venta_Eq">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->Visible) { // CLIENTE ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE" class="cap_datos_reingreso_x_cancelacion_tienda_CLIENTE">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo" class="cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->Visible) { // Acabado_eq ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq" class="cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI" class="cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID" class="cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Num_CEL" class="cap_datos_reingreso_x_cancelacion_tienda_Num_CEL">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Causa->Visible) { // Causa ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Causa" class="cap_datos_reingreso_x_cancelacion_tienda_Causa">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->Visible) { // Con_SIM ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Con_SIM">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->Visible) { // Observaciones ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Observaciones" class="cap_datos_reingreso_x_cancelacion_tienda_Observaciones">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->Visible) { // PrecioUnitario ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario" class="cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->Visible) { // MontoDescuento ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento" class="cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->Visible) { // Precio_SIM ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM" class="cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Monto->Visible) { // Monto ?>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->CellAttributes() ?>><span id="el<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>_cap_datos_reingreso_x_cancelacion_tienda_Monto" class="cap_datos_reingreso_x_cancelacion_tienda_Monto">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageObjName . "_row_" . $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_datos_reingreso_x_cancelacion_tienda_list->ListOptions->Render("body", "right", $cap_datos_reingreso_x_cancelacion_tienda_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_datos_reingreso_x_cancelacion_tienda->CurrentAction <> "gridadd")
		$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_datos_reingreso_x_cancelacion_tienda_list->Recordset)
	$cap_datos_reingreso_x_cancelacion_tienda_list->Recordset->Close();
?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs > 0) { ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CurrentAction <> "gridadd" && $cap_datos_reingreso_x_cancelacion_tienda->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_datos_reingreso_x_cancelacion_tienda_list->Pager)) $cap_datos_reingreso_x_cancelacion_tienda_list->Pager = new cNumericPager($cap_datos_reingreso_x_cancelacion_tienda_list->StartRec, $cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs, $cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs, $cap_datos_reingreso_x_cancelacion_tienda_list->RecRange) ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->PageUrl() ?>start=<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_datos_reingreso_x_cancelacion_tienda_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_datos_reingreso_x_cancelacion_tienda">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_datos_reingreso_x_cancelacion_tienda_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Export == "") { ?>
<script type="text/javascript">
fcap_datos_reingreso_x_cancelacion_tiendalist.Init();
</script>
<?php } ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_list->Page_Terminate();
?>
