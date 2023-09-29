<?php

// implementar opção para salvar a saída.

function scan($ip, $port)
{
    if ($fp = @fsockopen($ip, $port, $err, $err_string, 1)) {
        echo "$port OPEN\n";
        fclose($fp);
    } else {
        echo "$port CLOSED\n";
    }   
}

if ($argc < 3) {
    echo "[!!!] Insira o IP e as portas.";
} else {
    $ip = $argv[1];
    $ports = explode(',', $argv[2]);

    foreach ($ports as $port) {
        scan($ip, $port);
    }
}