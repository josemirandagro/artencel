<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_datos_garantia_eqinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_datos_garantia_eq_edit = NULL; // Initialize page object first

class ccap_datos_garantia_eq_edit extends ccap_datos_garantia_eq {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_datos_garantia_eq';

	// Page object name
	var $PageObjName = 'cap_datos_garantia_eq_edit';

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

		// Table object (cap_datos_garantia_eq)
		if (!isset($GLOBALS["cap_datos_garantia_eq"])) {
			$GLOBALS["cap_datos_garantia_eq"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_datos_garantia_eq"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_datos_garantia_eq', TRUE);

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
			$this->Page_Terminate("cap_datos_garantia_eqlist.php");
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
			$this->Page_Terminate("cap_datos_garantia_eqlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cap_datos_garantia_eqlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_datos_garantia_eqview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render as View
		} else {
			$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		}
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
		if (!$this->Fecha_Venta->FldIsDetailKey) {
			$this->Fecha_Venta->setFormValue($objForm->GetValue("x_Fecha_Venta"));
			$this->Fecha_Venta->CurrentValue = ew_UnFormatDateTime($this->Fecha_Venta->CurrentValue, 7);
		}
		if (!$this->Nombre_Completo->FldIsDetailKey) {
			$this->Nombre_Completo->setFormValue($objForm->GetValue("x_Nombre_Completo"));
		}
		if (!$this->Fecha_Entrada->FldIsDetailKey) {
			$this->Fecha_Entrada->setFormValue($objForm->GetValue("x_Fecha_Entrada"));
			$this->Fecha_Entrada->CurrentValue = ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7);
		}
		if (!$this->Id_Marca_eq->FldIsDetailKey) {
			$this->Id_Marca_eq->setFormValue($objForm->GetValue("x_Id_Marca_eq"));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue($objForm->GetValue("x_COD_Modelo_eq"));
		}
		if (!$this->Id_Acabado_eq->FldIsDetailKey) {
			$this->Id_Acabado_eq->setFormValue($objForm->GetValue("x_Id_Acabado_eq"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Id_Proveedor->FldIsDetailKey) {
			$this->Id_Proveedor->setFormValue($objForm->GetValue("x_Id_Proveedor"));
		}
		if (!$this->Accesorios_Recibidos->FldIsDetailKey) {
			$this->Accesorios_Recibidos->setFormValue($objForm->GetValue("x_Accesorios_Recibidos"));
		}
		if (!$this->Falla->FldIsDetailKey) {
			$this->Falla->setFormValue($objForm->GetValue("x_Falla"));
		}
		if (!$this->Condiciones_Equipo->FldIsDetailKey) {
			$this->Condiciones_Equipo->setFormValue($objForm->GetValue("x_Condiciones_Equipo"));
		}
		if (!$this->Id_Empleado_recibe->FldIsDetailKey) {
			$this->Id_Empleado_recibe->setFormValue($objForm->GetValue("x_Id_Empleado_recibe"));
		}
		if (!$this->Id_Venta_Eq->FldIsDetailKey)
			$this->Id_Venta_Eq->setFormValue($objForm->GetValue("x_Id_Venta_Eq"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Venta_Eq->CurrentValue = $this->Id_Venta_Eq->FormValue;
		$this->Fecha_Venta->CurrentValue = $this->Fecha_Venta->FormValue;
		$this->Fecha_Venta->CurrentValue = ew_UnFormatDateTime($this->Fecha_Venta->CurrentValue, 7);
		$this->Nombre_Completo->CurrentValue = $this->Nombre_Completo->FormValue;
		$this->Fecha_Entrada->CurrentValue = $this->Fecha_Entrada->FormValue;
		$this->Fecha_Entrada->CurrentValue = ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7);
		$this->Id_Marca_eq->CurrentValue = $this->Id_Marca_eq->FormValue;
		$this->COD_Modelo_eq->CurrentValue = $this->COD_Modelo_eq->FormValue;
		$this->Id_Acabado_eq->CurrentValue = $this->Id_Acabado_eq->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Id_Proveedor->CurrentValue = $this->Id_Proveedor->FormValue;
		$this->Accesorios_Recibidos->CurrentValue = $this->Accesorios_Recibidos->FormValue;
		$this->Falla->CurrentValue = $this->Falla->FormValue;
		$this->Condiciones_Equipo->CurrentValue = $this->Condiciones_Equipo->FormValue;
		$this->Id_Empleado_recibe->CurrentValue = $this->Id_Empleado_recibe->FormValue;
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
		$this->Fecha_Venta->setDbValue($rs->fields('Fecha_Venta'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha_Entrada'));
		$this->Id_Marca_eq->setDbValue($rs->fields('Id_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->Accesorios_Recibidos->setDbValue($rs->fields('Accesorios_Recibidos'));
		$this->Falla->setDbValue($rs->fields('Falla'));
		$this->Condiciones_Equipo->setDbValue($rs->fields('Condiciones_Equipo'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Empleado_recibe->setDbValue($rs->fields('Id_Empleado_recibe'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Venta_Eq
		// Fecha_Venta
		// Nombre_Completo
		// Fecha_Entrada
		// Id_Marca_eq
		// COD_Modelo_eq
		// Id_Acabado_eq
		// Num_IMEI
		// Id_Proveedor
		// Accesorios_Recibidos
		// Falla
		// Condiciones_Equipo
		// Id_Tel_SIM
		// Id_Empleado_recibe

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// Fecha_Venta
			$this->Fecha_Venta->ViewValue = $this->Fecha_Venta->CurrentValue;
			$this->Fecha_Venta->ViewValue = ew_FormatDateTime($this->Fecha_Venta->ViewValue, 7);
			$this->Fecha_Venta->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
			$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 7);
			$this->Fecha_Entrada->ViewCustomAttributes = "";

			// Id_Marca_eq
			$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
			if (strval($this->Id_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Marca_eq`" . ew_SearchString("=", $this->Id_Marca_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
				}
			} else {
				$this->Id_Marca_eq->ViewValue = NULL;
			}
			$this->Id_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Acabado_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
				}
			} else {
				$this->Id_Acabado_eq->ViewValue = NULL;
			}
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Proveedor
			$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->ViewValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// Accesorios_Recibidos
			if (strval($this->Accesorios_Recibidos->CurrentValue) <> "") {
				$this->Accesorios_Recibidos->ViewValue = "";
				$arwrk = explode(",", strval($this->Accesorios_Recibidos->CurrentValue));
				$cnt = count($arwrk);
				for ($ari = 0; $ari < $cnt; $ari++) {
					switch (trim($arwrk[$ari])) {
						case $this->Accesorios_Recibidos->FldTagValue(1):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(1) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(1) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(2):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(2) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(2) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(3):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(3) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(3) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(4):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(4) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(4) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(5):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(5) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(5) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(6):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(6) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(6) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(7):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(7) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(7) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(8):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(8) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(8) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(9):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(9) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(9) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(10):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(10) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(10) : trim($arwrk[$ari]);
							break;
						case $this->Accesorios_Recibidos->FldTagValue(11):
							$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(11) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(11) : trim($arwrk[$ari]);
							break;
						default:
							$this->Accesorios_Recibidos->ViewValue .= trim($arwrk[$ari]);
					}
					if ($ari < $cnt-1) $this->Accesorios_Recibidos->ViewValue .= ew_ViewOptionSeparator($ari);
				}
			} else {
				$this->Accesorios_Recibidos->ViewValue = NULL;
			}
			$this->Accesorios_Recibidos->ViewCustomAttributes = "";

			// Falla
			$this->Falla->ViewValue = $this->Falla->CurrentValue;
			$this->Falla->ViewCustomAttributes = "";

			// Condiciones_Equipo
			$this->Condiciones_Equipo->ViewValue = $this->Condiciones_Equipo->CurrentValue;
			$this->Condiciones_Equipo->ViewCustomAttributes = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(2,$this->Id_Tel_SIM) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->ViewValue = $this->Id_Empleado_recibe->CurrentValue;
			$this->Id_Empleado_recibe->ViewCustomAttributes = "";

			// Fecha_Venta
			$this->Fecha_Venta->LinkCustomAttributes = "";
			$this->Fecha_Venta->HrefValue = "";
			$this->Fecha_Venta->TooltipValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->LinkCustomAttributes = "";
			$this->Nombre_Completo->HrefValue = "";
			$this->Nombre_Completo->TooltipValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Id_Marca_eq
			$this->Id_Marca_eq->LinkCustomAttributes = "";
			$this->Id_Marca_eq->HrefValue = "";
			$this->Id_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";

			// Accesorios_Recibidos
			$this->Accesorios_Recibidos->LinkCustomAttributes = "";
			$this->Accesorios_Recibidos->HrefValue = "";
			$this->Accesorios_Recibidos->TooltipValue = "";

			// Falla
			$this->Falla->LinkCustomAttributes = "";
			$this->Falla->HrefValue = "";
			$this->Falla->TooltipValue = "";

			// Condiciones_Equipo
			$this->Condiciones_Equipo->LinkCustomAttributes = "";
			$this->Condiciones_Equipo->HrefValue = "";
			$this->Condiciones_Equipo->TooltipValue = "";

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->LinkCustomAttributes = "";
			$this->Id_Empleado_recibe->HrefValue = "";
			$this->Id_Empleado_recibe->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Fecha_Venta
			$this->Fecha_Venta->EditCustomAttributes = "";
			$this->Fecha_Venta->EditValue = $this->Fecha_Venta->CurrentValue;
			$this->Fecha_Venta->EditValue = ew_FormatDateTime($this->Fecha_Venta->EditValue, 7);
			$this->Fecha_Venta->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->EditCustomAttributes = "";
			$this->Nombre_Completo->EditValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->EditCustomAttributes = "";
			$this->Fecha_Entrada->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 7));

			// Id_Marca_eq
			$this->Id_Marca_eq->EditCustomAttributes = "";
			$this->Id_Marca_eq->EditValue = $this->Id_Marca_eq->CurrentValue;
			if (strval($this->Id_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Marca_eq`" . ew_SearchString("=", $this->Id_Marca_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Marca_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Marca_eq->EditValue = $this->Id_Marca_eq->CurrentValue;
				}
			} else {
				$this->Id_Marca_eq->EditValue = NULL;
			}
			$this->Id_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->EditCustomAttributes = "";
			$this->Id_Acabado_eq->EditValue = $this->Id_Acabado_eq->CurrentValue;
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Acabado_eq->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Acabado_eq->EditValue = $this->Id_Acabado_eq->CurrentValue;
				}
			} else {
				$this->Id_Acabado_eq->EditValue = NULL;
			}
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
			$this->Id_Proveedor->EditValue = $this->Id_Proveedor->CurrentValue;
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->EditValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->EditValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->EditValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// Accesorios_Recibidos
			$this->Accesorios_Recibidos->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(1), $this->Accesorios_Recibidos->FldTagCaption(1) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(1) : $this->Accesorios_Recibidos->FldTagValue(1));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(2), $this->Accesorios_Recibidos->FldTagCaption(2) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(2) : $this->Accesorios_Recibidos->FldTagValue(2));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(3), $this->Accesorios_Recibidos->FldTagCaption(3) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(3) : $this->Accesorios_Recibidos->FldTagValue(3));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(4), $this->Accesorios_Recibidos->FldTagCaption(4) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(4) : $this->Accesorios_Recibidos->FldTagValue(4));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(5), $this->Accesorios_Recibidos->FldTagCaption(5) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(5) : $this->Accesorios_Recibidos->FldTagValue(5));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(6), $this->Accesorios_Recibidos->FldTagCaption(6) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(6) : $this->Accesorios_Recibidos->FldTagValue(6));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(7), $this->Accesorios_Recibidos->FldTagCaption(7) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(7) : $this->Accesorios_Recibidos->FldTagValue(7));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(8), $this->Accesorios_Recibidos->FldTagCaption(8) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(8) : $this->Accesorios_Recibidos->FldTagValue(8));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(9), $this->Accesorios_Recibidos->FldTagCaption(9) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(9) : $this->Accesorios_Recibidos->FldTagValue(9));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(10), $this->Accesorios_Recibidos->FldTagCaption(10) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(10) : $this->Accesorios_Recibidos->FldTagValue(10));
			$arwrk[] = array($this->Accesorios_Recibidos->FldTagValue(11), $this->Accesorios_Recibidos->FldTagCaption(11) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(11) : $this->Accesorios_Recibidos->FldTagValue(11));
			$this->Accesorios_Recibidos->EditValue = $arwrk;

			// Falla
			$this->Falla->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Falla->EditValue = ew_HtmlEncode($this->Falla->CurrentValue);

			// Condiciones_Equipo
			$this->Condiciones_Equipo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Condiciones_Equipo->EditValue = ew_HtmlEncode($this->Condiciones_Equipo->CurrentValue);

			// Id_Empleado_recibe
			// Edit refer script
			// Fecha_Venta

			$this->Fecha_Venta->HrefValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->HrefValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->HrefValue = "";

			// Id_Marca_eq
			$this->Id_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->HrefValue = "";

			// Accesorios_Recibidos
			$this->Accesorios_Recibidos->HrefValue = "";

			// Falla
			$this->Falla->HrefValue = "";

			// Condiciones_Equipo
			$this->Condiciones_Equipo->HrefValue = "";

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->HrefValue = "";
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
		if (!is_null($this->Fecha_Entrada->FormValue) && $this->Fecha_Entrada->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Fecha_Entrada->FldCaption());
		}
		if (!ew_CheckEuroDate($this->Fecha_Entrada->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Entrada->FldErrMsg());
		}
		if ($this->Accesorios_Recibidos->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Accesorios_Recibidos->FldCaption());
		}
		if (!is_null($this->Falla->FormValue) && $this->Falla->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Falla->FldCaption());
		}
		if (!is_null($this->Condiciones_Equipo->FormValue) && $this->Condiciones_Equipo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Condiciones_Equipo->FldCaption());
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

			// Fecha_Entrada
			$this->Fecha_Entrada->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7), ew_CurrentDate(), $this->Fecha_Entrada->ReadOnly);

			// Accesorios_Recibidos
			$this->Accesorios_Recibidos->SetDbValueDef($rsnew, $this->Accesorios_Recibidos->CurrentValue, "", $this->Accesorios_Recibidos->ReadOnly);

			// Falla
			$this->Falla->SetDbValueDef($rsnew, $this->Falla->CurrentValue, "", $this->Falla->ReadOnly);

			// Condiciones_Equipo
			$this->Condiciones_Equipo->SetDbValueDef($rsnew, $this->Condiciones_Equipo->CurrentValue, "", $this->Condiciones_Equipo->ReadOnly);

			// Id_Empleado_recibe
			$this->Id_Empleado_recibe->SetDbValueDef($rsnew, CurrentUserID(), NULL);
			$rsnew['Id_Empleado_recibe'] = &$this->Id_Empleado_recibe->DbValue;

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
if (!isset($cap_datos_garantia_eq_edit)) $cap_datos_garantia_eq_edit = new ccap_datos_garantia_eq_edit();

