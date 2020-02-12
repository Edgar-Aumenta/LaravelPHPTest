<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>PostalMate Feature Request</title>
</head>
<body>
<p>PostalMate Feature Request</p>
<ul>
    <li>Name: {{ $requestMoreInfo->name }}</li>
    <li>Email address: {{ $requestMoreInfo->email }}</li>
    <li>Phone number: {{ $requestMoreInfo->phoneNumber }}</li>
    <li>Store name: {{ $requestMoreInfo->storeName }}</li>
    <li>Address: {{ $requestMoreInfo->address }}</li>
    <li>City: {{ $requestMoreInfo->city }}</li>
    <li>State: {{ $requestMoreInfo->state }}</li>
    <li>Zip code: {{ $requestMoreInfo->zipCode }}</li>
    <li>Current software: {{ $requestMoreInfo->currentSoftware }}</li>
    <li>Request PostalMate trial?: {{ $requestMoreInfo->requestPMTrial }}</li>
    <li>Store status: {{ $requestMoreInfo->storeStatus }}</li>
    <li>Comments: {{ $requestMoreInfo->comments }}</li>
</ul>
</body>
</html>
