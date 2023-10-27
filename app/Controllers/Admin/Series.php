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
use App\Entities\Season;
use App\Models\GenreModel;
use App\Models\MovieModel;
use App\Models\SeasonModel;
use CodeIgniter\Model;


class Series extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\SeriesModel();
    }


    public function index()
    {
        $title = 'TV Shows';

        $topBtnGroup = create_top_btn_group([
            'admin/series/new' => 'Add TV Show'
        ]);

        $data = [
            'title' => $title,
            'topBtnGroup' => $topBtnGroup
        ];
        return view('admin/series/list', $data);
    }

    public function new()
    {
        $title = 'New TV Show';
        $series = new \App\Entities\Series();
        $series->imdb_id = $this->request->getGet('imdb');
        $series->tmdb_id = $this->request->getGet('tmdb');

        $topBtnGroup = create_top_btn_group([
            'admin/series' => 'Back to TV Shows'
        ]);

        $genreModel = new GenreModel();
        $genres = $genreModel->asArray()->findAll();

        $data = [
            'title' => $title,
            'series' => $series,
            'genres' => $genres,
            'topBtnGroup' => $topBtnGroup
        ];

        return view('admin/series/new', $data);
    }

    public function edit($id)
    {
        $title = 'Edit TV Show';
        $series = $this->getSeries( $id );

        $isImportAllEpisodes = session()->get('import_all_episodes') == 1;
        if($isImportAllEpisodes) session()->remove('import_all_episodes');

        $topBtnGroup = create_top_btn_group([
            "admin/episodes/new?series_id={$series->id}" => 'Add Episode',
            'admin/series' => 'Back to TV Shows'
        ]);

        $genreModel = new GenreModel();
        $genres = $genreModel->asArray()->findAll();

        $seasonModel = new SeasonModel();
        $seasons = $seasonModel->withEpisodes(false)
                               ->findBySeriesId($id);

        $data = compact('title', 'series', 'genres', 'seasons',
            'topBtnGroup', 'isImportAllEpisodes');
        return view('admin/series/edit', $data);
    }



    public function create()
    {
        $warningAlerts = [];

        if($this->request->getMethod() == 'post') {

            $series = new \App\Entities\Series( $this->request->getPost() );

            if(! is_media_download_to_server()){
                $series->poster = $series->poster_url;
                $series->banner = $series->banner_url;
            }

            if($this->model->insert( $series )) {

                $series = $this->getSeries( $this->model->getInsertID() );

                $this->model->addGenres(
                    $series->id,
                    $this->request->getPost( 'genres' )
                );

                if( is_media_download_to_server() ){
                    $this->saveMediaFiles( $series );
                }

                if($this->validator !== null) {
                    $warningAlerts = $this->validator->getErrors();
                }

                // import all episodes
                if($this->request->getPost('import_all_episodes') !== null){
                    session()->set('import_all_episodes', 1);
                }


                return redirect()->to('/admin/series/edit/' . $series->id )
                                 ->with('warning', $warningAlerts)
                                 ->with('success', 'New TV show created successfully');

            }else{

                return redirect()->back()
                                 ->with('errors', $this->model->errors())
                                 ->withInput();

            }

        }
    }

    public function bulk_delete(): \CodeIgniter\HTTP\ResponseInterface
    {

        $success = false;

        if($this->validate([
            'ids.*' => 'is_natural_no_zero|exist[series.id]'
        ])){

            $ids = $this->request->getPost('ids');
            if($this->model->delete( $ids )){

                $success = true;

            }

        }

        return $this->response->setJSON(['success' => $success]);
    }

    public function update($id)
    {
        $warningAlerts = [];

        if($this->request->getMethod() == 'post') {

            $series = $this->getSeries( $id );
            $updatedData = $this->request->getPost([
                'title',
                'imdb_id',
                'tmdb_id',
                'total_seasons',
                'total_episodes',
                'released_at',
                'country',
                'language',
                'imdb_rate',
                'status'
            ]);

            if(! is_media_download_to_server()){
                if(! empty( $this->request->getPost('poster_url') )){
                    $series->poster = $this->request->getPost('poster_url');
                }
                if(! empty( $this->request->getPost('banner_url') )){
                    $series->banner = $this->request->getPost('banner_url');
                }
            }

            $series->fill( $updatedData );

            if($series->hasChanged()) {

                if(! $this->model->save($series)) {

                    return redirect()->back()
                                     ->with('errors', $this->model->errors())
                                     ->withInput();

                }

            }

            $this->model->addGenres(
                $series->id,
                $this->request->getPost( 'genres' )
            );

            if( is_media_download_to_server() ){
                $this->saveMediaFiles( $series );
            }
            $this->updateSeasonData();

            if($this->validator !== null) {
                $warningAlerts = $this->validator->getErrors();
            }

            return redirect()->back()
                             ->with('warning', $warningAlerts)
                             ->with('success', 'TV show updated successfully');

        }
    }

    public function delete( $id )
    {
        $series = $this->getSeries( $id );

        if($this->model->delete( $series->id )) {
            return redirect()->to('admin/series')
                             ->with('success', "{$series->title} show deleted successfully" );
        }else{
            return redirect()->back()
                             ->with('errors', "{$series->title} show unable to deleted" );
        }

    }

    public function completed($id): \CodeIgniter\HTTP\RedirectResponse
    {
        $isDone = $this->request->getGet('done') == 1;
        $series = $this->getSeries($id);

        if($this->model->completed($series->id, $isDone)){
            $isNot = ! $isDone ? 'not' : '';
            return redirect()->back()
                            ->with('success', "{$series->title} mark as {$isNot} completed successfully" );
        }

        return redirect()->back()
                         ->with('errors', "Something went wrong" );
    }

    protected function updateSeasonData()
    {

        $totalSeaEpisodes = $this->request->getPost('total_season_episodes');

        if(! empty($totalSeaEpisodes) && is_array($totalSeaEpisodes)) {

            $seasonModel = new SeasonModel();

            foreach ($totalSeaEpisodes as $seaId => $seaEpisodes) {
                $season = $seasonModel->where('id', $seaId)
                                      ->first();
                if($season !== null){
                    $season->fill([ 'total_episodes' => $seaEpisodes ]);
                    if($season->hasChanged()){
                        $seasonModel->save($season);
                    }
                }
            }

        }
    }

    protected function saveMediaFiles(\App\Entities\Series $series)
    {
        $imageValidationRules = [];

        $posterFile = $this->request->getFile('poster_file');
        $bannerFile = $this->request->getFile('banner_file');

        $posterUrl = $this->request->getPost('poster_url');
        $bannerUrl = $this->request->getPost('banner_url');

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
            $series->addPoster( $posterFile );
        }

        if($bannerFile !== null){
            //remote old banner file if exist
            $series->addBanner( $bannerFile );
        }


        if($series->hasChanged()) {
            $this->model->protect(false)
                ->save( $series );
        }



    }

    public function load_json_data()
    {
        // Post data
        $postData = $this->request->getPost();

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
        $totalRecords = $this->model->select('id')
            ->countAllResults();

        #02: Total number of records with filtering
        $totalRecordsWithFilter = $this->model->select('id')
            ->groupStart()
            ->orLike('title', $searchValue)
            ->orLike('imdb_id', $searchValue)
            ->orLike('tmdb_id', $searchValue)
            ->groupEnd()
            ->countAllResults();

        #03: Fetch records
        $records = $this->model->groupStart()
            ->orLike('title', $searchValue)
            ->orLike('imdb_id', $searchValue)
            ->orLike('tmdb_id', $searchValue)
            ->groupEnd()
            ->orderBy($columnName,$columnSortOrder)
            ->findAll($rowsPerPage, $start);

        #04: create data list
        $data = [];

        foreach($records as $series ){

            //create poster
            $poster = '<a href="'. $series->getViewLink(true) .'" target="_blank">
                            <img src="'. poster_uri( $series->poster ) .'" height="75" alt="poster">
                        </a>';

            $actions = ' <a href="'. admin_url("/series/edit/{$series->id}") .'" class="btn btn-sm btn-warning">Edit</a>';
            if(is_admin()) {
                $actions .= '<a href="javascript:void(0)" data-url="' . admin_url("/series/delete/{$series->id}") . '" class="btn btn-sm btn-danger del-item">Del</a>';
            }
            $isDone = $series->is_completed ? '<i class="fa fa-check-square"></i>' : '--';

            $data[] = [
                'selection' => '',
                'id'            => $series->id,
                'poster'        => $poster,
                'title'         => $series->title,
                'imdb_id'       => $series->imdb_id,
                'tmdb_id'       => $series->tmdb_id,
                'year'          => $series->year,
                'total_seasons'          => $series->total_seasons,
                'total_episodes'          => $series->total_episodes,
                'is_completed'     => $isDone,
                'created_at'    => format_date_time( $series->created_at ),
                'updated_at'    => format_date_time( $series->updated_at ),
                'status'    => $series->status,
                'actions'       => $actions
            ];

        }

        $title = 'TV Shows - ( ' . $totalRecords . ' )';

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



    protected function getSeries($id) : \App\Entities\Series
    {
        $series = $this->model->where('id', $id)
            ->first();
        if($series == null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invalid series Id ' . $id);
        }
        return $series;
    }

}
