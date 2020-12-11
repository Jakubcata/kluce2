# Kľúče Jakubčatá

Jednoduchý nástroj na trackovanie pohybu kľúčov od fary.


### Prerequisites

Tento nástroj je napísaný ako web appka, preto na jej spustenie je potrebné:

```
php >=7.2.5
mysql
apache2, alebo niečo podobné
composer
```

### Installing

Pokiaľ máte všetky potrebné závislosti nainštalované, treba ešte doinštalovať používané balíčky pomocou príkazu:

```
composer install
```

Následne skopírujte

```
cp .env.example .env
```
a nastavte správne premenné

potom možno ešte bude treba zmeniť práva

```
chmod 777 -R bootstrap storage
```
