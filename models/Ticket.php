<?php
require_once ('Paiement.php');
require_once ('Parking.php');
require_once ('Conducteur.php');

/**
 * @author Antho
 * @version 1.0
 * @created 18-juin-2025 11:06:26
 */
class Ticket
{

	private int $idTicket;
	private DateTime $dateHeureEntree;
	private DateTime $dateHeureSortie;
	private float $montant;
	private Bool $paye;
	public $m_Paiement;
	public $m_Parking;
	public $m_Conducteur;

	function __construct()
	{
	}

	function __destruct()
	{
	}
}
?>