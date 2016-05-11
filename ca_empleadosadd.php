<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_empleadosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_empleados_add = NULL; // Initialize page object first

class cca_empleados_add extends cca_empleados {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_empleados';

	// Page object name
	var $PageObjName = 'ca_empleados_add';

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

		// Table object (ca_empleados)
		if (!isset($GLOBALS["ca_empleados"])) {
			$GLOBALS["ca_empleados"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_empleados"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_empleados', TRUE);

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
			$this->Page_Terminate("ca_empleadoslist.php");
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
			if (@$_GET["IdEmpleado"] != "") {
				$this->IdEmpleado->setQueryStringValue($_GET["IdEmpleado"]);
				$this->setKey("IdEmpleado", $this->IdEmpleado->CurrentValue); // Set up key
			} else {
				$this->setKey("IdEmpleado", ""); // Clear key
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
					$this->Page_Terminate("ca_empleadoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ca_empleadosview.php")
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
		$this->Nombre->CurrentValue = NULL;
		$this->Nombre->OldValue = $this->Nombre->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->_EMail->CurrentValue = NULL;
		$this->_EMail->OldValue = $this->_EMail->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Tel_Fijo->CurrentValue = NULL;
		$this->Tel_Fijo->OldValue = $this->Tel_Fijo->CurrentValue;
		$this->Id_Nivel->CurrentValue = 0;
		$this->MunicipioDel->CurrentValue = NULL;
		$this->MunicipioDel->OldValue = $this->MunicipioDel->CurrentValue;
		$this->CP->CurrentValue = NULL;
		$this->CP->OldValue = $this->CP->CurrentValue;
		$this->DiaPago->CurrentValue = NULL;
		$this->DiaPago->OldValue = $this->DiaPago->CurrentValue;
		$this->Poblacion->CurrentValue = NULL;
		$this->Poblacion->OldValue = $this->Poblacion->CurrentValue;
		$this->FechaNacimiento->CurrentValue = NULL;
		$this->FechaNacimiento->OldValue = $this->FechaNacimiento->CurrentValue;
		$this->FechaIngreso->CurrentValue = NULL;
		$this->FechaIngreso->OldValue = $this->FechaIngreso->CurrentValue;
		$this->RFC->CurrentValue = NULL;
		$this->RFC->OldValue = $this->RFC->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nombre->FldIsDetailKey) {
			$this->Nombre->setFormValue($objForm->GetValue("x_Nombre"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->_EMail->FldIsDetailKey) {
			$this->_EMail->setFormValue($objForm->GetValue("x__EMail"));
		}
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		if (!$this->Tel_Fijo->FldIsDetailKey) {
			$this->Tel_Fijo->setFormValue($objForm->GetValue("x_Tel_Fijo"));
		}
		if (!$this->Id_Nivel->FldIsDetailKey) {
			$this->Id_Nivel->setFormValue($objForm->GetValue("x_Id_Nivel"));
		}
		if (!$this->MunicipioDel->FldIsDetailKey) {
			$this->MunicipioDel->setFormValue($objForm->GetValue("x_MunicipioDel"));
		}
		if (!$this->CP->FldIsDetailKey) {
			$this->CP->setFormValue($objForm->GetValue("x_CP"));
		}
		if (!$this->DiaPago->FldIsDetailKey) {
			$this->DiaPago->setFormValue($objForm->GetValue("x_DiaPago"));
		}
		if (!$this->Poblacion->FldIsDetailKey) {
			$this->Poblacion->setFormValue($objForm->GetValue("x_Poblacion"));
		}
		if (!$this->FechaNacimiento->FldIsDetailKey) {
			$this->FechaNacimiento->setFormValue($objForm->GetValue("x_FechaNacimiento"));
			$this->FechaNacimiento->CurrentValue = ew_UnFormatDateTime($this->FechaNacimiento->CurrentValue, 7);
		}
		if (!$this->FechaIngreso->FldIsDetailKey) {
			$this->FechaIngreso->setFormValue($objForm->GetValue("x_FechaIngreso"));
			$this->FechaIngreso->CurrentValue = ew_UnFormatDateTime($this->FechaIngreso->CurrentValue, 7);
		}
		if (!$this->RFC->FldIsDetailKey) {
			$this->RFC->setFormValue($objForm->GetValue("x_RFC"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Nombre->CurrentValue = $this->Nombre->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->_EMail->CurrentValue = $this->_EMail->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Tel_Fijo->CurrentValue = $this->Tel_Fijo->FormValue;
		$this->Id_Nivel->CurrentValue = $this->Id_Nivel->FormValue;
		$this->MunicipioDel->CurrentValue = $this->MunicipioDel->FormValue;
		$this->CP->CurrentValue = $this->CP->FormValue;
		$this->DiaPago->CurrentValue = $this->DiaPago->FormValue;
		$this->Poblacion->CurrentValue = $this->Poblacion->FormValue;
		$this->FechaNacimiento->CurrentValue = $this->FechaNacimiento->FormValue;
		$this->FechaNacimiento->CurrentValue = ew_UnFormatDateTime($this->FechaNacimiento->CurrentValue, 7);
		$this->FechaIngreso->CurrentValue = $this->FechaIngreso->FormValue;
		$this->FechaIngreso->CurrentValue = ew_UnFormatDateTime($this->FechaIngreso->CurrentValue, 7);
		$this->RFC->CurrentValue = $this->RFC->FormValue;
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
		$this->IdEmpleado->setDbValue($rs->fields('IdEmpleado'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Tel_Fijo->setDbValue($rs->fields('Tel_Fijo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->IdUsuarioJefe->setDbValue($rs->fields('IdUsuarioJefe'));
		$this->MunicipioDel->setDbValue($rs->fields('MunicipioDel'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->DiaPago->setDbValue($rs->fields('DiaPago'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->FechaNacimiento->setDbValue($rs->fields('FechaNacimiento'));
		$this->FechaIngreso->setDbValue($rs->fields('FechaIngreso'));
		$this->RFC->setDbValue($rs->fields('RFC'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IdEmpleado")) <> "")
			$this->IdEmpleado->CurrentValue = $this->getKey("IdEmpleado"); // IdEmpleado
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
		// IdEmpleado
		// Nombre
		// Domicilio
		// EMail
		// Celular
		// Tel_Fijo
		// Usuario
		// Password
		// Id_Nivel
		// IdUsuarioJefe
		// MunicipioDel
		// CP
		// Status
		// DiaPago
		// Poblacion
		// FechaNacimiento
		// FechaIngreso
		// RFC

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// IdEmpleado
			$this->IdEmpleado->ViewValue = $this->IdEmpleado->CurrentValue;
			$this->IdEmpleado->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
			$this->Nombre->ViewValue = strtoupper($this->Nombre->ViewValue);
			$this->Nombre->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewCustomAttributes = "";

			// EMail
			$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
			$this->_EMail->ViewCustomAttributes = "";

			// Celular
			$this->Celular->ViewValue = $this->Celular->CurrentValue;
			$this->Celular->ViewCustomAttributes = "";

			// Tel_Fijo
			$this->Tel_Fijo->ViewValue = $this->Tel_Fijo->CurrentValue;
			$this->Tel_Fijo->ViewCustomAttributes = "";

			// Id_Nivel
			if (strval($this->Id_Nivel->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_userlevels`";
			$sWhereWrk = "";
			$lookuptblfilter = "`userlevelid`>0";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `userlevelid`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Nivel->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
				}
			} else {
				$this->Id_Nivel->ViewValue = NULL;
			}
			$this->Id_Nivel->ViewCustomAttributes = "";

			// MunicipioDel
			$this->MunicipioDel->ViewValue = $this->MunicipioDel->CurrentValue;
			$this->MunicipioDel->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

			// DiaPago
			if (strval($this->DiaPago->CurrentValue) <> "") {
				switch ($this->DiaPago->CurrentValue) {
					case $this->DiaPago->FldTagValue(1):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(1) <> "" ? $this->DiaPago->FldTagCaption(1) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(2):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(2) <> "" ? $this->DiaPago->FldTagCaption(2) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(3):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(3) <> "" ? $this->DiaPago->FldTagCaption(3) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(4):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(4) <> "" ? $this->DiaPago->FldTagCaption(4) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(5):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(5) <> "" ? $this->DiaPago->FldTagCaption(5) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(6):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(6) <> "" ? $this->DiaPago->FldTagCaption(6) : $this->DiaPago->CurrentValue;
						break;
					case $this->DiaPago->FldTagValue(7):
						$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(7) <> "" ? $this->DiaPago->FldTagCaption(7) : $this->DiaPago->CurrentValue;
						break;
					default:
						$this->DiaPago->ViewValue = $this->DiaPago->CurrentValue;
				}
			} else {
				$this->DiaPago->ViewValue = NULL;
			}
			$this->DiaPago->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewCustomAttributes = "";

			// FechaNacimiento
			$this->FechaNacimiento->ViewValue = $this->FechaNacimiento->CurrentValue;
			$this->FechaNacimiento->ViewValue = ew_FormatDateTime($this->FechaNacimiento->ViewValue, 7);
			$this->FechaNacimiento->ViewCustomAttributes = "";

			// FechaIngreso
			$this->FechaIngreso->ViewValue = $this->FechaIngreso->CurrentValue;
			$this->FechaIngreso->ViewValue = ew_FormatDateTime($this->FechaIngreso->ViewValue, 7);
			$this->FechaIngreso->ViewCustomAttributes = "";

			// RFC
			$this->RFC->ViewValue = $this->RFC->CurrentValue;
			$this->RFC->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// EMail
			$this->_EMail->LinkCustomAttributes = "";
			$this->_EMail->HrefValue = "";
			$this->_EMail->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Tel_Fijo
			$this->Tel_Fijo->LinkCustomAttributes = "";
			$this->Tel_Fijo->HrefValue = "";
			$this->Tel_Fijo->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// MunicipioDel
			$this->MunicipioDel->LinkCustomAttributes = "";
			$this->MunicipioDel->HrefValue = "";
			$this->MunicipioDel->TooltipValue = "";

			// CP
			$this->CP->LinkCustomAttributes = "";
			$this->CP->HrefValue = "";
			$this->CP->TooltipValue = "";

			// DiaPago
			$this->DiaPago->LinkCustomAttributes = "";
			$this->DiaPago->HrefValue = "";
			$this->DiaPago->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// FechaNacimiento
			$this->FechaNacimiento->LinkCustomAttributes = "";
			$this->FechaNacimiento->HrefValue = "";
			$this->FechaNacimiento->TooltipValue = "";

			// FechaIngreso
			$this->FechaIngreso->LinkCustomAttributes = "";
			$this->FechaIngreso->HrefValue = "";
			$this->FechaIngreso->TooltipValue = "";

			// RFC
			$this->RFC->LinkCustomAttributes = "";
			$this->RFC->HrefValue = "";
			$this->RFC->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nombre
			$this->Nombre->EditCustomAttributes = 'class="mayusculas"  onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre->EditValue = ew_HtmlEncode($this->Nombre->CurrentValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);

			// EMail
			$this->_EMail->EditCustomAttributes = "";
			$this->_EMail->EditValue = ew_HtmlEncode($this->_EMail->CurrentValue);

			// Celular
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);

			// Tel_Fijo
			$this->Tel_Fijo->EditCustomAttributes = "";
			$this->Tel_Fijo->EditValue = ew_HtmlEncode($this->Tel_Fijo->CurrentValue);

			// Id_Nivel
			$this->Id_Nivel->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sys_userlevels`";
			$sWhereWrk = "";
			$lookuptblfilter = "`userlevelid`>0";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `userlevelid`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Nivel->EditValue = $arwrk;

			// MunicipioDel
			$this->MunicipioDel->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->MunicipioDel->EditValue = ew_HtmlEncode($this->MunicipioDel->CurrentValue);

			// CP
			$this->CP->EditCustomAttributes = "";
			$this->CP->EditValue = ew_HtmlEncode($this->CP->CurrentValue);

			// DiaPago
			$this->DiaPago->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->DiaPago->FldTagValue(1), $this->DiaPago->FldTagCaption(1) <> "" ? $this->DiaPago->FldTagCaption(1) : $this->DiaPago->FldTagValue(1));
			$arwrk[] = array($this->DiaPago->FldTagValue(2), $this->DiaPago->FldTagCaption(2) <> "" ? $this->DiaPago->FldTagCaption(2) : $this->DiaPago->FldTagValue(2));
			$arwrk[] = array($this->DiaPago->FldTagValue(3), $this->DiaPago->FldTagCaption(3) <> "" ? $this->DiaPago->FldTagCaption(3) : $this->DiaPago->FldTagValue(3));
			$arwrk[] = array($this->DiaPago->FldTagValue(4), $this->DiaPago->FldTagCaption(4) <> "" ? $this->DiaPago->FldTagCaption(4) : $this->DiaPago->FldTagValue(4));
			$arwrk[] = array($this->DiaPago->FldTagValue(5), $this->DiaPago->FldTagCaption(5) <> "" ? $this->DiaPago->FldTagCaption(5) : $this->DiaPago->FldTagValue(5));
			$arwrk[] = array($this->DiaPago->FldTagValue(6), $this->DiaPago->FldTagCaption(6) <> "" ? $this->DiaPago->FldTagCaption(6) : $this->DiaPago->FldTagValue(6));
			$arwrk[] = array($this->DiaPago->FldTagValue(7), $this->DiaPago->FldTagCaption(7) <> "" ? $this->DiaPago->FldTagCaption(7) : $this->DiaPago->FldTagValue(7));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->DiaPago->EditValue = $arwrk;

			// Poblacion
			$this->Poblacion->EditCustomAttributes = "";
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->CurrentValue);

			// FechaNacimiento
			$this->FechaNacimiento->EditCustomAttributes = "";
			$this->FechaNacimiento->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaNacimiento->CurrentValue, 7));

			// FechaIngreso
			$this->FechaIngreso->EditCustomAttributes = "";
			$this->FechaIngreso->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaIngreso->CurrentValue, 7));

			// RFC
			$this->RFC->EditCustomAttributes = "";
			$this->RFC->EditValue = ew_HtmlEncode($this->RFC->CurrentValue);

			// Edit refer script
			// Nombre

			$this->Nombre->HrefValue = "";

			// Domicilio
			$this->Domicilio->HrefValue = "";

			// EMail
			$this->_EMail->HrefValue = "";

			// Celular
			$this->Celular->HrefValue = "";

			// Tel_Fijo
			$this->Tel_Fijo->HrefValue = "";

			// Id_Nivel
			$this->Id_Nivel->HrefValue = "";

			// MunicipioDel
			$this->MunicipioDel->HrefValue = "";

			// CP
			$this->CP->HrefValue = "";

			// DiaPago
			$this->DiaPago->HrefValue = "";

			// Poblacion
			$this->Poblacion->HrefValue = "";

			// FechaNacimiento
			$this->FechaNacimiento->HrefValue = "";

			// FechaIngreso
			$this->FechaIngreso->HrefValue = "";

			// RFC
			$this->RFC->HrefValue = "";
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
		if (!is_null($this->Nombre->FormValue) && $this->Nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nombre->FldCaption());
		}
		if (!ew_CheckEuroDate($this->FechaNacimiento->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaNacimiento->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->FechaIngreso->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaIngreso->FldErrMsg());
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
		if ($this->Nombre->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Nombre = '" . ew_AdjustSql($this->Nombre->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Nombre->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Nombre->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Nombre
		$this->Nombre->SetDbValueDef($rsnew, $this->Nombre->CurrentValue, NULL, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// EMail
		$this->_EMail->SetDbValueDef($rsnew, $this->_EMail->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Tel_Fijo
		$this->Tel_Fijo->SetDbValueDef($rsnew, $this->Tel_Fijo->CurrentValue, NULL, FALSE);

		// Id_Nivel
		$this->Id_Nivel->SetDbValueDef($rsnew, $this->Id_Nivel->CurrentValue, NULL, strval($this->Id_Nivel->CurrentValue) == "");

		// MunicipioDel
		$this->MunicipioDel->SetDbValueDef($rsnew, $this->MunicipioDel->CurrentValue, NULL, FALSE);

		// CP
		$this->CP->SetDbValueDef($rsnew, $this->CP->CurrentValue, NULL, FALSE);

		// DiaPago
		$this->DiaPago->SetDbValueDef($rsnew, $this->DiaPago->CurrentValue, NULL, FALSE);

		// Poblacion
		$this->Poblacion->SetDbValueDef($rsnew, $this->Poblacion->CurrentValue, NULL, FALSE);

		// FechaNacimiento
		$this->FechaNacimiento->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaNacimiento->CurrentValue, 7), NULL, FALSE);

		// FechaIngreso
		$this->FechaIngreso->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaIngreso->CurrentValue, 7), NULL, FALSE);

		// RFC
		$this->RFC->SetDbValueDef($rsnew, $this->RFC->CurrentValue, NULL, FALSE);

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
			$this->IdEmpleado->setDbValue($conn->Insert_ID());
			$rsnew['IdEmpleado'] = $this->IdEmpleado->DbValue;
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
if (!isset($ca_empleados_add)) $ca_empleados_add = new cca_empleados_add();

// Page init
$ca_empleados_add->Page_Init();

// Page main
$ca_empleados_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_empleados_add = new ew_Page("ca_empleados_add");
ca_empleados_add.PageID = "add"; // Page ID
var EW_PAGE_ID = ca_empleados_add.PageID; // For backward compatibility

// Form object
var fca_empleadosadd = new ew_Form("fca_empleadosadd");

// Validate form
fca_empleadosadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_empleados->Nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_FechaNacimiento"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_empleados->FechaNacimiento->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_FechaIngreso"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_empleados->FechaIngreso->FldErrMsg()) ?>");

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
fca_empleadosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_empleadosadd.ValidateRequired = true;
<?php } else { ?>
fca_empleadosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_empleadosadd.Lists["x_Id_Nivel"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_empleados->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $ca_empleados->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $ca_empleados_add->ShowPageHeader(); ?>
<?php
$ca_empleados_add->ShowMessage();
?>
<form name="fca_empleadosadd" id="fca_empleadosadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="ca_empleados">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_ca_empleadosadd" class="ewTable">
<?php if ($ca_empleados->Nombre->Visible) { // Nombre ?>
	<tr id="r_Nombre"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Nombre"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Nombre->CellAttributes() ?>><span id="el_ca_empleados_Nombre">
<input type="text" name="x_Nombre" id="x_Nombre" size="50" maxlength="50" value="<?php echo $ca_empleados->Nombre->EditValue ?>"<?php echo $ca_empleados->Nombre->EditAttributes() ?>>
</span><?php echo $ca_empleados->Nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Domicilio"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Domicilio->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Domicilio->CellAttributes() ?>><span id="el_ca_empleados_Domicilio">
<textarea name="x_Domicilio" id="x_Domicilio" cols="50" rows="3"<?php echo $ca_empleados->Domicilio->EditAttributes() ?>><?php echo $ca_empleados->Domicilio->EditValue ?></textarea>
</span><?php echo $ca_empleados->Domicilio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->_EMail->Visible) { // EMail ?>
	<tr id="r__EMail"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados__EMail"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->_EMail->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->_EMail->CellAttributes() ?>><span id="el_ca_empleados__EMail">
<input type="text" name="x__EMail" id="x__EMail" size="50" maxlength="50" value="<?php echo $ca_empleados->_EMail->EditValue ?>"<?php echo $ca_empleados->_EMail->EditAttributes() ?>>
</span><?php echo $ca_empleados->_EMail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->Celular->Visible) { // Celular ?>
	<tr id="r_Celular"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Celular"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Celular->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Celular->CellAttributes() ?>><span id="el_ca_empleados_Celular">
<input type="text" name="x_Celular" id="x_Celular" size="20" maxlength="20" value="<?php echo $ca_empleados->Celular->EditValue ?>"<?php echo $ca_empleados->Celular->EditAttributes() ?>>
</span><?php echo $ca_empleados->Celular->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->Tel_Fijo->Visible) { // Tel_Fijo ?>
	<tr id="r_Tel_Fijo"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Tel_Fijo"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Tel_Fijo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Tel_Fijo->CellAttributes() ?>><span id="el_ca_empleados_Tel_Fijo">
<input type="text" name="x_Tel_Fijo" id="x_Tel_Fijo" size="30" maxlength="50" value="<?php echo $ca_empleados->Tel_Fijo->EditValue ?>"<?php echo $ca_empleados->Tel_Fijo->EditAttributes() ?>>
</span><?php echo $ca_empleados->Tel_Fijo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->Id_Nivel->Visible) { // Id_Nivel ?>
	<tr id="r_Id_Nivel"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Id_Nivel"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Id_Nivel->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Id_Nivel->CellAttributes() ?>><span id="el_ca_empleados_Id_Nivel">
<select id="x_Id_Nivel" name="x_Id_Nivel"<?php echo $ca_empleados->Id_Nivel->EditAttributes() ?>>
<?php
if (is_array($ca_empleados->Id_Nivel->EditValue)) {
	$arwrk = $ca_empleados->Id_Nivel->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_empleados->Id_Nivel->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_empleadosadd.Lists["x_Id_Nivel"].Options = <?php echo (is_array($ca_empleados->Id_Nivel->EditValue)) ? ew_ArrayToJson($ca_empleados->Id_Nivel->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $ca_empleados->Id_Nivel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->MunicipioDel->Visible) { // MunicipioDel ?>
	<tr id="r_MunicipioDel"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_MunicipioDel"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->MunicipioDel->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->MunicipioDel->CellAttributes() ?>><span id="el_ca_empleados_MunicipioDel">
<input type="text" name="x_MunicipioDel" id="x_MunicipioDel" size="50" maxlength="50" value="<?php echo $ca_empleados->MunicipioDel->EditValue ?>"<?php echo $ca_empleados->MunicipioDel->EditAttributes() ?>>
</span><?php echo $ca_empleados->MunicipioDel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->CP->Visible) { // CP ?>
	<tr id="r_CP"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_CP"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->CP->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->CP->CellAttributes() ?>><span id="el_ca_empleados_CP">
<input type="text" name="x_CP" id="x_CP" size="6" maxlength="5" value="<?php echo $ca_empleados->CP->EditValue ?>"<?php echo $ca_empleados->CP->EditAttributes() ?>>
</span><?php echo $ca_empleados->CP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->DiaPago->Visible) { // DiaPago ?>
	<tr id="r_DiaPago"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_DiaPago"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->DiaPago->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->DiaPago->CellAttributes() ?>><span id="el_ca_empleados_DiaPago">
<select id="x_DiaPago" name="x_DiaPago"<?php echo $ca_empleados->DiaPago->EditAttributes() ?>>
<?php
if (is_array($ca_empleados->DiaPago->EditValue)) {
	$arwrk = $ca_empleados->DiaPago->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_empleados->DiaPago->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $ca_empleados->DiaPago->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->Poblacion->Visible) { // Poblacion ?>
	<tr id="r_Poblacion"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_Poblacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->Poblacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->Poblacion->CellAttributes() ?>><span id="el_ca_empleados_Poblacion">
<input type="text" name="x_Poblacion" id="x_Poblacion" size="50" maxlength="50" value="<?php echo $ca_empleados->Poblacion->EditValue ?>"<?php echo $ca_empleados->Poblacion->EditAttributes() ?>>
</span><?php echo $ca_empleados->Poblacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->FechaNacimiento->Visible) { // FechaNacimiento ?>
	<tr id="r_FechaNacimiento"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_FechaNacimiento"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->FechaNacimiento->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->FechaNacimiento->CellAttributes() ?>><span id="el_ca_empleados_FechaNacimiento">
<input type="text" name="x_FechaNacimiento" id="x_FechaNacimiento" size="12" maxlength="10" value="<?php echo $ca_empleados->FechaNacimiento->EditValue ?>"<?php echo $ca_empleados->FechaNacimiento->EditAttributes() ?>>
<?php if (!$ca_empleados->FechaNacimiento->ReadOnly && !$ca_empleados->FechaNacimiento->Disabled && @$ca_empleados->FechaNacimiento->EditAttrs["readonly"] == "" && @$ca_empleados->FechaNacimiento->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fca_empleadosadd$x_FechaNacimiento$" name="fca_empleadosadd$x_FechaNacimiento$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fca_empleadosadd", "x_FechaNacimiento", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $ca_empleados->FechaNacimiento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->FechaIngreso->Visible) { // FechaIngreso ?>
	<tr id="r_FechaIngreso"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_FechaIngreso"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->FechaIngreso->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->FechaIngreso->CellAttributes() ?>><span id="el_ca_empleados_FechaIngreso">
<input type="text" name="x_FechaIngreso" id="x_FechaIngreso" size="12" maxlength="10" value="<?php echo $ca_empleados->FechaIngreso->EditValue ?>"<?php echo $ca_empleados->FechaIngreso->EditAttributes() ?>>
<?php if (!$ca_empleados->FechaIngreso->ReadOnly && !$ca_empleados->FechaIngreso->Disabled && @$ca_empleados->FechaIngreso->EditAttrs["readonly"] == "" && @$ca_empleados->FechaIngreso->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fca_empleadosadd$x_FechaIngreso$" name="fca_empleadosadd$x_FechaIngreso$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fca_empleadosadd", "x_FechaIngreso", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $ca_empleados->FechaIngreso->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_empleados->RFC->Visible) { // RFC ?>
	<tr id="r_RFC"<?php echo $ca_empleados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_empleados_RFC"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_empleados->RFC->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_empleados->RFC->CellAttributes() ?>><span id="el_ca_empleados_RFC">
<input type="text" name="x_RFC" id="x_RFC" size="16" maxlength="15" value="<?php echo $ca_empleados->RFC->EditValue ?>"<?php echo $ca_empleados->RFC->EditAttributes() ?>>
</span><?php echo $ca_empleados->RFC->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fca_empleadosadd.Init();
</script>
<?php
$ca_empleados_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_empleados_add->Page_Terminate();
?>
