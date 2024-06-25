<?php
// Requires "guzzle" to be installed (see guzzlephp.org)
// If you have problems with our SSL certificate with error 'Uncaught GuzzleHttp\Exception\RequestException: cURL error 60: SSL certificate problem: unable to get local issuer certificate (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.remove.bg/v1.0/removebg'
// follow these steps to use the latest cacert certificate for cURL: https://github.com/guzzle/guzzle/issues/1935#issuecomment-371756738

$client = new GuzzleHttp\Client();
$res = $client->post('https://api.remove.bg/v1.0/removebg', [
    'multipart' => [
        [
            'name'     => 'image_file',
            'contents' => fopen('/path/to/file.jpg', 'r')
        ],
        [
            'name'     => 'size',
            'contents' => 'auto'
        ]
    ],
    'headers' => [
        'X-Api-Key' => 'cJKcNNXHbTZUSMQPeU8pU2x2'
    ]
]);

$fp = fopen("no-bg.png", "wb");
fwrite($fp, $res->getBody());
fclose($fp);

?>