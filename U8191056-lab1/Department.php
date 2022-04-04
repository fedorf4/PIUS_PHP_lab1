<?php

class Department
{
    public array $emloyees;
    public string $name;

    public function __construct(string $name, array $employees)
    {
        $this->name = $name;
        $this->emloyees = $employees;
    }

    public function getTotalSalary()
    {
        $totalSum = 0;
        foreach ($this->emloyees as $employee) {
            $totalSum += $employee->salary;
        }
        return $totalSum;
    }
}
