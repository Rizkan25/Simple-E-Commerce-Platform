<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidBankAccountLength implements ValidationRule
{
    protected ?string $bankName;

    public function __construct(?string $bankName = null)
    {
        $this->bankName = $bankName;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if value is only digits
        if (!preg_match('/^[0-9]+$/', $value)) {
            $fail('Nomor rekening hanya boleh berisi angka tanpa spasi atau karakter lain.');
            return;
        }

        $bankName = $this->bankName ?? request()->input('bank_name');
        
        $lengths = [
            'BCA' => [10],
            'BNI' => [10],
            'BSI' => [10],
            'Bank Danamon' => [10],
            'Bank Neo Commerce' => [12],
            'Bank Jago' => [12],
            'SeaBank' => [12],
            'Bank Mandiri' => [13],
            'BRI' => [15],
            'Permata Bank' => [10, 11],
            'CIMB Niaga' => [11, 12, 13],
            'BTN' => [10, 16],
        ];

        if ($bankName && array_key_exists($bankName, $lengths)) {
            $validLengths = $lengths[$bankName];
            $currentLength = strlen($value);

            if (!in_array($currentLength, $validLengths)) {
                if (count($validLengths) === 1) {
                    $fail("Nomor rekening untuk {$bankName} harus terdiri dari tepat {$validLengths[0]} digit angka.");
                } else {
                    $last = array_pop($validLengths);
                    $allowedStr = implode(', ', $validLengths) . ' atau ' . $last;
                    $fail("Nomor rekening untuk {$bankName} harus terdiri dari {$allowedStr} digit angka.");
                }
            }
        }
    }
}
