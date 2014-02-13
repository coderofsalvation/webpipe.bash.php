<?

// the index.php in the root always displays all available webpipe-urls

$rooturl  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
// trailing space to not lose POST-data because of apache 301 redirect
$trail    = strstr( $_SERVER['HTTP_HOST'], "appspot" ) ? "" : "/";
$webpipes = array();
$files = scandir( dirname(__FILE__) );
foreach ($files as $file) {
    if ($file === '.' or $file === '..' or $file === '.git' ) continue;
    if (is_dir($file)) $webpipes[]= $rooturl.$file.$trail;
}
printf("%s", implode("\n",$webpipes) );

?>
