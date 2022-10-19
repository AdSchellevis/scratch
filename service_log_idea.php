<?php

/**
 * service logger to be included in util.inc
 * @param $message string message to log
 * @param $verbose boolean verbose|bool (send to console),
 * @return void
 */
function service_log(string $message, bool $verbose=false): void
{
    if ($verbose) {
        echo $message;
        flush();
    }

    if (false) {
        /* if (!product::getInstance()->booting()) { */
        /* do not write boot log after boot */
        return;
    }

    $bt = debug_backtrace();
    $caller = '-';
    if (count($bt) > 1 && isset($bt[1]['function'])) {
        $caller = $bt[1]['function'];
    }
    $message = (new DateTime())->format('c') . " " . $caller . " " . $message . "\n";

    file_put_contents('/var/log/boot.log', $message, FILE_APPEND | LOCK_EX);
}

/**
 * sample service function
 * @return void
 */
function my_service_startup()
{
    service_log("started", true);
    usleep(100);
    service_log(".", true);
    usleep(100);
    service_log(".", true);
    usleep(100);
    service_log("boot log message only");
    usleep(500);
    service_log("done", true);
}

/**
 * main, sample startup
 */
my_service_startup();

/**
 * console output:
 * started..done
 * sample output in /var/log/boot.log:
 * 2022-10-19T09:22:26+00:00 my_service_startup started
 * 2022-10-19T09:22:26+00:00 my_service_startup .
 * 2022-10-19T09:22:26+00:00 my_service_startup .
 * 2022-10-19T09:22:26+00:00 my_service_startup boot log message only
 * 2022-10-19T09:22:26+00:00 my_service_startup done
 */


