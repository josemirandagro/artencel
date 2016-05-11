<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_almacenesinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_almacenes_list = NULL; // Initialize page object first

class cca_almacenes_list extends cca_almacenes {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_almacenes';

	// Page object name
	var $PageObjName = 'ca_almacenes_list';

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

		// Table object (ca_almacenes)
		if (!isset($GLOBALS["ca_almacenes"])) {
			$GLOBALS["ca_almacenes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_almacenes"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ca_almacenesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ca_almacenesdelete.php";
		$this->MultiUpdateUrl = "ca_almacenesupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_almacenes', TRUE);

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
		$this->Id_Almacen->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Id_Almacen->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Almacen->FormValue))
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
			$this->UpdateSort($this->Id_Almacen, $bCtrl); // Id_Almacen
			$this->UpdateSort($this->Almacen, $bCtrl); // Almacen
			$this->UpdateSort($this->Nombre_Corto, $bCtrl); // Nombre_Corto
			$this->UpdateSort($this->Id_Responsable, $bCtrl); // Id_Responsable
			$this->UpdateSort($this->Telefonos, $bCtrl); // Telefonos
			$this->UpdateSort($this->Categoria, $bCtrl); // Categoria
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
				$this->Almacen->setSort("ASC");
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
				$this->Id_Almacen->setSort("");
				$this->Almacen->setSort("");
				$this->Nombre_Corto->setSort("");
				$this->Id_Responsable->setSort("");
				$this->Telefonos->setSort("");
				$this->Categoria->setSort("");
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
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Almacen->setDbValue($rs->fields('Almacen'));
		$this->Nombre_Corto->setDbValue($rs->fields('Nombre_Corto'));
		$this->Id_Responsable->setDbValue($rs->fields('Id_Responsable'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Maximo_Equipos->setDbValue($rs->fields('Maximo_Equipos'));
		$this->Domicilio_Fiscal->setDbValue($rs->fields('Domicilio_Fiscal'));
		$this->Categoria->setDbValue($rs->fields('Categoria'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Consecutivo_NotaVenta->setDbValue($rs->fields('Consecutivo_NotaVenta'));
		$this->Serie_Factura->setDbValue($rs->fields('Serie_Factura'));
		$this->Consecutivo_Factura->setDbValue($rs->fields('Consecutivo_Factura'));
		$this->Status->setDbValue($rs->fields('Status'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Almacen")) <> "")
			$this->Id_Almacen->CurrentValue = $this->getKey("Id_Almacen"); // Id_Almacen
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

		$this->Id_Almacen->CellCssStyle = "white-space: nowrap;";

		// Almacen
		// Nombre_Corto
		// Id_Responsable
		// Telefonos
		// Domicilio
		// Maximo_Equipos

		$this->Maximo_Equipos->CellCssStyle = "white-space: nowrap;";

		// Domicilio_Fiscal
		// Categoria
		// Serie_NotaVenta
		// Consecutivo_NotaVenta
		// Serie_Factura
		// Consecutivo_Factura
		// Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Almacen
			$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Almacen
			$this->Almacen->ViewValue = $this->Almacen->CurrentValue;
			$this->Almacen->ViewCustomAttributes = "";

			// Nombre_Corto
			$this->Nombre_Corto->ViewValue = $this->Nombre_Corto->CurrentValue;
			$this->Nombre_Corto->ViewCustomAttributes = "";

			// Id_Responsable
			if (strval($this->Id_Responsable->CurrentValue) <> "") {
				$sFilterWrk = "`IdEmpleado`" . ew_SearchString("=", $this->Id_Responsable->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `IdEmpleado`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_empleados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Responsable->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Responsable->ViewValue = $this->Id_Responsable->CurrentValue;
				}
			} else {
				$this->Id_Responsable->ViewValue = NULL;
			}
			$this->Id_Responsable->ViewCustomAttributes = "";

			// Telefonos
			$this->Telefonos->ViewValue = $this->Telefonos->CurrentValue;
			$this->Telefonos->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewValue = strtoupper($this->Domicilio->ViewValue);
			$this->Domicilio->ViewCustomAttributes = "";

			// Domicilio_Fiscal
			$this->Domicilio_Fiscal->ViewValue = $this->Domicilio_Fiscal->CurrentValue;
			$this->Domicilio_Fiscal->ViewCustomAttributes = "";

			// Categoria
			if (strval($this->Categoria->CurrentValue) <> "") {
				switch ($this->Categoria->CurrentValue) {
					case $this->Categoria->FldTagValue(1):
						$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(1) <> "" ? $this->Categoria->FldTagCaption(1) : $this->Categoria->CurrentValue;
						break;
					case $this->Categoria->FldTagValue(2):
						$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(2) <> "" ? $this->Categoria->FldTagCaption(2) : $this->Categoria->CurrentValue;
						break;
					case $this->Categoria->FldTagValue(3):
						$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(3) <> "" ? $this->Categoria->FldTagCaption(3) : $this->Categoria->CurrentValue;
						break;
					default:
						$this->Categoria->ViewValue = $this->Categoria->CurrentValue;
				}
			} else {
				$this->Categoria->ViewValue = NULL;
			}
			$this->Categoria->ViewCustomAttributes = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->ViewValue = $this->Serie_NotaVenta->CurrentValue;
			$this->Serie_NotaVenta->ViewCustomAttributes = "";

			// Consecutivo_NotaVenta
			$this->Consecutivo_NotaVenta->ViewValue = $this->Consecutivo_NotaVenta->CurrentValue;
			$this->Consecutivo_NotaVenta->ViewCustomAttributes = "";

			// Serie_Factura
			$this->Serie_Factura->ViewValue = $this->Serie_Factura->CurrentValue;
			$this->Serie_Factura->ViewCustomAttributes = "";

			// Consecutivo_Factura
			$this->Consecutivo_Factura->ViewValue = $this->Consecutivo_Factura->CurrentValue;
			$this->Consecutivo_Factura->ViewCustomAttributes = "";

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

			// Id_Almacen
			$this->Id_Almacen->LinkCustomAttributes = "";
			$this->Id_Almacen->HrefValue = "";
			$this->Id_Almacen->TooltipValue = "";

			// Almacen
			$this->Almacen->LinkCustomAttributes = "";
			$this->Almacen->HrefValue = "";
			$this->Almacen->TooltipValue = "";

			// Nombre_Corto
			$this->Nombre_Corto->LinkCustomAttributes = "";
			$this->Nombre_Corto->HrefValue = "";
			$this->Nombre_Corto->TooltipValue = "";

			// Id_Responsable
			$this->Id_Responsable->LinkCustomAttributes = "";
			$this->Id_Responsable->HrefValue = "";
			$this->Id_Responsable->TooltipValue = "";

			// Telefonos
			$this->Telefonos->LinkCustomAttributes = "";
			$this->Telefonos->HrefValue = "";
			$this->Telefonos->TooltipValue = "";

			// Categoria
			$this->Categoria->LinkCustomAttributes = "";
			$this->Categoria->HrefValue = "";
			$this->Categoria->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_ca_almacenes\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_ca_almacenes',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fca_almaceneslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($ca_almacenes_list)) $ca_almacenes_list = new cca_almacenes_list();

// Page init
$ca_almacenes_list->Page_Init();

// Page main
$ca_almacenes_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ca_almacenes->Export == "") { ?>
<script type="text/javascript">

// Page object
var ca_almacenes_list = new ew_Page("ca_almacenes_list");
ca_almacenes_list.PageID = "list"; // Page ID
var EW_PAGE_ID = ca_almacenes_list.PageID; // For backward compatibility

// Form object
var fca_almaceneslist = new ew_Form("fca_almaceneslist");

// Form_CustomValidate event
fca_almaceneslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_almaceneslist.ValidateRequired = true;
<?php } else { ?>
fca_almaceneslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_almaceneslist.Lists["x_Id_Responsable"] = {"LinkField":"x_IdEmpleado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
		$ca_almacenes_list->TotalRecs = $ca_almacenes->SelectRecordCount();
	} else {
		if ($ca_almacenes_list->Recordset = $ca_almacenes_list->LoadRecordset())
			$ca_almacenes_list->TotalRecs = $ca_almacenes_list->Recordset->RecordCount();
	}
	$ca_almacenes_list->StartRec = 1;
	if ($ca_almacenes_list->DisplayRecs <= 0 || ($ca_almacenes->Export <> "" && $ca_almacenes->ExportAll)) // Display all records
		$ca_almacenes_list->DisplayRecs = $ca_almacenes_list->TotalRecs;
	if (!($ca_almacenes->Export <> "" && $ca_almacenes->ExportAll))
		$ca_almacenes_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ca_almacenes_list->Recordset = $ca_almacenes_list->LoadRecordset($ca_almacenes_list->StartRec-1, $ca_almacenes_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_almacenes->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $ca_almacenes_list->ExportOptions->Render("body"); ?>
</p>
<?php $ca_almacenes_list->ShowPageHeader(); ?>
<?php
$ca_almacenes_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($ca_almacenes->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($ca_almacenes->CurrentAction <> "gridadd" && $ca_almacenes->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_almacenes_list->Pager)) $ca_almacenes_list->Pager = new cNumericPager($ca_almacenes_list->StartRec, $ca_almacenes_list->DisplayRecs, $ca_almacenes_list->TotalRecs, $ca_almacenes_list->RecRange) ?>
<?php if ($ca_almacenes_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_almacenes_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_almacenes_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_almacenes_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_almacenes_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_almacenes">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_almacenes_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_almacenes_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_almacenes_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_almacenes_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_almacenes_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_almacenes_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_almacenes_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fca_almaceneslist" id="fca_almaceneslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="ca_almacenes">
<div id="gmp_ca_almacenes" class="ewGridMiddlePanel">
<?php if ($ca_almacenes_list->TotalRecs > 0) { ?>
<table id="tbl_ca_almaceneslist" class="ewTable ewTableSeparate">
<?php echo $ca_almacenes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ca_almacenes_list->RenderListOptions();

// Render list options (header, left)
$ca_almacenes_list->ListOptions->Render("header", "left");
?>
<?php if ($ca_almacenes->Id_Almacen->Visible) { // Id_Almacen ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Id_Almacen) == "") { ?>
		<td><span id="elh_ca_almacenes_Id_Almacen" class="ca_almacenes_Id_Almacen"><table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td><?php echo $ca_almacenes->Id_Almacen->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Id_Almacen) ?>',2);"><span id="elh_ca_almacenes_Id_Almacen" class="ca_almacenes_Id_Almacen">
			<table class="ewTableHeaderBtn" style="white-space: nowrap;"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Id_Almacen->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Id_Almacen->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Id_Almacen->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_almacenes->Almacen->Visible) { // Almacen ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Almacen) == "") { ?>
		<td><span id="elh_ca_almacenes_Almacen" class="ca_almacenes_Almacen"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_almacenes->Almacen->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Almacen) ?>',2);"><span id="elh_ca_almacenes_Almacen" class="ca_almacenes_Almacen">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Almacen->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Almacen->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Almacen->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_almacenes->Nombre_Corto->Visible) { // Nombre_Corto ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Nombre_Corto) == "") { ?>
		<td><span id="elh_ca_almacenes_Nombre_Corto" class="ca_almacenes_Nombre_Corto"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_almacenes->Nombre_Corto->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Nombre_Corto) ?>',2);"><span id="elh_ca_almacenes_Nombre_Corto" class="ca_almacenes_Nombre_Corto">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Nombre_Corto->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Nombre_Corto->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Nombre_Corto->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_almacenes->Id_Responsable->Visible) { // Id_Responsable ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Id_Responsable) == "") { ?>
		<td><span id="elh_ca_almacenes_Id_Responsable" class="ca_almacenes_Id_Responsable"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_almacenes->Id_Responsable->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Id_Responsable) ?>',2);"><span id="elh_ca_almacenes_Id_Responsable" class="ca_almacenes_Id_Responsable">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Id_Responsable->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Id_Responsable->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Id_Responsable->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_almacenes->Telefonos->Visible) { // Telefonos ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Telefonos) == "") { ?>
		<td><span id="elh_ca_almacenes_Telefonos" class="ca_almacenes_Telefonos"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_almacenes->Telefonos->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Telefonos) ?>',2);"><span id="elh_ca_almacenes_Telefonos" class="ca_almacenes_Telefonos">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Telefonos->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Telefonos->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Telefonos->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_almacenes->Categoria->Visible) { // Categoria ?>
	<?php if ($ca_almacenes->SortUrl($ca_almacenes->Categoria) == "") { ?>
		<td><span id="elh_ca_almacenes_Categoria" class="ca_almacenes_Categoria"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_almacenes->Categoria->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_almacenes->SortUrl($ca_almacenes->Categoria) ?>',2);"><span id="elh_ca_almacenes_Categoria" class="ca_almacenes_Categoria">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_almacenes->Categoria->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_almacenes->Categoria->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_almacenes->Categoria->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ca_almacenes_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ca_almacenes->ExportAll && $ca_almacenes->Export <> "") {
	$ca_almacenes_list->StopRec = $ca_almacenes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ca_almacenes_list->TotalRecs > $ca_almacenes_list->StartRec + $ca_almacenes_list->DisplayRecs - 1)
		$ca_almacenes_list->StopRec = $ca_almacenes_list->StartRec + $ca_almacenes_list->DisplayRecs - 1;
	else
		$ca_almacenes_list->StopRec = $ca_almacenes_list->TotalRecs;
}
$ca_almacenes_list->RecCnt = $ca_almacenes_list->StartRec - 1;
if ($ca_almacenes_list->Recordset && !$ca_almacenes_list->Recordset->EOF) {
	$ca_almacenes_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ca_almacenes_list->StartRec > 1)
		$ca_almacenes_list->Recordset->Move($ca_almacenes_list->StartRec - 1);
} elseif (!$ca_almacenes->AllowAddDeleteRow && $ca_almacenes_list->StopRec == 0) {
	$ca_almacenes_list->StopRec = $ca_almacenes->GridAddRowCount;
}

// Initialize aggregate
$ca_almacenes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ca_almacenes->ResetAttrs();
$ca_almacenes_list->RenderRow();
while ($ca_almacenes_list->RecCnt < $ca_almacenes_list->StopRec) {
	$ca_almacenes_list->RecCnt++;
	if (intval($ca_almacenes_list->RecCnt) >= intval($ca_almacenes_list->StartRec)) {
		$ca_almacenes_list->RowCnt++;

		// Set up key count
		$ca_almacenes_list->KeyCount = $ca_almacenes_list->RowIndex;

		// Init row class and style
		$ca_almacenes->ResetAttrs();
		$ca_almacenes->CssClass = "";
		if ($ca_almacenes->CurrentAction == "gridadd") {
		} else {
			$ca_almacenes_list->LoadRowValues($ca_almacenes_list->Recordset); // Load row values
		}
		$ca_almacenes->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ca_almacenes->RowAttrs = array_merge($ca_almacenes->RowAttrs, array('data-rowindex'=>$ca_almacenes_list->RowCnt, 'id'=>'r' . $ca_almacenes_list->RowCnt . '_ca_almacenes', 'data-rowtype'=>$ca_almacenes->RowType));

		// Render row
		$ca_almacenes_list->RenderRow();

		// Render list options
		$ca_almacenes_list->RenderListOptions();
?>
	<tr<?php echo $ca_almacenes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_almacenes_list->ListOptions->Render("body", "left", $ca_almacenes_list->RowCnt);
?>
	<?php if ($ca_almacenes->Id_Almacen->Visible) { // Id_Almacen ?>
		<td<?php echo $ca_almacenes->Id_Almacen->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Id_Almacen" class="ca_almacenes_Id_Almacen">
<span<?php echo $ca_almacenes->Id_Almacen->ViewAttributes() ?>>
<?php echo $ca_almacenes->Id_Almacen->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_almacenes->Almacen->Visible) { // Almacen ?>
		<td<?php echo $ca_almacenes->Almacen->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Almacen" class="ca_almacenes_Almacen">
<span<?php echo $ca_almacenes->Almacen->ViewAttributes() ?>>
<?php echo $ca_almacenes->Almacen->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_almacenes->Nombre_Corto->Visible) { // Nombre_Corto ?>
		<td<?php echo $ca_almacenes->Nombre_Corto->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Nombre_Corto" class="ca_almacenes_Nombre_Corto">
<span<?php echo $ca_almacenes->Nombre_Corto->ViewAttributes() ?>>
<?php echo $ca_almacenes->Nombre_Corto->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_almacenes->Id_Responsable->Visible) { // Id_Responsable ?>
		<td<?php echo $ca_almacenes->Id_Responsable->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Id_Responsable" class="ca_almacenes_Id_Responsable">
<span<?php echo $ca_almacenes->Id_Responsable->ViewAttributes() ?>>
<?php echo $ca_almacenes->Id_Responsable->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_almacenes->Telefonos->Visible) { // Telefonos ?>
		<td<?php echo $ca_almacenes->Telefonos->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Telefonos" class="ca_almacenes_Telefonos">
<span<?php echo $ca_almacenes->Telefonos->ViewAttributes() ?>>
<?php echo $ca_almacenes->Telefonos->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_almacenes->Categoria->Visible) { // Categoria ?>
		<td<?php echo $ca_almacenes->Categoria->CellAttributes() ?>><span id="el<?php echo $ca_almacenes_list->RowCnt ?>_ca_almacenes_Categoria" class="ca_almacenes_Categoria">
<span<?php echo $ca_almacenes->Categoria->ViewAttributes() ?>>
<?php echo $ca_almacenes->Categoria->ListViewValue() ?></span>
</span><a id="<?php echo $ca_almacenes_list->PageObjName . "_row_" . $ca_almacenes_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_almacenes_list->ListOptions->Render("body", "right", $ca_almacenes_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ca_almacenes->CurrentAction <> "gridadd")
		$ca_almacenes_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ca_almacenes->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ca_almacenes_list->Recordset)
	$ca_almacenes_list->Recordset->Close();
?>
<?php if ($ca_almacenes_list->TotalRecs > 0) { ?>
<?php if ($ca_almacenes->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ca_almacenes->CurrentAction <> "gridadd" && $ca_almacenes->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_almacenes_list->Pager)) $ca_almacenes_list->Pager = new cNumericPager($ca_almacenes_list->StartRec, $ca_almacenes_list->DisplayRecs, $ca_almacenes_list->TotalRecs, $ca_almacenes_list->RecRange) ?>
<?php if ($ca_almacenes_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_almacenes_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_almacenes_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_almacenes_list->PageUrl() ?>start=<?php echo $ca_almacenes_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_almacenes_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_almacenes_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_almacenes_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_almacenes_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_almacenes">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_almacenes_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_almacenes_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_almacenes_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_almacenes_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_almacenes_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_almacenes_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_almacenes_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($ca_almacenes->Export == "") { ?>
<script type="text/javascript">
fca_almaceneslist.Init();
</script>
<?php } ?>
<?php
$ca_almacenes_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ca_almacenes->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ca_almacenes_list->Page_Terminate();
?>
