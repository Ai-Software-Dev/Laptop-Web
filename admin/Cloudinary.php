<?php 
    require '../vendor/autoload.php';

    use Cloudinary\Cloudinary;

    $cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dypftrmtl', 
        'api_key'    => '425717823811326',   
        'api_secret' => '4Qmdz9LWEj7S0yFYWgpr9z4J770', 
    ],
    ]);
    ?>