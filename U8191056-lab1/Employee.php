<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Employee
{
    public int $id;
    public string $name;
    public float $salary;
    public DateTime $employmentDate;

    public function __construct(int $id, string $name, float $salary, DateTime $employmentDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->salary = $salary;
        $this->employmentDate = $employmentDate;
    }

    public function getCurrentWorkExperience()
    {
        $currentDate = new DateTime('now');
        $difference = $currentDate->diff($this->employmentDate);
        return $difference->format('%y');
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank());
        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'name',
            new Assert\Length(["min" => 3])
        );
        $metadata->addPropertyConstraint('salary', new Assert\NotBlank());
        $metadata->addPropertyConstraint('salary', new Assert\Positive());
        $metadata->addPropertyConstraint('employmentDate', new Assert\NotBlank());
        // Other constraints, if needed
    }
}
