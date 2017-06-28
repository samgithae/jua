<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:01 PM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\Employee;

interface EmployeeInterface
{
    public function create(Employee $employee);
    public function update(Employee $employee, $id);
    public static function delete($id);
    public static function destroy();
    public static function getEmployeeObject($id);
    public static function all();
}