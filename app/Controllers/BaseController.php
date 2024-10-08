<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use App\Libraries\Permission;
use CodeIgniter\HTTP\CLIRequest;
use App\Models\NotificationModel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    public $view  = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $permission = new Permission();
        $this->view = $permission->HeaderMenuItems();//echo __LINE__.'<pre>';print_r($this->view);die;
        
        $NModel = new NotificationModel();
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->view['notifications'] =  $NModel->where(['status'=>0,'user_id'=>$user_id,'is_deleted'=>0])->orderBy('id', 'desc')->findAll(); 
        // echo 'data <pre>';print_r( $this->view['notifications']);exit;
    }
}
