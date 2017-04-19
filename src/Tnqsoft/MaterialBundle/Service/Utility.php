<?php

namespace Tnqsoft\MaterialBundle\Service;

class Utility
{
    /**
     * Generate Slug from string Unicode
     *
     * @param string $str
     * @return string
     */
    public static function slugify($str)
    {
        $tmp = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $tmp = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $tmp);
        $tmp = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $tmp);
        $tmp = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $tmp);
        $tmp = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $tmp);
        $tmp = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $tmp);
        $tmp = preg_replace("/(đ)/", 'd', $tmp);
        $tmp = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $tmp);
        $tmp = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $tmp);
        $tmp = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $tmp);
        $tmp = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $tmp);
        $tmp = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $tmp);
        $tmp = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $tmp);
        $tmp = preg_replace("/(Đ)/", 'D', $tmp);
        $tmp = strtolower(trim($tmp));
        //$tmp = str_replace('-','',$tmp);
        $tmp = str_replace(' ', '-', $tmp);
        $tmp = str_replace('_', '-', $tmp);
        $tmp = str_replace('.', '', $tmp);
        $tmp = str_replace("'", '', $tmp);
        $tmp = str_replace('"', '', $tmp);
        $tmp = str_replace('"', '', $tmp);
        $tmp = str_replace('"', '', $tmp);
        $tmp = str_replace("'", '', $tmp);
        $tmp = str_replace('̀', '', $tmp);
        $tmp = str_replace('&', '', $tmp);
        $tmp = str_replace('@', '', $tmp);
        $tmp = str_replace('^', '', $tmp);
        $tmp = str_replace('=', '', $tmp);
        $tmp = str_replace('+', '', $tmp);
        $tmp = str_replace(':', '', $tmp);
        $tmp = str_replace(',', '', $tmp);
        $tmp = str_replace('{', '', $tmp);
        $tmp = str_replace('}', '', $tmp);
        $tmp = str_replace('?', '', $tmp);
        $tmp = str_replace('\\', '', $tmp);
        $tmp = str_replace('/', '', $tmp);
        $tmp = str_replace('quot;', '', $tmp);
        return $tmp;
    }

    /**
     * Generate random string
     *
     * @param  int  $length
     * @return string
     */
    public static function stringRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }


    /**
     * Delete all file and sub folder
     *
     * @param string $dirPath
     */
    public static function deleteDirectory($dirPath)
    {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object !="..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        static::deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dirPath);
        }
    }

    /**
     * Get IP
     *
     * @return string
     * @SuppressWarnings(PHPMD)
     */
    public static function getIP()
    {
        $ipKeys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ipList = explode(',', $_SERVER[$key]);
                return $ipList[0];
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : (gethostbyname(gethostname()));
    }

    /**
     * Check age over 18
     *
     * @param  string  $birthday with format like yyyy-mm-dd
     * @return boolean
     */
    public static function isOver18($birthday)
    {
        if (null === $birthday) {
            return false;
        }
        $birthDate = strtotime('+18 years', strtotime($birthday));
        if ($birthDate < time()) {
            return true;
        }

        return false;
    }

    /**
     * Get GUID
     *
     * @return string
     */
    public static function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid, 12, 4).$hyphen
                    .substr($charid, 16, 4).$hyphen
                    .substr($charid, 20, 12);
            return $uuid;
        }
    }

    /**
     * Format Duration
     *
     * @param  integer $duration
     * @return string
     */
    public static function formatDuration($duration)
    {
        $result = gmdate("H\\h i\\m s\\s", $duration);

        if ($duration < 60) {
            $result = gmdate("s\\s", $duration);
        } elseif ($duration > 60 && $duration < 3600) {
            $result = gmdate("i\\m s\\s", $duration);
        }

        return preg_replace('/(0)([0-9])/i', '$2', $result);
    }

    /**
     * Human File Size
     *
     * @param  float  $size
     * @param  integer $precision [description]
     * @return string
     */
    public static function humanFilesize($size, $precision = 2)
    {
        static $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision).$units[$i];
    }

    /**
     * Get value in array
     *
     * @param  array $data
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function valueOf(array $data, $key, $default=null, $isBoolean=false)
    {
        if (isset($data[$key])) {
            $value = $data[$key];
            if ($isBoolean) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
            return $value;
        }

        return $default;
    }

    /**
     * Nice time
     *
     * @param  string $date
     * @return string
     */
    public static function nicetime($date)
    {
        if (empty($date)) {
            return "No date provided";
        }
        $periods = array("giây", "phút", "giờ", "ngày", "tuần", "tháng", "năm", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);
        if (empty($unix_date)) {
            return "Bad date";
        }
        if ($now > $unix_date) {
            $difference     = $now - $unix_date;
            $tense         = "trước";
        } else {
            $difference     = $unix_date - $now;
            $tense         = "trước";
        }
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);

        return "$difference $periods[$j] {$tense}";
    }

    /**
     * Mask Phone Number
     *
     * @param  string $phone
     * @return string
     */
    public function maskPhoneNumber($phone)
    {
        return preg_replace('/^([0-9]+)([0-9]{3})$/', '$1***', $phone);
    }

    /**
     * Get Image In Folder
     *
     * @param  string  $folder
     * @return array
     */
    public static function getImageInFolder($folder)
    {
        $images = array();
        if (!is_dir($folder)) {
            return $images;
        }

        $listFiles = glob($folder.'*.{jpg,jpeg,png,gif,bmp,pdf}', GLOB_BRACE);
        if (is_array($listFiles) && !empty($listFiles)) {
            foreach ($listFiles as $file) {
                $pathParts = pathinfo($file);
                $images[] = $pathParts['basename'];
            }
        }

        return $images;
    }

    /**
     * Is Image
     *
     * @param  string  $filename
     * @return boolean
     */
    public static function isImage($filename)
    {
        $validFormats = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_BMP);
        $fileFormat = exif_imagetype($filename);
        return in_array($fileFormat, $validFormats);
    }

}
