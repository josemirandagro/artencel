<?php

// Global variable for table object
$cap_def_accesorios = NULL;

//
// Table class for cap_def_accesorios
//
class ccap_def_accesorios extends cTable {
	var $Id_Articulo;
	var $COD_Fam_Accesorio;
	var $COD_Marca_acc;
	var $COD_Acabado_acc;
	var $COD_Tipo_acc;
	var $COD_Equipo_acc;
	var $Codigo;
	var $Articulo;
	var $BarCode_Externo;
	var $Id_Almacen_Entrada;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_def_accesorios';
		$this->TableName = 'cap_def_accesorios';
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
		$this->Id_Articulo = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_COD_Fam_Accesorio', 'COD_Fam_Accesorio', '`COD_Fam_Accesorio`', '`COD_Fam_Accesorio`', 200, -1, FALSE, '`COD_Fam_Accesorio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Fam_Accesorio'] = &$this->COD_Fam_Accesorio;

		// COD_Marca_acc
		$this->COD_Marca_acc = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_COD_Marca_acc', 'COD_Marca_acc', '`COD_Marca_acc`', '`COD_Marca_acc`', 200, -1, FALSE, '`COD_Marca_acc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Marca_acc'] = &$this->COD_Marca_acc;

		// COD_Acabado_acc
		$this->COD_Acabado_acc = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_COD_Acabado_acc', 'COD_Acabado_acc', '`COD_Acabado_acc`', '`COD_Acabado_acc`', 200, -1, FALSE, '`COD_Acabado_acc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Acabado_acc'] = &$this->COD_Acabado_acc;

		// COD_Tipo_acc
		$this->COD_Tipo_acc = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_COD_Tipo_acc', 'COD_Tipo_acc', '`COD_Tipo_acc`', '`COD_Tipo_acc`', 200, -1, FALSE, '`COD_Tipo_acc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Tipo_acc'] = &$this->COD_Tipo_acc;

