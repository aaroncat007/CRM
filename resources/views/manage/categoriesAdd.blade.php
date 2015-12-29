<div class="">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ isset($parent) ? '新增子類別':'新增主類別'}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::open(array('route' => 'manage.categoriesAdd','id' => 'AddForm','class'=>'form-horizontal form-label-left')) !!}
                    @if(isset($parent))
                        {!! Form::hidden('parent_id',$parent->get('id')) !!}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cateName">主類別</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>{{ $parent->get('name') }}</label>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cateName">名稱<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" id="cateName" name="cateName" required="required" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catedesc">描述</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" id="catedesc" name="catedesc" type="text">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">啟用</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="btn-group" id="gender" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-passive-class="btn-default" data-toggle-class="btn-primary">
                                    <input name="activated" type="radio" value="0" data-parsley-id="6649" data-parsley-multiple="gender"> &nbsp; 停用 &nbsp;
                                </label>
                                <label class="btn btn-primary active" data-toggle-passive-class="btn-default" data-toggle-class="btn-primary">
                                    <input name="activated" type="radio" checked="" value="1" data-parsley-id="6649" data-parsley-multiple="gender"> 啟用
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button id="btn-submit" class="btn btn-success" type="button">建立</button>
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div id="alertBlock" class="alert alert-danger" style="display:none;">
                        <strong>建立失敗:</strong><label id="errorMsg"></label>
                    </div>          
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
$(document).on('click','#btn-submit',function(){
        var url = $("#AddForm").attr('action');       
        $('#alertBlock').hide();
        if($('#AddForm').valid()){
          $("#btn-submit").button('loading');
          $.ajax({
              type: "POST",
              url: url,
                      data: $("#AddForm").serialize(), // serializes the form's elements.
                      success: function(data)
                      {
                        if(data.success) {               
                          window.location.reload();
                      } 
                      else {  
                        $('#errorMsg').html(data.message);
                        $('#alertBlock').show();
                    }
                },
                complete:function(data){
                    $("#btn-submit").button('reset');
                },
                error: function(data){
                    // Error...
                    var errors = $.parseJSON(data.responseText);
                    $("#btn-submit").button('reset');
                    console.log(errors);
                    $('#errorMsg').html('Exception Error');
                    $.each(errors, function(index, value) {
                        $.gritter.add({
                            title: 'Error',
                            text: value
                        });
                    });
                }
            });
    }
    return false;
    });

    </script>