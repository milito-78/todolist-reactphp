<?php 

namespace Infrastructure;

use Common\Initializer\InitAbstract;
use League\Container\DefinitionContainerInterface;

class App extends InitAbstract {

    public function init(DefinitionContainerInterface $container) {
        $container->addServiceProvider(new ServiceProvider());
    }
}