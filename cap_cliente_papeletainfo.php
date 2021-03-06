<?php

// Global variable for table object
$cap_cliente_papeleta = NULL;

//
// Table class for cap_cliente_papeleta
//
class ccap_cliente_papeleta extends cTable {
	var $Id_Cliente;
	var $Nombre_Completo;
	var $Domicilio;
	var $Num_Exterior;
	var $Num_Interior;
	var $Colonia;
	var $Poblacion;
	var $CP;
	var $Id_Estado;
	var $Tel_Particular;
	var $Tel_Oficina;
	var $Tipo_Identificacion;
	var $Numero_Identificacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_cliente_papeleta';
		$this->TableName = 'cap_cliente_papeleta';
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

		// Id_Cliente
		$this->Id_Cliente = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Id_Cliente', 'Id_Cliente', '`Id_Cliente`', '`Id_Cliente`', 3, -1, FALSE, '`Id_Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Cliente'] = &$this->Id_Cliente;

		// Nombre_Completo
		$this->Nombre_Completo = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Nombre_Completo', 'Nombre_Completo', '`Nombre_Completo`', '`Nombre_Completo`', 200, -1, FALSE, '`Nombre_Completo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre_Completo'] = &$this->Nombre_Completo;

		// Domicilio
		$this->Domicilio = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Num_Exterior
		$this->Num_Exterior = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Num_Exterior', 'Num_Exterior', '`Num_Exterior`', '`Num_Exterior`', 200, -1, FALSE, '`Num_Exterior`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_Exterior'] = &$this->Num_Exterior;

		// Num_Interior
		$this->Num_Interior = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Num_Interior', 'Num_Interior', '`Num_Interior`', '`Num_Interior`', 200, -1, FALSE, '`Num_Interior`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_Interior'] = &$this->Num_Interior;

		// Colonia
		$this->Colonia = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Colonia', 'Colonia', '`Colonia`', '`Colonia`', 200, -1, FALSE, '`Colonia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Colonia'] = &$this->Colonia;

		// Poblacion
		$this->Poblacion = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Poblacion', 'Poblacion', '`Poblacion`', '`Poblacion`', 200, -1, FALSE, '`Poblacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Poblacion'] = &$this->Poblacion;

		// CP
		$this->CP = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_CP', 'CP', '`CP`', '`CP`', 200, -1, FALSE, '`CP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CP'] = &$this->CP;

		// Id_Estado
		$this->Id_Estado = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// Tel_Particular
		$this->Tel_Particular = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Tel_Particular', 'Tel_Particular', '`Tel_Particular`', '`Tel_Particular`', 200, -1, FALSE, '`Tel_Particular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tel_Particular'] = &$this->Tel_Particular;

		// Tel_Oficina
		$this->Tel_Oficina = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Tel_Oficina', 'Tel_Oficina', '`Tel_Oficina`', '`Tel_Oficina`', 200, -1, FALSE, '`Tel_Oficina`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tel_Oficina'] = &$this->Tel_Oficina;

