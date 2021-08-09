<?php


namespace App\Modules\Profile\Permission;


use App\Permission\AbstractPermission;

class ProfilePermission extends AbstractPermission
{
    const VIEW = 'Profile.View';
    const EDIT = 'Profile.Edit';
}
