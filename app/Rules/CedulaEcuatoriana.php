<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class CedulaEcuatoriana implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Validar la cédula ecuatoriana
        return $this->validarCedulaEcuatoriana($value);
    }
    public function message()
    {
        return 'La cédula ecuatoriana proporcionada no es válida.';
    }

    // Función para validar la cédula ecuatoriana
    private function validarCedulaEcuatoriana($cedula)
    {
        // Verificar que la cédula tenga 10 dígitos
        if (strlen($cedula) != 10) {
            return false;
        }

        // Verificar que todos los caracteres sean dígitos
        if (!ctype_digit($cedula)) {
            return false;
        }

        // Validar el dígito verificador
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $resultado = $cedula[$i] * $coeficientes[$i];
            $suma += ($resultado > 9) ? $resultado - 9 : $resultado;
        }
        $verificador = 10 - ($suma % 10);
        if ($verificador == 10) {
            $verificador = 0;
        }

        return $cedula[9] == $verificador;
    }
}
