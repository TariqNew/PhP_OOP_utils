<?php

class Calculator {
    private $num1;
    private $num2;

    public function setNumbers($num1, $num2) {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }

    public function add() {
        return $this->num1 + $this->num2;
    }

    public function subtract() {
        return $this->num1 - $this->num2;
    }

    public function multiply() {
        return $this->num1 * $this->num2;
    }

    public function divide() {
        if ($this->num2 == 0) {
            return "Error: Division by zero is not allowed.";
        }
        return $this->num1 / $this->num2;
    }

    public function modulus() {
        if ($this->num2 == 0) {
            return "Error: Division by zero is not allowed.";
        }
        return $this->num1 % $this->num2;
    }

    public function power() {
        return pow($this->num1, $this->num2);
    }
}

// Example usage
$calculator = new Calculator();
$calculator->setNumbers(10, 5);

echo "Addition: " . $calculator->add() . "\n";
echo "Subtraction: " . $calculator->subtract() . "\n";
echo "Multiplication: " . $calculator->multiply() . "\n";
echo "Division: " . $calculator->divide() . "\n";
echo "Modulus: " . $calculator->modulus() . "\n";
echo "Power: " . $calculator->power() . "\n";

?>
