<?php
/**
 * Created by PhpStorm.
 * User: Rimshiane
 * Date: 11/26/2016
 * Time: 3:33 AM
 */

if(isset($_SESSION)) {
    echo $this->session->flashdata('flash_data');
} ?>