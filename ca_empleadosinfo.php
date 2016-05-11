<?php

// Global variable for table object
$ca_empleados = NULL;

//
// Table class for ca_empleados
//
class cca_empleados extends cTable {
	var $IdEmpleado;
	var $Nombre;
	var $Domicilio;
	var $_EMail;
	var $Celular;
	var $Tel_Fijo;
	var $Usuario;
	var $Password;
	var $Id_Nivel;
	var $IdUsuarioJefe;
	var $MunicipioDel;
	var $CP;
	var $Status;
	var $DiaPago;
	var $Poblacion;
	var $FechaNacimiento;
	var $FechaIngreso;
	var $RFC;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ca_empleados';
		$this->TableName = 'ca_empleados';
		$this->TableType = 'TABLE';
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

		// IdEmpleado
		$this->IdEmpleado = new cField('ca_empleados', 'ca_empleados', 'x_IdEmpleado', 'IdEmpleado', '`IdEmpleado`', '`IdEmpleado`', 3, -1, FALSE, '`IdEmpleado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->IdEmpleado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IdEmpleado'] = &$this->IdEmpleado;

		// Nombre
		$this->Nombre = new cField('ca_empleados', 'ca_empleados', 'x_Nombre', 'Nombre', '`Nombre`', '`Nombre`', 200, -1, FALSE, '`Nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre'] = &$this->Nombre;

