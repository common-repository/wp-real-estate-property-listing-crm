<?php
class Mwp_API_HomeJunction {

    protected $endPoint;
    protected $key;
    protected $token;  // private token
    protected $etoken; // hashed token

    protected $authenticated = FALSE;
    protected $errors = array(); // erros saved on array
    protected $uri;


    public function __construct( $key , $token, $endPoint )
    {
        $endPoint = substr( $endPoint , -1 ) == '/' ? $endPoint : $endPoint.'/' ;

        $this->endPoint  =     $endPoint;
        $this->key	  	 =     $key;
        $this->token  	 =     $token;

    }

    /**
     * 	Gets property list. Needs at least 1 filter set
     *
	 *  @params $data array
	 *
     *    possible query fields
	 *    
	 *	  ## Filters ##
     *    keyword = A keyword search. An aggregate of id, address.deliveryLine, subdivision, buildingName, area and description
	 *	  list_type = Listing type e.g. Commercial, Farm, Land, etc. Need to call getMarketListingTypes()
	 *	  property_type =	The property type, for example Single Family, Duplex or Townhouse. The possible values are market-specific.
     *    bathrooms = minimum number of bath rooms
	 *    bedrooms = minimum number of bed rooms
	 *	  lot_area		= The lot size
	 *	  lsu			= lot size unit. Defaults to square feet. Options: sqft, acres
	 *	  floor_area	= The living area or building size in ft2
     *    min_listprice = Minimum list price
     *    max_listprice = Maximum list price
	 *	  deliveryLine = delivery address line
     *    city	= Postal city name
	 * 	  state	= The state name or two-letter state
     *    zip	= The five-digit US ZIP code
	 *	  box	= is represented by four coordinates separated by a comma. box=north,east,south,west
	 *			  Note: The value for the north side of the box must always be greater than the south side. Likewise the value for the east side of the box must be greater than the west side. Latitude values must be between 0° and ±90° and longitude values between 0° and ±180°.
	 *	  daysonmarket = The number of days the listing has been on the market.
	 *	  listingdate = The date property was listed. Formats: e.g. 2016-04-29, 04-29-2016, 4/29/2016, April 29 2016, 29 Apr 2016
	 *
	 *
	 *	  ## Pagination ##
     *    limit  = The number of listings that are to be returned per page default page size is 25. The maximum page size is 100. 
     *    page 	= The page of listings to be returned
     *
	 *	  #sorting
	 *	  orderby = The field in the listings to sort by. This can be any search filter like listPrice, beds, size, etc.
	 *	  order_direction = The order in which the listings are to be sorted - desc for descending or asc for ascending sort order.
	 *
     * @return string json_encoded property list
     */
    public function getListings( $data )
    {
        return $this->sendRequest( 'getlistings' , $data );
    }
	
	/*
	* Looks up a specific listing
	*
	* @param $listingid string comma separated for multiple ids
	*
	* @return string json_encoded property
	*/
	
	public function getListingById($listingid){
		$data = ['listingid'=>$listingid];
        return $this->sendRequest( 'getlistingbyid' , $data );
    }
	
	/*
	* Retrieves Listing types. One of Commercial, Farm, Land, Multifamily, Rental, or Residential 
	*
	* @return string json_encoded list type
	*/
	public function getListingTypes(){
		return $this->sendRequest('getlistingtypes');
	}
	
	/*
	* Quickly find addresses that match a free-form text string. Used for auto-complete style text field
	*
	* @param $data array 
	* 	possible query fields
	*	
	*	keyword - searched address
	*	limit	- returned limit, default: 25, max: 100
	*
	* return string json encoded matches
	*/
	
	public function getMatchedAddress($data){
		return $this->sendRequest('getmatchedaddress',$data);
	}
	
	/*
	* Search for a specific set of schools.
	*
	* @param $data array filter and options for the returned results. At least 1 filter parameter is required
	*    possible query fields
	*	##filters
	*	box	- A bounding box encompassing the maximum extents of the search.	Box
	*	circle -	A bounding circle encompassing the maximum extents of the search.	Circle
	*	city -	Postal city name.	String
	*	county -	County name.	String
	*	state -	State name or postal abbreviation.	State
	*	street -	Street address for the school.	Substring
	*	zip -	Five digit postal ZIP code
	*	admission -	The school admission type, either Public or Private.	String
	*	charter -	true to limit the search to only charter schools.	Boolean
	*	district -	School district name or ID.	Substring
	*	grade -	Limit the search to only schools that serve a particular grade level. You can specify elementary, middle or high or an individual grade level (pk, kg, 1, 2, 3, etc.). Alternatively, you can specify multiple grade values separated with a comma (for example 5,6).	
	*	gsRating -	The Great Schools rating for this school.	Numeric
	*	magnet -	true to limit the search to only magnet schools.	Boolean
	*	name -	The name of the school.	Substring
	*	titlei -	true to limit the search to only Title I schools.	Boolean
	*
	*  #options
	*	details -	If true, the web service will return additional details about each school.
	*	limit -	Sets the maximum number of schools that are to be returned by the search.
	*	pageNumber -	The page of schools to be returned. This value can be between 1 and the maximum number of pages returned by the search.
	*	pageSize -	The number of schools that are to be returned per page. The default page size is 25. The maximum page size is 100.
	*
	*   #sorting
	*   orderby = The field in the schools to sort by. This can be any search filter like name, grade, etc.
	*   order_direction = The order in which the schools are to be sorted - desc for descending or asc for ascending sort order.
	
	*
	* return json encoded string contains: paging, schools, sorting, total
	*/
	public function getSchools($data){
		return $this->sendRequest('getschools',$data);
	}
	
