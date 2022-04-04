<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'Employee.php';
require_once 'Department.php';
require_once 'Employee.php';

use Symfony\Component\Validator\Validation;

// Creating employees
$emp11 = new Employee(123, 'emp11', 10000, new DateTime('02.10.2010'));
$emp12 = new Employee(456, 'emp12', 20000, new DateTime('06.10.2002'));
$emp13 = new Employee(789, 'emp13', 10000, new DateTime('14.03.2018'));
$emp14 = new Employee(729, 'emp14', 20000, new DateTime('14.03.2018'));
$staff1 = [$emp11, $emp12, $emp14, $emp13];

$emp21 = new Employee(453, 'emp21', 12300, new DateTime('02.10.2010'));
$emp22 = new Employee(-278, 'emp22', 1426, new DateTime('06.10.2002'));
$emp23 = new Employee(178, 'emp23', 18300, new DateTime('14.03.2018'));
$staff2 = [$emp21, $emp22, $emp23];

$emp31 = new Employee(375, 'emp31', 10000, new DateTime('02.10.2010'));
$emp32 = new Employee(433, 'emp32', 20000, new DateTime('06.10.2002'));
$emp33 = new Employee(155, 'emp33', 20000, new DateTime('14.03.2018'));
$emp34 = new Employee(555, 'emp34', 10000, new DateTime('15.03.2014'));
$staff3 = [$emp31, $emp32, $emp33, $emp34];

// Validation
$validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();

foreach ($staff2 as $key => $emp) {
    $violations = $validator->validate($emp);
    if (0 !== count($violations)) {
        echo "Employee $emp->name not valid: \n";
        foreach ($violations as $violation) {
            echo $violation->getMessage() . "\n";
        }
        unset($staff2[$key]);
    }
}

echo "\nCurrent work experience of empl11 - " .
    $emp11->getCurrentWorkExperience() . " years\n\n";

//Creating departments and working with them
$dep1 = new Department('Dep1', $staff1);
$dep2 = new Department('Dep2', $staff2);
$dep3 = new Department('Dep3', $staff3);
$departments = [$dep1, $dep2, $dep3];

$depsWithMinSum = array($departments[0]);
$depsWithMaxSum = array($departments[0]);
unset($departments[0]);

foreach ($departments as $department) {
    $curSum = $department->getTotalSalary();
    $maxSum = $depsWithMaxSum[0]->getTotalSalary();
    $minSum = $depsWithMinSum[0]->getTotalSalary();

    if ($curSum > $maxSum) {
        $depsWithMaxSum = array();
        $depsWithMaxSum[] = $department;
    } elseif ($curSum == $maxSum) {
        if (count($department->emloyees) > count($depsWithMaxSum[0]->emloyees)) {
            $depsWithMaxSum = array();
            $depsWithMaxSum[] = $department;
        } elseif (count($department->emloyees) == count($depsWithMaxSum[0]->emloyees)) {
            $depsWithMaxSum[] = $department;
        }
    }

    if ($curSum < $minSum) {
        $depsWithMinSum = array();
        $depsWithMinSum[] = $department;
    } elseif ($curSum == $minSum) {
        if (count($department->emloyees) > count($depsWithMinSum[0]->emloyees)) {
            $depsWithMinSum = array();
            $depsWithMinSum[] = $department;
        } elseif (count($department->emloyees) == count($depsWithMinSum[0]->emloyees)) {
            $depsWithMinSum[] = $department;
        }
    }
}

echo "Departments with min total sum: \n";
foreach ($depsWithMinSum as $dep) {
    echo "\t" . $dep->name . ' -> ' . $dep->getTotalSalary() . " units\n";
}
echo "Departments with max total sum: \n";
foreach ($depsWithMaxSum as $dep) {
    echo "\t" . $dep->name . ' -> ' . $dep->getTotalSalary() . " units\n";
}
