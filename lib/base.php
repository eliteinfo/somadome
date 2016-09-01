<?php
error_reporting(0);
date_default_timezone_set('Asia/Calcutta');

class PCGDb extends PDO{
    private $strDriver          =   'mysql';
    private $strHost            =   'localhost';
	private $strDB              =   'somadome';  //server db
	private $strUser            =   'somauser';   //server user
	private $strPass            =   'y^##fLxd]P04';       //server pw
	//private $strDB              =   'somadome';             //local db
	//private $strUser            =   'root';                 //local user
	//private $strPass            =   '';                     //local pw
    public $strWhere            =   '';
    public $strAction           =   '';
    public $strSQL              =   '';
    public $strGroupBy          =   '';
    public $strOrderBy          =   '';
    public $strLimit            =   '';
    public  $intLastInsertedId  =   '';
    public $intTotalRows        =   '';
    protected $strTableName     =   '';
    protected $arrFields        =   array();
    protected $objDB            =   null;
    protected $objUsDB          =   null;
    protected $arrFieldValues   =   array();  
	public $SITEURL             =   "http://www.aurosys.co/Somadome_New/";
	public $ADMIN		=   "http://www.aurosys.co/Somadome_New/admin/";
	public $root		=   "http://www.aurosys.co/Somadome_New/";
    //public $INFO_MAIL = "info@somadome.com";
	public $INFO_MAIL = "donotreply@somadome.com";
    function __construct($strHost='', $strDB='', $strUser='', $strPass='')
    {
        try{
            if($strHost != ''){$this->strHost = $strHost;}
            if($strDB != ''){$this->strDB = $strDB;}
            if($strUser != ''){$this->strUser = $strUser;}
            if($strPass != ''){$this->strPass = $strPass;}
            $this->objDB        =   new PDO("mysql:host=".$this->strHost.";dbname=".$this->strDB,$this->strUser, $this->strPass, array( PDO::ATTR_PERSISTENT => false));
            if($this->objDB)
            {
                return $this->objDB;
            }
            else
            {
                echo "Database Connection Failed.";die;
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
	function timeDiff2($strDate1, $strDate2)
	{
		$dateF = new DateTime($strDate1);
		$dateL = new DateTime($strDate2);
		$interval = $dateF->diff($dateL);
		$years = $interval->y;
		$days = $interval->d;
		$hours = $interval->h;
		$mins = $interval->i;
		$sec = $interval->s;
		$diff = abs(strtotime($strDate1) - strtotime($strDate2));
		$weeks = floor($diff / 604800);
		$str = '';
		if ($days > 0)
		{
			return date("M d Y",  strtotime($strDate2));
		}
		else
		{
			if ($hours > 0)
			{
				$str = $this->chk_gtr2($hours, 'hr');
			}
			if ($mins > 0)
			{
				$str .='&nbsp;' . $this->chk_gtr2($mins, 'minute');
			}
			if($mins==0)
			{
				$str .='&nbsp;' .'0'. ' ' .'minute';
			}
			return $str . ' &nbsp; ago';
		}
	}
	
	function chk_gtr2($count, $attr)
    {
        if ($count > 1)
        {
            return $count . ' ' . $attr . 's';
        }
        else
        {
            return $count . ' ' . $attr;
        }
    }
    function getAll($strSQL, $arrFields=array(), $strWhere='', $strGroupBy='', $strOrderBy='', $intStart='', $intNum='')
    {
        try
        {
            $this->strAction    =   'SELECT';
            if(is_array($arrFields) && !empty($arrFields))
            {
                $this->strTableName = $strSQL;
                $this->arrFields    =   $arrFields;
                $this->setWhere($strWhere);
                $this->setGroupBy($strGroupBy);
                $this->setOrderBy($strOrderBy);
                $this->setLimit((string)$intStart, (string)$intNum);
                $this->generateSQL();
            }
            else
            {
                $this->strSQL       =   $strSQL;
            }
            return $this->executeQuery();
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    
    function executeQuery()
    {
        try{
            if($this->strSQL != '')
            {
                
                    $objStmt = $this->objDB->prepare($this->strSQL);
                
                switch(strtoupper($this->strAction))
                {
                    case 'SELECT':
                        $objStmt->execute();
                        $arrReturn  = $objStmt->fetchAll(PDO::FETCH_ASSOC);
                        $objStmt = $this->objDB->prepare("SELECT FOUND_ROWS() as totalcount");
                        $objStmt->execute();
                        $arrTemp = $objStmt->fetch();
                        $this->intTotalRows = $arrTemp['totalcount'];
                        unset($arrTemp);unset($objStmt);
                        return $arrReturn;
                        break;
                    case 'INSERT':
                        $objStmt->execute();
                            return $this->objDB->lastInsertId();
                        break;
                    case 'UPDATE':
                        $objStmt->execute();
                            return $this->objDB->lastInsertId();
                        break;
                    case 'DELETE':
                        $objStmt->execute();
                            return $this->objDB->lastInsertId();
                        break;
                    default:
                }
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function setWhere($strWhere = '')
    {
        try{
            if($strWhere != '')
            {
                $this->strWhere =   ' WHERE '.$strWhere;
            }
            else
            {
                $this->strWhere = '';
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function setGroupBy($strGroupBy = '')
    {
        try{
            if($strGroupBy != '')
            {
                $this->strGroupBy =  ' GROUP BY '. $strGroupBy;
            }
            else
            {
                $this->strGroupBy = '';
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function setOrderBy($strOrderBy = '')
    {
        try{
            if($strOrderBy != '')
            {
                $this->strOrderBy =  ' ORDER BY '. $strOrderBy;
            }
            else
            {
                $this->strOrderBy   =   '';
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function setLimit($intStart='', $intNum='')
    {
        try{
            if($intStart != '' && $intNum != '')
            {
                $this->strLimit =   ' LIMIT '.$intStart.', '.$intNum;
            }
            else
            {
                $this->strLimit = '';
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function getSQL()
    {
        try{
            return $this->strSQL;
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function generateSQL()
    {
        try{
            $strSQL     =   '';
            switch (strtoupper($this->strAction))
            {
                case 'SELECT':
                        $strSQL = 'SELECT SQL_CALC_FOUND_ROWS '.@implode(", ", $this->arrFields);
                        if(trim($this->strTableName) != ''):
                            $strSQL .= ' FROM '.$this->strTableName;
                        endif;
                        $strSQL .=  $this->strWhere;
                        $strSQL .=  $this->strGroupBy;
                        $strSQL .=  $this->strOrderBy;
                        $strSQL .=  $this->strLimit;
                        $this->strSQL   =   $strSQL;
                    break;
                case 'UPDATE':
                        $strSQL = 'UPDATE '.$this->strTableName;
                        $arrTemp    =   array();
                        foreach($this->arrFields as $intKey=>$strValue)
                        {
                            $arrTemp[] =  $strValue.' = "'.  addslashes($this->arrFieldValues[$intKey]).'"';
                        }
                        $strSQL .=  ' SET '.@implode(", ", $arrTemp);
                        unset($arrTemp);
                        $strSQL .=  $this->strWhere;
                        $this->strSQL   =   $strSQL;
                    break;
                case 'INSERT':
                    $strSQL =   'INSERT INTO '.$this->strTableName;
                    $arrTemp    =   array();
                    foreach($this->arrFields as $intKey=>$strValue)
                    {
                        $arrTemp['field'][] =   $strValue;
                        $arrTemp['value'][] =   addslashes($this->arrFieldValues[$intKey]);
                    }
                    $strSQL .=   ' ( '.@implode(", ", $arrTemp['field']).' ) VALUES ( "'.@implode('", "', $arrTemp['value']).'" )';
                    $this->strSQL   =   $strSQL;
                    break;
				case 'DELETE':
                    $strSQL =   'DELETE FROM '.$this->strTableName;
                    $strSQL .=  $this->strWhere;
                    $this->strSQL   =   $strSQL;
                    break;
                default;
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
}
class PCGData extends PCGDb{
    
    
    private $strPrimaryKey   =   '';
    
    function __construct()
    {
        //call parent class constuctor...
        parent::__construct();
    }
    
    function setTableDetails($strTableName, $strPrimaryKey)
    {
        try{
            if($strTableName != '')
            {
                $this->strTableName =   $strTableName;
            }
            else
            {
                echo "Table Name not selected.";exit;
            }
            
            if($strPrimaryKey != '')
            {
                $this->strPrimaryKey    =   $strPrimaryKey;
                $this->arrFields        =   array();
                $this->arrFieldValues   =   array();
            }
            else
            {
                echo "Primary Key not defined.";exit;
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    
    function setFieldValues($strFieldName, $strFieldValue='')
    {
        try{
            if($strFieldName != '')
            {
                $this->arrFields[]      =   $strFieldName;
                $this->arrFieldValues[] =   $strFieldValue;
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    
    function update()
    {
        try{
            $this->strAction    =   'UPDATE';
            $this->generateSQL();
            $this->intLastInsertedId = $this->executeQuery();
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function insert()
    {
        try{
            $this->strAction    =   'INSERT';
            $this->generateSQL();
            $this->intLastInsertedId = $this->executeQuery();
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function delete()
    {
        try{
            $this->strAction    =   'DELETE';
            $this->generateSQL();
            $this->intDeletedId = $this->executeQuery();
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    function redirect ($strPath)
    {
         if(!headers_sent()):
            header("location: ".$strPath);
         exit();
        else:
            echo "<script type='text/javascript'>window.location.href='".$strPath."'</script>";
        exit();
        endif;
        exit();
    }
    function setMessage($strMsg, $strType="sucess")
    { 
        if(trim($strMsg) != '')
        {
            $_SESSION[session_id().'_admin']["system_message"] = $strMsg;
            $_SESSION[session_id().'_admin']["system_message_type"] = $strType;
        }
    }
    function getMessage()
    {
        
        if(isset($_SESSION[session_id().'_admin']["system_message"]) && $_SESSION[session_id().'_admin']["system_message"]!=''):
            
            $strHtml = "<div class='alert alert-".$_SESSION[session_id().'_admin']['system_message_type']."'>";
            //$strHtml .="<button data-dismiss='alert' type='button' class='close'></button>";
            $strHtml .=$_SESSION[session_id().'_admin']['system_message'];
            $strHtml .='<span></span>';
            $strHtml .="</div>";
            unset($_SESSION[session_id().'_admin']['system_message']);
            unset($_SESSION[session_id().'_admin']['system_message_type']);
            return $strHtml;
        endif;
        return '';
    }
	// Procedure Start
	function register_user($arrData = array())
    {
		$sql= 'CALL reg_usr(?,?,?,?,?,?,?,?,?)' ;		//	Put Placeholders for parameters.
		$statement = $this->objDB->prepare($sql) ;			//	Sanitize the statement.
		$statement->execute($arrData) ;						//	Execute Call with array of parameters.
		if($statement->rowCount() == 1)
        {
			$statement->rowCount();
			$statement->setFetchMode(PDO::FETCH_OBJ) ;
			while($row = $statement->fetch())
            {
                return $row;  
            }
        }
        else
        {
            return  0;   
        }
    }
	function verify_usr($arrData = array())
    {
        $sql= 'CALL vry_usr(?)' ;							//	Put Placeholders for parameters.
        $statement = $this->objDB->prepare($sql) ;			//	Sanitize the statement.
		$statement->execute($arrData) ;						//	Execute Call with array of parameters.
		if($statement->rowCount() == 1)
        {
			$statement->rowCount();
            $statement->setFetchMode(PDO::FETCH_OBJ) ;
			while($row = $statement->fetch())
            {
               return $row;  
            }
        }
        else
        {
            return  0;   
        }
    }
	function login_usr($arrData = array())
    { 
        $sql= 'CALL lgn_usr(?,?,?,?)' ;		//	Put Placeholders for parameters.
        $statement = $this->objDB->prepare($sql) ;			//	Sanitize the statement.
		$statement->execute($arrData) ;						//	Execute Call with array of parameters.
		if($statement->rowCount() == 1)
        {
			$statement->rowCount();
            $statement->setFetchMode(PDO::FETCH_OBJ) ;
			while( $row = $statement->fetch())
            {
               return $row;  
            }
        }
        else
        {
            return  0;   
        }
    }
	function follwuser($arrData = array())
    {  
        $sql= 'CALL follow(?,?)';										//	Put Placeholders for parameters.
        $statement = $this->objDB->prepare($sql);						//	Sanitize the statement.
        $statement->execute($arrData);									//	Execute Call with array of parameters.
        if($statement->rowCount() == 1)
        {
            $statement->setFetchMode(PDO::FETCH_OBJ);
            while( $row = $statement->fetch())
            {
              return $row;  
            }
        }
        else
        {
            return  0;   
        }
    }
	function likeImg($arrData = array())
    {  
        $sql= 'CALL likeimg(?,?,?)';										//	Put Placeholders for parameters.
        $statement = $this->objDB->prepare($sql);						//	Sanitize the statement.
        $statement->execute($arrData);									//	Execute Call with array of parameters.
        if($statement->rowCount() == 1)
        {
            $statement->setFetchMode(PDO::FETCH_OBJ);
            while($row = $statement->fetch())
            {
             	return $row;  
            }
        }
        else
        {
            return  0;   
        }
    }
	
// Procedure End
}

$objData =  new PCGData();
?>