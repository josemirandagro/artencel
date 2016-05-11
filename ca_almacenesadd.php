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

$ca_almacenes_add = NULL; // Initialize page object first

class cca_almacenes_add extends cca_almacenes {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_almacenes';

	// Page object name
	var $PageObjName = 'ca_almacenes_add';

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

		// Table object (ca_almacenes)
		if (!isset($GLOBALS["ca_almacenes"])) {
			$GLOBALS["ca_almacenes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_almacenes"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_almacenes', TRUE);

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
			$this->Page_Terminate("ca_almaceneslist.php");
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
			if (@$_GET["Id_Almacen"] != "") {
				$this->Id_Almacen->setQueryStringValue($_GET["Id_Almacen"]);
				$this->setKey("Id_Almacen", $this->Id_Almacen->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Almacen", ""); // Clear key
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
					$this->Page_Terminate("ca_almaceneslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ca_almacenesview.php")
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
		$this->Almacen->CurrentValue = NULL;
		$this->Almacen->OldValue = $this->Almacen->CurrentValue;
		$this->Nombre_Corto->CurrentValue = NULL;
		$this->Nombre_Corto->OldValue = $this->Nombre_Corto->CurrentValue;
		$this->Id_Responsable->CurrentValue = NULL;
		$this->Id_Responsable->OldValue = $this->Id_Responsable->CurrentValue;
		$this->Telefonos->CurrentValue = NULL;
		$this->Telefonos->OldValue = $this->Telefonos->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Maximo_Equipos->CurrentValue = NULL;
		$this->Maximo_Equipos->OldValue = $this->Maximo_Equipos->CurrentValue;
		$this->Domicilio_Fiscal->CurrentValue = NULL;
		$this->Domicilio_Fiscal->OldValue = $this->Domicilio_Fiscal->CurrentValue;
		$this->Categoria->CurrentValue = "Publico 1";
		$this->Serie_NotaVenta->CurrentValue = NULL;
		$this->Serie_NotaVenta->OldValue = $this->Serie_NotaVenta->CurrentValue;
		$this->Serie_Factura->CurrentValue = NULL;
		$this->Serie_Factura->OldValue = $this->Serie_Factura->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Almacen->FldIsDetailKey) {
			$this->Almacen->setFormValue($objForm->GetValue("x_Almacen"));
		}
		if (!$this->Nombre_Corto->FldIsDetailKey) {
			$this->Nombre_Corto->setFormValue($objForm->GetValue("x_Nombre_Corto"));
		}
		if (!$this->Id_Responsable->FldIsDetailKey) {
			$this->Id_Responsable->setFormValue($objForm->GetValue("x_Id_Responsable"));
		}
		if (!$this->Telefonos->FldIsDetailKey) {
			$this->Telefonos->setFormValue($objForm->GetValue("x_Telefonos"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Maximo_Equipos->FldIsDetailKey) {
			$this->Maximo_Equipos->setFormValue($objForm->GetValue("x_Maximo_Equipos"));
		}
		if (!$this->Domicilio_Fiscal->FldIsDetailKey) {
			$this->Domicilio_Fiscal->setFormValue($objForm->GetValue("x_Domicilio_Fiscal"));
		}
		if (!$this->Categoria->FldIsDetailKey) {
			$this->Categoria->setFormValue($objForm->GetValue("x_Categoria"));
		}
		if (!$this->Serie_NotaVenta->FldIsDetailKey) {
			$this->Serie_NotaVenta->setFormValue($objForm->GetValue("x_Serie_NotaVenta"));
		}
		if (!$this->Serie_Factura->FldIsDetailKey) {
			$this->Serie_Factura->setFormValue($objForm->GetValue("x_Serie_Factura"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Almacen->CurrentValue = $this->Almacen->FormValue;
		$this->Nombre_Corto->CurrentValue = $this->Nombre_Corto->FormValue;
		$this->Id_Responsable->CurrentValue = $this->Id_Responsable->FormValue;
		$this->Telefonos->CurrentValue = $this->Telefonos->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Maximo_Equipos->CurrentValue = $this->Maximo_Equipos->FormValue;
		$this->Domicilio_Fiscal->CurrentValue = $this->Domicilio_Fiscal->FormValue;
		$this->Categoria->CurrentValue = $this->Categoria->FormValue;
		$this->Serie_NotaVenta->CurrentValue = $this->Serie_NotaVenta->FormValue;
		$this->Serie_Factura->CurrentValue = $this->Serie_Factura->FormValue;
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Almacen
		// Almacen
		// Nombre_Corto
		// Id_Responsable
		// Telefonos
		// Domicilio
		// Maximo_Equipos
		// Domicilio_Fiscal
		// Categoria
		// Serie_NotaVenta
		// Consecutivo_NotaVenta
		// Serie_Factura
		// Consecutivo_Factura
		// Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// Maximo_Equipos
			$this->Maximo_Equipos->ViewValue = $this->Maximo_Equipos->CurrentValue;
			$this->Maximo_Equipos->ViewCustomAttributes = "";

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

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Maximo_Equipos
			$this->Maximo_Equipos->LinkCustomAttributes = "";
			$this->Maximo_Equipos->HrefValue = "";
			$this->Maximo_Equipos->TooltipValue = "";

			// Domicilio_Fiscal
			$this->Domicilio_Fiscal->LinkCustomAttributes = "";
			$this->Domicilio_Fiscal->HrefValue = "";
			$this->Domicilio_Fiscal->TooltipValue = "";

			// Categoria
			$this->Categoria->LinkCustomAttributes = "";
			$this->Categoria->HrefValue = "";
			$this->Categoria->TooltipValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->LinkCustomAttributes = "";
			$this->Serie_NotaVenta->HrefValue = "";
			$this->Serie_NotaVenta->TooltipValue = "";

			// Serie_Factura
			$this->Serie_Factura->LinkCustomAttributes = "";
			$this->Serie_Factura->HrefValue = "";
			$this->Serie_Factura->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Almacen
			$this->Almacen->EditCustomAttributes = 'class="mayusculas"  onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Almacen->EditValue = ew_HtmlEncode($this->Almacen->CurrentValue);

			// Nombre_Corto
			$this->Nombre_Corto->EditCustomAttributes = "";
			$this->Nombre_Corto->EditValue = ew_HtmlEncode($this->Nombre_Corto->CurrentValue);

			// Id_Responsable
			$this->Id_Responsable->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `IdEmpleado`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_empleados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Responsable->EditValue = $arwrk;

			// Telefonos
			$this->Telefonos->EditCustomAttributes = "";
			$this->Telefonos->EditValue = ew_HtmlEncode($this->Telefonos->CurrentValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);

			// Maximo_Equipos
			$this->Maximo_Equipos->EditCustomAttributes = "";
			$this->Maximo_Equipos->EditValue = ew_HtmlEncode($this->Maximo_Equipos->CurrentValue);

			// Domicilio_Fiscal
			$this->Domicilio_Fiscal->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio_Fiscal->EditValue = ew_HtmlEncode($this->Domicilio_Fiscal->CurrentValue);

			// Categoria
			$this->Categoria->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Categoria->FldTagValue(1), $this->Categoria->FldTagCaption(1) <> "" ? $this->Categoria->FldTagCaption(1) : $this->Categoria->FldTagValue(1));
			$arwrk[] = array($this->Categoria->FldTagValue(2), $this->Categoria->FldTagCaption(2) <> "" ? $this->Categoria->FldTagCaption(2) : $this->Categoria->FldTagValue(2));
			$arwrk[] = array($this->Categoria->FldTagValue(3), $this->Categoria->FldTagCaption(3) <> "" ? $this->Categoria->FldTagCaption(3) : $this->Categoria->FldTagValue(3));
			$this->Categoria->EditValue = $arwrk;

			// Serie_NotaVenta
			$this->Serie_NotaVenta->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Serie_NotaVenta->EditValue = ew_HtmlEncode($this->Serie_NotaVenta->CurrentValue);

			// Serie_Factura
			$this->Serie_Factura->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Serie_Factura->EditValue = ew_HtmlEncode($this->Serie_Factura->CurrentValue);

			// Edit refer script
			// Almacen

			$this->Almacen->HrefValue = "";

			// Nombre_Corto
			$this->Nombre_Corto->HrefValue = "";

			// Id_Responsable
			$this->Id_Responsable->HrefValue = "";

			// Telefonos
			$this->Telefonos->HrefValue = "";

			// Domicilio
			$this->Domicilio->HrefValue = "";

			// Maximo_Equipos
			$this->Maximo_Equipos->HrefValue = "";

			// Domicilio_Fiscal
			$this->Domicilio_Fiscal->HrefValue = "";

			// Categoria
			$this->Categoria->HrefValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->HrefValue = "";

			// Serie_Factura
			$this->Serie_Factura->HrefValue = "";
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
		if (!is_null($this->Almacen->FormValue) && $this->Almacen->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Almacen->FldCaption());
		}
		if (!is_null($this->Telefonos->FormValue) && $this->Telefonos->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Telefonos->FldCaption());
		}
		if (!is_null($this->Domicilio->FormValue) && $this->Domicilio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Domicilio->FldCaption());
		}
		if (!ew_CheckInteger($this->Maximo_Equipos->FormValue)) {
			ew_AddMessage($gsFormError, $this->Maximo_Equipos->FldErrMsg());
		}
		if ($this->Categoria->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Categoria->FldCaption());
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
		if ($this->Almacen->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Almacen = '" . ew_AdjustSql($this->Almacen->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Almacen->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Almacen->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Almacen
		$this->Almacen->SetDbValueDef($rsnew, $this->Almacen->CurrentValue, "", FALSE);

		// Nombre_Corto
		$this->Nombre_Corto->SetDbValueDef($rsnew, $this->Nombre_Corto->CurrentValue, NULL, FALSE);

		// Id_Responsable
		$this->Id_Responsable->SetDbValueDef($rsnew, $this->Id_Responsable->CurrentValue, NULL, FALSE);

		// Telefonos
		$this->Telefonos->SetDbValueDef($rsnew, $this->Telefonos->CurrentValue, NULL, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, "", FALSE);

		// Maximo_Equipos
		$this->Maximo_Equipos->SetDbValueDef($rsnew, $this->Maximo_Equipos->CurrentValue, NULL, FALSE);

		// Domicilio_Fiscal
		$this->Domicilio_Fiscal->SetDbValueDef($rsnew, $this->Domicilio_Fiscal->CurrentValue, NULL, FALSE);

		// Categoria
		$this->Categoria->SetDbValueDef($rsnew, $this->Categoria->CurrentValue, NULL, strval($this->Categoria->CurrentValue) == "");

		// Serie_NotaVenta
		$this->Serie_NotaVenta->SetDbValueDef($rsnew, $this->Serie_NotaVenta->CurrentValue, NULL, FALSE);

		// Serie_Factura
		$this->Serie_Factura->SetDbValueDef($rsnew, $this->Serie_Factura->CurrentValue, NULL, FALSE);

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
			$this->Id_Almacen->setDbValue($conn->Insert_ID());
			$rsnew['Id_Almacen'] = $this->Id_Almacen->DbValue;
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
if (!isset($ca_almacenes_add)) $ca_almacenes_add = new cca_almacenes_add();

// Page init
$ca_almacenes_add->Page_Init();

// Page main
$ca_almacenes_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_almacenes_add = new ew_Page("ca_almacenes_add");
ca_almacenes_add.PageID = "add"; // Page ID
var EW_PAGE_ID = ca_almacenes_add.PageID; // For backward compatibility

// Form object
var fca_almacenesadd = new ew_Form("fca_almacenesadd");

// Validate form
fca_almacenesadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Almacen"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_almacenes->Almacen->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Telefonos"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_almacenes->Telefonos->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Domicilio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_almacenes->Domicilio->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Maximo_Equipos"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_almacenes->Maximo_Equipos->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Categoria"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_almacenes->Categoria->FldCaption()) ?>");

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
fca_almacenesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_almacenesadd.ValidateRequired = true;
<?php } else { ?>
fca_almacenesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_almacenesadd.Lists["x_Id_Responsable"] = {"LinkField":"x_IdEmpleado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_almacenes->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $ca_almacenes->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $ca_almacenes_add->ShowPageHeader(); ?>
<?php
$ca_almacenes_add->ShowMessage();
?>
<form name="fca_almacenesadd" id="fca_almacenesadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="ca_almacenes">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_ca_almacenesadd" class="ewTable">
<?php if ($ca_almacenes->Almacen->Visible) { // Almacen ?>
	<tr id="r_Almacen"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Almacen"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Almacen->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Almacen->CellAttributes() ?>><span id="el_ca_almacenes_Almacen">
<input type="text" name="x_Almacen" id="x_Almacen" size="30" maxlength="50" value="<?php echo $ca_almacenes->Almacen->EditValue ?>"<?php echo $ca_almacenes->Almacen->EditAttributes() ?>>
</span><?php echo $ca_almacenes->Almacen->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Nombre_Corto->Visible) { // Nombre_Corto ?>
	<tr id="r_Nombre_Corto"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Nombre_Corto"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Nombre_Corto->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Nombre_Corto->CellAttributes() ?>><span id="el_ca_almacenes_Nombre_Corto">
<input type="text" name="x_Nombre_Corto" id="x_Nombre_Corto" size="30" maxlength="4" value="<?php echo $ca_almacenes->Nombre_Corto->EditValue ?>"<?php echo $ca_almacenes->Nombre_Corto->EditAttributes() ?>>
</span><?php echo $ca_almacenes->Nombre_Corto->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Id_Responsable->Visible) { // Id_Responsable ?>
	<tr id="r_Id_Responsable"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Id_Responsable"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Id_Responsable->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Id_Responsable->CellAttributes() ?>><span id="el_ca_almacenes_Id_Responsable">
<select id="x_Id_Responsable" name="x_Id_Responsable"<?php echo $ca_almacenes->Id_Responsable->EditAttributes() ?>>
<?php
if (is_array($ca_almacenes->Id_Responsable->EditValue)) {
	$arwrk = $ca_almacenes->Id_Responsable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_almacenes->Id_Responsable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_almacenesadd.Lists["x_Id_Responsable"].Options = <?php echo (is_array($ca_almacenes->Id_Responsable->EditValue)) ? ew_ArrayToJson($ca_almacenes->Id_Responsable->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $ca_almacenes->Id_Responsable->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Telefonos->Visible) { // Telefonos ?>
	<tr id="r_Telefonos"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Telefonos"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Telefonos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Telefonos->CellAttributes() ?>><span id="el_ca_almacenes_Telefonos">
<textarea name="x_Telefonos" id="x_Telefonos" cols="12" rows="2"<?php echo $ca_almacenes->Telefonos->EditAttributes() ?>><?php echo $ca_almacenes->Telefonos->EditValue ?></textarea>
</span><?php echo $ca_almacenes->Telefonos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Domicilio"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Domicilio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Domicilio->CellAttributes() ?>><span id="el_ca_almacenes_Domicilio">
<textarea name="x_Domicilio" id="x_Domicilio" cols="70" rows="3"<?php echo $ca_almacenes->Domicilio->EditAttributes() ?>><?php echo $ca_almacenes->Domicilio->EditValue ?></textarea>
</span><?php echo $ca_almacenes->Domicilio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Maximo_Equipos->Visible) { // Maximo_Equipos ?>
	<tr id="r_Maximo_Equipos"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Maximo_Equipos"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Maximo_Equipos->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Maximo_Equipos->CellAttributes() ?>><span id="el_ca_almacenes_Maximo_Equipos">
<input type="text" name="x_Maximo_Equipos" id="x_Maximo_Equipos" size="4" value="<?php echo $ca_almacenes->Maximo_Equipos->EditValue ?>"<?php echo $ca_almacenes->Maximo_Equipos->EditAttributes() ?>>
</span><?php echo $ca_almacenes->Maximo_Equipos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Domicilio_Fiscal->Visible) { // Domicilio_Fiscal ?>
	<tr id="r_Domicilio_Fiscal"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Domicilio_Fiscal"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Domicilio_Fiscal->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Domicilio_Fiscal->CellAttributes() ?>><span id="el_ca_almacenes_Domicilio_Fiscal">
<textarea name="x_Domicilio_Fiscal" id="x_Domicilio_Fiscal" cols="70" rows="3"<?php echo $ca_almacenes->Domicilio_Fiscal->EditAttributes() ?>><?php echo $ca_almacenes->Domicilio_Fiscal->EditValue ?></textarea>
</span><?php echo $ca_almacenes->Domicilio_Fiscal->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Categoria->Visible) { // Categoria ?>
	<tr id="r_Categoria"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Categoria"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Categoria->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Categoria->CellAttributes() ?>><span id="el_ca_almacenes_Categoria">
<div id="tp_x_Categoria" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Categoria" id="x_Categoria" value="{value}"<?php echo $ca_almacenes->Categoria->EditAttributes() ?>></div>
<div id="dsl_x_Categoria" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_almacenes->Categoria->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_almacenes->Categoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Categoria" id="x_Categoria" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_almacenes->Categoria->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $ca_almacenes->Categoria->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
	<tr id="r_Serie_NotaVenta"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Serie_NotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Serie_NotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Serie_NotaVenta->CellAttributes() ?>><span id="el_ca_almacenes_Serie_NotaVenta">
<input type="text" name="x_Serie_NotaVenta" id="x_Serie_NotaVenta" size="2" maxlength="1" value="<?php echo $ca_almacenes->Serie_NotaVenta->EditValue ?>"<?php echo $ca_almacenes->Serie_NotaVenta->EditAttributes() ?>>
</span><?php echo $ca_almacenes->Serie_NotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_almacenes->Serie_Factura->Visible) { // Serie_Factura ?>
	<tr id="r_Serie_Factura"<?php echo $ca_almacenes->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_almacenes_Serie_Factura"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_almacenes->Serie_Factura->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_almacenes->Serie_Factura->CellAttributes() ?>><span id="el_ca_almacenes_Serie_Factura">
<input type="text" name="x_Serie_Factura" id="x_Serie_Factura" size="2" maxlength="1" value="<?php echo $ca_almacenes->Serie_Factura->EditValue ?>"<?php echo $ca_almacenes->Serie_Factura->EditAttributes() ?>>
</span><?php echo $ca_almacenes->Serie_Factura->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fca_almacenesadd.Init();
</script>
<?php
$ca_almacenes_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_almacenes_add->Page_Terminate();
?>
