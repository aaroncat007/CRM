<!--manage\accountIndex.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('style')

@endsection

@section('title',trans('profile.index'))

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                {{ $data->first_name . $data->last_name }}
                <small>
                    {{ trans('profile.comment') }}
                </small>
            </h3>
        </div>
<!--
                         <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div> 
                    -->
                </div>
                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                         <h2>{{ trans('profile.index') }}<small></small></h2>

                                <ul class="nav navbar-right panel_toolbox">
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
            {!! Form::open(array('route' => 'profile.edit','id' => 'AddForm','class'=>'form-horizontal form-label-left input_mask')) !!}
                
                {!! Form::hidden('uid',$data->id) !!}

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.name')}}</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input disabled="disabled" class="form-control" type="text" value="{{$data->first_name . $data->last_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.email')}}</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input disabled="disabled" class="form-control" type="text" value="{{$data->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.lastlogin_IP')}}</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input disabled="disabled" class="form-control" type="text" value="{{$data->ip_address}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.lastlogin_Time')}}</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input disabled="disabled" class="form-control" type="text" value="{{$data->last_login}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.NewPassword')}}</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" required="required" type="password" id="password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('profile.VaildPassword')}}</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" required="required" type="password" id="repassword" name="repassword">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-6">
                        <button class="btn btn-success" type="submit">{{trans('profile.btnEdit')}}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<br />
<br />
<br />

</div>

<div tabindex="-1" id="MyModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button class="close" aria-label="Close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function(){
        
 $("#AddForm").validate({
           rules: {
               password: { 
                 required: true,
                    minlength: 6,
                    maxlength: 10,

               } , 

                repassword: { 
                    equalTo: "#password",
                     minlength: 6,
                     maxlength: 10
               }


           },
     messages:{
         password: { 
                 required:"the password is required"

               }
     }

});
});
</script>  
@endsection