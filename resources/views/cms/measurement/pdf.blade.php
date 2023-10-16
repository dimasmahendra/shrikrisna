<!DOCTYPE html>
<html lang="en">
<head>
    <title>PDF</title>
    <style type="text/css">
        @font-face {
            font-family: Poppins-Regular;            
            src: url("{{ env('APP_URL') }}/fonts/Poppins/Poppins-Regular.ttf");
        }
        body {
            font-family: Poppins-Regular, sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #4A4646;
            background-color: #ffffff;
        }        
        .row {
            width: 100%;
            margin-right: 0px;
            margin-left: 0px;
            padding: 10px;
        }
        .col-md-6 {
            float: left;
            width: 35%;
            display: inline-block;
            padding-left: 65px;
            padding-right: 65px;
        }
        .fs-12 {font-size: 12px !important;}
        .fs-14 {font-size: 14px !important;}
        .fs-16 {font-size: 16px !important;}
        .m-t-5 {margin-top: 5px;}
        .m-t-10 {margin-top: 10px;}
        .m-t-15 {margin-top: 15px;}
        .m-t-20 {margin-top: 20px;}
        .m-t-30 {margin-top: 30px;}
        .m-t-120 {margin-top: 0px;}
        .m-b-120 {margin-bottom: 60px;}
        .fw-600 {
            font-weight: 600 !important;
        }
        .section-item {
            text-align: center;
            border: 1px solid #000;
            padding: 1px;
        }
        table {
            caption-side: bottom;
            border-collapse: collapse
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #002B4C;
            vertical-align: top;
            border-color: #E5E5E5
        }
        .table>:not(caption)>*>* {
            padding: 2px;
            background-color: var(--bs-table-bg);
            background-image: linear-gradient(var(--bs-table-accent-bg), var(--bs-table-accent-bg));
            border-bottom-width: 1px
        }
        .table>tbody {
            vertical-align: inherit;
            font-size: 12px;
        }
        .table>thead {
            vertical-align: bottom;
        }
        .col-2 {
            flex: 0 0 auto;
            width: 16.6666666667%;
        }
        .col-5 {
            flex: 0 0 auto;
            width: 41.6666666667%;
        }
        .col-7 {
            flex: 0 0 auto;
            width: 58.3333333333%;
        }
        .col-6 {
            flex: 0 0 auto;
            width: 50%;
        }
        .col-10 {
            flex: 0 0 auto;
            width: 83.3333333333%;
        }
        td.td-col-6 {
            width: 40px;
        }
        .text-PRIMARY90 {
            color: #002B4C;
        }
        .table-bordered>:not(caption)>*>* {
            border-width: 0 1px;
            border: 1px solid #E5E5E5;
        }
        .b-t-unset {
            border-top: 0px solid #ffffff !important;
        }
        .b-r-unset {
            border-right: 0px solid #ffffff !important;
        }
        .b-l-unset {
            border-left: 0px solid #ffffff !important;
        }
        .center {
            text-align: center;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="section-parent">
        @foreach ($data as $key => $value)
            <div class="col-md-6 m-b-120 m-t-120">
                @php
                    $measure = App\Models\Measurement::where('id', $key)->first();
                @endphp
                <div class="section-item">
                    <div class="m-t-5">
                        <strong class="fs-12">{{ $measure->customer->nomor_ktp }}</strong>
                    </div>
                    <div class="m-t-5">
                        <strong class="fs-12">{{ $measure->customer->name }}</strong>
                    </div>
                    <div class="m-t-5">
                        <strong class="fs-12">{{ $measure->category->name }}</strong>
                    </div>
                    <div class="m-t-5">
                        <strong class="fs-12">{{ date("d F Y", strtotime($measure->measurement_date)) }}</strong>
                    </div>
                    <div class="m-t-10">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-PRIMARY90 fw-600 col-2 b-t-unset b-r-unset fs-12">Description</th>
                                        <th class="text-PRIMARY90 fw-600 col-10 b-t-unset b-l-unset fs-12" colspan="2">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $details = $measure->items->groupBy('id_master_category_details');
                                    @endphp
                                    @foreach ($measure->category->details as $item)
                                        @for ($i = 0; $i < $item->total_rows; $i++)
                                            <tr>
                                                @if ($i == 0)
                                                    <td rowspan='{{ $item->total_rows }}' class="center">{{ $item->description }}</td>
                                                @endif
                                                <td class="p-td-unset" width="25%">
                                                    <div class="col">
                                                        <div class="h-45 text-center center3">
                                                            {{ isset($details[$item->id][$i]["value"]) ? $details[$item->id][$i]["value"] : '-' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-td-unset">
                                                    <div class="col">
                                                        <div class="h-45 text-center center3">
                                                            {{ isset($details[$item->id][$i]["option"]) ? $details[$item->id][$i]["option"] : '-' }}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($measure->notes != null)
                            <div class="text-PRIMARY90" style="text-align: left; padding-left: 20px; font-size: 12px;">
                                <div> Notes :</div>
                                <div>{{ $measure->notes }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (count($data) > 4)
                @if ($loop->iteration % 4 == 0)
                    <div style = "display:block; clear:both; page-break-after:always;"></div>
                @endif
            @endif
        @endforeach
    </div>

    <script src="{{ env('APP_URL') }}/cms/vendors/jquery/jquery.min.js"></script>
    <script>
        function equalheight() {
            $('.section-parent').each(function (index) {
                var maxHeight = 0;
                $(this).find('.section-item').height('auto');
                $(this).find('.section-item').each(function (index) {
                    if ($(this).height() > maxHeight)
                        maxHeight = $(this).height() + 10;
                });
                $(this).find('.section-item').height(maxHeight);
            });
        }
        $(document).ready(function () {
            equalheight();
        });
    </script>
</body>
</html>
