<?php

// implementar opção para salvar a saída.
// Scan em range de portas e por ai vai

$open = array();
$closed = array();

function scan($ip, $port)
{
    if ($fp = @fsockopen($ip, $port, $err, $err_string, 1)) {
        echo "$port OPEN\n";

        array_push($open, $port);

        fclose($fp);
    } else {
        array_push($closed, $port);
        echo "$port CLOSED\n";
    } 
}


if ($argc < 2) {
    echo "[!!!] Insira o IP e as portas.";
    die();
}

$ip = $argv[1];

if (str_contains($argv[2], '-')) {
    $range = explode('-', $argv[2]);
    $start = (int) $range[0];
    $stop = (int) $range[1];

    // verifica se o stop é zero.
    if (!$stop) {
        echo "[!!!] Somente o inicio pode ser zero.";
        die();
    }

    // veriifica se o final é maior que o começo.
    if ($start > $stop) {
        $temp = $stop;
        $stop = $start;
        $start = $temp;
    }


    for ($i=$start; $i <= $stop; $i++) { 
        scan($ip, $i);
    }

    die();
}

$ports = explode(',', $argv[2]);
foreach ($ports as $port) { 
    scan($ip, $port);
}


j