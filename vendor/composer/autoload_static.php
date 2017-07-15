<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4e3453010ba9f77a6119b03ae3282213
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hudutech\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hudutech\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Hudutech',
        ),
    );

    public static $classMap = array (
        'Hudutech\\AppInterface\\ClientInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/ClientInterface.php',
        'Hudutech\\AppInterface\\DefaulterInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/DefaulterInterface.php',
        'Hudutech\\AppInterface\\EmployeeInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/EmployeeInterface.php',
        'Hudutech\\AppInterface\\GroupInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/GroupInterface.php',
        'Hudutech\\AppInterface\\LoanInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/LoanInterface.php',
        'Hudutech\\AppInterface\\SavingInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/SavingInterface.php',
        'Hudutech\\AppInterface\\TransactionLogInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/TransactionLogInterface.php',
        'Hudutech\\AppInterface\\UserInterface' => __DIR__ . '/../..' . '/src/Hudutech/AppInterface/UserInterface.php',
        'Hudutech\\Auth\\Auth' => __DIR__ . '/../..' . '/src/Hudutech/Auth/Auth.php',
        'Hudutech\\Controller\\ClientController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/ClientController.php',
        'Hudutech\\Controller\\DefaulterController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/DefaulterController.php',
        'Hudutech\\Controller\\EmployeeController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/EmployeeController.php',
        'Hudutech\\Controller\\GroupController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/GroupController.php',
        'Hudutech\\Controller\\GroupStats' => __DIR__ . '/../..' . '/src/Hudutech/Controller/GroupStats.php',
        'Hudutech\\Controller\\LoanController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/LoanController.php',
        'Hudutech\\Controller\\LongTermLoan' => __DIR__ . '/../..' . '/src/Hudutech/Controller/LongTermLoan.php',
        'Hudutech\\Controller\\SavingController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/SavingController.php',
        'Hudutech\\Controller\\TransactionLogController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/TransactionLogController.php',
        'Hudutech\\Controller\\UserController' => __DIR__ . '/../..' . '/src/Hudutech/Controller/UserController.php',
        'Hudutech\\DBManager\\ComplexQuery' => __DIR__ . '/../..' . '/src/Hudutech/DBManager/ComplexQuery.php',
        'Hudutech\\DBManager\\DB' => __DIR__ . '/../..' . '/src/Hudutech/DBManager/DB.php',
        'Hudutech\\Entity\\Client' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Client.php',
        'Hudutech\\Entity\\Defaulter' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Defaulter.php',
        'Hudutech\\Entity\\Employee' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Employee.php',
        'Hudutech\\Entity\\Group' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Group.php',
        'Hudutech\\Entity\\Loan' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Loan.php',
        'Hudutech\\Entity\\Saving' => __DIR__ . '/../..' . '/src/Hudutech/Entity/Saving.php',
        'Hudutech\\Entity\\User' => __DIR__ . '/../..' . '/src/Hudutech/Entity/User.php',
        'Hudutech\\Services\\FileUploader' => __DIR__ . '/../..' . '/src/Hudutech/Services/FileUploader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4e3453010ba9f77a6119b03ae3282213::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4e3453010ba9f77a6119b03ae3282213::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4e3453010ba9f77a6119b03ae3282213::$classMap;

        }, null, ClassLoader::class);
    }
}
