<?php

namespace Tnqsoft\MaterialBundle\Service\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FileItem
 * @ExclusionPolicy("all")
 */
class FileItem
{
    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $url;

    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $extension;

    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $mime;

    /**
     * @var \DateTime
     *
     * @Type("DateTime")
     * @Expose
     */
    private $modification;

    /**
     * @var boolean
     *
     * @Type("boolean")
     * @Expose
     */
    private $isReadable;

    /**
     * @var boolean
     *
     * @Type("boolean")
     * @Expose
     */
    private $isWritable;

    /**
     * @var double
     *
     * @Type("double")
     * @Expose
     */
    private $size;

    /**
     * @var double
     *
     * @Type("double")
     * @Expose
     */
    private $width;

    /**
     * @var double
     *
     * @Type("double")
     * @Expose
     */
    private $height;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $path;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $basePath;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $baseDir;

    public function __construct($path, $basePath=null)
    {
        $this->path = $path;
        $this->basePath = $basePath;
        $this->parseFile();
    }

    /**
     * Parse File Infomation
     *
     * @return void
     */
    public function parseFile()
    {
        $pathParts = pathinfo($this->path);
        $this->name = $pathParts['basename'];
        $this->baseDir = $pathParts['dirname'];
        $this->extension = $pathParts['extension'];
        $this->size = filesize($this->path);
        if ($this->isImage($this->path)) {
            list($this->width, $this->height) = getimagesize($this->path);
        }
        $this->mime = mime_content_type($this->path);
        $this->modification = \DateTime::createFromFormat('U', filemtime($this->path));
        $this->isReadable = is_readable($this->path);
        $this->isWritable = is_writable($this->path);
        $this->url = $this->basePath.$this->name;
    }

    /**
     * Is Image
     *
     * @param  string  $filename
     * @return boolean
     */
    protected function isImage($filename)
    {
        $validFormats = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_BMP);
        $fileFormat = exif_imagetype($filename);

        return in_array($fileFormat, $validFormats);
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of Url
     *
     * @param string url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of Extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the value of Extension
     *
     * @param string extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the value of Mime
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set the value of Mime
     *
     * @param string mime
     *
     * @return self
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get the value of Modification
     *
     * @return \DateTime
     */
    public function getModification()
    {
        return $this->modification;
    }

    /**
     * Set the value of Modification
     *
     * @param \DateTime modification
     *
     * @return self
     */
    public function setModification(\DateTime $modification)
    {
        $this->modification = $modification;

        return $this;
    }

    /**
     * Get the value of Is Readable
     *
     * @return boolean
     */
    public function getIsReadable()
    {
        return $this->isReadable;
    }

    /**
     * Set the value of Is Readable
     *
     * @param boolean isReadable
     *
     * @return self
     */
    public function setIsReadable($isReadable)
    {
        $this->isReadable = $isReadable;

        return $this;
    }

    /**
     * Get the value of Is Writable
     *
     * @return boolean
     */
    public function getIsWritable()
    {
        return $this->isWritable;
    }

    /**
     * Set the value of Is Writable
     *
     * @param boolean isWritable
     *
     * @return self
     */
    public function setIsWritable($isWritable)
    {
        $this->isWritable = $isWritable;

        return $this;
    }

    /**
     * Get the value of Size
     *
     * @return double
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of Size
     *
     * @param double size
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of Width
     *
     * @return double
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of Width
     *
     * @param double width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of Height
     *
     * @return double
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of Height
     *
     * @param double height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of Path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of Path
     *
     * @param string path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

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
