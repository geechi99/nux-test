<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\Contracts\LinkServiceInterface;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected LinkServiceInterface $links;

    public function __construct(LinkServiceInterface $links)
    {
        $this->links = $links;
    }

    public function show($token)
    {
        $link = Link::where('token', $token)->firstOrFail();
        if (!$this->links->isValid($link)) {
            return redirect()->route('home')->with('error', 'This link is invalid or expired.');
        }
        
        return view('link', ['link' => $link, 'invalid' => false]);
    }

    public function regenerate($token)
    {
        $link = Link::where('token', $token)->firstOrFail();
        $new = $this->links->regenerate($link);

        return redirect()->route('link.show', ['token' => $new->token])->with('success', 'New link generated.');
    }

    public function deactivate($token)
    {
        $link = Link::where('token', $token)->firstOrFail();
        $this->links->deactivate($link);

        return redirect()->route('home')->with('success', 'Link deactivated.');
    }

    public function lucky(Request $request, $token)
    {
        $link = Link::where('token', $token)->firstOrFail();
        if (!$this->links->isValid($link)) {
            return response()->json(['error' => 'Link invalid'], 403);
        }
        $data = $this->links->playLucky($link);

        return response()->json([
            'random' => $data['random'],
            'win' => $data['win'] ? 'Win' : 'Lose',
            'amount' => number_format($data['amount'], 2, '.', ''),
            'created_at' => $data['result']->created_at->toDateTimeString(),
        ]);
    }

    public function history($token)
    {
        $link = Link::where('token', $token)->firstOrFail();
        if (!$this->links->isValid($link)) {
            return response()->json(['error' => 'Link invalid'], 403);
        }
        $last3 = $this->links->lastResults($link, 3);

        return response()->json($last3);
    }
}
