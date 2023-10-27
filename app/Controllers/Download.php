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

namespace App\Controllers;


use App\Libraries\UniqToken;
use App\Models\AdsModel;
use App\Models\LinkModel;
use App\Models\MovieModel;
use CodeIgniter\Model;


class Download extends Embed
{

    public function view( $uniqId, $sea = null, $epi = null )
    {
        // Attempt to view with general id
        if($tmpId = $this->getDirectGeneralId( $uniqId )){
            $uniqId = $tmpId;
            $this->reqUniqIdSource = 'id';
        }


        $title = '';
        $movie = $links = $activeMovie = null;
        $metaKeywords = $metaDescription = '';
        $nextEpisode = $prevEpisode = null;
        $directLinks = $torrentLinks = [];

        if($this->validateInputData( $uniqId, $sea, $epi )){

            $movieModel = new MovieModel();
            $activeMovie = $this->getMovie( $uniqId, $sea, $epi);

            if($activeMovie !== null){

                // Title and Meta data
                $title = '🔗BAIXAR O CONTEÚDO🔗 ' . $activeMovie->getMovieTitle();

                $metaKeywords = create_keywords_list($activeMovie->meta_keywords, $activeMovie->getMovieTitle());
                $metaDescription = $activeMovie->meta_description;


                if(get_config('movie_desc_as_meta') && empty($metaDescription) ) {
                    $metaDescription = substr($activeMovie->description, 0, 160);
                }
                $linkModel = new LinkModel();

                $directLinks = $linkModel->forView()
                                         ->findByMovieId( $activeMovie->id, LinkModel::TYPE_DIRECT_DL, false);

                if(! empty($directLinks))
                    $directLinks = create_links_group( $directLinks );


                $torrentLinks = $linkModel->forView()
                                          ->findByMovieId( $activeMovie->id, LinkModel::TYPE_TORRENT_DL, false);
                if(! empty($torrentLinks))
                    $torrentLinks = create_links_group( $torrentLinks );


                //load next episodes
                if($activeMovie->isEpisode()){

                    if($activeMovie instanceof \App\Entities\Movie){
                        $movieModel = new MovieModel();

                        $nextEpisode = $movieModel->getNextEpisode( $activeMovie );
                        $prevEpisode = $movieModel->getPrevEpisode( $activeMovie );

                    }

                }

            }

        }

        if(! empty($directLinks)){
            $links['directLinks'] = [
                'label' => lang('Download.direct_download_links'),
                'links' => $directLinks
            ];
        }

        if(! empty($torrentLinks)){
            $links['torrentLinks'] = [
                'label' => lang('Download.torrent_download_links'),
                'links' => $torrentLinks
            ];
        }

        //ads codes
        $adsModel = new AdsModel();
        $ads = $adsModel->forView()
                        ->getAds('download');


        $data = compact('activeMovie', 'links','nextEpisode','prevEpisode', 'ads','metaKeywords', 'metaDescription', 'title');




        // cache page
        $this->cacheIt('download');

        return view(theme_path('download'), $data);
    }



}