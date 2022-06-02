<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class GameController extends Controller
{
 
    private $game;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        //This middleware will set current game to controller.
        $this->middleware(function ($request, $next) {
            //if game key is empty->set default value as null
            $this->game = session('game', null);
            return $next($request);
        });
    }

    /**
     * Main page
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('game', ['game' => $this->game]);
    }

    /**
     * Player start action
     *
     * @param Request $request -> contains player name
     * @return Application|RedirectResponse|Redirector
     */
    public function start(Request $request)
    {
        if (isset($this->game)) {
            session()->now('status', 'Game already started');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string'
            ]);

            if($validator->fails()){
                //missing name or name is not valid
                return back()->withErrors($validator);
             }

             $this->gameStarter($request->input('name'));
        }
        return $this->response();
    }


    /**
     * Player hit action
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function hit()
    {
        //pop card from the decks
        $this->game->dealer->hitPlayer();
        //check if the player busted
        $this->game->checkPlayerBust();
        return $this->response();
    }

    /**
     * Player stay action
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function stay()
    {
        //revealed all dealer cards
        $this->game->dealer->hitDealerUntilToEnd();
        return $this->response();
    }


    /**
     * player clicked on the next button
     * Prepare to next round
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function next()
    {
        $this->gameStarter($this->game->playerName);
        return $this->response();
    }


    /**
     * store game stats to session
     * Redirects every action to main page
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function response()
    {
        $this->saveGameState();
        return redirect(route('blackjack.index'));
    }

    /**
     * Store game state to session
     */
    private function saveGameState()
    {
        session(['game' => $this->game]);
    }

    /**
     * This will generate new game || Start new round
     *
     * @param string $name
     */
    private function gameStarter(string $name)
    {
        $this->game = new Game($name, Carbon::now());
        $this->game->start();
    }
}
