<!--manage\index.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('title','系統管理')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>系統管理
                <small>
                    設定系統資訊
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
                <h2>系統參數 <small></small></h2>

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
            <table id="example" class="table responsive-utilities jambo_table">
                <thead>
                    <tr class="headings">
                        <th>
                            <!--<input type="checkbox" class="tableflat">-->
                            #
                        </th>
                        <th>名稱</th>
                        <th>值</th>
                        <th>更新時間</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($data as $d)
                        <tr class="odd pointer">
                            <td class="a-center ">{{ $count }}</td>
                            <td class=" ">{{ $d->Name }}</td>
                            <td class=" ">{{ $d->value }}</td>
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


@endsection
