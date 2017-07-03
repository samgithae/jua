<?php
require_once __DIR__.'/vendor/autoload.php';


$table = 'loans';
$tableColumn = array();
$options = array("loanType" => "long_term", "limit" => 1);
$loan = \Hudutech\DBManager\ComplexQuery::customFilter($table, $tableColumn, $options);
$interestRate = $loan[0]['interestRate'];
echo $interestRate;
