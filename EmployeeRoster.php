<?php

class EmployeeRoster {
    private $roster = [];
    private $space;  

    public function __construct($rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
        $this->space = $rosterSize; 
    }

    public function add(Employee $employee) {
        foreach ($this->roster as $existingEmployee) {
            if ($existingEmployee !== null && $existingEmployee->get_name() === $employee->get_name()) {
                echo "Employee already exists.\n";
                return false;
            }
        }

     
        foreach ($this->roster as $index => $existingEmployee) {
            if ($existingEmployee === null) {
                $this->roster[$index] = $employee;
                $this->space--;  
                echo "Employee added to the roster.\n";
                return true;
            }
        }

        echo "Roster is full. Cannot add more employees.\n";
        return false;
    }
    
    public function remove($empNumber) {
        $index = $empNumber - 1; 
        if (isset($this->roster[$index]) && $this->roster[$index] !== null) {
            $this->roster[$index] = null; 
            echo "Employee #$empNumber removed successfully.\n";
            return true;
        }
        echo "Invalid employee number or employee not found.\n";
        return false;
    }

    public function getRoster() {
        return $this->roster;
    }

    public function count() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee !== null;
        }));
    }

    public function countCE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof CommissionEmployee;
        }));
    }

    public function countHE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof HourlyEmployee;
        }));
    }

    public function countPE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof PieceWorker;
        }));
    }

    public function display() {
        echo "-- All Employees --\n";
        $this->displayEmployees($this->roster);
    }

    public function displayCE() {
        echo "-- Commission Employees --\n";
        $this->displayEmployees(array_filter($this->roster, function ($employee) {
            return $employee instanceof CommissionEmployee;
        }));
    }

    public function displayHE() {
        echo "-- Hourly Employees --\n";
        $this->displayEmployees(array_filter($this->roster, function ($employee) {
            return $employee instanceof HourlyEmployee;
        }));
    }

    public function displayPE() {
        echo "-- Piece Workers --\n";
        $this->displayEmployees(array_filter($this->roster, function ($employee) {
            return $employee instanceof PieceWorker;
        }));
    }

    public function displayEmployees($employeeArray) {
        echo "-- List of Employees on the Current Roster --\n";
    
        $hasEmployees = false;
    
        foreach ($employeeArray as $index => $employee) {
            if ($employee instanceof Employee) {
                $hasEmployees = true;
                $displayNumber = $index + 1; // Employee number starts at 1
                echo "Employee #$displayNumber\n"; 
                echo "Name       : " . $employee->get_name() . "\n";
                echo "Address    : " . $employee->get_address() . "\n";
                echo "Age        : " . $employee->get_age() . "\n";
                echo "Company    : " . $employee->get_CN() . "\n";
                echo "Type       : " . get_class($employee) . "\n";
                
                if ($employee instanceof CommissionEmployee) {
                    echo "Regular Salary : " . $employee->get_RS() . "\n";
                    echo "Items Sold     : " . $employee->get_IS() . "\n";
                    echo "Commission Rate: " . $employee->get_CR() . "\n";
                } elseif ($employee instanceof HourlyEmployee) {
                    echo "Hours Worked : " . $employee->get_HW() . "\n";
                    echo "Hourly Rate  : " . $employee->get_rate() . "\n";
                } elseif ($employee instanceof PieceWorker) {
                    echo "Pieces Completed: " . $employee->get_NI() . "\n";
                    echo "Wage Per Piece : " . $employee->get_WPI() . "\n";
                }
    
                echo "----------------------------------------\n";
            }
        }
    
        if (!$hasEmployees) {
            echo "No employees in the roster.\n";
        }
    }
    
    public function payroll() {
        echo "-----------------\nPayroll\n-----------------\n";
        $employeeNumber = 1;

        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo "Employee #{$employeeNumber}\n";
                echo "Name       : " . $employee->get_name() . "\n";
                echo "Address    : " . $employee->get_address() . "\n";
                echo "Age        : " . $employee->get_age() . "\n";
                echo "Company    : " . $employee->get_CN() . "\n";

                if (method_exists($employee, 'get_RS')) {
                    echo "Regular Salary: " . $employee->get_RS() . "\n";
                    echo "Items Sold    : " . $employee->get_IS() . "\n";
                    echo "Commission Rate: " . $employee->get_CR() . "\n";
                }

                echo "Earnings         :" . $employee->earnings() . "\n" .
                    "-----------------\n";
                $employeeNumber++;
            }
        }
    }
}

?>
