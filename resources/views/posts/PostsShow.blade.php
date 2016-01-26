<!--manage\accountIndex.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('style')
{!! Html::style('css/datatables/tools/css/dataTables.tableTools.css') !!}
<style type="text/css">
    .pointer {
        cursor: pointer;
    }

</style>
@endsection

@section('title','討論區')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                {{ $cateParents->title }} - {{ $cateInfo->title }}
                <small>
                    {{ trans('posts.comment') }}
                </small>
            </h3>
        </div>
         <div class="title_right">
            <div class="col-md-1 col-sm-1 col-xs-12 form-group pull-right top_search">
                        <a href="{{ route('posts.index') .'/'.$cateInfo->id }}" class="btn btn-default">返回</a>
{{--                 <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div> --}}
            </div>
        </div> 

                </div>
                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                         <h2>{{ $data->subject }}<small></small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                    <a href="{{ route('posts.reply.add').'/'.$data->id }}" id="btnAdd" class="btn btn-info btn-sm" type="button"><i class="fa fa-user"></i> {{ trans('posts.reply')}}</a><li>
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
            <!-- 顯示驗證錯誤 -->
            @include('include.errors')
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="logout">
            <div class="tab-content">
                <div class="tab-pane active" id="comments-logout">                
                    <ul class="media-list">
                      <li class="media">
                        @if($data->user_id == $userID)
                            <a class="pull-right" href="#">
                        @else
                            <a class="pull-left" href="#">
                        @endif
                          {!! Html::image(getUserimg($data->user_id),'profile',array('class' => 'media-object img-circle')) !!}
                        </a>
                        <div class="media-body">
                          <div class="well well-lg">
                            @if($data->user_id == $userID)
                              <div class="pull-right">
                                <a class="btn btn-info" href="{{route('posts.edit') .'/'.$data->id}}">編輯</a>
                                <button class="btn btnDelPost btn-danger" data-id="{{$data->id}}">刪除</button>
                              </div>
                            @endif
                              <h4 class="media-heading text-uppercase reviews">{{ $data->User->first_name . $data->User->last_name }}</h4>
                              <ul class="media-date text-uppercase reviews list-inline">
                              <li>{{ trans('posts.updateTime')}} :</li>
                              <li>{{ $data->updated_at }}</li>
                              </ul>
                              <hr />
                              <p class="media-comment">
                                {!! html_entity_decode($data->content) !!}
                              </p>
                          </div>              
                        </div>
                      </li> 
                      @foreach($reply as $r)
                      <li class="media">
                        @if($r->user_id == $userID)
                            <a class="pull-right" href="#">
                        @else
                            <a class="pull-left" href="#">
                        @endif
                          {!! Html::image(getUserimg($r->user_id),'profile',array('class' => 'media-object img-circle')) !!}
                        </a>
                        <div class="media-body">
                          <div class="well well-lg">
                          @if($r->user_id == $userID)
                              <div class="pull-right">
                                <a class="btn btn-info" href="{{route('posts.reply.edit') .'/'.$r->id}}">編輯</a>
                                <button class="btn btn-danger btnDelReply" data-id="{{$r->id}}">刪除</button>
                              </div>
                          @endif
                          <h4 class="media-heading text-uppercase reviews">{{$r->User->first_name . $r->User->last_name}}</h4>
                          <ul class="media-date text-uppercase reviews list-inline">
                          <li>{{ trans('posts.updateTime')}} :</li>
                          <li>{{ $r->updated_at }}</li>
                          </ul>
                        <hr />
                          <p class="media-comment">
                            {!! html_entity_decode($r->content) !!}
                          </p>
                          </div>              
                        </div>
                      </li>
                      @endforeach
                    </ul> 
                </div>
            </div>
        </div>
    </div>
  </div>
        </div>
    </div>
</div>

<br />
<br />
<br />

</div>

@endsection

@section('script')
{!! Html::script('js/datatables/js/jquery.dataTables.js') !!}
{!! Html::script('js/datatables/tools/js/dataTables.tableTools.js') !!} 

<script type="text/javascript">
    $(function(){

            $(document).on("click",".btnDelPost",function(){
            if(confirm("確定要刪除此討論串嗎?")){
                    $.ajax({
                          method: "get",
                          url: "{{ route('posts.del') }}",
                          data: { id: $(this).attr('data-id') }
                        })
                          .done(function( msg ) {
                            alert(msg.message);
                            location.href = msg.goto;
                    });
                }
            });

            $(document).on("click",".btnDelReply",function(){
            if(confirm("確定要刪除此回覆嗎?")){
                    $.ajax({
                          method: "get",
                          url: "{{ route('posts.reply.del') }}",
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