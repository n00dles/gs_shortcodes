<?php


/****************************************************
*
* @File:  shortcodes.php
* @Action:  Port of WP Shortcodes to GS  
*
*****************************************************/
$shortcode_tags   = array();  // Shortcode tags array
$shortcode_info   = array();  // Shortcode tags array

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile, 				# ID of plugin, should be filename minus php
	'Shortcodes',			 	# Title of plugin
	'1.1', 				# Version of plugin
	'Mike Swan',				# Author of plugin
	'http://www.digimute.com/', 		# Author URL
	'Shortcodes for GS', 			# Plugin Description
	'plugins', 				# Page type of plugin
	'shortcodes_show'  			# Function that displays content
);

# activate hooks
add_action('plugins-sidebar','createSideMenu',array($thisfile,'Shortcode Info')); 
if (get_filename_id()=="edit"){
	add_action('edit-extras','insertJS',array()); 
}

function insertJS(){
	global $shortcode_tags;  
  	global $shortcode_info; 
	echo "<script type=\"text/javascript\">";
	echo "jQuery(document).ready(function() { ";
	$js="<div style='width:100%;background-color:#efefef;height:36px;margin-bottom:5px;'>";
	$js.="<h2 style='padding-top:5px;padding-left:5px;color:#222;'>[shortcodes]";
	$js.= "<select style='width:300px;margin-left:30px;font-family:courier;font-size:11px;' id='shortcode_value'>";
	while (list($key, $val) = each($shortcode_tags)) {
		$js.= '<option >'.$key.' - '.str_replace("\"","'", $shortcode_info[$key]).'</option>';
	}
	$js.= "</select><input id='shorcode_insert' style='margin-left:15px;' type='button' value=' insert ' /></h2></div>";
	
	echo "$(\"".$js."\").insertAfter($('#metadata_window'));";
	?>
	
	$("#shorcode_insert").on("click", function(){
		var selectText = CKEDITOR.instances["post-content"].getSelection().getSelectedText();
		var tag=$('#shortcode_value').val();
		var tagIndex = tag.indexOf("[");
		tag =  tag.substr(tagIndex);
		if (selectText!='') {
			tag = tag.replace('content',selectText);
		}
		CKEDITOR.instances["post-content"].insertText(tag);
	})
	
	<?php 
	echo " })";
	echo "</script>";

}


function shortcodes_show() {
  global $shortcode_tags;  
  global $shortcode_info; 
  $table = '<thead><tr><th>Shortcode</th><th>Function</th><th>Usage</th></thead><tbody>';
	$counter=0;
	
  	while (list($key, $val) = each($shortcode_tags)) {
  	$table.=  '<tr>';
	$table .= '<td>'.$key.'</td>';
	$table .= '<td>'.$val.'</td>';
	$table .= '<td><pre style="white-space: normal;">'.$shortcode_info[$key].'</pre></td>';
	$table .= '</tr>';
	$counter++;
	
	
	}
	$table.="</tbody>";
	
	echo <<<HED
<label>Registered ShortCodes</label>

<p>The following shortcodes are registered with the system</p>
<table  id="pluginTable">
$table
</table>
HED;
}


/* 
 * @uses $shortcode_tags,$shortcode_info
 *
 * @param string $tag Shortcode tag to be searched in post content.
 * @param callable $func Hook to run when shortcode is found.
 * @param string $desc , the desription of the shortcode
 */
function add_shortcode($tag, $func, $desc="Default Description") {
        global $shortcode_tags;
	global $shortcode_info; 
        if ( is_callable($func) )
                $shortcode_tags[(string)$tag] = $func;
		$shortcode_info[(string)$tag] = $desc;
}

/* 
 * @uses $shortcode_tags,$shortcode_info
 *
 * @param string $tag Shortcode tag 
 * @desc Description of the shortcode
 */
function add_shortcodeDesc($tag, $desc="") {
	global $shortcode_info; 
	$shortcode_info[(string)$tag] = $desc;
}


/**
 * Removes hook for shortcode.
 *
 * @uses $shortcode_tags
 *
 * @param string $tag shortcode tag to remove hook for.
 */
function remove_shortcode($tag) {
        global $shortcode_tags;

        unset($shortcode_tags[$tag]);
}

/**
 * Clear all shortcodes.
 *
 * This function is simple, it clears all of the shortcode tags by replacing the
 * shortcodes global by a empty array. This is actually a very efficient method
 * for removing all shortcodes.
 *
 * @uses $shortcode_tags
 */
function remove_all_shortcodes() {
        global $shortcode_tags;
        $shortcode_tags = array();
}


/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. 
 * 
 * @uses $shortcode_tags
 * @uses get_shortcode_regex() Gets the search pattern for searching shortcodes.
 *
 * @param string $content Content to search for shortcodes
 * @return string Content with shortcodes filtered out.
 */
