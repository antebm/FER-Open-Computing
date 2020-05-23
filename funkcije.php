<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


class Filter{
    
    private $dom;
    private $xpath;
    private $wikiLink;
    private $wikiContent;
    private $wikiDecoded;
    private $timeElapsed;

    function __construct(){
        $this->dom = new DOMDocument();
        $this->dom->load("podaci.xml");

        $this->xpath = new DOMXpath($this->dom);
        $this->xpath->registerNamespace('php', 'http://php.net/xpath');
        $this->xpath->registerPhpFunctions();
        $this->wikiLink = "https://en.wikipedia.org/api/rest_v1/page/summary/";
    }

    function __destruct(){
        $this->dom = null;
    }

    public function lower($string) {
		return	"translate(" . $string . ",  'ABCDEFGHIJKLLJMNNJOPQRSTUVWXYZŠĐČĆŽ0123456789', 'abcdefghijklljmnnjopqrstuvwxyzšđčćž0123456789')";
    } 
    
    public function getWikiImage($handle){
        $link = $this->wikiLink . $handle;
        $start = microtime(true);
        $this->wikiContent = @file_get_contents($link);
        $this->timeElapsed = microtime(true) - $start;
		$encoded = utf8_encode($this->wikiContent);
		$this->wikiDecoded = json_decode($encoded, true);
		
        return $this->wikiDecoded['thumbnail']['source'];
    }

    public function getWikiCoordinates($handle){   
        $result = $this->wikiDecoded['coordinates']['lat'] . ' <br/> ' . $this->wikiDecoded['coordinates']['lon'];
        return $result;
    }

    public function getWikiExtract($handle){
        $result = substr($this->wikiDecoded['extract'],0, 80) . '...';
        return $result;
    }

    public function getWikiAdress($handle){
        
        $endPoint = "https://en.wikipedia.org/w/api.php";
        $params = [
         "action" => "query",
          "prop" => "revisions",
          "rvprop" => "content",
          "rvsection" => "0",
          "titles" => $handle,
          "format" => "json"
        ];

        $url = $endPoint . "?" . http_build_query( $params );

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close( $ch );
        
        $result = json_decode( $output, true );

        $subject = json_encode($result["query"]["pages"]);
        $pattern = "/location = \[\[([a-zA-Z\s]*)\]\],\s*\[\[([a-zA-Z\s]*)\]\],\s*\[\[([a-zA-Z\s]*)\]\]/";
       
        preg_match($pattern, $output, $matches);
        if(array_key_exists(1, $matches)){
            return $matches[1] . ', ' . $matches[2] . ', ' . $matches[3];
        }
        return "No data";
    }

    public function getWikiEpoch($handle){
        $endPoint = "https://en.wikipedia.org/w/api.php";
        $params = [
         "action" => "query",
          "prop" => "revisions",
          "rvprop" => "content",
          "rvsection" => "0",
          "titles" => $handle,
          "format" => "json"
        ];

        $url = $endPoint . "?" . http_build_query( $params );

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close( $ch );
        
        $result = json_decode( $output, true );

        $subject = json_encode($result["query"]["pages"]);
        $pattern = "/epochs = \[\[([\w*\s]*)/";

        preg_match($pattern, $output, $matches);
        if(array_key_exists(1, $matches)){
            return $matches[1];
        }
        return "No data";
    }

    public function getNominatimCoordinates($adress){

        return $adress . "<br/> TODO: get coord";
    }

    public function getTimeElapsed(){
        return $this->timeElapsed;
    }

    public function upit() {

    	$query = array();
	
		if (isset($_REQUEST['ime'])){
         //  $query[] = "contains(php:functionString('mb_strtolower', text()), '" . mb_strtolower($_REQUEST['ime']) . "')";    
         $query[] = 'contains(' . $this->lower('ime') . ', "' . mb_strtolower($_REQUEST['ime'], "UTF-8") . '")';
        }
			
		if (isset($_REQUEST['drzava'])){
        // $query[] = "contains(php:functionString('mb_strtolower', text()), '" . mb_strtolower($_REQUEST['drzava']) . "')";
        	$query[] = 'contains(' . $this->lower('drzava') . ', "' . mb_strtolower($_REQUEST['drzava'], "UTF-8") . '")';
        }

        if (isset($_REQUEST['regija'])){
                $query[] = 'contains(' . $this->lower('regija') . ', "' . mb_strtolower($_REQUEST['regija'], "UTF-8") . '")';
            }
        
        if (isset($_REQUEST['kultura'])){
                $query[] = 'contains(' . $this->lower('kultura') . ', "' . mb_strtolower($_REQUEST['kultura'], "UTF-8") . '")';
                }

        if (isset($_REQUEST['znamenitost'])){
                $query[] = 'contains(' . $this->lower('znamenitosti/znamenitost/imeZnamenitosti') . ', "' . mb_strtolower($_REQUEST['znamenitost'], "UTF-8") . '")';
                }
        
        if (isset($_REQUEST['tipZnamenitosti'])){
                $query[] = 'contains(' . $this->lower('znamenitosti/znamenitost/imeZnamenitosti/@tipZnamenitosti') . ', "' . mb_strtolower($_REQUEST['tipZnamenitosti'], "UTF-8") . '")';
                }

        if (isset($_REQUEST['unesco'])){
                 $query[] = 'contains(' . $this->lower('ime/@unesco') . ', "' . mb_strtolower($_REQUEST['unesco'], "UTF-8") . '")';
                    }

        if (isset($_REQUEST['razdoblje'])){
                $query[] = 'substring(razdoblje, 1, 1 ="' . mb_substr($_REQUEST['razdoblje'], 0, 1) . '")';
                    }

		$xpathQuery = implode(" and ", $query);
		

		if(!empty($xpathQuery))
			return $this->xpath->query("/podaci/grad[" . $xpathQuery . "]");

		else
			return $this->xpath->query("/podaci/grad");
	}
}
