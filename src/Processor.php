<?php

namespace AlexS\BotMan\Annotations;

use BotMan\BotMan\BotMan;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionMethod;
use ReflectionObject;

/**
 * @api
 */
class Processor
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    private $objects = [];

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param object $object
     *
     * @return $this
     */
    public function add($object): self
    {
        $this->objects[] = $object;

        return $this;
    }

    public function applyTo(BotMan $bot)
    {
        foreach ($this->objects as $object) {
            $class = new ReflectionObject($object);
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC & ~ReflectionMethod::IS_STATIC);

            foreach ($methods as $method) {
                $annotations = $this->annotationReader->getMethodAnnotations($method);
                foreach ($annotations as $annotation) {
                    if ($annotation instanceof Hears) {
                        $this->applyHears($bot, $annotation, function (...$args) use ($object, $method) {
                            return $method->invokeArgs($object, $args);
                        });
                    }
                }
            }
        }
    }

    private function applyHears(BotMan $bot, Hears $hears, callable $closure)
    {
        $bot->hears($hears->value, $closure, $hears->in);
    }
}
