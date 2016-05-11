<?php

// Global variable for table object
$cap_cancelar_venta = NULL;

//
// Table class for cap_cancelar_venta
//
class ccap_cancelar_venta extends cTable {
	var $Id_Venta_Eq;
	var $Id_Tienda;
	var $Num_IMEI;
	var $FechaVenta;
	var $Cliente;
	var $Id_Tel_SIM;
	var $Status_Venta;
	var $Con_SIM;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_cancelar_venta';
		$this->TableName = 'cap_cancelar_venta';
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
		$this->Id_Venta_Eq = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Id_Venta_Eq', 'Id_Venta_Eq', '`Id_Venta_Eq`', '`Id_Venta_Eq`', 3, -1, FALSE, '`Id_Venta_Eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Venta_Eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Venta_Eq'] = &$this->Id_Venta_Eq;

		// Id_Tienda
		$this->Id_Tienda = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Id_Tienda', 'Id_Tienda', '`Id_Tienda`', '`Id_Tienda`', 3, -1, FALSE, '`Id_Tienda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tienda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tienda'] = &$this->Id_Tienda;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// FechaVenta
		$this->FechaVenta = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_FechaVenta', 'FechaVenta', '`FechaVenta`', 'DATE_FORMAT(`FechaVenta`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaVenta->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaVenta'] = &$this->FechaVenta;

		// Cliente
		$this->Cliente = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Cliente', 'Cliente', '`Cliente`', '`Cliente`', 200, -1, FALSE, '`Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Cliente'] = &$this->Cliente;

		// Id_Tel_SIM
		$this->Id_Tel_SIM = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 3, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Status_Venta
		$this->Status_Venta = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Status_Venta', 'Status_Venta', '`Status_Venta`', '`Status_Venta`', 202, -1, FALSE, '`Status_Venta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status_Venta'] = &$this->Status_Venta;

		// Con_SIM
		$this->Con_SIM = new cField('cap_cancelar_venta', 'cap_cancelar_venta', 'x_Con_SIM', 'Con_SIM', '`Con_SIM`', '`Con_SIM`', 202, -1, FALSE, '`Con_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Con_SIM'] = &$this->Con_SIM;
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
		return "`cap_cancelar_venta`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "`Id_Tienda`=".Id_Tienda_actual();
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
	var $UpdateTable = "`cap_cancelar_venta`";

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
			return "cap_cancelar_ventalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_cancelar_ventalist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_cancelar_ventaview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_cancelar_ventaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_cancelar_ventaedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_cancelar_ventaadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_cancelar_ventadelete.php", $this->UrlParm());
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
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->FechaVenta->setDbValue($rs->fields('FechaVenta'));
		$this->Cliente->setDbValue($rs->fields('Cliente'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Status_Venta->setDbValue($rs->fields('Status_Venta'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Venta_Eq

		$this->Id_Venta_Eq->CellCssStyle = "white-space: nowrap;";

		// Id_Tienda
		// Num_IMEI
		// FechaVenta
		// Cliente
		// Id_Tel_SIM
		// Status_Venta
		// Con_SIM
		// Id_Venta_Eq

		$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
		$this->Id_Venta_Eq->ViewCustomAttributes = "";

		// Id_Tienda
		$this->Id_Tienda->ViewValue = $this->Id_Tienda->CurrentValue;
		$this->Id_Tienda->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// FechaVenta
		$this->FechaVenta->ViewValue = $this->FechaVenta->CurrentValue;
		$this->FechaVenta->ViewValue = ew_FormatDateTime($this->FechaVenta->ViewValue, 7);
		$this->FechaVenta->ViewCustomAttributes = "";

		// Cliente
		if (strval($this->Cliente->CurrentValue) <> "") {
			$sFilterWrk = "`Cliente`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Cliente`, `Cliente` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cap_cancelar_venta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`Id_Tienda`=".Id_Tienda_actual();
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Cliente`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Cliente->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
			}
		} else {
			$this->Cliente->ViewValue = NULL;
		}
		$this->Cliente->ViewCustomAttributes = "";

		// Id_Tel_SIM
		if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipo_vendido`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Articulo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
				$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			}
		} else {
			$this->Id_Tel_SIM->ViewValue = NULL;
		}
		$this->Id_Tel_SIM->ViewCustomAttributes = "";

		// Status_Venta
		if (strval($this->Status_Venta->CurrentValue) <> "") {
			switch ($this->Status_Venta->CurrentValue) {
				case $this->Status_Venta->FldTagValue(1):
					$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(1) <> "" ? $this->Status_Venta->FldTagCaption(1) : $this->Status_Venta->CurrentValue;
					break;
				case $this->Status_Venta->FldTagValue(2):
					$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(2) <> "" ? $this->Status_Venta->FldTagCaption(2) : $this->Status_Venta->CurrentValue;
					break;
				case $this->Status_Venta->FldTagValue(3):
					$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(3) <> "" ? $this->Status_Venta->FldTagCaption(3) : $this->Status_Venta->CurrentValue;
					break;
				case $this->Status_Venta->FldTagValue(4):
					$this->Status_Venta->ViewValue = $this->Status_Venta->FldTagCaption(4) <> "" ? $this->Status_Venta->FldTagCaption(4) : $this->Status_Venta->CurrentValue;
					break;
				default:
					$this->Status_Venta->ViewValue = $this->Status_Venta->CurrentValue;
			}
		} else {
			$this->Status_Venta->ViewValue = NULL;
		}
		$this->Status_Venta->ViewCustomAttributes = "";

		// Con_SIM
		if (strval($this->Con_SIM->CurrentValue) <> "") {
			switch ($this->Con_SIM->CurrentValue) {
				case $this->Con_SIM->FldTagValue(1):
					$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(1) <> "" ? $this->Con_SIM->FldTagCaption(1) : $this->Con_SIM->CurrentValue;
					break;
				case $this->Con_SIM->FldTagValue(2):
					$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(2) <> "" ? $this->Con_SIM->FldTagCaption(2) : $this->Con_SIM->CurrentValue;
					break;
				case $this->Con_SIM->FldTagValue(3):
					$this->Con_SIM->ViewValue = $this->Con_SIM->FldTagCaption(3) <> "" ? $this->Con_SIM->FldTagCaption(3) : $this->Con_SIM->CurrentValue;
					break;
				default:
					$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
			}
		} else {
			$this->Con_SIM->ViewValue = NULL;
		}
		$this->Con_SIM->ViewCustomAttributes = "";

		// Id_Venta_Eq
		$this->Id_Venta_Eq->LinkCustomAttributes = "";
		$this->Id_Venta_Eq->HrefValue = "";
		$this->Id_Venta_Eq->TooltipValue = "";

		// Id_Tienda
		$this->Id_Tienda->LinkCustomAttributes = "";
		$this->Id_Tienda->HrefValue = "";
		$this->Id_Tienda->TooltipValue = "";

		// Num_IMEI
		$this->Num_IMEI->LinkCustomAttributes = "";
		$this->Num_IMEI->HrefValue = "";
		$this->Num_IMEI->TooltipValue = "";

		// FechaVenta
		$this->FechaVenta->LinkCustomAttributes = "";
		$this->FechaVenta->HrefValue = "";
		$this->FechaVenta->TooltipValue = "";

		// Cliente
		$this->Cliente->LinkCustomAttributes = "";
		$this->Cliente->HrefValue = "";
		$this->Cliente->TooltipValue = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Status_Venta
		$this->Status_Venta->LinkCustomAttributes = "";
		$this->Status_Venta->HrefValue = "";
		$this->Status_Venta->TooltipValue = "";

		// Con_SIM
		$this->Con_SIM->LinkCustomAttributes = "";
		$this->Con_SIM->HrefValue = "";
		$this->Con_SIM->TooltipValue = "";

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
				if ($this->Id_Tienda->Exportable) $Doc->ExportCaption($this->Id_Tienda);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->FechaVenta->Exportable) $Doc->ExportCaption($this->FechaVenta);
				if ($this->Cliente->Exportable) $Doc->ExportCaption($this->Cliente);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Status_Venta->Exportable) $Doc->ExportCaption($this->Status_Venta);
				if ($this->Con_SIM->Exportable) $Doc->ExportCaption($this->Con_SIM);
			} else {
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->FechaVenta->Exportable) $Doc->ExportCaption($this->FechaVenta);
				if ($this->Cliente->Exportable) $Doc->ExportCaption($this->Cliente);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Status_Venta->Exportable) $Doc->ExportCaption($this->Status_Venta);
				if ($this->Con_SIM->Exportable) $Doc->ExportCaption($this->Con_SIM);
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
					if ($this->Id_Tienda->Exportable) $Doc->ExportField($this->Id_Tienda);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->FechaVenta->Exportable) $Doc->ExportField($this->FechaVenta);
					if ($this->Cliente->Exportable) $Doc->ExportField($this->Cliente);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Status_Venta->Exportable) $Doc->ExportField($this->Status_Venta);
					if ($this->Con_SIM->Exportable) $Doc->ExportField($this->Con_SIM);
				} else {
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->FechaVenta->Exportable) $Doc->ExportField($this->FechaVenta);
					if ($this->Cliente->Exportable) $Doc->ExportField($this->Cliente);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Status_Venta->Exportable) $Doc->ExportField($this->Status_Venta);
					if ($this->Con_SIM->Exportable) $Doc->ExportField($this->Con_SIM);
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

	  // Checamos si pusieron StatusVenta en CANCELCION O DEVOLUCION)
	  IF ($rsnew['Status_Venta'] != 'Vendido') {

		// INSERTAMOS el renglon correspondiente en reg_reingresos
		DB_Ejecuta("INSERT INTO reg_reingreso_eq
						  (Id_Venta_Eq,Id_Tel_SIM,Id_Tienda,Id_Cliente,Id_Articulo,
						   PrecioUnitario,MontoDescuento,Precio_SIM,
						   Monto,Num_IMEI,Num_ICCID,Num_CEL,Num_ICCID_Nota,Num_CEL_Nota,                                   
						   FechaVenta,Id_Vendedor,Causa,Fecha_Reingreso,Con_SIM)                                     
					SELECT * FROM z_datos_a_insertar_reg_reingreso_x_cancelacion WHERE Id_Venta_eq=".$rsold['Id_Venta_Eq']); 

	  //  Ponemos el EQUiPO disponible para la venta, tal como estaba en reg_unico_tel_sim                                  
	  DB_Ejecuta ("UPDATE reg_unico_tel_sim SET `Status`='Tienda',Status_resurtido='Pendiente' WHERE Id_Tel_SIM=".$rsold['Id_Tel_SIM']);   

	   // Si el campo Con_SIM en doc_venta_eq, traia 'Migracion', lo convertimos a 'SI'
	//  DB_Ejecuta("");                                                                 
	  // Ahora directamente a editar los datos de la cancelacion, (Con_SIM, Motivo,...) 
	  // Mostrando los avisos pertinentes. (Verificar IMEI, Verificar ICCID...)                                        

	  header('Location: cap_datos_reingreso_x_cancelacion_tiendaedit.php?Id_Venta_Eq='.$rsold['Id_Venta_Eq']);
	  exit;      
	  }
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
