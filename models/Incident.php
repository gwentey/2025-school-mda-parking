<?php

require_once ('Ticket.php');
require_once ('Operateur.php');

/**
 * @author Antho
 * @version 1.0
 * @created 18-juin-2025 11:06:26
 */
class Incident
{

	private int $idIncident;
	private String $nom;
	private String $description;
	public $m_Ticket;
	public $m_Operateur;

	function __construct()
	{
	}

	function __destruct()
	{
	}

}
?>