<?php
namespace FixedWidthFile\Formatters;

interface FormatterInterface
{
    /**
     * Format value with max length
     *
     * @param  mixed   $data
     * @param  integer $length
     * @return mixed
     */
    public function format($data, $length);
}
