<!--index.blade.php-->

{{--使用Master模板--}}
@extends('layouts.master')

@section('title','首頁')

@section('content')

                <div class="row">
                                        <!-- 顯示驗證錯誤 -->
            @include('include.errors')
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="dashboard_graph">

                            {!! Html::image('/images/welcome.png','profile',array('class' => 'center-block','height' => '480px')) !!}

                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <br />


@endsection