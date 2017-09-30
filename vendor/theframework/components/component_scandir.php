<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentScandir
 * @file component_scandir.php
 * @version 1.2.1
 * @date 30-09-2017 12:06
 * @observations
 * Flamagas devuelve todos los archivos .XNT que nos han pasado
 */
namespace TheFramework\Components;

class ComponentScandir 
{
    private $sPathRoot;
    private $arPaths;
    private $arFiles;
    private $sPrivToken;

    public function __construct($sToken=NULL) 
    {
        $this->sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->arPaths = [
            $this->sPathRoot."/data/private",
            $this->sPathRoot."/data/public",
        ];
        
        //$this->arFiles = ["private"=>[],"public"=>[]];
        $this->arFiles = [];
        $this->sPrivToken = $sToken;
    }
    
    private function is_tokenok()
    {
        $sTokenFile = $this->sPathRoot."/data/private/token.key";
        if(!is_file($sTokenFile))
            return FALSE;
        $sToken = file_get_contents($sTokenFile);
        $sToken = json_decode($sToken);
        $sToken = (isset($sToken[0]["token"])?$sToken[0]["token"]:"");
        pr("key:$sToken,gettoken=$this->sPrivToken");
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
            $sReplace = str_replace($str,"",$sReplace);
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
        //si no se ha proporcionado el token correcto se eliminan los archivos privados 
        //del listado.
        if(!$this->is_tokenok())
            unset($this->arFiles["private"]);
        
        return $this->arFiles;
    }//get_files
    
    public function run()
    {
        $arFiles = $this->get_files();
        //pr($arFiles);
        return $arFiles;
    }
    
}//ComponentScandir