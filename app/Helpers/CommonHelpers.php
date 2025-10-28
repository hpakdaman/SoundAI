<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('is_md5')) {
	/**
	 * Check if md5
	 * @return bool
	 */
	function is_md5($md5)
	{
		return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
	}
}

if (!function_exists('is_json')) {
	/**
	 * Check if md5
	 * @return bool
	 */
	function is_json($str)
	{
		json_decode($str);

		return (json_last_error() === JSON_ERROR_NONE);
	}
}

if (!function_exists('rmkdir')) {
    /**
     * Make directory recursive
     *
     * @param $dir
     * @return bool
     */

	function rmkdir($path, $mode = 0777)
	{
		$path = trim($path);
		$path = rtrim(preg_replace(["/\\\{2,}/", "/\/{2,}/"], "/", $path), "/");
		if (substr($path, 1, 1) == ":") {
			//win
			$s = substr($path, 0, 2);
			$path = substr($path, 3);
		} else {
			$s = null;
			$path = ltrim($path, './');
		}

		$dirs = explode('/', $path);
		$count = count($dirs);

		$oldmask = umask(0);
		for ($i = 0; $i < $count; ++$i) {
			$s .= '/' . $dirs[ $i ];
			if (@file_exists($s) || !@mkdir($s, $mode)) {
				continue;
			}
			@chmod($s, $mode);
		}
		umask($oldmask);
		return true;
	}
}


if (!function_exists('deleteDirectory')) {

    function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}

if ( ! function_exists('glob_recursive'))
{
    // Does not support flag GLOB_BRACE

    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }
}

if (!function_exists('is_localhost')) {
	/**
	 * check wheather is local server or not
	 * @return bool
	 */
	function is_localhost()
	{
		return isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], ['localhost', '127.0.0.1', '0.0.0.0', '::1','tp.test','trapay.test']);
	}
}

if (!function_exists('is_production')) {
	/**
	 * check wheather is in production level
	 * @return bool
	 */
	function is_production()
	{
		return app()->environment('production');
	}
}

if (!function_exists('is_base64')) {
	/**
	 * check if is base64
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	function is_base64($data)
	{
		if (preg_match('/^[a-zA-Z0-9\+\/]+\=*$/', $data))
			return true;
		return false;
	}
}

if (!function_exists('is_base64_file')) {
	/**
	 * check if is base64
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	function is_base64_file($data)
	{
		return preg_match('/^data\:\s*(?:[a-zA-Z]+\/[a-zA-Z]+);base64\,(?:[a-zA-Z0-9\+\/]+\=*)$/', $data) ? true : false;
	}
}

if (!function_exists('base64_decode_file')) {
	/**
	 * Decodes base64 encoded file string
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	function base64_decode_file($data)
	{
		if (preg_match('/^data\:\s*([a-zA-Z]+\/[a-zA-Z]+);base64\,([a-zA-Z0-9\+\/]+\=*)$/', $data, $matches)) {
			return [
				'mime' => $matches[1],
				'data' => base64_decode($matches[2]),
			];
		}
		return false;
	}
}

if (!function_exists('base64_encode_file')) {
	/**
	 * Returns encoded file string
	 *
	 * @param $file_path
	 *
	 * @return string
	 */
	function base64_encode_file($file_path, $mime = null)
	{
		// Read image path, convert to base64 encoding
		$data = @file_get_contents($file_path);
		$mime = $mime ?: (@mime_content_type($data) ?: 'text/plain');
		// Format the file to: data:{mime};base64,{data};
		return 'data:' . $mime . ';base64,' . base64_encode($data);
	}
}

if (!function_exists('mime_content_type')) {
	function mime_content_type($filename)
	{
		$result = new finfo();
		if (is_resource($result) === true) {
			return $result->file($filename, FILEINFO_MIME_TYPE);
		}

		return false;
	}
}


