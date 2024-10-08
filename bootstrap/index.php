<?php

define("PATH_ROOT", realpath(__DIR__ . "/.."));

date_default_timezone_set("Asia/Manila");

// autoload vendor files
require PATH_ROOT . "/vendor/autoload.php";

include PATH_ROOT . "/server/server.php";
include PATH_ROOT . "/helpers/role.php";
include PATH_ROOT . "/server/auth-middleware.php";
include PATH_ROOT . "/helpers/method-vars.php";
include PATH_ROOT . "/helpers/array-helpers.php";
include PATH_ROOT . "/helpers/view-helpers.php";
