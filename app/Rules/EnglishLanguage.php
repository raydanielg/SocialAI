<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnglishLanguage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match("/^[A-Za-z0-9 !@#$%^&*()_+\-=\[\]{};:'\"\\|,.<>\/?~:;]*$/", $value)) {
            $fail('The ' . $attribute . ' field may only contain English letters and certain symbols.');
        }
    }
}
