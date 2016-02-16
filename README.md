# Tietokantasovelluksen esittelysivu

## Viikko 4
Kärsin pitkittyneestä ebolasta, joten viikon tulos jäi vähän vähälle.
* Suurin saavutus varmaan on käytännössä valmis kirjautumis/rekisteröitymissysteemi
* Viikon vaatimuksissa mainittu **validointi** löytyy **User-modelista**, muualle en ole validointia ehtinyt toteuttaa
* **Destroy** ja **update** löytyvät Message-modelista ja Post-kontrollerista. Toimivat myös käytännössä:
 * Keskusteluja ei voi vieläkään luoda, mutta viestejä pystyy **luomaan, muokkaamaan ja poistamaan**
 * Viestien muokkaus ja poistaminen toimii vain omiin viesteihin
  * Jos kuitenkin haluaa lähteä hakkeroimaan, pystyy myös muoden viestejä todennäköisesti poistamaan/muokkaamaan. Kaikki on todella WIP, ja en ole vielä kerennyt mitään pahemmin suojaamaan. 

Tunnukset näet dokumentaation lopusta. Luo vaikka uudet rekisteröintilomakkeella. Valmiita tunnuksia ovat vlakanie, modemies sekä jorma, kaikilla salasana on "salasana".

## Yleistä

Yleisiä linkkejä:

* [Linkki sovellukseeni](http://vlakanie.users.cs.helsinki.fi/tsoha/)
* [Linkki dokumentaatiooni](https://github.com/TheDuckFIN/Tsoha-Bootstrap/blob/master/doc/dokumentaatio.pdf)

Bootstrap:

* [Typography](http://getbootstrap.com/css/#type)
* [Tables](http://getbootstrap.com/css/#tables)
* [Forms](http://getbootstrap.com/css/#forms)
* [Buttons](http://getbootstrap.com/css/#buttons)

## Työn aihe

Toteutan kurssilla geneerisen keskustelupalstasovelluksen, joka ei siis ole suunnattu mihinkään tiettyyn käyttötarkoitukseen (esimerkiksi pokemon-harrastajien keskustelunurkaksi), vaan se toimii yleisalustana mille tahansa keskustelufoorumille. 

Keskustelupalsta sisältää kategorioita, jotka taas sisältävät aihealueita. Aihealueille rekisteröityneet käyttäjät pystyvät luomaan uusia keskusteluja, ja keskusteluihin pystyy lähettämään viestejä. Omia viestejään pystyy muokkaamaan.

Moderaattorit pystyvät poistamaan ja muokkaamaan mitä tahansa viestejä, poistamaan, lukitsemaan tai avaamaan keskusteluja, ja asettamaan käyttäjiä porttikieltoon sekä poistamaan porttikieltoja. Ylläpitäjät taas pääsevät käsiksi käytännössä kaikkiin foorumin asetuksiin, ja pystyvät muun muassa hallitsemaan kategorioita sekä aihealueita. Tarkemmin dokumentaatiossa!

Lisäksi toteutan yksityisviestisysteemin ja hakutoiminnallisuuden jos ehdin :)
