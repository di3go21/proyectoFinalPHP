<?php
$fecha=date("Y/m/d");
echo $fecha;
echo "---";
echo time();

echo "<pre>";
print_r($_SERVER);


echo date("H:i:s");

?>

<a href="<?php echo $_SERVER['REQUEST_URI']."&loco=21" ?>">asdasd</a>

