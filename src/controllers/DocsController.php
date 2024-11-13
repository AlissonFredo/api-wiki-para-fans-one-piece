<?php

namespace app\controllers;

use app\controllers\Controller;

class DocsController extends Controller
{
    public function docs()
    {
        header('Content-Type: text/html');

        $html = file_get_contents(__DIR__ . '/../../vendor/swagger-api/swagger-ui/dist/index.html');
        $html = preg_replace('/<link\b[^>]*>(.*?)<\/link>/is', '', $html);
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        $customLinks = "
            <link rel='stylesheet' href='/documentation/assets?filename=swagger-ui.css'>
            <link rel='stylesheet' href='/documentation/assets?filename=index.css'>
            <link rel='icon' type='image/png' href='/documentation/assets?filename=favicon-32x32.png' sizes='32x32' />
            <link rel='icon' type='image/png' href='/documentation/assets?filename=favicon-16x16.png' sizes='16x16' />
        ";

        $customScripts = "
            <script src='/documentation/assets?filename=swagger-ui-bundle.js'></script>
            <script src='/documentation/assets?filename=swagger-ui-standalone-preset.js'></script>
            <script src='/documentation/assets?filename=swagger-initializer.js'></script>
            <script>
                window.onload = function() {
                    const ui = SwaggerUIBundle({
                        url: '/api-docs.json', // Certifique-se de que o `swagger.json` está disponível neste caminho
                        dom_id: '#swagger-ui',
                        deepLinking: true,
                        presets: [
                            SwaggerUIBundle.presets.apis,
                            SwaggerUIStandalonePreset
                        ],
                        layout: 'StandaloneLayout'
                    });
                    window.ui = ui;
                };
            </script>
        ";

        $html = preg_replace('/<head\b[^>]*>/is', '$0' . $customLinks, $html, 1);
        $html = preg_replace('/<\/body>/is', $customScripts . '$0', $html, 1);

        echo $html;
        exit;
    }

    public function asset($params)
    {
        $filename = $params['filename'] ?? null;

        if (!$filename) {
            return $this->response(400, ['message' => 'Filename is a required attribute']);
        }

        $path = __DIR__ . "/../../vendor/swagger-api/swagger-ui/dist/$filename";

        if (file_exists($path)) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'css':
                    header('Content-Type: text/css');
                    break;
                case 'js':
                    header('Content-Type: application/javascript');
                    break;
                case 'png':
                    header('Content-Type: image/png');
                    break;
                default:
                    header('Content-Type: text/plain');
            }

            readfile($path);
        } else {
            return $this->response(404, ['message' => 'File not found']);
        }
    }
}
