#!/usr/bin/env php
<?php

/**
 * Generator
 *
 * @link [sugeng-sulistiyawan.github.io](sugeng-sulistiyawan.github.io)
 * @author Sugeng Sulistiyawan <sugeng.sulistiyawan@gmail.com>
 * @copyright Copyright (c) 2023
 */

$themeCssStyle = "
/*
 * @Date:   2017-06-14 16:49:39
 *
 * @link [sugeng-sulistiyawan.github.io](sugeng-sulistiyawan.github.io)
 * @author Sugeng Sulistiyawan <sugeng.sulistiyawan@gmail.com>
 * @copyright Copyright (c) 2023
 */

html, body {
    color: {0};
    background-color: {1};
}

a, a:hover {
    color: {0};
}

.header {
    background-color: {2};
}

.btn-back {
    background-color: {3};
}

.btn-back:hover {
    background-color: {4};
}
";

$themeColors = [
    'default'     => ['#fff', '#1976d2', '#1565c0', '#0d47a1', '#0B3D88'],
    'amber'       => ['#fff', '#ffb300', '#ffa000', '#ff6f00', '#e56300'],
    'deep-purple' => ['#fff', '#5e35b1', '#512da8', '#311b92', '#2A177C'],
    'green'       => ['#fff', '#43a047', '#388e3c', '#1b5e20', '#164F1A'],
    'grey'        => ['#fff', '#546e7a', '#455a64', '#263238', '#242D32'],
    'indigo'      => ['#fff', '#3949ab', '#303f9f', '#1a237e', '#141C60'],
    'pink'        => ['#fff', '#d81b60', '#c2185b', '#880e4f', '#7C0D48'],
    'purple'      => ['#fff', '#8e24aa', '#7b1fa2', '#4a148c', '#3F1177'],
    'red'         => ['#fff', '#e53935', '#d32f2f', '#b71c1c', '#A31919'],
    'teal'        => ['#fff', '#00897b', '#00796b', '#004d40', '#00473A'],
];

$errors = [
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => 'Reserved',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',
    310 => 'Too many Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Time-out',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested range unsatisfiable',
    417 => 'Expectation failed',
    418 => 'I\'m a teapot',
    421 => 'Misdirected Request',
    422 => 'Unprocessable entity',
    423 => 'Locked',
    424 => 'Method failure',
    425 => 'Unordered Collection',
    426 => 'Upgrade Required',
    428 => 'Precondition Required',
    429 => 'Too Many Requests',
    431 => 'Request Header Fields Too Large',
    449 => 'Retry With',
    450 => 'Blocked by Windows Parental Controls',
    451 => 'Unavailable For Legal Reasons',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway or Proxy Error',
    503 => 'Service Unavailable',
    504 => 'Gateway Time-out',
    505 => 'HTTP Version not supported',
    507 => 'Insufficient storage',
    508 => 'Loop Detected',
    509 => 'Bandwidth Limit Exceeded',
    510 => 'Not Extended',
    511 => 'Network Authentication Required',
];

$root     = dirname(__DIR__);
$template = file_get_contents(__DIR__ . "/template.html");
$readme   = "# Error Page Html\nSimple template Error Page Html with custom color css\n\n";
$index    = [];

$i = 0;
foreach ($themeColors as $theme => $colors) {
    $fileCss = $root . "/assets/css/theme-{$theme}.css";

    $content = $themeCssStyle;
    foreach ($colors as $key => $value) {
        $content = str_replace("{{$key}}", $value, strtolower($content));
    }

    echo "Create file: {$fileCss} ...";
    file_put_contents("{$fileCss}", trim($content));
    echo "success\n";

    $title = strtoupper(str_replace("-", " ", $theme));
    $index[$i] = <<< HTML
<div class="card text-white bg-{$theme} border-0 my-5">
                <div class="card-body">
                    <h5 class="card-title"><strong>{$title}</strong></h5>
                    <ul>

HTML;

    foreach ($errors as $code => $title) {
        $fileHtml = "ErrorPage{$code}-{$theme}.html";

        $content = strtr($template, [
            '{{code}}'    => $code,
            '{{title}}'   => $title,
            '{{theme}}'   => "theme-{$theme}",
            '{{message}}' => "Error Code: {$code} - {$title}",
        ]);

        echo "Create file: {$root}/{$fileHtml} ...";
        file_put_contents("{$root}/{$fileHtml}", trim($content));
        echo "success\n";

        $index[$i] .= "                        <li><a href=\"{$fileHtml}\" class=\"btn btn-link\">{$fileHtml}</a></li>\n";
    }

    $index[$i] .= <<< HTML
                    </ul>
                </div>
            </div>
HTML;

    $readme .= "\n";

    $i++;
}

$content = file_get_contents(__DIR__ . "/index.html");
$content = str_replace('{{content}}', implode("\n\n            ", $index), $content);

echo "Create file: {$root}/index.html ...";
file_put_contents("{$root}/index.html", trim($content));
echo "success\n";

