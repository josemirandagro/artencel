<?php

// Global variable for table object
$cap_datos_garantia_eq = NULL;

//
// Table class for cap_datos_garantia_eq
//
class ccap_datos_garantia_eq extends cTable {
	var $Id_Venta_Eq;
	var $Fecha_Venta;
	var $Nombre_Completo;
	var $Fecha_Entrada;
	var $Id_Marca_eq;
	var $COD_Modelo_eq;
	var $Id_Acabado_eq;
	var $Num_IMEI;
	var $Id_Proveedor;
	var $Accesorios_Recibidos;
	var $Falla;
	var $Condiciones_Equipo;
	var $Id_Tel_SIM;
	var $Id_Empleado_recibe;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_datos_garantia_eq';
		$this->TableName = 'cap_datos_garantia_eq';
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
		$this->Id_Venta_Eq = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Venta_Eq', 'Id_Venta_Eq', '`Id_Venta_Eq`', '`Id_Venta_Eq`', 3, -1, FALSE, '`Id_Venta_Eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Venta_Eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Venta_Eq'] = &$this->Id_Venta_Eq;

		// Fecha_Venta
		$this->Fecha_Venta = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Fecha_Venta', 'Fecha_Venta', '`Fecha_Venta`', 'DATE_FORMAT(`Fecha_Venta`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`Fecha_Venta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha_Venta->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Venta'] = &$this->Fecha_Venta;

		// Nombre_Completo
		$this->Nombre_Completo = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Nombre_Completo', 'Nombre_Completo', '`Nombre_Completo`', '`Nombre_Completo`', 200, -1, FALSE, '`Nombre_Completo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre_Completo'] = &$this->Nombre_Completo;

		// Fecha_Entrada
		$this->Fecha_Entrada = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Fecha_Entrada', 'Fecha_Entrada', '`Fecha_Entrada`', 'DATE_FORMAT(`Fecha_Entrada`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`Fecha_Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha_Entrada->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Entrada'] = &$this->Fecha_Entrada;

		// Id_Marca_eq
		$this->Id_Marca_eq = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Marca_eq', 'Id_Marca_eq', '`Id_Marca_eq`', '`Id_Marca_eq`', 3, -1, FALSE, '`Id_Marca_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Marca_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Marca_eq'] = &$this->Id_Marca_eq;

		// COD_Modelo_eq
		$this->COD_Modelo_eq = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_COD_Modelo_eq', 'COD_Modelo_eq', '`COD_Modelo_eq`', '`COD_Modelo_eq`', 200, -1, FALSE, '`COD_Modelo_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Modelo_eq'] = &$this->COD_Modelo_eq;

		// Id_Acabado_eq
		$this->Id_Acabado_eq = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Acabado_eq', 'Id_Acabado_eq', '`Id_Acabado_eq`', '`Id_Acabado_eq`', 3, -1, FALSE, '`Id_Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Acabado_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Acabado_eq'] = &$this->Id_Acabado_eq;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// Id_Proveedor
		$this->Id_Proveedor = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Proveedor', 'Id_Proveedor', '`Id_Proveedor`', '`Id_Proveedor`', 3, -1, FALSE, '`Id_Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Proveedor'] = &$this->Id_Proveedor;

		// Accesorios_Recibidos
		$this->Accesorios_Recibidos = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Accesorios_Recibidos', 'Accesorios_Recibidos', '`Accesorios_Recibidos`', '`Accesorios_Recibidos`', 202, -1, FALSE, '`Accesorios_Recibidos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Accesorios_Recibidos'] = &$this->Accesorios_Recibidos;

		// Falla
		$this->Falla = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Falla', 'Falla', '`Falla`', '`Falla`', 201, -1, FALSE, '`Falla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Falla'] = &$this->Falla;

