<?php

// Global variable for table object
$cap_lista_precios_accesorios = NULL;

//
// Table class for cap_lista_precios_accesorios
//
class ccap_lista_precios_accesorios extends cTable {
	var $Id_Articulo;
	var $COD_Fam_Accesorio;
	var $COD_Marca_acc;
	var $Articulo;
	var $Codigo;
	var $Precio_compra;
	var $Precio_lista_venta_publico_1;
	var $Precio_lista_venta_publico_2;
	var $Precio_lista_venta_publico_3;
	var $Precio_lista_venta_medio_mayoreo;
	var $Precio_lista_venta_mayoreo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_lista_precios_accesorios';
		$this->TableName = 'cap_lista_precios_accesorios';
		$this->TableType = 'VIEW';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// COD_Fam_Accesorio
		$this->COD_Fam_Accesorio = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_COD_Fam_Accesorio', 'COD_Fam_Accesorio', '`COD_Fam_Accesorio`', '`COD_Fam_Accesorio`', 200, -1, FALSE, '`COD_Fam_Accesorio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Fam_Accesorio'] = &$this->COD_Fam_Accesorio;

		// COD_Marca_acc
		$this->COD_Marca_acc = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_COD_Marca_acc', 'COD_Marca_acc', '`COD_Marca_acc`', '`COD_Marca_acc`', 200, -1, FALSE, '`COD_Marca_acc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['COD_Marca_acc'] = &$this->COD_Marca_acc;

		// Articulo
		$this->Articulo = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Articulo', 'Articulo', '`Articulo`', '`Articulo`', 200, -1, FALSE, '`Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo'] = &$this->Articulo;

		// Codigo
		$this->Codigo = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Precio_compra
		$this->Precio_compra = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_compra', 'Precio_compra', '`Precio_compra`', '`Precio_compra`', 131, -1, FALSE, '`Precio_compra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_compra->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_compra'] = &$this->Precio_compra;

		// Precio_lista_venta_publico_1
		$this->Precio_lista_venta_publico_1 = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_lista_venta_publico_1', 'Precio_lista_venta_publico_1', '`Precio_lista_venta_publico_1`', '`Precio_lista_venta_publico_1`', 131, -1, FALSE, '`Precio_lista_venta_publico_1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_lista_venta_publico_1->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_lista_venta_publico_1'] = &$this->Precio_lista_venta_publico_1;

		// Precio_lista_venta_publico_2
		$this->Precio_lista_venta_publico_2 = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_lista_venta_publico_2', 'Precio_lista_venta_publico_2', '`Precio_lista_venta_publico_2`', '`Precio_lista_venta_publico_2`', 131, -1, FALSE, '`Precio_lista_venta_publico_2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_lista_venta_publico_2->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_lista_venta_publico_2'] = &$this->Precio_lista_venta_publico_2;

