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

$cap_datos_reingreso_x_cancelacion_tienda_edit = NULL; // Initialize page object first

class ccap_datos_reingreso_x_cancelacion_tienda_edit extends ccap_datos_reingreso_x_cancelacion_tienda {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_datos_reingreso_x_cancelacion_tienda';

	// Page object name
	var $PageObjName = 'cap_datos_reingreso_x_cancelacion_tienda_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["Id_Venta_Eq"] <> "")
			$this->Id_Venta_Eq->setQueryStringValue($_GET["Id_Venta_Eq"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Venta_Eq->CurrentValue == "")
			$this->Page_Terminate("cap_datos_reingreso_x_cancelacion_tiendalist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cap_datos_reingreso_x_cancelacion_tiendalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_datos_reingreso_x_cancelacion_tiendaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
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

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->CLIENTE->FldIsDetailKey) {
			$this->CLIENTE->setFormValue($objForm->GetValue("x_CLIENTE"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Acabado_eq->FldIsDetailKey) {
			$this->Acabado_eq->setFormValue($objForm->GetValue("x_Acabado_eq"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Num_ICCID->FldIsDetailKey) {
			$this->Num_ICCID->setFormValue($objForm->GetValue("x_Num_ICCID"));
		}
		if (!$this->Num_CEL->FldIsDetailKey) {
			$this->Num_CEL->setFormValue($objForm->GetValue("x_Num_CEL"));
		}
		if (!$this->Causa->FldIsDetailKey) {
			$this->Causa->setFormValue($objForm->GetValue("x_Causa"));
		}
		if (!$this->Con_SIM->FldIsDetailKey) {
			$this->Con_SIM->setFormValue($objForm->GetValue("x_Con_SIM"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
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
		if (!$this->Id_Venta_Eq->FldIsDetailKey)
			$this->Id_Venta_Eq->setFormValue($objForm->GetValue("x_Id_Venta_Eq"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Venta_Eq->CurrentValue = $this->Id_Venta_Eq->FormValue;
		$this->CLIENTE->CurrentValue = $this->CLIENTE->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Acabado_eq->CurrentValue = $this->Acabado_eq->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_ICCID->CurrentValue = $this->Num_ICCID->FormValue;
		$this->Num_CEL->CurrentValue = $this->Num_CEL->FormValue;
		$this->Causa->CurrentValue = $this->Causa->FormValue;
		$this->Con_SIM->CurrentValue = $this->Con_SIM->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->PrecioUnitario->CurrentValue = $this->PrecioUnitario->FormValue;
		$this->MontoDescuento->CurrentValue = $this->MontoDescuento->FormValue;
		$this->Precio_SIM->CurrentValue = $this->Precio_SIM->FormValue;
		$this->Monto->CurrentValue = $this->Monto->FormValue;
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
		$this->CLIENTE->setDbValue($rs->fields('CLIENTE'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Causa->setDbValue($rs->fields('Causa'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->PrecioUnitario->setDbValue($rs->fields('PrecioUnitario'));
		$this->MontoDescuento->setDbValue($rs->fields('MontoDescuento'));
		$this->Precio_SIM->setDbValue($rs->fields('Precio_SIM'));
		$this->Monto->setDbValue($rs->fields('Monto'));
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
		// Id_Venta_Eq
		// CLIENTE
		// Id_Articulo
		// Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Causa
		// Con_SIM
		// Observaciones
		// PrecioUnitario
		// MontoDescuento
		// Precio_SIM
		// Monto

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// CLIENTE
			$this->CLIENTE->ViewValue = $this->CLIENTE->CurrentValue;
			$this->CLIENTE->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->ViewValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Acabado_eq
			$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
			$this->Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Causa
			if (strval($this->Causa->CurrentValue) <> "") {
				switch ($this->Causa->CurrentValue) {
					case $this->Causa->FldTagValue(1):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(1) <> "" ? $this->Causa->FldTagCaption(1) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(2):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(2) <> "" ? $this->Causa->FldTagCaption(2) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(3):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(3) <> "" ? $this->Causa->FldTagCaption(3) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(4):
						$this->Causa->ViewValue = $this->Causa->FldTagCaption(4) <> "" ? $this->Causa->FldTagCaption(4) : $this->Causa->CurrentValue;
						break;
					default:
						$this->Causa->ViewValue = $this->Causa->CurrentValue;
				}
			} else {
				$this->Causa->ViewValue = NULL;
			}
			$this->Causa->ViewCustomAttributes = "";

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

			// CLIENTE
			$this->CLIENTE->LinkCustomAttributes = "";
			$this->CLIENTE->HrefValue = "";
			$this->CLIENTE->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Acabado_eq
			$this->Acabado_eq->LinkCustomAttributes = "";
			$this->Acabado_eq->HrefValue = "";
			$this->Acabado_eq->TooltipValue = "";

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

			// Causa
			$this->Causa->LinkCustomAttributes = "";
			$this->Causa->HrefValue = "";
			$this->Causa->TooltipValue = "";

			// Con_SIM
			$this->Con_SIM->LinkCustomAttributes = "";
			$this->Con_SIM->HrefValue = "";
			$this->Con_SIM->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// CLIENTE
			$this->CLIENTE->EditCustomAttributes = "";
			$this->CLIENTE->EditValue = $this->CLIENTE->CurrentValue;
			$this->CLIENTE->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->EditValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->EditValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Acabado_eq
			$this->Acabado_eq->EditCustomAttributes = "";
			$this->Acabado_eq->EditValue = $this->Acabado_eq->CurrentValue;
			$this->Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "onchange= 'ValidaICCID(this);' ";
			$this->Num_ICCID->EditValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "";
			$this->Num_CEL->EditValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Causa
			$this->Causa->EditCustomAttributes = "";
			if (strval($this->Causa->CurrentValue) <> "") {
				switch ($this->Causa->CurrentValue) {
					case $this->Causa->FldTagValue(1):
						$this->Causa->EditValue = $this->Causa->FldTagCaption(1) <> "" ? $this->Causa->FldTagCaption(1) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(2):
						$this->Causa->EditValue = $this->Causa->FldTagCaption(2) <> "" ? $this->Causa->FldTagCaption(2) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(3):
						$this->Causa->EditValue = $this->Causa->FldTagCaption(3) <> "" ? $this->Causa->FldTagCaption(3) : $this->Causa->CurrentValue;
						break;
					case $this->Causa->FldTagValue(4):
						$this->Causa->EditValue = $this->Causa->FldTagCaption(4) <> "" ? $this->Causa->FldTagCaption(4) : $this->Causa->CurrentValue;
						break;
					default:
						$this->Causa->EditValue = $this->Causa->CurrentValue;
				}
			} else {
				$this->Causa->EditValue = NULL;
			}
			$this->Causa->ViewCustomAttributes = "";

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Con_SIM->FldTagValue(1), $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->FldTagValue(1));
			$arwrk[] = array($this->Con_SIM->FldTagValue(2), $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->FldTagValue(2));
			$this->Con_SIM->EditValue = $arwrk;

			// Observaciones
			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// PrecioUnitario
			$this->PrecioUnitario->EditCustomAttributes = "";
			$this->PrecioUnitario->EditValue = $this->PrecioUnitario->CurrentValue;
			$this->PrecioUnitario->ViewCustomAttributes = "";

			// MontoDescuento
			$this->MontoDescuento->EditCustomAttributes = "";
			$this->MontoDescuento->EditValue = $this->MontoDescuento->CurrentValue;
			$this->MontoDescuento->ViewCustomAttributes = "";

			// Precio_SIM
			$this->Precio_SIM->EditCustomAttributes = "";
			$this->Precio_SIM->EditValue = $this->Precio_SIM->CurrentValue;
			$this->Precio_SIM->ViewCustomAttributes = "";

			// Monto
			$this->Monto->EditCustomAttributes = "";
			$this->Monto->EditValue = $this->Monto->CurrentValue;
			$this->Monto->ViewCustomAttributes = "";

			// Edit refer script
			// CLIENTE

			$this->CLIENTE->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Acabado_eq
			$this->Acabado_eq->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_ICCID
			$this->Num_ICCID->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// Causa
			$this->Causa->HrefValue = "";

			// Con_SIM
			$this->Con_SIM->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// PrecioUnitario
			$this->PrecioUnitario->HrefValue = "";

			// MontoDescuento
			$this->MontoDescuento->HrefValue = "";

			// Precio_SIM
			$this->Precio_SIM->HrefValue = "";

			// Monto
			$this->Monto->HrefValue = "";
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
		if ($this->Con_SIM->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Con_SIM->FldCaption());
		}
		if (!is_null($this->Observaciones->FormValue) && $this->Observaciones->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Observaciones->FldCaption());
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// Con_SIM
			$this->Con_SIM->SetDbValueDef($rsnew, $this->Con_SIM->CurrentValue, NULL, $this->Con_SIM->ReadOnly);

			// Observaciones
			$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, $this->Observaciones->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
if (!isset($cap_datos_reingreso_x_cancelacion_tienda_edit)) $cap_datos_reingreso_x_cancelacion_tienda_edit = new ccap_datos_reingreso_x_cancelacion_tienda_edit();

// Page init
$cap_datos_reingreso_x_cancelacion_tienda_edit->Page_Init();

// Page main
$cap_datos_reingreso_x_cancelacion_tienda_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_datos_reingreso_x_cancelacion_tienda_edit = new ew_Page("cap_datos_reingreso_x_cancelacion_tienda_edit");
cap_datos_reingreso_x_cancelacion_tienda_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_datos_reingreso_x_cancelacion_tienda_edit.PageID; // For backward compatibility

// Form object
var fcap_datos_reingreso_x_cancelacion_tiendaedit = new ew_Form("fcap_datos_reingreso_x_cancelacion_tiendaedit");

// Validate form
fcap_datos_reingreso_x_cancelacion_tiendaedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Con_SIM"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Observaciones"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_reingreso_x_cancelacion_tienda->Observaciones->FldCaption()) ?>");

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
fcap_datos_reingreso_x_cancelacion_tiendaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_datos_reingreso_x_cancelacion_tiendaedit.ValidateRequired = true;
<?php } else { ?>
fcap_datos_reingreso_x_cancelacion_tiendaedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fcap_datos_reingreso_x_cancelacion_tiendaedit.MultiPage = new ew_MultiPage("fcap_datos_reingreso_x_cancelacion_tiendaedit");
fcap_datos_reingreso_x_cancelacion_tiendaedit.MultiPage.Elements = [["x_CLIENTE",1],["x_Id_Articulo",1],["x_Acabado_eq",1],["x_Num_IMEI",1],["x_Num_ICCID",1],["x_Num_CEL",1],["x_Causa",1],["x_Con_SIM",1],["x_Observaciones",1],["x_PrecioUnitario",2],["x_MontoDescuento",2],["x_Precio_SIM",2],["x_Monto",2]];

// Dynamic selection lists
fcap_datos_reingreso_x_cancelacion_tiendaedit.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_datos_reingreso_x_cancelacion_tienda->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_datos_reingreso_x_cancelacion_tienda->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_datos_reingreso_x_cancelacion_tienda_edit->ShowPageHeader(); ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_edit->ShowMessage();
?>
<form name="fcap_datos_reingreso_x_cancelacion_tiendaedit" id="fcap_datos_reingreso_x_cancelacion_tiendaedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_datos_reingreso_x_cancelacion_tienda">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewStdTable"><tbody><tr><td>
<div id="cap_datos_reingreso_x_cancelacion_tienda_edit" class="yui-navset">
	<ul class="yui-nav">
		<li class="selected"><a href="#tab_cap_datos_reingreso_x_cancelacion_tienda1"><em><span class="phpmaker"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PageCaption(1) ?></span></em></a></li>
		<li><a href="#tab_cap_datos_reingreso_x_cancelacion_tienda2"><em><span class="phpmaker"><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PageCaption(2) ?></span></em></a></li>
	</ul>
	<div class="yui-content">
		<div id="tab_cap_datos_reingreso_x_cancelacion_tienda1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_datos_reingreso_x_cancelacion_tiendaedit1" class="ewTable">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->Visible) { // CLIENTE ?>
	<tr id="r_CLIENTE"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_CLIENTE">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->EditValue ?></span>
<input type="hidden" name="x_CLIENTE" id="x_CLIENTE" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->CLIENTE->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->Visible) { // Id_Articulo ?>
	<tr id="r_Id_Articulo"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Id_Articulo">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x_Id_Articulo" id="x_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Id_Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->Visible) { // Acabado_eq ?>
	<tr id="r_Acabado_eq"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Acabado_eq">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->EditValue ?></span>
<input type="hidden" name="x_Acabado_eq" id="x_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Acabado_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Num_IMEI">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->EditValue ?></span>
<input type="hidden" name="x_Num_IMEI" id="x_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->Visible) { // Num_ICCID ?>
	<tr id="r_Num_ICCID"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Num_ICCID">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->EditValue ?></span>
<input type="hidden" name="x_Num_ICCID" id="x_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_ICCID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->Visible) { // Num_CEL ?>
	<tr id="r_Num_CEL"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Num_CEL"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Num_CEL">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->EditValue ?></span>
<input type="hidden" name="x_Num_CEL" id="x_Num_CEL" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Num_CEL->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Causa->Visible) { // Causa ?>
	<tr id="r_Causa"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Causa"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Causa">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->EditValue ?></span>
<input type="hidden" name="x_Causa" id="x_Causa" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Causa->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Causa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->Visible) { // Con_SIM ?>
	<tr id="r_Con_SIM"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Con_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Con_SIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
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
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Observaciones"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Observaciones">
<textarea name="x_Observaciones" id="x_Observaciones" cols="50" rows="5"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->EditAttributes() ?>><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->EditValue ?></textarea>
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
		</div>
		<div id="tab_cap_datos_reingreso_x_cancelacion_tienda2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_datos_reingreso_x_cancelacion_tiendaedit2" class="ewTable">
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->Visible) { // PrecioUnitario ?>
	<tr id="r_PrecioUnitario"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_PrecioUnitario">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->EditValue ?></span>
<input type="hidden" name="x_PrecioUnitario" id="x_PrecioUnitario" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->PrecioUnitario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->Visible) { // MontoDescuento ?>
	<tr id="r_MontoDescuento"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_MontoDescuento">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->EditValue ?></span>
<input type="hidden" name="x_MontoDescuento" id="x_MontoDescuento" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->MontoDescuento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->Visible) { // Precio_SIM ?>
	<tr id="r_Precio_SIM"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Precio_SIM">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->EditValue ?></span>
<input type="hidden" name="x_Precio_SIM" id="x_Precio_SIM" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Precio_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_reingreso_x_cancelacion_tienda->Monto->Visible) { // Monto ?>
	<tr id="r_Monto"<?php echo $cap_datos_reingreso_x_cancelacion_tienda->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_reingreso_x_cancelacion_tienda_Monto"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->CellAttributes() ?>><span id="el_cap_datos_reingreso_x_cancelacion_tienda_Monto">
<span<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->ViewAttributes() ?>>
<?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->EditValue ?></span>
<input type="hidden" name="x_Monto" id="x_Monto" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Monto->CurrentValue) ?>">
</span><?php echo $cap_datos_reingreso_x_cancelacion_tienda->Monto->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
		</div>
	</div>
</div>
</td></tr></tbody></table>
<input type="hidden" name="x_Id_Venta_Eq" id="x_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_datos_reingreso_x_cancelacion_tienda->Id_Venta_Eq->CurrentValue) ?>">
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_datos_reingreso_x_cancelacion_tiendaedit.Init();
</script>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_datos_reingreso_x_cancelacion_tienda_edit->Page_Terminate();
?>
