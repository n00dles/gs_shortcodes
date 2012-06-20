<?php

function addH1($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<h1 '.$id.$class.'>'. do_shortcode($content).'</h1>'; 	
}
add_shortcode('h1','addH1', '[h1 class="" id=""]content[/h1]');

function addH2($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : '';   
  return '<h2 '.$id.$class.'>'. do_shortcode($content).'</h2>'; 	
}
add_shortcode('h2','addH2', '[h2 class="" id=""]content[/h2]');


function addH3($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<h3 '.$id.$class.'>'. do_shortcode($content).'</h3>'; 	
}
add_shortcode('h3','addH3', '[h3 class="" id=""]content[/h3]');


function addH4($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<h4 '.$id.$class.'>'. do_shortcode($content).'</h4>'; 	
}
add_shortcode('h4','addH4', '[h4 class="" id=""]content[/h4]');


function addH5($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<h5 '.$id.$class.'>'. do_shortcode($content).'</h5>'; 	
}
add_shortcode('h5','addH5', '[h5 class="" id=""]content[/h5]');

function addH6($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<h6 '.$id.$class.'>'. do_shortcode($content).'</h6>'; 	
}
add_shortcode('h6','addH6', '[h6 class="" id=""]content[/h6]');

function addP($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<p '.$id.$class.'>'. do_shortcode($content).'</p>'; 	
}
add_shortcode('p','addP', '[p class="" id=""]content[/p]');

function addB($atts, $content = null){
  return '<strong>'. do_shortcode($content).'</strong>'; 	
}
add_shortcode('b','addB', '[b]content[/b]');

function addI($atts, $content = null){
  return '<i>'. do_shortcode($content).'</i>'; 	
}
add_shortcode('i','addI', '[i]content[/i]');

