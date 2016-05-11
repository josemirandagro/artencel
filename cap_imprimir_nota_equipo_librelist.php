<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_imprimir_nota_equipo_libreinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_imprimir_nota_equipo_libre_list = NULL; // Initialize page object first

class ccap_imprimir_nota_equipo_libre_list extends ccap_imprimir_nota_equipo_libre {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_imprimir_nota_equipo_libre';

	// Page object name
	var $PageObjName = 'cap_imprimir_nota_equipo_libre_list';

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

		// Table object (cap_imprimir_nota_equipo_libre)
		if (!isset($GLOBALS["cap_imprimir_nota_equipo_libre"])) {
			$GLOBALS["cap_imprimir_nota_equipo_libre"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_imprimir_nota_equipo_libre"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_imprimir_nota_equipo_libreadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_imprimir_nota_equipo_libredelete.php";
		$this->MultiUpdateUrl = "cap_imprimir_nota_equipo_libreupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_imprimir_nota_equipo_libre', TRUE);

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
			$this->Id_Tel_SIM->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Tel_SIM->FormValue))
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
			$this->UpdateSort($this->Id_Tel_SIM); // Id_Tel_SIM
			$this->UpdateSort($this->Id_Cliente); // Id_Cliente
			$this->UpdateSort($this->Num_IMEI); // Num_IMEI
			$this->UpdateSort($this->Num_ICCID); // Num_ICCID
			$this->UpdateSort($this->Num_CEL); // Num_CEL
			$this->UpdateSort($this->ImprimirNotaVenta); // ImprimirNotaVenta
			$this->UpdateSort($this->Serie_NotaVenta); // Serie_NotaVenta
			$this->UpdateSort($this->Numero_NotaVenta); // Numero_NotaVenta
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
				$this->Id_Tel_SIM->setSort("");
				$this->Id_Cliente->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_ICCID->setSort("");
				$this->Num_CEL->setSort("");
				$this->ImprimirNotaVenta->setSort("");
				$this->Serie_NotaVenta->setSort("");
				$this->Numero_NotaVenta->setSort("");
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
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->ImprimirNotaVenta->setDbValue($rs->fields('ImprimirNotaVenta'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Numero_NotaVenta->setDbValue($rs->fields('Numero_NotaVenta'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Tel_SIM")) <> "")
			$this->Id_Tel_SIM->CurrentValue = $this->getKey("Id_Tel_SIM"); // Id_Tel_SIM
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
		// Id_Tel_SIM
		// Id_Cliente
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// ImprimirNotaVenta
		// Serie_NotaVenta
		// Numero_NotaVenta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoEquipo`='LIBRE'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Cliente
			$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
			if (strval($this->Id_Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Cliente`" . ew_SearchString("=", $this->Id_Cliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Cliente`, `Nombre_Completo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_clientes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Cliente->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
				}
			} else {
				$this->Id_Cliente->ViewValue = NULL;
			}
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// ImprimirNotaVenta
			if (strval($this->ImprimirNotaVenta->CurrentValue) <> "") {
				switch ($this->ImprimirNotaVenta->CurrentValue) {
					case $this->ImprimirNotaVenta->FldTagValue(1):
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(1) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(1) : $this->ImprimirNotaVenta->CurrentValue;
						break;
					case $this->ImprimirNotaVenta->FldTagValue(2):
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(2) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(2) : $this->ImprimirNotaVenta->CurrentValue;
						break;
					default:
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->CurrentValue;
				}
			} else {
				$this->ImprimirNotaVenta->ViewValue = NULL;
			}
			$this->ImprimirNotaVenta->ViewCustomAttributes = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->ViewValue = $this->Serie_NotaVenta->CurrentValue;
			$this->Serie_NotaVenta->ViewCustomAttributes = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->ViewValue = $this->Numero_NotaVenta->CurrentValue;
			$this->Numero_NotaVenta->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Id_Cliente
			$this->Id_Cliente->LinkCustomAttributes = "";
			$this->Id_Cliente->HrefValue = "";
			$this->Id_Cliente->TooltipValue = "";

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

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->LinkCustomAttributes = "";
			$this->ImprimirNotaVenta->HrefValue = "";
			$this->ImprimirNotaVenta->TooltipValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->LinkCustomAttributes = "";
			$this->Serie_NotaVenta->HrefValue = "";
			$this->Serie_NotaVenta->TooltipValue = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->LinkCustomAttributes = "";
			$this->Numero_NotaVenta->HrefValue = "";
			$this->Numero_NotaVenta->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_cap_imprimir_nota_equipo_libre\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_imprimir_nota_equipo_libre',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_imprimir_nota_equipo_librelist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_imprimir_nota_equipo_libre_list)) $cap_imprimir_nota_equipo_libre_list = new ccap_imprimir_nota_equipo_libre_list();

// Page init
$cap_imprimir_nota_equipo_libre_list->Page_Init();

// Page main
$cap_imprimir_nota_equipo_libre_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_imprimir_nota_equipo_libre->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_imprimir_nota_equipo_libre_list = new ew_Page("cap_imprimir_nota_equipo_libre_list");
cap_imprimir_nota_equipo_libre_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_imprimir_nota_equipo_libre_list.PageID; // For backward compatibility

// Form object
var fcap_imprimir_nota_equipo_librelist = new ew_Form("fcap_imprimir_nota_equipo_librelist");

// Form_CustomValidate event
fcap_imprimir_nota_equipo_librelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_imprimir_nota_equipo_librelist.ValidateRequired = true;
<?php } else { ?>
fcap_imprimir_nota_equipo_librelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_imprimir_nota_equipo_librelist.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_nota_equipo_librelist.Lists["x_Id_Cliente"] = {"LinkField":"x_Id_Cliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre_Completo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
		$cap_imprimir_nota_equipo_libre_list->TotalRecs = $cap_imprimir_nota_equipo_libre->SelectRecordCount();
	} else {
		if ($cap_imprimir_nota_equipo_libre_list->Recordset = $cap_imprimir_nota_equipo_libre_list->LoadRecordset())
			$cap_imprimir_nota_equipo_libre_list->TotalRecs = $cap_imprimir_nota_equipo_libre_list->Recordset->RecordCount();
	}
	$cap_imprimir_nota_equipo_libre_list->StartRec = 1;
	if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs <= 0 || ($cap_imprimir_nota_equipo_libre->Export <> "" && $cap_imprimir_nota_equipo_libre->ExportAll)) // Display all records
		$cap_imprimir_nota_equipo_libre_list->DisplayRecs = $cap_imprimir_nota_equipo_libre_list->TotalRecs;
	if (!($cap_imprimir_nota_equipo_libre->Export <> "" && $cap_imprimir_nota_equipo_libre->ExportAll))
		$cap_imprimir_nota_equipo_libre_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_imprimir_nota_equipo_libre_list->Recordset = $cap_imprimir_nota_equipo_libre_list->LoadRecordset($cap_imprimir_nota_equipo_libre_list->StartRec-1, $cap_imprimir_nota_equipo_libre_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_imprimir_nota_equipo_libre->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_imprimir_nota_equipo_libre_list->ExportOptions->Render("body"); ?>
</p>
<?php $cap_imprimir_nota_equipo_libre_list->ShowPageHeader(); ?>
<?php
$cap_imprimir_nota_equipo_libre_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_imprimir_nota_equipo_libre->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_imprimir_nota_equipo_libre->CurrentAction <> "gridadd" && $cap_imprimir_nota_equipo_libre->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_imprimir_nota_equipo_libre_list->Pager)) $cap_imprimir_nota_equipo_libre_list->Pager = new cPrevNextPager($cap_imprimir_nota_equipo_libre_list->StartRec, $cap_imprimir_nota_equipo_libre_list->DisplayRecs, $cap_imprimir_nota_equipo_libre_list->TotalRecs) ?>
<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_imprimir_nota_equipo_libre_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_imprimir_nota_equipo_libre_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_imprimir_nota_equipo_libre">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_imprimir_nota_equipo_libre->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<form name="fcap_imprimir_nota_equipo_librelist" id="fcap_imprimir_nota_equipo_librelist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_imprimir_nota_equipo_libre">
<div id="gmp_cap_imprimir_nota_equipo_libre" class="ewGridMiddlePanel">
<?php if ($cap_imprimir_nota_equipo_libre_list->TotalRecs > 0) { ?>
<table id="tbl_cap_imprimir_nota_equipo_librelist" class="ewTable ewTableSeparate">
<?php echo $cap_imprimir_nota_equipo_libre->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_imprimir_nota_equipo_libre_list->RenderListOptions();

// Render list options (header, left)
$cap_imprimir_nota_equipo_libre_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Id_Tel_SIM" class="cap_imprimir_nota_equipo_libre_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Id_Tel_SIM) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Id_Tel_SIM" class="cap_imprimir_nota_equipo_libre_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Id_Cliente->Visible) { // Id_Cliente ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Id_Cliente) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Id_Cliente" class="cap_imprimir_nota_equipo_libre_Id_Cliente"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Id_Cliente) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Id_Cliente" class="cap_imprimir_nota_equipo_libre_Id_Cliente">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Id_Cliente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Id_Cliente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Num_IMEI" class="cap_imprimir_nota_equipo_libre_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_IMEI) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Num_IMEI" class="cap_imprimir_nota_equipo_libre_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_ICCID) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Num_ICCID" class="cap_imprimir_nota_equipo_libre_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_ICCID) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Num_ICCID" class="cap_imprimir_nota_equipo_libre_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_CEL) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Num_CEL" class="cap_imprimir_nota_equipo_libre_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Num_CEL) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Num_CEL" class="cap_imprimir_nota_equipo_libre_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->Visible) { // ImprimirNotaVenta ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_ImprimirNotaVenta" class="cap_imprimir_nota_equipo_libre_ImprimirNotaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_ImprimirNotaVenta" class="cap_imprimir_nota_equipo_libre_ImprimirNotaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Serie_NotaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Serie_NotaVenta" class="cap_imprimir_nota_equipo_libre_Serie_NotaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Serie_NotaVenta) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Serie_NotaVenta" class="cap_imprimir_nota_equipo_libre_Serie_NotaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
	<?php if ($cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Numero_NotaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_nota_equipo_libre_Numero_NotaVenta" class="cap_imprimir_nota_equipo_libre_Numero_NotaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_nota_equipo_libre->SortUrl($cap_imprimir_nota_equipo_libre->Numero_NotaVenta) ?>',1);"><span id="elh_cap_imprimir_nota_equipo_libre_Numero_NotaVenta" class="cap_imprimir_nota_equipo_libre_Numero_NotaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_imprimir_nota_equipo_libre_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_imprimir_nota_equipo_libre->ExportAll && $cap_imprimir_nota_equipo_libre->Export <> "") {
	$cap_imprimir_nota_equipo_libre_list->StopRec = $cap_imprimir_nota_equipo_libre_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_imprimir_nota_equipo_libre_list->TotalRecs > $cap_imprimir_nota_equipo_libre_list->StartRec + $cap_imprimir_nota_equipo_libre_list->DisplayRecs - 1)
		$cap_imprimir_nota_equipo_libre_list->StopRec = $cap_imprimir_nota_equipo_libre_list->StartRec + $cap_imprimir_nota_equipo_libre_list->DisplayRecs - 1;
	else
		$cap_imprimir_nota_equipo_libre_list->StopRec = $cap_imprimir_nota_equipo_libre_list->TotalRecs;
}
$cap_imprimir_nota_equipo_libre_list->RecCnt = $cap_imprimir_nota_equipo_libre_list->StartRec - 1;
if ($cap_imprimir_nota_equipo_libre_list->Recordset && !$cap_imprimir_nota_equipo_libre_list->Recordset->EOF) {
	$cap_imprimir_nota_equipo_libre_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_imprimir_nota_equipo_libre_list->StartRec > 1)
		$cap_imprimir_nota_equipo_libre_list->Recordset->Move($cap_imprimir_nota_equipo_libre_list->StartRec - 1);
} elseif (!$cap_imprimir_nota_equipo_libre->AllowAddDeleteRow && $cap_imprimir_nota_equipo_libre_list->StopRec == 0) {
	$cap_imprimir_nota_equipo_libre_list->StopRec = $cap_imprimir_nota_equipo_libre->GridAddRowCount;
}

// Initialize aggregate
$cap_imprimir_nota_equipo_libre->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_imprimir_nota_equipo_libre->ResetAttrs();
$cap_imprimir_nota_equipo_libre_list->RenderRow();
while ($cap_imprimir_nota_equipo_libre_list->RecCnt < $cap_imprimir_nota_equipo_libre_list->StopRec) {
	$cap_imprimir_nota_equipo_libre_list->RecCnt++;
	if (intval($cap_imprimir_nota_equipo_libre_list->RecCnt) >= intval($cap_imprimir_nota_equipo_libre_list->StartRec)) {
		$cap_imprimir_nota_equipo_libre_list->RowCnt++;

		// Set up key count
		$cap_imprimir_nota_equipo_libre_list->KeyCount = $cap_imprimir_nota_equipo_libre_list->RowIndex;

		// Init row class and style
		$cap_imprimir_nota_equipo_libre->ResetAttrs();
		$cap_imprimir_nota_equipo_libre->CssClass = "";
		if ($cap_imprimir_nota_equipo_libre->CurrentAction == "gridadd") {
		} else {
			$cap_imprimir_nota_equipo_libre_list->LoadRowValues($cap_imprimir_nota_equipo_libre_list->Recordset); // Load row values
		}
		$cap_imprimir_nota_equipo_libre->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_imprimir_nota_equipo_libre->RowAttrs = array_merge($cap_imprimir_nota_equipo_libre->RowAttrs, array('data-rowindex'=>$cap_imprimir_nota_equipo_libre_list->RowCnt, 'id'=>'r' . $cap_imprimir_nota_equipo_libre_list->RowCnt . '_cap_imprimir_nota_equipo_libre', 'data-rowtype'=>$cap_imprimir_nota_equipo_libre->RowType));

		// Render row
		$cap_imprimir_nota_equipo_libre_list->RenderRow();

		// Render list options
		$cap_imprimir_nota_equipo_libre_list->RenderListOptions();
?>
	<tr<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_imprimir_nota_equipo_libre_list->ListOptions->Render("body", "left", $cap_imprimir_nota_equipo_libre_list->RowCnt);
?>
	<?php if ($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Id_Tel_SIM" class="cap_imprimir_nota_equipo_libre_Id_Tel_SIM">
<span<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Id_Cliente->Visible) { // Id_Cliente ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Id_Cliente" class="cap_imprimir_nota_equipo_libre_Id_Cliente">
<span<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Num_IMEI" class="cap_imprimir_nota_equipo_libre_Num_IMEI">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Num_ICCID" class="cap_imprimir_nota_equipo_libre_Num_ICCID">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Num_CEL" class="cap_imprimir_nota_equipo_libre_Num_CEL">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->Visible) { // ImprimirNotaVenta ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_ImprimirNotaVenta" class="cap_imprimir_nota_equipo_libre_ImprimirNotaVenta">
<span<?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Serie_NotaVenta" class="cap_imprimir_nota_equipo_libre_Serie_NotaVenta">
<span<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_nota_equipo_libre_list->RowCnt ?>_cap_imprimir_nota_equipo_libre_Numero_NotaVenta" class="cap_imprimir_nota_equipo_libre_Numero_NotaVenta">
<span<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_nota_equipo_libre_list->PageObjName . "_row_" . $cap_imprimir_nota_equipo_libre_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_imprimir_nota_equipo_libre_list->ListOptions->Render("body", "right", $cap_imprimir_nota_equipo_libre_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_imprimir_nota_equipo_libre->CurrentAction <> "gridadd")
		$cap_imprimir_nota_equipo_libre_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_imprimir_nota_equipo_libre_list->Recordset)
	$cap_imprimir_nota_equipo_libre_list->Recordset->Close();
?>
<?php if ($cap_imprimir_nota_equipo_libre_list->TotalRecs > 0) { ?>
<?php if ($cap_imprimir_nota_equipo_libre->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_imprimir_nota_equipo_libre->CurrentAction <> "gridadd" && $cap_imprimir_nota_equipo_libre->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($cap_imprimir_nota_equipo_libre_list->Pager)) $cap_imprimir_nota_equipo_libre_list->Pager = new cPrevNextPager($cap_imprimir_nota_equipo_libre_list->StartRec, $cap_imprimir_nota_equipo_libre_list->DisplayRecs, $cap_imprimir_nota_equipo_libre_list->TotalRecs) ?>
<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cap_imprimir_nota_equipo_libre_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cap_imprimir_nota_equipo_libre_list->PageUrl() ?>start=<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_imprimir_nota_equipo_libre_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_imprimir_nota_equipo_libre_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
	</td>
<?php if ($cap_imprimir_nota_equipo_libre_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_imprimir_nota_equipo_libre">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_imprimir_nota_equipo_libre_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($cap_imprimir_nota_equipo_libre->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
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
<?php if ($cap_imprimir_nota_equipo_libre->Export == "") { ?>
<script type="text/javascript">
fcap_imprimir_nota_equipo_librelist.Init();
</script>
<?php } ?>
<?php
$cap_imprimir_nota_equipo_libre_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_imprimir_nota_equipo_libre->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_imprimir_nota_equipo_libre_list->Page_Terminate();
?>
