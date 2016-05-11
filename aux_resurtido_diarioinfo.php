<?php

// Global variable for table object
$aux_resurtido_diario = NULL;

//
// Table class for aux_resurtido_diario
//
class caux_resurtido_diario extends cTable {
	var $Id;
	var $Id_Almacen;
	var $Id_Articulo;
	var $Id_Acabado_eq;
	var $Id_Tel_SIM;
	var $Id_Traspaso;
	var $Tipo;
	var $Fecha;
	var $Disponibles;
	var $Num_IMEI;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'aux_resurtido_diario';
		$this->TableName = 'aux_resurtido_diario';
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

		// Id
		$this->Id = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id', 'Id', '`Id`', '`Id`', 19, -1, FALSE, '`Id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id'] = &$this->Id;

		// Id_Almacen
		$this->Id_Almacen = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id_Almacen', 'Id_Almacen', '`Id_Almacen`', '`Id_Almacen`', 3, -1, FALSE, '`Id_Almacen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen'] = &$this->Id_Almacen;

		// Id_Articulo
		$this->Id_Articulo = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// Id_Acabado_eq
		$this->Id_Acabado_eq = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id_Acabado_eq', 'Id_Acabado_eq', '`Id_Acabado_eq`', '`Id_Acabado_eq`', 3, -1, FALSE, '`Id_Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Acabado_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Acabado_eq'] = &$this->Id_Acabado_eq;

		// Id_Tel_SIM
		$this->Id_Tel_SIM = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 3, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Id_Traspaso
		$this->Id_Traspaso = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Id_Traspaso', 'Id_Traspaso', '`Id_Traspaso`', '`Id_Traspaso`', 3, -1, FALSE, '`Id_Traspaso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Traspaso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Traspaso'] = &$this->Id_Traspaso;

		// Tipo
		$this->Tipo = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Tipo', 'Tipo', '`Tipo`', '`Tipo`', 202, -1, FALSE, '`Tipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tipo'] = &$this->Tipo;

		// Fecha
		$this->Fecha = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Fecha', 'Fecha', '`Fecha`', 'DATE_FORMAT(`Fecha`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`Fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha'] = &$this->Fecha;

		// Disponibles
		$this->Disponibles = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Disponibles', 'Disponibles', '`Disponibles`', '`Disponibles`', 3, -1, FALSE, '`Disponibles`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Disponibles->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Disponibles'] = &$this->Disponibles;

