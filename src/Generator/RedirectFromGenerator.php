<?php

/*
 * AJGL Redirector Spress Plugin
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Spress\Plugin\Redirector\Generator;

use Yosymfony\Spress\Core\ContentManager\Generator\GeneratorInterface;
use Yosymfony\Spress\Core\DataSource\Item;
use Yosymfony\Spress\Core\DataSource\ItemInterface;
use Yosymfony\Spress\Core\Support\ArrayWrapper;

class RedirectFromGenerator implements GeneratorInterface
{
    const ATTRIBUTE = 'redirect_from';
    const RELATION = 'canonical';

    public function generateItems(ItemInterface $templateItem, array $collections)
    {
        $destinations = [];
        $generatedItems = [];

        $items = (new ArrayWrapper($collections))->flatten();
        foreach ($items as $item) {
            $attributes = $item->getAttributes();
            if (!isset($attributes[self::ATTRIBUTE])) {
                continue;
            }

            $destination = ['item' => $item, 'sources' => []];

            $sources = (array) $attributes[self::ATTRIBUTE];
            foreach ($sources as $source) {
                $sourcePath = parse_url($source, PHP_URL_PATH);
                if ($sourcePath !== false && strlen($sourcePath)) {
                    $realSourcePath = substr($sourcePath, -1) !== '/' ? $sourcePath : $sourcePath.'index.html';
                    $destination['sources'][] = $realSourcePath;
                }
            }

            $destinations[] = $destination;
        }

        foreach ($destinations as $destination) {
            foreach ($destination['sources'] as $source) {
                $item = new Item($templateItem->getContent(), $source);
                $item->getRelationshipCollection()->add(self::RELATION, $destination['item']);
                $item->setPath($source, Item::SNAPSHOT_PATH_RELATIVE);
                $generatedItems[] = $item;
            }
        }

        return $generatedItems;
    }
}
