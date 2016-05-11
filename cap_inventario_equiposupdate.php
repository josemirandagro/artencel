<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_inventario_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_inventario_equipos_update = NULL; // Initialize page object first

class ccap_inventario_equipos_update extends ccap_inventario_equipos {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_inventario_equipos';

	// Page object name
	var $PageObjName = 'cap_inventario_equipos_update';

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

		// Table object (cap_inventario_equipos)
		if (!isset($GLOBALS["cap_inventario_equipos"])) {
			$GLOBALS["cap_inventario_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_inventario_equipos"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_inventario_equipos', TRUE);

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
			$this->Page_Terminate("cap_inventario_equiposlist.php");
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
	var $RecKeys;
	var $Disabled;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("cap_inventario_equiposlist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Cantidad_Minima->setDbValue($this->Recordset->fields('Cantidad_Minima'));
					$this->Cantidad_Maxima->setDbValue($this->Recordset->fields('Cantidad_Maxima'));
				} else {
					if (!ew_CompareValue($this->Cantidad_Minima->DbValue, $this->Recordset->fields('Cantidad_Minima')))
						$this->Cantidad_Minima->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Maxima->DbValue, $this->Recordset->fields('Cantidad_Maxima')))
						$this->Cantidad_Maxima->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		if (count($key) <> 2)
			return FALSE;
		$sKeyFld = $key[0];
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Id_Almacen->CurrentValue = $sKeyFld;
		$sKeyFld = $key[1];
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Id_Articulo->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $conn, $Language;
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = implode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
				$this->SendEmail = FALSE; // Do not send email on update success
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
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
		if (!$this->Cantidad_Minima->FldIsDetailKey) {
			$this->Cantidad_Minima->setFormValue($objForm->GetValue("x_Cantidad_Minima"));
		}
		$this->Cantidad_Minima->MultiUpdate = $objForm->GetValue("u_Cantidad_Minima");
		if (!$this->Cantidad_Maxima->FldIsDetailKey) {
			$this->Cantidad_Maxima->setFormValue($objForm->GetValue("x_Cantidad_Maxima"));
		}
		$this->Cantidad_Maxima->MultiUpdate = $objForm->GetValue("u_Cantidad_Maxima");
		if (!$this->Id_Almacen->FldIsDetailKey)
			$this->Id_Almacen->setFormValue($objForm->GetValue("x_Id_Almacen"));
		if (!$this->Id_Articulo->FldIsDetailKey)
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Almacen->CurrentValue = $this->Id_Almacen->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Cantidad_Minima->CurrentValue = $this->Cantidad_Minima->FormValue;
		$this->Cantidad_Maxima->CurrentValue = $this->Cantidad_Maxima->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Cantidad_Actual->setDbValue($rs->fields('Cantidad_Actual'));
		$this->Cantidad_MustBe->setDbValue($rs->fields('Cantidad_MustBe'));
		$this->Cantidad_Minima->setDbValue($rs->fields('Cantidad_Minima'));
		$this->Cantidad_Maxima->setDbValue($rs->fields('Cantidad_Maxima'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Almacen
		// COD_Marca_eq
		// COD_Modelo_eq
		// Id_Articulo
		// Codigo
		// Cantidad_Actual
		// Cantidad_MustBe
		// Cantidad_Minima
		// Cantidad_Maxima

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

			// COD_Marca_eq
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT DISTINCT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq`";
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
			if (strval($this->COD_Modelo_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Modelo_eq`" . ew_SearchString("=", $this->COD_Modelo_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Modelo_eq`, `COD_Modelo_eq` AS `DispFld`, `Apodo_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Modelo_eq->ViewValue = $rswrk->fields('DispFld');
					$this->COD_Modelo_eq->ViewValue .= ew_ValueSeparator(1,$this->COD_Modelo_eq) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
				}
			} else {
				$this->COD_Modelo_eq->ViewValue = NULL;
			}
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Cantidad_Actual
			$this->Cantidad_Actual->ViewValue = $this->Cantidad_Actual->CurrentValue;
			$this->Cantidad_Actual->ViewCustomAttributes = "";

			// Cantidad_MustBe
			$this->Cantidad_MustBe->ViewValue = $this->Cantidad_MustBe->CurrentValue;
			$this->Cantidad_MustBe->ViewCustomAttributes = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->ViewValue = $this->Cantidad_Minima->CurrentValue;
			$this->Cantidad_Minima->ViewCustomAttributes = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->ViewValue = $this->Cantidad_Maxima->CurrentValue;
			$this->Cantidad_Maxima->ViewCustomAttributes = "";

			// Cantidad_Minima
			$this->Cantidad_Minima->LinkCustomAttributes = "";
			$this->Cantidad_Minima->HrefValue = "";
			$this->Cantidad_Minima->TooltipValue = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->LinkCustomAttributes = "";
			$this->Cantidad_Maxima->HrefValue = "";
			$this->Cantidad_Maxima->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Cantidad_Minima
			$this->Cantidad_Minima->EditCustomAttributes = "";
			$this->Cantidad_Minima->EditValue = ew_HtmlEncode($this->Cantidad_Minima->CurrentValue);

			// Cantidad_Maxima
			$this->Cantidad_Maxima->EditCustomAttributes = "";
			$this->Cantidad_Maxima->EditValue = ew_HtmlEncode($this->Cantidad_Maxima->CurrentValue);

			// Edit refer script
			// Cantidad_Minima

			$this->Cantidad_Minima->HrefValue = "";

			// Cantidad_Maxima
			$this->Cantidad_Maxima->HrefValue = "";
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
		$lUpdateCnt = 0;
		if ($this->Cantidad_Minima->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Maxima->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Cantidad_Minima->MultiUpdate <> "" && !is_null($this->Cantidad_Minima->FormValue) && $this->Cantidad_Minima->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad_Minima->FldCaption());
		}
		if ($this->Cantidad_Minima->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Minima->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Minima->FldErrMsg());
			}
		}
		if ($this->Cantidad_Maxima->MultiUpdate <> "" && !is_null($this->Cantidad_Maxima->FormValue) && $this->Cantidad_Maxima->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad_Maxima->FldCaption());
		}
		if ($this->Cantidad_Maxima->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Maxima->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Maxima->FldErrMsg());
			}
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

			// Cantidad_Minima
			$this->Cantidad_Minima->SetDbValueDef($rsnew, $this->Cantidad_Minima->CurrentValue, 0, $this->Cantidad_Minima->ReadOnly || $this->Cantidad_Minima->MultiUpdate <> "1");

			// Cantidad_Maxima
			$this->Cantidad_Maxima->SetDbValueDef($rsnew, $this->Cantidad_Maxima->CurrentValue, 0, $this->Cantidad_Maxima->ReadOnly || $this->Cantidad_Maxima->MultiUpdate <> "1");

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
if (!isset($cap_inventario_equipos_update)) $cap_inventario_equipos_update = new ccap_inventario_equipos_update();

