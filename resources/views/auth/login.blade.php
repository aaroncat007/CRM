<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    {!! Html::style('css/loginstyle.css') !!}
    {!! Html::style('css/animate-custom.css') !!}
    <title>登入</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome&nbsp;<span>Mi-Bao</span>&nbsp;CRM</h1>
        </header>
        <section>               
            <div id="container_demo" >
                <div id="wrapper">
                    <div id="login" class="animate form">
                        {!! Form::open(array('id'=> 'login_form','method' => 'post','autocomplete' => 'on')) !!}
                            <h1>Login</h1> 
                            <p> 
                                <label for="user_name" class="uname" data-icon="u" > Your email or username </label>
                                <input id="user_name" name="user_name" required="required" type="text" placeholder="myusername or mymail@mail.com"/>
                            </p>
                            <p> 
                                <label for="user_password" class="youpasswd" data-icon="p"> Your password </label>
                                <input id="user_password" name="user_password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                            </p>
                            <p class="keeplogin"> 
                                <input type="checkbox" name="user_rememberme" id="user_rememberme" value="loginkeeping" /> 
                                <label for="user_rememberme">Keep me logged in</label>
                            </p>
                            <div id="alertBlock" class="alert alert-danger" style="display:none;">
                                <strong>登入失敗:</strong><label id="errorMsg"></label>
                            </div>                              
                            <p class="login button"> 
                                <input id="btn-login" type="button" data-loading-text="Loading..." value="Login" /> 
                            </p>
                        {!! Form::close() !!}
                    </div>                     
                </div>
            </div>  
        </section>
    </div>
    {!! Html::script('js/jquery-1.11.3.js') !!}
    {!! Html::script('js/jquery.form.min.js') !!}
    {!! Html::script('js/jquery.validate.min.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    <script type="text/javascript">
        $(document).ready(function(){
          $(document).on('click','#btn-login',function(){
            var url = "/auth/login";       
            $('#alertBlock').hide();
            if($('#login_form').valid()){
              $("#btn-login").button('loading');
              $.ajax({
                  type: "POST",
                  url: url,
                          data: $("#login_form").serialize(), // serializes the form's elements.
                          success: function(data)
                          {
                            if(data.success) {               
                              window.location.href = data.message;
                          } 
                          else {  
                            $('#errorMsg').html(data.message);
                            $('#alertBlock').show();
                        }
                    },
                    complete:function(data){
                        $("#btn-login").button('reset');
                    },
                    error: function(data){
                        // Error...
                        var errors = $.parseJSON(data.responseText);
                        $("#btn-login").button('reset');
                        console.log(errors);

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
});
</script>
</body>
</html>