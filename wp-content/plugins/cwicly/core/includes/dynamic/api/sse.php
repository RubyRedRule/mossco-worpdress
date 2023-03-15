<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class SSE
{
    public $request;

    public function __construct()
    {
    }

    public function start()
    {

        ini_set('zlib.output_compression', 'Off');
        ini_set('output_buffering', 'Off');
        ini_set('output_handler', '');

        // make session read-only
        session_start();
        session_write_close();

        // disable default disconnect checks
        ignore_user_abort(true);

        // set headers for stream
        header('Content-Type: text/event-stream; charset=utf-8');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');
        header_remove('Content-Encoding');
        header('Content-Encoding: none');

        $cwicly_local_active_fonts = get_option('cwicly_local_active_fonts');

        \Cwicly\Helpers::write_log('CWICLY RTD: New Call.');

        if (ob_get_level() == 0) {
            ob_start();
        }

        while (true) {

            // Send data to the client
            $this->sender();

            // Wait for 5 seconds before running the loop again
            sleep(2);
            // Stop broadcasting SSE if the client is not connected
            if (connection_status() !== CONNECTION_NORMAL) {
                Helpers::write_log('CWICLY RTD: Exited.');
                exit;
            }
        }

        // ob_end_flush();

    }

    private function sender()
    {
        $cwicly_local_active_fonts = get_option('cwicly_local_active_fonts');
        $encoded = json_encode($cwicly_local_active_fonts);

        Helpers::write_log('CWICLY RTD: Sent.');

        // header('Content-Type: text/plain');
        // header('Content-Length: 0');
        // header("Content-Encoding: none\r\n");
        // header('Connection: close');
        // echo str_pad("data: $encoded\n\n", 4096);
        // echo str_repeat(" ", 1024 * 64), "\n";
        echo "data: $encoded\n\n";
        // echo str_pad(' ', 4096) . "\n\n";
        // echo "data: $encoded\n\n";

        ob_flush();
        flush();
    }

}
