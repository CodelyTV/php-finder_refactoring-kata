<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Thing[] */
    private $_p;

    public function __construct(array $p)
    {
        $this->_p = $p;
    }

    public function find(int $ft): F
    {
        /** @var F[] $tr */
        $tr = [];

        for ($i = 0; $i < count($this->_p); $i++) {
            for ($j = $i + 1; $j < count($this->_p); $j++) {
                $r = new F();

                if ($this->_p[$i]->birthDate < $this->_p[$j]->birthDate) {
                    $r->p1 = $this->_p[$i];
                    $r->p2 = $this->_p[$j];
                } else {
                    $r->p1 = $this->_p[$j];
                    $r->p2 = $this->_p[$i];
                }

                $r->d = $r->p2->birthDate->getTimestamp()
                    - $r->p1->birthDate->getTimestamp();

                $tr[] = $r;
            }
        }

        if (count($tr) < 1) {
            return new F();
        }

        $answer = $tr[0];

        foreach ($tr as $result) {
            switch ($ft) {
                case FT::ONE:
                    if ($result->d < $answer->d) {
                        $answer = $result;
                    }
                    break;

                case FT::TWO:
                    if ($result->d > $answer->d) {
                        $answer = $result;
                    }
                    break;
            }
        }

        return $answer;
    }
}