		// Num_IMEI
		$this->Num_IMEI = new cField('aux_resurtido_diario', 'aux_resurtido_diario', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;
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
		if ($this->getCurrentDetailTable() == "con_invent_equipo_imeis") {
			$sDetailUrl = $GLOBALS["con_invent_equipo_imeis"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&Id_Almacen=" . $this->Id_Almacen->CurrentValue;
			$sDetailUrl .= "&Id_Articulo=" . $this->Id_Articulo->CurrentValue;
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`aux_resurtido_diario`";
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
	var $UpdateTable = "`aux_resurtido_diario`";

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
			$sql .= ew_QuotedName('Id') . '=' . ew_QuotedValue($rs['Id'], $this->Id->FldDataType) . ' AND ';
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
		return "`Id` = @Id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id@", ew_AdjustSql($this->Id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "aux_resurtido_diariolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "aux_resurtido_diariolist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("aux_resurtido_diarioview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "aux_resurtido_diarioadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("aux_resurtido_diarioedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("aux_resurtido_diarioedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("aux_resurtido_diarioadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("aux_resurtido_diarioadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("aux_resurtido_diariodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id->CurrentValue)) {
			$sUrl .= "Id=" . urlencode($this->Id->CurrentValue);
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
			$arKeys[] = @$_GET["Id"]; // Id

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
			$this->Id->CurrentValue = $key;
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
		$this->Id->setDbValue($rs->fields('Id'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Tipo->setDbValue($rs->fields('Tipo'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Disponibles->setDbValue($rs->fields('Disponibles'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id

		$this->Id->CellCssStyle = "white-space: nowrap;";

		// Id_Almacen
		// Id_Articulo

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->CellCssStyle = "white-space: nowrap;";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->CellCssStyle = "white-space: nowrap;";

		// Id_Traspaso
		$this->Id_Traspaso->CellCssStyle = "white-space: nowrap;";

		// Tipo
		$this->Tipo->CellCssStyle = "white-space: nowrap;";

		// Fecha
		$this->Fecha->CellCssStyle = "white-space: nowrap;";

		// Disponibles
		// Num_IMEI
		// Id

		$this->Id->ViewValue = $this->Id->CurrentValue;
		$this->Id->ViewCustomAttributes = "";

		// Id_Almacen
		if (strval($this->Id_Almacen->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Almacen->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
			}
		} else {
			$this->Id_Almacen->ViewValue = NULL;
		}
		$this->Id_Almacen->ViewCustomAttributes = "";

		// Id_Articulo
		$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
		if (strval($this->Id_Articulo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Id_Tel_SIM
		if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Tel_SIM`, `Num_IMEI` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `reg_unico_tel_sim`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Num_IMEI`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			}
		} else {
			$this->Id_Tel_SIM->ViewValue = NULL;
		}
		$this->Id_Tel_SIM->ViewCustomAttributes = "";

		// Id_Traspaso
		$this->Id_Traspaso->ViewValue = $this->Id_Traspaso->CurrentValue;
		$this->Id_Traspaso->ViewCustomAttributes = "";

		// Tipo
		if (strval($this->Tipo->CurrentValue) <> "") {
			switch ($this->Tipo->CurrentValue) {
				case $this->Tipo->FldTagValue(1):
					$this->Tipo->ViewValue = $this->Tipo->FldTagCaption(1) <> "" ? $this->Tipo->FldTagCaption(1) : $this->Tipo->CurrentValue;
					break;
				case $this->Tipo->FldTagValue(2):
					$this->Tipo->ViewValue = $this->Tipo->FldTagCaption(2) <> "" ? $this->Tipo->FldTagCaption(2) : $this->Tipo->CurrentValue;
					break;
				default:
					$this->Tipo->ViewValue = $this->Tipo->CurrentValue;
			}
		} else {
			$this->Tipo->ViewValue = NULL;
		}
		$this->Tipo->ViewCustomAttributes = "";

		// Fecha
		$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
		$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
		$this->Fecha->ViewCustomAttributes = "";

		// Disponibles
		$this->Disponibles->ViewValue = $this->Disponibles->CurrentValue;
		$this->Disponibles->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// Id
		$this->Id->LinkCustomAttributes = "";
		$this->Id->HrefValue = "";
		$this->Id->TooltipValue = "";

		// Id_Almacen
		$this->Id_Almacen->LinkCustomAttributes = "";
		$this->Id_Almacen->HrefValue = "";
		$this->Id_Almacen->TooltipValue = "";

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->LinkCustomAttributes = "";
		$this->Id_Acabado_eq->HrefValue = "";
		$this->Id_Acabado_eq->TooltipValue = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Id_Traspaso
		$this->Id_Traspaso->LinkCustomAttributes = "";
		$this->Id_Traspaso->HrefValue = "";
		$this->Id_Traspaso->TooltipValue = "";

		// Tipo
		$this->Tipo->LinkCustomAttributes = "";
		$this->Tipo->HrefValue = "";
		$this->Tipo->TooltipValue = "";

		// Fecha
		$this->Fecha->LinkCustomAttributes = "";
		$this->Fecha->HrefValue = "";
		$this->Fecha->TooltipValue = "";

		// Disponibles
		$this->Disponibles->LinkCustomAttributes = "";
		$this->Disponibles->HrefValue = "";
		$this->Disponibles->TooltipValue = "";

		// Num_IMEI
		$this->Num_IMEI->LinkCustomAttributes = "";
		$this->Num_IMEI->HrefValue = "";
		$this->Num_IMEI->TooltipValue = "";

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
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Tipo->Exportable) $Doc->ExportCaption($this->Tipo);
				if ($this->Disponibles->Exportable) $Doc->ExportCaption($this->Disponibles);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
			} else {
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Disponibles->Exportable) $Doc->ExportCaption($this->Disponibles);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
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
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Tipo->Exportable) $Doc->ExportField($this->Tipo);
					if ($this->Disponibles->Exportable) $Doc->ExportField($this->Disponibles);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
				} else {
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Disponibles->Exportable) $Doc->ExportField($this->Disponibles);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
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

		// Vamos a verificar que el IMEI Capturado
	//    $Reg= DB_EjecutaRs("SELECT Num_IMEI,Id_Almacen,Id_Articulo FROM reg_unico_tel_sim WHERE Num_IMEI='".$rsnew['Num_IMEI']."' AND Id_Almacen=".Id_Tienda_Actual()." AND Id_Articulo=".$rsold['Id_Articulo']." AND Status='Tienda'");

		$Reg= DB_EjecutaRs("SELECT Num_IMEI,Id_Almacen,Id_Articulo FROM reg_unico_tel_sim WHERE Num_IMEI='".$rsnew['Num_IMEI']."' AND Id_Almacen=".Id_Tienda_Actual()." AND Status='Tienda'");

	   // Si no encontro el IMEI seleccionado en la Tienda Aftual (Este caso de uso solo debe poderse ejecutar desde Tajonar)                       
		if ($Reg['Num_IMEI']=="") {                                                                                                                
		  Alertame(" El TELEFONO CON IMEI " . $rsnew['Num_IMEI'] . " NO ESTA REGISTRADO PARA RESURTIR EN LA TIENDA ACTUAL "); 
		  return false;
		}                                                        

		//  Si pusieron un IMEI que si esta en al tienda, pero corresponde a otro modelo de teléfono
		if (! ($rsold['Id_Articulo'] == $Reg['Id_Articulo']) )  {
		  Alertame(" El TELEFONO CON IMEI " . $rsnew['Num_IMEI'] . " NO ES DEL MISMO MODELO. NO SE PUEDE RESURTIR ");             
		  return false;
		}

	//    echo "  IMEI=" .    $Reg['Num_IMEI'];    
	//    echo "  Almacen =" .$Reg['Id_Almacen'];    
	//    echo "  Articulo=". $Reg['Id_Articulo'];     

		return true;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

	 // Primero Aveiguamos el Id_Tel_SIM del IMEI que eligiron, ya que no le tengo
	 $Id_TSIM_Nuevo = DB_EjecutaScalar("SELECT Id_Tel_SIM FROM reg_unico_tel_sim WHERE Num_IMEI =".$rsnew['Num_IMEI']);

	 // INSERTAMOS EL TRAPASO DEL TELEFONO A LA TIENDA CORRESPONDIENTE
	 DB_Ejecuta("INSERT INTO doc_traspaso_det (TipoArticulo,Cantidad,Status,Fecha,Hora,Observaciones,
											   Codigo,             Id_Articulo,               Id_Tel_SIM,                Id_Almacen_Entrega,Id_Almacen_Recibe,  Id_Empleado_Entrega)
										VALUES('Equipo',1,'Enviado',CURRENT_DATE(),CURRENT_TIME(),'Resurtido',"                                        
											  .$rsnew['Num_IMEI'].",".$rsold['Id_Articulo']. "," .$Id_TSIM_Nuevo. "," .Id_Tienda_Actual(). "," .$rsold['Id_Almacen']. "," .CurrentUserID().")");                                            

	  // Llenamos la descripcion del equipo en el registro de traspaso, con los datos del equipo que se está enviando                                        
	 Db_Ejecuta("UPDATE z_llenar_descripcion_equipo_en_traspaso SET Descripcion = New_Desc");                                          

	 //  OJO... REVISAR POR QUE PUSO STATUS Tienda  al que ya estaba vendido y 
	 //  Al recibir en tienda no le cambio el Status... En pocas palabras revisar el Proceso completo
	 // PONEMOS Status_resurtido = 'Resurtido' al telefono que YA esta vendido y que estamos resurtiendo

	  DB_Ejecuta("UPDATE reg_unico_tel_sim SET Status_resurtido='Resurtido' WHERE Id_Tel_SIM=".$rsold['Id_Tel_SIM']);

	 // PONEMOS Status='Transito' en Reg_Unico_Tel_SIM, y la tienda Destino, al telefono con el IMEI Seleccionado indicando que va en camino
	  DB_Ejecuta("UPDATE reg_unico_tel_sim SET `Status`='Transito', Id_Almacen=".$rsold['Id_Almacen']." WHERE Num_IMEI='".$rsnew['Num_IMEI']."'");           

	 // Hay que volver a la pagina list. Automaticamente debe quedar borrado el renglon en aux_resurtido_diario, y se deben racalcular los existentes
	  Redireccionar('aux_resurtido_diariolist.php');                    
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
