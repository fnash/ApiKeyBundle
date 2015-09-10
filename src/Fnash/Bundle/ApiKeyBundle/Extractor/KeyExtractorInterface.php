<?php

namespace Fnash\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

interface KeyExtractorInterface
{
    /**
     * Tells if the given requests carries an API key.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function hasKey(Request $request);

    /**
     * Extract the API key from thhe given request.
     *
     * @param Request $request
     *
     * @return string
     */
    public function extractKey(Request $request);
}
