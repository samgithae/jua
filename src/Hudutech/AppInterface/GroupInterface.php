<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:02 PM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\Group;

interface GroupInterface
{
    public function create(Group $group);
    public function update(Group $group, $id);
    public static function delete($id);
    public static function destroy();
    public static function getGroupObject($id);
    public static function all();
    public static function groupMembers($groupRefNo);
}