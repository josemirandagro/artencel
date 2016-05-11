<?php

// Global variable for table object
$cap_def_equipos = NULL;

//
// Table class for cap_def_equipos
//
class ccap_def_equipos extends cTable {
	var $Id_Articulo;
	var $COD_Marca_eq;
	var $COD_Modelo_eq;
	var $COD_Compania_eq;
	var $Apodo_eq;
	var $Status;
	var $Codigo;
	var $Articulo;
	var $Id_Almacen_Entrada;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_def_equipos';
		$this->TableName = 'cap_def_equipos';
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

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// COD_Marca_eq
		$this->COD_Marca_eq = new cField('cap_def_equipos', 'cap_def_equipos', 'x_COD_Marca_eq', 'COD_Marca_eq', '`COD_Marca_eq`', '`COD_Marca_eq`', 200, -1, FALSE, '`COD_Marca_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->COD_Marca_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['COD_Marca_eq'] = &$this->COD_Marca_eq;

		// COD_Modelo_eq
		$this->COD_Modelo_eq = new cField('cap_def_equipos', 'cap_def_equipos', 'x_COD_Modelo_eq', 'COD_Modelo_eq', '`COD_Modelo_eq`', '`COD_Modelo_eq`', 200, -1, FALSE, '`COD_Modelo_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Modelo_eq'] = &$this->COD_Modelo_eq;

		// COD_Compania_eq
		$this->COD_Compania_eq = new cField('cap_def_equipos', 'cap_def_equipos', 'x_COD_Compania_eq', 'COD_Compania_eq', '`COD_Compania_eq`', '`COD_Compania_eq`', 200, -1, FALSE, '`COD_Compania_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Compania_eq'] = &$this->COD_Compania_eq;

		// Apodo_eq
		$this->Apodo_eq = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Apodo_eq', 'Apodo_eq', '`Apodo_eq`', '`Apodo_eq`', 200, -1, FALSE, '`Apodo_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Apodo_eq'] = &$this->Apodo_eq;

		// Status
		$this->Status = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// Codigo
		$this->Codigo = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Articulo
		$this->Articulo = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Articulo', 'Articulo', '`Articulo`', '`Articulo`', 200, -1, FALSE, '`Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo'] = &$this->Articulo;

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada = new cField('cap_def_equipos', 'cap_def_equipos', 'x_Id_Almacen_Entrada', 'Id_Almacen_Entrada', '`Id_Almacen_Entrada`', '`Id_Almacen_Entrada`', 3, -1, FALSE, '`Id_Almacen_Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen_Entrada->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen_Entrada'] = &$this->Id_Almacen_Entrada;
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
		return "`cap_def_equipos`";
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
		return "`Articulo` ASC";
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
	var $UpdateTable = "`cap_def_equipos`";

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
			$sql .= ew_QuotedName('Id_Articulo') . '=' . ew_QuotedValue($rs['Id_Articulo'], $this->Id_Articulo->FldDataType) . ' AND ';
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
		return "`Id_Articulo` = @Id_Articulo@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Articulo->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Articulo@", ew_AdjustSql($this->Id_Articulo->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_def_equiposlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_def_equiposlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_def_equiposview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_def_equiposadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_def_equiposedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_def_equiposadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_def_equiposdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Articulo->CurrentValue)) {
			$sUrl .= "Id_Articulo=" . urlencode($this->Id_Articulo->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Articulo"]; // Id_Articulo

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
			$this->Id_Articulo->CurrentValue = $key;
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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Apodo_eq->setDbValue($rs->fields('Apodo_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Articulo

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq
		// Apodo_eq
		// Status
		// Codigo
		// Articulo
		// Id_Almacen_Entrada
		// Id_Articulo

		$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Articulo->ViewCustomAttributes = "";

		// COD_Marca_eq
		if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
			$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
		$sWhereWrk = "";
		$lookuptblfilter = "`Status`='Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
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
		$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
		$this->COD_Modelo_eq->ViewCustomAttributes = "";

		// COD_Compania_eq
		if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
			$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
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

		// Apodo_eq
		$this->Apodo_eq->ViewValue = $this->Apodo_eq->CurrentValue;
		$this->Apodo_eq->ViewCustomAttributes = "";

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

		// Codigo
		$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
		$this->Codigo->ViewCustomAttributes = "";

		// Articulo
		$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
		$this->Articulo->ViewCustomAttributes = "";

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

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// COD_Marca_eq
		$this->COD_Marca_eq->LinkCustomAttributes = "";
		$this->COD_Marca_eq->HrefValue = "";
		$this->COD_Marca_eq->TooltipValue = "";

		// COD_Modelo_eq
		$this->COD_Modelo_eq->LinkCustomAttributes = "";
		$this->COD_Modelo_eq->HrefValue = "";
		$this->COD_Modelo_eq->TooltipValue = "";

		// COD_Compania_eq
		$this->COD_Compania_eq->LinkCustomAttributes = "";
		$this->COD_Compania_eq->HrefValue = "";
		$this->COD_Compania_eq->TooltipValue = "";

		// Apodo_eq
		$this->Apodo_eq->LinkCustomAttributes = "";
		$this->Apodo_eq->HrefValue = "";
		$this->Apodo_eq->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// Codigo
		$this->Codigo->LinkCustomAttributes = "";
		$this->Codigo->HrefValue = "";
		$this->Codigo->TooltipValue = "";

		// Articulo
		$this->Articulo->LinkCustomAttributes = "";
		$this->Articulo->HrefValue = "";
		$this->Articulo->TooltipValue = "";

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
		$this->Id_Almacen_Entrada->HrefValue = "";
		$this->Id_Almacen_Entrada->TooltipValue = "";

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
				if ($this->COD_Marca_eq->Exportable) $Doc->ExportCaption($this->COD_Marca_eq);
				if ($this->COD_Modelo_eq->Exportable) $Doc->ExportCaption($this->COD_Modelo_eq);
				if ($this->COD_Compania_eq->Exportable) $Doc->ExportCaption($this->COD_Compania_eq);
				if ($this->Apodo_eq->Exportable) $Doc->ExportCaption($this->Apodo_eq);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportCaption($this->Id_Almacen_Entrada);
			} else {
				if ($this->COD_Marca_eq->Exportable) $Doc->ExportCaption($this->COD_Marca_eq);
				if ($this->COD_Modelo_eq->Exportable) $Doc->ExportCaption($this->COD_Modelo_eq);
				if ($this->COD_Compania_eq->Exportable) $Doc->ExportCaption($this->COD_Compania_eq);
				if ($this->Apodo_eq->Exportable) $Doc->ExportCaption($this->Apodo_eq);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportCaption($this->Id_Almacen_Entrada);
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
					if ($this->COD_Marca_eq->Exportable) $Doc->ExportField($this->COD_Marca_eq);
					if ($this->COD_Modelo_eq->Exportable) $Doc->ExportField($this->COD_Modelo_eq);
					if ($this->COD_Compania_eq->Exportable) $Doc->ExportField($this->COD_Compania_eq);
					if ($this->Apodo_eq->Exportable) $Doc->ExportField($this->Apodo_eq);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportField($this->Id_Almacen_Entrada);
				} else {
					if ($this->COD_Marca_eq->Exportable) $Doc->ExportField($this->COD_Marca_eq);
					if ($this->COD_Modelo_eq->Exportable) $Doc->ExportField($this->COD_Modelo_eq);
					if ($this->COD_Compania_eq->Exportable) $Doc->ExportField($this->COD_Compania_eq);
					if ($this->Apodo_eq->Exportable) $Doc->ExportField($this->Apodo_eq);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportField($this->Id_Almacen_Entrada);
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
	  $rsnew['TipoArticulo']='Equipo';  // NO esta jalando, POR QUE  el campo TipoArticulo NO ESTA EN LA VISTA!!!!

	  //  Hay que ver si jala poniendolo en la vista, pero NO poniendolo en lispage y en add page
	  return TRUE;     
	}                                                                              

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {
		global $conn;                 

	 // Le ponemos COD_Familia = "TEL" y TipoArticulo = "Equipo"(No halle manera de hacerlo con el Defaul Value sin mostrarlos)
	  $rs =& $rsnew;                                                                                                             

	//  OJO... La siguiente Linea NO JALA si le pongo $rsnew en lugar de $rs, habra que probar con &$rsnew, pero eso luego lo hacemos.
	  DB_Ejecuta("UPDATE ca_articulos set COD_Fam_Accesorio='TEL',TipoArticulo='Equipo' WHERE Id_Articulo=" . $rs['Id_Articulo']); 
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

	// El registro del Accesorio no se borra, se pone como "Descontinuado" para que ya no aparezca en la lista
	  Db_Ejecuta("UPDATE ca_articulos SET `Status`='Descontinuado' WHERE Id_Articulo=".$rs['Id_Articulo']);    

	// Nos regresamos directo a list page, para no tener que estar poniendo leltresros
	  Redireccionar('cap_def_equiposlist.php'); 
	  exit;       
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
