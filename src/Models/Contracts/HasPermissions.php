<?php

namespace GohostAuth\Models\Contracts;


interface HasPermissions
{
    /**
     * Return a tenant_id array
     *
     * @return array
     */
    static public function buildPermissions();
}
