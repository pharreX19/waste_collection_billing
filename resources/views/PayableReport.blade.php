<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style>
    @font-face {
        font-family: "Faruma";
        src: url({{ resource_path('fonts/Faruma.ttf') }})  format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    * {
        font-family: 'Faruma';
        direction: rtl;
        /* unicode-bidi: bidi-override; */
    }

    table {
    width: 100%;
    border-collapse: collapse;
    page-break-after: auto;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: right;
    }

    tr {
        page-break-inside: avoid;
    }

    thead {
        display: table-header-group;
        background-color: #f3f4f6;
        margin-top: 20px;
        page-break-before: avoid;
    }

    tbody {
        page-break-before: auto;
    }

    tfoot {
        display: table-footer-group;
        page-break-before: avoid;
    }
</style>
</head>

    <body class="bg-white p-8" dir="rtl">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr class="divide-x divide-gray-200">
              <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0">ނަން</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ބިލްކުރެވުނު މުއްދަތު</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ވިޔަ ރެފަރެންސް ނަންބަރ</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">މުއްދަތުހަމަވާ ތާރީޚް</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">މަހުފީ</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ޖޫރިމަނާ</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ދައްކަންޖެހޭ ޖުމްލަ</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ދެއްކި ޖުމްލަ</th>
              <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-right text-sm font-semibold text-gray-900">ސްޓޭޓަސް</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($payables as $payable)
                <tr class="divide-x divide-gray-200">
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500 sm:pl-0">{{ $payable->property->name }}</td>
                    <td class="whitespace-nowrap p-4 text-sm font-medium text-gray-900">{{ (new App\Services\FormatDhivehiDate())->formatDhivehiMonthYear($payable->billed_period) }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-900">{{ $payable->viya_reference_no }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ (new App\Services\FormatDhivehiDate())->formatDhivehiDate($payable->due_date) }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ $payable->amount }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ $payable->fine }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ $payable->balance }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ $payable->grand_total - $payable->balance }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                        {{ (new \App\Services\PayableStateMapping())->handle($payable->state) }}
                    </td>
                </tr>
                @endforeach
          </tbody>
        </table>
    </body>
</html>




