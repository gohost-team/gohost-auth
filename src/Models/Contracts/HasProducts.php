<?php

namespace GohostAuth\Models\ProductMember;


interface HasProducts
{
    /**
     * Return a tenant_id array
     *
     * @return array
     */
    public function hasProducts();

    public function canAccessProduct($tenant_id);
}
