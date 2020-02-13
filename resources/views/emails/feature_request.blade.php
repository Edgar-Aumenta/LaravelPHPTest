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
            <li>Name: {{ $featureRequest->contactName }}</li>
            <li>Phone number: {{ $featureRequest->contactPhone }}</li>
            <li>Email address: {{ $featureRequest->contactEmail }}</li>
            <li>PostalMate serial Number: {{ $featureRequest->pmSerial }}</li>
            <li>Store name: {{ $featureRequest->storeName }}</li>
            <li>Requested feature: {{ $featureRequest->requestedFeature }}</li>
        </ul>
    </body>
</html>
