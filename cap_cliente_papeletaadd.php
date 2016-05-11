<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_cliente_papeletainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_cliente_papeleta_add = NULL; // Initialize page object first

class ccap_cliente_papeleta_add extends ccap_cliente_papeleta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_cliente_papeleta';

	// Page object name
	var $PageObjName = 'cap_cliente_papeleta_add';

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

		// Table object (cap_cliente_papeleta)
		if (!isset($GLOBALS["cap_cliente_papeleta"])) {
			$GLOBALS["cap_cliente_papeleta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_cliente_papeleta"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_cliente_papeleta', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("cap_cliente_papeletalist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id_Cliente"] != "") {
				$this->Id_Cliente->setQueryStringValue($_GET["Id_Cliente"]);
				$this->setKey("Id_Cliente", $this->Id_Cliente->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Cliente", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cap_cliente_papeletalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_cliente_papeletaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = -1;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Nombre_Completo->CurrentValue = NULL;
		$this->Nombre_Completo->OldValue = $this->Nombre_Completo->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Num_Exterior->CurrentValue = NULL;
		$this->Num_Exterior->OldValue = $this->Num_Exterior->CurrentValue;
		$this->Num_Interior->CurrentValue = NULL;
		$this->Num_Interior->OldValue = $this->Num_Interior->CurrentValue;
		$this->Colonia->CurrentValue = NULL;
		$this->Colonia->OldValue = $this->Colonia->CurrentValue;
		$this->Poblacion->CurrentValue = NULL;
		$this->Poblacion->OldValue = $this->Poblacion->CurrentValue;
		$this->CP->CurrentValue = NULL;
		$this->CP->OldValue = $this->CP->CurrentValue;
		$this->Id_Estado->CurrentValue = 17;
		$this->Tel_Particular->CurrentValue = NULL;
		$this->Tel_Particular->OldValue = $this->Tel_Particular->CurrentValue;
		$this->Tel_Oficina->CurrentValue = NULL;
		$this->Tel_Oficina->OldValue = $this->Tel_Oficina->CurrentValue;
		$this->Tipo_Identificacion->CurrentValue = 'IFE';
		$this->Numero_Identificacion->CurrentValue = NULL;
		$this->Numero_Identificacion->OldValue = $this->Numero_Identificacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nombre_Completo->FldIsDetailKey) {
			$this->Nombre_Completo->setFormValue($objForm->GetValue("x_Nombre_Completo"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Num_Exterior->FldIsDetailKey) {
			$this->Num_Exterior->setFormValue($objForm->GetValue("x_Num_Exterior"));
		}
		if (!$this->Num_Interior->FldIsDetailKey) {
			$this->Num_Interior->setFormValue($objForm->GetValue("x_Num_Interior"));
		}
		if (!$this->Colonia->FldIsDetailKey) {
			$this->Colonia->setFormValue($objForm->GetValue("x_Colonia"));
		}
		if (!$this->Poblacion->FldIsDetailKey) {
			$this->Poblacion->setFormValue($objForm->GetValue("x_Poblacion"));
		}
		if (!$this->CP->FldIsDetailKey) {
			$this->CP->setFormValue($objForm->GetValue("x_CP"));
		}
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		if (!$this->Tel_Particular->FldIsDetailKey) {
			$this->Tel_Particular->setFormValue($objForm->GetValue("x_Tel_Particular"));
		}
		if (!$this->Tel_Oficina->FldIsDetailKey) {
			$this->Tel_Oficina->setFormValue($objForm->GetValue("x_Tel_Oficina"));
		}
		if (!$this->Tipo_Identificacion->FldIsDetailKey) {
			$this->Tipo_Identificacion->setFormValue($objForm->GetValue("x_Tipo_Identificacion"));
		}
		if (!$this->Numero_Identificacion->FldIsDetailKey) {
			$this->Numero_Identificacion->setFormValue($objForm->GetValue("x_Numero_Identificacion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Nombre_Completo->CurrentValue = $this->Nombre_Completo->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Num_Exterior->CurrentValue = $this->Num_Exterior->FormValue;
		$this->Num_Interior->CurrentValue = $this->Num_Interior->FormValue;
		$this->Colonia->CurrentValue = $this->Colonia->FormValue;
		$this->Poblacion->CurrentValue = $this->Poblacion->FormValue;
		$this->CP->CurrentValue = $this->CP->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Tel_Particular->CurrentValue = $this->Tel_Particular->FormValue;
		$this->Tel_Oficina->CurrentValue = $this->Tel_Oficina->FormValue;
		$this->Tipo_Identificacion->CurrentValue = $this->Tipo_Identificacion->FormValue;
		$this->Numero_Identificacion->CurrentValue = $this->Numero_Identificacion->FormValue;
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
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Num_Exterior->setDbValue($rs->fields('Num_Exterior'));
		$this->Num_Interior->setDbValue($rs->fields('Num_Interior'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Tel_Particular->setDbValue($rs->fields('Tel_Particular'));
		$this->Tel_Oficina->setDbValue($rs->fields('Tel_Oficina'));
		$this->Tipo_Identificacion->setDbValue($rs->fields('Tipo_Identificacion'));
		$this->Numero_Identificacion->setDbValue($rs->fields('Numero_Identificacion'));
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Cliente
		// Nombre_Completo
		// Domicilio
		// Num_Exterior
		// Num_Interior
		// Colonia
		// Poblacion
		// CP
		// Id_Estado
		// Tel_Particular
		// Tel_Oficina
		// Tipo_Identificacion
		// Numero_Identificacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Cliente
			$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
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
			$this->Poblacion->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

			// Id_Estado
			if (strval($this->Id_Estado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado`";
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

			// Tel_Particular
			$this->Tel_Particular->ViewValue = $this->Tel_Particular->CurrentValue;
			$this->Tel_Particular->ViewCustomAttributes = "";

			// Tel_Oficina
			$this->Tel_Oficina->ViewValue = $this->Tel_Oficina->CurrentValue;
			$this->Tel_Oficina->ViewCustomAttributes = "";

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

			// Numero_Identificacion
			$this->Numero_Identificacion->ViewValue = $this->Numero_Identificacion->CurrentValue;
			$this->Numero_Identificacion->ViewCustomAttributes = "";

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

			// CP
			$this->CP->LinkCustomAttributes = "";
			$this->CP->HrefValue = "";
			$this->CP->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Tel_Particular
			$this->Tel_Particular->LinkCustomAttributes = "";
			$this->Tel_Particular->HrefValue = "";
			$this->Tel_Particular->TooltipValue = "";

			// Tel_Oficina
			$this->Tel_Oficina->LinkCustomAttributes = "";
			$this->Tel_Oficina->HrefValue = "";
			$this->Tel_Oficina->TooltipValue = "";

			// Tipo_Identificacion
			$this->Tipo_Identificacion->LinkCustomAttributes = "";
			$this->Tipo_Identificacion->HrefValue = "";
			$this->Tipo_Identificacion->TooltipValue = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->LinkCustomAttributes = "";
			$this->Numero_Identificacion->HrefValue = "";
			$this->Numero_Identificacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nombre_Completo
			$this->Nombre_Completo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre_Completo->EditValue = ew_HtmlEncode($this->Nombre_Completo->CurrentValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);

			// Num_Exterior
			$this->Num_Exterior->EditCustomAttributes = "";
			$this->Num_Exterior->EditValue = ew_HtmlEncode($this->Num_Exterior->CurrentValue);

			// Num_Interior
			$this->Num_Interior->EditCustomAttributes = "";
			$this->Num_Interior->EditValue = ew_HtmlEncode($this->Num_Interior->CurrentValue);

			// Colonia
			$this->Colonia->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Colonia->EditValue = ew_HtmlEncode($this->Colonia->CurrentValue);

			// Poblacion
			$this->Poblacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->CurrentValue);

			// CP
			$this->CP->EditCustomAttributes = "";
			$this->CP->EditValue = ew_HtmlEncode($this->CP->CurrentValue);

			// Id_Estado
			$this->Id_Estado->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Estado->EditValue = $arwrk;

			// Tel_Particular
			$this->Tel_Particular->EditCustomAttributes = "";
			$this->Tel_Particular->EditValue = ew_HtmlEncode($this->Tel_Particular->CurrentValue);

			// Tel_Oficina
			$this->Tel_Oficina->EditCustomAttributes = "";
			$this->Tel_Oficina->EditValue = ew_HtmlEncode($this->Tel_Oficina->CurrentValue);

			// Tipo_Identificacion
			$this->Tipo_Identificacion->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(1), $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(2), $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(3), $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->FldTagValue(3));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(4), $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->FldTagValue(4));
			$this->Tipo_Identificacion->EditValue = $arwrk;

			// Numero_Identificacion
			$this->Numero_Identificacion->EditCustomAttributes = "";
			$this->Numero_Identificacion->EditValue = ew_HtmlEncode($this->Numero_Identificacion->CurrentValue);

			// Edit refer script
			// Nombre_Completo

			$this->Nombre_Completo->HrefValue = "";

			// Domicilio
			$this->Domicilio->HrefValue = "";

			// Num_Exterior
			$this->Num_Exterior->HrefValue = "";

			// Num_Interior
			$this->Num_Interior->HrefValue = "";

			// Colonia
			$this->Colonia->HrefValue = "";

			// Poblacion
			$this->Poblacion->HrefValue = "";

			// CP
			$this->CP->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->HrefValue = "";

			// Tel_Particular
			$this->Tel_Particular->HrefValue = "";

			// Tel_Oficina
			$this->Tel_Oficina->HrefValue = "";

			// Tipo_Identificacion
			$this->Tipo_Identificacion->HrefValue = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->HrefValue = "";
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
		if (!is_null($this->Nombre_Completo->FormValue) && $this->Nombre_Completo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nombre_Completo->FldCaption());
		}
		if (!is_null($this->Domicilio->FormValue) && $this->Domicilio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Domicilio->FldCaption());
		}
		if (!is_null($this->Num_Exterior->FormValue) && $this->Num_Exterior->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_Exterior->FldCaption());
		}
		if (!is_null($this->Colonia->FormValue) && $this->Colonia->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Colonia->FldCaption());
		}
		if (!is_null($this->Poblacion->FormValue) && $this->Poblacion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Poblacion->FldCaption());
		}
		if (!is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Estado->FldCaption());
		}
		if ($this->Tipo_Identificacion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Tipo_Identificacion->FldCaption());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		$rsnew = array();

		// Nombre_Completo
		$this->Nombre_Completo->SetDbValueDef($rsnew, $this->Nombre_Completo->CurrentValue, NULL, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Num_Exterior
		$this->Num_Exterior->SetDbValueDef($rsnew, $this->Num_Exterior->CurrentValue, NULL, FALSE);

		// Num_Interior
		$this->Num_Interior->SetDbValueDef($rsnew, $this->Num_Interior->CurrentValue, NULL, FALSE);

		// Colonia
		$this->Colonia->SetDbValueDef($rsnew, $this->Colonia->CurrentValue, NULL, FALSE);

		// Poblacion
		$this->Poblacion->SetDbValueDef($rsnew, $this->Poblacion->CurrentValue, NULL, FALSE);

		// CP
		$this->CP->SetDbValueDef($rsnew, $this->CP->CurrentValue, NULL, FALSE);

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, NULL, FALSE);

		// Tel_Particular
		$this->Tel_Particular->SetDbValueDef($rsnew, $this->Tel_Particular->CurrentValue, NULL, FALSE);

		// Tel_Oficina
		$this->Tel_Oficina->SetDbValueDef($rsnew, $this->Tel_Oficina->CurrentValue, NULL, FALSE);

		// Tipo_Identificacion
		$this->Tipo_Identificacion->SetDbValueDef($rsnew, $this->Tipo_Identificacion->CurrentValue, NULL, strval($this->Tipo_Identificacion->CurrentValue) == "");

		// Numero_Identificacion
		$this->Numero_Identificacion->SetDbValueDef($rsnew, $this->Numero_Identificacion->CurrentValue, NULL, FALSE);

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
			$this->Id_Cliente->setDbValue($conn->Insert_ID());
			$rsnew['Id_Cliente'] = $this->Id_Cliente->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cap_cliente_papeleta_add)) $cap_cliente_papeleta_add = new ccap_cliente_papeleta_add();

// Page init
$cap_cliente_papeleta_add->Page_Init();

// Page main
$cap_cliente_papeleta_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_cliente_papeleta_add = new ew_Page("cap_cliente_papeleta_add");
cap_cliente_papeleta_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_cliente_papeleta_add.PageID; // For backward compatibility

// Form object
var fcap_cliente_papeletaadd = new ew_Form("fcap_cliente_papeletaadd");

// Validate form
fcap_cliente_papeletaadd.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = "";
		elm = fobj.elements["x" + infix + "_Nombre_Completo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Nombre_Completo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Domicilio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Domicilio->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_Exterior"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Num_Exterior->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Colonia"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Colonia->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Poblacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Poblacion->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Estado"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Id_Estado->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Tipo_Identificacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_cliente_papeleta->Tipo_Identificacion->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}

	// Process detail page
	if (fobj.detailpage && fobj.detailpage.value && ewForms[fobj.detailpage.value])
		return ewForms[fobj.detailpage.value].Validate(fobj);
	return true;
}

// Form_CustomValidate event
fcap_cliente_papeletaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_cliente_papeletaadd.ValidateRequired = true;
<?php } else { ?>
fcap_cliente_papeletaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_cliente_papeletaadd.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_cliente_papeleta->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_cliente_papeleta->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_cliente_papeleta_add->ShowPageHeader(); ?>
<?php
$cap_cliente_papeleta_add->ShowMessage();
?>
<form name="fcap_cliente_papeletaadd" id="fcap_cliente_papeletaadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_cliente_papeleta">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_cliente_papeletaadd" class="ewTable">
<?php if ($cap_cliente_papeleta->Nombre_Completo->Visible) { // Nombre_Completo ?>
	<tr id="r_Nombre_Completo"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Nombre_Completo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Nombre_Completo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Nombre_Completo->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Nombre_Completo">
<input type="text" name="x_Nombre_Completo" id="x_Nombre_Completo" size="50" maxlength="50" value="<?php echo $cap_cliente_papeleta->Nombre_Completo->EditValue ?>"<?php echo $cap_cliente_papeleta->Nombre_Completo->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Nombre_Completo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Domicilio"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Domicilio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Domicilio->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Domicilio">
<textarea name="x_Domicilio" id="x_Domicilio" cols="50" rows="3"<?php echo $cap_cliente_papeleta->Domicilio->EditAttributes() ?>><?php echo $cap_cliente_papeleta->Domicilio->EditValue ?></textarea>
</span><?php echo $cap_cliente_papeleta->Domicilio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Num_Exterior->Visible) { // Num_Exterior ?>
	<tr id="r_Num_Exterior"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Num_Exterior"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Num_Exterior->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Num_Exterior->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Num_Exterior">
<input type="text" name="x_Num_Exterior" id="x_Num_Exterior" size="5" maxlength="5" value="<?php echo $cap_cliente_papeleta->Num_Exterior->EditValue ?>"<?php echo $cap_cliente_papeleta->Num_Exterior->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Num_Exterior->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Num_Interior->Visible) { // Num_Interior ?>
	<tr id="r_Num_Interior"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Num_Interior"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Num_Interior->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Num_Interior->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Num_Interior">
<input type="text" name="x_Num_Interior" id="x_Num_Interior" size="5" maxlength="5" value="<?php echo $cap_cliente_papeleta->Num_Interior->EditValue ?>"<?php echo $cap_cliente_papeleta->Num_Interior->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Num_Interior->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Colonia->Visible) { // Colonia ?>
	<tr id="r_Colonia"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Colonia"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Colonia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Colonia->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Colonia">
<input type="text" name="x_Colonia" id="x_Colonia" size="50" maxlength="50" value="<?php echo $cap_cliente_papeleta->Colonia->EditValue ?>"<?php echo $cap_cliente_papeleta->Colonia->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Colonia->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Poblacion->Visible) { // Poblacion ?>
	<tr id="r_Poblacion"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Poblacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Poblacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Poblacion->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Poblacion">
<input type="text" name="x_Poblacion" id="x_Poblacion" size="50" maxlength="50" value="<?php echo $cap_cliente_papeleta->Poblacion->EditValue ?>"<?php echo $cap_cliente_papeleta->Poblacion->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Poblacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->CP->Visible) { // CP ?>
	<tr id="r_CP"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_CP"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->CP->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->CP->CellAttributes() ?>><span id="el_cap_cliente_papeleta_CP">
<input type="text" name="x_CP" id="x_CP" size="6" maxlength="5" value="<?php echo $cap_cliente_papeleta->CP->EditValue ?>"<?php echo $cap_cliente_papeleta->CP->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->CP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Id_Estado->Visible) { // Id_Estado ?>
	<tr id="r_Id_Estado"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Id_Estado"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Id_Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Id_Estado->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Id_Estado">
<select id="x_Id_Estado" name="x_Id_Estado"<?php echo $cap_cliente_papeleta->Id_Estado->EditAttributes() ?>>
<?php
if (is_array($cap_cliente_papeleta->Id_Estado->EditValue)) {
	$arwrk = $cap_cliente_papeleta->Id_Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cliente_papeleta->Id_Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_cliente_papeletaadd.Lists["x_Id_Estado"].Options = <?php echo (is_array($cap_cliente_papeleta->Id_Estado->EditValue)) ? ew_ArrayToJson($cap_cliente_papeleta->Id_Estado->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_cliente_papeleta->Id_Estado->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Tel_Particular->Visible) { // Tel_Particular ?>
	<tr id="r_Tel_Particular"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Tel_Particular"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Tel_Particular->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Tel_Particular->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Tel_Particular">
<input type="text" name="x_Tel_Particular" id="x_Tel_Particular" size="20" maxlength="20" value="<?php echo $cap_cliente_papeleta->Tel_Particular->EditValue ?>"<?php echo $cap_cliente_papeleta->Tel_Particular->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Tel_Particular->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Tel_Oficina->Visible) { // Tel_Oficina ?>
	<tr id="r_Tel_Oficina"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Tel_Oficina"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Tel_Oficina->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Tel_Oficina->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Tel_Oficina">
<input type="text" name="x_Tel_Oficina" id="x_Tel_Oficina" size="20" maxlength="20" value="<?php echo $cap_cliente_papeleta->Tel_Oficina->EditValue ?>"<?php echo $cap_cliente_papeleta->Tel_Oficina->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Tel_Oficina->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Tipo_Identificacion->Visible) { // Tipo_Identificacion ?>
	<tr id="r_Tipo_Identificacion"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Tipo_Identificacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Tipo_Identificacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Tipo_Identificacion->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Tipo_Identificacion">
<div id="tp_x_Tipo_Identificacion" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="{value}"<?php echo $cap_cliente_papeleta->Tipo_Identificacion->EditAttributes() ?>></div>
<div id="dsl_x_Tipo_Identificacion" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_cliente_papeleta->Tipo_Identificacion->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_cliente_papeleta->Tipo_Identificacion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_cliente_papeleta->Tipo_Identificacion->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_cliente_papeleta->Tipo_Identificacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_cliente_papeleta->Numero_Identificacion->Visible) { // Numero_Identificacion ?>
	<tr id="r_Numero_Identificacion"<?php echo $cap_cliente_papeleta->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_cliente_papeleta_Numero_Identificacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_cliente_papeleta->Numero_Identificacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_cliente_papeleta->Numero_Identificacion->CellAttributes() ?>><span id="el_cap_cliente_papeleta_Numero_Identificacion">
<input type="text" name="x_Numero_Identificacion" id="x_Numero_Identificacion" size="20" maxlength="20" value="<?php echo $cap_cliente_papeleta->Numero_Identificacion->EditValue ?>"<?php echo $cap_cliente_papeleta->Numero_Identificacion->EditAttributes() ?>>
</span><?php echo $cap_cliente_papeleta->Numero_Identificacion->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_cliente_papeletaadd.Init();
</script>
<?php
$cap_cliente_papeleta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_cliente_papeleta_add->Page_Terminate();
?>
