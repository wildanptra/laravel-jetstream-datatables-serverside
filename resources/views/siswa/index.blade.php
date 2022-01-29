<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datatables Server Side</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <style>
        input{
            border: 1px solid black;
        }
    </style>
</head>
<body>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
            {{ __('Datatables Server Side') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="card mx-3 my-3 px-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <h4>Data Siswa</h4>
                    </div>
                    <div class="col-md-12 my-3">
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="table-siswa" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Detail</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js   "></script>

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>

    <script id="details-template" type="text/x-handlebars-template">
        <table class="table m-0" style="text-align: left !important">

            <tr>
                <td>No Id:</td>
                <td>@{{id}}</td>
            </tr>

            <tr>
                <td>Nama:</td>
                <td>@{{nama}}</td>
            </tr>

            <tr>
                <td>Kelas:</td>
                <td>@{{kelas.nama}}</td>
            </tr>

            <tr>
                <td>Alamat:</td>
                <td>@{{alamat}}</td>
            </tr>

            <tr>
                <td>Status:</td>
                <td>@{{status}}</td>
            </tr>

        </table>
    </script>

    <script type="text/javascript">

        $(document).ready(function(){

            var template = Handlebars.compile($("#details-template").html());

            var table = $('#table-siswa').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'csv', 'print'
                ],
                "lengthMenu": [
                    [ 10, 25, 50, 100, 1000, -1 ],
                    [ '10 rows', '25 rows', '50 rows', '100 rows', '1000 rows', 'All' ]
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ url('/siswa/json') }}",
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "data":           null,
                        "defaultContent": '<button class="btn btn-sm btn-success"> Lihat Detail </button>'
                    },
                    {data: 'nama', name: 'nama'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'kelas.nama', name: 'kelas.nama'},
                    {data: 'status_siswa', name: 'status_siswa'},
                    {data: 'action', name: 'action', searchable:false},
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });
                }
            });


            $('#table-siswa tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                if ( row.child.isShown() ) {

                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {

                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        })

    </script>
</body>
</html>

</x-app-layout>
