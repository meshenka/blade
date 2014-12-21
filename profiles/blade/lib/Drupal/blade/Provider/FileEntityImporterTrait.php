<?php

namespace Drupal\blade\Provider;

trait FileEntityImporterTrait
{
    protected function importFile($uri, $dest = 'public://remote')
    {
        //TODO make this more robust
        //some times fb image links got parameters that make pathinfo fails
        $image = drupal_http_request($uri);

        // $info = new \SplFileInfo($uri);
        // print_r($info->getExtension());
        $parsedUri = pathinfo($uri);
        $filename = uniqid('remote').'.'.$parsedUri['extension'];
        // echo "\n\n$filename\n\n";
        // print_r(image_type_to_extension($image->headers['content-type']));
        if ($image->code == 200 && file_prepare_directory($dest, FILE_CREATE_DIRECTORY)) {
            $dest = $dest.'/'.$filename;
            // $file = file_save_data($image->data, $dest);

            // return $file;
        }

        return false;
    }
}
