<?php

class Main {
    private EmployeeRoster $roster;
    private $size;
    private $repeat;
    private $space;

    public function __construct()
    {
        $this->roster = new EmployeeRoster(4);
        $this->size = 4;
    }


    public function start() {
        $this->clear();
        $this->repeat = true;

        $this->space = readline("Enter the size of the roster: ");
        $this->roster = new EmployeeRoster($this->size);


        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");

            $this->start();
        }
        elseif($this->size > 4){
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        }
        else{
            $this->menu();
        }

    }

    public function menu() {
    $availableSlots = str_repeat("*", $this->space); 
    $this->clear();

        echo "Available space in the roster:" . $this->space . "\n";
        echo "$availableSlots EMPLOYEE ROSTER MENU $availableSlots \n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";

        $this->entrance();
    }
    
    public function entrance() {
        $choice = readline("Pick from the menu: ");

        while ($this->repeat) {
            $this->clear();

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    exit("The process terminated...\n");
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    $this->entrance();
                    break;
            }
        }
        echo "Process terminated.\n";
        exit;
    }

    public function addMenu() {
        $this->clear();
        echo "*** Add New Employee ***\n" ;
        $name = readline("Enter employee name: ");
        $address = readline("Enter employee address: ");
        $age = readline("Enter employee age: ");
        $cName = readline("Enter company name: ");
    
        $this->empType($name, $address, $age, $cName);
        $this->repeat(); 
    }
 

    public function empType($name, $address, $age, $cName) {
        $this->clear();
        echo "---Employee Details \n";
        echo "Enter name: $name\n";
        echo "Enter address: $address\n";
        echo "Enter age: $age\n";
        echo "Enter company name: $cName\n";
        echo "[1] Commission Employee       [2] Hourly Employee       [3] Piece Worker";
        $type = readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $cName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $cName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $cName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $cName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $cName) {
        $regularSalary = (float) readline("Enter Regular Salary: ");
        $itemSold = (int) readline("Enter number of items sold: ");
        $commissionRate = (float) readline("Enter Commission Rate: ");
    
        $employee = new CommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemSold, $commissionRate);
    
        if($this->roster->add($employee)){
            $this->space--; 
            echo "Employee Added\n";
        } else {
            echo "Roster is Full!\n";
        }
        $this->repeat();
    }
    
    public function addOnsHE($name, $address, $age, $cName) {
        echo "*** Add New Hourly Employee ***\n";
    
        $hoursWorked = (int) readline("Enter number of hours worked: ");
        $rate = (float) readline("Enter rate per hour: ");
    
        $employee = new HourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate);            
        if ($this->roster->add($employee)) {
            $this->space--; 
        }
        $this->repeat();
    }
    
    public function addOnsPE($name, $address, $age, $cName) {
        echo "*** Add New Piece Worker ***\n";
    
        $numberItems = (int) readline("Enter number of pieces completed: ");
        $wagePerItem = (float) readline("Enter rate per piece: ");
    
        $employee = new PieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem);
        if ($this->roster->add($employee)) {
            $this->space--; // Decrease available slots
        }
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        
        echo "*** List of Employees on the Current Roster ***\n";
        $this->roster->displayEmployees($this->roster->getRoster()); 
        
        $empNumber = (int) readline("Enter employee number to delete: ");
        
    
        if ($this->roster->remove($empNumber)) {
            echo "Employee #$empNumber removed successfully.\n";
            $this->space++;  
        } else {
            echo "Invalid employee number or employee not found.\n";
        }
    
        readline("Press \"Enter\" key to continue...");
        $this->menu();
    }
    
    
    

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                break;
            case 0:
                $this->menu();
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->otherMenu();
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employee\n";
        echo "[2] Display Commission Employee\n";
        echo "[3] Display Hourly Employee\n";
        echo "[4] Display Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                break;
            default:
                echo "Invalid Input!";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
        $this->menu();
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employee\n";
        echo "[2] Count Commission Employee\n";
        echo "[3] Count Hourly Employee\n";
        echo "[4] Count Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Count Total Employees:" . $this->roster->count();
                break;
            case 2:
                echo "Count Commission Employees:" . $this->roster->countCE();
                break;
            case 3:
                echo "Count Hourly Employees:" . $this->roster->countHE();
                break;
            case 4:
                echo "Count Total Employees:" . $this->roster->countPE();
                break;
            case 0:
                break;
            default:
                echo "Invalid Input!";
                break;
        }


        readline("\nPress \"Enter\" key to continue...");
        $this->menu();
    }

    public function clear() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');  
        } else {
            system('clear');  
        }
    }
     
    public function repeat() {
        $choice = readline("Do you want to add another employee? (y/n): ");
        if (strtolower($choice) === 'y') {
            $this->addMenu(); 
        } else {
            echo "Returning to menu...\n";
            $this->menu();
        }
    }
}