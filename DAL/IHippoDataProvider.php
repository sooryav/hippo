<?php

/**
 * IHippoDataProvider short summary.
 *
 * IHippoDataProvider description.
 *
 * @version 1.0
 * @author akhilj
 */

namespace DataAccessLayer;

interface IHippoDataProvider
{
    public function GetVenuesbyZip($zipCode);
    public function GetVenues($zipcode,$type);

}
