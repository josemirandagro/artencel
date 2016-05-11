<?php

// Global variable for table object
$barcode_accesorio = NULL;

//
// Table class for barcode_accesorio
//
class cbarcode_accesorio extends cTable {
	var $Id_Etiqueta;
	var $Id_Compra;
	var $Id_Compra_Det;
	var $Articulo;
	var $Codigo;
	var $Status;
	var $Articulo_L1;
	var $Articulo_L2;
	var $Articulo_L3;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'barcode_accesorio';
		$this->TableName = 'barcode_accesorio';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Id_Etiqueta
		$this->Id_Etiqueta = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Id_Etiqueta', 'Id_Etiqueta', '`Id_Etiqueta`', '`Id_Etiqueta`', 3, -1, FALSE, '`Id_Etiqueta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Etiqueta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Etiqueta'] = &$this->Id_Etiqueta;

		// Id_Compra
		$this->Id_Compra = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Id_Compra', 'Id_Compra', '`Id_Compra`', '`Id_Compra`', 3, -1, FALSE, '`Id_Compra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Compra->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Compra'] = &$this->Id_Compra;

		// Id_Compra_Det
		$this->Id_Compra_Det = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Id_Compra_Det', 'Id_Compra_Det', '`Id_Compra_Det`', '`Id_Compra_Det`', 3, -1, FALSE, '`Id_Compra_Det`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Compra_Det->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Compra_Det'] = &$this->Id_Compra_Det;

		// Articulo
		$this->Articulo = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Articulo', 'Articulo', '`Articulo`', '`Articulo`', 200, -1, FALSE, '`Articulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo'] = &$this->Articulo;

		// Codigo
		$this->Codigo = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Codigo', 'Codigo', '`Codigo`', '`Codigo`', 200, -1, FALSE, '`Codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Codigo'] = &$this->Codigo;

		// Status
		$this->Status = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// Articulo_L1
		$this->Articulo_L1 = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Articulo_L1', 'Articulo_L1', '`Articulo_L1`', '`Articulo_L1`', 200, -1, FALSE, '`Articulo_L1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo_L1'] = &$this->Articulo_L1;

		// Articulo_L2
		$this->Articulo_L2 = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Articulo_L2', 'Articulo_L2', '`Articulo_L2`', '`Articulo_L2`', 200, -1, FALSE, '`Articulo_L2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo_L2'] = &$this->Articulo_L2;

