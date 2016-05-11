<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_datos_garantia_eqinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_datos_garantia_eq_list = NULL; // Initialize page object first

class ccap_datos_garantia_eq_list extends ccap_datos_garantia_eq {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_datos_garantia_eq';

	// Page object name
	var $PageObjName = 'cap_datos_garantia_eq_list';

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

		// Table object (cap_datos_garantia_eq)
		if (!isset($GLOBALS["cap_datos_garantia_eq"])) {
			$GLOBALS["cap_datos_garantia_eq"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_datos_garantia_eq"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_datos_garantia_eqadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_datos_garantia_eqdelete.php";
		$this->MultiUpdateUrl = "cap_datos_garantia_equpdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_datos_garantia_eq', TRUE);

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
		$this->Id_Empleado_recibe->Visible = !$this->IsAddOrEdit();

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
			$this->UpdateSort($this->Fecha_Venta, $bCtrl); // Fecha_Venta
			$this->UpdateSort($this->Nombre_Completo, $bCtrl); // Nombre_Completo
			$this->UpdateSort($this->Fecha_Entrada, $bCtrl); // Fecha_Entrada
			$this->UpdateSort($this->Id_Marca_eq, $bCtrl); // Id_Marca_eq
			$this->UpdateSort($this->COD_Modelo_eq, $bCtrl); // COD_Modelo_eq
			$this->UpdateSort($this->Id_Acabado_eq, $bCtrl); // Id_Acabado_eq
			$this->UpdateSort($this->Num_IMEI, $bCtrl); // Num_IMEI
			$this->UpdateSort($this->Id_Proveedor, $bCtrl); // Id_Proveedor
			$this->UpdateSort($this->Accesorios_Recibidos, $bCtrl); // Accesorios_Recibidos
			$this->UpdateSort($this->Id_Tel_SIM, $bCtrl); // Id_Tel_SIM
			$this->UpdateSort($this->Id_Empleado_recibe, $bCtrl); // Id_Empleado_recibe
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
				$this->Fecha_Venta->setSort("");
				$this->Nombre_Completo->setSort("");
				$this->Fecha_Entrada->setSort("");
				$this->Id_Marca_eq->setSort("");
				$this->COD_Modelo_eq->setSort("");
				$this->Id_Acabado_eq->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Id_Proveedor->setSort("");
				$this->Accesorios_Recibidos->setSort("");
				$this->Id_Tel_SIM->setSort("");
				$this->Id_Empleado_recibe->setSort("");
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
		$this->Fecha_Venta->setDbValue($rs->fields('Fecha_Venta'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha_Entrada'));
		$this->Id_Marca_eq->setDbValue($rs->fields('Id_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->Accesorios_Recibidos->setDbValue($rs->fields('Accesorios_Recibidos'));
		$this->Falla->setDbValue($rs->fields('Falla'));
		$this->Condiciones_Equipo->setDbValue($rs->fields('Condiciones_Equipo'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Empleado_recibe->setDbValue($rs->fields('Id_Empleado_recibe'));
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
		// Fecha_Venta
		// Nombre_Completo
		// Fecha_Entrada
		// Id_Marca_eq
		// COD_Modelo_eq
		// Id_Acabado_eq
		// Num_IMEI
		// Id_Proveedor
		// Accesorios_Recibidos
		// Falla
		// Condiciones_Equipo
		// Id_Tel_SIM
		// Id_Empleado_recibe

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// Fecha_Venta
			$this->Fecha_Venta->ViewValue = $this->Fecha_Venta->CurrentValue;
			$this->Fecha_Venta->ViewValue = ew_FormatDateTime($this->Fecha_Venta->ViewValue, 7);
			$this->Fecha_Venta->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
			$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 7);
			$this->Fecha_Entrada->ViewCustomAttributes = "";

			// Id_Marca_eq
			$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
			if (strval($this->Id_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Marca_eq`" . ew_SearchString("=", $this->Id_Marca_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
				}
			} else {
				$this->Id_Marca_eq->ViewValue = NULL;
			}
			$this->Id_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Proveedor
			$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->ViewValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// Accesorios_Recibidos
			if (strval($this->Accesorios_Recibidos->CurrentValue) <> "") {
				$this->Accesorios_Recibidos->ViewValue = "";
				$arwrk = explode(",", strval($this->Accesorios_Recibidos->CurrentValue));
				$cnt = count($arwrk);
				for ($ari = 0; $ari < $cnt; $ari++) {
					switch (trim($arwrk[$ari])) {
						case $this->Accesorios_Recibidos->FldTagValue(1):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(1) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(1) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(2):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(2) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(2) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(3):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(3) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(3) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(4):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(4) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(4) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(5):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(5) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(5) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(6):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(6) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(6) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(7):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(7) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(7) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(8):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(8) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(8) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(9):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(9) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(9) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(10):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(10) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(10) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(11):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(11) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(11) : trim($arwrk[$ari]);
							break;
						default:
							$this->Accesorios_Recibidos->ViewValue .= trim($arwrk[$ari]);
					}
					if ($ari < $cnt-1) $this->Accesorios_Recibidos->ViewValue .= ew_ViewOptionSeparator($ari);
				}
			} else {
				$this->Accesorios_Recibidos->ViewValue = NULL;
			}
			$this->Accesorios_Recibidos->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(2,$this->Id_Tel_SIM) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->ViewValue = $this->Id_Empleado_recibe->CurrentValue;
			$this->Id_Empleado_recibe->ViewCustomAttributes = "";

			// Id_Venta_Eq
			$this->Id_Venta_Eq->LinkCustomAttributes = "";
			$this->Id_Venta_Eq->HrefValue = "";
			$this->Id_Venta_Eq->TooltipValue = "";

			// Fecha_Venta
			$this->Fecha_Venta->LinkCustomAttributes = "";
			$this->Fecha_Venta->HrefValue = "";
			$this->Fecha_Venta->TooltipValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->LinkCustomAttributes = "";
			$this->Nombre_Completo->HrefValue = "";
			$this->Nombre_Completo->TooltipValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Id_Marca_eq
			$this->Id_Marca_eq->LinkCustomAttributes = "";
			$this->Id_Marca_eq->HrefValue = "";
			$this->Id_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";

			// Accesorios_Recibidos
			$this->Accesorios_Recibidos->LinkCustomAttributes = "";
			$this->Accesorios_Recibidos->HrefValue = "";
			$this->Accesorios_Recibidos->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->LinkCustomAttributes = "";
			$this->Id_Empleado_recibe->HrefValue = "";
			$this->Id_Empleado_recibe->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_cap_datos_garantia_eq\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_datos_garantia_eq',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_datos_garantia_eqlist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_datos_garantia_eq_list)) $cap_datos_garantia_eq_list = new ccap_datos_garantia_eq_list();

// Page init
$cap_datos_garantia_eq_list->Page_Init();

// Page main
$cap_datos_garantia_eq_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_datos_garantia_eq->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_datos_garantia_eq_list = new ew_Page("cap_datos_garantia_eq_list");
cap_datos_garantia_eq_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_datos_garantia_eq_list.PageID; // For backward compatibility

// Form object
var fcap_datos_garantia_eqlist = new ew_Form("fcap_datos_garantia_eqlist");

// Form_CustomValidate event
fcap_datos_garantia_eqlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_datos_garantia_eqlist.ValidateRequired = true;
<?php } else { ?>
fcap_datos_garantia_eqlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_datos_garantia_eqlist.Lists["x_Id_Marca_eq"] = {"LinkField":"x_Id_Marca_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_datos_garantia_eqlist.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_datos_garantia_eqlist.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_datos_garantia_eqlist.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","x_Num_IMEI","x_Num_ICCID",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
		$cap_datos_garantia_eq_list->TotalRecs = $cap_datos_garantia_eq->SelectRecordCount();
	} else {
		if ($cap_datos_garantia_eq_list->Recordset = $cap_datos_garantia_eq_list->LoadRecordset())
			$cap_datos_garantia_eq_list->TotalRecs = $cap_datos_garantia_eq_list->Recordset->RecordCount();
	}
	$cap_datos_garantia_eq_list->StartRec = 1;
	if ($cap_datos_garantia_eq_list->DisplayRecs <= 0 || ($cap_datos_garantia_eq->Export <> "" && $cap_datos_garantia_eq->ExportAll)) // Display all records
		$cap_datos_garantia_eq_list->DisplayRecs = $cap_datos_garantia_eq_list->TotalRecs;
	if (!($cap_datos_garantia_eq->Export <> "" && $cap_datos_garantia_eq->ExportAll))
		$cap_datos_garantia_eq_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_datos_garantia_eq_list->Recordset = $cap_datos_garantia_eq_list->LoadRecordset($cap_datos_garantia_eq_list->StartRec-1, $cap_datos_garantia_eq_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_datos_garantia_eq->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_datos_garantia_eq_list->ExportOptions->Render("body"); ?>
</p>
<?php $cap_datos_garantia_eq_list->ShowPageHeader(); ?>
<?php
$cap_datos_garantia_eq_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_datos_garantia_eq->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "gridadd" && $cap_datos_garantia_eq->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_datos_garantia_eq_list->Pager)) $cap_datos_garantia_eq_list->Pager = new cNumericPager($cap_datos_garantia_eq_list->StartRec, $cap_datos_garantia_eq_list->DisplayRecs, $cap_datos_garantia_eq_list->TotalRecs, $cap_datos_garantia_eq_list->RecRange) ?>
<?php if ($cap_datos_garantia_eq_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_datos_garantia_eq_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_datos_garantia_eq_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_datos_garantia_eq_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_datos_garantia_eq">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<form name="fcap_datos_garantia_eqlist" id="fcap_datos_garantia_eqlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_datos_garantia_eq">
<div id="gmp_cap_datos_garantia_eq" class="ewGridMiddlePanel">
<?php if ($cap_datos_garantia_eq_list->TotalRecs > 0) { ?>
<table id="tbl_cap_datos_garantia_eqlist" class="ewTable ewTableSeparate">
<?php echo $cap_datos_garantia_eq->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_datos_garantia_eq_list->RenderListOptions();

// Render list options (header, left)
$cap_datos_garantia_eq_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_datos_garantia_eq->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Venta_Eq) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Venta_Eq" class="cap_datos_garantia_eq_Id_Venta_Eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Venta_Eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Venta_Eq) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Venta_Eq" class="cap_datos_garantia_eq_Id_Venta_Eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Venta_Eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Venta_Eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Venta_Eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Fecha_Venta->Visible) { // Fecha_Venta ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Fecha_Venta) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Fecha_Venta" class="cap_datos_garantia_eq_Fecha_Venta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Fecha_Venta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Fecha_Venta) ?>',2);"><span id="elh_cap_datos_garantia_eq_Fecha_Venta" class="cap_datos_garantia_eq_Fecha_Venta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Fecha_Venta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Fecha_Venta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Fecha_Venta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Nombre_Completo->Visible) { // Nombre_Completo ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Nombre_Completo) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Nombre_Completo" class="cap_datos_garantia_eq_Nombre_Completo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Nombre_Completo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Nombre_Completo) ?>',2);"><span id="elh_cap_datos_garantia_eq_Nombre_Completo" class="cap_datos_garantia_eq_Nombre_Completo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Nombre_Completo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Nombre_Completo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Nombre_Completo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Fecha_Entrada) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Fecha_Entrada" class="cap_datos_garantia_eq_Fecha_Entrada"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Fecha_Entrada->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Fecha_Entrada) ?>',2);"><span id="elh_cap_datos_garantia_eq_Fecha_Entrada" class="cap_datos_garantia_eq_Fecha_Entrada">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Fecha_Entrada->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Fecha_Entrada->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Fecha_Entrada->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Id_Marca_eq->Visible) { // Id_Marca_eq ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Marca_eq) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Marca_eq" class="cap_datos_garantia_eq_Id_Marca_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Marca_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Marca_eq) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Marca_eq" class="cap_datos_garantia_eq_Id_Marca_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Marca_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Marca_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Marca_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->COD_Modelo_eq) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_COD_Modelo_eq" class="cap_datos_garantia_eq_COD_Modelo_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->COD_Modelo_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->COD_Modelo_eq) ?>',2);"><span id="elh_cap_datos_garantia_eq_COD_Modelo_eq" class="cap_datos_garantia_eq_COD_Modelo_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->COD_Modelo_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->COD_Modelo_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->COD_Modelo_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Acabado_eq" class="cap_datos_garantia_eq_Id_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Acabado_eq) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Acabado_eq" class="cap_datos_garantia_eq_Id_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Num_IMEI" class="cap_datos_garantia_eq_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Num_IMEI) ?>',2);"><span id="elh_cap_datos_garantia_eq_Num_IMEI" class="cap_datos_garantia_eq_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Num_IMEI->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Proveedor) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Proveedor" class="cap_datos_garantia_eq_Id_Proveedor"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Proveedor->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Proveedor) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Proveedor" class="cap_datos_garantia_eq_Id_Proveedor">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Proveedor->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Proveedor->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Proveedor->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Accesorios_Recibidos->Visible) { // Accesorios_Recibidos ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Accesorios_Recibidos) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Accesorios_Recibidos" class="cap_datos_garantia_eq_Accesorios_Recibidos"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Accesorios_Recibidos) ?>',2);"><span id="elh_cap_datos_garantia_eq_Accesorios_Recibidos" class="cap_datos_garantia_eq_Accesorios_Recibidos">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Accesorios_Recibidos->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Accesorios_Recibidos->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Tel_SIM" class="cap_datos_garantia_eq_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Tel_SIM) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Tel_SIM" class="cap_datos_garantia_eq_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_datos_garantia_eq->Id_Empleado_recibe->Visible) { // Id_Empleado_recibe ?>
	<?php if ($cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Empleado_recibe) == "") { ?>
		<td><span id="elh_cap_datos_garantia_eq_Id_Empleado_recibe" class="cap_datos_garantia_eq_Id_Empleado_recibe"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_datos_garantia_eq->Id_Empleado_recibe->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_datos_garantia_eq->SortUrl($cap_datos_garantia_eq->Id_Empleado_recibe) ?>',2);"><span id="elh_cap_datos_garantia_eq_Id_Empleado_recibe" class="cap_datos_garantia_eq_Id_Empleado_recibe">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_datos_garantia_eq->Id_Empleado_recibe->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_datos_garantia_eq->Id_Empleado_recibe->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_datos_garantia_eq->Id_Empleado_recibe->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_datos_garantia_eq_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_datos_garantia_eq->ExportAll && $cap_datos_garantia_eq->Export <> "") {
	$cap_datos_garantia_eq_list->StopRec = $cap_datos_garantia_eq_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_datos_garantia_eq_list->TotalRecs > $cap_datos_garantia_eq_list->StartRec + $cap_datos_garantia_eq_list->DisplayRecs - 1)
		$cap_datos_garantia_eq_list->StopRec = $cap_datos_garantia_eq_list->StartRec + $cap_datos_garantia_eq_list->DisplayRecs - 1;
	else
		$cap_datos_garantia_eq_list->StopRec = $cap_datos_garantia_eq_list->TotalRecs;
}
$cap_datos_garantia_eq_list->RecCnt = $cap_datos_garantia_eq_list->StartRec - 1;
if ($cap_datos_garantia_eq_list->Recordset && !$cap_datos_garantia_eq_list->Recordset->EOF) {
	$cap_datos_garantia_eq_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_datos_garantia_eq_list->StartRec > 1)
		$cap_datos_garantia_eq_list->Recordset->Move($cap_datos_garantia_eq_list->StartRec - 1);
} elseif (!$cap_datos_garantia_eq->AllowAddDeleteRow && $cap_datos_garantia_eq_list->StopRec == 0) {
	$cap_datos_garantia_eq_list->StopRec = $cap_datos_garantia_eq->GridAddRowCount;
}

// Initialize aggregate
$cap_datos_garantia_eq->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_datos_garantia_eq->ResetAttrs();
$cap_datos_garantia_eq_list->RenderRow();
while ($cap_datos_garantia_eq_list->RecCnt < $cap_datos_garantia_eq_list->StopRec) {
	$cap_datos_garantia_eq_list->RecCnt++;
	if (intval($cap_datos_garantia_eq_list->RecCnt) >= intval($cap_datos_garantia_eq_list->StartRec)) {
		$cap_datos_garantia_eq_list->RowCnt++;

		// Set up key count
		$cap_datos_garantia_eq_list->KeyCount = $cap_datos_garantia_eq_list->RowIndex;

		// Init row class and style
		$cap_datos_garantia_eq->ResetAttrs();
		$cap_datos_garantia_eq->CssClass = "";
		if ($cap_datos_garantia_eq->CurrentAction == "gridadd") {
		} else {
			$cap_datos_garantia_eq_list->LoadRowValues($cap_datos_garantia_eq_list->Recordset); // Load row values
		}
		$cap_datos_garantia_eq->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_datos_garantia_eq->RowAttrs = array_merge($cap_datos_garantia_eq->RowAttrs, array('data-rowindex'=>$cap_datos_garantia_eq_list->RowCnt, 'id'=>'r' . $cap_datos_garantia_eq_list->RowCnt . '_cap_datos_garantia_eq', 'data-rowtype'=>$cap_datos_garantia_eq->RowType));

		// Render row
		$cap_datos_garantia_eq_list->RenderRow();

		// Render list options
		$cap_datos_garantia_eq_list->RenderListOptions();
?>
	<tr<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_datos_garantia_eq_list->ListOptions->Render("body", "left", $cap_datos_garantia_eq_list->RowCnt);
?>
	<?php if ($cap_datos_garantia_eq->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Venta_Eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Venta_Eq" class="cap_datos_garantia_eq_Id_Venta_Eq">
<span<?php echo $cap_datos_garantia_eq->Id_Venta_Eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Venta_Eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Fecha_Venta->Visible) { // Fecha_Venta ?>
		<td<?php echo $cap_datos_garantia_eq->Fecha_Venta->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Fecha_Venta" class="cap_datos_garantia_eq_Fecha_Venta">
<span<?php echo $cap_datos_garantia_eq->Fecha_Venta->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Fecha_Venta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Nombre_Completo->Visible) { // Nombre_Completo ?>
		<td<?php echo $cap_datos_garantia_eq->Nombre_Completo->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Nombre_Completo" class="cap_datos_garantia_eq_Nombre_Completo">
<span<?php echo $cap_datos_garantia_eq->Nombre_Completo->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Nombre_Completo->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
		<td<?php echo $cap_datos_garantia_eq->Fecha_Entrada->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Fecha_Entrada" class="cap_datos_garantia_eq_Fecha_Entrada">
<span<?php echo $cap_datos_garantia_eq->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Fecha_Entrada->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Id_Marca_eq->Visible) { // Id_Marca_eq ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Marca_eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Marca_eq" class="cap_datos_garantia_eq_Id_Marca_eq">
<span<?php echo $cap_datos_garantia_eq->Id_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Marca_eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
		<td<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_COD_Modelo_eq" class="cap_datos_garantia_eq_COD_Modelo_eq">
<span<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Acabado_eq" class="cap_datos_garantia_eq_Id_Acabado_eq">
<span<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_datos_garantia_eq->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Num_IMEI" class="cap_datos_garantia_eq_Num_IMEI">
<span<?php echo $cap_datos_garantia_eq->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Num_IMEI->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Proveedor->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Proveedor" class="cap_datos_garantia_eq_Id_Proveedor">
<span<?php echo $cap_datos_garantia_eq->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Proveedor->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Accesorios_Recibidos->Visible) { // Accesorios_Recibidos ?>
		<td<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Accesorios_Recibidos" class="cap_datos_garantia_eq_Accesorios_Recibidos">
<span<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Tel_SIM" class="cap_datos_garantia_eq_Id_Tel_SIM">
<span<?php echo $cap_datos_garantia_eq->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Tel_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_datos_garantia_eq->Id_Empleado_recibe->Visible) { // Id_Empleado_recibe ?>
		<td<?php echo $cap_datos_garantia_eq->Id_Empleado_recibe->CellAttributes() ?>><span id="el<?php echo $cap_datos_garantia_eq_list->RowCnt ?>_cap_datos_garantia_eq_Id_Empleado_recibe" class="cap_datos_garantia_eq_Id_Empleado_recibe">
<span<?php echo $cap_datos_garantia_eq->Id_Empleado_recibe->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Empleado_recibe->ListViewValue() ?></span>
</span><a id="<?php echo $cap_datos_garantia_eq_list->PageObjName . "_row_" . $cap_datos_garantia_eq_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_datos_garantia_eq_list->ListOptions->Render("body", "right", $cap_datos_garantia_eq_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_datos_garantia_eq->CurrentAction <> "gridadd")
		$cap_datos_garantia_eq_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_datos_garantia_eq->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_datos_garantia_eq_list->Recordset)
	$cap_datos_garantia_eq_list->Recordset->Close();
?>
<?php if ($cap_datos_garantia_eq_list->TotalRecs > 0) { ?>
<?php if ($cap_datos_garantia_eq->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "gridadd" && $cap_datos_garantia_eq->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_datos_garantia_eq_list->Pager)) $cap_datos_garantia_eq_list->Pager = new cNumericPager($cap_datos_garantia_eq_list->StartRec, $cap_datos_garantia_eq_list->DisplayRecs, $cap_datos_garantia_eq_list->TotalRecs, $cap_datos_garantia_eq_list->RecRange) ?>
<?php if ($cap_datos_garantia_eq_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_datos_garantia_eq_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_datos_garantia_eq_list->PageUrl() ?>start=<?php echo $cap_datos_garantia_eq_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_datos_garantia_eq_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_datos_garantia_eq_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_datos_garantia_eq_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_datos_garantia_eq_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_datos_garantia_eq">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_datos_garantia_eq_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
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
<?php if ($cap_datos_garantia_eq->Export == "") { ?>
<script type="text/javascript">
fcap_datos_garantia_eqlist.Init();
</script>
<?php } ?>
<?php
$cap_datos_garantia_eq_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_datos_garantia_eq->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_datos_garantia_eq_list->Page_Terminate();
?>
