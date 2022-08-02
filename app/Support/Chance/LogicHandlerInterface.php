<?php
namespace RealEstate\Support\Chance;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface LogicHandlerInterface
{
    /**
     * @param Attempt $attempt
     * @return bool
     */
    public function handle(Attempt $attempt);

    /**
     * @param Attempt $attempt
     */
    public function outOfAttempts(Attempt $attempt);
}