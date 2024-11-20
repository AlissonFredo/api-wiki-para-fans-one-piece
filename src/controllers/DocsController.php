<?php

namespace app\controllers;

use app\controllers\Controller;
use app\services\DocsService;

class DocsController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new DocsService;
    }

    public function docs()
    {
        $response = $this->service->docs();

        return $this->response($response['code'], $response['data'], $response['header']);
    }

    public function asset($params)
    {
        $response = $this->service->asset($params['filename']);

        if ($response['code'] == 400 || $response['code'] == 404) {
            return $this->response($response['code'], [
                'message' => 'Error searching asset ',
                'errors' => $response['errors']
            ]);
        }

        return $this->response($response['code'], $response['data'], $response['header']);
    }
}
