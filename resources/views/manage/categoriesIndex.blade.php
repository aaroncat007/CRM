<!--manage\categoriesIndex.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('style')
{!! Html::style('css/datatables/tools/css/dataTables.tableTools.css') !!}
<style type="text/css">
    .jambo_table > tbody>.even {
    background-color: #f9f9f9;
}

</style>
@endsection

@section('title','板塊管理')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                板塊管理
                <small>
                    新增與維護分類板塊
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
                                <h2>板塊列表 <small></small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                    <button id="btnAdd" class="btn btn-info btn-sm" type="button"><i class="fa fa-user"></i> 新增主類別</button><li>
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
            <table id="example" class="table responsive-utilities jambo_table">
                <thead>
                    <tr class="headings">
                        <th>
                            <!--<input type="checkbox" class="tableflat">-->
                            #
                        </th>
                        <th>名稱</th>
                        <th>敘述</th>
                        <th>狀態</th>
                        <th>授權帳號數</th>
                        <th class=" no-link last"><span class="nobr">操作</span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($categoriesData as $data)
                    <?php 
                        $main = $data->get('main');
                        $msub = $data->get('sub');
                    ?>
                    @if(isset($main))
                        <tr class="even pointer">
                            <td class="a-center ">{{ $count }}</td>
                            <td class=" ">{{ $main->title }}</td>
                            <td class=" ">{{ $main->description or '' }}</td>
                            <td class=" ">{{ !isset($main->deactivate) ? '正常' :'停用' }}</td>
                            <td class=" ">{{ $data->get('subCount') }}</td>
                            <td class=" last">
                                <button class="btn btn-info btnSubAdd" data-id="{{ $main->id }}" type="button">新增子類別</button>
                                <button class="btn btn-default btnEdit" data-id="{{ $main->id }}" type="button">編輯</button>
                                <button class="btn btn-danger btnDel" data-id="{{ $main->id }}" type="button">刪除</button>
                            </td>
                        </tr>

                        <?php
                            
                            $subCount = 1;
                        ?>
                        @foreach($msub as $sub)
                            <tr class="odd pointer">
                            <td class="a-center ">{{ $count }}-{{ $subCount }}</td>
                            <td class=" "> -->{{ $sub->title }}</td>
                            <td class=" ">{{ $sub->description }}</td>
                            <td class=" ">{{ !isset($sub->deactivate) ? '正常' :'停用' }}</td>
                            <td class=" ">{{ count($sub->categories_auth) }}</td>
                            <td class=" last">
                                <button class="btn btn-default btnEdit" data-id="{{ $sub->id }}" type="button">編輯</button>
                                <button class="btn btn-danger btnDel" data-id="{{ $sub->id }}" type="button">刪除</button>
                            </td>
                        </tr>
                        <?php $subCount++ ?>
                        @endforeach

                    @endif
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
        $("#btnAdd").click(function(){
            $(".modal-body").load('{{route('manage.categoriesAdd')}}',function(){
                $('#MyModal').modal('toggle');
            });
        });

        $(".btnSubAdd").click(function(){
            $(".modal-body").load('{{route('manage.categoriesAdd')}}/'+$(this).attr("data-id"),function(){
                $('#MyModal').modal('toggle');
            });
        });

        $(".btnEdit").click(function(){
            $(".modal-body").load('{{route('manage.categoriesEdit')}}/'+$(this).attr("data-id"),function(){
                $('#MyModal').modal('toggle');
            });

        });

        $(".btnDel").click(function(){
            if(confirm("確定要刪除此類別嗎?")){
                $.ajax({
                      method: "get",
                      url: "{{ route('manage.categoriesDel') }}",
                      data: { id: $(this).attr('data-id') }
                    })
                      .done(function( msg ) {
                        alert(msg.message);
                        window.location.reload();
                });
            }
        });

        $('#MyModal').on('hidden.bs.modal',function(){
            $('.modal-body').html("");
        });


});
</script>  
@endsection