@extends('admin.index')

@section('content')
    <!-- Main content -->

        <div class="box">
            <div class="box-body ">
                {!! Form::open(['url'=>url('category'),'files'=>true]) !!}
                <div class="form-group">
                    {!! Form::label(trans('admin.category_name_ar')) !!}
                    {!! Form::text('category_name_ar',old('category_name_ar'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label(trans('admin.category_name_en')) !!}
                    {!! Form::text('category_name_en',old('category_name_en'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label(trans('admin.category_description_ar'))!!}
                    {!! Form::text('category_description_ar',old('category_description_ar'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label(trans('admin.category_description_en'))!!}
                    {!! Form::text('category_description_en',old('category_description_en'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label(trans('admin.category_image')) !!}
                        </div>
                        <div class="col-lg-12">
                            {!! Form::file('category_image',['class'=>'form-control']) !!}
                        </div>
                    </div>

                </div>
                </div>
            {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
            <!-- route admin.store function or url aurl('admin') this header for store function  -->
        </div>
        <!-- /.row -->
@endsection
