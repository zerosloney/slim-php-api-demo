<?php

namespace APISController\Controller;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

abstract class ApiController
{
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
    }

    /**
     * Renders a template, if there is no .php extenstion it will be.
     *
     * @param array $data
     * @param int   $status
     */
    protected function writeJson($data = [], $status = 200)
    {
        return $this->response->withJson($data, $status, 0);
    }
}
