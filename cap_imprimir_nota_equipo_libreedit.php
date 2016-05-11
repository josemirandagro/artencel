<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_imprimir_nota_equipo_libreinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_imprimir_nota_equipo_libre_edit = NULL; // Initialize page object first

class ccap_imprimir_nota_equipo_libre_edit extends ccap_imprimir_nota_equipo_libre {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_imprimir_nota_equipo_libre';

	// Page object name
	var $PageObjName = 'cap_imprimir_nota_equipo_libre_edit';

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

		// Table object (cap_imprimir_nota_equipo_libre)
		if (!isset($GLOBALS["cap_imprimir_nota_equipo_libre"])) {
			$GLOBALS["cap_imprimir_nota_equipo_libre"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_imprimir_nota_equipo_libre"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_imprimir_nota_equipo_libre', TRUE);

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
			$this->Page_Terminate("cap_imprimir_nota_equipo_librelist.php");
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
		if (@$_GET["Id_Tel_SIM"] <> "")
			$this->Id_Tel_SIM->setQueryStringValue($_GET["Id_Tel_SIM"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Tel_SIM->CurrentValue == "")
			$this->Page_Terminate("cap_imprimir_nota_equipo_librelist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cap_imprimir_nota_equipo_librelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_imprimir_nota_equipo_libreview.php")
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
		if (!$this->ImprimirNotaVenta->FldIsDetailKey) {
			$this->ImprimirNotaVenta->setFormValue($objForm->GetValue("x_ImprimirNotaVenta"));
		}
		if (!$this->Serie_NotaVenta->FldIsDetailKey) {
			$this->Serie_NotaVenta->setFormValue($objForm->GetValue("x_Serie_NotaVenta"));
		}
		if (!$this->Numero_NotaVenta->FldIsDetailKey) {
			$this->Numero_NotaVenta->setFormValue($objForm->GetValue("x_Numero_NotaVenta"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Tel_SIM->CurrentValue = $this->Id_Tel_SIM->FormValue;
		$this->Id_Cliente->CurrentValue = $this->Id_Cliente->FormValue;
		$this->Num_IMEI->CurrentValue = $this->Num_IMEI->FormValue;
		$this->Num_ICCID->CurrentValue = $this->Num_ICCID->FormValue;
		$this->Num_CEL->CurrentValue = $this->Num_CEL->FormValue;
		$this->ImprimirNotaVenta->CurrentValue = $this->ImprimirNotaVenta->FormValue;
		$this->Serie_NotaVenta->CurrentValue = $this->Serie_NotaVenta->FormValue;
		$this->Numero_NotaVenta->CurrentValue = $this->Numero_NotaVenta->FormValue;
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
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->ImprimirNotaVenta->setDbValue($rs->fields('ImprimirNotaVenta'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Numero_NotaVenta->setDbValue($rs->fields('Numero_NotaVenta'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Tel_SIM
		// Id_Cliente
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// ImprimirNotaVenta
		// Serie_NotaVenta
		// Numero_NotaVenta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoEquipo`='LIBRE'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
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
			$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->EditCustomAttributes = "";
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoEquipo`='LIBRE'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->EditValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->EditValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->EditValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->EditValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Cliente
			$this->Id_Cliente->EditCustomAttributes = "";
			$this->Id_Cliente->EditValue = $this->Id_Cliente->CurrentValue;
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
					$this->Id_Cliente->EditValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Cliente->EditValue = $this->Id_Cliente->CurrentValue;
				}
			} else {
				$this->Id_Cliente->EditValue = NULL;
			}
			$this->Id_Cliente->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->EditCustomAttributes = "";
			$this->Num_IMEI->EditValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->EditCustomAttributes = "";
			$this->Num_ICCID->EditValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->EditCustomAttributes = "";
			$this->Num_CEL->EditValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->EditCustomAttributes = "onchange= 'ImprimirNota(this);' ";
			$arwrk = array();
			$arwrk[] = array($this->ImprimirNotaVenta->FldTagValue(1), $this->ImprimirNotaVenta->FldTagCaption(1) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(1) : $this->ImprimirNotaVenta->FldTagValue(1));
			$arwrk[] = array($this->ImprimirNotaVenta->FldTagValue(2), $this->ImprimirNotaVenta->FldTagCaption(2) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(2) : $this->ImprimirNotaVenta->FldTagValue(2));
			$this->ImprimirNotaVenta->EditValue = $arwrk;

			// Serie_NotaVenta
			$this->Serie_NotaVenta->EditCustomAttributes = "";
			$this->Serie_NotaVenta->EditValue = $this->Serie_NotaVenta->CurrentValue;
			$this->Serie_NotaVenta->ViewCustomAttributes = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->EditCustomAttributes = "";
			$this->Numero_NotaVenta->EditValue = $this->Numero_NotaVenta->CurrentValue;
			$this->Numero_NotaVenta->ViewCustomAttributes = "";

			// Edit refer script
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

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->HrefValue = "";

			// Serie_NotaVenta
			$this->Serie_NotaVenta->HrefValue = "";

			// Numero_NotaVenta
			$this->Numero_NotaVenta->HrefValue = "";
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
			if ($this->Num_IMEI->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Num_IMEI` = '" . ew_AdjustSql($this->Num_IMEI->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_IMEI->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_IMEI->CurrentValue, $sIdxErrMsg);
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

			// ImprimirNotaVenta
			$this->ImprimirNotaVenta->SetDbValueDef($rsnew, $this->ImprimirNotaVenta->CurrentValue, NULL, $this->ImprimirNotaVenta->ReadOnly);

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

	  // Asi se hace a partir de la version 9
	  Language()->setPhrase("Edit", "IMPRIMIENDO");         
	  Language()->setPhrase("EditBtn", "ACEPTAR");         
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
if (!isset($cap_imprimir_nota_equipo_libre_edit)) $cap_imprimir_nota_equipo_libre_edit = new ccap_imprimir_nota_equipo_libre_edit();

// Page init
$cap_imprimir_nota_equipo_libre_edit->Page_Init();

// Page main
$cap_imprimir_nota_equipo_libre_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_imprimir_nota_equipo_libre_edit = new ew_Page("cap_imprimir_nota_equipo_libre_edit");
cap_imprimir_nota_equipo_libre_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_imprimir_nota_equipo_libre_edit.PageID; // For backward compatibility

// Form object
var fcap_imprimir_nota_equipo_libreedit = new ew_Form("fcap_imprimir_nota_equipo_libreedit");

// Validate form
fcap_imprimir_nota_equipo_libreedit.Validate = function(fobj) {
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
fcap_imprimir_nota_equipo_libreedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_imprimir_nota_equipo_libreedit.ValidateRequired = true;
<?php } else { ?>
fcap_imprimir_nota_equipo_libreedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_imprimir_nota_equipo_libreedit.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","x_Acabado_eq","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_imprimir_nota_equipo_libreedit.Lists["x_Id_Cliente"] = {"LinkField":"x_Id_Cliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre_Completo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
function ImprimirNota(x)  {             
   var Id_TS = document.getElementById('x_Id_Tel_SIM');                                              

// alert("Imprimiendo EDIT NOTA");
 if (x.value=='IMPRIMIR') {        
   window.open("prn_nota_venta_equipo_reprintview.php?Id_Tel_SIM="+Id_TS.value); void(0);  

//   window.open("aux_gen_pdfsedit.php?Id_Tel_SIM="+Id_TS.value+"&tipo=nota"); void(0);  
 }                                                        
}

// Quitamos la liga "REGRESAR" que aparece al inicio  de la pagina, ya que llegamos aqui por liga directa
// Lo que hacemos es desde DHTML quitamos el NODO inicial del elemento

var nRegresar = document.getElementById('a_GoBack');
nRegresar.removeChild(nRegresar.lastChild);
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_imprimir_nota_equipo_libre->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_imprimir_nota_equipo_libre->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_imprimir_nota_equipo_libre_edit->ShowPageHeader(); ?>
<?php
$cap_imprimir_nota_equipo_libre_edit->ShowMessage();
?>
<form name="fcap_imprimir_nota_equipo_libreedit" id="fcap_imprimir_nota_equipo_libreedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_imprimir_nota_equipo_libre">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_imprimir_nota_equipo_libreedit" class="ewTable">
<?php if ($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<tr id="r_Id_Tel_SIM"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Id_Tel_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Id_Tel_SIM">
<span<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->EditValue ?></span>
<input type="hidden" name="x_Id_Tel_SIM" id="x_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Id_Tel_SIM->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Id_Tel_SIM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Id_Cliente->Visible) { // Id_Cliente ?>
	<tr id="r_Id_Cliente"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Id_Cliente"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Id_Cliente">
<span<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->EditValue ?></span>
<input type="hidden" name="x_Id_Cliente" id="x_Id_Cliente" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Id_Cliente->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Id_Cliente->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Num_IMEI->Visible) { // Num_IMEI ?>
	<tr id="r_Num_IMEI"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Num_IMEI">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->EditValue ?></span>
<input type="hidden" name="x_Num_IMEI" id="x_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Num_IMEI->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Num_IMEI->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Num_ICCID->Visible) { // Num_ICCID ?>
	<tr id="r_Num_ICCID"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Num_ICCID"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Num_ICCID">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->EditValue ?></span>
<input type="hidden" name="x_Num_ICCID" id="x_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Num_ICCID->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Num_ICCID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Num_CEL->Visible) { // Num_CEL ?>
	<tr id="r_Num_CEL"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Num_CEL"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Num_CEL">
<span<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->EditValue ?></span>
<input type="hidden" name="x_Num_CEL" id="x_Num_CEL" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Num_CEL->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Num_CEL->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->Visible) { // ImprimirNotaVenta ?>
	<tr id="r_ImprimirNotaVenta"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_ImprimirNotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_ImprimirNotaVenta">
<div id="tp_x_ImprimirNotaVenta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_ImprimirNotaVenta" id="x_ImprimirNotaVenta" value="{value}"<?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->EditAttributes() ?>></div>
<div id="dsl_x_ImprimirNotaVenta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_ImprimirNotaVenta" id="x_ImprimirNotaVenta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_imprimir_nota_equipo_libre->ImprimirNotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->Visible) { // Serie_NotaVenta ?>
	<tr id="r_Serie_NotaVenta"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Serie_NotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Serie_NotaVenta">
<span<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->EditValue ?></span>
<input type="hidden" name="x_Serie_NotaVenta" id="x_Serie_NotaVenta" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Serie_NotaVenta->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Serie_NotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->Visible) { // Numero_NotaVenta ?>
	<tr id="r_Numero_NotaVenta"<?php echo $cap_imprimir_nota_equipo_libre->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_imprimir_nota_equipo_libre_Numero_NotaVenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->CellAttributes() ?>><span id="el_cap_imprimir_nota_equipo_libre_Numero_NotaVenta">
<span<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->ViewAttributes() ?>>
<?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->EditValue ?></span>
<input type="hidden" name="x_Numero_NotaVenta" id="x_Numero_NotaVenta" value="<?php echo ew_HtmlEncode($cap_imprimir_nota_equipo_libre->Numero_NotaVenta->CurrentValue) ?>">
</span><?php echo $cap_imprimir_nota_equipo_libre->Numero_NotaVenta->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_imprimir_nota_equipo_libreedit.Init();
</script>
<?php
$cap_imprimir_nota_equipo_libre_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

alert(" NO SE TE OLVIDE OFRECER ACCESORIOS AL CLIENTE PARA SU EQUIPO  ¡¡ POR FAVOR !!");
</script>
<?php include_once "footer.php" ?>
<?php
$cap_imprimir_nota_equipo_libre_edit->Page_Terminate();
?>
