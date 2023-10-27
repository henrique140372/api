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

use App\Controllers\BaseController;
use App\Models\SettingsModel;


class BaseSettings extends BaseController
{

    /**
     * @var SettingsModel
     */
    protected $model;


    public function __construct()
    {
        $this->model = new SettingsModel();
    }

    protected function save(array $data ): \CodeIgniter\HTTP\RedirectResponse
    {

        foreach ($data as $name => $val) {

            $config = $this->model->getConfig( $name );
            if($config === null)
                continue;

            $config->fill( ['value' => $val] );

            if($config->hasChanged()){

                $this->model->update($name, ['value' => $val]);

            }

        }

        return redirect()->back()
            ->with('errors', $this->validator !== null ? $this->validator->getErrors() : '')
            ->with('success', 'Application settings updated successfully');

    }

}