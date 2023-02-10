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

namespace Majimez\DoctrineBehaviors;

use Doctrine\DBAL\Types\Types;
use Knp\DoctrineBehaviors\EventSubscriber\BlameableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\LoggableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\SluggableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\SoftDeletableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TimestampableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TranslatableEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TreeEventSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\UuidableSubscriber;
use Knp\DoctrineBehaviors\Repository\DefaultSluggableRepository;
use Majimez\DoctrineBehaviors\ORM\Blameable\BlameableEventSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Loggable\LoggableEventSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Sluggable\DefaultSluggableRepositoryFactory;
use Majimez\DoctrineBehaviors\ORM\Sluggable\SluggableEventSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Timestampable\TimestampableEventSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Translatable\TranslatableEventSubscriberFactory;

/**
 * Class ConfigProvider
 *
 * @package Mez\DoctrineBehaviors
 */
final class ConfigProvider
{
    /**
     * __invoke
     *
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'doctrine-behaviors' => $this->getDoctrineBehaviorsConfig(),
        ];
    }

    public function getDoctrineBehaviorsConfig(): array
    {
        return [
            'blameable' => [
                'user_provider' => null,
                'user_entity' => null,
            ],
            'timestampable' => [
                'date_field_type' => Types::DATE_IMMUTABLE,
            ],
            'translatable' => [
                'locale_provider' => null,
                'translatable_fetch_mode' => 'LAZY',
                'translation_fetch_mode' => 'LAZY',
            ],
        ];
    }

    /**
     * getDependencies
     *
     * @return
     */
    public function getDependencyConfig(): array
    {
        return [
            'invokables' => [
                SoftDeletableEventSubscriber::class => SoftDeletableEventSubscriber::class,
                TreeEventSubscriber::class => TreeEventSubscriber::class,
                UuidableSubscriber::class => UuidableSubscriber::class,
            ],
            'factories' => [
                BlameableEventSubscriber::class => BlameableEventSubscriberFactory::class,
                DefaultSluggableRepository::class => DefaultSluggableRepositoryFactory::class,
                LoggableEventSubscriber::class => LoggableEventSubscriberFactory::class,
                SluggableEventSubscriber::class => SluggableEventSubscriberFactory::class,
                TimestampableEventSubscriber::class => TimestampableEventSubscriberFactory::class,
                TranslatableEventSubscriber::class => TranslatableEventSubscriberFactory::class,
            ],
            'shared' => [
                BlameableEventSubscriber::class => false,
                LoggableEventSubscriber::class => false,
                SluggableEventSubscriber::class => false,
                SoftDeletableEventSubscriber::class => false,
                TimestampableEventSubscriber::class => false,
                TranslatableEventSubscriber::class => false,
                TreeEventSubscriber::class => false,
                UuidableSubscriber::class => false,
            ],
        ];
    }
}
