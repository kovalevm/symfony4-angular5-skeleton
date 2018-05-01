<?php
/*
 * This file is part of the Traffic Force API.
 *
 * (c) OrbitScripts LLC <support@orbitscripts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

/**
 * Data transfer object that represent error resource
 *
 * @JMS\Serializer\Annotation\AccessType("public_method")
 *
 */
class Error
{

    /**
     * A unique identifier for this particular occurrence of the problem
     *
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $id;

    /**
     * The HTTP status code applicable to this problem
     *
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $status;

    /**
     * An application-specific error code
     *
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $code;

    /**
     * A short, human-readable summary of the problem.
     *
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $title;

    /**
     * The relative path to the relevant attribute within the
     * associated resource(s). Only appropriate for problems that
     * apply to a single resource or type of resource
     *
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $path;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns a unique identifier for this particular
     * occurrence of the problem
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a unique identifier for this particular
     * occurrence of the problem
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the relative path to the relevant attribute within the
     * associated resource(s). Only appropriate for problems that
     * apply to a single resource or type of resource
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the relative path to the relevant attribute within the
     * associated resource(s). Only appropriate for problems that
     * apply to a single resource or type of resource
     *
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns a short, human-readable summary of the problem.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets a short, human-readable summary of the problem.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns resource type
     *
     * @return string
     */
    public function getResourceType()
    {
        return 'errors';
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return sprintf(
            self::class . ' [title="%s", path="%s", id="%s", code="%s", status="%s"]',
            $this->title,
            $this->path,
            $this->id,
            $this->code,
            $this->status
        );
    }
}
