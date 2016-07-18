<?php

namespace App\Validators;

class InArrayValidator
{
    /**
     * Haystack of possible values.
     *
     * @var array
     */
    protected $haystack;

    /**
     * Constructor.
     *
     * To prevent "asdf" being converted to 0
     * and returning a false positive if 0 is in haystack, we type cast
     * the haystack to strings. To prevent "56asdf" == 56 === TRUE we also
     * type cast values like 56 to strings as well.
     *
     * This occurs only if the input is a string and a haystack member is an int
     *
     * @param array $haystack
     */
    public function __construct(array $haystack)
    {
        foreach ($haystack as &$h) {
            if (is_int($h) || is_float($h)) {
                $h = (string) $h;
            }
        }
        $this->haystack = $haystack;
    }

    /**
     * @param string $attribute Name of the $attribute being validated
     * @param mixed $value
     * @return bool
     */
    public function validate($attribute, $value)
    {
        if ((is_int($value) || is_float($value))) {
            $value = (string) $value;
        }

        return in_array($value, $this->haystack);
    }
}
