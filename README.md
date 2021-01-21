# slaeck-bot

Inoffizieller Släck-Bot für <https://www.berndeutsch.ch>

`LIVE`: <https://slaeck-bot.existenz.ch>

## Struktur

- Hört auf Slash-Command `/bärndütsch`.
- Benutzt [Requests](https://requests.ryanmccue.info) um die Suche bei Berndeutsch.ch anzuwerfen.
- Parset die Antwortseite.
- Gibt alle gefundenen Übersetzungen zurück.

## Installation

Dokumentation Slash Commands: <https://api.slack.com/interactivity/slash-commands>

- Auf Slack.com einloggen und neue App erstellen: <https://api.slack.com/apps>
- "Slash Commands" erstellen: <https://api.slack.com/apps/A01L4135ZME/slash-commands?>
- Neues Kommando:
  - Command: `/bärndütsch`
  - Request URL: <https://slaeck-bot.existenz.ch/api/slashcommand.php>
  - Short Description: "Übersetzt mal das hie."
  - Usage Hint: "Wort"
- Bot kreieren wenn notwendig.
- App installieren.

## Entwicklung

- Mindestens PHP 7.4 installieren, [Composer](https://getcomposer.org) installieren.
- `composer run serve`
- Öffne <http://localhost:8000>

## Deployment

`composer run deploy-LIVE`

Keine Test-Instanz vorhanden.

## Credits

Programmiert von [Christian Studer](mailto:cstuder@existenz.ch) zur Verwendung im internen [Aare.guru](Aare.guru)-Slackkanal.

Keine offizielle Verbindung zu [berndeutsch.ch](https://www.berndeutsch.ch), nur eine ideelle.

Item.

## Lizenz

[MIT](LICENSE)
