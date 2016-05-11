<?php

// Global variable for table object
$cap_control_papeleta_enviar = NULL;

//
// Table class for cap_control_papeleta_enviar
//
class ccap_control_papeleta_enviar extends cTable {
	var $Id_Venta_Eq;
	var $Num_IMEI;
	var $StatusPapeleta;
	var $Num_CEL;
	var $FolioImpresoPapeleta;
	var $FechaAviso;
	var $Tipo_Papeleta;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_control_papeleta_enviar';
		$this->TableName = 'cap_control_papeleta_enviar';
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
		$this->Id_Venta_Eq = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_Id_Venta_Eq', 'Id_Venta_Eq', '`Id_Venta_Eq`', '`Id_Venta_Eq`', 3, -1, FALSE, '`Id_Venta_Eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Venta_Eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Venta_Eq'] = &$this->Id_Venta_Eq;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// StatusPapeleta
		$this->StatusPapeleta = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_StatusPapeleta', 'StatusPapeleta', '`StatusPapeleta`', '`StatusPapeleta`', 202, -1, FALSE, '`StatusPapeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['StatusPapeleta'] = &$this->StatusPapeleta;

		// Num_CEL
		$this->Num_CEL = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_Num_CEL', 'Num_CEL', '`Num_CEL`', '`Num_CEL`', 200, -1, FALSE, '`Num_CEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_CEL'] = &$this->Num_CEL;

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_FolioImpresoPapeleta', 'FolioImpresoPapeleta', '`FolioImpresoPapeleta`', '`FolioImpresoPapeleta`', 200, -1, FALSE, '`FolioImpresoPapeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FolioImpresoPapeleta'] = &$this->FolioImpresoPapeleta;

