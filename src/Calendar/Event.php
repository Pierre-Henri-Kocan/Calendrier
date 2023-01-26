<?php

namespace Calendar;

class Event {
    
    private $id;
    private $name;
    private $description;
    private $start;
    private $end;



    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the value of start
     */ 
    public function getStart(): \DateTime
    {
        return new \DateTime($this->start);
    }

    /**
     * Get the value of end
     */ 
    public function getEnd(): \DateTime
    {
        return new \DateTime($this->end);
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Set the value of start
     *
     * @return  self
     */ 
    public function setStart(string $start)
    {
        $this->start = $start;
    }

    /**
     * Set the value of end
     *
     * @return  self
     */ 
    public function setEnd(string $end)
    {
        $this->end = $end;
    }
}