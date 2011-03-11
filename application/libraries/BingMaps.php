<?php
/**
 * BingMaps.php
 *
 * @author     Aaron McGowan (www.amcgowan.ca)
 */

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * BingMaps
 */
class BingMaps {
    /* Member variables */
    const GEOCODE_WSDL  = "http://dev.virtualearth.net/webservices/v1/metadata/geocodeservice/geocodeservice.wsdl";
    
	protected $_api_key = null;
    
    /**
     * __construct
     *
     * Ctor.
     * 
     * @access: 
     * @param: 
     * @return: 
     */
    public function __construct() {
		$ci = get_instance();
		if( null !== $ci ) {
			$this->_api_key = $ci->config->item('bing_maps_api_key');
		}
    }
    
    /**
     * geocode_lookup_raw
     * 
     * Performs a standard geocode lookup using the query, returns the response that is
     * returned from performing the geocode lookup.
     * 
     * @access: public
     * @param:  string
     * @return: mixed       Returns false on failure, else returns an object.
     */
    public function geocode_lookup_raw($query) {
        return $this->geocode_lookup($query);
    }
    
    /**
     * geocode_lookup_latlng
     *
     * Performs a standard geocode lookup using the query, returns an array
     * of objects containing only latitudes and longitudes along with formatted query.
     * 
     * @access: public
     * @param:  string
     * @return: mixed       Returns false on failure, else returns array
     */
    public function geocode_lookup_latlng($query) {
        $geocode_results = $this->geocode_lookup($query);
        if( $geocode_results ) {
            try {
                $geocode_results = &$geocode_results->GeocodeResult->Results;
                
                if( isset($geocode_results->GeocodeResult) && is_array($geocode_results->GeocodeResult) ) {
                    $results = array();
                    foreach( $geocode_results->GeocodeResult as &$result ) {
						if( 'canada' != strtolower($result->Address->CountryRegion) )
						{
							continue;
						}
						
                        $o = new stdClass;
                        $o->formatted_address = $result->Address->FormattedAddress;
                        $o->city = $result->Address->Locality;
                        $o->region = $result->Address->AdminDistrict;
                        $o->country = $result->Address->CountryRegion;
                        
                        if( is_array($result->Locations->GeocodeLocation) ) {
                            $o->latitude = $result->Locations->GeocodeLocation[0]->Latitude;
                            $o->longitude = $result->Locations->GeocodeLocation[0]->Longitude;
                        } else {
                            $o->latitude = $result->Locations->GeocodeLocation->Latitude;
                            $o->longitude = $result->Locations->GeocodeLocation->Longitude;
                        }
                        
                        $results[] = $o;
                    }
                    
                    return $results;
                    
                } else {
                    if( isset($geocode_results->GeocodeResult->Locations->GeocodeLocation) ) {
						$o = new stdClass;
						$o->formatted_address = $geocode_results->GeocodeResult->Address->FormattedAddress;
						$o->locality = $geocode_results->GeocodeResult->Address->Locality;
						
						if( is_array($geocode_results->GeocodeResult->Locations->GeocodeLocation) ) {
							$o->latitude = $geocode_results->GeocodeResult->Locations->GeocodeLocation[0]->Latitude;
							$o->longitude = $geocode_results->GeocodeResult->Locations->GeocodeLocation[0]->Longitude;
                            
                            $o->city = $geocode_results->GeocodeResult->Address->Locality;
                            $o->region = $geocode_results->GeocodeResult->Address->AdminDistrict;
                            $o->country = $geocode_results->GeocodeResult->Address->CountryRegion;
						} else {
							$o->latitude = $geocode_results->GeocodeResult->Locations->GeocodeLocation->Latitude;
							$o->longitude = $geocode_results->GeocodeResult->Locations->GeocodeLocation->Longitude;
                            
                            $o->city = $geocode_results->GeocodeResult->Address->Locality;
                            $o->region = $geocode_results->GeocodeResult->Address->AdminDistrict;
                            $o->country = $geocode_results->GeocodeResult->Address->CountryRegion;
						}
                        
                        return array($o);
                    }
                    
                    return false;
                }
            }
            catch( Exception $e ) {
                // throw $e;
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * geocode_lookup
     * 
     * @access: protected
     * @param:  string
     * @return: mixed
     */
    final protected function geocode_lookup($query) {
        $query = trim($query);
        if( $query ) {
            try {
                $soap_client = new SoapClient(self::GEOCODE_WSDL);
                $geocode_response = $soap_client->Geocode(array(
                    'request' => array(
                        'Credentials' => array('ApplicationId' => $this->_api_key),
                        'Query' => $query
                     )
                ));
                
                return $geocode_response;
            }
            catch( Exception $e ) {
                throw new Exception("An error has occurred with the SOAP client request.", 0, $e);
            }
        }
        
        return false;
    }
}