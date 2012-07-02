<?php

$numMaps=0;

function addYoutube($atts, $content = null) {
 extract(shortcode_atts(array(
    "id" => null,
    "width" => '400',
    "height" => '225'    
  ), $atts));
  return '<div><object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$id.'" style="width:'.$width.'px;height:'.$height.'px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/'.$id.'" /></object></div> 
  '; 
}
add_shortcode('youtube','addYoutube', '[youtube id="" width="" height="" /]');


function addPageField($atts){
	global $id;
	 extract(shortcode_atts(array(
        'field' => '',
        'page' => ''
    ), $atts));
	if ($page=='') $page=$id;
	$field=returnPageField($page,$field);
	return $field;
}
add_shortcode('pagefield','addPageField', '[pagefield page="" field="" /]');


function googlemap_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'width' => '500px',
        'height' => '300px',
        'marker' => '',
        'center' => '',
        'zoom' => '13'
    ), $atts));
 

    $rand = rand(1,100) * rand(1,100);
 
    return '
    	<div id="map_canvas" style="width: '.$width.'; height: '.$height.';"></div>
    	<script type="text/javascript"> 
		  function initialize() {
		    var myLatlng = new google.maps.LatLng(  '.$marker.');
		    var myOptions = {
		      zoom: 15,
		      center: myLatlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    }
		    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		    var marker = new google.maps.Marker({
		      position: myLatlng, 
		      map: map
		    });
		  }
		  
		  function loadScript() {
		    var script = document.createElement("script");
		    script.type = "text/javascript";
		    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
		    document.body.appendChild(script);
		  }
		  
		  window.onload = loadScript;
		</script>
    ';
 
}
add_shortcode('googlemap', 'googlemap_shortcode', '[googlemap width="" height="" marker="" center="" zoom="" /]');


function vimeo_shortcode($atts, $content=null) {
	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' 	=> '400',
		'height' 	=> '225',
	), $atts));

	if (empty($id) || !is_numeric($id)) return '<!-- Vimeo: Invalid clip_id -->';
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);

	return "<iframe src='http://player.vimeo.com/video/$id?title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' frameborder='0'></iframe>";
}
add_shortcode('vimeo', 'vimeo_shortcode', '[vimeo id="" width="" height="" /]');


function chart_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'data' => '',
	    'colors' => '',
	    'size' => '400x200',
	    'bg' => 'ffffff',
	    'title' => '',
	    'labels' => '',
	    'advanced' => '',
	    'type' => 'pie'
	), $atts));
 	$string='';
	switch ($type) {
		case 'line' :
			$charttype = 'lc'; break;
		case 'xyline' :
			$charttype = 'lxy'; break;
		case 'sparkline' :
			$charttype = 'ls'; break;
		case 'meter' :
			$charttype = 'gom'; break;
		case 'scatter' :
			$charttype = 's'; break;
		case 'venn' :
			$charttype = 'v'; break;
		case 'pie' :
			$charttype = 'p3'; break;
		case 'pie2d' :
			$charttype = 'p'; break;
		default :
			$charttype = $type;
		break;
	}
 
	if ($title) $string .= '&chtt='.$title.'';
	if ($labels) $string .= '&chl='.$labels.'';
	if ($colors) $string .= '&chco='.$colors.'';
	$string .= '&chs='.$size.'';
	$string .= '&chd=t:'.$data.'';
	$string .= '&chf='.$bg.'';
 
	return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
}
add_shortcode('chart', 'chart_shortcode', '[chart data="" colors="" size="" bg="" title="" labels="" advanced="" type="" /]');


function addCode($atts, $content = null) {
 extract(shortcode_atts(array(
    "mode" => null
  ), $atts));
  $mode   = isset($mode) ? $mode : 'html'; 
  return '<pre><code data-language="'.$mode.'">'.str_replace('<br/>', '', $content).'</code></pre>'; 
}
add_shortcode('code','addCode', '[code mode=""]content[/code]');

