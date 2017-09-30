<?php
//index.php 1.0.2
include("../vendor/theframework/helpers/autoload.php");
include("../vendor/theframework/components/autoload.php");
$oGetFile = new \TheFramework\Components\ComponentFilecontent();
//si viene $_GET["getfile"] y existe esto lanza headers y un exit
$oGetFile->run();

$oScandir = new \TheFramework\Components\ComponentScandir();
$arFiles = $oScandir->run();
$sDomain = $_SERVER["HTTP_HOST"];

?>
<!-- bootstrap 4 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Json provider</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());
      gtag('config', 'UA-18500857-7');
    </script>    
</head>
<body>
    <div id="root">
        <ul>
<?php
$sClassSpan = "badge-danger";
foreach($arFiles as $sFolder=>$arData):
    
    if($sFolder=="public")
        $sClassSpan = "badge-success";
    
    foreach($arData as $i=>$sFile):
        $sClass = "";
        if(strstr($sFile,".json")) $sClass="btn btn-info";
        $sUrl = "index.php?getfile=$sFile"
        
?>
            <li>
                <span class="badge <?=$sClassSpan?>"><?=$sFolder." - ".($i+1)?> </span>
                <a href="<?=$sUrl?>" target="_blank" class="<?=$sClass?>">
                    <?=$sFile?>
                </a>
                <label>
                    http://<?=$sDomain?>/<?=$sUrl?>
                </label>
            </li>
<?php
    endforeach;//foreach $arData
endforeach;//foreach arFiles
?>
        </ul>
    </div>
    <!-- bootstrap 4 -->
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>    
</body>
</html>
