<?php

namespace Fnash\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

class HeaderExtractor implements KeyExtractorInterface
{
    private $parameterName;

    /**
     * @param string $parameterName The name of the URL parameter containing the API key.
     */
    public function __construct($parameterName)
    {
        $this->parameterName = $parameterName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasKey(Request $request)
    {
        return $request->headers->has($this->parameterName);
    }

    /**
     * {@inheritdoc}
     */
    public function extractKey(Request $request)
    {
        return $request->headers->get($this->parameterName);
    }
}
