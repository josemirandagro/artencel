<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_imprimir_docs_amigokitinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_imprimir_docs_amigokit_list = NULL; // Initialize page object first

class ccap_imprimir_docs_amigokit_list extends ccap_imprimir_docs_amigokit {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_imprimir_docs_amigokit';

	// Page object name
	var $PageObjName = 'cap_imprimir_docs_amigokit_list';

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

		// Table object (cap_imprimir_docs_amigokit)
		if (!isset($GLOBALS["cap_imprimir_docs_amigokit"])) {
			$GLOBALS["cap_imprimir_docs_amigokit"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_imprimir_docs_amigokit"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cap_imprimir_docs_amigokitadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cap_imprimir_docs_amigokitdelete.php";
		$this->MultiUpdateUrl = "cap_imprimir_docs_amigokitupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_imprimir_docs_amigokit', TRUE);

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
		$this->Id_Venta_Eq->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Venta_Eq, FALSE); // Id_Venta_Eq
		$this->BuildSearchSql($sWhere, $this->FechaVenta, FALSE); // FechaVenta
		$this->BuildSearchSql($sWhere, $this->Id_Tienda, FALSE); // Id_Tienda
		$this->BuildSearchSql($sWhere, $this->Id_Tel_SIM, FALSE); // Id_Tel_SIM
		$this->BuildSearchSql($sWhere, $this->Id_Cliente, FALSE); // Id_Cliente
		$this->BuildSearchSql($sWhere, $this->Num_IMEI, FALSE); // Num_IMEI
		$this->BuildSearchSql($sWhere, $this->Num_ICCID, FALSE); // Num_ICCID
		$this->BuildSearchSql($sWhere, $this->Num_CEL, FALSE); // Num_CEL
		$this->BuildSearchSql($sWhere, $this->Descripcion_SIM, FALSE); // Descripcion_SIM
		$this->BuildSearchSql($sWhere, $this->Reg_Venta_Movi, FALSE); // Reg_Venta_Movi
		$this->BuildSearchSql($sWhere, $this->Monto_Recarga_Movi, FALSE); // Monto_Recarga_Movi
		$this->BuildSearchSql($sWhere, $this->Folio_Recarga_Movi, FALSE); // Folio_Recarga_Movi
		$this->BuildSearchSql($sWhere, $this->ImprimirNotaVenta, FALSE); // ImprimirNotaVenta
		$this->BuildSearchSql($sWhere, $this->Serie_NotaVenta, FALSE); // Serie_NotaVenta
		$this->BuildSearchSql($sWhere, $this->Numero_NotaVenta, FALSE); // Numero_NotaVenta
		$this->BuildSearchSql($sWhere, $this->Imprimirpapeleta, FALSE); // Imprimirpapeleta
		$this->BuildSearchSql($sWhere, $this->FolioImpresoPapeleta, FALSE); // FolioImpresoPapeleta
		$this->BuildSearchSql($sWhere, $this->Maneja_Papeleta, FALSE); // Maneja_Papeleta
		$this->BuildSearchSql($sWhere, $this->Maneja_Activacion_Movi, FALSE); // Maneja_Activacion_Movi
		$this->BuildSearchSql($sWhere, $this->Con_SIM, FALSE); // Con_SIM

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Venta_Eq->AdvancedSearch->Save(); // Id_Venta_Eq
			$this->FechaVenta->AdvancedSearch->Save(); // FechaVenta
			$this->Id_Tienda->AdvancedSearch->Save(); // Id_Tienda
			$this->Id_Tel_SIM->AdvancedSearch->Save(); // Id_Tel_SIM
			$this->Id_Cliente->AdvancedSearch->Save(); // Id_Cliente
			$this->Num_IMEI->AdvancedSearch->Save(); // Num_IMEI
			$this->Num_ICCID->AdvancedSearch->Save(); // Num_ICCID
			$this->Num_CEL->AdvancedSearch->Save(); // Num_CEL
			$this->Descripcion_SIM->AdvancedSearch->Save(); // Descripcion_SIM
			$this->Reg_Venta_Movi->AdvancedSearch->Save(); // Reg_Venta_Movi
			$this->Monto_Recarga_Movi->AdvancedSearch->Save(); // Monto_Recarga_Movi
			$this->Folio_Recarga_Movi->AdvancedSearch->Save(); // Folio_Recarga_Movi
			$this->ImprimirNotaVenta->AdvancedSearch->Save(); // ImprimirNotaVenta
			$this->Serie_NotaVenta->AdvancedSearch->Save(); // Serie_NotaVenta
			$this->Numero_NotaVenta->AdvancedSearch->Save(); // Numero_NotaVenta
			$this->Imprimirpapeleta->AdvancedSearch->Save(); // Imprimirpapeleta
			$this->FolioImpresoPapeleta->AdvancedSearch->Save(); // FolioImpresoPapeleta
			$this->Maneja_Papeleta->AdvancedSearch->Save(); // Maneja_Papeleta
			$this->Maneja_Activacion_Movi->AdvancedSearch->Save(); // Maneja_Activacion_Movi
			$this->Con_SIM->AdvancedSearch->Save(); // Con_SIM
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

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->Id_Venta_Eq->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FechaVenta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tienda->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tel_SIM->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_IMEI->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_ICCID->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_CEL->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Descripcion_SIM->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Reg_Venta_Movi->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Monto_Recarga_Movi->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Folio_Recarga_Movi->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ImprimirNotaVenta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Serie_NotaVenta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Numero_NotaVenta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Imprimirpapeleta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FolioImpresoPapeleta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Maneja_Papeleta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Maneja_Activacion_Movi->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Con_SIM->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Id_Venta_Eq->AdvancedSearch->UnsetSession();
		$this->FechaVenta->AdvancedSearch->UnsetSession();
		$this->Id_Tienda->AdvancedSearch->UnsetSession();
		$this->Id_Tel_SIM->AdvancedSearch->UnsetSession();
		$this->Id_Cliente->AdvancedSearch->UnsetSession();
		$this->Num_IMEI->AdvancedSearch->UnsetSession();
		$this->Num_ICCID->AdvancedSearch->UnsetSession();
		$this->Num_CEL->AdvancedSearch->UnsetSession();
		$this->Descripcion_SIM->AdvancedSearch->UnsetSession();
		$this->Reg_Venta_Movi->AdvancedSearch->UnsetSession();
		$this->Monto_Recarga_Movi->AdvancedSearch->UnsetSession();
		$this->Folio_Recarga_Movi->AdvancedSearch->UnsetSession();
		$this->ImprimirNotaVenta->AdvancedSearch->UnsetSession();
		$this->Serie_NotaVenta->AdvancedSearch->UnsetSession();
		$this->Numero_NotaVenta->AdvancedSearch->UnsetSession();
		$this->Imprimirpapeleta->AdvancedSearch->UnsetSession();
		$this->FolioImpresoPapeleta->AdvancedSearch->UnsetSession();
		$this->Maneja_Papeleta->AdvancedSearch->UnsetSession();
		$this->Maneja_Activacion_Movi->AdvancedSearch->UnsetSession();
		$this->Con_SIM->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore advanced search values
		$this->Id_Venta_Eq->AdvancedSearch->Load();
		$this->FechaVenta->AdvancedSearch->Load();
		$this->Id_Tienda->AdvancedSearch->Load();
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Descripcion_SIM->AdvancedSearch->Load();
		$this->Reg_Venta_Movi->AdvancedSearch->Load();
		$this->Monto_Recarga_Movi->AdvancedSearch->Load();
		$this->Folio_Recarga_Movi->AdvancedSearch->Load();
		$this->ImprimirNotaVenta->AdvancedSearch->Load();
		$this->Serie_NotaVenta->AdvancedSearch->Load();
		$this->Numero_NotaVenta->AdvancedSearch->Load();
		$this->Imprimirpapeleta->AdvancedSearch->Load();
		$this->FolioImpresoPapeleta->AdvancedSearch->Load();
		$this->Maneja_Papeleta->AdvancedSearch->Load();
		$this->Maneja_Activacion_Movi->AdvancedSearch->Load();
		$this->Con_SIM->AdvancedSearch->Load();
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
			$this->UpdateSort($this->FechaVenta, $bCtrl); // FechaVenta
			$this->UpdateSort($this->Id_Tienda, $bCtrl); // Id_Tienda
			$this->UpdateSort($this->Id_Tel_SIM, $bCtrl); // Id_Tel_SIM
			$this->UpdateSort($this->Id_Cliente, $bCtrl); // Id_Cliente
			$this->UpdateSort($this->Num_IMEI, $bCtrl); // Num_IMEI
			$this->UpdateSort($this->Num_ICCID, $bCtrl); // Num_ICCID
			$this->UpdateSort($this->Num_CEL, $bCtrl); // Num_CEL
			$this->UpdateSort($this->Descripcion_SIM, $bCtrl); // Descripcion_SIM
			$this->UpdateSort($this->Serie_NotaVenta, $bCtrl); // Serie_NotaVenta
			$this->UpdateSort($this->Numero_NotaVenta, $bCtrl); // Numero_NotaVenta
			$this->UpdateSort($this->FolioImpresoPapeleta, $bCtrl); // FolioImpresoPapeleta
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
				$this->Id_Venta_Eq->setSort("");
				$this->FechaVenta->setSort("");
				$this->Id_Tienda->setSort("");
				$this->Id_Tel_SIM->setSort("");
				$this->Id_Cliente->setSort("");
				$this->Num_IMEI->setSort("");
				$this->Num_ICCID->setSort("");
				$this->Num_CEL->setSort("");
				$this->Descripcion_SIM->setSort("");
				$this->Serie_NotaVenta->setSort("");
				$this->Numero_NotaVenta->setSort("");
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

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Id_Venta_Eq

		$this->Id_Venta_Eq->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Venta_Eq"]);
		if ($this->Id_Venta_Eq->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Venta_Eq->AdvancedSearch->SearchOperator = @$_GET["z_Id_Venta_Eq"];

		// FechaVenta
		$this->FechaVenta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FechaVenta"]);
		if ($this->FechaVenta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FechaVenta->AdvancedSearch->SearchOperator = @$_GET["z_FechaVenta"];
		$this->FechaVenta->AdvancedSearch->SearchCondition = @$_GET["v_FechaVenta"];
		$this->FechaVenta->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_FechaVenta"]);
		if ($this->FechaVenta->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->FechaVenta->AdvancedSearch->SearchOperator2 = @$_GET["w_FechaVenta"];

		// Id_Tienda
		$this->Id_Tienda->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tienda"]);
		if ($this->Id_Tienda->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tienda->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tienda"];

		// Id_Tel_SIM
		$this->Id_Tel_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tel_SIM"]);
		if ($this->Id_Tel_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tel_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tel_SIM"];

		// Id_Cliente
		$this->Id_Cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cliente"]);
		if ($this->Id_Cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cliente->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cliente"];

		// Num_IMEI
		$this->Num_IMEI->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_IMEI"]);
		if ($this->Num_IMEI->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_IMEI->AdvancedSearch->SearchOperator = @$_GET["z_Num_IMEI"];

		// Num_ICCID
		$this->Num_ICCID->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_ICCID"]);
		if ($this->Num_ICCID->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_ICCID->AdvancedSearch->SearchOperator = @$_GET["z_Num_ICCID"];

		// Num_CEL
		$this->Num_CEL->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_CEL"]);
		if ($this->Num_CEL->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_CEL->AdvancedSearch->SearchOperator = @$_GET["z_Num_CEL"];

		// Descripcion_SIM
		$this->Descripcion_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Descripcion_SIM"]);
		if ($this->Descripcion_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Descripcion_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Descripcion_SIM"];

		// Reg_Venta_Movi
		$this->Reg_Venta_Movi->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Reg_Venta_Movi"]);
		if ($this->Reg_Venta_Movi->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Reg_Venta_Movi->AdvancedSearch->SearchOperator = @$_GET["z_Reg_Venta_Movi"];

		// Monto_Recarga_Movi
		$this->Monto_Recarga_Movi->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Monto_Recarga_Movi"]);
		if ($this->Monto_Recarga_Movi->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Monto_Recarga_Movi->AdvancedSearch->SearchOperator = @$_GET["z_Monto_Recarga_Movi"];

		// Folio_Recarga_Movi
		$this->Folio_Recarga_Movi->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Folio_Recarga_Movi"]);
		if ($this->Folio_Recarga_Movi->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Folio_Recarga_Movi->AdvancedSearch->SearchOperator = @$_GET["z_Folio_Recarga_Movi"];

		// ImprimirNotaVenta
		$this->ImprimirNotaVenta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ImprimirNotaVenta"]);
		if ($this->ImprimirNotaVenta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->ImprimirNotaVenta->AdvancedSearch->SearchOperator = @$_GET["z_ImprimirNotaVenta"];

		// Serie_NotaVenta
		$this->Serie_NotaVenta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Serie_NotaVenta"]);
		if ($this->Serie_NotaVenta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Serie_NotaVenta->AdvancedSearch->SearchOperator = @$_GET["z_Serie_NotaVenta"];

		// Numero_NotaVenta
		$this->Numero_NotaVenta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Numero_NotaVenta"]);
		if ($this->Numero_NotaVenta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Numero_NotaVenta->AdvancedSearch->SearchOperator = @$_GET["z_Numero_NotaVenta"];

		// Imprimirpapeleta
		$this->Imprimirpapeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Imprimirpapeleta"]);
		if ($this->Imprimirpapeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Imprimirpapeleta->AdvancedSearch->SearchOperator = @$_GET["z_Imprimirpapeleta"];

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FolioImpresoPapeleta"]);
		if ($this->FolioImpresoPapeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FolioImpresoPapeleta->AdvancedSearch->SearchOperator = @$_GET["z_FolioImpresoPapeleta"];

		// Maneja_Papeleta
		$this->Maneja_Papeleta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Maneja_Papeleta"]);
		if ($this->Maneja_Papeleta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Maneja_Papeleta->AdvancedSearch->SearchOperator = @$_GET["z_Maneja_Papeleta"];

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Maneja_Activacion_Movi"]);
		if ($this->Maneja_Activacion_Movi->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Maneja_Activacion_Movi->AdvancedSearch->SearchOperator = @$_GET["z_Maneja_Activacion_Movi"];

		// Con_SIM
		$this->Con_SIM->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Con_SIM"]);
		if ($this->Con_SIM->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Con_SIM->AdvancedSearch->SearchOperator = @$_GET["z_Con_SIM"];
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
		$this->FechaVenta->setDbValue($rs->fields('FechaVenta'));
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Descripcion_SIM->setDbValue($rs->fields('Descripcion_SIM'));
		$this->Reg_Venta_Movi->setDbValue($rs->fields('Reg_Venta_Movi'));
		$this->Monto_Recarga_Movi->setDbValue($rs->fields('Monto_Recarga_Movi'));
		$this->Folio_Recarga_Movi->setDbValue($rs->fields('Folio_Recarga_Movi'));
		$this->ImprimirNotaVenta->setDbValue($rs->fields('ImprimirNotaVenta'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Numero_NotaVenta->setDbValue($rs->fields('Numero_NotaVenta'));
		$this->Imprimirpapeleta->setDbValue($rs->fields('Imprimirpapeleta'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
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
		// FechaVenta
		// Id_Tienda
		// Id_Tel_SIM
		// Id_Cliente
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Descripcion_SIM
		// Reg_Venta_Movi
		// Monto_Recarga_Movi
		// Folio_Recarga_Movi
		// ImprimirNotaVenta
		// Serie_NotaVenta
		// Numero_NotaVenta
		// Imprimirpapeleta
		// FolioImpresoPapeleta
		// Maneja_Papeleta
		// Maneja_Activacion_Movi
		// Con_SIM

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// FechaVenta
			$this->FechaVenta->ViewValue = $this->FechaVenta->CurrentValue;
			$this->FechaVenta->ViewValue = ew_FormatDateTime($this->FechaVenta->ViewValue, 7);
			$this->FechaVenta->ViewCustomAttributes = "";

			// Id_Tienda
			if (strval($this->Id_Tienda->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Tienda->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tienda->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Tienda->ViewValue = $this->Id_Tienda->CurrentValue;
				}
			} else {
				$this->Id_Tienda->ViewValue = NULL;
			}
			$this->Id_Tienda->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_disp_equipo_imprimir_docs_amigo_kit`";
			$sWhereWrk = "";
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

			// Descripcion_SIM
			$this->Descripcion_SIM->ViewValue = $this->Descripcion_SIM->CurrentValue;
			$this->Descripcion_SIM->ViewCustomAttributes = "";

			// Reg_Venta_Movi
			$this->Reg_Venta_Movi->ViewValue = $this->Reg_Venta_Movi->CurrentValue;
			$this->Reg_Venta_Movi->ViewCustomAttributes = "";

			// Monto_Recarga_Movi
			$this->Monto_Recarga_Movi->ViewValue = $this->Monto_Recarga_Movi->CurrentValue;
			$this->Monto_Recarga_Movi->ViewValue = ew_FormatCurrency($this->Monto_Recarga_Movi->ViewValue, 2, -2, -2, -2);
			$this->Monto_Recarga_Movi->ViewCustomAttributes = "";

			// Folio_Recarga_Movi
			$this->Folio_Recarga_Movi->ViewValue = $this->Folio_Recarga_Movi->CurrentValue;
			$this->Folio_Recarga_Movi->ViewCustomAttributes = "";

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

			// Imprimirpapeleta
			if (strval($this->Imprimirpapeleta->CurrentValue) <> "") {
				switch ($this->Imprimirpapeleta->CurrentValue) {
					case $this->Imprimirpapeleta->FldTagValue(1):
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(1) <> "" ? $this->Imprimirpapeleta->FldTagCaption(1) : $this->Imprimirpapeleta->CurrentValue;
						break;
					case $this->Imprimirpapeleta->FldTagValue(2):
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(2) <> "" ? $this->Imprimirpapeleta->FldTagCaption(2) : $this->Imprimirpapeleta->CurrentValue;
						break;
					default:
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->CurrentValue;
				}
			} else {
				$this->Imprimirpapeleta->ViewValue = NULL;
			}
			$this->Imprimirpapeleta->ViewCustomAttributes = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
			$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
			$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

			// Con_SIM
			$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
			$this->Con_SIM->ViewCustomAttributes = "";

			// Id_Venta_Eq
			$this->Id_Venta_Eq->LinkCustomAttributes = "";
			$this->Id_Venta_Eq->HrefValue = "";
			$this->Id_Venta_Eq->TooltipValue = "";

			// FechaVenta
			$this->FechaVenta->LinkCustomAttributes = "";
			$this->FechaVenta->HrefValue = "";
			$this->FechaVenta->TooltipValue = "";

			// Id_Tienda
			$this->Id_Tienda->LinkCustomAttributes = "";
			$this->Id_Tienda->HrefValue = "";
			$this->Id_Tienda->TooltipValue = "";

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

			// Descripcion_SIM
			$this->Descripcion_SIM->LinkCustomAttributes = "";
			$this->Descripcion_SIM->HrefValue = "";
			$this->Descripcion_SIM->TooltipValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->LinkCustomAttributes = "";
			$this->Serie_NotaVenta->HrefValue = "";
			$this->Serie_NotaVenta->TooltipValue = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->LinkCustomAttributes = "";
			$this->Numero_NotaVenta->HrefValue = "";
			$this->Numero_NotaVenta->TooltipValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->LinkCustomAttributes = "";
			$this->FolioImpresoPapeleta->HrefValue = "";
			$this->FolioImpresoPapeleta->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->EditCustomAttributes = "";
			$this->Id_Venta_Eq->EditValue = ew_HtmlEncode($this->Id_Venta_Eq->AdvancedSearch->SearchValue);

			// FechaVenta
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaVenta->AdvancedSearch->SearchValue, 7), 7));
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->FechaVenta->AdvancedSearch->SearchValue2, 7), 7));

			// Id_Tienda
			$this->Id_Tienda->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Tienda->EditValue = $arwrk;

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";

			// Id_Cliente
			$this->Id_Cliente->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Cliente`, `Nombre_Completo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_clientes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Cliente->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->AdvancedSearch->SearchValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->AdvancedSearch->SearchValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->AdvancedSearch->SearchValue);

			// Descripcion_SIM
			$this->Descripcion_SIM->EditCustomAttributes = "";
			$this->Descripcion_SIM->EditValue = ew_HtmlEncode($this->Descripcion_SIM->AdvancedSearch->SearchValue);

			// Serie_NotaVenta
			$this->Serie_NotaVenta->EditCustomAttributes = "";
			$this->Serie_NotaVenta->EditValue = ew_HtmlEncode($this->Serie_NotaVenta->AdvancedSearch->SearchValue);

			// Numero_NotaVenta
			$this->Numero_NotaVenta->EditCustomAttributes = "";
			$this->Numero_NotaVenta->EditValue = ew_HtmlEncode($this->Numero_NotaVenta->AdvancedSearch->SearchValue);

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->EditCustomAttributes = "onchange= 'ValidaFolioPapeleta(this);' ";
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
		if (!ew_CheckEuroDate($this->FechaVenta->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->FechaVenta->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->FechaVenta->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->FechaVenta->FldErrMsg());
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Venta_Eq->AdvancedSearch->Load();
		$this->FechaVenta->AdvancedSearch->Load();
		$this->Id_Tienda->AdvancedSearch->Load();
		$this->Id_Tel_SIM->AdvancedSearch->Load();
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Num_IMEI->AdvancedSearch->Load();
		$this->Num_ICCID->AdvancedSearch->Load();
		$this->Num_CEL->AdvancedSearch->Load();
		$this->Descripcion_SIM->AdvancedSearch->Load();
		$this->Reg_Venta_Movi->AdvancedSearch->Load();
		$this->Monto_Recarga_Movi->AdvancedSearch->Load();
		$this->Folio_Recarga_Movi->AdvancedSearch->Load();
		$this->ImprimirNotaVenta->AdvancedSearch->Load();
		$this->Serie_NotaVenta->AdvancedSearch->Load();
		$this->Numero_NotaVenta->AdvancedSearch->Load();
		$this->Imprimirpapeleta->AdvancedSearch->Load();
		$this->FolioImpresoPapeleta->AdvancedSearch->Load();
		$this->Maneja_Papeleta->AdvancedSearch->Load();
		$this->Maneja_Activacion_Movi->AdvancedSearch->Load();
		$this->Con_SIM->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_cap_imprimir_docs_amigokit\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cap_imprimir_docs_amigokit',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcap_imprimir_docs_amigokitlist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($cap_imprimir_docs_amigokit_list)) $cap_imprimir_docs_amigokit_list = new ccap_imprimir_docs_amigokit_list();

// Page init
$cap_imprimir_docs_amigokit_list->Page_Init();

// Page main
$cap_imprimir_docs_amigokit_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cap_imprimir_docs_amigokit->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_imprimir_docs_amigokit_list = new ew_Page("cap_imprimir_docs_amigokit_list");
cap_imprimir_docs_amigokit_list.PageID = "list"; // Page ID
var EW_PAGE_ID = cap_imprimir_docs_amigokit_list.PageID; // For backward compatibility

// Form object
var fcap_imprimir_docs_amigokitlist = new ew_Form("fcap_imprimir_docs_amigokitlist");

// Form_CustomValidate event
fcap_imprimir_docs_amigokitlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_imprimir_docs_amigokitlist.ValidateRequired = true;
<?php } else { ?>
fcap_imprimir_docs_amigokitlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_imprimir_docs_amigokitlist.Lists["x_Id_Tienda"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_docs_amigokitlist.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_docs_amigokitlist.Lists["x_Id_Cliente"] = {"LinkField":"x_Id_Cliente","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre_Completo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fcap_imprimir_docs_amigokitlistsrch = new ew_Form("fcap_imprimir_docs_amigokitlistsrch");

// Validate function for search
fcap_imprimir_docs_amigokitlistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = fobj.elements["x" + infix + "_FechaVenta"];
	if (elm && !ew_CheckEuroDate(elm.value))
		return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->FechaVenta->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj, infix);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fcap_imprimir_docs_amigokitlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_imprimir_docs_amigokitlistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fcap_imprimir_docs_amigokitlistsrch.ValidateRequired = false; // no JavaScript validation
<?php } ?>

// Dynamic selection lists
fcap_imprimir_docs_amigokitlistsrch.Lists["x_Id_Tienda"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_docs_amigokitlistsrch.Lists["x_Id_Cliente"] = {"LinkField":"x_Id_Cliente","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre_Completo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		$cap_imprimir_docs_amigokit_list->TotalRecs = $cap_imprimir_docs_amigokit->SelectRecordCount();
	} else {
		if ($cap_imprimir_docs_amigokit_list->Recordset = $cap_imprimir_docs_amigokit_list->LoadRecordset())
			$cap_imprimir_docs_amigokit_list->TotalRecs = $cap_imprimir_docs_amigokit_list->Recordset->RecordCount();
	}
	$cap_imprimir_docs_amigokit_list->StartRec = 1;
	if ($cap_imprimir_docs_amigokit_list->DisplayRecs <= 0 || ($cap_imprimir_docs_amigokit->Export <> "" && $cap_imprimir_docs_amigokit->ExportAll)) // Display all records
		$cap_imprimir_docs_amigokit_list->DisplayRecs = $cap_imprimir_docs_amigokit_list->TotalRecs;
	if (!($cap_imprimir_docs_amigokit->Export <> "" && $cap_imprimir_docs_amigokit->ExportAll))
		$cap_imprimir_docs_amigokit_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cap_imprimir_docs_amigokit_list->Recordset = $cap_imprimir_docs_amigokit_list->LoadRecordset($cap_imprimir_docs_amigokit_list->StartRec-1, $cap_imprimir_docs_amigokit_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_imprimir_docs_amigokit->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $cap_imprimir_docs_amigokit_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cap_imprimir_docs_amigokit->Export == "" && $cap_imprimir_docs_amigokit->CurrentAction == "") { ?>
<form name="fcap_imprimir_docs_amigokitlistsrch" id="fcap_imprimir_docs_amigokitlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fcap_imprimir_docs_amigokitlistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fcap_imprimir_docs_amigokitlistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fcap_imprimir_docs_amigokitlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cap_imprimir_docs_amigokit">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cap_imprimir_docs_amigokit_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cap_imprimir_docs_amigokit->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cap_imprimir_docs_amigokit->ResetAttrs();
$cap_imprimir_docs_amigokit_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($cap_imprimir_docs_amigokit->FechaVenta->Visible) { // FechaVenta ?>
	<span id="xsc_FechaVenta" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_imprimir_docs_amigokit->FechaVenta->FldCaption() ?></span>
		<span class="ewSearchOperator"><select name="z_FechaVenta" id="z_FechaVenta" onchange="ewForms['fcap_imprimir_docs_amigokitlistsrch'].SrchOprChanged(this);"><option value="="<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator=="=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("=") ?></option><option value="<>"<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator=="<>") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator=="<") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator=="<=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator==">") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator==">=") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($cap_imprimir_docs_amigokit->FechaVenta->AdvancedSearch->SearchOperator=="BETWEEN") ? " selected=\"selected\"" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
		<span class="ewSearchField">
<input type="text" name="x_FechaVenta" id="x_FechaVenta" value="<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditAttributes() ?>>
<?php if (!$cap_imprimir_docs_amigokit->FechaVenta->ReadOnly && !$cap_imprimir_docs_amigokit->FechaVenta->Disabled && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["readonly"] == "" && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_imprimir_docs_amigokitlistsrch$x_FechaVenta$" name="fcap_imprimir_docs_amigokitlistsrch$x_FechaVenta$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_imprimir_docs_amigokitlistsrch", "x_FechaVenta", "%d/%m/%Y");
</script>
<?php } ?>
</span>
		<span class="ewSearchCond btw1_FechaVenta" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
		<span class="ewSearchField btw1_FechaVenta" style="display: none">
<input type="text" name="y_FechaVenta" id="y_FechaVenta" value="<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditValue2 ?>"<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditAttributes() ?>>
<?php if (!$cap_imprimir_docs_amigokit->FechaVenta->ReadOnly && !$cap_imprimir_docs_amigokit->FechaVenta->Disabled && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["readonly"] == "" && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_imprimir_docs_amigokitlistsrch$y_FechaVenta$" name="fcap_imprimir_docs_amigokitlistsrch$y_FechaVenta$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_imprimir_docs_amigokitlistsrch", "y_FechaVenta", "%d/%m/%Y");
</script>
<?php } ?>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($cap_imprimir_docs_amigokit->Id_Tienda->Visible) { // Id_Tienda ?>
	<span id="xsc_Id_Tienda" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Tienda->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Tienda" id="z_Id_Tienda" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Tienda" name="x_Id_Tienda"<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->EditAttributes() ?>>
<?php
if (is_array($cap_imprimir_docs_amigokit->Id_Tienda->EditValue)) {
	$arwrk = $cap_imprimir_docs_amigokit->Id_Tienda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Id_Tienda->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_imprimir_docs_amigokitlistsrch.Lists["x_Id_Tienda"].Options = <?php echo (is_array($cap_imprimir_docs_amigokit->Id_Tienda->EditValue)) ? ew_ArrayToJson($cap_imprimir_docs_amigokit->Id_Tienda->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($cap_imprimir_docs_amigokit->Id_Cliente->Visible) { // Id_Cliente ?>
	<span id="xsc_Id_Cliente" class="ewCell">
		<span class="ewSearchCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Cliente->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Cliente" id="z_Id_Cliente" value="="></span>
		<span class="ewSearchField">
<select id="x_Id_Cliente" name="x_Id_Cliente"<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->EditAttributes() ?>>
<?php
if (is_array($cap_imprimir_docs_amigokit->Id_Cliente->EditValue)) {
	$arwrk = $cap_imprimir_docs_amigokit->Id_Cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Id_Cliente->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_imprimir_docs_amigokitlistsrch.Lists["x_Id_Cliente"].Options = <?php echo (is_array($cap_imprimir_docs_amigokit->Id_Cliente->EditValue)) ? ew_ArrayToJson($cap_imprimir_docs_amigokit->Id_Cliente->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cap_imprimir_docs_amigokit_list->ShowPageHeader(); ?>
<?php
$cap_imprimir_docs_amigokit_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cap_imprimir_docs_amigokit->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cap_imprimir_docs_amigokit->CurrentAction <> "gridadd" && $cap_imprimir_docs_amigokit->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_imprimir_docs_amigokit_list->Pager)) $cap_imprimir_docs_amigokit_list->Pager = new cNumericPager($cap_imprimir_docs_amigokit_list->StartRec, $cap_imprimir_docs_amigokit_list->DisplayRecs, $cap_imprimir_docs_amigokit_list->TotalRecs, $cap_imprimir_docs_amigokit_list->RecRange) ?>
<?php if ($cap_imprimir_docs_amigokit_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_imprimir_docs_amigokit_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_imprimir_docs_amigokit_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_imprimir_docs_amigokit_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_imprimir_docs_amigokit">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_imprimir_docs_amigokit_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_imprimir_docs_amigokit_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcap_imprimir_docs_amigokitlist" id="fcap_imprimir_docs_amigokitlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="cap_imprimir_docs_amigokit">
<div id="gmp_cap_imprimir_docs_amigokit" class="ewGridMiddlePanel">
<?php if ($cap_imprimir_docs_amigokit_list->TotalRecs > 0) { ?>
<table id="tbl_cap_imprimir_docs_amigokitlist" class="ewTable ewTableSeparate">
<?php echo $cap_imprimir_docs_amigokit->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_imprimir_docs_amigokit_list->RenderListOptions();

// Render list options (header, left)
$cap_imprimir_docs_amigokit_list->ListOptions->Render("header", "left");
?>
<?php if ($cap_imprimir_docs_amigokit->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Venta_Eq) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Id_Venta_Eq" class="cap_imprimir_docs_amigokit_Id_Venta_Eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Venta_Eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Venta_Eq) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Id_Venta_Eq" class="cap_imprimir_docs_amigokit_Id_Venta_Eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Venta_Eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Id_Venta_Eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Id_Venta_Eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->FechaVenta->Visible) { // FechaVenta ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->FechaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_FechaVenta" class="cap_imprimir_docs_amigokit_FechaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->FechaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->FechaVenta) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_FechaVenta" class="cap_imprimir_docs_amigokit_FechaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->FechaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->FechaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->FechaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Id_Tienda->Visible) { // Id_Tienda ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Tienda) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Id_Tienda" class="cap_imprimir_docs_amigokit_Id_Tienda"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Tienda->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Tienda) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Id_Tienda" class="cap_imprimir_docs_amigokit_Id_Tienda">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Tienda->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Id_Tienda->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Id_Tienda->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Id_Tel_SIM" class="cap_imprimir_docs_amigokit_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Tel_SIM) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Id_Tel_SIM" class="cap_imprimir_docs_amigokit_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Id_Cliente->Visible) { // Id_Cliente ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Cliente) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Id_Cliente" class="cap_imprimir_docs_amigokit_Id_Cliente"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Cliente->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Id_Cliente) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Id_Cliente" class="cap_imprimir_docs_amigokit_Id_Cliente">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Id_Cliente->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Id_Cliente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Id_Cliente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Num_IMEI" class="cap_imprimir_docs_amigokit_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_IMEI) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Num_IMEI" class="cap_imprimir_docs_amigokit_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Num_IMEI->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_ICCID) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Num_ICCID" class="cap_imprimir_docs_amigokit_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_ICCID) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Num_ICCID" class="cap_imprimir_docs_amigokit_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Num_ICCID->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_CEL) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Num_CEL" class="cap_imprimir_docs_amigokit_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Num_CEL) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Num_CEL" class="cap_imprimir_docs_amigokit_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Num_CEL->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Descripcion_SIM->Visible) { // Descripcion_SIM ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Descripcion_SIM) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Descripcion_SIM" class="cap_imprimir_docs_amigokit_Descripcion_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Descripcion_SIM) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Descripcion_SIM" class="cap_imprimir_docs_amigokit_Descripcion_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Descripcion_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Descripcion_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Serie_NotaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Serie_NotaVenta" class="cap_imprimir_docs_amigokit_Serie_NotaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Serie_NotaVenta) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Serie_NotaVenta" class="cap_imprimir_docs_amigokit_Serie_NotaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Serie_NotaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Serie_NotaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Numero_NotaVenta) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_Numero_NotaVenta" class="cap_imprimir_docs_amigokit_Numero_NotaVenta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->Numero_NotaVenta) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_Numero_NotaVenta" class="cap_imprimir_docs_amigokit_Numero_NotaVenta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->Numero_NotaVenta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->Numero_NotaVenta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_imprimir_docs_amigokit->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
	<?php if ($cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->FolioImpresoPapeleta) == "") { ?>
		<td><span id="elh_cap_imprimir_docs_amigokit_FolioImpresoPapeleta" class="cap_imprimir_docs_amigokit_FolioImpresoPapeleta"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $cap_imprimir_docs_amigokit->SortUrl($cap_imprimir_docs_amigokit->FolioImpresoPapeleta) ?>',2);"><span id="elh_cap_imprimir_docs_amigokit_FolioImpresoPapeleta" class="cap_imprimir_docs_amigokit_FolioImpresoPapeleta">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_imprimir_docs_amigokit->FolioImpresoPapeleta->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_imprimir_docs_amigokit->FolioImpresoPapeleta->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_imprimir_docs_amigokit_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cap_imprimir_docs_amigokit->ExportAll && $cap_imprimir_docs_amigokit->Export <> "") {
	$cap_imprimir_docs_amigokit_list->StopRec = $cap_imprimir_docs_amigokit_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cap_imprimir_docs_amigokit_list->TotalRecs > $cap_imprimir_docs_amigokit_list->StartRec + $cap_imprimir_docs_amigokit_list->DisplayRecs - 1)
		$cap_imprimir_docs_amigokit_list->StopRec = $cap_imprimir_docs_amigokit_list->StartRec + $cap_imprimir_docs_amigokit_list->DisplayRecs - 1;
	else
		$cap_imprimir_docs_amigokit_list->StopRec = $cap_imprimir_docs_amigokit_list->TotalRecs;
}
$cap_imprimir_docs_amigokit_list->RecCnt = $cap_imprimir_docs_amigokit_list->StartRec - 1;
if ($cap_imprimir_docs_amigokit_list->Recordset && !$cap_imprimir_docs_amigokit_list->Recordset->EOF) {
	$cap_imprimir_docs_amigokit_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_imprimir_docs_amigokit_list->StartRec > 1)
		$cap_imprimir_docs_amigokit_list->Recordset->Move($cap_imprimir_docs_amigokit_list->StartRec - 1);
} elseif (!$cap_imprimir_docs_amigokit->AllowAddDeleteRow && $cap_imprimir_docs_amigokit_list->StopRec == 0) {
	$cap_imprimir_docs_amigokit_list->StopRec = $cap_imprimir_docs_amigokit->GridAddRowCount;
}

// Initialize aggregate
$cap_imprimir_docs_amigokit->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_imprimir_docs_amigokit->ResetAttrs();
$cap_imprimir_docs_amigokit_list->RenderRow();
while ($cap_imprimir_docs_amigokit_list->RecCnt < $cap_imprimir_docs_amigokit_list->StopRec) {
	$cap_imprimir_docs_amigokit_list->RecCnt++;
	if (intval($cap_imprimir_docs_amigokit_list->RecCnt) >= intval($cap_imprimir_docs_amigokit_list->StartRec)) {
		$cap_imprimir_docs_amigokit_list->RowCnt++;

		// Set up key count
		$cap_imprimir_docs_amigokit_list->KeyCount = $cap_imprimir_docs_amigokit_list->RowIndex;

		// Init row class and style
		$cap_imprimir_docs_amigokit->ResetAttrs();
		$cap_imprimir_docs_amigokit->CssClass = "";
		if ($cap_imprimir_docs_amigokit->CurrentAction == "gridadd") {
		} else {
			$cap_imprimir_docs_amigokit_list->LoadRowValues($cap_imprimir_docs_amigokit_list->Recordset); // Load row values
		}
		$cap_imprimir_docs_amigokit->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cap_imprimir_docs_amigokit->RowAttrs = array_merge($cap_imprimir_docs_amigokit->RowAttrs, array('data-rowindex'=>$cap_imprimir_docs_amigokit_list->RowCnt, 'id'=>'r' . $cap_imprimir_docs_amigokit_list->RowCnt . '_cap_imprimir_docs_amigokit', 'data-rowtype'=>$cap_imprimir_docs_amigokit->RowType));

		// Render row
		$cap_imprimir_docs_amigokit_list->RenderRow();

		// Render list options
		$cap_imprimir_docs_amigokit_list->RenderListOptions();
?>
	<tr<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_imprimir_docs_amigokit_list->ListOptions->Render("body", "left", $cap_imprimir_docs_amigokit_list->RowCnt);
?>
	<?php if ($cap_imprimir_docs_amigokit->Id_Venta_Eq->Visible) { // Id_Venta_Eq ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Venta_Eq->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Id_Venta_Eq" class="cap_imprimir_docs_amigokit_Id_Venta_Eq">
<span<?php echo $cap_imprimir_docs_amigokit->Id_Venta_Eq->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Id_Venta_Eq->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->FechaVenta->Visible) { // FechaVenta ?>
		<td<?php echo $cap_imprimir_docs_amigokit->FechaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_FechaVenta" class="cap_imprimir_docs_amigokit_FechaVenta">
<span<?php echo $cap_imprimir_docs_amigokit->FechaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->FechaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Id_Tienda->Visible) { // Id_Tienda ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Id_Tienda" class="cap_imprimir_docs_amigokit_Id_Tienda">
<span<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Id_Tel_SIM" class="cap_imprimir_docs_amigokit_Id_Tel_SIM">
<span<?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Id_Cliente->Visible) { // Id_Cliente ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Id_Cliente" class="cap_imprimir_docs_amigokit_Id_Cliente">
<span<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Num_IMEI" class="cap_imprimir_docs_amigokit_Num_IMEI">
<span<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Num_ICCID" class="cap_imprimir_docs_amigokit_Num_ICCID">
<span<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Num_CEL" class="cap_imprimir_docs_amigokit_Num_CEL">
<span<?php echo $cap_imprimir_docs_amigokit->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Num_CEL->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Descripcion_SIM->Visible) { // Descripcion_SIM ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Descripcion_SIM" class="cap_imprimir_docs_amigokit_Descripcion_SIM">
<span<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Serie_NotaVenta" class="cap_imprimir_docs_amigokit_Serie_NotaVenta">
<span<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
		<td<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_Numero_NotaVenta" class="cap_imprimir_docs_amigokit_Numero_NotaVenta">
<span<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
		<td<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->CellAttributes() ?>><span id="el<?php echo $cap_imprimir_docs_amigokit_list->RowCnt ?>_cap_imprimir_docs_amigokit_FolioImpresoPapeleta" class="cap_imprimir_docs_amigokit_FolioImpresoPapeleta">
<span<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->ViewAttributes() ?>>
<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->ListViewValue() ?></span>
</span><a id="<?php echo $cap_imprimir_docs_amigokit_list->PageObjName . "_row_" . $cap_imprimir_docs_amigokit_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_imprimir_docs_amigokit_list->ListOptions->Render("body", "right", $cap_imprimir_docs_amigokit_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($cap_imprimir_docs_amigokit->CurrentAction <> "gridadd")
		$cap_imprimir_docs_amigokit_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cap_imprimir_docs_amigokit_list->Recordset)
	$cap_imprimir_docs_amigokit_list->Recordset->Close();
?>
<?php if ($cap_imprimir_docs_amigokit_list->TotalRecs > 0) { ?>
<?php if ($cap_imprimir_docs_amigokit->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cap_imprimir_docs_amigokit->CurrentAction <> "gridadd" && $cap_imprimir_docs_amigokit->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($cap_imprimir_docs_amigokit_list->Pager)) $cap_imprimir_docs_amigokit_list->Pager = new cNumericPager($cap_imprimir_docs_amigokit_list->StartRec, $cap_imprimir_docs_amigokit_list->DisplayRecs, $cap_imprimir_docs_amigokit_list->TotalRecs, $cap_imprimir_docs_amigokit_list->RecRange) ?>
<?php if ($cap_imprimir_docs_amigokit_list->Pager->RecordCount > 0) { ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($cap_imprimir_docs_amigokit_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $cap_imprimir_docs_amigokit_list->PageUrl() ?>start=<?php echo $cap_imprimir_docs_amigokit_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($cap_imprimir_docs_amigokit_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cap_imprimir_docs_amigokit_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($cap_imprimir_docs_amigokit_list->SearchWhere == "0=101") { ?>
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
<?php if ($cap_imprimir_docs_amigokit_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="cap_imprimir_docs_amigokit">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($cap_imprimir_docs_amigokit_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($cap_imprimir_docs_amigokit_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $cap_imprimir_docs_amigokit_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cap_imprimir_docs_amigokit->Export == "") { ?>
<script type="text/javascript">
fcap_imprimir_docs_amigokitlistsrch.Init();
fcap_imprimir_docs_amigokitlist.Init();
</script>
<?php } ?>
<?php
$cap_imprimir_docs_amigokit_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cap_imprimir_docs_amigokit->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cap_imprimir_docs_amigokit_list->Page_Terminate();
?>
