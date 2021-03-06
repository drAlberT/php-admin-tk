<?php

/*
 * This file is part of the Faktiva "PHP Admin ToolKit".
 *
 * (c) Faktiva (http://faktiva.com)
 *
 * NOTICE OF LICENSE
 * This source file is subject to the CC BY-SA 4.0 license that is
 * available at the URL https://creativecommons.org/licenses/by-sa/4.0/
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
 * @license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
 * @source   https://github.com/faktiva/php-admin-tk
 */

require __DIR__.'/../config.inc.php';

$tools = array_map(
    function ($item) {
        return BASE_URI.substr($item, strlen(BASE_DIR));
    },
    array_merge(glob(TOOLS_DIR.'/*', GLOB_ONLYDIR), glob(TOOLS_DIR.'/*.php'))
);
natcasesort($tools);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo BASE_URI ?>/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="<?php echo BASE_URI ?>/favicon.ico">
    <title><?php echo getenv('HOSTNAME') ?> admin console</title>
    <style type="text/css">
        * { margin:0; padding:0 }
        html, body { font-size:0.9em }
        h1 { text-align:center; font-size:1.1em; color:#444; padding:0.3em 0 0.1em 0 }
        nav > ul { list-style-type:none; padding:0 1em; margin-bottom:2px }
        nav > ul > li { display:inline-block; margin-left:10px; padding-left:10px; border-left:1px #e55 dotted; white-space:nowrap }
        nav > ul > li:first-child { border-left:0; margin-left:0; padding-left:0 }
        a { text-decoration:none; font-weight:bold; color:#449 }
        nav a:hover { background:rgba(255,255,255, 0.2) }
        header { border-bottom:1px solid #e55; background:lightblue; margin-bottom:4px; -webkit-box-shadow:0 2px 2px -1px #444; -moz-box-shadow:0 2px 2px -1px #444; box-shadow:0 2px 2px -1px #444 }
        footer { position:fixed; bottom:0; width:100%; text-align:center; font-size:0.8em; background-color:rgba(255,255,255, 0.9); border-top:1px solid #e55}
        footer a#github { display:inline-block; line-height:16px; padding-left:20px; background:transparent no-repeat left center url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAAQCAYAAAAbBi9cAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjE2MENCRkExNzVBQjExRTQ5NDBGRTUzMzQyMDVDNzFFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjE2MENCRkEyNzVBQjExRTQ5NDBGRTUzMzQyMDVDNzFFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MTYwQ0JGOUY3NUFCMTFFNDk0MEZFNTMzNDIwNUM3MUUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MTYwQ0JGQTA3NUFCMTFFNDk0MEZFNTMzNDIwNUM3MUUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7HtUU1AAABN0lEQVR42qyUvWoCQRSF77hCLLKC+FOlCKTyIbYQUuhbWPkSFnZ2NpabUvANLGyz5CkkYGMlFtFAUmiSM8lZOVkWsgm58K079+fMnTusZl92BXbgDrTtZ2szd8fas/XBOzmBKaiCEFyTkL4pc9L8vgpNJJDyWtDna61EoXpO+xcFfXUVqtrf7Vx7m9Pub/EatvgHoYXD4ylztC14BBVwydvydgDPHPgNaErN3jLKIxAUmEvAXK21I18SJpXBGAxyBAaMlblOWOs1bMXFkMGeBFsi0pJNe/QNuV7563+gs8LfhrRfE6GaHLuRqfnUiKi6lJ034B44EXL0baTTJWujNGkG3kBX5uRyZuRkPl3WzDTBtzjnxxiDDq83yNxUk7GYuXM53jeLuMNavvAXkv4zrJkTaeGHAAMAIal3icPMsyQAAAAASUVORK5CYII='); background-size:12px }
        #appframe { border:0; height:0; width:100% }
        .server-name { color:#e55; font-family:monospace; font-size:1.25em }
    </style>
    <script language="javascript" type="text/javascript">
        function resizeIframe(obj) {
            obj.style.height = 0 + 'px';
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }

        function fixLinks(obj) {
            links = obj.contentDocument.links;
            for (j = 0; j < links.length; ++j) {
                link = links[j];

                // Fix target
                if ('_blank' == link.getAttribute('target')) {
                    link.setAttribute('target', '_self');
                }
                // Fix protocol
                url = link.getAttribute('href').replace(/^(?:http:)?\/\//i, 'https://');
                link.setAttribute('href', url);
            }
        }
    </script>
</head>
<body>
    <header>
        <h1><span class="server-name"><?php echo php_uname('n') ?></span> admin console</h1>
        <nav>
            <ul>
                <?php foreach ($tools as $tool): ?>
                <li><a href="<?php echo $tool ?>" onclick="document.getElementById('appframe').src='<?php echo $tool ?>'; return false;"><?php echo strtr(basename($tool, '.php'), '_', ' ') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
    <iframe id="appframe" src="" frameborder="0" scrolling="auto" onload="fixLinks(this); resizeIframe(this);" sandbox="allow-same-origin allow-scripts allow-popups allow-modals allow-forms"></iframe>
    <footer>
        <a id="github" href="https://github.com/faktiva/php-admin-tk" target="_blank">faktiva/php-admin-tk</a>
    </footer>
</body>
</html>
