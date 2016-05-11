<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_proveedoresinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_proveedores_list = NULL; // Initialize page object first

class cca_proveedores_list extends cca_proveedores {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_proveedores';

	// Page object name
	var $PageObjName = 'ca_proveedores_list';

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

		// Table object (ca_proveedores)
		if (!isset($GLOBALS["ca_proveedores"])) {
			$GLOBALS["ca_proveedores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_proveedores"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ca_proveedoresadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ca_proveedoresdelete.php";
		$this->MultiUpdateUrl = "ca_proveedoresupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_proveedores', TRUE);

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
			$this->Id_Proveedor->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Proveedor->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->RazonSocial); // RazonSocial
			$this->UpdateSort($this->NombreContacto); // NombreContacto
			$this->UpdateSort($this->Poblacion); // Poblacion
			$this->UpdateSort($this->Id_Estado); // Id_Estado
			$this->UpdateSort($this->Telefonos); // Telefonos
			$this->UpdateSort($this->Celular); // Celular
			$this->UpdateSort($this->Maneja_Papeleta); // Maneja_Papeleta
			$this->UpdateSort($this->Maneja_Activacion_Movi); // Maneja_Activacion_Movi
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
				$this->RazonSocial->setSort("");
				$this->NombreContacto->setSort("");
				$this->Poblacion->setSort("");
				$this->Id_Estado->setSort("");
				$this->Telefonos->setSort("");
				$this->Celular->setSort("");
				$this->Maneja_Papeleta->setSort("");
				$this->Maneja_Activacion_Movi->setSort("");
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
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->RazonSocial->setDbValue($rs->fields('RazonSocial'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->NombreContacto->setDbValue($rs->fields('NombreContacto'));
		$this->CalleYNumero->setDbValue($rs->fields('CalleYNumero'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->Municipio_Delegacion->setDbValue($rs->fields('Municipio_Delegacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->Banco->setDbValue($rs->fields('Banco'));
		$this->NumCuenta->setDbValue($rs->fields('NumCuenta'));
		$this->CLABE->setDbValue($rs->fields('CLABE'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Proveedor")) <> "")
			$this->Id_Proveedor->CurrentValue = $this->getKey("Id_Proveedor"); // Id_Proveedor
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
		// Id_Proveedor
		// RazonSocial
		// RFC
		// NombreContacto
		// CalleYNumero
		// Colonia
		// Poblacion
		// Municipio_Delegacion
		// Id_Estado
		// CP
		// EMail
		// Telefonos
		// Celular
		// Fax
		// Banco
		// NumCuenta
		// CLABE
		// Maneja_Papeleta
		// Observaciones
		// Maneja_Activacion_Movi

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// RazonSocial
			$this->RazonSocial->ViewValue = $this->RazonSocial->CurrentValue;
			$this->RazonSocial->ViewValue = strtoupper($this->RazonSocial->ViewValue);
			$this->RazonSocial->ViewCustomAttributes = "";

			// NombreContacto
			$this->NombreContacto->ViewValue = $this->NombreContacto->CurrentValue;
			$this->NombreContacto->ViewValue = strtoupper($this->NombreContacto->ViewValue);
			$this->NombreContacto->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewValue = strtoupper($this->Poblacion->ViewValue);
			$this->Poblacion->ViewCustomAttributes = "";

			// Id_Estado
			if (strval($this->Id_Estado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Estado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
				}
			} else {
				$this->Id_Estado->ViewValue = NULL;
			}
			$this->Id_Estado->ViewCustomAttributes = "";

			// Telefonos
			$this->Telefonos->ViewValue = $this->Telefonos->CurrentValue;
			$this->Telefonos->ViewCustomAttributes = "";

			// Celular
			$this->Celular->ViewValue = $this->Celular->CurrentValue;
			$this->Celular->ViewCustomAttributes = "";

			// Maneja_Papeleta
			if (strval($this->Maneja_Papeleta->CurrentValue) <> "") {
				switch ($this->Maneja_Papeleta->CurrentValue) {
					case $this->Maneja_Papeleta->FldTagValue(1):
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(1) <> "" ? $this->Maneja_Papeleta->FldTagCaption(1) : $this->Maneja_Papeleta->CurrentValue;
						break;
					case $this->Maneja_Papeleta->FldTagValue(2):
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(2) <> "" ? $this->Maneja_Papeleta->FldTagCaption(2) : $this->Maneja_Papeleta->CurrentValue;
						break;
					default:
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->CurrentValue;
				}
			} else {
				$this->Maneja_Papeleta->ViewValue = NULL;
			}
			$this->Maneja_Papeleta->ViewCustomAttributes = "";

			// Maneja_Activacion_Movi
			if (strval($this->Maneja_Activacion_Movi->CurrentValue) <> "") {
				switch ($this->Maneja_Activacion_Movi->CurrentValue) {
					case $this->Maneja_Activacion_Movi->FldTagValue(1):
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(1) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(1) : $this->Maneja_Activacion_Movi->CurrentValue;
						break;
					case $this->Maneja_Activacion_Movi->FldTagValue(2):
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(2) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(2) : $this->Maneja_Activacion_Movi->CurrentValue;
						break;
					default:
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
				}
			} else {
				$this->Maneja_Activacion_Movi->ViewValue = NULL;
			}
			$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

			// RazonSocial
			$this->RazonSocial->LinkCustomAttributes = "";
			$this->RazonSocial->HrefValue = "";
			$this->RazonSocial->TooltipValue = "";

			// NombreContacto
			$this->NombreContacto->LinkCustomAttributes = "";
			$this->NombreContacto->HrefValue = "";
			$this->NombreContacto->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Telefonos
			$this->Telefonos->LinkCustomAttributes = "";
			$this->Telefonos->HrefValue = "";
			$this->Telefonos->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->LinkCustomAttributes = "";
			$this->Maneja_Papeleta->HrefValue = "";
			$this->Maneja_Papeleta->TooltipValue = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->LinkCustomAttributes = "";
			$this->Maneja_Activacion_Movi->HrefValue = "";
			$this->Maneja_Activacion_Movi->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
if (!isset($ca_proveedores_list)) $ca_proveedores_list = new cca_proveedores_list();

// Page init
$ca_proveedores_list->Page_Init();

// Page main
$ca_proveedores_list->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_proveedores_list = new ew_Page("ca_proveedores_list");
ca_proveedores_list.PageID = "list"; // Page ID
var EW_PAGE_ID = ca_proveedores_list.PageID; // For backward compatibility

// Form object
var fca_proveedoreslist = new ew_Form("fca_proveedoreslist");

// Form_CustomValidate event
fca_proveedoreslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_proveedoreslist.ValidateRequired = true;
<?php } else { ?>
fca_proveedoreslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_proveedoreslist.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$ca_proveedores_list->TotalRecs = $ca_proveedores->SelectRecordCount();
	} else {
		if ($ca_proveedores_list->Recordset = $ca_proveedores_list->LoadRecordset())
			$ca_proveedores_list->TotalRecs = $ca_proveedores_list->Recordset->RecordCount();
	}
	$ca_proveedores_list->StartRec = 1;
	if ($ca_proveedores_list->DisplayRecs <= 0 || ($ca_proveedores->Export <> "" && $ca_proveedores->ExportAll)) // Display all records
		$ca_proveedores_list->DisplayRecs = $ca_proveedores_list->TotalRecs;
	if (!($ca_proveedores->Export <> "" && $ca_proveedores->ExportAll))
		$ca_proveedores_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ca_proveedores_list->Recordset = $ca_proveedores_list->LoadRecordset($ca_proveedores_list->StartRec-1, $ca_proveedores_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_proveedores->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $ca_proveedores_list->ExportOptions->Render("body"); ?>
</p>
<?php $ca_proveedores_list->ShowPageHeader(); ?>
<?php
$ca_proveedores_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridUpperPanel">
<?php if ($ca_proveedores->CurrentAction <> "gridadd" && $ca_proveedores->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($ca_proveedores_list->Pager)) $ca_proveedores_list->Pager = new cPrevNextPager($ca_proveedores_list->StartRec, $ca_proveedores_list->DisplayRecs, $ca_proveedores_list->TotalRecs) ?>
<?php if ($ca_proveedores_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($ca_proveedores_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ca_proveedores_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ca_proveedores_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ca_proveedores_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ca_proveedores_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_proveedores_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($ca_proveedores_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_proveedores">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_proveedores_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_proveedores_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_proveedores_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_proveedores_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($ca_proveedores->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_proveedores_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_proveedores_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<form name="fca_proveedoreslist" id="fca_proveedoreslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="ca_proveedores">
<div id="gmp_ca_proveedores" class="ewGridMiddlePanel">
<?php if ($ca_proveedores_list->TotalRecs > 0) { ?>
<table id="tbl_ca_proveedoreslist" class="ewTable ewTableSeparate">
<?php echo $ca_proveedores->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ca_proveedores_list->RenderListOptions();

// Render list options (header, left)
$ca_proveedores_list->ListOptions->Render("header", "left");
?>
<?php if ($ca_proveedores->RazonSocial->Visible) { // RazonSocial ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->RazonSocial) == "") { ?>
		<td><span id="elh_ca_proveedores_RazonSocial" class="ca_proveedores_RazonSocial"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->RazonSocial->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->RazonSocial) ?>',1);"><span id="elh_ca_proveedores_RazonSocial" class="ca_proveedores_RazonSocial">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->RazonSocial->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->RazonSocial->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->RazonSocial->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->NombreContacto->Visible) { // NombreContacto ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->NombreContacto) == "") { ?>
		<td><span id="elh_ca_proveedores_NombreContacto" class="ca_proveedores_NombreContacto"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->NombreContacto->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->NombreContacto) ?>',1);"><span id="elh_ca_proveedores_NombreContacto" class="ca_proveedores_NombreContacto">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->NombreContacto->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->NombreContacto->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->NombreContacto->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Poblacion->Visible) { // Poblacion ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Poblacion) == "") { ?>
		<td><span id="elh_ca_proveedores_Poblacion" class="ca_proveedores_Poblacion"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Poblacion->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Poblacion) ?>',1);"><span id="elh_ca_proveedores_Poblacion" class="ca_proveedores_Poblacion">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Poblacion->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Poblacion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Poblacion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Id_Estado) == "") { ?>
		<td><span id="elh_ca_proveedores_Id_Estado" class="ca_proveedores_Id_Estado"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Id_Estado->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Id_Estado) ?>',1);"><span id="elh_ca_proveedores_Id_Estado" class="ca_proveedores_Id_Estado">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Id_Estado->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Id_Estado->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Id_Estado->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Telefonos->Visible) { // Telefonos ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Telefonos) == "") { ?>
		<td><span id="elh_ca_proveedores_Telefonos" class="ca_proveedores_Telefonos"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Telefonos->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Telefonos) ?>',1);"><span id="elh_ca_proveedores_Telefonos" class="ca_proveedores_Telefonos">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Telefonos->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Telefonos->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Telefonos->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Celular->Visible) { // Celular ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Celular) == "") { ?>
		<td><span id="elh_ca_proveedores_Celular" class="ca_proveedores_Celular"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Celular->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Celular) ?>',1);"><span id="elh_ca_proveedores_Celular" class="ca_proveedores_Celular">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Celular->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Celular->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Celular->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Maneja_Papeleta->Visible) { // Maneja_Papeleta ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Maneja_Papeleta) == "") { ?>
		<td><span id="elh_ca_proveedores_Maneja_Papeleta" class="ca_proveedores_Maneja_Papeleta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Maneja_Papeleta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Maneja_Papeleta) ?>',1);"><span id="elh_ca_proveedores_Maneja_Papeleta" class="ca_proveedores_Maneja_Papeleta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Maneja_Papeleta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Maneja_Papeleta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Maneja_Papeleta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_proveedores->Maneja_Activacion_Movi->Visible) { // Maneja_Activacion_Movi ?>
	<?php if ($ca_proveedores->SortUrl($ca_proveedores->Maneja_Activacion_Movi) == "") { ?>
		<td><span id="elh_ca_proveedores_Maneja_Activacion_Movi" class="ca_proveedores_Maneja_Activacion_Movi"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_proveedores->Maneja_Activacion_Movi->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_proveedores->SortUrl($ca_proveedores->Maneja_Activacion_Movi) ?>',1);"><span id="elh_ca_proveedores_Maneja_Activacion_Movi" class="ca_proveedores_Maneja_Activacion_Movi">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_proveedores->Maneja_Activacion_Movi->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_proveedores->Maneja_Activacion_Movi->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_proveedores->Maneja_Activacion_Movi->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ca_proveedores_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ca_proveedores->ExportAll && $ca_proveedores->Export <> "") {
	$ca_proveedores_list->StopRec = $ca_proveedores_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ca_proveedores_list->TotalRecs > $ca_proveedores_list->StartRec + $ca_proveedores_list->DisplayRecs - 1)
		$ca_proveedores_list->StopRec = $ca_proveedores_list->StartRec + $ca_proveedores_list->DisplayRecs - 1;
	else
		$ca_proveedores_list->StopRec = $ca_proveedores_list->TotalRecs;
}
$ca_proveedores_list->RecCnt = $ca_proveedores_list->StartRec - 1;
if ($ca_proveedores_list->Recordset && !$ca_proveedores_list->Recordset->EOF) {
	$ca_proveedores_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ca_proveedores_list->StartRec > 1)
		$ca_proveedores_list->Recordset->Move($ca_proveedores_list->StartRec - 1);
} elseif (!$ca_proveedores->AllowAddDeleteRow && $ca_proveedores_list->StopRec == 0) {
	$ca_proveedores_list->StopRec = $ca_proveedores->GridAddRowCount;
}

// Initialize aggregate
$ca_proveedores->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ca_proveedores->ResetAttrs();
$ca_proveedores_list->RenderRow();
while ($ca_proveedores_list->RecCnt < $ca_proveedores_list->StopRec) {
	$ca_proveedores_list->RecCnt++;
	if (intval($ca_proveedores_list->RecCnt) >= intval($ca_proveedores_list->StartRec)) {
		$ca_proveedores_list->RowCnt++;

		// Set up key count
		$ca_proveedores_list->KeyCount = $ca_proveedores_list->RowIndex;

		// Init row class and style
		$ca_proveedores->ResetAttrs();
		$ca_proveedores->CssClass = "";
		if ($ca_proveedores->CurrentAction == "gridadd") {
		} else {
			$ca_proveedores_list->LoadRowValues($ca_proveedores_list->Recordset); // Load row values
		}
		$ca_proveedores->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ca_proveedores->RowAttrs = array_merge($ca_proveedores->RowAttrs, array('data-rowindex'=>$ca_proveedores_list->RowCnt, 'id'=>'r' . $ca_proveedores_list->RowCnt . '_ca_proveedores', 'data-rowtype'=>$ca_proveedores->RowType));

		// Render row
		$ca_proveedores_list->RenderRow();

		// Render list options
		$ca_proveedores_list->RenderListOptions();
?>
	<tr<?php echo $ca_proveedores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_proveedores_list->ListOptions->Render("body", "left", $ca_proveedores_list->RowCnt);
?>
	<?php if ($ca_proveedores->RazonSocial->Visible) { // RazonSocial ?>
		<td<?php echo $ca_proveedores->RazonSocial->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_RazonSocial" class="ca_proveedores_RazonSocial">
<span<?php echo $ca_proveedores->RazonSocial->ViewAttributes() ?>>
<?php echo $ca_proveedores->RazonSocial->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->NombreContacto->Visible) { // NombreContacto ?>
		<td<?php echo $ca_proveedores->NombreContacto->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_NombreContacto" class="ca_proveedores_NombreContacto">
<span<?php echo $ca_proveedores->NombreContacto->ViewAttributes() ?>>
<?php echo $ca_proveedores->NombreContacto->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Poblacion->Visible) { // Poblacion ?>
		<td<?php echo $ca_proveedores->Poblacion->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Poblacion" class="ca_proveedores_Poblacion">
<span<?php echo $ca_proveedores->Poblacion->ViewAttributes() ?>>
<?php echo $ca_proveedores->Poblacion->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Id_Estado->Visible) { // Id_Estado ?>
		<td<?php echo $ca_proveedores->Id_Estado->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Id_Estado" class="ca_proveedores_Id_Estado">
<span<?php echo $ca_proveedores->Id_Estado->ViewAttributes() ?>>
<?php echo $ca_proveedores->Id_Estado->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Telefonos->Visible) { // Telefonos ?>
		<td<?php echo $ca_proveedores->Telefonos->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Telefonos" class="ca_proveedores_Telefonos">
<span<?php echo $ca_proveedores->Telefonos->ViewAttributes() ?>>
<?php echo $ca_proveedores->Telefonos->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Celular->Visible) { // Celular ?>
		<td<?php echo $ca_proveedores->Celular->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Celular" class="ca_proveedores_Celular">
<span<?php echo $ca_proveedores->Celular->ViewAttributes() ?>>
<?php echo $ca_proveedores->Celular->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Maneja_Papeleta->Visible) { // Maneja_Papeleta ?>
		<td<?php echo $ca_proveedores->Maneja_Papeleta->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Maneja_Papeleta" class="ca_proveedores_Maneja_Papeleta">
<span<?php echo $ca_proveedores->Maneja_Papeleta->ViewAttributes() ?>>
<?php echo $ca_proveedores->Maneja_Papeleta->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_proveedores->Maneja_Activacion_Movi->Visible) { // Maneja_Activacion_Movi ?>
		<td<?php echo $ca_proveedores->Maneja_Activacion_Movi->CellAttributes() ?>><span id="el<?php echo $ca_proveedores_list->RowCnt ?>_ca_proveedores_Maneja_Activacion_Movi" class="ca_proveedores_Maneja_Activacion_Movi">
<span<?php echo $ca_proveedores->Maneja_Activacion_Movi->ViewAttributes() ?>>
<?php echo $ca_proveedores->Maneja_Activacion_Movi->ListViewValue() ?></span>
</span><a id="<?php echo $ca_proveedores_list->PageObjName . "_row_" . $ca_proveedores_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_proveedores_list->ListOptions->Render("body", "right", $ca_proveedores_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ca_proveedores->CurrentAction <> "gridadd")
		$ca_proveedores_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ca_proveedores->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ca_proveedores_list->Recordset)
	$ca_proveedores_list->Recordset->Close();
?>
<?php if ($ca_proveedores_list->TotalRecs > 0) { ?>
<div class="ewGridLowerPanel">
<?php if ($ca_proveedores->CurrentAction <> "gridadd" && $ca_proveedores->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($ca_proveedores_list->Pager)) $ca_proveedores_list->Pager = new cPrevNextPager($ca_proveedores_list->StartRec, $ca_proveedores_list->DisplayRecs, $ca_proveedores_list->TotalRecs) ?>
<?php if ($ca_proveedores_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($ca_proveedores_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ca_proveedores_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ca_proveedores_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ca_proveedores_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ca_proveedores_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ca_proveedores_list->PageUrl() ?>start=<?php echo $ca_proveedores_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_proveedores_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_proveedores_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($ca_proveedores_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_proveedores">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_proveedores_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_proveedores_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_proveedores_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_proveedores_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($ca_proveedores->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_proveedores_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_proveedores_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
</td></tr></table>
<script type="text/javascript">
fca_proveedoreslist.Init();
</script>
<?php
$ca_proveedores_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_proveedores_list->Page_Terminate();
?>
