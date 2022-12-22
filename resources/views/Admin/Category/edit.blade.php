@extends('admin.index')

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-body ">
            {!! Form::open(['url'=>url('category/'.$category->id),'method'=>'put','files'=>true]) !!}
            <div class="form-group">
                {!! Form::label(trans('admin.category_name_ar')) !!}
                {!! Form::text('category_name_ar',$category->category_name_ar,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(trans('admin.category_name_en')) !!}
                {!! Form::text('category_name_en',$category->category_name_en,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(trans('admin.category_description_ar'))!!}
                {!! Form::text('category_description_ar',$category->category_description_ar,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(trans('admin.category_description_en'))!!}
                {!! Form::text('category_description_en',$category->category_description_en,['class'=>'form-control']) !!}
            </div>
            <div class="form-group ">
                @if(!empty($category->category_image))
                    <img src="{{asset('storage/'. $category->category_image)}}" style="width: 50px;height: 50px;">
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('category image') !!}
                    </div>
                    <div class="col-lg-12">
                        {!! Form::file('category_image',['class'=>'form-control']) !!}
                    </div>
                </div>

            </div>
        </div>
        {!! Form::submit('Edit',['class'=>'btn btn-primary form-control']) !!}
        {!! Form::close() !!}
        <!-- /.card-body -->
        <!-- /.card -->
    </div>
    <!-- /.row -->
@endsection
