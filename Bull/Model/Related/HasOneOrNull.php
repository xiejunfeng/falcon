<?php

class Bull_Model_Related_HasOneOrNull extends Bull_Model_Related_ToOne
{
    /**
     * 
     * Returns a null when there is no related data.
     * 
     * @return null
     * 
     */
    public function fetchEmpty()
    {
        return null;
    }
}