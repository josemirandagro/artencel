<?php

// Global variable for table object
$ca_proveedores = NULL;

//
// Table class for ca_proveedores
//
class cca_proveedores extends cTable {
	var $Id_Proveedor;
	var $RazonSocial;
	var $RFC;
	var $NombreContacto;
	var $CalleYNumero;
	var $Colonia;
	var $Poblacion;
	var $Municipio_Delegacion;
	var $Id_Estado;
	var $CP;
	var $_EMail;
	var $Telefonos;
	var $Celular;
	var $Fax;
	var $Banco;
	var $NumCuenta;
	var $CLABE;
	var $Maneja_Papeleta;
	var $Observaciones;
	var $Maneja_Activacion_Movi;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ca_proveedores';
		$this->TableName = 'ca_proveedores';
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

		// Id_Proveedor
		$this->Id_Proveedor = new cField('ca_proveedores', 'ca_proveedores', 'x_Id_Proveedor', 'Id_Proveedor', '`Id_Proveedor`', '`Id_Proveedor`', 3, -1, FALSE, '`Id_Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Proveedor'] = &$this->Id_Proveedor;

		// RazonSocial
		$this->RazonSocial = new cField('ca_proveedores', 'ca_proveedores', 'x_RazonSocial', 'RazonSocial', '`RazonSocial`', '`RazonSocial`', 200, -1, FALSE, '`RazonSocial`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RazonSocial'] = &$this->RazonSocial;

		// RFC
		$this->RFC = new cField('ca_proveedores', 'ca_proveedores', 'x_RFC', 'RFC', '`RFC`', '`RFC`', 200, -1, FALSE, '`RFC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RFC'] = &$this->RFC;

