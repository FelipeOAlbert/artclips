<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_EUA_to_BR'))
{
	function date_EUA_to_BR($str)
	{
		return implode('/',array_reverse(explode('-',$str)));
	}
}

if ( ! function_exists('date_BR_to_EUA'))
{
	function date_BR_to_EUA($str)
	{
		return implode('-',array_reverse(explode('/',$str)));
	}
}

if ( ! function_exists('convert_days_in_month'))
{
	function convert_days_in_month($days)
	{
		return (int) ceil( ($days * 12) / 365);
	}
}

if ( ! function_exists('convert_days_in_month_text'))
{
	function convert_days_in_month_text($days)
	{
		$meses = (int) convert_days_in_month($days);
		if ($meses == 1)
			return $meses . ' m&ecirc;s';
		
		if ($meses > 1)
			return $meses . ' meses';
	}
}
?>
