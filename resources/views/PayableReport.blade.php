<!DOCTYPE html>
<html lang="dv" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ public_path('tailwind-pdf.css') }}" rel="stylesheet" type="text/css" />

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
        unicode-bidi: bidi-override;
    }
</style>
</head>

<body class="bg-gray-50 p-8" dir="rtl">
    {{-- <div class="w-11/12 mx-auto flex justify-between items-center"> --}}
        {{-- <img src="{{ public_path('assets/images/logo.png') }}" class="w-24" alt="Logo"> --}}
        {{-- <h1 class="text-2xl font-bold text-teal-700">All User Details</h1> --}}
    {{-- </div> --}}

    <div class="overflow-x-auto mt-6">
        <table class="w-full border border-gray-300 bg-white shadow-lg">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-right" style="direction: ltr; unicode-bidi: embed;">ނަން</th>

                    <th class="px-4 py-2">ބިލްކުރެވުނު މުއްދަތު</th>
                    <th class="px-4 py-2">ވިޔަ ރެފަރެންސް ނަންބަރ</th>
                    <th class="px-4 py-2">މުއްދަތުހަމަވާ ތާރީޚް</th>
                    <th class="px-4 py-2">މަހުފީ</th>
                    <th class="px-4 py-2">ޖޫރިމަނާ</th>
                    <th class="px-4 py-2">ދައްކަންޖެހޭ ޖުމްލަ</th>
                    <th class="px-4 py-2">ދެއްކި ޖުމްލަ</th>
                    <th class="px-4 py-2">ސްޓޭޓަސް</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $payable)
                    <tr class="border-b border-gray-200 even:bg-gray-100">
                        <td class="px-4 py-2">{{ $payable->property->name }}</td>
                        <td class="px-4 py-2">{{ date('F Y', strtotime($payable->billed_period)) }}</td>
                        <td class="px-4 py-2 text-blue-500">{{ $payable->viya_reference_no }}</td>
                        <td class="px-4 py-2">{{ date('F j, Y', strtotime($payable->due_date)) }}</td>
                        <td class="px-4 py-2">{{ $payable->amount }}</td>
                        <td class="px-4 py-2">{{ $payable->fine }}</td>
                        <td class="px-4 py-2">{{ $payable->grand_total - $payable->balance }}</td>
                        <td class="px-4 py-2">{{ $payable->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
