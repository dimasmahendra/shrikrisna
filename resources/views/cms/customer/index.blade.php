@php
    $title = "Customer";
    $breadcrumbs[] = ["label" => "Customer", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card" style="margin-bottom: 0px;" id="cardcustomer">
    <div class="section-header">
        <div class="section-subitem">
            <div class="avatar avatar-mdx d-md-none-custom">
                <img src="{{ Auth::user()->gambar_url }}" alt="" class="object-fit-cover">                               
            </div>
        </div>
        <div class="p-l-10 p-r-10">
            <div class="text-item">Customer</div>
        </div>
        <div class="section-subitem">
            <div class="text-item-end">
                <a href="{{ route('customer.create') }}">Add</a>
            </div>
        </div>
    </div>
    <div>
        <div class="table-responsive">
            <table class="table" id="filterTable" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left fw-600 d-none">First Letter</th>
                        <th class="text-left fw-600 d-none">Name</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css-plugins')
<link rel="preload" href="/cms/css/pages/customer.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/pages/customer.css?v={{ $version }}">
</noscript>
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datatable/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $(document).ready(function() {
                var $mytable = $("#filterTable");
                var count = 1;
                var inp;
                var timer;
                var $datatable = $mytable.DataTable({
                    language: {
                        "info": "",
                        "searchPlaceholder": "Search",
                        "search": "",
                    },
                    dom: "<'row'<'col-sm-12 col-md-12'f>>" +
                        "<'row'<'col-sm-12 m-t-0'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    ordering: false,
                    searching: true,
                    bFilter: false,
                    bPaginate: false,
                    info: false,
                    lengthChange: false,
                    rowGroup: {
                        dataSrc: "first_letter"
                    },
                    initComplete: function () {
                        $('div.dataTables_filter input', this.api().table(). container()).attr('id', 'mysearchbox').off();
                    },
                    columns: [
                        {
                            "className": 'd-none',
                            "data": "first_letter",
                            "defaultContent": '1',
                            "orderable": false,
                        },
                        {
                            "data": function (row, type, val, meta) {
                                return `<div class="d-flex justify-content-between" data-id="` + row.id +`">
                                        <div class="col-md-8 customer_info" style="flex: 1 0 auto;">
                                            <div class="m-b-5">` + ((row.name == null) ? "" : row.name) +`</div>
                                            <div class="m-b-5 text-SECONDARY60 fs-12">` + ((row.nomor_ktp == null) ? "" : row.nomor_ktp) +`</div>
                                            <p class="m-b-5 text-PRIMARY60 fs-12">` + ((row.phone_number == null) ? "" : row.phone_number) +`</p>
                                            <p class="m-b-5 text-PRIMARY60 fs-12">` + ((row.institution == null) ? "" : row.institution) +`</p>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="/admin/customer/edit/` + row.id +`">
                                                <i class="icon-pencil fs-17"></i>
                                            </a>
                                            <button type="button" class="btn btn-WHITE100-red button-destroy"
                                                data-url="/admin/customer/destroy/` + row.id +`">
                                                <i class="icon-bin fs-20" style="color: #E82623;"></i>
                                            </button>
                                        </div>
                                </div>`
                            }
                        },
                    ]
                });

                $('input#mysearchbox').on('keyup', function () {
                    clearTimeout(timer);

                    inp = $("input#mysearchbox").val();
                    count = 1;
                    $datatable.clear();
                    timer = setTimeout(load_more, 1000);
                });

                $('input#mysearchbox').on('keydown', function () {
                    clearTimeout(timer);
                });

                load_more();
                
                $(window).scroll(function() {
                    var scrolltop = $(window).scrollTop();
                    var viewportHeight = $(window).height();
                    var documentHeight = $(document).height();

                    if(scrolltop + viewportHeight >= documentHeight - 100) {
                        load_more();
                    }
                });

                function load_more() {
                    $.ajax({
                        url: "/admin/customer/dt",
                        type: "GET",
                        data: {
                            pageNumber: count,
                            search: inp,
                        },
                        dataType: "json"
                    }).done(function(response) {
                        $.each(response.result, function(i, item) {
                            $datatable.row.add(item).draw(false);
                        });
                    }).fail(function(err){
                        console.error('error...', err)
                    });

                    count++;
                }
            })
        })(jQuery);
    });
</script>
@endpush