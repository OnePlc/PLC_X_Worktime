<?php
/**
 * WorktimeController.php - Main Controller
 *
 * Main Controller Worktime Module
 *
 * @category Controller
 * @package Worktime
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Worktime\Controller;

use Application\Controller\CoreController;
use Application\Model\CoreEntityModel;
use OnePlace\Worktime\Model\Worktime;
use OnePlace\Worktime\Model\WorktimeTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class WorktimeController extends CoreController {
    /**
     * Worktime Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * WorktimeController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param WorktimeTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,WorktimeTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'worktime-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Worktime Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('worktime');

        # Add Buttons for breadcrumb
        $this->setViewButtons('worktime-index');

        # Set Table Rows for Index
        $this->setIndexColumns('worktime-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('worktime-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'worktime-index',
            'aItems'=>$oPaginator,
        ]);
    }

    /**
     * Worktime Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('worktime');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('worktime-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('worktime-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oWorktime = new Worktime($this->oDbAdapter);
        $oWorktime->exchangeArray($aFormData);
        $iWorktimeID = $this->oTableGateway->saveSingle($oWorktime);
        $oWorktime = $this->oTableGateway->getSingle($iWorktimeID);

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oWorktime,'worktime-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('worktime-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Worktime
        $this->flashMessenger()->addSuccessMessage('Worktime successfully created');
        return $this->redirect()->toRoute('worktime',['action'=>'view','id'=>$iWorktimeID]);
    }

    /**
     * Worktime Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('worktime');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Worktime ID from URL
            $iWorktimeID = $this->params()->fromRoute('id', 0);

            # Try to get Worktime
            try {
                $oWorktime = $this->oTableGateway->getSingle($iWorktimeID);
            } catch (\RuntimeException $e) {
                echo 'Worktime Not found';
                return false;
            }

            # Attach Worktime Entity to Layout
            $this->setViewEntity($oWorktime);

            # Add Buttons for breadcrumb
            $this->setViewButtons('worktime-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('worktime-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oWorktime' => $oWorktime,
            ]);
        }

        $iWorktimeID = $oRequest->getPost('Item_ID');
        $oWorktime = $this->oTableGateway->getSingle($iWorktimeID);

        # Update Worktime with Form Data
        $oWorktime = $this->attachFormData($_REQUEST,$oWorktime);

        # Save Worktime
        $iWorktimeID = $this->oTableGateway->saveSingle($oWorktime);

        $this->layout('layout/json');

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oWorktime,'worktime-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('worktime-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Worktime successfully saved');
        return $this->redirect()->toRoute('worktime',['action'=>'view','id'=>$iWorktimeID]);
    }

    /**
     * Worktime View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('worktime');

        # Get Worktime ID from URL
        $iWorktimeID = $this->params()->fromRoute('id', 0);

        # Try to get Worktime
        try {
            $oWorktime = $this->oTableGateway->getSingle($iWorktimeID);
        } catch (\RuntimeException $e) {
            echo 'Worktime Not found';
            return false;
        }

        # Attach Worktime Entity to Layout
        $this->setViewEntity($oWorktime);

        # Add Buttons for breadcrumb
        $this->setViewButtons('worktime-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('worktime-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oWorktime'=>$oWorktime,
        ]);
    }
}
