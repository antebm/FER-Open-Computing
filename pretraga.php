<?php
include_once 'funkcije.php';
$filter = new Filter();

$queryResult = $filter->upit();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dobrodošli na stranicu sa zanimljivostima o starim gradovima i civilizacijama">
  <meta name="keywords" content="grad, povijest, antika, drevni gradovi">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>
  <link rel="stylesheet" href="dizajn.css">
  <script src="detalji.js"></script> 
  <title>Drevni gradovi</title>
</head>
<body>
  <header>
    <nav id="navbar">
      <div class="container">
        <h1 class="logo"><a href="index.html">Drevni gradovi</a></h1>
        <ul>
          <li><a href="index.html">Početna</a></li>
          <li><a class="current" href="obrazac.html">Pretraga</a></li>
          <li><a href="podaci.xml">Podaci</a></li>
          <li><a href="https://www.fer.unizg.hr">FER</a></li>
          <li><a href="https://www.fer.unizg.hr/predmet/or" target="_blank">OR</a></li>
          <li><a href="mailto:ante.balaic-marmun@fer.hr">Email</a> </li>
        </ul>
      </div>
    </nav>
  </header>
  <div class="leftpanel">
 <div class="additional-info" id="details">
    <h3>Više o...</h3>
  </div>
  <div id='mapid'></div>
  </div>
  <div class="container" style="margin-left:2rem;">
        <h2>Gradovi</h2>
        <table>
            <tr class="bg-primary">
                <th>Ime</th>
                <th>Država</th>
<!--                <th>Regija</th> -->
<!--                <th>Kultura</th>
                <th>Osnovan</th>  -->
                <th>Znamenitosti</th>
                <th>Slika</th>
<!--                <th>Sažetak</th>  -->
                <th>Koordinate (Wiki)</th>
                <th>Koordinate(Nominatim)</th>
<!--                <th>Vrijeme Pristupa</th>
                <th>Novi rezultat</th>  -->
                <th>Detalji</th>
            </tr>
            <?php foreach ($queryResult as $element) {
            ?>
            <tr class="bg-light" onmouseover="promijeniBoju(this)" onmouseout="obnoviBoju(this)" >
                <td><?php echo $element->getElementsByTagname('ime')->item(0)->nodeValue; ?></td>
                <td><?php echo $element->getElementsByTagname('drzava')->item(0)->nodeValue; ?></td>
<!--                <td><?php echo $element->getElementsByTagname('regija')->item(0)->nodeValue; ?></td> -->
<!--                <td><?php echo $element->getElementsByTagname('kultura')->item(0)->nodeValue; ?></td>
                <td><?php echo $element->getElementsByTagname('osnovan')->item(0)->nodeValue; ?></td> -->
                <td> <?php 
                    $znamenitosti = $element->getElementsByTagName('znamenitost');
                    for ($i = 0; $i <$znamenitosti->length; $i++) {
                        echo $element->getElementsByTagName('znamenitost')->item($i)->nodeValue;
                        echo '<br/>';} ?> </td>
                <td><img src=<?php echo $filter->getWikiImage($element->getAttribute('handle')); ?>></td>
<!--                <td><?php echo $filter->getWikiExtract($element->getAttribute('handle')); ?></td> -->
                <td><?php echo $filter->getWikiCoordinates($element->getAttribute('handle')); ?></td>
                <td><?php echo $element->getElementsByTagname('koordinate')->item(0)->nodeValue;?></td>
<!--                <td><?php echo $filter->getNominatimCoordinates($filter->getWikiAdress($element->getAttribute('handle'))); ?></td> -->
<!--                <td><?php echo substr($filter->getTimeElapsed(), 0, 5) . ' s'; ?></td>  -->
<!--                <td><?php echo $filter->getWikiEpoch($element->getAttribute('handle')); ?></td> -->
                <td><button type="button" onclick="loadDetails('<?php echo $element->getElementsByTagname('ime')->item(0)->nodeValue;?>', '<?php echo $filter->getWikiCoordinates($element->getAttribute('handle'));?>', '<?php echo $element->getElementsByTagname('koordinate')->item(0)->nodeValue;?>')">Više o...</button> </td>
            </tr>
            <?php
            }
            ?>
        </table>
        </div>

  <div class="clr"></div>

  <footer id="main-footer">
    <p>Drevni gradovi<br/>
    Ante Balaić-Marmun 2020.</p>
  </footer>
</body>
</html>