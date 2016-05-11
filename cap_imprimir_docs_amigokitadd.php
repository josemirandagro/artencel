<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_imprimir_docs_amigokitinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_imprimir_docs_amigokit_add = NULL; // Initialize page object first

class ccap_imprimir_docs_amigokit_add extends ccap_imprimir_docs_amigokit {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_imprimir_docs_amigokit';

	// Page object name
	var $PageObjName = 'cap_imprimir_docs_amigokit_add';

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

		// Table object (cap_imprimir_docs_amigokit)
		if (!isset($GLOBALS["cap_imprimir_docs_amigokit"])) {
			$GLOBALS["cap_imprimir_docs_amigokit"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_imprimir_docs_amigokit"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_imprimir_docs_amigokit', TRUE);

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
			$this->Page_Terminate("cap_imprimir_docs_amigokitlist.php");
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
			if (@$_GET["Id_Venta_Eq"] != "") {
				$this->Id_Venta_Eq->setQueryStringValue($_GET["Id_Venta_Eq"]);
				$this->setKey("Id_Venta_Eq", $this->Id_Venta_Eq->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Venta_Eq", ""); // Clear key
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
					$this->Page_Terminate("cap_imprimir_docs_amigokitlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_imprimir_docs_amigokitview.php")
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
		$this->FechaVenta->CurrentValue = NULL;
		$this->FechaVenta->OldValue = $this->FechaVenta->CurrentValue;
		$this->Id_Tienda->CurrentValue = NULL;
		$this->Id_Tienda->OldValue = $this->Id_Tienda->CurrentValue;
		$this->Id_Tel_SIM->CurrentValue = 0;
		$this->Id_Cliente->CurrentValue = 0;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->Num_ICCID->CurrentValue = NULL;
		$this->Num_ICCID->OldValue = $this->Num_ICCID->CurrentValue;
		$this->Num_CEL->CurrentValue = NULL;
		$this->Num_CEL->OldValue = $this->Num_CEL->CurrentValue;
		$this->Descripcion_SIM->CurrentValue = NULL;
		$this->Descripcion_SIM->OldValue = $this->Descripcion_SIM->CurrentValue;
		$this->Reg_Venta_Movi->CurrentValue = NULL;
		$this->Reg_Venta_Movi->OldValue = $this->Reg_Venta_Movi->CurrentValue;
		$this->Monto_Recarga_Movi->CurrentValue = NULL;
		$this->Monto_Recarga_Movi->OldValue = $this->Monto_Recarga_Movi->CurrentValue;
		$this->Folio_Recarga_Movi->CurrentValue = NULL;
		$this->Folio_Recarga_Movi->OldValue = $this->Folio_Recarga_Movi->CurrentValue;
		$this->ImprimirNotaVenta->CurrentValue = NULL;
		$this->ImprimirNotaVenta->OldValue = $this->ImprimirNotaVenta->CurrentValue;
		$this->Serie_NotaVenta->CurrentValue = NULL;
		$this->Serie_NotaVenta->OldValue = $this->Serie_NotaVenta->CurrentValue;
		$this->Numero_NotaVenta->CurrentValue = NULL;
		$this->Numero_NotaVenta->OldValue = $this->Numero_NotaVenta->CurrentValue;
		$this->Imprimirpapeleta->CurrentValue = NULL;
		$this->Imprimirpapeleta->OldValue = $this->Imprimirpapeleta->CurrentValue;
		$this->FolioImpresoPapeleta->CurrentValue = NULL;
		$this->FolioImpresoPapeleta->OldValue = $this->FolioImpresoPapeleta->CurrentValue;
		$this->Maneja_Papeleta->CurrentValue = "SI";
		$this->Maneja_Activacion_Movi->CurrentValue = "NO";
		$this->Con_SIM->CurrentValue = "SIN CHIP";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->FechaVenta->FldIsDetailKey) {
			$this->FechaVenta->setFormValue($objForm->GetValue("x_FechaVenta"));
			$this->FechaVenta->CurrentValue = ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7);
		}
		if (!$this->Id_Tienda->FldIsDetailKey) {
			$this->Id_Tienda->setFormValue($objForm->GetValue("x_Id_Tienda"));
		}
		if (!$this->Id_Tel_SIM->FldIsDetailKey) {
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		}
		if (!$this->Id_Cliente->FldIsDetailKey) {
			$this->Id_Cliente->setFormValue($objForm->GetValue("x_Id_Cliente"));
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
		if (!$this->Descripcion_SIM->FldIsDetailKey) {
			$this->Descripcion_SIM->setFormValue($objForm->GetValue("x_Descripcion_SIM"));
		}
		if (!$this->Reg_Venta_Movi->FldIsDetailKey) {
			$this->Reg_Venta_Movi->setFormValue($objForm->GetValue("x_Reg_Venta_Movi"));
		}
		if (!$this->Monto_Recarga_Movi->FldIsDetailKey) {
			$this->Monto_Recarga_Movi->setFormValue($objForm->GetValue("x_Monto_Recarga_Movi"));
		}
		if (!$this->Folio_Recarga_Movi->FldIsDetailKey) {
			$this->Folio_Recarga_Movi->setFormValue($objForm->GetValue("x_Folio_Recarga_Movi"));
		}
		if (!$this->ImprimirNotaVenta->FldIsDetailKey) {
			$this->ImprimirNotaVenta->setFormValue($objForm->GetValue("x_ImprimirNotaVenta"));
		}
		if (!$this->Serie_NotaVenta->FldIsDetailKey) {
			$this->Serie_NotaVenta->setFormValue($objForm->GetValue("x_Serie_NotaVenta"));
		}
		if (!$this->Numero_NotaVenta->FldIsDetailKey) {
			$this->Numero_NotaVenta->setFormValue($objForm->GetValue("x_Numero_NotaVenta"));
		}
		if (!$this->Imprimirpapeleta->FldIsDetailKey) {
			$this->Imprimirpapeleta->setFormValue($objForm->GetValue("x_Imprimirpapeleta"));
		}
		if (!$this->FolioImpresoPapeleta->FldIsDetailKey) {
			$this->FolioImpresoPapeleta->setFormValue($objForm->GetValue("x_FolioImpresoPapeleta"));
		}
		if (!$this->Maneja_Papeleta->FldIsDetailKey) {
			$this->Maneja_Papeleta->setFormValue($objForm->GetValue("x_Maneja_Papeleta"));
		}
		if (!$this->Maneja_Activacion_Movi->FldIsDetailKey) {
			$this->Maneja_Activacion_Movi->setFormValue($objForm->GetValue("x_Maneja_Activacion_Movi"));
		}
		if (!$this->Con_SIM->FldIsDetailKey) {
			$this->Con_SIM->setFormValue($objForm->GetValue("x_Con_SIM"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->FechaVenta->CurrentValue = $this->FechaVenta->FormValue;
		$this->FechaVenta->CurrentValue = ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7);
		$this->Id_Tienda->CurrentValue = $this->Id_Tienda->FormValue;
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Id_Cliente->CurrentValue = $this->Id_Cliente->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_ICCID->CurrentValue = $this->Num_ICCID->FormValue;
		$this->Num_CEL->CurrentValue = $this->Num_CEL->FormValue;
		$this->Descripcion_SIM->CurrentValue = $this->Descripcion_SIM->FormValue;
		$this->Reg_Venta_Movi->CurrentValue = $this->Reg_Venta_Movi->FormValue;
		$this->Monto_Recarga_Movi->CurrentValue = $this->Monto_Recarga_Movi->FormValue;
		$this->Folio_Recarga_Movi->CurrentValue = $this->Folio_Recarga_Movi->FormValue;
		$this->ImprimirNotaVenta->CurrentValue = $this->ImprimirNotaVenta->FormValue;
		$this->Serie_NotaVenta->CurrentValue = $this->Serie_NotaVenta->FormValue;
		$this->Numero_NotaVenta->CurrentValue = $this->Numero_NotaVenta->FormValue;
		$this->Imprimirpapeleta->CurrentValue = $this->Imprimirpapeleta->FormValue;
		$this->FolioImpresoPapeleta->CurrentValue = $this->FolioImpresoPapeleta->FormValue;
		$this->Maneja_Papeleta->CurrentValue = $this->Maneja_Papeleta->FormValue;
		$this->Maneja_Activacion_Movi->CurrentValue = $this->Maneja_Activacion_Movi->FormValue;
		$this->Con_SIM->CurrentValue = $this->Con_SIM->FormValue;
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
		$this->FechaVenta->setDbValue($rs->fields('FechaVenta'));
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Descripcion_SIM->setDbValue($rs->fields('Descripcion_SIM'));
		$this->Reg_Venta_Movi->setDbValue($rs->fields('Reg_Venta_Movi'));
		$this->Monto_Recarga_Movi->setDbValue($rs->fields('Monto_Recarga_Movi'));
		$this->Folio_Recarga_Movi->setDbValue($rs->fields('Folio_Recarga_Movi'));
		$this->ImprimirNotaVenta->setDbValue($rs->fields('ImprimirNotaVenta'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Numero_NotaVenta->setDbValue($rs->fields('Numero_NotaVenta'));
		$this->Imprimirpapeleta->setDbValue($rs->fields('Imprimirpapeleta'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Venta_Eq")) <> "")
			$this->Id_Venta_Eq->CurrentValue = $this->getKey("Id_Venta_Eq"); // Id_Venta_Eq
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

		if ($this->Monto_Recarga_Movi->FormValue == $this->Monto_Recarga_Movi->CurrentValue && is_numeric(ew_StrToFloat($this->Monto_Recarga_Movi->CurrentValue)))
			$this->Monto_Recarga_Movi->CurrentValue = ew_StrToFloat($this->Monto_Recarga_Movi->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Venta_Eq
		// FechaVenta
		// Id_Tienda
		// Id_Tel_SIM
		// Id_Cliente
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Descripcion_SIM
		// Reg_Venta_Movi
		// Monto_Recarga_Movi
		// Folio_Recarga_Movi
		// ImprimirNotaVenta
		// Serie_NotaVenta
		// Numero_NotaVenta
		// Imprimirpapeleta
		// FolioImpresoPapeleta
		// Maneja_Papeleta
		// Maneja_Activacion_Movi
		// Con_SIM

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// FechaVenta
			$this->FechaVenta->ViewValue = $this->FechaVenta->CurrentValue;
			$this->FechaVenta->ViewValue = ew_FormatDateTime($this->FechaVenta->ViewValue, 7);
			$this->FechaVenta->ViewCustomAttributes = "";

			// Id_Tienda
			if (strval($this->Id_Tienda->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Tienda->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tienda->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Tienda->ViewValue = $this->Id_Tienda->CurrentValue;
				}
			} else {
				$this->Id_Tienda->ViewValue = NULL;
			}
			$this->Id_Tienda->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_disp_equipo_imprimir_docs_amigo_kit`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Cliente
			if (strval($this->Id_Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Cliente`" . ew_SearchString("=", $this->Id_Cliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Cliente`, `Nombre_Completo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_clientes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Cliente->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
				}
			} else {
				$this->Id_Cliente->ViewValue = NULL;
			}
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Descripcion_SIM
			$this->Descripcion_SIM->ViewValue = $this->Descripcion_SIM->CurrentValue;
			$this->Descripcion_SIM->ViewCustomAttributes = "";

			// Reg_Venta_Movi
			$this->Reg_Venta_Movi->ViewValue = $this->Reg_Venta_Movi->CurrentValue;
			$this->Reg_Venta_Movi->ViewCustomAttributes = "";

			// Monto_Recarga_Movi
			$this->Monto_Recarga_Movi->ViewValue = $this->Monto_Recarga_Movi->CurrentValue;
			$this->Monto_Recarga_Movi->ViewValue = ew_FormatCurrency($this->Monto_Recarga_Movi->ViewValue, 2, -2, -2, -2);
			$this->Monto_Recarga_Movi->ViewCustomAttributes = "";

			// Folio_Recarga_Movi
			$this->Folio_Recarga_Movi->ViewValue = $this->Folio_Recarga_Movi->CurrentValue;
			$this->Folio_Recarga_Movi->ViewCustomAttributes = "";

			// ImprimirNotaVenta
			if (strval($this->ImprimirNotaVenta->CurrentValue) <> "") {
				switch ($this->ImprimirNotaVenta->CurrentValue) {
					case $this->ImprimirNotaVenta->FldTagValue(1):
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(1) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(1) : $this->ImprimirNotaVenta->CurrentValue;
						break;
					case $this->ImprimirNotaVenta->FldTagValue(2):
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(2) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(2) : $this->ImprimirNotaVenta->CurrentValue;
						break;
					default:
						$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->CurrentValue;
				}
			} else {
				$this->ImprimirNotaVenta->ViewValue = NULL;
			}
			$this->ImprimirNotaVenta->ViewCustomAttributes = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->ViewValue = $this->Serie_NotaVenta->CurrentValue;
			$this->Serie_NotaVenta->ViewCustomAttributes = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->ViewValue = $this->Numero_NotaVenta->CurrentValue;
			$this->Numero_NotaVenta->ViewCustomAttributes = "";

			// Imprimirpapeleta
			if (strval($this->Imprimirpapeleta->CurrentValue) <> "") {
				switch ($this->Imprimirpapeleta->CurrentValue) {
					case $this->Imprimirpapeleta->FldTagValue(1):
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(1) <> "" ? $this->Imprimirpapeleta->FldTagCaption(1) : $this->Imprimirpapeleta->CurrentValue;
						break;
					case $this->Imprimirpapeleta->FldTagValue(2):
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(2) <> "" ? $this->Imprimirpapeleta->FldTagCaption(2) : $this->Imprimirpapeleta->CurrentValue;
						break;
					default:
						$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->CurrentValue;
				}
			} else {
				$this->Imprimirpapeleta->ViewValue = NULL;
			}
			$this->Imprimirpapeleta->ViewCustomAttributes = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
			$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->CurrentValue;
			$this->Maneja_Papeleta->ViewCustomAttributes = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
			$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

			// Con_SIM
			$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
			$this->Con_SIM->ViewCustomAttributes = "";

			// FechaVenta
			$this->FechaVenta->LinkCustomAttributes = "";
			$this->FechaVenta->HrefValue = "";
			$this->FechaVenta->TooltipValue = "";

			// Id_Tienda
			$this->Id_Tienda->LinkCustomAttributes = "";
			$this->Id_Tienda->HrefValue = "";
			$this->Id_Tienda->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Id_Cliente
			$this->Id_Cliente->LinkCustomAttributes = "";
			$this->Id_Cliente->HrefValue = "";
			$this->Id_Cliente->TooltipValue = "";

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

			// Descripcion_SIM
			$this->Descripcion_SIM->LinkCustomAttributes = "";
			$this->Descripcion_SIM->HrefValue = "";
			$this->Descripcion_SIM->TooltipValue = "";

			// Reg_Venta_Movi
			$this->Reg_Venta_Movi->LinkCustomAttributes = "";
			$this->Reg_Venta_Movi->HrefValue = "";
			$this->Reg_Venta_Movi->TooltipValue = "";

			// Monto_Recarga_Movi
			$this->Monto_Recarga_Movi->LinkCustomAttributes = "";
			$this->Monto_Recarga_Movi->HrefValue = "";
			$this->Monto_Recarga_Movi->TooltipValue = "";

			// Folio_Recarga_Movi
			$this->Folio_Recarga_Movi->LinkCustomAttributes = "";
			$this->Folio_Recarga_Movi->HrefValue = "";
			$this->Folio_Recarga_Movi->TooltipValue = "";

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->LinkCustomAttributes = "";
			$this->ImprimirNotaVenta->HrefValue = "";
			$this->ImprimirNotaVenta->TooltipValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->LinkCustomAttributes = "";
			$this->Serie_NotaVenta->HrefValue = "";
			$this->Serie_NotaVenta->TooltipValue = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->LinkCustomAttributes = "";
			$this->Numero_NotaVenta->HrefValue = "";
			$this->Numero_NotaVenta->TooltipValue = "";

			// Imprimirpapeleta
			$this->Imprimirpapeleta->LinkCustomAttributes = "";
			$this->Imprimirpapeleta->HrefValue = "";
			$this->Imprimirpapeleta->TooltipValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->LinkCustomAttributes = "";
			$this->FolioImpresoPapeleta->HrefValue = "";
			$this->FolioImpresoPapeleta->TooltipValue = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->LinkCustomAttributes = "";
			$this->Maneja_Papeleta->HrefValue = "";
			$this->Maneja_Papeleta->TooltipValue = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->LinkCustomAttributes = "";
			$this->Maneja_Activacion_Movi->HrefValue = "";
			$this->Maneja_Activacion_Movi->TooltipValue = "";

			// Con_SIM
			$this->Con_SIM->LinkCustomAttributes = "";
			$this->Con_SIM->HrefValue = "";
			$this->Con_SIM->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// FechaVenta
			$this->FechaVenta->EditCustomAttributes = "";
			$this->FechaVenta->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaVenta->CurrentValue, 7));

			// Id_Tienda
			$this->Id_Tienda->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Tienda->EditValue = $arwrk;

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_disp_equipo_imprimir_docs_amigo_kit`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Tel_SIM->EditValue = $arwrk;

			// Id_Cliente
			$this->Id_Cliente->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Cliente`, `Nombre_Completo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_clientes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Cliente->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "";
			$this->Num_ICCID->EditValue = ew_HtmlEncode($this->Num_ICCID->CurrentValue);

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "";
			$this->Num_CEL->EditValue = ew_HtmlEncode($this->Num_CEL->CurrentValue);

			// Descripcion_SIM
			$this->Descripcion_SIM->EditCustomAttributes = "";
			$this->Descripcion_SIM->EditValue = ew_HtmlEncode($this->Descripcion_SIM->CurrentValue);

			// Reg_Venta_Movi
			$this->Reg_Venta_Movi->EditCustomAttributes = "";
			$this->Reg_Venta_Movi->EditValue = ew_HtmlEncode($this->Reg_Venta_Movi->CurrentValue);

			// Monto_Recarga_Movi
			$this->Monto_Recarga_Movi->EditCustomAttributes = "";
			$this->Monto_Recarga_Movi->EditValue = ew_HtmlEncode($this->Monto_Recarga_Movi->CurrentValue);
			if (strval($this->Monto_Recarga_Movi->EditValue) <> "" && is_numeric($this->Monto_Recarga_Movi->EditValue)) $this->Monto_Recarga_Movi->EditValue = ew_FormatNumber($this->Monto_Recarga_Movi->EditValue, -2, -2, -2, -2);

			// Folio_Recarga_Movi
			$this->Folio_Recarga_Movi->EditCustomAttributes = "";
			$this->Folio_Recarga_Movi->EditValue = ew_HtmlEncode($this->Folio_Recarga_Movi->CurrentValue);

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->EditCustomAttributes = "onclick= 'ImprimirNota(this);' ";
			$arwrk = array();
			$arwrk[] = array($this->ImprimirNotaVenta->FldTagValue(1), $this->ImprimirNotaVenta->FldTagCaption(1) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(1) : $this->ImprimirNotaVenta->FldTagValue(1));
			$arwrk[] = array($this->ImprimirNotaVenta->FldTagValue(2), $this->ImprimirNotaVenta->FldTagCaption(2) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(2) : $this->ImprimirNotaVenta->FldTagValue(2));
			$this->ImprimirNotaVenta->EditValue = $arwrk;

			// Serie_NotaVenta
			$this->Serie_NotaVenta->EditCustomAttributes = "";
			$this->Serie_NotaVenta->EditValue = ew_HtmlEncode($this->Serie_NotaVenta->CurrentValue);

			// Numero_NotaVenta
			$this->Numero_NotaVenta->EditCustomAttributes = "";
			$this->Numero_NotaVenta->EditValue = ew_HtmlEncode($this->Numero_NotaVenta->CurrentValue);

			// Imprimirpapeleta
			$this->Imprimirpapeleta->EditCustomAttributes = "onclick= 'ImprimirPapeleta(this);' ";
			$arwrk = array();
			$arwrk[] = array($this->Imprimirpapeleta->FldTagValue(1), $this->Imprimirpapeleta->FldTagCaption(1) <> "" ? $this->Imprimirpapeleta->FldTagCaption(1) : $this->Imprimirpapeleta->FldTagValue(1));
			$arwrk[] = array($this->Imprimirpapeleta->FldTagValue(2), $this->Imprimirpapeleta->FldTagCaption(2) <> "" ? $this->Imprimirpapeleta->FldTagCaption(2) : $this->Imprimirpapeleta->FldTagValue(2));
			$this->Imprimirpapeleta->EditValue = $arwrk;

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->EditCustomAttributes = "onchange= 'ValidaFolioPapeleta(this);' ";
			$this->FolioImpresoPapeleta->EditValue = ew_HtmlEncode($this->FolioImpresoPapeleta->CurrentValue);

			// Maneja_Papeleta
			$this->Maneja_Papeleta->EditCustomAttributes = "";
			$this->Maneja_Papeleta->CurrentValue = "SI";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->EditCustomAttributes = "";
			$this->Maneja_Activacion_Movi->CurrentValue = "NO";

			// Con_SIM
			$this->Con_SIM->EditCustomAttributes = "";
			$this->Con_SIM->CurrentValue = "SIN CHIP";

			// Edit refer script
			// FechaVenta

			$this->FechaVenta->HrefValue = "";

			// Id_Tienda
			$this->Id_Tienda->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Id_Cliente
			$this->Id_Cliente->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Num_ICCID
			$this->Num_ICCID->HrefValue = "";

			// Num_CEL
			$this->Num_CEL->HrefValue = "";

			// Descripcion_SIM
			$this->Descripcion_SIM->HrefValue = "";

			// Reg_Venta_Movi
			$this->Reg_Venta_Movi->HrefValue = "";

			// Monto_Recarga_Movi
			$this->Monto_Recarga_Movi->HrefValue = "";

			// Folio_Recarga_Movi
			$this->Folio_Recarga_Movi->HrefValue = "";

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->HrefValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->HrefValue = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->HrefValue = "";

			// Imprimirpapeleta
			$this->Imprimirpapeleta->HrefValue = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->HrefValue = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->HrefValue = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->HrefValue = "";

			// Con_SIM
			$this->Con_SIM->HrefValue = "";
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
		if (!is_null($this->FechaVenta->FormValue) && $this->FechaVenta->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->FechaVenta->FldCaption());
		}
		if (!ew_CheckEuroDate($this->FechaVenta->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaVenta->FldErrMsg());
		}
		if (!is_null($this->Id_Tienda->FormValue) && $this->Id_Tienda->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Tienda->FldCaption());
		}
		if (!is_null($this->Num_IMEI->FormValue) && $this->Num_IMEI->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_IMEI->FldCaption());
		}
		if (!is_null($this->Num_ICCID->FormValue) && $this->Num_ICCID->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_ICCID->FldCaption());
		}
		if (!is_null($this->Num_CEL->FormValue) && $this->Num_CEL->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Num_CEL->FldCaption());
		}
		if (!ew_CheckNumber($this->Monto_Recarga_Movi->FormValue)) {
			ew_AddMessage($gsFormError, $this->Monto_Recarga_Movi->FldErrMsg());
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

		// FechaVenta
		$this->FechaVenta->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaVenta->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Id_Tienda
		$this->Id_Tienda->SetDbValueDef($rsnew, $this->Id_Tienda->CurrentValue, 0, FALSE);

		// Id_Tel_SIM
		$this->Id_Tel_SIM->SetDbValueDef($rsnew, $this->Id_Tel_SIM->CurrentValue, 0, strval($this->Id_Tel_SIM->CurrentValue) == "");

		// Id_Cliente
		$this->Id_Cliente->SetDbValueDef($rsnew, $this->Id_Cliente->CurrentValue, NULL, strval($this->Id_Cliente->CurrentValue) == "");

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, "", FALSE);

		// Num_ICCID
		$this->Num_ICCID->SetDbValueDef($rsnew, $this->Num_ICCID->CurrentValue, NULL, FALSE);

		// Num_CEL
		$this->Num_CEL->SetDbValueDef($rsnew, $this->Num_CEL->CurrentValue, NULL, FALSE);

		// Descripcion_SIM
		$this->Descripcion_SIM->SetDbValueDef($rsnew, $this->Descripcion_SIM->CurrentValue, NULL, FALSE);

		// Reg_Venta_Movi
		$this->Reg_Venta_Movi->SetDbValueDef($rsnew, $this->Reg_Venta_Movi->CurrentValue, NULL, FALSE);

		// Monto_Recarga_Movi
		$this->Monto_Recarga_Movi->SetDbValueDef($rsnew, $this->Monto_Recarga_Movi->CurrentValue, NULL, FALSE);

		// Folio_Recarga_Movi
		$this->Folio_Recarga_Movi->SetDbValueDef($rsnew, $this->Folio_Recarga_Movi->CurrentValue, NULL, FALSE);

		// ImprimirNotaVenta
		$this->ImprimirNotaVenta->SetDbValueDef($rsnew, $this->ImprimirNotaVenta->CurrentValue, NULL, FALSE);

		// Serie_NotaVenta
		$this->Serie_NotaVenta->SetDbValueDef($rsnew, $this->Serie_NotaVenta->CurrentValue, NULL, FALSE);

		// Numero_NotaVenta
		$this->Numero_NotaVenta->SetDbValueDef($rsnew, $this->Numero_NotaVenta->CurrentValue, NULL, FALSE);

		// Imprimirpapeleta
		$this->Imprimirpapeleta->SetDbValueDef($rsnew, $this->Imprimirpapeleta->CurrentValue, NULL, FALSE);

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->SetDbValueDef($rsnew, $this->FolioImpresoPapeleta->CurrentValue, NULL, FALSE);

		// Maneja_Papeleta
		$this->Maneja_Papeleta->SetDbValueDef($rsnew, $this->Maneja_Papeleta->CurrentValue, NULL, strval($this->Maneja_Papeleta->CurrentValue) == "");

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->SetDbValueDef($rsnew, $this->Maneja_Activacion_Movi->CurrentValue, NULL, strval($this->Maneja_Activacion_Movi->CurrentValue) == "");

		// Con_SIM
		$this->Con_SIM->SetDbValueDef($rsnew, $this->Con_SIM->CurrentValue, NULL, strval($this->Con_SIM->CurrentValue) == "");

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
			$this->Id_Venta_Eq->setDbValue($conn->Insert_ID());
			$rsnew['Id_Venta_Eq'] = $this->Id_Venta_Eq->DbValue;
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
if (!isset($cap_imprimir_docs_amigokit_add)) $cap_imprimir_docs_amigokit_add = new ccap_imprimir_docs_amigokit_add();

// Page init
$cap_imprimir_docs_amigokit_add->Page_Init();

// Page main
$cap_imprimir_docs_amigokit_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_imprimir_docs_amigokit_add = new ew_Page("cap_imprimir_docs_amigokit_add");
cap_imprimir_docs_amigokit_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_imprimir_docs_amigokit_add.PageID; // For backward compatibility

// Form object
var fcap_imprimir_docs_amigokitadd = new ew_Form("fcap_imprimir_docs_amigokitadd");

// Validate form
fcap_imprimir_docs_amigokitadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_FechaVenta"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->FechaVenta->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_FechaVenta"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->FechaVenta->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Tienda"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->Id_Tienda->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_IMEI"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->Num_IMEI->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_ICCID"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->Num_ICCID->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Num_CEL"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->Num_CEL->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Monto_Recarga_Movi"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_imprimir_docs_amigokit->Monto_Recarga_Movi->FldErrMsg()) ?>");

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
fcap_imprimir_docs_amigokitadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	//  Validar que si imprimeron papeleta, tengan que escribir el folio 

 	return true;  
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_imprimir_docs_amigokitadd.ValidateRequired = true;
<?php } else { ?>
fcap_imprimir_docs_amigokitadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Tienda"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Cliente"] = {"LinkField":"x_Id_Cliente","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre_Completo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_imprimir_docs_amigokit->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_imprimir_docs_amigokit->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_imprimir_docs_amigokit_add->ShowPageHeader(); ?>
<?php
$cap_imprimir_docs_amigokit_add->ShowMessage();
?>
<form name="fcap_imprimir_docs_amigokitadd" id="fcap_imprimir_docs_amigokitadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_imprimir_docs_amigokit">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_imprimir_docs_amigokitadd" class="ewTable">
<?php if ($cap_imprimir_docs_amigokit->FechaVenta->Visible) { // FechaVenta ?>
	<tr id="r_FechaVenta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_FechaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->FechaVenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->FechaVenta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_FechaVenta">
<input type="text" name="x_FechaVenta" id="x_FechaVenta" value="<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->FechaVenta->EditAttributes() ?>>
<?php if (!$cap_imprimir_docs_amigokit->FechaVenta->ReadOnly && !$cap_imprimir_docs_amigokit->FechaVenta->Disabled && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["readonly"] == "" && @$cap_imprimir_docs_amigokit->FechaVenta->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_imprimir_docs_amigokitadd$x_FechaVenta$" name="fcap_imprimir_docs_amigokitadd$x_FechaVenta$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_imprimir_docs_amigokitadd", "x_FechaVenta", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $cap_imprimir_docs_amigokit->FechaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Id_Tienda->Visible) { // Id_Tienda ?>
	<tr id="r_Id_Tienda"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Id_Tienda"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Tienda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Id_Tienda">
<select id="x_Id_Tienda" name="x_Id_Tienda"<?php echo $cap_imprimir_docs_amigokit->Id_Tienda->EditAttributes() ?>>
<?php
if (is_array($cap_imprimir_docs_amigokit->Id_Tienda->EditValue)) {
	$arwrk = $cap_imprimir_docs_amigokit->Id_Tienda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Id_Tienda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Tienda"].Options = <?php echo (is_array($cap_imprimir_docs_amigokit->Id_Tienda->EditValue)) ? ew_ArrayToJson($cap_imprimir_docs_amigokit->Id_Tienda->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_imprimir_docs_amigokit->Id_Tienda->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<tr id="r_Id_Tel_SIM"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Id_Tel_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Id_Tel_SIM">
<select id="x_Id_Tel_SIM" name="x_Id_Tel_SIM"<?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($cap_imprimir_docs_amigokit->Id_Tel_SIM->EditValue)) {
	$arwrk = $cap_imprimir_docs_amigokit->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_imprimir_docs_amigokit->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Tel_SIM"].Options = <?php echo (is_array($cap_imprimir_docs_amigokit->Id_Tel_SIM->EditValue)) ? ew_ArrayToJson($cap_imprimir_docs_amigokit->Id_Tel_SIM->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_imprimir_docs_amigokit->Id_Tel_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Id_Cliente->Visible) { // Id_Cliente ?>
	<tr id="r_Id_Cliente"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Id_Cliente"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Id_Cliente->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Id_Cliente">
<select id="x_Id_Cliente" name="x_Id_Cliente"<?php echo $cap_imprimir_docs_amigokit->Id_Cliente->EditAttributes() ?>>
<?php
if (is_array($cap_imprimir_docs_amigokit->Id_Cliente->EditValue)) {
	$arwrk = $cap_imprimir_docs_amigokit->Id_Cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Id_Cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_imprimir_docs_amigokitadd.Lists["x_Id_Cliente"].Options = <?php echo (is_array($cap_imprimir_docs_amigokit->Id_Cliente->EditValue)) ? ew_ArrayToJson($cap_imprimir_docs_amigokit->Id_Cliente->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_imprimir_docs_amigokit->Id_Cliente->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_IMEI->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Num_IMEI">
<input type="text" name="x_Num_IMEI" id="x_Num_IMEI" size="30" maxlength="30" value="<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Num_IMEI->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Num_ICCID->Visible) { // Num_ICCID ?>
	<tr id="r_Num_ICCID"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Num_ICCID"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_ICCID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Num_ICCID">
<input type="text" name="x_Num_ICCID" id="x_Num_ICCID" size="20" maxlength="22" value="<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Num_ICCID->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Num_ICCID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Num_CEL->Visible) { // Num_CEL ?>
	<tr id="r_Num_CEL"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Num_CEL"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Num_CEL->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Num_CEL->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Num_CEL">
<input type="text" name="x_Num_CEL" id="x_Num_CEL" size="30" maxlength="10" value="<?php echo $cap_imprimir_docs_amigokit->Num_CEL->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Num_CEL->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Num_CEL->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Descripcion_SIM->Visible) { // Descripcion_SIM ?>
	<tr id="r_Descripcion_SIM"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Descripcion_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Descripcion_SIM">
<input type="text" name="x_Descripcion_SIM" id="x_Descripcion_SIM" size="30" maxlength="50" value="<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Descripcion_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Reg_Venta_Movi->Visible) { // Reg_Venta_Movi ?>
	<tr id="r_Reg_Venta_Movi"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Reg_Venta_Movi"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Reg_Venta_Movi->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Reg_Venta_Movi->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Reg_Venta_Movi">
<input type="text" name="x_Reg_Venta_Movi" id="x_Reg_Venta_Movi" size="30" maxlength="20" value="<?php echo $cap_imprimir_docs_amigokit->Reg_Venta_Movi->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Reg_Venta_Movi->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Reg_Venta_Movi->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Monto_Recarga_Movi->Visible) { // Monto_Recarga_Movi ?>
	<tr id="r_Monto_Recarga_Movi"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Monto_Recarga_Movi"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Monto_Recarga_Movi->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Monto_Recarga_Movi->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Monto_Recarga_Movi">
<input type="text" name="x_Monto_Recarga_Movi" id="x_Monto_Recarga_Movi" size="5" value="<?php echo $cap_imprimir_docs_amigokit->Monto_Recarga_Movi->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Monto_Recarga_Movi->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Monto_Recarga_Movi->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Folio_Recarga_Movi->Visible) { // Folio_Recarga_Movi ?>
	<tr id="r_Folio_Recarga_Movi"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Folio_Recarga_Movi"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Folio_Recarga_Movi->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Folio_Recarga_Movi->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Folio_Recarga_Movi">
<input type="text" name="x_Folio_Recarga_Movi" id="x_Folio_Recarga_Movi" size="30" maxlength="10" value="<?php echo $cap_imprimir_docs_amigokit->Folio_Recarga_Movi->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Folio_Recarga_Movi->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Folio_Recarga_Movi->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->ImprimirNotaVenta->Visible) { // ImprimirNotaVenta ?>
	<tr id="r_ImprimirNotaVenta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_ImprimirNotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->ImprimirNotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->ImprimirNotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_ImprimirNotaVenta">
<div id="tp_x_ImprimirNotaVenta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_ImprimirNotaVenta" id="x_ImprimirNotaVenta" value="{value}"<?php echo $cap_imprimir_docs_amigokit->ImprimirNotaVenta->EditAttributes() ?>></div>
<div id="dsl_x_ImprimirNotaVenta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_imprimir_docs_amigokit->ImprimirNotaVenta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->ImprimirNotaVenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_ImprimirNotaVenta" id="x_ImprimirNotaVenta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_imprimir_docs_amigokit->ImprimirNotaVenta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_imprimir_docs_amigokit->ImprimirNotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
	<tr id="r_Serie_NotaVenta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Serie_NotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Serie_NotaVenta">
<input type="text" name="x_Serie_NotaVenta" id="x_Serie_NotaVenta" size="30" maxlength="2" value="<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Serie_NotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
	<tr id="r_Numero_NotaVenta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Numero_NotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Numero_NotaVenta">
<input type="text" name="x_Numero_NotaVenta" id="x_Numero_NotaVenta" size="30" maxlength="255" value="<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->Numero_NotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->Imprimirpapeleta->Visible) { // Imprimirpapeleta ?>
	<tr id="r_Imprimirpapeleta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_Imprimirpapeleta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->Imprimirpapeleta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->Imprimirpapeleta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_Imprimirpapeleta">
<div id="tp_x_Imprimirpapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Imprimirpapeleta" id="x_Imprimirpapeleta" value="{value}"<?php echo $cap_imprimir_docs_amigokit->Imprimirpapeleta->EditAttributes() ?>></div>
<div id="dsl_x_Imprimirpapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_imprimir_docs_amigokit->Imprimirpapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_docs_amigokit->Imprimirpapeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Imprimirpapeleta" id="x_Imprimirpapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_imprimir_docs_amigokit->Imprimirpapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_imprimir_docs_amigokit->Imprimirpapeleta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_docs_amigokit->FolioImpresoPapeleta->Visible) { // FolioImpresoPapeleta ?>
	<tr id="r_FolioImpresoPapeleta"<?php echo $cap_imprimir_docs_amigokit->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_docs_amigokit_FolioImpresoPapeleta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->CellAttributes() ?>><span id="el_cap_imprimir_docs_amigokit_FolioImpresoPapeleta">
<input type="text" name="x_FolioImpresoPapeleta" id="x_FolioImpresoPapeleta" size="10" maxlength="8" value="<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->EditValue ?>"<?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->EditAttributes() ?>>
</span><?php echo $cap_imprimir_docs_amigokit->FolioImpresoPapeleta->CustomMsg ?></td>
	</tr>
<?php } ?>
<input type="hidden" name="x_Maneja_Papeleta" id="x_Maneja_Papeleta" value="<?php echo ew_HtmlEncode($cap_imprimir_docs_amigokit->Maneja_Papeleta->CurrentValue) ?>">
<input type="hidden" name="x_Maneja_Activacion_Movi" id="x_Maneja_Activacion_Movi" value="<?php echo ew_HtmlEncode($cap_imprimir_docs_amigokit->Maneja_Activacion_Movi->CurrentValue) ?>">
<input type="hidden" name="x_Con_SIM" id="x_Con_SIM" value="<?php echo ew_HtmlEncode($cap_imprimir_docs_amigokit->Con_SIM->CurrentValue) ?>">
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_imprimir_docs_amigokitadd.Init();
</script>
<?php
$cap_imprimir_docs_amigokit_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_imprimir_docs_amigokit_add->Page_Terminate();
?>
