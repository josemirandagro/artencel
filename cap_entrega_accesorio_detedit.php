<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_accesorio_detinfo.php" ?>
<?php include_once "cap_entrega_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_accesorio_det_edit = NULL; // Initialize page object first

class ccap_entrega_accesorio_det_edit extends ccap_entrega_accesorio_det {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_accesorio_det';

	// Page object name
	var $PageObjName = 'cap_entrega_accesorio_det_edit';

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

		// Table object (cap_entrega_accesorio_det)
		if (!isset($GLOBALS["cap_entrega_accesorio_det"])) {
			$GLOBALS["cap_entrega_accesorio_det"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_accesorio_det"];
		}

		// Table object (cap_entrega_accesorio)
		if (!isset($GLOBALS['cap_entrega_accesorio'])) $GLOBALS['cap_entrega_accesorio'] = new ccap_entrega_accesorio();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_accesorio_det', TRUE);

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
			$this->Page_Terminate("cap_entrega_accesorio_detlist.php");
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
		if (@$_GET["Id_Traspaso_Det"] <> "")
			$this->Id_Traspaso_Det->setQueryStringValue($_GET["Id_Traspaso_Det"]);

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Traspaso_Det->CurrentValue == "")
			$this->Page_Terminate("cap_entrega_accesorio_detlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cap_entrega_accesorio_detlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_entrega_accesorio_detview.php")
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
		if (!$this->Id_Traspaso->FldIsDetailKey) {
			$this->Id_Traspaso->setFormValue($objForm->GetValue("x_Id_Traspaso"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Id_Articulo->FldIsDetailKey) {
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		}
		if (!$this->Cantidad->FldIsDetailKey) {
			$this->Cantidad->setFormValue($objForm->GetValue("x_Cantidad"));
		}
		if (!$this->Id_Traspaso_Det->FldIsDetailKey)
			$this->Id_Traspaso_Det->setFormValue($objForm->GetValue("x_Id_Traspaso_Det"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Traspaso_Det->CurrentValue = $this->Id_Traspaso_Det->FormValue;
		$this->Id_Traspaso->CurrentValue = $this->Id_Traspaso->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Cantidad->CurrentValue = $this->Cantidad->FormValue;
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
		$this->Id_Traspaso_Det->setDbValue($rs->fields('Id_Traspaso_Det'));
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Cantidad->setDbValue($rs->fields('Cantidad'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Traspaso_Det
		// Id_Traspaso
		// Codigo
		// Id_Articulo
		// Cantidad
		// TipoArticulo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Traspaso
			$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";

			// Codigo
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_accesorios`";
			$sWhereWrk = "";
			$lookuptblfilter = "TipoArticulo='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Codigo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
				}
			} else {
				$this->Codigo->ViewValue = NULL;
			}
			$this->Codigo->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoArticulo`='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
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

			// Cantidad
			$this->Cantidad->ViewValue = $this->Cantidad->CurrentValue;
			$this->Cantidad->ViewCustomAttributes = "";

			// Id_Traspaso
			$this->Id_Traspaso->LinkCustomAttributes = "";
			$this->Id_Traspaso->HrefValue = "";
			$this->Id_Traspaso->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Cantidad
			$this->Cantidad->LinkCustomAttributes = "";
			$this->Cantidad->HrefValue = "";
			$this->Cantidad->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Traspaso
			$this->Id_Traspaso->EditCustomAttributes = "";
			if ($this->Id_Traspaso->getSessionValue() <> "") {
				$this->Id_Traspaso->CurrentValue = $this->Id_Traspaso->getSessionValue();
			$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
			$this->Id_Traspaso->ViewCustomAttributes = "";
			} else {
			$this->Id_Traspaso->EditValue = ew_HtmlEncode($this->Id_Traspaso->CurrentValue);
			}

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `aux_sel_accesorios`";
			$sWhereWrk = "";
			$lookuptblfilter = "TipoArticulo='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Codigo->EditValue = $arwrk;

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Articulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_articulos`";
			$sWhereWrk = "";
			$lookuptblfilter = "`TipoArticulo`='Accesorio'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Articulo->EditValue = $arwrk;

			// Cantidad
			$this->Cantidad->EditCustomAttributes = "";
			$this->Cantidad->EditValue = ew_HtmlEncode($this->Cantidad->CurrentValue);

			// Edit refer script
			// Id_Traspaso

			$this->Id_Traspaso->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Id_Articulo
			$this->Id_Articulo->HrefValue = "";

			// Cantidad
			$this->Cantidad->HrefValue = "";
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
		if (!is_null($this->Id_Traspaso->FormValue) && $this->Id_Traspaso->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Traspaso->FldCaption());
		}
		if (!ew_CheckInteger($this->Id_Traspaso->FormValue)) {
			ew_AddMessage($gsFormError, $this->Id_Traspaso->FldErrMsg());
		}
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
		}
		if (!is_null($this->Id_Articulo->FormValue) && $this->Id_Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Articulo->FldCaption());
		}
		if (!is_null($this->Cantidad->FormValue) && $this->Cantidad->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Cantidad->FldCaption());
		}
		if (!ew_CheckInteger($this->Cantidad->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad->FldErrMsg());
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

			// Id_Traspaso
			$this->Id_Traspaso->SetDbValueDef($rsnew, $this->Id_Traspaso->CurrentValue, NULL, $this->Id_Traspaso->ReadOnly);

			// Codigo
			$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, $this->Codigo->ReadOnly);

			// Id_Articulo
			$this->Id_Articulo->SetDbValueDef($rsnew, $this->Id_Articulo->CurrentValue, 0, $this->Id_Articulo->ReadOnly);

			// Cantidad
			$this->Cantidad->SetDbValueDef($rsnew, $this->Cantidad->CurrentValue, 0, $this->Cantidad->ReadOnly);

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
			if ($sMasterTblVar == "cap_entrega_accesorio") {
				$bValidMaster = TRUE;
				if (@$_GET["Id_Traspaso"] <> "") {
					$GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->setQueryStringValue($_GET["Id_Traspaso"]);
					$this->Id_Traspaso->setQueryStringValue($GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->QueryStringValue);
					$this->Id_Traspaso->setSessionValue($this->Id_Traspaso->QueryStringValue);
					if (!is_numeric($GLOBALS["cap_entrega_accesorio"]->Id_Traspaso->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cap_entrega_accesorio") {
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
if (!isset($cap_entrega_accesorio_det_edit)) $cap_entrega_accesorio_det_edit = new ccap_entrega_accesorio_det_edit();

// Page init
$cap_entrega_accesorio_det_edit->Page_Init();

// Page main
$cap_entrega_accesorio_det_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_entrega_accesorio_det_edit = new ew_Page("cap_entrega_accesorio_det_edit");
cap_entrega_accesorio_det_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_entrega_accesorio_det_edit.PageID; // For backward compatibility

// Form object
var fcap_entrega_accesorio_detedit = new ew_Form("fcap_entrega_accesorio_detedit");

// Validate form
fcap_entrega_accesorio_detedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Traspaso"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Id_Traspaso->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Traspaso"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_entrega_accesorio_det->Id_Traspaso->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldErrMsg()) ?>");

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
fcap_entrega_accesorio_detedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_accesorio_detedit.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_accesorio_detedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_accesorio_detedit.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":null,"AutoFill":true,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_accesorio_detedit.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":true,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_accesorio_det->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_entrega_accesorio_det->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_entrega_accesorio_det_edit->ShowPageHeader(); ?>
<?php
$cap_entrega_accesorio_det_edit->ShowMessage();
?>
<form name="fcap_entrega_accesorio_detedit" id="fcap_entrega_accesorio_detedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_entrega_accesorio_det">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_accesorio_detedit" class="ewTable">
<?php if ($cap_entrega_accesorio_det->Id_Traspaso->Visible) { // Id_Traspaso ?>
	<tr id="r_Id_Traspaso"<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_accesorio_det_Id_Traspaso"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio_det->Id_Traspaso->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_accesorio_det->Id_Traspaso->CellAttributes() ?>><span id="el_cap_entrega_accesorio_det_Id_Traspaso">
<?php if ($cap_entrega_accesorio_det->Id_Traspaso->getSessionValue() <> "") { ?>
<span<?php echo $cap_entrega_accesorio_det->Id_Traspaso->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Id_Traspaso->ViewValue ?></span>
<input type="hidden" id="x_Id_Traspaso" name="x_Id_Traspaso" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x_Id_Traspaso" id="x_Id_Traspaso" size="30" value="<?php echo $cap_entrega_accesorio_det->Id_Traspaso->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Id_Traspaso->EditAttributes() ?>>
<?php } ?>
</span><?php echo $cap_entrega_accesorio_det->Id_Traspaso->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
	<tr id="r_Codigo"<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_accesorio_det_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio_det->Codigo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_accesorio_det->Codigo->CellAttributes() ?>><span id="el_cap_entrega_accesorio_det_Codigo">
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x_Codigo" name="x_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fcap_entrega_accesorio_detedit.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
$sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
$sWhereWrk = "(`Codigo` = '{query_value}')";
$lookuptblfilter = "TipoArticulo='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Codigo" id="sf_x_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Codigo" id="ln_x_Codigo" value="x_Id_Articulo">
</span><?php echo $cap_entrega_accesorio_det->Codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
	<tr id="r_Id_Articulo"<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_accesorio_det_Id_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio_det->Id_Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_accesorio_det->Id_Articulo->CellAttributes() ?>><span id="el_cap_entrega_accesorio_det_Id_Articulo">
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x_Id_Articulo" name="x_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
$sWhereWrk = "";
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_Id_Articulo" id="s_x_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
$sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
$sWhereWrk = "(`Id_Articulo` = {query_value})";
$lookuptblfilter = "`TipoArticulo`='Accesorio'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Id_Articulo" id="sf_x_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Id_Articulo" id="ln_x_Id_Articulo" value="x_Codigo">
</span><?php echo $cap_entrega_accesorio_det->Id_Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
	<tr id="r_Cantidad"<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_entrega_accesorio_det_Cantidad"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio_det->Cantidad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_entrega_accesorio_det->Cantidad->CellAttributes() ?>><span id="el_cap_entrega_accesorio_det_Cantidad">
<input type="text" name="x_Cantidad" id="x_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
</span><?php echo $cap_entrega_accesorio_det->Cantidad->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_Id_Traspaso_Det" id="x_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso_Det->CurrentValue) ?>">
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_entrega_accesorio_detedit.Init();
</script>
<?php
$cap_entrega_accesorio_det_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_accesorio_det_edit->Page_Terminate();
?>
