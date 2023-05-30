# PFSwChO-zadanie1
#### Adrian Duwer 90902
##### Laboratorium Programowanie FullStack w chmurze obliczeniowej - sprawozdanie z zadania 1

## Zadanie 1: 
#### PLIK: index.php
Na początku kodu w pliku index.php zdefiniowana jest zmienna $clientIP, która przechowuje adres IP klienta. Następnie kod pobiera bieżącą datę i godzinę w strefie czasowej serwera i zapisuje je w zmiennej $serverDateTimeString. Wykorzystuje do tego obiekt DateTime i DateTimeZone, które pozwalają na operacje na czasie i strefach czasowych. Wykorzystujemy usługę IPAPI (https://ipapi.co/), aby uzyskać informacje o strefie czasowej na podstawie adresu IP klienta. Tworzony jest URL z adresem IP klienta, a następnie pobierane są dane w formacie JSON przy użyciu funkcji file_get_contents(). Otrzymane dane są dekodowane i przechowywane w zmiennej $ipInfo. Po pobraniu informacji o strefie czasowej klienta, kod sprawdza, czy informacja została pobrana poprawnie, sprawdzając, czy zmienna $ipInfo zawiera pole timezone i czy nie jest puste. Jeśli informacja o strefie czasowej jest dostępna, tworzona jest nowa strefa czasowa $clientTimeZone na podstawie otrzymanych danych. Jeśli jednak nie udało się pobrać informacji o strefie czasowej, kod użyje domyślnej strefy czasowej serwera. Następnie pobieramy bieżącą datę i godzinę w strefie czasowej klienta przy użyciu obiektu DateTime i $clientTimeZone. Wynik jest zapisywany w zmiennej $clientDateTimeString. Kolejnym krokiem jest zapisanie informacji o uruchomieniu serwera do pliku. Tworzony jest komunikat zawierający datę uruchomienia serwera, autora i port serwera. Komunikat ten jest zapisywany w pliku "log.txt" za pomocą funkcji file_put_contents(). Na końcu generowana jest strona HTML, która wyświetla informacje o kliencie. Cała struktura strony HTML jest generowana dynamicznie przy użyciu funkcji echo.

## Zadanie 2:
#### PLIK: Dockerfile
Tekstowy opis poszczególnych sekcji i instrukcji w pliku Dockerfile: <br> 
FROM php:7.4-alpine AS builder: Instrukcja FROM określa bazowy obraz, który zostanie użyty jako podstawa dla obrazu kontenera. W tym przypadku używamy obrazu php:7.4-alpine. <br> 
WORKDIR /app: Instrukcja WORKDIR ustawia katalog roboczy (working directory) dla wszystkich kolejnych instrukcji w kontekście tego obrazu. <br> 
RUN apk add --no-cache curl: Instrukcja RUN wykonuje polecenie wewnątrz kontenera podczas budowania obrazu. Tutaj instalujemy pakiet curl przy użyciu menedżera pakietów Alpine Linux. <br> 
COPY . .: Instrukcja COPY kopiuje pliki z lokalnego systemu plików do kontenera. Kopiujemy wszystkie pliki i foldery z obecnego katalogu (kontekstu) do katalogu roboczego w kontenerze. <br> 
FROM builder: Ta linijka rozpoczyna drugi etap budowania obrazu. Odnosi się do wcześniej zdefiniowanego etapu oznaczonego jako builder. <br> 
WORKDIR /app: Ponownie ustawiamy katalog roboczy dla drugiego etapu. <br> 
COPY --from=builder /app .: Kopiujemy pliki z etapu budowania (builder) do bieżącego katalogu roboczego w drugim etapie. <br> 
RUN apk add --no-cache curl: Instalujemy zależności aplikacji w drugim etapie, tak jak to zostało wykonane w pierwszym etapie. <br> 
RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini: Dodajemy wpis do pliku php.ini w celu ustawienia domyślnej strefy czasowej PHP na UTC. <br> 
EXPOSE 80: Instrukcja EXPOSE określa port, na którym aplikacja w kontenerze będzie nasłuchiwać. <br> 
HEALTHCHECK --interval=60s --timeout=3s CMD curl --fail http://localhost:80/ || exit 1: Instrukcja HEALTHCHECK definiuje mechanizm sprawdzania stanu zdrowia aplikacji wewnątrz kontenera. Tutaj wykonujemy zapytanie HTTP do lokalnego adresu przy użyciu curl. Jeśli zapytanie zwróci błąd, proces sprawdzania zakończy się niepowodzeniem. <br> 
LABEL author="Adrian Duwer": Etykieta LABEL umożliwia dodanie metadanych do obrazu. Tutaj dodajemy informację o autorze. <br> 
CMD ["php", "-S", "0.0.0.0:80"]: Instrukcja CMD definiuje domyślne polecenie, które zostanie wykonane podczas uruchamiania kontenera. Tutaj uruchamiamy serwer PHP, który nasłuchuje na adresie IP 0.0.0.0 i porcie 80 <br> 

## Zadanie 3: 
a) docker build -t aplikacja-pfswcho . <br> 
Polecenie "docker build -t aplikacja-pfswcho ." buduje obraz Docker o nazwie "aplikacja-pfswcho" na podstawie pliku Dockerfile znajdującego się w bieżącym katalogu. Ta komenda jest używana do utworzenia obrazu aplikacji. <br> 
<br> 
b) docker run –p 8080:80 aplikacja-pfswcho <br> 
Polecenie "docker run -p 8080:80 aplikacja-pfswcho" uruchamia kontener na podstawie obrazu "aplikacja-pfswcho" i mapuje port 8080 hosta na port 80 kontenera. Oznacza to, że aplikacja w kontenerze będzie dostępna na porcie 8080 na lokalnym hoście. <br> 
<br> 
c) docker exec upbeat_goldberg cat log.txt <br> 
Polecenie "docker exec nazwa_obrazu cat log.txt" wykonuje polecenie "cat log.txt" wewnątrz kontenera o konkretnej nazwie. Polecenie "cat" wyświetla zawartość pliku "log.txt" w konsoli. W naszym przypadku nazwa obrazu to upbeat_goldberg co zweryfikowane zostało komendą docker ps <br> 
<br> 
d) docker history aplikacja-pfswcho <br> 
Polecenie "docker history aplikacja-pfswcho" wyświetla historię warstw obrazu Docker o nazwie "aplikacja-pfswcho". Pozwala to zobaczyć, jakie instrukcje zostały użyte podczas budowania obrazu i jakie warstwy zostały utworzone. <br> 
Istnieje również możliwość użycia polecenia docker image inspect <nazwa_obrazu>, który służy do wyświetlenia szczegółowych informacji o danym obrazie  <br> 
<br>
Zrzuty ekranu dla poszczególnych zadań znajdują się w repozytorium z nazwą pliku odpowiadającej danemu zadaniu z konkretnym podpunktem.
Repozytorium zawiera również plik zbiorczy (Adrian Duwer 90902.pdf), który zawiera opis poszczególnych zadań wraz z załączonymi zrzutami ekranu
