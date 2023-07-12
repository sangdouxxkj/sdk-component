<?php

namespace Sangdou\Component\core\provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Sangdou\Component\component\TicketService;

class TicketProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['tickets'] = function () {
            return new TicketService();
        };
    }
}