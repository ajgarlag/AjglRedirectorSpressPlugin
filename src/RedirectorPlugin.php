<?php

/*
 * AJGL Redirector Spress Plugin
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Spress\Plugin\Redirector;

use Ajgl\Spress\Plugin\Redirector\Generator\RedirectFromGenerator;
use Yosymfony\Spress\Core\DataSource\Item;
use Yosymfony\Spress\Core\DataSource\Memory\MemoryDataSource;
use Yosymfony\Spress\Core\Plugin\Event\EnvironmentEvent;
use Yosymfony\Spress\Core\Plugin\EventSubscriber;
use Yosymfony\Spress\Core\Plugin\PluginInterface;

class RedirectorPlugin implements PluginInterface
{
    private $io;

    private $redirectTemplate = <<<'EOHTML'
{% set redirect_to_item = page.relationships[constant('Ajgl\\Spress\\Plugin\\Redirector\\Generator\\RedirectFromGenerator::RELATION')]|first %}
{% set redirect_to_location = site.url ~ redirect_to_item.url %}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="0; url={{redirect_to_location}}">
        <title>Content moved to {{redirect_to_location}}</title>
        <link rel="canonical" href="{{redirect_to_location}}">
    </head>
    <body onload="window.location.replace('{{redirect_to_location|escape('js')}}')">
        <h1>Content moved</h1>
        <p>
            Content moved to <a href="{{redirect_to_location}}">{{redirect_to_location}}</a>.
        </p>
        <p>
            Please, update your bookmarks.
        </p>
    </body>
</html>
EOHTML;

    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.start', 'onStart');
    }

    public function getMetas()
    {
        return [
            'name' => 'ajgl/redirector-spress-plugin',
            'description' => 'Seamlessly specify multiple redirections URLs for your pages and posts',
            'author' => 'Antonio J. García Lagar',
            'license' => 'MIT',
        ];
    }

    public function onStart(EnvironmentEvent $event)
    {
        $this->io = $event->getIO();
        $event->getGeneratorManager()->addGenerator('redirect-from', $this->buildRedirectFromGenerator());
        $event->getDataSourceManager()->addDataSource('redirector', $this->buildRedirectorDataSource());
    }

    /**
     * @return RedirectFromGenerator
     */
    private function buildRedirectFromGenerator()
    {
        return new RedirectFromGenerator();
    }

    /**
     * @return MemoryDataSource
     */
    private function buildRedirectorDataSource()
    {
        $dataSource = new MemoryDataSource();
        $dataSource->addItem(
            new Item($this->redirectTemplate, 'redirect-from-template', ['generator' => 'redirect-from'])
        );

        return $dataSource;
    }
}
