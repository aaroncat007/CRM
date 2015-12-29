<!--manage\accountIndex.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('style')
{!! Html::style('css/datatables/tools/css/dataTables.tableTools.css') !!}
@endsection

@section('title','帳號管理')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                帳號管理
                <small>
                    新增與維護系統帳號
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
                                <h2>帳號列表 <small></small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                    <button id="btnAdd" class="btn btn-info btn-sm" type="button"><i class="fa fa-user"></i> 新增</button><li>
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
            <table id="example" class="table table-striped responsive-utilities jambo_table">

                <thead>
                    <tr class="headings">
                        <th>
                            <!--<input type="checkbox" class="tableflat">-->
                            #
                        </th>
                        <th>名稱</th>
                        <th>帳號</th>
                        <th>群組</th>
                        <th>最後登入時間</th>
                        <th>最後登入位置</th>
                        <th>狀態</th>
                        <th class=" no-link last"><span class="nobr">操作</span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($userData as $data)
                    <tr class="{{ $count % 2 === 0 ? 'even' : 'odd'}} pointer">
                        <td class="a-center ">
                            {{ $count }}
                        </td>
                        <td class=" ">{{ $data->first_name . $data->last_name }}</td>
                        <td class=" ">{{ $data->email }}</td>
                        <td class=" ">
                            @foreach ($data->roles as $role)
                            {{ $role->name }} <br />
                            @endforeach
                        </td>
                        <td class=" ">{{ $data->last_login or '無' }}</td>
                        <td class=" ">{{ $data->ip_address or '無' }}</td>
                        <td class="a-right a-right ">{{ $data->activations->completed === 1 ? '正常':'停用' }}</td>
                        <td class=" last">
                            <button class="btn btn-default btnEdit" data-id="{{ $data->id }}" type="button">編輯</button>
                            <button class="btn btn-danger btnDel" data-id="{{ $data->id }}" type="button">刪除</button>
                            <a class="btn btn-primary" href="{{ route('manage.categoriesAuth',$data->id) }}">授權</a>
                        </td>
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
        $("#btnAdd").click(function(){
            $(".modal-body").load('{{route('manage.accountAdd')}}',function(){
                $('#MyModal').modal('toggle');
            });
        });

        $(".btnEdit").click(function(){
            $(".modal-body").load('{{route('manage.accountEdit')}}/'+$(this).attr("data-id"),function(){
                $('#MyModal').modal('toggle');
            });

        });

        $(".btnDel").click(function(){
            if(confirm("確定要刪除此帳號嗎?")){
                $.ajax({
                      method: "get",
                      url: "{{ route('manage.accountDel') }}",
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