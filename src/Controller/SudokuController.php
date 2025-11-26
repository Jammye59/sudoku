<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Sudoku;

class SudokuController extends AbstractController
{
    private Sudoku $sudoku;

    public function __construct()
    {
        $this->sudoku = new Sudoku();
    }

    #[Route('/sudoku/new', name: 'sudoku_new', methods: ['GET'])]
    public function new(): Response
    {
        // on genere le sudoku
        return new JsonResponse( $this->sudoku->generateWithBlank() );
    }

    #[Route('/sudoku/solve', name: 'sudoku_solve', methods: ['POST'])]
    public function solve(): Response
    {
        // À personnaliser : logique de résolution
        return new Response('Résoudre la grille de Sudoku');
    }

    #[Route('/sudoku/validate', name: 'sudoku_validate', methods: ['POST'])]
    public function validate(): Response
    {
        return new JsonResponse( $this->sudoku->validate( $this->input->post('sudoku') ) );
    }
}