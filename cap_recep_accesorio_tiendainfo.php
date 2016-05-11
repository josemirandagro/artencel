<?php

// Global variable for table object
$cap_recep_accesorio_tienda = NULL;

//
// Table class for cap_recep_accesorio_tienda
//
class ccap_recep_accesorio_tienda extends cTable {
	var $Id_Traspaso_Det;
	var $Id_Almacen_Entrega;
	var $Codigo;
	var $Status;
	var $Id_Almacen_Recibe;
	var $Id_Empleado_Recibe;
	var $Id_Empleado_Entrega;
	var $Id_Articulo;
	var $Fecha_recepcion;
	var $Hora_recepcion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_recep_accesorio_tienda';
		$this->TableName = 'cap_recep_accesorio_tienda';
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

		// Id_Traspaso_Det
		$this->Id_Traspaso_Det = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Traspaso_Det', 'Id_Traspaso_Det', '`Id_Traspaso_Det`', '`Id_Traspaso_Det`', 3, -1, FALSE, '`Id_Traspaso_Det`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Traspaso_Det->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Traspaso_Det'] = &$this->Id_Traspaso_Det;

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Almacen_Entrega', 'Id_Almacen_Entrega', '`Id_Almacen_Entrega`', '`Id_Almacen_Entrega`', 3, -1, FALSE, '`Id_Almacen_Entrega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen_Entrega->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen_Entrega'] = &$this->Id_Almacen_Entrega;

		// Codigo
		$this->Codigo = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Status
		$this->Status = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Almacen_Recibe', 'Id_Almacen_Recibe', '`Id_Almacen_Recibe`', '`Id_Almacen_Recibe`', 3, -1, FALSE, '`Id_Almacen_Recibe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen_Recibe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen_Recibe'] = &$this->Id_Almacen_Recibe;

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Empleado_Recibe', 'Id_Empleado_Recibe', '`Id_Empleado_Recibe`', '`Id_Empleado_Recibe`', 3, -1, FALSE, '`Id_Empleado_Recibe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Empleado_Recibe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Empleado_Recibe'] = &$this->Id_Empleado_Recibe;

		// Id_Empleado_Entrega
		$this->Id_Empleado_Entrega = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Empleado_Entrega', 'Id_Empleado_Entrega', '`Id_Empleado_Entrega`', '`Id_Empleado_Entrega`', 3, -1, FALSE, '`Id_Empleado_Entrega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Empleado_Entrega->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Empleado_Entrega'] = &$this->Id_Empleado_Entrega;

