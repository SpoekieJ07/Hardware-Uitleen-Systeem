<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inleverherinnering</title>
</head>

<body>
    <h2>Herinnering: de inleverdatum nadert</h2>

    <p>Beste {{ $loan->user->name ?? $loan->borrower_name }},</p>

    <p>
        Dit is een herinnering dat de inleverdatum van je geleende item nadert.
    </p>

    <ul>
        <li><strong>Hardware:</strong> {{ $loan->hardware->name ?? 'Onbekend' }}</li>
        <li><strong>Aantal:</strong> {{ $loan->quantity }}</li>
        <li><strong>Inleverdatum:</strong> {{ $loan->end_date?->format('d-m-Y') }}</li>
    </ul>

    <p>
        Zorg ervoor dat je het item op tijd terugbrengt.
    </p>

    <p>Met vriendelijke groet,<br>Hardware Uitleen Systeem</p>
</body>

</html>