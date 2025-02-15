<?php

namespace App\Services;

use Carbon\Carbon;

class FormatDhivehiDate
{

    private $_months = [
        'January' => 'ޖަނަވަރީ',
        'February' => 'ފެބްރުއަރީ',
        'March' => 'މާޗް',
        'April' => 'އެޕްރީލް',
        'May' => 'މެއި',
        'June' => 'ޖޫން',
        'July' => 'ޖުލައި',
        'August' => 'އޯގަސްޓް',
        'September' => 'ސެޕްޓެމްބަރު',
        'October' => 'އޮކްޓޫބަރު',
        'November' => 'ނޮވެމްބަރު',
        'December' => 'ޑިސެމްބަރު'
    ];

    public function formatDhivehiDate($date)
    {
        Carbon::setLocale('dv');

        $carbonDate = Carbon::parse($date);
        return $carbonDate->format('d') . ' ' . $this->_months[$carbonDate->format('F')] . ' ' . $carbonDate->format('Y');
    }


    public function formatDhivehiMonthYear($date)
    {
        Carbon::setLocale('dv');

        $carbonDate = Carbon::parse($date);
        return $this->_months[$carbonDate->format('F')] . ' ' . $carbonDate->format('Y');
    }
}
