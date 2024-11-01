<script>
	var MDJS = {
		"ajaxurl":"<?php echo admin_url( 'admin-ajax.php' );?>",
		"security":"<?php echo wp_create_nonce( 'md-ajax-request' );?>",
		"current_feed":"<?php echo mwp_get_current_api_source();?>",
		"current_view":"<?php echo Mwp_View::get_instance()->current_view_type;?>",
		"account_address_geocode":<?php echo json_encode(mwp_geocode_search_location());?>,
		"google_map_key":"<?php echo mwp_google_map_api();?>",
		"google_map_zoom":"<?php echo mwp_get_map_zoom();?>"
	};
	
	var searchResultApp = angular.module("searchResultApp", []);
	//set
	searchResultApp.value('WPMD', MDJS);
	//create factory
	//factory for map boundary
	//factory for no map boundary support
	searchResultApp.factory('factoryPropertyGetData', function($http, $q, WPMD){
		var _factoryPropertyGetData = {};
		var url = WPMD.ajaxurl;
		_factoryPropertyGetData.getData = function(search_data){
			var deferred = $q.defer();
			var search_property_data = [<?php echo json_encode(Mwp_View::get_instance()->method_data);?>];
			//console.log(search_data);
			//search_property_data:search_property_data,
			//fix for IE
			$http({
				url: url,
				method: "GET",
				params: {
					search_property_data:search_property_data,
					action :'get_property_data_' + WPMD.current_feed,
					current_view: WPMD.current_view,
					map_boundaries:search_data
				}
			}).success(function(res){
				//console.log(res);
				deferred.resolve(res);
			});
			return deferred.promise;
		}
		return _factoryPropertyGetData;
	});
	//initialize google map
	searchResultApp.factory('factoryInitGmap', function($window, $http, $q, WPMD){
		var _factoryGmapGetData = {};
		var gmap_bounds;
		var asyncUrl = 'https://maps.googleapis.com/maps/api/js?key=' + WPMD.google_map_key + '&callback=',
			mapsDefer = $q.defer();
		//Callback function - resolving promise after maps successfully loaded
		$window.googleMapsInitialized = mapsDefer.resolve; // removed ()	
		//Async loader
		var asyncLoad = function(asyncUrl, callbackName) {
		  var script = document.createElement('script');
		  //script.type = 'text/javascript';
		  script.src = asyncUrl + callbackName;
		  document.body.appendChild(script);
		};
		//Start loading google maps
		asyncLoad(asyncUrl, 'googleMapsInitialized');
		
		_factoryGmapGetData.init = function(){
			return mapsDefer.promise;
		}
		return _factoryGmapGetData;
	});
	searchResultApp.service('servicePropertyGetData', function(factoryPropertyGetData){
		this.getData = function(search_data){
			return factoryPropertyGetData.getData(search_data);
		}
	});
	searchResultApp.service('serviceInitGmap', function(factoryInitGmap){
		this.init = function(){
			return factoryInitGmap.init();
		}
	});
	searchResultApp.controller('ctrlPropertyGetData', function($scope, WPMD, servicePropertyGetData){
		var click_marker = false;
		//$scope.mwpproperties = {status: "Not Loaded"};
		//get bound when idle
		$scope.mwp_total_properties = 0;
		function detectBrowser() {
		  var useragent = navigator.userAgent;
		  var isMobile = false; //initiate as false
			// device detection
			if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
				|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
					return isMobile;
		}
		function get_bounds(){
			var gmap_bounds = $scope.map.getBounds();
			var gmap_bounds_ne = gmap_bounds.getNorthEast(); // LatLng of the north-east corner
			var gmap_bounds_sw = gmap_bounds.getSouthWest();
			return {
				'boundary' : gmap_bounds,
				'bound_ne' : gmap_bounds_ne,
				'bound_sw' : gmap_bounds_sw,
			}
		}
		
		function gmapInfoWindow(marker, _infowindow){
			$scope.property_img = marker.primary_photo;
			$scope.property_title = marker.title;
			$scope.property_price = marker.price;
			
			_infowindow.setContent(marker.infowindow_content);
			_infowindow.open($scope.map, marker);
			google.maps.event.addListener(_infowindow,'closeclick',function(){
				click_marker = false;
			});
		}
		
		function createMarker(info, indx, _infowindow){
			var marker = new RichMarker({
				map: $scope.map,
				position: new google.maps.LatLng(info.lat, info.long),
				title: info.title,
				property_id: info.property_id,
				price: info.price,
				primary_photo: info.primary_photo,
				flat:true,
				content: '<div class="mwp-marker mwp-marker-'+info.property_id+'"><span class="marker-price">' + info.marker_price + '</span></div>',
				infowindow_content:'<div class="media mwp-infowindow mwp-infowindow-'+info.property_id+'">'
										+ '<div class="media-left">'
												+ '<div class="md-listing-img">'
													+ '<img class="media-object" src="' + info.primary_photo + '" style="width:65px;height:65px;">'  
												+ '</div>'
										+ '</div>'
										+ '<div class="media-body">'
											+ '<h3 class="media-heading">' + info.price + '</h3>'
											+ '<a href="'+info.url+'" target="_blank">'
												+ info.title 
											+ '</a>'
											+ '<ul class="list-unstyled list-inline">'
												+'<li class="border-mute">'
													+'<span class="">Beds </span>'
													+'<span class="">' + info.bed + '</span>'
												+'</li>'
												+'<li class="border-mute">'
													+'<span class="">Baths </span>'
													+'<span class="">' + info.bath + '</span>'
												+'</li>'
												+'<li class="border-mute">'
													+'<span class="">'+info.area_unit+' </span>'
													+'<span class="">' + info.area +'</span>'
												+'</li>'
											+'</ul>'
										+ '</div>'
									+ '</div>',
			});

			google.maps.event.addListener(marker, 'click', function(){
				click_marker = true;
				gmapInfoWindow(marker, _infowindow);
			});
			
			$scope.markers.push(marker);
		}
					
		//serviceInitGmap.init().then(function(data){
			var infoWindow = new google.maps.InfoWindow({
				maxWidth: 200
			});
				
			$scope.map = new google.maps.Map(document.getElementById('map-canvas'), {
			  center: {lat: WPMD.account_address_geocode.lat, lng: WPMD.account_address_geocode.lng},
			  zoom: parseInt(MDJS.google_map_zoom)
			});
			
			$scope.map.addListener('idle', function() {
				if( !click_marker ){
					$scope.setLoading(true);
					var data_map_bound = {};
					var map_bound = get_bounds();
					data_map_bound = {
						'map_bound' : map_bound,
						'ne_lat' : map_bound.bound_ne.lat(),
						'ne_lng' : map_bound.bound_ne.lng(),
						'sw_lat' : map_bound.bound_sw.lat(),
						'sw_lng' : map_bound.bound_sw.lng(),
						'has_boundary': 1
					};
					servicePropertyGetData.getData(data_map_bound).then(function(data){
						$scope.mwpproperties = data;
						$scope.mwp_total_properties = data.length;
						$scope.markers = [];
						for (i = 0; i < $scope.mwpproperties.length; i++){
							createMarker($scope.mwpproperties[i], i, infoWindow);
						}
						$scope.setLoading(false);
					});
				}
			});
			$scope.openInfoWindow = function(e, selectedMarker){
				e.preventDefault();
				click_marker = true;
				var found_marker_index;
				for(var i = 0; i < $scope.markers.length; i++){ // looping through Markers Collection
					if( $scope.markers[i].property_id == selectedMarker.property_id ){
						found_marker = i;
					}
				}
				gmapInfoWindow($scope.markers[found_marker], infoWindow);
			}
		//});
		$scope.query = '';
		$scope.queryBy = 'raw_price';
		$scope.orderProp = '-posted_at';
		//console.log(detectBrowser());
		$scope.setLoading = function(loading) {
			$scope.isLoading = loading;
			jQuery('#search-result-map-left .row').hide();
		}
		$scope.layoutDone = function() {
			$scope.setLoading(false);
			jQuery('#search-result-map-left .row').show();
		}
	});
	searchResultApp.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	});
</script>
<script src="<?php echo mwp_public_url() . 'js/richmarker.js';?>"></script>
