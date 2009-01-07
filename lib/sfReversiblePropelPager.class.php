<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfReversiblePropelPager extends sfPropelPager
{
  protected
    $results        = null,
    $sqlOrderColumn = 'id',
    $sqlOrder       = Criteria::DESC,
    $listOrder      = Criteria::ASC;

  public function getResults()
  {
    if (is_null($this->results))
    {
      if (Criteria::ASC === $this->sqlOrder)
      {
        $this->getCriteria()->addAscendingOrderByColumn($this->sqlOrderColumn);
      }
      else
      {
        $this->getCriteria()->addDescendingOrderByColumn($this->sqlOrderColumn);
      }

      $this->results = parent::getResults();

      if ($this->sqlOrder !== $this->listOrder)
      {
        $this->results = array_reverse($this->results);
      }
    }

    return $this->results;
  }

  public function getEarlierPage()
  {
    return (Criteria::ASC === $this->sqlOrder) ? $this->getPreviousPage() : $this->getNextPage();
  }

  public function getLaterPage()
  {
    return (Criteria::ASC === $this->sqlOrder) ? $this->getNextPage() : $this->getPreviousPage();
  }

  public function hasEarlierPage()
  {
    return (Criteria::ASC === $this->sqlOrder) ? $this->hasPreviousPage() : $this->hasNextPage();
  }

  public function hasLaterPage()
  {
    return (Criteria::ASC === $this->sqlOrder) ? $this->hasNextPage() : $this->hasPreviousPage();
  }

  public function hasPreviousPage()
  {
    return (1 < $this->getPage());
  }

  public function hasNextPage()
  {
    return ($this->getPage() < $this->getLastPage());
  }

  public function getFirstItem()
  {
    if (Criteria::ASC === $this->listOrder)
    {
      return reset($this->getResults());
    }
    else
    {
      return end($this->getResults());
    }
  }

  public function getLastItem()
  {
    if (Criteria::ASC === $this->listOrder)
    {
      return end($this->getResults());
    }
    else
    {
      return reset($this->getResults());
    }
  }

  public function setSqlOrderColumn($sqlOrderColumn)
  {
    $this->sqlOrderColumn = $sqlOrderColumn;
  }

  public function setSqlOrder($order)
  {
    $this->sqlOrder = $this->normalizeOrder($order);
  }

  public function setListOrder($order)
  {
    $this->listOrder = $this->normalizeOrder($order);
  }

  protected function normalizeOrder($order)
  {
    if (Criteria::ASC === $order)
    {
      return Criteria::ASC;
    }
    else
    {
      return Criteria::DESC;
    }
  }
}
