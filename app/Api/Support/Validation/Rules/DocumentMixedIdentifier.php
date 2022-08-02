<?php
namespace RealEstate\Api\Support\Validation\Rules;

use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\Mixed;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentMixedIdentifier extends Mixed
{

    public function __construct()
    {
        parent::__construct([
            new IntegerCast(),
            new DocumentHashIdentifier()
        ]);

        $this->setIdentifier('cast');
        $this->setMessage('The document identifier must be int or hash consisting of id and token.');
    }
}