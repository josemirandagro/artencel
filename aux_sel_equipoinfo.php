<?php

// Global variable for table object
$aux_sel_equipo = NULL;

//
// Table class for aux_sel_equipo
//
class caux_sel_equipo extends cTable {
	var $Id_Tel_SIM;
	var $Id_Almacen;
	var $Articulo;
	var $Codigo;
	var $Acabado_eq;
	var $Num_IMEI;
	var $Num_ICCID;
	var $Num_CEL;
	var $Id_Articulo;
	var $Id_Acabado_eq;
	var $Status;
	var $EquipoAcabado;
	var $Precio_Venta;
	var $TipoEquipo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'aux_sel_equipo';
		$this->TableName = 'aux_sel_equipo';
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
		$this->Id_Tel_SIM = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 19, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Id_Almacen
		$this->Id_Almacen = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Id_Almacen', 'Id_Almacen', '`Id_Almacen`', '`Id_Almacen`', 3, -1, FALSE, '`Id_Almacen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen'] = &$this->Id_Almacen;

		// Articulo
		$this->Articulo = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Articulo', 'Articulo', '`Articulo`', '`Articulo`', 200, -1, FALSE, '`Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo'] = &$this->Articulo;

		// Codigo
		$this->Codigo = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Acabado_eq
		$this->Acabado_eq = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Acabado_eq', 'Acabado_eq', '`Acabado_eq`', '`Acabado_eq`', 200, -1, FALSE, '`Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Acabado_eq'] = &$this->Acabado_eq;

		// Num_IMEI
		$this->Num_IMEI = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// Num_ICCID
		$this->Num_ICCID = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Num_ICCID', 'Num_ICCID', '`Num_ICCID`', '`Num_ICCID`', 200, -1, FALSE, '`Num_ICCID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_ICCID'] = &$this->Num_ICCID;

		// Num_CEL
		$this->Num_CEL = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Num_CEL', 'Num_CEL', '`Num_CEL`', '`Num_CEL`', 200, -1, FALSE, '`Num_CEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_CEL'] = &$this->Num_CEL;

		// Id_Articulo
		$this->Id_Articulo = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Id_Articulo', 'Id_Articulo', '`Id_Articulo`', '`Id_Articulo`', 3, -1, FALSE, '`Id_Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Articulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Articulo'] = &$this->Id_Articulo;

		// Id_Acabado_eq
		$this->Id_Acabado_eq = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Id_Acabado_eq', 'Id_Acabado_eq', '`Id_Acabado_eq`', '`Id_Acabado_eq`', 3, -1, FALSE, '`Id_Acabado_eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Acabado_eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Acabado_eq'] = &$this->Id_Acabado_eq;

		// Status
		$this->Status = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// EquipoAcabado
		$this->EquipoAcabado = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_EquipoAcabado', 'EquipoAcabado', '`EquipoAcabado`', '`EquipoAcabado`', 200, -1, FALSE, '`EquipoAcabado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['EquipoAcabado'] = &$this->EquipoAcabado;

