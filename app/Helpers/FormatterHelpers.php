<?php


if (!function_exists('to_price')) {
    /**
     * Convert a float number to price value base on language it works on  Linux and Windows etc..
     * Author : Hamed Pakdaman (larabook.ir)
     * @param $amount
     * @param string $local
     * @param string $format ( just work on Linux)
     * @return string
     */
    function to_price($amount, $locale = 'fa_IRT', $html = true)
    {
        $shema = [
            'dollar' => ['$', '', 2, '.', ',', 0],                  //  United State
            'en_US'  => ['$', ' USD', 2, '.', ',', 0],              //  United State
            'en_AU'  => ['$', ' AU', 2, '.', ' ', 0],               //  Australian Dollar
            'en_CA'  => ['$', ' CAD', 2, '.', ',', 0],              //  Canadian Dollar
            'sv_AX'  => ['&euro;', NULL, 2, ',', '.', 0],           //  Euro
            'en_GG'  => ['&pound;', NULL, 2, '.', ',', 0],          //  Pound Sterling
            'fa_IR'  => [NULL, ' ربال', 0, '.', ',', 0],            //  Iranian Rial
            'fa_IRT' => [NULL, ' تومان', 0, '.', ',', 0],           //  Iranian Rial
            'ar_SA'  => [NULL, NULL, 2, '.', ',', 0],               //  Saudi Riyal
            'ar_AE'  => [NULL, NULL, 2, '.', ',', 0],               //  UAE Dirham
        ];

        $number = number_format(abs($amount), $shema[$locale][2], $shema[$locale][3], $shema[$locale][4]);
        //adding the symbol in the back
        if ($shema[$locale][0] === NULL && $shema[$locale][1] === NULL)
            $number .= ' ' . $locale;
        elseif ($shema[$locale][5] === 1)
            $number = $shema[$locale][1] . $number . $shema[$locale][0];
        //normally in front
        else
            $number = $shema[$locale][0] . $number . $shema[$locale][1];

        // برای واحد ایران اعداد فارسی نمایش داده شوند
        if ($locale == 'fa_IR' || $locale == 'fa_IRT') {
            $number = fix_persian_num($number);
        }

        if ($amount < 0 && $html) {
            return "<span style='color:red'>(" . $number . ")</span>";
        }
        return $number;
    }
}


if (!function_exists('is_price')) {
    /**
     * to price
     * @param $price
     * @return bool
     */
    function is_price($price)
    {
        if (preg_match("/^[\$]?[-+]?[\d\,]+\s*(usd|ریال|تومان)?$/i", $price))
            if (preg_match("/[\$]|usd|ریال|تومان/i", $price))
                return true;
        return false;
    }
}


if (!function_exists('str2int')) {
    /** Compelex string to integer
     * @param $string
     * @param bool $concat
     * @return int
     */
    function str2int($string, $concat = true)
    {
        if (is_numeric($string))
            return intval($string);
        $length = strlen($string);
        for ($i = 0, $int = '', $concat_flag = true; $i < $length; $i++) {
            if (is_numeric($string[$i]) && $concat_flag) {
                $int .= $string[$i];
            } elseif (!$concat && $concat_flag && strlen($int) > 0) {
                $concat_flag = false;
            }
        }
        //--sign
        if (($pos = strpos($string, '-')) !== false)
            if (is_numeric(substr($string, $pos + 1, 1)))
                $int = '-' . $int;

        return intval($int);
    }
}


if (!function_exists('to_integer')) {
    /**
     * To Integer
     * @param $string
     * @param null $default
     * @return int|null
     */
    function to_integer($string, $default = NULL)
    {
        if (is_numeric(str2int($string)))
            return str2int($string);
        return $default;
    }
}


if (!function_exists('to_bool')) {
    /**
     * To boolean
     * @param $value
     * @param bool $default
     * @return bool
     */
    function to_bool($value, $default = false)
    {
        if (is_bool($value))
            return $value;
        if (!is_scalar($value))
            return $default;
        $trues = ";1;t;y;yes;on;enabled;enable;active;true;بله;آری;صحیح;فعال;درست;نعم;";
        $falses = ";0;f;n;no;off;disabled;disable;inactive;false;null;;خیر;نه;غلط;غیر فعال;لا;";
        if (strpos($trues, ";" . strtolower($value) . ";") !== false)
            return true;
        if (strpos($falses, ";" . strtolower($value) . ";") !== false)
            return false;
        return $default;
    }

}


if (!function_exists('is_bool_type')) {
    /**
     * check if bool
     * @param $value
     * @return bool
     */
    function is_bool_type($value)
    {
        if (is_bool($value))
            return true;
        if (!is_scalar($value))
            return false;
        $trues = ";1;t;y;yes;on;enabled;enable;active;true;بله;آری;صحیح;فعال;درست;نعم;";
        $falses = ";0;f;n;no;off;disabled;disable;inactive;false;خیر;نه;غلط;غیر فعال;لا;";
        if (strpos($trues . $falses, ";" . strtolower($value) . ";") !== false)
            return true;
        return false;
    }
}

if (!function_exists('to_double')) {
    /**
     * To Double
     * @param $s
     * @param null $default
     * @return float|null
     */
    function to_double($s, $default = NULL)
    {
        if (is_numeric($s))
            return doubleval($s);
        return $default;
    }
}


