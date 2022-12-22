@extends('Admin.layouts.master')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-xm-12">
                <div class="card ">
                    <div class="card-body">
                        @include('Admin.layouts.massage')
                            <table id="example2" class="table table-bordered table-hover  ">
                            <thead>
                            <tr>
                                <th>{{trans('category.image')}}</th>
                                <th> {{trans('category.name')}} </th>
                                <th>{{trans('category.description')}}</th>
                                <th>{{trans('category.added_by')}}</th>
{{--                                <th>{{trans('admin.number_of_product')}}  </th>--}}
{{--                                <th>{{trans('admin.created_at')}}</th>--}}
{{--                                <th>{{trans('admin.updated_at')}}</th>--}}
                                <th> {{trans('category.update')}} </th>
                                <th> {{trans('category.delete')}} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if(!empty($category->image))
                                            <div style="width: 100px; height: 100px">
                                            <img src="{{asset($category->image)}}" style="width: 100%;height: 100%;">
                                            </div>
                                        @endif
                                    </td>
                                    <td> {{$category->name}} </td>
                                    <td>{{$category->description}}</td>
                                    <td>{{$category->admins->name}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('Category.edit',$category->id) }}"> <i class="fa fa-edit"></i> </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="{{route('Category.destroy',$category->id)}}"> <i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{trans('category.image')}}</th>
                                <th> {{trans('category.name')}} </th>
                                <th>{{trans('category.description')}}</th>
                                <th>{{trans('category.added_by')}}</th>
                                {{--                                <th>{{trans('admin.number_of_product')}}  </th>--}}
                                {{--                                <th>{{trans('admin.created_at')}}</th>--}}
                                {{--                                <th>{{trans('admin.updated_at')}}</th>--}}
                                <th> {{trans('category.update')}} </th>
                                <th> {{trans('category.delete')}} </th>
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


