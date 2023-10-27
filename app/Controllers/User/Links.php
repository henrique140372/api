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

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EarningsModel;
use App\Models\LinkModel;
use App\Models\MovieModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class Links extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new LinkModel();
    }

    public function all_links()
    {
        $title = 'Links';

        $type = $this->request->getGet('type');
        $type = LinkModel::isValidType( $type ) ? $type : 'all';

        $status = $this->request->getGet('status');
        $status = LinkModel::isValidStatus( $status ) ? $status : 'all';

        // Filter by type
        if($type !== 'all'){
            $this->model->where('type', $type);
        }

        // Filter by status
        if($status !== 'all'){
            $this->model->where('status', $status);
        }

        $links = $this->model->_user( get_current_user_id() )
                             ->orderBy('id', 'DESC')
                             ->find();


        $data = compact('title', 'links', 'type', 'status');

        return view(theme_path('user/links/my_links'), $data);
    }

    public function redirect(): \CodeIgniter\HTTP\RedirectResponse
    {
        $movieId = $this->request->getGet('id');
        if($movieId = decode_id( $movieId )){

            $movie = model('MovieModel')->getMovie( $movieId );
            if($movie !== null){

                return redirect()->to('/user/links/add/' . encode_id( $movie->id ));

            }

        }

      throw new PageNotFoundException('Invalid movie id');
    }

    public function add( $id )
    {
        $title = 'Add Link';
        $movie = $this->getMovie( $id );

        $streamLinks = $this->model->_user( get_current_user_id() )
                                 ->findByMovieId( $movie->id, LinkModel::TYPE_STREAM );

        $directDownloadLinks = $this->model->_user( get_current_user_id() )
                                         ->findByMovieId( $movie->id, LinkModel::TYPE_DIRECT_DL );

        $torrentDownloadLinks = $this->model->_user( get_current_user_id() )
                                          ->findByMovieId( $movie->id, LinkModel::TYPE_TORRENT_DL );

        // check rewards module has been enabled

        //stream module
        $streamType = ! $movie->isEpisode() ? EarningsModel::TYPE_MOVIE_STREAM_LINK : EarningsModel::TYPE_EPISODE_STREAM_LINK;
        $isStreamRewardsEnabled = EarningsModel::isRewardTypeEnabled( $streamType );

        //direct dl links module
        $directDlType = ! $movie->isEpisode() ? EarningsModel::TYPE_MOVIE_DIRECT_LINK : EarningsModel::TYPE_EPISODE_DIRECT_LINK;
        $isDirectDlRewardsEnabled = EarningsModel::isRewardTypeEnabled( $directDlType );

        //torrent dl links module
        $torrentDlType = ! $movie->isEpisode() ? EarningsModel::TYPE_MOVIE_TORRENT_LINK : EarningsModel::TYPE_EPISODE_TORRENT_LINK;
        $isTorrentDlRewardsEnabled = EarningsModel::isRewardTypeEnabled( $torrentDlType );


        $data =  compact('title', 'movie', 'streamLinks', 'directDownloadLinks',
            'torrentDownloadLinks', 'isStreamRewardsEnabled', 'isDirectDlRewardsEnabled', 'isTorrentDlRewardsEnabled');
        return view(theme_path('user/links/new'), $data);
    }

    public function create( $id )
    {

        if($this->request->getMethod() !== 'post'){
            throw new PageNotFoundException();
        }


        $movieModel = new MovieModel();
        $movie = $this->getMovie( $id );

        $streamLinks = $this->request->getPost('st_links');
        if(! empty($streamLinks) && is_array($streamLinks)){
            if(count($streamLinks) > get_max_steaming_links_per_user()){
                $streamLinks = array_slice($streamLinks, 0,get_max_steaming_links_per_user());
            }
            $movieModel->addLinks($movie->id, $streamLinks, LinkModel::TYPE_STREAM);
        }

        $directDlLinks = $this->request->getPost('direct_dl_links');
        if(! empty($directDlLinks) && is_array($directDlLinks)){
            if(count($directDlLinks) > get_max_download_links_per_user()){
                $directDlLinks = array_slice($directDlLinks, 0,get_max_download_links_per_user());
            }
            $movieModel->addLinks($movie->id, $directDlLinks, LinkModel::TYPE_DIRECT_DL);
        }

        $torrentDlLinks = $this->request->getPost('torrent_dl_links');
        if(! empty($torrentDlLinks) && is_array($torrentDlLinks)){
            if(count($torrentDlLinks) > get_max_torrent_links_per_user()){
                $torrentDlLinks = array_slice($torrentDlLinks, 0,get_max_torrent_links_per_user());
            }
            $movieModel->addLinks($movie->id, $torrentDlLinks, LinkModel::TYPE_TORRENT_DL);
        }

        return redirect()->back();

    }

    protected function getMovie( $id )
    {
        $movie = null;
        $movieModel = new MovieModel();
        if($id = decode_id( $id )){
            $movie = $movieModel->getMovie( $id );

            if($movie !== null){

                $uniqId = ! empty($movie->imdb_id) ? $movie->imdb_id : $movie->tmdb_id;
                if(! empty($uniqId)){
                    $movie = $movieModel->getMovieByUniqId( $uniqId );
                }

            }
        }

        if($movie === null){
            //create new movie
            throw new PageNotFoundException('Movie not found');
        }

        return $movie;
    }

}
