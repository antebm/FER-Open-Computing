var TableBackgroundNormalColor = "#fff";
var TableBackgroundMouseoverColor = "#444";
var TableTextColor = "#444";
var TableTextMouseoverColor = "#fff";
var mymap;
var marker1;
var marker2;
var pointA;
var pointB;
var pointList;
var mapPolyLine;

function promijeniBoju(row) { 
    row.style.backgroundColor = TableBackgroundMouseoverColor;
    row.style.color = TableTextMouseoverColor;
 }
function obnoviBoju(row) { 
    row.style.backgroundColor = TableBackgroundNormalColor; 
    row.style.color = TableTextColor;

}
function loadWikiHandle(handle){
    var xhttp = new XMLHttpRequest();
 
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("wikiTitle").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET", "https://en.wikipedia.org/api/rest_v1/page/html/" + handle, true);
    xhttp.send();
}
function loadDetails(ime, wiki, nomina, handle) {
    var xhttp = new XMLHttpRequest();
    console.log(ime);
    console.log(wiki);
    console.log(nomina);
    var wikiCoord = wiki.split(" <br/> ");
    var nominaCoord = nomina.split(",");

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("details").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "detalji.php?ime=" + ime, true);
    xhttp.send();
    // document.getElementById('mapid').innerHTML = "<div id='map' style='width: 100%; height: 100%;'></div>";
    map(wikiCoord[0], wikiCoord[1], nominaCoord[0], nominaCoord[1], ime);
    loadWikiHandle(handle);
}

function map(lat, lon, lat1, lon1, name) {

    if(typeof mymap === 'undefined'){
        mymap = L.map('mapid').setView([lat, lon], 13);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);
    }
    pointA = new L.LatLng(lat,lon);
    pointB = new L.LatLng(lat1,lon1);
    pointList = [pointA, pointB];

	mymap.setView([lat,lon],13);
    marker1 = L.marker([lat, lon]).addTo(mymap);
    marker2 = L.marker([lat1, lon1]).addTo(mymap);
    marker1.bindPopup( "Wiki " + " " + name + " [" + lat + ", " + lon + "]");
    marker2.bindPopup( "Nominatim" + " " + name + " [" + lat1 + ", " + lon1 + "]");
	mapPolyLine = new L.polyline(pointList, {
        color: 'red',
        weight: '4',
        opacity: 0.7,
        smoothFactor: 1
    });
    mapPolyLine.addTo(mymap);
}

