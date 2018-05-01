<?php

namespace App\Dto\JsonApi;

class Main
{
    /**
     * @var Data
     * @JMS\Serializer\Annotation\Type("App\Dto\JsonApi\Data")
     * @JMS\Serializer\Annotation\SerializedName("data")
     * @Symfony\Component\Validator\Constraints\NotBlank()
     * @Symfony\Component\Validator\Constraints\Valid()
     */
    protected $data;
}
