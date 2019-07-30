<?php

Router::Add('/', function () {
    return 'Router OK';
});

Router::Add('/hello_world/', 'Test@World');

Router::Error(404, function () {
    return 'Unknown page';
});