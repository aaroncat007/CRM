  <head>
    <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	 <!-- Bootstrap -->
    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('fonts/css/font-awesome.min.css') !!}
    {!! Html::style('css/animate.min.css') !!}
    {!! Html::style('css/custom.css') !!}
    
    @yield('style')
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>@yield('title') - {{ webInfo()->get('WebName') }}</title>
</head>