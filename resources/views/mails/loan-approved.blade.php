<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aanvraag goedgekeurd</title>
</head>
<body>
    <h2>Je uitleenaanvraag is goedgekeurd</h2>

    <p>Beste {{ $loanRequest->user->name ?? $loanRequest->borrower_name }},</p>

    <p>Je aanvraag voor het lenen van hardware is goedgekeurd.</p>

    <ul>
        <li><strong>Hardware:</strong> {{ $loanRequest->hardware->name ?? 'Onbekend' }}</li>
        <li><strong>Aantal:</strong> {{ $loanRequest->quantity }}</li>
        <li><strong>Startdatum:</strong> {{ $loanRequest->start_date }}</li>
        <li><strong>Einddatum:</strong> {{ $loanRequest->end_date }}</li>
    </ul>

    <p>Met vriendelijke groet,<br>Hardware Uitleen Systeem</p>
</body>
</html>