if (!function_exists('is_serialized')) {
	/**
	 * check if serialized
	 *
	 * @param $str
	 *
	 * @return bool
	 */
	function is_serialized($str)
	{
		return ($str == serialize(false) || @unserialize($str) !== false);
	}
}
if (!function_exists('ddd')) {
	/**
	 * Debug data without stoping
	 */
	function ddd()
	{
		echo "<style> div>.sf-dump{ margin: 0; } </style>";
		echo "<div style='direction: ltr; background: #E9900A none repeat scroll 0% 0% !important; padding: 4px 6px 4px 6px;margin:0;'>";
		array_map(function ($x) {
			(new \Illuminate\Support\Debug\Dumper())->dump($x);
		}, func_get_args());
		echo "</div>";
	}
}

if (!function_exists('dd_next_query')) {
	function dd_next_query()
	{
		DB::listen(function ($query) {
			$sql = $esql = $query->sql;
			$bindings = $query->bindings;
			$time = $query->time;

			if ($bindings) {
				$pdo = DB::getPdo();
				foreach ($bindings as $binding)
					$esql = preg_replace('/\?/', $pdo->quote($binding), $esql, 1);

				$res = (object)[
					'sql'          => $sql,
					'bindingss'    => $bindings,
					'executed_sql' => $esql,
					'time'         => $time,
				];
			} else {
				$res = (object)[
					'sql'  => $sql,
					'time' => $time,
				];
			}
			dd($res);
		});
	}
}

function getEloquentSqlWithBindings($query)
{
    return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
        return is_numeric($binding) ? $binding : "'{$binding}'";
    })->toArray());
}


if (!function_exists('posts_all')) {
	/**
	 * Get all posts
	 * @return array
	 */
	function posts_all()
	{
		$args = parse_args(func_get_args());
		if ($args)
			$all = request()->only($args);
		else
			$all = request()->all();

		$queries = request()->query();
		return array_diff_key_recursive($all, $queries);
	}
}


if (!function_exists('posts_except')) {

	function posts_except()
	{
		$args = parse_args(func_get_args());
		if ($args)
			$all = request()->except($args);
		else
			$all = request()->input();

		$queries = request()->query();
		return array_diff_key_recursive($all, $queries);
	}

}


if (!function_exists('left_ch')) {
	/**
	 * Removes tralin char and add one left
	 *
	 * @param $dir
	 *
	 * @return string
	 */
	function left_ch($dir, $ch = '/')
	{
		$trimed = ltrim($dir, $ch);
		if (!empty($trimed))
			return $ch . $trimed;
	}
}


if (!function_exists('right_ch')) {
	/**
	 * Removes tralin char and add one right
	 *
	 * @param $dir
	 *
	 * @return string
	 */
	function right_ch($dir, $ch = '/')
	{
		// Ensure $dir is a string to avoid rtrim() array error
		if (!is_string($dir)) {
			return '';
		}
		$trimed = rtrim($dir, $ch);
		if (!empty($trimed))
			return $trimed . $ch;
	}
}

if (!function_exists('int_random')) {
	/**
	 * Generate a more truly "random" numeric string.
	 *
	 * @param  int $length
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	function int_random($length = 11)
	{
		$a = null;
		for ($i = 0; $i < $length; $i++) {
			if ($length > 1 && $i == 0)
				$a .= mt_rand(1, 9);
			else
				$a .= mt_rand(0, 9);
		}
		return $a;
	}
}

if (!function_exists('controller_name')) {
	/**
	 * returns the current action name
	 * @return string
	 */
	function controller_name()
	{
		list($controller) = explode('@', Route::getCurrentRoute()->getActionName());
		$controller = explode('\\', $controller);
		return end($controller);
	}
}


if (!function_exists('action_name')) {
	/**
	 * returns the current action name
	 * @return string
	 */
	function action_name()
	{
		list(, $action) = explode('@', \Route::getCurrentRoute()->getActionName());
		return $action;
	}
}


if (!function_exists('is_editing')) {

	function is_editing()
	{
		return action_name() == 'edit';
	}
}

if (!function_exists('is_creating')) {

	function is_creating()
	{
		return action_name() == 'create';
	}
}


