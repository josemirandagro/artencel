<?php

// Global variable for table object
$ca_almacenes = NULL;

//
// Table class for ca_almacenes
//
class cca_almacenes extends cTable {
	var $Id_Almacen;
	var $Almacen;
	var $Nombre_Corto;
	var $Id_Responsable;
	var $Telefonos;
	var $Domicilio;
	var $Maximo_Equipos;
	var $Domicilio_Fiscal;
	var $Categoria;
	var $Serie_NotaVenta;
	var $Consecutivo_NotaVenta;
	var $Serie_Factura;
	var $Consecutivo_Factura;
	var $Status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ca_almacenes';
		$this->TableName = 'ca_almacenes';
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

		// Id_Almacen
		$this->Id_Almacen = new cField('ca_almacenes', 'ca_almacenes', 'x_Id_Almacen', 'Id_Almacen', '`Id_Almacen`', '`Id_Almacen`', 19, -1, FALSE, '`Id_Almacen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Almacen->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Almacen'] = &$this->Id_Almacen;

		// Almacen
		$this->Almacen = new cField('ca_almacenes', 'ca_almacenes', 'x_Almacen', 'Almacen', '`Almacen`', '`Almacen`', 200, -1, FALSE, '`Almacen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Almacen'] = &$this->Almacen;

		// Nombre_Corto
		$this->Nombre_Corto = new cField('ca_almacenes', 'ca_almacenes', 'x_Nombre_Corto', 'Nombre_Corto', '`Nombre_Corto`', '`Nombre_Corto`', 200, -1, FALSE, '`Nombre_Corto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre_Corto'] = &$this->Nombre_Corto;

		// Id_Responsable
		$this->Id_Responsable = new cField('ca_almacenes', 'ca_almacenes', 'x_Id_Responsable', 'Id_Responsable', '`Id_Responsable`', '`Id_Responsable`', 3, -1, FALSE, '`Id_Responsable`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Responsable->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Responsable'] = &$this->Id_Responsable;

		// Telefonos
		$this->Telefonos = new cField('ca_almacenes', 'ca_almacenes', 'x_Telefonos', 'Telefonos', '`Telefonos`', '`Telefonos`', 201, -1, FALSE, '`Telefonos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Telefonos'] = &$this->Telefonos;

