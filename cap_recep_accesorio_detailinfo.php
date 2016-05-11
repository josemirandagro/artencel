<?php

// Global variable for table object
$cap_recep_accesorio_detail = NULL;

//
// Table class for cap_recep_accesorio_detail
//
class ccap_recep_accesorio_detail extends cTable {
	var $Id_Compra_Det;
	var $Id_Compra;
	var $COD_Fam_Accesorio;
	var $Id_Articulo;
	var $CantRecibida;
	var $Precio_Unitario;
	var $TipoArticulo;
	var $MontoTotal;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_recep_accesorio_detail';
		$this->TableName = 'cap_recep_accesorio_detail';
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

		// Id_Compra_Det
		$this->Id_Compra_Det = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_Id_Compra_Det', 'Id_Compra_Det', '`Id_Compra_Det`', '`Id_Compra_Det`', 3, -1, FALSE, '`Id_Compra_Det`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Compra_Det->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Compra_Det'] = &$this->Id_Compra_Det;

		// Id_Compra
		$this->Id_Compra = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_Id_Compra', 'Id_Compra', '`Id_Compra`', '`Id_Compra`', 3, -1, FALSE, '`Id_Compra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Compra->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Compra'] = &$this->Id_Compra;

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_COD_Fam_Accesorio', 'COD_Fam_Accesorio', '`COD_Fam_Accesorio`', '`COD_Fam_Accesorio`', 200, -1, FALSE, '`COD_Fam_Accesorio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Fam_Accesorio'] = &$this->COD_Fam_Accesorio;

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`EV__Id_Articulo`', TRUE, TRUE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// CantRecibida
		$this->CantRecibida = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_CantRecibida', 'CantRecibida', '`CantRecibida`', '`CantRecibida`', 19, -1, FALSE, '`CantRecibida`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->CantRecibida->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['CantRecibida'] = &$this->CantRecibida;

		// Precio_Unitario
		$this->Precio_Unitario = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_Precio_Unitario', 'Precio_Unitario', '`Precio_Unitario`', '`Precio_Unitario`', 131, -1, FALSE, '`Precio_Unitario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_Unitario->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_Unitario'] = &$this->Precio_Unitario;

		// TipoArticulo
		$this->TipoArticulo = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_TipoArticulo', 'TipoArticulo', '`TipoArticulo`', '`TipoArticulo`', 202, -1, FALSE, '`TipoArticulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['TipoArticulo'] = &$this->TipoArticulo;

