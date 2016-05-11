<?php

// Global variable for table object
$ca_clientes = NULL;

//
// Table class for ca_clientes
//
class cca_clientes extends cTable {
	var $Id_Cliente;
	var $Nombre_Completo;
	var $Razon_Social;
	var $Domicilio;
	var $Num_Exterior;
	var $Num_Interior;
	var $Colonia;
	var $Poblacion;
	var $MunicipioDel;
	var $Id_Estado;
	var $CP;
	var $RFC;
	var $Categoria;
	var $CURP;
	var $Tel_Particular;
	var $Tel_Oficina;
	var $Celular;
	var $Edad;
	var $Sexo;
	var $Tipo_Identificacion;
	var $Otra_Identificacion;
	var $Numero_Identificacion;
	var $_EMail;
	var $Comentarios;
	var $Ap_Paterno;
	var $Ap_materno;
	var $Nombres;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ca_clientes';
		$this->TableName = 'ca_clientes';
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

		// Id_Cliente
		$this->Id_Cliente = new cField('ca_clientes', 'ca_clientes', 'x_Id_Cliente', 'Id_Cliente', '`Id_Cliente`', '`Id_Cliente`', 3, -1, FALSE, '`Id_Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Cliente'] = &$this->Id_Cliente;

		// Nombre_Completo
		$this->Nombre_Completo = new cField('ca_clientes', 'ca_clientes', 'x_Nombre_Completo', 'Nombre_Completo', '`Nombre_Completo`', '`Nombre_Completo`', 200, -1, FALSE, '`Nombre_Completo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombre_Completo'] = &$this->Nombre_Completo;

		// Razon_Social
		$this->Razon_Social = new cField('ca_clientes', 'ca_clientes', 'x_Razon_Social', 'Razon_Social', '`Razon_Social`', '`Razon_Social`', 200, -1, FALSE, '`Razon_Social`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Razon_Social'] = &$this->Razon_Social;

