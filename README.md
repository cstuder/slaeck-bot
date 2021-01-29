# slaeck-bot

Inoffizieller Släck-Bot für <https://www.berndeutsch.ch>

`LIVE`: <https://slaeck-bot.existenz.ch>

![PHPUnit tests](https://github.com/cstuder/slaeck-bot/workflows/PHPUnit%20tests/badge.svg)

## Struktur

- Hört auf Slash-Command `/bärndütsch` in der Datei [slashcommand.php](www/api/slashcommand.php)
- Benutzt [Requests](https://requests.ryanmccue.info) um die Suche bei Berndeutsch.ch anzuwerfen.
- Parst die Antwortseite.
- Gibt alle gefundenen Übersetzungen zurück.

## Installation

Dokumentation Slash Commands: <https://api.slack.com/interactivity/slash-commands>

- Auf Slack.com einloggen und neue App erstellen: <https://api.slack.com/apps>
- "Slash Commands" erstellen.
- Neues Kommando:
  - Command: `/bärndütsch`
  - Request URL: <https://slaeck-bot.existenz.ch/api/slashcommand>
  - Short Description: "Übersetzt mal das hie."
  - Usage Hint: "Wort"
- Bot kreieren wenn notwendig. In "App Home" den "Messages Tab" abstellen.
- App installieren.

## Entwicklung

- Mindestens PHP 7.4 installieren, [Composer](https://getcomposer.org) installieren.
- `composer run serve`
- Öffne <http://localhost:8000>

## Testen

`composer run test`

Hinweis: Benutzt die Webseite berndeutsch.ch als Quelle für Testdaten.

Vorteil: Wenn das Markup oder die Struktur der Webseite ändert, schlagen die Tests fehl.

Nachteil: Bei Nicht-Erreichbarkeit oder massiven Änderungen am Vokabular schlagen die Tests fehl.

## Deployment

`composer run deploy-LIVE`

Keine Test-Instanz vorhanden.

## Credits

Programmiert von [Christian Studer](mailto:cstuder@existenz.ch) zur Verwendung im internen [Aare.guru](Aare.guru)-Slackkanal.

Keine offizielle Verbindung zu [berndeutsch.ch](https://www.berndeutsch.ch), nur eine ideelle.

Verwendung von [berndeutsch.ch](https://www.berndeutsch.ch) mit freundlicher Genehmigung des Webmasters.

Logo von [Kaspar Allenbach](https://kaspar-allenbach.ch).

Item.

## Lizenz

[MIT](LICENSE)
