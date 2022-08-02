<?php
namespace RealEstate\Api\Support;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\RuleInterface;
use Restate\Libraries\Validation\Rules\BooleanCast;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Each;
use Restate\Libraries\Validation\Rules\FloatCast;
use Restate\Libraries\Validation\Rules\Moment;
use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\StringCast;
use Restate\Libraries\Validation\Rules\Walk;
use Illuminate\Http\Request;
use RealEstate\Api\Support\Validation\Rules\DocumentMixedIdentifier;
use RealEstate\Core\Back\Entities\Admin;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class BaseProcessor extends AbstractProcessor
{
    /**
     * @param Binder $binder
     */
    protected function rules(Binder $binder)
    {
        foreach ($this->configuration() as $name => $rule) {

            $binder->bind($name, $this->createRootInflator($rule));
        }
    }

	/**
	 * @param string|array $rule
	 * @return callable
	 */
	private function createRootInflator($rule)
	{
		return function (Property $property) use($rule) {

			if (is_string($rule) && ends_with($rule, '[]')){
				$rule = [cut_string_right($rule, '[]')];
			}

			if (is_array($rule) && count($rule) === 1 && array_key_exists(0, $rule)){
				$property->addRule(new Each(function() use ($rule){
					return $this->resolveRule(current($rule));
				}));
			} else {
				$property->addRule($this->resolveRule($rule));
			}
		};
	}

    /**
     *
     * @param mixed $rule
     * @return RuleInterface
     */
    private function resolveRule($rule)
    {
        if (is_string($rule)) {
            $rule = $this->mapRules()[$rule];
        }

        if (is_callable($rule)) {
            return call_user_func($rule);
        }

        if (is_object($rule)) {
            return $rule;
        }

        if (is_string($rule)) {
            return new $rule();
        }

        if (is_array($rule)) {
            return new Walk(function (Binder $binder) use($rule) {
                foreach ($rule as $key => $value) {
                    $binder->bind($key, $this->createRootInflator($value));
                }
            });
        }

        throw new RuntimeException('Unable to resolve a validation rule.');
    }

    /**
     *
     * @return array
     */
    protected function mapRules()
    {
        return [
            'string' => StringCast::class,
            'bool' => BooleanCast::class,
            'int' => IntegerCast::class,
            'float' => FloatCast::class,
            'datetime' => Moment::class,
            'document' => DocumentMixedIdentifier::class,
            'array' => (new Callback(function($v){
                return is_array($v);
            }))
                ->setIdentifier('cast')
                ->setMessage('The field should be an array.')
		];
    }

    /**
     *
     * @return array
     */
    protected function configuration()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    protected function allowable()
    {
        return array_keys($this->configuration());
    }

	/**
	 * @return bool
	 */
	protected function isPatch()
	{
		return strtolower($this->getRequest()->method()) == strtolower(Request::METHOD_PATCH);
	}

    /**
     * @return bool
     */
    protected function isAdmin()
    {
        /**
         * @var Session $session
         */
        $session = $this->container->make(Session::class);

        return $session->getUser() instanceof Admin;
    }

    /**
     *
     * @param UpdateOptions $options
     * @return UpdateOptions
     */
    public function schedulePropertiesToClear(UpdateOptions $options = null)
    {
        if ($options === null) {
            $options = new UpdateOptions();
        }

        $options->schedulePropertiesToClear($this->getFieldsWithNulls());

        return $options;
    }
}