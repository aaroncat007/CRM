<div class="inbox-body">
    <div class="mail_heading row">
        <div class="col-md-8">
        <!--功能列-->
            <div class="compose-btn">
                <a class="btn btn-sm btn-primary btnEdit" href="{{route('record.edit')}}/{{$data->id}}"><i class="fa fa-pencil"></i> 編輯</a>
                <a class="btn btn-sm btn-danger btnDel" data-id="{{$data->id}}"><i class="fa fa-pencil"></i> 刪除</a>
            </div>
        </div>

        <!--時間戳記-->
        <div class="col-md-4 text-right">
            <p class="date">{{$data->updated_at}}</p>
        </div>

        <!--標題列-->
        <div class="col-md-12">
            <h4>{{$data->title}}</h4>
        </div>
    </div>

    <!--內容-->
    <div class="view-mail">
        <!-- 顯示驗證錯誤 -->
        @include('include.errors')
        {!! html_entity_decode($data->content) !!}
    </div>
</div>