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

namespace App\Models;


use App\Entities\Translation;
use App\Models\Translations\PageTranslationsModel;
use CodeIgniter\Model;

/**
 * Class Pages
 * @package App\Models
 * @author John Antonio
 */
class CronQueryModel extends Model
{
    protected $table            = 'cron_query';

    public const STATUS_IMPORTED = 'imported';
    public const STATUS_FAILED = 'failed';
    public const STATUS_PENDING = 'pending';




}