		// Domicilio
		$this->Domicilio = new cField('ca_clientes', 'ca_clientes', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Num_Exterior
		$this->Num_Exterior = new cField('ca_clientes', 'ca_clientes', 'x_Num_Exterior', 'Num_Exterior', '`Num_Exterior`', '`Num_Exterior`', 200, -1, FALSE, '`Num_Exterior`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_Exterior'] = &$this->Num_Exterior;

		// Num_Interior
		$this->Num_Interior = new cField('ca_clientes', 'ca_clientes', 'x_Num_Interior', 'Num_Interior', '`Num_Interior`', '`Num_Interior`', 200, -1, FALSE, '`Num_Interior`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_Interior'] = &$this->Num_Interior;

		// Colonia
		$this->Colonia = new cField('ca_clientes', 'ca_clientes', 'x_Colonia', 'Colonia', '`Colonia`', '`Colonia`', 200, -1, FALSE, '`Colonia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Colonia'] = &$this->Colonia;

		// Poblacion
		$this->Poblacion = new cField('ca_clientes', 'ca_clientes', 'x_Poblacion', 'Poblacion', '`Poblacion`', '`Poblacion`', 200, -1, FALSE, '`Poblacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Poblacion'] = &$this->Poblacion;

		// MunicipioDel
		$this->MunicipioDel = new cField('ca_clientes', 'ca_clientes', 'x_MunicipioDel', 'MunicipioDel', '`MunicipioDel`', '`MunicipioDel`', 200, -1, FALSE, '`MunicipioDel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['MunicipioDel'] = &$this->MunicipioDel;

		// Id_Estado
		$this->Id_Estado = new cField('ca_clientes', 'ca_clientes', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// CP
		$this->CP = new cField('ca_clientes', 'ca_clientes', 'x_CP', 'CP', '`CP`', '`CP`', 200, -1, FALSE, '`CP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CP'] = &$this->CP;

		// RFC
		$this->RFC = new cField('ca_clientes', 'ca_clientes', 'x_RFC', 'RFC', '`RFC`', '`RFC`', 200, -1, FALSE, '`RFC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RFC'] = &$this->RFC;

		// Categoria
		$this->Categoria = new cField('ca_clientes', 'ca_clientes', 'x_Categoria', 'Categoria', '`Categoria`', '`Categoria`', 202, -1, FALSE, '`Categoria`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Categoria'] = &$this->Categoria;

		// CURP
		$this->CURP = new cField('ca_clientes', 'ca_clientes', 'x_CURP', 'CURP', '`CURP`', '`CURP`', 200, -1, FALSE, '`CURP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CURP'] = &$this->CURP;

		// Tel_Particular
		$this->Tel_Particular = new cField('ca_clientes', 'ca_clientes', 'x_Tel_Particular', 'Tel_Particular', '`Tel_Particular`', '`Tel_Particular`', 200, -1, FALSE, '`Tel_Particular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tel_Particular'] = &$this->Tel_Particular;

		// Tel_Oficina
		$this->Tel_Oficina = new cField('ca_clientes', 'ca_clientes', 'x_Tel_Oficina', 'Tel_Oficina', '`Tel_Oficina`', '`Tel_Oficina`', 200, -1, FALSE, '`Tel_Oficina`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tel_Oficina'] = &$this->Tel_Oficina;

		// Celular
		$this->Celular = new cField('ca_clientes', 'ca_clientes', 'x_Celular', 'Celular', '`Celular`', '`Celular`', 200, -1, FALSE, '`Celular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Celular'] = &$this->Celular;

		// Edad
		$this->Edad = new cField('ca_clientes', 'ca_clientes', 'x_Edad', 'Edad', '`Edad`', '`Edad`', 3, -1, FALSE, '`Edad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Edad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Edad'] = &$this->Edad;

		// Sexo
		$this->Sexo = new cField('ca_clientes', 'ca_clientes', 'x_Sexo', 'Sexo', '`Sexo`', '`Sexo`', 202, -1, FALSE, '`Sexo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Sexo'] = &$this->Sexo;

		// Tipo_Identificacion
		$this->Tipo_Identificacion = new cField('ca_clientes', 'ca_clientes', 'x_Tipo_Identificacion', 'Tipo_Identificacion', '`Tipo_Identificacion`', '`Tipo_Identificacion`', 202, -1, FALSE, '`Tipo_Identificacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Tipo_Identificacion'] = &$this->Tipo_Identificacion;

		// Otra_Identificacion
		$this->Otra_Identificacion = new cField('ca_clientes', 'ca_clientes', 'x_Otra_Identificacion', 'Otra_Identificacion', '`Otra_Identificacion`', '`Otra_Identificacion`', 200, -1, FALSE, '`Otra_Identificacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Otra_Identificacion'] = &$this->Otra_Identificacion;

		// Numero_Identificacion
		$this->Numero_Identificacion = new cField('ca_clientes', 'ca_clientes', 'x_Numero_Identificacion', 'Numero_Identificacion', '`Numero_Identificacion`', '`Numero_Identificacion`', 200, -1, FALSE, '`Numero_Identificacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Numero_Identificacion'] = &$this->Numero_Identificacion;

		// EMail
		$this->_EMail = new cField('ca_clientes', 'ca_clientes', 'x__EMail', 'EMail', '`EMail`', '`EMail`', 200, -1, FALSE, '`EMail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['EMail'] = &$this->_EMail;

		// Comentarios
		$this->Comentarios = new cField('ca_clientes', 'ca_clientes', 'x_Comentarios', 'Comentarios', '`Comentarios`', '`Comentarios`', 200, -1, FALSE, '`Comentarios`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Comentarios'] = &$this->Comentarios;

		// Ap_Paterno
		$this->Ap_Paterno = new cField('ca_clientes', 'ca_clientes', 'x_Ap_Paterno', 'Ap_Paterno', '`Ap_Paterno`', '`Ap_Paterno`', 200, -1, FALSE, '`Ap_Paterno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Ap_Paterno'] = &$this->Ap_Paterno;

		// Ap_materno
		$this->Ap_materno = new cField('ca_clientes', 'ca_clientes', 'x_Ap_materno', 'Ap_materno', '`Ap_materno`', '`Ap_materno`', 200, -1, FALSE, '`Ap_materno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Ap_materno'] = &$this->Ap_materno;

		// Nombres
		$this->Nombres = new cField('ca_clientes', 'ca_clientes', 'x_Nombres', 'Nombres', '`Nombres`', '`Nombres`', 200, -1, FALSE, '`Nombres`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nombres'] = &$this->Nombres;
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
		return "`ca_clientes`";
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
		return "`Nombre_Completo` ASC";
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
	var $UpdateTable = "`ca_clientes`";

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
			return "ca_clienteslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ca_clienteslist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("ca_clientesview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "ca_clientesadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("ca_clientesedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("ca_clientesadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ca_clientesdelete.php", $this->UrlParm());
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
		$this->Razon_Social->setDbValue($rs->fields('Razon_Social'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Num_Exterior->setDbValue($rs->fields('Num_Exterior'));
		$this->Num_Interior->setDbValue($rs->fields('Num_Interior'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->MunicipioDel->setDbValue($rs->fields('MunicipioDel'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->Categoria->setDbValue($rs->fields('Categoria'));
		$this->CURP->setDbValue($rs->fields('CURP'));
		$this->Tel_Particular->setDbValue($rs->fields('Tel_Particular'));
		$this->Tel_Oficina->setDbValue($rs->fields('Tel_Oficina'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Sexo->setDbValue($rs->fields('Sexo'));
		$this->Tipo_Identificacion->setDbValue($rs->fields('Tipo_Identificacion'));
		$this->Otra_Identificacion->setDbValue($rs->fields('Otra_Identificacion'));
		$this->Numero_Identificacion->setDbValue($rs->fields('Numero_Identificacion'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
		$this->Ap_Paterno->setDbValue($rs->fields('Ap_Paterno'));
		$this->Ap_materno->setDbValue($rs->fields('Ap_materno'));
		$this->Nombres->setDbValue($rs->fields('Nombres'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Cliente

		$this->Id_Cliente->CellCssStyle = "white-space: nowrap;";

		// Nombre_Completo
		// Razon_Social

		$this->Razon_Social->CellCssStyle = "white-space: nowrap;";

		// Domicilio
		// Num_Exterior
		// Num_Interior
		// Colonia
		// Poblacion
		// MunicipioDel
		// Id_Estado
		// CP
		// RFC
		// Categoria
		// CURP
		// Tel_Particular
		// Tel_Oficina
		// Celular
		// Edad
		// Sexo
		// Tipo_Identificacion
		// Otra_Identificacion
		// Numero_Identificacion
		// EMail
		// Comentarios
		// Ap_Paterno

		$this->Ap_Paterno->CellCssStyle = "white-space: nowrap;";

		// Ap_materno
		$this->Ap_materno->CellCssStyle = "white-space: nowrap;";

		// Nombres
		$this->Nombres->CellCssStyle = "white-space: nowrap;";

		// Id_Cliente
		$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
		$this->Id_Cliente->ViewCustomAttributes = "";

		// Nombre_Completo
		$this->Nombre_Completo->ViewValue = $this->Nombre_Completo->CurrentValue;
		$this->Nombre_Completo->ViewValue = strtoupper($this->Nombre_Completo->ViewValue);
		$this->Nombre_Completo->ViewCustomAttributes = "";

		// Razon_Social
		$this->Razon_Social->ViewValue = $this->Razon_Social->CurrentValue;
		$this->Razon_Social->ViewValue = strtoupper($this->Razon_Social->ViewValue);
		$this->Razon_Social->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewValue = strtoupper($this->Domicilio->ViewValue);
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
		$this->Poblacion->ViewValue = strtoupper($this->Poblacion->ViewValue);
		$this->Poblacion->ViewCustomAttributes = "";

		// MunicipioDel
		$this->MunicipioDel->ViewValue = $this->MunicipioDel->CurrentValue;
		$this->MunicipioDel->ViewValue = strtoupper($this->MunicipioDel->ViewValue);
		$this->MunicipioDel->ViewCustomAttributes = "";

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
		$this->Id_Estado->ViewValue = strtoupper($this->Id_Estado->ViewValue);
		$this->Id_Estado->ViewCustomAttributes = "";

		// CP
		$this->CP->ViewValue = $this->CP->CurrentValue;
		$this->CP->ViewCustomAttributes = "";

		// RFC
		$this->RFC->ViewValue = $this->RFC->CurrentValue;
		$this->RFC->ViewValue = strtoupper($this->RFC->ViewValue);
		$this->RFC->ViewCustomAttributes = "";

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

		// CURP
		$this->CURP->ViewValue = $this->CURP->CurrentValue;
		$this->CURP->ViewValue = strtoupper($this->CURP->ViewValue);
		$this->CURP->ViewCustomAttributes = "";

		// Tel_Particular
		$this->Tel_Particular->ViewValue = $this->Tel_Particular->CurrentValue;
		$this->Tel_Particular->ViewCustomAttributes = "";

		// Tel_Oficina
		$this->Tel_Oficina->ViewValue = $this->Tel_Oficina->CurrentValue;
		$this->Tel_Oficina->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Edad
		$this->Edad->ViewValue = $this->Edad->CurrentValue;
		$this->Edad->ViewCustomAttributes = "";

		// Sexo
		if (strval($this->Sexo->CurrentValue) <> "") {
			switch ($this->Sexo->CurrentValue) {
				case $this->Sexo->FldTagValue(1):
					$this->Sexo->ViewValue = $this->Sexo->FldTagCaption(1) <> "" ? $this->Sexo->FldTagCaption(1) : $this->Sexo->CurrentValue;
					break;
				case $this->Sexo->FldTagValue(2):
					$this->Sexo->ViewValue = $this->Sexo->FldTagCaption(2) <> "" ? $this->Sexo->FldTagCaption(2) : $this->Sexo->CurrentValue;
					break;
				default:
					$this->Sexo->ViewValue = $this->Sexo->CurrentValue;
			}
		} else {
			$this->Sexo->ViewValue = NULL;
		}
		$this->Sexo->ViewCustomAttributes = "";

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

		// Otra_Identificacion
		$this->Otra_Identificacion->ViewValue = $this->Otra_Identificacion->CurrentValue;
		$this->Otra_Identificacion->ViewCustomAttributes = "";

		// Numero_Identificacion
		$this->Numero_Identificacion->ViewValue = $this->Numero_Identificacion->CurrentValue;
		$this->Numero_Identificacion->ViewCustomAttributes = "";

		// EMail
		$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
		$this->_EMail->ViewValue = strtolower($this->_EMail->ViewValue);
		$this->_EMail->ViewCustomAttributes = "";

		// Comentarios
		$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
		$this->Comentarios->ViewValue = strtoupper($this->Comentarios->ViewValue);
		$this->Comentarios->ViewCustomAttributes = "";

		// Ap_Paterno
		$this->Ap_Paterno->ViewValue = $this->Ap_Paterno->CurrentValue;
		$this->Ap_Paterno->ViewValue = strtoupper($this->Ap_Paterno->ViewValue);
		$this->Ap_Paterno->ViewCustomAttributes = "";

		// Ap_materno
		$this->Ap_materno->ViewValue = $this->Ap_materno->CurrentValue;
		$this->Ap_materno->ViewValue = strtoupper($this->Ap_materno->ViewValue);
		$this->Ap_materno->ViewCustomAttributes = "";

		// Nombres
		$this->Nombres->ViewValue = $this->Nombres->CurrentValue;
		$this->Nombres->ViewValue = strtoupper($this->Nombres->ViewValue);
		$this->Nombres->ViewCustomAttributes = "";

		// Id_Cliente
		$this->Id_Cliente->LinkCustomAttributes = "";
		$this->Id_Cliente->HrefValue = "";
		$this->Id_Cliente->TooltipValue = "";

		// Nombre_Completo
		$this->Nombre_Completo->LinkCustomAttributes = "";
		$this->Nombre_Completo->HrefValue = "";
		$this->Nombre_Completo->TooltipValue = "";

		// Razon_Social
		$this->Razon_Social->LinkCustomAttributes = "";
		$this->Razon_Social->HrefValue = "";
		$this->Razon_Social->TooltipValue = "";

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

		// MunicipioDel
		$this->MunicipioDel->LinkCustomAttributes = "";
		$this->MunicipioDel->HrefValue = "";
		$this->MunicipioDel->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// CP
		$this->CP->LinkCustomAttributes = "";
		$this->CP->HrefValue = "";
		$this->CP->TooltipValue = "";

		// RFC
		$this->RFC->LinkCustomAttributes = "";
		$this->RFC->HrefValue = "";
		$this->RFC->TooltipValue = "";

		// Categoria
		$this->Categoria->LinkCustomAttributes = "";
		$this->Categoria->HrefValue = "";
		$this->Categoria->TooltipValue = "";

		// CURP
		$this->CURP->LinkCustomAttributes = "";
		$this->CURP->HrefValue = "";
		$this->CURP->TooltipValue = "";

		// Tel_Particular
		$this->Tel_Particular->LinkCustomAttributes = "";
		$this->Tel_Particular->HrefValue = "";
		$this->Tel_Particular->TooltipValue = "";

		// Tel_Oficina
		$this->Tel_Oficina->LinkCustomAttributes = "";
		$this->Tel_Oficina->HrefValue = "";
		$this->Tel_Oficina->TooltipValue = "";

		// Celular
		$this->Celular->LinkCustomAttributes = "";
		$this->Celular->HrefValue = "";
		$this->Celular->TooltipValue = "";

		// Edad
		$this->Edad->LinkCustomAttributes = "";
		$this->Edad->HrefValue = "";
		$this->Edad->TooltipValue = "";

		// Sexo
		$this->Sexo->LinkCustomAttributes = "";
		$this->Sexo->HrefValue = "";
		$this->Sexo->TooltipValue = "";

		// Tipo_Identificacion
		$this->Tipo_Identificacion->LinkCustomAttributes = "";
		$this->Tipo_Identificacion->HrefValue = "";
		$this->Tipo_Identificacion->TooltipValue = "";

		// Otra_Identificacion
		$this->Otra_Identificacion->LinkCustomAttributes = "";
		$this->Otra_Identificacion->HrefValue = "";
		$this->Otra_Identificacion->TooltipValue = "";

		// Numero_Identificacion
		$this->Numero_Identificacion->LinkCustomAttributes = "";
		$this->Numero_Identificacion->HrefValue = "";
		$this->Numero_Identificacion->TooltipValue = "";

		// EMail
		$this->_EMail->LinkCustomAttributes = "";
		$this->_EMail->HrefValue = "";
		$this->_EMail->TooltipValue = "";

		// Comentarios
		$this->Comentarios->LinkCustomAttributes = "";
		$this->Comentarios->HrefValue = "";
		$this->Comentarios->TooltipValue = "";

		// Ap_Paterno
		$this->Ap_Paterno->LinkCustomAttributes = "";
		$this->Ap_Paterno->HrefValue = "";
		$this->Ap_Paterno->TooltipValue = "";

		// Ap_materno
		$this->Ap_materno->LinkCustomAttributes = "";
		$this->Ap_materno->HrefValue = "";
		$this->Ap_materno->TooltipValue = "";

		// Nombres
		$this->Nombres->LinkCustomAttributes = "";
		$this->Nombres->HrefValue = "";
		$this->Nombres->TooltipValue = "";

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
				if ($this->Nombre_Completo->Exportable) $Doc->ExportCaption($this->Nombre_Completo);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Num_Exterior->Exportable) $Doc->ExportCaption($this->Num_Exterior);
				if ($this->Num_Interior->Exportable) $Doc->ExportCaption($this->Num_Interior);
				if ($this->Colonia->Exportable) $Doc->ExportCaption($this->Colonia);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->MunicipioDel->Exportable) $Doc->ExportCaption($this->MunicipioDel);
				if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
				if ($this->Categoria->Exportable) $Doc->ExportCaption($this->Categoria);
				if ($this->CURP->Exportable) $Doc->ExportCaption($this->CURP);
				if ($this->Tel_Particular->Exportable) $Doc->ExportCaption($this->Tel_Particular);
				if ($this->Tel_Oficina->Exportable) $Doc->ExportCaption($this->Tel_Oficina);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
				if ($this->Sexo->Exportable) $Doc->ExportCaption($this->Sexo);
				if ($this->Tipo_Identificacion->Exportable) $Doc->ExportCaption($this->Tipo_Identificacion);
				if ($this->Otra_Identificacion->Exportable) $Doc->ExportCaption($this->Otra_Identificacion);
				if ($this->Numero_Identificacion->Exportable) $Doc->ExportCaption($this->Numero_Identificacion);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Comentarios->Exportable) $Doc->ExportCaption($this->Comentarios);
			} else {
				if ($this->Nombre_Completo->Exportable) $Doc->ExportCaption($this->Nombre_Completo);
				if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
				if ($this->Num_Exterior->Exportable) $Doc->ExportCaption($this->Num_Exterior);
				if ($this->Num_Interior->Exportable) $Doc->ExportCaption($this->Num_Interior);
				if ($this->Colonia->Exportable) $Doc->ExportCaption($this->Colonia);
				if ($this->Poblacion->Exportable) $Doc->ExportCaption($this->Poblacion);
				if ($this->MunicipioDel->Exportable) $Doc->ExportCaption($this->MunicipioDel);
				if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
				if ($this->CP->Exportable) $Doc->ExportCaption($this->CP);
				if ($this->RFC->Exportable) $Doc->ExportCaption($this->RFC);
				if ($this->Categoria->Exportable) $Doc->ExportCaption($this->Categoria);
				if ($this->CURP->Exportable) $Doc->ExportCaption($this->CURP);
				if ($this->Tel_Particular->Exportable) $Doc->ExportCaption($this->Tel_Particular);
				if ($this->Tel_Oficina->Exportable) $Doc->ExportCaption($this->Tel_Oficina);
				if ($this->Celular->Exportable) $Doc->ExportCaption($this->Celular);
				if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
				if ($this->Sexo->Exportable) $Doc->ExportCaption($this->Sexo);
				if ($this->Tipo_Identificacion->Exportable) $Doc->ExportCaption($this->Tipo_Identificacion);
				if ($this->Otra_Identificacion->Exportable) $Doc->ExportCaption($this->Otra_Identificacion);
				if ($this->Numero_Identificacion->Exportable) $Doc->ExportCaption($this->Numero_Identificacion);
				if ($this->_EMail->Exportable) $Doc->ExportCaption($this->_EMail);
				if ($this->Comentarios->Exportable) $Doc->ExportCaption($this->Comentarios);
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
					if ($this->Nombre_Completo->Exportable) $Doc->ExportField($this->Nombre_Completo);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Num_Exterior->Exportable) $Doc->ExportField($this->Num_Exterior);
					if ($this->Num_Interior->Exportable) $Doc->ExportField($this->Num_Interior);
					if ($this->Colonia->Exportable) $Doc->ExportField($this->Colonia);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->MunicipioDel->Exportable) $Doc->ExportField($this->MunicipioDel);
					if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
					if ($this->Categoria->Exportable) $Doc->ExportField($this->Categoria);
					if ($this->CURP->Exportable) $Doc->ExportField($this->CURP);
					if ($this->Tel_Particular->Exportable) $Doc->ExportField($this->Tel_Particular);
					if ($this->Tel_Oficina->Exportable) $Doc->ExportField($this->Tel_Oficina);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
					if ($this->Sexo->Exportable) $Doc->ExportField($this->Sexo);
					if ($this->Tipo_Identificacion->Exportable) $Doc->ExportField($this->Tipo_Identificacion);
					if ($this->Otra_Identificacion->Exportable) $Doc->ExportField($this->Otra_Identificacion);
					if ($this->Numero_Identificacion->Exportable) $Doc->ExportField($this->Numero_Identificacion);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Comentarios->Exportable) $Doc->ExportField($this->Comentarios);
				} else {
					if ($this->Nombre_Completo->Exportable) $Doc->ExportField($this->Nombre_Completo);
					if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
					if ($this->Num_Exterior->Exportable) $Doc->ExportField($this->Num_Exterior);
					if ($this->Num_Interior->Exportable) $Doc->ExportField($this->Num_Interior);
					if ($this->Colonia->Exportable) $Doc->ExportField($this->Colonia);
					if ($this->Poblacion->Exportable) $Doc->ExportField($this->Poblacion);
					if ($this->MunicipioDel->Exportable) $Doc->ExportField($this->MunicipioDel);
					if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
					if ($this->CP->Exportable) $Doc->ExportField($this->CP);
					if ($this->RFC->Exportable) $Doc->ExportField($this->RFC);
					if ($this->Categoria->Exportable) $Doc->ExportField($this->Categoria);
					if ($this->CURP->Exportable) $Doc->ExportField($this->CURP);
					if ($this->Tel_Particular->Exportable) $Doc->ExportField($this->Tel_Particular);
					if ($this->Tel_Oficina->Exportable) $Doc->ExportField($this->Tel_Oficina);
					if ($this->Celular->Exportable) $Doc->ExportField($this->Celular);
					if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
					if ($this->Sexo->Exportable) $Doc->ExportField($this->Sexo);
					if ($this->Tipo_Identificacion->Exportable) $Doc->ExportField($this->Tipo_Identificacion);
					if ($this->Otra_Identificacion->Exportable) $Doc->ExportField($this->Otra_Identificacion);
					if ($this->Numero_Identificacion->Exportable) $Doc->ExportField($this->Numero_Identificacion);
					if ($this->_EMail->Exportable) $Doc->ExportField($this->_EMail);
					if ($this->Comentarios->Exportable) $Doc->ExportField($this->Comentarios);
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
