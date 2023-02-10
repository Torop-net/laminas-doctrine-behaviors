<?php

declare(strict_types=1);

namespace Majimez\DoctrineBehaviors;

class Module
{
    public function getConfig(): array
    {
        $config = new ConfigProvider();

        return [
            'service_manager' => $config->getDependencyConfig(),
            'doctrine-behaviors' => $config->getDoctrineBehaviorsConfig(),
        ];
    }
}