	/*
	* Allows you to look up one or more schools by ID, comma delimited for multiple school ids
	*
	* @params $data array
	*
	*   possible query fields
	*	id - The ID (or multiple IDs, comma delimited) of the school
	*	details - If true, the web service will return additional details about the school.
	*
	* return json encoded string
	*/
	public function getSchoolById($data){
		return $this->sendRequest('getschoolbyid',$data);		
	}
	
	/*
	* Search for a specific set of school districts.
	*
	* @params $data array
	*
	*    possible query fields
	*	##filters
	*	box	- A bounding box encompassing the maximum extents of the search.	Box
	*	circle -	A bounding circle encompassing the maximum extents of the search.	Circle
	*	city -	Postal city name.	String
	*	coords -	If the specified point lies inside a school district, that school district is returned.	Coordinates
	*	county	- County name.	String
	*	state -	State name or postal abbreviation.	State
	*	zip -	Five digit postal ZIP code	String
	*	gsRating	The Great Schools rating for the district.	Numeric
	*	name	The name of the school district.	Substring
	*
	*  #options
	*	details -	If true, the web service will return additional details about each school district.
	*	geometry -	If true, the web service will return the geometry of each school district.
	*	limit -	Sets the maximum number of school districts that are to be returned by the search.
	*	pageNumber -	The page of school districts to be returned. This value can be between 1 and the maximum number of pages returned by the search.
	*	pageSize -	The number of school districts that are to be returned per page. The default page size is 25. The maximum page size is 100.
	*
	*   #sorting
	*   orderby = The field in the school districts to sort by. This can be any search filter like name, city, zip etc.
	*   order_direction = The order in which the school districts are to be sorted - desc for descending or asc for ascending sort order.
	*
	* return json encoded string contains: districts, paging, sorting, total
	*/
	public function getSchoolDistricts($data){
		return $this->sendRequest('getschooldistricts',$data);
	}
	
	/*
	* Look up one or more school districts by ID. Comma delimited for multiple school ids.
	*
	* @params $data array
	*
	* # possible query fields
	*	details -	If true, the web service will return additional details about the school district.	
	*	geometry -	If true, the web service will return the geometry of the school district.	
	*	id -	The ID (or multiple IDs, comma delimited) of the school district.
	*
	* return json encoded string
	*/
	public function getSchoolDistrictById($data){
		return $this->sendRequest('getschooldistrictbyid',$data);
	}
	
	/*
	* Provides access to information about a Multiple Listing Service (MLS) 
	* including the data schema, compliance rules, agents and offices associated with that market.
	*
	* @params $data array
	*
	* # possible query fields
	* market - The MLS market identifier
	*
	*/
	public function getMarketInfo($data){
		return $this->sendRequest('getmarketinfo/'.$data['market'],$data);
	}
	
	public function customRequest($request,$data = array()){
		return $this->sendRequest($request,$data);
	}
		
    private function sendRequest( $request , $data = array() )
    {
       
        $data['key']      = $this->key;
        $data['request']  = $request;
        

        $uri    =   strtolower( $this->endPoint.$request );
        $this->uri =  $uri;
		 
        $data	=	http_build_query( $data );
        $etoken =   hash_hmac( 'sha256' , $data , $this->token ) ;

        $uri_with_data = $uri.'/?'.$data;
        $ch     =   curl_init( $uri );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_USERPWD, "$this->key:$etoken" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS,  $data );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        $this->uri =  $uri;

        try {
            $curl_output = curl_exec($ch);

        }catch( \Exception $e ){
            curl_close($ch);

            return ['success'=>'false',
					'error'=>['message' => 'CURL error: '.$e->getMessage()],
					'uri' =>  $uri
            ];
        }
		
        if( curl_errno( $ch ) ){
            $this->errors[] = curl_error( $ch );
            return ['success'=>'false',
					'error'=>['message' => curl_error( $ch )],
					'uri' =>  $uri
					];
        }

        curl_close($ch);

        if( ! $curl_output ){
            return ['success'=>'false',
                	'error'=>['message' => ' Application error. No output returned.']
					];
        }

        $decode =  json_decode( $curl_output );

        if( $decode === null ){
            return ['success'=>'false',
                	'error'=>['messsage' => ' No output returned. Most probably an Application Error '.$uri_with_data]
					];
        }

        return $decode;
    }
}
