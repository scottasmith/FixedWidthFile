<?php
namespace FixedWidthFile\Formatters;

class String implements FormatterInterface
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
        $value = sprintf("%-{$length}.{$length}s", $data);
		$value = substr($value, 0, $length);

        if ($debug) {
            return 'StringFormat: (' . $data . ',' . $length . ', ' . $value . ')';
        }
        else {
            return $value;
        }
    }
}
