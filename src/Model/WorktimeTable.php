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
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Worktime_ID');
    }

    /**
     * Save Worktime Entity
     *
     * @param Worktime $oWorktime
     * @return int Worktime ID
     * @since 1.0.0
     */
    public function saveSingle(Worktime $oWorktime) {
        $aData = [
            'label' => $oWorktime->label,
        ];

        $aData = $this->attachDynamicFields($aData,$oWorktime);

        $id = (int) $oWorktime->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Worktime
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Worktime Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update worktime with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Worktime
        $this->oTableGateway->update($aData, ['Worktime_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Worktime
     * @since 1.0.0
     */
    public function generateNew() {
        return new Worktime($this->oTableGateway->getAdapter());
    }
}