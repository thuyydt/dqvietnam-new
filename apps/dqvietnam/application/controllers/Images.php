<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Images extends Public_Controller
{
    protected $_data;
    protected $_name_controller;

    public function index($image)
    {
        $file_out = MEDIA_PATH . $image; // The image to return

        if (file_exists($file_out)) {

            $image_info = getimagesize($file_out);

            //Set the content-type header as appropriate
            header('Content-Type: ' . $image_info['mime']);

            //Set the content-length header
            header('Content-Length: ' . filesize($file_out));

            //Write the image bytes to the client
            readfile($file_out);
        }
        else { // Image file not found

            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");

        }
    }
}
