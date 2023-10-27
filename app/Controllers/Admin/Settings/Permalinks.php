<?php

/**
 * =====================================================================================
 *             VIPEmbed - Movies TV Shows Embed PHP Script (c) John Antonio
 * -------------------------------------------------------------------------------------
 *
 *  @copyright This software is exclusively sold at codester.com. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from https://www.codester.com
 *
 * ======================================================================================
 *
 * @author John Antonio
 * @link https://www.codester.com/jonty/
 * @license https://www.codester.com/items/35846/vipembed-movies-tv-shows-embed-php-script
 */

namespace App\Controllers\Admin\Settings;



class Permalinks extends BaseSettings
{

    public function index()
    {
        $title = 'Permalinks';


        return view('admin/settings/permalinks', compact('title'));
    }



    public function update()
    {

        if ($this->request->getMethod() == 'post') {


            $validationRules = [
                'default_embed_slug_type' => 'required|in_list[general_id,imdb,tmdb]',
                'default_movies_permalink_type' => 'required|in_list[general_id_short,general_id_long,imdb_short,imdb_long,tmdb_short,tmdb_long,custom_dynamic]',
                'embed_slug' => 'permit_empty|alpha_dash|min_length[1]',
                'download_slug' => 'permit_empty|alpha_dash|min_length[1]',
                'link_slug' => 'permit_empty|alpha_dash|min_length[1]',
                'library_slug' => 'permit_empty|alpha_dash|min_length[1]',
            ];

            if($this->validate($validationRules)){


                $data = $this->request->getPost([
                    'default_embed_slug_type',
                    'default_movies_permalink_type',
                    'movie_permalink_pattern',
                    'series_permalink_pattern',
                    'episode_permalink_pattern'
                ]);

                $customSlugsData = $this->request->getPost([
                    'view_slug',
                    'embed_slug',
                    'download_slug',
                    'link_slug',
                    'library_slug'
                ]);

                $this->updateCustomSlugs( $customSlugsData );

                return $this->save( $data );

            }

            return redirect()->back()
                            ->with('errors', $this->validator->getErrors())
                            ->withInput();



        }

        return redirect()->back();

    }


    protected function updateCustomSlugs(array $slugs )
    {

        $existSlugs = [
            'embed_slug' => embed_slug(),
            'download_slug' => download_slug(),
            'view_slug' => view_slug(),
            'link_slug' => link_slug(),
            'library_slug' => library_slug()
        ];

        foreach ($slugs as $key =>  $val) {

            if(! array_key_exists($key, $existSlugs)){
                continue;
            }

            $slugsForCheck = array_diff_key($existSlugs, array_flip([$key]));

            if(! in_array($val, $slugsForCheck)){

                $this->save( [$key => $val] );

            }else{

                $this->validator->setError($key, "{$key} : your selected slug value is blacklisted. choose another one");

            }

        }


    }

}