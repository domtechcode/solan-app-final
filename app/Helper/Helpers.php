<?php

if(!function_exists('currency_idr')){
    function currency_idr($value)
    {
        // return "Rp. " . number_format($value, 0, ',', '.');
        return number_format($value, 0, ',', '.');
    }
}

if(!function_exists('currency_convert')){
    function currency_convert($value)
    {
        return preg_replace('/\D/', '', $value);
    }
}