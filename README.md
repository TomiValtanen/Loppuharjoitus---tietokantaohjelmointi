# Loppuharjoitus tietokantaohjelmointi

## Loppuharjoituksen sisältö:

- Tuoteryhmien näyttäminen.
- Tuotteiden näyttäminen valitun tuoteryhmän perusteella.
- Tuotteiden tilaaminen ja tilausten käsittely.
- Ylläpitäjän kirjautuminen järjestelmään.
- Ylläpito-osio, jossa voi lisätä tuoteryhmän , tuotteen ja muuttaa tilauksen tilaa.
- Tuotteiden haku id:n perusteella.

## Tekniset vaatimukset:

- Sql komennot löytyvät sql kansiosta.
- Sqlite kantaan tehty.
- Json ja request parametrejä käytetty.
- kyselyitä ja funktioita.
- Valmistelut , parametrisointia ja sanitointia käytettynä. Transaktiota löytyy newOrder.php ja ordersManagement.php.
- Sessiota käyettynä tunnistaumisissa.

## Lisäystä 

- Backend tehty polkypyörä tietokantaan.
- Kirjautuminen sisään, rekisteröinti ja uloskirjautuminen löytyvät ja niihin kyselyt on laitettuna userControl.php
- Admin käyttäjälle on sama kirjautumis systeemi mitä tavalliselle käyttäjälle.
- Admin käyttäjä tunnistetaan , kun halutaan lisätä kategorioita, tuotteita tai muuttaa tilauksen tilaa.
- Käyttäjätietoja tarvitaan , kun halutaan tehdä tilausta.