		// Articulo_L3
		$this->Articulo_L3 = new cField('barcode_accesorio', 'barcode_accesorio', 'x_Articulo_L3', 'Articulo_L3', '`Articulo_L3`', '`Articulo_L3`', 200, -1, FALSE, '`Articulo_L3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Articulo_L3'] = &$this->Articulo_L3;
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
		return "`barcode_accesorio`";
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
	var $UpdateTable = "`barcode_accesorio`";

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
			$sql .= ew_QuotedName('Id_Etiqueta') . '=' . ew_QuotedValue($rs['Id_Etiqueta'], $this->Id_Etiqueta->FldDataType) . ' AND ';
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
		return "`Id_Etiqueta` = @Id_Etiqueta@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Etiqueta->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Etiqueta@", ew_AdjustSql($this->Id_Etiqueta->CurrentValue), $sKeyFilter); // Replace key value
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
			return "barcode_accesoriolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "barcode_accesoriolist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("barcode_accesorioview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "barcode_accesorioadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("barcode_accesorioedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("barcode_accesorioadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("barcode_accesoriodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Etiqueta->CurrentValue)) {
			$sUrl .= "Id_Etiqueta=" . urlencode($this->Id_Etiqueta->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Etiqueta"]; // Id_Etiqueta

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
			$this->Id_Etiqueta->CurrentValue = $key;
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
		$this->Id_Etiqueta->setDbValue($rs->fields('Id_Etiqueta'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Articulo_L1->setDbValue($rs->fields('Articulo_L1'));
		$this->Articulo_L2->setDbValue($rs->fields('Articulo_L2'));
		$this->Articulo_L3->setDbValue($rs->fields('Articulo_L3'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Etiqueta
		// Id_Compra
		// Id_Compra_Det

		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Articulo
		// Codigo
		// Status
		// Articulo_L1
		// Articulo_L2
		// Articulo_L3
		// Id_Etiqueta

		$this->Id_Etiqueta->ViewValue = $this->Id_Etiqueta->CurrentValue;
		$this->Id_Etiqueta->ViewCustomAttributes = "";

		// Id_Compra
		$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
		$this->Id_Compra->ViewCustomAttributes = "";

		// Id_Compra_Det
		if (strval($this->Id_Compra_Det->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Etiqueta`" . ew_SearchString("=", $this->Id_Compra_Det->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT DISTINCT `Id_Etiqueta`, `Id_Etiqueta` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `barcode_accesorio`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Compra_Det->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Compra_Det->ViewValue = $this->Id_Compra_Det->CurrentValue;
			}
		} else {
			$this->Id_Compra_Det->ViewValue = NULL;
		}
		$this->Id_Compra_Det->ViewCustomAttributes = "";

		// Articulo
		$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
		if (strval($this->Articulo->CurrentValue) <> "") {
			$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Articulo` ASC";
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
				default:
					$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// Articulo_L1
		$this->Articulo_L1->ViewValue = $this->Articulo_L1->CurrentValue;
		$this->Articulo_L1->ViewCustomAttributes = "";

		// Articulo_L2
		$this->Articulo_L2->ViewValue = $this->Articulo_L2->CurrentValue;
		$this->Articulo_L2->ViewCustomAttributes = "";

		// Articulo_L3
		$this->Articulo_L3->ViewValue = $this->Articulo_L3->CurrentValue;
		$this->Articulo_L3->ViewCustomAttributes = "";

		// Id_Etiqueta
		$this->Id_Etiqueta->LinkCustomAttributes = "";
		$this->Id_Etiqueta->HrefValue = "";
		$this->Id_Etiqueta->TooltipValue = "";

		// Id_Compra
		$this->Id_Compra->LinkCustomAttributes = "";
		$this->Id_Compra->HrefValue = "";
		$this->Id_Compra->TooltipValue = "";

		// Id_Compra_Det
		$this->Id_Compra_Det->LinkCustomAttributes = "";
		$this->Id_Compra_Det->HrefValue = "";
		$this->Id_Compra_Det->TooltipValue = "";

		// Articulo
		$this->Articulo->LinkCustomAttributes = "";
		$this->Articulo->HrefValue = "";
		$this->Articulo->TooltipValue = "";

		// Codigo
		$this->Codigo->LinkCustomAttributes = "";
		$this->Codigo->HrefValue = "";
		$this->Codigo->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// Articulo_L1
		$this->Articulo_L1->LinkCustomAttributes = "";
		$this->Articulo_L1->HrefValue = "";
		$this->Articulo_L1->TooltipValue = "";

		// Articulo_L2
		$this->Articulo_L2->LinkCustomAttributes = "";
		$this->Articulo_L2->HrefValue = "";
		$this->Articulo_L2->TooltipValue = "";

		// Articulo_L3
		$this->Articulo_L3->LinkCustomAttributes = "";
		$this->Articulo_L3->HrefValue = "";
		$this->Articulo_L3->TooltipValue = "";

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
				if ($this->Id_Etiqueta->Exportable) $Doc->ExportCaption($this->Id_Etiqueta);
				if ($this->Id_Compra->Exportable) $Doc->ExportCaption($this->Id_Compra);
				if ($this->Id_Compra_Det->Exportable) $Doc->ExportCaption($this->Id_Compra_Det);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Articulo_L1->Exportable) $Doc->ExportCaption($this->Articulo_L1);
				if ($this->Articulo_L2->Exportable) $Doc->ExportCaption($this->Articulo_L2);
				if ($this->Articulo_L3->Exportable) $Doc->ExportCaption($this->Articulo_L3);
			} else {
				if ($this->Id_Etiqueta->Exportable) $Doc->ExportCaption($this->Id_Etiqueta);
				if ($this->Id_Compra->Exportable) $Doc->ExportCaption($this->Id_Compra);
				if ($this->Id_Compra_Det->Exportable) $Doc->ExportCaption($this->Id_Compra_Det);
				if ($this->Articulo->Exportable) $Doc->ExportCaption($this->Articulo);
				if ($this->Codigo->Exportable) $Doc->ExportCaption($this->Codigo);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
				if ($this->Articulo_L1->Exportable) $Doc->ExportCaption($this->Articulo_L1);
				if ($this->Articulo_L2->Exportable) $Doc->ExportCaption($this->Articulo_L2);
				if ($this->Articulo_L3->Exportable) $Doc->ExportCaption($this->Articulo_L3);
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
					if ($this->Id_Etiqueta->Exportable) $Doc->ExportField($this->Id_Etiqueta);
					if ($this->Id_Compra->Exportable) $Doc->ExportField($this->Id_Compra);
					if ($this->Id_Compra_Det->Exportable) $Doc->ExportField($this->Id_Compra_Det);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Articulo_L1->Exportable) $Doc->ExportField($this->Articulo_L1);
					if ($this->Articulo_L2->Exportable) $Doc->ExportField($this->Articulo_L2);
					if ($this->Articulo_L3->Exportable) $Doc->ExportField($this->Articulo_L3);
				} else {
					if ($this->Id_Etiqueta->Exportable) $Doc->ExportField($this->Id_Etiqueta);
					if ($this->Id_Compra->Exportable) $Doc->ExportField($this->Id_Compra);
					if ($this->Id_Compra_Det->Exportable) $Doc->ExportField($this->Id_Compra_Det);
					if ($this->Articulo->Exportable) $Doc->ExportField($this->Articulo);
					if ($this->Codigo->Exportable) $Doc->ExportField($this->Codigo);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
					if ($this->Articulo_L1->Exportable) $Doc->ExportField($this->Articulo_L1);
					if ($this->Articulo_L2->Exportable) $Doc->ExportField($this->Articulo_L2);
					if ($this->Articulo_L3->Exportable) $Doc->ExportField($this->Articulo_L3);
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

	//  echo "Id_Etiqueta =". $rsnew['Id_Etiqueta'] . " DesdeId= ". $rsnew['DesdeId'];   
	  // Borramos el ultimo registro que es el que acaba de Inertar (Pues copio el registro elegido)

	  DB_Ejecuta("DELETE FROM barcode_accesorio WHERE Id_Etiqueta=" . $rsnew['Id_Etiqueta']);

	  // Borramos todos los registros anteriores a Desde_Id                                         
	  DB_Ejecuta("DELETE FROM barcode_accesorio WHERE Id_Etiqueta<" . $rsnew['Id_Compra_Det']);      
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
