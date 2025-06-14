<?php

namespace App\Rules;

use Closure;
use Http;
use Illuminate\Contracts\Validation\ValidationRule;


class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            "secret" => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            "response" => $value
        ])->json();

        $score = $response['score'] ?? 0;

        if (!$response['success']) {
            $fail("The google recaptcha is not valid.");
        }

        if ($score < 0.5) {
            $fail("Tu actividad fue considerada sospechosa.");
        }
    }
}
