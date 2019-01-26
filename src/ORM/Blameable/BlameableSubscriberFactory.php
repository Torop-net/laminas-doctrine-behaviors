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

namespace Mez\DoctrineBehaviors\ORM\Blameable;

use Interop\Container\ContainerInterface;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

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
     * @param \Interop\Container\ContainerInterface $container
     *
     * @return \Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber|object
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var array $config */
        $config = $container->get('config')['doctrine-behaviors'];

        /** @var ClassAnalyzer $classAnalyzer */
        $classAnalyzer = $container->get(ClassAnalyzer::class);

        /** @var bool $isRecursive */
        $isRecursive = $config['reflection']['is_recursive'];

        /** @var callable|null $userCallable */
        $userCallable = null;

        if (!empty($config['blameable_subscriber']['user_callable']) &&
            $container->has($config['blameable_subscriber']['user_callable'])) {
            $userCallable = $container->get($config['blameable_subscriber']['user_callable']);
        }

        /** @var string|null $userClass */
        $userClass = null;

        if (!empty($config['blameable_subscriber']['user_class']) &&
            \class_exists($config['blameable_subscriber']['user_class'])) {
            $userClass = $config['blameable_subscriber']['user_class'];
        }

        return new BlameableSubscriber($classAnalyzer, $isRecursive, Blameable::class, $userCallable, $userClass);
    }
}