if (!function_exists('phone')) {
    /**
     * phone formatter
     *
     * @param string $phone
     * @return string
     */
    function phone($phone)
    {
        //do we have an extension?
        //strip out non-numerics
        $phone = preg_replace("/[^0-9]/", "", $phone);
        //area code
        if (strlen($phone) == 10) {
            $phone = '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
        } //no area code
        elseif (strlen($phone) == 7) {
            $phone = substr($phone, 0, 3) . '-' . substr($phone, 3, 4);
        }
        //return
        return $phone;
    }
}

if (!function_exists('irPhone')) {
    /**
     * phone formatter
     *
     * @param string $phone
     * @return string
     */
    function irPhone($phone)
    {
        return $phone ? preg_replace('/.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*/', '0$1$2$3', $phone) : false;
    }
}


if (!function_exists('irLandLine')) {
    /**
     * +987138335832
     * 00987138335832
     * 0987138335832
     * 987138335832
     * 07138335832
     * 38325832
     * phone formatter
     *
     * @param string $phone
     * @return string
     */
    function irLandLine($phone)
    {
        return $phone ? preg_replace('/(\+98|0+98|98|0)?([1-8][0-9])([\d]{8})/', '0$2$3', $phone) : false;
    }
}


if (!function_exists('blurb')) {
    /**
     * blurb
     *
     * @param string $blurb
     * @param integer $maxChars
     * @param string $suffix
     * @param bool $br
     * @return string
     */
    function blurb($blurb, $maxChars = NULL, $suffix = '...', $br = true)
    {
        //blurb is shorter than max chars
        if (strlen($blurb) < $maxChars) {
            return nl2br($blurb);
        }
        //shorten output
        if ($maxChars) {
            $blurb = wordwrap($blurb, $maxChars, '<>');
            $blurb = explode('<>', $blurb);
            $blurb = $blurb[0];
        }
        //full output with line breaks
        if ($br) {
            $blurb = nl2br($blurb);
        }
        //return
        return $blurb . $suffix;
    }
}

if (!function_exists('format_bytes')) {
    /**
     * format bytes into something human readable
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function format_bytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        //calculate bytes
        $bytes /= pow(1024, $pow);
        //return the bytes
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}


if (!function_exists('sprintfn')) {
    /**
     * version of sprintf for cases where named arguments are desired (php syntax)
     * http://php.net/manual/en/function.sprintf.php
     * with sprintf: sprintf('second: %2$s ; first: %1$s', '1st', '2nd');
     *
     * with sprintfn: sprintfn('second: %second$s ; first: %first$s', array(
     *    'first' => '1st',
     *    'second'=> '2nd'
     * ));
     *
     * @param string $format sprintf format string, with any number of named arguments
     * @param array $args array of [ 'arg_name' => 'arg value', ... ] replacements to be made
     * @return string|false result of sprintf call, or bool false on error
     */
    function sprintfn($format, array $args = [])
    {
        // map of argument names to their corresponding sprintf numeric argument value
        $arg_nums = array_slice(array_flip(array_keys([0 => 0] + $args)), 1);

        // find the next named argument. each search starts at the end of the previous replacement.
        for ($pos = 0; preg_match('/(?<=%)([a-zA-Z_]\w*)(?=\$)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
            $arg_pos = $match[0][1];
            $arg_len = strlen($match[0][0]);
            $arg_key = $match[1][0];

            // programmer did not supply a value for the named argument found in the format string
            if (!array_key_exists($arg_key, $arg_nums)) {
                user_error("sprintfn(): Missing argument '{$arg_key}'", E_USER_WARNING);
                return false;
            }

            // replace the named argument with the corresponding numeric one
            $format = substr_replace($format, $replace = $arg_nums[$arg_key], $arg_pos, $arg_len);
            $pos = $arg_pos + strlen($replace); // skip to end of replacement for next iteration
        }

        return vsprintf($format, array_values($args));
    }
}


if (!function_exists('round_price')) {
    /**
     * round the given price
     * @param $price
     * @param int $by
     * @param bool|true $up
     * @return int
     */
    function round_price($price, $by = 50, $up = true)
    {
        if ($up)
            $price = ceil($price / $by);
        else
            $price = floor($price / $by);

        return intval($price * $by);
    }
}


if (!function_exists('str_rlimit')) {
    /**
     * Limit the number of characters in a string. (starts limiting from right)
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    function str_rlimit($value, $limit = 100, $end = '...')
    {
        $len = (int)mb_strwidth($value, 'UTF-8');
        if ($len <= $limit) {
            return $value;
        }

        return $end . ltrim(mb_strimwidth($value, $len - $limit, $limit, '', 'UTF-8'));
    }
}

if (!function_exists('blind')) {
    function blind($string, $from, $length = NULL, $ch = '*')
    {
        $len = strlen($string);
        $first = substr($string, 0, $from);

        if ($length) {
            $middle = substr($string, $from, $length);
            $last = $length ? substr($string, $length + $from) : NULL;
        } else {
            $middle = substr($string, $from);
            $last = NULL;
        }
        return $first . str_repeat($ch, strlen($middle)) . $last;
    }
}

if (!function_exists('br2nl')) {
    /**
     * reverse function for nl2br
     * @param $string - string with br's
     * @return string - string with \n
     */
    function br2nl($string)
    {
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }
}


function extractIban($admin_description)
{
    preg_match('/IR[0-9]{24}/', str_replace('-', '', $admin_description), $matches);
    return isset($matches[0]) ? $matches[0] : null;
}