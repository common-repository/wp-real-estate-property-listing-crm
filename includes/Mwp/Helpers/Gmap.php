<?php
class Mwp_Helpers_Gmap {

	public static function geocode($address, $output = 'json'){
		$url = 'https://maps.googleapis.com/maps/api/geocode/'.$output.'?address='.urlencode($address);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);
		if ($response['status'] != 'OK') {
			return false;
		}
		return $response;
	}
	public static function getLocation($address){
		$gmap_url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address=';
        $url = $gmap_url . urlencode($address);

        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if($resp['status']='OK'){
			if( isset($resp['results'][0]['geometry']['location']) ){
				return $resp['results'][0]['geometry']['location'];
			}
        }else{
            return false;
        }
        return false;
    }
	public static function getLocationByCoordinates($lat, $lng){
		$gmap_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng";
        $resp_json = self::curl_file_get_contents($gmap_url);
        $resp = json_decode($resp_json, true);

        if($resp['status']='OK'){
			return $resp;
			/*if( isset($resp['results'][0]['geometry']['location']) ){
				return $resp['results'][0]['geometry']['location'];
			}*/
        }else{
            return false;
        }
        return false;
    }
    private static function curl_file_get_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
            else return FALSE;
    }
} // End Gmap
