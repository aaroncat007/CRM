<!--index.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('title','首頁')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>
            {{ $cateParents->title }} - {{ $cateInfo->title }}
            <small>
            {{ trans('posts.edit') }}
            </small>
        </h3>
    </div>

{{--     <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div> --}}
</div>
<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    {{-- <button id="btnAdd" class="btn btn-info btn-sm" type="button"><i class="fa fa-user"></i> 新增</button><li>
                </li> --}}
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-close"></i></a>
                    </li>
                -->
            </ul> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <!-- 顯示驗證錯誤 -->
            @include('include.errors')
            <br>
            {!! Form::open(array('route' => 'posts.reply.edit','id' => 'AddForm','class'=>'form-horizontal form-label-left')) !!}
                
                {!! Form::hidden('id',$data->id) !!}

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="content">{{trans('posts.replyTitle')}}
                    </label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                    <label>{{ $post->subject }}</label>
                    </div>
                </div>

               <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="content">{{trans('posts.Input_content')}}<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" id="content" name="content" required="required" type="text" data-parsley-id="7614" rows="80" cols="20">{!! ($data->content) !!}</textarea><ul class="parsley-errors-list" id="parsley-id-7614"></ul>
                    </div>
                </div>

                <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button id="btn-submit" class="btn btn-success" type="submit">儲存</button>
                            <button id="btn-exit" class="btn btn-danger" type="submit" onclick="javascript:location.back();">放棄</button>
                        </div>
                    </div>

            {!! Form::close() !!}

            <div id="alertBlock" class="alert alert-danger" style="display:none;">
                <strong>儲存失敗:</strong><label id="errorMsg"></label>
            </div>  
        </div>
        </div>
    </div>
</div>

@endsection

@section('script')
{!! Html::script('js/ckeditor/ckeditor.js') !!}
<script type="text/javascript">
        $(function(){
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('content');
        });
</script>
@endsection