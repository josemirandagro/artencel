<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_clientesinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_clientes_list = NULL; // Initialize page object first

class cca_clientes_list extends cca_clientes {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_clientes';

	// Page object name
	var $PageObjName = 'ca_clientes_list';

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

		// Table object (ca_clientes)
		if (!isset($GLOBALS["ca_clientes"])) {
			$GLOBALS["ca_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_clientes"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ca_clientesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ca_clientesdelete.php";
		$this->MultiUpdateUrl = "ca_clientesupdate.php";

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_clientes', TRUE);

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
			$this->Id_Cliente->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Cliente->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Cliente, FALSE); // Id_Cliente
		$this->BuildSearchSql($sWhere, $this->Nombre_Completo, FALSE); // Nombre_Completo
		$this->BuildSearchSql($sWhere, $this->Razon_Social, FALSE); // Razon_Social
		$this->BuildSearchSql($sWhere, $this->Domicilio, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Num_Exterior, FALSE); // Num_Exterior
		$this->BuildSearchSql($sWhere, $this->Num_Interior, FALSE); // Num_Interior
		$this->BuildSearchSql($sWhere, $this->Colonia, FALSE); // Colonia
		$this->BuildSearchSql($sWhere, $this->Poblacion, FALSE); // Poblacion
		$this->BuildSearchSql($sWhere, $this->MunicipioDel, FALSE); // MunicipioDel
		$this->BuildSearchSql($sWhere, $this->Id_Estado, FALSE); // Id_Estado
		$this->BuildSearchSql($sWhere, $this->CP, FALSE); // CP
		$this->BuildSearchSql($sWhere, $this->RFC, FALSE); // RFC
		$this->BuildSearchSql($sWhere, $this->Categoria, FALSE); // Categoria
		$this->BuildSearchSql($sWhere, $this->CURP, FALSE); // CURP
		$this->BuildSearchSql($sWhere, $this->Tel_Particular, FALSE); // Tel_Particular
		$this->BuildSearchSql($sWhere, $this->Tel_Oficina, FALSE); // Tel_Oficina
		$this->BuildSearchSql($sWhere, $this->Celular, FALSE); // Celular
		$this->BuildSearchSql($sWhere, $this->Edad, FALSE); // Edad
		$this->BuildSearchSql($sWhere, $this->Sexo, FALSE); // Sexo
		$this->BuildSearchSql($sWhere, $this->Tipo_Identificacion, FALSE); // Tipo_Identificacion
		$this->BuildSearchSql($sWhere, $this->Otra_Identificacion, FALSE); // Otra_Identificacion
		$this->BuildSearchSql($sWhere, $this->Numero_Identificacion, FALSE); // Numero_Identificacion
		$this->BuildSearchSql($sWhere, $this->_EMail, FALSE); // EMail
		$this->BuildSearchSql($sWhere, $this->Comentarios, FALSE); // Comentarios
		$this->BuildSearchSql($sWhere, $this->Ap_Paterno, FALSE); // Ap_Paterno
		$this->BuildSearchSql($sWhere, $this->Ap_materno, FALSE); // Ap_materno
		$this->BuildSearchSql($sWhere, $this->Nombres, FALSE); // Nombres

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Cliente->AdvancedSearch->Save(); // Id_Cliente
			$this->Nombre_Completo->AdvancedSearch->Save(); // Nombre_Completo
			$this->Razon_Social->AdvancedSearch->Save(); // Razon_Social
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Num_Exterior->AdvancedSearch->Save(); // Num_Exterior
			$this->Num_Interior->AdvancedSearch->Save(); // Num_Interior
			$this->Colonia->AdvancedSearch->Save(); // Colonia
			$this->Poblacion->AdvancedSearch->Save(); // Poblacion
			$this->MunicipioDel->AdvancedSearch->Save(); // MunicipioDel
			$this->Id_Estado->AdvancedSearch->Save(); // Id_Estado
			$this->CP->AdvancedSearch->Save(); // CP
			$this->RFC->AdvancedSearch->Save(); // RFC
			$this->Categoria->AdvancedSearch->Save(); // Categoria
			$this->CURP->AdvancedSearch->Save(); // CURP
			$this->Tel_Particular->AdvancedSearch->Save(); // Tel_Particular
			$this->Tel_Oficina->AdvancedSearch->Save(); // Tel_Oficina
			$this->Celular->AdvancedSearch->Save(); // Celular
			$this->Edad->AdvancedSearch->Save(); // Edad
			$this->Sexo->AdvancedSearch->Save(); // Sexo
			$this->Tipo_Identificacion->AdvancedSearch->Save(); // Tipo_Identificacion
			$this->Otra_Identificacion->AdvancedSearch->Save(); // Otra_Identificacion
			$this->Numero_Identificacion->AdvancedSearch->Save(); // Numero_Identificacion
			$this->_EMail->AdvancedSearch->Save(); // EMail
			$this->Comentarios->AdvancedSearch->Save(); // Comentarios
			$this->Ap_Paterno->AdvancedSearch->Save(); // Ap_Paterno
			$this->Ap_materno->AdvancedSearch->Save(); // Ap_materno
			$this->Nombres->AdvancedSearch->Save(); // Nombres
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
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Completo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Domicilio, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_Exterior, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Num_Interior, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Colonia, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Poblacion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->MunicipioDel, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->Id_Estado, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->CP, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->RFC, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->CURP, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Tel_Particular, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Tel_Oficina, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Celular, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Otra_Identificacion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Numero_Identificacion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->_EMail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Comentarios, $Keyword);
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
		if ($this->Id_Cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Completo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Razon_Social->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_Exterior->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Num_Interior->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Colonia->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Poblacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->MunicipioDel->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->CP->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->RFC->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Categoria->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->CURP->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Particular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Oficina->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Celular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Edad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sexo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tipo_Identificacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Otra_Identificacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Numero_Identificacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->_EMail->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Comentarios->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Ap_Paterno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Ap_materno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombres->AdvancedSearch->IssetSession())
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
		$this->Id_Cliente->AdvancedSearch->UnsetSession();
		$this->Nombre_Completo->AdvancedSearch->UnsetSession();
		$this->Razon_Social->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Num_Exterior->AdvancedSearch->UnsetSession();
		$this->Num_Interior->AdvancedSearch->UnsetSession();
		$this->Colonia->AdvancedSearch->UnsetSession();
		$this->Poblacion->AdvancedSearch->UnsetSession();
		$this->MunicipioDel->AdvancedSearch->UnsetSession();
		$this->Id_Estado->AdvancedSearch->UnsetSession();
		$this->CP->AdvancedSearch->UnsetSession();
		$this->RFC->AdvancedSearch->UnsetSession();
		$this->Categoria->AdvancedSearch->UnsetSession();
		$this->CURP->AdvancedSearch->UnsetSession();
		$this->Tel_Particular->AdvancedSearch->UnsetSession();
		$this->Tel_Oficina->AdvancedSearch->UnsetSession();
		$this->Celular->AdvancedSearch->UnsetSession();
		$this->Edad->AdvancedSearch->UnsetSession();
		$this->Sexo->AdvancedSearch->UnsetSession();
		$this->Tipo_Identificacion->AdvancedSearch->UnsetSession();
		$this->Otra_Identificacion->AdvancedSearch->UnsetSession();
		$this->Numero_Identificacion->AdvancedSearch->UnsetSession();
		$this->_EMail->AdvancedSearch->UnsetSession();
		$this->Comentarios->AdvancedSearch->UnsetSession();
		$this->Ap_Paterno->AdvancedSearch->UnsetSession();
		$this->Ap_materno->AdvancedSearch->UnsetSession();
		$this->Nombres->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Nombre_Completo->AdvancedSearch->Load();
		$this->Razon_Social->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Num_Exterior->AdvancedSearch->Load();
		$this->Num_Interior->AdvancedSearch->Load();
		$this->Colonia->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->MunicipioDel->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->CP->AdvancedSearch->Load();
		$this->RFC->AdvancedSearch->Load();
		$this->Categoria->AdvancedSearch->Load();
		$this->CURP->AdvancedSearch->Load();
		$this->Tel_Particular->AdvancedSearch->Load();
		$this->Tel_Oficina->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Sexo->AdvancedSearch->Load();
		$this->Tipo_Identificacion->AdvancedSearch->Load();
		$this->Otra_Identificacion->AdvancedSearch->Load();
		$this->Numero_Identificacion->AdvancedSearch->Load();
		$this->_EMail->AdvancedSearch->Load();
		$this->Comentarios->AdvancedSearch->Load();
		$this->Ap_Paterno->AdvancedSearch->Load();
		$this->Ap_materno->AdvancedSearch->Load();
		$this->Nombres->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Nombre_Completo, $bCtrl); // Nombre_Completo
			$this->UpdateSort($this->Domicilio, $bCtrl); // Domicilio
			$this->UpdateSort($this->Num_Exterior, $bCtrl); // Num_Exterior
			$this->UpdateSort($this->Colonia, $bCtrl); // Colonia
			$this->UpdateSort($this->Id_Estado, $bCtrl); // Id_Estado
			$this->UpdateSort($this->Categoria, $bCtrl); // Categoria
			$this->UpdateSort($this->Tel_Particular, $bCtrl); // Tel_Particular
			$this->UpdateSort($this->Celular, $bCtrl); // Celular
			$this->UpdateSort($this->Comentarios, $bCtrl); // Comentarios
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
				$this->Nombre_Completo->setSort("ASC");
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
				$this->Nombre_Completo->setSort("");
				$this->Domicilio->setSort("");
				$this->Num_Exterior->setSort("");
				$this->Colonia->setSort("");
				$this->Id_Estado->setSort("");
				$this->Categoria->setSort("");
				$this->Tel_Particular->setSort("");
				$this->Celular->setSort("");
				$this->Comentarios->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->ViewUrl . "\">" . "<img src=\"phpimages/view.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ViewLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ViewLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
		// Id_Cliente

		$this->Id_Cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cliente"]);
		if ($this->Id_Cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cliente->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cliente"];

		// Nombre_Completo
		$this->Nombre_Completo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Completo"]);
		if ($this->Nombre_Completo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Completo->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Completo"];

		// Razon_Social
		$this->Razon_Social->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Razon_Social"]);
		if ($this->Razon_Social->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Razon_Social->AdvancedSearch->SearchOperator = @$_GET["z_Razon_Social"];

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Domicilio"]);
		if ($this->Domicilio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Domicilio->AdvancedSearch->SearchOperator = @$_GET["z_Domicilio"];

		// Num_Exterior
		$this->Num_Exterior->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_Exterior"]);
		if ($this->Num_Exterior->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_Exterior->AdvancedSearch->SearchOperator = @$_GET["z_Num_Exterior"];

		// Num_Interior
		$this->Num_Interior->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Num_Interior"]);
		if ($this->Num_Interior->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Num_Interior->AdvancedSearch->SearchOperator = @$_GET["z_Num_Interior"];

		// Colonia
		$this->Colonia->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Colonia"]);
		if ($this->Colonia->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Colonia->AdvancedSearch->SearchOperator = @$_GET["z_Colonia"];

		// Poblacion
		$this->Poblacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Poblacion"]);
		if ($this->Poblacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Poblacion->AdvancedSearch->SearchOperator = @$_GET["z_Poblacion"];

		// MunicipioDel
		$this->MunicipioDel->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_MunicipioDel"]);
		if ($this->MunicipioDel->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->MunicipioDel->AdvancedSearch->SearchOperator = @$_GET["z_MunicipioDel"];

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado"]);
		if ($this->Id_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado"];

		// CP
		$this->CP->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_CP"]);
		if ($this->CP->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->CP->AdvancedSearch->SearchOperator = @$_GET["z_CP"];

		// RFC
		$this->RFC->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_RFC"]);
		if ($this->RFC->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->RFC->AdvancedSearch->SearchOperator = @$_GET["z_RFC"];

		// Categoria
		$this->Categoria->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Categoria"]);
		if ($this->Categoria->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Categoria->AdvancedSearch->SearchOperator = @$_GET["z_Categoria"];

		// CURP
		$this->CURP->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_CURP"]);
		if ($this->CURP->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->CURP->AdvancedSearch->SearchOperator = @$_GET["z_CURP"];

		// Tel_Particular
		$this->Tel_Particular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tel_Particular"]);
		if ($this->Tel_Particular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tel_Particular->AdvancedSearch->SearchOperator = @$_GET["z_Tel_Particular"];

		// Tel_Oficina
		$this->Tel_Oficina->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tel_Oficina"]);
		if ($this->Tel_Oficina->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tel_Oficina->AdvancedSearch->SearchOperator = @$_GET["z_Tel_Oficina"];

		// Celular
		$this->Celular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Celular"]);
		if ($this->Celular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Celular->AdvancedSearch->SearchOperator = @$_GET["z_Celular"];

		// Edad
		$this->Edad->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Edad"]);
		if ($this->Edad->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Edad->AdvancedSearch->SearchOperator = @$_GET["z_Edad"];

		// Sexo
		$this->Sexo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sexo"]);
		if ($this->Sexo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sexo->AdvancedSearch->SearchOperator = @$_GET["z_Sexo"];

		// Tipo_Identificacion
		$this->Tipo_Identificacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tipo_Identificacion"]);
		if ($this->Tipo_Identificacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tipo_Identificacion->AdvancedSearch->SearchOperator = @$_GET["z_Tipo_Identificacion"];

		// Otra_Identificacion
		$this->Otra_Identificacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Otra_Identificacion"]);
		if ($this->Otra_Identificacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Otra_Identificacion->AdvancedSearch->SearchOperator = @$_GET["z_Otra_Identificacion"];

		// Numero_Identificacion
		$this->Numero_Identificacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Numero_Identificacion"]);
		if ($this->Numero_Identificacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Numero_Identificacion->AdvancedSearch->SearchOperator = @$_GET["z_Numero_Identificacion"];

		// EMail
		$this->_EMail->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x__EMail"]);
		if ($this->_EMail->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->_EMail->AdvancedSearch->SearchOperator = @$_GET["z__EMail"];

		// Comentarios
		$this->Comentarios->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Comentarios"]);
		if ($this->Comentarios->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Comentarios->AdvancedSearch->SearchOperator = @$_GET["z_Comentarios"];

		// Ap_Paterno
		$this->Ap_Paterno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Ap_Paterno"]);
		if ($this->Ap_Paterno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Ap_Paterno->AdvancedSearch->SearchOperator = @$_GET["z_Ap_Paterno"];

		// Ap_materno
		$this->Ap_materno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Ap_materno"]);
		if ($this->Ap_materno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Ap_materno->AdvancedSearch->SearchOperator = @$_GET["z_Ap_materno"];

		// Nombres
		$this->Nombres->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombres"]);
		if ($this->Nombres->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombres->AdvancedSearch->SearchOperator = @$_GET["z_Nombres"];
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
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Razon_Social->setDbValue($rs->fields('Razon_Social'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Num_Exterior->setDbValue($rs->fields('Num_Exterior'));
		$this->Num_Interior->setDbValue($rs->fields('Num_Interior'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->MunicipioDel->setDbValue($rs->fields('MunicipioDel'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->Categoria->setDbValue($rs->fields('Categoria'));
		$this->CURP->setDbValue($rs->fields('CURP'));
		$this->Tel_Particular->setDbValue($rs->fields('Tel_Particular'));
		$this->Tel_Oficina->setDbValue($rs->fields('Tel_Oficina'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Sexo->setDbValue($rs->fields('Sexo'));
		$this->Tipo_Identificacion->setDbValue($rs->fields('Tipo_Identificacion'));
		$this->Otra_Identificacion->setDbValue($rs->fields('Otra_Identificacion'));
		$this->Numero_Identificacion->setDbValue($rs->fields('Numero_Identificacion'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
		$this->Ap_Paterno->setDbValue($rs->fields('Ap_Paterno'));
		$this->Ap_materno->setDbValue($rs->fields('Ap_materno'));
		$this->Nombres->setDbValue($rs->fields('Nombres'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Cliente")) <> "")
			$this->Id_Cliente->CurrentValue = $this->getKey("Id_Cliente"); // Id_Cliente
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
		// Id_Cliente

		$this->Id_Cliente->CellCssStyle = "white-space: nowrap;";

		// Nombre_Completo
		// Razon_Social

		$this->Razon_Social->CellCssStyle = "white-space: nowrap;";

		// Domicilio
		// Num_Exterior
		// Num_Interior
		// Colonia
		// Poblacion
		// MunicipioDel
		// Id_Estado
		// CP
		// RFC
		// Categoria
		// CURP
		// Tel_Particular
		// Tel_Oficina
		// Celular
		// Edad
		// Sexo
		// Tipo_Identificacion
		// Otra_Identificacion
		// Numero_Identificacion
		// EMail
		// Comentarios
		// Ap_Paterno

		$this->Ap_Paterno->CellCssStyle = "white-space: nowrap;";

		// Ap_materno
		$this->Ap_materno->CellCssStyle = "white-space: nowrap;";

		// Nombres
		$this->Nombres->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewValue = strtoupper($this->Nombre_Completo->ViewValue);
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewValue = strtoupper($this->Domicilio->ViewValue);
			$this->Domicilio->ViewCustomAttributes = "";

			// Num_Exterior
			$this->Num_Exterior->ViewValue = $this->Num_Exterior->CurrentValue;
			$this->Num_Exterior->ViewCustomAttributes = "";

			// Num_Interior
			$this->Num_Interior->ViewValue = $this->Num_Interior->CurrentValue;
			$this->Num_Interior->ViewCustomAttributes = "";

			// Colonia
			$this->Colonia->ViewValue = $this->Colonia->CurrentValue;
			$this->Colonia->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewValue = strtoupper($this->Poblacion->ViewValue);
			$this->Poblacion->ViewCustomAttributes = "";

			// MunicipioDel
			$this->MunicipioDel->ViewValue = $this->MunicipioDel->CurrentValue;
			$this->MunicipioDel->ViewValue = strtoupper($this->MunicipioDel->ViewValue);
			$this->MunicipioDel->ViewCustomAttributes = "";

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
			$this->Id_Estado->ViewValue = strtoupper($this->Id_Estado->ViewValue);
			$this->Id_Estado->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

			// RFC
			$this->RFC->ViewValue = $this->RFC->CurrentValue;
			$this->RFC->ViewValue = strtoupper($this->RFC->ViewValue);
			$this->RFC->ViewCustomAttributes = "";

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

			// CURP
			$this->CURP->ViewValue = $this->CURP->CurrentValue;
			$this->CURP->ViewValue = strtoupper($this->CURP->ViewValue);
			$this->CURP->ViewCustomAttributes = "";

			// Tel_Particular
			$this->Tel_Particular->ViewValue = $this->Tel_Particular->CurrentValue;
			$this->Tel_Particular->ViewCustomAttributes = "";

			// Tel_Oficina
			$this->Tel_Oficina->ViewValue = $this->Tel_Oficina->CurrentValue;
			$this->Tel_Oficina->ViewCustomAttributes = "";

			// Celular
			$this->Celular->ViewValue = $this->Celular->CurrentValue;
			$this->Celular->ViewCustomAttributes = "";

			// Edad
			$this->Edad->ViewValue = $this->Edad->CurrentValue;
			$this->Edad->ViewCustomAttributes = "";

			// Sexo
			if (strval($this->Sexo->CurrentValue) <> "") {
				switch ($this->Sexo->CurrentValue) {
					case $this->Sexo->FldTagValue(1):
						$this->Sexo->ViewValue = $this->Sexo->FldTagCaption(1) <> "" ? $this->Sexo->FldTagCaption(1) : $this->Sexo->CurrentValue;
						break;
					case $this->Sexo->FldTagValue(2):
						$this->Sexo->ViewValue = $this->Sexo->FldTagCaption(2) <> "" ? $this->Sexo->FldTagCaption(2) : $this->Sexo->CurrentValue;
						break;
					default:
						$this->Sexo->ViewValue = $this->Sexo->CurrentValue;
				}
			} else {
				$this->Sexo->ViewValue = NULL;
			}
			$this->Sexo->ViewCustomAttributes = "";

			// Tipo_Identificacion
			if (strval($this->Tipo_Identificacion->CurrentValue) <> "") {
				switch ($this->Tipo_Identificacion->CurrentValue) {
					case $this->Tipo_Identificacion->FldTagValue(1):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(2):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(3):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->CurrentValue;
						break;
					case $this->Tipo_Identificacion->FldTagValue(4):
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->CurrentValue;
						break;
					default:
						$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->CurrentValue;
				}
			} else {
				$this->Tipo_Identificacion->ViewValue = NULL;
			}
			$this->Tipo_Identificacion->ViewCustomAttributes = "";

			// Otra_Identificacion
			$this->Otra_Identificacion->ViewValue = $this->Otra_Identificacion->CurrentValue;
			$this->Otra_Identificacion->ViewCustomAttributes = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->ViewValue = $this->Numero_Identificacion->CurrentValue;
			$this->Numero_Identificacion->ViewCustomAttributes = "";

			// EMail
			$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
			$this->_EMail->ViewValue = strtolower($this->_EMail->ViewValue);
			$this->_EMail->ViewCustomAttributes = "";

			// Comentarios
			$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
			$this->Comentarios->ViewValue = strtoupper($this->Comentarios->ViewValue);
			$this->Comentarios->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->LinkCustomAttributes = "";
			$this->Nombre_Completo->HrefValue = "";
			$this->Nombre_Completo->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Num_Exterior
			$this->Num_Exterior->LinkCustomAttributes = "";
			$this->Num_Exterior->HrefValue = "";
			$this->Num_Exterior->TooltipValue = "";

			// Colonia
			$this->Colonia->LinkCustomAttributes = "";
			$this->Colonia->HrefValue = "";
			$this->Colonia->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Categoria
			$this->Categoria->LinkCustomAttributes = "";
			$this->Categoria->HrefValue = "";
			$this->Categoria->TooltipValue = "";

			// Tel_Particular
			$this->Tel_Particular->LinkCustomAttributes = "";
			$this->Tel_Particular->HrefValue = "";
			$this->Tel_Particular->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Comentarios
			$this->Comentarios->LinkCustomAttributes = "";
			$this->Comentarios->HrefValue = "";
			$this->Comentarios->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Nombre_Completo
			$this->Nombre_Completo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre_Completo->EditValue = ew_HtmlEncode($this->Nombre_Completo->AdvancedSearch->SearchValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);

			// Num_Exterior
			$this->Num_Exterior->EditCustomAttributes = "";
			$this->Num_Exterior->EditValue = ew_HtmlEncode($this->Num_Exterior->AdvancedSearch->SearchValue);

			// Colonia
			$this->Colonia->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Colonia->EditValue = ew_HtmlEncode($this->Colonia->AdvancedSearch->SearchValue);

			// Id_Estado
			$this->Id_Estado->EditCustomAttributes = "";

			// Categoria
			$this->Categoria->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Categoria->FldTagValue(1), $this->Categoria->FldTagCaption(1) <> "" ? $this->Categoria->FldTagCaption(1) : $this->Categoria->FldTagValue(1));
			$arwrk[] = array($this->Categoria->FldTagValue(2), $this->Categoria->FldTagCaption(2) <> "" ? $this->Categoria->FldTagCaption(2) : $this->Categoria->FldTagValue(2));
			$arwrk[] = array($this->Categoria->FldTagValue(3), $this->Categoria->FldTagCaption(3) <> "" ? $this->Categoria->FldTagCaption(3) : $this->Categoria->FldTagValue(3));
			$this->Categoria->EditValue = $arwrk;

			// Tel_Particular
			$this->Tel_Particular->EditCustomAttributes = "";
			$this->Tel_Particular->EditValue = ew_HtmlEncode($this->Tel_Particular->AdvancedSearch->SearchValue);

			// Celular
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->AdvancedSearch->SearchValue);

			// Comentarios
			$this->Comentarios->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Comentarios->EditValue = ew_HtmlEncode($this->Comentarios->AdvancedSearch->SearchValue);
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Cliente->AdvancedSearch->Load();
		$this->Nombre_Completo->AdvancedSearch->Load();
		$this->Razon_Social->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Num_Exterior->AdvancedSearch->Load();
		$this->Num_Interior->AdvancedSearch->Load();
		$this->Colonia->AdvancedSearch->Load();
		$this->Poblacion->AdvancedSearch->Load();
		$this->MunicipioDel->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->CP->AdvancedSearch->Load();
		$this->RFC->AdvancedSearch->Load();
		$this->Categoria->AdvancedSearch->Load();
		$this->CURP->AdvancedSearch->Load();
		$this->Tel_Particular->AdvancedSearch->Load();
		$this->Tel_Oficina->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Sexo->AdvancedSearch->Load();
		$this->Tipo_Identificacion->AdvancedSearch->Load();
		$this->Otra_Identificacion->AdvancedSearch->Load();
		$this->Numero_Identificacion->AdvancedSearch->Load();
		$this->_EMail->AdvancedSearch->Load();
		$this->Comentarios->AdvancedSearch->Load();
		$this->Ap_Paterno->AdvancedSearch->Load();
		$this->Ap_materno->AdvancedSearch->Load();
		$this->Nombres->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_ca_clientes\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_ca_clientes',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fca_clienteslist,sel:false});\">" . "<img src=\"phpimages/exportemail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToEmail")) . "\" width=\"16\" height=\"16\" style=\"border: 0;\">" . "</a>";
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
if (!isset($ca_clientes_list)) $ca_clientes_list = new cca_clientes_list();

// Page init
$ca_clientes_list->Page_Init();

// Page main
$ca_clientes_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ca_clientes->Export == "") { ?>
<script type="text/javascript">

// Page object
var ca_clientes_list = new ew_Page("ca_clientes_list");
ca_clientes_list.PageID = "list"; // Page ID
var EW_PAGE_ID = ca_clientes_list.PageID; // For backward compatibility

// Form object
var fca_clienteslist = new ew_Form("fca_clienteslist");

// Form_CustomValidate event
fca_clienteslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_clienteslist.ValidateRequired = true;
<?php } else { ?>
fca_clienteslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_clienteslist.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fca_clienteslistsrch = new ew_Form("fca_clienteslistsrch");

// Validate function for search
fca_clienteslistsrch.Validate = function(fobj) {
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
fca_clienteslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_clienteslistsrch.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fca_clienteslistsrch.ValidateRequired = false; // no JavaScript validation
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
		$ca_clientes_list->TotalRecs = $ca_clientes->SelectRecordCount();
	} else {
		if ($ca_clientes_list->Recordset = $ca_clientes_list->LoadRecordset())
			$ca_clientes_list->TotalRecs = $ca_clientes_list->Recordset->RecordCount();
	}
	$ca_clientes_list->StartRec = 1;
	if ($ca_clientes_list->DisplayRecs <= 0 || ($ca_clientes->Export <> "" && $ca_clientes->ExportAll)) // Display all records
		$ca_clientes_list->DisplayRecs = $ca_clientes_list->TotalRecs;
	if (!($ca_clientes->Export <> "" && $ca_clientes->ExportAll))
		$ca_clientes_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ca_clientes_list->Recordset = $ca_clientes_list->LoadRecordset($ca_clientes_list->StartRec-1, $ca_clientes_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_clientes->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $ca_clientes_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($ca_clientes->Export == "" && $ca_clientes->CurrentAction == "") { ?>
<form name="fca_clienteslistsrch" id="fca_clienteslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ewForms[this.id].Submit();">
<a href="javascript:fca_clienteslistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fca_clienteslistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fca_clienteslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ca_clientes">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$ca_clientes_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$ca_clientes->RowType = EW_ROWTYPE_SEARCH;

// Render row
$ca_clientes->ResetAttrs();
$ca_clientes_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($ca_clientes->Categoria->Visible) { // Categoria ?>
	<span id="xsc_Categoria" class="ewCell">
		<span class="ewSearchCaption"><?php echo $ca_clientes->Categoria->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Categoria" id="z_Categoria" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Categoria" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Categoria" id="x_Categoria" value="{value}"<?php echo $ca_clientes->Categoria->EditAttributes() ?>></div>
<div id="dsl_x_Categoria" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_clientes->Categoria->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_clientes->Categoria->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Categoria" id="x_Categoria" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_clientes->Categoria->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($ca_clientes_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_3" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($ca_clientes_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($ca_clientes_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($ca_clientes_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ca_clientes_list->ShowPageHeader(); ?>
<?php
$ca_clientes_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($ca_clientes->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($ca_clientes->CurrentAction <> "gridadd" && $ca_clientes->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_clientes_list->Pager)) $ca_clientes_list->Pager = new cNumericPager($ca_clientes_list->StartRec, $ca_clientes_list->DisplayRecs, $ca_clientes_list->TotalRecs, $ca_clientes_list->RecRange) ?>
<?php if ($ca_clientes_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_clientes_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_clientes_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_clientes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_clientes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_clientes_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_clientes_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_clientes_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_clientes">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_clientes_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_clientes_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_clientes_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_clientes_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_clientes_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_clientes_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_clientes_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fca_clienteslist" id="fca_clienteslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="ca_clientes">
<div id="gmp_ca_clientes" class="ewGridMiddlePanel">
<?php if ($ca_clientes_list->TotalRecs > 0) { ?>
<table id="tbl_ca_clienteslist" class="ewTable ewTableSeparate">
<?php echo $ca_clientes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ca_clientes_list->RenderListOptions();

// Render list options (header, left)
$ca_clientes_list->ListOptions->Render("header", "left");
?>
<?php if ($ca_clientes->Nombre_Completo->Visible) { // Nombre_Completo ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Nombre_Completo) == "") { ?>
		<td><span id="elh_ca_clientes_Nombre_Completo" class="ca_clientes_Nombre_Completo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Nombre_Completo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Nombre_Completo) ?>',2);"><span id="elh_ca_clientes_Nombre_Completo" class="ca_clientes_Nombre_Completo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Nombre_Completo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Nombre_Completo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Nombre_Completo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Domicilio->Visible) { // Domicilio ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Domicilio) == "") { ?>
		<td><span id="elh_ca_clientes_Domicilio" class="ca_clientes_Domicilio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Domicilio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Domicilio) ?>',2);"><span id="elh_ca_clientes_Domicilio" class="ca_clientes_Domicilio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Domicilio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Domicilio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Domicilio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Num_Exterior->Visible) { // Num_Exterior ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Num_Exterior) == "") { ?>
		<td><span id="elh_ca_clientes_Num_Exterior" class="ca_clientes_Num_Exterior"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Num_Exterior->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Num_Exterior) ?>',2);"><span id="elh_ca_clientes_Num_Exterior" class="ca_clientes_Num_Exterior">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Num_Exterior->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Num_Exterior->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Num_Exterior->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Colonia->Visible) { // Colonia ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Colonia) == "") { ?>
		<td><span id="elh_ca_clientes_Colonia" class="ca_clientes_Colonia"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Colonia->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Colonia) ?>',2);"><span id="elh_ca_clientes_Colonia" class="ca_clientes_Colonia">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Colonia->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Colonia->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Colonia->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Id_Estado) == "") { ?>
		<td><span id="elh_ca_clientes_Id_Estado" class="ca_clientes_Id_Estado"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Id_Estado->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Id_Estado) ?>',2);"><span id="elh_ca_clientes_Id_Estado" class="ca_clientes_Id_Estado">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Id_Estado->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Id_Estado->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Id_Estado->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Categoria->Visible) { // Categoria ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Categoria) == "") { ?>
		<td><span id="elh_ca_clientes_Categoria" class="ca_clientes_Categoria"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Categoria->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Categoria) ?>',2);"><span id="elh_ca_clientes_Categoria" class="ca_clientes_Categoria">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Categoria->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Categoria->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Categoria->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Tel_Particular->Visible) { // Tel_Particular ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Tel_Particular) == "") { ?>
		<td><span id="elh_ca_clientes_Tel_Particular" class="ca_clientes_Tel_Particular"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Tel_Particular->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Tel_Particular) ?>',2);"><span id="elh_ca_clientes_Tel_Particular" class="ca_clientes_Tel_Particular">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Tel_Particular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Tel_Particular->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Tel_Particular->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Celular->Visible) { // Celular ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Celular) == "") { ?>
		<td><span id="elh_ca_clientes_Celular" class="ca_clientes_Celular"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Celular->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Celular) ?>',2);"><span id="elh_ca_clientes_Celular" class="ca_clientes_Celular">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Celular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Celular->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Celular->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ca_clientes->Comentarios->Visible) { // Comentarios ?>
	<?php if ($ca_clientes->SortUrl($ca_clientes->Comentarios) == "") { ?>
		<td><span id="elh_ca_clientes_Comentarios" class="ca_clientes_Comentarios"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $ca_clientes->Comentarios->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $ca_clientes->SortUrl($ca_clientes->Comentarios) ?>',2);"><span id="elh_ca_clientes_Comentarios" class="ca_clientes_Comentarios">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $ca_clientes->Comentarios->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($ca_clientes->Comentarios->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($ca_clientes->Comentarios->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ca_clientes_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ca_clientes->ExportAll && $ca_clientes->Export <> "") {
	$ca_clientes_list->StopRec = $ca_clientes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ca_clientes_list->TotalRecs > $ca_clientes_list->StartRec + $ca_clientes_list->DisplayRecs - 1)
		$ca_clientes_list->StopRec = $ca_clientes_list->StartRec + $ca_clientes_list->DisplayRecs - 1;
	else
		$ca_clientes_list->StopRec = $ca_clientes_list->TotalRecs;
}
$ca_clientes_list->RecCnt = $ca_clientes_list->StartRec - 1;
if ($ca_clientes_list->Recordset && !$ca_clientes_list->Recordset->EOF) {
	$ca_clientes_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ca_clientes_list->StartRec > 1)
		$ca_clientes_list->Recordset->Move($ca_clientes_list->StartRec - 1);
} elseif (!$ca_clientes->AllowAddDeleteRow && $ca_clientes_list->StopRec == 0) {
	$ca_clientes_list->StopRec = $ca_clientes->GridAddRowCount;
}

// Initialize aggregate
$ca_clientes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ca_clientes->ResetAttrs();
$ca_clientes_list->RenderRow();
while ($ca_clientes_list->RecCnt < $ca_clientes_list->StopRec) {
	$ca_clientes_list->RecCnt++;
	if (intval($ca_clientes_list->RecCnt) >= intval($ca_clientes_list->StartRec)) {
		$ca_clientes_list->RowCnt++;

		// Set up key count
		$ca_clientes_list->KeyCount = $ca_clientes_list->RowIndex;

		// Init row class and style
		$ca_clientes->ResetAttrs();
		$ca_clientes->CssClass = "";
		if ($ca_clientes->CurrentAction == "gridadd") {
		} else {
			$ca_clientes_list->LoadRowValues($ca_clientes_list->Recordset); // Load row values
		}
		$ca_clientes->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ca_clientes->RowAttrs = array_merge($ca_clientes->RowAttrs, array('data-rowindex'=>$ca_clientes_list->RowCnt, 'id'=>'r' . $ca_clientes_list->RowCnt . '_ca_clientes', 'data-rowtype'=>$ca_clientes->RowType));

		// Render row
		$ca_clientes_list->RenderRow();

		// Render list options
		$ca_clientes_list->RenderListOptions();
?>
	<tr<?php echo $ca_clientes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ca_clientes_list->ListOptions->Render("body", "left", $ca_clientes_list->RowCnt);
?>
	<?php if ($ca_clientes->Nombre_Completo->Visible) { // Nombre_Completo ?>
		<td<?php echo $ca_clientes->Nombre_Completo->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Nombre_Completo" class="ca_clientes_Nombre_Completo">
<span<?php echo $ca_clientes->Nombre_Completo->ViewAttributes() ?>>
<?php echo $ca_clientes->Nombre_Completo->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Domicilio->Visible) { // Domicilio ?>
		<td<?php echo $ca_clientes->Domicilio->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Domicilio" class="ca_clientes_Domicilio">
<span<?php echo $ca_clientes->Domicilio->ViewAttributes() ?>>
<?php echo $ca_clientes->Domicilio->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Num_Exterior->Visible) { // Num_Exterior ?>
		<td<?php echo $ca_clientes->Num_Exterior->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Num_Exterior" class="ca_clientes_Num_Exterior">
<span<?php echo $ca_clientes->Num_Exterior->ViewAttributes() ?>>
<?php echo $ca_clientes->Num_Exterior->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Colonia->Visible) { // Colonia ?>
		<td<?php echo $ca_clientes->Colonia->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Colonia" class="ca_clientes_Colonia">
<span<?php echo $ca_clientes->Colonia->ViewAttributes() ?>>
<?php echo $ca_clientes->Colonia->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Id_Estado->Visible) { // Id_Estado ?>
		<td<?php echo $ca_clientes->Id_Estado->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Id_Estado" class="ca_clientes_Id_Estado">
<span<?php echo $ca_clientes->Id_Estado->ViewAttributes() ?>>
<?php echo $ca_clientes->Id_Estado->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Categoria->Visible) { // Categoria ?>
		<td<?php echo $ca_clientes->Categoria->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Categoria" class="ca_clientes_Categoria">
<span<?php echo $ca_clientes->Categoria->ViewAttributes() ?>>
<?php echo $ca_clientes->Categoria->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Tel_Particular->Visible) { // Tel_Particular ?>
		<td<?php echo $ca_clientes->Tel_Particular->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Tel_Particular" class="ca_clientes_Tel_Particular">
<span<?php echo $ca_clientes->Tel_Particular->ViewAttributes() ?>>
<?php echo $ca_clientes->Tel_Particular->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Celular->Visible) { // Celular ?>
		<td<?php echo $ca_clientes->Celular->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Celular" class="ca_clientes_Celular">
<span<?php echo $ca_clientes->Celular->ViewAttributes() ?>>
<?php echo $ca_clientes->Celular->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ca_clientes->Comentarios->Visible) { // Comentarios ?>
		<td<?php echo $ca_clientes->Comentarios->CellAttributes() ?>><span id="el<?php echo $ca_clientes_list->RowCnt ?>_ca_clientes_Comentarios" class="ca_clientes_Comentarios">
<span<?php echo $ca_clientes->Comentarios->ViewAttributes() ?>>
<?php echo $ca_clientes->Comentarios->ListViewValue() ?></span>
</span><a id="<?php echo $ca_clientes_list->PageObjName . "_row_" . $ca_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$ca_clientes_list->ListOptions->Render("body", "right", $ca_clientes_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ca_clientes->CurrentAction <> "gridadd")
		$ca_clientes_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ca_clientes->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ca_clientes_list->Recordset)
	$ca_clientes_list->Recordset->Close();
?>
<?php if ($ca_clientes_list->TotalRecs > 0) { ?>
<?php if ($ca_clientes->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ca_clientes->CurrentAction <> "gridadd" && $ca_clientes->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_clientes_list->Pager)) $ca_clientes_list->Pager = new cNumericPager($ca_clientes_list->StartRec, $ca_clientes_list->DisplayRecs, $ca_clientes_list->TotalRecs, $ca_clientes_list->RecRange) ?>
<?php if ($ca_clientes_list->Pager->RecordCount > 0) { ?>
	<?php if ($ca_clientes_list->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_clientes_list->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_list->PageUrl() ?>start=<?php echo $ca_clientes_list->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ca_clientes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ca_clientes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ca_clientes_list->Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_clientes_list->SearchWhere == "0=101") { ?>
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
<?php if ($ca_clientes_list->TotalRecs > 0) { ?>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><table cellspacing="0" class="ewStdTable"><tbody><tr><td><?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</td><td>
<input type="hidden" name="t" value="ca_clientes">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();">
<option value="20"<?php if ($ca_clientes_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="40"<?php if ($ca_clientes_list->DisplayRecs == 40) { ?> selected="selected"<?php } ?>>40</option>
<option value="60"<?php if ($ca_clientes_list->DisplayRecs == 60) { ?> selected="selected"<?php } ?>>60</option>
<option value="100"<?php if ($ca_clientes_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($ca_clientes_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
</select></td></tr></tbody></table>
	</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_clientes_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $ca_clientes_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($ca_clientes->Export == "") { ?>
<script type="text/javascript">
fca_clienteslistsrch.Init();
fca_clienteslist.Init();
</script>
<?php } ?>
<?php
$ca_clientes_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ca_clientes->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ca_clientes_list->Page_Terminate();
?>
