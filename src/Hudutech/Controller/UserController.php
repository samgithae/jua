<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/1/17
 * Time: 11:47 AM
 */

namespace Hudutech\Controller;


use Hudutech\AppInterface\UserInterface;
use Hudutech\Auth\Auth;
use Hudutech\DBManager\DB;
use Hudutech\Entity\User;

class UserController extends Auth implements UserInterface
{
    public function create(User $user)
    {
        $db = new DB();
        $conn = $db->connect();

        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $role = $user->getRole();

        try{
            $stmt = $conn->prepare("INSERT INTO users(
                                                        username,
                                                        email,
                                                        password,
                                                        role
                                                      ) 
                                                VALUES (
                                                    :username,
                                                    :email,
                                                    :password,
                                                    :role)"
                                                );

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public function update(User $user, $id)
    {
        $db = new DB();
        $conn = $db->connect();

        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $role = $user->getRole();

        try {
            $stmt = $conn->prepare("UPDATE users SET 
                                                    username=:username,
                                                    password=:password,
                                                    role=:role, email=:email
                                                  WHERE
                                                        id=:id
                                                    ");


            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function delete($id)
    {
        $db = new DB();
        $conn = $db->connect();
      try{
         $stmt = $conn->prepare("DELETE FROM sacco.users WHERE id=:id");
         $stmt->bindParam(":id", $id);
         return $stmt->execute() ? true : false;
      } catch (\PDOException $exception) {
          echo $exception->getMessage();
          return false;
      }

    }

    public static function destroy()
    {
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("DELETE FROM sacco.users");
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function getId($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try{

            $stmt = $conn->prepare("SELECT u.* FROM users u WHERE u.id=:id");
            $stmt->bindParam(":id", $id);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    public static function all()
    {
        $db = new DB();
        $conn = $db->connect();

        try{

            $stmt = $conn->prepare("SELECT u.* FROM users u WHERE 1");
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    public static function getUserObject($id)
    {
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, User::class);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch() : null;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }
    }


}