		// NombreContacto
		$this->NombreContacto = new cField('ca_proveedores', 'ca_proveedores', 'x_NombreContacto', 'NombreContacto', '`NombreContacto`', '`NombreContacto`', 200, -1, FALSE, '`NombreContacto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['NombreContacto'] = &$this->NombreContacto;

		// CalleYNumero
		$this->CalleYNumero = new cField('ca_proveedores', 'ca_proveedores', 'x_CalleYNumero', 'CalleYNumero', '`CalleYNumero`', '`CalleYNumero`', 200, -1, FALSE, '`CalleYNumero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CalleYNumero'] = &$this->CalleYNumero;

		// Colonia
		$this->Colonia = new cField('ca_proveedores', 'ca_proveedores', 'x_Colonia', 'Colonia', '`Colonia`', '`Colonia`', 200, -1, FALSE, '`Colonia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Colonia'] = &$this->Colonia;

		// Poblacion
		$this->Poblacion = new cField('ca_proveedores', 'ca_proveedores', 'x_Poblacion', 'Poblacion', '`Poblacion`', '`Poblacion`', 200, -1, FALSE, '`Poblacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Poblacion'] = &$this->Poblacion;

		// Municipio_Delegacion
		$this->Municipio_Delegacion = new cField('ca_proveedores', 'ca_proveedores', 'x_Municipio_Delegacion', 'Municipio_Delegacion', '`Municipio_Delegacion`', '`Municipio_Delegacion`', 200, -1, FALSE, '`Municipio_Delegacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Municipio_Delegacion'] = &$this->Municipio_Delegacion;

		// Id_Estado
		$this->Id_Estado = new cField('ca_proveedores', 'ca_proveedores', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// CP
		$this->CP = new cField('ca_proveedores', 'ca_proveedores', 'x_CP', 'CP', '`CP`', '`CP`', 200, -1, FALSE, '`CP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CP'] = &$this->CP;

		// EMail
		$this->_EMail = new cField('ca_proveedores', 'ca_proveedores', 'x__EMail', 'EMail', '`EMail`', '`EMail`', 200, -1, FALSE, '`EMail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['EMail'] = &$this->_EMail;

		// Telefonos
		$this->Telefonos = new cField('ca_proveedores', 'ca_proveedores', 'x_Telefonos', 'Telefonos', '`Telefonos`', '`Telefonos`', 200, -1, FALSE, '`Telefonos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Telefonos'] = &$this->Telefonos;

		// Celular
		$this->Celular = new cField('ca_proveedores', 'ca_proveedores', 'x_Celular', 'Celular', '`Celular`', '`Celular`', 200, -1, FALSE, '`Celular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Celular'] = &$this->Celular;

		// Fax
		$this->Fax = new cField('ca_proveedores', 'ca_proveedores', 'x_Fax', 'Fax', '`Fax`', '`Fax`', 200, -1, FALSE, '`Fax`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Fax'] = &$this->Fax;

		// Banco
		$this->Banco = new cField('ca_proveedores', 'ca_proveedores', 'x_Banco', 'Banco', '`Banco`', '`Banco`', 200, -1, FALSE, '`Banco`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Banco'] = &$this->Banco;

		// NumCuenta
		$this->NumCuenta = new cField('ca_proveedores', 'ca_proveedores', 'x_NumCuenta', 'NumCuenta', '`NumCuenta`', '`NumCuenta`', 200, -1, FALSE, '`NumCuenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['NumCuenta'] = &$this->NumCuenta;

		// CLABE
		$this->CLABE = new cField('ca_proveedores', 'ca_proveedores', 'x_CLABE', 'CLABE', '`CLABE`', '`CLABE`', 200, -1, FALSE, '`CLABE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CLABE'] = &$this->CLABE;

		// Maneja_Papeleta
		$this->Maneja_Papeleta = new cField('ca_proveedores', 'ca_proveedores', 'x_Maneja_Papeleta', 'Maneja_Papeleta', '`Maneja_Papeleta`', '`Maneja_Papeleta`', 202, -1, FALSE, '`Maneja_Papeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Maneja_Papeleta'] = &$this->Maneja_Papeleta;

		// Observaciones
		$this->Observaciones = new cField('ca_proveedores', 'ca_proveedores', 'x_Observaciones', 'Observaciones', '`Observaciones`', '`Observaciones`', 201, -1, FALSE, '`Observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Observaciones'] = &$this->Observaciones;

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi = new cField('ca_proveedores', 'ca_proveedores', 'x_Maneja_Activacion_Movi', 'Maneja_Activacion_Movi', '`Maneja_Activacion_Movi`', '`Maneja_Activacion_Movi`', 202, -1, FALSE, '`Maneja_Activacion_Movi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Maneja_Activacion_Movi'] = &$this->Maneja_Activacion_Movi;
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
		return "`ca_proveedores`";
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
		return "`Id_Proveedor` ASC";
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
	var $UpdateTable = "`ca_proveedores`";

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
			$sql .= ew_QuotedName('Id_Proveedor') . '=' . ew_QuotedValue($rs['Id_Proveedor'], $this->Id_Proveedor->FldDataType) . ' AND ';
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
		return "`Id_Proveedor` = @Id_Proveedor@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Proveedor->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Proveedor@", ew_AdjustSql($this->Id_Proveedor->CurrentValue), $sKeyFilter); // Replace key value
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
			return "ca_proveedoreslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ca_proveedoreslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("ca_proveedoresview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "ca_proveedoresadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("ca_proveedoresedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("ca_proveedoresadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ca_proveedoresdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Proveedor->CurrentValue)) {
			$sUrl .= "Id_Proveedor=" . urlencode($this->Id_Proveedor->CurrentValue);
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
			$arKeys[] = @$_GET["Id_Proveedor"]; // Id_Proveedor

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
			$this->Id_Proveedor->CurrentValue = $key;
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
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->RazonSocial->setDbValue($rs->fields('RazonSocial'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->NombreContacto->setDbValue($rs->fields('NombreContacto'));
		$this->CalleYNumero->setDbValue($rs->fields('CalleYNumero'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->Municipio_Delegacion->setDbValue($rs->fields('Municipio_Delegacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->Banco->setDbValue($rs->fields('Banco'));
		$this->NumCuenta->setDbValue($rs->fields('NumCuenta'));
		$this->CLABE->setDbValue($rs->fields('CLABE'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Proveedor
		// RazonSocial
		// RFC
		// NombreContacto
		// CalleYNumero
		// Colonia
		// Poblacion
		// Municipio_Delegacion
		// Id_Estado
		// CP
		// EMail
		// Telefonos
		// Celular
		// Fax
		// Banco
		// NumCuenta
		// CLABE
		// Maneja_Papeleta
		// Observaciones
		// Maneja_Activacion_Movi
		// Id_Proveedor

		$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
		$this->Id_Proveedor->ViewCustomAttributes = "";

		// RazonSocial
		$this->RazonSocial->ViewValue = $this->RazonSocial->CurrentValue;
		$this->RazonSocial->ViewValue = strtoupper($this->RazonSocial->ViewValue);
		$this->RazonSocial->ViewCustomAttributes = "";

		// RFC
		$this->RFC->ViewValue = $this->RFC->CurrentValue;
		$this->RFC->ViewValue = strtoupper($this->RFC->ViewValue);
		$this->RFC->ViewCustomAttributes = "";

		// NombreContacto
		$this->NombreContacto->ViewValue = $this->NombreContacto->CurrentValue;
		$this->NombreContacto->ViewValue = strtoupper($this->NombreContacto->ViewValue);
		$this->NombreContacto->ViewCustomAttributes = "";

		// CalleYNumero
		$this->CalleYNumero->ViewValue = $this->CalleYNumero->CurrentValue;
		$this->CalleYNumero->ViewValue = strtoupper($this->CalleYNumero->ViewValue);
		$this->CalleYNumero->ViewCustomAttributes = "";

		// Colonia
		$this->Colonia->ViewValue = $this->Colonia->CurrentValue;
		$this->Colonia->ViewValue = strtoupper($this->Colonia->ViewValue);
		$this->Colonia->ViewCustomAttributes = "";

		// Poblacion
		$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
		$this->Poblacion->ViewValue = strtoupper($this->Poblacion->ViewValue);
		$this->Poblacion->ViewCustomAttributes = "";

		// Municipio_Delegacion
		$this->Municipio_Delegacion->ViewValue = $this->Municipio_Delegacion->CurrentValue;
		$this->Municipio_Delegacion->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Estado` Asc";
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

		// Fax
		$this->Fax->ViewValue = $this->Fax->CurrentValue;
		$this->Fax->ViewCustomAttributes = "";

		// Banco
		$this->Banco->ViewValue = $this->Banco->CurrentValue;
		$this->Banco->ViewCustomAttributes = "";

		// NumCuenta
		$this->NumCuenta->ViewValue = $this->NumCuenta->CurrentValue;
		$this->NumCuenta->ViewCustomAttributes = "";

		// CLABE
		$this->CLABE->ViewValue = $this->CLABE->CurrentValue;
		$this->CLABE->ViewCustomAttributes = "";

		// Maneja_Papeleta
		if (strval($this->Maneja_Papeleta->CurrentValue) <> "") {
			switch ($this->Maneja_Papeleta->CurrentValue) {
				case $this->Maneja_Papeleta->FldTagValue(1):
					$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(1) <> "" ? $this->Maneja_Papeleta->FldTagCaption(1) : $this->Maneja_Papeleta->CurrentValue;
					break;
				case $this->Maneja_Papeleta->FldTagValue(2):
					$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(2) <> "" ? $this->Maneja_Papeleta->FldTagCaption(2) : $this->Maneja_Papeleta->CurrentValue;
					break;
				default:
					$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->CurrentValue;
			}
		} else {
			$this->Maneja_Papeleta->ViewValue = NULL;
		}
		$this->Maneja_Papeleta->ViewCustomAttributes = "";

		// Observaciones
		$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
		$this->Observaciones->ViewValue = strtoupper($this->Observaciones->ViewValue);
		$this->Observaciones->ViewCustomAttributes = "";

		// Maneja_Activacion_Movi
		if (strval($this->Maneja_Activacion_Movi->CurrentValue) <> "") {
			switch ($this->Maneja_Activacion_Movi->CurrentValue) {
				case $this->Maneja_Activacion_Movi->FldTagValue(1):
					$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(1) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(1) : $this->Maneja_Activacion_Movi->CurrentValue;
					break;
				case $this->Maneja_Activacion_Movi->FldTagValue(2):
					$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(2) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(2) : $this->Maneja_Activacion_Movi->CurrentValue;
					break;
				default:
					$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
			}
		} else {
			$this->Maneja_Activacion_Movi->ViewValue = NULL;
		}
		$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

		// Id_Proveedor
		$this->Id_Proveedor->LinkCustomAttributes = "";
		$this->Id_Proveedor->HrefValue = "";
		$this->Id_Proveedor->TooltipValue = "";

		// RazonSocial
		$this->RazonSocial->LinkCustomAttributes = "";
		$this->RazonSocial->HrefValue = "";
		$this->RazonSocial->TooltipValue = "";

		// RFC
		$this->RFC->LinkCustomAttributes = "";
		$this->RFC->HrefValue = "";
		$this->RFC->TooltipValue = "";

		// NombreContacto
		$this->NombreContacto->LinkCustomAttributes = "";
		$this->NombreContacto->HrefValue = "";
		$this->NombreContacto->TooltipValue = "";

		// CalleYNumero
		$this->CalleYNumero->LinkCustomAttributes = "";
		$this->CalleYNumero->HrefValue = "";
		$this->CalleYNumero->TooltipValue = "";

		// Colonia
		$this->Colonia->LinkCustomAttributes = "";
		$this->Colonia->HrefValue = "";
		$this->Colonia->TooltipValue = "";

		// Poblacion
		$this->Poblacion->LinkCustomAttributes = "";
		$this->Poblacion->HrefValue = "";
		$this->Poblacion->TooltipValue = "";

		// Municipio_Delegacion
		$this->Municipio_Delegacion->LinkCustomAttributes = "";
		$this->Municipio_Delegacion->HrefValue = "";
		$this->Municipio_Delegacion->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

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

		// Fax
		$this->Fax->LinkCustomAttributes = "";
		$this->Fax->HrefValue = "";
		$this->Fax->TooltipValue = "";

		// Banco
		$this->Banco->LinkCustomAttributes = "";
		$this->Banco->HrefValue = "";
		$this->Banco->TooltipValue = "";

		// NumCuenta
		$this->NumCuenta->LinkCustomAttributes = "";
		$this->NumCuenta->HrefValue = "";
		$this->NumCuenta->TooltipValue = "";

		// CLABE
		$this->CLABE->LinkCustomAttributes = "";
		$this->CLABE->HrefValue = "";
		$this->CLABE->TooltipValue = "";

		// Maneja_Papeleta
		$this->Maneja_Papeleta->LinkCustomAttributes = "";
		$this->Maneja_Papeleta->HrefValue = "";
		$this->Maneja_Papeleta->TooltipValue = "";

		// Observaciones
		$this->Observaciones->LinkCustomAttributes = "";
		$this->Observaciones->HrefValue = "";
		$this->Observaciones->TooltipValue = "";

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->LinkCustomAttributes = "";
		$this->Maneja_Activacion_Movi->HrefValue = "";
		$this->Maneja_Activacion_Movi->TooltipValue = "";

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
				if ($this->Id_Proveedor->Exportable) $Doc->ExportCaption($this->Id_Proveedor);
				if ($this->RazonSocial->Exportable) $Doc->ExportCaption($this->RazonSocial);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
				if ($this->NombreContacto->Exportable) $Doc->ExportCaption($this->NombreContacto);
				if ($this->CalleYNumero->Exportable) $Doc->ExportCaption($this->CalleYNumero);
				if ($this->Colonia->Exportable) $Doc->ExportCaption($this->Colonia);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->Municipio_Delegacion->Exportable) $Doc->ExportCaption($this->Municipio_Delegacion);
				if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Telefonos->Exportable) $Doc->ExportCaption($this->Telefonos);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Fax->Exportable) $Doc->ExportCaption($this->Fax);
				if ($this->Banco->Exportable) $Doc->ExportCaption($this->Banco);
				if ($this->NumCuenta->Exportable) $Doc->ExportCaption($this->NumCuenta);
				if ($this->CLABE->Exportable) $Doc->ExportCaption($this->CLABE);
				if ($this->Maneja_Papeleta->Exportable) $Doc->ExportCaption($this->Maneja_Papeleta);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportCaption($this->Maneja_Activacion_Movi);
			} else {
				if ($this->Maneja_Papeleta->Exportable) $Doc->ExportCaption($this->Maneja_Papeleta);
				if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportCaption($this->Maneja_Activacion_Movi);
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
					if ($this->Id_Proveedor->Exportable) $Doc->ExportField($this->Id_Proveedor);
					if ($this->RazonSocial->Exportable) $Doc->ExportField($this->RazonSocial);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
					if ($this->NombreContacto->Exportable) $Doc->ExportField($this->NombreContacto);
					if ($this->CalleYNumero->Exportable) $Doc->ExportField($this->CalleYNumero);
					if ($this->Colonia->Exportable) $Doc->ExportField($this->Colonia);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->Municipio_Delegacion->Exportable) $Doc->ExportField($this->Municipio_Delegacion);
					if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Telefonos->Exportable) $Doc->ExportField($this->Telefonos);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Fax->Exportable) $Doc->ExportField($this->Fax);
					if ($this->Banco->Exportable) $Doc->ExportField($this->Banco);
					if ($this->NumCuenta->Exportable) $Doc->ExportField($this->NumCuenta);
					if ($this->CLABE->Exportable) $Doc->ExportField($this->CLABE);
					if ($this->Maneja_Papeleta->Exportable) $Doc->ExportField($this->Maneja_Papeleta);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportField($this->Maneja_Activacion_Movi);
				} else {
					if ($this->Maneja_Papeleta->Exportable) $Doc->ExportField($this->Maneja_Papeleta);
					if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportField($this->Maneja_Activacion_Movi);
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
