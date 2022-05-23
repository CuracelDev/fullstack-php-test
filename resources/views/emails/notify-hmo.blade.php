<!DOCTYPE html>
<html>
<head>
	<title>{{$data['title']}}</title>
</head>
<body>
	<p>Hi {{$data['hmo']->name}},</p>
	<p>This is a mail to notify you that your orders for the month of {{$data['month']}} have been successfully processed</p>  
	<p>Best Regards</p>
	<strong>{{config('app.name')}}</strong>
</body>
</html>