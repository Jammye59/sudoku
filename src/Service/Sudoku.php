<?php

namespace App\Service;

class Sudoku
{
		/**
		 * Génère une grille de Sudoku partiellement remplie (niveau facile)
		 * @return array
		 */
		public function generate(): array
		{
			// Exemple simple : grille vide (à remplacer par une vraie génération)
			$grid = array_fill(0, 9, array_fill(0, 9, 0));
			// À améliorer : générer une vraie grille valide
			return $grid;
		}

		/**
		 * Valide si une grille de Sudoku est correcte (règles de base)
		 * @param array $grid
		 * @return bool
		 */
		public function validate(array $grid): bool
		{
			// Vérifie lignes, colonnes et blocs 3x3
			for ($i = 0; $i < 9; $i++) {
				$row = $col = $block = [];
				for ($j = 0; $j < 9; $j++) {
					// Ligne
					if ($grid[$i][$j] !== 0) {
						if (in_array($grid[$i][$j], $row)) return false;
						$row[] = $grid[$i][$j];
					}
					// Colonne
					if ($grid[$j][$i] !== 0) {
						if (in_array($grid[$j][$i], $col)) return false;
						$col[] = $grid[$j][$i];
					}
					// Bloc 3x3
					$r = 3 * floor($i / 3) + floor($j / 3);
					$c = 3 * ($i % 3) + ($j % 3);
					if ($grid[$r][$c] !== 0) {
						if (in_array($grid[$r][$c], $block)) return false;
						$block[] = $grid[$r][$c];
					}
				}
			}
			return true;
		}

		/**
		 * Vérifie si la solution proposée correspond à la solution attendue
		 * @param array $solution
		 * @param array $expected
		 * @return bool
		 */
		public function isSolutionCorrect(array $solution, array $expected): bool
		{
			return $solution === $expected;
		}
}