		// Domicilio
		$this->Domicilio = new cField('ca_empleados', 'ca_empleados', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio'] = &$this->Domicilio;

		// EMail
		$this->_EMail = new cField('ca_empleados', 'ca_empleados', 'x__EMail', 'EMail', '`EMail`', '`EMail`', 200, -1, FALSE, '`EMail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['EMail'] = &$this->_EMail;

		// Celular
		$this->Celular = new cField('ca_empleados', 'ca_empleados', 'x_Celular', 'Celular', '`Celular`', '`Celular`', 200, -1, FALSE, '`Celular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Celular'] = &$this->Celular;

		// Tel_Fijo
		$this->Tel_Fijo = new cField('ca_empleados', 'ca_empleados', 'x_Tel_Fijo', 'Tel_Fijo', '`Tel_Fijo`', '`Tel_Fijo`', 200, -1, FALSE, '`Tel_Fijo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tel_Fijo'] = &$this->Tel_Fijo;

		// Usuario
		$this->Usuario = new cField('ca_empleados', 'ca_empleados', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Usuario'] = &$this->Usuario;

		// Password
		$this->Password = new cField('ca_empleados', 'ca_empleados', 'x_Password', 'Password', '`Password`', '`Password`', 200, -1, FALSE, '`Password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Password'] = &$this->Password;

		// Id_Nivel
		$this->Id_Nivel = new cField('ca_empleados', 'ca_empleados', 'x_Id_Nivel', 'Id_Nivel', '`Id_Nivel`', '`Id_Nivel`', 3, -1, FALSE, '`Id_Nivel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Nivel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Nivel'] = &$this->Id_Nivel;

		// IdUsuarioJefe
		$this->IdUsuarioJefe = new cField('ca_empleados', 'ca_empleados', 'x_IdUsuarioJefe', 'IdUsuarioJefe', '`IdUsuarioJefe`', '`IdUsuarioJefe`', 3, -1, FALSE, '`IdUsuarioJefe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->IdUsuarioJefe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IdUsuarioJefe'] = &$this->IdUsuarioJefe;

		// MunicipioDel
		$this->MunicipioDel = new cField('ca_empleados', 'ca_empleados', 'x_MunicipioDel', 'MunicipioDel', '`MunicipioDel`', '`MunicipioDel`', 200, -1, FALSE, '`MunicipioDel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['MunicipioDel'] = &$this->MunicipioDel;

		// CP
		$this->CP = new cField('ca_empleados', 'ca_empleados', 'x_CP', 'CP', '`CP`', '`CP`', 200, -1, FALSE, '`CP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CP'] = &$this->CP;

		// Status
		$this->Status = new cField('ca_empleados', 'ca_empleados', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// DiaPago
		$this->DiaPago = new cField('ca_empleados', 'ca_empleados', 'x_DiaPago', 'DiaPago', '`DiaPago`', '`DiaPago`', 202, -1, FALSE, '`DiaPago`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['DiaPago'] = &$this->DiaPago;

		// Poblacion
		$this->Poblacion = new cField('ca_empleados', 'ca_empleados', 'x_Poblacion', 'Poblacion', '`Poblacion`', '`Poblacion`', 200, -1, FALSE, '`Poblacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Poblacion'] = &$this->Poblacion;

		// FechaNacimiento
		$this->FechaNacimiento = new cField('ca_empleados', 'ca_empleados', 'x_FechaNacimiento', 'FechaNacimiento', '`FechaNacimiento`', 'DATE_FORMAT(`FechaNacimiento`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaNacimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaNacimiento->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaNacimiento'] = &$this->FechaNacimiento;

		// FechaIngreso
		$this->FechaIngreso = new cField('ca_empleados', 'ca_empleados', 'x_FechaIngreso', 'FechaIngreso', '`FechaIngreso`', 'DATE_FORMAT(`FechaIngreso`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaIngreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaIngreso->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaIngreso'] = &$this->FechaIngreso;

		// RFC
		$this->RFC = new cField('ca_empleados', 'ca_empleados', 'x_RFC', 'RFC', '`RFC`', '`RFC`', 200, -1, FALSE, '`RFC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RFC'] = &$this->RFC;
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
		return "`ca_empleados`";
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
		return "`Nombre` ASC";
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
	var $UpdateTable = "`ca_empleados`";

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
			$sql .= ew_QuotedName('IdEmpleado') . '=' . ew_QuotedValue($rs['IdEmpleado'], $this->IdEmpleado->FldDataType) . ' AND ';
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
		return "`IdEmpleado` = @IdEmpleado@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->IdEmpleado->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@IdEmpleado@", ew_AdjustSql($this->IdEmpleado->CurrentValue), $sKeyFilter); // Replace key value
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
			return "ca_empleadoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ca_empleadoslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("ca_empleadosview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "ca_empleadosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("ca_empleadosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("ca_empleadosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ca_empleadosdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->IdEmpleado->CurrentValue)) {
			$sUrl .= "IdEmpleado=" . urlencode($this->IdEmpleado->CurrentValue);
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
			$arKeys[] = @$_GET["IdEmpleado"]; // IdEmpleado

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
			$this->IdEmpleado->CurrentValue = $key;
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
		$this->IdEmpleado->setDbValue($rs->fields('IdEmpleado'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Tel_Fijo->setDbValue($rs->fields('Tel_Fijo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->IdUsuarioJefe->setDbValue($rs->fields('IdUsuarioJefe'));
		$this->MunicipioDel->setDbValue($rs->fields('MunicipioDel'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->DiaPago->setDbValue($rs->fields('DiaPago'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->FechaNacimiento->setDbValue($rs->fields('FechaNacimiento'));
		$this->FechaIngreso->setDbValue($rs->fields('FechaIngreso'));
		$this->RFC->setDbValue($rs->fields('RFC'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// IdEmpleado
		// Nombre
		// Domicilio
		// EMail
		// Celular
		// Tel_Fijo
		// Usuario

		$this->Usuario->CellCssStyle = "white-space: nowrap;";

		// Password
		$this->Password->CellCssStyle = "white-space: nowrap;";

		// Id_Nivel
		$this->Id_Nivel->CellCssStyle = "white-space: nowrap;";

		// IdUsuarioJefe
		$this->IdUsuarioJefe->CellCssStyle = "white-space: nowrap;";

		// MunicipioDel
		// CP
		// Status

		$this->Status->CellCssStyle = "white-space: nowrap;";

		// DiaPago
		// Poblacion
		// FechaNacimiento
		// FechaIngreso
		// RFC
		// IdEmpleado

		$this->IdEmpleado->ViewValue = $this->IdEmpleado->CurrentValue;
		$this->IdEmpleado->ViewCustomAttributes = "";

		// Nombre
		$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
		$this->Nombre->ViewValue = strtoupper($this->Nombre->ViewValue);
		$this->Nombre->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// EMail
		$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
		$this->_EMail->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Tel_Fijo
		$this->Tel_Fijo->ViewValue = $this->Tel_Fijo->CurrentValue;
		$this->Tel_Fijo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_userlevels`";
		$sWhereWrk = "";
		$lookuptblfilter = "`userlevelid`>0";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `userlevelid`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Nivel->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// IdUsuarioJefe
		$this->IdUsuarioJefe->ViewValue = $this->IdUsuarioJefe->CurrentValue;
		$this->IdUsuarioJefe->ViewCustomAttributes = "";

		// MunicipioDel
		$this->MunicipioDel->ViewValue = $this->MunicipioDel->CurrentValue;
		$this->MunicipioDel->ViewCustomAttributes = "";

		// CP
		$this->CP->ViewValue = $this->CP->CurrentValue;
		$this->CP->ViewCustomAttributes = "";

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

		// DiaPago
		if (strval($this->DiaPago->CurrentValue) <> "") {
			switch ($this->DiaPago->CurrentValue) {
				case $this->DiaPago->FldTagValue(1):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(1) <> "" ? $this->DiaPago->FldTagCaption(1) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(2):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(2) <> "" ? $this->DiaPago->FldTagCaption(2) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(3):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(3) <> "" ? $this->DiaPago->FldTagCaption(3) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(4):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(4) <> "" ? $this->DiaPago->FldTagCaption(4) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(5):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(5) <> "" ? $this->DiaPago->FldTagCaption(5) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(6):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(6) <> "" ? $this->DiaPago->FldTagCaption(6) : $this->DiaPago->CurrentValue;
					break;
				case $this->DiaPago->FldTagValue(7):
					$this->DiaPago->ViewValue = $this->DiaPago->FldTagCaption(7) <> "" ? $this->DiaPago->FldTagCaption(7) : $this->DiaPago->CurrentValue;
					break;
				default:
					$this->DiaPago->ViewValue = $this->DiaPago->CurrentValue;
			}
		} else {
			$this->DiaPago->ViewValue = NULL;
		}
		$this->DiaPago->ViewCustomAttributes = "";

		// Poblacion
		$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
		$this->Poblacion->ViewCustomAttributes = "";

		// FechaNacimiento
		$this->FechaNacimiento->ViewValue = $this->FechaNacimiento->CurrentValue;
		$this->FechaNacimiento->ViewValue = ew_FormatDateTime($this->FechaNacimiento->ViewValue, 7);
		$this->FechaNacimiento->ViewCustomAttributes = "";

		// FechaIngreso
		$this->FechaIngreso->ViewValue = $this->FechaIngreso->CurrentValue;
		$this->FechaIngreso->ViewValue = ew_FormatDateTime($this->FechaIngreso->ViewValue, 7);
		$this->FechaIngreso->ViewCustomAttributes = "";

		// RFC
		$this->RFC->ViewValue = $this->RFC->CurrentValue;
		$this->RFC->ViewCustomAttributes = "";

		// IdEmpleado
		$this->IdEmpleado->LinkCustomAttributes = "";
		$this->IdEmpleado->HrefValue = "";
		$this->IdEmpleado->TooltipValue = "";

		// Nombre
		$this->Nombre->LinkCustomAttributes = "";
		$this->Nombre->HrefValue = "";
		$this->Nombre->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// EMail
		$this->_EMail->LinkCustomAttributes = "";
		$this->_EMail->HrefValue = "";
		$this->_EMail->TooltipValue = "";

		// Celular
		$this->Celular->LinkCustomAttributes = "";
		$this->Celular->HrefValue = "";
		$this->Celular->TooltipValue = "";

		// Tel_Fijo
		$this->Tel_Fijo->LinkCustomAttributes = "";
		$this->Tel_Fijo->HrefValue = "";
		$this->Tel_Fijo->TooltipValue = "";

		// Usuario
		$this->Usuario->LinkCustomAttributes = "";
		$this->Usuario->HrefValue = "";
		$this->Usuario->TooltipValue = "";

		// Password
		$this->Password->LinkCustomAttributes = "";
		$this->Password->HrefValue = "";
		$this->Password->TooltipValue = "";

		// Id_Nivel
		$this->Id_Nivel->LinkCustomAttributes = "";
		$this->Id_Nivel->HrefValue = "";
		$this->Id_Nivel->TooltipValue = "";

		// IdUsuarioJefe
		$this->IdUsuarioJefe->LinkCustomAttributes = "";
		$this->IdUsuarioJefe->HrefValue = "";
		$this->IdUsuarioJefe->TooltipValue = "";

		// MunicipioDel
		$this->MunicipioDel->LinkCustomAttributes = "";
		$this->MunicipioDel->HrefValue = "";
		$this->MunicipioDel->TooltipValue = "";

		// CP
		$this->CP->LinkCustomAttributes = "";
		$this->CP->HrefValue = "";
		$this->CP->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// DiaPago
		$this->DiaPago->LinkCustomAttributes = "";
		$this->DiaPago->HrefValue = "";
		$this->DiaPago->TooltipValue = "";

		// Poblacion
		$this->Poblacion->LinkCustomAttributes = "";
		$this->Poblacion->HrefValue = "";
		$this->Poblacion->TooltipValue = "";

		// FechaNacimiento
		$this->FechaNacimiento->LinkCustomAttributes = "";
		$this->FechaNacimiento->HrefValue = "";
		$this->FechaNacimiento->TooltipValue = "";

		// FechaIngreso
		$this->FechaIngreso->LinkCustomAttributes = "";
		$this->FechaIngreso->HrefValue = "";
		$this->FechaIngreso->TooltipValue = "";

		// RFC
		$this->RFC->LinkCustomAttributes = "";
		$this->RFC->HrefValue = "";
		$this->RFC->TooltipValue = "";

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
				if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Tel_Fijo->Exportable) $Doc->ExportCaption($this->Tel_Fijo);
				if ($this->Id_Nivel->Exportable) $Doc->ExportCaption($this->Id_Nivel);
				if ($this->MunicipioDel->Exportable) $Doc->ExportCaption($this->MunicipioDel);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->DiaPago->Exportable) $Doc->ExportCaption($this->DiaPago);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->FechaNacimiento->Exportable) $Doc->ExportCaption($this->FechaNacimiento);
				if ($this->FechaIngreso->Exportable) $Doc->ExportCaption($this->FechaIngreso);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
			} else {
				if ($this->IdEmpleado->Exportable) $Doc->ExportCaption($this->IdEmpleado);
				if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Tel_Fijo->Exportable) $Doc->ExportCaption($this->Tel_Fijo);
				if ($this->MunicipioDel->Exportable) $Doc->ExportCaption($this->MunicipioDel);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->DiaPago->Exportable) $Doc->ExportCaption($this->DiaPago);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->FechaNacimiento->Exportable) $Doc->ExportCaption($this->FechaNacimiento);
				if ($this->FechaIngreso->Exportable) $Doc->ExportCaption($this->FechaIngreso);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
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
					if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Tel_Fijo->Exportable) $Doc->ExportField($this->Tel_Fijo);
					if ($this->Id_Nivel->Exportable) $Doc->ExportField($this->Id_Nivel);
					if ($this->MunicipioDel->Exportable) $Doc->ExportField($this->MunicipioDel);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->DiaPago->Exportable) $Doc->ExportField($this->DiaPago);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->FechaNacimiento->Exportable) $Doc->ExportField($this->FechaNacimiento);
					if ($this->FechaIngreso->Exportable) $Doc->ExportField($this->FechaIngreso);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
				} else {
					if ($this->IdEmpleado->Exportable) $Doc->ExportField($this->IdEmpleado);
					if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Tel_Fijo->Exportable) $Doc->ExportField($this->Tel_Fijo);
					if ($this->MunicipioDel->Exportable) $Doc->ExportField($this->MunicipioDel);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->DiaPago->Exportable) $Doc->ExportField($this->DiaPago);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->FechaNacimiento->Exportable) $Doc->ExportField($this->FechaNacimiento);
					if ($this->FechaIngreso->Exportable) $Doc->ExportField($this->FechaIngreso);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
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
