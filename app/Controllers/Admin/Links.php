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
use App\Models\LinkModel;
use App\Models\MovieModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;


class Links extends BaseController
{

    protected $model;


    public function __construct()
    {
        $this->model = new LinkModel;
    }

    public function users_added( $type )
    {
        $title = 'Users Added Links';

        $status = $this->request->getGet('status');
        $movieType = $this->request->getGet('movie_type');
        $userId = $this->request->getGet('user');

        $user = null;
        if(! empty($userId) && is_numeric($userId)){
            $user = model('UserModel')->where('role !=', UserModel::ROLE_ADMIN)
                                            ->getUser($userId);;
            if($user === null){
                throw new PageNotFoundException();
            }
        }

        $data = compact('title',  'status', 'type', 'userId', 'user', 'movieType');
        return view('admin/links/users_added', $data);
    }

    public function load_link_info()
    {
        $data = [];
        $linkId = $this->request->getGet('link');
        if(! empty($linkId) && is_numeric($linkId)){

            $link = $this->model->join('users', 'users.id = links.user_id')
                                ->where('links.user_id != ', get_admin_id())
                                ->where('links.id ', $linkId)
                                ->select('links.id, links.link, links.status,links.movie_id, 
                                    users.id as user_id, users.username as user')
                                ->groupBy('links.id')
                                ->first();

            if($link !== null){

                $data = $link->toArray();

                $movie = model('MovieModel')->getFullMovie( $link->movie_id );

                if($movie !== null){

                    $mlink = ! $movie->isEpisode() ? admin_url('/movies/edit/' . $movie->id ) : admin_url('/episodes/edit/' . $movie->id );

                    $data['title'] = $movie->getMovieTitle();
                    $data['poster'] = poster_uri( $movie->poster );
                    $data['season'] = $movie->season;
                    $data['episode'] = $movie->episode;
                    $data['movie_type'] = $movie->type;
                    $data['user_link'] = admin_url('/users/edit/' . $data['user_id']);
                    $data['movie_link'] = $mlink;

                }

            }

        }

        if(! empty($data)){
            $resp = [
                'success' => true,
                'data' => $data
            ];
        }else{
            $resp = [
                'success' => false
            ];
        }

        return $this->response->setJSON($resp);
    }

    protected function filterUserAddedCommonData($req = true)
    {
        // link type
        $linkType = $this->request->getGet('type');
        if(! empty($linkType)){
            $this->model->where('links.type', $linkType);
        }

        // link status
        $linkStatus = $this->request->getGet('status');
        if(! empty($linkStatus) && $linkStatus != 'all'){
            $this->model->where('links.status', $linkStatus);
        }


        // user
        $userId = $this->request->getGet('user');
        if(! empty($userId) && is_numeric($userId)){
            $this->model->where('links.user_id', $userId);
        }

        if($req){
            // movies type
            $movieType = $this->request->getGet('movie_type');
            if(! empty($movieType) && $movieType != 'all'){
                $this->model->where('movies.type', $movieType);
            }
        }

    }

    public function load_users_added_links_json_data()
    {
        if(! $this->request->isAJAX()){
//            throw new PageNotFoundException();
        }

        // POST data
        $postData = $this->request->getGet();

        // Custom filters
        $linkType = $this->request->getGet('type');
        $allowedFilters = [LinkModel::TYPE_STREAM, LinkModel::TYPE_DIRECT_DL, LinkModel::TYPE_TORRENT_DL];
        $title = 'Links';
        if(in_array($linkType, $allowedFilters)){
            switch ($linkType) {
                case LinkModel::TYPE_STREAM:
                    $title = 'Stream Links';
                    break;
                case LinkModel::TYPE_DIRECT_DL:
                    $title = 'Direct Links';
                    break;
                default:
                    $title = 'Torrent Links';
                    break;
            }
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
        $this->filterUserAddedCommonData(false);
        $totalRecords = $this->model->select('id')
                                    ->countAllResults();

        #02: Total number of records with filtering
        $this->filterUserAddedCommonData();
        $totalRecordsWithFilter = $this->model->join('users', 'users.id = links.user_id')
                            ->join('movies', 'movies.id = links.movie_id')
                            ->select('links.id')
                            ->where('links.user_id !=', get_admin_id())
                                ->groupStart()
                                    ->orLike('users.username', $searchValue)
                                    ->orLike('links.link', $searchValue)
                                ->groupEnd()
                            ->orderBy('links.id')
                            ->groupBy('links.id')
                            ->countAllResults();


        #03: Fetch records
        $this->filterUserAddedCommonData();
        $records = $this->model->join('users', 'users.id = links.user_id')
                        ->join('movies', 'movies.id = links.movie_id')
                        ->select('links.*, users.username as user, users.id as user_id')
                        ->where('links.user_id !=', get_admin_id())
                            ->groupStart()
                                ->orLike('users.username', $searchValue)
                                ->orLike('links.link', $searchValue)
                            ->groupEnd()
                        ->orderBy($columnName,$columnSortOrder)
                        ->groupBy('links.id')
                        ->findAll($rowsPerPage, $start);

        #04: create data list
        $data = [];

        foreach($records as $link ){

            $actions = '<a href="javascript:void(0)" onclick="show_user_link_info(this)" data-id="' . $link->id . '" class="btn btn-sm btn-info">View More</a>';

            $linkStr = '<a target="_blank" class="cut-text" style="max-width: 200px" href="'. $link->link .'"> '. $link->link .' </a>';
            $userLink = '<a href="'. admin_url('/users/edit/' . $link->user_id) .'"> '. $link->user .' </a>';

            $data[] = [
                'id'            => $link->id,
                'link'          => $linkStr,
                'user'          => $userLink,
                'status'          => format_links_status($link->status),
                'created_at'    => format_date_time( $link->created_at ),
                'actions'       => $actions
            ];

        }

        //page title
        $title .= ' - ( ' . $totalRecords . ' ) <small>Added by users</small>';

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

    public function load_json_data()
    {
        if(! $this->request->isAJAX()){
            throw new PageNotFoundException();
        }

        $title = 'Links';

        // POST data
        $postData = $this->request->getPost();

        // Custom filters
        $filter = $this->request->getGet('filter');
        $allowedFilters = [LinkModel::TYPE_STREAM, LinkModel::TYPE_DIRECT_DL, LinkModel::TYPE_TORRENT_DL];
        $linkType = '';

        if(in_array($filter, $allowedFilters)){
            $linkType = $filter;
            switch ($filter) {
                case LinkModel::TYPE_STREAM:
                    $title = 'Stream Links';
                    break;
                case LinkModel::TYPE_DIRECT_DL:
                    $title = 'Direct Links';
                    break;
                case LinkModel::TYPE_TORRENT_DL:
                    $title = 'Torrent Links';
                    break;
            }
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
        $this->commonDataFilter( $linkType );
        $totalRecords = $this->model->select('id')
                                    ->countAllResults();

        #02: Total number of records with filtering
        $this->commonDataFilter( $linkType );
        $totalRecordsWithFilter = $this->model->select('id')
                                              ->groupStart()
                                                  ->orLike('link', $searchValue)
                                              ->groupEnd()
                                              ->countAllResults();

        #03: Fetch records
        $this->commonDataFilter( $linkType );
        $records = $this->model->groupStart()
                                  ->orLike('link', $searchValue)
                              ->groupEnd()
                              ->orderBy($columnName,$columnSortOrder)
                              ->findAll($rowsPerPage, $start);

        #04: create data list
        $data = [];

        foreach($records as $link ){

            $actions = '<a href="'. admin_url("/links/edit/{$link->id}") .'" class="text-info">Edit</a>';
            $actions .= '<a href="'. admin_url("/movies/edit/{$link->movie_id}") .'" class="text-success ml-2">Movie</a>';
            $actions .= '<a href="javascript:void(0)" class="text-danger ml-2 del-item" data-url="'. admin_url("/links/delete/{$link->id}") .'">Del</a>';

            $linkStr = '<a target="_blank" href="'. $link->link .'"> '. $link->link .' </a>';

            $data[] = [
                'selection' => '',
                'id'            => $link->id,
                'link'          => $linkStr,
                'requests'       => nf( $link->requests ),
                'created_at'    => format_date_time( $link->created_at ),
                'updated_at'    => format_date_time( $link->updated_at ),
                'actions'       => $actions
            ];

        }

        //page title
        $title = 'Links - ( ' . $totalRecords . ' )';

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

    protected function commonDataFilter($linkType)
    {
        if(empty($linkType))
            return;

        $this->model->where('type', $linkType);
    }

    public function index()
    {
        $title = 'Links';

        $filter = $this->request->getGet('filter');
        return view('admin/links/list', compact('title',  'filter'));
    }

    public function reported()
    {
        $title = 'Reported Links';


        $links = $this->model->reported()
                           ->orderBy('reports_not_working', 'DESC')
                           ->orderBy('reports_wrong_link', 'DESC')
                           ->findAll();


        $data = compact('title', 'links');

        return view('admin/links/reported', $data);
    }

    public function edit( $id )
    {

        $title = 'Edit Link';

        $link = $this->getLink( $id );

        $movieModel = new MovieModel();
        $movie = $movieModel->select('title')
                            ->getMovie( $link->movie_id );

        return view('admin/links/edit', compact('title', 'link', 'movie'));
    }


    public function update( $id )
    {
        $link = $this->getLink( $id );

        $link->fill( $this->request->getPost() );

        if($link->hasChanged()){

            if($this->model->save( $link )){

                //if is it reported, remove it
                if($link->countReports() > 0){

                    if( $link->hasChanged('link') ){
                        $this->model->resetReports( $id );
                    }

                    return redirect()->to('/admin/links/reported')
                                     ->with('success', 'Link updated successfully');
                }


                return redirect()->to('/admin/links')
                                 ->with('success', 'Link updated successfully');

            }else{

                return redirect()->back()
                                 ->with('error', $this->model->errors())
                                 ->withInput();

            }

        }

        if($link->countReports() > 0){
            return redirect()->to('/admin/links/reported');
        }

        return redirect()->to('/admin/links');

    }

    public function clear( $id )
    {
        $link = $this->getLink( $id );

        if($link->countReports() > 0){

            if(! $this->model->resetReports( $id )){

                return redirect()->back()
                                 ->with('success', 'link removed from reported list');

            }

        }

        return redirect()->back();
    }

    public function delete( $id )
    {
        $link = $this->getLink( $id );

        if(! $this->model->delete( $link->id )){

            return redirect()->back()
                             ->with('error', $this->model->errors());

        }

        return redirect()->back()
                         ->with('success', 'link deleted successfully');

    }

    public function bulk_delete(): \CodeIgniter\HTTP\ResponseInterface
    {

        $success = false;

        if($this->validate([
            'ids.*' => 'is_natural_no_zero|exist[links.id]'
        ])){

            $ids = $this->request->getPost('ids');
            if($this->model->delete( $ids )){

                $success = true;

            }

        }

        return $this->response->setJSON(['success' => $success]);
    }

    public function update_status( $id ): \CodeIgniter\HTTP\ResponseInterface
    {
        if(! $this->request->isAJAX()){
            throw new PageNotFoundException('Invalid request');
        }

        $success = false;

        $link = $this->getLink( $id );
        $isApproved = $this->request->getGet('is_approved') == 1;

        if( $isApproved ){

            if(! $link->isActive()){

                $success =  $this->model->approved( $link );

            }

        }else{

            if(! $link->isRejected()){

                $success = $this->model->rejected( $link );

            }

        }

        return $this->response->setJSON(['success' => $success]);

    }

    protected function getLink( $id )
    {
        $link = $this->model->where('id', $id)
                            ->first();

        if($link == null){

            throw new PageNotFoundException('link page not found');

        }

        return $link;

    }



}
