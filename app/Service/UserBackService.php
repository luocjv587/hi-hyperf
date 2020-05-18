<?php


namespace App\Service;


class UserBackService
{
    public function getInfoById($id){
        return $id+1;
    }
}