<?php

// AppBundle/Controller/DefaultController.php
 // use SymfonyComponentHttpFoundationJsonResponse;
 
 // Você define a rota usando anotações
 /**
  * @Route("/fileuploadhandler", name="fileuploadhandler")
  */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;

class DefaultController extends AbstractController
{

 public function fileUploadHandler(Request $request) {
     $output = array('uploaded' => false);
     //Pega (get) o arquivo do objeto solicitado
     $file = $request->files->get('file');
     // Gera um novo novo para o arquivo
     // Para usar o nome original do arquivo, %filename = $this->file->getClientOriginalName();
     $fileName = md5(uniqid()).'.'.$file->guessExtension();
     //Nota: Ao usar $file-> guessExtension (), às vezes o MIME-guesser pode falhar para arquivos codificados incorretamente. É recomendável usar um fallback para esses casos, se você souber quais extensões de arquivo são esperadas. (Você pode fazer um loop sobre as extensões de arquivo permitidas ou até mesmo codificá-las se você espera apenas um tipo específico de extensão de arquivo.)
    
     // configura seu diretório de upload
     $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
     if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
         mkdir($uploadDir, 0775, true);
     }
     if ($file->move($uploadDir, $fileName)) { 
        $output['uploaded'] = true;
        $output['fileName'] = $fileName;
     }
     return new JsonResponse($output);
 }
}
