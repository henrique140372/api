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

namespace App\Models\Translations;

use App\Models\BaseTranslationModel;

/**
 * Class GenreTranslationsModel
 * @package App\Models\Translations
 * @author John Antonio
 */
class GenreTranslationsModel extends BaseTranslationModel
{
    protected $table = 'genre_translations';
    protected $allowedFields = [ 'genre_id', 'lang', 'name'];
    protected $validationRules = [
        'genre_id' => 'required|is_natural_no_zero|exist[genres.id]',
        'lang' => 'required|alpha|max_length[5]|valid_lang_code|both_unique[genre_translations.genre_id,lang]'
    ];

    public function findByGenreId(int $genreId, $lang = '')
    {
        if(empty( $lang )){

            $results = $this->where('genre_id', $genreId)
                            ->findAll();

            $selectedLanguages = get_selected_languages();
            $resultsLanguages = array_keys( $results );

            $diff = array_diff($selectedLanguages, $resultsLanguages);
            if(! empty( $diff )){
                foreach ($diff as $tmp){
                    $results[$tmp] = $this->getDummyEntity( $tmp );
                }
            }


        }else{

            $results = $this->where('genre_id', $genreId)
                            ->where('lang', $lang)
                            ->first();

        }

        return $results;
    }

}