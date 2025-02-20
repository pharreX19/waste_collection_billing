<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Payable;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class GenerateReports
{
    public function handle(Request $request)
    {
        $start_date = $request->query('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $end_date = $request->query('end_date') ?? Carbon::parse($request->query('start_date'))->addYear(1)->toDateString();
        $name = $request->query('name') ?? null;

        $data = Payable::with('property:id,name')
            // ->whereDate('billed_period', '>=', $start_date)
            // ->whereDate('billed_period', '<', $end_date)
            ->whereBetween('billed_period', [$start_date, $end_date])
            ->when(!empty($name), function ($query) use ($name) {
                $query->whereHas('property', function ($q) use ($name) {
                    $q->where('name', $name);
                });
            })
            ->get();

        if ($request->format === 'csv') {
            return $this->csv($data);
        } else {
            return $this->pdf($data);
        }
    }

    private function pdf($data)
    {
        $html = view('PayableReport', ['payables' => $data])->render();
        $pdfPath = public_path('payables.pdf');

        Browsershot::html($html)
            ->margins(10, 10, 10, 10)
            ->format('A4')
            ->landscape()
            ->noSandbox()
            ->transparentBackground()
            ->setOption('args', ['--no-sandbox', '--disable-gpu'])
            ->setOption('disable-dev-shm-usage', true)
            ->waitUntilNetworkIdle()
            ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    private function csv($data)
    {
        $csvFileName = 'payables.csv';
        $csvFile = fopen($csvFileName, 'w');
        $headers = [
            'ސްޓޭޓަސް',
            'ދެއްކި ޖުމްލަ',
            'ދައްކަންޖެހޭ ޖުމްލަ',
            'ޖޫރިމަނާ',
            'މަހުފީ',
            'މުއްދަތުހަމަވާ ތާރީޚް',
            'ވިޔަ ރެފަރެންސް ނަންބަރ',
            'ބިލްކުރެވުނު މުއްދަތު',
            'ގޭގެ ނަން',
        ];

        fputcsv($csvFile, $headers);

        foreach ($data as $row) {
            fputcsv($csvFile, [
                $stateLabels[$row['state']] ?? 'މުއްދަތު ހަމަވެފައި',
                $row['grand_total'] - $row['balance'],
                $row['balance'],
                $row['fine'],
                $row['amount'],
                (new FormatDhivehiDate())->formatDhivehiDate($row['due_date']),
                $row['viya_reference_no'],
                (new FormatDhivehiDate())->formatDhivehiMonthYear($row['billed_period']),
                $row->property->name,
            ]);
        }

        fclose($csvFile);
        return response()->download(public_path($csvFileName))->deleteFileAfterSend(true);
    }
}
