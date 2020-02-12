<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>

<p>PostalMate Feature Request</p>
<ul>
<li>Name</li>
<li>Phone number: {{ $distressCall-&gt;user-&gt;phone }}</li>
<li>PostalMate serial Number: {{ $distressCall-&gt;user-&gt;name }}</li>
<li>Store name: {{ $distressCall-&gt;user-&gt;phone }}</li>
<li>Requested feature: {{ $distressCall-&gt;user-&gt;dni }}</li>
</ul>
</body>
</html>
