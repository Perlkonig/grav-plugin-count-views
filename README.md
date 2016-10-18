# Count Views Plugin

The **Count Views** Plugin is for [Grav CMS](http://github.com/getgrav/grav). It's a simple and naive page view counter.

## Installation

Installing the Count Views plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install count-views

This will install the Count Views plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/count-views`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `count-views`. You can find these files on [GitHub](https://github.com/aaron-dalton/grav-plugin-count-views) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/count-views
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/count-views/count-views.yaml` to `user/config/plugins/count-views.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
datadir: ''
datafile: count-views.yaml
```

  * The `enabled` field lets you turn the plugin off and on.

  * `datadir` is a folder relative to the `user/data` folder where the count data will be stored.

  * `datafile` is the name of the file that contains the count data.

## Usage

This is a simple, naive page view counter. Whenever the Grav system produces a page (cached or not), the route is stored and the count incremented. Obviously if you have a front-end cache that delivers the page without invoking `index.php`, then the view won't be counted. 

After the view count is incremented, the full view count data is dumped as an associative array (i.e., route -> count) into the `config.plugins.count-views.count` namespace so you can access it via twig (e.g., `{{ config.plugins['count-views'].counts['/blog/my-slug'] }}`).