function mapme($attr) {
	global $numMaps;
	// default atts
	$attr = shortcode_atts(array(	
		'lat'   => '0', 
		'lon'    => '0',
		'id' => 'map',
		'z' => '1',
		'w' => '400',
		'h' => '300',
		'maptype' => 'ROADMAP',
		'address' => '',
		'kml' => '',
		'kmlautofit' => 'yes',
		'marker' => '',
		'markerimage' => '',
		'traffic' => 'no',
		'bike' => 'no',
		'fusion' => '',
		'start' => '',
		'end' => '',
		'infowindow' => '',
		'infowindowdefault' => 'yes',
		'directions' => '',
		'hidecontrols' => 'false',
		'scale' => 'false',
		'scrollwheel' => 'true'
		
		), $attr);
									

	$returnme = '
    <div id="' .$attr['id'] . '" style="width:' . $attr['w'] . 'px;height:' . $attr['h'] . 'px;"></div>
	';
	
	//directions panel
	if($attr['start'] != '' && $attr['end'] != '') 
	{
		$panelwidth = $attr['w']-20;
		$returnme .= '
		<div id="directionsPanel" style="width:' . $panelwidth . 'px;height:' . $attr['h'] . 'px;border:1px solid gray;padding:10px;overflow:auto;"></div><br>
		';
	}

	if ($numMaps==0){
		$returnme .= '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';
		$numMaps++;
	}
	$returnme .= '
    

	
    <script type="text/javascript">

		var latlng = new google.maps.LatLng(' . $attr['lat'] . ', ' . $attr['lon'] . ');
		var myOptions = {
			zoom: ' . $attr['z'] . ',
			center: latlng,
			scrollwheel: ' . $attr['scrollwheel'] .',
			scaleControl: ' . $attr['scale'] .',
			disableDefaultUI: ' . $attr['hidecontrols'] .',
			mapTypeId: google.maps.MapTypeId.' . $attr['maptype'] . '
		};
		var ' . $attr['id'] . ' = new google.maps.Map(document.getElementById("' . $attr['id'] . '"),
		myOptions);
		';
				
		//kml
		if($attr['kml'] != '') 
		{
			if($attr['kmlautofit'] == 'no') 
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:true};
				';
			}
			else
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:false};
				';
			}
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\'' . html_entity_decode($attr['kml']) . '\',kmlLayerOptions);
			kmllayer.setMap(' . $attr['id'] . ');
			';
		}

		//directions
		if($attr['start'] != '' && $attr['end'] != '') 
		{
			$returnme .= '
			var directionDisplay;
			var directionsService = new google.maps.DirectionsService();
		    directionsDisplay = new google.maps.DirectionsRenderer();
		    directionsDisplay.setMap(' . $attr['id'] . ');
    		directionsDisplay.setPanel(document.getElementById("directionsPanel"));

				var start = \'' . $attr['start'] . '\';
				var end = \'' . $attr['end'] . '\';
				var request = {
					origin:start, 
					destination:end,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});


			';
		}
		
		//traffic
		if($attr['traffic'] == 'yes')
		{ 
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $attr['id'] . ');
			';
		}
	
		//bike
		if($attr['bike'] == 'yes')
		{
			$returnme .= '			
			var bikeLayer = new google.maps.BicyclingLayer();
			bikeLayer.setMap(' . $attr['id'] . ');
			';
		}
		
		//fusion tables
		if($attr['fusion'] != '')
		{
			$returnme .= '			
			var fusionLayer = new google.maps.FusionTablesLayer(' . $attr['fusion'] . ');
			fusionLayer.setMap(' . $attr['id'] . ');
			';
		}

		
		//address
		if($attr['address'] != '')
		{
			$returnme .= '
		    var geocoder_' . $attr['id'] . ' = new google.maps.Geocoder();
			var address = \'' . $attr['address'] . '\';
			geocoder_' . $attr['id'] . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $attr['id'] . '.setCenter(results[0].geometry.location);
					';
					
					if ($attr['marker'] !='')
					{
						//add custom image
						if ($attr['markerimage'] !='')
						{
							$returnme .= 'var image = "'. $attr['markerimage'] .'";';
						}
						$returnme .= '
						var marker = new google.maps.Marker({
							map: ' . $attr['id'] . ', 
							';
							if ($attr['markerimage'] !='')
							{
								$returnme .= 'icon: image,';
							}
						$returnme .= '
							position: ' . $attr['id'] . '.getCenter()
						});
						';

						//infowindow
						if($attr['infowindow'] != '') 
						{
							//first convert and decode html chars
							$thiscontent = htmlspecialchars_decode($attr['infowindow']);
							$returnme .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
										
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $attr['id'] . ',marker);
							});
							';

							//infowindow default
							if ($attr['infowindowdefault'] == 'yes')
							{
								$returnme .= '
									infowindow.open(' . $attr['id'] . ',marker);
								';
							}
						}
					}
			$returnme .= '
				} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
		}

		//marker: show if address is not specified
		if ($attr['marker'] != '' && $attr['address'] == '')
		{
			//add custom image
			if ($attr['markerimage'] !='')
			{
				$returnme .= 'var image = "'. $attr['markerimage'] .'";';
			}

			$returnme .= '
				var marker = new google.maps.Marker({
				map: ' . $attr['id'] . ', 
				';
				if ($attr['markerimage'] !='')
				{
					$returnme .= 'icon: image,';
				}
			$returnme .= '
				position: ' . $attr['id'] . '.getCenter()
			});
			';

			//infowindow
			if($attr['infowindow'] != '') 
			{
				$returnme .= '
				var contentString = \'' . $attr['infowindow'] . '\';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
							
				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $attr['id'] . ',marker);
				});
				';
				//infowindow default
				if ($attr['infowindowdefault'] == 'yes')
				{
					$returnme .= '
						infowindow.open(' . $attr['id'] . ',marker);
					';
				}				
			}
		}
		
		$returnme .= '</script>';
		
		return $returnme;
	?>
    

	<?php
}
add_shortcode('googlemap', 'mapme', '[googlemap address="" z="" w="" h="" /]');
