# HomeScreen

HomeScreen is simple PHP script for providing your custom configurable start page for browsers.
The start page consists of number of blocks where you can add anything you want: list of you favorite sites, 
any notifications, rss, weather forecast, money exchange rates and do on.
Now it is at very beggining of development, only test "Hello world" plugin is provided.

## Usage
Add
```php -S localhost:4321 -t <path-to-HomeScreen-root>```
to your system autostart and then set http://localhost:4321 as start page in your browser settings.
Or just add put it to subdirectory on your local web server if you have one. (Every web developer should have it, huh!)

## Configuration
Configuration is defined in `settings.json` file in JSON format (see settings.json.sample for example). This file consist following entries:
title — A title tag for start page.
lang — Language code for <html> tag lang attribute.
template — Template for whole page will be taken from `template/<template_name>/template.php` subdirectory
blocks — The items displayed on the page should be listed here as array. Each item should have following keys:
 * type — Name of plug-in to display the block
 * params — Parameters for block. They are plugin-depended, look to plugins code or settings.json.sample for example.
 * area — The area in template file where block will be printed. 
 * id — Id attribute for external HTML tag of the block. If none specified, block#number will be used.
 * class — Class attribute for external HTML tag of the block.

## Design
You can create your own design for your start page. Just create new subdirectory in template dir, 
copy there `template/default/template.php` file and edit it for your needs. Then specify your new design directory as "template" in `settings.json`.
Put any assets to same directory if you need.

## Plugins or blocks
Plugins or the blocks are stored in `blocks/<plugin-name>` subdirectory. The filename for plugin uses snake_case (all lowercase letters with underscores as separators).
The main plugin file should contain PHP class Block<PluginName>, where PluginName is written in CamelCase (first letter of each word is uppercase, no separators).

The class should define at least two functions:
__construct($id,$params,$class=null) — accepts id and class attributes for outer HTML tag in the block and parameters used to display block. 
__toString() — outputs HTML code of the block.