function addlink($atts, $content = null){
  extract(shortcode_atts(array(
    "src" => null, 
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : '';
  $src       = isset($src) ? " href='".$src."' " : 'src="http://" '; 
  return '<a  '.$src.$id.$class.' >'. do_shortcode($content).'</a>'; 	
}
add_shortcode('link','addLink', '[link src="" class="" id=""]content[/link]');

function addToggle($atts, $content = null){
  extract(shortcode_atts(array(
    "title" => null
  ), $atts));
  return '<h3 class="toggle"><a href="#">'.$title.'</a></h3><div class="toggle-box" style="display: none; ">'. do_shortcode($content).'</div>'; 	
}
add_shortcode('toggle','addToggle', '[toggle title=""]content[/title]');


function addText($atts, $content = null){
  extract(shortcode_atts(array(
    "size" => null,
    "width" => null,
    "height" => null,
    "line_height" => null,
    "color" => null,
    "align" => null    
  ), $atts));
  $size       = isset($size) ? "font-size:".$size."px;" : '';
  $width       = isset($width) ? "width:".$width.";" : '';
  $height       = isset($height) ? "height:".$height.";" : '';
  $color       = isset($color) ? "color:".$color.";" : '';
  $line_height       = isset($line_height) ? "line-height:".$line_height.";" : '';
  $align       = isset($align) ? " ".$align." " : '';
  return '<div class="text-box '.$align.'" style="'.$size.$width.$height.$line_height.$color.'">'. do_shortcode($content).'</div>'; 	
}
add_shortcode('text','addText', '[text title=""]content[/text]');



function addImage($atts, $content = null){
  extract(shortcode_atts(array(
    "src" => null, 
    "class" => null,
    "id" => null,
    "alt" => null,
    "width" => null,
    "height" => null,
    "style" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : '';
  $src       = isset($src) ? " src='".$src."' " : ''; 
  $style       = isset($style) ? " style='".$style."' " : ''; 
  $width       = isset($width) ? " width='".$width."' " : ''; 
  $height       = isset($height) ? " height='".$height."' " : ''; 
  $alt       = isset($alt) ? " alt='".$alt."' " : ' alt=""'; 
  return '<img '.$src.$id.$class.$style.$alt.$width.$height.' />'; 	
}
add_shortcode('image','addImage', '[image class="" id="" /]');

function addHighlight($atts, $content = null){
  extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<span '.$id.$class.'>'. do_shortcode($content).'</span>'; 	
}
add_shortcode('highlight','addHighlight', '[highlight class="" id=""]content[/highlight]');

function addDropcap($atts, $content = null){
  extract(shortcode_atts(array(
    "type" => null
  ), $atts));
  $type    = isset($type) ? $type : ''; 
  return '<span class="dropcap'.$type.'">'. $content.'</span>'; 	
}

add_shortcode('dropcap','addDropcap', '[dropcap type="1|2|3|4|5" ]content[/dropcap]');

function addDiv($atts, $content = null) {
 extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<div '.$id.$class.'>'. do_shortcode($content).'</div>'; 
}
function addSpan($atts, $content = null) {
 extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  $id       = isset($id) ? " id='".$id."'" : ''; 
  return '<span '.$id.$class.'>'. do_shortcode($content).'</span>'; 
}

function addPre($atts, $content = null) {
 extract(shortcode_atts(array(
    "class" => null,
    "id" => null
  ), $atts));
 $class    = isset($class) ? " class='".$class."'" : ''; 
 $id       = isset($id) ? " id='".$id."'" : ''; 
 return '<pre '.$id.$class.'>'.$content.'</pre>'; 
}


function addColumn($atts, $content = null){
extract(shortcode_atts(array(
	"size" => null,
    "id" => null,
    "class" => null
  ), $atts));	
  if (substr($size,-5)=="_last"){
  	$clss=" class='".substr($size,0,strlen($size)-5)." last ";
  } else {
  	$clss=" class='".$size." ";
  }
	$clss.=$class." '";
  return '<div '.$id.$clss.'>'. do_shortcode($content).'</div>';
}


function addQuote($atts, $content = null) {
 extract(shortcode_atts(array(
    "class" => null
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  return '<blockquote ><p '.$class.'>'.$content.'</p></blockquote>'; 
}

function addCode($atts, $content = null) {
 extract(shortcode_atts(array(
    "mode" => null
  ), $atts));
  $mode   = isset($mode) ? $mode : 'html'; 
  return '<code data-language="'.$mode.'">'.str_replace('<br>', '', $content).'</code>'; 
}


function addYoutube($atts, $content = null) {
 extract(shortcode_atts(array(
    "id" => null,
    "width" => null,
    "height" => null    
  ), $atts));
  $class    = isset($class) ? " class='".$class."'" : ''; 
  return '<div><object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$id.'" style="width:'.$width.'px;height:'.$height.'px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/'.$id.'" /></object></div> 
  '; 
}


function addLightbox($atts, $content = null) {
extract(shortcode_atts(array(
    "type" => null,
    "title" => null,
    "src" => null,
    "width" => null,
    "autoplay" => null,
    "height" => null    
  ), $atts));
  	$extras='';
	if ($type=='youtube') $extras.=';player=swf';
	$autoplay    = isset($autoplay) ? "&amp;autoplay=1" : '';
	$rel=' rel="shadowbox;width='.$width.';height='.$height.$extras.'" ';
	//$rel='rel="shadowbox;width=405;height=340;"';
	return '<a '.$rel.' title="'.$title.'" href="'.$src.$autoplay.'"  class="nyroModal" >'. do_shortcode($content).'</a>';
}
add_shortcode('lightbox','addLightbox', '[lightbox type="" src="" title="" width="" height=""]content[/lightbox]');


function addDownload($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" =>'' 
    ), $atts));
    return '<a class="button-2" href="'.$url.'">'.$content.'</a>';
}



add_shortcode('div','addDiv', '[div class="" id=""]content[/div]');
add_shortcode('span','addSpan', '[span class="" id=""]content[/span]');
add_shortcode('prep','addPre', '[pre class="" id=""]content[/pre]');
add_shortcode('column','addColumn', '[column size="" id=""]content[/column]');
add_shortcode('quote','addQuote', '[quote class="" ]content[/quote]');
add_shortcode('code','addCode', '[code class=""]content[/code]');
add_shortcode('youtube','addYoutube', '[youtube id="" width="" height="" /]<br/>Where id is the Youtube Video ID');
add_shortcode('download', 'addDownload', '[download url="" id=""]content[/download]');

function box($atts, $content = null) {
    return '<div class="box">'. do_shortcode($content).'</div>';
}

add_shortcode('box', 'box', '[box]content[/pre]');

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

function paypal_donation_shortcode($atts) {
	extract(shortcode_atts(array(
	    "text" 		=> '',  
		"email" 	=> '',
		"amount"	=> '',
		"currency"	=> 'EUR',
		"title"		=> 'Donation'
	), $atts));
	
	$content = "";
	
	if($text != "" && $email != "")
		$content .= "<a class='donate' href=\"https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amp;business=".$email."&amp;currency_code=".$currency."&amp;amount=".$amount."&amp;return=&amp;item_name=".$title."\">".$text."</a>";
	
	return $content;
}

add_shortcode('donate', 'paypal_donation_shortcode', '[donate text="" email="" amount="" currency="" title="" /]');


function addTooltip($atts, $content = null) {
 extract(shortcode_atts(array(
    "class" => 'classic',
    "text" => '',
    "href" => '#'
  ), $atts));
  $class    = isset($class) ? $class : ""; 
  
  return '<a class="tooltip" href="'.$href.'">'.$content.'<span class="'.$class.'">'.$text.'</span></a>';
}

add_shortcode('tooltip', 'addTooltip', '[tooltip class="classic|custom|critical|help|info|warning" text="" href="" ]content[/tooltip]');
