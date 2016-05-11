<?php

// Global variable for table object
$cap_datos_reingreso_x_cancelacion_tienda = NULL;

//
// Table class for cap_datos_reingreso_x_cancelacion_tienda
//
class ccap_datos_reingreso_x_cancelacion_tienda extends cTable {
	var $Id_Venta_Eq;
	var $CLIENTE;
	var $Id_Articulo;
	var $Acabado_eq;
	var $Num_IMEI;
	var $Num_ICCID;
	var $Num_CEL;
	var $Causa;
	var $Con_SIM;
	var $Observaciones;
	var $PrecioUnitario;
	var $MontoDescuento;
	var $Precio_SIM;
	var $Monto;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_datos_reingreso_x_cancelacion_tienda';
		$this->TableName = 'cap_datos_reingreso_x_cancelacion_tienda';
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

		// Id_Venta_Eq
		$this->Id_Venta_Eq = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Id_Venta_Eq', 'Id_Venta_Eq', '`Id_Venta_Eq`', '`Id_Venta_Eq`', 3, -1, FALSE, '`Id_Venta_Eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Venta_Eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Venta_Eq'] = &$this->Id_Venta_Eq;

		// CLIENTE
		$this->CLIENTE = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_CLIENTE', 'CLIENTE', '`CLIENTE`', '`CLIENTE`', 200, -1, FALSE, '`CLIENTE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CLIENTE'] = &$this->CLIENTE;

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// Acabado_eq
		$this->Acabado_eq = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Acabado_eq', 'Acabado_eq', '`Acabado_eq`', '`Acabado_eq`', 200, -1, FALSE, '`Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Acabado_eq'] = &$this->Acabado_eq;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// Num_ICCID
		$this->Num_ICCID = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Num_ICCID', 'Num_ICCID', '`Num_ICCID`', '`Num_ICCID`', 200, -1, FALSE, '`Num_ICCID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_ICCID'] = &$this->Num_ICCID;

		// Num_CEL
		$this->Num_CEL = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Num_CEL', 'Num_CEL', '`Num_CEL`', '`Num_CEL`', 200, -1, FALSE, '`Num_CEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_CEL'] = &$this->Num_CEL;

		// Causa
		$this->Causa = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Causa', 'Causa', '`Causa`', '`Causa`', 202, -1, FALSE, '`Causa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Causa'] = &$this->Causa;

		// Con_SIM
		$this->Con_SIM = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Con_SIM', 'Con_SIM', '`Con_SIM`', '`Con_SIM`', 202, -1, FALSE, '`Con_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Con_SIM'] = &$this->Con_SIM;

		// Observaciones
		$this->Observaciones = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Observaciones', 'Observaciones', '`Observaciones`', '`Observaciones`', 200, -1, FALSE, '`Observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Observaciones'] = &$this->Observaciones;

		// PrecioUnitario
		$this->PrecioUnitario = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_PrecioUnitario', 'PrecioUnitario', '`PrecioUnitario`', '`PrecioUnitario`', 131, -1, FALSE, '`PrecioUnitario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->PrecioUnitario->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['PrecioUnitario'] = &$this->PrecioUnitario;

		// MontoDescuento
		$this->MontoDescuento = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_MontoDescuento', 'MontoDescuento', '`MontoDescuento`', '`MontoDescuento`', 131, -1, FALSE, '`MontoDescuento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->MontoDescuento->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['MontoDescuento'] = &$this->MontoDescuento;

