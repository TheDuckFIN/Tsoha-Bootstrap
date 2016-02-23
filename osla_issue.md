Koodi ladattu 23.2.2016 klo 3:10

Moi! Projektisi näyttää edistyneen oikein mallikkaasti :) Tässä muutamia kehitysehdotuksia!

* Joidenkin sarakkeiden nimet ja näin ollen myös modeleissa esiintyvät muuttujanimet ovat hieman ikäviä, ja itseäni ainakin häiritsee kovin :D Esimerkiksi kurssin id on nimeltään "kurssiid". Eikö se voisi vain yksinkertaisesti olla id? :D Ylipäätänsä pyrkisin ehkä pitämään muuttujien sekä taulujen sarakkeiden nimet lyhyinä ja ytimekkäinä. Lisää esimerkkejä: kayttajaid -> id, kayttajannimi -> nimi, kayttajansposti -> email jne. Virheitähän nämä eivät missään nimessä ole, mutta esimerkiksi kun käyttäjän hakee vaikka koodilla $kayttaja = Kayttaja::find(1) niin tällä hetkellä nimen saa $kayttaja->kayttajannimi kun se voisi vain olla $kayttaja->nimi.
* Tällä hetkellä olet määrittänyt käyttäjän sähköpostin säilöttäväksi tietokannassa tyypillä VARCHAR(50), eli maksimissaan 50 merkkiä. Sähköpostiosoite voi kuitenkin olla jopa 254 merkkiä pitkä (http://www.eph.co.uk/resources/email-address-length-faq/#emailmaxlength), jolloin järjestelmän kanssa tulee ongelmia. 
* Projektissasi on tällä hetkellä kaksi modelia käyttäjälle: models/user.php sekä models/kayttaja.php. Miksi? 
* User.php:ssä find-metodissa on rivi "SELECT * FROM Kayttaja WHERE kayttajaid=:$id LIMIT 1". Tässä taitaa olla virhe, pitäisikö :$id kenties olla :id? 
* Yksi asia mitä omaa sovellustanikin tehdessä huomasin, oli se, että käyttäjän syötteet kannattaa validoida niin formeista, kuin osoitepalkistakin. Sillä esimerkiksi seuraavat osoitteet aiheuttavat hieman hassuja tilanteita:
    - http://mkjarvi.users.cs.helsinki.fi/kurssikysely_tsoha/kysely/1000000000000000000000
    - http://mkjarvi.users.cs.helsinki.fi/kurssikysely_tsoha/kysely/moi
    - Nämä johtuvat siitä, ettei missään välissä tarkasteta onko käyttäjän antama id validi kokonaisluku, tai edes kokonaisluku ollenkaan, jolloin PostreSQL suuttuu, kun saa vääränlaisen syötteen. Tämä on kuitenkin pientä "hifistelyä" eikä välttämättä kurssin kannalta ole olennaista lähteä id:tä validoimaan, kun järjestelmän oikein toimiessa ei pitäisi käyttäjän joutua sellaiseen tilanteeseen, missä id olisi epävalidi.
        + Yksi minkä voisi tosin korjata on seuraava: http://mkjarvi.users.cs.helsinki.fi/kurssikysely_tsoha/kysely/20
            * Tämä johtuu siitä, ettet tarkista missään vaiheessa kyselyt_controller.php:ssa onko kyselyä tällä ID:llä löydetty kannasta. Kun kutsut $kysely = Kysely::find($id);, tulee muuttujan $kysely arvoksi NULL jos kyselyä ei ole kannassa, eli voit kyseisen rivin jälkeen käskeä if (!$kysely) { ...toteuta virheilmoitus... }
