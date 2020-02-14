<?php
/**
 * WorktimeTable.php - Worktime Table
 *
 * Table Model for Worktime
 *
 * @category Model
 * @package Worktime
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Worktime\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class WorktimeTable extends CoreEntityTable {

    /**
     * WorktimeTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'worktime-single';
    }

    /**
     * Get Worktime Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'Worktime_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save Worktime Entity
     *
     * @param Worktime $oWorktime
     * @return int Worktime ID
     * @since 1.0.0
     */
    public function saveSingle(Worktime $oWorktime) {
        $aDefaultData = [
            'label' => $oWorktime->label,
        ];

        return $this->saveSingleEntity($oWorktime,'Worktime_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Worktime
     * @since 1.0.1
     */
    public function generateNew() {
        return new Worktime($this->oTableGateway->getAdapter());
    }
}