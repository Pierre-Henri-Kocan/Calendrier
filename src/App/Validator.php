<?php

namespace App;

class Validator {

    private $data;
    protected $errors = [];


    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {

        $this->errors = [];
        $this->data = $data;

        return $this->errors;
    }

    public function validate(string $field, string $method, ...$parameters):bool {
        if (!isset($this->data[$field])) {
            $this->errors[$field] = "Le champ $field n'est pas rempli";
            return false;
        } else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }

    }

    public function minLenght(string $field, int $lenght): bool {
        if (mb_strlen($field) < $lenght) {
            $this->errors[$field] = " Le champ doit avoir plus de $lenght caractères";
            return false;
        }
        return true;
    }

    public function date(string $field): bool {
        if (\DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field] = "La date n'est pas valide";
            return false;
        }
        return true;
    }

    public function time(string $field): bool {
        if (\DateTime::createFromFormat('H:i', $this->data[$field]) === false) {
            $this->errors[$field] = "L'heure n'est pas valide";
            return false;
        }
        return true;
    }

    public function beforeTime(string $startField, string $endField) {
        if ($this->time($startField) && $this->time($endField)) {
            $start = \DateTime::createFromFormat('H:i', $this->data[$startField]);
            $end = \DateTime::createFromFormat('H:i', $this->data[$endField]);

            if ($start->getTimestamp() > $end->getTimestamp()) {
                $this->errors[$startField] = "L'heure de début doit être inférieure à l'heure de fin";
                return false;
            }
            return true;
        }
        return false;
    }
}