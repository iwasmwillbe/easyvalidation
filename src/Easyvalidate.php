<?php

namespace Ashish\Easyvalidation;

use Validator;

trait Easyvalidate
{

    /**
     * valiadation rule will be stored in.
     *
     * @var array
     */
    protected $validationRules;

    /**
     * parsed values will be stored in.
     *
     * @var array
     */
    protected $values;

    /**
     * excepted rules keys will be stored in.
     *
     * @var array
     */
    protected $excepts;

    /**
     * additional rules add/update will be stored in.
     *
     * @var array
     */
    protected $addition;

    /**
     * Make validation handler will parse value to non-static method.
     *
     * @var array
     */
    public static function makeValidate(array $values = [], array $excepts = [], array $additions = [])
    {
        // parse value to non'static method
        return (new self)->catchValues($values, $excepts, $additions);
    }

    /**
     * Get list of rules from model.
     *
     * @var array
     */
    public function getRules()
    {
        $this->validationRules = collect($this->rules);
    }

    /**
     * remove rules from the list which are excepted.
     *
     * @var array
     */
    public function removeExcepts()
    {
        $this->excepts->map(function ($value) {
            $this->validationRules->forget($value);
        });
    }
    /**
     * if any addition/modification in rules.
     *
     * @var array
     */
    public function addModifyRules()
    {
        $this->validationRules = $this->validationRules->merge($this->addition);
    }
    /**
     * non-static method. to handle further frocess.
     *
     * @var array
     */
    public function catchValues(array $values = [], array $excepts = [], array $additions = [])
    {
        // get values
        $this->values = $values;
        //  get excepted list
        $this->excepts = collect($excepts);
        //  get rule add/update list
        $this->addition = collect($additions);
        //  get main model rules list
        $this->getRules();
        // remove excepted records
        $this->removeExcepts();
        //  add modify/record
        $this->addModifyRules();

        //  validate record and return whole validation response back
        return $this->validateData();
    }
    /**
     * validating request with laravel's builtin Validation class.
     *
     * @var array
     */
    public function validateData()
    {
        return Validator::make($this->values, $this->validationRules->toArray());
    }

}
