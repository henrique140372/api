<?php

// =============== EMBED form ===============
return [

    'finding_label' => 'Tìm theo',
    'tab_select_with_ids' => 'IMDB & TMDB Id',
    'tab_select_with_title' => 'Tiêu Đề & Năm',

    'tabs' => [
        'movie_label' => 'Phim Lẻ',
        'series_label' => 'Phim Bộ',
        'api_label' => 'API',
    ],

    // =============== FIND BY IMDB Hoặc TMDB Ids ===============
    'ids_tab_content' => [

        //MOVIES TAB CONTENT
        'movie' => [
            'title' =>
                'Thử 
                %s IMDB %s Hoặc 
                %s TMDB %s
                id để lấy  Phim Lẻ',
            'form' => [
                'input_imdb' => [
                    'label' => 'Nhập IMDB Hoặc TMDB id',
                    'placeholder' => 'ví dụ: tt6468322'
                ],
                'submit_btn_txt' => 'Lấy Phim'
            ]
        ],

        //Phim BộS TAB CONTENT
        'series' => [
            'title' => 'Thử %s IMDB %s Hoặc %s TMDB %s id để lấy  Phim Bộ',
            'form' => [
                'input_imdb' => [
                    'label' => 'Nhập IMDB Hoặc TMDB id',
                    'placeholder' => 'ví dụ: tt6468322'
                ],
                'input_season' => [
                    'label' => 'Phần',
                    'placeholder' => 'ví dụ: 1'
                ],
                'input_episode' => [
                    'label' => 'Tập',
                    'placeholder' => 'ví dụ: 1'
                ],
                'submit_btn_txt' => 'Lấy Phim'
            ]
        ]
    ],
    'title_tab_content' => [

        //MOVIES TAB CONTENT
        'movie' => [
            'title' =>
                'Thử 
                %s Tên Phim %s Hoặc 
                %s Năm %s
                id để lấy  Phim Lẻ',
            'form' => [
                'input_title' => [
                    'label' => 'Nhập Tên Phim',
                    'placeholder' => 'The Batman'
                ],
                'input_year' => [
                    'label' => 'Năm',
                    'placeholder' => 'ví dụ: 2009'
                ]
            ]
        ],

        //Phim BộS TAB CONTENT
        'series' => [
            'title' =>
                'Thử 
                %s Tên Phim %s Hoặc 
                %s Năm %s
                id để lấy  Phim Bộ',
            'form' => [
                'input_title' => [
                    'label' => 'Nhập Tên Phim',
                    'placeholder' => 'The Flash'
                ],
                'input_year' => [
                    'label' => 'Năm',
                    'placeholder' => 'ví dụ: 2016'
                ]
            ]
        ],

    ],
    //API TAB CONTENT
    'api_tab_content' => [
        'movie_title' => '%s Phim Lẻ %s API',
        'series_title' => '%s Phim Bộ %s API',
        'learn_more_btn_txt' => 'Xem Thêm'
    ],

    'form_version' => 'Mã Nhúng '


];