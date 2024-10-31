<?php

use App\Http\Services\PermissionExtract;

if (!function_exists('userHasAction')) {
    function userHasAction($action) {
        $permissionExtract = new \App\Http\Services\PermissionExtract();
        return $permissionExtract->userHasAction($action);
    }
}

if (!function_exists('userHasPath')) {
    function userHasPath($path) {
        $permissionExtract = new \App\Http\Services\PermissionExtract();
        return $permissionExtract->userHasPath($path);
    }
}


