<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/sudoku/new' => [[['_route' => 'sudoku_new', '_controller' => 'App\\Controller\\SudokuController::new'], null, ['GET' => 0], null, false, false, null]],
        '/sudoku/solve' => [[['_route' => 'sudoku_solve', '_controller' => 'App\\Controller\\SudokuController::solve'], null, ['POST' => 0], null, false, false, null]],
        '/sudoku/validate' => [[['_route' => 'sudoku_validate', '_controller' => 'App\\Controller\\SudokuController::validate'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
