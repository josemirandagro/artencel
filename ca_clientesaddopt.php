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

$ca_clientes_addopt = NULL; // Initialize page object first

class cca_clientes_addopt extends cca_clientes {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_clientes';

	// Page object name
	var $PageObjName = 'ca_clientes_addopt';

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

		// Table object (ca_clientes)
		if (!isset($GLOBALS["ca_clientes"])) {
			$GLOBALS["ca_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_clientes"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_clientes', TRUE);

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
			$this->Page_Terminate("ca_clienteslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->Id_Cliente->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Process form if post back
		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_Id_Cliente"] = $this->Id_Cliente->DbValue;
					$row["x_Nombre_Completo"] = $this->Nombre_Completo->DbValue;
					$row["x_Razon_Social"] = $this->Razon_Social->DbValue;
					$row["x_Domicilio"] = $this->Domicilio->DbValue;
					$row["x_Num_Exterior"] = $this->Num_Exterior->DbValue;
					$row["x_Num_Interior"] = $this->Num_Interior->DbValue;
					$row["x_Colonia"] = $this->Colonia->DbValue;
					$row["x_Poblacion"] = $this->Poblacion->DbValue;
					$row["x_MunicipioDel"] = $this->MunicipioDel->DbValue;
					$row["x_Id_Estado"] = $this->Id_Estado->DbValue;
					$row["x_CP"] = $this->CP->DbValue;
					$row["x_RFC"] = $this->RFC->DbValue;
					$row["x_Categoria"] = $this->Categoria->DbValue;
					$row["x_CURP"] = $this->CURP->DbValue;
					$row["x_Tel_Particular"] = $this->Tel_Particular->DbValue;
					$row["x_Tel_Oficina"] = $this->Tel_Oficina->DbValue;
					$row["x_Celular"] = $this->Celular->DbValue;
					$row["x_Edad"] = $this->Edad->DbValue;
					$row["x_Sexo"] = $this->Sexo->DbValue;
					$row["x_Tipo_Identificacion"] = $this->Tipo_Identificacion->DbValue;
					$row["x_Otra_Identificacion"] = $this->Otra_Identificacion->DbValue;
					$row["x_Numero_Identificacion"] = $this->Numero_Identificacion->DbValue;
					$row["x__EMail"] = $this->_EMail->DbValue;
					$row["x_Comentarios"] = $this->Comentarios->DbValue;
					$row["x_Ap_Paterno"] = $this->Ap_Paterno->DbValue;
					$row["x_Ap_materno"] = $this->Ap_materno->DbValue;
					$row["x_Nombres"] = $this->Nombres->DbValue;
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
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
		$this->Id_Cliente->CurrentValue = NULL;
		$this->Id_Cliente->OldValue = $this->Id_Cliente->CurrentValue;
		$this->Nombre_Completo->CurrentValue = NULL;
		$this->Nombre_Completo->OldValue = $this->Nombre_Completo->CurrentValue;
		$this->Razon_Social->CurrentValue = NULL;
		$this->Razon_Social->OldValue = $this->Razon_Social->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Num_Exterior->CurrentValue = "S/N";
		$this->Num_Interior->CurrentValue = "";
		$this->Colonia->CurrentValue = NULL;
		$this->Colonia->OldValue = $this->Colonia->CurrentValue;
		$this->Poblacion->CurrentValue = NULL;
		$this->Poblacion->OldValue = $this->Poblacion->CurrentValue;
		$this->MunicipioDel->CurrentValue = NULL;
		$this->MunicipioDel->OldValue = $this->MunicipioDel->CurrentValue;
		$this->Id_Estado->CurrentValue = 17;
		$this->CP->CurrentValue = NULL;
		$this->CP->OldValue = $this->CP->CurrentValue;
		$this->RFC->CurrentValue = NULL;
		$this->RFC->OldValue = $this->RFC->CurrentValue;
		$this->Categoria->CurrentValue = "Publico";
		$this->CURP->CurrentValue = NULL;
		$this->CURP->OldValue = $this->CURP->CurrentValue;
		$this->Tel_Particular->CurrentValue = NULL;
		$this->Tel_Particular->OldValue = $this->Tel_Particular->CurrentValue;
		$this->Tel_Oficina->CurrentValue = NULL;
		$this->Tel_Oficina->OldValue = $this->Tel_Oficina->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Edad->CurrentValue = NULL;
		$this->Edad->OldValue = $this->Edad->CurrentValue;
		$this->Sexo->CurrentValue = NULL;
		$this->Sexo->OldValue = $this->Sexo->CurrentValue;
		$this->Tipo_Identificacion->CurrentValue = "IFE";
		$this->Otra_Identificacion->CurrentValue = NULL;
		$this->Otra_Identificacion->OldValue = $this->Otra_Identificacion->CurrentValue;
		$this->Numero_Identificacion->CurrentValue = NULL;
		$this->Numero_Identificacion->OldValue = $this->Numero_Identificacion->CurrentValue;
		$this->_EMail->CurrentValue = NULL;
		$this->_EMail->OldValue = $this->_EMail->CurrentValue;
		$this->Comentarios->CurrentValue = NULL;
		$this->Comentarios->OldValue = $this->Comentarios->CurrentValue;
		$this->Ap_Paterno->CurrentValue = NULL;
		$this->Ap_Paterno->OldValue = $this->Ap_Paterno->CurrentValue;
		$this->Ap_materno->CurrentValue = NULL;
		$this->Ap_materno->OldValue = $this->Ap_materno->CurrentValue;
		$this->Nombres->CurrentValue = NULL;
		$this->Nombres->OldValue = $this->Nombres->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nombre_Completo->FldIsDetailKey) {
			$this->Nombre_Completo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Nombre_Completo")));
		}
		if (!$this->Razon_Social->FldIsDetailKey) {
			$this->Razon_Social->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Razon_Social")));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Domicilio")));
		}
		if (!$this->Num_Exterior->FldIsDetailKey) {
			$this->Num_Exterior->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Num_Exterior")));
		}
		if (!$this->Num_Interior->FldIsDetailKey) {
			$this->Num_Interior->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Num_Interior")));
		}
		if (!$this->Colonia->FldIsDetailKey) {
			$this->Colonia->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Colonia")));
		}
		if (!$this->Poblacion->FldIsDetailKey) {
			$this->Poblacion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Poblacion")));
		}
		if (!$this->MunicipioDel->FldIsDetailKey) {
			$this->MunicipioDel->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_MunicipioDel")));
		}
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Id_Estado")));
		}
		if (!$this->CP->FldIsDetailKey) {
			$this->CP->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_CP")));
		}
		if (!$this->RFC->FldIsDetailKey) {
			$this->RFC->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_RFC")));
		}
		if (!$this->Categoria->FldIsDetailKey) {
			$this->Categoria->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Categoria")));
		}
		if (!$this->CURP->FldIsDetailKey) {
			$this->CURP->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_CURP")));
		}
		if (!$this->Tel_Particular->FldIsDetailKey) {
			$this->Tel_Particular->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Tel_Particular")));
		}
		if (!$this->Tel_Oficina->FldIsDetailKey) {
			$this->Tel_Oficina->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Tel_Oficina")));
		}
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Celular")));
		}
		if (!$this->Edad->FldIsDetailKey) {
			$this->Edad->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Edad")));
		}
		if (!$this->Sexo->FldIsDetailKey) {
			$this->Sexo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Sexo")));
		}
		if (!$this->Tipo_Identificacion->FldIsDetailKey) {
			$this->Tipo_Identificacion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Tipo_Identificacion")));
		}
		if (!$this->Otra_Identificacion->FldIsDetailKey) {
			$this->Otra_Identificacion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Otra_Identificacion")));
		}
		if (!$this->Numero_Identificacion->FldIsDetailKey) {
			$this->Numero_Identificacion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Numero_Identificacion")));
		}
		if (!$this->_EMail->FldIsDetailKey) {
			$this->_EMail->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x__EMail")));
		}
		if (!$this->Comentarios->FldIsDetailKey) {
			$this->Comentarios->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Comentarios")));
		}
		if (!$this->Ap_Paterno->FldIsDetailKey) {
			$this->Ap_Paterno->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Ap_Paterno")));
		}
		if (!$this->Ap_materno->FldIsDetailKey) {
			$this->Ap_materno->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Ap_materno")));
		}
		if (!$this->Nombres->FldIsDetailKey) {
			$this->Nombres->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Nombres")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Nombre_Completo->CurrentValue = ew_ConvertToUtf8($this->Nombre_Completo->FormValue);
		$this->Razon_Social->CurrentValue = ew_ConvertToUtf8($this->Razon_Social->FormValue);
		$this->Domicilio->CurrentValue = ew_ConvertToUtf8($this->Domicilio->FormValue);
		$this->Num_Exterior->CurrentValue = ew_ConvertToUtf8($this->Num_Exterior->FormValue);
		$this->Num_Interior->CurrentValue = ew_ConvertToUtf8($this->Num_Interior->FormValue);
		$this->Colonia->CurrentValue = ew_ConvertToUtf8($this->Colonia->FormValue);
		$this->Poblacion->CurrentValue = ew_ConvertToUtf8($this->Poblacion->FormValue);
		$this->MunicipioDel->CurrentValue = ew_ConvertToUtf8($this->MunicipioDel->FormValue);
		$this->Id_Estado->CurrentValue = ew_ConvertToUtf8($this->Id_Estado->FormValue);
		$this->CP->CurrentValue = ew_ConvertToUtf8($this->CP->FormValue);
		$this->RFC->CurrentValue = ew_ConvertToUtf8($this->RFC->FormValue);
		$this->Categoria->CurrentValue = ew_ConvertToUtf8($this->Categoria->FormValue);
		$this->CURP->CurrentValue = ew_ConvertToUtf8($this->CURP->FormValue);
		$this->Tel_Particular->CurrentValue = ew_ConvertToUtf8($this->Tel_Particular->FormValue);
		$this->Tel_Oficina->CurrentValue = ew_ConvertToUtf8($this->Tel_Oficina->FormValue);
		$this->Celular->CurrentValue = ew_ConvertToUtf8($this->Celular->FormValue);
		$this->Edad->CurrentValue = ew_ConvertToUtf8($this->Edad->FormValue);
		$this->Sexo->CurrentValue = ew_ConvertToUtf8($this->Sexo->FormValue);
		$this->Tipo_Identificacion->CurrentValue = ew_ConvertToUtf8($this->Tipo_Identificacion->FormValue);
		$this->Otra_Identificacion->CurrentValue = ew_ConvertToUtf8($this->Otra_Identificacion->FormValue);
		$this->Numero_Identificacion->CurrentValue = ew_ConvertToUtf8($this->Numero_Identificacion->FormValue);
		$this->_EMail->CurrentValue = ew_ConvertToUtf8($this->_EMail->FormValue);
		$this->Comentarios->CurrentValue = ew_ConvertToUtf8($this->Comentarios->FormValue);
		$this->Ap_Paterno->CurrentValue = ew_ConvertToUtf8($this->Ap_Paterno->FormValue);
		$this->Ap_materno->CurrentValue = ew_ConvertToUtf8($this->Ap_materno->FormValue);
		$this->Nombres->CurrentValue = ew_ConvertToUtf8($this->Nombres->FormValue);
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

			// Id_Cliente
			$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Nombre_Completo
			$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
			$this->Nombre_Completo->ViewValue = strtoupper($this->Nombre_Completo->ViewValue);
			$this->Nombre_Completo->ViewCustomAttributes = "";

			// Razon_Social
			$this->Razon_Social->ViewValue = $this->Razon_Social->CurrentValue;
			$this->Razon_Social->ViewValue = strtoupper($this->Razon_Social->ViewValue);
			$this->Razon_Social->ViewCustomAttributes = "";

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

			// Ap_Paterno
			$this->Ap_Paterno->ViewValue = $this->Ap_Paterno->CurrentValue;
			$this->Ap_Paterno->ViewValue = strtoupper($this->Ap_Paterno->ViewValue);
			$this->Ap_Paterno->ViewCustomAttributes = "";

			// Ap_materno
			$this->Ap_materno->ViewValue = $this->Ap_materno->CurrentValue;
			$this->Ap_materno->ViewValue = strtoupper($this->Ap_materno->ViewValue);
			$this->Ap_materno->ViewCustomAttributes = "";

			// Nombres
			$this->Nombres->ViewValue = $this->Nombres->CurrentValue;
			$this->Nombres->ViewValue = strtoupper($this->Nombres->ViewValue);
			$this->Nombres->ViewCustomAttributes = "";

			// Id_Cliente
			$this->Id_Cliente->LinkCustomAttributes = "";
			$this->Id_Cliente->HrefValue = "";
			$this->Id_Cliente->TooltipValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->LinkCustomAttributes = "";
			$this->Nombre_Completo->HrefValue = "";
			$this->Nombre_Completo->TooltipValue = "";

			// Razon_Social
			$this->Razon_Social->LinkCustomAttributes = "";
			$this->Razon_Social->HrefValue = "";
			$this->Razon_Social->TooltipValue = "";

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

			// Ap_Paterno
			$this->Ap_Paterno->LinkCustomAttributes = "";
			$this->Ap_Paterno->HrefValue = "";
			$this->Ap_Paterno->TooltipValue = "";

			// Ap_materno
			$this->Ap_materno->LinkCustomAttributes = "";
			$this->Ap_materno->HrefValue = "";
			$this->Ap_materno->TooltipValue = "";

			// Nombres
			$this->Nombres->LinkCustomAttributes = "";
			$this->Nombres->HrefValue = "";
			$this->Nombres->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Cliente
			// Nombre_Completo

			$this->Nombre_Completo->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre_Completo->EditValue = ew_HtmlEncode($this->Nombre_Completo->CurrentValue);

			// Razon_Social
			$this->Razon_Social->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Razon_Social->EditValue = ew_HtmlEncode($this->Razon_Social->CurrentValue);

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

			// MunicipioDel
			$this->MunicipioDel->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->MunicipioDel->EditValue = ew_HtmlEncode($this->MunicipioDel->CurrentValue);

			// Id_Estado
			$this->Id_Estado->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Estado->EditValue = $arwrk;

			// CP
			$this->CP->EditCustomAttributes = "";
			$this->CP->EditValue = ew_HtmlEncode($this->CP->CurrentValue);

			// RFC
			$this->RFC->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->RFC->EditValue = ew_HtmlEncode($this->RFC->CurrentValue);

			// Categoria
			$this->Categoria->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Categoria->FldTagValue(1), $this->Categoria->FldTagCaption(1) <> "" ? $this->Categoria->FldTagCaption(1) : $this->Categoria->FldTagValue(1));
			$arwrk[] = array($this->Categoria->FldTagValue(2), $this->Categoria->FldTagCaption(2) <> "" ? $this->Categoria->FldTagCaption(2) : $this->Categoria->FldTagValue(2));
			$arwrk[] = array($this->Categoria->FldTagValue(3), $this->Categoria->FldTagCaption(3) <> "" ? $this->Categoria->FldTagCaption(3) : $this->Categoria->FldTagValue(3));
			$this->Categoria->EditValue = $arwrk;

			// CURP
			$this->CURP->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->CURP->EditValue = ew_HtmlEncode($this->CURP->CurrentValue);

			// Tel_Particular
			$this->Tel_Particular->EditCustomAttributes = "";
			$this->Tel_Particular->EditValue = ew_HtmlEncode($this->Tel_Particular->CurrentValue);

			// Tel_Oficina
			$this->Tel_Oficina->EditCustomAttributes = "";
			$this->Tel_Oficina->EditValue = ew_HtmlEncode($this->Tel_Oficina->CurrentValue);

			// Celular
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);

			// Edad
			$this->Edad->EditCustomAttributes = "";
			$this->Edad->EditValue = ew_HtmlEncode($this->Edad->CurrentValue);

			// Sexo
			$this->Sexo->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Sexo->FldTagValue(1), $this->Sexo->FldTagCaption(1) <> "" ? $this->Sexo->FldTagCaption(1) : $this->Sexo->FldTagValue(1));
			$arwrk[] = array($this->Sexo->FldTagValue(2), $this->Sexo->FldTagCaption(2) <> "" ? $this->Sexo->FldTagCaption(2) : $this->Sexo->FldTagValue(2));
			$this->Sexo->EditValue = $arwrk;

			// Tipo_Identificacion
			$this->Tipo_Identificacion->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(1), $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->FldTagValue(1));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(2), $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->FldTagValue(2));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(3), $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->FldTagValue(3));
			$arwrk[] = array($this->Tipo_Identificacion->FldTagValue(4), $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->FldTagValue(4));
			$this->Tipo_Identificacion->EditValue = $arwrk;

			// Otra_Identificacion
			$this->Otra_Identificacion->EditCustomAttributes = "";
			$this->Otra_Identificacion->EditValue = ew_HtmlEncode($this->Otra_Identificacion->CurrentValue);

			// Numero_Identificacion
			$this->Numero_Identificacion->EditCustomAttributes = "";
			$this->Numero_Identificacion->EditValue = ew_HtmlEncode($this->Numero_Identificacion->CurrentValue);

			// EMail
			$this->_EMail->EditCustomAttributes = "";
			$this->_EMail->EditValue = ew_HtmlEncode($this->_EMail->CurrentValue);

			// Comentarios
			$this->Comentarios->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Comentarios->EditValue = ew_HtmlEncode($this->Comentarios->CurrentValue);

			// Ap_Paterno
			$this->Ap_Paterno->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Ap_Paterno->EditValue = ew_HtmlEncode($this->Ap_Paterno->CurrentValue);

			// Ap_materno
			$this->Ap_materno->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Ap_materno->EditValue = ew_HtmlEncode($this->Ap_materno->CurrentValue);

			// Nombres
			$this->Nombres->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombres->EditValue = ew_HtmlEncode($this->Nombres->CurrentValue);

			// Edit refer script
			// Id_Cliente

			$this->Id_Cliente->HrefValue = "";

			// Nombre_Completo
			$this->Nombre_Completo->HrefValue = "";

			// Razon_Social
			$this->Razon_Social->HrefValue = "";

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

			// MunicipioDel
			$this->MunicipioDel->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->HrefValue = "";

			// CP
			$this->CP->HrefValue = "";

			// RFC
			$this->RFC->HrefValue = "";

			// Categoria
			$this->Categoria->HrefValue = "";

			// CURP
			$this->CURP->HrefValue = "";

			// Tel_Particular
			$this->Tel_Particular->HrefValue = "";

			// Tel_Oficina
			$this->Tel_Oficina->HrefValue = "";

			// Celular
			$this->Celular->HrefValue = "";

			// Edad
			$this->Edad->HrefValue = "";

			// Sexo
			$this->Sexo->HrefValue = "";

			// Tipo_Identificacion
			$this->Tipo_Identificacion->HrefValue = "";

			// Otra_Identificacion
			$this->Otra_Identificacion->HrefValue = "";

			// Numero_Identificacion
			$this->Numero_Identificacion->HrefValue = "";

			// EMail
			$this->_EMail->HrefValue = "";

			// Comentarios
			$this->Comentarios->HrefValue = "";

			// Ap_Paterno
			$this->Ap_Paterno->HrefValue = "";

			// Ap_materno
			$this->Ap_materno->HrefValue = "";

			// Nombres
			$this->Nombres->HrefValue = "";
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
		if (!is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Estado->FldCaption());
		}
		if (!ew_CheckInteger($this->Edad->FormValue)) {
			ew_AddMessage($gsFormError, $this->Edad->FldErrMsg());
		}
		if ($this->Tipo_Identificacion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Tipo_Identificacion->FldCaption());
		}
		if (!is_null($this->Ap_Paterno->FormValue) && $this->Ap_Paterno->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Ap_Paterno->FldCaption());
		}
		if (!is_null($this->Ap_materno->FormValue) && $this->Ap_materno->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Ap_materno->FldCaption());
		}
		if (!is_null($this->Nombres->FormValue) && $this->Nombres->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nombres->FldCaption());
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
		if ($this->Nombre_Completo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Nombre_Completo = '" . ew_AdjustSql($this->Nombre_Completo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Nombre_Completo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Nombre_Completo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->Razon_Social->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Razon_Social = '" . ew_AdjustSql($this->Razon_Social->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Razon_Social->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Razon_Social->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->RFC->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(RFC = '" . ew_AdjustSql($this->RFC->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->RFC->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->RFC->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->CURP->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(CURP = '" . ew_AdjustSql($this->CURP->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->CURP->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->CURP->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Nombre_Completo
		$this->Nombre_Completo->SetDbValueDef($rsnew, $this->Nombre_Completo->CurrentValue, NULL, FALSE);

		// Razon_Social
		$this->Razon_Social->SetDbValueDef($rsnew, $this->Razon_Social->CurrentValue, NULL, FALSE);

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

		// MunicipioDel
		$this->MunicipioDel->SetDbValueDef($rsnew, $this->MunicipioDel->CurrentValue, NULL, FALSE);

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, NULL, FALSE);

		// CP
		$this->CP->SetDbValueDef($rsnew, $this->CP->CurrentValue, NULL, FALSE);

		// RFC
		$this->RFC->SetDbValueDef($rsnew, $this->RFC->CurrentValue, NULL, FALSE);

		// Categoria
		$this->Categoria->SetDbValueDef($rsnew, $this->Categoria->CurrentValue, NULL, strval($this->Categoria->CurrentValue) == "");

		// CURP
		$this->CURP->SetDbValueDef($rsnew, $this->CURP->CurrentValue, NULL, FALSE);

		// Tel_Particular
		$this->Tel_Particular->SetDbValueDef($rsnew, $this->Tel_Particular->CurrentValue, NULL, FALSE);

		// Tel_Oficina
		$this->Tel_Oficina->SetDbValueDef($rsnew, $this->Tel_Oficina->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Edad
		$this->Edad->SetDbValueDef($rsnew, $this->Edad->CurrentValue, NULL, FALSE);

		// Sexo
		$this->Sexo->SetDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, FALSE);

		// Tipo_Identificacion
		$this->Tipo_Identificacion->SetDbValueDef($rsnew, $this->Tipo_Identificacion->CurrentValue, NULL, strval($this->Tipo_Identificacion->CurrentValue) == "");

		// Otra_Identificacion
		$this->Otra_Identificacion->SetDbValueDef($rsnew, $this->Otra_Identificacion->CurrentValue, NULL, FALSE);

		// Numero_Identificacion
		$this->Numero_Identificacion->SetDbValueDef($rsnew, $this->Numero_Identificacion->CurrentValue, NULL, FALSE);

		// EMail
		$this->_EMail->SetDbValueDef($rsnew, $this->_EMail->CurrentValue, NULL, FALSE);

		// Comentarios
		$this->Comentarios->SetDbValueDef($rsnew, $this->Comentarios->CurrentValue, NULL, FALSE);

		// Ap_Paterno
		$this->Ap_Paterno->SetDbValueDef($rsnew, $this->Ap_Paterno->CurrentValue, "", FALSE);

		// Ap_materno
		$this->Ap_materno->SetDbValueDef($rsnew, $this->Ap_materno->CurrentValue, "", FALSE);

		// Nombres
		$this->Nombres->SetDbValueDef($rsnew, $this->Nombres->CurrentValue, "", FALSE);

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

	// Custom validate event
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
if (!isset($ca_clientes_addopt)) $ca_clientes_addopt = new cca_clientes_addopt();

// Page init
$ca_clientes_addopt->Page_Init();

// Page main
$ca_clientes_addopt->Page_Main();
?>
<script type="text/javascript">

// Page object
var ca_clientes_addopt = new ew_Page("ca_clientes_addopt");
ca_clientes_addopt.PageID = "addopt"; // Page ID
var EW_PAGE_ID = ca_clientes_addopt.PageID; // For backward compatibility

// Form object
var fca_clientesaddopt = new ew_Form("fca_clientesaddopt");

// Validate form
fca_clientesaddopt.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Nombre_Completo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Domicilio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Domicilio->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_Exterior"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Num_Exterior->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Estado"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Id_Estado->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Edad"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ca_clientes->Edad->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Tipo_Identificacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Tipo_Identificacion->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Ap_Paterno"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Ap_Paterno->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Ap_materno"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Ap_materno->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Nombres"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ca_clientes->Nombres->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fca_clientesaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_clientesaddopt.ValidateRequired = true;
<?php } else { ?>
fca_clientesaddopt.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_clientesaddopt.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$ca_clientes_addopt->ShowMessage();
?>
<form name="fca_clientesaddopt" id="fca_clientesaddopt" class="ewForm" action="ca_clientesaddopt.php" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="ca_clientes">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<table id="tbl_ca_clientesaddopt" class="ewTableAddOpt">
	<tr>
		<td><span id="elh_ca_clientes_Nombre_Completo"><?php echo $ca_clientes->Nombre_Completo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Nombre_Completo">
<input type="text" name="x_Nombre_Completo" id="x_Nombre_Completo" size="50" maxlength="50" value="<?php echo $ca_clientes->Nombre_Completo->EditValue ?>"<?php echo $ca_clientes->Nombre_Completo->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Razon_Social"><?php echo $ca_clientes->Razon_Social->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Razon_Social">
<input type="text" name="x_Razon_Social" id="x_Razon_Social" size="30" maxlength="50" value="<?php echo $ca_clientes->Razon_Social->EditValue ?>"<?php echo $ca_clientes->Razon_Social->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Domicilio"><?php echo $ca_clientes->Domicilio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Domicilio">
<input type="text" name="x_Domicilio" id="x_Domicilio" size="80" maxlength="150" value="<?php echo $ca_clientes->Domicilio->EditValue ?>"<?php echo $ca_clientes->Domicilio->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Num_Exterior"><?php echo $ca_clientes->Num_Exterior->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Num_Exterior">
<input type="text" name="x_Num_Exterior" id="x_Num_Exterior" size="7" maxlength="5" value="<?php echo $ca_clientes->Num_Exterior->EditValue ?>"<?php echo $ca_clientes->Num_Exterior->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Num_Interior"><?php echo $ca_clientes->Num_Interior->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Num_Interior">
<input type="text" name="x_Num_Interior" id="x_Num_Interior" size="7" maxlength="5" value="<?php echo $ca_clientes->Num_Interior->EditValue ?>"<?php echo $ca_clientes->Num_Interior->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Colonia"><?php echo $ca_clientes->Colonia->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Colonia">
<input type="text" name="x_Colonia" id="x_Colonia" size="52" maxlength="50" value="<?php echo $ca_clientes->Colonia->EditValue ?>"<?php echo $ca_clientes->Colonia->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Poblacion"><?php echo $ca_clientes->Poblacion->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Poblacion">
<input type="text" name="x_Poblacion" id="x_Poblacion" size="50" maxlength="50" value="<?php echo $ca_clientes->Poblacion->EditValue ?>"<?php echo $ca_clientes->Poblacion->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_MunicipioDel"><?php echo $ca_clientes->MunicipioDel->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_MunicipioDel">
<input type="text" name="x_MunicipioDel" id="x_MunicipioDel" size="52" maxlength="50" value="<?php echo $ca_clientes->MunicipioDel->EditValue ?>"<?php echo $ca_clientes->MunicipioDel->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Id_Estado"><?php echo $ca_clientes->Id_Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Id_Estado">
<select id="x_Id_Estado" name="x_Id_Estado"<?php echo $ca_clientes->Id_Estado->EditAttributes() ?>>
<?php
if (is_array($ca_clientes->Id_Estado->EditValue)) {
	$arwrk = $ca_clientes->Id_Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_clientes->Id_Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_clientesaddopt.Lists["x_Id_Estado"].Options = <?php echo (is_array($ca_clientes->Id_Estado->EditValue)) ? ew_ArrayToJson($ca_clientes->Id_Estado->EditValue, 1) : "[]" ?>;
</script>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_CP"><?php echo $ca_clientes->CP->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_CP">
<input type="text" name="x_CP" id="x_CP" size="6" maxlength="5" value="<?php echo $ca_clientes->CP->EditValue ?>"<?php echo $ca_clientes->CP->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_RFC"><?php echo $ca_clientes->RFC->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_RFC">
<input type="text" name="x_RFC" id="x_RFC" size="15" maxlength="13" value="<?php echo $ca_clientes->RFC->EditValue ?>"<?php echo $ca_clientes->RFC->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Categoria"><?php echo $ca_clientes->Categoria->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Categoria">
<div id="tp_x_Categoria" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Categoria" id="x_Categoria" value="{value}"<?php echo $ca_clientes->Categoria->EditAttributes() ?>></div>
<div id="dsl_x_Categoria" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_clientes->Categoria->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_clientes->Categoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
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
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_CURP"><?php echo $ca_clientes->CURP->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_CURP">
<input type="text" name="x_CURP" id="x_CURP" size="25" maxlength="25" value="<?php echo $ca_clientes->CURP->EditValue ?>"<?php echo $ca_clientes->CURP->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Tel_Particular"><?php echo $ca_clientes->Tel_Particular->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Tel_Particular">
<input type="text" name="x_Tel_Particular" id="x_Tel_Particular" size="20" maxlength="20" value="<?php echo $ca_clientes->Tel_Particular->EditValue ?>"<?php echo $ca_clientes->Tel_Particular->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Tel_Oficina"><?php echo $ca_clientes->Tel_Oficina->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Tel_Oficina">
<input type="text" name="x_Tel_Oficina" id="x_Tel_Oficina" size="20" maxlength="20" value="<?php echo $ca_clientes->Tel_Oficina->EditValue ?>"<?php echo $ca_clientes->Tel_Oficina->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Celular"><?php echo $ca_clientes->Celular->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Celular">
<input type="text" name="x_Celular" id="x_Celular" size="20" maxlength="20" value="<?php echo $ca_clientes->Celular->EditValue ?>"<?php echo $ca_clientes->Celular->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Edad"><?php echo $ca_clientes->Edad->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Edad">
<input type="text" name="x_Edad" id="x_Edad" size="30" value="<?php echo $ca_clientes->Edad->EditValue ?>"<?php echo $ca_clientes->Edad->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Sexo"><?php echo $ca_clientes->Sexo->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Sexo">
<div id="tp_x_Sexo" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Sexo" id="x_Sexo" value="{value}"<?php echo $ca_clientes->Sexo->EditAttributes() ?>></div>
<div id="dsl_x_Sexo" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_clientes->Sexo->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_clientes->Sexo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Sexo" id="x_Sexo" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_clientes->Sexo->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Tipo_Identificacion"><?php echo $ca_clientes->Tipo_Identificacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Tipo_Identificacion">
<div id="tp_x_Tipo_Identificacion" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="{value}"<?php echo $ca_clientes->Tipo_Identificacion->EditAttributes() ?>></div>
<div id="dsl_x_Tipo_Identificacion" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_clientes->Tipo_Identificacion->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_clientes->Tipo_Identificacion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Tipo_Identificacion" id="x_Tipo_Identificacion" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_clientes->Tipo_Identificacion->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Otra_Identificacion"><?php echo $ca_clientes->Otra_Identificacion->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Otra_Identificacion">
<input type="text" name="x_Otra_Identificacion" id="x_Otra_Identificacion" size="20" maxlength="20" value="<?php echo $ca_clientes->Otra_Identificacion->EditValue ?>"<?php echo $ca_clientes->Otra_Identificacion->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Numero_Identificacion"><?php echo $ca_clientes->Numero_Identificacion->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Numero_Identificacion">
<input type="text" name="x_Numero_Identificacion" id="x_Numero_Identificacion" size="20" maxlength="20" value="<?php echo $ca_clientes->Numero_Identificacion->EditValue ?>"<?php echo $ca_clientes->Numero_Identificacion->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes__EMail"><?php echo $ca_clientes->_EMail->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes__EMail">
<input type="text" name="x__EMail" id="x__EMail" size="50" maxlength="50" value="<?php echo $ca_clientes->_EMail->EditValue ?>"<?php echo $ca_clientes->_EMail->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Comentarios"><?php echo $ca_clientes->Comentarios->FldCaption() ?></span></td>
		<td><span id="el_ca_clientes_Comentarios">
<textarea name="x_Comentarios" id="x_Comentarios" cols="50" rows="5"<?php echo $ca_clientes->Comentarios->EditAttributes() ?>><?php echo $ca_clientes->Comentarios->EditValue ?></textarea>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Ap_Paterno"><?php echo $ca_clientes->Ap_Paterno->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Ap_Paterno">
<input type="text" name="x_Ap_Paterno" id="x_Ap_Paterno" size="30" maxlength="20" value="<?php echo $ca_clientes->Ap_Paterno->EditValue ?>"<?php echo $ca_clientes->Ap_Paterno->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Ap_materno"><?php echo $ca_clientes->Ap_materno->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Ap_materno">
<input type="text" name="x_Ap_materno" id="x_Ap_materno" size="30" maxlength="20" value="<?php echo $ca_clientes->Ap_materno->EditValue ?>"<?php echo $ca_clientes->Ap_materno->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_ca_clientes_Nombres"><?php echo $ca_clientes->Nombres->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_ca_clientes_Nombres">
<input type="text" name="x_Nombres" id="x_Nombres" size="30" maxlength="20" value="<?php echo $ca_clientes->Nombres->EditValue ?>"<?php echo $ca_clientes->Nombres->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<br>
</form>
<script type="text/javascript">
fca_clientesaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$ca_clientes_addopt->Page_Terminate();
?>
