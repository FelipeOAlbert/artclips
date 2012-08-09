<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Asset Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Philip Sturgeon < phil.sturgeon@styledna.net >
*/

// ------------------------------------------------------------------------


/**
  * General Asset Helper
  *
  * Helps generate links to asset files of any sort. Asset type should be the
  * name of the folder they are stored in.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    the asset type (name of folder)
  * @param		string    optional, module name
  * @return		string    full url to asset
  */

function other_asset_url($asset_name, $module_name = NULL, $asset_type = NULL)
{
	if( strpos($asset_name, 'http://') !== false ) return $asset_name;
	$obj =& get_instance();
	$base_url = $obj->config->item('base_url');

	$asset_location = $base_url.'';

	if(!empty($module_name)):
		$asset_location .= 'modules/'.$module_name.'/';
	endif;

	$asset_location .= $asset_type.'/'.$asset_name;

	return $asset_location;

}


// ------------------------------------------------------------------------

/**
  * Parse HTML Attributes
  *
  * Turns an array of attributes into a string
  *
  * @access		public
  * @param		array		attributes to be parsed
  * @return		string 		string of html attributes
  */

function _parse_asset_html($attributes = NULL)
{

	if(is_array($attributes)):
		$attribute_str = '';

		foreach($attributes as $key => $value):
			$attribute_str .= ' '.$key.'="'.$value.'"';
		endforeach;

		return $attribute_str;
	endif;

	return '';
}


// ------------------------------------------------------------------------

/**
  * @access		public
  * @param		string    the pack to include in HTML document
  * @param		string    the path to validate include or not include
  * @param		string    optional, boolean to include once
  * @return		string    pack or empty string
  */

function include_once_pack($pack, $path, $include_once = TRUE)
{
	$CI = &get_instance();
	
	$include = array();
	
	if ( !$CI->input->is_ajax_request() )
		$include = $CI->config->item('include_once');
	else
		$include = $CI->phpsession->get('include_once');
		
	//print_r($include);
	if (! is_array($include))
		$include = array();
		
	if ( isset($include[$path]) ) {
		
		if (! $include_once) {
			$include[$path]++;
			return $pack;
		}
		
		return '';
	
	} else {
		$include[$path] = 1;
		
		$CI->phpsession->save('include_once', $include);
		$CI->config->set_item('include_once', $include);
		
		return $pack;
	}
}


// ------------------------------------------------------------------------

/**
  * CSS Asset Helper
  *
  * Helps generate CSS asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to css asset
  */

function css_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'css');
}


// ------------------------------------------------------------------------

/**
  * CSS Asset HTML Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @param		string    optional, extra attributes
  * @return		string    HTML code for JavaScript asset
  */

function css($asset_name, $module_name = NULL, $attributes = array())
{
	$attribute_str = _parse_asset_html($attributes);
	
	$url = css_url($asset_name, $module_name);
	
	return include_once_pack('<link href="' . $url . '" rel="stylesheet" type="text/css"'.$attribute_str.' />', $url);
}

// ------------------------------------------------------------------------

/**
  * Image Asset Helper
  *
  * Helps generate CSS asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to image asset
  */

function img_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'images');
}


// ------------------------------------------------------------------------

/**
  * Image Asset HTML Helper
  *
  * Helps generate image HTML.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @param		string    optional, extra attributes
  * @return		string    HTML code for image asset
  */

function img($asset_name, $module_name = '', $attributes = array())
{
	$attribute_str = _parse_asset_html($attributes);

	return '<img src="'.img_url($asset_name, $module_name).'"'.$attribute_str.' />';
}


// ------------------------------------------------------------------------

/**
  * JavaScript Asset URL Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to JavaScript asset
  */

function js_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'js');
}


// ------------------------------------------------------------------------

/**
  * JavaScript Asset HTML Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    HTML code for JavaScript asset
  */

function js($asset_name, $module_name = NULL)
{
	$url = js_url($asset_name, $module_name);
	
	return include_once_pack('<script type="text/javascript" src="' . $url . '"></script>', $url);
}

function printr($array = ''){
	print '<pre>';
	print_r($array);
	die('fim array');
}

?>
