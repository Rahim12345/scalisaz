@extends('back.layout.master')

@section('title') {{ __('menus.contact') }}  @endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">

    <style>
        table tr td {
            width: max-content !important;
        }

        table.dataTable {
            margin: 0 0 !important;
        }

        .card {
            word-wrap: normal;
        }


        .dt-buttons {
            margin-left: 35%;
            margin-top: 15px;
        }

        .buttons-excel,.buttons-print {
            background-color:
                #232e3c;
        }

        table.dataTable tbody tr, .dataTables_length select {
            background-color:
                #232e3c !important;
        }

        table.theme-dark tr td{
            color:
                #FFFFFF;
        }

        .table-mobile-md td {
            color:
                #FFFFFF !important;
        }

        #messages_info {
            color:
                #FFFFFF !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button           {
            color:
                #FFFFFF !important;
        }

        .page-item, .paginate_button,#messages_length,#messages_filter,#messages_paginate,a.paginate_button {
            color:
                #FFFFFF !important;
        }

        .text-wrap{
            white-space:normal;
        }
        .width-200{
            width:400px;
        }

    </style>
@endsection

@section('content')
    <div class="page">
        @include('back.includes.menu')

        <div class="content">
            <div class="mb-3 col-md-8 offset-md-2 table-responsive" style="overflow-x: hidden;padding: 0 10px !important;">
                <table class="table table-vcenter table-mobile-md card-table" style="width: 100% !important;" id="messages">
                    <thead>
                    <tr>
                        <th>{{ __('static.ad_soyad') }}</th>
                        <th>{{ __('login.email') }}</th>
                        <th>{{ __('static.mesaj') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody style="width: 100% !important;">

                    </tbody>
                </table>
            </div>
        </div>
        @include('back.includes.footer')
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#messages');
        getUsers(table);

        function getUsers(table,filter) {
            table.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    data : {filter},
                    url: "{{ route('contact.index') }}",
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'contact_details', name: 'contact_details'},
                    {data: 'message', name: 'message'},
                    {
                        name: 'created_at.timestamp',
                        data: {
                            _: 'created_at.display',
                            sort: 'created_at.timestamp'
                        }
                    },
                    {data: 'action', name: 'action'}
                ],
                    createdRow: function( row, data, dataIndex ) {
                    $( row ).find('td:eq(0)').attr('data-label', "{{ __('static.ad_soyad') }}");
                    $( row ).find('td:eq(1)').attr('data-label', "{{ __('login.email').' / '.__('static.nomre') }}");
                    $( row ).find('td:eq(2)').attr('data-label', "{{ __('static.mesaj') }}");
                    $( row ).find('td:eq(3)').attr('data-label', 'Tarix');
                    $( row ).find('td:eq(4)').attr('data-label', 'Action');
                },
                    columnDefs: [
                    {
                        render: function (data, type, full, meta) {
                            return "<div class='text-wrap width-200'>" + data + "</div>";
                        },
                        targets: 2
                    },
                        {
                            targets: 4, searchable: false, orderable: false,
                        }
                ],
                "language": {
                    "emptyTable": "C??dv??ld?? he?? bir m??lumat yoxdur",
                    "infoEmpty": "N??tic?? Yoxdur",
                    "infoFiltered": "( _MAX_ N??tic?? ????ind??n Tap??lanlar)",
                    "lengthMenu": "S??hif??d?? _MENU_ N??tic?? G??st??r",
                    "loadingRecords": "Y??kl??nir...",
                    "processing": "G??zl??yin...",
                    "search": "Axtar????:",
                    "zeroRecords": "N??tic?? Tap??lmad??.",
                    "paginate": {
                        "first": "??lk",
                        "last": "Ax??r??nc??",
                        "previous": "??nc??ki",
                        "next": "Sonrak??"
                    },
                    "aria": {
                        "sortDescending": ": s??tunu azalma s??ras?? ??z??r?? aktiv etm??k",
                        "sortAscending": ": s??tunu artma s??ras?? ??z??r?? aktiv etm??kr"
                    },
                    "autoFill": {
                        "cancel": "L????v Et",
                        "fill": "B??t??n h??cr??l??ri <i>%d<\/i> ile doldur",
                        "fillHorizontal": "H??cr??l??ri ??fiqi olaraq doldur",
                        "fillVertical": "H??cr??l??ri ??aquli olara1 doldur"
                    },
                    "buttons": {
                        "collection": "Kolleksiya <span class=\"\\\"><\/span>",
                        "colvis": "S??tun bax??????",
                        "colvisRestore": "Bax?????? ??vv??lki v??ziyy??tin?? g??tir",
                        "copy": "Kopyala",
                        "copyKeys": "C??dv??ld??ki qeydi kopyalamaq ??????n CTRL v?? ya u2318 + C d??ym??l??rin?? bas??n. L????v etm??k ??????n bu mesaj?? vurun v?? ya ESC d??ym??sini vurun.",
                        "copySuccess": {
                            "1": "1 s??tir panoya kopyaland??",
                            "_": "%ds s??tir panoya kopyaland??"
                        },
                        "copyTitle": "Panoya kopyala",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "B??t??n s??tirlari g??st??r",
                            "_": "%d s??tir g??st??r"
                        },
                        "pdf": "PDF",
                        "print": "??ap Et"
                    },
                    "decimal": ",",
                    "info": "_TOTAL_ N??tic??d??n _START_ - _END_ Aras?? N??tic??l??r",
                    "infoThousands": ".",
                    "searchBuilder": {
                        "add": "Ko??ul Ekle",
                        "button": {
                            "0": "Axtar???? Yarad??c??",
                            "_": "Axtar???? Yarad??c?? (%d)"
                        },
                        "clearAll": "Filtrl??ri T??mizl??",
                        "condition": "????rt",
                        "conditions": {
                            "date": {
                                "after": "N??vb??ti",
                                "before": "??nc??ki",
                                "between": "Aras??nda",
                                "empty": "Bo??",
                                "equals": "B??rab??rdir",
                                "not": "Deyildir",
                                "notBetween": "Xaricind??",
                                "notEmpty": "Dolu"
                            },
                            "number": {
                                "between": "Aras??nda",
                                "empty": "Bo??",
                                "equals": "B??rab??rdir",
                                "gt": "B??y??kd??r",
                                "gte": "B??y??k b??rab??rdir",
                                "lt": "Ki??ikdir",
                                "lte": "Ki??ik b??rab??rdir",
                                "not": "Deyildir",
                                "notBetween": "Xaricind??",
                                "notEmpty": "Dolu"
                            },
                            "string": {
                                "contains": "T??rkibind??",
                                "empty": "Bo??",
                                "endsWith": "??l?? bit??r",
                                "equals": "B??rab??rdir",
                                "not": "Deyildir",
                                "notEmpty": "Dolu",
                                "startsWith": "??l?? ba??layar"
                            },
                            "array": {
                                "equals": "B??rab??rdir",
                                "empty": "Bo??",
                                "contains": "T??rkibind??",
                                "not": "Deyildir",
                                "notEmpty": "Dolu",
                                "without": "Xaric"
                            }
                        },
                        "data": "Qeyd",
                        "deleteTitle": "Filtrl??m?? qaydas??n?? silin",
                        "leftTitle": "Meyar?? xaric?? ????xarmaq",
                        "logicAnd": "v??",
                        "logicOr": "v??ya",
                        "rightTitle": "Meyar?? i????ri al",
                        "title": {
                            "0": "Axtar???? Yarad??c??",
                            "_": "Axtar???? Yarad??c?? (%d)"
                        },
                        "value": "De??er"
                    },
                    "searchPanes": {
                        "clearMessage": "Ham??s??n?? T??mizl??",
                        "collapse": {
                            "0": "Axtar???? B??lm??si",
                            "_": "Axtar???? B??lm??si (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown}\/{total}",
                        "emptyPanes": "Axtar???? B??lm??si yoxdur",
                        "loadMessage": "Axtar???? B??lm??si y??kl??nir ...",
                        "title": "Aktiv filtrl??r - %d"
                    },
                    "select": {
                        "cells": {
                            "1": "1 h??cr?? se??ildi",
                            "_": "%d h??cr?? se??ildi"
                        },
                        "columns": {
                            "1": "1 s??tun se??ildi",
                            "_": "%d s??tun se??ildi"
                        },
                        "rows": {
                            "1": "1 qeyd se??ildi",
                            "_": "%d qeyd se??ildi"
                        }
                    },
                    "thousands": ".",
                    "datetime": {
                        "previous": "??nc??ki",
                        "next": "N??vb??ti",
                        "hours": "Saat",
                        "minutes": "D??qiq??",
                        "seconds": "Saniy??",
                        "unknown": "Nam??lum",
                        "amPm": [
                            "am",
                            "pm"
                        ]
                    },
                    "editor": {
                        "close": "Ba??la",
                        "create": {
                            "button": "T??z??",
                            "title": "Yeni qeyd yarat",
                            "submit": "Qeyd Et"
                        },
                        "edit": {
                            "button": "Redakt?? Et",
                            "title": "Qeydi Redakt?? Et",
                            "submit": "Yenil??yin"
                        },
                        "remove": {
                            "button": "Sil",
                            "title": "Qeydl??ri sil",
                            "submit": "Sil",
                            "confirm": {
                                "_": "%d ??d??d qeydi silm??k ist??diyiniz?? ??minsiniz?",
                                "1": "Bu qeydi silm??k ist??diyiniz?? ??minsiniz?"
                            }
                        },
                        "error": {
                            "system": "Sistem x??tas?? ba?? verdi (??trafl?? M??lumat)"
                        },
                        "multi": {
                            "title": "??ox d??y??r",
                            "info": "Se??ilmi?? qeydl??r bu sah??d?? f??rqli d??y??rl??r ehtiva edir. B??t??n se??ilmi?? qeydl??r ??????n bu sah??y?? eyni d??y??ri t??yin etm??k ??????n buraya vurun; ??ks halda h??r qeyd ??z d??y??rini saxlayacaqd??r.",
                            "restore": "D??yi??iklikl??ri geri qaytar??n",
                            "noMulti": "Bu sah?? qrup ????klind?? deyil, ayr??-ayr??l??qda t????kil edil?? bil??r."
                        }
                    }
                } ,
                stateSave: true,
            });
        }
    </script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('843a7ab9d55ffbd631c5', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('contact-message');
    channel.bind('App\\Events\\ContactMessage', function(data) {
        var table = $('#messages');
        table.dataTable().fnDestroy();
        getUsers(table)
    });
</script>

    <script>
        $(document).on('click', '.messageDeleter', function () {
            var id = $(this).data('id');
            var table = $('#messages');
            $.ajax({
                url: '/admin/contact/' + id,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function (result) {
                    toastr.success(result.message);
                    table.dataTable().fnDestroy();
                    getUsers(table)
                }
            });
        });
    </script>
@endsection