		// Id_Articulo
		$this->Id_Articulo = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// Fecha_recepcion
		$this->Fecha_recepcion = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Fecha_recepcion', 'Fecha_recepcion', '`Fecha_recepcion`', 'DATE_FORMAT(`Fecha_recepcion`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`Fecha_recepcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha_recepcion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_recepcion'] = &$this->Fecha_recepcion;

		// Hora_recepcion
		$this->Hora_recepcion = new cField('cap_recep_accesorio_tienda', 'cap_recep_accesorio_tienda', 'x_Hora_recepcion', 'Hora_recepcion', '`Hora_recepcion`', 'DATE_FORMAT(`Hora_recepcion`, \'%d/%m/%Y %H:%i:%s\')', 134, -1, FALSE, '`Hora_recepcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Hora_recepcion->FldDefaultErrMsg = $Language->Phrase("IncorrectTime");
		$this->fields['Hora_recepcion'] = &$this->Hora_recepcion;
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

	// Table level SQL
	function SqlFrom() { // From
		return "`cap_recep_accesorio_tienda`";
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
	var $UpdateTable = "`cap_recep_accesorio_tienda`";

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
			$sql .= ew_QuotedName('Id_Traspaso_Det') . '=' . ew_QuotedValue($rs['Id_Traspaso_Det'], $this->Id_Traspaso_Det->FldDataType) . ' AND ';
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
		return "`Id_Traspaso_Det` = @Id_Traspaso_Det@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Traspaso_Det->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Traspaso_Det@", ew_AdjustSql($this->Id_Traspaso_Det->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_recep_accesorio_tiendalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_recep_accesorio_tiendalist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_recep_accesorio_tiendaview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_recep_accesorio_tiendaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_recep_accesorio_tiendaedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_recep_accesorio_tiendaadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_recep_accesorio_tiendadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Traspaso_Det->CurrentValue)) {
			$sUrl .= "Id_Traspaso_Det=" . urlencode($this->Id_Traspaso_Det->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Traspaso_Det"]; // Id_Traspaso_Det

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
			$this->Id_Traspaso_Det->CurrentValue = $key;
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
		$this->Id_Traspaso_Det->setDbValue($rs->fields('Id_Traspaso_Det'));
		$this->Id_Almacen_Entrega->setDbValue($rs->fields('Id_Almacen_Entrega'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Id_Almacen_Recibe->setDbValue($rs->fields('Id_Almacen_Recibe'));
		$this->Id_Empleado_Recibe->setDbValue($rs->fields('Id_Empleado_Recibe'));
		$this->Id_Empleado_Entrega->setDbValue($rs->fields('Id_Empleado_Entrega'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Fecha_recepcion->setDbValue($rs->fields('Fecha_recepcion'));
		$this->Hora_recepcion->setDbValue($rs->fields('Hora_recepcion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Traspaso_Det

		$this->Id_Traspaso_Det->CellCssStyle = "white-space: nowrap;";

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->CellCssStyle = "white-space: nowrap;";

		// Codigo
		// Status
		// Id_Almacen_Recibe

		$this->Id_Almacen_Recibe->CellCssStyle = "white-space: nowrap;";

		// Id_Empleado_Recibe
		// Id_Empleado_Entrega
		// Id_Articulo
		// Fecha_recepcion
		// Hora_recepcion
		// Id_Traspaso_Det

		$this->Id_Traspaso_Det->ViewValue = $this->Id_Traspaso_Det->CurrentValue;
		$this->Id_Traspaso_Det->ViewCustomAttributes = "";

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->ViewValue = $this->Id_Almacen_Entrega->CurrentValue;
		if (strval($this->Id_Almacen_Entrega->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Almacen_Entrega->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Almacen_Entrega->ViewValue = $this->Id_Almacen_Entrega->CurrentValue;
			}
		} else {
			$this->Id_Almacen_Entrega->ViewValue = NULL;
		}
		$this->Id_Almacen_Entrega->ViewCustomAttributes = "";

		// Codigo
		$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
		$this->Codigo->ViewCustomAttributes = "";

		// Status
		if (strval($this->Status->CurrentValue) <> "") {
			switch ($this->Status->CurrentValue) {
				case $this->Status->FldTagValue(1):
					$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(2):
					$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(3):
					$this->Status->ViewValue = $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->CurrentValue;
					break;
				default:
					$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe->ViewValue = $this->Id_Almacen_Recibe->CurrentValue;
		if (strval($this->Id_Almacen_Recibe->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Recibe->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Almacen_Recibe->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Almacen_Recibe->ViewValue = $this->Id_Almacen_Recibe->CurrentValue;
			}
		} else {
			$this->Id_Almacen_Recibe->ViewValue = NULL;
		}
		$this->Id_Almacen_Recibe->ViewCustomAttributes = "";

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe->ViewValue = $this->Id_Empleado_Recibe->CurrentValue;
		$this->Id_Empleado_Recibe->ViewCustomAttributes = "";

		// Id_Empleado_Entrega
		if (strval($this->Id_Empleado_Entrega->CurrentValue) <> "") {
			$sFilterWrk = "`Id_usuario`" . ew_SearchString("=", $this->Id_Empleado_Entrega->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_usuario`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sys_user`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Empleado_Entrega->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Empleado_Entrega->ViewValue = $this->Id_Empleado_Entrega->CurrentValue;
			}
		} else {
			$this->Id_Empleado_Entrega->ViewValue = NULL;
		}
		$this->Id_Empleado_Entrega->ViewCustomAttributes = "";

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

		// Fecha_recepcion
		$this->Fecha_recepcion->ViewValue = $this->Fecha_recepcion->CurrentValue;
		$this->Fecha_recepcion->ViewValue = ew_FormatDateTime($this->Fecha_recepcion->ViewValue, 7);
		$this->Fecha_recepcion->ViewCustomAttributes = "";

		// Hora_recepcion
		$this->Hora_recepcion->ViewValue = $this->Hora_recepcion->CurrentValue;
		$this->Hora_recepcion->ViewCustomAttributes = "";

		// Id_Traspaso_Det
		$this->Id_Traspaso_Det->LinkCustomAttributes = "";
		$this->Id_Traspaso_Det->HrefValue = "";
		$this->Id_Traspaso_Det->TooltipValue = "";

		// Id_Almacen_Entrega
		$this->Id_Almacen_Entrega->LinkCustomAttributes = "";
		$this->Id_Almacen_Entrega->HrefValue = "";
		$this->Id_Almacen_Entrega->TooltipValue = "";

		// Codigo
		$this->Codigo->LinkCustomAttributes = "";
		$this->Codigo->HrefValue = "";
		$this->Codigo->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// Id_Almacen_Recibe
		$this->Id_Almacen_Recibe->LinkCustomAttributes = "";
		$this->Id_Almacen_Recibe->HrefValue = "";
		$this->Id_Almacen_Recibe->TooltipValue = "";

		// Id_Empleado_Recibe
		$this->Id_Empleado_Recibe->LinkCustomAttributes = "";
		$this->Id_Empleado_Recibe->HrefValue = "";
		$this->Id_Empleado_Recibe->TooltipValue = "";

		// Id_Empleado_Entrega
		$this->Id_Empleado_Entrega->LinkCustomAttributes = "";
		$this->Id_Empleado_Entrega->HrefValue = "";
		$this->Id_Empleado_Entrega->TooltipValue = "";

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// Fecha_recepcion
		$this->Fecha_recepcion->LinkCustomAttributes = "";
		$this->Fecha_recepcion->HrefValue = "";
		$this->Fecha_recepcion->TooltipValue = "";

		// Hora_recepcion
		$this->Hora_recepcion->LinkCustomAttributes = "";
		$this->Hora_recepcion->HrefValue = "";
		$this->Hora_recepcion->TooltipValue = "";

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
				if ($this->Id_Traspaso_Det->Exportable) $Doc->ExportCaption($this->Id_Traspaso_Det);
				if ($this->Id_Almacen_Entrega->Exportable) $Doc->ExportCaption($this->Id_Almacen_Entrega);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportCaption($this->Id_Empleado_Recibe);
				if ($this->Id_Empleado_Entrega->Exportable) $Doc->ExportCaption($this->Id_Empleado_Entrega);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Fecha_recepcion->Exportable) $Doc->ExportCaption($this->Fecha_recepcion);
				if ($this->Hora_recepcion->Exportable) $Doc->ExportCaption($this->Hora_recepcion);
			} else {
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Id_Almacen_Recibe->Exportable) $Doc->ExportCaption($this->Id_Almacen_Recibe);
				if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportCaption($this->Id_Empleado_Recibe);
				if ($this->Id_Empleado_Entrega->Exportable) $Doc->ExportCaption($this->Id_Empleado_Entrega);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Fecha_recepcion->Exportable) $Doc->ExportCaption($this->Fecha_recepcion);
				if ($this->Hora_recepcion->Exportable) $Doc->ExportCaption($this->Hora_recepcion);
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
					if ($this->Id_Traspaso_Det->Exportable) $Doc->ExportField($this->Id_Traspaso_Det);
					if ($this->Id_Almacen_Entrega->Exportable) $Doc->ExportField($this->Id_Almacen_Entrega);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportField($this->Id_Empleado_Recibe);
					if ($this->Id_Empleado_Entrega->Exportable) $Doc->ExportField($this->Id_Empleado_Entrega);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Fecha_recepcion->Exportable) $Doc->ExportField($this->Fecha_recepcion);
					if ($this->Hora_recepcion->Exportable) $Doc->ExportField($this->Hora_recepcion);
				} else {
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Id_Almacen_Recibe->Exportable) $Doc->ExportField($this->Id_Almacen_Recibe);
					if ($this->Id_Empleado_Recibe->Exportable) $Doc->ExportField($this->Id_Empleado_Recibe);
					if ($this->Id_Empleado_Entrega->Exportable) $Doc->ExportField($this->Id_Empleado_Entrega);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Fecha_recepcion->Exportable) $Doc->ExportField($this->Fecha_recepcion);
					if ($this->Hora_recepcion->Exportable) $Doc->ExportField($this->Hora_recepcion);
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
