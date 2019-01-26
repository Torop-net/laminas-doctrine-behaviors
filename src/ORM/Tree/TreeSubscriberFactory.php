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

namespace Mez\DoctrineBehaviors\ORM\Tree;

use Interop\Container\ContainerInterface;
use Knp\DoctrineBehaviors\ORM\Tree\Tree;
use Knp\DoctrineBehaviors\ORM\Tree\TreeSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

/**
 * Class TreeSubscriberFactory
 *
 * @package Mez\DoctrineBehaviors\ORM\Tree
 */
final class TreeSubscriberFactory
{
    /**
     * __invoke
     *
     * @param \Interop\Container\ContainerInterface $container
     *
     * @return \Knp\DoctrineBehaviors\ORM\Tree\TreeSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var ClassAnalyzer $classAnalyzer */
        $classAnalyzer = $container->get(ClassAnalyzer::class);

        /** @var bool $isRecursive */
        $isRecursive = $container->get('config')['doctrine-behaviors']['reflection']['is_recursive'];

        return new TreeSubscriber($classAnalyzer, $isRecursive, Tree::class);
    }
}
