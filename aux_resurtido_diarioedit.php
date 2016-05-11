<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "aux_resurtido_diarioinfo.php" ?>
<?php include_once "ca_almacenesinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$aux_resurtido_diario_edit = NULL; // Initialize page object first

class caux_resurtido_diario_edit extends caux_resurtido_diario {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'aux_resurtido_diario';

	// Page object name
	var $PageObjName = 'aux_resurtido_diario_edit';

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

		// Table object (aux_resurtido_diario)
		if (!isset($GLOBALS["aux_resurtido_diario"])) {
			$GLOBALS["aux_resurtido_diario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aux_resurtido_diario"];
		}

		// Table object (ca_almacenes)
		if (!isset($GLOBALS['ca_almacenes'])) $GLOBALS['ca_almacenes'] = new cca_almacenes();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'aux_resurtido_diario', TRUE);

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
			$this->Page_Terminate("aux_resurtido_diariolist.php");
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
		if (@$_GET["Id"] <> "")
			$this->Id->setQueryStringValue($_GET["Id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id->CurrentValue == "")
			$this->Page_Terminate("aux_resurtido_diariolist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("aux_resurtido_diariolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "aux_resurtido_diarioview.php")
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
		if (!$this->Id_Almacen->FldIsDetailKey) {
			$this->Id_Almacen->setFormValue($objForm->GetValue("x_Id_Almacen"));
		}
		if (!$this->Num_IMEI->FldIsDetailKey) {
			$this->Num_IMEI->setFormValue($objForm->GetValue("x_Num_IMEI"));
		}
		if (!$this->Id_Tel_SIM->FldIsDetailKey) {
			$this->Id_Tel_SIM->setFormValue($objForm->GetValue("x_Id_Tel_SIM"));
		}
		if (!$this->Tipo->FldIsDetailKey) {
			$this->Tipo->setFormValue($objForm->GetValue("x_Tipo"));
		}
		if (!$this->Disponibles->FldIsDetailKey) {
			$this->Disponibles->setFormValue($objForm->GetValue("x_Disponibles"));
		}
		if (!$this->Id->FldIsDetailKey)
			$this->Id->setFormValue($objForm->GetValue("x_Id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id->CurrentValue = $this->Id->FormValue;
		$this->Id_Almacen->CurrentValue = $this->Id_Almacen->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Tipo->CurrentValue = $this->Tipo->FormValue;
		$this->Disponibles->CurrentValue = $this->Disponibles->FormValue;
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
		$this->Id->setDbValue($rs->fields('Id'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Tipo->setDbValue($rs->fields('Tipo'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Disponibles->setDbValue($rs->fields('Disponibles'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id
		// Id_Articulo
		// Id_Acabado_eq
		// Id_Almacen
		// Num_IMEI
		// Id_Tel_SIM
		// Id_Traspaso
		// Tipo
		// Fecha
		// Disponibles

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Almacen
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->ViewValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Num_IMEI
			if (strval($this->Num_IMEI->CurrentValue) <> "") {
				$sFilterWrk = "`Num_IMEI`" . ew_SearchString("=", $this->Num_IMEI->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Num_IMEI`, `Num_IMEI` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_trasp_tel_sim`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Almacen'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Num_IMEI->ViewValue = $rswrk->fields('DispFld');
					$this->Num_IMEI->ViewValue .= ew_ValueSeparator(1,$this->Num_IMEI) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
				}
			} else {
				$this->Num_IMEI->ViewValue = NULL;
			}
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, `Num_CEL` AS `Disp4Fld` FROM `aux_sel_existencia_equipos_sims`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
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

			// Tipo
			if (strval($this->Tipo->CurrentValue) <> "") {
				switch ($this->Tipo->CurrentValue) {
					case $this->Tipo->FldTagValue(1):
						$this->Tipo->ViewValue = $this->Tipo->FldTagCaption(1) <> "" ? $this->Tipo->FldTagCaption(1) : $this->Tipo->CurrentValue;
						break;
					case $this->Tipo->FldTagValue(2):
						$this->Tipo->ViewValue = $this->Tipo->FldTagCaption(2) <> "" ? $this->Tipo->FldTagCaption(2) : $this->Tipo->CurrentValue;
						break;
					default:
						$this->Tipo->ViewValue = $this->Tipo->CurrentValue;
				}
			} else {
				$this->Tipo->ViewValue = NULL;
			}
			$this->Tipo->ViewCustomAttributes = "";

			// Disponibles
			$this->Disponibles->ViewValue = $this->Disponibles->CurrentValue;
			$this->Disponibles->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->LinkCustomAttributes = "";
			$this->Id_Almacen->HrefValue = "";
			$this->Id_Almacen->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Tipo
			$this->Tipo->LinkCustomAttributes = "";
			$this->Tipo->HrefValue = "";
			$this->Tipo->TooltipValue = "";

			// Disponibles
			$this->Disponibles->LinkCustomAttributes = "";
			$this->Disponibles->HrefValue = "";
			$this->Disponibles->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Almacen
			$this->Id_Almacen->EditCustomAttributes = "";
			if (strval($this->Id_Almacen->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen->EditValue = $this->Id_Almacen->CurrentValue;
				}
			} else {
				$this->Id_Almacen->EditValue = NULL;
			}
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			if (trim(strval($this->Num_IMEI->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Num_IMEI`" . ew_SearchString("=", $this->Num_IMEI->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `Num_IMEI`, `Num_IMEI` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Articulo` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_trasp_tel_sim`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Almacen'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Num_IMEI->EditValue = $arwrk;

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "onFocus='PonFocusIMEI(this);'  ";
			if (trim(strval($this->Id_Tel_SIM->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, `Num_CEL` AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_existencia_equipos_sims`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Tel_SIM->EditValue = $arwrk;

			// Tipo
			$this->Tipo->EditCustomAttributes = "";
			if (strval($this->Tipo->CurrentValue) <> "") {
				switch ($this->Tipo->CurrentValue) {
					case $this->Tipo->FldTagValue(1):
						$this->Tipo->EditValue = $this->Tipo->FldTagCaption(1) <> "" ? $this->Tipo->FldTagCaption(1) : $this->Tipo->CurrentValue;
						break;
					case $this->Tipo->FldTagValue(2):
						$this->Tipo->EditValue = $this->Tipo->FldTagCaption(2) <> "" ? $this->Tipo->FldTagCaption(2) : $this->Tipo->CurrentValue;
						break;
					default:
						$this->Tipo->EditValue = $this->Tipo->CurrentValue;
				}
			} else {
				$this->Tipo->EditValue = NULL;
			}
			$this->Tipo->ViewCustomAttributes = "";

			// Disponibles
			$this->Disponibles->EditCustomAttributes = "";
			$this->Disponibles->EditValue = $this->Disponibles->CurrentValue;
			$this->Disponibles->ViewCustomAttributes = "";

			// Edit refer script
			// Id_Almacen

			$this->Id_Almacen->HrefValue = "";

			// Num_IMEI
			$this->Num_IMEI->HrefValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->HrefValue = "";

			// Tipo
			$this->Tipo->HrefValue = "";

			// Disponibles
			$this->Disponibles->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
			if ($this->Id_Tel_SIM->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Id_Tel_SIM` = " . ew_AdjustSql($this->Id_Tel_SIM->CurrentValue) . ")";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Id_Tel_SIM->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Id_Tel_SIM->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// Num_IMEI
			$this->Num_IMEI->SetDbValueDef($rsnew, $this->Num_IMEI->CurrentValue, NULL, $this->Num_IMEI->ReadOnly);

			// Id_Tel_SIM
			$this->Id_Tel_SIM->SetDbValueDef($rsnew, $this->Id_Tel_SIM->CurrentValue, 0, $this->Id_Tel_SIM->ReadOnly);

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
if (!isset($aux_resurtido_diario_edit)) $aux_resurtido_diario_edit = new caux_resurtido_diario_edit();

// Page init
$aux_resurtido_diario_edit->Page_Init();

// Page main
$aux_resurtido_diario_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var aux_resurtido_diario_edit = new ew_Page("aux_resurtido_diario_edit");
aux_resurtido_diario_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = aux_resurtido_diario_edit.PageID; // For backward compatibility

// Form object
var faux_resurtido_diarioedit = new ew_Form("faux_resurtido_diarioedit");

// Validate form
faux_resurtido_diarioedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Tel_SIM"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_resurtido_diario->Id_Tel_SIM->FldCaption()) ?>");

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
faux_resurtido_diarioedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_resurtido_diarioedit.ValidateRequired = true;
<?php } else { ?>
faux_resurtido_diarioedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faux_resurtido_diarioedit.Lists["x_Id_Almacen"] = {"LinkField":"x_Id_Almacen","Ajax":true,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faux_resurtido_diarioedit.Lists["x_Num_IMEI"] = {"LinkField":"x_Num_IMEI","Ajax":true,"AutoFill":true,"DisplayFields":["x_Num_IMEI","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faux_resurtido_diarioedit.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","x_Num_ICCID","x_Num_CEL"],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $aux_resurtido_diario->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $aux_resurtido_diario->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $aux_resurtido_diario_edit->ShowPageHeader(); ?>
<?php
$aux_resurtido_diario_edit->ShowMessage();
?>
<form name="faux_resurtido_diarioedit" id="faux_resurtido_diarioedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="aux_resurtido_diario">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_aux_resurtido_diarioedit" class="ewTable">
<?php if ($aux_resurtido_diario->Id_Almacen->Visible) { // Id_Almacen ?>
	<tr id="r_Id_Almacen"<?php echo $aux_resurtido_diario->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_aux_resurtido_diario_Id_Almacen"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Almacen->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $aux_resurtido_diario->Id_Almacen->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Almacen">
<span<?php echo $aux_resurtido_diario->Id_Almacen->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Almacen->EditValue ?></span>
<input type="hidden" name="x_Id_Almacen" id="x_Id_Almacen" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id_Almacen->CurrentValue) ?>">
</span><?php echo $aux_resurtido_diario->Id_Almacen->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $aux_resurtido_diario->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_aux_resurtido_diario_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $aux_resurtido_diario->Num_IMEI->CellAttributes() ?>><span id="el_aux_resurtido_diario_Num_IMEI">
<?php $aux_resurtido_diario->Num_IMEI->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$aux_resurtido_diario->Num_IMEI->EditAttrs["onchange"]; ?>
<select id="x_Num_IMEI" name="x_Num_IMEI"<?php echo $aux_resurtido_diario->Num_IMEI->EditAttributes() ?>>
<?php
if (is_array($aux_resurtido_diario->Num_IMEI->EditValue)) {
	$arwrk = $aux_resurtido_diario->Num_IMEI->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($aux_resurtido_diario->Num_IMEI->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$aux_resurtido_diario->Num_IMEI) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `Num_IMEI`, `Num_IMEI` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_trasp_tel_sim`";
$sWhereWrk = "";
$lookuptblfilter = "Status='Almacen'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Num_IMEI`";
?>
<input type="hidden" name="s_x_Num_IMEI" id="s_x_Num_IMEI" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($aux_resurtido_diario->Num_IMEI->LookupFn) ?>&f0=<?php echo TEAencrypt("undefined"); ?>&t0=undefined">
<?php
$sSqlWrk = "SELECT `Id_Tel_SIM` AS FIELD0 FROM `aux_sel_trasp_tel_sim`";
$sWhereWrk = "(`Num_IMEI` = '{query_value}')";
$lookuptblfilter = "Status='Almacen'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Num_IMEI`";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Num_IMEI" id="sf_x_Num_IMEI" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Num_IMEI" id="ln_x_Num_IMEI" value="x_Id_Tel_SIM">
</span><?php echo $aux_resurtido_diario->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<tr id="r_Id_Tel_SIM"<?php echo $aux_resurtido_diario->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_aux_resurtido_diario_Id_Tel_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Tel_SIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $aux_resurtido_diario->Id_Tel_SIM->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Tel_SIM">
<select id="x_Id_Tel_SIM" name="x_Id_Tel_SIM"<?php echo $aux_resurtido_diario->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($aux_resurtido_diario->Id_Tel_SIM->EditValue)) {
	$arwrk = $aux_resurtido_diario->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($aux_resurtido_diario->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$aux_resurtido_diario->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$aux_resurtido_diario->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][4] <> "") { ?>
<?php echo ew_ValueSeparator(3,$aux_resurtido_diario->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][4] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, `Num_CEL` AS `Disp4Fld` FROM `aux_sel_existencia_equipos_sims`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo`";
?>
<input type="hidden" name="s_x_Id_Tel_SIM" id="s_x_Id_Tel_SIM" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($aux_resurtido_diario->Id_Tel_SIM->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Tel_SIM` = {filter_value}"); ?>&t0=19">
</span><?php echo $aux_resurtido_diario->Id_Tel_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Tipo->Visible) { // Tipo ?>
	<tr id="r_Tipo"<?php echo $aux_resurtido_diario->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_aux_resurtido_diario_Tipo"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Tipo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $aux_resurtido_diario->Tipo->CellAttributes() ?>><span id="el_aux_resurtido_diario_Tipo">
<span<?php echo $aux_resurtido_diario->Tipo->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Tipo->EditValue ?></span>
<input type="hidden" name="x_Tipo" id="x_Tipo" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Tipo->CurrentValue) ?>">
</span><?php echo $aux_resurtido_diario->Tipo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Disponibles->Visible) { // Disponibles ?>
	<tr id="r_Disponibles"<?php echo $aux_resurtido_diario->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_aux_resurtido_diario_Disponibles"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Disponibles->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $aux_resurtido_diario->Disponibles->CellAttributes() ?>><span id="el_aux_resurtido_diario_Disponibles">
<span<?php echo $aux_resurtido_diario->Disponibles->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Disponibles->EditValue ?></span>
<input type="hidden" name="x_Disponibles" id="x_Disponibles" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Disponibles->CurrentValue) ?>">
</span><?php echo $aux_resurtido_diario->Disponibles->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_Id" id="x_Id" value="<?php echo ew_HtmlEncode($aux_resurtido_diario->Id->CurrentValue) ?>">
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
faux_resurtido_diarioedit.Init();
</script>
<?php
$aux_resurtido_diario_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
// Inhibimos la edicion del Articulo, lo dejamos solo para mostrar                                                

document.getElementById('x_Id_Tel_SIM').style.backgroundColor="#DCDCDC";  // Lo ponemos en gris
document.getElementById('x_Id_Tel_SIM').style.display='block';  // Lo deshabilitamos 
</script>
<?php include_once "footer.php" ?>
<?php
$aux_resurtido_diario_edit->Page_Terminate();
?>
