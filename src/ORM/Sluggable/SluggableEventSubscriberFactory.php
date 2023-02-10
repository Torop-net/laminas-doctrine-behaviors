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

namespace Majimez\DoctrineBehaviors\ORM\Sluggable;

use Doctrine\ORM\EntityManager;
use Knp\DoctrineBehaviors\EventSubscriber\SluggableEventSubscriber;
use Knp\DoctrineBehaviors\Repository\DefaultSluggableRepository;
use Psr\Container\ContainerInterface;

/**
 * Class SluggableEventSubscriberFactory
 *
 * @package Mez\DoctrineBehaviors\ORM\Sluggable
 */
final class SluggableEventSubscriberFactory
{
    /**
     * __invoke
     *
     * @param \Psr\Container\ContainerInterface $container
     *
     * @return \Knp\DoctrineBehaviors\EventSubscriber\SluggableEventSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        $entity_manager = $container->get(EntityManager::class);

        $default_sluggable_repo = $container->get(
            DefaultSluggableRepository::class
        );

        return new SluggableEventSubscriber(
            $entity_manager,
            $default_sluggable_repo
        );
    }
}
