@extends('layouts.app')

@section('content')
    <div class="w-full bg-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class='impressum'>
                    <h1 class="h1">Impressum</h1>
                    <p>Angaben gemäß § 5 TMG</p>
                    <p>Tristan Eberhardt<br>
                    Dietrich-Bonhoeffer-Str. 15<br>
                    73732 Esslingen am Neckar <br></p>
                    <p> <strong>Vertreten durch: </strong><br>
                        Raluca Vedislav (1. Vorsitzende)<br>
                        Tristan Eberhardt (2. Vorsitzender)<br>
                        Maximilian Frenken (Kassenwart)<br>
                    </p>
                    <p>
                        <strong>Satzung: </strong><br>
                        <a class="text-blue-500" href="{{ asset('storage/imp_files/satzung_cl_ev.pdf') }}" target="_blank">Satzung CampusLeben
                            e.V.</a>
                    </p>
                    <p><strong>Kontakt:</strong> <br>
                        Telefon: 0711 397-3498<br>
                        E-Mail: <a href='mailto:campusleben@hs-esslingen.de'>campusleben@hs-esslingen.de</a></br></p>
                    <p><strong>Registereintrag: </strong><br>
                        Eintragung im Registergericht: Stuttgart<br>
                        Registernummer: VR210516<br></p>
                    <p><strong>Umsatzsteuer-ID: </strong> <br>
                        Umsatzsteuer-Identifikationsnummer gemäß §27a Umsatzsteuergesetz: 59338/02038<br>
                    </p>
                    <p><strong>Aufsichtsbehörde:</strong><br>
                        Amtsgericht Stuttgart<br></p>
                    <p><strong>Genderhinweis:</strong><br>
                        Aus Gründen der besseren Lesbarkeit wird auf die gleichzeitige Verwendung der Sprachformen männlich,
                        weiblich und divers (m/w/d) verzichtet. Sämtliche Personenbezeichnungen gelten gleichermaßen für
                        alle
                        Geschlechter.<br></p>
                    <p><strong>Haftungsausschluss: </strong><br><br><strong>Haftung für Inhalte</strong><br><br>
                        Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit,
                        Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als
                        Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den
                        allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht
                        verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen
                        zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder
                        Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine
                        diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten
                        Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese
                        Inhalte umgehend entfernen.<br><br><strong>Haftung für Links</strong><br><br>
                        Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss
                        haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte
                        der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die
                        verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft.
                        Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente
                        inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer
                        Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links
                        umgehend entfernen.<br><br><strong>Urheberrecht</strong><br><br>
                        Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem
                        deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung
                        außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors
                        bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen
                        Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden
                        die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet.
                        Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen
                        entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte
                        umgehend entfernen.<br><br><strong>Datenschutz</strong><br><br>
                        Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich. Soweit
                        auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen)
                        erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis. Diese Daten werden ohne
                        Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben. <br>
                        Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail)
                        Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist
                        nicht möglich. <br>
                        Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten durch Dritte zur
                        Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit
                        ausdrücklich widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte
                        im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor. Mehr
                        Information
                        zum Datenschutz finden Sie <a href="{{ route('datenschutz') }}">hier.</a><br>
                        <br>
                    </p><br>
                    Website Impressum erstellt durch <a href="https://www.impressum-generator.de">impressum-generator.de</a>
                    von der <a href="https://www.kanzlei-hasselbach.de/" rel="nofollow">Kanzlei Hasselbach</a>
                </div>
            </div>
        </div>
    </div>
@endsection
