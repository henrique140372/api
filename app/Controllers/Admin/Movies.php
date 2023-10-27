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

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Movie;
use App\Models\GenreModel;
use App\Models\LinkModel;
use App\Models\Translations\MovieTranslationsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;


class Movies extends BaseController
{

    protected $model;
    protected $translation;

    public function __construct()
    {
        $this->model = new \App\Models\MovieModel();

        if(get_config('is_multi_lang')) {
            $this->translation = new MovieTranslationsModel();
        }

    }

    public function index()
    {


        $type = class_basename($this) != 'Episodes' ? 'movie' : 'episode';
        $isMovie = $type == 'movie';

        $title = $isMovie ? 'Movies' : 'Episodes';

        $filter = $this->request->getGet('filter');
        $allowedFilters = [
            'with_st_links',
            'without_st_links',
            'with_dl_links',
            'without_dl_links'
        ];

        if(in_array($filter, $allowedFilters)){

            $linkType = '';

            if($filter == 'with_st_links' || $filter == 'without_st_links')
                $linkType = 'stream';

            if($filter == 'with_dl_links' || $filter == 'without_dl_links')
                $linkType = 'download';

            if($filter == 'with_st_links' || $filter == 'with_dl_links')
                $this->model->notEmptyLinks( $linkType );

            if($filter == 'without_st_links' || $filter == 'without_dl_links')
                $this->model->emptyLinks( $linkType );

        }

        $movies = [];



        if( $isMovie ){

            $topBtnGroup = create_top_btn_group([
                'admin/movies/new' => 'Add Movie'
            ]);

        }else{

            $topBtnGroup = create_top_btn_group([
                'admin/episodes/new' => 'Add Episode'
            ]);

        }

        $title .= ' - ( ' . count( $movies ) . ' )';

        $data = [
            'title' => $title,
            'movies' => $movies,
            'filter' => $filter,
            'topBtnGroup' => $topBtnGroup,
            'isMovie' => $isMovie
        ];

       
        return view('admin/movies/list', $data);
    }

    public function new()
    {
        $title = 'New Movie';
        $translations = null;

        $topBtnGroup = create_top_btn_group([
            'admin/movies' => 'Back to movies'
        ]);

        $genreModel = new GenreModel();
        $genres = $genreModel->asArray()->findAll();

        $movie = new Movie();
        $movie->imdb_id = $this->request->getGet('imdb');
        $movie->tmdb_id = $this->request->getGet('tmdb');
        $movie->type = 'movie';

        if( is_multi_languages_enabled() ){

            //Translations
            $translations = $this->translation->getDummyList();

        }

        $data = compact('title', 'movie', 'genres', 'translations', 'topBtnGroup');
        return view('admin/movies/new', $data);
    }

    public function edit($id)
    {

        $movie = $this->getMovie($id);
        $title = $movie->getMovieTitle();

        $translations = null;

        if($movie->isEpisode()) {
            return redirect()->to("/admin/episodes/edit/{$id}");
        }

        $nextMovie = $this->model->getNextMovie( $id );


        $genreModel = new GenreModel();
        $genres = $genreModel->asArray()->findAll();

        $linkModel = new LinkModel();
        $directDownloadLinks = $linkModel->findByMovieId( $id, LinkModel::TYPE_DIRECT_DL);
        $torrentDownloadLinks = $linkModel->findByMovieId( $id, LinkModel::TYPE_TORRENT_DL);
        $streamLinks = $linkModel->orderBy('quality')
                                 ->findByMovieId( $id, LinkModel::TYPE_STREAM );

       if( is_multi_languages_enabled() ){

           //Translations
           $translations = $this->translation->findByMovieId( $id );

       }


        $topBtnGroup = create_top_btn_group([
            'admin/movies/new' => 'New Movie',
            'admin/movies' => 'Back to Movies'
        ]);

//       dd($movie->getCustomSlug());

        $data = compact('title', 'movie', 'nextMovie', 'genres', 'directDownloadLinks', 'torrentDownloadLinks',
            'streamLinks', 'translations', 'topBtnGroup');

        return view('admin/movies/edit', $data);
    }

