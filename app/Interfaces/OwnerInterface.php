<?php

namespace Dodona\Interfaces;

interface Owner
{

    /**
     * The dependants of the entity.
     */
    public function children();

    /**
     * The enabled dependants of the entity.
     */
    public function enabledChildren();
}