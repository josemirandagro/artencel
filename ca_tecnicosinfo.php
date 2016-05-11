<?php

// Global variable for table object
$ca_tecnicos = NULL;

//
// Table class for ca_tecnicos
//
class cca_tecnicos extends cTable {
	var $Id_Tecnico;
	var $Nombre;
	var $RFC;
	var $Domicilio;
	var $Poblacion;
	var $Municipio_Delegacion;
	var $Estado;
	var $CP;
	var $_EMail;
	var $Telefonos;
	var $Celular;
	var $Comentarios;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ca_tecnicos';
		$this->TableName = 'ca_tecnicos';
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

		// Id_Tecnico
		$this->Id_Tecnico = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Id_Tecnico', 'Id_Tecnico', '`Id_Tecnico`', '`Id_Tecnico`', 3, -1, FALSE, '`Id_Tecnico`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tecnico->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tecnico'] = &$this->Id_Tecnico;

		// Nombre
		$this->Nombre = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Nombre', 'Nombre', '`Nombre`', '`Nombre`', 200, -1, FALSE, '`Nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre'] = &$this->Nombre;

		// RFC
		$this->RFC = new cField('ca_tecnicos', 'ca_tecnicos', 'x_RFC', 'RFC', '`RFC`', '`RFC`', 200, -1, FALSE, '`RFC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RFC'] = &$this->RFC;

		// Domicilio
		$this->Domicilio = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Poblacion
		$this->Poblacion = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Poblacion', 'Poblacion', '`Poblacion`', '`Poblacion`', 3, -1, FALSE, '`Poblacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Poblacion'] = &$this->Poblacion;

		// Municipio_Delegacion
		$this->Municipio_Delegacion = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Municipio_Delegacion', 'Municipio_Delegacion', '`Municipio_Delegacion`', '`Municipio_Delegacion`', 3, -1, FALSE, '`Municipio_Delegacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Municipio_Delegacion'] = &$this->Municipio_Delegacion;

		// Estado
		$this->Estado = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Estado', 'Estado', '`Estado`', '`Estado`', 3, -1, FALSE, '`Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Estado'] = &$this->Estado;

		// CP
		$this->CP = new cField('ca_tecnicos', 'ca_tecnicos', 'x_CP', 'CP', '`CP`', '`CP`', 200, -1, FALSE, '`CP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CP'] = &$this->CP;

