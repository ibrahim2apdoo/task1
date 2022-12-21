@extends('Admin.layouts.master')


@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-xm-12">
                <div class="card ">
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{trans('admin.name')}}</th>
                                <th> {{trans('admin.email')}} </th>
                                <th>{{trans('admin.status')}}</th>
                                <th>{{trans('admin.isAdmin')}}</th>
                                <th> {{trans('admin.update')}} </th>
                                <th> {{trans('admin.delete')}} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>

                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td>{{$admin->getActive()}}</td>
                                    <td>{{$admin->Is_admin()}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="#"> <i class="fa fa-edit"></i> </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="#"> <i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{trans('admin.name')}}</th>
                                <th> {{trans('admin.email')}} </th>
                                <th>{{trans('admin.status')}}</th>
                                <th>{{trans('admin.isAdmin')}}</th>
                                <th> {{trans('admin.update')}} </th>
                                <th> {{trans('admin.delete')}} </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </section>
@endsection
@section('footer')

    <script src="{{url('/design/adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('/design/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('/design/adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{url('/design/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{url('/design/adminlte/dist/js/adminlte.min.js')}}"></script>
    <script src="{{url('/design/adminlte/dist/js/demo.js')}}"></script>

    <script type="text/javascript">
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
        })
    </script>
@endsection