    public function create()
    {
        $warningAlerts = [];

        if($this->request->getMethod() == 'post'){
            //create movie entity
            $movie = new Movie( $this->request->getPost() );

            if(! is_media_download_to_server()){
                $movie->poster = $movie->poster_url;
                $movie->banner = $movie->banner_url;
            }


            //attempt to save data
            if($this->model->saveMovie( $movie )) {
                $movie = $this->getMovie( $this->model->getInsertID() );

                //add genres
                $this->model->addGenres(
                    $movie->id,
                    $this->request->getPost( 'genres' )
                );

                //add translations
                if( is_multi_languages_enabled() ){

                    $this->model->addTranslations(
                        $movie->id,
                        $this->request->getPost( 'translations' )
                    );

                }

                //save media files
                $this->saveMediaFiles( $movie );
                if( is_media_download_to_server() ){
                    $this->saveRemoteMediaFiles( $movie );
                }

                //save links
                $this->saveLinks( $movie );

                if($this->validator !== null) {
                    $warningAlerts = $this->validator->getErrors();
                }

                return redirect()->to('/admin/movies/edit/' . $movie->id)
                                 ->with('warning', $warningAlerts)
                                 ->with('success', 'movie saved successfully');

            }else{
                return redirect()->back()
                                 ->with('errors', $this->model->errors())
                                 ->withInput();
            }
        }
    }

    public function update( $id )
    {
        if($this->request->getMethod() == 'post') {
            $movie = $this->getMovie($id);
            $updatedData = $this->request->getPost([
                'title',
                'description',
                'imdb_id',
                'tmdb_id',
                'duration',
                'series_id',
                'season',
                'imdb_rate',
                'quality',
                'episode',
                'released_at',
                'trailer',
                'country',
                'language',
                'meta_keywords',
                'meta_description',
                'status'
            ]);

            if(! is_media_download_to_server()){
                if(! empty( $this->request->getPost('poster_url') )){
                    $movie->poster = $this->request->getPost('poster_url');
                }
                if(! empty( $this->request->getPost('banner_url') )){
                    $movie->banner = $this->request->getPost('banner_url');
                }
            }

            $movie->fill( $updatedData );

            //attempt to save movie
            if(! $this->model->saveMovie($movie)) {
                return redirect()->back()
                    ->with('errors', $this->model->errors())
                    ->withInput();
            }

            //add or update genres
            $this->model->addGenres(
                $movie->id,
                $this->request->getPost( 'genres' )
            );

            // save translations
            if( is_multi_languages_enabled() ){

                $this->model->addTranslations(
                    $movie->id,
                    $this->request->getPost( 'translations' )
                );

            }

            // save media files
            $this->saveMediaFiles( $movie );
            if(is_media_download_to_server()){
                $this->saveRemoteMediaFiles( $movie );
            }

            // save links
            $this->saveLinks( $movie );

            $warningAlerts = $this->validator !== null ? $this->validator->getErrors() : [];

            return redirect()->back()
                             ->with('warning', $warningAlerts)
                             ->with('success', 'Movie updated successfully.');
        }
    }

    public function delete( $id )
    {
        $movie = $this->getMovie( $id );

        if($this->model->delete( $movie->id )) {

            $redirect = $movie->isEpisode() ? '/episodes' : '/movies';

            return redirect()->to("/admin/{$redirect}")
                             ->with('success', "{$movie->title} movie deleted successfully" );
        }else{
            return redirect()->back()
                ->with('errors', "{$movie->title} movie unable to deleted" );
        }

    }

    public function bulk_delete(): \CodeIgniter\HTTP\ResponseInterface
    {

        $success = false;

        if($this->validate([
            'ids.*' => 'is_natural_no_zero|exist[movies.id]'
        ])){

            $ids = $this->request->getPost('ids');
            if($this->model->delete( $ids )){

                $success = true;

            }

        }

        return $this->response->setJSON(['success' => $success]);
    }


