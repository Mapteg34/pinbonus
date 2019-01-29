<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class Login implements Rule
{
    /** @var array */
    private $message;

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validator = Validator::make([
            $attribute => $value,
        ], [
            $attribute => 'string|min:4|max:12',
        ]);
        $result    = $validator->passes();

        $this->message = $validator->messages()->get($attribute);

        return $result;
    }

    /**
     * @return array
     */
    public function message()
    {
        return $this->message;
    }
}
