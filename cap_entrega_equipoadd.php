<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_entrega_equipo_detgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_equipo_add = NULL; // Initialize page object first

class ccap_entrega_equipo_add extends ccap_entrega_equipo {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_equipo';

	// Page object name
	var $PageObjName = 'cap_entrega_equipo_add';

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

		// Table object (cap_entrega_equipo)
		if (!isset($GLOBALS["cap_entrega_equipo"])) {
			$GLOBALS["cap_entrega_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_equipo"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_equipo', TRUE);

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
			$this->Page_Terminate("cap_entrega_equipolist.php");
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
			if (@$_GET["Id_Traspaso"] != "") {
				$this->Id_Traspaso->setQueryStringValue($_GET["Id_Traspaso"]);
				$this->setKey("Id_Traspaso", $this->Id_Traspaso->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Traspaso", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("cap_entrega_equipolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_entrega_equipoview.php")
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
		$this->Id_Almacen_Entrega->CurrentValue = NULL;
		$this->Id_Almacen_Entrega->OldValue = $this->Id_Almacen_Entrega->CurrentValue;
		$this->Id_Almacen_Recibe->CurrentValue = NULL;
		$this->Id_Almacen_Recibe->OldValue = $this->Id_Almacen_Recibe->CurrentValue;
		$this->Status->CurrentValue = "Enviado";
		$this->Fecha->CurrentValue = NULL;
		$this->Fecha->OldValue = $this->Fecha->CurrentValue;
		$this->Hora->CurrentValue = NULL;
		$this->Hora->OldValue = $this->Hora->CurrentValue;
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
		$this->Id_Empleado_Entrega->CurrentValue = NULL;
		$this->Id_Empleado_Entrega->OldValue = $this->Id_Empleado_Entrega->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Almacen_Entrega->FldIsDetailKey) {
			$this->Id_Almacen_Entrega->setFormValue($objForm->GetValue("x_Id_Almacen_Entrega"));
		}
		if (!$this->Id_Almacen_Recibe->FldIsDetailKey) {
			$this->Id_Almacen_Recibe->setFormValue($objForm->GetValue("x_Id_Almacen_Recibe"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->Hora->FldIsDetailKey) {
			$this->Hora->setFormValue($objForm->GetValue("x_Hora"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->Id_Empleado_Entrega->FldIsDetailKey) {
			$this->Id_Empleado_Entrega->setFormValue($objForm->GetValue("x_Id_Empleado_Entrega"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Almacen_Entrega->CurrentValue = $this->Id_Almacen_Entrega->FormValue;
		$this->Id_Almacen_Recibe->CurrentValue = $this->Id_Almacen_Recibe->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->Hora->CurrentValue = $this->Hora->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->Id_Empleado_Entrega->CurrentValue = $this->Id_Empleado_Entrega->FormValue;
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
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Id_Almacen_Entrega->setDbValue($rs->fields('Id_Almacen_Entrega'));
		$this->Id_Almacen_Recibe->setDbValue($rs->fields('Id_Almacen_Recibe'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Hora->setDbValue($rs->fields('Hora'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Id_Empleado_Entrega->setDbValue($rs->fields('Id_Empleado_Entrega'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Traspaso")) <> "")
			$this->Id_Traspaso->CurrentValue = $this->getKey("Id_Traspaso"); // Id_Traspaso
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
		// Id_Traspaso
		// Id_Almacen_Entrega
		// Id_Almacen_Recibe
		// Status
		// Fecha
		// Hora
		// TipoArticulo
		// Observaciones
		// Id_Empleado_Entrega

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Traspaso
			$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";

			// Id_Almacen_Entrega
			if (strval($this->Id_Almacen_Entrega->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Entrega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Entrega->ViewValue = $this->Id_Almacen_Entrega->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Entrega->ViewValue = NULL;
			}
			$this->Id_Almacen_Entrega->ViewCustomAttributes = "";

			// Id_Almacen_Recibe
			if (strval($this->Id_Almacen_Recibe->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Recibe->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Recibe->ViewValue = $this->Id_Almacen_Recibe->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Recibe->ViewValue = NULL;
			}
			$this->Id_Almacen_Recibe->ViewCustomAttributes = "";

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(3):
						$this->Status->ViewValue = $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Hora
			$this->Hora->ViewValue = $this->Hora->CurrentValue;
			$this->Hora->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// Id_Empleado_Entrega
			if (strval($this->Id_Empleado_Entrega->CurrentValue) <> "") {
				$sFilterWrk = "`IdEmpleado`" . ew_SearchString("=", $this->Id_Empleado_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `IdEmpleado`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_empleados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Empleado_Entrega->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Empleado_Entrega->ViewValue = $this->Id_Empleado_Entrega->CurrentValue;
				}
			} else {
				$this->Id_Empleado_Entrega->ViewValue = NULL;
			}
			$this->Id_Empleado_Entrega->ViewCustomAttributes = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrega->HrefValue = "";
			$this->Id_Almacen_Entrega->TooltipValue = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->LinkCustomAttributes = "";
			$this->Id_Almacen_Recibe->HrefValue = "";
			$this->Id_Almacen_Recibe->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Hora
			$this->Hora->LinkCustomAttributes = "";
			$this->Hora->HrefValue = "";
			$this->Hora->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->LinkCustomAttributes = "";
			$this->Id_Empleado_Entrega->HrefValue = "";
			$this->Id_Empleado_Entrega->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Almacen_Entrega
			// Id_Almacen_Recibe

			$this->Id_Almacen_Recibe->EditCustomAttributes = "";
			if (trim(strval($this->Id_Almacen_Recibe->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Recibe->EditValue = $arwrk;

			// Status
			// Fecha
			// Hora
			// Observaciones

			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Id_Empleado_Entrega
			// Edit refer script
			// Id_Almacen_Entrega

			$this->Id_Almacen_Entrega->HrefValue = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Hora
			$this->Hora->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Id_Empleado_Entrega
			$this->Id_Empleado_Entrega->HrefValue = "";
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
		if (!is_null($this->Id_Almacen_Recibe->FormValue) && $this->Id_Almacen_Recibe->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Almacen_Recibe->FldCaption());
		}

		// Validate detail grid
		if ($this->getCurrentDetailTable() == "cap_entrega_equipo_det" && $GLOBALS["cap_entrega_equipo_det"]->DetailAdd) {
			if (!isset($GLOBALS["cap_entrega_equipo_det_grid"])) $GLOBALS["cap_entrega_equipo_det_grid"] = new ccap_entrega_equipo_det_grid(); // get detail page object
			$GLOBALS["cap_entrega_equipo_det_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();
		$rsnew = array();

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->SetDbValueDef($rsnew, Id_Tienda_actual(), 0);
		$rsnew['Id_Almacen_Entrega'] = &$this->Id_Almacen_Entrega->DbValue;

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe->SetDbValueDef($rsnew, $this->Id_Almacen_Recibe->CurrentValue, 0, FALSE);

		// Status
		$this->Status->SetDbValueDef($rsnew, Enviado(), "");
		$rsnew['Status'] = &$this->Status->DbValue;

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_CurrentDate(), ew_CurrentDate());
		$rsnew['Fecha'] = &$this->Fecha->DbValue;

		// Hora
		$this->Hora->SetDbValueDef($rsnew, ew_CurrentTime(), ew_CurrentTime());
		$rsnew['Hora'] = &$this->Hora->DbValue;

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Id_Empleado_Entrega
		$this->Id_Empleado_Entrega->SetDbValueDef($rsnew, CurrentUserID(), 0);
		$rsnew['Id_Empleado_Entrega'] = &$this->Id_Empleado_Entrega->DbValue;

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
			$this->Id_Traspaso->setDbValue($conn->Insert_ID());
			$rsnew['Id_Traspaso'] = $this->Id_Traspaso->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			if ($this->getCurrentDetailTable() == "cap_entrega_equipo_det" && $GLOBALS["cap_entrega_equipo_det"]->DetailAdd) {
				$GLOBALS["cap_entrega_equipo_det"]->Id_Traspaso->setSessionValue($this->Id_Traspaso->CurrentValue); // Set master key
				if (!isset($GLOBALS["cap_entrega_equipo_det_grid"])) $GLOBALS["cap_entrega_equipo_det_grid"] = new ccap_entrega_equipo_det_grid(); // get detail page object
				$AddRow = $GLOBALS["cap_entrega_equipo_det_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cap_entrega_equipo_det"]->Id_Traspaso->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			if ($sDetailTblVar == "cap_entrega_equipo_det") {
				if (!isset($GLOBALS["cap_entrega_equipo_det_grid"]))
					$GLOBALS["cap_entrega_equipo_det_grid"] = new ccap_entrega_equipo_det_grid;
				if ($GLOBALS["cap_entrega_equipo_det_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cap_entrega_equipo_det_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cap_entrega_equipo_det_grid"]->CurrentMode = "add";
					$GLOBALS["cap_entrega_equipo_det_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cap_entrega_equipo_det_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cap_entrega_equipo_det_grid"]->setStartRecordNumber(1);
					$GLOBALS["cap_entrega_equipo_det_grid"]->Id_Traspaso->FldIsDetailKey = TRUE;
					$GLOBALS["cap_entrega_equipo_det_grid"]->Id_Traspaso->CurrentValue = $this->Id_Traspaso->CurrentValue;
					$GLOBALS["cap_entrega_equipo_det_grid"]->Id_Traspaso->setSessionValue($GLOBALS["cap_entrega_equipo_det_grid"]->Id_Traspaso->CurrentValue);
				}
			}
		}
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
if (!isset($cap_entrega_equipo_add)) $cap_entrega_equipo_add = new ccap_entrega_equipo_add();

// Page init
$cap_entrega_equipo_add->Page_Init();

// Page main
$cap_entrega_equipo_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_entrega_equipo_add = new ew_Page("cap_entrega_equipo_add");
cap_entrega_equipo_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_entrega_equipo_add.PageID; // For backward compatibility

// Form object
var fcap_entrega_equipoadd = new ew_Form("fcap_entrega_equipoadd");

// Validate form
fcap_entrega_equipoadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Almacen_Recibe"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_equipo->Id_Almacen_Recibe->FldCaption()) ?>");

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
fcap_entrega_equipoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_equipoadd.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_equipoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_equipoadd.Lists["x_Id_Almacen_Entrega"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_equipoadd.Lists["x_Id_Almacen_Recibe"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_equipoadd.Lists["x_Id_Empleado_Entrega"] = {"LinkField":"x_IdEmpleado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_equipo->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_entrega_equipo->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_entrega_equipo_add->ShowPageHeader(); ?>
<?php
$cap_entrega_equipo_add->ShowMessage();
?>
<form name="fcap_entrega_equipoadd" id="fcap_entrega_equipoadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_entrega_equipo">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_equipoadd" class="ewTable">
<?php if ($cap_entrega_equipo->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
	<tr id="r_Id_Almacen_Recibe"<?php echo $cap_entrega_equipo->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_equipo_Id_Almacen_Recibe"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo->Id_Almacen_Recibe->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->CellAttributes() ?>><span id="el_cap_entrega_equipo_Id_Almacen_Recibe">
<select id="x_Id_Almacen_Recibe" name="x_Id_Almacen_Recibe"<?php echo $cap_entrega_equipo->Id_Almacen_Recibe->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo->Id_Almacen_Recibe->EditValue)) {
	$arwrk = $cap_entrega_equipo->Id_Almacen_Recibe->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo->Id_Almacen_Recibe->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
$sWhereWrk = "";
$lookuptblfilter = "Id_Almacen>1 AND Id_Almacen<>".Id_Tienda_Actual();
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Almacen` Asc";
?>
<input type="hidden" name="s_x_Id_Almacen_Recibe" id="s_x_Id_Almacen_Recibe" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo->Id_Almacen_Recibe->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Almacen` = {filter_value}"); ?>&t0=19">
</span><?php echo $cap_entrega_equipo->Id_Almacen_Recibe->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_equipo->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones"<?php echo $cap_entrega_equipo->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_equipo_Observaciones"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo->Observaciones->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_equipo->Observaciones->CellAttributes() ?>><span id="el_cap_entrega_equipo_Observaciones">
<textarea name="x_Observaciones" id="x_Observaciones" cols="50" rows="4"<?php echo $cap_entrega_equipo->Observaciones->EditAttributes() ?>><?php echo $cap_entrega_equipo->Observaciones->EditValue ?></textarea>
</span><?php echo $cap_entrega_equipo->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<?php if ($cap_entrega_equipo->getCurrentDetailTable() == "cap_entrega_equipo_det" && $cap_entrega_equipo_det->DetailAdd) { ?>
<br>
<?php include_once "cap_entrega_equipo_detgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_entrega_equipoadd.Init();
</script>
<?php
$cap_entrega_equipo_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_equipo_add->Page_Terminate();
?>
