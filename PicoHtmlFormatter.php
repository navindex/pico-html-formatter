<?php

namespace Navindex\PicoHtmlFormatter;

use Navindex\HtmlFormatter\Formatter;

/**
 * HTML formatter plugin.
 *
 * Do not use this plugin in production environment.
 *
 * {@see https://github.com/navindex/html-formatter} for a full list of features.
 *
 * @author  Navindex Pty Ltd
 * @link    https://navindex.com.au
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 0.1.0
 */
class PicoHtmlFormatter extends AbstractPicoPlugin
{
    /**
     * Configuration section key.
     *
     * @var array|null
     */
    protected $section = 'HtmlFormatter';

    /**
     * Plugin configuration
     *
     * @var array|null
     */
    protected $config;

    /**
     * API version used by this plugin
     *
     * @var int
     */
    const API_VERSION = 3;

    /**
     * @see AbstractPicoPlugin::$enabled
     * @var bool|null
     */
    protected $enabled;

    /**
     * Formatter action (beautify or minify).
     *
     * @var string
     */
    protected $action = 'beautify';
    /**
     * Triggered after Pico has read its configuration
     *
     * @see Pico::getConfig()
     * @see Pico::getBaseUrl()
     * @see Pico::isUrlRewritingEnabled()
     *
     * @param array &$config array of config variables
     */
    public function onConfigLoaded(array &$config)
    {
        $this->config = $config[$this->section] ?? null;

        $action = $this->config['action'] ?? null;
        $this->action = in_array($action, ['beautify', 'minify']) ? $action : 'beautify';
        unset($this->config['action']);
    }

    /**
     * Triggered after Pico has rendered the page
     *
     * @see DummyPlugin::onPageRendering()
     *
     * @param string &$output contents which will be sent to the user
     */
    public function onPageRendered(&$output)
    {
        $output = (new Formatter($this->config))->beautify($output);
    }
}