		// Tipo_Identificacion
		$this->Tipo_Identificacion = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Tipo_Identificacion', 'Tipo_Identificacion', '`Tipo_Identificacion`', '`Tipo_Identificacion`', 202, -1, FALSE, '`Tipo_Identificacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tipo_Identificacion'] = &$this->Tipo_Identificacion;

		// Numero_Identificacion
		$this->Numero_Identificacion = new cField('cap_cliente_papeleta', 'cap_cliente_papeleta', 'x_Numero_Identificacion', 'Numero_Identificacion', '`Numero_Identificacion`', '`Numero_Identificacion`', 200, -1, FALSE, '`Numero_Identificacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Numero_Identificacion'] = &$this->Numero_Identificacion;
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
		return "`cap_cliente_papeleta`";
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
	var $UpdateTable = "`cap_cliente_papeleta`";

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
			$sql .= ew_QuotedName('Id_Cliente') . '=' . ew_QuotedValue($rs['Id_Cliente'], $this->Id_Cliente->FldDataType) . ' AND ';
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
		return "`Id_Cliente` = @Id_Cliente@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Cliente->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Cliente@", ew_AdjustSql($this->Id_Cliente->CurrentValue), $sKeyFilter); // Replace key value
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
			return "cap_cliente_papeletalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_cliente_papeletalist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_cliente_papeletaview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_cliente_papeletaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_cliente_papeletaedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_cliente_papeletaadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_cliente_papeletadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Cliente->CurrentValue)) {
			$sUrl .= "Id_Cliente=" . urlencode($this->Id_Cliente->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Cliente"]; // Id_Cliente

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
			$this->Id_Cliente->CurrentValue = $key;
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
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Nombre_Completo->setDbValue($rs->fields('Nombre_Completo'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Num_Exterior->setDbValue($rs->fields('Num_Exterior'));
		$this->Num_Interior->setDbValue($rs->fields('Num_Interior'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Tel_Particular->setDbValue($rs->fields('Tel_Particular'));
		$this->Tel_Oficina->setDbValue($rs->fields('Tel_Oficina'));
		$this->Tipo_Identificacion->setDbValue($rs->fields('Tipo_Identificacion'));
		$this->Numero_Identificacion->setDbValue($rs->fields('Numero_Identificacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Cliente
		// Nombre_Completo

		$this->Nombre_Completo->CellCssStyle = "white-space: nowrap;";

		// Domicilio
		// Num_Exterior
		// Num_Interior
		// Colonia
		// Poblacion
		// CP
		// Id_Estado
		// Tel_Particular
		// Tel_Oficina
		// Tipo_Identificacion
		// Numero_Identificacion
		// Id_Cliente

		$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
		$this->Id_Cliente->ViewCustomAttributes = "";

		// Nombre_Completo
		$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
		$this->Nombre_Completo->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Num_Exterior
		$this->Num_Exterior->ViewValue = $this->Num_Exterior->CurrentValue;
		$this->Num_Exterior->ViewCustomAttributes = "";

		// Num_Interior
		$this->Num_Interior->ViewValue = $this->Num_Interior->CurrentValue;
		$this->Num_Interior->ViewCustomAttributes = "";

		// Colonia
		$this->Colonia->ViewValue = $this->Colonia->CurrentValue;
		$this->Colonia->ViewCustomAttributes = "";

		// Poblacion
		$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
		$this->Poblacion->ViewCustomAttributes = "";

		// CP
		$this->CP->ViewValue = $this->CP->CurrentValue;
		$this->CP->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Estado`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Estado->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// Tel_Particular
		$this->Tel_Particular->ViewValue = $this->Tel_Particular->CurrentValue;
		$this->Tel_Particular->ViewCustomAttributes = "";

		// Tel_Oficina
		$this->Tel_Oficina->ViewValue = $this->Tel_Oficina->CurrentValue;
		$this->Tel_Oficina->ViewCustomAttributes = "";

		// Tipo_Identificacion
		if (strval($this->Tipo_Identificacion->CurrentValue) <> "") {
			switch ($this->Tipo_Identificacion->CurrentValue) {
				case $this->Tipo_Identificacion->FldTagValue(1):
					$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(1) <> "" ? $this->Tipo_Identificacion->FldTagCaption(1) : $this->Tipo_Identificacion->CurrentValue;
					break;
				case $this->Tipo_Identificacion->FldTagValue(2):
					$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(2) <> "" ? $this->Tipo_Identificacion->FldTagCaption(2) : $this->Tipo_Identificacion->CurrentValue;
					break;
				case $this->Tipo_Identificacion->FldTagValue(3):
					$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(3) <> "" ? $this->Tipo_Identificacion->FldTagCaption(3) : $this->Tipo_Identificacion->CurrentValue;
					break;
				case $this->Tipo_Identificacion->FldTagValue(4):
					$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->FldTagCaption(4) <> "" ? $this->Tipo_Identificacion->FldTagCaption(4) : $this->Tipo_Identificacion->CurrentValue;
					break;
				default:
					$this->Tipo_Identificacion->ViewValue = $this->Tipo_Identificacion->CurrentValue;
			}
		} else {
			$this->Tipo_Identificacion->ViewValue = NULL;
		}
		$this->Tipo_Identificacion->ViewCustomAttributes = "";

		// Numero_Identificacion
		$this->Numero_Identificacion->ViewValue = $this->Numero_Identificacion->CurrentValue;
		$this->Numero_Identificacion->ViewCustomAttributes = "";

		// Id_Cliente
		$this->Id_Cliente->LinkCustomAttributes = "";
		$this->Id_Cliente->HrefValue = "";
		$this->Id_Cliente->TooltipValue = "";

		// Nombre_Completo
		$this->Nombre_Completo->LinkCustomAttributes = "";
		$this->Nombre_Completo->HrefValue = "";
		$this->Nombre_Completo->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Num_Exterior
		$this->Num_Exterior->LinkCustomAttributes = "";
		$this->Num_Exterior->HrefValue = "";
		$this->Num_Exterior->TooltipValue = "";

		// Num_Interior
		$this->Num_Interior->LinkCustomAttributes = "";
		$this->Num_Interior->HrefValue = "";
		$this->Num_Interior->TooltipValue = "";

		// Colonia
		$this->Colonia->LinkCustomAttributes = "";
		$this->Colonia->HrefValue = "";
		$this->Colonia->TooltipValue = "";

		// Poblacion
		$this->Poblacion->LinkCustomAttributes = "";
		$this->Poblacion->HrefValue = "";
		$this->Poblacion->TooltipValue = "";

		// CP
		$this->CP->LinkCustomAttributes = "";
		$this->CP->HrefValue = "";
		$this->CP->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// Tel_Particular
		$this->Tel_Particular->LinkCustomAttributes = "";
		$this->Tel_Particular->HrefValue = "";
		$this->Tel_Particular->TooltipValue = "";

		// Tel_Oficina
		$this->Tel_Oficina->LinkCustomAttributes = "";
		$this->Tel_Oficina->HrefValue = "";
		$this->Tel_Oficina->TooltipValue = "";

		// Tipo_Identificacion
		$this->Tipo_Identificacion->LinkCustomAttributes = "";
		$this->Tipo_Identificacion->HrefValue = "";
		$this->Tipo_Identificacion->TooltipValue = "";

		// Numero_Identificacion
		$this->Numero_Identificacion->LinkCustomAttributes = "";
		$this->Numero_Identificacion->HrefValue = "";
		$this->Numero_Identificacion->TooltipValue = "";

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
				if ($this->Id_Cliente->Exportable) $Doc->ExportCaption($this->Id_Cliente);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Num_Exterior->Exportable) $Doc->ExportCaption($this->Num_Exterior);
				if ($this->Num_Interior->Exportable) $Doc->ExportCaption($this->Num_Interior);
				if ($this->Colonia->Exportable) $Doc->ExportCaption($this->Colonia);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
				if ($this->Tel_Particular->Exportable) $Doc->ExportCaption($this->Tel_Particular);
				if ($this->Tel_Oficina->Exportable) $Doc->ExportCaption($this->Tel_Oficina);
				if ($this->Tipo_Identificacion->Exportable) $Doc->ExportCaption($this->Tipo_Identificacion);
				if ($this->Numero_Identificacion->Exportable) $Doc->ExportCaption($this->Numero_Identificacion);
			} else {
				if ($this->Id_Cliente->Exportable) $Doc->ExportCaption($this->Id_Cliente);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Num_Exterior->Exportable) $Doc->ExportCaption($this->Num_Exterior);
				if ($this->Num_Interior->Exportable) $Doc->ExportCaption($this->Num_Interior);
				if ($this->Colonia->Exportable) $Doc->ExportCaption($this->Colonia);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
				if ($this->Tel_Particular->Exportable) $Doc->ExportCaption($this->Tel_Particular);
				if ($this->Tel_Oficina->Exportable) $Doc->ExportCaption($this->Tel_Oficina);
				if ($this->Tipo_Identificacion->Exportable) $Doc->ExportCaption($this->Tipo_Identificacion);
				if ($this->Numero_Identificacion->Exportable) $Doc->ExportCaption($this->Numero_Identificacion);
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
					if ($this->Id_Cliente->Exportable) $Doc->ExportField($this->Id_Cliente);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Num_Exterior->Exportable) $Doc->ExportField($this->Num_Exterior);
					if ($this->Num_Interior->Exportable) $Doc->ExportField($this->Num_Interior);
					if ($this->Colonia->Exportable) $Doc->ExportField($this->Colonia);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
					if ($this->Tel_Particular->Exportable) $Doc->ExportField($this->Tel_Particular);
					if ($this->Tel_Oficina->Exportable) $Doc->ExportField($this->Tel_Oficina);
					if ($this->Tipo_Identificacion->Exportable) $Doc->ExportField($this->Tipo_Identificacion);
					if ($this->Numero_Identificacion->Exportable) $Doc->ExportField($this->Numero_Identificacion);
				} else {
					if ($this->Id_Cliente->Exportable) $Doc->ExportField($this->Id_Cliente);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Num_Exterior->Exportable) $Doc->ExportField($this->Num_Exterior);
					if ($this->Num_Interior->Exportable) $Doc->ExportField($this->Num_Interior);
					if ($this->Colonia->Exportable) $Doc->ExportField($this->Colonia);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
					if ($this->Tel_Particular->Exportable) $Doc->ExportField($this->Tel_Particular);
					if ($this->Tel_Oficina->Exportable) $Doc->ExportField($this->Tel_Oficina);
					if ($this->Tipo_Identificacion->Exportable) $Doc->ExportField($this->Tipo_Identificacion);
					if ($this->Numero_Identificacion->Exportable) $Doc->ExportField($this->Numero_Identificacion);
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
