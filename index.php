<?php
// Pobierz IP klienta
$clientIP = $_SERVER['REMOTE_ADDR'];

// Pobierz datę i godzinę w strefie czasowej serwera
$serverTimeZone = new DateTimeZone(date_default_timezone_get());
$serverDateTime = new DateTime('now', $serverTimeZone);
$serverDateTimeString = $serverDateTime->format('l, d-m-Y, H:i:s');

// Pobierz informacje o strefie czasowej na podstawie adresu IP klienta
$ipInfoUrl = "https://ipapi.co/{$clientIP}/json/";
$ipInfo = json_decode(file_get_contents($ipInfoUrl));

// Sprawdź, czy informacja o strefie czasowej została pobrana poprawnie
if (isset($ipInfo->timezone) && !empty($ipInfo->timezone)) {
    $clientTimeZone = new DateTimeZone($ipInfo->timezone);
} else {
    $clientTimeZone = $serverTimeZone; // Użyj domyślnej strefy czasowej serwera
}

// Pobierz datę i godzinę w strefie czasowej klienta
$clientDateTime = new DateTime('now', $clientTimeZone);
$clientDateTimeString = $clientDateTime->format('l, d-m-Y, H:i:s');

// Zapisz informacje do logów:
$logMessage = sprintf("Serwer uruchomiony dnia: %s \nprzez: Adrian Duwer \nna porcie: %s \n", $serverDateTimeString, $_SERVER['SERVER_PORT']);
file_put_contents('log.txt', $logMessage . PHP_EOL, FILE_APPEND);

// Wyświetl stronę informacyjną dla klienta
echo "<html>
<head>
<title>Informacje o kliencie</title>
</head>
<body>
<h1>Adres IP klienta: $clientIP</h1>
<h2>Data i godzina: $clientDateTimeString</h2>
</body>
</html>";
?>