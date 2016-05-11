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

$ca_clientes_view = NULL; // Initialize page object first

class cca_clientes_view extends cca_clientes {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_clientes';

	// Page object name
	var $PageObjName = 'ca_clientes_view';

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
		$KeyUrl = "";
		if (@$_GET["Id_Cliente"] <> "") {
			$this->RecKey["Id_Cliente"] = $_GET["Id_Cliente"];
			$KeyUrl .= "&Id_Cliente=" . urlencode($this->RecKey["Id_Cliente"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_clientes', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("ca_clienteslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
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
	var $ExportOptions; // Export options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["Id_Cliente"] <> "") {
				$this->Id_Cliente->setQueryStringValue($_GET["Id_Cliente"]);
				$this->RecKey["Id_Cliente"] = $this->Id_Cliente->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("ca_clienteslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Id_Cliente->CurrentValue) == strval($this->Recordset->fields('Id_Cliente'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ca_clienteslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "ca_clienteslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Cliente
		// Nombre_Completo
		// Razon_Social
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
		// Ap_materno
		// Nombres

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

			// Num_Interior
			$this->Num_Interior->LinkCustomAttributes = "";
			$this->Num_Interior->HrefValue = "";
			$this->Num_Interior->TooltipValue = "";

			// Colonia
			$this->Colonia->LinkCustomAttributes = "";
			$this->Colonia->HrefValue = "";
			$this->Colonia->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// MunicipioDel
			$this->MunicipioDel->LinkCustomAttributes = "";
			$this->MunicipioDel->HrefValue = "";
			$this->MunicipioDel->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// CP
			$this->CP->LinkCustomAttributes = "";
			$this->CP->HrefValue = "";
			$this->CP->TooltipValue = "";

			// RFC
			$this->RFC->LinkCustomAttributes = "";
			$this->RFC->HrefValue = "";
			$this->RFC->TooltipValue = "";

			// Categoria
			$this->Categoria->LinkCustomAttributes = "";
			$this->Categoria->HrefValue = "";
			$this->Categoria->TooltipValue = "";

			// CURP
			$this->CURP->LinkCustomAttributes = "";
			$this->CURP->HrefValue = "";
			$this->CURP->TooltipValue = "";

			// Tel_Particular
			$this->Tel_Particular->LinkCustomAttributes = "";
			$this->Tel_Particular->HrefValue = "";
			$this->Tel_Particular->TooltipValue = "";

			// Tel_Oficina
			$this->Tel_Oficina->LinkCustomAttributes = "";
			$this->Tel_Oficina->HrefValue = "";
			$this->Tel_Oficina->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Edad
			$this->Edad->LinkCustomAttributes = "";
			$this->Edad->HrefValue = "";
			$this->Edad->TooltipValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";
			$this->Sexo->TooltipValue = "";

			// Tipo_Identificacion
			$this->Tipo_Identificacion->LinkCustomAttributes = "";
			$this->Tipo_Identificacion->HrefValue = "";
			$this->Tipo_Identificacion->TooltipValue = "";

			// Otra_Identificacion
			$this->Otra_Identificacion->LinkCustomAttributes = "";
			$this->Otra_Identificacion->HrefValue = "";
			$this->Otra_Identificacion->TooltipValue = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->LinkCustomAttributes = "";
			$this->Numero_Identificacion->HrefValue = "";
			$this->Numero_Identificacion->TooltipValue = "";

			// EMail
			$this->_EMail->LinkCustomAttributes = "";
			$this->_EMail->HrefValue = "";
			$this->_EMail->TooltipValue = "";

			// Comentarios
			$this->Comentarios->LinkCustomAttributes = "";
			$this->Comentarios->HrefValue = "";
			$this->Comentarios->TooltipValue = "";
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ca_clientes_view)) $ca_clientes_view = new cca_clientes_view();

// Page init
$ca_clientes_view->Page_Init();

// Page main
$ca_clientes_view->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_clientes_view = new ew_Page("ca_clientes_view");
ca_clientes_view.PageID = "view"; // Page ID
var EW_PAGE_ID = ca_clientes_view.PageID; // For backward compatibility

// Form object
var fca_clientesview = new ew_Form("fca_clientesview");

// Form_CustomValidate event
fca_clientesview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_clientesview.ValidateRequired = true;
<?php } else { ?>
fca_clientesview.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fca_clientesview.MultiPage = new ew_MultiPage("fca_clientesview");
fca_clientesview.MultiPage.Elements = [["x_Nombre_Completo",1],["x_Domicilio",1],["x_Num_Exterior",1],["x_Num_Interior",1],["x_Colonia",1],["x_Poblacion",1],["x_MunicipioDel",1],["x_Id_Estado",1],["x_CP",1],["x_RFC",1],["x_Categoria",1],["x_CURP",2],["x_Tel_Particular",2],["x_Tel_Oficina",2],["x_Celular",2],["x_Edad",2],["x_Sexo",1],["x_Tipo_Identificacion",2],["x_Otra_Identificacion",2],["x_Numero_Identificacion",2],["x__EMail",2],["x_Comentarios",2]];

// Dynamic selection lists
fca_clientesview.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_clientes->TableCaption() ?>&nbsp;&nbsp;</span><?php $ca_clientes_view->ExportOptions->Render("body"); ?>
</p>
<p class="phpmaker">
<a href="<?php echo $ca_clientes_view->ListUrl ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<?php if ($ca_clientes_view->AddUrl <> "") { ?>
<a href="<?php echo $ca_clientes_view->AddUrl ?>" id="a_AddLink" class="ewLink"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<?php if ($ca_clientes_view->EditUrl <> "") { ?>
<a href="<?php echo $ca_clientes_view->EditUrl ?>" id="a_EditLink" class="ewLink"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<?php if ($ca_clientes_view->DeleteUrl <> "") { ?>
<a href="<?php echo $ca_clientes_view->DeleteUrl ?>" id="a_DeleteLink" class="ewLink"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php $ca_clientes_view->ShowPageHeader(); ?>
<?php
$ca_clientes_view->ShowMessage();
?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<span class="phpmaker">
<?php if (!isset($ca_clientes_view->Pager)) $ca_clientes_view->Pager = new cNumericPager($ca_clientes_view->StartRec, $ca_clientes_view->DisplayRecs, $ca_clientes_view->TotalRecs, $ca_clientes_view->RecRange) ?>
<?php if ($ca_clientes_view->Pager->RecordCount > 0) { ?>
	<?php if ($ca_clientes_view->Pager->FirstButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_view->PageUrl() ?>start=<?php echo $ca_clientes_view->Pager->FirstButton->Start ?>"><b><?php echo $Language->Phrase("PagerFirst") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_view->Pager->PrevButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_view->PageUrl() ?>start=<?php echo $ca_clientes_view->Pager->PrevButton->Start ?>"><b><?php echo $Language->Phrase("PagerPrevious") ?></b></a>&nbsp;
	<?php } ?>
	<?php foreach ($ca_clientes_view->Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="<?php echo $ca_clientes_view->PageUrl() ?>start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_view->Pager->NextButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_view->PageUrl() ?>start=<?php echo $ca_clientes_view->Pager->NextButton->Start ?>"><b><?php echo $Language->Phrase("PagerNext") ?></b></a>&nbsp;
	<?php } ?>
	<?php if ($ca_clientes_view->Pager->LastButton->Enabled) { ?>
	<a href="<?php echo $ca_clientes_view->PageUrl() ?>start=<?php echo $ca_clientes_view->Pager->LastButton->Start ?>"><b><?php echo $Language->Phrase("PagerLast") ?></b></a>&nbsp;
	<?php } ?>
<?php } else { ?>	
	<?php if ($Security->CanList()) { ?>
	<?php if ($ca_clientes_view->SearchWhere == "0=101") { ?>
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
</tr></table>
</form>
<br>
<form name="fca_clientesview" id="fca_clientesview" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="ca_clientes">
<?php if ($ca_clientes->Export == "") { ?>
<table class="ewStdTable"><tbody><tr><td>
<div id="ca_clientes_view" class="yui-navset">
	<ul class="yui-nav">
		<li class="selected"><a href="#tab_ca_