		// COD_Equipo_acc
		$this->COD_Equipo_acc = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_COD_Equipo_acc', 'COD_Equipo_acc', '`COD_Equipo_acc`', '`COD_Equipo_acc`', 200, -1, FALSE, '`EV__COD_Equipo_acc`', TRUE, TRUE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Equipo_acc'] = &$this->COD_Equipo_acc;

		// Codigo
		$this->Codigo = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Articulo
		$this->Articulo = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_Articulo', 'Articulo', '`Articulo`', '`Articulo`', 200, -1, FALSE, '`Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo'] = &$this->Articulo;

		// BarCode_Externo
		$this->BarCode_Externo = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_BarCode_Externo', 'BarCode_Externo', '`BarCode_Externo`', '`BarCode_Externo`', 200, -1, FALSE, '`BarCode_Externo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['BarCode_Externo'] = &$this->BarCode_Externo;

		// Id_Almacen_Entrada
		$this->Id_Almacen_Entrada = new cField('cap_def_accesorios', 'cap_def_accesorios', 'x_Id_Almacen_Entrada', 'Id_Almacen_Entrada', '`Id_Almacen_Entrada`', '`Id_Almacen_Entrada`', 3, -1, FALSE, '`Id_Almacen_Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`cap_def_accesorios`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlSelectList() { // Select for List page
		return "SELECT * FROM (" .
			"SELECT *, (SELECT DISTINCT `Articulo` FROM `aux_sel_equipos_accesorios` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`Codigo` = `cap_def_accesorios`.`COD_Equipo_acc` LIMIT 1) AS `EV__COD_Equipo_acc` FROM `cap_def_accesorios`" .
			") `EW_TMP_TABLE`";
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
		return "`Id_Articulo` DESC,`Articulo` ASC";
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
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->SqlSelectList(), $this->SqlWhere(), $this->SqlGroupBy(), 
				$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
				$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->BasicSearch->getKeyword() <> "")
			return TRUE;
		if (strpos($sOrderBy, " " . $this->COD_Equipo_acc->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
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
	var $UpdateTable = "`cap_def_accesorios`";

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
			return "cap_def_accesorioslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_def_accesorioslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_def_accesoriosview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_def_accesoriosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_def_accesoriosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_def_accesoriosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_def_accesoriosdelete.php", $this->UrlParm());
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
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->COD_Marca_acc->setDbValue($rs->fields('COD_Marca_acc'));
		$this->COD_Acabado_acc->setDbValue($rs->fields('COD_Acabado_acc'));
		$this->COD_Tipo_acc->setDbValue($rs->fields('COD_Tipo_acc'));
		$this->COD_Equipo_acc->setDbValue($rs->fields('COD_Equipo_acc'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->BarCode_Externo->setDbValue($rs->fields('BarCode_Externo'));
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

		// COD_Fam_Accesorio
		// COD_Marca_acc
		// COD_Acabado_acc
		// COD_Tipo_acc
		// COD_Equipo_acc
		// Codigo
		// Articulo
		// BarCode_Externo
		// Id_Almacen_Entrada
		// Id_Articulo

		$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Articulo->ViewCustomAttributes = "";

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

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

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
				if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportCaption($this->COD_Fam_Accesorio);
				if ($this->COD_Marca_acc->Exportable) $Doc->ExportCaption($this->COD_Marca_acc);
				if ($this->COD_Acabado_acc->Exportable) $Doc->ExportCaption($this->COD_Acabado_acc);
				if ($this->COD_Tipo_acc->Exportable) $Doc->ExportCaption($this->COD_Tipo_acc);
				if ($this->COD_Equipo_acc->Exportable) $Doc->ExportCaption($this->COD_Equipo_acc);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->BarCode_Externo->Exportable) $Doc->ExportCaption($this->BarCode_Externo);
				if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportCaption($this->Id_Almacen_Entrada);
			} else {
				if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportCaption($this->COD_Fam_Accesorio);
				if ($this->COD_Marca_acc->Exportable) $Doc->ExportCaption($this->COD_Marca_acc);
				if ($this->COD_Acabado_acc->Exportable) $Doc->ExportCaption($this->COD_Acabado_acc);
				if ($this->COD_Tipo_acc->Exportable) $Doc->ExportCaption($this->COD_Tipo_acc);
				if ($this->COD_Equipo_acc->Exportable) $Doc->ExportCaption($this->COD_Equipo_acc);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->BarCode_Externo->Exportable) $Doc->ExportCaption($this->BarCode_Externo);
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
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->COD_Marca_acc->Exportable) $Doc->ExportField($this->COD_Marca_acc);
					if ($this->COD_Acabado_acc->Exportable) $Doc->ExportField($this->COD_Acabado_acc);
					if ($this->COD_Tipo_acc->Exportable) $Doc->ExportField($this->COD_Tipo_acc);
					if ($this->COD_Equipo_acc->Exportable) $Doc->ExportField($this->COD_Equipo_acc);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->BarCode_Externo->Exportable) $Doc->ExportField($this->BarCode_Externo);
					if ($this->Id_Almacen_Entrada->Exportable) $Doc->ExportField($this->Id_Almacen_Entrada);
				} else {
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->COD_Marca_acc->Exportable) $Doc->ExportField($this->COD_Marca_acc);
					if ($this->COD_Acabado_acc->Exportable) $Doc->ExportField($this->COD_Acabado_acc);
					if ($this->COD_Tipo_acc->Exportable) $Doc->ExportField($this->COD_Tipo_acc);
					if ($this->COD_Equipo_acc->Exportable) $Doc->ExportField($this->COD_Equipo_acc);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->BarCode_Externo->Exportable) $Doc->ExportField($this->BarCode_Externo);
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

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		global $conn;                 

		// Le ponemos TipoArticulo = "Accesorio" (No halle manera de hacerlo con el Defaul Value sin mostrarlo)
	  $rs =& $rsnew;                   
	  $Codigo = $rs['COD_Fam_Accesorio'].$rs['COD_Marca_acc'].$rs['COD_Acabado_acc'].$rs['Id_Articulo'];                                  
	  $AuxSQL = "UPDATE ca_articulos set TipoArticulo='Accesorio', Codigo=" .$Codigo ." WHERE Id_Articulo=" . $rs['Id_Articulo'];
	  DB_Ejecuta($AuxSQL);         

	// Si insertan un Articulo hay que crear su renglon de registro para existencias  
	  InsertaRenglones_RegExistencias();
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
	  $Codigo = $rsnew['COD_Fam_Accesorio'].$rsnew['COD_Marca_acc'].$rsnew['COD_Acabado_acc'].$rsold['Id_Articulo'];                                  
	  $AuxSQL = "UPDATE ca_articulos set TipoArticulo='Accesorio', Codigo=" .$Codigo ." WHERE Id_Articulo=" . $rs['Id_Articulo'];
	  DB_Ejecuta($AuxSQL);         
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
	// El registro del Accesorio no se borra, se pone como "Descontinuado" para que ya no aparezca en la lista

	  Db_Ejecuta("UPDATE ca_articulos SET `Status`='Descontinuado' WHERE Id_Articulo=".$rs['Id_Articulo']);    

	// Nos regresamos directo a list page, para no tener que estar poniendo leltresros
	  Redireccionar('cap_def_accesorioslist.php'); 
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
