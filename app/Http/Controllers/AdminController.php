<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\ { AdRepository, MessageRepository };
class AdminController extends Controller
{
    protected $adRepository;
    protected $messagerepository;
    public function __construct(AdRepository $adRepository, Messagerepository $messagerepository)
    {
        $this->adRepository = $adRepository;
        $this->messagerepository = $messagerepository;
    }
    public function index()
    {
        return view('admin.index');
    }
}
