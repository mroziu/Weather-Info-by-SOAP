<?php
/**
 * Description of SOAP
 *
 * @author damian
 */
class ReceiveWeatherBySoap {

    private $service_url;
    private $timeout;
    private $country = 'Poland';
    private $city = 'Warszawa';

    function __construct($config) {
        $this->service_url = $config['url'];
        $this->timeout = $config['time_out'];
    }

    public function set_country($country) {
        $this->country = $country;
    }

    public function set_city($city) {
        $this->city = $city;
    }

    public function get_xml() {
        $this->set_socket_timeout();
        try {
            
            $response = @get_headers($this->service_url, 1);
            if ($response === false) return 'HTTP Error';
            if ($response[0] !== 'HTTP/1.1 200 OK') return 'HTTP Error';
            
            $this->client = new SoapClient($this->service_url);
            $request_params = array('CityName' => $this->city, 'CountryName' => $this->country);
            $response = $this->client->GetWeather($request_params);
        } catch (SoapFault $e) {
            $this->xml_result = $e->getMessage();
            return $this->xml_result;
        }
        $result = $response->GetWeatherResult;
        if ($result == 'Data Not Found')
            return $result;
        $converted = str_replace("utf-16", "utf-8", $result);
        $this->xml_result = simplexml_load_string($converted);
        return $this->xml_result;
    }

    private function set_socket_timeout() {
        ini_set('default_socket_timeout', $this->timeout);
    }
}