		// EMail
		$this->_EMail = new cField('ca_tecnicos', 'ca_tecnicos', 'x__EMail', 'EMail', '`EMail`', '`EMail`', 200, -1, FALSE, '`EMail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['EMail'] = &$this->_EMail;

		// Telefonos
		$this->Telefonos = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Telefonos', 'Telefonos', '`Telefonos`', '`Telefonos`', 200, -1, FALSE, '`Telefonos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Telefonos'] = &$this->Telefonos;

		// Celular
		$this->Celular = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Celular', 'Celular', '`Celular`', '`Celular`', 200, -1, FALSE, '`Celular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Celular'] = &$this->Celular;

		// Comentarios
		$this->Comentarios = new cField('ca_tecnicos', 'ca_tecnicos', 'x_Comentarios', 'Comentarios', '`Comentarios`', '`Comentarios`', 201, -1, FALSE, '`Comentarios`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Comentarios'] = &$this->Comentarios;
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
		return "`ca_tecnicos`";
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
	var $UpdateTable = "`ca_tecnicos`";

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
			$sql .= ew_QuotedName('Id_Tecnico') . '=' . ew_QuotedValue($rs['Id_Tecnico'], $this->Id_Tecnico->FldDataType) . ' AND ';
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
		return "`Id_Tecnico` = @Id_Tecnico@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Tecnico->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Tecnico@", ew_AdjustSql($this->Id_Tecnico->CurrentValue), $sKeyFilter); // Replace key value
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
			return "ca_tecnicoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ca_tecnicoslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("ca_tecnicosview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "ca_tecnicosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("ca_tecnicosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("ca_tecnicosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ca_tecnicosdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Tecnico->CurrentValue)) {
			$sUrl .= "Id_Tecnico=" . urlencode($this->Id_Tecnico->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Tecnico"]; // Id_Tecnico

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
			$this->Id_Tecnico->CurrentValue = $key;
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
		$this->Id_Tecnico->setDbValue($rs->fields('Id_Tecnico'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->Municipio_Delegacion->setDbValue($rs->fields('Municipio_Delegacion'));
		$this->Estado->setDbValue($rs->fields('Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Tecnico

		$this->Id_Tecnico->CellCssStyle = "white-space: nowrap;";

		// Nombre
		$this->Nombre->CellCssStyle = "white-space: nowrap;";

		// RFC
		$this->RFC->CellCssStyle = "white-space: nowrap;";

		// Domicilio
		$this->Domicilio->CellCssStyle = "white-space: nowrap;";

		// Poblacion
		$this->Poblacion->CellCssStyle = "white-space: nowrap;";

		// Municipio_Delegacion
		$this->Municipio_Delegacion->CellCssStyle = "white-space: nowrap;";

		// Estado
		$this->Estado->CellCssStyle = "white-space: nowrap;";

		// CP
		$this->CP->CellCssStyle = "white-space: nowrap;";

		// EMail
		$this->_EMail->CellCssStyle = "white-space: nowrap;";

		// Telefonos
		$this->Telefonos->CellCssStyle = "white-space: nowrap;";

		// Celular
		$this->Celular->CellCssStyle = "white-space: nowrap;";

		// Comentarios
		// Id_Tecnico

		$this->Id_Tecnico->ViewValue = $this->Id_Tecnico->CurrentValue;
		$this->Id_Tecnico->ViewCustomAttributes = "";

		// Nombre
		$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
		$this->Nombre->ViewCustomAttributes = "";

		// RFC
		$this->RFC->ViewValue = $this->RFC->CurrentValue;
		$this->RFC->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Poblacion
		$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
		$this->Poblacion->ViewCustomAttributes = "";

		// Municipio_Delegacion
		$this->Municipio_Delegacion->ViewValue = $this->Municipio_Delegacion->CurrentValue;
		$this->Municipio_Delegacion->ViewCustomAttributes = "";

		// Estado
		if (strval($this->Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Estado->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Estado->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Estado->ViewValue = $this->Estado->CurrentValue;
			}
		} else {
			$this->Estado->ViewValue = NULL;
		}
		$this->Estado->ViewCustomAttributes = "";

		// CP
		$this->CP->ViewValue = $this->CP->CurrentValue;
		$this->CP->ViewCustomAttributes = "";

		// EMail
		$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
		$this->_EMail->ViewCustomAttributes = "";

		// Telefonos
		$this->Telefonos->ViewValue = $this->Telefonos->CurrentValue;
		$this->Telefonos->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Comentarios
		$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
		$this->Comentarios->ViewCustomAttributes = "";

		// Id_Tecnico
		$this->Id_Tecnico->LinkCustomAttributes = "";
		$this->Id_Tecnico->HrefValue = "";
		$this->Id_Tecnico->TooltipValue = "";

		// Nombre
		$this->Nombre->LinkCustomAttributes = "";
		$this->Nombre->HrefValue = "";
		$this->Nombre->TooltipValue = "";

		// RFC
		$this->RFC->LinkCustomAttributes = "";
		$this->RFC->HrefValue = "";
		$this->RFC->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Poblacion
		$this->Poblacion->LinkCustomAttributes = "";
		$this->Poblacion->HrefValue = "";
		$this->Poblacion->TooltipValue = "";

		// Municipio_Delegacion
		$this->Municipio_Delegacion->LinkCustomAttributes = "";
		$this->Municipio_Delegacion->HrefValue = "";
		$this->Municipio_Delegacion->TooltipValue = "";

		// Estado
		$this->Estado->LinkCustomAttributes = "";
		$this->Estado->HrefValue = "";
		$this->Estado->TooltipValue = "";

		// CP
		$this->CP->LinkCustomAttributes = "";
		$this->CP->HrefValue = "";
		$this->CP->TooltipValue = "";

		// EMail
		$this->_EMail->LinkCustomAttributes = "";
		$this->_EMail->HrefValue = "";
		$this->_EMail->TooltipValue = "";

		// Telefonos
		$this->Telefonos->LinkCustomAttributes = "";
		$this->Telefonos->HrefValue = "";
		$this->Telefonos->TooltipValue = "";

		// Celular
		$this->Celular->LinkCustomAttributes = "";
		$this->Celular->HrefValue = "";
		$this->Celular->TooltipValue = "";

		// Comentarios
		$this->Comentarios->LinkCustomAttributes = "";
		$this->Comentarios->HrefValue = "";
		$this->Comentarios->TooltipValue = "";

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
				if ($this->Id_Tecnico->Exportable) $Doc->ExportCaption($this->Id_Tecnico);
				if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->Municipio_Delegacion->Exportable) $Doc->ExportCaption($this->Municipio_Delegacion);
				if ($this->Estado->Exportable) $Doc->ExportCaption($this->Estado);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Telefonos->Exportable) $Doc->ExportCaption($this->Telefonos);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Comentarios->Exportable) $Doc->ExportCaption($this->Comentarios);
			} else {
				if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->Municipio_Delegacion->Exportable) $Doc->ExportCaption($this->Municipio_Delegacion);
				if ($this->Estado->Exportable) $Doc->ExportCaption($this->Estado);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Telefonos->Exportable) $Doc->ExportCaption($this->Telefonos);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
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
					if ($this->Id_Tecnico->Exportable) $Doc->ExportField($this->Id_Tecnico);
					if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->Municipio_Delegacion->Exportable) $Doc->ExportField($this->Municipio_Delegacion);
					if ($this->Estado->Exportable) $Doc->ExportField($this->Estado);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Telefonos->Exportable) $Doc->ExportField($this->Telefonos);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Comentarios->Exportable) $Doc->ExportField($this->Comentarios);
				} else {
					if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->Municipio_Delegacion->Exportable) $Doc->ExportField($this->Municipio_Delegacion);
					if ($this->Estado->Exportable) $Doc->ExportField($this->Estado);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Telefonos->Exportable) $Doc->ExportField($this->Telefonos);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
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
