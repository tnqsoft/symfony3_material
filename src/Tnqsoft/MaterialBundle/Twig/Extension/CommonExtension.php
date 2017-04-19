<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\NumberParseException;
use \libphonenumber\PhoneNumberFormat;

/**
 * Class AppExtension
 *
 * @package CommonExtension\Twig\Extension
 */
class CommonExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('strpad', array($this, 'strpadFilter')),
            new \Twig_SimpleFilter('jsonDecode', array($this, 'jsonDecodeFilter')),
            new \Twig_SimpleFilter('priceDisplay', array($this, 'priceDisplayFilter')),
            new \Twig_SimpleFilter('dateDisplay', array($this, 'dateDisplayFilter')),
            new \Twig_SimpleFilter('phoneFormat', array($this, 'phoneFormatFilter')),
            new \Twig_SimpleFilter('inArray', array($this, 'inArrayFilter')),
        );
    }

    /**
     * @param $string
     * @param int $count
     * @param string $symbol
     * @param string $position
     * @param bool $keepLen
     * @return mixed
     */
    public function strpadFilter($string, $count = 0, $symbol = '-', $position = 'L', $keepLen = false)
    {
        switch ($position) {
            case 'L':
                $posConst = STR_PAD_LEFT;
                break;
            case 'R':
                $posConst = STR_PAD_RIGHT;
                break;
            case 'B':
                $posConst = STR_PAD_BOTH;
                break;
            default:
                $posConst = STR_PAD_LEFT;
                break;
        }

        $len = (true === $keepLen)?intval($count)+mb_strlen($string):intval($count);

        $newString = $this->mb_str_pad($string, $len, $symbol, $posConst);

        return $newString;
    }

    /**
     * @param $price
     * @param string $symbol
     * @return string
     */
    public function priceDisplayFilter($price, $symbol='đ')
    {
        $formatNumber = number_format($price, 0, ',', '.');
        return $formatNumber.' '.$symbol;
    }

    /**
     * @param $string
     * @param bool $assoc
     * @return array|null
     */
    public function jsonDecodeFilter($string, $assoc=false)
    {
        if (empty($string)) {
            if ($assoc === true) {
                return array();
            } else {
                return null;
            }
        }

        return json_decode($string, $assoc);
    }

    /**
     * @param string $price
     * @return string
     */
    public function dateDisplayFilter($date)
    {
        $dateObject = $date;
        if (($date instanceof \DateTime) === false) {
            $dateObject = new \DateTime($date);
        }

        if ($dateObject->format('Ymd') === date('Ymd')) {
            return 'Hôm nay '.$dateObject->format('H:i');
        }

        return $dateObject->format('Y/m/d H:i');
    }

    /**
     * Phone Format Filter
     *
     * @param  string $phoneNumber
     * @param  string $locale Locale default
     * @return string
     */
    public function phoneFormatFilter($phoneNumber, $locale='VN')
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parseNumberProto = $phoneUtil->parse($phoneNumber, $locale);

            return $phoneUtil->format($parseNumberProto, PhoneNumberFormat::NATIONAL);
        } catch (NumberParseException $e) {
            return $phoneNumber;
        }
    }

    /**
     * In Array Filter
     *
     * @param  string $value Value is finded
     * @param  array $list List search
     * @return boolean
     */
    public function inArrayFilter($value, array $list)
    {
        return $this->inArrayInsensitive($value, $list);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'common_extension';
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @param $input
     * @param $pad_length
     * @param string $pad_string
     * @param int $pad_type
     * @param null $encoding
     * @return mixed
     */
    private function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = null)
    {
        if (!$encoding) {
            $diff = strlen($input) - mb_strlen($input);
        } else {
            $diff = strlen($input) - mb_strlen($input, $encoding);
        }
        return str_pad($input, $pad_length + $diff, $pad_string, $pad_type);
    }

    /**
     * In Array Insensitive
     *
     * @param  string $needle
     * @param  array $haystack
     * @return boolean
     */
    private function inArrayInsensitive($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
