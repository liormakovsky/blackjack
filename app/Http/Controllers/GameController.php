<?php

namespace App\Games\Blackjack\Http\Controllers;

use App\Games\Blackjack\Http\Requests\GameStarterRequest;
use App\Games\Blackjack\Models\Game;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class GameController extends Controller
{
    /**
     * Main game object
     *
     * @var Game
     */
    private $game;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        //This middleware will set current game to controller.
        $this->middleware(function ($request, $next) {
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
     * @param GameStarterRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function start(GameStarterRequest $request)
    {
        if (isset($this->game)) {
            session()->now('status', 'Game already started');
        } else {
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
        $this->game->dealer->hitPlayer();
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
        $this->game->dealer->hitDealerUntilToEnd();
        return $this->response();
    }


    /**
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
