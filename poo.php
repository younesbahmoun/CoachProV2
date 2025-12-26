<?php
class BankAccount {
    private $balance;
    
    public function __construct($initialBalance) {
        $this->balance = $initialBalance;
    }
    
    // Getter - allows reading the balance
    public function getBalance() {
        return $this->balance;
    }
    
    // Setter with validation - deposit money
    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            return true;
        }
        return false;
    }
    
    // Setter with validation - withdraw money
    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }
}

// Usage
$account = new BankAccount(1000);
// echo $account->balance; // ERROR: cannot access directly
echo $account->getBalance(); // 1000 - Controlled access

$account->deposit(500);
echo $account->getBalance(); // 1500

$account->withdraw(2000); // false - insufficient balance
?>

<?php
