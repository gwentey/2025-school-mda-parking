<?php
require_once ('Parking.php');
/**
 * @author Antho
 * @version 1.0
 * @created 18-juin-2025 11:06:26
 */
class Tarification
{

	private int $id;
	private float $tarifHoraire;
	private float $dureeGratuite;
	public $m_Parking;

	function __construct()
	{
	}

	function __destruct()
	{
	}
}
?>