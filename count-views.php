<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use RocketTheme\Toolbox\File\File;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CountViewsPlugin
 * @package Grav\Plugin
 */
class CountViewsPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0]
        ]);
    }

    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPageInitialized(Event $e)
    {
        // Get count data file
        $config = $this->grav['config'];
        $locator = $this->grav['locator'];
        $path = $locator->findResource('user://data', true);
        $datadir = $config->get('plugins.count-views.datadir', '');
        $datafile = $config->get('plugins.count-views.datafile', 'count-views.yaml');
        if (! empty($datadir)) {
            $filename = $path . DS . $datadir . DS . $datafile;
        } else {
            $filename = $path . DS . $datafile;
        }

        // Get page route
        $page = $this->grav['page'];
        $route = $page->route();

        // Open data file
        $datafh = File::instance($filename);
        $datafh->lock();
        $data = Yaml::parse($datafh->content());
        if ($data === null) {
            $data = array();
        }

        // Record count
        if (array_key_exists($route, $data)) {
            $data[$route]++;
        } else {
            $data[$route] = 1;
        }

        // Load count data into `config.plugins` space
        $this->config->set('plugins.count-views.counts', $data);

        // Save 
        $datafh->save(YAML::dump($data));
        $datafh->free();
    }
}