    protected function saveMediaFiles(\App\Entities\Movie $movie)
    {
        $imageValidationRules = [];

        $posterFile = $this->request->getFile('poster_file');
        $bannerFile = $this->request->getFile('banner_file');

        if(! $posterFile->isValid()) $posterFile = null;
        if(! $bannerFile->isValid()) $bannerFile = null;

        if($posterFile !== null) {
            $imageValidationRules['poster_file'] = [
                'label' => 'poster image',
                'rules' => 'uploaded[poster_file]'
                    . '|is_image[poster_file]'
                    . '|mime_in[poster_file,image/jpg,image/jpeg,image/png]'
                    . '|max_size[poster_file,2048]'
            ];
        }

        if($bannerFile !== null) {
            $imageValidationRules['banner_file'] =[
                'label' => 'banner image',
                'rules' => 'uploaded[banner_file]'
                    . '|is_image[banner_file]'
                    . '|mime_in[banner_file,image/jpg,image/jpeg,image/png]'
                    . '|max_size[banner_file,4096]'
            ];
        }

        if(! empty($imageValidationRules) ) {

            $this->validate( $imageValidationRules );

            if($this->validator->hasError('poster_file'))
                $posterFile = null;

            if($this->validator->hasError('banner_file'))
                $bannerFile = null;

        }

        if($posterFile !== null){
            //remote old poster file if exist
            $movie->addPoster( $posterFile );
        }

        if($bannerFile !== null){
            //remote old banner file if exist
            $movie->addBanner( $bannerFile );
        }

        if($movie->hasChanged()) {
            $this->model->save($movie);
        }

    }

    protected function saveRemoteMediaFiles(\App\Entities\Movie $movie)
    {
        $imageValidationRules = [];

        $posterUrl = $this->request->getPost('poster_url');
        $bannerUrl = $this->request->getPost('banner_url');

        $posterFile = $bannerFile = null;

        if(! empty($posterUrl)){
            helper('remote_download');
            if($filepath =  download_image( $posterUrl)){
                $posterFile = new \CodeIgniter\Files\File( $filepath );
            }
        }

        if(! empty($bannerUrl)){
            helper('remote_download');
            if($filepath =  download_image( $bannerUrl )){
                $bannerFile = new \CodeIgniter\Files\File( $filepath );
            }
        }


        if($posterFile !== null){
            //remote old poster file if exist
            $movie->addPoster( $posterFile );
        }

        if($bannerFile !== null){
            //remote old banner file if exist
            $movie->addBanner( $bannerFile );
        }


        if($movie->hasChanged()) {
            $this->model->save($movie);
        }

    }

    protected function saveLinks(\App\Entities\Movie $movie)
    {

        $streamLinks = $this->request->getPost('st_links');
        $this->model->addLinks($movie->id, $streamLinks, LinkModel::TYPE_STREAM);

        $directDlLinks = $this->request->getPost('direct_dl_links');
        $this->model->addLinks($movie->id, $directDlLinks, LinkModel::TYPE_DIRECT_DL);

        $torrentDlLinks = $this->request->getPost('torrent_dl_links');
        $this->model->addLinks($movie->id, $torrentDlLinks, LinkModel::TYPE_TORRENT_DL);

    }

    protected function getMovie($id) : \App\Entities\Movie
    {
        $movie = $this->model->getMovie($id);
        if($movie == null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invalid movie Id ' . $id);
        }
        return $movie;
    }

