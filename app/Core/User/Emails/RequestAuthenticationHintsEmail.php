<?php
namespace RealEstate\Core\User\Emails;
use RealEstate\Core\Support\Letter\Email;
use RealEstate\Core\User\Entities\Token;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RequestAuthenticationHintsEmail extends Email
{
    /**
     * @var Token[]
     */
    private $tokens;

    /**
     * @param Token[] $tokens
     */
    public function __construct($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return Token[]
     */
    public function getTokens()
    {
        return $this->tokens;
    }
}