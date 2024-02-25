<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\CedulaEcuatoriana;

class RucEcuatoriano implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $ruc)
    {
        // Validar la cédula ecuatoriana
        return $this->validarRUCEcuatoriana($ruc);
    }

    public function message()
    {
        return 'El RUC proporcionado no es válido.';
    }
    private function validarRUCEcuatoriana($ruc){

        if (strlen($ruc) !== 13) {
            return false;
        }

        if (!ctype_digit($ruc)) {
            return false;
        }

        $digitos = str_split($ruc);
        $total = 0;
        $coeficientes = array();
        if($digitos[2] == "9"):
            $coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
            for ($i = 0; $i < 9; $i++) {
                $total += $digitos[$i] * $coeficientes[$i];
            }
            $remainder = $total % 11;
            $digito_verificador = $remainder === 0 ? 0 : 11 - $remainder;
        elseif($digitos[2] == "6"):
            $coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
            for ($i = 0; $i < 8; $i++) {
                $total += $digitos[$i] * $coeficientes[$i];
            }
            $remainder = $total % 11;
            $digito_verificador = $remainder === 0 ? 0 : 11 - $remainder;
        else:
               // Extrae los primeros 9 dígitos de la cédula
            $cedula = substr($ruc, 0, 9);
            $ultimos_digitos = substr($ruc, 10,13 );

            $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

            for ($i = 0; $i < 9; $i++) {
                $resultado = $cedula[$i] * $coeficientes[$i];
                $total += ($resultado >= 10 ) ? $resultado - 9 : $resultado;
            }

            // $digito_verificador = $total % 10;
            $decena = $total / 10;//divide entre 10, te dará 4.6
            $decena =ceil($decena);//te dará 5
            $decena*=10;//te dará 50

            $digito_verificador = $decena-$total;
            if ($digito_verificador == 10) {
                $digito_verificador = 0;
            }

        endif;

        // Verifica si el último dígito coincide con el dígito verificador
        if($digitos[2] == "9"):
        
            return $digito_verificador === (int)$digitos[9];
        elseif($digitos[2] == "6"):
            return $digito_verificador === (int)$digitos[8];
        else: 
            if($ultimos_digitos == "001" || $ultimos_digitos == "002" || $ultimos_digitos == "003"): 
    
                return $digitos[9] == $digito_verificador;

            endif;
        endif;






        // // Verifica el dígito verificador
        // $digitos = str_split($ruc);
        // $total = 0;
        // $coeficientes = array();
        // if($digitos[2] == "9"):
        //     $coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
        //     for ($i = 0; $i < 9; $i++) {
        //         $total += $digitos[$i] * $coeficientes[$i];
        //     }
        // elseif($digitos[2] == "6"):
        //     $coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
        //     for ($i = 0; $i < 8; $i++) {
        //         $total += $digitos[$i] * $coeficientes[$i];
        //     }
        // endif;
    
        // $remainder = $total % 11;
        // $digito_verificador = $remainder === 0 ? 0 : 11 - $remainder;

        // // Verifica si el último dígito coincide con el dígito verificador
        // if($digitos[2] == "9"):
        //     return $digito_verificador === (int)$digitos[9];
        // elseif($digitos[2] == "6"):
        //     return $digito_verificador === (int)$digitos[8];
        // endif;

        
        //     // Verifica si la longitud es de 13 caracteres
        // if (strlen($ruc) !== 13) {
        //     return false;
        // }
        // // // Verifica si los dos primeros dígitos son 10 o 20 (personas naturales o jurídicas)
        // // $tipo = substr($ruc, 0, 2);
        // // if ($tipo !== '10' && $tipo !== '20') {
        // //     return false;
        // // }

        // // Verifica el dígito verificador
        // $digitos = str_split($ruc);
        // $total = 0;
        // $coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
        // for ($i = 0; $i < 9; $i++) {
        //     $total += $digitos[$i] * $coeficientes[$i];
        // }
        // $remainder = $total % 11;
        // $digito_verificador = $remainder === 0 ? 0 : 11 - $remainder;

        // // Verifica si el último dígito coincide con el dígito verificador
        // return $digito_verificador === (int)$digitos[9];
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
