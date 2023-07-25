<?php

if(!function_exists('currency_idr')){
    function currency_idr($value)
{
    // Convert $value to a float or integer if it's a string
    $value = is_numeric($value) ? $value : (float) str_replace(',', '.', str_replace('.', '', $value));

    // Return the formatted number
    return number_format($value, 0, ',', '.');
}
}

if(!function_exists('currency_convert')){
    function currency_convert($value)
    {
        return preg_replace('/\D/', '', $value);
    }
}