<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_def_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_def_equipos_add = NULL; // Initialize page object first

class ccap_def_equipos_add extends ccap_def_equipos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_def_equipos';

	// Page object name
	var $PageObjName = 'cap_def_equipos_add';

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

		// Table object (cap_def_equipos)
		if (!isset($GLOBALS["cap_def_equipos"])) {
			$GLOBALS["cap_def_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_def_equipos"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_def_equipos', TRUE);

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
			$this->Page_Terminate("cap_def_equiposlist.php");
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
			if (@$_GET["Id_Articulo"] != "") {
				$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);
				$this->setKey("Id_Articulo", $this->Id_Articulo->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Articulo", ""); // Clear key
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
					$this->Page_Terminate("cap_def_equiposlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_def_equiposview.php")
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
		$this->COD_Marca_eq->CurrentValue = NULL;
		$this->COD_Marca_eq->OldValue = $this->COD_Marca_eq->CurrentValue;
		$this->COD_Modelo_eq->CurrentValue = NULL;
		$this->COD_Modelo_eq->OldValue = $this->COD_Modelo_eq->CurrentValue;
		$this->COD_Compania_eq->CurrentValue = NULL;
		$this->COD_Compania_eq->OldValue = $this->COD_Compania_eq->CurrentValue;
		$this->Apodo_eq->CurrentValue = NULL;
		$this->Apodo_eq->OldValue = $this->Apodo_eq->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Articulo->CurrentValue = "TELEFONO";
		$this->Id_Almacen_Entrada->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->COD_Marca_eq->FldIsDetailKey) {
			$this->COD_Marca_eq->setFormValue($objForm->GetValue("x_COD_Marca_eq"));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue($objForm->GetValue("x_COD_Modelo_eq"));
		}
		if (!$this->COD_Compania_eq->FldIsDetailKey) {
			$this->COD_Compania_eq->setFormValue($objForm->GetValue("x_COD_Compania_eq"));
		}
		if (!$this->Apodo_eq->FldIsDetailKey) {
			$this->Apodo_eq->setFormValue($objForm->GetValue("x_Apodo_eq"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Id_Almacen_Entrada->FldIsDetailKey) {
			$this->Id_Almacen_Entrada->setFormValue($objForm->GetValue("x_Id_Almacen_Entrada"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->COD_Marca_eq->CurrentValue = $this->COD_Marca_eq->FormValue;
		$this->COD_Modelo_eq->CurrentValue = $this->COD_Modelo_eq->FormValue;
		$this->COD_Compania_eq->CurrentValue = $this->COD_Compania_eq->FormValue;
		$this->Apodo_eq->CurrentValue = $this->Apodo_eq->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Id_Almacen_Entrada->CurrentValue = $this->Id_Almacen_Entrada->FormValue;
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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Apodo_eq->setDbValue($rs->fields('Apodo_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Articulo")) <> "")
			$this->Id_Articulo->CurrentValue = $this->getKey("Id_Articulo"); // Id_Articulo
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
		// Id_Articulo
		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq
		// Apodo_eq
		// Status
		// Codigo
		// Articulo
		// Id_Almacen_Entrada

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// COD_Marca_eq
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->ViewValue = NULL;
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->ViewValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->ViewValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Apodo_eq
			$this->Apodo_eq->ViewValue = $this->Apodo_eq->CurrentValue;
			$this->Apodo_eq->ViewCustomAttributes = "";

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

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Id_Almacen_Entrada
			if (strval($this->Id_Almacen_Entrada->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrada->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Entrada->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Entrada->ViewValue = $this->Id_Almacen_Entrada->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Entrada->ViewValue = NULL;
			}
			$this->Id_Almacen_Entrada->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";

			// Apodo_eq
			$this->Apodo_eq->LinkCustomAttributes = "";
			$this->Apodo_eq->HrefValue = "";
			$this->Apodo_eq->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "onchange= 'ActualizaCodigo_Equipo(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_eq->EditValue = $arwrk;

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "onchange= 'ActualizaCodigo_Equipo(this);' ";
			$this->COD_Modelo_eq->EditValue = ew_HtmlEncode($this->COD_Modelo_eq->CurrentValue);

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "onchange= 'ActualizaCodigo_Equipo(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Compania_eq->EditValue = $arwrk;

			// Apodo_eq
			$this->Apodo_eq->EditCustomAttributes = "onchange= 'ActualizaCodigo_Equipo(this);' ";
			$this->Apodo_eq->EditValue = ew_HtmlEncode($this->Apodo_eq->CurrentValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "onFocus='NoEditarCodigoEquipo(this);' ";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Edit refer script
			// COD_Marca_eq

			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Apodo_eq
			$this->Apodo_eq->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->HrefValue = "";
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
		if (!is_null($this->COD_Marca_eq->FormValue) && $this->COD_Marca_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Marca_eq->FldCaption());
		}
		if (!is_null($this->COD_Modelo_eq->FormValue) && $this->COD_Modelo_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Modelo_eq->FldCaption());
		}
		if (!is_null($this->COD_Compania_eq->FormValue) && $this->COD_Compania_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Compania_eq->FldCaption());
		}
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
		}
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
		}
		if (!is_null($this->Id_Almacen_Entrada->FormValue) && $this->Id_Almacen_Entrada->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Almacen_Entrada->FldCaption());
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
		if ($this->Codigo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Codigo = '" . ew_AdjustSql($this->Codigo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Codigo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Codigo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
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

		// COD_Marca_eq
		$this->COD_Marca_eq->SetDbValueDef($rsnew, $this->COD_Marca_eq->CurrentValue, NULL, FALSE);

		// COD_Modelo_eq
		$this->COD_Modelo_eq->SetDbValueDef($rsnew, $this->COD_Modelo_eq->CurrentValue, NULL, FALSE);

		// COD_Compania_eq
		$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, FALSE);

		// Apodo_eq
		$this->Apodo_eq->SetDbValueDef($rsnew, $this->Apodo_eq->CurrentValue, NULL, FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, strval($this->Id_Almacen_Entrada->CurrentValue) == "");

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
			$this->Id_Articulo->setDbValue($conn->Insert_ID());
			$rsnew['Id_Articulo'] = $this->Id_Articulo->DbValue;
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
if (!isset($cap_def_equipos_add)) $cap_def_equipos_add = new ccap_def_equipos_add();

// Page init
$cap_def_equipos_add->Page_Init();

// Page main
$cap_def_equipos_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_def_equipos_add = new ew_Page("cap_def_equipos_add");
cap_def_equipos_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_def_equipos_add.PageID; // For backward compatibility

// Form object
var fcap_def_equiposadd = new ew_Form("fcap_def_equiposadd");

// Validate form
fcap_def_equiposadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_COD_Marca_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->COD_Marca_eq->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_COD_Modelo_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->COD_Modelo_eq->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_COD_Compania_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->COD_Compania_eq->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Almacen_Entrada"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_equipos->Id_Almacen_Entrada->FldCaption()) ?>");

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
fcap_def_equiposadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_equiposadd.ValidateRequired = true;
<?php } else { ?>
fcap_def_equiposadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_def_equiposadd.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_equiposadd.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_equiposadd.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

function ActualizaCodigo_Articulo(x)
{                                                               
   var Marca = document.getElementById('x_COD_Marca_eq');                             
   var Compania = document.getElementById('x_COD_Compania_eq');
   var Modelo = document.getElementById('x_COD_Modelo_eq');
   Modelo.value = Modelo.value.toUpperCase(); // Lo pasamos a Mayusculas
   Modelo.value = Modelo.value.replace(/\s/g,'');  // Le quitamos todos los espacios, Modelo no puede llevar espacios, puede llevar guinoes
   document.getElementById('x_Apodo_eq').value=document.getElementById('x_Apodo_eq').value.toUpperCase();
   var Apodo = document.getElementById('x_Apodo_eq').value;                                                
   var xCodigo = document.getElementById('x_Codigo');
   var xArticulo = document.getElementById('x_Articulo');

//  Llenamos el Codigo con los valores de los catalogos y el modelo                            
   xCodigo.value=Marca.value + Modelo.value + Compania.options[Compania.selectedIndex].value;

/*  Vamos a quitar las Z en el codigo, nomas estorban, el codigo el cel nunca se va a escanear

//  Lo ajustamos a 9 digitos llenando el final con Z
   while (xCodigo.value.length<9){  
	xCodigo.value=xCodigo.value+'z';
   } // While    
*/                          

//  LO pasamos a mayusculas
   xCodigo.value=xCodigo.value.toUpperCase();

//  Llenamos el Articulo con los valores de los catalogos                                                                    
   var Articulo=Marca.options[Marca.selectedIndex].text;
   Articulo += " " + Modelo.value;                       
   Articulo += " " + Apodo;                                
   Articulo += " (" + Compania.options[Compania.selectedIndex].text +")";   
   Articulo=Articulo.replace("   "," "); // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo   
   Articulo=Articulo.replace("  "," ");  // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo 
   xArticulo.value=Articulo;      
}                                
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_def_equipos->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_def_equipos->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_def_equipos_add->ShowPageHeader(); ?>
<?php
$cap_def_equipos_add->ShowMessage();
?>
<form name="fcap_def_equiposadd" id="fcap_def_equiposadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_def_equipos">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_def_equiposadd" class="ewTable">
<?php if ($cap_def_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<tr id="r_COD_Marca_eq"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_COD_Marca_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Marca_eq->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->COD_Marca_eq->CellAttributes() ?>><span id="el_cap_def_equipos_COD_Marca_eq">
<select id="x_COD_Marca_eq" name="x_COD_Marca_eq"<?php echo $cap_def_equipos->COD_Marca_eq->EditAttributes() ?>>
<?php
if (is_array($cap_def_equipos->COD_Marca_eq->EditValue)) {
	$arwrk = $cap_def_equipos->COD_Marca_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_equipos->COD_Marca_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php if (AllowAdd(CurrentProjectID() . "me_marca_equipo")) { ?>
&nbsp;<a id="aol_x_COD_Marca_eq" class="ewLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({frm:ewForms['fcap_def_equiposadd'],lnk:this,el:'x_COD_Marca_eq',url:'me_marca_equipoaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $cap_def_equipos->COD_Marca_eq->FldCaption() ?></a>
<?php } ?>
<script type="text/javascript">
fcap_def_equiposadd.Lists["x_COD_Marca_eq"].Options = <?php echo (is_array($cap_def_equipos->COD_Marca_eq->EditValue)) ? ew_ArrayToJson($cap_def_equipos->COD_Marca_eq->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_equipos->COD_Marca_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<tr id="r_COD_Modelo_eq"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_COD_Modelo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Modelo_eq->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->COD_Modelo_eq->CellAttributes() ?>><span id="el_cap_def_equipos_COD_Modelo_eq">
<input type="text" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" size="6" maxlength="6" value="<?php echo $cap_def_equipos->COD_Modelo_eq->EditValue ?>"<?php echo $cap_def_equipos->COD_Modelo_eq->EditAttributes() ?>>
</span><?php echo $cap_def_equipos->COD_Modelo_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<tr id="r_COD_Compania_eq"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_COD_Compania_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Compania_eq->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->COD_Compania_eq->CellAttributes() ?>><span id="el_cap_def_equipos_COD_Compania_eq">
<select id="x_COD_Compania_eq" name="x_COD_Compania_eq"<?php echo $cap_def_equipos->COD_Compania_eq->EditAttributes() ?>>
<?php
if (is_array($cap_def_equipos->COD_Compania_eq->EditValue)) {
	$arwrk = $cap_def_equipos->COD_Compania_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_equipos->COD_Compania_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_equiposadd.Lists["x_COD_Compania_eq"].Options = <?php echo (is_array($cap_def_equipos->COD_Compania_eq->EditValue)) ? ew_ArrayToJson($cap_def_equipos->COD_Compania_eq->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_equipos->COD_Compania_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->Apodo_eq->Visible) { // Apodo_eq ?>
	<tr id="r_Apodo_eq"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_Apodo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Apodo_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->Apodo_eq->CellAttributes() ?>><span id="el_cap_def_equipos_Apodo_eq">
<input type="text" name="x_Apodo_eq" id="x_Apodo_eq" size="20" maxlength="20" value="<?php echo $cap_def_equipos->Apodo_eq->EditValue ?>"<?php echo $cap_def_equipos->Apodo_eq->EditAttributes() ?>>
</span><?php echo $cap_def_equipos->Apodo_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->Codigo->Visible) { // Codigo ?>
	<tr id="r_Codigo"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Codigo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->Codigo->CellAttributes() ?>><span id="el_cap_def_equipos_Codigo">
<input type="text" name="x_Codigo" id="x_Codigo" size="25" maxlength="22" value="<?php echo $cap_def_equipos->Codigo->EditValue ?>"<?php echo $cap_def_equipos->Codigo->EditAttributes() ?>>
</span><?php echo $cap_def_equipos->Codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->Articulo->Visible) { // Articulo ?>
	<tr id="r_Articulo"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->Articulo->CellAttributes() ?>><span id="el_cap_def_equipos_Articulo">
<input type="text" name="x_Articulo" id="x_Articulo" size="60" maxlength="100" value="<?php echo $cap_def_equipos->Articulo->EditValue ?>"<?php echo $cap_def_equipos->Articulo->EditAttributes() ?>>
</span><?php echo $cap_def_equipos->Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_equipos->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
	<tr id="r_Id_Almacen_Entrada"<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_equipos_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Id_Almacen_Entrada->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_equipos->Id_Almacen_Entrada->CellAttributes() ?>><span id="el_cap_def_equipos_Id_Almacen_Entrada">
<select id="x_Id_Almacen_Entrada" name="x_Id_Almacen_Entrada"<?php echo $cap_def_equipos->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($cap_def_equipos->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $cap_def_equipos->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_equipos->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_equiposadd.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($cap_def_equipos->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($cap_def_equipos->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_equipos->Id_Almacen_Entrada->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_def_equiposadd.Init();
</script>
<?php
$cap_def_equipos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

document.getElementById('x_Codigo').style.backgroundColor="#DCDCDC";
document.getElementById('x_Codigo').style.display='block';
</script>
<?php include_once "footer.php" ?>
<?php
$cap_def_equipos_add->Page_Terminate();
?>
