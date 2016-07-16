<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type="text/css">
	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #018699;
		margin: 60px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
		padding: 11px;
	}

	a {
		color: #003399;
		background-color: transparent;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		font-weight: normal;
	}

	h1 {
		color: #FFF;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 29px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}
	h6{
		color: #FFF;
		background-color: transparent;
		font-size: 9px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		color: #FFF;
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	
	ul{
		text-align: center;
		padding: 20px;
	}
	
	li{
		display: inline;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		border-left-color: #CCC;
		border-left-width: 1px;
		border-right-color: #CCC;
		border-right-width: 1px;
		border-top-width: 2px;
		border-top-color: #CCC;
		border-top-style: solid;
		border-bottom-width: 2px;
		text-align: center;
	}
	#menu{
		font-family: Arial,Helvetica,sans-serif;
		color: #FFF;
		text-decoration: none;
		font-size: 0.9em;
		display: block;
		padding: 7px;
		float: left;
		border-bottom-style: solid;
		border-bottom-width: 2px;
		border-bottom-color: #CCC;
		border-top-style: solid;
		border-top-color: #CCC;
		border-top-width: 2px;
	}
	#menu:hover{
		color: #FFF;
		background-color: #666;
	}
	#menu:selected{
		color: #FFF;
		background-color: #666;
	}
.clear{
	clear: both;
}
	
	</style>
</head>
<body>
	<nav>
	<ul>
		<!--  
		<li><a href='<?php echo site_url('examples/customers_management')?>'>Customers</a></li>
		<li><a href='<?php echo site_url('examples/orders_management')?>'>Orders</a></li>
		<li><a href='<?php echo site_url('examples/products_management')?>'>Products</a>
		<li><a href='<?php echo site_url('examples/offices_management')?>'>Offices</a></li> 
		<li><a href='<?php echo site_url('examples/employees_management')?>'>Employees</a></li>		 
		<li><a href='<?php echo site_url('examples/film_management')?>'>Films</a></li>
		<li><a href='<?php echo site_url('examples/film_management_twitter_bootstrap')?>'>Twitter Bootstrap Theme [BETA]</a></li>
		<li><a href='<?php echo site_url('examples/multigrids')?>'>Multigrid [BETA]</a></li>
		-->
		<li><a href='<?php echo site_url('examples/user_management')?>'>Users</a></li>
	</ul>	
	</nav>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