		// Precio_Venta
		$this->Precio_Venta = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_Precio_Venta', 'Precio_Venta', '`Precio_Venta`', '`Precio_Venta`', 131, -1, FALSE, '`Precio_Venta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Precio_Venta->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Precio_Venta'] = &$this->Precio_Venta;

		// TipoEquipo
		$this->TipoEquipo = new cField('aux_sel_equipo', 'aux_sel_equipo', 'x_TipoEquipo', 'TipoEquipo', '`TipoEquipo`', '`TipoEquipo`', 200, -1, FALSE, '`TipoEquipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['TipoEquipo'] = &$this->TipoEquipo;
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
		return "`aux_sel_equipo`";
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
	var $UpdateTable = "`aux_sel_equipo`";

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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "aux_sel_equipolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "aux_sel_equipolist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("aux_sel_equipoview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "aux_sel_equipoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("aux_sel_equipoedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("aux_sel_equipoadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("aux_sel_equipodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
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
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Acabado_eq->setDbValue($rs->fields('Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->EquipoAcabado->setDbValue($rs->fields('EquipoAcabado'));
		$this->Precio_Venta->setDbValue($rs->fields('Precio_Venta'));
		$this->TipoEquipo->setDbValue($rs->fields('TipoEquipo'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Tel_SIM
		// Id_Almacen
		// Articulo
		// Codigo
		// Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Id_Articulo
		// Id_Acabado_eq
		// Status
		// EquipoAcabado
		// Precio_Venta
		// TipoEquipo
		// Id_Tel_SIM

		$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
		$this->Id_Tel_SIM->ViewCustomAttributes = "";

		// Id_Almacen
		$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
		$this->Id_Almacen->ViewCustomAttributes = "";

		// Articulo
		$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
		$this->Articulo->ViewCustomAttributes = "";

		// Codigo
		$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
		$this->Codigo->ViewCustomAttributes = "";

		// Acabado_eq
		$this->Acabado_eq->ViewValue = $this->Acabado_eq->CurrentValue;
		$this->Acabado_eq->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// Num_ICCID
		$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
		$this->Num_ICCID->ViewCustomAttributes = "";

		// Num_CEL
		$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
		$this->Num_CEL->ViewCustomAttributes = "";

		// Id_Articulo
		$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
		$this->Id_Articulo->ViewCustomAttributes = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
		$this->Id_Acabado_eq->ViewCustomAttributes = "";

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
				case $this->Status->FldTagValue(4):
					$this->Status->ViewValue = $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->CurrentValue;
					break;
				default:
					$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// EquipoAcabado
		$this->EquipoAcabado->ViewValue = $this->EquipoAcabado->CurrentValue;
		$this->EquipoAcabado->ViewCustomAttributes = "";

		// Precio_Venta
		$this->Precio_Venta->ViewValue = $this->Precio_Venta->CurrentValue;
		$this->Precio_Venta->ViewCustomAttributes = "";

		// TipoEquipo
		$this->TipoEquipo->ViewValue = $this->TipoEquipo->CurrentValue;
		$this->TipoEquipo->ViewCustomAttributes = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Id_Almacen
		$this->Id_Almacen->LinkCustomAttributes = "";
		$this->Id_Almacen->HrefValue = "";
		$this->Id_Almacen->TooltipValue = "";

		// Articulo
		$this->Articulo->LinkCustomAttributes = "";
		$this->Articulo->HrefValue = "";
		$this->Articulo->TooltipValue = "";

		// Codigo
		$this->Codigo->LinkCustomAttributes = "";
		$this->Codigo->HrefValue = "";
		$this->Codigo->TooltipValue = "";

		// Acabado_eq
		$this->Acabado_eq->LinkCustomAttributes = "";
		$this->Acabado_eq->HrefValue = "";
		$this->Acabado_eq->TooltipValue = "";

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

		// Id_Articulo
		$this->Id_Articulo->LinkCustomAttributes = "";
		$this->Id_Articulo->HrefValue = "";
		$this->Id_Articulo->TooltipValue = "";

		// Id_Acabado_eq
		$this->Id_Acabado_eq->LinkCustomAttributes = "";
		$this->Id_Acabado_eq->HrefValue = "";
		$this->Id_Acabado_eq->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// EquipoAcabado
		$this->EquipoAcabado->LinkCustomAttributes = "";
		$this->EquipoAcabado->HrefValue = "";
		$this->EquipoAcabado->TooltipValue = "";

		// Precio_Venta
		$this->Precio_Venta->LinkCustomAttributes = "";
		$this->Precio_Venta->HrefValue = "";
		$this->Precio_Venta->TooltipValue = "";

		// TipoEquipo
		$this->TipoEquipo->LinkCustomAttributes = "";
		$this->TipoEquipo->HrefValue = "";
		$this->TipoEquipo->TooltipValue = "";

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
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Acabado_eq->Exportable) $Doc->ExportCaption($this->Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->EquipoAcabado->Exportable) $Doc->ExportCaption($this->EquipoAcabado);
				if ($this->Precio_Venta->Exportable) $Doc->ExportCaption($this->Precio_Venta);
				if ($this->TipoEquipo->Exportable) $Doc->ExportCaption($this->TipoEquipo);
			} else {
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Almacen->Exportable) $Doc->ExportCaption($this->Id_Almacen);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Acabado_eq->Exportable) $Doc->ExportCaption($this->Acabado_eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Id_Articulo->Exportable) $Doc->ExportCaption($this->Id_Articulo);
				if ($this->Id_Acabado_eq->Exportable) $Doc->ExportCaption($this->Id_Acabado_eq);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->EquipoAcabado->Exportable) $Doc->ExportCaption($this->EquipoAcabado);
				if ($this->Precio_Venta->Exportable) $Doc->ExportCaption($this->Precio_Venta);
				if ($this->TipoEquipo->Exportable) $Doc->ExportCaption($this->TipoEquipo);
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
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Acabado_eq->Exportable) $Doc->ExportField($this->Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->EquipoAcabado->Exportable) $Doc->ExportField($this->EquipoAcabado);
					if ($this->Precio_Venta->Exportable) $Doc->ExportField($this->Precio_Venta);
					if ($this->TipoEquipo->Exportable) $Doc->ExportField($this->TipoEquipo);
				} else {
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Almacen->Exportable) $Doc->ExportField($this->Id_Almacen);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Acabado_eq->Exportable) $Doc->ExportField($this->Acabado_eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Id_Articulo->Exportable) $Doc->ExportField($this->Id_Articulo);
					if ($this->Id_Acabado_eq->Exportable) $Doc->ExportField($this->Id_Acabado_eq);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->EquipoAcabado->Exportable) $Doc->ExportField($this->EquipoAcabado);
					if ($this->Precio_Venta->Exportable) $Doc->ExportField($this->Precio_Venta);
					if ($this->TipoEquipo->Exportable) $Doc->ExportField($this->TipoEquipo);
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
