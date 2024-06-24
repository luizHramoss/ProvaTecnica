<?php

function validaCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os digitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validaCNPJ($cnpj) {
    // Remove caracteres não numéricos
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica se todos os digitos são iguais
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    // Faz o calculo para validar o CNPJ
    for ($t = 12; $t < 14; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cnpj[$c] * (($t - 7 - $c) % 8 + 2);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cnpj[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validaCpfCnpj($value) {
    // Verifica se é CPF ou CNPJ
    if (strlen($value) === 11) {
        return validaCPF($value);
    } elseif (strlen($value) === 14) {
        return validaCNPJ($value);
    }
    return false;
}
