<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aanvraag afgewezen</title>
</head>
<body>
    <h2>Je uitleenaanvraag is afgewezen</h2>

    <p>Beste {{ $loanRequest->user->name ?? $loanRequest->borrower_name }},</p>

    <p>Helaas is je aanvraag afgewezen.</p>

    <ul>
        <li><strong>Hardware:</strong> {{ $loanRequest->hardware->name ?? 'Onbekend' }}</li>
        <li><strong>Aantal:</strong> {{ $loanRequest->quantity }}</li>
        <li><strong>Startdatum:</strong> {{ $loanRequest->start_date }}</li>
        <li><strong>Einddatum:</strong> {{ $loanRequest->end_date }}</li>
    </ul>

    @if(!empty($loanRequest->review_notes))
        <p><strong>Reden van afwijzing:</strong> {{ $loanRequest->review_notes }}</p>
    @endif

    <p>Met vriendelijke groet,<br>Hardware Uitleen Systeem</p>
</body>
</html>