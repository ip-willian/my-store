<?php

namespace App\Service;

class UploaderService {


    public function handleUpload($file): ?string
    {
        if (!is_null($file)) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = md5(time());
            $newFilename = $safeFilename . $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
            return $newFilename;
        }
        return null;
    }

}