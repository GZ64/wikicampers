<?php

namespace App\Data;
use App\Entity\Equipment;
use Faker\Core\Number;
use phpDocumentor\Reflection\Types\Integer;

class SearchData {
	/**
	 * @var string|null
	 */
	public string|null $q = '';
	/**
	 * @var string
	 */
	public string $city;
	/**
	 * @var int|null
	 */
	public int|null $pricePerDayMin;
	/**
	 * @var int|null
	 */
	public int|null $pricePerDayMax;
	/**
	 * @var \DateTimeImmutable|null
	 */
	public ?\DateTimeImmutable $availability = null;
	/**
	 * @var Equipment[]
	 */
	public array $equipment = [];
	/**
	 * @var int|null
	 */
	public int|null $campingCarSize = 0;
	
	
}
