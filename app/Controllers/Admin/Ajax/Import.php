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

namespace App\Controllers\Admin\Ajax;

use App\Controllers\BaseAjax;
use App\Entities\Movie;
use App\Entities\Series;
use App\Libraries\DataAPI\API;
use App\Models\GenreModel;
use App\Models\MovieModel;
use App\Models\SeriesModel;


/**
 * Class Import
 * @package App\Controllers\Admin\Ajax
 * @author John Antonio
 */
class Import extends BaseAjax
{
    /**
     * Import status
     * @var string success, failed
     */
    protected $status = 'failed';

    /**
     * Import data type
     * @var string movie, episode, series
     */
    protected $type = 'movie';

    /**
     * Current Imdb Id for import
     * @var string
     */
    protected $imdbId  = '';

    /**
     * Data API (tmdb and omdb handler)
     */
    protected $bulkImport = null;

    /**
     * Import constructor.
     */
    public function __construct()
    {
        $this->helpers[] = 'bulk_import';
        $this->bulkImport = service('bulk_import');
    }


    public function index()
    {
        session_write_close();
        set_time_limit(0);

        if($this->request->getGet('is_alive') == 1){
            ignore_user_abort(true);
        }

        $uniqIds = $this->request->getGet('uniq_ids');
        $type = $this->request->getGet('type');

        if(! empty($uniqIds)){
            $uniqIds = str_replace(' ', '', $uniqIds);
            $uniqIds = explode(',', $uniqIds);
        }

        if(! empty( $uniqIds )){

            $type == 'movies' ? $this->bulkImport->movies() : $this->bulkImport->series();
            $this->bulkImport->set( $uniqIds )->run();_d();

            if($results = $this->bulkImport->getResults()){

                $this->addData( $results );
            }

        }


        return $this->jsonResponse();
    }



}