# slaeck-bot

Inoffizieller Släck-Bot für <https://www.berndeutsch.ch>

`LIVE`: <https://slaeck-bot.existenz.ch>

## Struktur

- Hört auf Slash-Commands `/berndeutsch` und `/bärndütsch`.
- Benutzt [Requests](https://requests.ryanmccue.info) um die Suche bei Berndeutsch.ch anzuwerfen.
- Parset die Antwortseite und nimmt die ersten drei Übersetzungen zur Hand.
- Benutzt [slack-php-api](https://github.com/jolicode/slack-php-api) um eine Response nach Slack zu posten.

## Installation

TODO.

## Entwicklung

- Mindestens PHP 7.4 installieren, [Composer](https://getcomposer.org) installieren.
- `composer run-script serve`
- Öffne <http://localhost:8000>

## Deployment

`composer run-script deploy-LIVE`

## Credits

Programmiert von [Christian Studer](mailto:cstuder@existenz.ch) zur Verwendung im internen [Aare.guru](Aare.guru)-Slackkanal.

Keine offizielle Verbindung zu [berndeutsch.ch](https://www.berndeutsch.ch), nur eine ideelle.

Item.

## Lizenz

[MIT](LICENSE)
