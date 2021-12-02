# Pcelarski-obrti
Uloge: administrator, moderator, registrirani korisnik i anonimni/neregistrirani korisnici.

Sustav služi za reklamiranje proizvoda certificiranih pčelarskih obrta. Sustav ima mogućnost prijave i odjave korisnika sa sustava. 
U sustavu postoji jedan ugrađeni administrator (korisničko ime: admin, lozinka: foi). Administrator je prijavljeni korisnik koji ima vrstu jednaku jedan.
Sustav sadrži stranicu o_autoru.html (poveznica na stranicu u zaglavlju svake stranice) u kojoj se nalaze osobni podaci autora i slika.

Anonimni/neregistrirani korisnik može samo vidjeti top 15 proizvoda sa najboljom ocjenom u obliku galerije slika.

Registrirani korisnik uz svoje funkcionalnosti ima i sve funkcionalnosti kao i neprijavljeni korisnik. Vidi popis certificiranih obrta i odabirom obrta vidi proizvode tog obrta kao galeriju slika.
Može odabrati proizvod nakon čega dobiva kontakt informacije (telefon, mail, adresa, ...) obrta i sve informacije o proizvodu te može samo jednom ocijeniti proizvod od 1 do 5.
Kod ocjenjivanja automatski se unosi datum i vrijeme ocjene. Vidi popis svih proizvoda koje je ocijenio (prikazuje se naziv proizvoda, naziv obrta, ocjena i datum ocjene).

Moderator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i registrirani korisnik te uz to može kreirati samo jedan obrt.
Kod kreiranja unosi naziv obrta, opis i kontakt informacije. Inicijalno je obrt u statusu kreiran, a administrator mora certificirati obrt prije nego moderator može dodavati proizvode. 
Moderator nakon prijave može pregledavati i ažurirati kontakt informacije svog obrta (naziv i opis se ne mogu mijenjati). Moderator unosi, ažurira i pregledava proizvode svog obrta. 
Kod unosa proizvoda mora unijeti naziv, opis, sliku i video. Prilikom prijave vidi popis svih svojih proizvoda s prosječnom ocjenom svakog proizvoda.

Administrator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i moderator. Unosi, ažurira i pregledava korisnike sustava te definira i ažurira njihove tipove.
Administrator ima popis kreiranih obrta, posebno su naznačeni obrti koji nisu certificirani. Odabirom obrta vidi sve informacije i može promijeniti status obrta u certificiran.
Ako je obrt certificiran može mu promijeniti status natrag u kreiran i time taj obrt i svi proizvodi nisu više vidljivi. Također moderator ne može dodavati nove proizvode dok se status opet ne promjeni u certificiran. 
Vidi prosječne ocjene po proizvodima, a podatke može filtrirati na temelju obrta i vremenskog razdoblja po datumu ocjene. Razdoblje se definira datumom i vremenom od i do.

