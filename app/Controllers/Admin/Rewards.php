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
use App\Entities\RefReward;
use App\Models\RefRewardsModel;
use App\Models\SettingsModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Rewards extends BaseController
{

    protected $model;

    public function __construct()
    {
        helper('countries');
        $this->model = new RefRewardsModel();
    }

    public function general()
    {
        $title = 'Rewards';

        return view('admin/rewards/general', compact('title'));
    }

    public function referrals()
    {
        $title = 'Rewards for Referrals';

        $topBtnGroup = create_top_btn_group([
            'admin/rewards/ref_reward' => 'Add Ref Reward'
        ]);

        $rewards = $this->model->orderBy('stars_per_view', 'desc')
                              ->findAll();

        $data = compact('title', 'rewards', 'topBtnGroup');
        return view('admin/rewards/referrals', $data);
    }

    public function update_gen_rewards()
    {
        $data = $this->request->getPost();

        $settingsModel = new SettingsModel();

        foreach ($data as $name => $val) {

            $config = $settingsModel->getConfig( $name );
            if($config === null)
                continue;

            if(! is_numeric($val) || $val < 0) {
                continue;
            }

            $config->fill( ['value' => $val] );

            if($config->hasChanged()){

                $settingsModel->update($name, ['value' => $val]);

            }

        }

        return redirect()->back()
                         ->with('success','Rewards has been successfully updated');
    }

    public function ref_reward( $id = null )
    {
        $title = 'Add Reward for Referrals';
        $topBtnGroup = create_top_btn_group([
            'admin/rewards/referrals' => 'Back to Ref Rewards'
        ]);

        $reward = ! empty($id) ? $this->getRefReward( $id ) : new RefReward();

        $data = compact('title', 'reward', 'topBtnGroup');
        return view('admin/rewards/ref_reward', $data);
    }

    public function del_ref_reward( $id ): \CodeIgniter\HTTP\RedirectResponse
    {
        $reward = $this->getRefReward( $id );
        if($this->model->delete( $reward->id )){

            return redirect()->back()
                             ->with('success', 'Ref reward has been deleted successfully');

        }

        return redirect()->back()
                         ->with('errors', 'Unable to delete');
    }

    public function save_ref_reward( $id = null )
    {
        $refReward = ! empty( $id ) ? $this->getRefReward( $id ) : new RefReward();
        $refReward->fill( $this->request->getPost() );

        if($refReward->hasChanged()){

            if($this->model->save( $refReward )){

                return redirect()->to('/admin/rewards/referrals')
                                 ->with('success', 'Reward has been successfully saved');


            }

            return redirect()->back()
                             ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/rewards/referrals');
    }


    protected function getRefReward( $id )
    {
        $reward = $this->model->where('id', $id)
                              ->first();

        if($reward === null){

            throw new PageNotFoundException('Ref Reward not found');

        }

        return $reward;
    }

}
