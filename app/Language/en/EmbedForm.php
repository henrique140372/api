<?php

// =============== EMBED FORM ===============
return [

    'finding_label' => 'Localizar por',
    'tab_select_with_ids' => 'IMDB & TMDB ID',
    'tab_select_with_title' => 'TíTULO & ANO',

    'tabs' => [
        'movie_label' => 'FILMES',
        'series_label' => 'SERIES',
        'api_label' => 'USE NOSSA API',
    ],

    // =============== FIND BY IMDB or TMDB Ids ===============
    'ids_tab_content' => [

        //MOVIES TAB CONTENT
        'movie' => [
            'title' =>
                'Experimentar
                 %s IMDB %s ou
                 %s TMDB %s
                 id para obter filme',
            'form' => [
                'input_imdb' => [
                    'label' => 'Digite o ID do IMDB ou TMDB',
                    'placeholder' => 'Ex: tt6468322'
                ],
                'submit_btn_txt' => 'PEGUE'
            ]
        ],

        //TV SHOWS TAB CONTENT
        'series' => [
            'title' => 'Experimente %s IMDB %s ou %s TMDB %s id para obter series',
            'form' => [
                'input_imdb' => [
                    'label' => 'Digite o ID do IMDB ou TMDB',
                    'placeholder' => 'Ex: tt6468322'
                ],
                'input_season' => [
                    'label' => 'TEMPORADA',
                    'placeholder' => 'Ex: 1'
                ],
                'input_episode' => [
                    'label' => 'EPISODIO',
                    'placeholder' => 'Ex: 1'
                ],
                'submit_btn_txt' => 'PEGUE'
            ]
        ]
    ],
    'title_tab_content' => [

        //MOVIES TAB CONTENT
        'movie' => [
            'title' =>
                'Experimentar
                 %s Título %s ou
                 %s Ano %s
                 id para obter filme',
            'form' => [
                'input_title' => [
                    'label' => 'Digite o título',
                    'placeholder' => 'O LUTADOR DE RUA'
                ],
                'input_year' => [
                    'label' => 'Ano',
                    'placeholder' => 'Ex: 2023'
                ]
            ]
        ],

        //TV SHOWS TAB CONTENT
        'series' => [
            'title' =>
                'Experimentar
                 %s Título %s ou
                 %s Ano %s
                 id para obter SERIES',
            'form' => [
                'input_title' => [
                    'label' => 'Digite o título',
                    'placeholder' => 'LA CASA DE PAPEL'
                ],
                'input_year' => [
                    'label' => 'ANO',
                    'placeholder' => 'Ex: 2023'
                ]
            ]
        ],

    ],
    //API TAB CONTENT
    'api_tab_content' => [
        'movie_title' => '%s Filme %s API',
        'series_title' => '%s Series %s API',
        'learn_more_btn_txt' => 'Saber mais'
    ],

    'form_version' => 'Formulário de Incorporação Rápido'


];