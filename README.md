ESTA - Elternsprechtagsanwendung
================================

Diese Anwendung ist dafür gedacht den Organisationsaufwand von Elternsprechtagen für Schüler, Eltern, Lehrern und der Verwaltung so gering wie möglich zu halten. Insbesondere den Eltern soll damit die Möglichkeit gegeben werden in Echtzeit Termine buchen zu können.

Alle Informationen können im Wiki unter http://synlos.net/redmine/projects/est/wiki gefunden werden.

Bei Fragen, Kritik, Lob und/oder Anregungen kann man sich an Christian Ehringfeld (c[dot]ehringfeld[at]t-online[dot]de) oder David Mock (dumock[at]gmail[dot]com) wenden.

Sollten Sie das Projekt unterstützen wollen (z.B. bei der Übersetzung von Deutsch in Englisch oder der weiteren Entwicklung) so können Sie sich ebenfalls an die genannten Personen wenden.


Information for english speaking People
---------------------------------------

This project is intended to manage parent teacher days. At the moment this application is  only available in german and english. The english translation is mostly done and only a few bits are left to translate. It is licensed under the GPLv3.

For more Information contact Christian Ehringfeld (c[dot]ehringfeld[at]t-online[dot]de) or David Mock (dumock[at]gmail[dot]com).

# Running the tests

You can run the common (unit) tests using:

    vendor/bin/phpunit

## Feature Tests

You should start the development server using:

    php -S localhost:8000 -t ./ index.php

And then run the feature tests using:

    vendor/bin/phpunit --group=feature

To debug the feature tests use:

    vendor/bin/phpunit --group=feature --debug --stop-on-failure

### Generate Code Coverage for Feature Tests

Execute the following commands in order:

    touch .generate-functional-coverage
    vendor/bin/phpunit --group=feature --debug --stop-on-failure
    rm .generate-functional-coverage
    vendor/bin/phpcov merge --html=build/functional-coverage-report build/functional-coverage

And you'll find the coverage report in
`build/functional-coverage-report/index.html`.

