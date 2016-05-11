<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_datos_reingreso_x_cancelacion_tiendainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_datos_reingreso_x_cancelacion_tienda_add = NULL; // Initialize page object first

class ccap_datos_reingreso_x_cancelacion_tienda_add extends ccap_datos_reingreso_x_cancelacion_tienda {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_datos_reingreso_x_cancelacion_tienda';

	// Page object name
	var $PageObjName = 'cap_datos_reingreso_x_cancelacion_tienda_add';

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

		// Table object (cap_datos_reingreso_x_cancelacion_tienda)
		if (!isset($GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"])) {
			$GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_datos_reingreso_x_cancelacion_tienda"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_datos_reingreso_x_cancelacion_tienda', TRUE);

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
			$this->Page_Terminate("cap_datos_reingreso_x_cancelacion_tiendalist.php");
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
			if (@$_GET["Id_Reingreso"] != "") {
				$this->Id_Reingreso->setQueryStringValue($_GET["Id_Reingreso"]);
				$this->setKey("Id_Reingreso", $this->Id_Reingreso->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Reingreso", ""); // Clear key
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
					$this->Page_Terminate("cap_datos_reingreso_x_cancelacion_tiendalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_datos_reingreso_x_cancelacion_tiendaview.php")
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
		$this->Id_Tienda->CurrentValue = NULL;
		$this->Id_Tienda->OldValue = $this->Id_Tienda->CurrentValue;
		$this->CLIENTE->CurrentValue = NULL;
		$this->CLIENTE->OldValue = $this->CLIENTE->CurrentValue;
		$this->PrecioUnitario->CurrentValue = 0.00;
		$this->MontoDescuento->CurrentValue = 0.00;
		$this->Precio_SIM->CurrentValue = 1.00;
		$this->Monto->CurrentValue = 0.00;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->Num_ICCID->CurrentValue = NULL;
		$this->Num_ICCID->OldValue = $this->Num_ICCID->CurrentValue;
		$this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue = NULL;
		$this->IFNULL28Num_CEL2CNum_CEL_Nota29->OldValue = $this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue;
		$this->Con_SIM->CurrentValue = "SI";
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Acabado_eq->CurrentValue = NULL;
		$this->Acabado_eq->OldValue = $this->Acabado_eq->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Tienda->FldIsDetailKey) {
			$this->Id_Tienda->setFormValue($objForm->GetValue("x_Id_Tienda"));
		}
		if (!$this->CLIENTE->FldIsDetailKey) {
			$this->CLIENTE->setFormValue($objForm->GetValue("x_CLIENTE"));
		}
		if (!$this->PrecioUnitario->FldIsDetailKey) {
			$this->PrecioUnitario->setFormValue($objForm->GetValue("x_PrecioUnitario"));
		}
		if (!$this->MontoDescuento->FldIsDetailKey) {
			$this->MontoDescuento->setFormValue($objForm->GetValue("x_MontoDescuento"));
		}
		if (!$this->Precio_SIM->FldIsDetailKey) {
			$this->Precio_SIM->setFormValue($objForm->GetValue("x_Precio_SIM"));
		}
		if (!$this->Monto->FldIsDetailKey) {
			$this->Monto->setFormValue($objForm->GetValue("x_Monto"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Num_ICCID->FldIsDetailKey) {
			$this->Num_ICCID->setFormValue($objForm->GetValue("x_Num_ICCID"));
		}
		if (!$this->IFNULL28Num_CEL2CNum_CEL_Nota29->FldIsDetailKey) {
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->setFormValue($objForm->GetValue("x_IFNULL28Num_CEL2CNum_CEL_Nota29"));
		}
		if (!$this->Con_SIM->FldIsDetailKey) {
			$this->Con_SIM->setFormValue($objForm->GetValue("x_Con_SIM"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Acabado_eq->FldIsDetailKey) {
			$this->Acabado_eq->setFormValue($objForm->GetValue("x_Acabado_eq"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Tienda->CurrentValue = $this->Id_Tienda->FormValue;
		$this->CLIENTE->CurrentValue = $this->CLIENTE->FormValue;
		$this->PrecioUnitario->CurrentValue = $this->PrecioUnitario->FormValue;
		$this->MontoDescuento->CurrentValue = $this->MontoDescuento->FormValue;
		$this->Precio_SIM->CurrentValue = $this->Precio_SIM->FormValue;
		$this->Monto->CurrentValue = $this->Monto->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_ICCID->CurrentValue = $this->Num_ICCID->FormValue;
		$this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue = $this->IFNULL28Num_CEL2CNum_CEL_Nota29->FormValue;
		$this->Con_SIM->CurrentValue = $this->Con_SIM->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Acabado_eq->CurrentValue = $this->Acabado_eq->FormValue;
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
		$this->Id_Reingreso->setDbValue($rs->fields('Id_Reingreso'));
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->CLIENTE->setDbValue($rs->fields('CLIENTE'));
		$this->PrecioUnitario->setDbValue($rs->fields('PrecioUnitario'));
		$this->MontoDescuento->setDbValue($rs->fields('MontoDescuento'));
		$this->Precio_SIM->setDbValue($rs->fields('Precio_SIM'));
		$this->Monto->setDbValue($rs->fields('Monto'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->IFNULL28Num_CEL2CNum_CEL_Nota29->setDbValue($rs->fields('IFNULL(Num_CEL,Num_CEL_Nota)'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Reingreso")) <> "")
			$this->Id_Reingreso->CurrentValue = $this->getKey("Id_Reingreso"); // Id_Reingreso
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
		// Convert decimal values if posted back

		if ($this->PrecioUnitario->FormValue == $this->PrecioUnitario->CurrentValue && is_numeric(ew_StrToFloat($this->PrecioUnitario->CurrentValue)))
			$this->PrecioUnitario->CurrentValue = ew_StrToFloat($this->PrecioUnitario->CurrentValue);

		// Convert decimal values if posted back
		if ($this->MontoDescuento->FormValue == $this->MontoDescuento->CurrentValue && is_numeric(ew_StrToFloat($this->MontoDescuento->CurrentValue)))
			$this->MontoDescuento->CurrentValue = ew_StrToFloat($this->MontoDescuento->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_SIM->FormValue == $this->Precio_SIM->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_SIM->CurrentValue)))
			$this->Precio_SIM->CurrentValue = ew_StrToFloat($this->Precio_SIM->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Monto->FormValue == $this->Monto->CurrentValue && is_numeric(ew_StrToFloat($this->Monto->CurrentValue)))
			$this->Monto->CurrentValue = ew_StrToFloat($this->Monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Reingreso
		// Id_Tienda
		// CLIENTE
		// PrecioUnitario
		// MontoDescuento
		// Precio_SIM
		// Monto
		// Num_IMEI
		// Num_ICCID
		// IFNULL(Num_CEL,Num_CEL_Nota)
		// Con_SIM
		// Observaciones
		// Articulo
		// Acabado_eq

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Reingreso
			$this->Id_Reingreso->ViewValue = $this->Id_Reingreso->CurrentValue;
			$this->Id_Reingreso->ViewCustomAttributes = "";

			// Id_Tienda
			$this->Id_Tienda->ViewValue = $this->Id_Tienda->CurrentValue;
			$this->Id_Tienda->ViewCustomAttributes = "";

			// CLIENTE
			$this->CLIENTE->ViewValue = $this->CLIENTE->CurrentValue;
			$this->CLIENTE->ViewCustomAttributes = "";

			// PrecioUnitario
			$this->PrecioUnitario->ViewValue = $this->PrecioUnitario->CurrentValue;
			$this->PrecioUnitario->ViewCustomAttributes = "";

			// MontoDescuento
			$this->MontoDescuento->ViewValue = $this->MontoDescuento->CurrentValue;
			$this->MontoDescuento->ViewCustomAttributes = "";

			// Precio_SIM
			$this->Precio_SIM->ViewValue = $this->Precio_SIM->CurrentValue;
			$this->Precio_SIM->ViewCustomAttributes = "";

			// Monto
			$this->Monto->ViewValue = $this->Monto->CurrentValue;
			$this->Monto->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// IFNULL(Num_CEL,Num_CEL_Nota)
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->ViewValue = $this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue;
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->ViewCustomAttributes = "";

			// Con_SIM
			if (strval($this->Con_SIM->CurrentValue) <> "") {
				switch ($this->Con_SIM->CurrentValue) {
					case $this->Con_SIM->FldTagValue(1):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
						break;
					case $this->Con_SIM->FldTagValue(2):
						$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
						break;
					default:
						$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
				}
			} else {
				$this->Con_SIM->ViewValue = NULL;
			}
			$this->Con_SIM->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Acabado_eq
			$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
			$this->Acabado_eq->ViewCustomAttributes = "";

			// Id_Tienda
			$this->Id_Tienda->LinkCustomAttributes = "";
			$this->Id_Tienda->HrefValue = "";
			$this->Id_Tienda->TooltipValue = "";

			// CLIENTE
			$this->CLIENTE->LinkCustomAttributes = "";
			$this->CLIENTE->HrefValue = "";
			$this->CLIENTE->TooltipValue = "";

			// PrecioUnitario
			$this->PrecioUnitario->LinkCustomAttributes = "";
			$this->PrecioUnitario->HrefValue = "";
			$this->PrecioUnitario->TooltipValue = "";

			// MontoDescuento
			$this->MontoDescuento->LinkCustomAttributes = "";
			$this->MontoDescuento->HrefValue = "";
			$this->MontoDescuento->TooltipValue = "";

			// Precio_SIM
			$this->Precio_SIM->LinkCustomAttributes = "";
			$this->Precio_SIM->HrefValue = "";
			$this->Precio_SIM->TooltipValue = "";

			// Monto
			$this->Monto->LinkCustomAttributes = "";
			$this->Monto->HrefValue = "";
			$this->Monto->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Num_ICCID
			$this->Num_ICCID->LinkCustomAttributes = "";
			$this->Num_ICCID->HrefValue = "";
			$this->Num_ICCID->TooltipValue = "";

			// IFNULL(Num_CEL,Num_CEL_Nota)
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->LinkCustomAttributes = "";
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->HrefValue = "";
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->TooltipValue = "";

			// Con_SIM
			$this->Con_SIM->LinkCustomAttributes = "";
			$this->Con_SIM->HrefValue = "";
			$this->Con_SIM->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Acabado_eq
			$this->Acabado_eq->LinkCustomAttributes = "";
			$this->Acabado_eq->HrefValue = "";
			$this->Acabado_eq->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Tienda
			$this->Id_Tienda->EditCustomAttributes = "";
			$this->Id_Tienda->EditValue = ew_HtmlEncode($this->Id_Tienda->CurrentValue);

			// CLIENTE
			$this->CLIENTE->EditCustomAttributes = "";
			$this->CLIENTE->EditValue = ew_HtmlEncode($this->CLIENTE->CurrentValue);

			// PrecioUnitario
			$this->PrecioUnitario->EditCustomAttributes = "";
			$this->PrecioUnitario->EditValue = ew_HtmlEncode($this->PrecioUnitario->CurrentValue);
			if (strval($this->PrecioUnitario->EditValue) <> "" && is_numeric($this->PrecioUnitario->EditValue)) $this->PrecioUnitario->EditValue = ew_FormatNumber($this->PrecioUnitario->EditValue, -2, -1, -2, 0);

			// MontoDescuento
			$this->MontoDescuento->EditCustomAttributes = "";
			$this->MontoDescuento->EditValue = ew_HtmlEncode($this->MontoDescuento->CurrentValue);
			if (strval($this->MontoDescuento->EditValue) <> "" && is_numeric($this->MontoDescuento->EditValue)) $this->MontoDescuento->EditValue = ew_FormatNumber($this->MontoDescuento->EditValue, -2, -1, -2, 0);

			// Precio_SIM
			$this->Precio_SIM->EditCustomAttributes = "";
			$this->Precio_SIM->EditValue = ew_HtmlEncode($this->Precio_SIM->CurrentValue);
			if (strval($this->Precio_SIM->EditValue) <> "" && is_numeric($this->Precio_SIM->EditValue)) $this->Precio_SIM->EditValue = ew_FormatNumber($this->Precio_SIM->EditValue, -2, -1, -2, 0);

			// Monto
			$this->Monto->EditCustomAttributes = "";
			$this->Monto->EditValue = ew_HtmlEncode($this->Monto->CurrentValue);
			if (strval($this->Monto->EditValue) <> "" && is_numeric($this->Monto->EditValue)) $this->Monto->EditValue = ew_FormatNumber($this->Monto->EditValue, -2, -1, -2, 0);

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->CurrentValue);

			// IFNULL(Num_CEL,Num_CEL_Nota)
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->EditCustomAttributes = "";
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->EditValue = ew_HtmlEncode($this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue);

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Con_SIM->FldTagValue(1), $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->FldTagValue(1));
			$arwrk[] = array($this->Con_SIM->FldTagValue(2), $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->FldTagValue(2));
			$this->Con_SIM->EditValue = $arwrk;

			// Observaciones
			$this->Observaciones->EditCustomAttributes = "";
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// Acabado_eq
			$this->Acabado_eq->EditCustomAttributes = "";
			$this->Acabado_eq->EditValue = ew_HtmlEncode($this->Acabado_eq->CurrentValue);

			// Edit refer script
			// Id_Tienda

			$this->Id_Tienda->HrefValue = "";

			// CLIENTE
			$this->CLIENTE->HrefValue = "";

			// PrecioUnitario
			$this->PrecioUnitario->HrefValue = "";

			// MontoDescuento
			$this->MontoDescuento->HrefValue = "";

			// Precio_SIM
			$this->Precio_SIM->HrefValue = "";

			// Monto
			$this->Monto->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_ICCID
			$this->Num_ICCID->HrefValue = "";

			// IFNULL(Num_CEL,Num_CEL_Nota)
			$this->IFNULL28Num_CEL2CNum_CEL_Nota29->HrefValue = "";

			// Con_SIM
			$this->Con_SIM->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Acabado_eq
			$this->Acabado_eq->HrefValue = "";
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
		if (!is_null($this->Id_Tienda->FormValue) && $this->Id_Tienda->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Tienda->FldCaption());
		}
		if (!ew_CheckInteger($this->Id_Tienda->FormValue)) {
			ew_AddMessage($gsFormError, $this->Id_Tienda->FldErrMsg());
		}
		if (!is_null($this->PrecioUnitario->FormValue) && $this->PrecioUnitario->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->PrecioUnitario->FldCaption());
		}
		if (!ew_CheckNumber($this->PrecioUnitario->FormValue)) {
			ew_AddMessage($gsFormError, $this->PrecioUnitario->FldErrMsg());
		}
		if (!ew_CheckNumber($this->MontoDescuento->FormValue)) {
			ew_AddMessage($gsFormError, $this->MontoDescuento->FldErrMsg());
		}
		if (!is_null($this->Precio_SIM->FormValue) && $this->Precio_SIM->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_SIM->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_SIM->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_SIM->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->Monto->FldErrMsg());
		}
		if (!is_null($this->Num_IMEI->FormValue) && $this->Num_IMEI->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_IMEI->FldCaption());
		}
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
		}
		if (!is_null($this->Acabado_eq->FormValue) && $this->Acabado_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Acabado_eq->FldCaption());
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
		if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Articulo = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Id_Tienda
		$this->Id_Tienda->SetDbValueDef($rsnew, $this->Id_Tienda->CurrentValue, 0, FALSE);

		// CLIENTE
		$this->CLIENTE->SetDbValueDef($rsnew, $this->CLIENTE->CurrentValue, NULL, FALSE);

		// PrecioUnitario
		$this->PrecioUnitario->SetDbValueDef($rsnew, $this->PrecioUnitario->CurrentValue, 0, strval($this->PrecioUnitario->CurrentValue) == "");

		// MontoDescuento
		$this->MontoDescuento->SetDbValueDef($rsnew, $this->MontoDescuento->CurrentValue, NULL, strval($this->MontoDescuento->CurrentValue) == "");

		// Precio_SIM
		$this->Precio_SIM->SetDbValueDef($rsnew, $this->Precio_SIM->CurrentValue, 0, strval($this->Precio_SIM->CurrentValue) == "");

		// Monto
		$this->Monto->SetDbValueDef($rsnew, $this->Monto->CurrentValue, NULL, strval($this->Monto->CurrentValue) == "");

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, "", FALSE);

		// Num_ICCID
		$this->Num_ICCID->SetDbValueDef($rsnew, $this->Num_ICCID->CurrentValue, NULL, FALSE);

		// IFNULL(Num_CEL,Num_CEL_Nota)
		$this->IFNULL28Num_CEL2CNum_CEL_Nota29->SetDbValueDef($rsnew, $this->IFNULL28Num_CEL2CNum_CEL_Nota29->CurrentValue, NULL, FALSE);

		// Con_SIM
		$this->Con_SIM->SetDbValueDef($rsnew, $this->Con_SIM->CurrentValue, NULL, strval($this->Con_SIM->CurrentValue) == "");

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Acabado_eq
		$this->Acabado_eq->SetDbValueDef($rsnew, $this->Acabado_eq->CurrentValue, "", FALSE);

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
			$this->Id_Reingreso->setDbValue($conn->Insert_ID());
			$rsnew['Id_Reingreso'] = $this->Id_Reingreso->DbValue;
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
if (!isset($cap_datos_reingreso_x_cancelacion_tienda_add)) $cap_datos_reingreso_x_cancelacion_tienda_add = new ccap_datos_reingreso_x_cancelacion_tienda_add();

// Page init
$cap_datos_reingreso_x_cancelacion_tienda_add->Page_Init();

// Page main
$cap_datos_reingreso_x_cancelacion_tienda_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_datos_reingreso_x_cancelacion_tienda_add = new ew_Page("cap_datos_reingreso_x_cancelacion_tienda_add");
cap_datos_reingreso_x_cancelacion_tienda_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_datos_reingreso_x_cancelacion_tienda_add.PageID; // For backward compatibility

// Form object
var fcap_datos_reingreso_x_cancelacion_tiendaadd = new ew_Form("fcap_datos_reingreso_x_cancelacion_tiendaadd");

// Validate form
fcap_datos_reingreso_x_cancelacion_tiendaadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Tienda"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Tienda"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_PrecioUnitario"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_PrecioUnitario"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_MontoDescuento"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_SIM"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_SIM"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Monto"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Monto->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Num_IMEI"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Acabado_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->FldCaption()) ?>");

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
fcap_datos_reingreso_x_cancelacion_tiendaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_datos_reingreso_x_cancelacion_tiendaadd.ValidateRequired = true;
<?php } else { ?>
fcap_datos_reingreso_x_cancelacion_tiendaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_datos_reingreso_x_cancelacion_tienda->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_datos_reingreso_x_cancelacion_tienda_add->ShowPageHeader(); ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_add->ShowMessage();
?>
<form name="fcap_datos_reingreso_x_cancelacion_tiendaadd" id="fcap_datos_reingreso_x_cancelacion_tiendaadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_datos_reingreso_x_cancelacion_tienda">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_datos_reingreso_x_cancelacion_tiendaadd" class="ewTable">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->Visible) { // Id_Tienda ?>
	<tr id="r_Id_Tienda"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Tienda"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Id_Tienda">
<input type="text" name="x_Id_Tienda" id="x_Id_Tienda" size="30" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Tienda->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->Visible) { // CLIENTE ?>
	<tr id="r_CLIENTE"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE">
<input type="text" name="x_CLIENTE" id="x_CLIENTE" size="30" maxlength="50" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->Visible) { // PrecioUnitario ?>
	<tr id="r_PrecioUnitario"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario">
<input type="text" name="x_PrecioUnitario" id="x_PrecioUnitario" size="30" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->Visible) { // MontoDescuento ?>
	<tr id="r_MontoDescuento"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento">
<input type="text" name="x_MontoDescuento" id="x_MontoDescuento" size="30" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->Visible) { // Precio_SIM ?>
	<tr id="r_Precio_SIM"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM">
<input type="text" name="x_Precio_SIM" id="x_Precio_SIM" size="30" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Monto->Visible) { // Monto ?>
	<tr id="r_Monto"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Monto"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Monto">
<input type="text" name="x_Monto" id="x_Monto" size="30" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI">
<input type="text" name="x_Num_IMEI" id="x_Num_IMEI" size="30" maxlength="16" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
	<tr id="r_Num_ICCID"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID">
<input type="text" name="x_Num_ICCID" id="x_Num_ICCID" size="30" maxlength="20" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->Visible) { // IFNULL(Num_CEL,Num_CEL_Nota) ?>
	<tr id="r_IFNULL28Num_CEL2CNum_CEL_Nota29"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_IFNULL28Num_CEL2CNum_CEL_Nota29"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_IFNULL28Num_CEL2CNum_CEL_Nota29">
<input type="text" name="x_IFNULL28Num_CEL2CNum_CEL_Nota29" id="x_IFNULL28Num_CEL2CNum_CEL_Nota29" size="30" maxlength="12" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->IFNULL28Num_CEL2CNum_CEL_Nota29->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->Visible) { // Con_SIM ?>
	<tr id="r_Con_SIM"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM">
<div id="tp_x_Con_SIM" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Con_SIM" id="x_Con_SIM" value="{value}"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->EditAttributes() ?>></div>
<div id="dsl_x_Con_SIM" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Con_SIM" id="x_Con_SIM" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Observaciones"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Observaciones">
<input type="text" name="x_Observaciones" id="x_Observaciones" size="30" maxlength="255" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Articulo->Visible) { // Articulo ?>
	<tr id="r_Articulo"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Articulo->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Articulo">
<input type="text" name="x_Articulo" id="x_Articulo" size="30" maxlength="100" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Articulo->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Articulo->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->Visible) { // Acabado_eq ?>
	<tr id="r_Acabado_eq"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq">
<input type="text" name="x_Acabado_eq" id="x_Acabado_eq" size="30" maxlength="20" value="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->EditValue ?>"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->EditAttributes() ?>>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_datos_reingreso_x_cancelacion_tiendaadd.Init();
</script>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_add->Page_Terminate();
?>
