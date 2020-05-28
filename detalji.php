<?php
include_once 'funkcije.php';
$filter = new Filter();
$ime = $_REQUEST["ime"];
$queryResult = $filter->upit();
$resp = 0;

foreach($queryResult as $element) {
    if($element->getElementsByTagName('ime')->item(0)->nodeValue == $ime){
        $resp = " " . $element->getElementsByTagname('ime')->item(0)->nodeValue . '</br>'
        . " " . $element->getElementsByTagname('drzava')->item(0)->nodeValue . '</br>'
        . " " . $element->getElementsByTagname('regija')->item(0)->nodeValue . '</br>';
        $znamenitosti = $element->getElementsByTagName('znamenitost');
        for ($i = 0; $i <$znamenitosti->length; $i++) {
                $resp = $resp . " " . $element->getElementsByTagName('znamenitost')->item($i)->nodeValue . '</br>';
              } 
    }
}

?>
<html>
<?php echo $resp; ?>
</html>