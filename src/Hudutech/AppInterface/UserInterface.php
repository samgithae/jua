<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/1/17
 * Time: 11:26 AM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\User;

interface UserInterface
{
    public function create(User $user);
    public function update(User $user, $id);
    public static function delete($id);
    public static function destroy();
    public static function getId($id);
    public static function all();
    public static function getUserObject($id);

}