if (!function_exists('gen_uuid')) {
	/**
	 * Generate universal unique ID
	 * @return string
	 */
	function gen_uuid()
	{
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

}


if (!function_exists('upload_img')) {
	/**
	 * Resize image on fly on save it to given path
	 *
	 * @param $maxwidth
	 * @param $maxheight
	 * @param int $quality
	 * quality is optional, and ranges from 0 (worst
	 * quality, smaller file) to 100 (best quality, biggest file). The
	 * default is the default IJG quality value (about 75).
	 * @param $dir
	 * @param $image
	 *
	 * @return bool
	 */
	function upload_img($maxwidth, $maxheight, $quality, $dir, $image)
	{

		$msg = false;

		if ($dir != "" && $image != "") {
			$size = getimagesize("$image");

			$width_1 = $size[0];
			$height_1 = $size[1];

			if ($height_1 <= $maxheight || $width_1 <= $maxwidth) {
				$n_width = $width_1;
				$n_height = $height_1;
			}

			if ($height_1 > $maxheight) {
				$n_height = $maxheight;
				$percent = ($size[1] / $n_height);
				$n_width = ($size[0] / $percent);
			} else if ($width_1 > $maxwidth) {
				$n_width = $maxwidth;
				$percent = ($size[0] / $n_width);
				$n_height = ($size[1] / $percent);
			}

			if ($n_height > $maxheight) {
				$n_height = $maxheight;
				$percent = ($size[1] / $n_height);
				$n_width = ($size[0] / $percent);
			} else if ($n_width > $maxwidth) {
				$n_width = $maxwidth;
				$percent = ($size[0] / $n_width);
				$n_height = ($size[1] / $percent);
			}

			$image_p = imagecreatetruecolor($n_width, $n_height);
			$image_q = imagecreatefromjpeg($image);
			imagecopyresampled($image_p, $image_q, 0, 0, 0, 0, $n_width, $n_height, $width_1, $height_1);

			if (imagejpeg($image_p, $dir, $quality)) {
				$msg = true;
			} else {
				$msg = false;
			}
		}

		return $msg;

	}
}


if (!function_exists('str_uslug')) {
	/**
	 * Generate a unicode URL friendly "slug" from a given string
	 *
	 * @param $string
	 *
	 * @return mixed|string
	 */
	function str_uslug($string)
	{
		$LNSH = '/[^\_\-\s\pN\pL]+/u';
		$SADH = '/[\_\-\s]+/';

		$string = preg_replace($LNSH, '', mb_strtolower($string, 'UTF-8'));
		$string = preg_replace($SADH, '-', $string);
		$string = trim($string, '-');

		return $string;
	}
}


if (!function_exists('str_unique_uslug')) {
	/**
	 * Generate a unique and  unicode URL friendly "slug" from a given string
	 *
	 * @param $title
	 * @param $model
	 * @param $field
	 *
	 * @return mixed|string
	 */
	function str_unique_uslug($title, $model, $field = 'slug', $exceptId = null, $primaryKeyField = 'id')
	{
		$slug = str_uslug($title);

		$qb = $model->whereRaw($field . " REGEXP '^{$slug}(-[0-9]*)?$'");

		if ($exceptId && $primaryKeyField)
			$qb->where($primaryKeyField, '<>', $exceptId);

		$slugCount = count($qb->get());

		return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
	}
}


if (!function_exists('str_unique_random')) {
	/**
	 * Generate a unique random string
	 *
	 * @param $title
	 * @param $model
	 * @param $field
	 *
	 * @return mixed|string
	 */
	function str_unique_random($length, $model, $field = 'rand')
	{
		$rand = strtolower(str_random($length));
		while ($model->where($field, $rand)->count()) {
			$rand = str_random($length);
		}
		return $rand;
	}
}

if (!function_exists('fix_persian_num')) {
	/**
	 * convert the given number to persian
	 *
	 * @param $text
	 *
	 * @param bool $flip
	 *
	 * @return null|string
	 */
	function fix_persian_num($text,$flip=false)
	{

		if (is_null($text)) {
			return null;
		}
		$replacePairs = [
			'0' => chr(0xDB) . chr(0xB0),
			'1' => chr(0xDB) . chr(0xB1),
			'2' => chr(0xDB) . chr(0xB2),
			'3' => chr(0xDB) . chr(0xB3),
			'4' => chr(0xDB) . chr(0xB4),
			'5' => chr(0xDB) . chr(0xB5),
			'6' => chr(0xDB) . chr(0xB6),
			'7' => chr(0xDB) . chr(0xB7),
			'8' => chr(0xDB) . chr(0xB8),
			'9' => chr(0xDB) . chr(0xB9),
		];

		if($flip)
			$replacePairs = array_flip($replacePairs);

		return strtr($text, $replacePairs);

	}
}


if (!function_exists('validation_state')) {
	/**
	 * validation state helper
	 *
	 * @param \Illuminate\Support\ViewErrorBag $errors
	 * @param array|string $names
	 * @param string $context
	 *
	 * @return string
	 */
	function validation_state(Illuminate\Support\ViewErrorBag $errors, $names, $context = 'has-danger')
	{
		//normalize input to array
		if (!is_array($names)) {
			$names = [$names];
		}
		//check if error exists
		foreach ($names as $name) {
			if ($errors->has($name)) {
				return $context;
			}
		}
		//no error
		return '';
	}
}

if (!function_exists('select_raw')) {
	/**
	 * Set the columns to be selected.
	 *
	 * @param  array $columns
	 *
	 * @return mixed
	 */
	function select_raw($columns = ['1 as res'], $binding = [], $raw = true)
	{
		if ($raw)
			array_walk($columns, function (&$v) {
				$v = \DB::raw($v);
			});

		$db = app('db');
		$processor = $db->getPostProcessor();
		$query = (new Illuminate\Database\Query\Builder(current($db->getConnections()), $db->getQueryGrammar(), $processor))
			->select((array)$columns);

		if ($binding) {
			foreach ($binding as $bind)
				$query->mergeBindings($bind);
		}
		return $query;
	}
}


/**
 * version of sprintf for cases where named arguments are desired (php syntax)
 *
 * with sprintf: sprintf('second: %2$s ; first: %1$s', '1st', '2nd');
 *
 * with sprintfn: sprintfn('second: %second$s ; first: %first$s', array(
 *  'first' => '1st',
 *  'second'=> '2nd'
 * ));
 *
 * @param string $format sprintf format string, with any number of named arguments
 * @param array $args    array of [ 'arg_name' => 'arg value', ... ] replacements to be made
 *
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
		$format = substr_replace($format, $replace = $arg_nums[ $arg_key ], $arg_pos, $arg_len);
		$pos = $arg_pos + strlen($replace); // skip to end of replacement for next iteration
	}

	return vsprintf($format, array_values($args));
}

/**
 * If you want a simple way to show values that are in either array, but not both, you can use this
 * @param $a
 * @param $b
 *
 * @return array
 */
function array_diff_sides($a, $b) {
    $intersect = array_intersect($a, $b);
    return array_merge(array_diff($a, $intersect), array_diff($b, $intersect));
}




/**
 * Creates the unique browser fingerprint
 * We use it for validating web authentication
 * @return string
 */
function getBrowserFingerprint() {
    $client_ip = request()->ip();
    $user_agent = request()->server('HTTP_USER_AGENT');
    //$accept   = request()->server('HTTP_ACCEPT');
    //$charset  = request()->server('HTTP_ACCEPT_CHARSET');
    $encoding = request()->server('HTTP_ACCEPT_ENCODING');
    $language = request()->server('HTTP_ACCEPT_LANGUAGE');
    $data = '';
    $data .= $client_ip.'|';
    $data .= $user_agent.'|';
    //$data .= $accept.'|';
    //$data .= $charset.'|';
    $data .= $encoding.'|';
    $data .= $language.'|';
    return md5($data);
}