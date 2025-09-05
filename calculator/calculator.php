<!DOCTYPE html>
<html>
<head>
    <title>PHP Calculator</title>
</head>
<body>
<h2>Simple PHP Calculator</h2>
<form method="post">
    <input type="number" name="num1" placeholder="Enter first number" required>
    <input type="number" name="num2" placeholder="Enter second number" required>
    <select name="operator">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <button type="submit" name="calculate">Calculate</button>
</form>

<?php
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $op = $_POST['operator'];
    $result = 0;

    if ($op == "+") {
        $result = $num1 + $num2;
    } elseif ($op == "-") {
        $result = $num1 - $num2;
    } elseif ($op == "*") {
        $result = $num1 * $num2;
    } elseif ($op == "/") {
        if ($num2 != 0) {
            $result = $num1 / $num2;
        } else {
            echo "<p style='color:red;'>Cannot divide by zero!</p>";
            exit;
        }
    }

    echo "<h3>Result: $result</h3>";
}
?>
</body>
</html>
