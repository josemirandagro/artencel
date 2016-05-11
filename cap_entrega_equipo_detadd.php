<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_equipo_detinfo.php" ?>
<?php include_once "ca_almacenesinfo.php" ?>
<?php include_once "cap_entrega_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_equipo_det_add = NULL; // Initialize page object first

class ccap_entrega_equipo_det_add extends ccap_entrega_equipo_det {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_equipo_det';

	// Page object name
	var $PageObjName = 'cap_entrega_equipo_det_add';

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

		// Table object (cap_entrega_equipo_det)
		if (!isset($GLOBALS["cap_entrega_equipo_det"])) {
			$GLOBALS["cap_entrega_equipo_det"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_equipo_det"];
		}

		// Table object (ca_almacenes)
		if (!isset($GLOBALS['ca_almacenes'])) $GLOBALS['ca_almacenes'] = new cca_almacenes();

		// Table object (cap_entrega_equipo)
		if (!isset($GLOBALS['cap_entrega_equipo'])) $GLOBALS['cap_entrega_equipo'] = new ccap_entrega_equipo();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_equipo_det', TRUE);

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
			$this->Page_Terminate("cap_entrega_equipo_detlist.php");
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id_Traspaso_Det"] != "") {
				$this->Id_Traspaso_Det->setQueryStringValue($_GET["Id_Traspaso_Det"]);
				$this->setKey("Id_Traspaso_Det", $this->Id_Traspaso_Det->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Traspaso_Det", ""); // Clear key
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
					$this->Page_Terminate("cap_entrega_equipo_detlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->GetAddUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_entrega_equipo_detview.php")
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
		$this->Id_Almacen_Recibe->CurrentValue = NULL;
		$this->Id_Almacen_Recibe->OldValue = $this->Id_Almacen_Recibe->CurrentValue;
		$this->Num_IMEI->CurrentValue = NULL;
		$this->Num_IMEI->OldValue = $this->Num_IMEI->CurrentValue;
		$this->Id_Tel_SIM->CurrentValue = NULL;
		$this->Id_Tel_SIM->OldValue = $this->Id_Tel_SIM->CurrentValue;
		$this->Fecha->CurrentValue = NULL;
		$this->Fecha->OldValue = $this->Fecha->CurrentValue;
		$this->Hora->CurrentValue = NULL;
		$this->Hora->OldValue = $this->Hora->CurrentValue;
		$this->Id_Almacen_Entrega->CurrentValue = NULL;
		$this->Id_Almacen_Entrega->OldValue = $this->Id_Almacen_Entrega->CurrentValue;
		$this->TipoArticulo->CurrentValue = NULL;
		$this->TipoArticulo->OldValue = $this->TipoArticulo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Almacen_Recibe->FldIsDetailKey) {
			$this->Id_Almacen_Recibe->setFormValue($objForm->GetValue("x_Id_Almacen_Recibe"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Id_Tel_SIM->FldIsDetailKey) {
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->Hora->FldIsDetailKey) {
			$this->Hora->setFormValue($objForm->GetValue("x_Hora"));
		}
		if (!$this->Id_Almacen_Entrega->FldIsDetailKey) {
			$this->Id_Almacen_Entrega->setFormValue($objForm->GetValue("x_Id_Almacen_Entrega"));
		}
		if (!$this->TipoArticulo->FldIsDetailKey) {
			$this->TipoArticulo->setFormValue($objForm->GetValue("x_TipoArticulo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Almacen_Recibe->CurrentValue = $this->Id_Almacen_Recibe->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->Hora->CurrentValue = $this->Hora->FormValue;
		$this->Id_Almacen_Entrega->CurrentValue = $this->Id_Almacen_Entrega->FormValue;
		$this->TipoArticulo->CurrentValue = $this->TipoArticulo->FormValue;
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
		$this->Id_Traspaso_Det->setDbValue($rs->fields('Id_Traspaso_Det'));
		$this->Id_Almacen_Recibe->setDbValue($rs->fields('Id_Almacen_Recibe'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Hora->setDbValue($rs->fields('Hora'));
		$this->Id_Almacen_Entrega->setDbValue($rs->fields('Id_Almacen_Entrega'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Traspaso_Det")) <> "")
			$this->Id_Traspaso_Det->CurrentValue = $this->getKey("Id_Traspaso_Det"); // Id_Traspaso_Det
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
		// Id_Traspaso_Det
		// Id_Almacen_Recibe
		// Num_IMEI
		// Id_Tel_SIM
		// Fecha
		// Hora
		// Id_Almacen_Entrega
		// TipoArticulo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Almacen_Recibe
			if (strval($this->Id_Almacen_Recibe->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Id_Almacen` NOT IN (1,".Id_Tienda_Actual().")";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
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

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(2,$this->Id_Tel_SIM) . $rswrk->fields('Disp3Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(3,$this->Id_Tel_SIM) . $rswrk->fields('Disp4Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Hora
			$this->Hora->ViewValue = $this->Hora->CurrentValue;
			$this->Hora->ViewCustomAttributes = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->ViewValue = $this->Id_Almacen_Entrega->CurrentValue;
			$this->Id_Almacen_Entrega->ViewCustomAttributes = "";

			// TipoArticulo
			if (strval($this->TipoArticulo->CurrentValue) <> "") {
				switch ($this->TipoArticulo->CurrentValue) {
					case $this->TipoArticulo->FldTagValue(1):
						$this->TipoArticulo->ViewValue = $this->TipoArticulo->FldTagCaption(1) <> "" ? $this->TipoArticulo->FldTagCaption(1) : $this->TipoArticulo->CurrentValue;
						break;
					case $this->TipoArticulo->FldTagValue(2):
						$this->TipoArticulo->ViewValue = $this->TipoArticulo->FldTagCaption(2) <> "" ? $this->TipoArticulo->FldTagCaption(2) : $this->TipoArticulo->CurrentValue;
						break;
					case $this->TipoArticulo->FldTagValue(3):
						$this->TipoArticulo->ViewValue = $this->TipoArticulo->FldTagCaption(3) <> "" ? $this->TipoArticulo->FldTagCaption(3) : $this->TipoArticulo->CurrentValue;
						break;
					default:
						$this->TipoArticulo->ViewValue = $this->TipoArticulo->CurrentValue;
				}
			} else {
				$this->TipoArticulo->ViewValue = NULL;
			}
			$this->TipoArticulo->ViewCustomAttributes = "";

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->LinkCustomAttributes = "";
			$this->Id_Almacen_Recibe->HrefValue = "";
			$this->Id_Almacen_Recibe->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Hora
			$this->Hora->LinkCustomAttributes = "";
			$this->Hora->HrefValue = "";
			$this->Hora->TooltipValue = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrega->HrefValue = "";
			$this->Id_Almacen_Entrega->TooltipValue = "";

			// TipoArticulo
			$this->TipoArticulo->LinkCustomAttributes = "";
			$this->TipoArticulo->HrefValue = "";
			$this->TipoArticulo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Almacen_Recibe
			$this->Id_Almacen_Recibe->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_almacenes`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Id_Almacen` NOT IN (1,".Id_Tienda_Actual().")";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if (!$GLOBALS["cap_entrega_equipo_det"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["ca_almacenes"]->AddUserIDFilter($sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Almacen_Recibe->EditValue = $arwrk;

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "onchange= 'Checa_IMEI_ent_eq(this);' ";
			$this->Num_IMEI->EditValue = ew_HtmlEncode($this->Num_IMEI->CurrentValue);

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "onfocus= 'Focus_Cliente(this);' ";
			if (trim(strval($this->Id_Tel_SIM->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Tel_SIM->EditValue = $arwrk;

			// Fecha
			// Hora
			// Id_Almacen_Entrega
			// TipoArticulo
			// Edit refer script
			// Id_Almacen_Recibe

			$this->Id_Almacen_Recibe->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Hora
			$this->Hora->HrefValue = "";

			// Id_Almacen_Entrega
			$this->Id_Almacen_Entrega->HrefValue = "";

			// TipoArticulo
			$this->TipoArticulo->HrefValue = "";
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
		if (!is_null($this->Id_Tel_SIM->FormValue) && $this->Id_Tel_SIM->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Tel_SIM->FldCaption());
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
		if ($this->Id_Tel_SIM->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Id_Tel_SIM = " . ew_AdjustSql($this->Id_Tel_SIM->CurrentValue) . ")";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Id_Tel_SIM->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Id_Tel_SIM->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe->SetDbValueDef($rsnew, $this->Id_Almacen_Recibe->CurrentValue, 0, FALSE);

		// Num_IMEI
		$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, FALSE);

		// Id_Tel_SIM
		$this->Id_Tel_SIM->SetDbValueDef($rsnew, $this->Id_Tel_SIM->CurrentValue, NULL, FALSE);

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha'] = &$this->Fecha->DbValue;

		// Hora
		$this->Hora->SetDbValueDef($rsnew, ew_CurrentTime(), NULL);
		$rsnew['Hora'] = &$this->Hora->DbValue;

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->SetDbValueDef($rsnew, Id_Tienda_Actual(), 0);
		$rsnew['Id_Almacen_Entrega'] = &$this->Id_Almacen_Entrega->DbValue;

		// TipoArticulo
		$this->TipoArticulo->SetDbValueDef($rsnew, 'Equipo', NULL);
		$rsnew['TipoArticulo'] = &$this->TipoArticulo->DbValue;

		// Id_Traspaso
		if ($this->Id_Traspaso->getSessionValue() <> "") {
			$rsnew['Id_Traspaso'] = $this->Id_Traspaso->getSessionValue();
		}

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
			$this->Id_Traspaso_Det->setDbValue($conn->Insert_ID());
			$rsnew['Id_Traspaso_Det'] = $this->Id_Traspaso_Det->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cap_entrega_equipo") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Traspaso"] <> "") {
					$GLOBALS["cap_entrega_equipo"]->Id_Traspaso->setQueryStringValue($_GET["Id_Traspaso"]);
					$this->Id_Traspaso->setQueryStringValue($GLOBALS["cap_entrega_equipo"]->Id_Traspaso->QueryStringValue);
					$this->Id_Traspaso->setSessionValue($this->Id_Traspaso->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_entrega_equipo"]->Id_Traspaso->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cap_entrega_equipo") {
				if ($this->Id_Traspaso->QueryStringValue == "") $this->Id_Traspaso->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
if (!isset($cap_entrega_equipo_det_add)) $cap_entrega_equipo_det_add = new ccap_entrega_equipo_det_add();

// Page init
$cap_entrega_equipo_det_add->Page_Init();

// Page main
$cap_entrega_equipo_det_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_entrega_equipo_det_add = new ew_Page("cap_entrega_equipo_det_add");
cap_entrega_equipo_det_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_entrega_equipo_det_add.PageID; // For backward compatibility

// Form object
var fcap_entrega_equipo_detadd = new ew_Form("fcap_entrega_equipo_detadd");

// Validate form
fcap_entrega_equipo_detadd.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_equipo_det->Id_Almacen_Recibe->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Tel_SIM"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_equipo_det->Id_Tel_SIM->FldCaption()) ?>");

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
fcap_entrega_equipo_detadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_equipo_detadd.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_equipo_detadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_equipo_detadd.Lists["x_Id_Almacen_Recibe"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_equipo_detadd.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":true,"DisplayFields":["x_EquipoAcabado","x_Num_IMEI","x_Status","x_Num_ICCID"],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.

/************************************************************************************
* Al capturar el IMEI, checa si el el equipo esta en la tienda usando como base el catalogo Id_Tel_SIM
***************************************************************************************/  

function Checa_IMEI_ent_eq(x)          
{  // Si llego aqui por que cambio el valor a ""                  

//   alert("LLAMADA DESDE " + x.id);                      
  // Vamos a checar aqui si el IMEI existe en la lista de equipos

   var Telefono = document.getElementById('x_Id_Tel_SIM'); 
   if (x.value=="") {
	 Telefono.options[-1].selected=true;  
	 return;            
   }     
   var Indice=-1;
   for (i=0;i<Telefono.length;i++) { 
	 var n=Telefono.options[i].text.split(",",4); // Separamos el letrero en 4 campos del arreglo "n" (OJO, a partir del primer campo,traen un espacio al inicio
	 if (n[1]==(" "+ x.value)) {      
	   Indice=i; // Comparamos el texto introducidao con el IMEI (Campo 1)
	   break;
	 }                    
   }  // for                                                                 

//   alert("Indice:--" + Indice + "--" + n[1] + "Status:" + n[2] );   
   if (Indice==-1) {  // Si no fue encontrado el IMEI                                                                                         
	 alert(" EL TELEFONO CON IMEI :" + x.value + " NO ESTA DISPONIBLE PARA ENTREGAR DESDE ESTE ALMACEN EN ESTA TIENDA");  
	 document.getElementById('x_Num_IMEI').value="";      
	 document.getElementById('x_Num_IMEI').focus();                          
   } else {   
	 if (n[2]==' Transito') {            
	   alert(" EL TELEFONO CON IMEI :" + x.value + " YA FUE REGISTRADO COMO ENVIADO");  
	   document.getElementById('x_Num_IMEI').value="";      
	   document.getElementById('x_Num_IMEI').focus();
	   Telefono.options[0].selected=true;  // lo marcamos como seleccionado en la lista
	   return;  
	 }  

	 // Si fue encotrado y NO ha sido ENVIADO
	 Telefono.options[Indice].selected=true;  // lo marcamos como seleccionado en la lista
	 document.getElementById('btnAction').focus(); // Pasamos el foco al boton de aceptar

//     document.getElementById(x_Id_Cliente).focus();  // Lo marcamos en 
   }   

//   alert("El valor fue encontrado en "+ Indice);              
}       
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_equipo_det->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_entrega_equipo_det->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_entrega_equipo_det_add->ShowPageHeader(); ?>
<?php
$cap_entrega_equipo_det_add->ShowMessage();
?>
<form name="fcap_entrega_equipo_detadd" id="fcap_entrega_equipo_detadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_entrega_equipo_det">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_equipo_detadd" class="ewTable">
<?php if ($cap_entrega_equipo_det->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
	<tr id="r_Id_Almacen_Recibe"<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_equipo_det_Id_Almacen_Recibe"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Id_Almacen_Recibe->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_equipo_det->Id_Almacen_Recibe->CellAttributes() ?>><span id="el_cap_entrega_equipo_det_Id_Almacen_Recibe">
<select id="x_Id_Almacen_Recibe" name="x_Id_Almacen_Recibe"<?php echo $cap_entrega_equipo_det->Id_Almacen_Recibe->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo_det->Id_Almacen_Recibe->EditValue)) {
	$arwrk = $cap_entrega_equipo_det->Id_Almacen_Recibe->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo_det->Id_Almacen_Recibe->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_entrega_equipo_detadd.Lists["x_Id_Almacen_Recibe"].Options = <?php echo (is_array($cap_entrega_equipo_det->Id_Almacen_Recibe->EditValue)) ? ew_ArrayToJson($cap_entrega_equipo_det->Id_Almacen_Recibe->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_entrega_equipo_det->Id_Almacen_Recibe->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_equipo_det->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_equipo_det_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_equipo_det->Num_IMEI->CellAttributes() ?>><span id="el_cap_entrega_equipo_det_Num_IMEI">
<input type="text" name="x_Num_IMEI" id="x_Num_IMEI" size="15" maxlength="15" value="<?php echo $cap_entrega_equipo_det->Num_IMEI->EditValue ?>"<?php echo $cap_entrega_equipo_det->Num_IMEI->EditAttributes() ?>>
</span><?php echo $cap_entrega_equipo_det->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_equipo_det->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<tr id="r_Id_Tel_SIM"<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_equipo_det_Id_Tel_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Id_Tel_SIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->CellAttributes() ?>><span id="el_cap_entrega_equipo_det_Id_Tel_SIM">
<?php $cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"]; ?>
<select id="x_Id_Tel_SIM" name="x_Id_Tel_SIM"<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo_det->Id_Tel_SIM->EditValue)) {
	$arwrk = $cap_entrega_equipo_det->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo_det->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][4] <> "") { ?>
<?php echo ew_ValueSeparator(3,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][4] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo`";
$sWhereWrk = "";
$lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
?>
<input type="hidden" name="s_x_Id_Tel_SIM" id="s_x_Id_Tel_SIM" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo_det->Id_Tel_SIM->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Tel_SIM` = {filter_value}"); ?>&t0=19">
<?php
$sSqlWrk = "SELECT `Num_IMEI` AS FIELD0 FROM `aux_sel_equipo`";
$sWhereWrk = "(`Id_Tel_SIM` = {query_value})";
$lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Id_Tel_SIM" id="sf_x_Id_Tel_SIM" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Id_Tel_SIM" id="ln_x_Id_Tel_SIM" value="x_Num_IMEI">
</span><?php echo $cap_entrega_equipo_det->Id_Tel_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<?php if (strval($cap_entrega_equipo_det->Id_Traspaso->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Id_Traspaso" id="x_Id_Traspaso" value="<?php echo ew_HtmlEncode(strval($cap_entrega_equipo_det->Id_Traspaso->getSessionValue())) ?>">
<?php } ?>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_entrega_equipo_detadd.Init();
</script>
<?php
$cap_entrega_equipo_det_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

document.getElementById('x_Id_Tel_SIM').style.backgroundColor="#DCDCDC";  // Lo ponemos en gris
document.getElementById('x_Id_Tel_SIM').style.display='block';  // Lo deshabilitamos 
document.getElementById('x_Num_IMEI').value="";
document.getElementById('x_Num_IMEI').focus();   
</script>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_equipo_det_add->Page_Terminate();
?>
