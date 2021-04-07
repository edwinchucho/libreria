<?php


namespace App\Services;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper extends AbstractController
{
    private string $uploadsPath;
    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadProductImage(UploadedFile $file): string
    {
        $destination = $this->uploadsPath.'/images';
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$file->guessExtension();
        $file->move(
            $destination,
            $newFilename
        );
        return $newFilename;
    }
}