<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentScandir
 * @file component_scandir.php
 * @version 1.0.1
 * @date 27-07-2017 12:06
 * @observations
 * Flamagas devuelve todos los archivos .XNT que nos han pasado
 */
namespace TheFramework\Components;

class ComponentScandir 
{
    private $arPaths;
    private $arFiles;

    public function __construct() 
    {
        $sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->arPaths = [
            $sPathRoot."/data",
        ];
        
        $this->arFiles = [];
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
    
    private function get_files()
    {
        foreach($this->arPaths as $sPath)
        {
            $arFiles = scandir($sPath);
            $sPath = explode("/",$sPath);
            $sPath = end($sPath);
            foreach($arFiles as $sFileName)
            {
                if($this->in_string([".json",".csv"],$sFileName))
                    $this->arFiles[$sPath][] = $sFileName;
            }
            asort($this->arFiles[$sPath]);
        }
        return $this->arFiles;
    }
    
    public function run()
    {
        $arFiles = $this->get_files();
        //pr($arFiles);
        return $arFiles;
    }
    
}//ComponentScandir