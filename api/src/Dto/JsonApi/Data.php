<?php

namespace App\Dto\JsonApi;

class Data
{
    /**
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     * @Symfony\Component\Validator\Constraints\NotBlank()
     * @Symfony\Component\Validator\Constraints\Type("string")
     */
    protected $type;

    /**
     * @var string
     * @JMS\Serializer\Annotation\Type("string")
     * @Symfony\Component\Validator\Constraints\Type("string")
     */
    protected $id;

    /**
     * @var array
     * @JMS\Serializer\Annotation\Type("array")
     * @Symfony\Component\Validator\Constraints\Type("array")
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $relationships;
}
