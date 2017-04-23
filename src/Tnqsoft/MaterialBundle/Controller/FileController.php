<?php

namespace Tnqsoft\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Tnqsoft\MaterialBundle\Service\Upload;
use Tnqsoft\MaterialBundle\Service\Model\FileItem;
use JMS\Serializer\SerializationContext;

/**
 * @Route("/file")
 */
class FileController extends Controller
{
    /**
     * @Route("/list/{type}", requirements={"type" = "avatar|banner|hotel|area|news|page"}, name="api_file_list")
     * @Method({"GET"})
     */
    public function listFileAction(Request $request, $type)
    {
        //* @Security("has_role('ROLE_USER')")
        $path = $request->query->get('path');
        $dir = $this->getParameter($type.'_dir').((!empty($path))?$path.DIRECTORY_SEPARATOR:'');
        $basePath = $this->getParameter($type.'_path').((!empty($path))?$path.'/':'');

        $files = array();
        if (!is_dir($dir)) {
            return $this->json($files, Response::HTTP_OK);
        }

        $listFiles = glob($dir.'*.{jpg,jpeg,png,gif,bmp,pdf}', GLOB_BRACE);
        if (is_array($listFiles) && !empty($listFiles)) {
            foreach ($listFiles as $file) {
                $files[] = new FileItem($file, $basePath);
            }
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($files, 'json', SerializationContext::create()->setSerializeNull(true));

        // Response client
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @Route("/list/{type}", requirements={"type" = "avatar|banner|hotel|area|news|page"}, name="api_file_delete")
     * @Method({"DELETE"})
     */
    public function deleteFileAction(Request $request, $type)
    {
        //* @Security("has_role('ROLE_USER')")
        if ($request->isXmlHttpRequest() && $request->isMethod('DELETE')) {
            $path = $request->query->get('path');
            $fileName = $request->query->get('file');
            $dir = $this->getParameter($type.'_dir').((!empty($path))?$path.DIRECTORY_SEPARATOR:'');

            if (!is_dir($dir) || !file_exists($dir.$fileName) ) {
                return $this->json(array('error' => 'Không tồn tại file cần xóa'), Response::HTTP_NOT_FOUND);
            }

            $file = new FileItem($dir.$fileName);
            if ($file->getIsWritable() === false) {
                return $this->json(array('error' => 'Không thể xóa file '.$fileName), Response::HTTP_FORBIDDEN);
            }

            unlink($dir.$fileName);

            // Response client
            return $this->json(null, Response::HTTP_OK);
        }

        return new Response('Bad request', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/upload", name="api_file_upload")
     * @Method({"POST"})
     */
    public function uploadFileAction(Request $request)
    {
        //* @Security("has_role('ROLE_USER')")
        $path = $request->query->get('path');
        $type = $request->query->get('type');

        $baseDir = $this->getParameter('upload_tmp_dir');
        $basePath = $this->getParameter('upload_tmp_path');
        if ( $type !== null ) {
            $baseDir = $this->getParameter($type.'_dir').((!empty($path))?$path.DIRECTORY_SEPARATOR:'');
            $basePath = $this->getParameter($type.'_path').((!empty($path))?$path.'/':'');
        }

        $validator = $this->get('tnqsoft_material.validator.file');
        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $file = $request->files->get('file');
            $input = array(
                'file' => $file,
            );
            if (false === $validator->uploadValidate($input)) {
                return new Response(json_encode($validator->getErrorList()), Response::HTTP_BAD_REQUEST);
            }

            $uploadProcess = $this->get('tnqsoft_material.process.upload');
            $uploadProcess->setAllowList(array('image/*', 'application/pdf'));
            $uploadProcess->setBasePath($request->getSchemeAndHttpHost());
            try {
                $fileItem = $uploadProcess->upload($baseDir, $basePath);

                $serializer = $this->get('jms_serializer');
                $data = $serializer->serialize($fileItem, 'json', SerializationContext::create()->setSerializeNull(true));
                // Response client
                return new Response($data, Response::HTTP_OK);
            } catch(\Exception $e) {
                return new Response($e->getMessage(), Response::HTTP_NOT_IMPLEMENTED);
            }
        }

        return new Response('Bad request', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/crop", name="api_file_crop")
     * @Method({"PUT"})
     */
    public function cropImageAction(Request $request)
    {
        //* @Security("has_role('ROLE_USER')")
        $path = $request->query->get('path');
        $type = $request->query->get('type');

        $baseDir = $this->getParameter('upload_tmp_dir');
        $basePath = $this->getParameter('upload_tmp_path');
        if ( $type !== null ) {
            $baseDir = $this->getParameter($type.'_dir').((!empty($path))?$path.DIRECTORY_SEPARATOR:'');
            $basePath = $this->getParameter($type.'_path').((!empty($path))?$path.'/':'');
        }

        if ($request->isXmlHttpRequest() && $request->isMethod('PUT')) {
            $data = $request->request->all();
            $x1 = floatval($request->request->get('x1'));
            $y1 = floatval($request->request->get('y1'));
            $x2 = floatval($request->request->get('x2'));
            $y2 = floatval($request->request->get('y2'));
            $file = $request->request->get('file');

            $pathParts = pathinfo($file);

            $uploadProcess = $this->get('tnqsoft_material.process.upload');
            try {
                $fileItem = $uploadProcess->cropImage($baseDir, $basePath, $pathParts['basename'], $x1, $x2, $y1, $y2);

                $serializer = $this->get('jms_serializer');
                $data = $serializer->serialize($fileItem, 'json', SerializationContext::create()->setSerializeNull(true));
                // Response client
                return new Response($data, Response::HTTP_OK);
            } catch(\Exception $e) {
                return new Response($e->getMessage(), Response::HTTP_NOT_IMPLEMENTED);
            }
        }

        return new Response('Bad request', Response::HTTP_BAD_REQUEST);
    }

}
