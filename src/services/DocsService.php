<?php

namespace app\services;

class DocsService
{
    public function docs()
    {
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

        return ['code' => 200, 'data' => $html, 'header' => 'text/html'];
    }

    public function asset($filename)
    {
        if (!isset($filename) || $filename === '') {
            return [
                'code' => 400,
                'errors' => array(['filename' => 'Filename is a required attribute'])
            ];
        }

        $path = __DIR__ . "/../../vendor/swagger-api/swagger-ui/dist/$filename";

        if (!file_exists($path)) {
            return [
                'code' => 404,
                'errors' => array(['file' => 'File not found'])
            ];
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $header = "text/plain";

        switch ($extension) {
            case 'css':
                $header = "text/css";
                break;
            case 'js':
                $header = "application/javascript";
                break;
            case 'png':
                $header = "image/png";
                break;
        }

        return ['code' => 200, 'data' => $path, 'header' => $header];
    }
}