function do_shortcode($content) {
        global $shortcode_tags;

        if (empty($shortcode_tags) || !is_array($shortcode_tags))
                return $content;

        $tagnames = array_keys($shortcode_tags);
        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );
        
		$removeTagsPattern = '/(\s*)(<p>\s*)(\[('.$tagregexp.')\b(.*?)(?:(\/))?\])(?:(.+?)\[\/\2\])?(.?)(\s*<\/p>)/';

		$content2 = preg_replace($removeTagsPattern, '$3 ', $content) ;
		
        $pattern = get_shortcode_regex();
        return preg_replace_callback('/'.$pattern.'/s', 'do_shortcode_tag', htmlspecialchars_decode($content2));
}

/**
 * Retrieve the shortcode regular expression for searching.
 *
 * The regular expression combines the shortcode tags in the regular expression
 * in a regex class.
 *
 * The regular expresion contains 6 different sub matches to help with parsing.
 *
 * 1/6 - An extra [ or ] to allow for escaping shortcodes with double [[]]
 * 2 - The shortcode name
 * 3 - The shortcode argument list
 * 4 - The self closing /
 * 5 - The content of a shortcode when it wraps some content.
 *
 * @uses $shortcode_tags
 *
 * @return string The shortcode search regular expression
 */
function get_shortcode_regex() {
        global $shortcode_tags;
        $tagnames = array_keys($shortcode_tags);
        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );

        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcodes()
        return '(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
//        return '(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
}

/**
 * Regular Expression callable for do_shortcode() for calling shortcode hook.
 * @see get_shortcode_regex for details of the match array contents.
 *
 * @access private
 * @uses $shortcode_tags
 *
 * @param array $m Regular expression match array
 * @return mixed False on failure.
 */
function do_shortcode_tag( $m ) {
        global $shortcode_tags;

        // allow [[foo]] syntax for escaping a tag
        if ( $m[1] == '[' && $m[6] == ']' ) {
                return substr($m[0], 1, -1);
        }

        $tag = $m[2];
        $attr = shortcode_parse_atts( $m[3] );

        if ( isset( $m[5] ) ) {
                // enclosing tag - extra parameter
                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, $m[5], $tag ) . $m[6];
        } else {
                // self-closing tag
                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, NULL,  $tag ) . $m[6];
        }
}

/**
 * Retrieve all attributes from the shortcodes tag.
 *
 * The attributes list has the attribute name as the key and the value of the
 * attribute as the value in the key/value pair. This allows for easier
 * retrieval of the attributes, since all attributes have to be known.
 *
 *
 * @param string $text
 * @return array List of attributes and their value.
 */
function shortcode_parse_atts($text) {
        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
                foreach ($match as $m) {
                        if (!empty($m[1]))
                                $atts[strtolower($m[1])] = stripcslashes($m[2]);
                        elseif (!empty($m[3]))
                                $atts[strtolower($m[3])] = stripcslashes($m[4]);
                        elseif (!empty($m[5]))
                                $atts[strtolower($m[5])] = stripcslashes($m[6]);
                        elseif (isset($m[7]) and strlen($m[7]))
                                $atts[] = stripcslashes($m[7]);
                        elseif (isset($m[8]))
                                $atts[] = stripcslashes($m[8]);
                }
        } else {
                $atts = ltrim($text);
        }
        return $atts;
}

/**
 * Combine user attributes with known attributes and fill in defaults when needed.
 *
 * The pairs should be considered to be all of the attributes which are
 * supported by the caller and given as a list. The returned attributes will
 * only contain the attributes in the $pairs list.
 *
 * If the $atts list has unsupported attributes, then they will be ignored and
 * removed from the final returned list.
 *
 *
 * @param array $pairs Entire list of supported attributes and their defaults.
 * @param array $atts User defined attributes in shortcode tag.
 * @return array Combined and filtered attribute list.
 */
function shortcode_atts($pairs, $atts) {
        $atts = (array)$atts;
        $out = array();
        foreach($pairs as $name => $default) {
                if ( array_key_exists($name, $atts) )
                        $out[$name] = $atts[$name];
                else
                        $out[$name] = $default;
        }
        return $out;
}

/**
 * Remove all shortcode tags from the given content.
 *
 * @uses $shortcode_tags
 *
 * @param string $content Content to remove shortcode tags.
 * @return string Content without shortcode tags.
 */
function strip_shortcodes( $content ) {
        global $shortcode_tags;

        if (empty($shortcode_tags) || !is_array($shortcode_tags))
                return $content;

        $pattern = get_shortcode_regex();

        return preg_replace('/'.$pattern.'/s', '$1$6', $content);
}



function output_shortcode($data){
	$ret=do_shortcode($data);
	echo $ret;
}

include GSPLUGINPATH.'gs_shortcodes/shortcodes.php';

if (file_exists(GSTHEMESPATH .$TEMPLATE.'/shortcodes.php')){
	include GSTHEMESPATH.$TEMPLATE.'/shortcodes.php';
	
}

add_filter('content','do_shortcode');
?>
