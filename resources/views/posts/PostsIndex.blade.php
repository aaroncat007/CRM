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
                         <h2>{{ trans('posts.index') }}<small></small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                    <a id="btnAdd" class="btn btn-info btn-sm" type="button" href="{{route('posts.create').'/'.$cateInfo->id}}"><i class="fa fa-user"></i> {{ trans('posts.create')}}</a><li>
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
            <table id="example" class="table table-striped responsive-utilities jambo_table">

                <thead>
                    <tr class="headings">
                        <th>
                            <!--<input type="checkbox" class="tableflat">-->
                            #
                        </th>
                        <th>標題</th>
                        <th>作者</th>
                        <th>回覆</th>
                        <th>更新時間</th>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($data as $d)
                    <tr class="{{ $count % 2 === 0 ? 'even' : 'odd'}} pointer" data-id="{{ $d->id }}">
                        <td class="a-center ">
                            {{ $count }}
                        </td>
                        <td class=" ">{{ $d->subject }}</td>
                        <td class=" ">{{ $d->User->first_name . $d->User->last_name }}</td>
                        <td class=" ">{{ $d->posts_reply->count() }}</td>
                        <td class=" ">{{ $d->updated_at }}</td>
                    </tr>
                    <?php $count++ ?>
                    @endforeach
                </tbody>

            </table>
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
{!! Html::script('js/datatables/js/jquery.dataTables.js') !!}
{!! Html::script('js/datatables/tools/js/dataTables.tableTools.js') !!} 

<script type="text/javascript">
    $(function(){
        $(".pointer").click(function(){
            location.href = "{{ route('posts.show',null)}}/"+$(this).attr("data-id");
        });
});
</script>  
@endsection