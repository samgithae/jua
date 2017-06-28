<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:02 PM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\Defaulter;

interface DefaulterInterface
{
    public function create(Defaulter $defaulter);
    public function update(Defaulter $defaulter, $id);
    public static function delete($id);
    public static function destroy();
    public static function getDefaulterObject($id);
    public static function all();
}