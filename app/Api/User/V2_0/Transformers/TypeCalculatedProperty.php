<?php
namespace RealEstate\Api\User\V2_0\Transformers;
use RealEstate\Api\Support\TransformerModifiers;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class TypeCalculatedProperty
{
    /**
     * @var TransformerModifiers
     */
    private $modifier;

    /**
     * @param TransformerModifiers $modifier
     */
    public function __construct(TransformerModifiers $modifier)
    {
        $this->modifier = $modifier;
    }

    /**
     * @param User $user
     * @return string
     */
    public function __invoke(User $user)
    {
        return $this->modifier->stringable($user);
    }
}