		// Condiciones_Equipo
		$this->Condiciones_Equipo = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Condiciones_Equipo', 'Condiciones_Equipo', '`Condiciones_Equipo`', '`Condiciones_Equipo`', 201, -1, FALSE, '`Condiciones_Equipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Condiciones_Equipo'] = &$this->Condiciones_Equipo;

		// Id_Tel_SIM
		$this->Id_Tel_SIM = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 3, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Id_Empleado_recibe
		$this->Id_Empleado_recibe = new cField('cap_datos_garantia_eq', 'cap_datos_garantia_eq', 'x_Id_Empleado_recibe', 'Id_Empleado_recibe', '`Id_Empleado_recibe`', '`Id_Empleado_recibe`', 3, -1, FALSE, '`Id_Empleado_recibe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Empleado_recibe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Empleado_recibe'] = &$this->Id_Empleado_recibe;
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
		return "`cap_datos_garantia_eq`";
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
	var $UpdateTable = "`cap_datos_garantia_eq`";

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
			return "cap_datos_garantia_eqlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_datos_garantia_eqlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_datos_garantia_eqview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_datos_garantia_eqadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_datos_garantia_eqedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_datos_garantia_eqadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_datos_garantia_eqdelete.php", $this->UrlParm());
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
		$this->Fecha_Venta->setDbValue($rs->fields('Fecha_Venta'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha_Entrada'));
		$this->Id_Marca_eq->setDbValue($rs->fields('Id_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->Accesorios_Recibidos->setDbValue($rs->fields('Accesorios_Recibidos'));
		$this->Falla->setDbValue($rs->fields('Falla'));
		$this->Condiciones_Equipo->setDbValue($rs->fields('Condiciones_Equipo'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Empleado_recibe->setDbValue($rs->fields('Id_Empleado_recibe'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Venta_Eq
		// Fecha_Venta
		// Nombre_Completo
		// Fecha_Entrada
		// Id_Marca_eq
		// COD_Modelo_eq
		// Id_Acabado_eq
		// Num_IMEI
		// Id_Proveedor
		// Accesorios_Recibidos
		// Falla
		// Condiciones_Equipo
		// Id_Tel_SIM
		// Id_Empleado_recibe
		// Id_Venta_Eq

		$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
		$this->Id_Venta_Eq->ViewCustomAttributes = "";

		// Fecha_Venta
		$this->Fecha_Venta->ViewValue = $this->Fecha_Venta->CurrentValue;
		$this->Fecha_Venta->ViewValue = ew_FormatDateTime($this->Fecha_Venta->ViewValue, 7);
		$this->Fecha_Venta->ViewCustomAttributes = "";

		// Nombre_Completo
		$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
		$this->Nombre_Completo->ViewCustomAttributes = "";

		// Fecha_Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 7);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Id_Marca_eq
		$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
		if (strval($this->Id_Marca_eq->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca_eq`" . ew_SearchString("=", $this->Id_Marca_eq->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Marca_eq->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Marca_eq->ViewValue = $this->Id_Marca_eq->CurrentValue;
			}
		} else {
			$this->Id_Marca_eq->ViewValue = NULL;
		}
		$this->Id_Marca_eq->ViewCustomAttributes = "";

		// COD_Modelo_eq
		$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
		$this->COD_Modelo_eq->ViewCustomAttributes = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
		if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Id_Proveedor
		$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
		if (strval($this->Id_Proveedor->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Accesorios_Recibidos
		if (strval($this->Accesorios_Recibidos->CurrentValue) <> "") {
			$this->Accesorios_Recibidos->ViewValue = "";
			$arwrk = explode(",", strval($this->Accesorios_Recibidos->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				switch (trim($arwrk[$ari])) {
					case $this->Accesorios_Recibidos->FldTagValue(1):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(1) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(1) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(2):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(2) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(2) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(3):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(3) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(3) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(4):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(4) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(4) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(5):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(5) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(5) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(6):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(6) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(6) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(7):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(7) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(7) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(8):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(8) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(8) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(9):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(9) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(9) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(10):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(10) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(10) : trim($arwrk[$ari]);
						break;
					case $this->Accesorios_Recibidos->FldTagValue(11):
						$this->Accesorios_Recibidos->ViewValue .= $this->Accesorios_Recibidos->FldTagCaption(11) <> "" ? $this->Accesorios_Recibidos->FldTagCaption(11) : trim($arwrk[$ari]);
						break;
					default:
						$this->Accesorios_Recibidos->ViewValue .= trim($arwrk[$ari]);
				}
				if ($ari < $cnt-1) $this->Accesorios_Recibidos->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->Accesorios_Recibidos->ViewValue = NULL;
		}
		$this->Accesorios_Recibidos->ViewCustomAttributes = "";

		// Falla
		$this->Falla->ViewValue = $this->Falla->CurrentValue;
		$this->Falla->ViewCustomAttributes = "";

		// Condiciones_Equipo
		$this->Condiciones_Equipo->ViewValue = $this->Condiciones_Equipo->CurrentValue;
		$this->Condiciones_Equipo->ViewCustomAttributes = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
		if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Num_ICCID` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
				$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
				$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(2,$this->Id_Tel_SIM) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			}
		} else {
			$this->Id_Tel_SIM->ViewValue = NULL;
		}
		$this->Id_Tel_SIM->ViewCustomAttributes = "";

		// Id_Empleado_recibe
		$this->Id_Empleado_recibe->ViewValue = $this->Id_Empleado_recibe->CurrentValue;
		$this->Id_Empleado_recibe->ViewCustomAttributes = "";

		// Id_Venta_Eq
		$this->Id_Venta_Eq->LinkCustomAttributes = "";
		$this->Id_Venta_Eq->HrefValue = "";
		$this->Id_Venta_Eq->TooltipValue = "";

		// Fecha_Venta
		$this->Fecha_Venta->LinkCustomAttributes = "";
		$this->Fecha_Venta->HrefValue = "";
		$this->Fecha_Venta->TooltipValue = "";

		// Nombre_Completo
		$this->Nombre_Completo->LinkCustomAttributes = "";
		$this->Nombre_Completo->HrefValue = "";
		$this->Nombre_Completo->TooltipValue = "";

		// Fecha_Entrada
		$this->Fecha_Entrada->LinkCustomAttributes = "";
		$this->Fecha_Entrada->HrefValue = "";
		$this->Fecha_Entrada->TooltipValue = "";

		// Id_Marca_eq
		$this->Id_Marca_eq->LinkCustomAttributes = "";
		$this->Id_Marca_eq->HrefValue = "";
		$this->Id_Marca_eq->TooltipValue = "";

		// COD_Modelo_eq
		$this->COD_Modelo_eq->LinkCustomAttributes = "";
		$this->COD_Modelo_eq->HrefValue = "";
		$this->COD_Modelo_eq->TooltipValue = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->LinkCustomAttributes = "";
		$this->Id_Acabado_eq->HrefValue = "";
		$this->Id_Acabado_eq->TooltipValue = "";

		// Num_IMEI
		$this->Num_IMEI->LinkCustomAttributes = "";
		$this->Num_IMEI->HrefValue = "";
		$this->Num_IMEI->TooltipValue = "";

		// Id_Proveedor
		$this->Id_Proveedor->LinkCustomAttributes = "";
		$this->Id_Proveedor->HrefValue = "";
		$this->Id_Proveedor->TooltipValue = "";

		// Accesorios_Recibidos
		$this->Accesorios_Recibidos->LinkCustomAttributes = "";
		$this->Accesorios_Recibidos->HrefValue = "";
		$this->Accesorios_Recibidos->TooltipValue = "";

		// Falla
		$this->Falla->LinkCustomAttributes = "";
		$this->Falla->HrefValue = "";
		$this->Falla->TooltipValue = "";

		// Condiciones_Equipo
		$this->Condiciones_Equipo->LinkCustomAttributes = "";
		$this->Condiciones_Equipo->HrefValue = "";
		$this->Condiciones_Equipo->TooltipValue = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Id_Empleado_recibe
		$this->Id_Empleado_recibe->LinkCustomAttributes = "";
		$this->Id_Empleado_recibe->HrefValue = "";
		$this->Id_Empleado_recibe->TooltipValue = "";

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
				if ($this->Fecha_Venta->Exportable) $Doc->ExportCaption($this->Fecha_Venta);
				if ($this->Nombre_Completo->Exportable) $Doc->ExportCaption($this->Nombre_Completo);
				if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
				if ($this->Id_Marca_eq->Exportable) $Doc->ExportCaption($this->Id_Marca_eq);
				if ($this->COD_Modelo_eq->Exportable) $Doc->ExportCaption($this->COD_Modelo_eq);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
				if ($this->Accesorios_Recibidos->Exportable) $Doc->ExportCaption($this->Accesorios_Recibidos);
				if ($this->Falla->Exportable) $Doc->ExportCaption($this->Falla);
				if ($this->Condiciones_Equipo->Exportable) $Doc->ExportCaption($this->Condiciones_Equipo);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Empleado_recibe->Exportable) $Doc->ExportCaption($this->Id_Empleado_recibe);
			} else {
				if ($this->Id_Venta_Eq->Exportable) $Doc->ExportCaption($this->Id_Venta_Eq);
				if ($this->Fecha_Venta->Exportable) $Doc->ExportCaption($this->Fecha_Venta);
				if ($this->Nombre_Completo->Exportable) $Doc->ExportCaption($this->Nombre_Completo);
				if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
				if ($this->Id_Marca_eq->Exportable) $Doc->ExportCaption($this->Id_Marca_eq);
				if ($this->COD_Modelo_eq->Exportable) $Doc->ExportCaption($this->COD_Modelo_eq);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
				if ($this->Accesorios_Recibidos->Exportable) $Doc->ExportCaption($this->Accesorios_Recibidos);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Empleado_recibe->Exportable) $Doc->ExportCaption($this->Id_Empleado_recibe);
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
					if ($this->Fecha_Venta->Exportable) $Doc->ExportField($this->Fecha_Venta);
					if ($this->Nombre_Completo->Exportable) $Doc->ExportField($this->Nombre_Completo);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
					if ($this->Id_Marca_eq->Exportable) $Doc->ExportField($this->Id_Marca_eq);
					if ($this->COD_Modelo_eq->Exportable) $Doc->ExportField($this->COD_Modelo_eq);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
					if ($this->Accesorios_Recibidos->Exportable) $Doc->ExportField($this->Accesorios_Recibidos);
					if ($this->Falla->Exportable) $Doc->ExportField($this->Falla);
					if ($this->Condiciones_Equipo->Exportable) $Doc->ExportField($this->Condiciones_Equipo);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Empleado_recibe->Exportable) $Doc->ExportField($this->Id_Empleado_recibe);
				} else {
					if ($this->Id_Venta_Eq->Exportable) $Doc->ExportField($this->Id_Venta_Eq);
					if ($this->Fecha_Venta->Exportable) $Doc->ExportField($this->Fecha_Venta);
					if ($this->Nombre_Completo->Exportable) $Doc->ExportField($this->Nombre_Completo);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
					if ($this->Id_Marca_eq->Exportable) $Doc->ExportField($this->Id_Marca_eq);
					if ($this->COD_Modelo_eq->Exportable) $Doc->ExportField($this->COD_Modelo_eq);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
					if ($this->Accesorios_Recibidos->Exportable) $Doc->ExportField($this->Accesorios_Recibidos);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Empleado_recibe->Exportable) $Doc->ExportField($this->Id_Empleado_recibe);
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
