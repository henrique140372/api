<?php

if(! function_exists('get_formatted_user_status_badges'))
{
    function get_formatted_user_status_badges( $status ): string
    {
        $badge = '';
        switch ( $status ) {
            case \App\Models\UserModel::STATUS_ACTIVE:
                $badge = '<span class="badge badge-success">Active</span>';
                break;
            case \App\Models\UserModel::STATUS_PENDING:
                $badge = '<span class="badge badge-warning">Pending</span>';
                break;
            case \App\Models\UserModel::STATUS_BLOCKED:
                $badge = '<span class="badge badge-danger">Blocked</span>';
                break;
        }

        return $badge;
    }
}

if(! function_exists('get_formatted_admin_approval_icon'))
{
    function get_formatted_admin_approval_icon( $isApproved, $status ): string
    {
        $txt = 'not required';
        $type = 'secondary';

        if( is_user_admin_approval_enabled() ){

            $txt = $isApproved ? 'approved' : 'not approved';
            $type  = $isApproved ? 'success' : 'danger';
            if( ! $isApproved && $status != \App\Models\UserModel::STATUS_BLOCKED){

                $txt = 'pending';
                $type = 'warning';

            }

        }


        return '<span class="lead text-'.$type.'"'.' data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$txt.'"> <i class="fa fa-dot-circle-o"></i> </span>';
    }
}

if(! function_exists('get_formatted_email_approval_icon'))
{
    function get_formatted_email_approval_icon( $isVerified ): string
    {
        $txt = 'not required';
        $type = 'secondary';

        if( is_user_email_verification_enabled() ){

            $txt = $isVerified ? 'verified' : 'not verified';
            $type  = $isVerified ? 'success' : 'warning';

        }

        return '<span class="lead text-'.$type.'"'.' data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$txt.'"> <i class="fa fa-dot-circle-o"></i> </span>';
    }
}

if(! function_exists('get_formatted_user_role_text'))
{
    function get_formatted_user_role_text( $role ): string
    {
        $txt = 'info';
        if($role != \App\Models\UserModel::ROLE_USER){
            $txt = 'danger';
        }

        return '<span class="text-'.$txt.'">'. strtoupper($role) .'</span>';
    }
}


if(! function_exists('get_formatted_payout_status_badges'))
{
    function get_formatted_payout_status_badges( $status ): string
    {
        $badge = '';
        switch ( $status ) {
            case \App\Models\PayoutsModel::STATUS_COMPLETED:
                $badge = '<span class="badge badge-success">Completed</span>';
                break;
            case \App\Models\PayoutsModel::STATUS_PENDING:
                $badge = '<span class="badge badge-warning">Pending</span>';
                break;
            case \App\Models\PayoutsModel::STATUS_REJECTED:
                $badge = '<span class="badge badge-danger">Rejected</span>';
                break;
        }

        return $badge;
    }
}

if(! function_exists('get_formatted_stars_status'))
{
    function get_formatted_stars_status( $status, $ucwords = false )
    {
        switch ($status) {
            case \App\Models\EarningsModel::STATUS_CREDITED:
                $class = 'text-success';
                break;
            case \App\Models\EarningsModel::STATUS_PENDING:
                $class = 'text-warning';
                break;
            case \App\Models\EarningsModel::STATUS_REJECTED:
                $class = 'text-danger';
                break;
            default:
                $class = 'text-primary';
                break;
        }
        if($ucwords) $status = ucwords($status);
        return '<span class="'. $class .'">'. $status .'</span>';
    }
}