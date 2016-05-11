<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_def_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_def_accesorios_edit = NULL; // Initialize page object first

class ccap_def_accesorios_edit extends ccap_def_accesorios {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_def_accesorios';

	// Page object name
	var $PageObjName = 'cap_def_accesorios_edit';

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

		// Table object (cap_def_accesorios)
		if (!isset($GLOBALS["cap_def_accesorios"])) {
			$GLOBALS["cap_def_accesorios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_def_accesorios"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_def_accesorios', TRUE);

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
			$this->Page_Terminate("cap_def_accesorioslist.php");
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
		if (@$_GET["Id_Articulo"] <> "")
			$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Articulo->CurrentValue == "")
			$this->Page_Terminate("cap_def_accesorioslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cap_def_accesorioslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_def_accesoriosview.php")
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
		if (!$this->COD_Fam_Accesorio->FldIsDetailKey) {
			$this->COD_Fam_Accesorio->setFormValue($objForm->GetValue("x_COD_Fam_Accesorio"));
		}
		if (!$this->COD_Marca_acc->FldIsDetailKey) {
			$this->COD_Marca_acc->setFormValue($objForm->GetValue("x_COD_Marca_acc"));
		}
		if (!$this->COD_Acabado_acc->FldIsDetailKey) {
			$this->COD_Acabado_acc->setFormValue($objForm->GetValue("x_COD_Acabado_acc"));
		}
		if (!$this->COD_Tipo_acc->FldIsDetailKey) {
			$this->COD_Tipo_acc->setFormValue($objForm->GetValue("x_COD_Tipo_acc"));
		}
		if (!$this->COD_Equipo_acc->FldIsDetailKey) {
			$this->COD_Equipo_acc->setFormValue($objForm->GetValue("x_COD_Equipo_acc"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->BarCode_Externo->FldIsDetailKey) {
			$this->BarCode_Externo->setFormValue($objForm->GetValue("x_BarCode_Externo"));
		}
		if (!$this->Id_Almacen_Entrada->FldIsDetailKey) {
			$this->Id_Almacen_Entrada->setFormValue($objForm->GetValue("x_Id_Almacen_Entrada"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey)
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->COD_Fam_Accesorio->CurrentValue = $this->COD_Fam_Accesorio->FormValue;
		$this->COD_Marca_acc->CurrentValue = $this->COD_Marca_acc->FormValue;
		$this->COD_Acabado_acc->CurrentValue = $this->COD_Acabado_acc->FormValue;
		$this->COD_Tipo_acc->CurrentValue = $this->COD_Tipo_acc->FormValue;
		$this->COD_Equipo_acc->CurrentValue = $this->COD_Equipo_acc->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->BarCode_Externo->CurrentValue = $this->BarCode_Externo->FormValue;
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
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->COD_Marca_acc->setDbValue($rs->fields('COD_Marca_acc'));
		$this->COD_Acabado_acc->setDbValue($rs->fields('COD_Acabado_acc'));
		$this->COD_Tipo_acc->setDbValue($rs->fields('COD_Tipo_acc'));
		$this->COD_Equipo_acc->setDbValue($rs->fields('COD_Equipo_acc'));
		if (array_key_exists('EV__COD_Equipo_acc', $rs->fields)) {
			$this->COD_Equipo_acc->VirtualValue = $rs->fields('EV__COD_Equipo_acc'); // Set up virtual field value
		} else {
			$this->COD_Equipo_acc->VirtualValue = ""; // Clear value
		}
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->BarCode_Externo->setDbValue($rs->fields('BarCode_Externo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
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
		// COD_Fam_Accesorio
		// COD_Marca_acc
		// COD_Acabado_acc
		// COD_Tipo_acc
		// COD_Equipo_acc
		// Codigo
		// Articulo
		// BarCode_Externo
		// Id_Almacen_Entrada

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// COD_Fam_Accesorio
			if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Fam_Accesorio->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Fam_Accesorio->ViewValue = $this->COD_Fam_Accesorio->CurrentValue;
				}
			} else {
				$this->COD_Fam_Accesorio->ViewValue = NULL;
			}
			$this->COD_Fam_Accesorio->ViewCustomAttributes = "";

			// COD_Marca_acc
			if (strval($this->COD_Marca_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_acc`" . ew_SearchString("=", $this->COD_Marca_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_acc->ViewValue = $this->COD_Marca_acc->CurrentValue;
				}
			} else {
				$this->COD_Marca_acc->ViewValue = NULL;
			}
			$this->COD_Marca_acc->ViewCustomAttributes = "";

			// COD_Acabado_acc
			if (strval($this->COD_Acabado_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Acabado_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Acabado_acc->ViewValue = $this->COD_Acabado_acc->CurrentValue;
				}
			} else {
				$this->COD_Acabado_acc->ViewValue = NULL;
			}
			$this->COD_Acabado_acc->ViewCustomAttributes = "";

			// COD_Tipo_acc
			if (strval($this->COD_Tipo_acc->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Tipo_acc`" . ew_SearchString("=", $this->COD_Tipo_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Tipo_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Tipo_acc->ViewValue = $this->COD_Tipo_acc->CurrentValue;
				}
			} else {
				$this->COD_Tipo_acc->ViewValue = NULL;
			}
			$this->COD_Tipo_acc->ViewCustomAttributes = "";

			// COD_Equipo_acc
			if ($this->COD_Equipo_acc->VirtualValue <> "") {
				$this->COD_Equipo_acc->ViewValue = $this->COD_Equipo_acc->VirtualValue;
			} else {
			if (strval($this->COD_Equipo_acc->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Equipo_acc->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Equipo_acc->ViewValue = $this->COD_Equipo_acc->CurrentValue;
				}
			} else {
				$this->COD_Equipo_acc->ViewValue = NULL;
			}
			}
			$this->COD_Equipo_acc->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// BarCode_Externo
			$this->BarCode_Externo->ViewValue = $this->BarCode_Externo->CurrentValue;
			$this->BarCode_Externo->ViewCustomAttributes = "";

			// Id_Almacen_Entrada
			if (strval($this->Id_Almacen_Entrada->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrada->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen`";
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

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->LinkCustomAttributes = "";
			$this->COD_Fam_Accesorio->HrefValue = "";
			$this->COD_Fam_Accesorio->TooltipValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->LinkCustomAttributes = "";
			$this->COD_Marca_acc->HrefValue = "";
			$this->COD_Marca_acc->TooltipValue = "";

			// COD_Acabado_acc
			$this->COD_Acabado_acc->LinkCustomAttributes = "";
			$this->COD_Acabado_acc->HrefValue = "";
			$this->COD_Acabado_acc->TooltipValue = "";

			// COD_Tipo_acc
			$this->COD_Tipo_acc->LinkCustomAttributes = "";
			$this->COD_Tipo_acc->HrefValue = "";
			$this->COD_Tipo_acc->TooltipValue = "";

			// COD_Equipo_acc
			$this->COD_Equipo_acc->LinkCustomAttributes = "";
			$this->COD_Equipo_acc->HrefValue = "";
			$this->COD_Equipo_acc->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// BarCode_Externo
			$this->BarCode_Externo->LinkCustomAttributes = "";
			$this->BarCode_Externo->HrefValue = "";
			$this->BarCode_Externo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Fam_Accesorio->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Fam_Accesorio->EditValue = $arwrk;

			// COD_Marca_acc
			$this->COD_Marca_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Marca_acc`, `Marca_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_marca_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Marca_acc->EditValue = $arwrk;

			// COD_Acabado_acc
			$this->COD_Acabado_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Acabado_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`COD_Acabado`" . ew_SearchString("=", $this->COD_Acabado_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_acabado_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Acabado_acc->EditValue = $arwrk;

			// COD_Tipo_acc
			$this->COD_Tipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `COD_Tipo_acc`, `Tipo_acc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `me_tipo_accesoio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Tipo_acc` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Tipo_acc->EditValue = $arwrk;

			// COD_Equipo_acc
			$this->COD_Equipo_acc->EditCustomAttributes = "onchange= 'ActualizaCodigo_Accesorio(this);' ";
			if (trim(strval($this->COD_Equipo_acc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->COD_Equipo_acc->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_equipos_accesorios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->COD_Equipo_acc->EditValue = $arwrk;

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// BarCode_Externo
			$this->BarCode_Externo->EditCustomAttributes = "";
			$this->BarCode_Externo->EditValue = ew_HtmlEncode($this->BarCode_Externo->CurrentValue);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->EditCustomAttributes = "";
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
			$this->Id_Almacen_Entrada->EditValue = $arwrk;

			// Edit refer script
			// COD_Fam_Accesorio

			$this->COD_Fam_Accesorio->HrefValue = "";

			// COD_Marca_acc
			$this->COD_Marca_acc->HrefValue = "";

			// COD_Acabado_acc
			$this->COD_Acabado_acc->HrefValue = "";

			// COD_Tipo_acc
			$this->COD_Tipo_acc->HrefValue = "";

			// COD_Equipo_acc
			$this->COD_Equipo_acc->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// BarCode_Externo
			$this->BarCode_Externo->HrefValue = "";

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
		if (!is_null($this->COD_Fam_Accesorio->FormValue) && $this->COD_Fam_Accesorio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Fam_Accesorio->FldCaption());
		}
		if (!is_null($this->COD_Marca_acc->FormValue) && $this->COD_Marca_acc->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->COD_Marca_acc->FldCaption());
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
			if ($this->Codigo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Codigo` = '" . ew_AdjustSql($this->Codigo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Codigo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Codigo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
			if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Articulo` = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
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

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->SetDbValueDef($rsnew, $this->COD_Fam_Accesorio->CurrentValue, NULL, $this->COD_Fam_Accesorio->ReadOnly);

			// COD_Marca_acc
			$this->COD_Marca_acc->SetDbValueDef($rsnew, $this->COD_Marca_acc->CurrentValue, NULL, $this->COD_Marca_acc->ReadOnly);

			// COD_Acabado_acc
			$this->COD_Acabado_acc->SetDbValueDef($rsnew, $this->COD_Acabado_acc->CurrentValue, NULL, $this->COD_Acabado_acc->ReadOnly);

			// COD_Tipo_acc
			$this->COD_Tipo_acc->SetDbValueDef($rsnew, $this->COD_Tipo_acc->CurrentValue, NULL, $this->COD_Tipo_acc->ReadOnly);

			// COD_Equipo_acc
			$this->COD_Equipo_acc->SetDbValueDef($rsnew, $this->COD_Equipo_acc->CurrentValue, NULL, $this->COD_Equipo_acc->ReadOnly);

			// Articulo
			$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", $this->Articulo->ReadOnly);

			// BarCode_Externo
			$this->BarCode_Externo->SetDbValueDef($rsnew, $this->BarCode_Externo->CurrentValue, NULL, $this->BarCode_Externo->ReadOnly);

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->SetDbValueDef($rsnew, $this->Id_Almacen_Entrada->CurrentValue, 0, $this->Id_Almacen_Entrada->ReadOnly);

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
if (!isset($cap_def_accesorios_edit)) $cap_def_accesorios_edit = new ccap_def_accesorios_edit();

// Page init
$cap_def_accesorios_edit->Page_Init();

// Page main
$cap_def_accesorios_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_def_accesorios_edit = new ew_Page("cap_def_accesorios_edit");
cap_def_accesorios_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_def_accesorios_edit.PageID; // For backward compatibility

// Form object
var fcap_def_accesoriosedit = new ew_Form("fcap_def_accesoriosedit");

// Validate form
fcap_def_accesoriosedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_COD_Fam_Accesorio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->COD_Fam_Accesorio->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_COD_Marca_acc"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->COD_Marca_acc->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Almacen_Entrada"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_def_accesorios->Id_Almacen_Entrada->FldCaption()) ?>");

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
fcap_def_accesoriosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_accesoriosedit.ValidateRequired = true;
<?php } else { ?>
fcap_def_accesoriosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_def_accesoriosedit.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosedit.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosedit.Lists["x_COD_Acabado_acc"] = {"LinkField":"x_COD_Acabado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosedit.Lists["x_COD_Tipo_acc"] = {"LinkField":"x_COD_Tipo_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Tipo_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosedit.Lists["x_COD_Equipo_acc"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosedit.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

function ActualizaCodigo_Accesorio(x)                                            
{          

//alert("Llamada desde: " + x.name + "  Valor: " + x.value);      
   var Fam = document.getElementById('x_COD_Fam_Accesorio');
   var Marca = document.getElementById('x_COD_Marca_acc');                             
   var Acabado = document.getElementById('x_COD_Acabado_acc');                             
   var Tipo = document.getElementById('x_COD_Tipo_acc');                             
   var Modelo = document.getElementById('x_COD_Equipo_acc');  
   var xCodigo = document.getElementById('x_Codigo');
   var xArticulo = document.getElementById('x_Articulo');

// Llenamos el Codigo con los valores de los catalogos                             
   Codigo = Fam.value + Marca.value + Acabado.value + Tipo.value + Modelo.value;                  
   xCodigo.value=Codigo;

// Llenamos el Codigo con los valores de los catalogos                             

/*   var Codigo = Fam.value + Marca.value;
   if (Acabado.value == "") { Codigo += "XXX" } else { Codigo += Acabado.value }                               
   if (Tipo.value == "")    { Codigo += "YYY" } else { Codigo += Tipo.value    }                     
   if (Modelo.value == "")  { Codigo += "ZZZZZZZZZ" } else { Codigo += Modelo.value }
   xCodigo.value=Codigo;
*/

//  Llenamos el Articulo con los valores de los catalogos                             
   var Articulo=Fam.options[Fam.selectedIndex].text;
   Articulo += " " + Marca.options[Marca.selectedIndex].text;                 
   Articulo += " " + Acabado.options[Acabado.selectedIndex].text;                 
   Articulo += " " + Tipo.options[Tipo.selectedIndex].text;                 
   Articulo += " " + Modelo.options[Modelo.selectedIndex].text;
   Articulo=Articulo.replace("   "," ");  // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo 
   Articulo=Articulo.replace("  "," ");   // Solo para quitar los espacios que quedan cuando no eligen Acabado, Tipo o Modelo 
   xArticulo.value=Articulo;
}

function AvisoNoEditarCodigo(x) {     
  alert(" EL CODIGO NO PUEDE SER MODIFICADO MANUALMENTE ");
  document.getElementById('x_COD_Fam_Accesorio').focus();
}
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_def_accesorios->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_def_accesorios->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_def_accesorios_edit->ShowPageHeader(); ?>
<?php
$cap_def_accesorios_edit->ShowMessage();
?>
<form name="fcap_def_accesoriosedit" id="fcap_def_accesoriosedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_def_accesorios">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_def_accesoriosedit" class="ewTable">
<?php if ($cap_def_accesorios->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<tr id="r_COD_Fam_Accesorio"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Fam_Accesorio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->COD_Fam_Accesorio->CellAttributes() ?>><span id="el_cap_def_accesorios_COD_Fam_Accesorio">
<select id="x_COD_Fam_Accesorio" name="x_COD_Fam_Accesorio"<?php echo $cap_def_accesorios->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Familia_Accesorio` Asc";
?>
<input type="hidden" name="s_x_COD_Fam_Accesorio" id="s_x_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
</span><?php echo $cap_def_accesorios->COD_Fam_Accesorio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->COD_Marca_acc->Visible) { // COD_Marca_acc ?>
	<tr id="r_COD_Marca_acc"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_COD_Marca_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Marca_acc->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->COD_Marca_acc->CellAttributes() ?>><span id="el_cap_def_accesorios_COD_Marca_acc">
<select id="x_COD_Marca_acc" name="x_COD_Marca_acc"<?php echo $cap_def_accesorios->COD_Marca_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Marca_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Marca_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesoriosedit.Lists["x_COD_Marca_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Marca_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Marca_acc->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_accesorios->COD_Marca_acc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->COD_Acabado_acc->Visible) { // COD_Acabado_acc ?>
	<tr id="r_COD_Acabado_acc"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_COD_Acabado_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Acabado_acc->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->COD_Acabado_acc->CellAttributes() ?>><span id="el_cap_def_accesorios_COD_Acabado_acc">
<select id="x_COD_Acabado_acc" name="x_COD_Acabado_acc"<?php echo $cap_def_accesorios->COD_Acabado_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Acabado_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Acabado_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Acabado_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT DISTINCT `COD_Acabado`, `Acabado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Acabado` Asc";
?>
<input type="hidden" name="s_x_COD_Acabado_acc" id="s_x_COD_Acabado_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Acabado_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Acabado` = {filter_value}"); ?>&t0=200">
</span><?php echo $cap_def_accesorios->COD_Acabado_acc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->COD_Tipo_acc->Visible) { // COD_Tipo_acc ?>
	<tr id="r_COD_Tipo_acc"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_COD_Tipo_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Tipo_acc->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->COD_Tipo_acc->CellAttributes() ?>><span id="el_cap_def_accesorios_COD_Tipo_acc">
<select id="x_COD_Tipo_acc" name="x_COD_Tipo_acc"<?php echo $cap_def_accesorios->COD_Tipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Tipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Tipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesoriosedit.Lists["x_COD_Tipo_acc"].Options = <?php echo (is_array($cap_def_accesorios->COD_Tipo_acc->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->COD_Tipo_acc->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_accesorios->COD_Tipo_acc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->COD_Equipo_acc->Visible) { // COD_Equipo_acc ?>
	<tr id="r_COD_Equipo_acc"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_COD_Equipo_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Equipo_acc->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->COD_Equipo_acc->CellAttributes() ?>><span id="el_cap_def_accesorios_COD_Equipo_acc">
<select id="x_COD_Equipo_acc" name="x_COD_Equipo_acc"<?php echo $cap_def_accesorios->COD_Equipo_acc->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->COD_Equipo_acc->EditValue)) {
	$arwrk = $cap_def_accesorios->COD_Equipo_acc->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->COD_Equipo_acc->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT DISTINCT `Codigo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos_accesorios`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x_COD_Equipo_acc" id="s_x_COD_Equipo_acc" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_def_accesorios->COD_Equipo_acc->LookupFn) ?>&f0=<?php echo TEAencrypt("`Codigo` = {filter_value}"); ?>&t0=200">
</span><?php echo $cap_def_accesorios->COD_Equipo_acc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->Codigo->Visible) { // Codigo ?>
	<tr id="r_Codigo"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Codigo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->Codigo->CellAttributes() ?>><span id="el_cap_def_accesorios_Codigo">
<span<?php echo $cap_def_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Codigo->EditValue ?></span>
<input type="hidden" name="x_Codigo" id="x_Codigo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Codigo->CurrentValue) ?>">
</span><?php echo $cap_def_accesorios->Codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->Articulo->Visible) { // Articulo ?>
	<tr id="r_Articulo"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->Articulo->CellAttributes() ?>><span id="el_cap_def_accesorios_Articulo">
<input type="text" name="x_Articulo" id="x_Articulo" size="100" maxlength="100" value="<?php echo $cap_def_accesorios->Articulo->EditValue ?>"<?php echo $cap_def_accesorios->Articulo->EditAttributes() ?>>
</span><?php echo $cap_def_accesorios->Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->BarCode_Externo->Visible) { // BarCode_Externo ?>
	<tr id="r_BarCode_Externo"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_BarCode_Externo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->BarCode_Externo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->BarCode_Externo->CellAttributes() ?>><span id="el_cap_def_accesorios_BarCode_Externo">
<input type="text" name="x_BarCode_Externo" id="x_BarCode_Externo" size="30" maxlength="25" value="<?php echo $cap_def_accesorios->BarCode_Externo->EditValue ?>"<?php echo $cap_def_accesorios->BarCode_Externo->EditAttributes() ?>>
</span><?php echo $cap_def_accesorios->BarCode_Externo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_def_accesorios->Id_Almacen_Entrada->Visible) { // Id_Almacen_Entrada ?>
	<tr id="r_Id_Almacen_Entrada"<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_def_accesorios_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Id_Almacen_Entrada->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_def_accesorios->Id_Almacen_Entrada->CellAttributes() ?>><span id="el_cap_def_accesorios_Id_Almacen_Entrada">
<select id="x_Id_Almacen_Entrada" name="x_Id_Almacen_Entrada"<?php echo $cap_def_accesorios->Id_Almacen_Entrada->EditAttributes() ?>>
<?php
if (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) {
	$arwrk = $cap_def_accesorios->Id_Almacen_Entrada->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_def_accesorios->Id_Almacen_Entrada->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_def_accesoriosedit.Lists["x_Id_Almacen_Entrada"].Options = <?php echo (is_array($cap_def_accesorios->Id_Almacen_Entrada->EditValue)) ? ew_ArrayToJson($cap_def_accesorios->Id_Almacen_Entrada->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_def_accesorios->Id_Almacen_Entrada->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_Id_Articulo" id="x_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_def_accesorios->Id_Articulo->CurrentValue) ?>">
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_def_accesoriosedit.Init();
</script>
<?php
$cap_def_accesorios_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_def_accesorios_edit->Page_Terminate();
?>