		// MontoTotal
		$this->MontoTotal = new cField('cap_recep_accesorio_detail', 'cap_recep_accesorio_detail', 'x_MontoTotal', 'MontoTotal', '`MontoTotal`', '`MontoTotal`', 131, -1, FALSE, '`MontoTotal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->MontoTotal->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['MontoTotal'] = &$this->MontoTotal;
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "cap_recep_accesorio") {
			if ($this->Id_Compra->getSessionValue() <> "")
				$sMasterFilter .= "`Id_Compra`=" . ew_QuotedValue($this->Id_Compra->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "cap_recep_accesorio") {
			if ($this->Id_Compra->getSessionValue() <> "")
				$sDetailFilter .= "`Id_Compra`=" . ew_QuotedValue($this->Id_Compra->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_cap_recep_accesorio() {
		return "`Id_Compra`=@Id_Compra@";
	}

	// Detail filter
	function SqlDetailFilter_cap_recep_accesorio() {
		return "`Id_Compra`=@Id_Compra@";
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`cap_recep_accesorio_detail`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlSelectList() { // Select for List page
		return "SELECT * FROM (" .
			"SELECT *, (SELECT `Articulo` FROM `ca_articulos` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`Id_Articulo` = `cap_recep_accesorio_detail`.`Id_Articulo` LIMIT 1) AS `EV__Id_Articulo` FROM `cap_recep_accesorio_detail`" .
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
		if (strpos($sOrderBy, " " . $this->Id_Articulo->FldVirtualExpression . " ") !== FALSE)
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
	var $UpdateTable = "`cap_recep_accesorio_detail`";

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
			$sql .= ew_QuotedName('Id_Compra_Det') . '=' . ew_QuotedValue($rs['Id_Compra_Det'], $this->Id_Compra_Det->FldDataType) . ' AND ';
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
		return "`Id_Compra_Det` = @Id_Compra_Det@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Compra_Det->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Compra_Det@", ew_AdjustSql($this->Id_Compra_Det->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_recep_accesorio_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_recep_accesorio_detaillist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_recep_accesorio_detailview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_recep_accesorio_detailadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_recep_accesorio_detailedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_recep_accesorio_detailadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_recep_accesorio_detaildelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Compra_Det->CurrentValue)) {
			$sUrl .= "Id_Compra_Det=" . urlencode($this->Id_Compra_Det->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Compra_Det"]; // Id_Compra_Det

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
			$this->Id_Compra_Det->CurrentValue = $key;
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
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->CantRecibida->setDbValue($rs->fields('CantRecibida'));
		$this->Precio_Unitario->setDbValue($rs->fields('Precio_Unitario'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->MontoTotal->setDbValue($rs->fields('MontoTotal'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Compra_Det

		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Id_Compra
		$this->Id_Compra->CellCssStyle = "white-space: nowrap;";

		// COD_Fam_Accesorio
		// Id_Articulo
		// CantRecibida
		// Precio_Unitario
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// MontoTotal
		// Id_Compra_Det

		$this->Id_Compra_Det->ViewValue = $this->Id_Compra_Det->CurrentValue;
		$this->Id_Compra_Det->ViewCustomAttributes = "";

		// Id_Compra
		$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
		$this->Id_Compra->ViewCustomAttributes = "";

		// COD_Fam_Accesorio
		if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
			$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Familia_Accesorio` ASC";
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

		// Id_Articulo
		if ($this->Id_Articulo->VirtualValue <> "") {
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->VirtualValue;
		} else {
		if (strval($this->Id_Articulo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Articulo` Asc";
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
		}
		$this->Id_Articulo->ViewCustomAttributes = "";

		// CantRecibida
		$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
		$this->CantRecibida->ViewCustomAttributes = "";

		// Precio_Unitario
		$this->Precio_Unitario->ViewValue = $this->Precio_Unitario->CurrentValue;
		$this->Precio_Unitario->ViewValue = ew_FormatCurrency($this->Precio_Unitario->ViewValue, 2, -2, -2, -2);
		$this->Precio_Unitario->ViewCustomAttributes = "";

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

		// MontoTotal
		$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
		$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
		$this->MontoTotal->ViewCustomAttributes = "";

		// Id_Compra_Det
		$this->Id_Compra_Det->LinkCustomAttributes = "";
		$this->Id_Compra_Det->HrefValue = "";
		$this->Id_Compra_Det->TooltipValue = "";

		// Id_Compra
		$this->Id_Compra->LinkCustomAttributes = "";
		$this->Id_Compra->HrefValue = "";
		$this->Id_Compra->TooltipValue = "";

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio->LinkCustomAttributes = "";
		$this->COD_Fam_Accesorio->HrefValue = "";
		$this->COD_Fam_Accesorio->TooltipValue = "";

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// CantRecibida
		$this->CantRecibida->LinkCustomAttributes = "";
		$this->CantRecibida->HrefValue = "";
		$this->CantRecibida->TooltipValue = "";

		// Precio_Unitario
		$this->Precio_Unitario->LinkCustomAttributes = "";
		$this->Precio_Unitario->HrefValue = "";
		$this->Precio_Unitario->TooltipValue = "";

		// TipoArticulo
		$this->TipoArticulo->LinkCustomAttributes = "";
		$this->TipoArticulo->HrefValue = "";
		$this->TipoArticulo->TooltipValue = "";

		// MontoTotal
		$this->MontoTotal->LinkCustomAttributes = "";
		$this->MontoTotal->HrefValue = "";
		$this->MontoTotal->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->CantRecibida->CurrentValue))
				$this->CantRecibida->Total += $this->CantRecibida->CurrentValue; // Accumulate total
			if (is_numeric($this->MontoTotal->CurrentValue))
				$this->MontoTotal->Total += $this->MontoTotal->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->CantRecibida->CurrentValue = $this->CantRecibida->Total;
			$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
			$this->CantRecibida->ViewCustomAttributes = "";
			$this->CantRecibida->HrefValue = ""; // Clear href value
			$this->MontoTotal->CurrentValue = $this->MontoTotal->Total;
			$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";
			$this->MontoTotal->HrefValue = ""; // Clear href value
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
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->CantRecibida->Exportable) $Doc->ExportCaption($this->CantRecibida);
				if ($this->Precio_Unitario->Exportable) $Doc->ExportCaption($this->Precio_Unitario);
				if ($this->MontoTotal->Exportable) $Doc->ExportCaption($this->MontoTotal);
			} else {
				if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportCaption($this->COD_Fam_Accesorio);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->CantRecibida->Exportable) $Doc->ExportCaption($this->CantRecibida);
				if ($this->Precio_Unitario->Exportable) $Doc->ExportCaption($this->Precio_Unitario);
				if ($this->MontoTotal->Exportable) $Doc->ExportCaption($this->MontoTotal);
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
				$this->AggregateListRowValues(); // Aggregate row values

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->CantRecibida->Exportable) $Doc->ExportField($this->CantRecibida);
					if ($this->Precio_Unitario->Exportable) $Doc->ExportField($this->Precio_Unitario);
					if ($this->MontoTotal->Exportable) $Doc->ExportField($this->MontoTotal);
				} else {
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->CantRecibida->Exportable) $Doc->ExportField($this->CantRecibida);
					if ($this->Precio_Unitario->Exportable) $Doc->ExportField($this->Precio_Unitario);
					if ($this->MontoTotal->Exportable) $Doc->ExportField($this->MontoTotal);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}

		// Export aggregates (horizontal format only)
		if ($Doc->Horizontal) {
			$this->RowType = EW_ROWTYPE_AGGREGATE;
			$this->ResetAttrs();
			$this->AggregateListRow();
			$Doc->BeginExportRow(-1);
			$Doc->ExportAggregate($this->COD_Fam_Accesorio, '');
			$Doc->ExportAggregate($this->Id_Articulo, '');
			$Doc->ExportAggregate($this->CantRecibida, 'TOTAL');
			$Doc->ExportAggregate($this->Precio_Unitario, '');
			$Doc->ExportAggregate($this->MontoTotal, 'TOTAL');
			$Doc->EndExportRow();
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

	   // Indico el TipoArticulo
	  $rsnew['TipoArticulo'] ='Accesorio';
	  return TRUE;                                           
	}                                                         

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

	// Actualiamos el monto total de la compra o recepcion
	  ActualizaMontoTotalCompra($rsnew['Id_Compra']);                                                                                    

	// Actualizamos el Ultimo precio de compra, con el precio guardado
	  DB_Ejecuta("UPDATE ca_articulos SET Precio_compra=".$rsnew['Precio_Unitario']." WHERE Id_Articulo = ".$rsnew['Id_Articulo']); 

	// Vamos a traer el almacen de entrada, para insertarlo ahi.                                     
	  $Id_Almacen_IN = DB_EjecutaScalar("SELECT Id_Almacen_Entrada FROM ca_articulos WHERE Id_Articulo =".$rsnew['Id_Articulo']);                   

	// Agregamos a reg_existencias la cantidad del articulo recibido, en el almacen que le corresponde
	  DB_Ejecuta("UPDATE z_actualiza_existencias_por_compras SET Id_Almacen=" .$Id_Almacen_IN. ",Cantidad_MustBe=Cantidad_MustBe+Cantidad WHERE Id_Compra_Det =" . $rsnew['Id_Compra_Det']);

	// Le ponemos Inventariado a los renglones de esta COMPRA o RECEPCION, con fecha de hoy (OJO  Creo que esto ya no se va a usar, pero por el momento lo dejamos)
	  DB_Ejecuta("UPDATE doc_compra_det set Status_Recepcion='Inventariado',Fecha= NOW()WHERE Id_Compra_Det=" . $rsnew['Id_Compra_Det'] );                                                               

	// Al insertar, regresa a esta pagina en modo Copiar en linea, con el ultimo registro precapturado
	  $Id_Compra_det=&$rsnew['Id_Compra_Det']; // Obtengo el Id_CompraDet
	  header( 'Location: cap_recep_accesorio_detaillist.php?a=copy&Id_Compra_Det='.$Id_Compra_det );
	  exit;
	}                                                                          

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {    

	// Actualizamos TODOS los renglones de la Nota de Compra (no solo el actual)  
	  DB_Ejecuta("UPDATE doc_compra_det SET MontoTotal= Precio_Unitario*CantRecibida WHERE Id_Compra=" . $rsold['Id_Compra']);

	// Actualiamos el monto total de la compra o recepcion                                                
	  ActualizaMontoTotalCompra($rsold['Id_Compra']);                                                                                    

	// Actualizamos el Ultimo precio de compra, con el precio guardado
	  DB_Ejecuta("UPDATE ca_articulos SET Precio_compra=".$rsnew['Precio_Unitario']." WHERE Id_Articulo = ".$rsold['Id_Articulo']);      

	// Vamos a traer el almacen de entrada, para insertarlo ahi.                                     
	  $Id_Almacen_IN = DB_EjecutaScalar("SELECT Id_Almacen_Entrada FROM ca_articulos WHERE Id_Articulo =".$rsnew['Id_Articulo']);                   
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
	  ActualizaMontoTotalCompra($rs['Id_Compra']);
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
