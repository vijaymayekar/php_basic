<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DICLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader as RouteLoader;

$sc = new DependencyInjection\ContainerBuilder();

$sc->setParameter('charset', 'UTF-8');

$locator = new FileLocator(__DIR__);
$loader = new RouteLoader($locator);
$routes = $loader->load('routes.yml');
$sc->setParameter('routes', $routes);

$loader = new DICLoader($sc, $locator);
$loader->load('services.yml');

return $sc;