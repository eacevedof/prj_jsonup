<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentFilecontent
 * @file component_filecontent.php
 * @version 2.1.0
 * @date 30-09-2017 16:05
 * @observations
 * Flamagas 
 */
namespace TheFramework\Components;

class ComponentFilecontent 
{
    private $sPathRoot;
    private $sGetFile;
    private $sPahFolder;
    private $arHeaders;
    private $sPrivToken;

    public function __construct($sToken=NULL) 
    {
        $this->sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->sPrivToken = (isset($_GET["token"])?$_GET["token"]:$sToken);
        $this->sGetFile = (isset($_GET["getfile"])?$_GET["getfile"]:"");
        
        $this->sPahFolder = $this->sPathRoot."/data";
        if($this->sPrivToken)
            $this->sPahFolder.="/private";
        else
            $this->sPahFolder.="/public";
          
        //headers por defecto
        $this->arHeaders["Content-Type"]="application/json";
        $this->arHeaders["Access-Control-Allow-Origin"]="*";
    }
    
    private function is_tokenok()
    {
        $sTokenFile = $this->sPathRoot."/data/private/".APP_FILENAME_TOKEN;
        if(!is_file($sTokenFile))
            return FALSE;
        $sToken = file_get_contents($sTokenFile);
        //bug($sToken,"token 1");
        $sToken = json_decode($sToken,TRUE);
        //pr($sToken,"token 2");die;
        $sToken = (isset($sToken[0]["token"])?$sToken[0]["token"]:"");
        //pr("key:$sToken,gettoken=$this->sPrivToken");
        return ($this->sPrivToken===$sToken);
    }
    
    private function in_string($arChars=[],$sString)
    {
        foreach($arChars as $c)
            if(strstr($sString,$c))
                return TRUE;
        return FALSE;
    }
    
    private function clean($arSubstrings=[],&$sString)
    {
        $sReplace = $sString;
        foreach($arSubstrings as $str)
            $sReplace = str_replace ($str,"",$sReplace);
        $sString = $sReplace;
    }
    
    private function print_content($sPathFile)
    {
        $sContent = file_get_contents($sPathFile);
        if(!$sContent)
            $sContent = "Empty file $this->sGetFile";
        
        foreach($this->arHeaders as $sKey=>$sValue)
            header("$sKey:$sValue");
        
        s($sContent);
        exit();
    }
    
    private function dieerror($sData)
    {
        $arError = ["error"=>["number"=>"001","message"=>"wrong token!","data_received"=>$sData]];
        $sError = json_encode($arError);
        die($sError);
    }
    
    private function is_file()
    {
        //comprobar si es solo json o csv
        if($this->in_string([".json",".csv"],$this->sGetFile))
            if($this->sGetFile)
            {
                $sPathFile = $this->sPahFolder."/$this->sGetFile";
                if($this->in_string(["/private/"],$sPathFile))
                {
                    if($this->is_tokenok())
                        return $sPathFile;
                    //es archivo privado pero el token es incorrecto
                    else
                    {
                        lg("wrong token: $this->sPrivToken,uri:{$_SERVER["REQUEST_URI"]}");
                        $this->dieerror($this->sPrivToken);
                    }
                }
                return (is_file($sPathFile)?$sPathFile:FALSE);
            }
        return FALSE;
    }
    
    public function run()
    {
        $sPathFile = $this->is_file();
        if($sPathFile)
            $this->print_content($sPathFile);
    }
    
}//ComponentFilecontent