		// Precio_SIM
		$this->Precio_SIM = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Precio_SIM', 'Precio_SIM', '`Precio_SIM`', '`Precio_SIM`', 131, -1, FALSE, '`Precio_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_SIM'] = &$this->Precio_SIM;

		// Monto
		$this->Monto = new cField('cap_datos_reingreso_x_cancelacion_tienda', 'cap_datos_reingreso_x_cancelacion_tienda', 'x_Monto', 'Monto', '`Monto`', '`Monto`', 131, -1, FALSE, '`Monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Monto'] = &$this->Monto;
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`cap_datos_reingreso_x_cancelacion_tienda`";
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
		return "";
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
	var $UpdateTable = "`cap_datos_reingreso_x_cancelacion_tienda`";

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
			$sql .= ew_QuotedName('Id_Venta_Eq') . '=' . ew_QuotedValue($rs['Id_Venta_Eq'], $this->Id_Venta_Eq->FldDataType) . ' AND ';
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
		return "`Id_Venta_Eq` = @Id_Venta_Eq@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Venta_Eq->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Venta_Eq@", ew_AdjustSql($this->Id_Venta_Eq->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_datos_reingreso_x_cancelacion_tiendalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_datos_reingreso_x_cancelacion_tiendalist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_datos_reingreso_x_cancelacion_tiendaview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_datos_reingreso_x_cancelacion_tiendaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_datos_reingreso_x_cancelacion_tiendaedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_datos_reingreso_x_cancelacion_tiendaadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_datos_reingreso_x_cancelacion_tiendadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Venta_Eq->CurrentValue)) {
			$sUrl .= "Id_Venta_Eq=" . urlencode($this->Id_Venta_Eq->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Venta_Eq"]; // Id_Venta_Eq

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
			$this->Id_Venta_Eq->CurrentValue = $key;
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
		$this->Id_Venta_Eq->setDbValue($rs->fields('Id_Venta_Eq'));
		$this->CLIENTE->setDbValue($rs->fields('CLIENTE'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Causa->setDbValue($rs->fields('Causa'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->PrecioUnitario->setDbValue($rs->fields('PrecioUnitario'));
		$this->MontoDescuento->setDbValue($rs->fields('MontoDescuento'));
		$this->Precio_SIM->setDbValue($rs->fields('Precio_SIM'));
		$this->Monto->setDbValue($rs->fields('Monto'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Venta_Eq
		// CLIENTE
		// Id_Articulo
		// Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Causa
		// Con_SIM
		// Observaciones
		// PrecioUnitario
		// MontoDescuento
		// Precio_SIM
		// Monto
		// Id_Venta_Eq

		$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
		$this->Id_Venta_Eq->ViewCustomAttributes = "";

		// CLIENTE
		$this->CLIENTE->ViewValue = $this->CLIENTE->CurrentValue;
		$this->CLIENTE->ViewCustomAttributes = "";

		// Id_Articulo
		if (strval($this->Id_Articulo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Articulo`";
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

		// Acabado_eq
		$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
		$this->Acabado_eq->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// Num_ICCID
		$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
		$this->Num_ICCID->ViewCustomAttributes = "";

		// Num_CEL
		$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
		$this->Num_CEL->ViewCustomAttributes = "";

		// Causa
		if (strval($this->Causa->CurrentValue) <> "") {
			switch ($this->Causa->CurrentValue) {
				case $this->Causa->FldTagValue(1):
					$this->Causa->ViewValue = $this->Causa->FldTagCaption(1) <> "" ? $this->Causa->FldTagCaption(1) : $this->Causa->CurrentValue;
					break;
				case $this->Causa->FldTagValue(2):
					$this->Causa->ViewValue = $this->Causa->FldTagCaption(2) <> "" ? $this->Causa->FldTagCaption(2) : $this->Causa->CurrentValue;
					break;
				case $this->Causa->FldTagValue(3):
					$this->Causa->ViewValue = $this->Causa->FldTagCaption(3) <> "" ? $this->Causa->FldTagCaption(3) : $this->Causa->CurrentValue;
					break;
				case $this->Causa->FldTagValue(4):
					$this->Causa->ViewValue = $this->Causa->FldTagCaption(4) <> "" ? $this->Causa->FldTagCaption(4) : $this->Causa->CurrentValue;
					break;
				default:
					$this->Causa->ViewValue = $this->Causa->CurrentValue;
			}
		} else {
			$this->Causa->ViewValue = NULL;
		}
		$this->Causa->ViewCustomAttributes = "";

		// Con_SIM
		if (strval($this->Con_SIM->CurrentValue) <> "") {
			switch ($this->Con_SIM->CurrentValue) {
				case $this->Con_SIM->FldTagValue(1):
					$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
					break;
				case $this->Con_SIM->FldTagValue(2):
					$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
					break;
				default:
					$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
			}
		} else {
			$this->Con_SIM->ViewValue = NULL;
		}
		$this->Con_SIM->ViewCustomAttributes = "";

		// Observaciones
		$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
		$this->Observaciones->ViewCustomAttributes = "";

		// PrecioUnitario
		$this->PrecioUnitario->ViewValue = $this->PrecioUnitario->CurrentValue;
		$this->PrecioUnitario->ViewCustomAttributes = "";

		// MontoDescuento
		$this->MontoDescuento->ViewValue = $this->MontoDescuento->CurrentValue;
		$this->MontoDescuento->ViewCustomAttributes = "";

		// Precio_SIM
		$this->Precio_SIM->ViewValue = $this->Precio_SIM->CurrentValue;
		$this->Precio_SIM->ViewCustomAttributes = "";

		// Monto
		$this->Monto->ViewValue = $this->Monto->CurrentValue;
		$this->Monto->ViewCustomAttributes = "";

		// Id_Venta_Eq
		$this->Id_Venta_Eq->LinkCustomAttributes = "";
		$this->Id_Venta_Eq->HrefValue = "";
		$this->Id_Venta_Eq->TooltipValue = "";

		// CLIENTE
		$this->CLIENTE->LinkCustomAttributes = "";
		$this->CLIENTE->HrefValue = "";
		$this->CLIENTE->TooltipValue = "";

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// Acabado_eq
		$this->Acabado_eq->LinkCustomAttributes = "";
		$this->Acabado_eq->HrefValue = "";
		$this->Acabado_eq->TooltipValue = "";

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

		// Causa
		$this->Causa->LinkCustomAttributes = "";
		$this->Causa->HrefValue = "";
		$this->Causa->TooltipValue = "";

		// Con_SIM
		$this->Con_SIM->LinkCustomAttributes = "";
		$this->Con_SIM->HrefValue = "";
		$this->Con_SIM->TooltipValue = "";

		// Observaciones
		$this->Observaciones->LinkCustomAttributes = "";
		$this->Observaciones->HrefValue = "";
		$this->Observaciones->TooltipValue = "";

		// PrecioUnitario
		$this->PrecioUnitario->LinkCustomAttributes = "";
		$this->PrecioUnitario->HrefValue = "";
		$this->PrecioUnitario->TooltipValue = "";

		// MontoDescuento
		$this->MontoDescuento->LinkCustomAttributes = "";
		$this->MontoDescuento->HrefValue = "";
		$this->MontoDescuento->TooltipValue = "";

		// Precio_SIM
		$this->Precio_SIM->LinkCustomAttributes = "";
		$this->Precio_SIM->HrefValue = "";
		$this->Precio_SIM->TooltipValue = "";

		// Monto
		$this->Monto->LinkCustomAttributes = "";
		$this->Monto->HrefValue = "";
		$this->Monto->TooltipValue = "";

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
				if ($this->Id_Venta_Eq->Exportable) $Doc->ExportCaption($this->Id_Venta_Eq);
				if ($this->CLIENTE->Exportable) $Doc->ExportCaption($this->CLIENTE);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Acabado_eq->Exportable) $Doc->ExportCaption($this->Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Causa->Exportable) $Doc->ExportCaption($this->Causa);
				if ($this->Con_SIM->Exportable) $Doc->ExportCaption($this->Con_SIM);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->PrecioUnitario->Exportable) $Doc->ExportCaption($this->PrecioUnitario);
				if ($this->MontoDescuento->Exportable) $Doc->ExportCaption($this->MontoDescuento);
				if ($this->Precio_SIM->Exportable) $Doc->ExportCaption($this->Precio_SIM);
				if ($this->Monto->Exportable) $Doc->ExportCaption($this->Monto);
			} else {
				if ($this->Id_Venta_Eq->Exportable) $Doc->ExportCaption($this->Id_Venta_Eq);
				if ($this->CLIENTE->Exportable) $Doc->ExportCaption($this->CLIENTE);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Acabado_eq->Exportable) $Doc->ExportCaption($this->Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Causa->Exportable) $Doc->ExportCaption($this->Causa);
				if ($this->Con_SIM->Exportable) $Doc->ExportCaption($this->Con_SIM);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->PrecioUnitario->Exportable) $Doc->ExportCaption($this->PrecioUnitario);
				if ($this->MontoDescuento->Exportable) $Doc->ExportCaption($this->MontoDescuento);
				if ($this->Precio_SIM->Exportable) $Doc->ExportCaption($this->Precio_SIM);
				if ($this->Monto->Exportable) $Doc->ExportCaption($this->Monto);
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
					if ($this->Id_Venta_Eq->Exportable) $Doc->ExportField($this->Id_Venta_Eq);
					if ($this->CLIENTE->Exportable) $Doc->ExportField($this->CLIENTE);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Acabado_eq->Exportable) $Doc->ExportField($this->Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Causa->Exportable) $Doc->ExportField($this->Causa);
					if ($this->Con_SIM->Exportable) $Doc->ExportField($this->Con_SIM);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->PrecioUnitario->Exportable) $Doc->ExportField($this->PrecioUnitario);
					if ($this->MontoDescuento->Exportable) $Doc->ExportField($this->MontoDescuento);
					if ($this->Precio_SIM->Exportable) $Doc->ExportField($this->Precio_SIM);
					if ($this->Monto->Exportable) $Doc->ExportField($this->Monto);
				} else {
					if ($this->Id_Venta_Eq->Exportable) $Doc->ExportField($this->Id_Venta_Eq);
					if ($this->CLIENTE->Exportable) $Doc->ExportField($this->CLIENTE);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Acabado_eq->Exportable) $Doc->ExportField($this->Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Causa->Exportable) $Doc->ExportField($this->Causa);
					if ($this->Con_SIM->Exportable) $Doc->ExportField($this->Con_SIM);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->PrecioUnitario->Exportable) $Doc->ExportField($this->PrecioUnitario);
					if ($this->MontoDescuento->Exportable) $Doc->ExportField($this->MontoDescuento);
					if ($this->Precio_SIM->Exportable) $Doc->ExportField($this->Precio_SIM);
					if ($this->Monto->Exportable) $Doc->ExportField($this->Monto);
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

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	  if ($rsnew['Con_SIM']=='NO') {
	   DB_Ejecuta ("UPDATE reg_unico_tel_sim SET Num_ICCID=NULL,Num_CEL=NULL WHERE Num_IMEI='".$rsold['Num_IMEI']."'");   
	  }    

	  // OJO ..Hay que ver si hubo cambio en CON_SIM, Si hubo de KIT o Migracion a libre, hay que poner
	  // el CHIP com libre en reg_unico
	  // al guardar cap_datos_reingreso_x_cancelacion_tienda

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
