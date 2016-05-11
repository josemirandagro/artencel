<?php

// Global variable for table object
$cap_inventario_inicial_tienda = NULL;

//
// Table class for cap_inventario_inicial_tienda
//
class ccap_inventario_inicial_tienda extends cTable {
	var $Id_Tel_SIM;
	var $Id_Articulo;
	var $Id_Acabado_eq;
	var $Num_IMEI;
	var $Num_ICCID;
	var $Num_CEL;
	var $Id_Almacen;
	var $Id_Usuario;
	var $TipoArticulo;
	var $Id_Proveedor;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_inventario_inicial_tienda';
		$this->TableName = 'cap_inventario_inicial_tienda';
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

		// Id_Tel_SIM
		$this->Id_Tel_SIM = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 19, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// Id_Acabado_eq
		$this->Id_Acabado_eq = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Acabado_eq', 'Id_Acabado_eq', '`Id_Acabado_eq`', '`Id_Acabado_eq`', 3, -1, FALSE, '`Id_Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Acabado_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Acabado_eq'] = &$this->Id_Acabado_eq;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// Num_ICCID
		$this->Num_ICCID = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Num_ICCID', 'Num_ICCID', '`Num_ICCID`', '`Num_ICCID`', 200, -1, FALSE, '`Num_ICCID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_ICCID'] = &$this->Num_ICCID;

		// Num_CEL
		$this->Num_CEL = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Num_CEL', 'Num_CEL', '`Num_CEL`', '`Num_CEL`', 200, -1, FALSE, '`Num_CEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_CEL'] = &$this->Num_CEL;

		// Id_Almacen
		$this->Id_Almacen = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Almacen', 'Id_Almacen', '`Id_Almacen`', '`Id_Almacen`', 3, -1, FALSE, '`Id_Almacen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen'] = &$this->Id_Almacen;

		// Id_Usuario
		$this->Id_Usuario = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Usuario', 'Id_Usuario', '`Id_Usuario`', '`Id_Usuario`', 3, -1, FALSE, '`Id_Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Usuario->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Usuario'] = &$this->Id_Usuario;

		// TipoArticulo
		$this->TipoArticulo = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_TipoArticulo', 'TipoArticulo', '`TipoArticulo`', '`TipoArticulo`', 202, -1, FALSE, '`TipoArticulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['TipoArticulo'] = &$this->TipoArticulo;

