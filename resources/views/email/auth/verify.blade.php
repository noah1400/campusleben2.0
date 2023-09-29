<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eaeaea;
            background-color: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 200px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px 0;
            color: #000000 !important;
            background-color: #007BFF;
            border-radius: 4px;
            text-decoration: none;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007BFF;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://www.campusleben-es.de/storage/images/csm_logo_campusleben.png" alt="CampusLeben e.V. Logo">
        </div>
        <p>Hallo {{ $name }},</p>
        <p>danke, dass du dich bei CampusLeben e.V. registriert hast! Um Funktionen wie das Voranmelden zu
            Veranstaltungen nutzen zu können, ist es wichtig, dass du deine E-Mail-Adresse bestätigst. Klicke hierfür
            einfach auf den folgenden Button:</p>
        <a href="{{ $url }}" class="button">E-Mail bestätigen</a>
        <p>Solltest du Probleme mit dem Button haben, kannst du auch diesen Link direkt in die Adresszeile deines
            Browsers kopieren:</p>
        <p>{{ $url }}</p>
        <p>Beste Grüße,<br>Dein CampusLeben e.V. Team</p>
        <div class="links">
            <a href="https://campusleben-es.de/contact">Kontakt</a> | <a href="https://www.instagram.com/campus_leben/">Instagram</a>
        </div>
        <div class="footer">
            (c) 2023 CampusLeben e.V. Alle Rechte vorbehalten.
        </div>
    </div>
</body>

</html>
