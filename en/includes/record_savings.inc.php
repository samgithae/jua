<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 18:30
 */

$array = filter_input_array(INPUT_POST);
print_r($array);
print_r(json_encode($array));

?>

<form action="record_savings.inc.php" method="post">
    <input type="text" name="savings[name][]">
    <input type="text" name="savings[name][]">
    <input type="text" name="savings[amount][]">
    <input type="text" name="savings[amount][]">
<input type="submit" value="test">
</form>
