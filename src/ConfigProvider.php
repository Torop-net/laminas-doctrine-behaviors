<?php
/**
 * Copyright 2019 Martin Meredith <martin@sourceguru.net>
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

namespace Mez\DoctrineBehaviors;

use Doctrine\DBAL\Types\Type;
use Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber;
use Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriber;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber;
use Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableSubscriber;
use Knp\DoctrineBehaviors\ORM\Sortable\SortableSubscriber;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Knp\DoctrineBehaviors\ORM\Tree\TreeSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;
use Mez\DoctrineBehaviors\ORM\Blameable\BlameableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Loggable\LoggableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Sortable\SortableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Translatable\DefaultLocaleCallable;
use Mez\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriberFactory;
use Mez\DoctrineBehaviors\ORM\Tree\TreeSubscriberFactory;

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
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine-behaviors' => [
                'blameable_subscriber' => [],
                'geocodable_callable' => null,
                'loggable_subscriber' => [],
                'reflection' => [
                    'is_recursive' => true,
                ],
                'timestampable_subscriber' => [
                    'db_field_type' => Type::DATETIME,
                ],
                'translatable_subscriber' => [
                    'default_locale_callable' => DefaultLocaleCallable::class,
                    'translatable_fetch_method' => 'LAZY',
                    'translation_fetch_method' => 'LAZY',
                ],
            ],
        ];
    }

    /**
     * getDependencies
     *
     * @return array
     */
    private function getDependencies(): array
    {
        return [
            'invokables' => [
                ClassAnalyzer::class => ClassAnalyzer::class,
                DefaultLocaleCallable::class => DefaultLocaleCallable::class,
            ],
            'factories' => [
                BlameableSubscriber::class => BlameableSubscriberFactory::class,
                GeocodableSubscriber::class => GeocodableSubscriberFactory::class,
                LoggableSubscriber::class => LoggableSubscriberFactory::class,
                SluggableSubscriber::class => SluggableSubscriberFactory::class,
                SoftDeletableSubscriber::class => SoftDeletableSubscriberFactory::class,
                SortableSubscriber::class => SortableSubscriberFactory::class,
                TimestampableSubscriber::class => TimestampableSubscriberFactory::class,
                TranslatableSubscriber::class => TranslatableSubscriberFactory::class,
                TreeSubscriber::class => TreeSubscriberFactory::class,
            ],
            'shared' => [
                BlameableSubscriber::class => false,
                ClassAnalyzer::class => false,
                DefaultLocaleCallable::class => false,
                GeocodableSubscriber::class => false,
                LoggableSubscriber::class => false,
                SluggableSubscriber::class => false,
                SoftDeletableSubscriber::class => false,
                SortableSubscriber::class => false,
                TimestampableSubscriber::class => false,
                TranslatableSubscriber::class => false,
                TreeSubscriber::class => false,
            ],
        ];
    }
}