		// FechaAviso
		$this->FechaAviso = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_FechaAviso', 'FechaAviso', '`FechaAviso`', 'DATE_FORMAT(`FechaAviso`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaAviso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaAviso->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaAviso'] = &$this->FechaAviso;

		// Tipo Papeleta
		$this->Tipo_Papeleta = new cField('cap_control_papeleta_enviar', 'cap_control_papeleta_enviar', 'x_Tipo_Papeleta', 'Tipo Papeleta', '`Tipo Papeleta`', '`Tipo Papeleta`', 202, -1, FALSE, '`Tipo Papeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tipo Papeleta'] = &$this->Tipo_Papeleta;
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
		return "`cap_control_papeleta_enviar`";
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
		return "`Tipo Papeleta` ASC,`Num_IMEI` ASC";
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
	var $UpdateTable = "`cap_control_papeleta_enviar`";

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
			return "cap_control_papeleta_enviarlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_control_papeleta_enviarlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_control_papeleta_enviarview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_control_papeleta_enviaradd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_control_papeleta_enviaredit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_control_papeleta_enviaradd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_control_papeleta_enviardelete.php", $this->UrlParm());
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
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->StatusPapeleta->setDbValue($rs->fields('StatusPapeleta'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
		$this->FechaAviso->setDbValue($rs->fields('FechaAviso'));
		$this->Tipo_Papeleta->setDbValue($rs->fields('Tipo Papeleta'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Venta_Eq
		// Num_IMEI
		// StatusPapeleta
		// Num_CEL
		// FolioImpresoPapeleta
		// FechaAviso
		// Tipo Papeleta
		// Id_Venta_Eq

		$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
		$this->Id_Venta_Eq->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// StatusPapeleta
		if (strval($this->StatusPapeleta->CurrentValue) <> "") {
			switch ($this->StatusPapeleta->CurrentValue) {
				case $this->StatusPapeleta->FldTagValue(1):
					$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->CurrentValue;
					break;
				case $this->StatusPapeleta->FldTagValue(2):
					$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->CurrentValue;
					break;
				case $this->StatusPapeleta->FldTagValue(3):
					$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->CurrentValue;
					break;
				case $this->StatusPapeleta->FldTagValue(4):
					$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->CurrentValue;
					break;
				default:
					$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->CurrentValue;
			}
		} else {
			$this->StatusPapeleta->ViewValue = NULL;
		}
		$this->StatusPapeleta->ViewCustomAttributes = "";

		// Num_CEL
		$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
		$this->Num_CEL->ViewCustomAttributes = "";

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
		$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

		// FechaAviso
		$this->FechaAviso->ViewValue = $this->FechaAviso->CurrentValue;
		$this->FechaAviso->ViewValue = ew_FormatDateTime($this->FechaAviso->ViewValue, 7);
		$this->FechaAviso->ViewCustomAttributes = "";

		// Tipo Papeleta
		if (strval($this->Tipo_Papeleta->CurrentValue) <> "") {
			switch ($this->Tipo_Papeleta->CurrentValue) {
				case $this->Tipo_Papeleta->FldTagValue(1):
					$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->CurrentValue;
					break;
				case $this->Tipo_Papeleta->FldTagValue(2):
					$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->CurrentValue;
					break;
				case $this->Tipo_Papeleta->FldTagValue(3):
					$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->CurrentValue;
					break;
				default:
					$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->CurrentValue;
			}
		} else {
			$this->Tipo_Papeleta->ViewValue = NULL;
		}
		$this->Tipo_Papeleta->ViewCustomAttributes = "";

		// Id_Venta_Eq
		$this->Id_Venta_Eq->LinkCustomAttributes = "";
		$this->Id_Venta_Eq->HrefValue = "";
		$this->Id_Venta_Eq->TooltipValue = "";

		// Num_IMEI
		$this->Num_IMEI->LinkCustomAttributes = "";
		$this->Num_IMEI->HrefValue = "";
		$this->Num_IMEI->TooltipValue = "";

		// StatusPapeleta
		$this->StatusPapeleta->LinkCustomAttributes = "";
		$this->StatusPapeleta->HrefValue = "";
		$this->StatusPapeleta->TooltipValue = "";

		// Num_CEL
		$this->Num_CEL->LinkCustomAttributes = "";
		$this->Num_CEL->HrefValue = "";
		$this->Num_CEL->TooltipValue = "";

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->LinkCustomAttributes = "";
		$this->FolioImpresoPapeleta->HrefValue = "";
		$this->FolioImpresoPapeleta->TooltipValue = "";

		// FechaAviso
		$this->FechaAviso->LinkCustomAttributes = "";
		$this->FechaAviso->HrefValue = "";
		$this->FechaAviso->TooltipValue = "";

		// Tipo Papeleta
		$this->Tipo_Papeleta->LinkCustomAttributes = "";
		$this->Tipo_Papeleta->HrefValue = "";
		$this->Tipo_Papeleta->TooltipValue = "";

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
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->StatusPapeleta->Exportable) $Doc->ExportCaption($this->StatusPapeleta);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportCaption($this->FolioImpresoPapeleta);
				if ($this->Tipo_Papeleta->Exportable) $Doc->ExportCaption($this->Tipo_Papeleta);
			} else {
				if ($this->Id_Venta_Eq->Exportable) $Doc->ExportCaption($this->Id_Venta_Eq);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->StatusPapeleta->Exportable) $Doc->ExportCaption($this->StatusPapeleta);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportCaption($this->FolioImpresoPapeleta);
				if ($this->FechaAviso->Exportable) $Doc->ExportCaption($this->FechaAviso);
				if ($this->Tipo_Papeleta->Exportable) $Doc->ExportCaption($this->Tipo_Papeleta);
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
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->StatusPapeleta->Exportable) $Doc->ExportField($this->StatusPapeleta);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportField($this->FolioImpresoPapeleta);
					if ($this->Tipo_Papeleta->Exportable) $Doc->ExportField($this->Tipo_Papeleta);
				} else {
					if ($this->Id_Venta_Eq->Exportable) $Doc->ExportField($this->Id_Venta_Eq);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->StatusPapeleta->Exportable) $Doc->ExportField($this->StatusPapeleta);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportField($this->FolioImpresoPapeleta);
					if ($this->FechaAviso->Exportable) $Doc->ExportField($this->FechaAviso);
					if ($this->Tipo_Papeleta->Exportable) $Doc->ExportField($this->Tipo_Papeleta);
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

	  // Cuando modificamos en grid edit, modifica la fecha de envio todos los registros mostrados, hayan o no sido modificados
	  // de modo que aqui quitamos la fecha de envio de los que no fueron enviados

	  Db_Ejecuta("UPDATE doc_venta_eq set FechaAviso=NULL WHERE StatusPapeleta='Por Enviar'");
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
