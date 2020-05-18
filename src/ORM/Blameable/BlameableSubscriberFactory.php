<?php
/**
 * Copyright (c) 2019 Martin Meredith <martin@sourceguru.net>
 * Coypright (c) 2020 Majimez Limited <contact@majimez.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace Majimez\DoctrineBehaviors\ORM\Blameable;

use Doctrine\ORM\EntityManager;
use Knp\DoctrineBehaviors\EventSubscriber\BlameableSubscriber;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class BlameableSubscriberFactory
 *
 * @package Mez\DoctrineBehaviors\ORM\Blameable
 */
final class BlameableSubscriberFactory
{
    /**
     * __invoke
     *
     * @param \Psr\Container\ContainerInterface $container
     *
     * @return \Knp\DoctrineBehaviors\EventSubscriber\BlameableSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var array<string, array<string, string>> $module_config */
        $module_config = $container->get('config')['doctrine-behaviors'];

        if (!isset($module_config['blameable'])) {
            throw new RuntimeException('No configuration provided');
        }

        $config = $module_config['blameable'];

        if (!isset($config['user_provider'])) {
            throw new RuntimeException('You must provider a User Provider');
        }

        /**
         * @var \Knp\DoctrineBehaviors\Contract\Provider\UserProviderInterface $user_provider
         */
        $user_provider = $container->get($config['user_provider']);

        $entity_manager = $container->get(EntityManager::class);

        $user_class = null;

        $user_entity =
            $config['user_entity'] ?? $user_provider->provideUserEntity();

        return new BlameableSubscriber(
            $user_provider,
            $entity_manager,
            $user_entity
        );
    }
}
