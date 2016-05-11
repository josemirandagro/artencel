<?php

// Global variable for table object
$cap_imprimir_docs_amigokit = NULL;

//
// Table class for cap_imprimir_docs_amigokit
//
class ccap_imprimir_docs_amigokit extends cTable {
	var $Id_Venta_Eq;
	var $FechaVenta;
	var $Id_Tienda;
	var $Id_Tel_SIM;
	var $Id_Cliente;
	var $Num_IMEI;
	var $Num_ICCID;
	var $Num_CEL;
	var $Descripcion_SIM;
	var $Reg_Venta_Movi;
	var $Monto_Recarga_Movi;
	var $Folio_Recarga_Movi;
	var $ImprimirNotaVenta;
	var $Serie_NotaVenta;
	var $Numero_NotaVenta;
	var $Imprimirpapeleta;
	var $FolioImpresoPapeleta;
	var $Maneja_Papeleta;
	var $Maneja_Activacion_Movi;
	var $Con_SIM;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cap_imprimir_docs_amigokit';
		$this->TableName = 'cap_imprimir_docs_amigokit';
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
		$this->Id_Venta_Eq = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Id_Venta_Eq', 'Id_Venta_Eq', '`Id_Venta_Eq`', '`Id_Venta_Eq`', 3, -1, FALSE, '`Id_Venta_Eq`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Venta_Eq->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Venta_Eq'] = &$this->Id_Venta_Eq;

