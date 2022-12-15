<!DOCTYPE html>
<html>

<head>
    <title>Employees Ajax</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1>Daftar Karyawan</h1>
        <div class="table-responsive">
            <div class="my-3">
                <a href="{{ route('export.excel') }}" target="_blank" class="btn btn-success">Export xls</a>
                <a href="{{ route('export.pdf') }}" target="_blank" class="btn btn-danger">Export pdf</a>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <a class="btn btn-success my-3" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-nama" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="employeeForm" name="employeeForm" class="form-horizontal">
                        <input type="hidden" name="employee_id" id="employee_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Nama"
                                    value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-12">
                                <textarea id="alamat" name="alamat" required="" placeholder="Enter Alamat"
                                    class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Telepon</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="telp" name="telp"
                                    placeholder="Enter No. Telepon" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('karyawan.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama', name: 'nama' },
                    { data: 'email', name: 'email' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'telp', name: 'telp' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
            $('#createNewEmployee').click(function () {
                $('#saveBtn').val("create-employee");
                $('#employee_id').val('');
                $('#employeeForm').trigger("reset");
                $('#modelHeading').html("Create New Employee");
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.editEmployee', function () {
                var employee_id = $(this).data('id');
                $.get("{{ route('karyawan.index') }}" + '/' + employee_id + '/edit', function (data) {
                    $('#modelHeading').html("Edit Employee");
                    $('#saveBtn').val("edit-employee");
                    $('#ajaxModel').modal('show');
                    $('#employee_id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#email').val(data.email);
                    $('#alamat').val(data.alamat);
                    $('#telp').val(data.telp);
                })
            });
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Save');
                $.ajax({
                    data: $('#employeeForm').serialize(),
                    url: "{{ route('karyawan.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#employeeForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
            $('body').on('click', '.deleteEmployee', function () {
                var employee_id = $(this).data("id");
                $confirm = confirm("Are You sure want to delete?");
                if ($confirm == true) {
                    $.ajax({
                        url: "{{ route('karyawan.store') }}" + '/' + employee_id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>