<?php

// Global variable for table object
$cap_recep_accesorio = NULL;

//
// Table class for cap_recep_accesorio
//
class ccap_recep_accesorio extends cTable {
	var $Id_Compra;
	var $Id_Proveedor;
	var $FechaEntrega;
	var $Observaciones;
	var $MontoTotal;
	var $Status_Recepcion;
	var $TipoArticulo;
	var $Id_Empleado_Recibe;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_recep_accesorio';
		$this->TableName = 'cap_recep_accesorio';
		$this->TableType = 'VIEW';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Id_Compra
		$this->Id_Compra = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_Id_Compra', 'Id_Compra', '`Id_Compra`', '`Id_Compra`', 3, -1, FALSE, '`Id_Compra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Compra->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Compra'] = &$this->Id_Compra;

		// Id_Proveedor
		$this->Id_Proveedor = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_Id_Proveedor', 'Id_Proveedor', '`Id_Proveedor`', '`Id_Proveedor`', 3, -1, FALSE, '`Id_Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Proveedor'] = &$this->Id_Proveedor;

		// FechaEntrega
		$this->FechaEntrega = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_FechaEntrega', 'FechaEntrega', '`FechaEntrega`', 'DATE_FORMAT(`FechaEntrega`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaEntrega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaEntrega->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaEntrega'] = &$this->FechaEntrega;

		// Observaciones
		$this->Observaciones = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_Observaciones', 'Observaciones', '`Observaciones`', '`Observaciones`', 200, -1, FALSE, '`Observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Observaciones'] = &$this->Observaciones;

		// MontoTotal
		$this->MontoTotal = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_MontoTotal', 'MontoTotal', '`MontoTotal`', '`MontoTotal`', 131, -1, FALSE, '`MontoTotal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->MontoTotal->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['MontoTotal'] = &$this->MontoTotal;

		// Status_Recepcion
		$this->Status_Recepcion = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_Status_Recepcion', 'Status_Recepcion', '`Status_Recepcion`', '`Status_Recepcion`', 202, -1, FALSE, '`Status_Recepcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status_Recepcion'] = &$this->Status_Recepcion;

		// TipoArticulo
		$this->TipoArticulo = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_TipoArticulo', 'TipoArticulo', '`TipoArticulo`', '`TipoArticulo`', 202, -1, FALSE, '`TipoArticulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['TipoArticulo'] = &$this->TipoArticulo;

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe = new cField('cap_recep_accesorio', 'cap_recep_accesorio', 'x_Id_Empleado_Recibe', 'Id_Empleado_Recibe', '`Id_Empleado_Recibe`', '`Id_Empleado_Recibe`', 3, -1, FALSE, '`Id_Empleado_Recibe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Empleado_Recibe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Empleado_Recibe'] = &$this->Id_Empleado_Recibe;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "cap_recep_accesorio_detail") {
			$sDetailUrl = $GLOBALS["cap_recep_accesorio_detail"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&Id_Compra=" . $this->Id_Compra->CurrentValue;
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`cap_recep_accesorio`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`FechaEntrega` DESC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		return TRUE;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`cap_recep_accesorio`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			$sql .= ew_QuotedName('Id_Compra') . '=' . ew_QuotedValue($rs['Id_Compra'], $this->Id_Compra->FldDataType) . ' AND ';
		}
		if (substr($sql, -5) == " AND ") $sql = substr($sql, 0, -5);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " AND " . $filter;
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Id_Compra` = @Id_Compra@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Compra->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Compra@", ew_AdjustSql($this->Id_Compra->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "cap_recep_accesoriolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_recep_accesoriolist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_recep_accesorioview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_recep_accesorioadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("cap_recep_accesorioedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("cap_recep_accesorioedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("cap_recep_accesorioadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("cap_recep_accesorioadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_recep_accesoriodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Compra->CurrentValue)) {
			$sUrl .= "Id_Compra=" . urlencode($this->Id_Compra->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["Id_Compra"]; // Id_Compra

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Id_Compra->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->FechaEntrega->setDbValue($rs->fields('FechaEntrega'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->MontoTotal->setDbValue($rs->fields('MontoTotal'));
		$this->Status_Recepcion->setDbValue($rs->fields('Status_Recepcion'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Empleado_Recibe->setDbValue($rs->fields('Id_Empleado_Recibe'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Compra
		// Id_Proveedor
		// FechaEntrega
		// Observaciones

		$this->Observaciones->CellCssStyle = "white-space: nowrap;";

		// MontoTotal
		// Status_Recepcion

		$this->Status_Recepcion->CellCssStyle = "white-space: nowrap;";

		// TipoArticulo
		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe->CellCssStyle = "white-space: nowrap;";

		// Id_Compra
		$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
		$this->Id_Compra->ViewCustomAttributes = "";

		// Id_Proveedor
		if (strval($this->Id_Proveedor->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `RazonSocial` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Proveedor->ViewValue = strtoupper($rswrk->fields('DispFld'));
				$rswrk->Close();
			} else {
				$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
			}
		} else {
			$this->Id_Proveedor->ViewValue = NULL;
		}
		$this->Id_Proveedor->ViewCustomAttributes = "";

		// FechaEntrega
		$this->FechaEntrega->ViewValue = $this->FechaEntrega->CurrentValue;
		$this->FechaEntrega->ViewValue = ew_FormatDateTime($this->FechaEntrega->ViewValue, 7);
		$this->FechaEntrega->ViewCustomAttributes = "";

		// Observaciones
		$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
		$this->Observaciones->ViewCustomAttributes = "";

		// MontoTotal
		$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
		$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
		$this->MontoTotal->ViewCustomAttributes = "";

		// Status_Recepcion
		if (strval($this->Status_Recepcion->CurrentValue) <> "") {
			switch ($this->Status_Recepcion->CurrentValue) {
				case $this->Status_Recepcion->FldTagValue(1):
					$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(1) <> "" ? $this->Status_Recepcion->FldTagCaption(1) : $this->Status_Recepcion->CurrentValue;
					break;
				case $this->Status_Recepcion->FldTagValue(2):
					$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(2) <> "" ? $this->Status_Recepcion->FldTagCaption(2) : $this->Status_Recepcion->CurrentValue;
					break;
				case $this->Status_Recepcion->FldTagValue(3):
					$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(3) <> "" ? $this->Status_Recepcion->FldTagCaption(3) : $this->Status_Recepcion->CurrentValue;
					break;
				default:
					$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->CurrentValue;
			}
		} else {
			$this->Status_Recepcion->ViewValue = NULL;
		}
		$this->Status_Recepcion->ViewCustomAttributes = "";

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

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe->ViewValue = $this->Id_Empleado_Recibe->CurrentValue;
		$this->Id_Empleado_Recibe->ViewCustomAttributes = "";

		// Id_Compra
		$this->Id_Compra->LinkCustomAttributes = "";
		$this->Id_Compra->HrefValue = "";
		$this->Id_Compra->TooltipValue = "";

		// Id_Proveedor
		$this->Id_Proveedor->LinkCustomAttributes = "";
		$this->Id_Proveedor->HrefValue = "";
		$this->Id_Proveedor->TooltipValue = "";

		// FechaEntrega
		$this->FechaEntrega->LinkCustomAttributes = "";
		$this->FechaEntrega->HrefValue = "";
		$this->FechaEntrega->TooltipValue = "";

		// Observaciones
		$this->Observaciones->LinkCustomAttributes = "";
		$this->Observaciones->HrefValue = "";
		$this->Observaciones->TooltipValue = "";

		// MontoTotal
		$this->MontoTotal->LinkCustomAttributes = "";
		$this->MontoTotal->HrefValue = "";
		$this->MontoTotal->TooltipValue = "";

		// Status_Recepcion
		$this->Status_Recepcion->LinkCustomAttributes = "";
		$this->Status_Recepcion->HrefValue = "";
		$this->Status_Recepcion->TooltipValue = "";

		// TipoArticulo
		$this->TipoArticulo->LinkCustomAttributes = "";
		$this->TipoArticulo->HrefValue = "";
		$this->TipoArticulo->TooltipValue = "";

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe->LinkCustomAttributes = "";
		$this->Id_Empleado_Recibe->HrefValue = "";
		$this->Id_Empleado_Recibe->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
				if ($this->FechaEntrega->Exportable) $Doc->ExportCaption($this->FechaEntrega);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->MontoTotal->Exportable) $Doc->ExportCaption($this->MontoTotal);
			} else {
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
				if ($this->FechaEntrega->Exportable) $Doc->ExportCaption($this->FechaEntrega);
				if ($this->MontoTotal->Exportable) $Doc->ExportCaption($this->MontoTotal);
				if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportCaption($this->Id_Empleado_Recibe);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
					if ($this->FechaEntrega->Exportable) $Doc->ExportField($this->FechaEntrega);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->MontoTotal->Exportable) $Doc->ExportField($this->MontoTotal);
				} else {
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
					if ($this->FechaEntrega->Exportable) $Doc->ExportField($this->FechaEntrega);
					if ($this->MontoTotal->Exportable) $Doc->ExportField($this->MontoTotal);
					if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportField($this->Id_Empleado_Recibe);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {
	  $rsnew['TipoArticulo']="Accesorio";   
	  return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

	// == Si el STATUS INICIAL es RECIBIDO hacemos el registro de entrada a Almacen Central
	  if  ($rsnew['Status_Recepcion']== "Recibido") {           
		RegistraEntradasXRecepcion($rsnew['Id_Compra']);        
	  } // if  ($rsnew['Recibido'])
	}                    

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

	/*   

		// Si el cambio fue A RECIBIDO hacemos el registro de entrada a Almacen Central
	  if  ($rsnew['Status_Recepcion']=="Recibido") {
		if ($rsold['Status_Recepcion']=="Registrado") { // Si el Status Anterior era REGISTRADO
		  RegistraEntradasXRecepcion($rsold['Id_Compra']); // Hay que Ingresar los articulos al Almacen
		  DB_Ejecuta("UPDATE doc_compra_det set Status_Recepcion='Inventariado' WHERE Id_Compra=".$rsold['Id_Compra'] ,1,false);      
		}                 

	  // Si el Status Anterior era ETIQUETADO, es que se equivocaron y ponemos los renglones como 'Recibido', si afectar existencias
		if ($rsold['Status_Recepcion']=="Etiquetado") {          
		  DB_Ejecuta("UPDATE doc_compra_det set Status_Recepcion='Inventariado' WHERE Id_Compra=".$rsold['Id_Compra'] ,1,false);     
		}  
	  } // if  ($rsnew['Recibido'])
	*/  
	}                                                                  

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