		// FechaVenta
		$this->FechaVenta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_FechaVenta', 'FechaVenta', '`FechaVenta`', 'DATE_FORMAT(`FechaVenta`, \'%d/%m/%Y %H:%i:%s\')', 133, 7, FALSE, '`FechaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->FechaVenta->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['FechaVenta'] = &$this->FechaVenta;

		// Id_Tienda
		$this->Id_Tienda = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Id_Tienda', 'Id_Tienda', '`Id_Tienda`', '`Id_Tienda`', 3, -1, FALSE, '`Id_Tienda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tienda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tienda'] = &$this->Id_Tienda;

		// Id_Tel_SIM
		$this->Id_Tel_SIM = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Id_Tel_SIM', 'Id_Tel_SIM', '`Id_Tel_SIM`', '`Id_Tel_SIM`', 3, -1, FALSE, '`Id_Tel_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Tel_SIM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tel_SIM'] = &$this->Id_Tel_SIM;

		// Id_Cliente
		$this->Id_Cliente = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Id_Cliente', 'Id_Cliente', '`Id_Cliente`', '`Id_Cliente`', 3, -1, FALSE, '`Id_Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Cliente'] = &$this->Id_Cliente;

		// Num_IMEI
		$this->Num_IMEI = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Num_IMEI', 'Num_IMEI', '`Num_IMEI`', '`Num_IMEI`', 200, -1, FALSE, '`Num_IMEI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_IMEI'] = &$this->Num_IMEI;

		// Num_ICCID
		$this->Num_ICCID = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Num_ICCID', 'Num_ICCID', '`Num_ICCID`', '`Num_ICCID`', 200, -1, FALSE, '`Num_ICCID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_ICCID'] = &$this->Num_ICCID;

		// Num_CEL
		$this->Num_CEL = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Num_CEL', 'Num_CEL', '`Num_CEL`', '`Num_CEL`', 200, -1, FALSE, '`Num_CEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Num_CEL'] = &$this->Num_CEL;

		// Descripcion_SIM
		$this->Descripcion_SIM = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Descripcion_SIM', 'Descripcion_SIM', '`Descripcion_SIM`', '`Descripcion_SIM`', 200, -1, FALSE, '`Descripcion_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Descripcion_SIM'] = &$this->Descripcion_SIM;

		// Reg_Venta_Movi
		$this->Reg_Venta_Movi = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Reg_Venta_Movi', 'Reg_Venta_Movi', '`Reg_Venta_Movi`', '`Reg_Venta_Movi`', 200, -1, FALSE, '`Reg_Venta_Movi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Reg_Venta_Movi'] = &$this->Reg_Venta_Movi;

		// Monto_Recarga_Movi
		$this->Monto_Recarga_Movi = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Monto_Recarga_Movi', 'Monto_Recarga_Movi', '`Monto_Recarga_Movi`', '`Monto_Recarga_Movi`', 131, -1, FALSE, '`Monto_Recarga_Movi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Monto_Recarga_Movi->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Monto_Recarga_Movi'] = &$this->Monto_Recarga_Movi;

		// Folio_Recarga_Movi
		$this->Folio_Recarga_Movi = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Folio_Recarga_Movi', 'Folio_Recarga_Movi', '`Folio_Recarga_Movi`', '`Folio_Recarga_Movi`', 200, -1, FALSE, '`Folio_Recarga_Movi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Folio_Recarga_Movi'] = &$this->Folio_Recarga_Movi;

		// ImprimirNotaVenta
		$this->ImprimirNotaVenta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_ImprimirNotaVenta', 'ImprimirNotaVenta', '`ImprimirNotaVenta`', '`ImprimirNotaVenta`', 202, -1, FALSE, '`ImprimirNotaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['ImprimirNotaVenta'] = &$this->ImprimirNotaVenta;

		// Serie_NotaVenta
		$this->Serie_NotaVenta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Serie_NotaVenta', 'Serie_NotaVenta', '`Serie_NotaVenta`', '`Serie_NotaVenta`', 200, -1, FALSE, '`Serie_NotaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Serie_NotaVenta'] = &$this->Serie_NotaVenta;

		// Numero_NotaVenta
		$this->Numero_NotaVenta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Numero_NotaVenta', 'Numero_NotaVenta', '`Numero_NotaVenta`', '`Numero_NotaVenta`', 200, -1, FALSE, '`Numero_NotaVenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Numero_NotaVenta'] = &$this->Numero_NotaVenta;

		// Imprimirpapeleta
		$this->Imprimirpapeleta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Imprimirpapeleta', 'Imprimirpapeleta', '`Imprimirpapeleta`', '`Imprimirpapeleta`', 202, -1, FALSE, '`Imprimirpapeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Imprimirpapeleta'] = &$this->Imprimirpapeleta;

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_FolioImpresoPapeleta', 'FolioImpresoPapeleta', '`FolioImpresoPapeleta`', '`FolioImpresoPapeleta`', 200, -1, FALSE, '`FolioImpresoPapeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FolioImpresoPapeleta'] = &$this->FolioImpresoPapeleta;

		// Maneja_Papeleta
		$this->Maneja_Papeleta = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Maneja_Papeleta', 'Maneja_Papeleta', '`Maneja_Papeleta`', '`Maneja_Papeleta`', 202, -1, FALSE, '`Maneja_Papeleta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Maneja_Papeleta'] = &$this->Maneja_Papeleta;

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Maneja_Activacion_Movi', 'Maneja_Activacion_Movi', '`Maneja_Activacion_Movi`', '`Maneja_Activacion_Movi`', 202, -1, FALSE, '`Maneja_Activacion_Movi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Maneja_Activacion_Movi'] = &$this->Maneja_Activacion_Movi;

		// Con_SIM
		$this->Con_SIM = new cField('cap_imprimir_docs_amigokit', 'cap_imprimir_docs_amigokit', 'x_Con_SIM', 'Con_SIM', '`Con_SIM`', '`Con_SIM`', 202, -1, FALSE, '`Con_SIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Con_SIM'] = &$this->Con_SIM;
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
		return "`cap_imprimir_docs_amigokit`";
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
	var $UpdateTable = "`cap_imprimir_docs_amigokit`";

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
			return "cap_imprimir_docs_amigokitlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cap_imprimir_docs_amigokitlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("cap_imprimir_docs_amigokitview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "cap_imprimir_docs_amigokitadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("cap_imprimir_docs_amigokitedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("cap_imprimir_docs_amigokitadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cap_imprimir_docs_amigokitdelete.php", $this->UrlParm());
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
		$this->FechaVenta->setDbValue($rs->fields('FechaVenta'));
		$this->Id_Tienda->setDbValue($rs->fields('Id_Tienda'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Cliente->setDbValue($rs->fields('Id_Cliente'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Descripcion_SIM->setDbValue($rs->fields('Descripcion_SIM'));
		$this->Reg_Venta_Movi->setDbValue($rs->fields('Reg_Venta_Movi'));
		$this->Monto_Recarga_Movi->setDbValue($rs->fields('Monto_Recarga_Movi'));
		$this->Folio_Recarga_Movi->setDbValue($rs->fields('Folio_Recarga_Movi'));
		$this->ImprimirNotaVenta->setDbValue($rs->fields('ImprimirNotaVenta'));
		$this->Serie_NotaVenta->setDbValue($rs->fields('Serie_NotaVenta'));
		$this->Numero_NotaVenta->setDbValue($rs->fields('Numero_NotaVenta'));
		$this->Imprimirpapeleta->setDbValue($rs->fields('Imprimirpapeleta'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
		$this->Con_SIM->setDbValue($rs->fields('Con_SIM'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Venta_Eq
		// FechaVenta
		// Id_Tienda
		// Id_Tel_SIM
		// Id_Cliente
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Descripcion_SIM
		// Reg_Venta_Movi
		// Monto_Recarga_Movi
		// Folio_Recarga_Movi
		// ImprimirNotaVenta
		// Serie_NotaVenta
		// Numero_NotaVenta
		// Imprimirpapeleta
		// FolioImpresoPapeleta
		// Maneja_Papeleta
		// Maneja_Activacion_Movi
		// Con_SIM
		// Id_Venta_Eq

		$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
		$this->Id_Venta_Eq->ViewCustomAttributes = "";

		// FechaVenta
		$this->FechaVenta->ViewValue = $this->FechaVenta->CurrentValue;
		$this->FechaVenta->ViewValue = ew_FormatDateTime($this->FechaVenta->ViewValue, 7);
		$this->FechaVenta->ViewCustomAttributes = "";

		// Id_Tienda
		if (strval($this->Id_Tienda->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Tienda->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Almacen`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tienda->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Id_Tienda->ViewValue = $this->Id_Tienda->CurrentValue;
			}
		} else {
			$this->Id_Tienda->ViewValue = NULL;
		}
		$this->Id_Tienda->ViewCustomAttributes = "";

		// Id_Tel_SIM
		if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Tel_SIM`, `Articulo` AS `DispFld`, `Acabado_eq` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_disp_equipo_imprimir_docs_amigo_kit`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Id_Cliente
		if (strval($this->Id_Cliente->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cliente`" . ew_SearchString("=", $this->Id_Cliente->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Cliente`, `Nombre_Completo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_clientes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Cliente->ViewValue = strtoupper($rswrk->fields('DispFld'));
				$rswrk->Close();
			} else {
				$this->Id_Cliente->ViewValue = $this->Id_Cliente->CurrentValue;
			}
		} else {
			$this->Id_Cliente->ViewValue = NULL;
		}
		$this->Id_Cliente->ViewCustomAttributes = "";

		// Num_IMEI
		$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
		$this->Num_IMEI->ViewCustomAttributes = "";

		// Num_ICCID
		$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
		$this->Num_ICCID->ViewCustomAttributes = "";

		// Num_CEL
		$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
		$this->Num_CEL->ViewCustomAttributes = "";

		// Descripcion_SIM
		$this->Descripcion_SIM->ViewValue = $this->Descripcion_SIM->CurrentValue;
		$this->Descripcion_SIM->ViewCustomAttributes = "";

		// Reg_Venta_Movi
		$this->Reg_Venta_Movi->ViewValue = $this->Reg_Venta_Movi->CurrentValue;
		$this->Reg_Venta_Movi->ViewCustomAttributes = "";

		// Monto_Recarga_Movi
		$this->Monto_Recarga_Movi->ViewValue = $this->Monto_Recarga_Movi->CurrentValue;
		$this->Monto_Recarga_Movi->ViewValue = ew_FormatCurrency($this->Monto_Recarga_Movi->ViewValue, 2, -2, -2, -2);
		$this->Monto_Recarga_Movi->ViewCustomAttributes = "";

		// Folio_Recarga_Movi
		$this->Folio_Recarga_Movi->ViewValue = $this->Folio_Recarga_Movi->CurrentValue;
		$this->Folio_Recarga_Movi->ViewCustomAttributes = "";

		// ImprimirNotaVenta
		if (strval($this->ImprimirNotaVenta->CurrentValue) <> "") {
			switch ($this->ImprimirNotaVenta->CurrentValue) {
				case $this->ImprimirNotaVenta->FldTagValue(1):
					$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(1) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(1) : $this->ImprimirNotaVenta->CurrentValue;
					break;
				case $this->ImprimirNotaVenta->FldTagValue(2):
					$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->FldTagCaption(2) <> "" ? $this->ImprimirNotaVenta->FldTagCaption(2) : $this->ImprimirNotaVenta->CurrentValue;
					break;
				default:
					$this->ImprimirNotaVenta->ViewValue = $this->ImprimirNotaVenta->CurrentValue;
			}
		} else {
			$this->ImprimirNotaVenta->ViewValue = NULL;
		}
		$this->ImprimirNotaVenta->ViewCustomAttributes = "";

		// Serie_NotaVenta
		$this->Serie_NotaVenta->ViewValue = $this->Serie_NotaVenta->CurrentValue;
		$this->Serie_NotaVenta->ViewCustomAttributes = "";

		// Numero_NotaVenta
		$this->Numero_NotaVenta->ViewValue = $this->Numero_NotaVenta->CurrentValue;
		$this->Numero_NotaVenta->ViewCustomAttributes = "";

		// Imprimirpapeleta
		if (strval($this->Imprimirpapeleta->CurrentValue) <> "") {
			switch ($this->Imprimirpapeleta->CurrentValue) {
				case $this->Imprimirpapeleta->FldTagValue(1):
					$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(1) <> "" ? $this->Imprimirpapeleta->FldTagCaption(1) : $this->Imprimirpapeleta->CurrentValue;
					break;
				case $this->Imprimirpapeleta->FldTagValue(2):
					$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->FldTagCaption(2) <> "" ? $this->Imprimirpapeleta->FldTagCaption(2) : $this->Imprimirpapeleta->CurrentValue;
					break;
				default:
					$this->Imprimirpapeleta->ViewValue = $this->Imprimirpapeleta->CurrentValue;
			}
		} else {
			$this->Imprimirpapeleta->ViewValue = NULL;
		}
		$this->Imprimirpapeleta->ViewCustomAttributes = "";

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
		$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

		// Maneja_Papeleta
		$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->CurrentValue;
		$this->Maneja_Papeleta->ViewCustomAttributes = "";

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
		$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

		// Con_SIM
		$this->Con_SIM->ViewValue = $this->Con_SIM->CurrentValue;
		$this->Con_SIM->ViewCustomAttributes = "";

		// Id_Venta_Eq
		$this->Id_Venta_Eq->LinkCustomAttributes = "";
		$this->Id_Venta_Eq->HrefValue = "";
		$this->Id_Venta_Eq->TooltipValue = "";

		// FechaVenta
		$this->FechaVenta->LinkCustomAttributes = "";
		$this->FechaVenta->HrefValue = "";
		$this->FechaVenta->TooltipValue = "";

		// Id_Tienda
		$this->Id_Tienda->LinkCustomAttributes = "";
		$this->Id_Tienda->HrefValue = "";
		$this->Id_Tienda->TooltipValue = "";

		// Id_Tel_SIM
		$this->Id_Tel_SIM->LinkCustomAttributes = "";
		$this->Id_Tel_SIM->HrefValue = "";
		$this->Id_Tel_SIM->TooltipValue = "";

		// Id_Cliente
		$this->Id_Cliente->LinkCustomAttributes = "";
		$this->Id_Cliente->HrefValue = "";
		$this->Id_Cliente->TooltipValue = "";

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

		// Descripcion_SIM
		$this->Descripcion_SIM->LinkCustomAttributes = "";
		$this->Descripcion_SIM->HrefValue = "";
		$this->Descripcion_SIM->TooltipValue = "";

		// Reg_Venta_Movi
		$this->Reg_Venta_Movi->LinkCustomAttributes = "";
		$this->Reg_Venta_Movi->HrefValue = "";
		$this->Reg_Venta_Movi->TooltipValue = "";

		// Monto_Recarga_Movi
		$this->Monto_Recarga_Movi->LinkCustomAttributes = "";
		$this->Monto_Recarga_Movi->HrefValue = "";
		$this->Monto_Recarga_Movi->TooltipValue = "";

		// Folio_Recarga_Movi
		$this->Folio_Recarga_Movi->LinkCustomAttributes = "";
		$this->Folio_Recarga_Movi->HrefValue = "";
		$this->Folio_Recarga_Movi->TooltipValue = "";

		// ImprimirNotaVenta
		$this->ImprimirNotaVenta->LinkCustomAttributes = "";
		$this->ImprimirNotaVenta->HrefValue = "";
		$this->ImprimirNotaVenta->TooltipValue = "";

		// Serie_NotaVenta
		$this->Serie_NotaVenta->LinkCustomAttributes = "";
		$this->Serie_NotaVenta->HrefValue = "";
		$this->Serie_NotaVenta->TooltipValue = "";

		// Numero_NotaVenta
		$this->Numero_NotaVenta->LinkCustomAttributes = "";
		$this->Numero_NotaVenta->HrefValue = "";
		$this->Numero_NotaVenta->TooltipValue = "";

		// Imprimirpapeleta
		$this->Imprimirpapeleta->LinkCustomAttributes = "";
		$this->Imprimirpapeleta->HrefValue = "";
		$this->Imprimirpapeleta->TooltipValue = "";

		// FolioImpresoPapeleta
		$this->FolioImpresoPapeleta->LinkCustomAttributes = "";
		$this->FolioImpresoPapeleta->HrefValue = "";
		$this->FolioImpresoPapeleta->TooltipValue = "";

		// Maneja_Papeleta
		$this->Maneja_Papeleta->LinkCustomAttributes = "";
		$this->Maneja_Papeleta->HrefValue = "";
		$this->Maneja_Papeleta->TooltipValue = "";

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->LinkCustomAttributes = "";
		$this->Maneja_Activacion_Movi->HrefValue = "";
		$this->Maneja_Activacion_Movi->TooltipValue = "";

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
				if ($this->FechaVenta->Exportable) $Doc->ExportCaption($this->FechaVenta);
				if ($this->Id_Tienda->Exportable) $Doc->ExportCaption($this->Id_Tienda);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Cliente->Exportable) $Doc->ExportCaption($this->Id_Cliente);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Descripcion_SIM->Exportable) $Doc->ExportCaption($this->Descripcion_SIM);
				if ($this->Reg_Venta_Movi->Exportable) $Doc->ExportCaption($this->Reg_Venta_Movi);
				if ($this->Monto_Recarga_Movi->Exportable) $Doc->ExportCaption($this->Monto_Recarga_Movi);
				if ($this->Folio_Recarga_Movi->Exportable) $Doc->ExportCaption($this->Folio_Recarga_Movi);
				if ($this->ImprimirNotaVenta->Exportable) $Doc->ExportCaption($this->ImprimirNotaVenta);
				if ($this->Serie_NotaVenta->Exportable) $Doc->ExportCaption($this->Serie_NotaVenta);
				if ($this->Numero_NotaVenta->Exportable) $Doc->ExportCaption($this->Numero_NotaVenta);
				if ($this->Imprimirpapeleta->Exportable) $Doc->ExportCaption($this->Imprimirpapeleta);
				if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportCaption($this->FolioImpresoPapeleta);
				if ($this->Maneja_Papeleta->Exportable) $Doc->ExportCaption($this->Maneja_Papeleta);
				if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportCaption($this->Maneja_Activacion_Movi);
				if ($this->Con_SIM->Exportable) $Doc->ExportCaption($this->Con_SIM);
			} else {
				if ($this->Id_Venta_Eq->Exportable) $Doc->ExportCaption($this->Id_Venta_Eq);
				if ($this->FechaVenta->Exportable) $Doc->ExportCaption($this->FechaVenta);
				if ($this->Id_Tienda->Exportable) $Doc->ExportCaption($this->Id_Tienda);
				if ($this->Id_Tel_SIM->Exportable) $Doc->ExportCaption($this->Id_Tel_SIM);
				if ($this->Id_Cliente->Exportable) $Doc->ExportCaption($this->Id_Cliente);
				if ($this->Num_IMEI->Exportable) $Doc->ExportCaption($this->Num_IMEI);
				if ($this->Num_ICCID->Exportable) $Doc->ExportCaption($this->Num_ICCID);
				if ($this->Num_CEL->Exportable) $Doc->ExportCaption($this->Num_CEL);
				if ($this->Descripcion_SIM->Exportable) $Doc->ExportCaption($this->Descripcion_SIM);
				if ($this->Reg_Venta_Movi->Exportable) $Doc->ExportCaption($this->Reg_Venta_Movi);
				if ($this->Monto_Recarga_Movi->Exportable) $Doc->ExportCaption($this->Monto_Recarga_Movi);
				if ($this->Folio_Recarga_Movi->Exportable) $Doc->ExportCaption($this->Folio_Recarga_Movi);
				if ($this->ImprimirNotaVenta->Exportable) $Doc->ExportCaption($this->ImprimirNotaVenta);
				if ($this->Serie_NotaVenta->Exportable) $Doc->ExportCaption($this->Serie_NotaVenta);
				if ($this->Numero_NotaVenta->Exportable) $Doc->ExportCaption($this->Numero_NotaVenta);
				if ($this->Imprimirpapeleta->Exportable) $Doc->ExportCaption($this->Imprimirpapeleta);
				if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportCaption($this->FolioImpresoPapeleta);
				if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportCaption($this->Maneja_Activacion_Movi);
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
					if ($this->FechaVenta->Exportable) $Doc->ExportField($this->FechaVenta);
					if ($this->Id_Tienda->Exportable) $Doc->ExportField($this->Id_Tienda);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Cliente->Exportable) $Doc->ExportField($this->Id_Cliente);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Descripcion_SIM->Exportable) $Doc->ExportField($this->Descripcion_SIM);
					if ($this->Reg_Venta_Movi->Exportable) $Doc->ExportField($this->Reg_Venta_Movi);
					if ($this->Monto_Recarga_Movi->Exportable) $Doc->ExportField($this->Monto_Recarga_Movi);
					if ($this->Folio_Recarga_Movi->Exportable) $Doc->ExportField($this->Folio_Recarga_Movi);
					if ($this->ImprimirNotaVenta->Exportable) $Doc->ExportField($this->ImprimirNotaVenta);
					if ($this->Serie_NotaVenta->Exportable) $Doc->ExportField($this->Serie_NotaVenta);
					if ($this->Numero_NotaVenta->Exportable) $Doc->ExportField($this->Numero_NotaVenta);
					if ($this->Imprimirpapeleta->Exportable) $Doc->ExportField($this->Imprimirpapeleta);
					if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportField($this->FolioImpresoPapeleta);
					if ($this->Maneja_Papeleta->Exportable) $Doc->ExportField($this->Maneja_Papeleta);
					if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportField($this->Maneja_Activacion_Movi);
					if ($this->Con_SIM->Exportable) $Doc->ExportField($this->Con_SIM);
				} else {
					if ($this->Id_Venta_Eq->Exportable) $Doc->ExportField($this->Id_Venta_Eq);
					if ($this->FechaVenta->Exportable) $Doc->ExportField($this->FechaVenta);
					if ($this->Id_Tienda->Exportable) $Doc->ExportField($this->Id_Tienda);
					if ($this->Id_Tel_SIM->Exportable) $Doc->ExportField($this->Id_Tel_SIM);
					if ($this->Id_Cliente->Exportable) $Doc->ExportField($this->Id_Cliente);
					if ($this->Num_IMEI->Exportable) $Doc->ExportField($this->Num_IMEI);
					if ($this->Num_ICCID->Exportable) $Doc->ExportField($this->Num_ICCID);
					if ($this->Num_CEL->Exportable) $Doc->ExportField($this->Num_CEL);
					if ($this->Descripcion_SIM->Exportable) $Doc->ExportField($this->Descripcion_SIM);
					if ($this->Reg_Venta_Movi->Exportable) $Doc->ExportField($this->Reg_Venta_Movi);
					if ($this->Monto_Recarga_Movi->Exportable) $Doc->ExportField($this->Monto_Recarga_Movi);
					if ($this->Folio_Recarga_Movi->Exportable) $Doc->ExportField($this->Folio_Recarga_Movi);
					if ($this->ImprimirNotaVenta->Exportable) $Doc->ExportField($this->ImprimirNotaVenta);
					if ($this->Serie_NotaVenta->Exportable) $Doc->ExportField($this->Serie_NotaVenta);
					if ($this->Numero_NotaVenta->Exportable) $Doc->ExportField($this->Numero_NotaVenta);
					if ($this->Imprimirpapeleta->Exportable) $Doc->ExportField($this->Imprimirpapeleta);
					if ($this->FolioImpresoPapeleta->Exportable) $Doc->ExportField($this->FolioImpresoPapeleta);
					if ($this->Maneja_Activacion_Movi->Exportable) $Doc->ExportField($this->Maneja_Activacion_Movi);
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

	 //  Vamos a actualizar el Status de la papeleta 
	 if ($rsnew['Imprimirpapeleta']=='SI') { 
	   DB_Ejecuta("UPDATE doc_venta_eq SET StatusPapeleta='Por Validar' WHERE Id_Venta_Eq=".$rsold['Id_Venta_Eq']);
	 } else {                                                                                                 

	   //  OJO... fala verificar esta instruccion
	   DB_Ejecuta("UPDATE doc_venta_eq SET FolioImpresoPapeleta=NULL WHERE FolioImpresoPapeleta=0");
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
