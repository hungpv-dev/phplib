<?php
function logHelp($type, $msg)
{
    $padding = str_repeat(' ', max(0, 20 - strlen($type)));
    echo "\t\e[1;33m" . $type . "\e[0m" . $padding . ": \e[0;36m" . $msg . "\e[0m\n";
}

echo "\e[1;34mMake (Tạo)\e[0m\n";

logHelp("make:view", "Tạo file view");
logHelp("make:api", "Tạo file api");
logHelp("make:one", "Tạo file api one");
logHelp("make:js", "Tạo file javascript");
logHelp("make:controller", "Tạo class controller");
