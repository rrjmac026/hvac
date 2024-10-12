<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Schedule</title>
</head>
<body>
    <h1>Visit Schedule</h1>
    <p>Dear {{ $clientName }},</p>
    <p>This is to inform you about the visit scheduled for your pet <strong>{{ $petName }}</strong>.</p>
    <p><strong>Visit Date:</strong> {{ $visitDate }}</p>
    <p><strong>Status:</strong> {{ $status }}</p>
    
    <h2>Diagnosis</h2>
    <p>{{ $diagnosis }}</p>
    
    <h2>Treatment</h2>
    <p>{{ $treatment }}</p>
    
    <h2>Thank you for choosing Highland Vets!</h2>
</body>
</html>
