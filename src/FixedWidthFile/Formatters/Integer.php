<?php
namespace FixedWidthFile\Formatters;

class Integer implements FormatterInterface
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
        $value = sprintf("%0{$length}d", $data);
		$value = substr($value, 0, $length);

        if ($debug) {
            return 'IntegerFormat: (' . $data . ',' . $length . ',' . $value . ')';
        }
        else {
            return $value;
        }
    }
}
