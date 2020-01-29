<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
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

    public function uploadMultiple(User $user = null, array $options = [])
    {
        foreach($options as $key => $file) {
            if($file !== null) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                $directory = $this->getDirectory($key);
                try {
                    $file->move($directory, $fileName);
                    $this->setUserFile($user, $key, $fileName);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
        }

        return $user;
    }

    private function setUserFile($user, $type, $fileName)
    {
        $filesystem = new Filesystem();

        switch ($type) {
            case 'cv':

                if($user->getCv() !== null) {
                    $filesystem->remove($this->getDirectory($type) . '/' . $user->getCv());
                }
                $user->setCv($fileName);
                break;

            case 'motivation':
                if($user->getMotivation() !== null) {
                    $filesystem->remove($this->getDirectory($type) . '/' . $user->getMotivation());
                }
                $user->setMotivation($fileName);
                break;

            default:
                throw new \Exception('invalid key');
                break;
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

    public function showFile($path)
    {
        if(file_exists($path)) {
            return new BinaryFileResponse($path);
        }

        throw new \Exception('file does not exist');
    }
}
