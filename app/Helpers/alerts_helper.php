<?php

if(! function_exists( 'displayAlerts' ))
{
    function displayAlerts()
    {
        $alerts = get_alerts();
        $alertsHtml = '';

        if(! empty($alerts)){
            foreach ($alerts as $type => $val) {
                if(is_array($val)){
                    $i = 0;
                    foreach ($val as $alert ) {
                        //max alerts 4 - from each alert group
                        if($i > 3) break;

                        $alertHtml = '<div class="alert alert-'. $type .' alert-dismissible mb-2" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>';
                        $alertHtml .= $alert;
                        $alertHtml .= '</div>';
                        $alertsHtml .= $alertHtml;

                        $i++;

                    }
                }
            }
        }

        echo $alertsHtml;

    }
}

if(! function_exists( 'get_alerts' )) {
    function get_alerts(): array
    {
        $alerts = [];

        //danger alerts
        if(session()->has('errors')) {
            $errors = session('errors');
            if(!empty($errors)){
                $alerts['danger'] = is_array($errors) ? $errors : [ $errors ];
            }
        }

        //warning alerts
        if(session()->has('warning')) {
            $warnings = session('warning');
            if(!empty($warnings)){
                $alerts['warning'] = is_array($warnings) ? $warnings : [ $warnings ];
            }
        }

        //info alerts
        if(session()->has('info')) {
            $info = session('info');
            if(!empty($info)){
                $alerts['info'] = is_array($info) ? $info : [ $info ];
            }
        }

        //success alerts
        if(session()->has('success')) {
            $success = session('success');
            if(!empty($success)){
                $alerts['success'] = is_array($success) ? $success : [ $success ];
            }
        }

        return $alerts;

    }
}
