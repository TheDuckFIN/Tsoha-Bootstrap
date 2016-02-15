# Tietokantasovelluksen esittelysivu

## Viikko 3 palautus huom!
Toteutin viikolla aika monta modelia, kontrolleria ja viewiä!

* Etusivulla näkyvä kategorioiden ja aihealueiden listaus käytännössä valmis, varmaan hienosäätöä vielä tulevaisuudessa
* Keskustelujen listaus aihealueella toimii (mutta listausjärjestys ei riipu uusimmasta viestistä, TODO!)
* Uuden keskustelun luominen **EI OLE TOTEUTETTU**, teen sen ensi viikolla
  * Valmiissa keskustelussa voi tosin **lähettää sekä poistaa viestejä**
  * Viestin muokkaus toimii visuaalisesti, mutta tietokantaan tallennusta en vielä tehnyt
* Rekisteröitymistä/kirjautumista en vielä toteuttanut. Kaikki viestit, jotka lähetät, kirjautuvat käyttäjälle **Jorma**, jonka profiilisivua et pysty katsomaan. **Ainoastaan käyttäjän vlakanie profiilisivu toimii, ja se on staattinen.**
* Viikon pistevaatimuksissa mainitut metodit **all, find ja save** löytyvät ainakin luokasta **message**, kts. https://github.com/TheDuckFIN/Tsoha-Bootstrap/blob/master/app/models/message.php
* Kontrollereiden vastuut eivät ole aivan yhtä selvät, sillä esimerkiksi BoardController hoitaa sekä kategorioita, että aihealueita.
  * Viikon pistevaatimusten toisen kohdan toteuttaa todennäköisesti keskustelu.
    * https://github.com/TheDuckFIN/Tsoha-Bootstrap/blob/master/app/controllers/thread_controller.php
      * Keskustelut listaa metodi **index**
      * Yksittäisen keskustelun esittelee metodi **show**, joka listaa kaikki keskustelun viestit. 
    * https://github.com/TheDuckFIN/Tsoha-Bootstrap/blob/master/app/controllers/post_controller.php
      * Uuden viestin lisäys keskusteluun onnistuu PostControllerin metodeilla **create** ja **store**, boonuksena myös metodi **delete** viestin poistamiseen.
* Validoinnit puuttuvat vielä täysin, ja sovelluksessa pystyy tällä hetkellä tekemään ihan järjettömiäkin juttuja, mutta validointia ilmeisesti tulee ensi viikolla, joten se jääkööt sen ajan murheeksi. 

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
