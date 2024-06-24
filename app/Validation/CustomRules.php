<?php

namespace App\Validation;

class CustomRules
{
    public function cpfCnpj(?string $str, ?string $fields = null, array $data = []): bool
    {
        try {
            return validaCpfCnpj($str);
        } catch (Exception $e) {
            log_message('error', 'Erro na validação customizada CPF/CNPJ: ' . $e->getMessage());
            return false;
        }
    }
}
