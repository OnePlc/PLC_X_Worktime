<?php
/**
 * ApiController.php - Worktime Api Controller
 *
 * Main Controller for Worktime Api
 *
 * @category Controller
 * @package Application
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Worktime\Controller;

use Application\Controller\CoreApiController;
use OnePlace\Worktime\Model\WorktimeTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class ApiController extends CoreApiController {
    protected $sApiName;

    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param WorktimeTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,WorktimeTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'worktime-single';
        $this->sApiName = 'Worktime';
    }
}
