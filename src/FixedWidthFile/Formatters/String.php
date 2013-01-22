<?php
namespace FixedWidthFile\Formatters;

class String implements FormatterInterface
{
    /**
     * @param  mixed
     * @param  integer
     * @return string
     */
    public function format($data, $length)
    {
        $value = sprintf("%-{$length}.{$length}s", $data);
		$value = substr($value, 0, $length);

        return $value;
    }
}
