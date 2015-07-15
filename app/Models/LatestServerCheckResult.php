<?php namespace Dodona\Models;

use Dodona\Models\ServerCheckResult;

/**
 * Latest Server Check Result Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * LatestServerCheckResult class.
 *
 * Maps the v_latest_server_check_results view.
 */
class LatestServerCheckResult extends ServerCheckResult
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_latest_server_check_results';
}