    public function load_json_data(): \CodeIgniter\HTTP\ResponseInterface
    {
        if(! $this->request->isAJAX()){
            throw new PageNotFoundException();
        }

        $type = class_basename($this) != 'Episodes' ? 'movie' : 'episode';
        $isMovie = $type == 'movie';

        $title = $isMovie ? 'Movies' : 'Episodes';
        $postData = $this->request->getPost();

        $filter = $postData['filter'] ?? '';
        $allowedFilters = [
            'with_st_links',
            'without_st_links',
            'with_dl_links',
            'without_dl_links'
        ];

        //Check general filter
        if(! in_array($filter, $allowedFilters)){
            $filter = '';
        }

        //Datatables requested val
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowsPerPage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnName = strtolower(str_replace(' ', '_', $columnName));
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        #01: Total number of records without filtering
        $this->commonDataFilter( $filter );
        $totalRecords = $this->model->select('id')
                                    ->where('type', $type)
                                    ->countAllResults();

        #02: Total number of records with filtering
        $this->commonDataFilter( $filter );
        $totalRecordsWithFilter = $this->model->select('id')
            ->where('type', $type)
            ->groupStart()
            ->orLike('title', $searchValue)
            ->orLike('imdb_id', $searchValue)
            ->orLike('tmdb_id', $searchValue)
            ->groupEnd()
            ->countAllResults();

        #03: Fetch records
        $this->commonDataFilter( $filter );
        $records = $this->model->join('visitors', 'visitors.movie_id = movies.id', 'LEFT')
                               ->select('movies.*, SUM(visitors.views) as views')
                               ->where('type', $type)
                               ->groupStart()
                                   ->orLike('title', $searchValue)
                                   ->orLike('imdb_id', $searchValue)
                                   ->orLike('tmdb_id', $searchValue)
                               ->groupEnd()
                               ->groupBy('movies.id')
                               ->orderBy($columnName,$columnSortOrder)
                               ->findAll($rowsPerPage, $start);

        #04: create data list
        $data = [];

        foreach($records as $movie ){

            //create poster
            $poster = '<a href="'. $movie->getViewLink(true) .'" target="_blank">
                            <img src="'. poster_uri( $movie->poster ) .'" height="75" alt="poster">
                        </a>';

            $actions = '';
            if(is_admin()){
                $actions = '<a href="'. admin_url("/statistics/views?movie={$movie->id}") .'" class="btn btn-sm btn-info"><i class="fa fa-line-chart"></i></a>';
            }
            $actions .= ' <a href="'. admin_url("/movies/edit/{$movie->id}") .'" class="btn btn-sm btn-warning text-dark"><i class="fa fa-pencil"></i></a>';
            if(is_admin()){
                $actions .= '<a href="javascript:void(0)" data-url="'. admin_url("/movies/delete/{$movie->id}") .'" class="btn btn-sm btn-danger del-item"><i class="fa fa-trash"></i></a>';
            }

            $titleHtml = anchor($movie->getViewLink(true), $movie->title, ['target'=>'_blank']);

            $data[] = [
                'selection' => '',
                'id'            => $movie->id,
                'poster'        => $poster,
                'title'         => $titleHtml,
                'imdb_id'       => $movie->imdb_id,
                'tmdb_id'       => $movie->tmdb_id,
                'year'          => $movie->year,
                'imdb_rate'     => $movie->imdb_rate,
                'views'         => nf( (int) $movie->views ),
                'created_at'    => format_date_time( $movie->created_at ),
                'updated_at'    => format_date_time( $movie->updated_at ),
                'actions'       => $actions
            ];

        }

        //page title
        $title = $isMovie ? 'Movies' : 'Episodes';
        $title .= ' - ( ' . $totalRecords . ' )';

        #05: Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data,
            'page_title' => $title
        );

        return $this->response->setJSON( $response );
    }

    protected function commonDataFilter($filter)
    {
        if(empty($filter))
            return;

        $linkType = '';
        if($filter == 'with_st_links' || $filter == 'without_st_links')
            $linkType = 'stream';

        if($filter == 'with_dl_links' || $filter == 'without_dl_links')
            $linkType = 'download';

        if($filter == 'with_st_links' || $filter == 'with_dl_links')
            $this->model->notEmptyLinks( $linkType );

        if($filter == 'without_st_links' || $filter == 'without_dl_links')
            $this->model->emptyLinks( $linkType );


    }


}
