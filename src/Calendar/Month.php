<?php

namespace Calendar;

use DateTime;

class Month
{
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month Le mois compris entre 1 et 12
     * @param int $year L'année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {

        if($month === null) {
            $month = intval(date('m'));
        }

        if($year === null) {
            $year = intval(date('Y'));
        }

        if ($month < 1 || $month > 12) {
            throw new \Exception("Le mois $month n'est pas valide");
        }

        if ($year < 1970) {
            throw new \Exception("L'année est inférieure à 1970");
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoi le 1er jour du mois
     * @return \DateTime
     */
    public function getStartingDay(): \DateTimeInterface
    {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toute lettre
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Renvoi le nombre de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int 
    {
        $start = $this->getStartingDay();
        $end = $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if($endWeek === 1) {
            $endWeek = intval($end->modify('- 7 days')->format('W')) + 1;
        }
        if($startWeek > 52) {
            $startWeek -= 1;
        }
        If ($startWeek == 52) {
            $startWeek = 0 ;
        }
        $weeks = $endWeek - $startWeek + 1;
        

        if($weeks < 0) {
            $weeks = intval($end->format('W'));
        }

        return $weeks;
    }

    /**
     *  Est-ce que le jour est dans le mois en cours
     * @param \DateTime $date
     * @return bool
     */
    
    public function withinMonth(\DateTimeInterface $date): bool 
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoi le mois suivant
     * @return Month
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }

        return new Month($month, $year);
    }

    /**
     * Renvoi le mois précédent
     * @return Month
     */
    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }

        return new Month($month, $year);
    }
}