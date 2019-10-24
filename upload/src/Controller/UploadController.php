<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/doUpload", name="upload")
     */
     public function index(Request $request, string $uploadDir, 
             FileUploader $uploader, LoggerInterface $logger)
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token)) 
        {
            $logger->info("CSRF failure");

            return new Response("Operação não permitida",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }        

        $file = $request->files->get('file');

        if (empty($file)) 
        {
            return new Response("Nenhum arquivo especificado",  
               Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }        

        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $filename);

        return new Response("Upload realizado!",  Response::HTTP_OK, 
            ['content-type' => 'text/plain']);         
    }
}
