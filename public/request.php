<?php
$request = new Yaf_Request_Simple('CLI', 'Index', 'Controller', 'Hello', ['para' => 2]);
print_r($request);