// Page init
$cap_inventario_equipos_update->Page_Init();

// Page main
$cap_inventario_equipos_update->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_inventario_equipos_update = new ew_Page("cap_inventario_equipos_update");
cap_inventario_equipos_update.PageID = "update"; // Page ID
var EW_PAGE_ID = cap_inventario_equipos_update.PageID; // For backward compatibility

// Form object
var fcap_inventario_equiposupdate = new ew_Form("fcap_inventario_equiposupdate");

// Validate form
fcap_inventario_equiposupdate.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var uelm;
	var elm, aelm;
	var rowcnt = 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = "";
		elm = fobj.elements["x" + infix + "_Cantidad_Minima"];
		uelm = fobj.elements["u" + infix + "_Cantidad_Minima"];
		if (uelm && uelm.checked) {
			if (elm && !ew_HasValue(elm))
				return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_equipos->Cantidad_Minima->FldCaption()) ?>");
		}
		elm = fobj.elements["x" + infix + "_Cantidad_Minima"];
		uelm = fobj.elements["u" + infix + "_Cantidad_Minima"];
		if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_inventario_equipos->Cantidad_Minima->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad_Maxima"];
		uelm = fobj.elements["u" + infix + "_Cantidad_Maxima"];
		if (uelm && uelm.checked) {
			if (elm && !ew_HasValue(elm))
				return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_equipos->Cantidad_Maxima->FldCaption()) ?>");
		}
		elm = fobj.elements["x" + infix + "_Cantidad_Maxima"];
		uelm = fobj.elements["u" + infix + "_Cantidad_Maxima"];
		if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_inventario_equipos->Cantidad_Maxima->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_inventario_equiposupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_equiposupdate.ValidateRequired = true;
