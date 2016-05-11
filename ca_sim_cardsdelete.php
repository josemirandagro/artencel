<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_sim_cardsinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_sim_cards_delete = NULL; // Initialize page object first

class cca_sim_cards_delete extends cca_sim_cards {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_sim_cards';

	// Page object name
	var $PageObjName = 'ca_sim_cards_delete';

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

		// Table object (ca_sim_cards)
		if (!isset($GLOBALS["ca_sim_cards"])) {
			$GLOBALS["ca_sim_cards"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_sim_cards"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_sim_cards', TRUE);

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
			$this->Page_Terminate("ca_sim_cardslist.php");
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
			$this->Page_Terminate("ca_sim_cardslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ca_sim_cards class, ca_sim_cardsinfo.php

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
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Amigo_CHIP->setDbValue($rs->fields('Amigo_CHIP'));
		$this->Activacion_Movi->setDbValue($rs->fields('Activacion_Movi'));
		$this->Precio_compra->setDbValue($rs->fields('Precio_compra'));
		$this->Precio_lista_venta_publico_1->setDbValue($rs->fields('Precio_lista_venta_publico_1'));
		$this->Precio_lista_venta_publico_2->setDbValue($rs->fields('Precio_lista_venta_publico_2'));
		$this->Precio_lista_venta_publico_3->setDbValue($rs->fields('Precio_lista_venta_publico_3'));
		$this->Precio_lista_venta_medio_mayoreo->setDbValue($rs->fields('Precio_lista_venta_medio_mayoreo'));
		$this->Precio_lista_venta_mayoreo->setDbValue($rs->fields('Precio_lista_venta_mayoreo'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
		$this->Status->setDbValue($rs->fields('Status'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Precio_compra->FormValue == $this->Precio_compra->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_compra->CurrentValue)))
			$this->Precio_compra->CurrentValue = ew_StrToFloat($this->Precio_compra->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_1->FormValue == $this->Precio_lista_venta_publico_1->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue)))
			$this->Precio_lista_venta_publico_1->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_1->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_publico_2->FormValue == $this->Precio_lista_venta_publico_2->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue)))
			$this->Precio_lista_venta_publico_2->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_publico_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_medio_mayoreo->FormValue == $this->Precio_lista_venta_medio_mayoreo->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_medio_mayoreo->CurrentValue)))
			$this->Precio_lista_venta_medio_mayoreo->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_medio_mayoreo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Precio_lista_venta_mayoreo->FormValue == $this->Precio_lista_venta_mayoreo->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_lista_venta_mayoreo->CurrentValue)))
			$this->Precio_lista_venta_mayoreo->CurrentValue = ew_StrToFloat($this->Precio_lista_venta_mayoreo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Articulo
		// Articulo
		// Codigo
		// COD_Compania_eq
		// Amigo_CHIP
		// Activacion_Movi
		// Precio_compra
		// Precio_lista_venta_publico_1
		// Precio_lista_venta_publico_2
		// Precio_lista_venta_publico_3
		// Precio_lista_venta_medio_mayoreo
		// Precio_lista_venta_mayoreo
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// Id_Almacen_Entrada
		// Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->ViewValue = NULL;
			}
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			if (strval($this->Codigo->CurrentValue) <> "") {
				$sFilterWrk = "`Codigo`" . ew_SearchString("=", $this->Codigo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Codigo`, `Codigo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_lista_precios_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Codigo` Asc";
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

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// Amigo_CHIP
			if (strval($this->Amigo_CHIP->CurrentValue) <> "") {
				switch ($this->Amigo_CHIP->CurrentValue) {
					case $this->Amigo_CHIP->FldTagValue(1):
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->FldTagCaption(1) <> "" ? $this->Amigo_CHIP->FldTagCaption(1) : $this->Amigo_CHIP->CurrentValue;
						break;
					case $this->Amigo_CHIP->FldTagValue(2):
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->FldTagCaption(2) <> "" ? $this->Amigo_CHIP->FldTagCaption(2) : $this->Amigo_CHIP->CurrentValue;
						break;
					default:
						$this->Amigo_CHIP->ViewValue = $this->Amigo_CHIP->CurrentValue;
				}
			} else {
				$this->Amigo_CHIP->ViewValue = NULL;
			}
			$this->Amigo_CHIP->ViewCustomAttributes = "";

			// Activacion_Movi
			if (strval($this->Activacion_Movi->CurrentValue) <> "") {
				switch ($this->Activacion_Movi->CurrentValue) {
					case $this->Activacion_Movi->FldTagValue(1):
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->FldTagCaption(1) <> "" ? $this->Activacion_Movi->FldTagCaption(1) : $this->Activacion_Movi->CurrentValue;
						break;
					case $this->Activacion_Movi->FldTagValue(2):
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->FldTagCaption(2) <> "" ? $this->Activacion_Movi->FldTagCaption(2) : $this->Activacion_Movi->CurrentValue;
						break;
					default:
						$this->Activacion_Movi->ViewValue = $this->Activacion_Movi->CurrentValue;
				}
			} else {
				$this->Activacion_Movi->ViewValue = NULL;
			}
			$this->Activacion_Movi->ViewCustomAttributes = "";

			// Precio_compra
			$this->Precio_compra->ViewValue = $this->Precio_compra->CurrentValue;
			$this->Precio_compra->ViewValue = ew_FormatCurrency($this->Precio_compra->ViewValue, 2, -2, -2, -2);
			$this->Precio_compra->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->ViewValue = $this->Precio_lista_venta_publico_1->CurrentValue;
			$this->Precio_lista_venta_publico_1->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_publico_1->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_publico_1->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->ViewValue = $this->Precio_lista_venta_publico_2->CurrentValue;
			$this->Precio_lista_venta_publico_2->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_publico_2->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_publico_2->ViewCustomAttributes = "";

			// Precio_lista_venta_publico_3
			$this->Precio_lista_venta_publico_3->ViewValue = $this->Precio_lista_venta_publico_3->CurrentValue;
			$this->Precio_lista_venta_publico_3->ViewCustomAttributes = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->ViewValue = $this->Precio_lista_venta_medio_mayoreo->CurrentValue;
			$this->Precio_lista_venta_medio_mayoreo->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_medio_mayoreo->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_medio_mayoreo->ViewCustomAttributes = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->ViewValue = $this->Precio_lista_venta_mayoreo->CurrentValue;
			$this->Precio_lista_venta_mayoreo->ViewValue = ew_FormatCurrency($this->Precio_lista_venta_mayoreo->ViewValue, 2, -2, -2, -2);
			$this->Precio_lista_venta_mayoreo->ViewCustomAttributes = "";

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

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";

			// Amigo_CHIP
			$this->Amigo_CHIP->LinkCustomAttributes = "";
			$this->Amigo_CHIP->HrefValue = "";
			$this->Amigo_CHIP->TooltipValue = "";

			// Activacion_Movi
			$this->Activacion_Movi->LinkCustomAttributes = "";
			$this->Activacion_Movi->HrefValue = "";
			$this->Activacion_Movi->TooltipValue = "";

			// Precio_compra
			$this->Precio_compra->LinkCustomAttributes = "";
			$this->Precio_compra->HrefValue = "";
			$this->Precio_compra->TooltipValue = "";

			// Precio_lista_venta_publico_1
			$this->Precio_lista_venta_publico_1->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_1->HrefValue = "";
			$this->Precio_lista_venta_publico_1->TooltipValue = "";

			// Precio_lista_venta_publico_2
			$this->Precio_lista_venta_publico_2->LinkCustomAttributes = "";
			$this->Precio_lista_venta_publico_2->HrefValue = "";
			$this->Precio_lista_venta_publico_2->TooltipValue = "";

			// Precio_lista_venta_medio_mayoreo
			$this->Precio_lista_venta_medio_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_medio_mayoreo->TooltipValue = "";

			// Precio_lista_venta_mayoreo
			$this->Precio_lista_venta_mayoreo->LinkCustomAttributes = "";
			$this->Precio_lista_venta_mayoreo->HrefValue = "";
			$this->Precio_lista_venta_mayoreo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";
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
if (!isset($ca_sim_cards_delete)) $ca_sim_cards_delete = new cca_sim_cards_delete();

// Page init
$ca_sim_cards_delete->Page_Init();

// Page main
$ca_sim_cards_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_sim_cards_delete = new ew_Page("ca_sim_cards_delete");
ca_sim_cards_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = ca_sim_cards_delete.PageID; // For backward compatibility

// Form object
var fca_sim_cardsdelete = new ew_Form("fca_sim_cardsdelete");

// Form_CustomValidate event
fca_sim_cardsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_sim_cardsdelete.ValidateRequired = true;
<?php } else { ?>
fca_sim_cardsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_sim_cardsdelete.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardsdelete.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardsdelete.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fca_sim_cardsdelete.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($ca_sim_cards_delete->Recordset = $ca_sim_cards_delete->LoadRecordset())
	$ca_sim_cards_deleteTotalRecs = $ca_sim_cards_delete->Recordset->RecordCount(); // Get record count
if ($ca_sim_cards_deleteTotalRecs <= 0) { // No record found, exit
	if ($ca_sim_cards_delete->Recordset)
		$ca_sim_cards_delete->Recordset->Close();
	$ca_sim_cards_delete->Page_Terminate("ca_sim_cardslist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $ca_sim_cards->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $ca_sim_cards->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $ca_sim_cards_delete->ShowPageHeader(); ?>
<?php
$ca_sim_cards_delete->ShowMessage();
?>
<form name="fca_sim_cardsdelete" id="fca_sim_cardsdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="ca_sim_cards">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ca_sim_cards_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_ca_sim_cardsdelete" class="ewTable ewTableSeparate">
<?php echo $ca_sim_cards->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Articulo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Codigo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->COD_Compania_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Amigo_CHIP->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Activacion_Movi->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Precio_compra->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_publico_1->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_publico_2->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Id_Almacen_Entrada->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_ca_sim_cards_Status" class="ca_sim_cards_Status"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_sim_cards->Status->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$ca_sim_cards_delete->RecCnt = 0;
$i = 0;
while (!$ca_sim_cards_delete->Recordset->EOF) {
	$ca_sim_cards_delete->RecCnt++;
	$ca_sim_cards_delete->RowCnt++;

	// Set row properties
	$ca_sim_cards->ResetAttrs();
	$ca_sim_cards->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ca_sim_cards_delete->LoadRowValues($ca_sim_cards_delete->Recordset);

	// Render row
	$ca_sim_cards_delete->RenderRow();
?>
	<tr<?php echo $ca_sim_cards->RowAttributes() ?>>
		<td<?php echo $ca_sim_cards->Articulo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Articulo" class="ca_sim_cards_Articulo">
<span<?php echo $ca_sim_cards->Articulo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Articulo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Codigo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Codigo" class="ca_sim_cards_Codigo">
<span<?php echo $ca_sim_cards->Codigo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Codigo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->COD_Compania_eq->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_COD_Compania_eq" class="ca_sim_cards_COD_Compania_eq">
<span<?php echo $ca_sim_cards->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $ca_sim_cards->COD_Compania_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Amigo_CHIP->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Amigo_CHIP" class="ca_sim_cards_Amigo_CHIP">
<span<?php echo $ca_sim_cards->Amigo_CHIP->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Amigo_CHIP->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Activacion_Movi->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Activacion_Movi" class="ca_sim_cards_Activacion_Movi">
<span<?php echo $ca_sim_cards->Activacion_Movi->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Activacion_Movi->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Precio_compra->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Precio_compra" class="ca_sim_cards_Precio_compra">
<span<?php echo $ca_sim_cards->Precio_compra->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_compra->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_1" class="ca_sim_cards_Precio_lista_venta_publico_1">
<span<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_publico_1->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Precio_lista_venta_publico_2" class="ca_sim_cards_Precio_lista_venta_publico_2">
<span<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_publico_2->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Precio_lista_venta_medio_mayoreo" class="ca_sim_cards_Precio_lista_venta_medio_mayoreo">
<span<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_medio_mayoreo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Precio_lista_venta_mayoreo" class="ca_sim_cards_Precio_lista_venta_mayoreo">
<span<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Precio_lista_venta_mayoreo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Id_Almacen_Entrada->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Id_Almacen_Entrada" class="ca_sim_cards_Id_Almacen_Entrada">
<span<?php echo $ca_sim_cards->Id_Almacen_Entrada->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Id_Almacen_Entrada->ListViewValue() ?></span>
</span></td>
		<td<?php echo $ca_sim_cards->Status->CellAttributes() ?>><span id="el<?php echo $ca_sim_cards_delete->RowCnt ?>_ca_sim_cards_Status" class="ca_sim_cards_Status">
<span<?php echo $ca_sim_cards->Status->ViewAttributes() ?>>
<?php echo $ca_sim_cards->Status->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$ca_sim_cards_delete->Recordset->MoveNext();
}
$ca_sim_cards_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fca_sim_cardsdelete.Init();
</script>
<?php
$ca_sim_cards_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_sim_cards_delete->Page_Terminate();
?>
