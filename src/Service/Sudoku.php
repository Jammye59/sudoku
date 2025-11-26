<?php

namespace App\Service;

class Sudoku
{
	/**
	 * Génère une solution complète (grille remplie) de Sudoku
	 * @return array 9x9
	 */
	public function generateFull(): array
	{
		$grid = array_fill(0, 9, array_fill(0, 9, 0));
		$this->fillGrid($grid);
		return $grid;
	}

	/**
	 * Génère une grille en retirant des valeurs d'une solution complète
	 * @param int $remove nombre de cases à retirer (par défaut 40)
	 * @return array 9x9 avec 0 = case vide
	 */
	public function generateWithBlank(int $remove = 3): array
	{
		$grid = $this->generateFull();

		$cells = [];
		for ($r = 0; $r < 9; $r++) {
			for ($c = 0; $c < 9; $c++) {
				$cells[] = [$r, $c];
			}
		}
		shuffle($cells);

		$removed = 0;
		foreach ($cells as [$r, $c]) {
			if ($removed >= $remove) break;
			$backup = $grid[$r][$c];
			$grid[$r][$c] = 0;
			$removed++;
		}

		return $grid;
	}

	/**
	 * On remplit la grille de manière récursive
	 * @param array &$grid
	 * @return bool
	 */
	private function fillGrid(array &$grid): bool
	{
		for ($row = 0; $row < 9; $row++) {
			for ($col = 0; $col < 9; $col++) {
				if ($grid[$row][$col] === 0) {
					$numbers = range(1, 9);
					shuffle($numbers);
					foreach ($numbers as $num) {
						if ($this->isDispo($grid, $row, $col, $num)) {
							$grid[$row][$col] = $num;

							// on fait du backtracking
							if ($this->fillGrid($grid)) return true;
							$grid[$row][$col] = 0;
						}
					}
					return false; // trigger backtrack
				}
			}
		}
		return true; // filled
	}

	/**
	 * Vérifie si on peut placer num en (row,col)
	 */
	private function isDispo(array $grid, int $row, int $col, int $num): bool
	{
		// check dans les ligne et colonne
		for ($i = 0; $i < 9; $i++) {
			if ($grid[$row][$i] === $num) return false;
			if ($grid[$i][$col] === $num) return false;
		}

		// check dans les blocs 3x3
		$startRow = intdiv($row, 3) * 3;
		$startCol = intdiv($col, 3) * 3;
		for ($r = $startRow; $r < $startRow + 3; $r++) {
			for ($c = $startCol; $c < $startCol + 3; $c++) {
				if ($grid[$r][$c] === $num) return false;
			}
		}
		return true;
	}

	/**
	 * Résout un puzzle de Sudoku incomplet
	 * @param array $puzzle grille avec 0 = case vide
	 * @return array|false la grille résolue ou false si impossible
	 */
	public function resolve(array $puzzle): array|false
	{
		$grid = array_map(fn($row) => array_values($row), $puzzle);
		if ($this->solveBacktrack($grid)) {
			return $grid;
		}
		return false;
	}

	/**
	 * Résout la grille par backtracking (helper privé)
	 */
	private function solveBacktrack(array &$grid): bool
	{
		for ($row = 0; $row < 9; $row++) {
			for ($col = 0; $col < 9; $col++) {
				if ($grid[$row][$col] === 0) {
					for ($num = 1; $num <= 9; $num++) {
						if ($this->isDispo($grid, $row, $col, $num)) {
							$grid[$row][$col] = $num;
							if ($this->solveBacktrack($grid)) return true;
							$grid[$row][$col] = 0;
						}
					}
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Valide si une grille de Sudoku respecte les règles
	 */
	public function validate(array $grid): bool
	{
		// Vérifie lignes
		for ($r = 0; $r < 9; $r++) {
			$seen = [];
			for ($c = 0; $c < 9; $c++) {
				$v = $grid[$r][$c] ?? 0;
				if ($v === 0) continue;
				if (isset($seen[$v])) return false;
				$seen[$v] = true;
			}
		}
		// Vérifie colonnes
		for ($c = 0; $c < 9; $c++) {
			$seen = [];
			for ($r = 0; $r < 9; $r++) {
				$v = $grid[$r][$c] ?? 0;
				if ($v === 0) continue;
				if (isset($seen[$v])) return false;
				$seen[$v] = true;
			}
		}
		// Vérifie blocs
		for ($br = 0; $br < 3; $br++) {
			for ($bc = 0; $bc < 3; $bc++) {
				$seen = [];
				for ($r = $br * 3; $r < $br * 3 + 3; $r++) {
					for ($c = $bc * 3; $c < $bc * 3 + 3; $c++) {
						$v = $grid[$r][$c] ?? 0;
						if ($v === 0) continue;
						if (isset($seen[$v])) return false;
						$seen[$v] = true;
					}
				}
			}
		}
		return true;
	}
}