<?php

namespace App\Rules\V1;

use App\Enums\ReceivableType;
use App\Models\Barangay;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReceivable implements ValidationRule
{
    public function __construct(
        public ?string $receiverType
    ){}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->receiverType) {
            $exists = $this->receiverType === ReceivableType::User->value
                ?  User::where('id', $value)->exists()
                :  Barangay::where('id', $value)->exists();

            if (! $exists) $fail("The selected receiver is invalid.");
        }
    }
}
