# Etap 1: Budowanie aplikacji PHP
FROM php:7.4-alpine AS builder
WORKDIR /app

# Instalacja zależności aplikacji
RUN apk add --no-cache curl

# Skopiuj resztę plików aplikacji
COPY . .

# Etap 2: Uruchomienie aplikacji PHP
FROM builder
WORKDIR /app

# Skopiuj pliki z etapu budowania
COPY --from=builder /app .

# Instalacja zależności aplikacji
RUN apk add --no-cache curl

# Ustawienia PHP
RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini

# Port, na którym działa aplikacja
EXPOSE 80

# HEALTHCHECK aplikacji
HEALTHCHECK --interval=60s --timeout=3s \
  CMD curl --fail http://localhost:80/ || exit 1

# Informacja o autorze
LABEL author="Adrian Duwer"

# Uruchomienie serwera HTTP
CMD ["php", "-S", "0.0.0.0:80"]

