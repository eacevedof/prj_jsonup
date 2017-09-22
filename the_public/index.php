<?php
include("../vendor/theframework/helpers/autoload.php");
include("../vendor/theframework/components/autoload.php");
$oScandir = new \TheFramework\Components\ComponentScandir();
$arFiles = $oScandir->run();
$sDomain = $_SERVER["HTTP_HOST"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Json provider</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-18500857-7"></script>
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
foreach($arFiles as $sFolder=>$arData):
    foreach($arData as $sFile):
        $sClass = "";
        if(strstr($sFile,".json")) $sClass="btn btn-info";
        
?>
            <li>
                <a href="/data/<?=$sFile?>" target="_blank" class="<?=$sClass?>">
                    <?=$sFile?>
                </a>
                <label>
                    http://<?=$sDomain?>/data/<?=$sFile?>
                </label>
            </li>
<?php
    endforeach;
endforeach;
?>
        </ul>
    </div>
</body>
</html>
