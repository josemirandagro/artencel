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

$cap_def_accesorios_delete = NULL; // Initialize page object first

class ccap_def_accesorios_delete extends ccap_def_accesorios {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_def_accesorios';

	// Page object name
	var $PageObjName = 'cap_def_accesorios_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("cap_def_accesorioslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cap_def_accesorioslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cap_def_accesorios class, cap_def_accesoriosinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Articulo'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cap_def_accesorios_delete)) $cap_def_accesorios_delete = new ccap_def_accesorios_delete();

// Page init
$cap_def_accesorios_delete->Page_Init();

// Page main
$cap_def_accesorios_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_def_accesorios_delete = new ew_Page("cap_def_accesorios_delete");
cap_def_accesorios_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = cap_def_accesorios_delete.PageID; // For backward compatibility

// Form object
var fcap_def_accesoriosdelete = new ew_Form("fcap_def_accesoriosdelete");

// Form_CustomValidate event
fcap_def_accesoriosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_accesoriosdelete.ValidateRequired = true;
<?php } else { ?>
fcap_def_accesoriosdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_def_accesoriosdelete.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosdelete.Lists["x_COD_Marca_acc"] = {"LinkField":"x_COD_Marca_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosdelete.Lists["x_COD_Acabado_acc"] = {"LinkField":"x_COD_Acabado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Acabado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosdelete.Lists["x_COD_Tipo_acc"] = {"LinkField":"x_COD_Tipo_acc","Ajax":null,"AutoFill":false,"DisplayFields":["x_Tipo_acc","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosdelete.Lists["x_COD_Equipo_acc"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_accesoriosdelete.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($cap_def_accesorios_delete->Recordset = $cap_def_accesorios_delete->LoadRecordset())
	$cap_def_accesorios_deleteTotalRecs = $cap_def_accesorios_delete->Recordset->RecordCount(); // Get record count
if ($cap_def_accesorios_deleteTotalRecs <= 0) { // No record found, exit
	if ($cap_def_accesorios_delete->Recordset)
		$cap_def_accesorios_delete->Recordset->Close();
	$cap_def_accesorios_delete->Page_Terminate("cap_def_accesorioslist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_def_accesorios->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_def_accesorios->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_def_accesorios_delete->ShowPageHeader(); ?>
<?php
$cap_def_accesorios_delete->ShowMessage();
?>
<form name="fcap_def_accesoriosdelete" id="fcap_def_accesoriosdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="cap_def_accesorios">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cap_def_accesorios_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_def_accesoriosdelete" class="ewTable ewTableSeparate">
<?php echo $cap_def_accesorios->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Fam_Accesorio->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Marca_acc->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Acabado_acc->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Tipo_acc->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->COD_Equipo_acc->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Codigo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Articulo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->BarCode_Externo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_accesorios->Id_Almacen_Entrada->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$cap_def_accesorios_delete->RecCnt = 0;
$i = 0;
while (!$cap_def_accesorios_delete->Recordset->EOF) {
	$cap_def_accesorios_delete->RecCnt++;
	$cap_def_accesorios_delete->RowCnt++;

	// Set row properties
	$cap_def_accesorios->ResetAttrs();
	$cap_def_accesorios->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cap_def_accesorios_delete->LoadRowValues($cap_def_accesorios_delete->Recordset);

	// Render row
	$cap_def_accesorios_delete->RenderRow();
?>
	<tr<?php echo $cap_def_accesorios->RowAttributes() ?>>
		<td<?php echo $cap_def_accesorios->COD_Fam_Accesorio->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_COD_Fam_Accesorio" class="cap_def_accesorios_COD_Fam_Accesorio">
<span<?php echo $cap_def_accesorios->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Fam_Accesorio->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->COD_Marca_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_COD_Marca_acc" class="cap_def_accesorios_COD_Marca_acc">
<span<?php echo $cap_def_accesorios->COD_Marca_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Marca_acc->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->COD_Acabado_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_COD_Acabado_acc" class="cap_def_accesorios_COD_Acabado_acc">
<span<?php echo $cap_def_accesorios->COD_Acabado_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Acabado_acc->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->COD_Tipo_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_COD_Tipo_acc" class="cap_def_accesorios_COD_Tipo_acc">
<span<?php echo $cap_def_accesorios->COD_Tipo_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Tipo_acc->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->COD_Equipo_acc->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_COD_Equipo_acc" class="cap_def_accesorios_COD_Equipo_acc">
<span<?php echo $cap_def_accesorios->COD_Equipo_acc->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->COD_Equipo_acc->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_Codigo" class="cap_def_accesorios_Codigo">
<span<?php echo $cap_def_accesorios->Codigo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Codigo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_Articulo" class="cap_def_accesorios_Articulo">
<span<?php echo $cap_def_accesorios->Articulo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Articulo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->BarCode_Externo->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_BarCode_Externo" class="cap_def_accesorios_BarCode_Externo">
<span<?php echo $cap_def_accesorios->BarCode_Externo->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->BarCode_Externo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_accesorios->Id_Almacen_Entrada->CellAttributes() ?>><span id="el<?php echo $cap_def_accesorios_delete->RowCnt ?>_cap_def_accesorios_Id_Almacen_Entrada" class="cap_def_accesorios_Id_Almacen_Entrada">
<span<?php echo $cap_def_accesorios->Id_Almacen_Entrada->ViewAttributes() ?>>
<?php echo $cap_def_accesorios->Id_Almacen_Entrada->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$cap_def_accesorios_delete->Recordset->MoveNext();
}
$cap_def_accesorios_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fcap_def_accesoriosdelete.Init();
</script>
<?php
$cap_def_accesorios_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_def_accesorios_delete->Page_Terminate();
?>
