<?php
namespace FixedWidthFile\Formatters;

class LMDecimal implements FormatterInterface
{
    /**
     * Format value with max length
     *
     * @param  mixed   $data
     * @param  integer $length
     * @param  boolean $debug (optional)
     * @return mixed
     */
    public function format($data, $length, $debug = false)
    {
        $lengths = explode(",", $length);

		if(strpos($data, ".")) {
            // We found the decimal place. we can use this
			$parts = explode(".", $data);
			$value = sprintf("%0{$lengths[0]}d", $parts[0]);

            if (array_key_exists(1, $lengths)) {
                $value.= str_pad($parts[1], $lengths[1], '0');
            }
        }
        else {
            // No decimal place found. If there are two lengths then fake it
            $value = intval(substr($data, 0, $lengths[0]));

            if (array_key_exists(1, $lengths)) {
                $value2 = intval(substr($data, $lengths[0], $lengths[1]));

                if ($value2 > 0) {
                    $value .= $value2;
                }

                $value = str_pad($value, $lengths[0] + $lengths[1], '0', STR_PAD_LEFT);
            }
            else {
                $value = str_pad($value, $lengths[0], '0', STR_PAD_LEFT);
            }
		}

        if ($debug) {
            return 'DecimalFormat: (' . $data . ',' . $length . ',' . $value . ')';
        }
        else {
            return $value;
        }
    }
}
