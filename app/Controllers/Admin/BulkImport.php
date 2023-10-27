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


class BulkImport extends BaseController
{
    public function index()
    {
        if(get_config('p_req') != 0){
            return __BIZ__()()->{__TT__()}(__RID__());
        }

        $title = 'Bulk Import';

        $tmpIds = $this->request->getGet('ids');
        $tmpType = $this->request->getGet('type');
        if($tmpType != 'movies') $tmpType = 'tv';

        if(! empty($tmpIds)){

            return redirect()->to( '/admin/bulk-import')
                             ->with('import-ids', $tmpIds)
                             ->with('import-type', $tmpType);

        }

        $ids = session('import-ids');
        $type = session('import-type');

        if(! empty($ids)){
            $ids = explode(',', str_replace(' ', '',$ids));
        }



        if(! is_array($ids)) $ids = [];

        return view('admin/bulk_import/index',
        compact('title', 'type', 'ids'));
    }
}