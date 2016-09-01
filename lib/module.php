<?php
session_start();
include_once 'base.php';
class Module extends PCGDb
{

    public $objDB = null;
    public $PostStatus=array(
        '0'=>'Rejected',
        '1'=>'Running',
        '2'=>'Closed',
        '3'=>'Won'
        
    );
    public $PostStatusColor=array(
        '0'=>'red',
        '1'=>'green',
        '2'=>'red',
        '3'=>'green'
    );
    
    public $arrWinStatus = array('0'=>'Running','1'=>'Awarded','2'=>'Completed','3'=>'Not Awarded','4'=>'Mark as done');
    public $arrWinStatusColor = array('0'=>'green','1'=>'green','2'=>'green','3'=>'red','4'=>'green');
    
    public $arrMessage=array(
        '1'=> "has bidded on your job",
        '2'=>"has sent you a message for the job",
        '3'=>"has updated bid for your job",
        '4'=>"has accepted your bid for the job",
        '5'=>"has rejected your bid for the job",
        '6'=>"has accepted milestone for the job",
        '7'=>"has rejected milestone for the job",
        '8'=>"has added new milestone for job",
        '9'=>"has added review for the job",
        '10'=>"Your milestone <milestone name> for job <job name> is running over due"
    );

    function __consturct($strHost = '', $strDB = '', $strUser = '', $strPass = '')
    {
        parent::__construct($strHost, $strDB, $strUser, $strPass);
    }

    function getRequest($strKey, $strDefault = '', $strGlobal = 'REQUEST')
    {
        switch (strtoupper(trim($strGlobal)))
        {
            case 'REQUEST':
                if (isset($_REQUEST[$strKey]))
                {
                    return trim($_REQUEST[$strKey]);
                }
                else
                {
                    return $strDefault;
                }
                break;
            case 'POST':
                if (isset($_POST[$strKey]))
                {
                    return trim($_POST[$strKey]);
                }
                else
                {
                    return $strDefault;
                }
                break;
            case 'GET':
                if (isset($_GET[$strKey]))
                {
                    return trim($_GET[$strKey]);
                }
                else
                {
                    return $strDefault;
                }
                break;
            default: return $strDefault;
        }
    }

    function setSession($strKey, $strValue)
    {
        $_SESSION[session_id() . '_admin'][$strKey] = $strValue;
    }

    function resetSession($strKey)
    {
        if (isset($_SESSION[session_id() . '_admin']))
            unset($_SESSION[session_id() . '_admin'][$strKey]);
    }

    function getSession($strKey, $strDefault = '')
    {
        if (isset($_SESSION[session_id() . '_admin'][$strKey]))
        {
            return $_SESSION[session_id() . '_admin'][$strKey];
        }
        else
        {
            return $strDefault;
        }
    }

    function getConfig($strFlag)
    {
        if (isset($_SESSION[session_id() . '_CONFIG'][$strFlag]))
        {
            return $_SESSION[session_id() . '_CONFIG'][$strFlag];
        }
        return '';
    }

    function getEditData(&$arrEditData, $strKey)
    {
        if (trim($strKey) != '' && isset($arrEditData[$strKey]))
        {
            return stripslashes(htmlspecialchars($arrEditData[$strKey]));
        }
        return '';
    }

    /**
     * @param type $strMsg
     * @param type $strType (success/error/danger/info)
     * 
     */
    function setMessage($strMsg, $strType = "sucess")
    {
        if (trim($strMsg) != '')
        {
            $_SESSION[session_id() . '_admin']["system_message"] = $strMsg;
            $_SESSION[session_id() . '_admin']["system_message_type"] = $strType;
        }
    }

    function getMessage()
    {
        if (isset($_SESSION[session_id() . '_admin']["system_message"]) && $_SESSION[session_id() . '_admin']["system_message"] != ''):

            $strHtml = "<div class='alert alert-" . $_SESSION[session_id() . '_admin']['system_message_type'] . "'>";
            //$strHtml .="<button data-dismiss='alert' type='button' class='close'></button>";
            $strHtml .=$_SESSION[session_id() . '_admin']['system_message'];
            $strHtml .='<span></span>';
            $strHtml .="</div>";
            unset($_SESSION[session_id() . '_admin']['system_message']);
            unset($_SESSION[session_id() . '_admin']['system_message_type']);
            return $strHtml;
        endif;
        return '';
    }

    function redirect($strPath)
    {
        if (!headers_sent()):
            header("location: " . $strPath);
            exit;
        else:
            echo "<script type='text/javascript'>window.location.href='" . $strPath . "'</script>";
            exit;
        endif;
    }

    function getCountry()
    {
        return $this->getAll("select * from tbl_country ORDER BY Name asc");
    }

    function getCategory()
    {
        return $this->getAll("SELECT * FROM tbl_category ORDER BY name ASC");
    }

    function timeDiff($strDate1, $strDate2)
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
            return date("M d Y",  strtotime($strDate1));
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

    function timeLeft($strDate1, $strDate2)
    {
        $dateF = new DateTime($strDate1);
        $dateL = new DateTime($strDate2);
        $interval = $dateF->diff($dateL);
        $years = $interval->y;
        $days = $interval->d;
        $hours = $interval->h;
        $mins = $interval->i;
        $sec = $interval->s;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $weeks = floor($diff / 604800);
        $str = '';
        if ($days > 0)
        {
            $str = $days . " d ";
        }
        if ($hours > 0)
        {
            $str .=$hours . ' h';
        }

        return $str;
    }

    function getClass($strEx = '')
    {
        if ($strEx != '')
        {
            $arrEx = array(
                'doc' => 'jp-word',
                'docx' => 'jp-word',
                'txt' => 'jp-text',
                'pdf' => 'jp-pdf',
                'xls' => 'jp-xls',
                'xlsx' => 'jp-xls',
                'jpg' => 'jp-img',
                'jpeg' => 'jp-img',
                'png' => 'jp-img'
            );
            return $arrEx[$strEx];
        }
        return '';
    }

    function getName($table, $column1, $field1, $field2)
    {
        if ($field1 != '' && $field2 != '')
        {
            $strTableName   =   $table;
            $arrFields      =   array($column1);
            $strWhere       =   " ".$field1." = '".$field2."'  ";
            $arrResult      = $this->getAll($strTableName,$arrFields,$strWhere);
            return $arrResult;
        }
    }
    function getShortDescription($strString='')
    {
        $strNew='';
        if($strString!='')
        {
            $strLen = strlen($strString);
            if($strLen>500)
            {
                $strNew = substr($strString, 0, 500)."...";
            }
            else
            {
                $strNew =  $strString;
            }
            return stripslashes($strNew);
        }
        return '';
    }
    function roundDownToHalf($n) 
    {
        return number_format(floatval(intval($n)+((($n*10)%10)>=5?.5:0)),1,'.','');
    }
    

}

$objModule = new Module();
?>
