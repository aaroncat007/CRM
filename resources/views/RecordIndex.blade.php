<!--index.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('title','首頁')

@section('style')
<style type="text/css">
    .mail_list_column {
        height: 624px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .mail_view {
        height: 624px;
        overflow-y: auto; 
        overflow-x: hidden; 
    }

    .mail_list{
        cursor: pointer;
        padding-top: 10px;
    }

    .mail_list:hover{
        background-color: #FFF7FC;
    }

</style>
@endsection

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>
            {{ $cateParents->title }} - {{ $cateInfo->title }}
            <small>
            {{ trans('record.comment') }}
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
                    <a id="btnAdd" class="btn btn-info btn-sm" href="{{route('record.create')}}/{{$cateInfo->id}}" type="button"><i class="fa fa-user"></i> 新增</a><li>
                </li>
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


                <div class="row">

                    <div class="col-sm-3 mail_list_column">

<!--列表開始-->
                    @foreach($data as $d)
                        <div class="mail_list" data-id="{{$d->id}}">
                            <div class="left">
                                 <i class="fa fa-edit"></i>
                            </div>
                            <div class="right">
                                <h3>{{$d->title}}<small>{{$d->updated_at}}</small></h3>
                                <p>{{$d->content}}</p>
                            </div>
                        </div>
                    @endforeach
<!--列表結束-->

                    </div>


                    <!-- CONTENT MAIL -->
                    <div class="col-sm-9 mail_view">
                        
                    </div>
                    <!-- /CONTENT MAIL -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
        $(function(){
            $(".mail_list").click(function(){
                $(".mail_list").css("background-color","");
                $(this).css("background-color","#FFF7FC");
                $(".mail_view").load("/Record/show/"+$(this).attr("data-id"));
            });

            $(document).on("click",".btnDel",function(){
            if(confirm("確定要刪除此紀錄嗎?")){
                    $.ajax({
                          method: "get",
                          url: "{{ route('record.del') }}",
                          data: { id: $(this).attr('data-id') }
                        })
                          .done(function( msg ) {
                            alert(msg.message);
                            window.location.reload();
                    });
                }
            });
        });
</script>
@endsection