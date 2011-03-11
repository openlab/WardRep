<?php
/**
 * OGDI.php
 *
 * @author     Aaron McGowan (www.amcgowan.ca)
 */

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * OGDI
 */
class OGDI {
	/* Member variables */
	/**
	* @var: _query_base_url
	*
	* David Eave's data(dot)gc.ca OGDI instance base query for performing and or retrieving data
	* from the data storage.
	*/
	private $_query_base_url = 'http://datadotgcds.cloudapp.net/v1/def/';
	
	/**
	* __construct
	*
	* Constructor
	*
	* @access: public
	* @param:  void
	* @return: void
	*/
	public function __construct() {
		/* empty constructor */
	}
	
	/**
	* query
	*
	* A simple method for querying OGDI based on the data set and OGDI's query language.
	*
	* @access: public
	* @param:  string			Contains the data set name in which to perform the query on
	* @param:  string			Contains the query (filtering string) to perform on the specified dataset
	* @return: mixed			Returns an array of records from the data set if found, else false if nothing found and or error.
	*/
	public function query($dataset, $query = '') {
		$url = $this->build_query_url($dataset, array(
			'$filter' => $query,
			'format' => 'json'
		));
		
		$data = @file_get_contents($url);
		if( $data ) {
			$data = json_decode($data);
			$data = isset($data->d) ? $data->d : false;
			return $data;
		}
		
		return false;
	}
	
	/**
	* build_query_url
	* 
	* A simple URL builder for querying data from OGDI.
	*
	* @access: protected
	* @param:  string			Contains the data set name.
	* @param:  array			Contains an array of query string arguments
	* @return: string			Returns the 'built' URL.
	*/
	final protected function build_query_url($dataset, array $args) {
		$url = rtrim($this->_query_base_url, '/') . '/' . $dataset . '/';
		return $url . '?' . http_build_query($args);
	}
}