		// Id_Proveedor
		$this->Id_Proveedor = new cField('cap_inventario_inicial_tienda', 'cap_inventario_inicial_tienda', 'x_Id_Proveedor', 'Id_Proveedor', '`Id_Proveedor`', '`Id_Proveedor`', 3, -1, FALSE, '`Id_Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Proveedor'] = &$this->Id_Proveedor;
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
		return "`cap_inventario_inicial_tienda`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "`Id_Almacen`=".Id_Tienda_Actual();
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
		return "`Id_Tel_SIM` DESC";
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
	var $UpdateTable = "`cap_inventario_inicial_tienda`";

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
			$sql .= ew_QuotedName('Id_Tel_SIM') . '=' . ew_QuotedValue($rs['Id_Tel_SIM'], $this->Id_Tel_SIM->FldDataType) . ' AND ';
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
		return "`Id_Tel_SIM` = @Id_Tel_SIM@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Tel_SIM->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Tel_SIM@", ew_AdjustSql($this->Id_Tel_SIM->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_inventario_inicial_tiendalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_inventario_inicial_tiendalist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_inventario_inicial_tiendaview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_inventario_inicial_tiendaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_inventario_inicial_tiendaedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_inventario_inicial_tiendaadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_inventario_inicial_tiendadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Tel_SIM->CurrentValue)) {
			$sUrl .= "Id_Tel_SIM=" . urlencode($this->Id_Tel_SIM->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Tel_SIM"]; // Id_Tel_SIM

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
			$this->Id_Tel_SIM->CurrentValue = $key;
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
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Id_Usuario->setDbValue($rs->fields('Id_Usuario'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Tel_SIM
		// Id_Articulo
		// Id_Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Id_Almacen
		// Id_Usuario
		// TipoArticulo
		// Id_Proveedor
		// Id_Tel_SIM

		$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
		$this->Id_Tel_SIM->ViewCustomAttributes = "";

		// Id_Articulo
		if (strval($this->Id_Articulo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
				$this->Id_Articulo->ViewValue .= ew_ValueSeparator(1,$this->Id_Articulo) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			}
		} else {
			$this->Id_Articulo->ViewValue = NULL;
		}
		$this->Id_Articulo->ViewCustomAttributes = "";

		// Id_Acabado_eq
		if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
		$sWhereWrk = "";
		$lookuptblfilter = "Status='Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Acabado_eq`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Acabado_eq->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
			}
		} else {
			$this->Id_Acabado_eq->ViewValue = NULL;
		}
		$this->Id_Acabado_eq->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// Num_ICCID
		$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
		$this->Num_ICCID->ViewCustomAttributes = "";

		// Num_CEL
		$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
		$this->Num_CEL->ViewCustomAttributes = "";

		// Id_Almacen
		$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
		$this->Id_Almacen->ViewCustomAttributes = "";

		// Id_Usuario
		$this->Id_Usuario->ViewValue = $this->Id_Usuario->CurrentValue;
		$this->Id_Usuario->ViewCustomAttributes = "";

		// TipoArticulo
		$this->TipoArticulo->ViewValue = $this->TipoArticulo->CurrentValue;
		$this->TipoArticulo->ViewCustomAttributes = "";

		// Id_Proveedor
		if (strval($this->Id_Proveedor->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `RazonSocial`";
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

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->LinkCustomAttributes = "";
		$this->Id_Acabado_eq->HrefValue = "";
		$this->Id_Acabado_eq->TooltipValue = "";

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

		// Id_Almacen
		$this->Id_Almacen->LinkCustomAttributes = "";
		$this->Id_Almacen->HrefValue = "";
		$this->Id_Almacen->TooltipValue = "";

		// Id_Usuario
		$this->Id_Usuario->LinkCustomAttributes = "";
		$this->Id_Usuario->HrefValue = "";
		$this->Id_Usuario->TooltipValue = "";

		// TipoArticulo
		$this->TipoArticulo->LinkCustomAttributes = "";
		$this->TipoArticulo->HrefValue = "";
		$this->TipoArticulo->TooltipValue = "";

		// Id_Proveedor
		$this->Id_Proveedor->LinkCustomAttributes = "";
		$this->Id_Proveedor->HrefValue = "";
		$this->Id_Proveedor->TooltipValue = "";

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
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Id_Usuario->Exportable) $Doc->ExportCaption($this->Id_Usuario);
				if ($this->TipoArticulo->Exportable) $Doc->ExportCaption($this->TipoArticulo);
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
			} else {
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Id_Usuario->Exportable) $Doc->ExportCaption($this->Id_Usuario);
				if ($this->TipoArticulo->Exportable) $Doc->ExportCaption($this->TipoArticulo);
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
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
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Id_Usuario->Exportable) $Doc->ExportField($this->Id_Usuario);
					if ($this->TipoArticulo->Exportable) $Doc->ExportField($this->TipoArticulo);
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
				} else {
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Id_Usuario->Exportable) $Doc->ExportField($this->Id_Usuario);
					if ($this->TipoArticulo->Exportable) $Doc->ExportField($this->TipoArticulo);
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
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

	  // Autoupdate NO jala, si los campos no estan en List Page 
	  // de modo que campos que NO quiero que se listen, los tengo que actualizar manualmente aqui

	  $rsnew['Id_Almacen']=Id_Tienda_actual();
	  $rsnew['Id_Usuario']=CurrentUserID();       
	  $rsnew['TipoArticulo']='Equipo';     

	//  echo "Tienda ". Id_Tienda_actual();
	//  exit; 

	  return TRUE;  
	}                       

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

	   //  Le pone tipo 'KIT' o 'SIN CHIP' dependiendo si tiene ICCID y Num CEL asignado
	  Actualiza_Con_SIM_In($rsnew['Id_Tel_SIM']);

	   //  Vamos a capturar de inmediato el nuevo registro  
	  Redireccionar("cap_inventario_inicial_tiendalist.php?a=add");
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
