<?php

namespace Ecedi\PagerBundle\Helper;

use Symfony\Component\HttpFoundation\ParameterBag;

class Pager
{
    private $_count;
    private $_currentCount;
    private $_defaultLimit;
    private $_limit;
    private $_offset;
    private $_nbPages;
    private $_currentPage;
    private $_limitArgName;
    private $_offsetArgName;

    private $_args = array();

    function __construct($count = 0, $currentCount = 0, $limit = 10, $offset = 0)
    {
        $this->setLimitArgName('l');
        $this->setOffsetArgName('o');
        $this->setCount($count);
        $this->setCurrentCount($currentCount);
        $this->setLimit($limit);
        $this->setOffset($offset);
    }

    public function bind(ParameterBag $params)
    {
        $argLimit  = $this->getLimitArgName();
        $argOffset = $this->getOffsetArgName();

        $limit = $params->has($argLimit) ? $params->get($argLimit) : $this->getDefaultLimit();
        $this->setLimit($limit);

        $offset = ($limit && $params->has($argOffset)) ? $params->get($argOffset) : null;
        $this->setOffset($offset);
    }

    /**
     * Définit le nombre total d'enregistrements
     */
    public function setCount($count)
    {
        $this->_count = $count;
        $this->refreshNbPages();
    }

    public function getCount()
    {
        return $this->_count;
    }

    /**
     * Définit le nombre d'enregistrements affichés
     */
    public function setCurrentCount($currentCount)
    {
        $this->_currentCount = $currentCount;
    }

    public function getCurrentCount()
    {
        return $this->_currentCount;
    }

    /**
     * Définit le nombre d'enregistrement à afficher
     */
    public function setLimit($limit)
    {
        $this->_limit = max(0, $limit);
        $this->refreshNbPages();
        $this->refreshCurrentPage();
    }

    public function getLimit()
    {
        return $this->_limit;
    }

    public function setDefaultLimit($default_limit)
    {
        $this->_defaultLimit = $default_limit;
    }

    public function getDefaultLimit()
    {
        return $this->_defaultLimit;
    }

    /**
     * Définit l'index du premier enregistrement à afficher
     */
    public function setOffset($offset)
    {
        $this->_offset = max(0, $offset);
        $this->refreshCurrentPage();
    }

    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * Renvoie l'offset pour une page donnée
     */
    public function getOffsetPage($page)
    {
        // 1 <= $p <= $this->_nbPages
        $p = min(max($page, 1), $this->_nbPages);

        return ($p - 1)*$this->_limit;
    }

    /**
     * Renvoie l'offset pour la première page
     */
    public function getOffsetPageFirst()
    {
        return $this->getOffsetPage(1);
    }

    /**
     * Renvoie l'offset pour la dernière page
     */
    public function getOffsetPageLast()
    {
        return $this->getOffsetPage($this->_nbPages);
    }

    /**
     * Renvoie l'offset pour la page précédente
     */
    public function getOffsetPagePrev()
    {
        return $this->getOffsetPage($this->_currentPage - 1);
    }

    /**
     * Renvoie l'offset pour la page suivante
     */
    public function getOffsetPageNext()
    {
        return $this->getOffsetPage($this->_currentPage + 1);
    }

    public function getNbPages()
    {
        return $this->_nbPages;
    }

    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    public function getArgs()
    {
        return $this->_args;
    }

    public function setArgs($args)
    {
        $this->_args = $args;
    }

    public function getLimitArgName()
    {
        return $this->_limitArgName;
    }

    public function setLimitArgName($key)
    {
        $this->_limitArgName = $key;
    }

    public function getOffsetArgName()
    {
        return $this->_offsetArgName;
    }

    public function setOffsetArgName($key)
    {
        $this->_offsetArgName = $key;
    }

    public function getPathArgs($offset)
    {
        $args = array(
            $this->getLimitArgName()  => $this->getLimit(),
            $this->getOffsetArgName() => $offset,
        );

        return array_merge($this->getArgs(), $args);
    }

    public function getPathArgsPageFirst()
    {
        return $this->getPathArgs($this->getOffsetPageFirst());
    }

    public function getPathArgsPagePrev()
    {
        return $this->getPathArgs($this->getOffsetPagePrev());
    }

    public function getPathArgsPageNext()
    {
        return $this->getPathArgs($this->getOffsetPageNext());
    }

    public function getPathArgsPageLast()
    {
        return $this->getPathArgs($this->getOffsetPageLast());
    }

    public function getPageRange($n = 5)
    {
        $a = array();

        $n = min($n, $this->getNbPages());
        $d = $n%2 ? ($n - 1)/2 : $n/2;
        $c = $this->getCurrentPage();

        $s = ($n == 1) ? $c : min(max($c - $d, 1), $this->getNbPages() - $n + 1);
        for ($i = 0; $i < $n; $i++) {
            $p = $s + $i;
            $a[$p] = $this->getOffsetPage($p);
        }

        return $a;
    }

    /**
     * Recalcule le nombre de pages affichables
     */
    private function refreshNbPages()
    {
        $this->_nbPages = $this->_limit ? ceil($this->_count/$this->_limit) : 0;
    }

    /**
     * Recalcule l'index de la page courante
     */
    private function refreshCurrentPage()
    {
        $this->_currentPage = $this->_limit ? floor($this->_offset/$this->_limit) + 1 : 1;
    }
}
