<!DOCTYPE html>
<html>
<head>
	<title>{{title}}</title>
</head>
<body>
	<p>Hi {{$hmo->name}},</p>
	<p>This is a mail to notify you that your orders for the month of {{month}} have been successfully processed</p>  
	<p>Best Regards</p>
	<strong>{{config('app.name')}}</strong>
</body>
</html>