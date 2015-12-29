<div class="">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>新增授權<small>{{ $user->first_name }} ({{ $user->email }})</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::open(array('route' => 'manage.categoriesAuthAdd','id' => 'AddForm','class'=>'form-horizontal form-label-left')) !!}

                    {!! Form::hidden('uid',$user->id) !!}



                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cateName">板塊名稱<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::select('category',$categoryList,null,array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button id="btn-submit" class="btn btn-success" type="button">新增</button>
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div id="alertBlock" class="alert alert-danger" style="display:none;">
                        <strong>新增失敗:</strong><label id="errorMsg"></label>
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