<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentWalk extends Walk
{
	public function __construct()
	{
		parent::__construct(function(Binder $binder){

			foreach (['url', 'name', 'format'] as $field){

				$binder->bind($field, function(Property $property) use ($field){
					$property->addRule(new Obligate());
					$property->addRule(new Blank());
				});
			}

			$binder->bind('size', function(Property $property){
				$property
					->addRule(new Obligate())
					->addRule(new Greater(0, false));
			});
		});
	}
}