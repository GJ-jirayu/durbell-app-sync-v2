<html>
<head>
<style>
table { 
font-family: ms sans serif;
font-size: 10pt; 
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Control Panel</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.1.1/css/blog.css">
<link rel="stylesheet" href="bootstrap-3.1.1/css/doc.css">
<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->

<!--<script src="//code.jquery.com/jquery-2.1.0.min.js"></script>-->
<script src="bootstrap-3.1.1/js/jquery-2.1.1.min.js"></script>
<script src="bootstrap-3.1.1/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
	$("form#formLogin").submit(function(){
			//alert($("#user").val());
			//alert($("#pass").val());
			$.ajax({
				url:"loginAction.php",
				type:"GET",
				dataType:"json",
				data:{"paramUser":$("#user").val(),"paramPass":$("#pass").val(),"paramAction":"login"},
				success:function(data){
					if(data[0]=="success"){
//					alert("เข้าสู่ระบบสำเร็จ");
					window.location.href = "View/index.php";
					}else{
					alert("Username หรือ Password ไม่ถูกต้อง");
					window.location.href = "login.php";
					}
					return false;
				}
			});
		return false;
	});
});
	
</script>

</head>

<body leftmargin="0" topmargin="0">

<table class="table" height="" align="center" border="0" cellpadding="1" cellspacing="1">
<tr><td bgcolor="#428bca">

	<table width="1000" align="center" border="0" cellpadding="5" cellspacing="1">
	<tr>
		<td colspan="2">
			<div style="margin:10px; color:#ffffff; font-size:16px;">
				<b>iVan BackOffice <span class="glyphicon glyphicon-lock"></span></b>
			</div>
		</td>
	</tr>
	</table>

</td></tr>
<tr><td bgcolor="#f5e79e" height="10"></td></tr>


<tr><td>
<br>
<br>
<br>
<br>

<table width="300" align="center" border="0" cellpadding="5" cellspacing="1">
<tr><td colspan="2" align="center"><img src="images/adminloginhead.jpg"></td></tr>

<tr>
	<td colspan="2" align="center">&nbsp;
	</td>
</tr>


<form id="formLogin">

<tr><td  style="text-align:right; padding-right:5px;"><b>Username</b></td>
<td style=" padding-top: 2px;"><input name="user" id="user" type="text" size="15" class="form-control input-sm"></td></tr>
<tr><td style="text-align:right; padding-right:5px;"><b>Password</b></td>
<td style=" padding-top: 2px;"><input name="pass" id="pass" type="password" size="15" class="form-control input-sm"></td></tr>
<tr><td align="center">&nbsp;</td>
  <td align="left" style="padding-top:5px;" >
  <!--
  <input name="submit" type="submit" value="Login now">
  -->
  
  <button type="submit" class="btn  btn-xs btn-primary"><span class=" glyphicon glyphicon-arrow-right"></span> Login</button>
  <button type="reset" class="btn  btn-xs btn-danger"><span class=" glyphicon glyphicon-off"></span> Cancel</button>
  </td>
</tr>

</form>

</table>

</td></tr>
</table>
<!--
<table class="table" align="center" border="0" cellpadding="5" cellspacing="1">
<tr><td bgcolor="#E1E1E1" height="15"></td></tr>
<tr><td bgcolor="#5272A3">&nbsp;</td></tr>
</table>
-->
</body>
</html>



