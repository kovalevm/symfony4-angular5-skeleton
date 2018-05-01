<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;
use App\Dto\Error;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ApiController extends Controller
{
    /**
     * Validator service
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        if ($this->validator === null) {
            $this->validator = $this->get('validator');
        }

        return $this->validator;
    }

    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        if ($this->serializer === null) {
            $this->serializer = $this->get('jms_serializer');
        }

        return $this->serializer;
    }

    /**
     * @param SerializerInterface $serializer
     * @return $this
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * Serialize specified data to json string
     *
     * @param mixed $data
     * @return string
     */
    protected function serialize($data)
    {
        return $this->getSerializer()->serialize($data, 'json');
    }

    /**
     * Deserialize object from request body
     *
     * @param string  $objClass
     * @param Request $request
     * @return mixed
     */
    protected function deserialize($objClass, Request $request)
    {
        return $this->getSerializer()->deserialize($request->getContent(), $objClass, 'json');
    }

    /**
     * Validate specified parameters
     *
     * @param mixed $params
     * @param array|null $groups
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function validate($params, $groups = null)
    {
        return $this->getValidator()->validate($params, null, $groups);
    }

    /**
     * Create response from specified data
     *
     * @param mixed $data
     * @param int   $status
     * @return Response
     */
    protected function createResponse($data, $status = Response::HTTP_OK)
    {
        return new Response(
            $this->serialize($data),
            $status,
            ['Content-Type' => 'application/vnd.api+json']
        );
    }

    /**
     * Create error response
     *
     * @param Error|Error[] $errors
     * @param int           $status
     * @return Response
     */
    protected function createErrorResponse($errors, $status)
    {
        if (false === is_array($errors)) {
            $errors = array($errors);
        }

        return $this->createResponse(['errors' => $errors], $status);
    }

    /**
     * Create bad request response
     *
     * @param string|null $message
     * @return Response
     */
    protected function createBadRequestResponse($message = 'Failed to parse request')
    {
        $error = new Error();
        $error
            ->setId(uniqid())
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setCode('bad_request')
            ->setTitle($message);

        return $this->createErrorResponse($error, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Create validation error response
     *
     * @param ConstraintViolationListInterface $violations
     * @return Response
     */
    protected function createValidationErrorResponse(ConstraintViolationListInterface $violations)
    {
        $errors = array();

        foreach ($violations as $violation) {
            /* @var $violation \Symfony\Component\Validator\ConstraintViolationInterface */

            $error = new Error();
            $error
                ->setId(uniqid())
                ->setCode($violation->getCode())
                ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->setTitle($violation->getMessage())
                ->setPath($violation->getPropertyPath());

            $errors[] = $error;
        }

        return $this->createErrorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Create not found response
     *
     * @param string|null $message
     * @return Response
     */
    protected function createNotFoundResponse($message = null)
    {
        if (null === $message) {
            $message = 'Not found';
        }

        $error = new Error();
        $error
            ->setId(uniqid())
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setCode('not_found')
            ->setTitle($message);

        return $this->createErrorResponse($error, Response::HTTP_NOT_FOUND);
    }
}