		// Domicilio
		$this->Domicilio = new cField('ca_almacenes', 'ca_almacenes', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Maximo_Equipos
		$this->Maximo_Equipos = new cField('ca_almacenes', 'ca_almacenes', 'x_Maximo_Equipos', 'Maximo_Equipos', '`Maximo_Equipos`', '`Maximo_Equipos`', 3, -1, FALSE, '`Maximo_Equipos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Maximo_Equipos->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Maximo_Equipos'] = &$this->Maximo_Equipos;

		// Domicilio_Fiscal
		$this->Domicilio_Fiscal = new cField('ca_almacenes', 'ca_almacenes', 'x_Domicilio_Fiscal', 'Domicilio_Fiscal', '`Domicilio_Fiscal`', '`Domicilio_Fiscal`', 200, -1, FALSE, '`Domicilio_Fiscal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio_Fiscal'] = &$this->Domicilio_Fiscal;

		// Categoria
		$this->Categoria = new cField('ca_almacenes', 'ca_almacenes', 'x_Categoria', 'Categoria', '`Categoria`', '`Categoria`', 202, -1, FALSE, '`Categoria`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Categoria'] = &$this->Categoria;

		// Serie_NotaVenta
		$this->Serie_NotaVenta = new cField('ca_almacenes', 'ca_almacenes', 'x_Serie_NotaVenta', 'Serie_NotaVenta', '`Serie_NotaVenta`', '`Serie_NotaVenta`', 200, -1, FALSE, '`Serie_NotaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Serie_NotaVenta'] = &$this->Serie_NotaVenta;

		// Consecutivo_NotaVenta
		$this->Consecutivo_NotaVenta = new cField('ca_almacenes', 'ca_almacenes', 'x_Consecutivo_NotaVenta', 'Consecutivo_NotaVenta', '`Consecutivo_NotaVenta`', '`Consecutivo_NotaVenta`', 3, -1, FALSE, '`Consecutivo_NotaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Consecutivo_NotaVenta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Consecutivo_NotaVenta'] = &$this->Consecutivo_NotaVenta;

		// Serie_Factura
		$this->Serie_Factura = new cField('ca_almacenes', 'ca_almacenes', 'x_Serie_Factura', 'Serie_Factura', '`Serie_Factura`', '`Serie_Factura`', 200, -1, FALSE, '`Serie_Factura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Serie_Factura'] = &$this->Serie_Factura;

		// Consecutivo_Factura
		$this->Consecutivo_Factura = new cField('ca_almacenes', 'ca_almacenes', 'x_Consecutivo_Factura', 'Consecutivo_Factura', '`Consecutivo_Factura`', '`Consecutivo_Factura`', 3, -1, FALSE, '`Consecutivo_Factura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Consecutivo_Factura->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Consecutivo_Factura'] = &$this->Consecutivo_Factura;

		// Status
		$this->Status = new cField('ca_almacenes', 'ca_almacenes', 'x_Status', 'Status', '`Status`', '`Status`', 202, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;
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
		return "`ca_almacenes`";
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
		return "`Almacen` ASC";
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
	var $UpdateTable = "`ca_almacenes`";

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
			$sql .= ew_QuotedName('Id_Almacen') . '=' . ew_QuotedValue($rs['Id_Almacen'], $this->Id_Almacen->FldDataType) . ' AND ';
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
		return "`Id_Almacen` = @Id_Almacen@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Almacen->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Almacen@", ew_AdjustSql($this->Id_Almacen->CurrentValue), $sKeyFilter); // Replace key value
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
			return "ca_almaceneslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ca_almaceneslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("ca_almacenesview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "ca_almacenesadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("ca_almacenesedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("ca_almacenesadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ca_almacenesdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Almacen->CurrentValue)) {
			$sUrl .= "Id_Almacen=" . urlencode($this->Id_Almacen->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Almacen"]; // Id_Almacen

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
			$this->Id_Almacen->CurrentValue = $key;
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
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Almacen->setDbValue($rs->fields('Almacen'));
		$this->Nombre_Corto->setDbValue($rs->fields('Nombre_Corto'));
		$this->Id_Responsable->setDbValue($rs->fields('Id_Responsable'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Maximo_Equipos->setDbValue($rs->fields('Maximo_Equipos'));
		$this->Domicilio_Fiscal->setDbValue($rs->fields('Domicilio_Fiscal'));
		$this->Categoria->setDbValue($rs->fields('Categoria'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Consecutivo_NotaVenta->setDbValue($rs->fields('Consecutivo_NotaVenta'));
		$this->Serie_Factura->setDbValue($rs->fields('Serie_Factura'));
		$this->Consecutivo_Factura->setDbValue($rs->fields('Consecutivo_Factura'));
		$this->Status->setDbValue($rs->fields('Status'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Almacen

		$this->Id_Almacen->CellCssStyle = "white-space: nowrap;";

		// Almacen
		// Nombre_Corto
		// Id_Responsable
		// Telefonos
		// Domicilio
		// Maximo_Equipos

		$this->Maximo_Equipos->CellCssStyle = "white-space: nowrap;";

		// Domicilio_Fiscal
		// Categoria
		// Serie_NotaVenta
		// Consecutivo_NotaVenta
		// Serie_Factura
		// Consecutivo_Factura
		// Status
		// Id_Almacen

		$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
		$this->Id_Almacen->ViewCustomAttributes = "";

		// Almacen
		$this->Almacen->ViewValue = $this->Almacen->CurrentValue;
		$this->Almacen->ViewCustomAttributes = "";

		// Nombre_Corto
		$this->Nombre_Corto->ViewValue = $this->Nombre_Corto->CurrentValue;
		$this->Nombre_Corto->ViewCustomAttributes = "";

		// Id_Responsable
		if (strval($this->Id_Responsable->CurrentValue) <> "") {
			$sFilterWrk = "`IdEmpleado`" . ew_SearchString("=", $this->Id_Responsable->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `IdEmpleado`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_empleados`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Responsable->ViewValue = strtoupper($rswrk->fields('DispFld'));
				$rswrk->Close();
			} else {
				$this->Id_Responsable->ViewValue = $this->Id_Responsable->CurrentValue;
			}
		} else {
			$this->Id_Responsable->ViewValue = NULL;
		}
		$this->Id_Responsable->ViewCustomAttributes = "";

		// Telefonos
		$this->Telefonos->ViewValue = $this->Telefonos->CurrentValue;
		$this->Telefonos->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewValue = strtoupper($this->Domicilio->ViewValue);
		$this->Domicilio->ViewCustomAttributes = "";

		// Maximo_Equipos
		$this->Maximo_Equipos->ViewValue = $this->Maximo_Equipos->CurrentValue;
		$this->Maximo_Equipos->ViewCustomAttributes = "";

		// Domicilio_Fiscal
		$this->Domicilio_Fiscal->ViewValue = $this->Domicilio_Fiscal->CurrentValue;
		$this->Domicilio_Fiscal->ViewCustomAttributes = "";

		// Categoria
		if (strval($this->Categoria->CurrentValue) <> "") {
			switch ($this->Categoria->CurrentValue) {
				case $this->Categoria->FldTagValue(1):
					$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(1) <> "" ? $this->Categoria->FldTagCaption(1) : $this->Categoria->CurrentValue;
					break;
				case $this->Categoria->FldTagValue(2):
					$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(2) <> "" ? $this->Categoria->FldTagCaption(2) : $this->Categoria->CurrentValue;
					break;
				case $this->Categoria->FldTagValue(3):
					$this->Categoria->ViewValue = $this->Categoria->FldTagCaption(3) <> "" ? $this->Categoria->FldTagCaption(3) : $this->Categoria->CurrentValue;
					break;
				default:
					$this->Categoria->ViewValue = $this->Categoria->CurrentValue;
			}
		} else {
			$this->Categoria->ViewValue = NULL;
		}
		$this->Categoria->ViewCustomAttributes = "";

		// Serie_NotaVenta
		$this->Serie_NotaVenta->ViewValue = $this->Serie_NotaVenta->CurrentValue;
		$this->Serie_NotaVenta->ViewCustomAttributes = "";

		// Consecutivo_NotaVenta
		$this->Consecutivo_NotaVenta->ViewValue = $this->Consecutivo_NotaVenta->CurrentValue;
		$this->Consecutivo_NotaVenta->ViewCustomAttributes = "";

		// Serie_Factura
		$this->Serie_Factura->ViewValue = $this->Serie_Factura->CurrentValue;
		$this->Serie_Factura->ViewCustomAttributes = "";

		// Consecutivo_Factura
		$this->Consecutivo_Factura->ViewValue = $this->Consecutivo_Factura->CurrentValue;
		$this->Consecutivo_Factura->ViewCustomAttributes = "";

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

		// Id_Almacen
		$this->Id_Almacen->LinkCustomAttributes = "";
		$this->Id_Almacen->HrefValue = "";
		$this->Id_Almacen->TooltipValue = "";

		// Almacen
		$this->Almacen->LinkCustomAttributes = "";
		$this->Almacen->HrefValue = "";
		$this->Almacen->TooltipValue = "";

		// Nombre_Corto
		$this->Nombre_Corto->LinkCustomAttributes = "";
		$this->Nombre_Corto->HrefValue = "";
		$this->Nombre_Corto->TooltipValue = "";

		// Id_Responsable
		$this->Id_Responsable->LinkCustomAttributes = "";
		$this->Id_Responsable->HrefValue = "";
		$this->Id_Responsable->TooltipValue = "";

		// Telefonos
		$this->Telefonos->LinkCustomAttributes = "";
		$this->Telefonos->HrefValue = "";
		$this->Telefonos->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Maximo_Equipos
		$this->Maximo_Equipos->LinkCustomAttributes = "";
		$this->Maximo_Equipos->HrefValue = "";
		$this->Maximo_Equipos->TooltipValue = "";

		// Domicilio_Fiscal
		$this->Domicilio_Fiscal->LinkCustomAttributes = "";
		$this->Domicilio_Fiscal->HrefValue = "";
		$this->Domicilio_Fiscal->TooltipValue = "";

		// Categoria
		$this->Categoria->LinkCustomAttributes = "";
		$this->Categoria->HrefValue = "";
		$this->Categoria->TooltipValue = "";

		// Serie_NotaVenta
		$this->Serie_NotaVenta->LinkCustomAttributes = "";
		$this->Serie_NotaVenta->HrefValue = "";
		$this->Serie_NotaVenta->TooltipValue = "";

		// Consecutivo_NotaVenta
		$this->Consecutivo_NotaVenta->LinkCustomAttributes = "";
		$this->Consecutivo_NotaVenta->HrefValue = "";
		$this->Consecutivo_NotaVenta->TooltipValue = "";

		// Serie_Factura
		$this->Serie_Factura->LinkCustomAttributes = "";
		$this->Serie_Factura->HrefValue = "";
		$this->Serie_Factura->TooltipValue = "";

		// Consecutivo_Factura
		$this->Consecutivo_Factura->LinkCustomAttributes = "";
		$this->Consecutivo_Factura->HrefValue = "";
		$this->Consecutivo_Factura->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

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
				if ($this->Almacen->Exportable) $Doc->ExportCaption($this->Almacen);
				if ($this->Nombre_Corto->Exportable) $Doc->ExportCaption($this->Nombre_Corto);
				if ($this->Id_Responsable->Exportable) $Doc->ExportCaption($this->Id_Responsable);
				if ($this->Telefonos->Exportable) $Doc->ExportCaption($this->Telefonos);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Domicilio_Fiscal->Exportable) $Doc->ExportCaption($this->Domicilio_Fiscal);
				if ($this->Categoria->Exportable) $Doc->ExportCaption($this->Categoria);
				if ($this->Serie_NotaVenta->Exportable) $Doc->ExportCaption($this->Serie_NotaVenta);
				if ($this->Serie_Factura->Exportable) $Doc->ExportCaption($this->Serie_Factura);
				if ($this->Consecutivo_Factura->Exportable) $Doc->ExportCaption($this->Consecutivo_Factura);
			} else {
				if ($this->Almacen->Exportable) $Doc->ExportCaption($this->Almacen);
				if ($this->Nombre_Corto->Exportable) $Doc->ExportCaption($this->Nombre_Corto);
				if ($this->Id_Responsable->Exportable) $Doc->ExportCaption($this->Id_Responsable);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Domicilio_Fiscal->Exportable) $Doc->ExportCaption($this->Domicilio_Fiscal);
				if ($this->Categoria->Exportable) $Doc->ExportCaption($this->Categoria);
				if ($this->Serie_NotaVenta->Exportable) $Doc->ExportCaption($this->Serie_NotaVenta);
				if ($this->Consecutivo_NotaVenta->Exportable) $Doc->ExportCaption($this->Consecutivo_NotaVenta);
				if ($this->Serie_Factura->Exportable) $Doc->ExportCaption($this->Serie_Factura);
				if ($this->Consecutivo_Factura->Exportable) $Doc->ExportCaption($this->Consecutivo_Factura);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
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
					if ($this->Almacen->Exportable) $Doc->ExportField($this->Almacen);
					if ($this->Nombre_Corto->Exportable) $Doc->ExportField($this->Nombre_Corto);
					if ($this->Id_Responsable->Exportable) $Doc->ExportField($this->Id_Responsable);
					if ($this->Telefonos->Exportable) $Doc->ExportField($this->Telefonos);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Domicilio_Fiscal->Exportable) $Doc->ExportField($this->Domicilio_Fiscal);
					if ($this->Categoria->Exportable) $Doc->ExportField($this->Categoria);
					if ($this->Serie_NotaVenta->Exportable) $Doc->ExportField($this->Serie_NotaVenta);
					if ($this->Serie_Factura->Exportable) $Doc->ExportField($this->Serie_Factura);
					if ($this->Consecutivo_Factura->Exportable) $Doc->ExportField($this->Consecutivo_Factura);
				} else {
					if ($this->Almacen->Exportable) $Doc->ExportField($this->Almacen);
					if ($this->Nombre_Corto->Exportable) $Doc->ExportField($this->Nombre_Corto);
					if ($this->Id_Responsable->Exportable) $Doc->ExportField($this->Id_Responsable);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Domicilio_Fiscal->Exportable) $Doc->ExportField($this->Domicilio_Fiscal);
					if ($this->Categoria->Exportable) $Doc->ExportField($this->Categoria);
					if ($this->Serie_NotaVenta->Exportable) $Doc->ExportField($this->Serie_NotaVenta);
					if ($this->Consecutivo_NotaVenta->Exportable) $Doc->ExportField($this->Consecutivo_NotaVenta);
					if ($this->Serie_Factura->Exportable) $Doc->ExportField($this->Serie_Factura);
					if ($this->Consecutivo_Factura->Exportable) $Doc->ExportField($this->Consecutivo_Factura);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
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
	// Si insertan un Almacen hay que crear su renglon de registro para existencias  

	  InsertaRenglones_RegExistencias();
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
