<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\AdMessage;
use App\Http\Requests\MessageAd;
use App\Repositories\ { AdRepository, MessageRepository };

class UserController extends Controller
{
    protected $adRepository;
    protected $messagerepository;
    public function __construct(AdRepository $adRepository, Messagerepository $messagerepository)
    {
        $this->adRepository = $adRepository;
        $this->messagerepository = $messagerepository;
    }
    public function message(MessageAd $request)
    {
        $ad = $this->adRepository->getById($request->id);
        if(auth()->check()) {
            $ad->notify(new AdMessage($ad, $request->message, auth()->user()->email));
            return response()->json(['info' => 'Votre message va être rapidement transmis.']);
        }
        $this->messagerepository->create([
            'texte' => $request->message,
            'email' => $request->email,
            'ad_id' => $ad->id,
        ]);
        return response()->json(['info' => 'Votre message a été mémorisé et sera transmis après modération.']);
    }
}