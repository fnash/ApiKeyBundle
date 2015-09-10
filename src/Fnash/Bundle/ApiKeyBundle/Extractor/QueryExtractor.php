<?php

namespace Fnash\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

class QueryExtractor implements KeyExtractorInterface
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
        return $request->query->has($this->parameterName);
    }

    /**
     * {@inheritdoc}
     */
    public function extractKey(Request $request)
    {
        return $request->query->get($this->parameterName);
    }
}
