<?php
namespace FixedWidthFile\Formatters;

class LMDecimal implements FormatterInterface
{
    /**
     * Format value with max length
     *
     * @param  mixed   $data
     * @param  integer $length
     * @return mixed
     */
    public function format($data, $length)
    {
        $lengths = explode(",", $length);

		if(strpos($data, ".")) {
            $value = $this->getFormatWithDecimal($data, $lengths);
        }
        else {
            $value = $this->getFormatNoDecimal($data, $lengths);
		}

        return $value;
    }

    private function getFormatWithDecimal($data, $lengths)
    {
        $parts = explode(".", $data);
        $value = sprintf("%0{$lengths[0]}d", $parts[0]);

        if (array_key_exists(1, $lengths)) {
            $value.= str_pad($parts[1], $lengths[1], '0');
        }

        return $value;
    }

    private function getFormatNoDecimal($data, $lengths)
    {
        if (array_key_exists(1, $lengths)) {
            $value = intval(substr($data, 0, $lengths[0]));
            $value.= $this->getMultipleLengthValue($data, $lengths);
        }
        else {
            $data = intval($data);
            $value = $this->getSingleLengthValue($data, $lengths[0]);
        }

        return $value;
    }

    private function getMultipleLengthValue($data, $lengths)
    {
        $returnValue = '';

        $value = intval(substr($data, $lengths[0], $lengths[1]));

        if ($value > 0) {
            $returnValue .= $value;
        }

        $returnValue = str_pad($returnValue, $lengths[0] + $lengths[1], '0', STR_PAD_LEFT);

        return $returnValue;
    }

    private function getSingleLengthValue($data, $length)
    {
        return  str_pad($data, $length, '0', STR_PAD_LEFT);
    }
}
