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

namespace Mez\DoctrineBehaviors\ORM\Translatable;

use Interop\Container\ContainerInterface;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

/**
 * Class TranslatableSubscriberFactory
 *
 * @package Mez\DoctrineBehaviors\ORM\Translatable
 */
final class TranslatableSubscriberFactory
{
    /**
     * __invoke
     *
     * @param \Interop\Container\ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return \Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber|object
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['doctrine-behaviors']['translatable_subscriber'];

        /** @var ClassAnalyzer $classAnalyzer */
        $classAnalyzer = $container->get(ClassAnalyzer::class);

        /** @var callable|null $currentLocaleCallable */
        $currentLocaleCallable = null;

        if (!empty($config['current_locale_callable']) && $container->has($config['current_locale_callable'])) {
            $currentLocaleCallable = $container->get($config['current_locale_callable']);
        }

        /** @var callable|null $defaultLocaleCallable */
        $defaultLocaleCallable = null;

        if (!empty($config['default_locale_callable']) && $container->has($config['default_locale_callable'])) {
            $defaultLocaleCallable = $container->get($config['default_locale_callable']);
        }

        return new TranslatableSubscriber(
            $classAnalyzer,
            $currentLocaleCallable,
            $defaultLocaleCallable,
            Translatable::class,
            Translation::class,
            $config['translatable_fetch_method'],
            $config['translation_fetch_method']
        );
    }
}