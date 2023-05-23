<?php
function tryMem($mbyte) {
    $bytes = 1048576; // bytes in a megabyte
    $dummy = str_repeat("0", $bytes * $mbyte); // allocate memory
    echo("Successfully allocated {$mbyte} MBs\n");
    echo("Current Memory Use: " . memory_get_usage(true) / $bytes . " MBs\n");
    echo("Peak Memory Use: " . memory_get_peak_usage(true) / $bytes . " MBs\n");
}

$start_time = microtime(true);

for ($i = 10; $i < 6000; $i += 50) {
    $limit = $i . 'M';
    ini_set('memory_limit', $limit);
    echo("Memory limit set to: " . ini_get('memory_limit') . "\n");

    $max_execution_time = ini_get('max_execution_time');
    $current_execution_time = microtime(true) - $start_time;
    
    echo("Max Execution Time: " . $max_execution_time . " seconds\n");
    echo("Current Execution Time: " . $current_execution_time . " seconds\n");

    if ($current_execution_time >= $max_execution_time) {
        echo("Reached max execution time limit. Stopping script.\n");
        break;
    }

    try {
        tryMem($i-10); // try to allocate $i-10 MBs
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        // if allocation failed, break out of the loop
        break;
    }
}

?>