<?php } else { ?>
fcap_inventario_equiposupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Update") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_inventario_equipos->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_inventario_equipos->getReturnUrl() ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a></p>
<?php $cap_inventario_equipos_update->ShowPageHeader(); ?>
<?php
$cap_inventario_equipos_update->ShowMessage();
?>
<form name="fcap_inventario_equiposupdate" id="fcap_inventario_equiposupdate" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_inventario_equipos">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php foreach ($cap_inventario_equipos_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_inventario_equiposupdate" class="ewTable ewTableSeparate">
	<tr class="ewTableHeader">
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("UpdateValue") ?><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"></td></tr></table></td>
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("FieldName") ?></td></tr></table></td>
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("NewValue") ?></td></tr></table></td>
	</tr>
<?php if ($cap_inventario_equipos->Cantidad_Minima->Visible) { // Cantidad_Minima ?>
	<tr id="r_Cantidad_Minima"<?php echo $cap_inventario_equipos->RowAttributes() ?>>
		<td class="ewCheckbox"<?php echo $cap_inventario_equipos->Cantidad_Minima->CellAttributes() ?>>
<input type="checkbox" name="u_Cantidad_Minima" id="u_Cantidad_Minima" value="1"<?php echo ($cap_inventario_equipos->Cantidad_Minima->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
</td>
		<td<?php echo $cap_inventario_equipos->Cantidad_Minima->CellAttributes() ?>><span id="elh_cap_inventario_equipos_Cantidad_Minima"><?php echo $cap_inventario_equipos->Cantidad_Minima->FldCaption() ?></span></td>
		<td<?php echo $cap_inventario_equipos->Cantidad_Minima->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_Minima">
<input type="text" name="x_Cantidad_Minima" id="x_Cantidad_Minima" size="5" maxlength="5" value="<?php echo $cap_inventario_equipos->Cantidad_Minima->EditValue ?>"<?php echo $cap_inventario_equipos->Cantidad_Minima->EditAttributes() ?>>
</span><?php echo $cap_inventario_equipos->Cantidad_Minima->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Cantidad_Maxima->Visible) { // Cantidad_Maxima ?>
	<tr id="r_Cantidad_Maxima"<?php echo $cap_inventario_equipos->RowAttributes() ?>>
		<td class="ewCheckbox"<?php echo $cap_inventario_equipos->Cantidad_Maxima->CellAttributes() ?>>
<input type="checkbox" name="u_Cantidad_Maxima" id="u_Cantidad_Maxima" value="1"<?php echo ($cap_inventario_equipos->Cantidad_Maxima->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
</td>
		<td<?php echo $cap_inventario_equipos->Cantidad_Maxima->CellAttributes() ?>><span id="elh_cap_inventario_equipos_Cantidad_Maxima"><?php echo $cap_inventario_equipos->Cantidad_Maxima->FldCaption() ?></span></td>
		<td<?php echo $cap_inventario_equipos->Cantidad_Maxima->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_Maxima">
<input type="text" name="x_Cantidad_Maxima" id="x_Cantidad_Maxima" size="5" maxlength="5" value="<?php echo $cap_inventario_equipos->Cantidad_Maxima->EditValue ?>"<?php echo $cap_inventario_equipos->Cantidad_Maxima->EditAttributes() ?>>
</span><?php echo $cap_inventario_equipos->Cantidad_Maxima->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("UpdateBtn")) ?>">
</form>
<script type="text/javascript">
fcap_inventario_equiposupdate.Init();
</script>
<?php
$cap_inventario_equipos_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_inventario_equipos_update->Page_Terminate();
?>
