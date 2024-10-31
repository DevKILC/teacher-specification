<?php

namespace App\Http\Services;

class PermissionExtract {

    protected $permissions;

    public function __construct()
    {
        // Ambil session 'user' dan akses permissions
        $value = session('user');
        $this->permissions = $value['message']['permissions'] ?? [];
    }

    public function extractPermissions()
    {
        $permissionActionNames = [];
        $permissionPathNames = [];

        foreach ($this->permissions as $permission) {
            // Memisahkan izin berdasarkan ":" dan menyimpannya dalam array
            $explodedPermission = explode(':', $permission);

            // Mengambil nama izin (aksi) dan path
            if (isset($explodedPermission[0]) && isset($explodedPermission[1])) {
                $permissionActionNames[] = $explodedPermission[0] . ':' . $explodedPermission[1]; 
            }
            if (isset($explodedPermission[2])) {
                $permissionPathNames[] = $explodedPermission[2]; 
            }
        }

        return [
            'action' => $permissionActionNames,
            'path' => $permissionPathNames
        ];
    }

    public function userHasAction($userAction) {
        // Ambil semua nama izin
        $permissions = $this->extractPermissions();

        // Periksa apakah $userAction ada di dalam $permissions['action']
        return in_array($userAction, $permissions['action']);
    }

    public function userHasPath($userPath) {
        // Ambil semua nama izin
        $permissions = $this->extractPermissions();
        
        // Periksa apakah $userPath ada di dalam $permissions['path']
        return in_array($userPath, $permissions['path']);
    }
}