		// Precio_lista_venta_publico_3
		$this->Precio_lista_venta_publico_3 = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_lista_venta_publico_3', 'Precio_lista_venta_publico_3', '`Precio_lista_venta_publico_3`', '`Precio_lista_venta_publico_3`', 131, -1, FALSE, '`Precio_lista_venta_publico_3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_lista_venta_publico_3->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_lista_venta_publico_3'] = &$this->Precio_lista_venta_publico_3;

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_lista_venta_medio_mayoreo', 'Precio_lista_venta_medio_mayoreo', '`Precio_lista_venta_medio_mayoreo`', '`Precio_lista_venta_medio_mayoreo`', 131, -1, FALSE, '`Precio_lista_venta_medio_mayoreo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_lista_venta_medio_mayoreo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_lista_venta_medio_mayoreo'] = &$this->Precio_lista_venta_medio_mayoreo;

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo = new cField('cap_lista_precios_accesorios', 'cap_lista_precios_accesorios', 'x_Precio_lista_venta_mayoreo', 'Precio_lista_venta_mayoreo', '`Precio_lista_venta_mayoreo`', '`Precio_lista_venta_mayoreo`', 131, -1, FALSE, '`Precio_lista_venta_mayoreo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_lista_venta_mayoreo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_lista_venta_mayoreo'] = &$this->Precio_lista_venta_mayoreo;
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
		return "`cap_lista_precios_accesorios`";
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
	var $UpdateTable = "`cap_lista_precios_accesorios`";

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
			return "cap_lista_precios_accesorioslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_lista_precios_accesorioslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_lista_precios_accesoriosview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_lista_precios_accesoriosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_lista_precios_accesoriosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_lista_precios_accesoriosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_lista_precios_accesoriosdelete.php", $this->UrlParm());
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
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Precio_compra->setDbValue($rs->fields('Precio_compra'));
		$this->Precio_lista_venta_publico_1->setDbValue($rs->fields('Precio_lista_venta_publico_1'));
		$this->Precio_lista_venta_publico_2->setDbValue($rs->fields('Precio_lista_venta_publico_2'));
		$this->Precio_lista_venta_publico_3->setDbValue($rs->fields('Precio_lista_venta_publico_3'));
		$this->Precio_lista_venta_medio_mayoreo->setDbValue($rs->fields('Precio_lista_venta_medio_mayoreo'));
		$this->Precio_lista_venta_mayoreo->setDbValue($rs->fields('Precio_lista_venta_mayoreo'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Articulo
		// COD_Fam_Accesorio

		$this->COD_Fam_Accesorio->CellCssStyle = "white-space: nowrap;";

		// COD_Marca_acc
		$this->COD_Marca_acc->CellCssStyle = "white-space: nowrap;";

		// Articulo
		// Codigo
		// Precio_compra
		// Precio_lista_venta_publico_1
		// Precio_lista_venta_publico_2
		// Precio_lista_venta_publico_3
		// Precio_lista_venta_medio_mayoreo
		// Precio_lista_venta_mayoreo
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

		// Precio_compra
		$this->Precio_compra->ViewValue = $this->Precio_compra->CurrentValue;
		$this->Precio_compra->ViewCustomAttributes = "";

		// Precio_lista_venta_publico_1
		$this->Precio_lista_venta_publico_1->ViewValue = $this->Precio_lista_venta_publico_1->CurrentValue;
		$this->Precio_lista_venta_publico_1->ViewCustomAttributes = "";

		// Precio_lista_venta_publico_2
		$this->Precio_lista_venta_publico_2->ViewValue = $this->Precio_lista_venta_publico_2->CurrentValue;
		$this->Precio_lista_venta_publico_2->ViewCustomAttributes = "";

		// Precio_lista_venta_publico_3
		$this->Precio_lista_venta_publico_3->ViewValue = $this->Precio_lista_venta_publico_3->CurrentValue;
		$this->Precio_lista_venta_publico_3->ViewCustomAttributes = "";

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo->ViewValue = $this->Precio_lista_venta_medio_mayoreo->CurrentValue;
		$this->Precio_lista_venta_medio_mayoreo->ViewCustomAttributes = "";

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo->ViewValue = $this->Precio_lista_venta_mayoreo->CurrentValue;
		$this->Precio_lista_venta_mayoreo->ViewCustomAttributes = "";

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

		// Articulo
		$this->Articulo->LinkCustomAttributes = "";
		$this->Articulo->HrefValue = "";
		$this->Articulo->TooltipValue = "";

		// Codigo
		$this->Codigo->LinkCustomAttributes = "";
		$this->Codigo->HrefValue = "";
		$this->Codigo->TooltipValue = "";

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

		// Precio_lista_venta_publico_3
		$this->Precio_lista_venta_publico_3->LinkCustomAttributes = "";
		$this->Precio_lista_venta_publico_3->HrefValue = "";
		$this->Precio_lista_venta_publico_3->TooltipValue = "";

		// Precio_lista_venta_medio_mayoreo
		$this->Precio_lista_venta_medio_mayoreo->LinkCustomAttributes = "";
		$this->Precio_lista_venta_medio_mayoreo->HrefValue = "";
		$this->Precio_lista_venta_medio_mayoreo->TooltipValue = "";

		// Precio_lista_venta_mayoreo
		$this->Precio_lista_venta_mayoreo->LinkCustomAttributes = "";
		$this->Precio_lista_venta_mayoreo->HrefValue = "";
		$this->Precio_lista_venta_mayoreo->TooltipValue = "";

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
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportCaption($this->COD_Fam_Accesorio);
				if ($this->COD_Marca_acc->Exportable) $Doc->ExportCaption($this->COD_Marca_acc);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Precio_compra->Exportable) $Doc->ExportCaption($this->Precio_compra);
				if ($this->Precio_lista_venta_publico_1->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_1);
				if ($this->Precio_lista_venta_publico_2->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_2);
				if ($this->Precio_lista_venta_publico_3->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_3);
				if ($this->Precio_lista_venta_medio_mayoreo->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_medio_mayoreo);
				if ($this->Precio_lista_venta_mayoreo->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_mayoreo);
			} else {
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportCaption($this->COD_Fam_Accesorio);
				if ($this->COD_Marca_acc->Exportable) $Doc->ExportCaption($this->COD_Marca_acc);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Precio_compra->Exportable) $Doc->ExportCaption($this->Precio_compra);
				if ($this->Precio_lista_venta_publico_1->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_1);
				if ($this->Precio_lista_venta_publico_2->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_2);
				if ($this->Precio_lista_venta_publico_3->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_publico_3);
				if ($this->Precio_lista_venta_medio_mayoreo->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_medio_mayoreo);
				if ($this->Precio_lista_venta_mayoreo->Exportable) $Doc->ExportCaption($this->Precio_lista_venta_mayoreo);
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
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->COD_Marca_acc->Exportable) $Doc->ExportField($this->COD_Marca_acc);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Precio_compra->Exportable) $Doc->ExportField($this->Precio_compra);
					if ($this->Precio_lista_venta_publico_1->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_1);
					if ($this->Precio_lista_venta_publico_2->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_2);
					if ($this->Precio_lista_venta_publico_3->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_3);
					if ($this->Precio_lista_venta_medio_mayoreo->Exportable) $Doc->ExportField($this->Precio_lista_venta_medio_mayoreo);
					if ($this->Precio_lista_venta_mayoreo->Exportable) $Doc->ExportField($this->Precio_lista_venta_mayoreo);
				} else {
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->COD_Fam_Accesorio->Exportable) $Doc->ExportField($this->COD_Fam_Accesorio);
					if ($this->COD_Marca_acc->Exportable) $Doc->ExportField($this->COD_Marca_acc);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Precio_compra->Exportable) $Doc->ExportField($this->Precio_compra);
					if ($this->Precio_lista_venta_publico_1->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_1);
					if ($this->Precio_lista_venta_publico_2->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_2);
					if ($this->Precio_lista_venta_publico_3->Exportable) $Doc->ExportField($this->Precio_lista_venta_publico_3);
					if ($this->Precio_lista_venta_medio_mayoreo->Exportable) $Doc->ExportField($this->Precio_lista_venta_medio_mayoreo);
					if ($this->Precio_lista_venta_mayoreo->Exportable) $Doc->ExportField($this->Precio_lista_venta_mayoreo);
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
	$rs =& $rsnew;

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

	    //echo "Row Updated"; OJO.. Checando        
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
