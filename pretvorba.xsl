<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 

<xsl:template match="/">
<html>
    <head>
    <link href="dizajn.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="bg-dark">

        <nav id="navbar">
      <div class="container">
        <h1 class="logo"><a href="index.html">Drevni gradovi</a></h1>
        <ul>
          <li><a href="index.html">Početna</a></li>
          <li><a href="obrazac.html">Pretraga</a></li>
          <li><a class="current" href="podaci.xml">Podaci</a></li>
          <li><a href="https://www.fer.unizg.hr">FER</a></li>
          <li><a href="https://www.fer.unizg.hr/predmet/or" target="_blank">OR</a></li>
          <li><a href="mailto:ante.balaic-marmun@fer.hr">Email</a> </li>
        </ul>
      </div>
    </nav>

    <div class="container">
        <h2>Gradovi</h2>
        <table border="1">
            <tr class="bg-primary">
                <th>Ime</th>
                <th>Država</th>
                <th>Regija</th>
                <th>Kultura</th>
                <th>Osnovan</th>
                <th>Znamenitosti</th>
            </tr>
            <xsl:for-each select="podaci/grad">
            <tr class="bg-light">
                <td><xsl:value-of select="ime"/></td>
                <td><xsl:value-of select="drzava"/></td>
                <td><xsl:value-of select="regija"/></td>
                <td><xsl:value-of select="kultura"/></td>
                <td><xsl:value-of select="osnovan"/></td>               
                <td><xsl:for-each select="znamenitosti/znamenitost">
                  <xsl:value-of select="imeZnamenitosti"/><br/>
                </xsl:for-each>
                </td>
            </tr>
           </xsl:for-each>
        </table>
        </div>
    <footer id="main-footer">
    <p>Drevni gradovi<br/>
      Ante Balaić-Marmun 2020.</p>
  </footer>
    </body>
</html>
</xsl:template>
</xsl:stylesheet>