// Page init
$cap_datos_garantia_eq_edit->Page_Init();

// Page main
$cap_datos_garantia_eq_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_datos_garantia_eq_edit = new ew_Page("cap_datos_garantia_eq_edit");
cap_datos_garantia_eq_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_datos_garantia_eq_edit.PageID; // For backward compatibility

// Form object
var fcap_datos_garantia_eqedit = new ew_Form("fcap_datos_garantia_eqedit");

// Validate form
fcap_datos_garantia_eqedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Fecha_Entrada"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_garantia_eq->Fecha_Entrada->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Fecha_Entrada"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_datos_garantia_eq->Fecha_Entrada->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Accesorios_Recibidos[]"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_garantia_eq->Accesorios_Recibidos->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Falla"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_garantia_eq->Falla->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Condiciones_Equipo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_datos_garantia_eq->Condiciones_Equipo->FldCaption()) ?>");

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
fcap_datos_garantia_eqedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_datos_garantia_eqedit.ValidateRequired = true;
<?php } else { ?>
fcap_datos_garantia_eqedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_datos_garantia_eqedit.Lists["x_Id_Marca_eq"] = {"LinkField":"x_Id_Marca_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_datos_garantia_eqedit.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_datos_garantia_eqedit.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_datos_garantia_eq->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_datos_garantia_eq->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_datos_garantia_eq_edit->ShowPageHeader(); ?>
<?php
$cap_datos_garantia_eq_edit->ShowMessage();
?>
<form name="fcap_datos_garantia_eqedit" id="fcap_datos_garantia_eqedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_datos_garantia_eq">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($cap_datos_garantia_eq->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_datos_garantia_eqedit" class="ewTable">
<?php if ($cap_datos_garantia_eq->Fecha_Venta->Visible) { // Fecha_Venta ?>
	<tr id="r_Fecha_Venta"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Fecha_Venta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Fecha_Venta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Fecha_Venta->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Fecha_Venta">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Fecha_Venta->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Fecha_Venta->EditValue ?></span>
<input type="hidden" name="x_Fecha_Venta" id="x_Fecha_Venta" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Fecha_Venta->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Fecha_Venta->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Fecha_Venta->ViewValue ?></span>
<input type="hidden" name="x_Fecha_Venta" id="x_Fecha_Venta" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Fecha_Venta->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Fecha_Venta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Nombre_Completo->Visible) { // Nombre_Completo ?>
	<tr id="r_Nombre_Completo"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Nombre_Completo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Nombre_Completo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Nombre_Completo->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Nombre_Completo">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Nombre_Completo->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Nombre_Completo->EditValue ?></span>
<input type="hidden" name="x_Nombre_Completo" id="x_Nombre_Completo" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Nombre_Completo->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Nombre_Completo->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Nombre_Completo->ViewValue ?></span>
<input type="hidden" name="x_Nombre_Completo" id="x_Nombre_Completo" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Nombre_Completo->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Nombre_Completo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
	<tr id="r_Fecha_Entrada"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Fecha_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Fecha_Entrada->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Fecha_Entrada->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Fecha_Entrada">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<input type="text" name="x_Fecha_Entrada" id="x_Fecha_Entrada" value="<?php echo $cap_datos_garantia_eq->Fecha_Entrada->EditValue ?>"<?php echo $cap_datos_garantia_eq->Fecha_Entrada->EditAttributes() ?>>
<?php if (!$cap_datos_garantia_eq->Fecha_Entrada->ReadOnly && !$cap_datos_garantia_eq->Fecha_Entrada->Disabled && @$cap_datos_garantia_eq->Fecha_Entrada->EditAttrs["readonly"] == "" && @$cap_datos_garantia_eq->Fecha_Entrada->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_datos_garantia_eqedit$x_Fecha_Entrada$" name="fcap_datos_garantia_eqedit$x_Fecha_Entrada$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_datos_garantia_eqedit", "x_Fecha_Entrada", "%d/%m/%Y");
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Fecha_Entrada->ViewValue ?></span>
<input type="hidden" name="x_Fecha_Entrada" id="x_Fecha_Entrada" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Fecha_Entrada->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Fecha_Entrada->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Id_Marca_eq->Visible) { // Id_Marca_eq ?>
	<tr id="r_Id_Marca_eq"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Id_Marca_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Id_Marca_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Id_Marca_eq->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Id_Marca_eq">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Marca_eq->EditValue ?></span>
<input type="hidden" name="x_Id_Marca_eq" id="x_Id_Marca_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Marca_eq->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Marca_eq->ViewValue ?></span>
<input type="hidden" name="x_Id_Marca_eq" id="x_Id_Marca_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Marca_eq->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Id_Marca_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<tr id="r_COD_Modelo_eq"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_COD_Modelo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->COD_Modelo_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_COD_Modelo_eq">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->EditValue ?></span>
<input type="hidden" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->COD_Modelo_eq->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->COD_Modelo_eq->ViewValue ?></span>
<input type="hidden" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->COD_Modelo_eq->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->COD_Modelo_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<tr id="r_Id_Acabado_eq"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Id_Acabado_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Id_Acabado_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Id_Acabado_eq">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->EditValue ?></span>
<input type="hidden" name="x_Id_Acabado_eq" id="x_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Acabado_eq->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Acabado_eq->ViewValue ?></span>
<input type="hidden" name="x_Id_Acabado_eq" id="x_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Acabado_eq->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Id_Acabado_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Num_IMEI->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Num_IMEI">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Num_IMEI->EditValue ?></span>
<input type="hidden" name="x_Num_IMEI" id="x_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Num_IMEI->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Num_IMEI->ViewValue ?></span>
<input type="hidden" name="x_Num_IMEI" id="x_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Num_IMEI->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<tr id="r_Id_Proveedor"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Id_Proveedor"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Id_Proveedor->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Id_Proveedor->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Id_Proveedor">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Proveedor->EditValue ?></span>
<input type="hidden" name="x_Id_Proveedor" id="x_Id_Proveedor" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Proveedor->CurrentValue) ?>">
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Id_Proveedor->ViewValue ?></span>
<input type="hidden" name="x_Id_Proveedor" id="x_Id_Proveedor" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Proveedor->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Id_Proveedor->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Accesorios_Recibidos->Visible) { // Accesorios_Recibidos ?>
	<tr id="r_Accesorios_Recibidos"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Accesorios_Recibidos"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Accesorios_Recibidos">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<div id="tp_x_Accesorios_Recibidos" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME; ?>"><input type="checkbox" name="x_Accesorios_Recibidos[]" id="x_Accesorios_Recibidos[]" value="{value}"<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->EditAttributes() ?>></div>
<div id="dsl_x_Accesorios_Recibidos" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_datos_garantia_eq->Accesorios_Recibidos->EditValue;
if (is_array($arwrk)) {
	$armultiwrk= explode(",", strval($cap_datos_garantia_eq->Accesorios_Recibidos->CurrentValue));
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		$cnt = count($armultiwrk);
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (strval($arwrk[$rowcntwrk][0]) == trim(strval($armultiwrk[$ari]))) {
				$selwrk = " checked=\"checked\"";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="checkbox" name="x_Accesorios_Recibidos[]" id="x_Accesorios_Recibidos[]" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->ViewValue ?></span>
<input type="hidden" name="x_Accesorios_Recibidos" id="x_Accesorios_Recibidos" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Accesorios_Recibidos->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Accesorios_Recibidos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Falla->Visible) { // Falla ?>
	<tr id="r_Falla"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Falla"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Falla->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Falla->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Falla">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<textarea name="x_Falla" id="x_Falla" cols="35" rows="4"<?php echo $cap_datos_garantia_eq->Falla->EditAttributes() ?>><?php echo $cap_datos_garantia_eq->Falla->EditValue ?></textarea>
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Falla->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Falla->ViewValue ?></span>
<input type="hidden" name="x_Falla" id="x_Falla" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Falla->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Falla->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_datos_garantia_eq->Condiciones_Equipo->Visible) { // Condiciones_Equipo ?>
	<tr id="r_Condiciones_Equipo"<?php echo $cap_datos_garantia_eq->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_datos_garantia_eq_Condiciones_Equipo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_datos_garantia_eq->Condiciones_Equipo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_datos_garantia_eq->Condiciones_Equipo->CellAttributes() ?>><span id="el_cap_datos_garantia_eq_Condiciones_Equipo">
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { ?>
<textarea name="x_Condiciones_Equipo" id="x_Condiciones_Equipo" cols="35" rows="4"<?php echo $cap_datos_garantia_eq->Condiciones_Equipo->EditAttributes() ?>><?php echo $cap_datos_garantia_eq->Condiciones_Equipo->EditValue ?></textarea>
<?php } else { ?>
<span<?php echo $cap_datos_garantia_eq->Condiciones_Equipo->ViewAttributes() ?>>
<?php echo $cap_datos_garantia_eq->Condiciones_Equipo->ViewValue ?></span>
<input type="hidden" name="x_Condiciones_Equipo" id="x_Condiciones_Equipo" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Condiciones_Equipo->FormValue) ?>">
<?php } ?>
</span><?php echo $cap_datos_garantia_eq->Condiciones_Equipo->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_Id_Venta_Eq" id="x_Id_Venta_Eq" value="<?php echo ew_HtmlEncode($cap_datos_garantia_eq->Id_Venta_Eq->CurrentValue) ?>">
<br>
<?php if ($cap_datos_garantia_eq->CurrentAction <> "F") { // Confirm page ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>" onclick="this.form.a_edit.value='F';">
<?php } else { ?>
<input type="submit" name="btnCancel" id="btnCancel" value="<?php echo ew_BtnCaption($Language->Phrase("CancelBtn")) ?>" onclick="this.form.a_edit.value='X';">
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("ConfirmBtn")) ?>">
<?php } ?>
</form>
<script type="text/javascript">
fcap_datos_garantia_eqedit.Init();
</script>
<?php
$cap_datos_garantia_eq_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_datos_garantia_eq_edit->Page_Terminate();
?>
