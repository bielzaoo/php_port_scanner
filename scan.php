<?php

// implementar opção para salvar a saída.
// Scan em range de portas e por ai vai

$ip = $argv[1];
$ports = $argv[2];
$open = array();
$closed = array();

function scan($ip, $port, &$open, &$closed)
{
    if ($fp = @fsockopen($ip, $port, $err, $err_string, 1)) {
        // echo "$port -> ABERTA\n";
        array_push($open, $port);
        fclose($fp);
    } else {
        // echo "$port -> FECHADA\n";
        array_push($closed, $port);
    } 
}

function printResult(&$open, &$closed){

    if (!empty($open)) {
        echo "[OPEN PORTS]\n";
        foreach ($open as $port) {
            echo "$port -> OPEN\n";
        }
    }

    echo "\n";

    if (!empty($closed)) {
        echo "[CLOSED PORTS]\n";
        foreach ($closed as $port) {
            echo "$port -> CLOSED\n";
        }
    }
}


if ($argc < 2) {
    echo "[!!!] Insira o IP e as portas.";
    die();
}

function portRange($ip, $ports, &$open, &$closed)
{
    if (str_contains($ports, '-')) {
        $range = explode('-', $ports);
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


        for ($port=$start; $port <= $stop; $port++) { 
            scan($ip, $port, $open, $closed);
        }

       return true; 
    } 
    return false; 
}

if (portRange($ip, $ports, $open, $closed)) {
    printResult($open, $closed);
    die();
} else {
    $all_ports = explode(',', $ports);
    foreach ($all_ports as $port) { 
        scan($ip, $port, $open, $closed);
    }
    printResult($open, $closed);
}


