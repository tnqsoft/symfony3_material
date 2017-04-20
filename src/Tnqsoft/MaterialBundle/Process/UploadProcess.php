<?php

namespace Tnqsoft\MaterialBundle\Process;

use Tnqsoft\MaterialBundle\Service\Upload;
use Tnqsoft\MaterialBundle\Service\Utility;
use Tnqsoft\MaterialBundle\Service\Model\FileItem;

class UploadProcess
{
    /**
     * @var string
     */
    protected $fileField = 'file';

    /**
     * @var array
     */
    protected $allowList = array('image/*');

    /**
     * @var float
     */
    protected $maxSize = 2*1024*1024;

    /**
     * @var integer
     */
    protected $maxWidth = 800;

    /**
     * @var string
     */
    protected $tmpDir;

    /**
     * @var string
     */
    protected $tmpPath;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $baseDir;

    /**
     * __construct
     *
     * @param string       $tmpDir
     * @param string       $tmpPath
     * @param float       $maxSize
     * @param integer       $maxWidth
     */
    public function __construct($tmpDir, $tmpPath, $maxSize, $maxWidth)
    {
        $this->tmpDir = realpath($tmpDir).DIRECTORY_SEPARATOR;
        $this->tmpPath = $tmpPath;
        $this->maxSize = $maxSize;
        $this->maxWidth = $maxWidth;
    }

    /**
     * Format Name
     *
     * @param  string  $srcName
     * @return string
     */
    public function formatName($srcName)
    {
        return Utility::slugify($srcName);
    }

    /**
     * Upload File with FileItem Model
     * TODO: Replace all method to use upload2
     *
     * @return array
     */
    public function upload($baseDir, $basePath)
    {
        $this->baseDir = $baseDir;
        $this->basePath = $basePath;
        $handle = new Upload($_FILES[$this->fileField]);
        if ($handle->uploaded) {
            // Set Options
            $handle->mime_check = true;
            $handle->no_script = true;
            $handle->file_auto_rename = true;
            $handle->file_max_size = $this->maxSize;
            $handle->allowed = $this->allowList;
            $handle->jpeg_quality = 100;
            $handle->dir_auto_create  = true;
            $handle->dir_auto_chmod = true;
            $handle->dir_chmod = 0777;
            $handle->file_new_name_body = $this->formatName($handle->file_src_name_body);
            //$handle->image_convert = jpg;
            if ($handle->image_src_x > $this->maxWidth) {
                $handle->image_resize = true;
                $handle->image_x = $this->maxWidth;
                $handle->image_ratio_y = true;
            }

            $handle->Process($this->baseDir);
            if ($handle->processed) {
                $handle->Clean();

                return new FileItem($handle->file_dst_pathname, $this->basePath);
            } else {
                throw new \RuntimeException($handle->error);
            }
        }
    }

    /**
     * Crop Image
     *
     * @param  string  $file
     * @param  float  $x1   [description]
     * @param  float  $x2   [description]
     * @param  float  $y1   [description]
     * @param  float  $y2   [description]
     * @return array
     */
    public function cropImage($baseDir, $basePath, $file, $x1, $x2, $y1, $y2)
    {
        $this->baseDir = $baseDir;
        $this->basePath = $basePath;
        $handle = new Upload($this->baseDir.$file);
        if ($handle->uploaded) {
            // Set Options
            $handle->image_resize = false;
            $handle->mime_check = true;
            $handle->no_script = true;
            $handle->file_auto_rename = false;
            $handle->file_overwrite = true;
            $handle->file_max_size = $this->maxSize;
            $handle->allowed = $this->allowList;
            $handle->jpeg_quality = 100;
            $handle->dir_auto_create  = true;
            $handle->dir_auto_chmod = true;
            $handle->dir_chmod = 0777;
            if ($x2 != 0 && $y2 != 0) {
                $handle->image_crop = array($y1, $handle->image_src_x-$x2, $handle->image_src_y-$y2, $x1);
            }

            $handle->Process($this->baseDir);
            if ($handle->processed) {
                return new FileItem($handle->file_dst_pathname, $this->basePath);
                // $handle->Clean();
            } else {
                throw new \RuntimeException($handle->error);
            }
        }
    }

    /**
     * Get the value of File Field
     *
     * @return string
     */
    public function getFileField()
    {
        return $this->fileField;
    }

    /**
     * Set the value of File Field
     *
     * @param string fileField
     *
     * @return self
     */
    public function setFileField($fileField)
    {
        $this->fileField = $fileField;

        return $this;
    }

    /**
     * Get the value of Allow List
     *
     * @return array
     */
    public function getAllowList()
    {
        return $this->allowList;
    }

    /**
     * Set the value of Allow List
     *
     * @param array allowList
     *
     * @return self
     */
    public function setAllowList(array $allowList)
    {
        $this->allowList = $allowList;

        return $this;
    }

    /**
     * Get the value of Max Size
     *
     * @return float
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * Set the value of Max Size
     *
     * @param float maxSize
     *
     * @return self
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;

        return $this;
    }

    /**
     * Get the value of Max Width
     *
     * @return integer
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Set the value of Max Width
     *
     * @param integer maxWidth
     *
     * @return self
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Get the value of Tmp Dir
     *
     * @return string
     */
    public function getTmpDir()
    {
        return $this->tmpDir;
    }

    /**
     * Set the value of Tmp Dir
     *
     * @param string tmpDir
     *
     * @return self
     */
    public function setTmpDir($tmpDir)
    {
        $this->tmpDir = $tmpDir;

        return $this;
    }

    /**
     * Get the value of Tmp Path
     *
     * @return string
     */
    public function getTmpPath()
    {
        return $this->getBasePath().$this->tmpPath;
    }

    /**
     * Set the value of Tmp Path
     *
     * @param string tmpPath
     *
     * @return self
     */
    public function setTmpPath($tmpPath)
    {
        $this->tmpPath = $tmpPath;

        return $this;
    }

    /**
     * Get the value of Base Path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Set the value of Base Path
     *
     * @param string basePath
     *
     * @return self
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * Get the value of Base Dir
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     * Set the value of Base Dir
     *
     * @param string baseDir
     *
     * @return self
     */
    public function setBaseDir($baseDir)
    {
        $this->baseDir = $baseDir;

        return $this;
    }

}
