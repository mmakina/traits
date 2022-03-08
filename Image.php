<?php


namespace App\Traits;


trait Image
{
    protected static $base_path = "";


    /**
     *  SaveImage
     */

    public static function saveImage($imageObject, string $imageDirectory = ""): string
    {
        self::createImagePath();

        // Create Image Name
        $image_name = date("Y-m-d") . time() . $imageObject->getClientOriginalName();

        // Create Image Path
        if ($imageDirectory !== "") {
            $image_path = "/images" . "/" . $imageDirectory . "/" . $image_name;
        } else {
            $image_path = "/images" . "/" . $image_name;
        }
        // Move Image to folder
        $imageObject->move(self::$base_path . $imageDirectory, $image_name);

        // Return Image Path for database use
        return $image_path;
    }

    public static function createImagePath()
    {
        if (env("APP_ENV") == "local") {
            self::$base_path = public_path("images/");
        } else {
            // TODO Change the path to reflect the production environment if using shared hosting 
            self::$base_path = base_path() . "/../public_html/images/";
            // self::$base_path = base_path() . "/../test.michaelmakina.me/images/";
        }
    }

    public static function deleteImage($file_name)
    {
        self::createImagePath();
        $path = str_replace("images/", "", self::$base_path);
        unlink($path . $file_name);
        return true;
    }
}
