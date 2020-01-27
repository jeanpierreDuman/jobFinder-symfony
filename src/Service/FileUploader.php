<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\User;

class FileUploader
{
    private $directoryCV = null;

    private $directoryMotivation = null;

    public function __construct($directoryCV, $directoryMotivation)
    {
        $this->directoryCV = $directoryCV;
        $this->directoryMotivation = $directoryMotivation;
    }

    public function uploadMultiple(User $user = null, $options = [])
    {
        dd($user);

        foreach($options as $key => $file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            $directory = $this->getDirectory($key);
            try {
                $file->move($directory, $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }
    }

    private function getDirectory($value)
    {
        switch ($value) {
            case 'cv':
                return $this->directoryCV;
                break;

            case 'motivation':
                return $this->directoryMotivation;
                break;

            default:
                throw new \Exception('invalid key');
                break;
        }
    }

}
