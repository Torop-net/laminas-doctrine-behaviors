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
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Knp\DoctrineBehaviors\EventSubscriber\BlameableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\LoggableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\SluggableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\SoftDeletableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TimestampableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TranslatableSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\TreeSubscriber;
use Knp\DoctrineBehaviors\EventSubscriber\UuidableSubscriber;
use Knp\DoctrineBehaviors\Repository\DefaultSluggableRepository;
use Majimez\DoctrineBehaviors\ORM\Blameable\BlameableSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Loggable\LoggableSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Sluggable\DefaultSluggableRepositoryFactory;
use Majimez\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriberFactory;
use Majimez\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriberFactory;

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
            'dependencies' => $this->getDependencies(),
            'doctrine-behaviors' => [
                'blameable' => [
                    'user_provider' => null,
                    'user_entity' => null,
                ],
                'timestampable' => [
                    'date_field_type' => Types::DATE_IMMUTABLE,
                ],
                'translatable' => [
                    'locale_provider' => null,
                    'translatable_fetch_method' => ClassMetadataInfo::FETCH_LAZY,
                    'translation_fetch_method' => ClassMetadataInfo::FETCH_LAZY,
                ],
            ],
        ];
    }

    /**
     * getDependencies
     *
     * @return array<string, array<class-string|int, class-string|false>>
     */
    private function getDependencies(): array
    {
        return [
            'invokables' => [
                SoftDeletableSubscriber::class => SoftDeletableSubscriber::class,
                TreeSubscriber::class => TreeSubscriber::class,
                UuidableSubscriber::class => UuidableSubscriber::class,
            ],
            'factories' => [
                BlameableSubscriber::class => BlameableSubscriberFactory::class,
                DefaultSluggableRepository::class => DefaultSluggableRepositoryFactory::class,
                LoggableSubscriber::class => LoggableSubscriberFactory::class,
                SluggableSubscriber::class => SluggableSubscriberFactory::class,
                TimestampableSubscriber::class => TimestampableSubscriberFactory::class,
                TranslatableSubscriber::class => TranslatableSubscriberFactory::class,
            ],
            'shared' => [
                BlameableSubscriber::class => false,
                LoggableSubscriber::class => false,
                SluggableSubscriber::class => false,
                SoftDeletableSubscriber::class => false,
                TimestampableSubscriber::class => false,
                TranslatableSubscriber::class => false,
                TreeSubscriber::class => false,
                UuidableSubscriber::class,
            ],
        ];
    }
}
