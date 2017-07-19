<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 27/04/2017
 * Time: 06:42
 */
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Rep Kenya Sacco</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">


            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
               <a href="index.php"> <p style="text-align: center; padding: 20px; color: #0d6aad;">
                <i class="fa fa-university" aria-hidden="true" style="font-size: 100px;"></i>
            </p></a>
                <ul class="nav" id="side-menu">





                    <li>


                        <a href="#" data-toggle="collapse" data-target="#submenu-1"> <div class="menu-links"><i class="fa fa-fw fa-user-plus"></i> Registration <i class="fa fa-fw fa-angle-down pull-right"></i></div></a>
                        <ul id="submenu-1" class="nav nav-second-level">
                            <li >
                                <a href="register_client.php"> <i class="fa fa-fw fa-user-plus"></i> Register Client </a>
                            </li>

                            <li>
                                <a href="register_employee.php"><div class="menu-links" ><i class="fa fa-fw  fa-user"></i>  Register Employee</div></a>
                            </li>
                            <li>
                                <a href="register_group.php"><div class="menu-links" ><i class="fa fa-fw  fa-group"></i> Register Group</div></a>
                            </li>
                            <li>
                                <a href="register_user.php"><div class="menu-links" ><i class="fa fa-fw  fa-user-plus"></i> Register User</div></a>
                            </li>
                        </ul>
                    </li>

                    <li>


                        <a href="#" data-toggle="collapse" data-target="#submenu-2"> <div class="menu-links"><i class="fa fa-fw  fa-search"></i> View <i class="fa fa-fw fa-angle-down pull-right"></i></div></a>
                        <ul id="submenu-2" class="nav nav-second-level">
                            <li >
                                <a href="clients.php"><div class="menu-links" > <i class="fa fa-fw fa-user"></i> View Clients</div> </a>
                            </li>

                            <li>
                                <a href="employees.php"><div class="menu-links" ><i class="fa fa-fw  fa-user"></i> View Employees</div></a>
                            </li>
                            <li>
                                <a href="groups.php"><div class="menu-links" ><i class="fa fa-fw  fa-group"></i> View Groups</div></a>
                            </li>
                            <li>
                                <a href="group_member.php"><div class="menu-links" ><i class="fa fa-fw  fa-group"></i> View Group Members</div></a>
                            </li>
                            <li>
                                <a href="users.php"><div class="menu-links" ><i class="fa fa-fw  fa-user-plus"></i> View Users</div></a>
                            </li>
                        </ul>
                    </li>


                    <li>


                        <a href="#" data-toggle="collapse" data-target="#submenu-3"> <div class="menu-links"><i class="fa fa-fw  fa-pencil"></i> Record Savings <i class="fa fa-fw fa-angle-down pull-right"></i></div></a>
                        <ul id="submenu-3" class="nav nav-second-level">


                            <li>
                                <a href="record_saving.php"><div class="menu-links" ><i class="fa fa-fw  fa-user"></i> Clients Saving</div></a>
                            </li>
                        </ul>
                    </li>
                    <li>


                        <a href="#" data-toggle="collapse" data-target="#submenu-4"> <div class="menu-links"><i class="fa fa-fw  fa-dollar"></i> Savings and Withdraw <i class="fa fa-fw fa-angle-down pull-right"></i></div></a>
                        <ul id="submenu-4" class="nav nav-second-level">

                            <li>
                                <a href="group_saving.php"><div class="menu-links" ><i class="fa fa-fw  fa-group"></i> Groups Savings</div></a>
                            </li>
                            <li>
                                <a href="client_saving.php"><div class="menu-links" ><i class="fa fa-fw  fa-user"></i> Clients Savings</div></a>
                            </li>
                        </ul>
                    </li>

                    <li>


                        <a href="#" data-toggle="collapse" data-target="#submenu-5"> <div class="menu-links"><i class="fa fa-fw  fa-suitcase" ></i> Loans <i class="fa fa-fw fa-angle-down pull-right"></i></div></a>
                        <ul id="submenu-5" class="nav nav-second-level">

                            <li>
                                <a href="lead_loan.php"><div class="menu-links" ><i class="fa fa-fw fa-fw fa-university"></i> Loan Leading</div></a>
                            </li>
                            <li>
                                <a href="loan_repayment.php"><div class="menu-links" ><i class="fa fa-fw  fa-check-square"></i> Loan Repayments</div></a>
                            </li>
                        </ul>
                    </li>

                    <li>




                            <li>
                                <a href="defaulter.php"><div class="menu-links" ><i class="fa fa-fw fa-fw  fa-exclamation-triangle"></i> Defaulters</div></a>
                            </li>


                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>