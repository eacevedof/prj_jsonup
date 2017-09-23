<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentFilecontent
 * @file component_filecontent.php
 * @version 1.0.0
 * @date 23-09-2017 16:05
 * @observations
 * Flamagas 
 */
namespace TheFramework\Components;

class ComponentFilecontent 
{
    private $sGetFile;
    private $sPahFolder;
    private $arHeaders;

    public function __construct() 
    {
        $sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->sPahFolder = $sPathRoot."/data";
        $this->sGetFile = (isset($_GET["getfile"])?$_GET["getfile"]:"");
        
        //headers por defecto
        $this->arHeaders["Content-Type"]="application/json";
        $this->arHeaders["Access-Control-Allow-Origin"]="*";
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
    
    private function is_file()
    {
        //comprobar si es solo json o csv
        if($this->in_string([".json",".csv"],$this->sGetFile))
            if($this->sGetFile)
            {
                $sPathFile = $this->sPahFolder."/$this->sGetFile";
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